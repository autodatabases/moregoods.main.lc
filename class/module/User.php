<?
/**
 * @author Mikhail Starovoyt
 *
 */
class User extends Base
{
	public static $aErrorTr=array();

	//-----------------------------------------------------------------------------------------------
	public function __construct()
	{
		Repository::InitDatabase('user',false);

		Base::$aData['template']['bWidthLimit']=true;
		//Manual::ShowShort('CUS');
		Base::$bXajaxPresent=true;
	}
	//-----------------------------------------------------------------------------------------------
	public function Login()
	{
		$oAuth=new Auth();
		$oAuth->Logout();
		Base::$sText.=Base::$tpl->fetch('user/login.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	public function DoLogin()
	{
		$aOldUser=Auth::$aUser;
		$oAuth=new Auth();
		$aUser=$oAuth->Login(trim($_POST['login']),$_POST['password'],false,true
		,Base::GetConstant('user:is_salt_password',1));

		Db::AutoExecute('user',array('password_temp'=>''),'UPDATE',"id='".$aUser['id']."'");
		if ($aUser['type_']=='customer') {
			if ($aOldUser && Customer::IsChangeableLogin($aOldUser['login'])) {
				//Syncronization
//06.01.2017
//
		if ($aUser['type_']=='customer')
		$sUserCartSql="select c.id,pr.price 
			from cart c
			inner join ec_price pr on pr.id_product=c.id_product 
			inner join user_customer uc on uc.id_customer_group=pr.id_customer_group and uc.id_region=pr.id_region and uc.id_user='".$aUser['id']."'
			where type_='cart' and c.id_user='".$aOldUser['id']."'";
			
		if ($aUser['type_']=='manager')		
		$sUserCartSql="select c.id,pr.price 
			from cart c
			inner join ec_price pr on pr.id_product=c.id_product 
			inner join user_manager um on um.id_customer_group=pr.id_customer_group and um.id_region=pr.id_region and um.id_user='".$aUser['id']."'
			where type_='cart' and c.id_user='".$aOldUser['id']."'";
	
		$aUserCart=Db::GetAll($sUserCartSql);
		if ($aUserCart) foreach ($aUserCart as $iKey => $aValue) {
			Db::Execute("update cart set price='".$aValue['price']."',discount=0,customer_id='".$aOldUser['id']."'  where id='".$aValue['id']."'");
		}

//
				Db::Execute("update cart set id_user='".$aUser['id']."' where id_user='".$aOldUser['id']."'");
				
				Db::Execute("update cart_package set id_user='".$aUser['id']."' where id_user='".$aOldUser['id']."'");
				Db::Execute("update user set visible='0' where id='".$aOldUser['id']."'");
				Db::Execute("update user_auto set id_user='".$aUser['id']."' where id_user='".$aOldUser['id']."'");
			}
			if($aUser['language']=='ru'){
				Base::Redirect("http://ru.moregoods.com.ua/?action=dashboard");
			}else{
			Base::Redirect("/?action=dashboard");
				}
		}
		if($aUser['language']=='ru'){
			Base::Redirect("http://ru.moregoods.com.ua/");
		}else{
			Base::Redirect("/");
		}
		
	}
	//-----------------------------------------------------------------------------------------------
	public function ChangeRegion()
	{
		if(Base::$aRequest['id_region'] && (Auth::$aUser['type_']=='customer' && !Customer::IsChangeableLogin(Auth::$aUser['login']) ) ) {
			$sCity=Base::$aRequest['id_region'];
			
			//$aManager=User::SelectManager($sCity);
			$sOblasRegion=array();
			//if($aManager) 
			//$aDataUpdate['id_manager']=$aManager['id'];
			//$aDataUpdate['id_region']=$sCity;
			$sOblasRegion['id_region']=Db::GetOne("select ec_region from net_city where id='".$sCity."'");
            $sOblasRegion['id_geo']=$sCity;
			Db::AutoExecute("user_customer",$sOblasRegion,'UPDATE',"id_user='".Auth::$aUser['id']."'");
			//Debug::PrintPre($sCity);
		} elseif(Base::$aRequest['id_region']) {
			$_SESSION['selected_city']=Base::$aRequest['id_region'];
		}
		$this->GeoYes();
		Base::$oResponse->addScript("location.reload();");
        //$this->ChangePhone(Base::$aRequest['id_region']);
		//Debug::PrintPre($sOblasRegion);
	}
	function ChangePhone($iRegion){
	    if(!$iRegion)$iRegion=1;
	    $sPhone= Db::GetOne("select r.phone1 from ec_region as r,net_city as nc where nc.ec_region=r.id and nc.id=".$iRegion);
	    if($sPhone) Base::$oResponse->addScript("$('#block-phones').text('".$sPhone."')");
	}
	//-------------------------------------------------------------------------------------------------
	public function GeoYes(){
	    $_SESSION['selected_city_first'] = 1;
	}
	
	//-------------------------------------------------------------------------------------------------
	/*public function LoginzaLogin()
	{
	$oAuth=new Auth();

	$sSig=md5(Base::$aRequest['token'].Base::GetConstant("loginza:api_sig","988e4decefc134d603dfcd89ce283e25"));
	$sURL="http://loginza.ru/api/authinfo?token=".Base::$aRequest['token']."&id=".Base::GetConstant("loginza:widget_id","31889")."&sig=".$sSig;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
	curl_setopt($ch, CURLOPT_TIMEOUT, 3);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_NOBODY, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_URL, $sURL);
	$aPostResult=curl_exec($ch);
	curl_close($ch);

	//$aPostResult='{"identity":"http:\/\/vkontakte.ru\/id11d78101","provider":"http:\/\/vkontakte.ru\/","uid":1128271,"name":{"first_name":"\u0416\u0435\u043d\u044f","last_name":"\u041b\u0430\u0437\u0430\u0440\u0435\u0432"},"gender":"M","dob":"1990-02-21","address":{"home":{"country":"2"}},"photo":"http:\/\/cs407224.userapi.com\/u11827810\/e_0164c9ba.jpg"}';
	$oJsonResult=json_decode($aPostResult);

	$aResult=Db::GetRow("select * from loginza_user where identity='".$oJsonResult->identity."'");
	if ($aResult){
	$sLogin=$aResult['login'];
	$sPassword=$aResult['uid'];
	$aUser=$oAuth->Login($sLogin,$sPassword,false,true,Base::GetConstant('user:is_salt_password',1));
	Base::Redirect("./");
	}
	else {
	if (!$oJsonResult->nickname){
	if (!$oJsonResult->email){
	$sNick=$oJsonResult->uid;
	}
	else {
	$sNick=substr($oJsonResult->email,0,strpos($oJsonResult->email,'@'));
	}
	}
	else {
	$sNick=$oJsonResult->nickname;
	}
	$sNick=Catalog::StripLogin($sNick);

	if (!$oJsonResult->name->full_name){
	$sName=$oJsonResult->name->first_name." ".$oJsonResult->name->last_name;
	} else {
	$sName=$oJsonResult->name->full_name;
	}

	//write loginza data to db
	Db::Execute("INSERT INTO `loginza_user` (`uid`, `nickname`, `provider`, `full_name`, `gender`, `identity`, `photo`)
	VALUES(
	'".$oJsonResult->uid."',
	'".$sNick."',
	'".$oJsonResult->provider."',
	'".$sName."',
	'".$oJsonResult->gender."',
	'".$oJsonResult->identity."',
	'".$oJsonResult->photo."'
	)");
	$sLogin="lz".Db::InsertId()."-".$sNick;
	Db::Execute("update loginza_user set login='".$sLogin."' where identity='".$oJsonResult->identity."'");

	$sEmail= null; ///Base::$aRequest['email'];
	$sIdentity=$oJsonResult->identity;
	$sPassword=$oJsonResult->uid;

	//emulate POST data
	$_POST['login'] = $sLogin;
	$_POST['password'] = $sPassword;

	//default registration
	$sSignature=md5(time()."autozp_customer".$sLogin.$sEmail);
	$sIp=Auth::GetIp();
	$sSalt=String::GenerateSalt();

	$sQuery="insert into user(type_,login,password,email,visible,approved,signature,ip,id_language,last_visit_date,salt
	,password_temp) values
	('customer','".$sLogin."','".String::Md5Salt($sPassword,$sSalt)."'
	,'".$sEmail."','1','0','".$sSignature."','".$sIp."','".Language::$iLocale."',NOW(),'".$sSalt."'
	,'".$sPassword."')";
	Db::Execute($sQuery);
	$sIdUser=Db::InsertId();
	if ($sIdUser) {

	if (!$aManager) $aManager=Db::GetRow("select u.*,um.* from user_manager um,user u
	where u.id=um.id_user and u.visible=1 and um.has_customer=1 order by rand()");

	$aUserCustomer=array(
	'name'=>$sName
	);
	$aUserCustomer['id_user']=$sIdUser;
	$aUserCustomer['id_manager']=$aManager['id'];
	Db::Autoexecute('user_customer',$aUserCustomer);


	$sQuery="insert into user_account(id_user) values ('$sIdUser')";
	Db::Execute($sQuery);

	if ($bAutoCreate) return true;

	$sLink="<A href='http://".SERVER_NAME."/?action=user_confirm_registration&signature=".$sSignature."'
	>".Base::$language->getMessage('Confirm')."</a>";
	$sUrl="http://".SERVER_NAME."/?action=user_confirm_registration&signature=".$sSignature;

	$aData=array(
	'info'=>array(
	'link'=>$sLink,
	'url'=>$sUrl,
	'email'=>$sEmail,
	'provider'=>$oJsonResult->provider
	),
	'aManager'=>$aManager
	);
	$aSmartyTemplate=String::GetSmartyTemplate('confirmation_letter_loginza', $aData);
	$sBody=$aSmartyTemplate['parsed_text'];

	Mail::AddDelayed($sEmail,Base::$language->getMessage('Confirmation Letter'),$sBody,'','',true,2);

	$sQuery="update loginza_user set user_id='$sIdUser', create_done=1 where identity='".$sIdentity."'";
	Db::Execute($sQuery);

	$this->DoLogin();
	Base::Redirect("/?action=customer_profile");
	}
	else {
	Base::$sText.=Content::getTemplate('new_account_error_created');
	}
	}
	}*/
	//-----------------------------------------------------------------------------------------------
	public function UloginLogin()
	{
		$oAuth=new Auth();

		$sJsonResult = file_get_contents('http://ulogin.ru/token.php?token=' . Base::$aRequest['token'] . '&host=' . $_SERVER['HTTP_HOST']);
		//$sJsonResult='{"access_token":"ya29.AHES6ZREFYc5VObrmoKu-3EP6GhPjzsgbPdLSC3CrZ15UC4","network":"google","identity":"https:\/\/plus.google.com\/u\/0\/100142627275839704974\/","uid":"100142627275839704974","email":"zaman.ua@gmail.com","nickname":"ZHenya","first_name":"\u0416\u0435\u043d\u044f","last_name":"\u041b\u0430\u0437\u0430\u0440\u0435\u0432","profile":"https:\/\/plus.google.com\/u\/0\/100142627275839704974\/","manual":"nickname"}';
		$aJsonResult = json_decode($sJsonResult, true);
		$aResult=Db::GetRow("select * from ulogin_user where identity='".$aJsonResult['identity']."'");
		if ($aResult){
			$sLogin=$aResult['login'];
			$sPassword=$aJsonResult['uid'];
			$aUser=$oAuth->Login($sLogin,$sPassword,false,true,Base::GetConstant('user:is_salt_password',1));
			Base::Redirect("./");
		}
		else {
			$sNick=Catalog::StripLogin($aJsonResult['nickname']);

			$sName=$aJsonResult['first_name']." ".$aJsonResult['last_name'];

			//write ulogin data to db
			Db::Execute("INSERT INTO `ulogin_user` (`uid`, `nickname`, `provider`, `full_name`, `identity`)
					VALUES(
					'".$aJsonResult['uid']."',
					'".$sNick."',
					'".$aJsonResult['network']."',
					'".$sName."',
					'".$aJsonResult['identity']."'
					)");
			$sLogin="lz".Db::InsertId()."-".$sNick;
			//$sPassword=trim("passwd".Db::InsertId());  //, password='".$sPassword."
			Db::Execute("update ulogin_user set login='".$sLogin."' where identity='".$aJsonResult['identity']."'");

			$sEmail=$aJsonResult['email'];
			$sIdentity=$aJsonResult['identity'];
			$sPassword=$aJsonResult['uid'];
			//emulate POST data
			$_POST['login'] = $sLogin;
			$_POST['password'] = $sPassword;

			//default registration
			$sSignature=md5(time()."autozp_customer".$sLogin.$sEmail);
			$sIp=Auth::GetIp();
			$sSalt=String::GenerateSalt();

			$sQuery="insert into user(type_,login,password,email,visible,approved,signature,ip,id_language,last_visit_date,salt
				,password_temp) values
			 ('customer','".$sLogin."','".String::Md5Salt($sPassword,$sSalt)."'
			 	,'".$sEmail."','1','0','".$sSignature."','".$sIp."','".Language::$iLocale."',NOW(),'".$sSalt."'
			 	,'".$sPassword."')";
			Db::Execute($sQuery);
			$sIdUser=Db::InsertId();
			if ($sIdUser) {

				if (!$aManager) $aManager=Db::GetRow("select u.*,um.* from user_manager um,user u
					where u.id=um.id_user and u.visible=1 and um.has_customer=1 order by rand()");

				$aUserCustomer=array(
				'name'=>$sName
				);
				$aUserCustomer['id_user']=$sIdUser;
				$aUserCustomer['id_manager']=$aManager['id'];
				Db::Autoexecute('user_customer',$aUserCustomer);


				$sQuery="insert into user_account(id_user) values ('$sIdUser')";
				Db::Execute($sQuery);

				if ($bAutoCreate) return true;

				$sLink="<A href='http://".SERVER_NAME."/?action=user_confirm_registration&signature=".$sSignature."'
					>".Base::$language->getMessage('Confirm')."</a>";
				$sUrl="http://".SERVER_NAME."/?action=user_confirm_registration&signature=".$sSignature;

				$aData=array(
				'info'=>array(
				'link'=>$sLink,
				'url'=>$sUrl,
				'email'=>$sEmail,
				'provider'=>$aJsonResult['network']
				),
				'aManager'=>$aManager
				);
				$aSmartyTemplate=String::GetSmartyTemplate('confirmation_letter_ulogin', $aData);
				$sBody=$aSmartyTemplate['parsed_text'];

				Mail::AddDelayed($sEmail,Base::$language->getMessage('Confirmation Letter'),$sBody,'','',true,2);

				$sQuery="update ulogin_user set user_id='$sIdUser', create_done=1 where identity='".$sIdentity."'";
				Db::Execute($sQuery);

				$this->DoLogin();
				Base::Redirect("/?action=customer_profile");
			}
			else {
				Base::$sText.=Content::getTemplate('new_account_error_created');
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function Logout()
	{
		$oAuth=new Auth();
		$oAuth->Logout();

		$this->Redirect('/?action=user_login');
	}
	//-----------------------------------------------------------------------------------------------
	public function NewAccount()
	{
		if (Base::$aRequest['is_post']) {
    		//Base::$aRequest['login']=preg_replace("/[^0-9]/", '', Base::$aRequest['data']['phone']);
    		$_REQUEST['login']=Base::$aRequest['login'];
    		$_POST['login']=Base::$aRequest['login'];
			$sError=$this->NewAccountError();
			if (!$sError) {
				$this->DoNewAccount();
				return;
			}
		}

		if (Base::$aRequest['second_time']) {
			Base::$tpl->assign('sSecondTime',1);
			//restore captcha
			$aCapcha=array(
				'mathematic_formula' => Base::$aRequest['capcha']['mathematic_formula'],
				'validation_hash' => Base::$aRequest['capcha']['validation_hash'],
				'result' => Base::$aRequest['capcha']['result'],
			);
			Base::$tpl->assign('aCapcha',$aCapcha);
			Base::$tpl->assign('sCapcha',Base::$tpl->fetch('addon/capcha/mathematic.tpl'));
		} else {
			$oCpacha= new Capcha();
			Base::$tpl->assign('sCapcha',$oCpacha->GetMathematic());
			Base::$tpl->assign('sSecondTime',1);
		}
		
		$aRegionList=Db::GetAssoc("select 0 as id,' Виберіть свій регіон !!!' as  name_ru union all 
        
        select id, name_ru from net_city order by name_ru");
		Base::$tpl->assign('aRegionList',$aRegionList);

		$aData=array(
		'sHeader'=>"method=post",
		'sTitle'=>"Register new user",
		'sContent'=>Base::$tpl->fetch('user/new_account.tpl'),
		//'sSubmitButton'=>'Register',
		'sSubmitAction'=>'user_new_account',
		'sError'=>$sError,
		);
		$oForm=new Form($aData);
		$oForm->sWidth=' ';
		Base::$oContent->AddCrumb(Language::GetMessage('Register'),'');

		Base::$sText.=$oForm->getForm();
	}
	//-----------------------------------------------------------------------------------------------
	public function NewAccountError()
	{

		if (!Base::$aRequest['user_agreement'])
		return "You need to apply user agreemnt";

		if (!Base::$aRequest['login']||!Base::$aRequest['password']||!Base::$aRequest['email']
		|| !Base::$aRequest['data']['phone'] || !Base::$aRequest['data']['name'] || !Base::$aRequest['data']['address']
		|| !Base::$aRequest['data']['city'])
		return "Please, enter all the fields";

	
        
        
		if (Base::$aRequest['password']!=Base::$aRequest['verify_password'])
		return "Passwosds are different. Please try again";

		if (Base::$aRequest['password']==Base::$aRequest['login'])
		return "Login and password must be different. Please try again";

		if (strlen(Base::$aRequest['password'])<4)
		return "Password can't be less then 4 digits";

		if (!String::CheckEmail(Base::$aRequest['email']))
		return "Please, check your email";

		$sQuery="select * from user where login='".Base::$aRequest['login']."'";
		$aUser=Db::GetRow($sQuery);
		if ($aUser)	return "This login is already occupied. Please choose different one.";

		$sQuery="select * from user where email='".Base::$aRequest['email']."'";
		$aUser=Db::GetRow($sQuery);
		if ($aUser)	return "This email is already registered. Please use the link \"Forgot password\".";

		if (!Capcha::CheckMathematic()) return "Check capcha value";

		return false;
	}
	//-----------------------------------------------------------------------------------------------
	public function DoNewAccount($bAutoCreate=false)
	{
		$sSignature=md5(time()."autozp_customer".Base::$aRequest['login'].Base::$aRequest['email']);
		$sIp=Auth::GetIp();
		$sSalt=String::GenerateSalt();

		$sQuery="insert into user(type_,login,password,email,visible,approved,signature,ip,id_language,last_visit_date,salt
			,password_temp) values
		 ('customer','".Base::$aRequest['login']."','".String::Md5Salt(Base::$aRequest['password'],$sSalt)."'
		 	,'".Base::$aRequest['email']."','1','0','".$sSignature."','".$sIp."','".Language::$iLocale."',NOW(),'".$sSalt."'
		 	,'".Base::$aRequest['password']."')";
		Db::Execute($sQuery);
		$sIdUser=Db::InsertId();
		if ($sIdUser) {
			$aUserCustomer=String::FilterRequestData(Base::$aRequest['data'],array(
			'name','country','city','address','address2','zip','phone','phone2','remark'
			,'additional_field1','additional_field2','additional_field3','additional_field4','id_geo'
			));
			$aUserCustomer['id_user']=$sIdUser;

			if($aUserCustomer['id_geo']){
				$aUserCustomer['id_region']=Db::GetOne("select ec_region from net_city where id='".$aUserCustomer['id_geo']."'");
				$aUserCustomer['id_geo'] = $aUserCustomer['id_geo'];
			}
			elseif($_SESSION['selected_city']){
				$aUserCustomer['id_region']=Db::GetOne("select ec_region from net_city where id='".$_SESSION['selected_city']."'");
				$aUserCustomer['id_geo'] = Db::GetOne("select id from net_city where id='".$_SESSION['selected_city']."'");
			}else{
				$aUserCustomer['id_region']=Db::GetOne("select ec_region from net_city where name_ru='".Base::$aRequest['uc']['city'] ."'");
				$aUserCustomer['id_geo'] = Db::GetOne("select id from net_city where name_ru='".Base::$aRequest['uc']['city']."'");
			
			}
			if(!$aUserCustomer['id_region']){
				$aUserCustomer['id_region']=1;			//Киевская область
				$aUserCustomer['id_geo'] = 49713;		//Киев
			
			}
			
			if(Auth::$aUser['type_']=='manager') $aManager=Db::GetRow("select u.*,um.* from user_manager um,user u
				where u.id=um.id_user and u.id='".Auth::$aUser['id']."'");
			if (!$aManager) $aManager=Db::GetRow("select u.*,um.* from user_manager um,user u
				where u.id=um.id_user and u.visible=1 and um.has_customer=1 and um.id_region='".$aUserCustomer['id_region']."' and um.is_main_manager_region=1 and um.id_customer_group='".Auth::$aUser['id_customer_group']."'");
			if (!$aManager) $aManager=Db::GetRow("select u.*,um.* from user_manager um,user u
				where u.id=um.id_user and u.visible=1 and um.has_customer=1 and um.id_region='".$aUserCustomer['id_region']."' and um.is_main_manager_region=1 ");
			if (!$aManager) $aManager=Db::GetRow("select u.*,um.* from user_manager um,user u
				where u.id=um.id_user and u.visible=1 and um.has_customer=1 and um.id_region='".$aUserCustomer['id_region']."'  ");
				
			$aUserCustomer['id_manager']=$aManager['id'];
			Db::Autoexecute('user_customer',$aUserCustomer);


			$sQuery="insert into user_account(id_user) values ('$sIdUser')";
			Db::Execute($sQuery);

			if ($bAutoCreate) return $sIdUser;

			$sLink="<A href='http://".SERVER_NAME."/?action=user_confirm_registration&signature=".$sSignature."'
				>".Base::$language->getMessage('Confirm')."</a>";
			$sUrl="http://".SERVER_NAME."/?action=user_confirm_registration&signature=".$sSignature;

			$aData=array(
			'info'=>array(
			'link'=>$sLink,
			'url'=>$sUrl,
			'login'=>Base::$aRequest['login'],
			'password'=>Base::$aRequest['password'],
			'email'=>Base::$aRequest['email'],
			),
			'aManager'=>$aManager
			);
			$aSmartyTemplate=String::GetSmartyTemplate('confirmation_letter', $aData);
			$sBody=$aSmartyTemplate['parsed_text'];

			Mail::AddDelayed(Base::$aRequest['email'],Base::$language->getMessage('Confirmation Letter'),$sBody,'','',true,2);

			$this->DoLogin();
		}
		else {
			Base::$sText.=Content::getTemplate('new_account_error_created');
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function ConfirmRegistration()
	{
		if (Base::$aRequest['signature']) {
			$sQuery="update user set approved=1 where signature='".Base::$aRequest['signature']."'";
			Db::Execute($sQuery);
			if (Base::$db->Affected_Rows()) {
				Base::$sText.=Language::GetText('approve_text');
				return;
			}
		}
		Base::$sText.=Language::GetText('approve_error');
	}
	//-----------------------------------------------------------------------------------------------
	public function RestorePassword()
	{
		if (Base::$aRequest['is_post'] && !$sError) {

			if (!Base::$aRequest['email'] && !Base::$aRequest['login']) $sError="Empty fields";

			if (Base::$aRequest['login']) $sWhere.=" and login='".Base::$aRequest['login']."'";
			if (Base::$aRequest['email']) $sWhere.=" and email='".Base::$aRequest['email']."'";

			$aUser=Db::GetRow("select * from user where 1=1 ".$sWhere);
			if (!$sError && $aUser['id']) {
				$aSmartyTemplate=String::GetSmartyTemplate('restore_password_sent', $aData);
				Base::$sText.=$aSmartyTemplate['parsed_text'];

				$sRestoreCode=md5(Base::GetConstant('global:project_name').$aUser['id'].$aUser['salt']);
				$sLink="<A href='http://".SERVER_NAME."/?action=user_new_password&id=".$aUser['id']."&restore_code=".$sRestoreCode."'
				>".Language::GetMessage('Create new password')."</a>";
				$sUrl="http://".SERVER_NAME."/?action=user_new_password&id=".$aUser['id']."&restore_code=".$sRestoreCode;

				$aData=array(
				'aUser'=>$aUser,
				'sLink'=>$sLink,
				'sUrl'=>$sUrl,
				);
				$aTemplate=String::GetSmartyTemplate('restore_password', $aData);
				$sBody=$aTemplate['parsed_text'];

				Mail::SendNow($aUser['email'],$aTemplate['name'],$sBody);

				return;
			}
			if (!$sError) $sError="There is no such a record in our user database.";
		}

		$aData=array(
		'sHeader'=>"method=post",
		'sTitle'=>"Forgot Password",
		'sContent'=>Base::$tpl->fetch('user/restore_password.tpl'),
		'sSubmitButton'=>'Send',
		'sSubmitAction'=>'user_restore_password',
		'sError'=>$sError,
		);
		$oForm=new Form($aData);

		Base::$sText.=$oForm->getForm();
	}
	//-----------------------------------------------------------------------------------------------
	public function NotifyConfirmedProfileFill($iIdUser)
	{
		$aCustomer=Db::GetRow(Base::GetSql('Customer',array('id'=>$iIdUser)));

		if (!$aCustomer) return;
		if ($aCustomer['profile_notified']) return;

		Message::CreateNotification($aCustomer['login'],'profile_fill_notification','customer');
		Message::AddNote($aCustomer['id'],Language::GetMessage('profile_fill_notification')
		,Content::GetTemplate('profile_fill_notification'));
		Db::Execute("update user_customer set profile_notified='1' where id_user='{$aCustomer['id']}'");

	}
	//-----------------------------------------------------------------------------------------------
	public function ChangePassword()
	{
		Auth::NeedAuth();
		if (Base::$aRequest['is_post']) {

			if (!Base::$aRequest['data']['new_password'] ||  !Base::$aRequest['data']['old_password']
			|| !Base::$aRequest['data']['retype_new_password'])
			$sError='Please fill out all fields';

			if (strlen(trim(Base::$aRequest['data']['new_password']))<=5 && !$sError)
			$sError='Password must more than 5 digits';

			if (Base::$aRequest['data']['new_password']!=Base::$aRequest['data']['retype_new_password'] && !$sError)
			$sError='Passwords are not the same';

			$aUser=Db::GetRow(Base::GetSql('User',array('login'=>Auth::$aUser['login'])));
			if ($aUser['password'] !=String::Md5Salt(trim(Base::$aRequest['data']['old_password']),$aUser['salt']) && !$sError)
			$sError='Please, check the old password';

			if (!$sError) {
				$sSalt=String::GenerateSalt();
				$aUserUpdate=array(
				'password'=>String::Md5Salt(Base::$aRequest['data']['new_password'],$sSalt),
				'salt'=>$sSalt,
				);
				Db::AutoExecute('user',$aUserUpdate,"UPDATE"," login='".Auth::$aUser['login']."'");
				$sError=Language::GetMessage('You have successfully changed your password');
			}
		}

		$aData=array(
		'sHeader'=>"method=post",
		'sTitle'=>"Change Password Form",
		'sWidth'=>" ",
		'sContent'=>Base::$tpl->fetch('user/form_change_password.tpl'),
		'sSubmitButton'=>'Update',
		'sSubmitAction'=>'user_change_password',
		'sReturnButton'=>'Return to profile',
		'sReturnAction'=>Auth::$aUser['type_'].'_profile',
		'sError'=>$sError,
		);
		$oForm=new Form($aData);
		Base::$sText.=$oForm->getForm();
	}
	//-----------------------------------------------------------------------------------------------
	public function ChangeLogin()
	{
		Auth::NeedAuth();

		if (!Customer::IsChangeableLogin(Auth::$aUser['login'])) return;

		if (Base::$aRequest['is_post']) {
			$sNewLogin = trim(Base::$aRequest['data']['new_login']);
			// check if not exist
			$aUser=Db::GetRow("select * from user where login='".$sNewLogin."'");
			if ($aUser){
				$sError=Language::GetMessage('This login already exist');
			}else {
				if (strlen($sNewLogin)==0 || (Auth::$aUser['login'] == $sNewLogin) ){
					$sError='Incorrect new login';
				}else {
					$aUser=Db::GetRow("select * from user where login='".Auth::$aUser['login']."'");
					if (!$sError) {
						//[----- UPDATE -----------------------------------------------------]
						Db::Execute("update user_customer set is_locked='1' where id_user='".Auth::$aUser['id']."'");
						$sQuery="update user set login='".$sNewLogin."' where id='".Auth::$aUser['id']."' ";
						if ($aUser['has_forum']){
							//require(SERVER_PATH.'/class/module/Forum.php');
							Forum::ChangeLogin($aUser, $sNewLogin);
						}

						//[----- END UPDATE -------------------------------------------------]
						$bResult = Db::Execute($sQuery);
						if ($bResult) {
							$sError=Language::GetMessage('You have successfully changed your login');
							Auth::NeedAuth();
						}
						else $sError=Language::GetMessage('Error during changed your login');
					}
				}
			}
		}
		Base::$tpl->assign('old_login',Auth::$aUser['login']);

		$aData=array(
		'sHeader'=>"method=post",
		'sTitle'=>"Change Login Form",
		'sWidth'=>" ",
		'sContent'=>Base::$tpl->fetch('user/form_change_login.tpl'),
		'sSubmitButton'=>'Update',
		'sSubmitAction'=>'user_change_login',
		'sReturnButton'=>'Return to profile',
		'sReturnAction'=>Auth::$aUser['type_'].'_profile',
		'sError'=>$sError,
		);
		$oForm=new Form($aData);
		Base::$sText.=$oForm->getForm();
	}
	//-----------------------------------------------------------------------------------------------
	public function NewPassword()
	{
		$aUser=Db::GetRow(Base::GetSql('User',array(
		'id'=>(Base::$aRequest['id'] ? Base::$aRequest['id']:'-1')
		)));
		$sRestoreCode=md5(Base::GetConstant('global:project_name').$aUser['id'].$aUser['salt']);

		if (!$aUser	|| Base::$aRequest['restore_code']!=$sRestoreCode) {
			Base::$sText.=Language::GetText('User not found or restore_code is incorrect error');
			return;
		}

		if (Base::$aRequest['is_post']) {

			if (!Base::$aRequest['data']['new_password'] || !Base::$aRequest['data']['retype_new_password'])
			$sError='Please fill out all fields';

			if (strlen(trim(Base::$aRequest['data']['new_password']))<=5 && !$sError)
			$sError='Password must more than 5 digits';

			if (Base::$aRequest['data']['new_password']!=Base::$aRequest['data']['retype_new_password'] && !$sError)
			$sError='Passwords are not the same';

			if (!$sError) {
				$sSalt=String::GenerateSalt();
				$aUserUpdate=array(
				'password'=>String::Md5Salt(Base::$aRequest['data']['new_password'],$sSalt),
				'salt'=>$sSalt,
				);
				Db::AutoExecute('user',$aUserUpdate,"UPDATE"," id='".$aUser['id']."'");
				$sError=Language::GetMessage('You have successfully changed your password. Letter is sent to your email');
				$aUser['new_password']=Base::$aRequest['data']['new_password'];

				$aData=array('aUser'=>$aUser);
				$aTemplate=String::GetSmartyTemplate('new_password_letter', $aData);
				$sBody=$aTemplate['parsed_text'];

				Mail::AddDelayed($aUser['email'],$aTemplate['name'],$sBody,'','',true,$aTemplate['priority']);

				Base::$sText.=Language::GetText("new password changed successfully");
				return;
			}
		}

		$aData=array(
		'sHeader'=>"method=post",
		'sTitle'=>"New password Form",
		'sWidth'=>" ",
		'sContent'=>Base::$tpl->fetch('user/form_new_password.tpl'),
		'sSubmitButton'=>'Set new password',
		'sSubmitAction'=>'user_new_password',
		'sError'=>$sError,
		);
		$oForm=new Form($aData);
		Base::$sText.=$oForm->getForm();
	}
	//-------------------------------------------------------------------------------------------------
	public function CheckLogin()
	{
		$bChecked=true;
		//if (!preg_match('/^[a-zA-Z0-9_]+$/',Base::$aRequest['login'])) $bChecked=false;
		Base::$aRequest['login']=preg_replace("/[^0-9]/", '',Base::$aRequest['login']);

		if ($bChecked) {
			$aUser=Db::GetRow("select * from user where login='".Base::$aRequest['login']."'");
			if ($aUser) $bChecked=false;
		}

		Base::$tpl->assign('bChecked',$bChecked);
		Base::$oResponse->addAssign('check_login_image_id','innerHTML',Base::$tpl->fetch("user/check_login_image.tpl"));
	}
	//-------------------------------------------------------------------------------------------------
	public function ChangeLevelPrice()
	{
		$sUrl = '/';
		if (Base::$aRequest['uri'])
			$sUrl = Base::$aRequest['uri'];
		
		$sMessage="?aMessage[MI_NOTICE]=Level price updated";
		
		if (Base::$aRequest['type_price']) {
			Db::Execute("Update user_manager set type_price='".Base::$aRequest['type_price']."' where id_user=".Auth::$aUser['id_user']);
			// check user
			if (Base::$aRequest['type_price'] == 'user' && Base::$aRequest['data']['id_type_price_user']) {
				$aCustomer=Db::GetRow(Base::GetSql('Customer',array('id'=>Base::$aRequest['data']['id_type_price_user'])));
				if (!$aCustomer)
					$aMessage = "?aMessage[MI_NOTICE]=Incorrect selected user";
				else 
					Db::Execute("Update user_manager set id_type_price_user = ".$aCustomer['id_user']." where id_user=".Auth::$aUser['id_user']);
			}	
			elseif (Base::$aRequest['type_price'] == 'group' && Base::$aRequest['data']['id_type_price_group']) {
				$aGroup=Db::GetRow(Base::GetSql('CustomerGroup',array('id'=>Base::$aRequest['data']['id_type_price_group'])));
				if (!$aGroup || $aGroup['visible'] == 0)
					$aMessage = "?aMessage[MI_NOTICE]=Incorrect selected group";
				else 
					Db::Execute("Update user_manager set id_type_price_group = ".$aGroup['id']." where id_user=".Auth::$aUser['id_user']);
			}
			Auth::IsAuth(); // rescan user
			$this->RecalcCart(Auth::$aUser['id_user']);
		}
		else 
			Base::Redirect($sUrl);

		Base::Redirect($sUrl.$sMessage);
	}
	//-------------------------------------------------------------------------------------------------
	// $iIdUserNotManager - 1 use if manager create order for selected user
	public function RecalcCart($iIdUser,$iIdUserNotManager = 0) {
		if ($iIdUserNotManager){
			$aCart = Db::GetAll("Select * from cart where id_user=".Auth::$aUser['id_user']." and type_='cart'");
			$aUser = Base::$db->GetRow( Base::GetSql('Customer',array('id'=>$iIdUser)));
		}
		else {
			$aCart = Db::GetAll("Select * from cart where id_user=".$iIdUser." and type_='cart'");
			$aUser = Auth::$aUser; 
		}
		if ($aCart) {
			$aItemCode = array();
			foreach($aCart as $aValue) {
				$aItemCode[] = $aValue['id_product'];
			}
			$aPrice = array();
			if (count($aItemCode) > 0) 
				$aPrice=Db::GetAll(Base::GetSql("EcProductVidRegion",array(
				    'id_products'=>"'".implode("','", $aItemCode)."'",
				    'id_region'=>$oCatalog->iIdRegion
				)));
			foreach($aCart as $aValue) {
				$iFound=0;
				foreach($aPrice as $aPriceValue) {
					if ($aPriceValue['id_product'] == $aValue['id_product']) {
						$iFound = 1;
						if ($aPriceValue['price'] != $aValue['price'])
							Db::Execute("Update cart set price = '".Currency::GetPriceWithoutSymbol($aPriceValue['price'])."' where id = ".$aValue['id']);
					}
				}
				if ($iFound == 0)
					Db::Execute("Delete from cart where id=".$aValue['id']);
			}
		}
	}
}
?>