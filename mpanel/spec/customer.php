<?

/**
 * @author Mikhail Starovoyt
 *
 * @version 4.5.1
 * - fixed:AT-138 customer creation with password was incorrect
 *
 * @version 4.5.0
 * Initial admin module from base auto box: AT-114
 */

require_once(SERVER_PATH.'/mpanel/spec/user.php');
class ACustomer extends AUser
{
	//-----------------------------------------------------------------------------------------------
	function __construct()
	{
		$this->sTableName='user';
		$this->sAdditionalLink='_customer';
		$this->sSqlPath = "Customer";
		$this->sTablePrefix='u';
		$this->sAction='customer';
		$this->sWinHead=Language::getDMessage('Customer');
		$this->sPath = Language::GetDMessage('>>Users >');
		$this->aCheckField=array('login','id_region');
		$this->sBeforeAddMethod = "BeforeAdd";
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		$this->PreIndex();

		$oTable=new Table();
		$oTable->aColumn=array(
		'login'=> array('sTitle'=>'Login','sOrder'=>'u.login'),
		'id_user'=>	array('sTitle'=>'Id','sOrder'=>'uc.id_user'),
		'customer_name'=> array('sTitle'=>'Fname','sOrder'=>'uc.name'),
		'phone'=> array('sTitle'=>'Phone','sOrder'=>'uc.phone'),
		'customer_group_name'=>	array('sTitle'=>'Gustomer group','sOrder'=>'cg.name'),
		'customer_type_name'=>	array('sTitle'=>'Customer type','sOrder'=>'ct.name'),
		'email'=> array('sTitle'=>'E-mail','sOrder'=>'u.email'),
		'region'=> array('sTitle'=>'region','sOrder'=>'r.name'),
		'visible'=> array('sTitle'=>'Visible','sOrder'=>'u.visible'),
		'confirmed'=> array('sTitle'=>'confirmed','sOrder'=>'u.comfirmed'),
		'action'=> array(),
		);

		$this->SetDefaultTable($oTable);
		$oTable->bCacheStepper=true;
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
		public function BeforeAddAssign ( &$aData ) {
	//	if (!isset($aData['owner_code'])) { 
	}
	public function BeforeAdd()
	{

//		$aCustomer=Base::$db->GetRow(Base::GetSql('Customer',array('id_user'=>Base::$aRequest['data']['id']) ));
//		Base::$tpl->assign('aCustomerType', Db::GetAssoc("select id, name from user_customer_type where not name='' and id_customer_group='".$aCustomer['id_customer_group']."' order by name"));
		Base::$tpl->assign('aCustomerType', Db::GetAssoc("select id, name from user_customer_type where not name='' order by name"));

		Base::$tpl->assign('aCustomerGroupAssoc', DB::GetAssoc('Assoc/CustomerGroup'));

		$aFinanceType = array(
		'fiz' 	=> 'fiz',
		'nds'	=> 'nds',
		'beznds'	=> 'beznds',
		);
		$aOfficeCountry=Db::GetAssoc("Assoc/OfficeCountry");

		Base::$tpl->assign('aFinanceType', $aFinanceType);
		Base::$tpl->assign('aManagerAssoc', Db::GetAssoc('Assoc/UserManager'));
		Base::$tpl->assign('aCustomerGroup', $aCustomerGroup);
		Base::$tpl->assign('aOfficeCountry', $aOfficeCountry);
		
		Base::$tpl->assign('aRegionList',Db::GetAssoc("select id, name from ec_region order by name"));

        $aRegionGeo=Db::GetAssoc("select id, name_ru from net_city order by name_ru");
        Base::$tpl->assign('aRegionGeo',$aRegionGeo);
	}
	//-----------------------------------------------------------------------------------------------
	public function AfterApply($aBeforeRow,$aAfterRow)
	{
		// Create new
		if (!$aBeforeRow && $aAfterRow){
			$aUserCustomer  = Base::$aRequest['data'];
			unset($aUserCustomer['id']);
			$aUserCustomer['id_user'] = $aAfterRow['id'];
			$aUserAccount['id_user'] = $aAfterRow['id'];
			$aUserAccount['amount'] = Base::$aRequest['amount'] ?  Base::$aRequest['amount'] : 0;
			Base::$db->AutoExecute('user_customer', $aUserCustomer , 'INSERT', false, true, true );
			Base::$db->AutoExecute('user_account', $aUserAccount , 'INSERT', false, true, true );
		}else{
			Db::AutoExecute('user_customer',Base::$aRequest['data'],'UPDATE',"id_user='".Base::$aRequest['data']['id']."'"
			,true,true);

			// Edit current
			Base::$aRequest['data']['discount_static']  =
			Base::$aRequest['data']['discount_static']>=99 ? 0 : Base::$aRequest['data']['discount_static'];
			Base::$aRequest['data']['discount_dynamic'] =
			Base::$aRequest['data']['discount_dynamic']>=99 ? 0 : Base::$aRequest['data']['discount_dynamic'];


			$aCustomer=Base::$db->GetRow(Base::GetSql('Customer',array('id'=>Base::$aRequest['data']['id']) ));
			if ($aCustomer['user_debt']!=Base::$aRequest['data']['user_debt']) {
				Log::FinanceAdd(array(),'debt',$aAfterRow['id'],'New user debt: $'.
				Base::$aRequest['data']['user_debt'],$_SESSION['admin']['login']);
			}
			if ($aCustomer['discount_static']!=Base::$aRequest['data']['discount_static']) {
				Log::FinanceAdd(array(),'discount',$aAfterRow['id'],"New static discount: ".
				Base::$aRequest['data']['discount_static']." %",$_SESSION['admin']['login']);
			}
			if ($aCustomer['discount_dynamic']!=Base::$aRequest['data']['discount_dynamic']) {
				Log::FinanceAdd(array(),'discount',$aAfterRow['id'],"New dynamic discount: ".
				Base::$aRequest['data']['discount_dynamic'] ."%",$_SESSION['admin']['login']);
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	/**
	 * Test global test data for customers and providers if is_test flag is set for user
	 */
	public function ClearTestData($bShowAlert=true)
	{
		$iAffectedRow = 0;
		$aTestUser = DB::GetAssoc("select u.id as id, u.id as value from user as u where u.is_test='1'");
		if ($aTestUser){
			$sWhere=" and id_user in (".implode(',',$aTestUser).")";
			$inCustomer="'".implode("','", $aTestUser)."'";
			DB::Execute("delete from cart_package where 1=1" . $sWhere);
			$iAffectedRow+=DB::AffectedRow();

			$aCart=DB::getAll("select * from cart where type_='order' ".$sWhere);
			$aCartInvoice=Db::GetAssoc("select id as i,id  from cart_invoice where id_user_customer in (".$inCustomer.")");
			if ($aCart) foreach ($aCart as $value) $aCartId[]=$value['id'];
			if ($aCartId) {
				DB::Execute("delete from cart_history where id_cart in (".implode(',',$aCartId).")");
				$iAffectedRow+=DB::AffectedRow();
				DB::Execute("delete from cart_log where id_cart in (".implode(',',$aCartId).")");
				$iAffectedRow+=DB::AffectedRow();
			}
			DB::Execute("delete from cart where type_='order'".$sWhere);
			$iAffectedRow+=DB::AffectedRow();
			DB::Execute("delete from user_account_log where 1=1".$sWhere);
			$iAffectedRow+=DB::AffectedRow();
			//DB::Execute("update user_account set amount=0  where 1=1".$sWhere);
			DB::Execute("delete from user_account where 1=1".$sWhere);
			$iAffectedRow+=DB::AffectedRow();
			DB::Execute("delete from log_finance where 1=1".$sWhere);
			$iAffectedRow+=DB::AffectedRow();
			DB::Execute("delete from log_debt where 1=1".$sWhere);
			$iAffectedRow+=DB::AffectedRow();
			/*
			DB::Execute("delete from invoice_account_log where 1=1".$sWhere);
			$iAffectedRow+=DB::AffectedRow();
			*/
			DB::Execute("delete from invoice_customer where 1=1".$sWhere);
			$iAffectedRow+=DB::AffectedRow();
			DB::Execute("delete from vin_request where 1=1".$sWhere);
			$iAffectedRow+=DB::AffectedRow();
			
			$aMessage=Db::GetAssoc("select id as i,id  from message where 1=1".$sWhere);
			DB::Execute("delete from message_attachment where id_message in ('".implode("','", $aMessage)."')");
			$iAffectedRow+=DB::AffectedRow();
			
			DB::Execute("delete from message where 1=1".$sWhere);
			$iAffectedRow+=DB::AffectedRow();
			
			DB::Execute("delete from cart_invoice_log where id_cart_invoice in ('".implode("','", $aCartInvoice)."')");
			$iAffectedRow+=DB::AffectedRow();
				
			DB::Execute("delete from cart_invoice where id_user_customer in (".$inCustomer.")");
			$iAffectedRow+=DB::AffectedRow();

			DB::Execute("delete from user where id in (".$inCustomer.")");
			$iAffectedRow+=DB::AffectedRow();
			
			DB::Execute("delete from user_customer where 1=1".$sWhere);
			$iAffectedRow+=DB::AffectedRow();
		}
		if ($bShowAlert)
		Base::$oResponse->addAlert(Language::GetDMessage("All test data cleared. Deleted and updated rows:").$iAffectedRow);
		
		Base::$oResponse->addScript("javascript:xajax_process_browse_url('?action=customer'); return false;");
	
	}
	//-----------------------------------------------------------------------------------------------

}
?>