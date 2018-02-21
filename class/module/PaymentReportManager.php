<?
/**
 * @author Vladimir Fedorov
 * 
 */

class PaymentReportManager extends Base
{
	//-----------------------------------------------------------------------------------------------
	public function __construct()
	{
		Auth::NeedAuth('manager');
		Base::$bXajaxPresent = true;
		Base::$aData['template']['bWidthLimit']=true;
		Base::Message();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		require(SERVER_PATH.'/class/module/LiqPay.php');

		$aMethod = Db::GetAll("select DISTINCT pr.method from payment_report pr");
		foreach ($aMethod as $key => $value) {
			$aMethod[$key] = $value[method];
		}
		Base::$tpl->assign('aMethod',$aMethod);

		$aGroup = Db::GetAll("select DISTINCT cg.name from customer_group cg");
		foreach ($aGroup as $key => $value) {
			$aGroup[$key] = $value[name];
		}
		Base::$tpl->assign('aGroup',$aGroup);

		$aListManager=Db::GetAssoc("select luh.id, luh.name from ec_list_of_users_h as luh
			where luh.id_manager=".Auth::$aUser['id_user']);
		Base::$tpl->assign('aListManager',$aListManager);

		$aData=array(
		'sHeader'=>"method=post enctype='multipart/form-data' id='id_order_report_form'",
		'sContent'=>Base::$tpl->fetch('manager/form_bill_search.tpl'),
		'sSubmitButton'=>'Search',
		'sSubmitAction'=>'payment_report_manager',
		'sReturnButton'=>'Clear',
		
		'sAdditionalButtonTemplate' => 'manager/export_bills.tpl',

		'sWidth'=>'700px',
		//'sError'=>$sError,
		);
		$oForm=new Form($aData);

		Base::$sText.=$oForm->getForm();
		
		Base::$sText.=Language::GetText("form_bill");

		// --- search ---
		if (Base::$aRequest['search']['method']) $sWhere.=" and pr.method = '".Base::$aRequest['search']['method']."'";
		if (Base::$aRequest['search']['id_cart_package']) $sWhere.=" and pr.id_cart_package = '".Base::$aRequest['search']['id_cart_package']."'";
		if (Base::$aRequest['search']['name']) $sWhere.=" and uc.name  like '%".Base::$aRequest['search']['name']."%'";
		if (Base::$aRequest['search']['customer_group']) $sWhere.=" and cg.name = '".Base::$aRequest['search']['customer_group']."'";
		if (Base::$aRequest['search']['date_from']) $sWhere.=" and pr.payment_date >= '".DateFormat::FormatSearch(Base::$aRequest['search']['date_from'])."'";
		if (Base::$aRequest['search']['date_to']) $sWhere.=" and pr.payment_date <= '".DateFormat::FormatSearch(Base::$aRequest['search']['date_to'])."'";
		if (Base::$aRequest['search_list_cust'] ) {
			$aListIdM=Db::GetAssoc("select id, id_user from ec_list_of_users_d as lud 
				where id_list_of_users_h=".Base::$aRequest['search_list_cust']);
				$aListId=implode(",", $aListIdM);
			if (Base::$aRequest['search_list_cust']) $sWhere.=" and uc.id_user in (".$aListId.")";
		}
		// --------------

		$date_from = DateTime::createFromFormat('d-m-Y', date('d-m-Y',strtotime(Base::$aRequest['search']['date_from'])), new DateTimeZone('UTC'));
		$date_f = $date_from->getTimestamp();


		$date_to = DateTime::createFromFormat('d-m-Y', date('d-m-Y',strtotime(Base::$aRequest['search']['date_to'])), new DateTimeZone('UTC'));
		$date_t = $date_to->getTimestamp();

		
		$liqpay = new LiqPay('i54276112930', "R15mltUEp2UkL7pPI3FebTV10V0nsZ7w3DPoehz9");
		$res = $liqpay->api("request", array(
		'action'    => 'reports',
		'version'   => '3',
		'date_from' => $date_f*1000,
		'date_to'   => $date_t*1000,
		));
		//Debug::PrintPre(Base::$aRequest);
		$res=json_encode($res);	
		$res=json_decode($res, true);				

		/*$other = Db::GetAll("select pr.*, uc.id_customer_group, u.id, u.email, u.login, uc.name, cg.*
		 from payment_report pr 
				left join user as u ON u.id = pr.id_user
				left join user_customer as uc ON uc.id_user = pr.id_user
				left join customer_group cg on uc.id_customer_group=cg.id
				 where 1=1 ".$sWhere);*/

		

		//$merg = array_merge($res[data],$other);
		//Debug::PrintPre($merg);
		$oTable=new Table();
		//$oTable->sType='array';
		//$oTable->aDataFoTable=$merg;
		$oTable->sSql="select pr.*, u.email, u.login, uc.name, uc.id_customer_group, cg.name as customer_group
		 from payment_report pr 
				left join user as u ON u.id = pr.id_user
				left join user_customer as uc ON uc.id_user = pr.id_user
				left join customer_group cg on uc.id_customer_group=cg.id where 1=1 ".$sWhere;
		$oTable->aOrdered="order by payment_date desc";
		$oTable->aColumn=array(
			//'status'=>array('sTitle'=>'status'),
			'method'=>array('sTitle'=>'method'),
			'id_cart_package'=>array('sTitle'=>'order'),
			'name' =>array('sTitle' => 'Customer'), 
			'customer_group'=>array('sTitle'=>'customer_group'),
			'price'=>array('sTitle'=>'amount'),
			'comis'=>array('sTitle'=>'receiver_commission'),
			//'receiver_commission'=>array('sTitle'=>'receiver_commission'),
			'payment_date'=>array('sTitle'=>'Date payment'),
			'action'=>array('sTitle'=>'Export Bills'),
		);
		$oTable->sDataTemplate='payment_report/row_payment_report_manager.tpl';
		$oTable->bStepperVisible=true;
		$oTable->bHeaderVisible=true;
		$oTable->iRowPerPage=50;
		//$oTable->aCallback=array($this,'CallParseBill');
		Base::$sText.=$oTable->getTable();
	}
	//-----------------------------------------------------------------------------------------------
	public function CallParseBill(&$aItem){
		if ($aItem) {
			foreach($aItem as $key => $value) {
			$sSql="select cg.*,u.*,uc.*, cp.*, cg.name as group_name from user u
							inner join user_customer uc on u.id=uc.id_user
							inner join customer_group cg on uc.id_customer_group=cg.id
							inner join cart_package cp on cp.id_user=uc.id_user
							 where cp.id='".$value['order_id']."' ";
			$aCustomerGroup = Base::$db->getRow($sSql);
			$aNotLiqPayGroup = Base::$db->getRow("select cg.*,u.*,uc.*, cg.name as group_name from user u
							inner join user_customer uc on u.id=uc.id_user
							inner join customer_group cg on uc.id_customer_group=cg.id
							inner join cart_package cp on cp.id_user=uc.id_user
							 where u.id='".$value['id_user']."' ");
				if (!$value['order_id']){
					$aItem[$key]['name'] = $aItem[$key]['name'];
					$aItem[$key]['order_id'] = $aItem[$key]['id_cart_package'];
					$aItem[$key]['customer_group'] = $aNotLiqPayGroup['group_name'];
				}
				else{
					$aItem[$key]['name'] = $aCustomerGroup['name'];
					$aItem[$key]['customer_group'] = $aCustomerGroup['group_name'];
				}
				
				$aItem[$key]['end_date'] = date('Y-m-d H:i:s', $aItem[$key]['end_date']/1000);
				
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
}
?>