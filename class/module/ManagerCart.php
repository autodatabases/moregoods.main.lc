<?

class ManagerCart extends Base
{
//	private $sCustomerSql;

	//-----------------------------------------------------------------------------------------------
	function __construct()
	{
		Base::$bXajaxPresent=true;
		Auth::NeedAuth('manager');
		Base::$aData['template']['bWidthLimit']=false;

/*		if (Auth::$aUser['is_super_manager'] || Auth::$aUser['is_sub_manager'])
		$this->sCustomerSql="SELECT id_user from user_customer";
		else $this->sCustomerSql="SELECT id_user from user_customer where id_manager='".Auth::$aUser['id']."'";
*/
		Base::$aData['template']['bWidthLimit']=false;
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		Base::$aTopPageTemplate=array('panel/tab_manager_cart.tpl'=>'cart');

	    $aGroupsG=Db::GetAssoc("select 0 as id, 'Всі' as name 
			union all
			select id,name from customer_group where visible=1");
	    $aAutors=Db::GetAssoc("select 0 as id, '' as id_autor,'Всі' as login,'' as name
			union all
			select u.id,u.login as id_autor,u.login as login,cu.name as name 
            from user u
            inner join  user_customer cu on cu.id_user=u.id and cu.id_region='".Auth::$aUser['id_region']."'
            inner join cart c on c.id_user=u.id   and id_cart_package=0
			");
		Base::$tpl->assign('aAutors',$aAutors);

		$aListManager=Db::GetAssoc("select luh.id, luh.name from ec_list_of_users_h as luh
			where luh.id_manager=".Auth::$aUser['id_user']);
		Base::$tpl->assign('aListManager',$aListManager);
		
		Base::$tpl->assign('aGroupsG',$aGroupsG);

		if (Base::$aRequest['is_post']) {

			if (!Base::$aRequest['code'] || !Base::$aRequest['price'] || !Base::$aRequest['name']
			|| !Base::$aRequest['term'] || !Base::$aRequest['item_code']) {
				Form::ShowError("Please, fill the required fields");
				Base::$aRequest['action']='manager_cart_add';
				Base::$tpl->assign('aData',Base::$aRequest);
			}
			else {
				if (!Base::$aRequest['id']) {
					//[----- INSERT -----------------------------------------------------]
					$sQuery="insert into cart(type_,id_user,code,number,price,name,term
						,item_code,cat_name,provider_name,weight,post)
        			        values('cart','".Base::$aRequest['id_user']."','".Base::$aRequest['code']."','".Base::$aRequest['namber']."'
        			        ,'".Base::$aRequest['price']."','".Base::$aRequest['name']."','".Base::$aRequest['name']."'
        			        ,'".Base::$aRequest['item_code']."','".Base::$aRequest['cat_name']."'
        			       ,'".Base::$aRequest['weight']."'
        			        	,UNIX_TIMESTAMP())";
					//[----- END INSERT -------------------------------------------------]
				} else {
					//[----- UPDATE -----------------------------------------------------]
					$sQuery="update cart set
						id_user='".Base::$aRequest['id_user']."',
						code='".Base::$aRequest['code']."',
						number='".Base::$aRequest['number']."',
						price='".Base::$aRequest['price']."',
						name='".Base::$aRequest['name']."',
						term='".Base::$aRequest['term']."',
						item_code='".Base::$aRequest['item_code']."',
						cat_name='".Base::$aRequest['cat_name']."',
						weight='".Base::$aRequest['weight']."'
                        		where id='".Base::$aRequest['id']."'
                        			and type_='cart'";
//                        			and id_user in (".$this->sCustomerSql.") ";
					//[----- END UPDATE -------------------------------------------------]
				}
				Base::$db->Execute($sQuery);
				Base::Redirect("/?action=manager_cart");
			}
		}

		if (Base::$aRequest['action']=='manager_cart_add' || Base::$aRequest['action']=='manager_cart_edit') {
			if (Base::$aRequest['action']=='manager_cart_edit') {
				$aCart=Base::$db->getRow("
					select c.*,u.login, uc.name as customer_name
					from cart c
					inner join user u on c.id_user=u.id
					inner join user_customer uc on uc.id_user=u.id
					where 1=1 and c.type_='cart'
						and c.id='".Base::$aRequest['id']."'");
//						and c.id_user in (".$this->sCustomerSql.")");
				if (!$aCart) Base::Redirect('/?action=manager_cart');
				Base::$tpl->assign('aData',$aCart);
			}

			$aData=array(
			'sHeader'=>"method=post",
			'sTitle'=>"Cart item",
			'sContent'=>Base::$tpl->fetch('manager_cart/form_cart.tpl'),
			'sSubmitButton'=>'Apply',
			'sSubmitAction'=>'manager_cart',
			'sReturnButton'=>'<< Return',
			'sReturnAction'=>'manager_cart',
			'sError'=>$sError,
			);
			$oForm=new Form($aData);
			Base::$sText.=$oForm->getForm();
			return;
		}

		if (Base::$aRequest['action']=='manager_cart_delete') {
			Base::$db->Execute("delete from cart where
				type_='cart'
				and id='".Base::$aRequest['id']."'");
//				and id_user in (".$this->sCustomerSql.") ");
		}

		$aData=array(
		'sHeader'=>"method=get",
		//'sTitle'=>"Cart Items",
		'sContent'=>Base::$tpl->fetch('manager_cart/form_cart_search.tpl'),
		'sSubmitButton'=>'Search',
		'sSubmitAction'=>'manager_cart',
		'sReturnButton'=>'Clear',
		'sReturnAction'=>'manager_cart',
		'bIsPost'=>0,
		'sWidth'=>'700px',
		'sError'=>$sError,
		);
		$oForm=new Form($aData);

		$aData['sSearchForm']=$oForm->getForm();

		// --- search ---
		if (!Base::$aRequest['search_archive']) $sWhere.=" and c.is_archive='0'";
		if (Base::$aRequest['search_id']) $sWhere.=" and c.id like '%".Base::$aRequest['search_id']."%'";
		if (Base::$aRequest['search_name']) $sWhere.=" and c.name like '%".Base::$aRequest['search_name']."%'";
		//if (Base::$aRequest['search_id_user']) $sWhere.=" and c.id_user like '%".Base::$aRequest['search_id_user']."%'";
		if (Base::$aRequest['search_login']) $sWhere.=" and u.login ='".Base::$aRequest['search_login']."'";
		//if (Base::$aRequest['search_cart_status']) $sWhere.=" and c.cart_status = '".Base::$aRequest['search_cart_status']."'";

		if (Base::$aRequest['group_id']) $sWhere.=" and (uc.id_customer_group ='".Base::$aRequest['group_id']."' or '".Base::$aRequest['group_id']."'='0')";
		if (Base::$aRequest['id_autor'] ) $sWhere.=" and  u.login='".Base::$aRequest['id_autor']."'";
		if (Base::$aRequest['search_list_cust'] ) {
			$aListIdM=Db::GetAssoc("select id, id_user from ec_list_of_users_d as lud 
				where id_list_of_users_h=".Base::$aRequest['search_list_cust']);
				$aListId=implode(",", $aListIdM);
			if (Base::$aRequest['search_list_cust']) $sWhere.=" and uc.id_user in (".$aListId.")";
		}
		
		switch(Base::$aRequest['search_changes']){
			case  '': break;
			case '1':
			    $sWhere.=" and c.post_date>='".date('Y-m-d H:i:s',strtotime('-1 DAY'))."'
				and c.post_date<='".DateFormat::FormatSearchNow()."'";
			    break;
			case '7':
			    $sWhere.=" and c.post_date>='".date('Y-m-d H:i:s',strtotime('-7 DAY'))."'
				and c.post_date<='".DateFormat::FormatSearchNow()."'";
			    break;
			case '30':
			    $sWhere.=" and c.post_date>='".date('Y-m-d H:i:s',strtotime('-30 DAY'))."'
				and c.post_date<='".DateFormat::FormatSearchNow()."'";
			    break;
			}
		
		    if(Base::$aRequest['search']['datestart']) {
		    $iDate=strtotime(Base::$aRequest['search']['datestart']);
		    $sWhere.=" and DATE(c.post_date) >= '".date("Y-m-d",$iDate)."' ";
			}
			if(Base::$aRequest['search']['dateend']) {
		    $iDate=strtotime(Base::$aRequest['search']['dateend']);
		    $sWhere.=" and DATE(c.post_date) <= '".date("Y-m-d",$iDate)."' ";
			}
		// --------------
		$aCarts=Db::GetAll("select c.price,c.number
				from cart c
					inner join user u on c.id_user=u.id
				 	inner join user_customer uc on uc.id_user=u.id and uc.id_region='".Auth::$aUser['id_region']."'
				 	inner join user_account ua on ua.id_user=u.id
					inner join customer_group cg on uc.id_customer_group=cg.id
					inner join user m on uc.id_manager=m.id
				where 1=1 and c.type_='cart'
					".$sWhere);
//		and c.id_user in (".$this->sCustomerSql.")
		
		foreach($aCarts as $key1 => $value) {
			$dSubtotalGrn+=$value['number'] * Currency::PrintPrice($value['price'],null,2,'<none>');
			$dSubtotalCount+=$value['number'];
		}
		Base::$tpl->assign('dSubtotalGrn',$dSubtotalGrn);
		Base::$tpl->assign('dSubtotalCount',$dSubtotalCount);
		Base::$tpl->assign('sWhere',$sWhere);
		
		
		$oTable=new Table();
		$oTable->sSql="select uc.*, cg.*,u.*,uc.*,c.*,u.login, uc.name as customer_name
					, m.login as manager_login, u.post_date as user_post_date
				from cart c
					inner join user u on c.id_user=u.id
				 	inner join user_customer uc on uc.id_user=u.id and uc.id_region='".Auth::$aUser['id_region']."'
				 	inner join user_account ua on ua.id_user=u.id
					inner join customer_group cg on uc.id_customer_group=cg.id
					inner join user m on uc.id_manager=m.id
				where 1=1 and c.type_='cart'
					".$sWhere;
//					and c.id_user in (".$this->sCustomerSql.")
		
		$oTable->aColumn=array(
		'id'=>array('sTitle'=>'cart #','sWidth'=>'5%'),
//		'code'=>array('sTitle'=>'Code','sWidth'=>'10%'),
		'id_user'=>array('sTitle'=>'User','sWidth'=>'10%'),
		'name'=>array('sTitle'=>'Name','sWidth'=>'40%'),
//		'term'=>array('sTitle'=>'Term','sWidth'=>'1%'),
		'number'=>array('sTitle'=>'#','sWidth'=>'1%'),
		'price'=>array('sTitle'=>'Price','sWidth'=>'5%'),
//		'total'=>array('sTitle'=>'Total','sWidth'=>'5%'),
//		'post'=>array('sTitle'=>'Date','sWidth'=>'5%'),
		'action'=>array('sTitle'=>'Action','sWidth'=>'10%'),
		);
		//$oTable->iRowPerPage=5;
		$oTable->sDataTemplate='manager_cart/row_cart.tpl';
		$oTable->sSubtotalTemplate='manager/subtotal_cart_customer.tpl';
		$oTable->aCallback=array($this,'CallParseCart');
		//		$oTable->sAddButton="Add cart for Customer";
		//		$oTable->sAddAction="manager_cart_add";
		$oTable->aOrdered="order by c.post_date desc";
		$oTable->iRowPerPage=20;

		$aData['sCartItem']=$oTable->getTable("Customer Cart Items by Manager");
		Base::$tpl->assign('aData',$aData);


		Base::$sText.=Base::$tpl->fetch('manager_cart/list.tpl');;
	}
	//-----------------------------------------------------------------------------------------------
	public function CallParseCart(&$aItem)
	{
		if ($aItem) {
			foreach($aItem as $key => $value) {
				$acartId[]=$value['id'];

				//$aItem[$key]['post_date']=DateFormat::getDateTime($value['post']);
				$aItem[$key]['name']="<b>".(trim($value['name']) != '' ? $value['name'] : $value['name_translate']).
				"</b><br>".String::FirstNwords($value['customer_comment'],5);
				$aItem[$key]['total']=$value['number']*Currency::PrintPrice($value['price']);
				
//				if (!$aItem[$key]['is_archive']) {
//				$dSubtotal+=$value['number'] * Currency::PrintPrice($value['price'],null,2,'<none>');
//				$dSubtotalCount+=$value['number'];
//				}
			}
		}

//		Base::$tpl->assign('dSubtotalCount',$dSubtotalCount);

//		return array('dSubtotal'=>$dSubtotal);//,'dSubtotalCount'=>$dSubtotalCount);
		
	}
	//-----------------------------------------------------------------------------------------------
	public function Archive()
	{
		if (Base::$aRequest['is_archive']) $iIsArchive=1;
		$sQuery="update cart set
				is_archive='".$iIsArchive."'
			where id='".Base::$aRequest['id']."'
				and type_='cart'
				";
//				and id_user in (".$this->sCustomerSql.")
		Base::$db->Execute($sQuery);
		$this->Index();
	}
	//-----------------------------------------------------------------------------------------------
	public function Store()
	{
		Base::$aTopPageTemplate=array('panel/tab_manager_cart.tpl'=>'cart_store');

		User::AssignPartnerRegion();
		Base::$tpl->assign('aUserManager',array(""=>"")+Base::$db->GetAssoc("select id, login as name
			from user where type_='manager' and visible=1"));

		$aData=array(
		'sHeader'=>"method=get",
		//'sTitle'=>"Customer Store Items",
		'sContent'=>Base::$tpl->fetch('manager_cart/form_cart_store_search.tpl'),
		'sSubmitButton'=>'Search',
		'sSubmitAction'=>'manager_cart_store',
		'sReturnButton'=>'Clear',
		'sReturnAction'=>'manager_cart_store',
		'bIsPost'=>0,
		'sError'=>$sError,
		);
		$oForm=new Form($aData);

		Base::$sText.=$oForm->getForm();

		// --- search ---
		if (Base::$aRequest['search']['amount']>0) $sWhere.=" and ua.amount>0 ";
		if (Base::$aRequest['search']['amount']<0) $sWhere.=" and ua.amount<0 ";

		if (Base::$aRequest['search']['id_user_manager'])
		$sWhere.=" and uc.id_manager='".Base::$aRequest['search']['id_user_manager']."'";
		// --------------

		$oTable=new Table();
		$oTable->sSql="select u.*, ua.*, c.*
						, count(c.id) as cart_number
						, uum.login as manager_login
				from cart c
					inner join user as u on c.id_user=u.id
					inner join user_customer uc on u.id=uc.id_user
					inner join user_account as ua on c.id_user=ua.id_user
					inner join cart_log as cl on (c.id=cl.id_cart and cl.order_status=c.order_status and c.order_status='store')
					inner join user_manager um on uc.id_manager=um.id_user
					inner join user uum on um.id_user=uum.id
				where 1=1 and c.type_='order'
					".$sWhere."
				group by c.id_user";
//		.($this->sCustomerSql ? " and c.id_user in (".$this->sCustomerSql.")":"")."
		$oTable->aColumn=array(
		'login'=>array('sTitle'=>'User'),
		'amount'=>array('sTitle'=>'Amount'),
		'cart_number'=>array('sTitle'=>'Number'),
		'region'=>array('sTitle'=>'Region'),
		'action'=>array(),
		);
		$oTable->iRowPerPage=100;
		$oTable->sDataTemplate='manager_cart/row_cart_store.tpl';
		$oTable->aOrdered="order by u.login";
		$oTable->bFormAvailable=false;

		Base::$sText.=$oTable->getTable("Store Carts");
	}
	//-----------------------------------------------------------------------------------------------
	public function Payment()
	{
		Base::$aTopPageTemplate=array('panel/tab_manager_cart.tpl'=>'cart_payment');

		if (Base::$aRequest['is_post'])
		{
			$aCart=Db::GetRow(Base::GetSql('Cart',array('id'=>Base::$aRequest['data']['id_cart'])));

			if (!Base::$aRequest['data']['id_cart'] || !$aCart['id']) {
				Form::ShowError("Please, fill the required fields");
				Base::$aRequest['action']='manager_cart_payment_add';
				Base::$tpl->assign('aData',Base::$aRequest['data']);
			}
			else {
				$aCartPayment=String::FilterRequestData(Base::$aRequest['data'],
				array('id_cart','number','weight_payment','volume_payment'));

				if (!Base::$aRequest['id']) {
					Db::Autoexecute('cart_payment',$aCartPayment);
				} else {
					$sWhere="id='".Base::$aRequest['id']."'";
					Db::Autoexecute('cart_payment',$aCartPayment,'UPDATE',$sWhere);
				}
				Form::RedirectAuto("&aMessage[MI_NOTICE]=cart payment updated");
			}
		}

		if (Base::$aRequest['action']=='manager_cart_payment_add' || Base::$aRequest['action']=='manager_cart_payment_edit') {
			if (Base::$aRequest['action']=='manager_cart_payment_edit') {
				$aCartPayment=Db::GetRow(Base::GetSql('CartPayment',array(
				'id'=>Base::$aRequest['id']
				)));
				if ($aCartPayment['is_payed']) Base::Redirect('/?action=manager_cart_payment&aMessage[MI_NOTICE]=error_payed');

				Base::$tpl->assign('aData',$aCartPayment);
			}

			$aData=array(
			'sHeader'=>"method=post",
			'sTitle'=>"Cart Payment",
			'sContent'=>Base::$tpl->fetch('manager_cart/form_cart_payment.tpl'),
			'sSubmitButton'=>'Apply',
			'sSubmitAction'=>'manager_cart_payment',
			'sReturnButton'=>'<< Return',
			'sReturnAction'=>'manager_cart_payment',
			'sError'=>$sError,
			);
			$oForm=new Form($aData);


			Base::$sText.=$oForm->getForm();
			return;
		}

		if (Base::$aRequest['action']=='manager_cart_payment_delete') {
			Base::$db->Execute("delete from cart_payment where id='".Base::$aRequest['id']."' and is_payed='0'");
			Form::RedirectAuto("&aMessage[MI_NOTICE]=cart payment deleted");
		}

		if (Base::$aRequest['action']=='manager_cart_payment_pay')
		{
			$aCartPayment=Db::GetRow(Base::GetSql('CartPayment',array(
			'id'=>Base::$aRequest['id']
			)));
			if ($aCartPayment['is_payed']) Base::Redirect('/?action=manager_cart_payment&aMessage[MI_NOTICE]=error_payed');

			if ($aCartPayment['weight_payment']) {
				//				Finance::Deposit($aCartPackage['id_user'],-$dCartPrice
				//				,Language::getMessage($sPaymentCode).$aValue['id'],$aValue['id'],'internal','cart','',9);
				//
				//				InvoiceAccountLog::AddItem($aValue['id'],$dCartPrice,Language::GetMessage('ii_cart'));
				//				Base::$db->Execute("update cart set full_payment_discount='{$aValue['full_payment_discount']}'
				//where id='$sKey'");
				//
				//				$aCartUpdate['weight_delivery_cost']='';
				//				$aCartUpdate['weight_delivery_cost_post']='Now()';
				$bPayed=true;
			}

			if ($aCartPayment['volume_payment']) {
				//				Finance::Deposit($aCartPackage['id_user'],-$dCartPrice
				//				,Language::getMessage($sPaymentCode).$aValue['id'],$aValue['id'],'internal','cart','',9);
				//
				//				InvoiceAccountLog::AddItem($aValue['id'],$dCartPrice,Language::GetMessage('ii_cart'));
				//				Base::$db->Execute("update cart set full_payment_discount='{$aValue['full_payment_discount']}'
				//where id='$sKey'");
				$bPayed=true;
			}

			if ($bPayed) {
				$aCartPaymentUpdate=array();
				$aCartPaymentUpdate['is_payed']='1';
				$aCartPaymentUpdate['payed_date']='Now()';
				Db::AutoExecute('cart_payment',$aCartPaymentUpdate,'UPDATE',"id='".$aCartPayment['id']."'");
				Form::RedirectAuto("&aMessage[MI_NOTICE]=cart payment deleted");
			}
		}




		$aData=array(
		'sHeader'=>"method=get",
		'sContent'=>Base::$tpl->fetch('manager_cart/form_cart_payment_search.tpl'),
		'sSubmitButton'=>'Search',
		'sSubmitAction'=>'manager_cart_payment',
		'sReturnButton'=>'Clear',
		'sReturnAction'=>'manager_cart_payment',
		'bIsPost'=>0,
		'sError'=>$sError,
		);
		$oForm=new Form($aData);
		Base::$sText.=$oForm->getForm();

		// --- search ---
		if (Base::$aRequest['search']['login']) $sWhere.=" and u.login='".Base::$aRequest['search']['login']."'";
		// --------------

		$oTable=new Table();
		$oTable->sSql=Base::GetSql('CartPayment',array('where'=>$sWhere));
		$oTable->aColumn=array(
		'id'=>array('sTitle'=>'ID'),
		'cart'=>array('sTitle'=>'Cart'),
		'post_date'=>array('sTitle'=>'PostDate'),
		'number'=>array('sTitle'=>'number'),
		'weight_payment'=>array('sTitle'=>'weight_payment'),
		'volume_payment'=>array('sTitle'=>'volume_payment'),
		'is_payed'=>array('sTitle'=>'is_payed'),
		'action'=>array(),
		);
		$oTable->iRowPerPage=20;
		$oTable->sButtonTemplate='manager_cart/button_cart_payment.tpl';
		$oTable->sDataTemplate='manager_cart/row_cart_payment.tpl';

		Base::$sText.=$oTable->getTable("Cart Payments");

	}
	//-----------------------------------------------------------------------------------------------

}
?>