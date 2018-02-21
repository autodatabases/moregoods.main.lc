<?

/**
 * @author Mikhail Starovoyt
 * @author Oleksandr Starovoit
 */

class Manager extends Base
{
	var $sPrefix="manager";
	var $sPrefixAction="";
	private $sCustomerSql;
	public $sExportSql;
	public $sExportMegaSql;

	public $aCustomerList;
	public $sCurrentOrderStatus;
	var $iIdRegion;
	//public $aUserManagerRegionId=array();

	//-----------------------------------------------------------------------------------------------
	function __construct()
	{
		Auth::NeedAuth('manager');
		Base::$aData['template']['bWidthLimit']=false;
		
	    $sCityByIp=Content::GetSelectedCity();
		if(Auth::$aUser['id_region']){
		    $this->iIdRegion=Auth::$aUser['id_region'];
		}
		elseif($_SESSION['selected_city'] && !Auth::$aUser['id_region']){
		    $sOblasRegion=Db::GetOne("select ec_region from net_city where id='".$sCityByIp."'");
		    $this->iIdRegion=$sOblasRegion;
		}
		else{
		    $sOblasRegion=Db::GetOne("select ec_region from net_city where id='".$sCityByIp."'");
		    $this->iIdRegion=$sOblasRegion;
		}
		

		if (Auth::$aUser['is_super_manager'] || Auth::$aUser['is_sub_manager'])
		$this->sCustomerSql="SELECT id_user from user_customer";
		else $this->sCustomerSql="SELECT id_user from user_customer where id_manager='".Auth::$aUser['id']."'";

		Base::$bXajaxPresent=true;
		Base::$aData['template']['bWidthLimit']=false;

		Base::$tpl->assign_by_ref("oManager", $this);

		//$this->aUserManagerRegionId=array_keys(Db::GetAssoc('Assoc/UserManagerRegion',array('id_user'=>Auth::$aUser['id'])));
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		$this->Profile();
	}
	//-----------------------------------------------------------------------------------------------
	public function CustomerCartPrint()
	{
		$sWhere=Base::$aRequest['where'];
		$sWhere = str_replace("\\", "", $sWhere);



		$aUserCart=Db::GetAll("select uc.*, cg.*,u.*,uc.*,c.*,u.login, uc.name as customer_name
					, m.login as manager_login, u.post_date as user_post_date
				from cart c
					inner join user u on c.id_user=u.id
				 	inner join user_customer uc on uc.id_user=u.id and uc.id_region='".Auth::$aUser['id_region']."'
				 	inner join user_account ua on ua.id_user=u.id
					inner join customer_group cg on uc.id_customer_group=cg.id
					inner join user m on uc.id_manager=m.id
				where 1=1 and c.type_='cart'
					".$sWhere);
		foreach($aUserCart as $key1 => $value) {
			$dSubtotalGrn+=$value['number'] * Currency::PrintPrice($value['price'],null,2,'<none>');
			$dSubtotalCount+=$value['number'];
		}

//		$aCartPackage=Db::GetRow(Base::GetSql('CartPackage',array('where'=>"and cp.id='0'"))); //and cp.id_user='".Auth::$aUser['id']."'
		$sPriceTotalString=Currency::CurrecyConvert(Currency::BillRound($dSubtotalGrn),Base::GetConstant('global:base_currency'));
		$sPriceTotalString=String::GetUcfirst(trim($sPriceTotalString));
		$aCartPackage['price_total_string']=$sPriceTotalString;
//		$aCustomer=Db::GetRow(Base::GetSql('Customer',array(
//		'id'=>(-1),
//		)));
		
//		$aCustomer['name']='Cart Customer';
		$iTime = time();
		$sTime = date("Y-m-d H:i:s", $iTime);
		$aCartPackage['post_date']=$sTime;
		$aCartPackage['price_total']=$dSubtotalGrn;
		Base::$tpl->assign('aUserCart',$aUserCart);
		Base::$tpl->assign('aCartPackage',$aCartPackage);
		Base::$tpl->assign('aCustomer',$aCustomer);
		
		
		PrintContent::Append(Base::$tpl->fetch('cart/package_print.tpl'));
		Base::Redirect('?action=print_content&return=manager_cart');
	}
	public function GetCustomerList()
	{
		if ($this->aCustomerList) return $this->aCustomerList;

		$this->aCustomerList=Base::$db->getAll("select u.*, uc.* , cg.name as customer_group_name
			from user u
			inner join user_customer uc on u.id=uc.id_user
			inner join user_account ua on u.id=ua.id_user
			inner join customer_group cg on cg.id=uc.id_customer_group
			where 1=1
			 	and u.id in (".$this->sCustomerSql.")
			group by u.id ");
		return $this->aCustomerList;
	}
	//-----------------------------------------------------------------------------------------------
	public function Profile()
	{
		//Base::$sText.=Base::$tpl->fetch('letter.tpl');
		Base::$aTopPageTemplate=array('panel/tab_manager.tpl'=>'profile');

		if (Base::$aRequest['is_post']) {
			$sLanguage="update user set language='".Base::$aRequest['data']['language']."' 
			where id='".Auth::$aUser['id']."';";
			$sQuery="
			update user_manager set
				name='".Base::$aRequest['name']."',
				address='".Base::$aRequest['address']."',
				phone='".Base::$aRequest['phone']."',
				remark='".Base::$aRequest['remark']."'
			where id_user='".Auth::$aUser['id']."';
			";
			Base::$db->Execute($sQuery);
			Base::$db->Execute($sLanguage);
//				id_region='".Base::$aRequest['id_region']."',
//				id_customer_group='".Base::$aRequest['id_group']."',

			$aCanChange=Base::$db->getAll("select can_change_region,can_change_group,can_change_customer_partner from user_manager where id_user='".Auth::$aUser['id']."';");

			if($aCanChange){
			if($aCanChange[0]['can_change_region']==1){
			$sQuery="
			update user_manager set
				id_region='".Base::$aRequest['id_region']."'
			where id_user='".Auth::$aUser['id']."';
			";
			Base::$db->Execute($sQuery);
			}
			
			if($aCanChange[0]['can_change_group']==1){
			$sQuery="
			update user_manager set
				id_customer_group='".Base::$aRequest['id_group']."'
			where id_user='".Auth::$aUser['id']."';
			";
			Base::$db->Execute($sQuery);
			}
			if($aCanChange[0]['can_change_customer_partner']==1){
			$sQuery="
			update user_manager set
				id_customer_partner='".Base::$aRequest['id_customer_partner']."'
			where id_user='".Auth::$aUser['id']."';
			";
			Base::$db->Execute($sQuery);
			}
			
			}
			$sQuery="
			update user set
				email='".Base::$aRequest['email']."'
			where id='".Auth::$aUser['id']."';
			";
			Base::$db->Execute($sQuery);


			Auth::$aUser=Auth::IsUser(Auth::$aUser['login'],Auth::$aUser['password']);
			if (Auth::$aUser['has_forum']){
				Forum::ChangeProfile(Auth::$aUser);
			}
		}

		Auth::RefreshSession(Auth::$aUser);
		Base::$tpl->assign('aUser',Auth::$aUser);
		//$aCurrency=Base::$db->getAll("select * from currency where visible=1 order by num");
		//Base::$tpl->assign('aCurrency',$aCurrency);
	    $aGroupsG=Db::GetAssoc("select id,name from customer_group where visible=1");
		Base::$tpl->assign('aGroupsG',$aGroupsG);

	
		$iCustomerGroup=Db::GetOne("select cg.id from customer_group cg inner join user_manager uc on uc.id_customer_group=cg.id where uc.id_user='".Auth::$aUser['id']."'");
		Base::$tpl->assign('iCustomerGroup',$iCustomerGroup);


		$aCustomerPartnerList=Db::GetAssoc("select 0 as id_user,'  All' as  name
		union all
		select id_user, name from user_customer where id_region='".$this->iIdRegion."' and id_customer_group='".$iCustomerGroup."' order by name");
		Base::$tpl->assign('aCustomerPartnerList',$aCustomerPartnerList);
		
		$aRegionList=Db::GetAssoc("select id, name from ec_region order by name");
		Base::$tpl->assign('aRegionList',$aRegionList);

		$aCanChange=Base::$db->getAll("select can_change_region,can_change_group,can_change_customer_partner from user_manager where id_user='".Auth::$aUser['id']."';");
		Base::$tpl->assign('aCanChange',$aCanChange);

		
		require_once(SERVER_PATH.'/class/core/Form.php');
		$aData=array(
		'sHeader'=>"method=post",
		'sTitle'=>"Manager Profile",
		'sContent'=>Base::$tpl->fetch('manager/profile.tpl'),
		'sSubmitButton'=>'Apply',
		'sSubmitAction'=>'manager_profile',
		'sError'=>$sError,
		'sWidth'=>"410px",
		);
		$oForm=new Form($aData);

		Base::$sText.=$oForm->getForm();
	}
	//-----------------------------------------------------------------------------------------------
	public function Customer()
	{
		Base::$aTopPageTemplate=array('panel/tab_manager_cart.tpl'=>'customer');
	    $aGroupsG=Db::GetAssoc("select 0 as id, 'Всі' as name 
			union all
			select id,name from customer_group where visible=1");
		Base::$tpl->assign('aGroupsG',$aGroupsG);
		
	    $aTypeG=Db::GetAssoc("select 0 as id, 'Всі' as name 
			union all
			select id,name from user_customer_type where visible=1");
		Base::$tpl->assign('aTypeG',$aTypeG);

		$aListManager=Db::GetAssoc("select luh.id, luh.name from ec_list_of_users_h as luh
			where luh.id_manager=".Auth::$aUser['id_user']);
		Base::$tpl->assign('aListManager',$aListManager);
		
		$aData=array(
		'sHeader'=>"method=get",
		//'sTitle'=>"Order Items",
		'sContent'=>Base::$tpl->fetch('manager/form_customer_search.tpl'),
		'sSubmitButton'=>'Search',
		'sSubmitAction'=>'manager_customer',
		'sReturnButton'=>'Clear',
		'bIsPost'=>0,
		'sError'=>$sError,
		);
		$oForm=new Form($aData);

		Base::$sText.=$oForm->getForm();

		// --- search ---
		if (Base::$aRequest['search']['id_user']) $sWhere.=" and uc.id_user='".Base::$aRequest['search']['id_user']."'";
		if (Base::$aRequest['search']['login']) $sWhere.=" and u.login like '%".Base::$aRequest['search']['login']."%'";
		if (Base::$aRequest['search']['name']) $sWhere.=" and uc.name like '%".Base::$aRequest['search']['name']."%'";
		if (Base::$aRequest['search']['phone']) $sWhere.=" and uc.phone like '%".Base::$aRequest['search']['phone']."%'";
		if (Base::$aRequest['search']['group_id']) $sWhere.=" and (uc.id_customer_group='".Base::$aRequest['search']['group_id']."' or '".Base::$aRequest['search']['group_id']."'='')";
		if (Base::$aRequest['search']['type_id']) $sWhere.=" and (uc.id_user_customer_type='".Base::$aRequest['search']['type_id']."' or '".Base::$aRequest['search']['type_id']."'='')";
		if (Base::$aRequest['search_list_cust'] ) {
			$aListIdM=Db::GetAssoc("select id, id_user from ec_list_of_users_d as lud 
				where id_list_of_users_h=".Base::$aRequest['search_list_cust']);
				$aListId=implode(",", $aListIdM);
			if (Base::$aRequest['search_list_cust']) $sWhere.=" and uc.id_user in (".$aListId.")";
		}
		// --------------

		require_once(SERVER_PATH.'/class/core/Table.php');
		$oTable=new Table();
		$oTable->sSql="select cg.*,uc.*, ua.* ,u.*, concat_ws('<br>', cg.name,uct.name)  as group_name 
					, m.login as manager_login
					 from user u
				inner join user_customer uc on uc.id_user=u.id
				inner join user_account ua on ua.id_user=u.id
				inner join customer_group cg on uc.id_customer_group=cg.id
				left join user_customer_type uct on uct.id=uc.id_user_customer_type and uct.id_customer_group=cg.id
				inner join user m on uc.id_manager=m.id
			 where 1=1
			 	and u.id in (".$this->sCustomerSql.") and uc.id_region ='".$this->iIdRegion."'
			 ".$sWhere;
		$oTable->aColumn=array(
		'id'=>array('sTitle'=>'CustID','sWidth'=>'15px'),
		'login'=>array('sTitle'=>'Login'),
		'name'=>array('sTitle'=>'CustName/Phone'),
		'group_name'=>array('sTitle'=>'Group Name'),
		'email'=>array('sTitle'=>'Email','sWidth'=>'20%'),
		//'amount'=>array('sTitle'=>'CustAmount','sWidth'=>'20%'),
		'action'=>array(),
		);
		$oTable->aOrdered="order by u.id desc";
		$oTable->iRowPerPage=20;
		$oTable->sDataTemplate='manager/row_customer.tpl';
		$oTable->aCallback=array($this,'CallParseOrder');

		Base::$sText.=$oTable->getTable("My customers");
	}
	//-----------------------------------------------------------------------------------------------
	public function CustomerEdit()
	{
		Base::$bXajaxPresent=true;
		Base::$aTopPageTemplate=array('panel/tab_customer.tpl'=>'profile');

		$aCanChange=Base::$db->getAll("select is_customer_readonly,is_customer_login_change,is_customer_passw_change,is_customer_region_change,is_customer_group_change from user_manager where id_user='".Auth::$aUser['id']."';");
//		Base::$tpl->assign('aCanChange',$aCanChange);


		if($aCanChange[0]['is_customer_readonly']==1)
		$sTitleList=Language::GetMessage("customer data");
		else
		$sTitleList=Language::GetMessage("edit customer data");


		if (Base::$aRequest['is_post']) {

		/*
			$sQueryR="update user_customer set
				remark='".strip_tags(Base::$aRequest['data']['remark'])."'
			where id_user='".Base::$aRequest['id_user']."';";
			Base::$db->Execute($sQueryR);
//				vip_remark='".strip_tags(Base::$aRequest['data']['vip_remark'])."'
		*/
/*			
			if(Base::$aRequest['data']['addreses']) {
			    $aAdresses=String::FilterRequestData(Base::$aRequest['data']['addreses']);
			    if($aAdresses) {
			        Db::Execute("delete from ec_addres where id_user='".Base::$aRequest['id_user']."' and id not in ('".implode("','", array_keys($aAdresses))."') ");
			        foreach ($aAdresses as $iKey => $sValue) {
			            if(!$sValue) continue;
			            $bExist=Db::GetOne("select id from  ec_addres where id_user='".Base::$aRequest['id_user']."' and id='".$iKey."' ");

			            $aInsert=array(
			                'id_user'=>Base::$aRequest['id_user'],
			                'addresses'=>$sValue,
			                'visible'=>'1',
			                'post_date'=>date("Y-m-d H:i:s")
			            );
			            
			            if(!$bExist) {
    			            Db::AutoExecute('ec_addres',$aInsert);
			            } else {
			                Db::AutoExecute('ec_addres',$aInsert,"UPDATE", " id = '".$iKey."' ");
			            }
			        }
			    }
			}
*/
			if($aCanChange[0]['is_customer_readonly']==0){
				if($aCanChange[0]['is_customer_group_change']==1 && Base::$aRequest['data']['id_group']!=0){
					$sQuery1="
						update user_customer set
						id_customer_group='".Base::$aRequest['data']['id_group']."',
						id_user_customer_type='".Base::$aRequest['data']['id_user_customer_type']."'						
						where id_user='".Base::$aRequest['id_user']."';
						";
					Base::$db->Execute($sQuery1);
				}
		
				if($aCanChange[0]['is_customer_region_change']==1 && Base::$aRequest['data']['id_geo']!=0 && Base::$aRequest['data']['id_region']!=0){
//           $aUserCustomer['id_region']=Db::GetOne("select ec_region from net_city where id='".$aUserCustomer['id_geo']."'");
//			$aFields.=array('id_geo');
					$sQuery2="
						update user_customer set
						id_geo='".Base::$aRequest['data']['id_geo']."',
						id_region='".Base::$aRequest['data']['id_region']."'
						where id_user='".Base::$aRequest['id_user']."';
					";
					Base::$db->Execute($sQuery2);
				}
		
				$aUserCustomer=String::FilterRequestData(Base::$aRequest['data'],array('name', 'city','address','phone','remark','is_bonus'));
				Db::Autoexecute('user_customer',$aUserCustomer,'UPDATE',"id_user='".Base::$aRequest['id_user']."'");
				
// change email
				$aUserEmail=String::FilterRequestData(Base::$aRequest['data'],array('email'));
				if (!String::CheckEmail($aUserEmail['email'])) {
					$aUserEmail['email']='';
					$sError.=Language::GetMessage("Not valid email and will be set to empty.");
				}
				else
				Base::$db->Autoexecute('user',$aUserEmail,'UPDATE',"id='".Base::$aRequest['id_user']."'");

			}
		}

		$aUser=Db::GetRow(Base::GetSql('User',array('id'=>Base::$aRequest['id_user'],)));
		$aUser=Db::GetRow(Base::GetSql('Customer',array('id'=>$aUser['id'])));
		$sTitleList.="  ".$aUser['login']."/".$aUser['name'];
		Base::$tpl->assign('sTitleList',$sTitleList);

		Base::$sText.=Base::$tpl->fetch('manager/header_customer_edit.tpl');
		
		
//		Auth::RefreshSession($aUser);
		$aUser['amount_currency']=Base::$oCurrency->PrintPrice($aUser['amount'],$aUser['id_currency']);

		Base::$tpl->assign('aUser',$aUser);
		Base::$tpl->assign('sManagerLogin',Base::$db->getOne("select login from user where id='".$aUser['id_manager']."'"));
		Base::$tpl->assign('sManagerName',Base::$db->getOne("select name from user_manager where id_user='".$aUser['id_manager']."'"));

		
		$aGeoRegionList=Db::GetAssoc("select id, name_ru from net_city order by name_ru");
		Base::$tpl->assign('aGeoRegionList',$aGeoRegionList);

        $aRegionGeoSelected=Db::GetOne("select name_ru from net_city where id = '".$aUser['id_geo']."'");
        Base::$tpl->assign('aRegionGeoSelected',$aRegionGeoSelected);

		$sSelectedCity=Content::GetSelectedCity();
		Base::$tpl->assign('sSelectedCity',$sSelectedCity);

		$aRegionList=Db::GetAssoc("select id, name from ec_region order by name");
		Base::$tpl->assign('aRegionList',$aRegionList);
		
        $aRegionSelected=Db::GetOne("select name from ec_region where id = '".$aUser['id_region']."'");
        Base::$tpl->assign('aRegionSelected',$aRegionSelected);

	    $aGroupsG=Db::GetAssoc("select id,name from customer_group where visible=1");
		Base::$tpl->assign('aGroupsG',$aGroupsG);

        $aGroupSelected=Db::GetOne("select name from customer_group where id = '".$aUser['id_customer_group']."'");
        Base::$tpl->assign('aGroupSelected',$aGroupSelected);
		
	    $aTypeG=Db::GetAssoc("select id,name from user_customer_type where visible=1 and id_customer_group='".$aUser['id_customer_group']."' order by name");
		Base::$tpl->assign('aTypeG',$aTypeG);
		
        $aTypeSelected=Db::GetOne("select name from user_customer_type where id = '".$aUser['id_user_customer_type']."'");
        Base::$tpl->assign('aTypeSelected',$aTypeSelected);
		
//        $aCity=Db::GetAssoc("select id, name_ru from net_city  order by name_ru");
//        Base::$tpl->assign('aCity',array(''=>$sSelectedCity)+$aCity);

		$aCurrency=Base::$db->getAll("select * from currency where visible=1 order by num");
		Base::$tpl->assign('aCurrency',$aCurrency);

/*		
		$aData=array(
		'table'=>'rating',
		'where'=>" and section='store_customer' and num in (1,2,4)",
		//'locale_where'=>" and l.visible='1' ",
		'order'=>" order by t.num",
		);
		$aTmp=Language::GetLocalizedAll($aData);
		foreach ($aTmp as $aValue) {
			$aRating[$aValue['num']]=$aValue['content']?$aValue['content']:$aValue['name'];
		}
		Base::$tpl->assign('aRatingAssoc',$aRating);
*/		
		$aAdress=Db::GetAll("select * from ec_addres where id_user='".Base::$aRequest['id_user']."' ");
		Base::$tpl->assign('aAdress',$aAdress);


		
//		if(1==2)
		if($aCanChange[0]['is_customer_readonly']==1)
			Base::$tpl->assign('bReadOnly',1);	
		else
		{	
		if($aCanChange[0]['is_customer_login_change']==1)
			Base::$tpl->assign('bLoginChange',1);
		if($aCanChange[0]['is_customer_passw_change']==1)
			Base::$tpl->assign('bPasswChange',1);
		if($aCanChange[0]['is_customer_region_change']==1)
			Base::$tpl->assign('bRegionChange',1);
		if($aCanChange[0]['is_customer_group_change']==1)
			Base::$tpl->assign('bGroupChange',1);
		}
		
		
		if($aCanChange[0]['is_customer_readonly']==1)
		$aData=array(
		'sHeader'=>"method=post",
		//'sTitle'=>"Customer Profile",
		'sContent'=>Base::$tpl->fetch('manager/customer_profile.tpl'),
		'sReturnButton'=>'<< Return',
		'sReturnAction'=>'manager_customer',
		'sError'=>$sError,
		'sWidth'=>' '
		);
		else
		$aData=array(
		'sHeader'=>"method=post",
		//'sTitle'=>"Customer Profile",
		'sContent'=>Base::$tpl->fetch('manager/customer_profile.tpl'),
		'sSubmitButton'=>'Apply',
		'sSubmitAction'=>'manager_customer_edit',
		'sReturnButton'=>'<< Return',
		'sReturnAction'=>'manager_customer',
		'sError'=>$sError,
		'sWidth'=>' '
		);

		$oForm=new Form($aData);
		Base::$sText.=$oForm->getForm();

		//Base::$tpl->assign('sForm',);
		//Base::$sText.=Base::$tpl->fetch('user/outer_profile.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	public function SetUserLogin()
	{
		$aUser=Db::GetRow(Base::GetSql('User',array('id'=>Base::$aRequest['id_user'],)));
		$aUser=Db::GetRow(Base::GetSql('Customer',array('id'=>$aUser['id'])));
//		if (!Customer::IsChangeableLogin($aUser['login'])) return;

		if (Base::$aRequest['is_post']) {
			$sNewLogin = trim(Base::$aRequest['data']['new_login']);
			// check if not exist
			$aUserNew=Db::GetRow("select * from user where login='".$sNewLogin."'");
			if ($aUserNew){
				$sError=Language::GetMessage('This login already exist');
			}else {
				if (strlen($sNewLogin)==0 || ($aUser['login'] == $sNewLogin) ){
					$sError='Incorrect new login';
				}else {
					if (!$sError) {
						//[----- UPDATE -----------------------------------------------------]
						Db::Execute("update user_customer set is_locked='1' where id_user='".Base::$aRequest['id_user']."'");
						$sQuery="update user set login='".$sNewLogin."' where id='".Base::$aRequest['id_user']."' ";
						//[----- END UPDATE -------------------------------------------------]
						$bResult = Db::Execute($sQuery);
						if ($bResult) {
							$sError=Language::GetMessage('You have successfully changed customer login');
//							Auth::NeedAuth();
							$aUser['login']=$sNewLogin;
						}
						else $sError=Language::GetMessage('Error during changed customer login');
					}
				}
			}
		}
		
		
		Base::$tpl->assign('old_login',$aUser['login']);
		
		$aUserCustomer=Db::GetRow(Base::GetSql('Customer',array('id'=>$aUser['id'])));
		Base::$tpl->assign('sLoginInfo',$aUserCustomer['name']." / ".$aUserCustomer['phone']." / ".$aUserCustomer['address']);

		$aData=array(
		'sHeader'=>"method=post",
		'sTitle'=>"Change Login Form",
		'sWidth'=>" ",
		'sContent'=>Base::$tpl->fetch('manager/form_change_user_login.tpl'),
		'sSubmitButton'=>'Update',
		'sSubmitAction'=>'manager_set_user_login',
		'sReturnButton'=>'Return to profile',
		'sReturnAction'=>'manager_customer_edit&id='.Base::$aRequest['id_user'],
		'sError'=>$sError,
		);
		$oForm=new Form($aData);
		Base::$sText.=$oForm->getForm();
	}
	//-----------------------------------------------------------------------------------------------
	public function SetUserPassword()
	{
		$aUser=Db::GetRow(Base::GetSql('User',array('id'=>Base::$aRequest['id_user'],)));

		if (Base::$aRequest['is_post']) {

			if (!Base::$aRequest['data']['new_password'] //||  !Base::$aRequest['data']['old_password']
			|| !Base::$aRequest['data']['retype_new_password'])
			$sError='Please fill out all fields';

			if (strlen(trim(Base::$aRequest['data']['new_password']))<=5 && !$sError)
			$sError='Password must more than 5 digits';

			if (Base::$aRequest['data']['new_password']!=Base::$aRequest['data']['retype_new_password'] && !$sError)
			$sError='Passwords are not the same';

			$aUser=Db::GetRow(Base::GetSql('User',array('login'=>$aUser['login'])));

//			if ($aUser['password'] !=String::Md5Salt(trim(Base::$aRequest['data']['old_password']),$aUser['salt']) && !$sError)
//			$sError='Please, check the old password';

			if (!$sError) {
				$sSalt=String::GenerateSalt();
				$aUserUpdate=array(
				'password'=>String::Md5Salt(Base::$aRequest['data']['new_password'],$sSalt),
				'salt'=>$sSalt,
				);
				Db::AutoExecute('user',$aUserUpdate,"UPDATE"," login='".$aUser['login']."'");
				$sError=Language::GetMessage('You have successfully changed customer password');
			}
		}

		$aUserCustomer=Db::GetRow(Base::GetSql('Customer',array('id'=>$aUser['id'])));
		Base::$tpl->assign('sLoginInfo',$aUserCustomer['name']." / ".$aUserCustomer['phone']." / ".$aUserCustomer['address']);
		
		$aData=array(
		'sHeader'=>"method=post",
		'sTitle'=>"Change Password Form",
		'sWidth'=>" ",
		'sContent'=>Base::$tpl->fetch('manager/form_change_user_password.tpl'),
		'sSubmitButton'=>'Update',
		'sSubmitAction'=>'manager_set_user_password',
		'sReturnButton'=>'Return to profile',
		'sReturnAction'=>'manager_customer_edit&id='.Base::$aRequest['id_user'],
		'sError'=>$sError,
		);
		$oForm=new Form($aData);
		Base::$sText.=$oForm->getForm();
	}
	//-----------------------------------------------------------------------------------------------
	public function CustomerList()
	{
		Base::$aTopPageTemplate=array('panel/tab_manager_cart.tpl'=>'customer_list');
			
		$oTable=new Table();
		$oTable->sSql="Select lu.id,lu.name,lu.post_date,lu.sort,r.name as region from ec_list_of_users_h lu 
		left join ec_region r on r.id=lu.id_region where id_manager='".Auth::$aUser['id']."'";
		$oTable->aOrdered="order by sort,name,post_date";
		$oTable->aColumn=array(
			'sort'=>array('sTitle'=>'Sort'),
			'name'=>array('sTitle'=>'Name'),
			'region' =>array('sTitle' => 'Region'), 
			'post_date'=>array('sTitle'=>'Date'),
			'action'=>array('sTitle'=>'Actions'),
		);
		$oTable->sDataTemplate='manager/row_customer_list_manager.tpl';
		$oTable->sButtonTemplate='manager/button_customer_list_manager.tpl';
		$oTable->bStepperVisible=true;
		$oTable->bHeaderVisible=true;
		$oTable->iRowPerPage=10;
		$oTable->bCountStepper=true;
//		$oTable->aCallback=array($this,'CallParseOrder');
		Base::$sText.=$oTable->getTable("My customers list");
	}
	
	//-----------------------------------------------------------------------------------------------
	public function CustomerListFill()
	{
		Base::$aTopPageTemplate=array('panel/tab_manager_cart.tpl'=>'customer_list_fill');

		if(Base::$aRequest['id_list']) 
			$_SESSION['id_list']=Base::$aRequest['id_list'];
		if(!Base::$aRequest['id_list'] && $_SESSION['id_list'])
			Base::$aRequest['id_list'] = $_SESSION['id_list'];
		if($_SESSION['id_list'])	
		$_REQUEST['id_list']=$_SESSION['id_list'];

	    $aGroupsG=Db::GetAssoc("select 0 as id, 'Всі' as name 
			union all
			select id,name from customer_group where visible=1");
		Base::$tpl->assign('aGroupsG',$aGroupsG);
		
	    $aInList=Db::GetAssoc("select 0 as id, 'Всі' as name 
			union all
			select 1 as id,'В списке' as name 
			union all
			select 2 as id,'Не в списке' as name 
			");
		Base::$tpl->assign('aInList',$aInList);

		$sTitleList=Language::GetMessage("fill list name");
		$sTitleList.=Db::GetOne("select name from ec_list_of_users_h where id='".Base::$aRequest['id_list']."'");
		Base::$tpl->assign('sTitleList',$sTitleList);

		Base::$sText.=Base::$tpl->fetch('manager/header_customer_list_fill.tpl');
		
	$aData=array(
		'sHeader'=>"method=get",
		//'sTitle'=>"Order Items",
		'sContent'=>Base::$tpl->fetch('manager/form_customer_list_search.tpl'),
		'sSubmitButton'=>'Search',
		'sSubmitAction'=>'manager_customer_list_fill',
		'sReturnButton'=>'Clear',
		'sAdditionalButtonTemplate' => 'manager/button_form_customer_list_search.tpl',
		'bIsPost'=>0,
		'sError'=>$sError,
		);
		$oForm=new Form($aData);

		Base::$sText.=$oForm->getForm();

		// --- search ---
		if (Base::$aRequest['search']['id_user']) $sWhere.=" and uc.id_user='".Base::$aRequest['search']['id_user']."'";
		if (Base::$aRequest['search']['login']) $sWhere.=" and u.login like '%".Base::$aRequest['search']['login']."%'";
		if (Base::$aRequest['search']['name']) $sWhere.=" and uc.name like '%".Base::$aRequest['search']['name']."%'";
		if (Base::$aRequest['search']['phone']) $sWhere.=" and uc.phone like '%".Base::$aRequest['search']['phone']."%'";
		if (Base::$aRequest['search']['group_id']) $sWhere.=" and uc.id_customer_group='".Base::$aRequest['search']['group_id']."'";

		if (Base::$aRequest['search']['inlist']) $sWhere.=" and ( (lud.id_user=uc.id_user and '".Base::$aRequest['search']['inlist']."'=1) or (lud.id_user is null and '".Base::$aRequest['search']['inlist']."'=2))";
		
		// --------------

		require_once(SERVER_PATH.'/class/core/Table.php');
		$oTable=new Table();
		$oTable->sSql="select cg.*,uc.*, ua.* ,u.*, cg.name as group_name
					, m.login as manager_login,lud.id as is_fill,'".Base::$aRequest['id_list']."' as id_list
					 from user u
				inner join user_customer uc on uc.id_user=u.id
				inner join user_account ua on ua.id_user=u.id
				inner join user m on uc.id_manager=m.id
				left join ec_list_of_users_d lud on lud.id_user=uc.id_user and lud.id_list_of_users_h='".Base::$aRequest['id_list']."'
				left join customer_group cg on uc.id_customer_group=cg.id
				where 1=1
			 	and u.id in (".$this->sCustomerSql.") and uc.id_region ='".$this->iIdRegion."'
			 ".$sWhere;
		$oTable->aColumn=array(
		'id'=>array('sTitle'=>'CustID','sWidth'=>'15px'),
		'login'=>array('sTitle'=>'Login'),
		'name'=>array('sTitle'=>'CustName/Phone'),
		'group_name'=>array('sTitle'=>'Group Name'),
		'email'=>array('sTitle'=>'Email','sWidth'=>'20%'),
		'action'=>array('sTitle'=>'Actions'),
		);
		$oTable->aOrdered="order by u.id desc";
		$oTable->iRowPerPage=20;
		$oTable->sDataTemplate='manager/row_customer_list_fill.tpl';
		$oTable->aCallback=array($this,'CallParseOrder');

		Base::$sText.=$oTable->getTable("My customers");

	}
	//-----------------------------------------------------------------------------------------------
	public function CustomerListFillAdd()
	{
		Base::$bXajaxPresent=true;
		$sLink='';
		if (Base::$aRequest['search']['id_user']) $sLink.="&search[id_user]=".Base::$aRequest['search']['id_user'];
		if (Base::$aRequest['search']['login']) $sLink.="&search[login]=".Base::$aRequest['search']['login'];
		if (Base::$aRequest['search']['name']) $sLink.="&search[name]=".Base::$aRequest['search']['name'];
		if (Base::$aRequest['search']['phone']) $sLink.="&search[phone]=".Base::$aRequest['search']['phone'];
		if (Base::$aRequest['search']['group_id']) $sLink.="&search[group_id]=".Base::$aRequest['search']['group_id'];
		if (Base::$aRequest['search']['inlist']) $sLink.="&search[inlist]=".Base::$aRequest['search']['inlist'];

				$iTime = time();
				$sTime = date("Y-m-d H:i:s", $iTime);
	

				if (isset(Base::$aRequest['id'])) {
					$sQuery = "Insert into ec_list_of_users_d (id_list_of_users_h, id_user, visible, post_date,sort) VALUES
					('".Base::$aRequest['id_list']."',".Base::$aRequest['id'].",1,'".$sTime."','".Base::$aRequest['id']."')";
					Base::$db->Execute($sQuery);
					$sMessage="Customer list created";
					}
				else {
					$sMessage="Error... Please select user!!!";
//					$sQuery = "Update ec_list_of_users_h set name='".Base::$aRequest['data']['name']."',post_date = '".$sTime."', id_manager = ".Auth::$aUser['id'].", sort = '".Base::$aRequest['data']['sort']."' where id = ".Base::$aRequest['id'];
					}
				Base::Redirect("/?action=manager_customer_list_fill&id_list=".Base::$aRequest['id_list'].$sLink);
				/*?aMessage[MT_NOTICE]=".$sMessage);*/
			
		

	}
	//-----------------------------------------------------------------------------------------------
	public function CustomerListFillDelete()
	{
		Base::$bXajaxPresent=true;

		$sLink='';
		if (Base::$aRequest['search']['id_user']) $sLink.="&search[id_user]=".Base::$aRequest['search']['id_user'];
		if (Base::$aRequest['search']['login']) $sLink.="&search[login]=".Base::$aRequest['search']['login'];
		if (Base::$aRequest['search']['name']) $sLink.="&search[name]=".Base::$aRequest['search']['name'];
		if (Base::$aRequest['search']['phone']) $sLink.="&search[phone]=".Base::$aRequest['search']['phone'];
		if (Base::$aRequest['search']['group_id']) $sLink.="&search[group_id]=".Base::$aRequest['search']['group_id'];
		if (Base::$aRequest['search']['inlist']) $sLink.="&search[inlist]=".Base::$aRequest['search']['inlist'];


				if (isset(Base::$aRequest['id'])) {
					$sQuery = "delete from ec_list_of_users_d where id_list_of_users_h='".Base::$aRequest['id_list']."' and id_user= ".Base::$aRequest['id'];
					Base::$db->Execute($sQuery);
					$sMessage="Customer list deleted";
					}
				else {
					$sMessage="Error... Please select user!!!";
//					$sQuery = "Update ec_list_of_users_h set name='".Base::$aRequest['data']['name']."',post_date = '".$sTime."', id_manager = ".Auth::$aUser['id'].", sort = '".Base::$aRequest['data']['sort']."' where id = ".Base::$aRequest['id'];
					}
				Base::Redirect("/?action=manager_customer_list_fill&id_list=".Base::$aRequest['id_list'].$sLink);
				/*?aMessage[MT_NOTICE]=".$sMessage);*/
	}
	//-----------------------------------------------------------------------------------------------
	public function CustomerListAdd()
	{
		Base::$bXajaxPresent=true;
//		$oCurrency = new Currency();
		$sError = '';
		$aData = array();

		if (Base::$aRequest['is_post']) {
		
			$aData = Base::$aRequest['data'];
				$iTime = time();
				$sTime = date("Y-m-d H:i:s", $iTime);
				$aData['data']['post_date'] = date("d-m-Y H:i:s", $iTime);
				$aData['data']['id_region'] =Auth::$aUser['id_region'];
				
			if (!Base::$aRequest['data']['sort'] || trim(Base::$aRequest['data']['sort']) == '') {
				$sError .= Language::GetMessage("Incorrect №");
			}
			else {
				$aData['sort'] = Base::$aRequest['data']['sort'];
			}

			
			if (!Base::$aRequest['data']['name'] || trim(Base::$aRequest['data']['name']) == '') {
				if ($sError != '')
					$sError .= "<br>";
				$sError .= language::GetMessage("Incorrect name. Please fill this field.");
			}
			else {
				$aData['name'] = Base::$aRequest['data']['name'];
			}
			
			if ($sError == '') {

				if (!isset(Base::$aRequest['id'])) {
					$sQuery = "Insert into ec_list_of_users_h (name, id_manager, id_region, visible, post_date,sort) VALUES
					('".Base::$aRequest['data']['name']."',".Auth::$aUser['id'].",".Auth::$aUser['id_region'].",1,'".$sTime."','".Base::$aRequest['data']['sort']."')";
					}
				else {
					$sQuery = "Update ec_list_of_users_h set name='".Base::$aRequest['data']['name']."',post_date = '".$sTime."', id_manager = ".Auth::$aUser['id'].", sort = '".Base::$aRequest['data']['sort']."' where id = ".Base::$aRequest['id'];
					}
				$sMessage="Customer list created";
				Base::$db->Execute($sQuery);
				Base::Redirect("/pages/manager_customer_list/?aMessage[MT_NOTICE]=".$sMessage);
			}
		}

		$sButtonSubmit = 'Add';
		if (Base::$aRequest['id']) {
			$aInfo = Db::GetRow("Select lu.*,r.name as region from ec_list_of_users_h lu left join ec_region r on r.id=lu.id_region where lu.id =".Base::$aRequest['id']);
			if ($aInfo['id']) {
				$aData = $aInfo;
				$sButtonSubmit = 'Edit';
			}
		}
	
		Base::$tpl->assign('aData',$aData);

		$aData=array(
				'sHeader'=>"method=post",
				'sTitle'=>"Create list",
				'sContent'=>Base::$tpl->fetch('manager/form_add_customer_list_manager.tpl'),
				'sSubmitButton'=>$sButtonSubmit,
				'sSubmitAction'=>'manager_customer_list_add',
				'sErrorNT'=>$sError,
				'sReturnButton'=>'<< Return',
				'sReturnAction'=>'manager_customer_list',
				'sReturnButtonClass' => '',
				'sSubmitButtonClass' => '',
		);
		$oForm=new Form($aData);
		Base::$sText.=$oForm->getForm();
	}
	//-----------------------------------------------------------------------------------------------
	public function CustomerListDelete()
	{
		if (!Base::$aRequest['id'])
			$sMessage = 'Not found payment declaration item for delete';
		else {
			$aInfo = Db::GetRow("Select * from ec_list_of_users_h where id =".Base::$aRequest['id']);
			if (!$aInfo['id'])
				$sMessage = 'Not found customer list item for delete';
			else {
				Db::Execute("Delete from ec_list_of_users_h where id =".Base::$aRequest['id']);
				Db::Execute("Delete from ec_list_of_users_d where id_list_of_users_h =".Base::$aRequest['id']);
				$sMessage = 'Customer list item delete';
			}
		}
		Base::Redirect("/pages/manager_customer_list/?aMessage[MT_NOTICE]=".$sMessage);
	}
	//-----------------------------------------------------------------------------------------------
	public function CustomerRedirect()
	{
		//$id_array=Base::db->GetAll
		if (Base::$db->getOne("select count(*) from user where id='".Base::$aRequest['id']."'
			and id in (".$this->sCustomerSql.")")) {

		$aManager=Base::$db->getRow("select u.*,um.* from user_manager um,user u
				where u.id=um.id_user and u.visible=1 and um.has_customer=1
					and u.id!='".Base::$aRequest['id_manager']."' order by rand()
				");
		if ($aManager) {
			Base::$db->Execute("update user_customer set id_manager='".$aManager['id']."'
					where id_user='".Base::$aRequest['id']."'");
		}
			}
			Base::Redirect("/?action=manager_customer");
	}
	//-----------------------------------------------------------------------------------------------
	public function Order()
	{
		if (Base::$aRequest['search']['id_cart_package']) {
			Base::$db->Execute("update cart_package set is_viewed='1' where id='".Base::$aRequest['search']['id_cart_package']."' ");
		}
		
		Base::$aTopPageTemplate=array('panel/tab_manager_cart.tpl'=>'order');
		Resource::Get()->Add('/css/manager_panel.css');

		if (Base::$aRequest['is_post']) {
			//[----- UPDATE -----------------------------------------------------]
			//if (Base::$aRequest['order_status']!=Base::$aRequest['old_order_status']) {
			$sMessage=$this->ProcessOrderStatus();
			//}
			
			Base::$db->Execute("update cart set
				price_fact='".Base::$aRequest['price_fact']."',
				count_fact='".Base::$aRequest['count_fact']."',
				summa_fact='".Base::$aRequest['price_fact']."' * '".Base::$aRequest['count_fact']."',
					weight='".Base::$aRequest['weight']."'
					 , id_provider_order='".Base::$aRequest['id_provider_order']."'
					 , id_provider_invoice='".Base::$aRequest['id_provider_invoice']."'
					 , provider_price='".Base::$aRequest['provider_price']."'
					 where id='".Base::$aRequest['id']."'
						and id_user in (".$this->sCustomerSql.") ");
			//[----- END UPDATE -------------------------------------------------]
			//Base::Redirect("/?action=manager_order");
			//if ($sMessage) $sAddedMessage.=;
			//Form::AfterReturn('manager_order'.$sAddedMessage,"&aMessage[MT_NOTICE]=".$sMessage);
			Base::Redirect("/".Base::$aRequest['return']."&aMessage[MT_NOTICE]=".$sMessage);
		}
		if ( Base::$aRequest['action']=='manager_order_edit') {
			//closed change status only for super manager
			//if (!Auth::$aUser['is_super_manager']) Base::Redirect('/?action=auth_type_error');//Base::Redirect('/?closed');

			Form::BeforeReturn('manager_order','manager_order_edit');

			$aCart=Base::$db->getRow("
				select cg.*,u.*,uc.*,c.*,u.login, uc.name as customer_name
				from cart c
				inner join user u on c.id_user=u.id
				inner join user_customer uc on uc.id_user=u.id
				inner join customer_group cg on uc.id_customer_group=cg.id
				inner join user_account ua on ua.id_user=u.id

				where 1=1 and c.type_='order'
					and c.id='".Base::$aRequest['id']."'
					and c.id_user in (".$this->sCustomerSql.")");
			if (!$aCart) Base::Redirect('/?action=manager_order');

			Base::$tpl->assign('aData',$aCart);
			include(SERVER_PATH.'/include/order_status_config.php');
			Base::$tpl->assign('aOrderStatusConfig',$aOrderStatusConfig[$aCart['order_status']]);
			Base::$tpl->assign('aUnstateOrderStatus',$aUnstateOrderStatus);
			Base::$tpl->assign("aPrefChange",Db::GetAssoc("Assoc/Pref", array("is_price"=>1)));

			$aData=array(
			'sHeader'=>"method=post",
			'sTitle'=>"Fact",
			'sContent'=>Base::$tpl->fetch('manager/form_order.tpl'),
			'sSubmitButton'=>'Apply',
			'sSubmitAction'=>'manager_order',
			'sReturnButton'=>'<< Return',
			//'sReturnAction'=>'manager_order',
			//'sError'=>$sError,
			);
			$oForm=new Form($aData);
			$oForm->bAutoReturn=true;
			Base::$sText.=$oForm->getForm();
			return;
		}

		$sSql=Base::GetSql('UserProvider');
		Base::$tpl->assign('aProvider',Base::$db->getAll($sSql));
		$a=array(""=>"all");
		Base::$tpl->assign('aUserManager',array(""=>"")+Base::$db->GetAssoc("select id, login as name
			from user where type_='manager' and visible=1"));
		//Base::$tpl->assign('aPriceType',$a+array('margin'=>'margin','discount'=>'discount') );
		//Base::$tpl->assign('aCustomerGroup',$a+Db::GetAssoc('Assoc/CustomerGroup'));
		//Base::$tpl->assign('aCustomerGroupDiscount',$a+Db::GetAssoc('Assoc/CustomerGroup',array('price_type'=>'discount')));
		//Base::$tpl->assign('aCustomerGroupMargin',$a+Db::GetAssoc('Assoc/CustomerGroup',array('price_type'=>'margin')));
		Base::$tpl->assign("aPref",$a+Db::GetAssoc("Assoc/Pref"));

		$aData=array(
		'sHeader'=>"method=get",
		'sContent'=>Base::$tpl->fetch('manager/form_order_search.tpl'),
		'sSubmitButton'=>'Search',
		'sSubmitAction'=>'manager_order',
		'sReturnButton'=>'Clear',
		'bIsPost'=>0,
		'sWidth'=>'650px',
		'sError'=>$sError,
		);
		//$oForm=new Form($aData);
		//Base::$sText.=$oForm->GetForm();

		if (!isset(Base::$aRequest['search_order_status']) || Base::$aRequest['search_order_status']=='notend') {
			$sWhere.=" and c.order_status not in ('end', 'refused') ";
		} elseif (Base::$aRequest['search_order_status']!='0') {
			$sWhere.=" and c.order_status = '".Base::$aRequest['search_order_status']."'";
			if (Base::$aRequest['search_id_user_manager']) {
				$iSearchIdUserManager=Base::$aRequest['search_id_user_manager'];
			}
		}

		if (Base::$aRequest['search_date']) {
			if (Base::$aRequest['search']['date_type']=='cart') {
				$sDateField='c';
				$bCartJoin=false;
			}
			else {
				$sDateField='cl';
				$bCartJoin=true;
			}

			$sWhere.=" and ".$sDateField.".post_date>='".DateFormat::FormatSearch(Base::$aRequest['search']['date_from'])."'
				and ".$sDateField.".post_date<='".DateFormat::FormatSearch(Base::$aRequest['search']['date_to'])."'";
		}

		if (Base::$aRequest['search']['period']) {
			list($sDateFrom,$sDateTo)=explode("-",Base::$aRequest['search']['period']);
		}

		// --------------

		require(SERVER_PATH.'/include/order_status_config.php');
		Base::$tpl->assign('aOrderStatus',array_keys($aOrderStatusConfig));
		Base::Message();

		if (1 || count(Base::$aRequest['search'])>=1) {
			if (!Base::$aRequest['search']) Base::$aRequest['search']=array();

			$oTable=new Table();
			$oTable->sPanelTemplateTop='manager/panel.tpl';
			$oTable->sSql=Base::GetSql("Part/Search",Base::$aRequest['search']+array(
			"where"=>$sWhere,
			"id_user_manager"=>$iSearchIdUserManager,
			"cart_log_join"=>$bCartJoin,
			"is_confirm"=>1,
			"cp_date_from"=>trim($sDateFrom),
			"cp_date_to"=>trim($sDateTo),
			"is_buh_balance"=>1,
			"id_provider_ordered"=>Base::$aRequest['search']['id_provider'],
			));
			$_SESSION['order']['current_sql']=$oTable->sSql;

			//$sSubtotalSql="select sum(price*number) from (select c.* ".substr($oTable->sSql,strpos($oTable->sSql,'from')).") t";
			//Base::$tpl->assign('dOrderSubtotal',Base::$db->getOne($sSubtotalSql));
			$sSubtotalSql="select price, number from (select c.* ".substr($oTable->sSql,strpos($oTable->sSql,'from')).") t";
			$aMass = Base::$db->getAll($sSubtotalSql);
			$dOrderSubtotal = 0;
			foreach($aMass as $aValue)
				$dOrderSubtotal += $aValue['number'] * Currency::PrintPrice($aValue['price']);
			
			Base::$tpl->assign('dOrderSubtotal',$dOrderSubtotal);
			
			$oTable->aOrdered="order by c.post desc";
			$oTable->aCallback=array($this,'CallParseOrder');

			//		else $oTable->sSql="select 1 from cart where 1!=1";
			//and c.order_status!='pending'

			$oTable->aColumn=array(
			//'id'=>array('sTitle'=>'man_Order #',),
			'id_cart_package'=>array('sTitle'=>'#CP'),
			'user'=>array('sTitle'=>'man_User'),
			'cat_name'=>array('sTitle'=>'man_Brand'),
			'code'=>array('sTitle'=>'CartCode'),
			'name'=>array('sTitle'=>'Name'),
			'provider'=>array('sTitle'=>'Provider'),
			'price'=>array('sTitle'=>'Price'),
			//'number'=>array('sTitle'=>'Qty'),
			'total'=>array('sTitle'=>'Qty/Total'),
			//'buh_balance'=>array('sTitle'=>'Balance'),
			//'debt'=>array('sTitle'=>'debt'),
			//'total_original'=>array('sTitle'=>'Sum buy'),
			//'total_profit'=>array('sTitle'=>'profit'),
			//'term'=>array('sTitle'=>'Term'),
			//'comment_manager'=>array('sTitle'=>'Commnet Manager'),
			//'date_wait'=>array('sTitle'=>'Date wait'),

			'cp_post_date_f'=>array('sTitle'=>'Date'),
			'order_status'=>array('sTitle'=>'man_Order Status'),
			'action'=>array(),
			);
			$oTable->iRowPerPage=50;
			$oTable->sSubtotalTemplateTop='manager/subtotal_order_top.tpl';
			$oTable->sDataTemplate='manager/row_order.tpl';
			//$oTable->sButtonTemplate='manager/button_order.tpl';
			$oTable->bCheckVisible=true;
			$oTable->bDefaultChecked=false;
			$oTable->sSubtotalTemplate='manager/subtotal_order.tpl';

			Base::$sText.=$oTable->getTable();
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function CallParseOrder(&$aItem)
	{
		require_once(SERVER_PATH.'/class/core/String.php');
		require_once(SERVER_PATH.'/class/system/Currency.php');

		if ($aItem) {
			foreach($aItem as $key => $value) {
				$aOrderId[]=$value['id'];

				$aItem[$key]['name']="<b>".$value['name'].
				"</b><br>".String::FirstNwords($value['customer_comment'],5);
				$aItem[$key]['total']=$value['number']*Currency::PrintPrice($value['price']);
				$aItem[$key]['discount']=max(array($value['discount_static']
				, $value['discount_dynamic'], $value['group_discount']));
				$aItem[$key]['debt']=Currency::PrintPrice(
				max(array($value['user_debt'], $value['group_debt'])),$value['code_currency']);
			}

			$aHistory=Base::$db->getAll("select * from cart_log
				where id_cart in (".implode(',',$aOrderId).")");
			if ($aHistory) foreach($aHistory as $key => $value) {
				//$value['post']=DateFormat::getDateTime($value['post']);
				$aHistoryHash[$value['id_cart']][]=$value;
			}

			foreach($aItem as $key => $value) {
				if ($aHistoryHash && in_array($value['id'],array_keys($aHistoryHash)) ) {
					$aItem[$key]['history']=$aHistoryHash[$value['id']];
				}
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function ChangeStatus()
	{
		if (Base::$aRequest['row_check']) {
			foreach (Base::$aRequest['row_check'] as $sKey => $sValue) {
				$sMessage.=$sValue.":".$this->ProcessOrderStatus($sValue,Base::$aRequest['order_status'])." ";
			}
			Form::RedirectAuto("&aMessage[MT_NOTICE_NT]=".$sMessage);
		} elseif (Base::$aRequest['id'] && Base::$aRequest['order_status']) {
			//Base::$oResponse->addAlert('1');
			$sMessage=$this->ProcessOrderStatus(Base::$aRequest['id'],Base::$aRequest['order_status']);
			Base::$oResponse->AddAlert($sMessage);
		} else {
			Form::RedirectAuto("&aMessage[MT_ERROR]=Need to check item");
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function AgreeGrowth()
	{
		if (Base::$aRequest['id']) {
			$aCart['is_agree_growth']=(Base::$aRequest['checked'] ? 1:0);
			Base::$db->AutoExecute('cart',$aCart,'UPDATE',"id='".Base::$aRequest['id']."'");
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function Reorder()
	{
		$aCart=Base::$db->getRow("
				select cg.*,u.*,uc.*,c.*,u.login, uc.name as customer_name
				from cart c
				inner join user u on c.id_user=u.id
				inner join user_customer uc on uc.id_user=u.id
				inner join customer_group cg on uc.id_customer_group=cg.id
				inner join user_account ua on ua.id_user=u.id

				where 1=1 and c.type_='order'
				and c.id='".Base::$aRequest['id']."'
				and c.id_user in (".$this->sCustomerSql.")");

		if (Base::$aRequest['is_post']) {

			if (!Base::$aRequest['code'] || !Base::$aRequest['price'] || !Base::$aRequest['number']) {
				$sError="Please, fill the required fields";
			}
			if (Base::$aRequest['price'] < $aCart['price_original']) {
				$sError="Reorders price is less than price original";
			}

			if ($sError) Base::$tpl->assign('aData',Base::$aRequest);
			else {
				//[----- UPDATE -----------------------------------------------------]
				Debt::CheckPayDebt(Base::$aRequest['id']);

				if ($aCart['order_status']!='refused') {
					Finance::Deposit($aCart['id_user'],$aCart['price']*$aCart['number'],Language::getMessage('Reordered Detal'),
					$aCart['id'],'internal','cart','',5);

					//InvoiceAccountLog::AddItem($aCart['id'],-$aCart['price']*$aCart['number'],Language::GetMessage('ii_reorder'));
				}


				Base::$db->Execute("insert into cart_log (id_cart,post,order_status,comment)
				values ('".Base::$aRequest['id']."',UNIX_TIMESTAMP(),'reorder'
				,'".Language::getMessage('New status').": ".Language::getMessage(Base::$aRequest['order_status'])."')");

				Base::$db->Execute("update cart set
				code='".Base::$aRequest['code']."',
				price='".Base::$aRequest['price']."',
				number='".Base::$aRequest['number']."',
				order_status='".Base::$aRequest['order_status']."',
				manager_comment= '".Base::$aRequest['manager_comment']."',
				name_translate='".Base::$aRequest['name_translate']."',
				weight='".Base::$aRequest['weight']."',
				sign='".Base::$aRequest['sign']."'
				where id='".Base::$aRequest['id']."'
				and id_user in (".$this->sCustomerSql.") ");

				if (Base::$aRequest['order_status']!='refused') {
					Finance::Deposit($aCart['id_user'],-Base::$aRequest['price']*Base::$aRequest['number']
					,Language::getMessage('Detal #').Base::$aRequest['id'],Base::$aRequest['id'],'internal','cart','',5);

					//InvoiceAccountLog::AddItem(Base::$aRequest['id'],Base::$aRequest['price']*Base::$aRequest['number']
					//,Language::GetMessage('ii_reorder'));
				}
				//[----- END UPDATE -------------------------------------------------]
				Form::AfterReturn('manager_order');
			}
		}

		if (!Base::$aRequest['is_post']) {

			if (!$aCart) Base::Redirect('/?action=manager_order');

			Base::$tpl->assign('aData',$aCart);
		}

		Form::BeforeReturn('manager_order','manager_reorder');

		include(SERVER_PATH.'/include/order_status_config.php');
		Base::$tpl->assign('aOrderStatusConfig',$aOrderStatusConfig['work']);

		$aData=array(
		'sHeader'=>"method=post",
		'sTitle'=>"Reorder Cart item",
		'sContent'=>Base::$tpl->fetch('manager/form_reorder.tpl'),
		'sSubmitButton'=>'Apply',
		'sSubmitAction'=>'manager_reorder',
		'sReturnAction'=>'manager_order',
		'sReturnButton'=>'<< Return',
		'bConfirmSubmit'=>true,
		'sError'=>$sError,
		);
		$oForm=new Form($aData);
		Base::$sText.=$oForm->getForm();
		return;
	}
	//-----------------------------------------------------------------------------------------------
	//	public function Archive() {
	//		if (Base::$aRequest['is_archive']) $iIsArchive=1;
	//		$sQuery="update cart set
	//				is_archive='".$iIsArchive."'
	//			where id='".Base::$aRequest['id']."'
	//				and type_='order'
	//				and id_user in (".$this->sCustomerSql.")
	//				";
	//		Base::$db->Execute($sQuery);
	//		$this->OrderList();
	//	}
	//-----------------------------------------------------------------------------------------------
	//	public function XajaxRequest($oReponse) {
	//		Base::$db->Execute("select * from user");
	//		$oReponse->addAlert('Ok');
	//	}

	//-----------------------------------------------------------------------------------------------
	public function Bill()
	{
		if (Base::$aRequest['is_post'])
		{
			if (!Base::$aRequest['amount']) {
				Form::ShowError("Please, fill the required fields");
				Base::$aRequest['action']='manager_bill_add';
				Base::$tpl->assign('aData',Base::$aRequest);
			}
			else {
				if (!Base::$aRequest['id']) {
					//[----- INSERT -----------------------------------------------------]
					$sQuery="insert into bill(id_user,amount,code_template,post)
        			        values('".Base::$aRequest['id_user']."','".Base::$aRequest['amount']."'
        			        	,'".Base::$aRequest['code_template']."',UNIX_TIMESTAMP())";
					//[----- END INSERT -------------------------------------------------]
				}
				else {
					//[----- UPDATE -----------------------------------------------------]
					$sQuery="update bill set
							id_user='".Base::$aRequest['id_user']."',
							code_template='".Base::$aRequest['code_template']."',
							amount='".Base::$aRequest['amount']."'
				               where id='".Base::$aRequest['id']."'
				               	and id_user in (".$this->sCustomerSql.")
				               ";
					//[----- END UPDATE -------------------------------------------------]
				}
				Base::$db->Execute($sQuery);
				Base::Redirect("/?action=manager_bill");
			}
		}

		if (Base::$aRequest['action']=='manager_bill_add' || Base::$aRequest['action']=='manager_bill_edit') {
			if (Base::$aRequest['action']=='manager_bill_edit') {
				$aBill=Base::$db->getRow("select * from bill where id='".Base::$aRequest['id']."'
						and id_user in (".$this->sCustomerSql.")
					");
				Base::$tpl->assign('aData',$aBill);
			}

			Base::$tpl->assign('aUser',$this->getCustomerList());
			Base::$tpl->assign('aBillTemplate',Base::$db->getAll("select * from template where type_='bill'"));

			$aData=array(
			'sHeader'=>"method=post",
			'sTitle'=>"User Bill",
			'sContent'=>Base::$tpl->fetch('manager/form_bill.tpl'),
			'sSubmitButton'=>'Apply',
			'sSubmitAction'=>'manager_bill',
			'sReturnButton'=>'<< Return',
			'sError'=>$sError,
			);
			$oForm=new Form($aData);

			Base::$sText.=$oForm->getForm();

			return;
		}

		if (Base::$aRequest['action']=='manager_bill_delete') {
			Base::$db->Execute("delete from bill where id='".Base::$aRequest['id']."'
					and id_user in (".$this->sCustomerSql.")");
		}

		require_once(SERVER_PATH.'/class/core/Table.php');
		$oTable=new Table();
		$oTable->sSql="select cg.*,uc.*, ua.* ,u.*, cg.name as group_name
				, b.*, t.name as template_name
				, m.login as manager_login
			from bill b, template t, user u
				inner join user_customer uc on u.id=uc.id_user
				inner join customer_group cg on uc.id_customer_group=cg.id
				inner join user_account ua on ua.id_user=u.id
				inner join user m on uc.id_manager=m.id

			where 1=1 and b.code_template=t.code
				and b.id_user=u.id
				and b.id_user in (".$this->sCustomerSql.")
				group by b.id
			";
		$oTable->aOrdered=" order by b.post desc";
		$oTable->aColumn=array(
		'login'=>array('sTitle'=>'Customer','sWidth'=>'40%'),
		'amount'=>array('sTitle'=>'Amount','sWidth'=>'150px'),
		'template'=>array('sTitle'=>'Template','sWidth'=>'30%'),
		'post'=>array('sTitle'=>'Date','sWidth'=>'40%'),
		'action'=>array(),
		);
		$oTable->sDataTemplate='manager/row_bill.tpl';
		$oTable->sAddButton="Add";
		$oTable->sAddAction="manager_bill_add";
		//$oTable->aCallback=array($this,'CallParseBill');

		Base::$sText.=$oTable->getTable("Customer Bills");
	}
	//-----------------------------------------------------------------------------------------------
	//	public function CallParseBill(&$aItem) {
	//		require_once(SERVER_PATH.'/class/core/DateFormat.php');
	//		if ($aItem) foreach($aItem as $key => $value) {
	//			$aItem[$key]['post_date']=DateFormat::getDateTime($value['post']);
	//		}
	//	}
	//-----------------------------------------------------------------------------------------------
	public function ProcessOrderStatus($iId='',$sOrderStatus='',$sComment='',$sIdProviderOrder='',$dProviderPrice=''
	,$sIdProviderInvoice='',$sCustomValue='')
	{
		$iId_GeneralCurrencyCode = Db::getOne("Select id from currency where id=1");
		
		if (!$iId) $iId=Base::$aRequest['id'];
		if (!$sOrderStatus) $sOrderStatus=Base::$aRequest['order_status'];
		if (!$sComment) $sComment=Base::$aRequest['comment'];
		if (!$sIdProviderOrder) $sIdProviderOrder=Base::$aRequest['id_provider_order'];
		if (!$sIdProviderInvoice) $sIdProviderInvoice=Base::$aRequest['id_provider_invoice'];
		if (!$dProviderPrice) $dProviderPrice=Base::$aRequest['provider_price'];
		if (!$sCustomValue) $sCustomValue=Base::$aRequest['custom_value'];
		$iId=trim($iId);
		$sOrderStatus=trim($sOrderStatus);
		$sComment=trim($sComment);
		$sIdProviderOrder=trim($sIdProviderOrder);
		$sIdProviderInvoice=trim($sIdProviderInvoice);
		$sCustomValue=trim($sCustomValue);

		$aCart=Db::GetRow(Base::GetSql('Part/Search',array(
		'id_cart'=> $iId,
		'where'=>" and c.type_='order' ",
		)));
		//and prg.id in (".implode(',',$this->aUserManagerRegionId).")

		if (!$aCart) return Language::getMessage('No such order or access denied by region and other permissions');
		$this->sCurrentOrderStatus=$aCart['order_status'];

		require(SERVER_PATH.'/include/order_status_config.php');

		//		if (!$sOrderStatus || !(in_array($sOrderStatus,array_keys($aOrderStatusConfig))
		//		|| in_array($sOrderStatus,$aUnstateOrderStatus)) )
		//		return Language::getMessage('Error: Not valid next status');

		if (!in_array($sOrderStatus,$aUnstateOrderStatus) )	{
			if (!$aOrderStatusConfig[$aCart['order_status']]
			|| !in_array($sOrderStatus,$aOrderStatusConfig[$aCart['order_status']])
			|| $sOrderStatus==$aCart['order_status']
			)
			return ;
		//Language::getMessage('Error: Not valid next status');
		}

		//	if ($sOrderStatus==$aCart['order_status']) return Language::getMessage('Error: The same next status: not changed.');

		switch ($sOrderStatus) {
			case 'change_price':
				$aChangeResult=$this->ChangeCart($aCart,$sOrderStatus,$sCustomValue);
				//Price::AddItem($aCart,$dProviderPrice);
				Catalog::UpdatePrice($aCart['item_code'],$aCart['id_provider'],$sCustomValue);
				$this->SetPriceTotalCartPackage($aCart);
				if (!$aChangeResult['bResult']) return Language::getMessage($aChangeResult['sMessage']);
				break;
			case 'change_quantity':
				$aChangeResult=$this->ChangeCart($aCart,$sOrderStatus,$sCustomValue);
				$this->SetPriceTotalCartPackage($aCart);
				if (!$aChangeResult['bResult']) return Language::getMessage($aChangeResult['sMessage']);
				break;
			case 'change_code':
				$aChangeResult=$this->ChangeCart($aCart,$sOrderStatus,$sCustomValue);
				if (!$aChangeResult['bResult']) return Language::getMessage($aChangeResult['sMessage']);
				break;
		}


		if (!in_array($sOrderStatus,$aUnstateOrderStatus) )
		{
			if ($sOrderStatus=='work') $sDateUpdate=" ,post=UNIX_TIMESTAMP(),post_date=now()";
			//else $sDateUpdate='';
			Base::$db->Execute("update cart set
					order_status='$sOrderStatus'
					$sDateUpdate
					where id='$iId' ");
		}
		else {
			if ($sOrderStatus=='change_price') $sCustomValue=$aChangeResult['sPreviousNext'];
			if ($sOrderStatus=='change_quantity') $sCustomValue=$aChangeResult['sPreviousNext'];
			//if ($sOrderStatus=='change_code') $sCustomValue=$aCart['code'];
			$sComment=mysql_escape_string(Language::getMessage($sOrderStatus).': '.$sCustomValue.' '.$sComment);
		}

		if ($sIdProviderOrder)  $sIdProviderOrderSqlUpdate=" , id_provider_order='$sIdProviderOrder'";
		if ($sIdProviderInvoice)  $sIdProviderInvoiceSqlUpdate=" , id_provider_invoice='$sIdProviderInvoice'";
		if ($dProviderPrice)  $sProviderPriceSqlUpdate=" , provider_price='$dProviderPrice'";
		if ($sComment)  $sCommentSqlUpdate=" , manager_comment= concat(manager_comment,'".$sComment."',' ; ') ";

		if ($sComment || $sIdProviderOrder || $sIdProviderInvoice || $dProviderPrice) {
			Base::$db->Execute("update cart set id_user=id_user
				$sIdProviderOrderSqlUpdate
				$sProviderPriceSqlUpdate
				$sIdProviderInvoiceSqlUpdate
				$sCommentSqlUpdate
						where id='$iId'");
		}
		// for buh amount module
		//$dTotal=Currency::PrintPrice($aCart['price'],$iId_GeneralCurrencyCode,2,"<none>")*$aCart['number'];
		if ($sOrderStatus=='refused') $this->SetPriceTotalCartPackage($aCart);

		Base::$db->Execute("insert into cart_log (id_cart,post,order_status,comment,id_user_manager)
				values ('$iId',UNIX_TIMESTAMP(),'$sOrderStatus'
					,'$sComment',".Auth::$aUser["id"].")");

		$aCart['comment']=$sComment;
		//require_once(SERVER_PATH.'/class/core/DateFormat.php');
		$aCart['date']=DateFormat::getDateTime(time());

		$aCartManager=Db::GetRow(Base::GetSql('Manager',array(
		'id'=>$aCart['id_manager'],
		)));
		$aCartCustomer=Db::GetRow(Base::GetSql('Customer',array(
		'id'=>$aCart['id_user'],
		)));

		switch ($sOrderStatus) {
			case 'work':
				Message::CreateDelayedNotification($aCart['id_user'],'order_is_work'
				,array('aCart'=>$aCart,'aManager'=>$aCartManager,'aCustomer'=>$aCartCustomer),true,$aCart['id']);
				break;
			case 'confirmed':
				Message::CreateDelayedNotification($aCart['id_user'],'order_is_confirmed'
				,array('aCart'=>$aCart,'aManager'=>$aCartManager,'aCustomer'=>$aCartCustomer),true,$aCart['id']);
				break;
			case 'road':
				Message::CreateDelayedNotification($aCart['id_user'],'order_is_road'
				,array('aCart'=>$aCart,'aManager'=>$aCartManager,'aCustomer'=>$aCartCustomer),true,$aCart['id']);
				break;
			case 'store':
				Message::CreateDelayedNotification($aCart['id_user'],'order_is_store'
				,array('aCart'=>$aCart,'aManager'=>$aCartManager,'aCustomer'=>$aCartCustomer),true,$aCart['id']);
				$aCart['order_status']=$sOrderStatus;
				break;
			case 'end':
				Message::CreateDelayedNotification($aCart['id_user'],'order_is_end'
				,array('aCart'=>$aCart,'aManager'=>$aCartManager,'aCustomer'=>$aCartCustomer),true,$aCart['id']);
				break;
			case 'refused':
				//Finance::Deposit($aCart['id_user'],$aCart['price']*$aCart['number'],Language::getMessage("Refused order #")
				//." $aCart[id]",$aCart[id],'internal','cart','',4);

				Message::CreateDelayedNotification($aCart['id_user'],'order_is_refused'
				,array('aCart'=>$aCart,'aManager'=>$aCartManager,'aCustomer'=>$aCartCustomer),true,$aCart['id']);

				$aCart['order_status']=$sOrderStatus;
				break;
				//			case 'reclamation':
				//				Message::CreateDelayedNotification($aCart['id_user'],'order_is_reclamation'
				//				,array('aCart'=>$aCart),true,$aCart['id']);
				//
				//				Db::Execute("update cart_package set order_status='work' where id=".$aCart['id_cart_package']);
				//				break;
			case 'reclamation':
				$dAmount=Currency::PrintPrice($aCart['price'],$iId_GeneralCurrencyCode,2,"<none>")*$aCart['number'];
				/*if(!Base::$aRequest['commission'])Base::$aRequest['commission']=0;
				if(Base::$aRequest['commission_type']=='percent'){
					$dAmount=$dAmount*(1-Base::$aRequest['commission']/100);
				}elseif(Base::$aRequest['commission_type']=='absolute'){
					if($dAmount>=Base::$aRequest['commission'])
						$dAmount=$dAmount-Base::$aRequest['commission'];
					else
						$dAmount=0;
				}*/
				$sName = Language::getMessage('return for').' '.$aCart['code'].' '.$aCart['cat_title'].' ['.$aCart['number'].' '.Language::getMessage('col.').']';
				Finance::Deposit($aCart['id_user'],$dAmount
				,Language::getMessage("Returned order #")." ".$aCart['id'].Finance::GetDescriptionDebt($dAmount,$sName)
				,$aCart['id'],'cart','',3335,361);
				
				Message::CreateDelayedNotification($aCart['id_user'],'order_is_returned'
						,array('aCart'=>$aCart,'aManager'=>$aCartManager,'aCustomer'=>$aCartCustomer),true,$aCart['id']);
			
				/*if($aCartCustomer['id_parent'])
					Finance::Deposit($aCartCustomer['id_parent'],(-1)*($aCart['price_parent_margin']*$aCart['number'])
							,Language::getMessage("returned Vip order #")." ".$aCart['id'].Finance::GetDescriptionDebt($aCart['price_parent_margin']*$aCart['number'])
							,$aCart['id'],'cart','',3341,361);*/
			
				$aCart['order_status']=$sOrderStatus;
				break;
		}

		if (!in_array($sOrderStatus,$aUnstateOrderStatus) )
		{
			Cron::CloseCartPackage($aCart['id_cart_package'],$sOrderStatus);
		}
		return Language::getMessage('Changed ok.');
	}
	//-----------------------------------------------------------------------------------------------
	public function ChangeCart($aCart,$sOrderStatus,$sCustomValue)
	{
		$iId_GeneralCurrencyCode = Db::getOne("Select id from currency where id=1");
		
		$aCartManager=Db::GetRow(Base::GetSql('Manager',array(
			'id'=>$aCart['id_manager'],
		)));
		$aCartCustomer=Db::GetRow(Base::GetSql('Customer',array(
			'id'=>$aCart['id_user'],
		)));
		
		switch ($sOrderStatus) {
			case 'change_price':
				if ( stripos($aCart['sign'],'AGRE')===false && $sCustomValue>$aCart['price_original']
				&& !Base::$aRequest['ignore_confirm_growth']){
					return array('bResult'=>false,'sMessage'=>'Not valid cart sign');
				}
				//if (!Base::$aConstant['price_growth']['value']) $dPriceGrowth=10;
				$dPriceGrowth=Base::GetConstant('price_growth',10);

				if (!$aCart['price_original'])
				return array('bResult'=>false,'sMessage'=>'empty original price');
				if (!is_numeric($sCustomValue) || !$sCustomValue || $sCustomValue<=0)
				return array('bResult'=>false,'sMessage'=>'new price is not valid');

				$aCart['price'] = Currency::PrintPrice($aCart['price'],$iId_GeneralCurrencyCode,2,"<none>");
				
				if ( (($sCustomValue-$aCart['price']) / $aCart['price']) <= ($dPriceGrowth/100)
				|| $sCustomValue<$aCart['price'] || Base::$aRequest['ignore_confirm_growth'])
				{
					$sPreviousValue=$aCart['price'];
					$sNextValue=$sCustomValue;

					$dAmount=$aCart['number']*($aCart['price']-$sCustomValue);
					$sSql="update cart set price='".$sCustomValue."' where id='{$aCart['id']}'";

					$aCart['order_status']=$sOrderStatus;
					$aCart['comment']=Language::getMessage('change_price_comment price_difference').':'
					.($sCustomValue-$aCart['price']);

				}
				else return array('bResult'=>false,'sMessage'=>'missed new percentage '.$dPriceGrowth.'%');
				break;

			case 'change_quantity':
				if ( stripos($aCart['sign'],'QUAN')!==false)
				return array('bResult'=>false,'sMessage'=>'Not valid cart sign');
				//if ( $sCustomValue>=$aCart['number'] || !$sCustomValue)
				if (!$sCustomValue)
				return array('bResult'=>false,'sMessage'=>'Not valid number');

				$sPreviousValue=$aCart['number'];
				$sNextValue=$sCustomValue;

				$dAmount=$aCart['price']*($aCart['number'] - $sCustomValue);
				$sSql="update cart set number='$sCustomValue' where id='{$aCart['id']}'";
				break;

			case 'change_code':
				if (!$sCustomValue)	return array('bResult'=>false,'sMessage'=>'Not valid code');

				$sPreviousValue=$aCart['code'];
				$sNextValue=$sCustomValue;

				$aCart['order_status']=$sOrderStatus;
				$aCart['comment']=Language::getMessage('change_code_comment new-code').':'
				.Base::$aRequest['pref_changed']."_".$sCustomValue;

				if ( stripos($aCart['sign'],'ONLY')!==false) return array('bResult'=>false,'sMessage'=>'Not valid cart sign');

				$sSql="update cart set code_changed='".Catalog::StripCode($sCustomValue)."', pref_changed='"
				.Base::$aRequest['pref_changed']."' where id='{$aCart['id']}'";

				break;
		}
		if ($dAmount) {
			Finance::Deposit($aCart['id_user'],$dAmount,Language::getMessage($sOrderStatus).' '.$aCart['id']
			." : $sPreviousValue => $sNextValue",$aCart['id']
			,'internal','cart','',6);
			//			InvoiceAccountLog::AddItem($aCart['id'],-$dAmount
			//			,Language::GetMessage('ii_change_price_quantity')." $sPreviousValue => $sNextValue");
		}
		if ($sSql) Base::$db->Execute($sSql);
		$aCart['change_date'] = date('Y-m-d H:i:s');
		switch($sOrderStatus)
		{
			case 'change_price':
				$sSubject = 'Price of part in order is changed';
				$aCart['new_price'] = $sCustomValue;
				//$aData=array('cart_data'=>$aCart);
				$sCode='change_price';
				break;
			case 'change_quantity':
				$sSubject = 'Quantity of parts in order is changed';
				$aCart['new_num'] = $sCustomValue;
				//$aData=array('cart_data'=>$aCart);
				$sCode='change_quantity';
				break;
			case 'change_code':
				$sSubject = 'Code of part in order is changed';
				$aCart['code_changed'] = $sCustomValue;
				//$aData=array('cart_data'=>$aCart);
				$sCode='change_code';
				break;
		};
		Message::CreateDelayedNotification($aCart['id_user'], $sCode
		,array('aCart'=>$aCart, 'info' => $aCartCustomer, 'aManager' => $aCartManager),true,$aCart['id']);
		$aChangeResult=array(
		'bResult'=>true,
		'sMessage'=>Language::getMessage('Changed ok. But notification not created'),
		'sPreviousNext'=>" $sPreviousValue => $sNextValue",
		);
		return $aChangeResult;
	}
	//-----------------------------------------------------------------------------------------------
	public function VinRequest()
	{
		Base::$aTopPageTemplate=array('panel/tab_manager_cart.tpl'=>'vin_request');

		// ######### Edit #########
		if ( Base::$aRequest['action']=='manager_vin_request_edit') {

			Form::BeforeReturn('manager_vin_request');

			$aVinRequest=Base::$db->getRow(Base::GetSql('VinRequest',array(
			'id'=>Base::$aRequest['id'],
			//'id_in'=>$this->GetVinIdList(),
			)));

			//			if (Auth::$aUser['id_vin_request_fixed']!=Base::$aRequest['id']
			//			&& Auth::$aUser['id_vin_request_fixed']
			//			&& !Auth::$aUser['is_sub_manager']
			//			&& !Auth::$aUser['is_super_manager']
			//			&& Auth::$aUser['id'] != $aVinRequest['id_manager_fixed']
			//			) Base::Redirect('/?action=manager_vin_request');


			if (!$aVinRequest) Base::Redirect('/?action=manager_vin_request');
			if ($aVinRequest['order_status']=='new') {
				//				if (!$aVinRequest['id_manager_fixed']) {
				//					$sSet.=",id_manager_fixed='".Auth::$aUser['id']."'";
				//					Base::$db->Execute("update user_manager set id_vin_request_fixed='".Base::$aRequest['id']."'
				//						where id_user='".Auth::$aUser['id']."'");
				//					Auth::$aUser['id_vin_request_fixed']=Base::$aRequest['id'];
				//					Base::$tpl->assign('aAuthUser',Auth::$aUser);
				//					Base::$db->Execute("update user_customer set id_manager='".Auth::$aUser['id']."'
				//						where id_user='".$aVinRequest['id_user']."'");
				//				}
				Base::$db->Execute("update vin_request set order_status='work' $sSet
					where id='".Base::$aRequest['id']."'");
			}

			require_once(SERVER_PATH.'/class/system/Currency.php');
			$aVinRequest['discount']=max(array($aVinRequest['discount_static']
			, $aVinRequest['discount_dynamic'], $aVinRequest['group_discount']));
			$aVinRequest['debt']=Currency::PrintPrice(
			max(array($aVinRequest['user_debt'], $aVinRequest['group_debt'])),$aVinRequest['code_currency']);

			Base::$tpl->assign('aData',$aVinRequest);

			$aData=array(
			'sHeader'=>"method=post",
			'sTitle'=>"VIN Request Preview",
			'sAdditionalTitle'=>" # ".Base::$aRequest['id'],
			'sContent'=>Base::$tpl->fetch('manager/form_vin_request.tpl'),
			'bShowBottomForm'=>false,
			'sError'=>$sError,
			);
			$oForm=new Form($aData);
			Base::$sText.=$oForm->getForm();

			$aPartList=unserialize($aVinRequest['part_array']);
			if ($aPartList) foreach ($aPartList as $key => $value)
			$aPartList[$key]['name']=base64_decode($value[name]);

			Base::$tpl->assign('aPartList',$aPartList);
			if ($aPartList) {
				foreach ($aPartList as $value) {
					$dSubtotal+=floatval($value['number'])*floatval($value['price']);
				}
			}
			Base::$tpl->assign('dSubtotal',$dSubtotal);
			Base::$tpl->assign('iRowCount',count($aPartList));

			Base::$tpl->assign('aManagerLogin',  Base::$db->GetAssoc(Base::GetSql('Manager/LoginAssoc')) );

			Base::$sText.=Base::$tpl->fetch('manager/form_vin_request_part_list.tpl');
			return;
		}

		// ######### List #########
		$sSql="select u.*,uc.* from user u
			inner join user_customer uc on u.id=uc.id_user
			 where 1=1
			 	and u.id in (".$this->sCustomerSql.")";
		Base::$tpl->assign('aCustomer',Base::$db->getAll($sSql));

		$aData=array(
		'sHeader'=>"method=get",
		//'sTitle'=>"Search vin requests",
		'sContent'=>Base::$tpl->fetch('manager/form_vin_request_search.tpl'),
		'sSubmitButton'=>'Search',
		'sSubmitAction'=>'manager_vin_request',
		'sReturnButton'=>'Clear',
		'bIsPost'=>0,
		'sError'=>$sError,
		);
		$oForm=new Form($aData);

		Base::$sText.=$oForm->getForm();

		// --- search ---
		if (Base::$aRequest['search']['id']) $sWhere.=" and vr.id = '".Base::$aRequest['search']['id']."'";
		if (Base::$aRequest['search']['login']) $sWhere.=" and u.login ='".Base::$aRequest['search']['login']."'";
		if (Base::$aRequest['search']['is_remember']) $sWhere.=" and vr.is_remember ='1'";
		if (Base::$aRequest['search']['phone']) $sWhere.=" and uc.phone like '%".Base::$aRequest['search']['phone']."%'";
		if (Base::$aRequest['search']['email']) $sWhere.=" and u.email like '%".Base::$aRequest['search']['email']."%'";
		if (Base::$aRequest['search']['order_status']) $sWhere.=" and vr.order_status = '"
		.Base::$aRequest['search']['order_status']."'";
		if (Base::$aRequest['search']['marka']) $sWhere.=" and vr.marka = '".Base::$aRequest['search']['marka']."'
			and vr.order_status!='new'";
		// --------------

		$oTable=new Table();
		$oTable->sSql="select uc.*, cg.*,u.*,uc.*,u.login, uc.name as customer_name
					, m.login as manager_login
					, vr.*
					from vin_request vr
				inner join user u on vr.id_user=u.id
				inner join user_customer uc on uc.id_user=u.id
				inner join customer_group cg on uc.id_customer_group=cg.id
				inner join user_account ua on ua.id_user=u.id
				inner join user m on uc.id_manager=m.id
			where vr.id_user=u.id
				".$sWhere;

		$oTable->aOrdered="order by vr.post desc";
		$oTable->iRowPerPage=20;
		$oTable->aColumn=array(
		'id'=>array('sTitle'=>'#'),
		'order_status'=>array('sTitle'=>'Order Status'),
		'id_user'=>array('sTitle'=>'Customer/Phone'),
		'vin'=>array('sTitle'=>'VIN'),
		'post'=>array('sTitle'=>'Post'),
		'order_status'=>array('sTitle'=>'Status'),
		'marka'=>array('sTitle'=>'Marka'),
		'manager_comment'=>array('sTitle'=>'Manager Comment/Remember'),
		'action'=>array(),
		);
		$oTable->aCallback=array($this,'CallParseVinRequest');
		$oTable->sDataTemplate='manager/row_vin_request.tpl';

		Base::$sText.=$oTable->getTable("Vin requests from customers");
	}
	//-----------------------------------------------------------------------------------------------
	public function CallParseVinRequest(&$aItem)
	{
		//require_once(SERVER_PATH.'/class/core/DateFormat.php');
		require_once(SERVER_PATH.'/class/core/String.php');
		require_once(SERVER_PATH.'/class/system/Currency.php');

		if ($aItem) {
			foreach($aItem as $key => $value) {
				$aOrderId[]=$value['id'];
				$aItem[$key]['discount']=max(array($value['discount_static']
				, $value['discount_dynamic'], $value['group_discount']));
				$aItem[$key]['debt']=Currency::PrintPrice(
				max(array($value['user_debt'], $value['group_debt'])),$value['code_currency']);
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function VinRequestSave($bRedirect=true)
	{
		if (Base::$aRequest['is_post']) {
			$aUserInputCode = array();

			if (Base::$aRequest['data']['change_login'] && Base::$aRequest['data']['current_login']) {
				Db::Execute("update user inner join user_customer on user.id=user_customer.id_user
				set user.login='".Base::$aRequest['data']['change_login']."'
				, user.email='".Base::$aRequest['data']['email']."'
				, user_customer.phone='".Base::$aRequest['data']['phone']."'
				where user.login='".Base::$aRequest['data']['current_login']."'");
			} else {
				Db::Execute(" update user inner join user_customer on user.id=user_customer.id_user
				set user.email='".Base::$aRequest['data']['email']."'
				, user_customer.phone='".Base::$aRequest['data']['phone']."'
				where user.login='".Base::$aRequest['data']['current_login']."'"
				);
			}




			//[----- UPDATE -----------------------------------------------------]
			if (Base::$aRequest['part']) {
				require_once(SERVER_PATH.'/class/module/Catalog.php');
				$j = 0;
				foreach(Base::$aRequest['part'] as $value) {
					++ $j;
					if(
					$value['user_input_code'] &&
					(strripos($value['code'], "ZZZ_") !== false)
					)
					{
						$aUserInputCode[$j] = $value['user_input_code'];
					} else {
						$aUserInputCode[$j] = $value['code'];
					}
					$aCode[]="'" . Catalog::StripCode( $value['code'] ) . "'";
				}
				$aCrosCode=Base::$db->GetAll("select * from cat_part where code in (".implode(',',$aCode).")");
				$aCrosHash=Language::Array2Hash($aCrosCode,'code');
			}

			for ($i=1;$i<=100;$i++) {
				if (Base::$aRequest['part'][$i]) {

					if (Base::$aRequest['part'][$i]['number']<=0) Base::$aRequest['part'][$i]['number']=1;
					require_once(SERVER_PATH.'/class/system/Discount.php');

					if ($aCrosHash[Base::$aRequest['part'][$i]['code']]['id']
					&& Base::$db->GetRow(Base::GetSql('Price/Search',array('sCode'=>"'".Base::$aRequest['part'][$i]['code']."'"
					, 'sItemCode'=>"''"	, 'price_type'=>Auth::$aUser['price_type']
					, 'customer_margin'=>Auth::$aUser['customer_group_margin']+Auth::$aUser['parent_margin']
					, 'customer_discount'=>Discount::CustomerDiscount(Auth::$aUser)))))
					{
						$sCode = 'zzz_' . $aCrosHash[ Base::$aRequest['part'][$i]['code'] ]['id'];
					} else {
						require_once(SERVER_PATH.'/class/module/Catalog.php');
						$sCode = Catalog::StripCode( Base::$aRequest['part'][$i]['code'] );
					}

					$aPartList[] = array(
					'i'=>$i,
					'name'=>base64_encode(Base::$aRequest['part'][$i]['name']),
					'marka'=>Base::$aRequest['part'][$i]['marka'],
					'code'=> $sCode,
					'user_input_code' => $aUserInputCode[$i],
					'cat_name'=>Base::$aRequest['part'][$i]['cat_name'],
					'code_visible'=>Base::$aRequest['part'][$i]['code_visible'],
					'i_visible'=>Base::$aRequest['part'][$i]['i'],
					'number'=>Base::$aRequest['part'][$i]['number'],
					'price'=>Base::$aRequest['part'][$i]['price'],
					'price_original'=>Base::$aRequest['part'][$i]['price_original'],
					'term'=>Base::$aRequest['part'][$i]['term'],
					'id_provider'=>Base::$aRequest['part'][$i]['id_provider'],
					'provider'=> $aProviderHash[Base::$aRequest['part'][$i]['id_provider']]['name'],
					'code_delivery'=> $aProviderHash[Base::$aRequest['part'][$i]['id_provider']]['code_delivery'],
					'weight'=>Base::$aRequest['part'][$i]['weight'],
					);
				}
			}
			$sPartArray=serialize($aPartList);

			Base::$db->Execute("update vin_request set
						part_array='$sPartArray',
						manager_comment= '".Base::$aRequest['manager_comment']."',
						remember_text= '".Base::$aRequest['remember_text']."'
					where id='".Base::$aRequest['id']."'
						and id in (".$this->GetVinIdList(true).") ");
			//[----- END UPDATE -------------------------------------------------]
		}
		if ($bRedirect) Base::Redirect('/?action=manager_vin_request_edit&form_message=saved&id='.Base::$aRequest['id']);
	}
	//-----------------------------------------------------------------------------------------------
	public function VinRequestSend()
	{
		if (Base::$aRequest['is_post']) {
			$this->VinRequestSave(false);

			$aVinRequest=Base::$db->getRow(Base::GetSql('VinRequest',array(
			'id'=>Base::$aRequest['id'],
			'id_in'=>$this->GetVinIdList(),
			)));
			if (!$aVinRequest) Base::Redirect('/?action=manager_vin_request');

			$aPartList=unserialize($aVinRequest['part_array']);
			if ($aPartList) foreach ($aPartList as $key => $value)
			$aPartList[$key]['name']=base64_decode($value[name]);
			$aVinRequest['part_list']=$aPartList;

			Base::$db->Execute("update vin_request set order_status='parsed' where
				order_status in ('work','refused')
				and id='".Base::$aRequest['id']."'
				and id in (".$this->GetVinIdList(true).") ");

			$this->VinRequestRelease(Base::$aRequest['id']);

			if ($aVinRequest['mobile']) {
				//$this->VinRequestMobileNotification($aVinRequest);
			}

			if (Base::$aRequest['section']=='customer') {
				//				if (Customer::IsChangeableLogin($aVinRequest['login'])) {
				//					Message::CreateDelayedNotification($aVinRequest['id_user'], 'vin_request_sent_password'
				//					,array('aVinRequest'=>$aVinRequest),true);
				//				}
				//				else {
				Message::CreateDelayedNotification($aVinRequest['id_user'], 'vin_request_sent'
				,array('aVinRequest'=>$aVinRequest),true);
				//}
			}
		}
		Base::Redirect('/?action=manager_vin_request');
	}
	//-----------------------------------------------------------------------------------------------
	public function VinRequestRefuse()
	{
		if (Base::$aRequest['is_post']) {
			$aVinRequest=Base::$db->getRow(Base::GetSql('VinRequest',array(
			'id'=>Base::$aRequest['id'],
			'id_in'=>$this->GetVinIdList(),
			)));
			if (!$aVinRequest) Base::Redirect('/?action=manager_vin_request');

			Base::$db->Execute("update vin_request set order_status='refused' where id='".Base::$aRequest['id']."'");
			$this->VinRequestRelease(Base::$aRequest['id']);

			require_once(SERVER_PATH.'/class/module/Message.php');
			Message::CreateDelayedNotification($aVinRequest['id_user'], 'vin_request_refused' ,$aVinRequest);

			if ($aVinRequest['mobile']) {
				$this->VinRequestMobileNotification($aVinRequest);
			}
		}
		Base::Redirect('/?action=manager_vin_request');
	}
	//-----------------------------------------------------------------------------------------------
	/**
	 * Makes manager able to take new vin request from general queue
	 */
	public function VinRequestRelease($iId)
	{
		Base::$db->Execute("update user_manager set id_vin_request_fixed='0'
				where id_user='".Auth::$aUser['id']."' and id_vin_request_fixed='$iId'");
	}
	//-----------------------------------------------------------------------------------------------
	public function VinRequestMobileNotification($aVinRequest)
	{
		require_once(SERVER_PATH.'/class/system/Content.php');
		$aCustomer=Base::$db->GetRow( Base::GetSql('Customer',array('id'=>$aVinRequest['id_user'])) );
		$sMessage=strip_tags(Content::GetTemplate('parsed_vin_request',array(
		'vin_request'=>$aVinRequest,
		'user'=>$aCustomer,
		)));
		require_once(SERVER_PATH.'/class/core/Sms.php');
		Sms::AddDelayed($aVinRequest['mobile'],$sMessage);

		require_once(SERVER_PATH.'/class/module/Message.php');
		$sNoteDescription=Content::GetTemplate('vin_request_mobile_parsed');
		Message::AddNote($aVinRequest['id_user'], Language::GetMessage('Vin request mobile parsed Subject')
		,$sNoteDescription);
	}
	//-----------------------------------------------------------------------------------------------
	/**
	 * Get the list of id vinrequests which manager can have access
	 *
	 * @return array
	 */
	public function GetVinIdList($bReturnArray=false)
	{
		$sVinRequestQueue=Base::GetSql('VinRequest/MyQueue',array(
		'id_manager'=>Auth::$aUser['id'],
		'view_all'=>(Auth::$aUser['is_super_manager'] || Auth::$aUser['is_sub_manager'] ? "1":"") ,
		'assoc'=>($bReturnArray ? "1":"") ,
		));
		if ($bReturnArray) {
			return implode(',',Base::$db->GetAssoc($sVinRequestQueue));
		}
		return $sVinRequestQueue;
	}
	//-----------------------------------------------------------------------------------------------
	public function VinRequestRemember()
	{
		if (Base::$aRequest['id']) {
			$aVinRequest['is_remember']=(Base::$aRequest['checked']=='true' ? 1:0);
			Base::$db->AutoExecute('vin_request',$aVinRequest,'UPDATE',"id='".Base::$aRequest['id']."'");
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function PackageAddOrderItem() {
	    if(!Base::$aRequest['zzz_code'] || !Base::$aRequest['id_cart_package']) {
	        //error
	        Base::Redirect("/?".urldecode(Base::$aRequest['return'])."&aMessage[MT_ERROR]=Ошибка добавления товара к заказу");
	    } else {
	        //all ok
	        $a=Db::GetRow(Base::GetSql('Catalog/Price',array(
	           'where'=>" and p.id='".str_replace("ZZZ_", '', Base::$aRequest['zzz_code'])."' "
	        )));
	        
	        if($a) {
	            $aCartPackage=Db::GetRow(Base::GetSql('CartPackage',array('id'=>Base::$aRequest['id_cart_package'])));
	            
	            if(!Base::$aRequest['number']) Base::$aRequest['number']=1;
	            $a['type_']='order';
	            $a['id_cart_package']=$aCartPackage['id'];
    	        $a['zzz_code'] = $a['id'];
    	        $a['id_currency_user']=(Auth::$aUser['id_currency']?Auth::$aUser['id_currency']:1);
    	        $a['price_currency_user'] = Currency::PrintPrice($a['price'],Auth::$aUser['id_currency'],2,"<none>")*Base::$aRequest['number'];
    	        
    	        if($aCartPackage['order_status']=='new') $a['order_status']='new';		//30.12.2016
    	        else $a['order_status']='new';
    	        
    	        unset($a['id']);
    	        unset($a['post_date']);
    	        $a['id_user']=$aCartPackage['id_user'];
    	        $a['session']=session_id();
    	        $a['number']=Base::$aRequest['number'];
				if(Auth::$aUser['id'])
					$a['customer_id']=Auth::$aUser['id'];
				else
					$a['customer_id']='';
    	        $a['price_parent_margin']=$a['price_original']*Auth::$aUser['parent_margin']/100;
    	        $a['price_parent_margin_second']=$a['price_original']*Auth::$aUser['parent_margin_second']/100;
    	        $a['id_provider_ordered']=$a['id_provider'];
    	        $a['provider_name_ordered']=$a['provider_name'];
        		Db::AutoExecute("cart", $a);
        		
        		//recalc order
        		$aData['id_cart_package']=$aCartPackage['id'];
        		$this->SetPriceTotalCartPackage($aData);
        		
        		Base::Redirect("/?".urldecode(Base::$aRequest['return'])."&aMessage[MT_NOTICE]=Товар добавлен к заказу успешно");
	        } else {
	            Base::Redirect("/?".urldecode(Base::$aRequest['return'])."&aMessage[MT_ERROR]=Ошибка! Нет такого товара в прайсе");
	        }
	    }
	}
	//-----------------------------------------------------------------------------------------------
	public function Package() {
	    $aGroupsG=Db::GetAssoc("select 0 as id, 'Всі' as name 
			union all
			select id,name from customer_group where visible=1");
	    $aAutors=Db::GetAssoc("select 0 as id, '' as id_autor,'Всі' as login,'' as name
			union all
			select u.id,u.login as id_autor,u.login as login,cu.name as name 
            from user u
            inner join  user_customer cu on cu.id_user=u.id
            inner join cart_package cp on cp.name_manager=u.login
			");
		Base::$tpl->assign('aAutors',$aAutors);
		$aListManager=Db::GetAssoc("select luh.id, luh.name from ec_list_of_users_h as luh
			where luh.id_manager=".Auth::$aUser['id_user']);
		Base::$tpl->assign('aListManager',$aListManager);

		Base::Message();
		$this->sPreffixAction="manager_package_list";
		Base::$aTopPageTemplate=array('panel/tab_manager_cart.tpl'=>'package_list');

		/* [ apply  */
		if (Base::$aRequest['is_post'])
		{
			//if (!Base::$aRequest['data']['id_user'] || !Base::$aRequest['data']['id_user_provider'])
			if (0)
			{
				Base::Message(array('MF_ERROR'=>'Required fields user and provider'));
				Base::$aRequest['action']=$this->sPreffix.'_add';
				Base::$tpl->assign('aData', Base::$aRequest['data']);
			}
			else
			{
				$aData=String::FilterRequestData(Base::$aRequest['data']);
				
				if(Base::$aRequest['data']['addreses']) {
				    $iIdUser=Db::GetOne("select id from user where login='".$aData['login']."' ");
				    $aAdresses=String::FilterRequestData(Base::$aRequest['data']['addreses']);
				    Db::Execute("delete from ec_addres where id_user='".$iIdUser."' and id not in ('".implode("','", array_keys($aAdresses))."') ");		//????????
				    if($aAdresses) {
				        foreach ($aAdresses as $iKey => $sValue) {
				            if(!$sValue) continue;
				            $bExist=Db::GetOne("select id from  ec_addres where id_user='".$iIdUser."' and id='".$iKey."' ");
				            
				            $aInsert=array(
				                'id_user'=>$iIdUser,
				                'addresses'=>$sValue,
				                'visible'=>'1',
				                'post_date'=>date("Y-m-d H:i:s")
				            );
				            
				            if(!$bExist) {
				                Db::AutoExecute('ec_addres',$aInsert);
				            } else {
				                Db::AutoExecute('ec_addres',$aInsert,"UPDATE", " id = '".$iKey."' ");
				            }
				        }
				    }
				}

				//$aData["date_accept"]=DateFormat::FormatSearch($aData["date_accept"]);

				if (Base::$aRequest['id']) {

					$aData['delivery_link']=str_replace("&amp;","&",$aData['delivery_link']);
					$aData['id_addres']=Base::$aRequest['id_addres'];
					$aData['date_delivery']=Base::$aRequest['date_delivery'];
					$aData['id_time']=Base::$aRequest['id_name'];
					$aData['bonus']=Base::$aRequest['bonus'];
					
					Db::AutoExecute("cart_package",$aData,"UPDATE","id=".Base::$aRequest['id']);
					$sMessage="&aMessage[MT_NOTICE]=Package updated";

					$aData['id_cart_package']=Base::$aRequest['id'];
					$this->SetPriceTotalCartPackage($aData);

					/*
					Db::Execute(" update user
					inner join user_customer on user.id=user_customer.id_user
					set user.email='".$aData['email']."'
					, user_customer.name='".$aData['name']."'
					, user_customer.address='".$aData['address']."'
					, user_customer.zip='".$aData['zip']."'
					, user_customer.city='".$aData['city']."'
					, user_customer.phone='".$aData['phone']."'
					, user_customer.phone2='".$aData['phone2']."'
					, user_customer.country='".$aData['country']."'
					, user_customer.remark='".$aData['remark']."'
					where user.login='".$aData['login']."'
					");

					
					if (Base::$aRequest['data']['change_login'] && Base::$aRequest['data']['login']) {
					    Db::Execute("update user 
            				set user.login='".Base::$aRequest['data']['change_login']."'
            				where user.login='".Base::$aRequest['data']['login']."'");
					}
					*/

				}
				else
				{
					//Db::AutoExecute("package",$aData);
					$sMessage="&aMessage[MF_ERROR]=Faild";
				}
				Form::RedirectAuto($sMessage);
			}
		}
		/* ] apply */

		//--------------------------------------------------------------------------
		if (Base::$aRequest['action']=='manager_package_order') {
			//if (!Auth::$aUser['is_super_manager']) Base::Redirect('/?action=auth_type_error');
			//require_once(SERVER_PATH.'/class/module/Finance.php');
//30.12.2016
			$aUserCart=Base::$db->getAll("select * from cart where id_cart_package='".Base::$aRequest['id']."'
				and order_status='new'
				and type_='order'
				");
			//and id_user in (".$this->sCustomerSql.")
			if (!$aUserCart) Base::Redirect('?action=manager_package_list&table_error=cart_package_not_found');
			else {
				$iIdUser=$aUserCart[0]['id_user'];
				$aUserCartId=array();
				foreach ($aUserCart as $aValue) {
					$dPriceTotal+=$aValue['price']*$aValue['number'];
					$aUserCartId[]=$aValue['id'];
				}
			}

			//if (!Finance::HaveMoney($dPriceTotal,$iIdUser))
			//Base::Redirect('/?action=manager_package_list&table_error=not_enough_money');

			require_once(SERVER_PATH.'/class/module/Cart.php');
			Cart::SendPendingWork(Base::$aRequest['id']);

			Base::Redirect("/?action=manager_package_list");
		}
		//--------------------------------------------------------------------------

		if (Base::$aRequest['action']=='manager_package_edit') {

				$aCart=Base::$db->getRow("select * from cart where id_cart_package='".Base::$aRequest['id']."'
							and id_user in (".$this->sCustomerSql.")");
				
				//recalc summa_fact
//Debug::PrintPre();
				
        		$this->SetPriceTotalCartPackage(array('id_cart_package'=>Base::$aRequest['id']));
				
				Base::$tpl->assign('sAutoInfo',OwnAuto::GetAutoInfoTip(Base::$aRequest['id']));
				Base::$tpl->assign('aDeliveryType',array(""=>"")+Db::GetAssoc("Assoc/DeliveryType"));
				Base::$tpl->assign('aPaymentType',Db::GetAssoc("select pt.id, pt.name from payment_type pt where 1=1 and pt.visible=1  order by pt.num"));
				$aOrderStatus=array(
						'new'=>"Новий",
						'pending'=>"Призупинений",
						'work'=>"В роботі",
						'end'=>'Отриманий',
						'refused'=>'Cкасований',
						);
				Base::$tpl->assign('aOrderStatus',$aOrderStatus);

				$aCartPackage=Db::GetRow(Base::GetSql("CartPackage", array("id"=>Base::$aRequest['id'])));
				Base::$tpl->assign('aUser',$aCartPackage);
				Base::$tpl->assign('aData',$aCartPackage);
				
				$aAdress=Db::GetAll("select * from ec_addres where id_user='".$aCartPackage['id_user']."' ");
				Base::$tpl->assign('aAdress',$aAdress);

				$oBuh=new Buh();
				$aPayment=$oBuh->GetAmount("cart_package",$aCartPackage['id'],361);
				Base::$tpl->assign('aPayment',$aPayment);

				if ($aPayment['id_buh_debit_subconto1']) {
					$aAccount=Db::GetRow(Base::GetSql("Account", array("id"=>$aPayment['id_buh_debit_subconto1'])));
					Base::$tpl->assign('aAccount',$aAccount);
				}

				$oContent = new Content();
				Base::$tpl->assign('oContent',$oContent);
			
			$aTime = Db::GetAll("select * from ec_time");
			Base::$tpl->assign('aTime',$aTime);
			
			$oForm=new Form();
			$oForm->sHeader="method=post";
			$oForm->sTitle="Замовник";
//			$oForm->sAdditionalTitle=" ".Base::$aRequest['id']."   &nbsp;&nbsp;&nbsp;Дата: ".$aCartPackage['post_date'];
			$oForm->sContent=Base::$tpl->fetch($this->sPrefix.'/form_package.tpl');
			$oForm->sRightTemplate=$this->sPrefix.'/right_form_package.tpl';
			$oForm->sSubmitButton='Apply';
			$oForm->sSubmitAction=$this->sPreffixAction;
			$oForm->sReturnButton='<< Return';
			$oForm->bAutoReturn=true;
			$oForm->sReturn=Base::RemoveMessageFromUrl($_SERVER ['QUERY_STRING']);
			$oForm->sWidth="380px";
			$sStyleForm='style="padding:20px 0px 0px 0px "';
			Base::$tpl->assign('sStyleForm',$sStyleForm);

			Base::$sText.=$oForm->getForm();

			$sAlreadySent = Db::GetOne("select id from mail_delayed where subject  like '%Подтверждение заказа  ".$aCartPackage['id']."%'");
			
			Base::$tpl->assign('sAlreadySent',$sAlreadySent);
			
			$oTable=new Table();

			$oTable->sSql=Base::GetSql("Part/Search",array(
			"id_cart_package"=>Base::$aRequest['id'],
			));
			
			$oTable->aOrdered="order by c.post desc";
			
			$oTable->aColumn=array(
			//'id'=>array('sTitle'=>'id_cart #',),
			//'user'=>array('sTitle'=>'man_User'),
			//'id_cart_package'=>array('sTitle'=>'man_CP'),
			'image'=>array('sTitle'=>'image',),		
			//'cat_name'=>array('sTitle'=>'Brand'),
			//'code'=>array('sTitle'=>'CartCode'),
			'name'=>array('sTitle'=>'Name','sWidth'=>'30%'),
//			'order_status'=>array('sTitle'=>'man_Order Status'),
			//'id_user'=>array('sTitle'=>'man_User'),
			//'term'=>array('sTitle'=>'Term'),
			'price'=>array('sTitle'=>'Price'),
			'number'=>array('sTitle'=>'number'),
			'price_total'=>array('sTitle'=>'Price Total'),
			'price_fact'=>array('sTitle'=>'Price Fact'),
			'count_fact'=>array('sTitle'=>'Count Fact'),
			'summa_fact'=>array('sTitle'=>'Summa Fact'),
//			'action'=>array(),
			);
			
			$oTable->iRowPerPage=200;
			$oTable->sDataTemplate='manager/row_order_new.tpl';
			$oTable->sSubtotalTemplate='manager/subtotal_cart_new.tpl';
			//$oTable->sTemplateName = 'home/table_template.tpl';
			//$oTable->sButtonTemplate='manager/button_order.tpl';
			//$oTable->bCheckVisible=true;
			//$oTable->sSubtotalTemplate='manager/subtotal_order.tpl';
//			$oTable->bStepperVisible=false;
//			$oTable->aCallback=array($this,'CallParseOrder');
			$oTable->aCallback=array($this,'CallParseCart');

			Base::$sText.=$oTable->getTable("Order");

//			Base::$sText.=Base::$tpl->fetch('manager/button_add_order_item.tpl');

			return;
		}

	    $aList=Db::GetAssoc("select 0 as id_list, '' as name
			union all
			select id as id_list,name
            from ec_list_of_users_h where id_manager='".Auth::$aUser['id_user']."'");
		Base::$tpl->assign('aList',$aList);
		
		
		
		Base::Message();

		Base::$tpl->assign("aPref",array(""=>"")+Db::GetAssoc("Assoc/Pref"));
		Base::$sText.=Base::$tpl->fetch('manager/link_package_search.tpl');
		//Base::$tpl->fetch('manager/form_package_search.tpl'),
		//$this->AssignCustomers();
		Base::$tpl->assign('aGroupsG',$aGroupsG);
		$aData=array(
		'sHeader'=>"method=get",
		//'sTitle'=>"Order Items",
		'sContent'=>Base::$tpl->fetch('manager/form_package_search.tpl'),
		'sSubmitButton'=>'Search',
		'sSubmitAction'=>'manager_package_list',
		'sReturnButton'=>'Clear',
		'bIsPost'=>0,
		'sWidth'=>'90%',
		//'sError'=>$sError,
		);
		$oForm=new Form($aData);

		$oForm->sReturn=Base::RemoveMessageFromUrl($_SERVER ['QUERY_STRING']);
		//$oForm->sAdditionalButtonTemplate=$this->sPrefix.'/button_form_package_search.tpl';

		Base::$sText.=$oForm->getForm();


		// --- search ---
		if (Base::$aRequest['search']['is_viewed']) $sWhere.=" and cp.is_viewed ='0'";
		if (Base::$aRequest['search']['id']) $sWhere.=" and cp.id  in (".Base::$aRequest['search']['id'].")";
		//if (Base::$aRequest['search_id_user']) $sWhere.=" and cp.id_user ='".Base::$aRequest['search_id_user']."'";
		if (Base::$aRequest['search_login']) { 
			$sWhere.=" and (u.login like '%".Base::$aRequest['search_login']."%'";
			$sWhere.=" || uc.name like '%".Base::$aRequest['search_login']."%'";
			$sWhere.=" || uc.phone like '%".Base::$aRequest['search_login']."%')";
		}
		if (Base::$aRequest['search_zip']) $sWhere.=" and uc.zip ='".Base::$aRequest['search_zip']."'";
		if (Base::$aRequest['search_order_status']) $sWhere.=" and cp.order_status ='".Base::$aRequest['search_order_status']."'";
		if (Base::$aRequest['search_code'] || Base::$aRequest['search']['pref']) {
			Base::$aRequest['search_code']=str_replace('-','',trim(Base::$aRequest['search_code']));
			$sJoin.=" inner join cart cart  on cp.id=cart.id_cart_package ";
			if (Base::$aRequest['search_code']) $sWhere.=" and  cart.code='".Base::$aRequest['search_code']."'";
			if (Base::$aRequest['search']['pref']) $sWhere.=" and  cart.pref='".Base::$aRequest['search']['pref']."'";
		}

		if (Base::$aRequest['id_autor'] ) {
			$sJoin.=" inner join cart cart  on cp.id=cart.id_cart_package ";
			if (Base::$aRequest['id_autor']) $sWhere.=" and  cp.name_manager='".Base::$aRequest['id_autor']."'";
		}
		if (Base::$aRequest['search_list_cust'] ) {
			$aListIdM=Db::GetAssoc("select id, id_user from ec_list_of_users_d as lud 
				where id_list_of_users_h=".Base::$aRequest['search_list_cust']);
				$aListId=implode(",", $aListIdM);
			if (Base::$aRequest['search_list_cust']) $sWhere.=" and uc.id_user in (".$aListId.")";
		}
	
		if (Base::$aRequest['status_liq']) $sWhere.=" and  cp.is_payed='".Base::$aRequest['status_liq']."'";
		
		/*if (Base::$aRequest['search']['id_list'] ) {
			$sJoin.=" inner join ec_list_of_users_d lud on lud.id_user=cp.id_user ";
			if (Base::$aRequest['search']['id_list']) $sWhere.=" and  lud.id_list_of_users_h='".Base::$aRequest['search']['id_list']."'";
		}*/

		if (Base::$aRequest['group_id']) $sWhere.=" and (uc.id_customer_group ='".Base::$aRequest['group_id']."' or '".Base::$aRequest['group_id']."'='0')";
		// --------------

		$oTable=new Table();
		$oTable->sSql=Base::GetSql('CartPackage',array(
		'where'=>" and cp.is_archive='0' and cp.id_user in (".$this->sCustomerSql.")  and uc.id_region ='".$this->iIdRegion."'".$sWhere,
		'join'=>$sJoin,
		));

		$oTable->aOrdered="order by cp.post_date desc";
		$oTable->aColumn=array(
		'id'=>array('sTitle'=>'№',"sWidth"=>"1%"),
		'post'=>array('sTitle'=>'Customer/Date_delivery/Addres',"sWidth"=>"80%"),
		'id_autor'=>array('sTitle'=>'Autor/Date', "sWidth"=>"5%"),
		'part'=>array('sTitle'=>'Group',"sWidth"=>"4%"),
		'order_status'=>array('sTitle'=>'Status', "sWidth"=>"5%"),
		'status_liq'=>array('sTitle'=>'status_liq', "sWidth"=>"5%"),
		//'price'=>array('sTitle'=>'Price',"sWidth"=>"5%"),
		'price_total'=>array('sTitle'=>'Total',"sWidth"=>"5%"),
		//'name_manager'=>array('sTitle'=>'NameManager'),
		//'action'=>array(),
		);
		$oTable->sDataTemplate='manager/row_package.tpl';
		$oTable->sButtonTemplate='manager/button_package.tpl';
		$oTable->bCheckVisible=true;
		$oTable->iRowPerPage=50;
		$oTable->sClass="datatable";
		$oTable->aCallback=array($this,'CallParsePackage');
		
		$aGroupsG=Db::GetAssoc("select id,name from customer_group where visible=1");
		Base::$tpl->assign('aGroupsG',$aGroupsG);

		$sOblasRegion=Db::GetOne("select name from ec_region where id='".$this->iIdRegion."'");
		$sCustomerGroup=Db::GetOne("select cg.name from customer_group cg inner join user_manager uc on uc.id_customer_group=cg.id where uc.id_user='".Auth::$aUser['id']."'");

		Base::$tpl->assign('sRegion',$sOblasRegion);
		Base::$tpl->assign('sCustomerGroup',$sCustomerGroup);
		
	    $aAutors=Db::GetAssoc("select 0 as id, 'All' as id_autor,'' as login,'' as name
			union all
			select u.id,u.login as id_autor,u.login as login,cu.name as name 
            from user u
            inner join  user_customer cu on cu.id_user=u.id
            inner join cart_package cp on cp.name_manager=u.login
			");
		Base::$tpl->assign('aAutors',$aAutors);

		Base::$sText.= $oTable->getTable("Cart Packages",'cart_package_table');
	}

	
	//-----------------------------------------------------------------------------------------------
	public function UpdateNumberFact()
	{
		if (Base::$aRequest['price_fact'] > 0 || Base::$aRequest['count_fact'] > 0){


		if (Base::$aRequest['price_fact']) {			
			Db::Execute("update cart set price_fact=".Base::$aRequest['price_fact']."
			 where id=".Base::$aRequest['id']);
		}
		if (Base::$aRequest['count_fact']){
			Db::Execute("update cart set count_fact=".Base::$aRequest['count_fact']."
			 where id=".Base::$aRequest['id']);
		}


			$aCart=Db::GetRow("select * from cart where id='".Base::$aRequest['id']."'");

		if ($aCart['price_fact'] && $aCart['count_fact']){
			Db::Execute("update cart set summa_fact = ".$aCart['price_fact']." * ".$aCart['count_fact']."
			 where id=".Base::$aRequest['id']);
		}
			
			//Debug::PrintPre($aCart);
			if ($aCart) {
				Base::$oResponse->addAssign('cart_total_fact_'.Base::$aRequest['id'],'innerHTML'
				,Base::$oCurrency->PrintPrice($aCart['count_fact']*$aCart['price_fact']) );

				//$dSubTotal=Base::$db->getOne("select sum(count_fact*price_fact) from (".$_SESSION['cart']['table_sql'].") sc ");
				
				$sCartListId=Db::GetOne("select id_cart_package from cart where id=".Base::$aRequest['id']."");
				$aCartList=Db::GetAll("select * from cart where id_cart_package=".$sCartListId."");
				$sPriceDelivery=Db::GetOne("select price_delivery from cart_package where id=".$sCartListId."");
				//Debug::PrintPre($sPriceDelivery);
				if ($aCartList) foreach ($aCartList as $aValue) {
					$dSubTotal+=$aValue['count_fact']*$aValue['price_fact'];
					
				}
				$sBonus=Db::GetOne("select bonus from cart_package where id=".Base::$aRequest['id']."");

				Base::$oResponse->addAssign('cart_subtotal_fact','innerHTML',Base::$oCurrency->PrintPrice($dSubTotal + 
					$sPriceDelivery - $sBonus));
				//Base::$oResponse->addAssign('cart_subtotal_fact2','innerHTML',Base::$oCurrency->PrintPrice($dSubTotal));
				//Base::$oResponse->addAssign('cart_subtotal','innerHTML',Base::$oCurrency->PrintPrice($dSubTotal));
				//Base::$oResponse->addAssign('cart_total_fact'.Base::$aRequest['id'],'innerHTML',$dSubTotalWeight);
			}

		}
		elseif (Base::$aRequest['price_fact'] < 0 || Base::$aRequest['count_fact'] < 0) {
			Base::$oResponse->addAlert(Base::$language->getMessage('Error: not valid number.'));
		}
		
	}
	//-----------------------------------------------------------------------------------------------
	public function CopyFact(){
		
		
		Db::Execute("update cart set price_fact = price,
									count_fact = number,
									summa_fact = price * number
		where id_cart_package=".Base::$aRequest['id']."");
		Base::Redirect('?action=manager_package_edit&id='.Base::$aRequest[id].'&return=action%3Dmanager_package_list');

	}
	//-----------------------------------------------------------------------------------------------
	public function SendLiqPay(){
		$aCartPackage=Db::GetRow(Base::GetSql('CartPackage',array('id'=>Base::$aRequest['id'],)));
			$aCart=Db::GetAll("select * from cart where id_cart_package='".Base::$aRequest['id']."'");
					if (Base::GetConstant("manager:enable_order_notification_on_email","1")) {
					$aCustomer=Db::GetRow( Base::GetSql('Customer',array('id'=>$aCartPackage['id_user'])) );
					
					foreach ($aCart as $iKey => $aValue) {
						$dPriceTotal+=Currency::PrintPrice($aValue['price'],null,2,"<none>")*$aValue['number'];
						$aCart[$iKey]['print_price'] = Currency::PrintPrice($aValue['price'],null,2,"<none>");
					}

					include_once(SERVER_PATH.'/class/module/LiqPay.php'); 
	  												
					$liqpay = new LiqPay('i54276112930', "R15mltUEp2UkL7pPI3FebTV10V0nsZ7w3DPoehz9");
					
					$aCartPackage['html'] = $liqpay->cnb_form(array(
			            'action'         => 'pay',
			            'amount'         => $aCartPackage['summa_fact'],
			            'currency'       => 'UAH',
			            'description'    => 'Замовлення: #'.$aCartPackage['id'],
			            'order_id'       => $aCartPackage['id'],
			            'version'        => '3'
			            ));
					//Debug::PrintPre($aCartPackage);
					//$aCartPackage=Db::GetRow(Base::GetSql('CartPackage',array('id'=>$aTotalSum['id'])));
					$aSmartyTemplate=String::GetSmartyTemplate('cart_package_details', array(
							'aCartPackage'=>$aCartPackage,
							'aCart'=>$aCart,
							'aCustomer'=>$aCustomer,
					));
					
					// to user
					if(Base::GetConstant('sms:send_or_not','1')){
						require_once SERVER_PATH.'/class/module/Sms.php';
						if ($aCartPackage['id_delivery_type'] != 6){
							$sDostavkaTime = $aCartPackage['date_delivery'].' '.$aCartPackage['time_delivery'];
						}else{
							$sDostavkaTime = ' коли замовлення буде доставлено на склад Нової Пошти, Вам прийде повідомлення';
						}
						$sTextSms='Ваше замовлення № '.$aCartPackage['id'].', прийнято, сума '.$aCartPackage['summa_fact'].' грн, очікуйте доставку ('.$sDostavkaTime.') Дякуємо за покупку!';
						Sms::AddDelayed($aCustomer['phone'],$sTextSms);
						Sms::SendDelayed();
					}
						
					//
					Mail::AddDelayed($aCustomer['email'],$aSmartyTemplate['name']." ".$aCartPackage['id'],
					$aSmartyTemplate['parsed_text'],'',"info",false);
					// to managers
					Mail::AddDelayed(Base::GetConstant('manager:email_recievers','info@moregoods.com.ua')
					,$aSmartyTemplate['name']." ".$aCartPackage['id'],
					$aSmartyTemplate['parsed_text'],'',"info",false);
				}
				Db::Execute("update cart_package set order_status='work' where id=".Base::$aRequest['id']."");
				
				Base::Redirect('?action=manager_package_list');
	}
	//-----------------------------------------------------------------------------------------------		
	public function CallParseCart(&$aItem)
	{
		if ($aItem) foreach($aItem as $key => $value) {
			/*$aItem[$key]['name']="<b>".$value['name'].
			"</b><br>".String::FirstNwords($value['customer_comment'],5);*/
//			$aItem[$key]['total']=$value['number'] * Currency::PrintPrice($value['price'],null,2,'<none>');
			$aItem[$key]['image'] = Db::GetOne("select image from ec_products where id ='". $aItem[$key]['id_product'] ."'");		//29.12.201
/*			$aItem[$key]['cart_history']=Db::GetAll(
			Base::GetSql('CartHistory',array(
			'code'=>$value['code'],
			'make'=>$value['make'],
			'id_provider'=>$value['id_provider'],
			'order'=>' order by post DESC',
			'limit'=>' limit 0,3',
			)));

			if (!$aItem[$key]['is_archive']) {
				$dSubtotal+=$value['number'] * Currency::PrintPrice($value['price'],null,2,'<none>');
				$dSubtotalWeight+=$value['number']*$value['weight'];
			}
*/			
		}

		return array('dSubtotal'=>$dSubtotal,'dSubtotalWeight'=>$dSubtotalWeight);
	}
	//-----------------------------------------------------------------------------------------------
	public function CallParsePackage(&$aItem) {
		
		if ($aItem) {
			foreach($aItem as $sKey => $aValue) {
				$aCart=Db::GetAll(Base::GetSql("Part/Search",array("id_cart_package"=>$aValue["id"])));

				if ($aCart) foreach ($aCart as $sKeyItem=> $aCartItem) {
					if ($aCartItem['order_status']=='reclamation') $aItem[$sKey]['is_reclamation']=1;
					$aCart[$sKeyItem]['history']=Db::GetAssoc("select cl.* from cart_log as cl	where id_cart = ".$aCartItem["id"]);
				}
				$aItem[$sKey]['aCart']=$aCart;

				$aFile=Db::GetAll(Base::GetSql("FileAttachment",array(
				"table_name"=>"cart_package",
				"table_id"=>$aValue['id'],
				)));
				if ($aFile) {
					$aItem[$sKey]['file']=$aFile;
				}
				//$aItem[$key]['post_date']=DateFormat::getDateTime($value['post']);
				//$aItem[$key]['customer_comment']=String::FirstNwords($value['customer_comment'],10);
				//$aItem[$key]['price_total']=Currency::PrintPrice($value['price_total'],Auth::$aUser['code_currency']);
				$aItem[$sKey]['sAutoInfo'] = OwnAuto::GetAutoInfoTip($aValue['id']);

				$liqpay = new LiqPay('i54276112930', "R15mltUEp2UkL7pPI3FebTV10V0nsZ7w3DPoehz9");
					$res = $liqpay->api("request", array(
					'action'        => 'status',
					'version'       => '3',
					'order_id'      => $aItem[$sKey]['id']
				));
					$res=json_encode($res);	
					$res=json_decode($res, true);
					$aItem[$sKey]['status_liq']=$res['status'];
					$aItem[$sKey]['id_user']=Db::GetOne("select cp.id_user 
						from cart_package as cp where cp.id='".$aItem[$sKey]['id']."' ");
					$aItem[$sKey]['price']=$res['amount'];
					$aItem[$sKey]['receiver_commission']=$res['receiver_commission'];
					$aItem[$sKey]['end_date'] = date('Y-m-d H:i:s', $res['end_date']/1000);
				
				$aExistCartP = Db::GetAll("select pr.id_cart_package from payment_report as pr");

				foreach ($aExistCartP as $key => $value) {
					$aExistCartP[$key] = $value[id_cart_package];
				} 
					if ($aItem[$sKey]['status_liq']=='success'){
						Db::Execute("update cart_package as cp set cp.is_payed='1' where cp.id=".$aItem[$sKey]['id']."");

						if (in_array($aItem[$sKey]['id'], $aExistCartP) === false){
							Db::Execute("insert into payment_report (id_user, payment_date, method, price, 
								id_cart_package, comis)
							values ('".$aItem[$sKey]['id_user']."', '".$aItem[$sKey]['end_date']."',
								'LiqPay', '".$aItem[$sKey]['price']."', '".$aItem[$sKey]['id']."',
								'".$aItem[$sKey]['receiver_commission']."')");
						}
					}
			}
			Base::$tpl->assign('sHeader',Language::GetMessage("Cart Packages"));
		}

		Base::$tpl->assign('sClass',"datatable");
		Base::$tpl->assign('sWidth',"100%");
	}
	//-----------------------------------------------------------------------------------------------
	public function DeletePackageEmpty() {
		if (Base::$aRequest['id'])
		{
			$aCartPackage=Db::GetRow("select * from cart_package where id=".Base::$aRequest['id']);
			//if (Db::GetAll("select * from cart where id_cart_package=".Base::$aRequest['id'])) {

			if ($aCartPackage['order_status']=="new" || $aCartPackage['order_status']=="pending"			//30.12.2016
			|| ($aCartPackage['order_status']=="work" && $aCartPackage['is_payed']==0))
			{
				Db::Execute("update user_account as ua
				inner join user_account_log as ual on ua.id_user=ual.id_user and section='cart_package'
				and custom_id=".Base::$aRequest['id']." set ua.amount=ua.amount-ual.amount");

				Db::Execute("delete from cart_package where id=".Base::$aRequest['id']);
				Db::Execute("delete from cart where id_cart_package=".Base::$aRequest['id']);

				Db::Execute("delete from user_account_log
				where section='cart_package' and custom_id=".Base::$aRequest['id'] );

				$sMessage="&aMessage[MT_NOTICE]=Package deleted";
			} else {
				$sMessage="&aMessage[MT_ERROR]=Package is not new or payed";
			}

		} else $sMessage="&aMessage[MT_ERROR]=Check Package";

		Form::RedirectAuto($sMessage);
	}
	//-----------------------------------------------------------------------------------------------
	//	public function PackageArchive($sType='cart') {
	//		if (Base::$aRequest['row_check']) {
	//			$sQuery="update cart_package set
	//					is_archive='1'
	//				where id in (".implode(',',Base::$aRequest['row_check']).")
	//					".Auth::$sWhere;
	//			Base::$db->Execute($sQuery);
	//		}
	//		$this->PackageList();
	//	}
	//-----------------------------------------------------------------------------------------------
	public function ExportAll()
	{
		$this->sExportSql=$_SESSION['order']['current_sql'];
		$this->Export('sql');
	}
	//-----------------------------------------------------------------------------------------------
	public function Export($sType='row_check')
	{
		if ($sType=='row_check' &&Base::$aRequest['row_check']) {
			$sSql=Base::GetSql("Part/Search",array(
			"where"=>"and c.id_user in (".$this->sCustomerSql.")
					and c.id in (".implode(',',Base::$aRequest['row_check']).")"));
		}

		if ($sType=='sql') {
			$sSql=$this->sExportSql;
		}

		$aCart=Base::$db->getAll($sSql);
		if ($aCart) {
			$oExcel = new Excel();
			$aHeader=array(
			'A'=>array("value"=>'date'),
			'B'=>array("value"=>'id_detal', "autosize"=>true),
			'C'=>array("value"=>'id_package', "autosize"=>true),
			'D'=>array("value"=>'Make', "autosize"=>true),
			'E'=>array("value"=>'Code', "autosize"=>true),
			'F'=>array("value"=>'Customer', "autosize"=>true),
			'G'=>array("value"=>'Name_Russian'),
			'H'=>array("value"=>'Name'),
			'I'=>array("value"=>'Order_status'),
			'J'=>array("value"=>'Number'),
			'K'=>array("value"=>'Price'),
			'L'=>array("value"=>'Total'),
			'M'=>array("value"=>'Provider'),
			'N'=>array("value"=>'Sign'),
			'O'=>array("value"=>'OriginalPrice'),
			'P'=>array("value"=>'OriginalTotal'),
			'Q'=>array("value"=>'address'),
			);
			if (Auth::$aUser['is_super_manager'] || Auth::$aUser['is_sub_manager']){
				$aHeader['R']=array("value"=>Language::getMessage('XLS_Diff'));
				$aHeader['S']=array("value"=>Language::getMessage('XLS_Invoice'));
				$aHeader['T']=array("value"=>Language::getMessage('XLS_Order'));
				$aHeader['U']=array("value"=>Language::getMessage('XLS_Provider_price'));
			}
			$oExcel->SetHeaderValue($aHeader,1);
			$oExcel->SetAutoSize($aHeader);
			$oExcel->DuplicateStyleArray("A1:U1");

			$i=$j=2;
			foreach ($aCart as $aValue)
			{
				$sMake=substr($aValue['item_code'],0,2);
				if (strlen($aValue['cat_name'])==2) $sMake=$aValue['cat_name'];
				$sMake=str_ireplace('LX','LS',$sMake);
				$sMake=str_ireplace('HY','HU',$sMake);

				$oExcel->setCellValue('A'.$i, $aValue['post_date']);
				$oExcel->setCellValue('B'.$i, $aValue['id']);
				$oExcel->setCellValue('C'.$i, $aValue['id_cart_package']);
				$oExcel->setCellValue('D'.$i, $sMake);
				$oExcel->setCellValue('E'.$i, " ".$aValue['code']);
				$oExcel->setCellValue('F'.$i, $aValue['code_customer_group'].' '.$aValue['id'].' '.$aValue['login']);
				$oExcel->setCellValue('G'.$i, strip_tags($aValue['name_translate']));
				$oExcel->setCellValue('H'.$i, strip_tags($aValue['name']));
				$oExcel->setCellValue('I'.$i, $aValue['order_status'] .' '.$aValue['sign'] );
				$oExcel->setCellValue('J'.$i, $aValue['number']);
				$oExcel->setCellValue('K'.$i, $aValue['price']);
				$oExcel->setCellValue('L'.$i, $aValue['number']*$aValue['price']);

				if (Auth::$aUser['is_super_manager'] || Auth::$aUser['is_sub_manager'])
				$oExcel->setCellValue('M'.$i, $aValue['provider_name']);
				else $oExcel->setCellValue('M'.$i, '');

				$dPriceOriginal=($aValue['provider_price']>0 ? $aValue['provider_price'] : $aValue['price_original']);

				$oExcel->setCellValue('N'.$i, $aValue['sign']);
				$oExcel->setCellValue('O'.$i, $aValue['price_original']);
				$oExcel->setCellValue('P'.$i, $aValue['number']*$aValue['price_original']);
				$oExcel->setCellValue('Q'.$i, $aValue['country'].";".$aValue['city']."; ".$aValue['address']);

				if (Auth::$aUser['is_super_manager'] || Auth::$aUser['is_sub_manager']){
					$oExcel->setCellValue('R'.$i, $aValue['number']*($aValue['price']-$dPriceOriginal));
					$oExcel->setCellValue('S'.$i, $aValue['id_provider_invoice']);
					$oExcel->setCellValue('T'.$i, $aValue['id_provider_order']);
					$oExcel->setCellValue('U'.$i, $aValue['provider_price']);
				}

				$i++;
			}

			//new sheet
			$oExcel->CreateSheet();
			$oExcel->SetActiveSheetIndex(1);
			$oExcel->SetTitle(Language::GetMessage("Order to the provider"));
			$aHeader=array(
			'A'=>array("value"=>'Marka', "autosize"=>true),
			'B'=>array("value"=>'Code', "autosize"=>true),
			'C'=>array("value"=>'Name', "autosize"=>true),
			'D'=>array("value"=>'Number', "autosize"=>true),
			'E'=>array("value"=>'Price', "autosize"=>true),
			'F'=>array("value"=>'Total', "autosize"=>true),
			);
			$oExcel->SetHeaderValue($aHeader,1);
			$oExcel->SetAutoSize($aHeader);
			$oExcel->DuplicateStyleArray("A1:F1");
			$i=$j=2;
			foreach ($aCart as $aValue)
			{
				/*$sMake=substr($aValue['item_code'],0,2);
				if (strlen($aValue['cat_name'])==2) $sMake=$aValue['cat_name'];
				$sMake=str_ireplace('LX','LS',$sMake);
				$sMake=str_ireplace('HY','HU',$sMake);*/

				$oExcel->setCellValue('A'.$i, $aValue['cat_name']);
				//$oExcel->setCellValue('A'.$i, $sMake);
				$oExcel->setCellValue('B'.$i, " ".$aValue['code']);
				if ($aValue['name']<>" ") $oExcel->setCellValue('C'.$i, strip_tags($aValue['name']));
				else $oExcel->setCellValue('C'.$i, strip_tags($aValue['name_translate']));
				$oExcel->setCellValue('D'.$i, $aValue['number']);
				$oExcel->setCellValue('E'.$i, $aValue['price_original']);
				$oExcel->setCellValue('F'.$i, $aValue['number']*$aValue['price_original']);

				$i++;
			}
			//end new sheet
			$sFileName=uniqid().'.xls';
			$oExcel->WriterExcel5(SERVER_PATH.'/imgbank/temp_upload/'.$sFileName, true);
		}
		else $sFileName='EmptyData.xls';

		Base::$tpl->assign('sFileName',$sFileName);
		Base::$sText.=Base::$tpl->fetch('manager/export.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	//	public function ExportMegaAll() {
	//		$this->sExportMegaSql=$_SESSION['order']['current_sql'];
	//		$this->ExportMega('sql');
	//	}
	//-----------------------------------------------------------------------------------------------
	//	public function ExportMega($sType='row_check') {
	//		//error_reporting(E_ALL ^ E_NOTICE);
	//		if ($sType=='row_check' &&Base::$aRequest['row_check']) {
	//			$sSql="select u.*, uc.name as customer_name, c.*
	//				 from cart c
	//				 inner join user u on c.id_user=u.id
	//				 inner join user_customer uc on uc.id_user=u.id
	//				where 1=1 and c.type_='order'
	//					and c.id_user in (".$this->sCustomerSql.")
	//					and c.id in (".implode(',',Base::$aRequest['row_check']).")
	//					";
	//		} elseif ($sType=='sql') {
	//			$sSql=$this->sExportMegaSql;
	//		}
	//
	//		//Base::$sText.=$sSql."<br>";
	//		$aCart=Base::$db->getAll($sSql);
	//		if ($aCart) {
	//			require_once(SERVER_PATH.'/class/module/Catalog.php');
	//			foreach ($aCart as $aValue) {
	//				$aPartItem=array();
	//				$aPartItem['Confirm']='1';
	//				$aPartItem['MakeLogo']=$this->GetCartMake($aValue);
	//				$aPartItem['DetailNum']=Catalog::StripCode($aValue['code']);
	//				$aPartItem['Destinationlogo']='EMEW';
	//				$aPartItem['PriceId']='103';
	//				$aPartItem['Quantity']=$aValue['number'];
	//				if (stripos($aValue['sign'],'ONLY')!==false) $aPartItem['bitOnly']=1;
	//				else $aPartItem['bitOnly']=0;
	//				if (stripos($aValue['sign'],'QUAN')!==false) $aPartItem['bitQuantity']=1;
	//				else $aPartItem['bitQuantity']=0;
	//				if (stripos($aValue['sign'],'WAIT')!==false) $aPartItem['bitWait']=1;
	//				else $aPartItem['bitWait']=0;
	//				if (stripos($aValue['sign'],'AGRE')!==false) $aPartItem['bitAgree']=1;
	//				else $aPartItem['bitAgree']=0;
	//				if (stripos($aValue['sign'],'BRAND')!==false) $aPartItem['OnlyThisBrand']=1;
	//				else $aPartItem['OnlyThisBrand']=0;
	//				$aPartItem['Reference']=$aValue['login'];
	//				$aPartItem['CustomerSubId']=$aValue['id'];
	//				$aPart[]=$aPartItem;
	//			}
	//			//Base::$sText.=print_r($aPart,true)."<br>";
	//			require_once(SERVER_PATH.'/class/module/ManagerService.php');
	//			$oManagerService=new ManagerService();
	//			$oManagerService->SendToCartAll($aPart);
	//
	//			Base::$sText.=Language::getText('Items are sent to Mega Cart. Please login there and send the order.');
	//		}
	//		else {
	//			Base::$sText.=Language::getText('No items selected.');
	//		}
	//		Base::$sText.=Base::$tpl->fetch('manager/button_mega_return.tpl');
	//	}
	//-----------------------------------------------------------------------------------------------
	public function GetCartMake($aCart)
	{
		//		if ($aCart['login_vin_request']) {
		//			return $aCart['cat_name'];
		//		}
		//		else {
		return substr($aCart['item_code'],0,strpos($aCart['item_code'],'_'));
		//		}
	}
	//-----------------------------------------------------------------------------------------------
	public function ImportStatus()
	{
		if (Base::$aRequest['is_post']) {
			if (is_uploaded_file($_FILES['import_file']['tmp_name'])) {

				require_once(SERVER_PATH.'/lib/excel/reader.php');
				$oReader = new Spreadsheet_Excel_Reader();
				$oReader->setOutputEncoding('CP1251');
				$oReader->read($_FILES['import_file']['tmp_name']);

				$aResult=$oReader->sheets[0]['cells'];
				if ($aResult) foreach ($aResult as $key=>$value) {

					$value['id']=trim($value[1]);
					$iSpace=stripos($value['id'],' ');
					if ($iSpace) $value['id']=substr($value['id'],0,$iSpace);
					$value['id']=preg_replace('/[^0-9]/', '',$value[id]);

					$value['order_status']=$value[2];
					$value['id_provider_order']=$value[4];
					$value['provider_price']=$value[5];
					$value['id_provider_invoice']=$value[6];
					$value['custom_value']=$value[7];
					if ($value[id] && $value[order_status]) {
						$value['comment']=$value[3];
						$value['message']=$this->ProcessOrderStatus($value['id'],$value['order_status'],$value['comment']
						,$value['id_provider_order'],$value['provider_price'],$value['id_provider_invoice'],$value['custom_value']);
						$value['old_order_status']=$this->sCurrentOrderStatus;
						$aProcessed[]=$value;
					}
				}
				Base::$tpl->assign('aProcessed',$aProcessed);
			}
			else Base::Redirect('/?action=manager_import_status');
		}

		$aData=array(
		'sHeader'=>"method=post enctype='multipart/form-data'",
		'sTitle'=>"Import Cart Statuses",
		'sContent'=>Base::$tpl->fetch('manager/form_import_status.tpl'),
		'sSubmitButton'=>'Upload',
		'sSubmitAction'=>'manager_import_status',
		'sReturnButton'=>'Return',
		'sReturnAction'=>'manager_order',
		'bIsPost'=>0,
		'sError'=>$sError,
		);
		$oForm=new Form($aData);

		Base::$sText.=$oForm->getForm();

		if ($aProcessed) Base::$sText.=Base::$tpl->fetch('manager/processed_import.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	public function EditWeight () {
		Auth::NeedAuth('manager');
		Base::$tpl->assign("aPref",array(""=>"")+Db::GetAssoc("Assoc/Pref"));

		/* [ apply  */
		if (Base::$aRequest['is_post'])
		{
			$aData=String::FilterRequestData(Base::$aRequest['data']);
			if (Base::$aRequest['item_code']) {
				list($aData['pref'],$aData['code'])=explode('_',$aData['item_code']);
				$aData['comment']='edit manager';

				if (isset($aData['item_code']) && trim($aData['item_code'])!="") {
					Manager::AddWeightName($aData);
				}
				$sMessage="&aMessage[MT_NOTICE]=changed";
			}
			Form::RedirectAuto($sMessage);

		}
		/* ] apply */

		if (Base::$aRequest['action']==$this->sPrefix.'_add_weight' || Base::$aRequest['action']==$this->sPrefix.'_edit_weight')
		{
			if (Base::$aRequest['action']==$this->sPrefix.'_edit_weight')
			{
				Base::$tpl->assign('aData',Base::$db->getRow(Base::GetSql("CatPart",array(
				"item_code"=>Base::$aRequest['item_code']
				))));
			}

			$aData=array(
			'sHeader'=>"method=post",
			'sTitle'=>"Edit weight, name",
			'sContent'=>Base::$tpl->fetch($this->sPrefix.'/form_weight.tpl'),
			'sSubmitButton'=>'Apply',
			'sSubmitAction'=>$this->sPrefix."_edit_weight",
			'sReturnButton'=>'<< Return',
			'bAutoReturn'=>true,
			'sWidth'=>"500px",
			);
			$oForm=new Form($aData);
			Base::$sText.=$oForm->getForm();

			return;
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function ImportWeight()
	{
		if (Auth::$aUser['id_manager_partner'] || Auth::$aUser['id_customer_partner']) Base::Redirect('/?action=auth_type_error');

		//Base::$aTopPageTemplate=array('panel/tab_manager_price.tpl'=>'import_weight');

		if (Base::$aRequest['is_post'] && is_uploaded_file($_FILES['import_file']['tmp_name'])) {
			set_time_limit(0);

			$oExcel= new Excel();
			$oExcel->ReadExcel5($_FILES['import_file']['tmp_name'],true);
			$oExcel->SetActiveSheetIndex();
			$oExcel->GetActiveSheet();

			$aResult=$oExcel->GetSpreadsheetData();

			if ($aResult) {
				$aPref=Base::$db->getAssoc("select cp.name,c.pref from cat_pref cp inner join cat c on c.id=cp.cat_id");
				$aPrefName=Base::$db->getAssoc("select id,name from cat_pref");

				foreach ($aResult as $key=>$value) {
					unset($u);

					$u['pref']=strtoupper($value[1]);
					if (in_array($u['pref'],$aPrefName)) {
						$u['pref']=$aPref[$u['pref']];
						$u['code']=Catalog::StripCode($value[2]);
						$u['item_code']=$u['pref']."_".$u['code'];
						$u['name_rus']=trim($value[3]);
						$u['weight']=str_replace(",",".",$value[4]);
						$u['comment']='excel_import';
					}

					if (isset($u['item_code']) && trim($u['item_code'])!="") {
						Manager::AddWeightName($u);
						$aProcessed[]=$u;
					}

				}
			}

			if (count($aProcessed)<10000) Base::$tpl->assign('aProcessed',$aProcessed);
			else Base::$tpl->assign('aProcessed',array(0=>Language::GetMessage("Data load OK")));

		}

		$aData=array(
		'sHeader'=>"method=post enctype='multipart/form-data'",
		'sTitle'=>"Import Weight and Name",
		'sContent'=>Base::$tpl->fetch('manager/form_import_weight.tpl'),
		'sSubmitButton'=>'Upload/Search',
		'sSubmitAction'=>'manager_import_weight',
		'sReturnButton'=>'Return',
		'sReturnAction'=>'manager_import_weight',
		'bIsPost'=>0,
		'sWidth'=>'650px',
		'sError'=>$sError,
		);
		$oForm=new Form($aData);

		Base::$sText.=$oForm->getForm();

		if ($aProcessed) Base::$sText.=Base::$tpl->fetch('manager/processed_weight.tpl');
		else {
			// --- search ---
			if (Base::$aRequest['search']['comment']) $sWhere.=" and cpw.comment like '%".Base::$aRequest['search']['comment']."%'";
			// --------------

			$oTable=new Table();
			$oTable->iRowPerPage=50;
			$oTable->sSql=Base::GetSql("CatPart",array(
			'code'=>Base::$aRequest['search']['code'],
			'weight_log'=>1,
			'where'=>$sWhere,
			));

			$oTable->aOrdered="order by cpw.id desc";
			$oTable->aColumn=array(
			'item_code'=>array('sTitle'=>'Item_code'),
			'weight'=>array('sTitle'=>'Weight'),
			'name_rus'=>array('sTitle'=>'Name rus'),
			'login'=>array('sTitle'=>'Login'),
			'post_date'=>array('sTitle'=>'Date'),
			'comment'=>array('sTitle'=>'Comment'),
			);
			$oTable->sDataTemplate='manager/row_cat_part_weight.tpl';
			//$oTable->sButtonTemplate='manager/button_finance.tpl';
			//$oTable->sSubtotalTemplate='manager/subtotal_finance.tpl';
			//$oTable->aCallback=array($this,'CallParseLog');

			Base::$sText.=$oTable->getTable();
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function AddWeightName($u)
	{
		Db::Execute("
		insert into cat_part (item_code, pref, code, name_rus,weight)
		values ('".$u['item_code']."','".$u['pref']."','".$u['code']."','"
		.mysql_escape_string($u['name_rus'])."','".$u['weight']."')
		on duplicate key update name_rus=if('".mysql_escape_string($u['name_rus'])."'='',name_rus, '"
		.mysql_escape_string($u['name_rus'])."')
		, weight=if('".$u['weight']."'='', weight, '".$u['weight']."')"
		);

		$id_cat_part=Db::GetOne("select id from cat_part where item_code='".$u['item_code']."'");

		if ($id_cat_part){
			$aCartPartWeight=array(
			'id_user'=>Auth::$aUser['id'],
			'id_cat_part'=>$id_cat_part,
			'weight'=>$u['weight'],
			'name_rus'=>$u['name_rus'],
			'comment'=>$u['comment'],
			);
			Db::AutoExecute('cat_part_weight',$aCartPartWeight);
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function AssignCustomers()
	{
		/* Commented unsed method */
		//		$sSql="select cg.*,u.*,uc.* from user u
		//					inner join user_customer uc on u.id=uc.id_user
		//					inner join customer_group cg on uc.id_customer_group=cg.id
		//					 where 1=1
		//					 	and u.id in (".$this->sCustomerSql.")";
		//		Base::$tpl->assign('aCustomer',Base::$db->getAll($sSql));
	}
	//-----------------------------------------------------------------------------------------------
	public function Finance()
	{
		Base::$aTopPageTemplate=array('panel/tab_manager.tpl'=>'finance');

		if (Base::$aRequest['is_post'])
		{
			if (!Base::$aRequest['data']['amount'] || !Base::$aRequest['data']['id_user']) {
				Form::ShowError("Please, fill the required fields");
				Base::$aRequest['action']='manager_finance_add';
				Base::$tpl->assign('aData',Base::$aRequest['data']);
			}
			else {

				$sDescription = (Base::$aRequest['data']['description'] ? Base::$aRequest['data']['description']:
				Language::GetMessage('manager money deposit')) ;

				Finance::Deposit(Base::$aRequest['data']['id_user'],
				Base::$aRequest['data']['amount'],
				$sDescription,
				Base::$aRequest['data']['custom_id'],
				Base::$aRequest['data']['pay_type'],
				'internal',
				''
				,Base::$aRequest['data']['id_user_account_log_type']);

				//Buh::EntrySingle(array(),311,361,Base::$aRequest['data']['amount'],$sDescription
				//,);
				$this->PayCartPackage(Base::$aRequest['data']['custom_id']);

				Form::RedirectAuto("&aMessage[MI_NOTICE]=payment added");
			}
		}

		if (Base::$aRequest['action']=='manager_finance_add') {

			Base::$tpl->assign('aUserAccountLogType',Base::$db->GetAssoc(Base::GetSql('Finance/UserAccountLogTypeAssoc',array(
			'where'=>" and ualt.id in (1,8)"
			))));
			Base::$tpl->assign('aPayTypeId', BaseTemp::EnumToArray("user_account_log","pay_type"));
			Base::$tpl->assign('aPayTypeValue', BaseTemp::EnumToArray("user_account_log","pay_type"));

			$aData=array(
			'sHeader'=>"method=post",
			'sTitle'=>"Finance add",
			'sContent'=>Base::$tpl->fetch('manager/form_finance.tpl'),
			'sSubmitButton'=>'Apply',
			'sSubmitAction'=>'manager_finance_add',
			'sError'=>$sError,
			);
			$oForm=new Form($aData);

			Base::$sText.=$oForm->getForm();
			return;
		}




		Base::$tpl->assign('aUserAccountLogType',Base::$db->GetAssoc(Base::GetSql('Finance/UserAccountLogTypeAssoc')));

		$aData=array(
		'sHeader'=>"method=get",
		'sContent'=>Base::$tpl->fetch('manager/form_finance_search.tpl'),
		'sSubmitButton'=>'Search',
		'sSubmitAction'=>'manager_finance',
		'sReturnButton'=>'Clear',
		'bIsPost'=>0,
		'sWidth'=>'700px',
		'sError'=>$sError,
		);
		$oForm=new Form($aData);

		Base::$sText.=$oForm->getForm();



		// --- search ---
		if (Base::$aRequest['search']['login']) $sWhere.=" and u.login ='".Base::$aRequest['search']['login']."'";

		if (Base::$aRequest['search']['date']) {
			$sWhere.=" and ual.post_date>='".DateFormat::FormatSearch(Base::$aRequest['search']['date_from'])."'
				and ual.post_date<'".DateFormat::FormatSearch(Base::$aRequest['search']['date_to'])."'";
		}
		if (Base::$aRequest['search']['description'])
		$sWhere.=" and ual.description like '%".Base::$aRequest['search']['description']."%'";

		if (Base::$aRequest['search']['id_user_account_log_type']) {
			$sWhere.=" and ual.id_user_account_log_type='".Base::$aRequest['search']['id_user_account_log_type']."'";
		}
		if (Base::$aRequest['search']['custom_id']) {
			$sWhere.=" and ual.custom_id='".Base::$aRequest['search']['custom_id']."'";
		}
		// --------------
		Finance::AssignSubtotal($sWhere);
		// --------------

		$oTable=new Table();
		$oTable->iRowPerPage=20;
		$oTable->sSql=Base::GetSql('UserAccountLog',array(
		'where'=>$sWhere,
		));

		//		$oTable->sSql="select u.*,uc.*, uc.name as customer_name, ual.*
		//						,ua.amount as current_account_amount
		//						, ualt.name as user_account_log_type_name
		//					from user_account_log as ual
		//					inner join user as u on ual.id_user=u.id
		//					inner join user_customer as uc on uc.id_user=u.id
		//					inner join user_account as ua on ua.id_user=u.id
		//					left join user_account_log_type as ualt on ual.id_user_account_log_type=ualt.id
		//					where 1=1
		//						and ual.id_user in (".$this->sCustomerSql.")
		//						".$sWhere;
		$_SESSION['finance']['current_sql']=$oTable->sSql;

		$oTable->aOrdered="order by ual.id desc";
		$oTable->aColumn=array(
		'login'=>array('sTitle'=>'Customer Login'),
		'account_amount'=>array('sTitle'=>'AccountAmount/DebtAmount'),
		'debet'=>array('sTitle'=>'finance debet'),
		'credit'=>array('sTitle'=>'finance credit'),
		'custom_id'=>array('sTitle'=>'Ual CustomId'),
		'post'=>array('sTitle'=>'Date'),
		'description'=>array('sTitle'=>'Description'),
		);
		$oTable->sDataTemplate='manager/row_finance.tpl';
		$oTable->sButtonTemplate='manager/button_finance.tpl';
		$oTable->sSubtotalTemplate='manager/subtotal_finance.tpl';
		$oTable->aCallback=array($this,'CallParseLog');

		$sTable=$oTable->getTable("Account Log",'customer_account_log');


		if (Base::$aRequest['search']['login'] || Base::$aRequest['search']['custom_id']) {
			if (Base::$aRequest['search']['custom_id']) {
				$aCartPackage=Db::GetRow(Base::GetSql('CartPackage',array('id'=>Base::$aRequest['search']['custom_id'])));

				$aCustomer=Db::GetRow(Db::GetSql('Customer',array(
				'id'=>($aCartPackage['id_user'] ? $aCartPackage['id_user']:'-1'),
				)));
			}
			elseif (Base::$aRequest['search']['login']) {
				$aCustomer=Db::GetRow(Db::GetSql('Customer',array('login'=>Base::$aRequest['search']['login'])));
			}

			if ($aCustomer) {
				Base::$tpl->assign('aCustomer',$aCustomer);
				Base::$tpl->assign('aCartPackage',$aCartPackage);
				$aData=array(
				'sContent'=>Base::$tpl->fetch('manager/form_finance_login.tpl'),
				'sWidth'=>'90%',
				);
				$oForm=new Form($aData);
				Base::$sText.=$oForm->getForm();
			}
		}

		/**
		 * Moved bottom from table for $sReturn generation
		 */
		Base::$sText.=$sTable;
	}
	//-----------------------------------------------------------------------------------------------
	public function CallParseLog(&$aItem)
	{
		$aCustomerDebt=Base::$db->GetAll(Base::GetSql('CustomerDebt'));
		$aCustomerDebtHash=Language::Array2Hash($aCustomerDebt,'id_user');
		//Base::$tpl->assign('aCustomerDebtHash',$aCustomerDebtHash);
		$aIdCustomer=array();
		if ($aItem) foreach($aItem as $key => $value) {
			$aItem[$key]['current_debt_amount']=$aCustomerDebtHash[$value['id_user']]['amount'];
			if (!in_array($value['id_user'],$aIdCustomer)) $aIdCustomer[]=$value['id_user'];

			if ($value['custom_id']>0) $aCustomId[]=$value['custom_id'];
		}

		$aCustomerManagerHash=Base::$db->GetAssoc(Base::GetSql('Customer/ManagerAssoc',array('id_user_array'=>$aIdCustomer)));
		if ($aCustomId) {
			$aDebtCartAssoc=Db::GetAssoc('Assoc/DebtCart',array('where'=>" and ld.is_payed='0'
				and custom_id in (".(implode(',',$aCustomId)).")"));
		}
		if ($aItem) foreach($aItem as $sKey => $aValue) {
			$aItem[$sKey]['manager_login']=$aCustomerManagerHash[$aValue['id_user']];
			$aItem[$sKey]['debt_cart_unpaid']=$aDebtCartAssoc[$aValue['custom_id']];
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function ReturnFullPaymentDiscount($aCart)
	{
		if ($aCart['full_payment_discount']>0) {
			Finance::Deposit($aCart['id_user'],-$aCart['full_payment_discount']
			,Language::getMessage('Return full payment discount for cart #').$aCart['id']
			,$aCart['id'],'internal','cart','',3);
			Base::$db->Execute("update cart set full_payment_discount='0' where id='{$aCart['id']}'");
			$aCart['full_payment_discount']=0;
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function FinanceExportAll()
	{
		$sFileName=Finance::CreateFinanceExcel($_SESSION['finance']['current_sql'].' order by ual.id desc',true);
		Base::$tpl->assign('sFileName',$sFileName);

		Base::$sText.=Base::$tpl->fetch('manager/export_finance.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	public function ParentMarginDebet($aCart)
	{
		/**
		 * Unused
		 */
		//		if ($aCart['is_parent_margin_debeted']) return;
		//		$aUser=Base::$db->getRow(Base::GetSql('Customer',array('id'=>$aCart['id_user'],)));
		//		if ($aUser['is_test'] || !$aUser['id_parent']) return;
		//
		//		$dDebetAmount=$aCart['price_parent_margin']*$aCart['number'];
		//		if ($dDebetAmount>0) {
		//			$iInsertedId=Finance::Deposit($aUser['id_parent'],$dDebetAmount
		//			,Language::getMessage('Parent margin debet cart #').$aCart['id'].' - '.$aUser['login']
		//			,$aCart['id'],'internal','cart','',10);
		//
		//			//			InvoiceAccountLog::Add($aUser['id_parent'],$iInsertedId,'user_account_log',$dDebetAmount);
		//		}
		//
		//		$dDebetAmountSecond=$aCart['price_parent_margin_second']*$aCart['number'];
		//		if ($dDebetAmountSecond>0) {
		//			$iInsertedId=Finance::Deposit($aUser['id_parent_second'],$dDebetAmountSecond
		//			,Language::getMessage('Parent margin debet cart #').$aCart['id'].' - '.$aUser['login']
		//			,$aCart['id'],'internal','cart','',10);
		//
		//			/*InvoiceAccountLog::Add($aUser['id_parent_second'],$iInsertedId,'user_account_log',$dDebetAmountSecond);*/
		//		}
		//
		//		Base::$db->Execute("update cart set is_parent_margin_debeted='1' where id='{$aCart['id']}'");
	}
	//-----------------------------------------------------------------------------------------------
	public function IsChangeableLogin($sLogin)
	{
		return Customer::IsChangeableLogin($sLogin);
	}
	//-----------------------------------------------------------------------------------------------
	public function CountMoney()
	{
		if (Base::$aRequest['is_post']) {

			$sWhere="
			and cl.post_date >= '".DateFormat::FormatSearch(Base::$aRequest['search']['count_date_from'])."'
			and cl.post_date <= '".DateFormat::FormatSearch(Base::$aRequest['search']['count_date_to'])."'
			";

			$sVinWhere=" and c.login_vin_request = '".Auth::$aUser['login']."'";
			$sVinSumSql=Base::GetSql('Manager/CountMoney',array('where'=>$sVinWhere.$sWhere));

			$sDiscountWhere=" and cg.price_type='discount' and uc.id_manager='".Auth::$aUser['id']."'";
			if (Base::$aRequest['search']['code_customer_group_discount'])
			$sDiscountWhere.=" and cg.code='".Base::$aRequest['search']['code_customer_group_discount']."'";
			$sDiscountSumSql=Base::GetSql('Manager/CountMoney',array('where'=>$sDiscountWhere.$sWhere));

			$sMarginWhere=" and cg.price_type='margin' and uc.id_manager='".Auth::$aUser['id']."'";
			if (Base::$aRequest['search']['code_customer_group_margin'])
			$sMarginWhere.=" and cg.code='".Base::$aRequest['search']['code_customer_group_margin']."'";
			$sMarginSumSql=Base::GetSql('Manager/CountMoney',array('where'=>$sMarginWhere.$sWhere));

			Base::$oResponse->AddAssign('manager_vin_money','innerHTML',Language::PrintPrice(Db::GetOne($sVinSumSql)));
			Base::$oResponse->AddAssign('manager_discount_money','innerHTML', Language::PrintPrice(Db::GetOne($sDiscountSumSql)));
			Base::$oResponse->AddAssign('manager_margin_money','innerHTML', Language::PrintPrice(Db::GetOne($sMarginSumSql)));
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function PayCartPackage($iIdCartPackage,$aEntry=array())
	{
		if ($iIdCartPackage) {
			$aCartPackageUpdate=array(
			'is_payed'=>1,
			);

			$sOrderStaus=Db::GetOne("select order_status from cart_package where id='".$iIdCartPackage."'");
			if ($sOrderStaus=="new" || $sOrderStaus=="pending") $aCartPackageUpdate['order_status']='work';		//30.12.2016

			Db::AutoExecute('cart_package',$aCartPackageUpdate,'UPDATE',"id='".$iIdCartPackage."'");
			Manager::SetPriceTotalCartPackage(array('id_cart_package'=>$iIdCartPackage));

			Cart::SendPendingWork($iIdCartPackage);

			Manager::NotifyDebitedMoney($aEntry);
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function NotifyDebitedMoney($aEntry=array())
	{
		if ($aEntry && $aEntry['id_buh_credit']=361)
		{
			$aIdBuhDebit=explode(",",Base::GetConstant('buh:id_buh_debit_money','302,301'));
			if ($aIdBuhDebit && in_array($aEntry['id_buh_debit'],$aIdBuhDebit)) {
				$aCustomer=Db::GetRow(Base::GetSql('Customer',array(
				'id'=>$aEntry['id_buh_credit_subconto1'],
				)));

				$aManager=Db::GetRow(Base::GetSql('Manager',array(
				'id'=>$aCustomer['id_manager'],
				)));

				Message::CreateDelayedNotification($aCustomer['id'],'notified_debited_money'
				,array('aEntry'=>$aEntry,'aCustomer'=>$aCustomer,'aManager'=>$aManager),true);
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function PrintOrder()
	{
		$aCartPackage=Db::GetRow(Base::GetSql('CartPackage',array(
		'where'=>"and cp.id='".Base::$aRequest['id']."'"))); //and cp.id_user='".Auth::$aUser['id']."'
		$aUserCart=Db::GetAll(Base::GetSql("Part/Search",array(
		"where"=>" and c.id_cart_package='".Base::$aRequest['id']."' and c.type_='order' ".
		"and c.order_status != 'refused' " //and c.id_user='".Auth::$aUser['id']."'
		)));

		$aCustomer=Db::GetRow(Base::GetSql('Customer',array(
		'id'=>(Base::$aRequest['id_user'] ? Base::$aRequest['id_user'] : -1),
		)));

		if (!$aUserCart || !$aCartPackage) Base::Redirect('?action=cart_package&table_error=cart_package_not_found');

		$aActiveAccount=Db::GetRow(Base::GetSql('Account',array('is_active'=>1)));
		$aCartPackage['summa_fact']=$aCartPackage['summa_fact']-$aCartPackage['bonus'];

		$sPriceTotalString=Currency::CurrecyConvert(Currency::BillRound($aCartPackage['summa_fact']),
		Base::GetConstant('global:base_currency'));
		$sPriceTotalString=String::GetUcfirst(trim($sPriceTotalString));

		$aCartPackage['price_total_string']=$sPriceTotalString;

		Base::$tpl->assign('aActiveAccount',$aActiveAccount);
		Base::$tpl->assign('aUserCart',$aUserCart);
		Base::$tpl->assign('aCartPackage',$aCartPackage);
		Base::$tpl->assign('aCustomer',$aCustomer);

		//Base::$tpl->assign('sMirautoInfo',Language::GetText('mirauto_info'));

		PrintContent::Append(Base::$tpl->fetch('cart/package_print.tpl'));
		Base::Redirect('?action=print_content&return=manager_package_list');
	}
	//-----------------------------------------------------------------------------------------------
	public function RefusePending()
	{
		$aCart=Db::GetRow(Base::GetSql('Cart',array(
		'id'=> Base::$aRequest['id'],
		'status_array'=> array("'new','pending'"),				
		)));				//30.12.2016
		if (!$aCart) Form::RedirectAuto("&aMessage[MI_NOTICE]=no such cart");

		$this->ProcessOrderStatus($aCart['id'],'refused');

		Form::RedirectAuto("&aMessage[MT_NOTICE]=order refused");
	}
	//-----------------------------------------------------------------------------------------------
	public function PrintPakage() {
		if (Base::$aRequest['row_check'])
		{
			$oCart= new Cart(false);
			$sFile=$oCart->PrintPackageExcel(Base::$aRequest['row_check']);
			if ($sFile) $sMessage="&aMessage[MT_NOTICE]=<a href=".$oCart->sPathToFile.$sFile.">Download files</a>";
			else $sMessage="&aMessage[MT_ERROR]=Export Faild";
		} else $sMessage="&aMessage[MT_ERROR]=Check Package";

		Form::RedirectAuto($sMessage);
	}
	//-----------------------------------------------------------------------------------------------
	static function SetPriceTotalCartPackage($aCart) {
		if ($aCart['id_cart_package']){
			$iId_GeneralCurrencyCode = Db::getOne("Select id from currency where id=1");
				
			$aUserCart=Db::GetAll("select * from cart
				where id_cart_package='".$aCart['id_cart_package']."' and order_status<>'refused'");
			
			//$aFactCart=Db::GetAll("select price_fact, count_fact, summa_fact from cart
			//	where id_cart_package='".$aCart['id_cart_package']."'");

			if (!$aUserCart) return;
				
			foreach ($aUserCart as $iKey => $aValue)
				$dSum+=Currency::PrintPrice($aValue['price'],$iId_GeneralCurrencyCode,2,"<none>")*$aValue['number'];

			if (!$aUserCart) return;
				
			foreach ($aUserCart as $iKeyF => $aValueF)
				$dSumFact+=Currency::PrintPrice($aValueF['price_fact'],$iId_GeneralCurrencyCode,2,"<none>")*$aValueF['count_fact'];
			
			/*$dSum=Db::GetOne("select sum(number*price) from cart
			 where id_cart_package='".$aCart['id_cart_package']."' and order_status<>'refused'");
			*/

			$dAmount=Db::GetOne("select sum(amount) as amountsum
				from user_account_log
				where section='internal' and custom_id=".$aCart['id_cart_package']);

			$dDiscountTotal=round($dSum*$aCart['discount']/100,2);
			if ($dSumFact){
					$sSql="update cart_package set summa_fact=".$dSumFact."-".$dDiscountTotal."+price_delivery";
					if ($dAmount) $sSql.=", price_additional=".$dSumFact."-".$dDiscountTotal."+price_delivery-".$dAmount;
					$sSql.=", discount_total=".$dDiscountTotal." where id='".$aCart['id_cart_package']."'";	
			}else{
				if ($dSum) {
					$sSql="update cart_package set price_total=".$dSum."-".$dDiscountTotal."+price_delivery";
					if ($dAmount) $sSql.=", price_additional=".$dSum."-".$dDiscountTotal."+price_delivery-".$dAmount;
					$sSql.=", discount_total=".$dDiscountTotal." where id='".$aCart['id_cart_package']."'";
						} else {
							$sSql="update cart_package set price_total=0, price_additional=0 where id='".$aCart['id_cart_package']."'";
						}
				}	
			Db::Execute($sSql);
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function MergePakage() {
		if (Base::$aRequest['id'])
		{
			$aCart=Db::GetAll(Base::GetSql("Cart",array('id_cart_package'=>Base::$aRequest['id'])));

			if ($aCart) {
				$aCartPackage=Db::GetRow(Base::GetSql("CartPackage",array(
				'id_user'=>$aCart[0]['id_user'],
				'order_status'=>'work',
				))." order by id desc"
				);

				foreach ($aCart as $sKey => $aValue) {
					Db::Execute("update cart
					set id_cart_package=".$aCartPackage['id']."
					where id=".$aValue['id']);
				}
				$this->SetPriceTotalCartPackage(array('id_cart_package'=>$aCartPackage['id']));

				Db::Execute("update user_account_log
					set custom_id=".$aCartPackage['id']." , description= concat(description,' merge ".Base::$aRequest['id']."')
					where custom_id=".Base::$aRequest['id']);

				Db::Execute("update cart_package
					set is_payed=0, manager_comment=concat(manager_comment,' merge to ".$aCartPackage['id']."')
					where id=".Base::$aRequest['id']);


				$sMessage="&aMessage[MT_NOTICE]=Merge successful";
			} else $sMessage="&aMessage[MT_ERROR]=Empty Cart";
		} else $sMessage="&aMessage[MT_ERROR]=Check Package";

		Form::RedirectAuto($sMessage);
	}
	//-----------------------------------------------------------------------------------------------
	public function ChangeProvider () {
		Auth::NeedAuth('manager');
		Base::$tpl->assign('aProvider',Db::GetAssoc("Assoc/UserProvider"));

		/* [ apply  */
		if (Base::$aRequest['is_post'])
		{
			$aData=String::FilterRequestData(Base::$aRequest['data']);
			if ($aData['id_provider_ordered']) {
				$aData['provider_name_ordered']=Db::GetOne("select name from user_provider where id_user=".$aData['id_provider_ordered']);
				$aData['comment']='changed provider';
				Db::AutoExecute("cart",$aData,"UPDATE","id=".Base::$aRequest['id_cart']);
				$sMessage="&aMessage[MT_NOTICE]=changed";
			}
			Form::RedirectAuto($sMessage);

		}
		/* ] apply */

		if (Base::$aRequest['action']==$this->sPrefix.'_change_provider')
		{
			Base::$tpl->assign('aData',Db::GetRow(Base::GetSql('Part/Search',array(
			'id_cart'=> Base::$aRequest['id_cart']
			))));

			$aData=array(
			'sHeader'=>"method=post",
			'sTitle'=>"Order to the provider",
			'sContent'=>Base::$tpl->fetch($this->sPrefix.'/form_order_provider.tpl'),
			'sSubmitButton'=>'Apply',
			'sSubmitAction'=>$this->sPrefix."_change_provider",
			'sReturnButton'=>'<< Return',
			'bAutoReturn'=>true,
			'sWidth'=>"500px",
			);
			$oForm=new Form($aData);
			Base::$sText.=$oForm->getForm();

			return;
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function SetPackagePayed () {
		$aUser=Db::GetRow("select * from cart_package as cp 
				inner join user as u ON u.id = cp.id_user
				inner join user_customer as uc ON uc.id_user = cp.id_user 
				/*inner join payment_report as pr ON pr.id_user = cp.id_user*/
				where cp.id=".Base::$aRequest['id']."
				order by cp.post_date desc");

				//Debug::PrintPre($aUser);

		$iTime = time();
		$sTime = date("Y-m-d H:i:s", $iTime);

		$sTypePay=Db::GetOne("select name from payment_type where id=".$aUser['id_payment_type']);

		if($aUser['summa_fact'] != 0.00){
			$fPrice=$aUser['summa_fact'];
		}
		else{
			$fPrice=$aUser['price_total'];
		}
		$fPriceBezCom= $fPrice - ($fPrice*0.0275);
		$fPriceCom = $fPrice * 0.0275;
		//Debug::PrintPre($sTypePay);
		$sQuery = "Insert into payment_report (id_user, payment_date, method, price, comis) VALUES
		(".$aUser['id_user'].",
		'".$sTime."', 
		'".$sTypePay."',
		".$fPriceBezCom.",
		".$fPriceCom.") ";
//Debug::PrintPre($sQuery);
		$sMessage='Payment report updated';
		$sSubject = Language::GetMessage('updated payment report');
		
		Base::$db->Execute($sQuery);
		/*if(Base::$aRequest['id']){
			$aCartPackage=Db::GetRow(Base::GetSql('CartPackage',array(
			'id'=> Base::$aRequest['id']
			)));
		}
		if(!$aCartPackage['id']){
			$sMessage="&aMessage[MT_ERROR]=not found";
		}else{*/
			Db::Execute("update cart_package set is_payed=1 where id='".Base::$aRequest['id']."' ");
			$sMessage="&aMessage[MT_NOTICE]=changed";
	//	}
		Form::RedirectAuto($sMessage);
	}
	//-----------------------------------------------------------------------------------------------
	public function ExportBills(){
		//Debug::PrintPre(Base::$aRequest);
		if (Base::$aRequest['action']=='manager_export_bill_all'){

		if (Base::$aRequest['search']['method']) $sWhere.=" and pr.method = '".Base::$aRequest['search']['method']."'";
		if (Base::$aRequest['search']['id_cart_package']) $sWhere.=" and pr.id_cart_package = '".Base::$aRequest['search']['id_cart_package']."'";
		if (Base::$aRequest['search']['name']) $sWhere.=" and uc.name  like '%".Base::$aRequest['search']['name']."%'";
		if (Base::$aRequest['search']['customer_group']) $sWhere.=" and cg.name = '".Base::$aRequest['search']['customer_group']."'";
		if (Base::$aRequest['search']['date_from']) $sWhere.=" and pr.payment_date >= '".DateFormat::FormatSearch(Base::$aRequest['search']['date_from'])."'";
		if (Base::$aRequest['search']['date_to']) $sWhere.=" and pr.payment_date <= '".DateFormat::FormatSearch(Base::$aRequest['search']['date_to'])."'";

			$sSql="select pr.*, u.email, u.login, uc.name, uc.id_customer_group, cg.name as customer_group
		 from payment_report pr 
				left join user as u ON u.id = pr.id_user
				left join user_customer as uc ON uc.id_user = pr.id_user
				left join customer_group cg on uc.id_customer_group=cg.id where 1=1
				".$sWhere;
		}else{
		  $sSql="select pr.*, u.email, u.login, uc.name, uc.id_customer_group, cg.name as customer_group
		 from payment_report pr 
				left join user as u ON u.id = pr.id_user
				left join user_customer as uc ON uc.id_user = pr.id_user
				left join customer_group cg on uc.id_customer_group=cg.id 
				where pr.id=".Base::$aRequest['id'];
			}
	        $aBill=Base::$db->getAll($sSql);
	    if ($aBill) {
	        $oExcel = new Excel();
	        $aHeader=array(
	            'A'=>array("value"=>'post_date'),
	            'B'=>array("value"=>'client'),
	            'C'=>array("value"=>'method'),
	            'D'=>array("value"=>'summa'),
	            'E'=>array("value"=>'comissiya'),
	            'F'=>array("value"=>'id_cart_package'),
	            'G'=>array("value"=>'customer_group'),
	        );
	        $oExcel->SetHeaderValue($aHeader,1,false);
	        $oExcel->SetAutoSize($aHeader);
	        $oExcel->DuplicateStyleArray("A1:U1");
	
	        $i=$j=2;
	        foreach ($aBill as $aValue)
	        {
	            /*$sMake=substr($aValue['item_code'],0,2);
	            if (strlen($aValue['cat_name'])==2) $sMake=$aValue['cat_name'];
	            $sMake=str_ireplace('LX','LS',$sMake);
	            $sMake=str_ireplace('HY','HU',$sMake);*/
	
	            $oExcel->setCellValue('A'.$i, $aValue['payment_date']);
	            $oExcel->setCellValue('B'.$i, $aValue['name']);
	            $oExcel->setCellValue('C'.$i, $aValue['method']);
	            $oExcel->setCellValue('D'.$i, $aValue['price']);
	            $oExcel->setCellValue('E'.$i, $aValue['comis']);
	            $oExcel->setCellValue('F'.$i, $aValue['id_cart_package']);
				$oExcel->setCellValue('G'.$i, $aValue['customer_group']);

	            $i++;
	        }
	        //end 
	        $sFileName=uniqid().'.xls';
	        $oExcel->WriterExcel5(SERVER_PATH.'/imgbank/temp_upload/'.$sFileName, true);
	    }

	    else $sFileName='EmptyData.xls';
	    Base::$tpl->assign('sFileName',$sFileName);
	    Base::$sText.=Base::$tpl->fetch('manager/export.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	public function Cat () {
		if (Base::$aRequest['is_post'])
		{
			Base::$aRequest['data']['pref']=substr(mb_strtoupper(str_replace(array(' ','-','#','.','/',',','_',':','[',']','(',')','*','&','+','`','\'','"','\\','<','>','?','!','$','%','^','@','~','|','=',';','{','}','№'), '', trim(Content::Translit(Base::$aRequest['data']['pref']))),'UTF-8'),0,3);
			if (Base::$aRequest['data']['id']) $sWhere=" and id<>'".Base::$aRequest['data']['id']."'";
			$bExist=Db::GetOne("select count(*) from cat where pref='".Base::$aRequest['data']['pref']."' ".$sWhere);
			Base::$aRequest['data']['name']=mb_strtoupper(str_replace(array(' ','-','#','.','/',',','_',':','[',']','(',')','*','&','+','`','\'','"','\\','<','>','?','!','$','%','^','@','~','|','=',';','{','}','№'), '', trim(Content::Translit(Base::$aRequest['data']['name']))),'UTF-8');			
			
			if ($bExist){
				Form::ShowError("pref already exists");
				Base::$aRequest['action']='manager_cat_add';
				Base::$tpl->assign('aData',Base::$aRequest['data']);
			} elseif (!Base::$aRequest['data']['name'] || !Base::$aRequest['data']['pref'] || !Base::$aRequest['data']['title']) {
				Form::ShowError("Please, fill the required fields");
				Base::$aRequest['action']='manager_cat_add';
				Base::$tpl->assign('aData',Base::$aRequest['data']);
			}
			else {
				$aData=String::FilterRequestData(Base::$aRequest['data']);
				$aData['descr']=Base::$aRequest['data']['descr'];
				if($aData['id']){
					Db::AutoExecute('cat',$aData,'UPDATE',"id='".$aData['id']."'");
					Form::RedirectAuto("&aMessage[MI_NOTICE]=updated");
				}else{
					Db::AutoExecute('cat',$aData);
					Form::RedirectAuto("&aMessage[MI_NOTICE]=added");
				}
			}
		}

		if (Base::$aRequest['action']=='manager_cat_add') {
			Resource::Get()->Add('/libp/ckeditor/ckeditor.js');
			Resource::Get()->Add('/libp/ckeditor/config.js');

			if(Base::$aRequest['id'] && !Base::$aRequest['data']['id']){
				Base::$tpl->assign('aData',Db::GetRow(Base::GetSql('Cat',array('id'=>Base::$aRequest['id']))));
			}

			$aData=array(
			'sHeader'=>"method=post",
			'sTitle'=>"Cat add",
			'sContent'=>Base::$tpl->fetch('manager/form_cat.tpl'),
			'sSubmitButton'=>'Apply',
			'sSubmitAction'=>'manager_cat_add',
			'sWidth'=>'100%',
			'sError'=>$sError,
			);
			$oForm=new Form($aData);

			Base::$sText.=$oForm->getForm();
			return;
		}

		$aData=array(
		'sHeader'=>"method=get",
		'sContent'=>Base::$tpl->fetch('manager/form_cat_search.tpl'),
		'sSubmitButton'=>'Search',
		'sSubmitAction'=>'manager_cat',
		'sReturnButton'=>'Clear',
		'bIsPost'=>0,
		'sWidth'=>'700px',
		'sError'=>$sError,
		);
		$oForm=new Form($aData);

		Base::$sText.=$oForm->getForm();



		// --- search ---
		if (Base::$aRequest['search']['name']) $sWhere.=" and c.name like '".Base::$aRequest['search']['name']."%'";
		if (Base::$aRequest['search']['pref']) $sWhere.=" and c.pref = '".Base::$aRequest['search']['pref']."'";
		if (Base::$aRequest['search']['title']) $sWhere.=" and c.title like '".Base::$aRequest['search']['title']."%'";

		// --------------

		$oTable=new Table();
		$oTable->iRowPerPage=20;
		$oTable->sSql=Base::GetSql('Cat',array(
		'where'=>$sWhere,
		));

		$oTable->aColumn=array(
		'name'=>array('sTitle'=>'Name'),
		'pref'=>array('sTitle'=>'Pref'),
		'title'=>array('sTitle'=>'Title'),
		'visible'=>array('sTitle'=>'visible'),
		'is_brand'=>array('sTitle'=>'is_brand'),
		'is_main'=>array('sTitle'=>'is_main'),
		'action'=>array(),
		);
		$oTable->sDataTemplate='manager/row_cat.tpl';
		$oTable->sButtonTemplate='manager/button_cat.tpl';

		$sTable=$oTable->getTable("ManagerCat");


		Base::$sText.=$sTable;
	}
	//-----------------------------------------------------------------------------------------------
	public function SynonymBrandClear ($sBrand) {
		$sBrand=  str_replace(' ', '', $sBrand);
		$sBrand=  str_replace('&', '', $sBrand);
		return $sBrand;
	}
	//-----------------------------------------------------------------------------------------------
	public function Synonym () {
		if(Base::$aRequest['xajax']){
			if(Base::$aRequest['new_brand']){
				$sPrefNew=Db::GetOne("select pref from cat where id='".Base::$aRequest['cat_id']."'");
				if(!$sPrefNew){
					Base::$oResponse->addAlert(Language::GetMessage("mansyn_not_found_new_pref"));
					return;
				}
				$sMain=Db::GetOne("select pref from cat where title='".Base::$aRequest['new_brand']."'");
				if($sMain){
					$iPrice=Db::GetOne("select count(*) from price where pref='".$sMain."'");
					if($iPrice){
						Db::Execute("update price set pref='".$sPrefNew."'
							,item_code=replace(item_code,'".$sMain."_','".$sPrefNew."_') 
							where pref='".$sMain."'");
					}
					$iCart=Db::GetOne("select count(*) from cart where pref='".$sMain."'");
					if($iCart){
						Db::Execute("update cart set pref='".$sPrefNew."'
							,item_code=replace(item_code,'".$sMain."_','".$sPrefNew."_') 
							where pref='".$sMain."'");
					}
					if($iPrice>0 || $iCart>0){
						$s='';
						if($iPrice>0) $s.=' '.Language::GetMessage("mansyn_changed_price");
						if($iCart>0) $s.=' '.Language::GetMessage("mansyn_changed_cart");
						Base::$oResponse->addAlert(Language::GetMessage("mansyn_main_brand").$s);
					}
					$iMain=Db::GetOne("select id from cat where title='".Base::$aRequest['new_brand']."'");
					Db::Execute("update cat_pref set cat_id='".Base::$aRequest['cat_id']."' 	where cat_id='".$iMain."'");
					Db::Execute("delete from cat where pref='".$sMain."'");
					//Base::$oResponse->addAlert("Это основной бренд, его нельзя добавлять");
					//return;
				}
				$sMain=Db::GetOne("select c.title from cat_pref cp inner join cat c on c.id=cp.cat_id and cp.name='".Base::$aRequest['new_brand']."'");
				if($sMain){
					Base::$oResponse->addAlert("Выбранный бренд уже привязан к ".$sMain);
					return;
				}
				Db::Execute("update cat_pref set cat_id='".Base::$aRequest['cat_id']."' where name='".Base::$aRequest['new_brand']."'");
				Base::$aRequest['brand']=Db::GetOne("select title from cat where id='".Base::$aRequest['cat_id']."'");
			}
			if(Base::$aRequest['brand']){
				$sMain=Db::GetOne("select title from cat where title='".Base::$aRequest['brand']."'");
				if(!$sMain) $sMain=Db::GetOne("select c.title from cat c
					inner join cat_pref cp on c.id=cp.cat_id and cp.name='".Base::$aRequest['brand']."'");
				if(Base::$aRequest['delete']==2){
					$i=DB::GetOne("select id from cat where title='".Base::$aRequest['brand']."'");
					Db::Execute("delete from cat_pref where cat_id='".$i."'");
					Db::Execute("delete from cat where title='".Base::$aRequest['brand']."'");
					Base::$oResponse->addScript("location.reload();");
					return;
				}
				if(Base::$aRequest['delete']){
					Db::Execute("delete from cat_pref where name='".Base::$aRequest['brand']."'");
					if(!$sMain){
						Base::$oResponse->addScript("location.reload();");
						return;
					}
				}
				if($sMain){
					Base::$tpl->assign('iCatId',Db::GetOne("select id from cat where title='".$sMain."'"));
					$aSynonym0=array(array(
					'name'=>$sMain,
					'is_main'=>1,
					));
					$aSynonym1=Db::GetAll(
					$s="select cp.name,0 is_main from cat c"
					. " left join cat_pref cp on cp.cat_id=c.id"
					. " where c.title='".$sMain."'"
					. " order by cp.name"
					);
					$aSynonym=  array_merge($aSynonym0,$aSynonym1);
				}
				if($aSynonym){
					Base::$oResponse->addScript("$('.synonym-plus').show();");
					foreach ($aSynonym as $value) {
						$sBrand=  Manager::SynonymBrandClear($value['name']);
						Base::$oResponse->addScript("$('.synonym-plus_".$sBrand."').hide();");
					}
				}else
				Base::$oResponse->addScript("$('.synonym-plus').hide();");
				if(!$aSynonym)
				$aSynonym=Db::GetAll(
					$s="select cp.name,0 is_main from cat_pref cp "
					. " where cp.name='".Base::$aRequest['brand']."'"
					. " order by cp.name"
					);
				//Debug::PrintPre($aSynonym);
				Base::$tpl->assign('aSynonym',$aSynonym);
				Base::$oResponse->addAssign('id_synonym','outerHTML',Base::$tpl->fetch("manager/select_synonym.tpl"));
				$sBrand=  Manager::SynonymBrandClear(Base::$aRequest['brand']);
				Base::$oResponse->addScript("$('#div_brand').scrollTo($('#brand_".$sBrand."'), 10);");
			}
			if(isset(Base::$aRequest['search'])){
				$s=Db::GetOne("select id from ("
				. " select replace(replace(title,'&',''),' ','') as id,title as name from cat"
				. " union "
				. " select replace(replace(name,'&',''),' ','') as id, name from cat_pref /*where cat_id>0*/"
				. " ) t"
				. " where t.name like '".Base::$aRequest['search']."%' order by t.name");
				Base::$oResponse->addScript("$('#div_brand').scrollTo($('#brand_".$s."'), 500);");
			}
			return;
		}
		Base::$tpl->assign('aBrand',Db::GetAssoc("select id,name from ("
				. " select replace(replace(title,'&',''),' ','') as id,title as name from cat"
				. " union "
				. " select replace(replace(name,'&',''),' ','') as id, name from cat_pref /*where cat_id>0*/"
				. " ) t"
				. " order by t.name"));
		Base::$tpl->assign('aSynonym',array(-1=>array('name'=>Language::GetMessage('Choose brand first'))));
		Base::$aTopPageTemplate=array('panel/tab_price.tpl'=>'manager_synonym');
		Base::$sText.=Base::$tpl->fetch('manager/synonym.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	public function CatPref () {
		Base::$aTopPageTemplate=array('panel/tab_price.tpl'=>'manager_cat_pref');
		if (Base::$aRequest['is_post'])
		{
			if (!Base::$aRequest['data']['name'] || !Base::$aRequest['data']['cat_id']) {
				Form::ShowError("Please, fill the required fields");
				Base::$aRequest['action']='manager_cat_pref_add';
				Base::$tpl->assign('aData',Base::$aRequest['data']);
			}
			else {
				$aData=String::FilterRequestData(Base::$aRequest['data']);
				if($aData['id']){
					Db::AutoExecute('cat_pref',$aData,'UPDATE',"id='".$aData['id']."'");
					Form::RedirectAuto("&aMessage[MI_NOTICE]=updated");
				}else{
					Db::AutoExecute('cat_pref',$aData);
					Form::RedirectAuto("&aMessage[MI_NOTICE]=added");
				}
			}
		}

		if (Base::$aRequest['action']=='manager_cat_pref_add') {
			if(Base::$aRequest['id'] && !Base::$aRequest['data']['id']){
				Base::$tpl->assign('aData',Db::GetRow(Base::GetSql('CatPref',
				array(
					'id'=>Base::$aRequest['id'],
					'is_left'=> true,
				))));
			}
			Base::$tpl->assign('aPrefAssoc',array(""=>"")+Db::GetAssoc("select id, concat(title,' [',pref,']') name from cat order by title"));

			$aData=array(
			'sHeader'=>"method=post",
			'sTitle'=>"Catpref add",
			'sContent'=>Base::$tpl->fetch('manager/form_cat_pref.tpl'),
			'sSubmitButton'=>'Apply',
			'sSubmitAction'=>'manager_cat_pref_add',
			//'sWidth'=>'750px',
			'sError'=>$sError,
			);
			$oForm=new Form($aData);

			Base::$sText.=$oForm->getForm();
			return;
		}

		if (Base::$aRequest['action']=='manager_cat_pref_delete') {
			Db::Execute("delete from cat_pref where id='".Base::$aRequest['id']."'");
			Base::Message(array('MI_NOTICE'=>'deleted'));
		}

		$aData=array(
		'sHeader'=>"method=get",
		'sContent'=>Base::$tpl->fetch('manager/form_cat_pref_search.tpl'),
		'sSubmitButton'=>'Search',
		'sSubmitAction'=>'manager_cat_pref',
		'sReturnButton'=>'Clear',
		'bIsPost'=>0,
		'sWidth'=>'700px',
		'sError'=>$sError,
		);
		$oForm=new Form($aData);

		Base::$sText.=$oForm->getForm();



		// --- search ---
		if (Base::$aRequest['search']['name']) $sWhere.=" and cp.name like '".Base::$aRequest['search']['name']."%'";
		if (Base::$aRequest['search']['pref']) $sWhere.=" and c.pref = '".Base::$aRequest['search']['pref']."'";

		// --------------

		$oTable=new Table();
		$oTable->iRowPerPage=20;
		$oTable->sSql=Base::GetSql('CatPref',array(
		'where'=>$sWhere,
		'is_left'=> true,
		));

		$oTable->aColumn=array(
		'name'=>array('sTitle'=>'Name'),
		'pref'=>array('sTitle'=>'Pref'),
		'action'=>array(),
		);
		$oTable->sDataTemplate='manager/row_cat_pref.tpl';
		$oTable->sButtonTemplate='manager/button_cat_pref.tpl';

		$sTable=$oTable->getTable("ManagerCatPref");


		Base::$sText.=$sTable;
	}
	//-----------------------------------------------------------------------------------------------
	public function SetCheckedAuto () {
		if (Base::$aRequest['id'] && isset(Base::$aRequest['val']) ) {
			$aMass = explode("_",Base::$aRequest['id']);
			$aOrder = Db::GetRow("Select * from cart_package where id=".$aMass[1]);
			if ($aOrder['id']) {
				// need set checked
				if ($aOrder['is_need_check'] == 1) 
					Db::Execute("Update cart_package set is_checked_auto=".Base::$aRequest['val']." where id=".$aOrder['id']);
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function CustomerRecalcCart () {
		if (Base::$aRequest['id']) {
			User::RecalcCart(Base::$aRequest['id'],1);
			// rebuild order items - code from cart CartOnePageOrder
			$sUserCartSql=Base::GetSql("Part/Search",array(
					"type_"=>'cart',
					"where"=> " and c.id_user='".Auth::$aUser['id']."'",
			));
			$aUserCart=Db::GetAll($sUserCartSql);
			if ($aUserCart) foreach ($aUserCart as $iKey => $aValue) {
				$dSubtotal+=$aValue['number']*Currency::PrintPrice($aValue['price']);
				$aUserCart[$iKey]['number_price'] = $aValue['number']*Currency::PrintPrice($aValue['price']);
			}
			Base::$tpl->assign('aUserCart',$aUserCart);
			Base::$tpl->assign('dSubtotal',$dSubtotal);
			Base::$tpl->assign('dTotal',$dSubtotal+Currency::PrintPrice($_SESSION['current_cart']['price_delivery']));
			
			$aBonusForUser = Db::GetRow("select
            0 as id,
            (select name from user_customer u where u.id_user = h.id_customer) as name,
            ' ' as addr,
            ' ' as manager,
            'Итого' as num,
            sum(summa) as summa ,
            null as dt,
            null as dt5,
            sum(summa_order) as summa_order,
            null as dt_pay,
            sum(summa_pay) as summa_pay,
            sum(summa_all) as summa_all,
            sum(summa_dolg) as summa_dolg,
            comment as comment ,
            move_id as move_id
            	    
            FROM ec_saleh h
            where h.id_customer='".Base::$aRequest['id']."'
            ");

			$aBonusForUser=$aBonusForUser['summa_all']-$aBonusForUser['summa_dolg'];

			Base::$tpl->assign('aBonusForUser',$aBonusForUser);
			if($aBonusForUser < 0){
				Base::$oResponse->addAssign('sum_dolg','outerHTML',
			Base::$tpl->fetch("cart/text_dolg.tpl"));
			}
			
		
			if($aBonusForUser < 0){
				Base::$oResponse->addScript("
			    $('.js-popup-auth2').fadeIn();
			    var popupBlock = $('.js-popup-auth2').find('.block-popup');
			    var popupHeight = popupBlock.height();
			    popupBlock.css({
			        'top' : - popupHeight
			    });
			    popupBlock.animate({
			        'top': 0
			    }, 300);");
			}
			Base::$oResponse->addAssign('text_order','innerHTML',
			Base::$tpl->fetch("cart/text_order.tpl"));

			if($aBonusForUser > 0){
			Base::$oResponse->addAssign('bonus','innerHTML',
			Base::$tpl->fetch("cart/input_bonus.tpl"));
				}

			$aAdress=Db::GetAll("select * from ec_addres where id_user='".Base::$aRequest['id']."' ");
            $aDataAlready=Db::GetRow("select * from user_customer where id_user='".Base::$aRequest['id']."' ");
			Base::$tpl->assign('aAdress',$aAdress);
            Base::$tpl->assign('aDataAlready',$aDataAlready);
			Base::$oResponse->addAssign('id_delivery_point','innerHTML',Base::$tpl->fetch("cart/cart_onepage_user_delivery_point.tpl"));
            Base::$oResponse->addAssign('table_id','innerHTML',Base::$tpl->fetch("cart/form_choose_ac_manager.tpl"));

            Base::$oResponse->addScript("
    	$('#delivery2').toggle();
    	$('#delivery2_2').toggle();
    	 $('#delivery2_3').toggle();
    	$('.step:last').addClass('selected');
    	
          $('.js-block-label2 input[type='radio']').change(function(){
        $('.js-block-label2 .label').removeClass('selected');
        $(this).closest('.label').addClass('selected');
    });

    $('.js-block-label2 .label').click(function(){
        $(this).find('input[type='radio']').attr('checked', 'checked');
        $(this).find('input[type='radio']').change();
    })");
		}
		elseif (Base::$aRequest['id_list']) {
		
		if(Base::$aRequest['id_list']) 
			$_SESSION['id_list']=Base::$aRequest['id_list'];
		if(!Base::$aRequest['id_list'] && $_SESSION['id_list'])
			Base::$aRequest['id_list'] = $_SESSION['id_list'];
		if($_SESSION['id_list'])	
		$_REQUEST['id_list']=$_SESSION['id_list'];

//		Base::Redirect("/pages/cart_onepage_order_manager");
		
		}

	}
	//-----------------------------------------------------------------------------------------------
	public function JoinOrders() {
		if (Base::$aRequest['row_check']) {
			// check diff owners orders
			$aCnt = Db::GetAll("Select count(*) as cnt, id_user from cart_package where id in ('".implode("','",Base::$aRequest['row_check'])."') group by id_user");
			if (count($aCnt) > 1)
				$sMessage = "&aMessage[MT_ERROR]=Great 1 Check Package";
			else {
				// check diff user auto
				$aAutoCnt = Db::GetAll("Select id_own_auto from cart_package where id_own_auto > 0 and id in ('".implode("','",Base::$aRequest['row_check'])."') group by id_own_auto");
				if (count($aAutoCnt) > 1) {
					$sMessage = "&aMessage[MT_ERROR]=Great 1 Check Auto Package";
					Form::RedirectAuto($sMessage);
					return;
				}
				
				$sManagerCommentOld = Db::GetOne("SELECT group_concat(manager_comment SEPARATOR '\n ')
					FROM `cart_package`	WHERE id in ('".implode("','",Base::$aRequest['row_check'])."')");
				$sCustomerCommentOld = Db::GetOne("SELECT group_concat(customer_comment SEPARATOR '\n ')
					FROM `cart_package`	WHERE id in ('".implode("','",Base::$aRequest['row_check'])."')");
				
				$aTotalSum = Db::GetRow("Select max(id) as id, sum(price_total) as price_total, sum(price_delivery) as price_delivery ".
						" from cart_package where id in ('".implode("','",Base::$aRequest['row_check'])."')");
				// package
				$sNumbers = implode(",",Base::$aRequest['row_check']);
				$aOldPackage = Db::GetRow("Select * from cart_package where id=".$aTotalSum['id']);
				$sText = '';
				if ($sManagerCommentOld)
					$sText = $sManagerCommentOld."\n";
				$sText .= date("d-m-Y H:i:s")." ".Language::getMessage('split orders').": ".Auth::$aUser['login'].
				", ".Language::getMessage('numbers').': '.$sNumbers;
				Db::Execute("Update cart_package set price_total='".$aTotalSum['price_total']."', price_delivery='".$aTotalSum['price_delivery']."' ".
					",manager_comment='".$sText."',customer_comment='".$sCustomerCommentOld."' where id=".$aTotalSum['id']);
				Db::Execute("Delete from cart_package where id in ('".implode("','",Base::$aRequest['row_check'])."') and id !=".$aTotalSum['id']);
				// cart
				Db::Execute("Update cart set id_cart_package=".$aTotalSum['id']." where id_cart_package in ('".implode("','",Base::$aRequest['row_check'])."')");
				
				// update auto?
				if ($aAutoCnt != array()) {
					$aAuto = Db::GetRow("Select * from cart_package where id=".$aTotalSum['id']);
					if ($aAuto['id_own_auto'] != $aAutoCnt[0]['id_own_auto'])
						Db::Execute("Update cart_package set id_own_auto=".$aAutoCnt[0]['id_own_auto'].", is_need_check=1, is_checked_auto=0 where id=".$aTotalSum['id']);
				}				
				$sMessage="&aMessage[MT_NOTICE]=Join orders successfully";
				
				if (Base::GetConstant("manager:enable_order_notification_on_email","1")) {
					$aCustomer=Db::GetRow( Base::GetSql('Customer',array('id'=>$aCnt[0]['id_user'])) );
						
					$sUserCartSql=Base::GetSql("Part/Search",array(
							"type_"=>'order',
							"where"=> " and c.id_cart_package=".$aTotalSum['id']." and c.id_user='".$aCnt[0]['id_user']."'",
					));
					$aUserCart=Db::GetAll($sUserCartSql);
					$aUserCartId=array();
					foreach ($aUserCart as $iKey => $aValue) {
						$dPriceTotal+=Currency::PrintPrice($aValue['price'],null,2,"<none>")*$aValue['number'];
						$aUserCart[$iKey]['print_price'] = Currency::PrintPrice($aValue['price'],null,2,"<none>");
					}

					$aCartPackage=Db::GetRow(Base::GetSql('CartPackage',array('id'=>$aTotalSum['id'])));
					$aSmartyTemplate=String::GetSmartyTemplate('manager_join_orders', array(
							'aCartPackage'=>$aCartPackage,
							'aCart'=>$aUserCart,
							'sListJoinOrders'=>$sNumbers,
					));
					// to user
					Mail::AddDelayed($aCustomer['email'],$aSmartyTemplate['name']." ".$aCartPackage['id'],
					$aSmartyTemplate['parsed_text'],'',"info",false);
					// to managers
					Mail::AddDelayed(Base::GetConstant('manager:email_recievers','info@moregoods.com.ua')
					,$aSmartyTemplate['name']." ".$aCartPackage['id'],
					$aSmartyTemplate['parsed_text'],'',"info",false);
				}
			}
		} 
		else $sMessage="&aMessage[MT_ERROR]=Check Package";
	
		Form::RedirectAuto($sMessage);
	}
	//-----------------------------------------------------------------------------------------------
	public function GetUserSelect(){
		if(Auth::$aUser['is_super_manager'])
			$sWhereManager = '';
		else
		 	$sWhereManager = " and uc.id_manager='".Auth::$aUser['id_user']."'";
		 	
		$sWhereManager .= " and uc.name like '%".Base::$aRequest['data']['term']."%'";
		$aUsersArray = Db::GetAll("select id as id, 
					concat(uc.name,' ( ',u.login,' )', 
				IF(uc.phone is null or uc.phone='','',concat(' ".
		Language::getMessage('tel.')." ',uc.phone))) name
			from user as u
			inner join user_customer as uc on u.id=uc.id_user
			where u.visible=1 and uc.name is not null and trim(uc.name)!=''
			".$sWhereManager."
			order by uc.name");
		echo json_encode($aUsersArray);
		die();
	}
	//-----------------------------------------------------------------------------------------------
	public function GetUserDebt(){
	    if (Base::$aRequest['action']=='manager_user_debt') {
	        
	        Base::$tpl->assign('aNameUser',array(0 =>'')+Db::GetAssoc("select u.id, uc.name as name
		from user as u
		inner join user_customer as uc on u.id=uc.id_user
        and u.id in (".$this->sCustomerSql.") and uc.id_region ='".$this->iIdRegion."'
		order by uc.name"));


	        Base::$tpl->assign('aNameDistr',array(0=>'')+Db::GetAssoc("select ed.id, ed.name as dist
				from ec_distributor as ed
				inner join ec_distributor_region as edr on edr.id_distributor=ed.id
                where edr.id_region='".$this->iIdRegion."' 
				order by ed.name"));
		

        $aData=array(
            'sHeader'=>"method=get",
          //  'sTitle'=>"Distribute",
            'sContent'=>Base::$tpl->fetch('manager/form_distribute.tpl'),
            'sSubmitButton'=>'Search',
            'sSubmitAction'=>'manager_user_debt',
            'sReturnButton'=>'Clear',
            'bIsPost'=>0,
            'sWidth'=>'800px',
            //'sError'=>$sError,
        );
        $oForm=new Form($aData);
        
        Base::$sText.=$oForm->getForm();
        // --- search ---
        if (Base::$aRequest['search_dist']) $sWhere.=" and h.id_dist=".Base::$aRequest['search_dist']." ";
        if (Base::$aRequest['search_login']) $sWhere.=" and h.id_customer = ".Base::$aRequest['search_login']." ";
        if (Base::$aRequest['search']['is_debt']=='is') $sWhere.=" and ( 1=0 OR ( NOT(h.summa_all=0 AND h.summa_dolg=0) or h.summa_order<>0 OR h.num in ('Начальный долг')))";
        // --------------
 // summa_all - ОДЗ
//summa_dolg - ПДЗ
	    $oTable=new Table();
	   // if (Base::$aRequest['search_login']){
	    $oTable->sSql="
            select
            0 as id,
            (select name from user_customer u where u.id_user = h.id_customer) as name,
            ' ' as addr,
            ' ' as manager,
            'Итого' as num,
            sum(summa) as summa ,
            null as dt,
            null as dt5,
            sum(summa_order) as summa_order,
            null as dt_pay,
            sum(summa_pay) as summa_pay,
            sum(summa_all) as summa_all,
            sum(summa_dolg) as summa_dolg,
            comment as comment ,
            move_id as move_id
            	    
            FROM ec_saleh h
            where h.id_region=".$this->iIdRegion."
            	    ".$sWhere."
            union all
            SELECT
            id,
            (select name from user_customer u where u.id_user=h.id_customer) as name,
            h.addr as addr,
            h.manager as manager,
            h.num as num,
            h.summa as summa,
            h.dt as dt,
            h.dt5 as dt5,
            h.summa_order as summa_order,
            h.dt_pay as dt_pay,
            h.summa_pay as summa_pay,
            h.summa_all as summa_all,
            h.summa_dolg as summa_dolg,
            h.comment as comment,
            h.move_id as move_id
            FROM ec_saleh h
            where  h.id_region=".$this->iIdRegion." and 1=1 
                ".$sWhere."
            order by id";
	    //print_r($oTable->sSql, false);
	    $oTable->iRowPerPage=100;
	    $oTable->aColumn=array(
	        'name'=>array('sTitle'=>'user_debt'),
	        'addr'=>array('sTitle'=>'addr'),
	        'manager'=>array('sTitle'=>'manager'),
	        'num'=>array('sTitle'=>'#'),
	        'summa'=>array('sTitle'=>'summa'),
	        'dt'=>array('sTitle'=>'dt'),
	        'dt5'=>array('sTitle'=>'dt5'),
	        'summa_order'=>array('sTitle'=>'summa_order'),
	        'dt_pay'=>array('sTitle'=>'dt_pay'),
	        'summa_pay'=>array('sTitle'=>'summa_pay'),
	        'summa_All'=>array('sTitle'=>'summa_All'),
	        'summa_Dolg'=>array('sTitle'=>'summa_Dolg'),
	        'comment'=>array('sTitle'=>'comment'),
	        //'id_dist'=>array('sTitle'=>'id_dist'),
	    );
	    //$oTable->sSubtotalTemplate='manager/subtotal_debt.tpl';
	    $oTable->sDataTemplate='manager/row_debt.tpl';
	    $sTable=$oTable->getTable();
	    Base::$sText.=$sTable;
	   
	    }
	    if (Base::$aRequest['action']=='manager_order_ship') {
	        $oTable=new Table();
	        
	        $oTable->sSql="select esd.* from ec_saled as esd
	            where esd.move_id='".Base::$aRequest['id']."'";
	        
	        //$oTable->aOrdered="order by c.post desc";
	        $oTable->aCallback=array($this,'CallParseOrderShip');
	        
	        $oTable->aColumn=array(
	            'name'=>array('sTitle'=>'name',),
	           // 'id_product'=>array('sTitle'=>'Code'),
	            'id_product'=>array('sTitle'=>'Articule'),
	            'qty'=>array('sTitle'=>'qty','sWidth'=>'30%'),
	            'unit'=>array('sTitle'=>'unit'),
	            'price'=>array('sTitle'=>'price'),
	            'total'=>array('sTitle'=>'total'),
	        //'action'=>array(),
	        );
	        
	        $oTable->iRowPerPage=200;
	        $oTable->sDataTemplate='manager/row_order_ship.tpl';
	        $oTable->bStepperVisible=false;
	        Base::$sText.=$oTable->getTable();
	        
	        return;
	    }
	    if (Base::$aRequest['action']=='manager_payment_ship') {
	        $oTable=new Table();
	         
	        $oTable->sSql="select ep.dt, ep.summa from ec_payments as ep
	            where ep.move_id='".Base::$aRequest['id']."'";
	         
	        //$oTable->aOrdered="order by c.post desc";
	        //$oTable->aCallback=array($this,'CallParseOrderShip');
	         
	        $oTable->aColumn=array(
	            'dt'=>array('sTitle'=>'dt',),
	            'summa'=>array('sTitle'=>'summa'),
	        );
	         
	        $oTable->iRowPerPage=200;
	        $oTable->sDataTemplate='manager/row_payment_ship.tpl';
	        $oTable->bStepperVisible=false;
	        Base::$sText.=$oTable->getTable();
	         
	        return;
	    }
	
	}
	//-----------------------------------------------------------------------------------------------
	public function CallParseOrderShip(&$aItem){
	    if ($aItem) {
	        foreach($aItem as $key => $value) {
	            $aOrderId[]=$value['id'];
	    
	            $aItem[$key]['name']=$value['name'];
	            $aItem[$key]['id_product']=$value['id_product'];
	            $aItem[$key]['qty']=$value['qty'];
	            $aItem[$key]['unit']=$value['unit'];
	            $aItem[$key]['price']=$value['price'];
	            $aItem[$key]['total']=$value['qty']*Currency::PrintPrice($value['price']);
	            
	            
	            //$dSubtotal+=$value['qty'] * Currency::PrintPrice($value['price'],null,2,'<none>');
	            //
	        }
	       
	        //$dSubtotal=array_sum($aItem[]['total']);
	        //Debug::PrintPre($aItem);
	    }
	    //return array('dSubtotal'=>$dSubtotal);
	    
	    
	}
	
	//*********************************
		public function GetUserDiscounts(){
	    if (Base::$aRequest['action']=='manager_user_discounts') {

//for manager
	        Base::$tpl->assign('aNameUser',array(0 =>'')+Db::GetAssoc("select u.id, uc.name as name
		from user as u
		inner join user_customer as uc on u.id=uc.id_user
        where u.id in (".$this->sCustomerSql.") and uc.id_region ='".$this->iIdRegion."'
		and exists(select * from ec_discounts ds where ds.id_user=uc.id_user)
		order by uc.name"));



	    $aGroupsG=Db::GetAssoc("select 0 as id, 'Всі' as name 
			union all
			select id,name from customer_group where visible=1");
		Base::$tpl->assign('aGroupsG',$aGroupsG);

		$aList=Db::GetAssoc("select 0 as id_list, '' as name
			union all
			select id as id_list,name
            from ec_list_of_users_h where id_manager='".Auth::$aUser['id_user']."'");
		Base::$tpl->assign('aList',$aList);
//for manager

		
	        Base::$tpl->assign('aNameDistr',array(0=>'')+Db::GetAssoc("select ed.id, ed.name as dist
				from ec_distributor as ed
				inner join ec_distributor_region as edr on edr.id_distributor=ed.id
                where edr.id_region='".$this->iIdRegion."' 
				order by ed.name"));

	        Base::$tpl->assign('aNameBrandGroup',array(0=>'')+Db::GetAssoc("select bgr.id, bgr.name as brand_group
				from ec_brand_group as bgr
				order by bgr.sort"));

	        Base::$tpl->assign('aNameBrand',array(0=>'')+Db::GetAssoc("select b.id, b.name as brand
				from ec_brand as b
				order by b.sort"));

        $aData=array(
            'sHeader'=>"method=get",
            'sContent'=>Base::$tpl->fetch('manager/form_discounts.tpl'),
            'sSubmitButton'=>'Search',
            'sSubmitAction'=>'manager_user_discounts',
            'sReturnButton'=>'Clear',
            'bIsPost'=>0,
            'sWidth'=>'800px',
        );
        $oForm=new Form($aData);
        
        Base::$sText.=$oForm->getForm();
        // --- search ---
        if (Base::$aRequest['search_dist']) $sWhere.=" and ds.id_distributor=".Base::$aRequest['search_dist']." ";
        if (Base::$aRequest['search_brand_group']) $sWhere.=" and ds.id_brand_group=".Base::$aRequest['search_brand_group']." ";
        if (Base::$aRequest['search_brand']) $sWhere.=" and ds.id_brand=".Base::$aRequest['search_brand']." ";
        if (Base::$aRequest['search_group']) $sWhere.=" and uc.id_customer_group=".Base::$aRequest['search_group']." ";
        if (Base::$aRequest['search_list']) $sWhere.=" and ds.id_brand=".Base::$aRequest['search_list']." ";

        if (Base::$aRequest['search_login']) $sWhere.=" and uc.id_user=".Base::$aRequest['search_login']." ";
        // --------------
	    $oTable=new Table();
	    
	    $oTable->sSql="
            SELECT 
            ds.id,
            uc.name as name,
            bgr.name as brand_group,
            b.name as brand,
            r.name as region,
            d.name as distr,
            cg.name as group_name,
            ds.discount as discount
            FROM ec_discounts ds
			inner join ec_brand_group bgr on bgr.id=ds.id_brand_group
			inner join ec_brand b on b.id=ds.id_brand
			inner join ec_region r on r.id=ds.id_region
			left join ec_distributor d on d.id=ds.id_distributor
			inner join user_customer uc on uc.id_user=ds.id_user
            inner join customer_group cg on cg.id=uc.id_customer_group
            where ds.id_region='".$this->iIdRegion."' 
                ".$sWhere."
            order by id";
//	    and uc.id_user in (".$this->sCustomerSql.")
            
	    $oTable->iRowPerPage=100;
	    $oTable->aColumn=array(
	        'name'=>array('sTitle'=>'user_debt'),
	        'brand_group'=>array('sTitle'=>'brand group'),
	        'brand'=>array('sTitle'=>'brand'),
	        'discount'=>array('sTitle'=>'discount'),
	        'distr'=>array('sTitle'=>'distributor'),
	        'region'=>array('sTitle'=>'region'),
	        'group_name'=>array('sTitle'=>'group_name'),
	        //'id_dist'=>array('sTitle'=>'id_dist'),
	    );
	    
	    $oTable->sDataTemplate='manager/row_discount.tpl';
	    //$oTable->sSubtotalTemplate='manager/subtotal_debt.tpl';
//	    $sTable=$oTable->getTable();
//	    Base::$sText.=$sTable;
        Base::$sText.=$oTable->getTable();
	    
	    }
	
	}


	
}
?>