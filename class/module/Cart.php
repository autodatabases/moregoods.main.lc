<?

/**
 * @author Mikhail Starovoyt
 * @author Roman Dehtyarov
 * @version 4.5.3
 */

class Cart extends Base
{
	public $sExportSql;
	var $iIdRegion;
	//-----------------------------------------------------------------------------------------------
	public function __construct($bNeedAuth=true)
	{
		Repository::InitDatabase('cart');

/*		$oCpacha= new Capcha();
		Base::$tpl->assign('sCapcha',$oCpacha->GetMathematic('contact_form/mathematic.tpl'));
*/
		
		
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
//log add to cart		
		if (Base::$aRequest['action']=='cart_add_cart_item' &&  Auth::IsAuth()
		&& Base::$aRequest['xajax']) 
		{
				Cart::LogCart();
		}
		
		if (Base::$aRequest['action']=='cart_add_cart_item' &&  !Auth::IsAuth()
		&& Base::$aRequest['xajax']) {
			$aRegisteredUser=Auth::AutoCreateUser();
			Auth::Login($aRegisteredUser['login'],$aRegisteredUser['password_temp'],false,true,
			Base::GetConstant('user:is_salt_password',1));
		}
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


		if (Auth::$aUser['type_']!='manager' && $bNeedAuth) Auth::NeedAuth('customer');
		Base::$aData['template']['bWidthLimit']=true;
		Base::$bXajaxPresent=true;

		$oContent = new Content();//For template assign hack

		Resource::Get()->Add('/css/cart_path.css',2);
		//Resource::Get()->Add('/css/new.css');
		$check=Customer::IsChangeableLogin(Auth::$aUser['login']);
	}
	//-----------------------------------------------------------------------------------------------
	public static function LogCart()
	{
		if (Base::$aRequest['xajaxr'])
			$sQuery="insert into log_visit (id_user,post,url,referer,ip)
			values('".Auth::$aUser['id']."',UNIX_TIMESTAMP(),'".mysql_real_escape_string(Base::$aRequest['xajaxargs'][0])."'
				,'".mysql_real_escape_string(Base::$aRequest['xajaxargs'][0])."' 
				,'".Auth::GetIp()."')";
		else
			$sQuery="insert into log_visit (id_user,post,url,referer,ip)
			values('".Auth::$aUser['id']."',UNIX_TIMESTAMP(),'".mysql_real_escape_string($_SERVER['QUERY_STRING'])."'
				,'".mysql_real_escape_string($_SERVER['HTTP_REFERER'])."'
				,'".Auth::GetIp()."')";
		Base::$db->Execute($sQuery);
	}

	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		$this->CartList();
	}
	//-----------------------------------------------------------------------------------------------
	public function CartList()
	{
		Base::$aTopPageTemplate=array('panel/tab_customer_cart.tpl'=>'cart');
		Base::$tpl->assign_by_ref("oCatalog", new Catalog());

		if (Base::$aRequest['is_post']) {
			if (Base::$aRequest['number']<=0) {
				Form::ShowError("Please, fill the required fields");
				Base::$aRequest['action']='cart_cart_edit';
				Base::$tpl->assign('aData',Base::$aRequest);
			}
			else {
				//[----- UPDATE -----------------------------------------------------]
				$sQuery="update cart set
								number='".Base::$aRequest['number']."',
								customer_comment='".Base::$aRequest['customer_comment']."',
								customer_id='".Base::$aRequest['customer_id']."'
		                        		where id='".Base::$aRequest['id']."'  and type_='cart' ".Auth::$sWhere;
				//[----- END UPDATE -------------------------------------------------]
				Base::$db->Execute($sQuery);
				//Form::AfterReturn('cart_cart');
				Base::Redirect('/pages/cart_cart/');
			}
		}

		if (Base::$aRequest['action']=='cart_cart_edit') {
			Form::BeforeReturn('cart_cart','cart_cart_edit');

			if (Base::$aRequest['action']=='cart_cart_edit') {
				$aUserCart=Db::GetRow("select * from cart where id='".Base::$aRequest['id']."'
							and type_='cart' ".Auth::$sWhere);
				Base::$tpl->assign('aData',$aUserCart);
			}

			$aData=array(
			'sHeader'=>"method=post",
			'sTitle'=>"Cart item",
			'sContent'=>Base::$tpl->fetch('cart/form_cart.tpl'),
			'sSubmitButton'=>'Apply',
			'sSubmitAction'=>'cart_cart',
			'sReturnButton'=>'<< Return',
			'sReturnAction'=>'cart_cart',
			'sError'=>$sError,
			);
			$oForm=new Form($aData);

			Base::$sText.=$oForm->getForm();
			return;
		}

		if (Base::$aRequest['action']=='cart_cart_delete') {
			//Form::BeforeReturn('cart_cart','cart_cart_delete');
			if (Base::$aRequest['row_check']) {
				Base::$db->Execute("delete from cart where id in (".implode(',',Base::$aRequest['row_check']).")
					and type_='cart'
					".Auth::$sWhere);
			}
			else {
				Base::$db->Execute("delete from cart where id='".Base::$aRequest['id']."'
					and type_='cart'
					".Auth::$sWhere);
			}
			//Form::AfterReturn('cart_cart');
			if(Base::$aRequest['xajax']){
			    $oContent=new Content();
			    $oContent->ParseTemplate(true);
			}else
			 Base::Redirect('/pages/cart_cart');
		}

		if (Base::$aRequest ['action'] == 'cart_cart_clear') {
			Base::$db->Execute ( "delete from cart where 1=1
					and type_='cart'
					" . Auth::$sWhere );

			//Form::AfterReturn('cart_cart');
			Base::Redirect ( '/pages/cart_cart/' );
		}

/*				//02.01.2017   выключаем добавление товара в заказ со статусом new		
		if(Auth::$aUser['type_']=='manager') {			//02.01.2017
		    $aOrders=Db::GetAssoc("select id,id as order_id from cart_package where order_status='new' ".Auth::$sWhere);			//30.12.2016
		    if($aOrders) {
    		    Base::$tpl->assign('bAllowEditOrder',1);		
    		    Base::$tpl->assign('aOrderAvailable',array(''=>'')+$aOrders);
		    }
		}
*/
		$oTable=new Table();

		$oTable->sClass.=" cart-table";

		// get list expired history positions
		$aExpiredCount = $this->CartExpiredCountPositions();
		if ($aExpiredCount > 0) {
			$oTable->sTableMessage=Language::GetText("exist_expired_cart");
			Base::$tpl->assign('sTableMessageClass','warning_p');
		}

		$sWhere.=" and c.id_user=".Auth::$aUser['id'];
		$oTable->sSql=Base::GetSql("Part/Search",array(
		"type_"=>'cart',
		"where"=>$sWhere,
		));

		$oTable->aOrdered="order by c.post_date asc";
		$oTable->iRowPerPage=100;
		$oTable->aColumn=array(
		'code'=>array('sTitle'=>'CartCode', 'sClass'=>'cell-code'),
		'id_product'=>array('sTitle'=>'ID', 'sClass'=>'cell-id_product'),
		'name'=>array('sTitle'=>'Name/Customer_Id', 'sClass'=>'cell-name'),
		'term'=>array('sTitle'=>'Cart Date', 'sClass'=>'cell-date'),
		'number'=>array('sTitle'=>'Number', 'sClass'=>'cell-number'),
		'weight'=>array('sTitle'=>'Weight', 'sClass'=>'cell-weight'),
		'price'=>array('sTitle'=>'Price', 'sClass'=>'cell-price'),
		'total'=>array('sTitle'=>'Total', 'sClass'=>'cell-total'),
		'action'=>array('sClass'=>'cell-action'),
		);
		$oTable->sDataTemplate='cart/row_cart.tpl';
		$oTable->sButtonTemplate='cart/button_cart.tpl';
		$oTable->sSubtotalTemplate='cart/subtotal_cart.tpl';
		$oTable->bCheckVisible=false;
		$oTable->bStepperVisible=false;
		$oTable->aCallback=array($this,'CallParseCart');
		$oTable->sTemplateName = 'index_include/cart_cart_table.tpl';

		Base::$sText.=$oTable->getTable("Cart Items");
		Base::$tpl->assign('aData',$aData);

		$_SESSION['cart']['table_sql']=$oTable->sTableSql;
		//if(Auth::$aUser['type_']!='manager')
		//Base::$sText.=Home::GetPopularProducts();
	}
	//-----------------------------------------------------------------------------------------------
	public function AssignDeliveryMethods($isAssoc=false)
	{
			$aData=array(
				'table'=>'delivery_type',
				'where'=>" and t.visible=1 order by t.num desc",
		);
		if ($isAssoc)
			$aDeliveryType=Language::GetLocalizedAll($aData,false,'id,name,');
		else
			$aDeliveryType=Language::GetLocalizedAll($aData);
		Base::$tpl->assign('aDeliveryType',$aDeliveryType);
		//Base::$tpl->assign('aDeliveryType',Db::GetAll(Base::GetSql('DeliveryType',array('visible'=>1))));
		/*$aDeliveryTypeRow=Db::GetRow(Base::GetSql('DeliveryType',array(
		'id'=>$_SESSION['current_cart']['id_delivery_type'],
		'visible'=>1,
		)));
		Base::$tpl->assign('aDeliveryTypeRow',$aDeliveryTypeRow);*/
		return $aDeliveryType;
	}
	//-----------------------------------------------------------------------------------------------
	public function CartOnePageOrder()
	{
		if (Auth::IsAuth()) Cart::LogCart();
		if (Auth::$aUser['type_']=='manager') Base::Redirect('/?action=cart_onepage_order_manager');
		if(Base::$aRequest['data']['order_by_phone']) {
			$this->OrderByPhone();
			return true;
		}
		//if (Auth::$aUser['type_']=='manager') Base::Redirect('/?action=cart_select_account');
		Resource::Get()->Add('/single/language_js.php');
		$sCheckLoggedError=false;
		$sCheckNewAccountError=false;
		if(Base::$aRequest['capcha_error']){
//			$sCheckLoggedError=true;
			$sCheckLoggedError='Помилка при перевірці від спам ботів(капча). Порахуйте правильно і запишіть число!!!';//Base::$aRequest['capcha_error'];
		}
		/* hack for fixing back button on end step */
		$_SESSION['is_checked_account']=true;
		$_SESSION['current_cart']['is_confirmed']=0;
		if (!$_SESSION['current_cart']['id_delivery_type']) $_SESSION['current_cart']['id_delivery_type']=1;

		$_REQUEST['user_phone']=$_SESSION['user_phone'];
		$_REQUEST['user_name']=$_SESSION['user_name'];
		$_REQUEST['user_email']=$_SESSION['user_email'];
		$_REQUEST['user_comment']=$_SESSION['user_comment'];
		
		
		//подготовка popup
		Base::$aMessageJavascript = array(
		"MakeAuto_select"=> Language::GetMessage("Choose model"),
		"DetailAuto_select"=> Language::GetMessage("Choose year"),
		"add_auto_error"=>Language::GetMessage("error_add_auto"),
		"add_auto_17symbol"=> Language::GetMessage("vin_have_no_17_symbols"),
		"add_auto_model_empty"=> Language::GetMessage("model_and_series_empty"),
		"add_auto_volume_empty"=> Language::GetMessage("volume_empty"),
		);
		Base::$sText.=Base::$tpl->fetch('cart/popup.tpl');

		$aRegionList=Db::GetAssoc("select id, name from ec_region order by name");
		Base::$tpl->assign('aRegionList',$aRegionList);

		$aTime = Db::GetAll("select * from ec_time");
		Base::$tpl->assign('aTime',$aTime);

		$aAdress=Db::GetAll("select * from ec_addres where id_user='".Auth::$aUser['id']."' ");
		Base::$tpl->assign('aAdress',$aAdress);

		if (Base::$aRequest['is_post']) {
			$_SESSION['current_cart_package']['id_addres']=Base::$aRequest['id_addres'];
			$_SESSION['current_cart_package']['name_manager']=Base::$aRequest['login'];				//29.12.2016
			$_SESSION['current_cart_package']['customer_comment']=Base::$aRequest['customer_comment'];				//29.12.2016
			$_SESSION['current_cart']['id_time']==Base::$aRequest['id_time'];	

			if($_SESSION['current_cart']['id_delivery_type']==6){
				$_SESSION['current_cart_package']['date_delivery']= null;
			}else{
				$_SESSION['current_cart_package']['date_delivery']=date("Y-m-d H:i:s",strtotime(Base::$aRequest['date_delivery']));	
			}			//29.12.2016

			if(Auth::$aUser['customer_group_name'] !='PERSONAL' && !$_SESSION['current_cart']['id_delivery_type']){
				$_SESSION['current_cart']['id_delivery_type']= 5;
			}

			//$_SESSION['current_cart_package']['time']=Base::$aRequest['time'];	
			$_SESSION['current_cart']['id_time']=Base::$aRequest['id_time'];	

			if (Base::$aRequest['subaction']=='create_new_account'){
			    Base::$aRequest['login']=preg_replace("/[^0-9]/", '', Base::$aRequest['data']['phone']);
			    $_REQUEST['login']=Base::$aRequest['login'];
			    $_POST['login']=Base::$aRequest['login'];
			    Base::$aRequest['data']['login']=Base::$aRequest['login'];
				$sCheckNewAccountError=$this->NewAccountError();
				if (!Base::$aRequest['data']['name'] || !Base::$aRequest['data']['city']
				|| !Base::$aRequest['data']['address'] || !Base::$aRequest['data']['phone']
				|| $sCheckNewAccountError
				) {
					if ($sCheckNewAccountError) {
						$sError=$sCheckNewAccountError;
					} else {
						$sError="Please, fill the required fields";
					}
					Base::$tpl->assign('aUser',Base::$aRequest['data']);
				}
				else {
					$aRequestUser=String::FilterRequestData(Base::$aRequest['data'],array('login','password','email'));
					$sSalt=String::GenerateSalt();
					$aRequestUser['password']=String::Md5Salt($aRequestUser['password'],$sSalt);
					$aRequestUser['salt']=$sSalt;
					$aRequestUser['password_temp']='';
					Db::Autoexecute('user',$aRequestUser,'UPDATE',"id='".Auth::$aUser['id']."'");

					$aRequestUserCustomer=String::FilterRequestData(Base::$aRequest['data'],array(
					'name','country','city','zip','company','address','phone','remark','id_region'
					));
					Db::Autoexecute('user_customer',$aRequestUserCustomer,'UPDATE',"id_user='".Auth::$aUser['id']."'");

					$aCartPackageUpdate['customer_comment']=Base::$aRequest['data']['customer_comment'];//$aRequestUserCustomer['remark'];
					$aCartPackageUpdate['name_manager']=Base::$aRequest['login'];				//28.12.2016
					$aCartPackageUpdate['date_delivery']=date("Y-m-d H:i:s",strtotime(Base::$aRequest['date_delivery']));				//29.12.2016
					Db::AutoExecute('cart_package',$aCartPackageUpdate,'UPDATE'
					," id='".$_SESSION['current_cart_package']['id']."' ".Auth::$sWhere);

					$aPaymentType=Db::GetRow(Base::GetSql('PaymentType',array('id'=>Base::$aRequest['data']['id_payment_type'])));
					Base::Redirect("/?action=cart_payment_end&data[id_payment_type]=".$aPaymentType['id']);
					//CART::PAYMENTEND
				}

			}
			if (Base::$aRequest['subaction']=='check_logged') {
				if (!Base::$aRequest['data']['old_login'] || !Base::$aRequest['data']['old_password'])
				$sCheckLoggedError="Please, enter all the fields";
				else {
//				    Base::$aRequest['data']['old_login']=preg_replace("/[^0-9]/", '',Base::$aRequest['data']['old_login']);

					$aOldUser=Auth::IsUser(Base::$aRequest['data']['old_login'], Base::$aRequest['data']['old_password']
					,false,Base::GetConstant('user:is_salt_password',1));
					if ($aOldUser) {
						//Syncronization
//02.01.2017
//в корзине надо проставить цены региона и группы контрагентов к которой относится выбранный логин

//type пользователя
		$sUserTypeSql="select type_ from user uc where uc.id='".$aOldUser['id']."'";
		$aUserType=Db::GetAll($sUserTypeSql);
		
		if (!$aUserType['type_']=='manager')
		$sUserCartSql="select c.id,pr.price 
			from cart c
			inner join ec_price pr on pr.id_product=c.id_product 
			inner join user_customer uc on uc.id_customer_group=pr.id_customer_group and uc.id_region=pr.id_region and uc.id_user='".$aOldUser['id']."'
			where type_='cart'and c.id_user='".Auth::$aUser['id']."'";
		else
		$sUserCartSql="select c.id,pr.price 
			from cart c
			inner join ec_price pr on pr.id_product=c.id_product 
			inner join user_manager um on um.id_customer_group=pr.id_customer_group and um.id_region=pr.id_region and um.id_user='".$aOldUser['id']."'
			where type_='cart'and c.id_user='".Auth::$aUser['id']."'";

// надо учесть проводимые акции!!!
			
		$aUserCart=Db::GetAll($sUserCartSql);
		if ($aUserCart) foreach ($aUserCart as $iKey => $aValue) {
			Db::Execute("update cart set price='".$aValue['price']."' where id='".$aValue['id']."'");
		}

//забираем корзину под выбранный логин
						Db::Execute("update cart set id_user='".$aOldUser['id']."' where id_user='".Auth::$aUser['id']."'");
						Db::Execute("update cart_package set id_user='".$aOldUser['id']."' where id_user='".Auth::$aUser['id']."'");
//выключаем временный логин
						Db::Execute("update user set visible='0' where id='".Auth::$aUser['id']."'");

						Auth::Login(Base::$aRequest['data']['old_login'], Base::$aRequest['data']['old_password'],false,true
						,Base::GetConstant('user:is_salt_password',1));
//после регистрации делаем переход в корзину
						Base::Redirect("/?action=cart_cart");
//						Base::Redirect("/?action=cart_onepage_order");
					}
					else
					{
						Base::$tpl->assign('bFromCheckLogged', true);
						$sCheckLoggedError="No user with such login and password";
					}
				}
			}
			if (Base::$aRequest['subaction']=='check_authorized_user') {
				if ( (($_SESSION['current_cart']['price_delivery'] > 0) && (!Base::$aRequest['data']['name']
				|| !Base::$aRequest['data']['city'] || !Base::$aRequest['data']['address'] || !Base::$aRequest['data']['phone'])
				|| (Base::$aRequest['data']['check_order'] == 1 && Base::$aRequest['data']['check_order'] == 0))

				|| (($_SESSION['current_cart']['price_delivery'] == 0) && (!Base::$aRequest['data']['name']
				|| !Base::$aRequest['data']['phone'])
				|| (Base::$aRequest['data']['check_order'] == 1 && Base::$aRequest['data']['own_auto_id'] == 0)) ) {		//проверка - всели заполнено на этапе оформления заказа!!!
					$sError="Please, fill the required fields";
					Base::$tpl->assign('aUser',Base::$aRequest['data']);
				}
				else {
					$aRequestUserCustomer=String::FilterRequestData(Base::$aRequest['data'],array(
					'name','country','city','zip','company','address','phone', 'remark','id_region'
					));
					//Debug::PrintPre($aRequestUserCustomer);
					$_SESSION['current_cart_package']['customer_comment']=Base::$aRequest['data']['customer_comment'];//Base::$aRequest['data']['remark'];	//28.12.2016
					$_SESSION['current_cart']['is_need_check'] = 0;
					$_SESSION['current_cart_package']['novaposta']=Base::$aRequest['novaposta'];
					if (isset(Base::$aRequest['check_order']))
						$_SESSION['current_cart']['is_need_check'] = Base::$aRequest['check_order'];

					$_SESSION['current_cart']['own_auto_id'] = 0;
					if (isset(Base::$aRequest['own_auto_id']))
						$_SESSION['current_cart']['own_auto_id'] = Base::$aRequest['own_auto_id'];

//					Db::Autoexecute('user_customer',$aRequestUserCustomer,'UPDATE',"id_user='".Auth::$aUser['id']."'");		//выключить обновление параметров юзера

					//Base::Redirect("/?action=cart_payment_method");
					$aPaymentType=Db::GetRow(Base::GetSql('PaymentType',array('id'=>Base::$aRequest['data']['id_payment_type'])));
					Base::Redirect("/?action=cart_payment_end&data[id_payment_type]=".$aPaymentType['id']);
				}
			}
		}


		//order table section


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

		
		//Добавление методов доставки в шаблон
		$this->AssignDeliveryMethods();
		$_SESSION['current_cart']['id_delivery_type']='';
		$_SESSION['current_cart']['price_delivery']='';
		
		Base::$tpl->assign('dSubtotal',$dSubtotal);
		Base::$tpl->assign('dTotal',$dSubtotal+Currency::PrintPrice($_SESSION['current_cart']['price_delivery']));
		Base::$tpl->assign('iDostavka',Currency::PrintPrice($_SESSION['current_cart']['price_delivery']));
	

		Base::$tpl->assign('aPaymentType',Db::GetAll(Base::GetSql('PaymentType',array(
		'where'=>' and pt.visible=1',
		'order'=>' order by pt.num',
		))));

		//select auto section
		$iCountAuto = Db::GetOne("Select count(*) from user_auto where id_user=".Auth::$aUser['id']);
		Base::$tpl->assign('iCountAuto',$iCountAuto);
		Base::$tpl->assign('error_field_auto',Language::GetMessage('Your set check order. Please fill field auto.'));
		if (Customer::IsChangeableLogin(Auth::$aUser['login']))
		{
			$aData=array(
			'sWidth'=>" ",
			'sHeader'=>"method=post",
			'sContent'=>Base::$tpl->fetch('cart/cart_onepage_check_new_user.tpl'),
			//'sSubmitButton'=>'Create and process',
			'sSubmitAction'=>'cart_onepage_order',
			'sClass'=>'testForm',
			'sError'=>$sError,
			'sHidden'=>" <input type=hidden name=subaction value='create_new_account' />",
			);
			$oForm=new Form($aData);
			Base::$tpl->assign('sCheckNewAccountForm',$oForm->getForm());

			$aData=array(
			'sWidth'=>" ",
			'sHeader'=>"method=post",
			'sContent'=>Base::$tpl->fetch('cart/form_check_logged.tpl'),
			//'sSubmitButton'=>'Login and process',
			'sSubmitAction'=>'cart_onepage_order',
			'sError'=>$sCheckLoggedError,
			'sHidden'=>" <input type=hidden name=subaction value='check_logged' />",
			);
			$oForm=new Form($aData);
			Base::$tpl->assign('sCheckLoggedForm',$oForm->getForm());
		}
		else
		{
			Base::$tpl->assign('aUser',Auth::$aUser);
			$iTime = time();
			$sTime = date("Y-m-d H:i:s", $iTime);
//			date_add($sTime,date_interval_create_from_date_string("2 days"));

			$aData=array(
			'sWidth'=>" ",
			'sHeader'=>"method=post",
			'sDateDelivery'=>$sTime,
			'sContent'=>Base::$tpl->fetch('cart/cart_onepage_shipment_detail.tpl'),
			//'sSubmitButton'=>'Update and pay',
			//'sSubmitButton'=>'Save and process',
			'sSubmitAction'=>'cart_onepage_order',
			'sError'=>$sCheckLoggedError,
			    'sClass'=>'loggedForm',
			'sHidden'=>" <input type=hidden name=subaction value='check_authorized_user' />",
			);
			$oForm=new Form($aData);
			Base::$tpl->assign('sCheckNewAccountForm',$oForm->getForm());
		}

		Base::$sText.=Base::$tpl->fetch("cart/cart_onepage_order.tpl");
		//if(Auth::$aUser['type_']!='manager')
		//Base::$sText.=Home::GetPopularProducts();
	}
	//-----------------------------------------------------------------------------------------------
	public function CartOnePageOrderManager()
	{
		if (Auth::$aUser['type_']!='manager') Base::Redirect('/?action=cart_check_account');
		Resource::Get()->Add('/js/jquery.searchabledropdown-1.0.8.min.js');
		Resource::Get()->Add('/single/language_js.php');
		$aTime = Db::GetAll("select * from ec_time");
		Base::$tpl->assign('aTime',$aTime);
		$_SESSION['current_cart']['is_confirmed']=0;

		if ($_SESSION['id_list'] && $_SESSION['id_list']!=0){
		$sJoin=" inner join ec_list_of_users_d lud on lud.id_user=uc.id_user ";
		$sWhere="and lud.id_list_of_users_h='".$_SESSION['id_list']."' ";
		}

		/*Base::$tpl->assign('aLogin',array(-1=>'')+Db::GetAssoc(Base::GetSql("Assoc/UserCustomer",
		array('where'=>" and uc.id_manager='".Auth::$aUser['id_user']."'")).' order by u.login'));*/
		Base::$tpl->assign('aName',array(-1=>'')+Db::GetAssoc("select u.id as id, concat(uc.name,' ( ',u.login,' )',
				IF(uc.phone is null or uc.phone='','',concat(' ".
		Language::getMessage('tel.')." ',uc.phone))) name
		from user as u
		inner join user_customer as uc on u.id=uc.id_user
		".$sJoin."
		where u.visible=1 and uc.name is not null and trim(uc.name)!=''
		    and uc.id_region ='".$this->iIdRegion."'
		".$sWhere."
		order by uc.name"));
		/*and uc.id_manager='".Auth::$aUser['id_user']."'*/

		$sCheckLoggedError=false;
		$sCheckNewAccountError=false;

		$aRegionList=Db::GetAssoc("select id, name from ec_region order by name");
		Base::$tpl->assign('aRegionList',$aRegionList);

		if (Base::$aRequest['is_post']) {
		    $_SESSION['current_cart_package']['id_addres']=Base::$aRequest['id_addres'];
			$_SESSION['current_cart_package']['name_manager']=Auth::$aUser['login'];				//29.12.2016
			$_SESSION['current_cart_package']['customer_comment']=Base::$aRequest['data']['customer_comment'];				//29.12.2016
			$_SESSION['current_cart_package']['date_delivery']=date("Y-m-d",strtotime(Base::$aRequest['date_delivery']));				//29.12.2016
			//$_SESSION['current_cart_package']['time']=Base::$aRequest['time'];
			$_SESSION['current_cart']['id_time']=Base::$aRequest['id_time'];		
			$_SESSION['current_cart_package']['novaposta']=Base::$aRequest['novaposta'];
			$_SESSION['current_cart_package']['bonus']=Base::$aRequest['bonus'];
			if (Base::$aRequest['subaction']=='create_new_account'){
			    Base::$aRequest['data']['login']=preg_replace("/[^0-9]/", '',Base::$aRequest['data']['phone']);
			    Base::$aRequest['login']=preg_replace("/[^0-9]/", '',Base::$aRequest['data']['phone']);
				$sCheckNewAccountError=$this->NewAccountManagerError();
				if (!Base::$aRequest['data']['name'] || !Base::$aRequest['data']['phone']
				|| $sCheckNewAccountError
				) {
					if ($sCheckNewAccountError) {
						$sError=$sCheckNewAccountError;
					} else {
						$sError="Please, fill the required fields";
					}
					Base::$tpl->assign('aUser',Base::$aRequest['data']);
				}
				else {
					$aRequestUser=String::FilterRequestData(Base::$aRequest['data'],array('login','password','email'));
					Base::$aRequest['login']=$aRequestUser['login'];
					Base::$aRequest['password']=$aRequestUser['password'];
					Base::$aRequest['email']=$aRequestUser['email'];

					$_SESSION['current_cart_package']['new_user']=User::DoNewAccount(true);

					// recalc cart
					User::RecalcCart($_SESSION['current_cart_package']['new_user'],1);

					$aPaymentType=Db::GetRow(Base::GetSql('PaymentType',array('id'=>Base::$aRequest['data']['id_payment_type'])));
					Base::Redirect("/?action=cart_payment_end&data[id_payment_type]=".$aPaymentType['id']);
				}

			}
			if (Base::$aRequest['subaction']=='select_account') {
				$bOk=(Base::$aRequest['data']['old_login']>0 || Base::$aRequest['data']['old_name']>0);
				if(Base::$aRequest['data']['old_login']>0 && Base::$aRequest['data']['old_name']>0
				&& Base::$aRequest['data']['old_login']!=Base::$aRequest['data']['old_name']) $bOk=FALSE;
				if ($bOk)
				{
					if ($aOldUser) {
						//Syncronization
						//Db::Execute("update cart set id_user='".$aOldUser['id']."' where id_user='".Auth::$aUser['id']."'");
						//Db::Execute("update cart_package set id_user='".$aOldUser['id']."' where id_user='".Auth::$aUser['id']."'");
						//Db::Execute("update user set visible='0' where id='".Auth::$aUser['id']."'");

						//if(Auth::IsAuth()) Cart::RefreshCartPackage(Auth::$aUser['id']);
						Base::Redirect("/?action=cart_shipment_detail");
					}
					if(Base::$aRequest['data']['old_login']>0)$_SESSION['current_cart_package']['new_user']=Base::$aRequest['data']['old_login'];
					else $_SESSION['current_cart_package']['new_user']=Base::$aRequest['data']['old_name'];
					Cart::RecalcCartUser(Auth::$aUser['id_user'],$_SESSION['current_cart_package']['new_user']);

					$aPaymentType=Db::GetRow(Base::GetSql('PaymentType',array('id'=>Base::$aRequest['data']['id_payment_type'])));
					Base::Redirect("/?action=cart_payment_end&data[id_payment_type]=".$aPaymentType['id']);
				}else
				$sCheckLoggedError="Please, enter all the fields";
			}
		}

		$aDeliveryType=Db::GetRow(Base::GetSql('DeliveryType'));
		if ($aDeliveryType) {
		    $_SESSION['current_cart']['id_delivery_type']=$aDeliveryType['id'];
		    $_SESSION['current_cart']['price_delivery']=$aDeliveryType['price'];
		}

		$_SESSION['is_checked_account']=true;
		if(!Base::$aRequest['data']['login']) $_REQUEST['data']['login']='m'.Auth::GenerateLogin();
		if(!Base::$aRequest['data']['password']) $_REQUEST['data']['password']=Auth::GeneratePassword();
		if(!Base::$aRequest['data']['verify_password']) $_REQUEST['data']['verify_password']=$_REQUEST['data']['password'];

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

		Db::Execute("insert into ec_saleh (id_customer ,summa_all) values('".Auth::$aUser['id']."',
			'".-$_SESSION['current_cart']['bonus']."')");
		
		//Добавление методов доставки в шаблон
		$this->AssignDeliveryMethods();

		//Добавление методов оплаты в шаблон
		Base::$tpl->assign('aPaymentType',Db::GetAll(Base::GetSql('PaymentType',array(
		'where'=>' and pt.visible=1',
		'order'=>' order by pt.num',
		))));

		Base::$tpl->assign('dSubtotal',$dSubtotal);
		Base::$tpl->assign('dTotal',$dSubtotal+Currency::PrintPrice($_SESSION['current_cart']['price_delivery']));

	    $aList=Db::GetAssoc("select 0 as id_list, '' as name
			union all
			select id as id_list,name
            from ec_list_of_users_h where id_manager='".Auth::$aUser['id_user']."'");
		Base::$tpl->assign('aList',$aList);

/*
		$aData=array(
		'sWidth'=>"450px;",
		'sHeader'=>"method=post",
		'sTitle'=>"Create New account",
		'sContent'=>Base::$tpl->fetch('cart/cart_onepage_select_new_account.tpl'),
		'sSubmitButton'=>'Create and process',
		'sSubmitAction'=>'cart_onepage_order_manager',
		'sError'=>$sError,
		'sHidden'=>" <input type=hidden name=subaction value='create_new_account' />",
		);
		$oForm=new Form($aData);
		Base::$tpl->assign('sCheckNewAccountForm',$oForm->getForm());
*/
		$aData=array(
		'sWidth'=>" ",
		'sHeader'=>"method=post",
//		'sTitle'=>"Select account",
		'sContent'=>Base::$tpl->fetch('cart/cart_onepage_select_account.tpl'),
		'sSubmitButton'=>'process',
		'sSubmitAction'=>'cart_onepage_order_manager',
		'sError'=>$sCheckLoggedError,
		'sHidden'=>" <input type=hidden name=subaction value='select_account' />",
		);
		$oForm=new Form($aData);
		Base::$tpl->assign('sCheckLoggedForm',$oForm->getForm());


		Base::$sText.=Base::$tpl->fetch("cart/cart_onepage_order.tpl");
		//if(Auth::$aUser['type_']!='manager')
		//Base::$sText.=Home::GetPopularProducts();
	}
	//-----------------------------------------------------------------------------------------------
	public function CartPrint()
	{
		if (Auth::IsAuth()) Cart::LogCart();
		$aCart=Db::GetAll("select * from cart where type_='cart' ".Auth::$sWhere." order by post_date desc");
		if (!$aCart) Base::Redirect('?action=cart_cart&table_error=cart_not_found');

		Base::$tpl->assign('aCart',$aCart);
		Base::$tpl->assign('dSubtotal',Base::$db->getOne("select sum(number*price) from cart where type_='cart' ".Auth::$sWhere));

		PrintContent::Append(Base::$tpl->fetch('cart/cart_print.tpl'));
		Base::Redirect('?action=print_content&return=cart_cart');
	}
	//-----------------------------------------------------------------------------------------------
	public function CallParseCart(&$aItem)
	{
		if ($aItem) foreach($aItem as $key => $value) {
			/*$aItem[$key]['name']="<b>".$value['name'].
			"</b><br>".String::FirstNwords($value['customer_comment'],5);*/
			$aItem[$key]['total']=$value['number'] * Currency::PrintPrice($value['price'],null,2,'<none>');
			$aItem[$key]['image'] = Db::GetOne("select image from ec_products where id ='". $aItem[$key]['id_product'] ."'");		//29.12.201
			$aItem[$key]['cart_history']=Db::GetAll(
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
		}

		return array('dSubtotal'=>$dSubtotal,'dSubtotalWeight'=>$dSubtotalWeight);
	}
	//-----------------------------------------------------------------------------------------------
	public function AddCartItemChecked()
	{
		if (Base::$aRequest['row_check']) {
			foreach (Base::$aRequest['row_check'] as $value) {
				list(Base::$aRequest['item_code'],Base::$aRequest['id_provider'])=explode('::',$value);

				if (Base::$aRequest['item_code'] && Base::$aRequest['id_provider'] )
				$this->AddCartItem(Base::$aRequest['n'][$value],false,Base::$aRequest['r'][$value]);
			}
		}
		Base::Redirect('/?action=cart_cart');
	}
	//-----------------------------------------------------------------------------------------------
	public function AddCartItem($iNumber=1,$bRedirect=true,$sReference='')
	{
		if ($iNumber<=0) $iNumber=1;
		if ((int)Base::$aRequest['number']>0) $iNumber=(int)Base::$aRequest['number'];

		$oCatalog=New catalog();

//log add to cart		
//		if (Auth::IsAuth()) Cart::LogCart();
		
		$iTime = time();
		$sTime = date("Y-m-d H:i:s", $iTime);

		$aCondition=Db::GetAll("select p.id_parent,p.id as id_product,ch.id as ch_id,concat_ws(' ', gp.name,ch.info) as name, gp.color,ch.skidka,ch.id_type_skidka from ec_condition_d as cd
        	        inner join ec_condition_h as ch on cd.id_condition_h=ch.id
        	        inner join ec_group_p as gp on ch.id_group_p=gp.id
	    			inner join ec_products p on p.id=cd.id_product
        	        where ch.dt1 < '".$sTime."' and ch.dt2 > '".$sTime."'
	    		    and ch.id_group_p in(2,3) and (ch.id_customer_group='". $oCatalog->id_customer_group ."' or ch.id_customer_group=0)
        	        and (ch.is_all_region=1 or ch.id_region='".$oCatalog->iIdRegion."') and ch.visible=1");

	    if (Auth::$aUser['id'] && Auth::$aUser['type_']=='customer')
	    {
			$User_discount=Auth::$aUser['id'];
			$Discounts=Db::GetOne("select count( * ) from ec_discounts di where id_region='".$this->iIdRegion."' and id_user='".$User_discount."' ");
	    }
	    elseif (Auth::$aUser['id'] && Auth::$aUser['type_']=='manager')
	    {
			$User_discount=Db::GetOne("select id_customer_partner as user_discount from user_manager um where id_user='".Auth::$aUser['id']."' ");
			$Discounts=Db::GetOne("select count( * ) from ec_discounts di where id_region='".$this->iIdRegion."' and id_user='".$User_discount."' ");
	    }

		$a=Db::GetRow(Base::GetSql("EcProductVidRegion",array(
		    'id_products'=>"'".Base::$aRequest['id_product']."'",
		    'id_region'=>$oCatalog->iIdRegion,
				'discounts'=>$Discounts,
				'user_discount'=>$User_discount,
		    'id_customer_group'=> $oCatalog->id_customer_group
		)));

		if (!$a || $a['price']==0) {
			if ($bRedirect) Base::Redirect('?action=cart_cart&table_error=cart_not_found');
			else return;
		}


		foreach($aCondition as $keyp2 => &$aValue2) {
			if($a['id'] == $aValue2['id_product']){
					$a['promo'][0]= $aValue2;
			}
		}


		$a['id_product']=$a['id'];
		$a['id_provider']=1;
		$a['zzz_code'] = $a['id'];
		$a['id_currency_user']=(Auth::$aUser['id_currency']?Auth::$aUser['id_currency']:1);
		$a['price_currency_user'] = Currency::PrintPrice($a['price'],Auth::$aUser['id_currency'],2,"<none>")*$iNumber;

		unset($a['id']);
		unset($a['post_date']);
		$a['id_user']=Auth::$aUser['id'];
		$a['session']=session_id();
		$a['number']=$iNumber;
		$a['customer_id']=mysql_real_escape_string($sReference);

		if($a['promo'][0]['skidka']){
		$a['price_original']=$a['price'];
			if($a['promo'][0]['id_type_skidka']==3)
				$a['price']=round(round(round($a['base_price']*$a['promo'][0]['skidka'],2)/1.2,2)*1.2,2);			
			else
				$a['price']=round(round(round($a['price']*$a['promo'][0]['skidka'],2)/1.2,2)*1.2,2);			
		}

		if($a['promo'][0]['skidka'])
		$a['price_parent_margin']=$a['promo'][0]['skidka'];
		if ($a['promo'][0]['ch_id'])
		$a['discount']=$a['promo'][0]['ch_id'];
		if($a['promo'][0]['name'])
		$a['term']=$a['promo'][0]['name'];
		if($a['promo'][0]['color'])
		$a['id_provider_order']=$a['promo'][0]['color'];
		//		provider_price

//		$a['price_parent_margin_second']=$a['price_original']*Auth::$aUser['parent_margin_second']/100;
		$a['id_provider_ordered']=$a['id_provider'];
		$a['provider_name_ordered']=$a['provider_name'];
		//$a['price']=Currency::GetPriceWithoutSymbol($a['price']);
		//$a['price_order']=Currency::GetPriceWithoutSymbol($a['price_order']);

		$aExistingCart=Db::GetRow(Base::GetSql("Part/Search",array(
		"type_"=>'cart',
		"where"=>" and c.id_user='".Auth::$aUser['id']."' and c.id_product='".$a['id_product']."'
			and c.id_provider='".$a['id_provider']."'"
		)));
		if ($aExistingCart) {
			$iNewNumber=$aExistingCart['number']+$a['number'];
			Db::AutoExecute('cart',array('number'=>$iNewNumber),'UPDATE'," id='".$aExistingCart['id']."'");
		} else {
		    Db::AutoExecute("cart", $a);
		}

		if (Base::$aRequest['xajax_request']) {
			$bRedirect=false;
			Base::$oResponse->AddAssign(Base::$aRequest['link_id'],'innerHTML',
			'<button type="submit" class="btn btn-sm btn-primary">Добавлено</button>');//.Language::GetMessage('added to cart')
		}
		if ($bRedirect) Base::Redirect('?action=cart_cart');

		$oContent=new Content();
		$oContent->ParseTemplate(true);
	}
	//-----------------------------------------------------------------------------------------------
	public function SetCartItem($iNumber=1,$bRedirect=true,$sReference='')
	{
//		if ($iNumber<=0) $iNumber=1;
		if ((int)Base::$aRequest['number']>0) $iNumber=(int)Base::$aRequest['number'];

		$oCatalog=New catalog();

		if (Auth::IsAuth()) Cart::LogCart();

		$iTime = time();
		$sTime = date("Y-m-d H:i:s", $iTime);

		$aCondition=Db::GetAll("select p.id_parent,p.id as id_product,ch.id as ch_id,concat_ws(' ', gp.name,ch.info) as name, gp.color,ch.skidka,ch.id_type_skidka from ec_condition_d as cd
        	        inner join ec_condition_h as ch on cd.id_condition_h=ch.id
        	        inner join ec_group_p as gp on ch.id_group_p=gp.id
	    			inner join ec_products p on p.id=cd.id_product
        	        where ch.dt1 < '".$sTime."' and ch.dt2 > '".$sTime."'
	    		    and ch.id_group_p in(2,3) and (ch.id_customer_group='". $oCatalog->id_customer_group ."' or ch.id_customer_group=0)
        	        and (ch.is_all_region=1 or ch.id_region='".$oCatalog->iIdRegion."') and ch.visible=1");

	    if (Auth::$aUser['id'] && Auth::$aUser['type_']=='customer')
	    {
			$User_discount=Auth::$aUser['id'];
			$Discounts=Db::GetOne("select count( * ) from ec_discounts di where id_region='".$this->iIdRegion."' and id_user='".$User_discount."' ");
	    }
	    elseif (Auth::$aUser['id'] && Auth::$aUser['type_']=='manager')
	    {
			$User_discount=Db::GetOne("select id_customer_partner as user_discount from user_manager um where id_user='".Auth::$aUser['id']."' ");
			$Discounts=Db::GetOne("select count( * ) from ec_discounts di where id_region='".$this->iIdRegion."' and id_user='".$User_discount."' ");
	    }

		$a=Db::GetRow(Base::GetSql("EcProductVidRegion",array(
		    'id_products'=>"'".Base::$aRequest['id_product']."'",
		    'id_region'=>$oCatalog->iIdRegion,
				'discounts'=>$Discounts,
				'user_discount'=>$User_discount,
		    'id_customer_group'=> $oCatalog->id_customer_group
		)));

		if (!$a || $a['price']==0) {
			if ($bRedirect) Base::Redirect('?action=cart_cart&table_error=cart_not_found');
			else return;
		}


		foreach($aCondition as $keyp2 => &$aValue2) {
			if($a['id'] == $aValue2['id_product']){
					$a['promo'][0]= $aValue2;
			}
		}


		$a['id_product']=$a['id'];
		$a['id_provider']=1;
		$a['zzz_code'] = $a['id'];
		$a['id_currency_user']=(Auth::$aUser['id_currency']?Auth::$aUser['id_currency']:1);
		$a['price_currency_user'] = Currency::PrintPrice($a['price'],Auth::$aUser['id_currency'],2,"<none>")*$iNumber;

		unset($a['id']);
		unset($a['post_date']);
		$a['id_user']=Auth::$aUser['id'];
		$a['session']=session_id();
		$a['number']=$iNumber;
		$a['customer_id']=mysql_real_escape_string($sReference);

		if($a['promo'][0]['skidka']){
		$a['price_original']=$a['price'];
			if($a['promo'][0]['id_type_skidka']==3)
				$a['price']=round(round(round($a['base_price']*$a['promo'][0]['skidka'],2)/1.2,2)*1.2,2);			
			else
				$a['price']=round(round(round($a['price']*$a['promo'][0]['skidka'],2)/1.2,2)*1.2,2);			
		}

		if($a['promo'][0]['skidka'])
		$a['price_parent_margin']=$a['promo'][0]['skidka'];
		if ($a['promo'][0]['ch_id'])
		$a['discount']=$a['promo'][0]['ch_id'];
		if($a['promo'][0]['name'])
		$a['term']=$a['promo'][0]['name'];
		if($a['promo'][0]['color'])
		$a['id_provider_order']=$a['promo'][0]['color'];
		//		provider_price

//		$a['price_parent_margin_second']=$a['price_original']*Auth::$aUser['parent_margin_second']/100;
		$a['id_provider_ordered']=$a['id_provider'];
		$a['provider_name_ordered']=$a['provider_name'];
		//$a['price']=Currency::GetPriceWithoutSymbol($a['price']);
		//$a['price_order']=Currency::GetPriceWithoutSymbol($a['price_order']);

		$aExistingCart=Db::GetRow(Base::GetSql("Part/Search",array(
		"type_"=>'cart',
		"where"=>" and c.id_user='".Auth::$aUser['id']."' and c.id_product='".$a['id_product']."'
			and c.id_provider='".$a['id_provider']."'"
		)));
		
	if ((int)Base::$aRequest['number']>0)
	{
		if ($aExistingCart) {
			$iNewNumber=$a['number'];
			Db::AutoExecute('cart',array('number'=>$iNewNumber),'UPDATE'," id='".$aExistingCart['id']."'");
		} else {
		    Db::AutoExecute("cart", $a);
		}

		if (Base::$aRequest['xajax_request']) {
			$bRedirect=false;
			Base::$oResponse->AddAssign(Base::$aRequest['link_id'],'innerHTML',
			'<button type="submit" class="btn btn-sm btn-primary">Добавлено</button>');//.Language::GetMessage('added to cart')
		}
		if ($bRedirect) Base::Redirect('?action=cart_cart');
	}
	else
	{
		if ($aExistingCart) {
			Db::Execute("delete from cart where id='".$aExistingCart['id']."'");
		}
	}

		$oContent=new Content();
		$oContent->ParseTemplate(true);
	}
	//-----------------------------------------------------------------------------------------------
	public function CartUpdateNumber()
	{
		if (Auth::IsAuth()) Cart::LogCart();
		if (Base::$aRequest['number']>0) {
			Base::$db->Execute("update cart set number='".Base::$aRequest['number']."' where type_='cart'
			and id='".Base::$aRequest['id']."' ".Auth::$sWhere);

			$aCart=Db::GetRow("select * from cart where id='".Base::$aRequest['id']."'");
			if ($aCart) {
				$iPrice_currency_user = $aCart['number'] * Base::$oCurrency->PrintPrice($aCart['price'],$aCart['id_currency_user'],2,"<none>");
				Base::$db->Execute("update cart set price_currency_user='".$iPrice_currency_user."' where type_='cart'
					and id='".Base::$aRequest['id']."' ".Auth::$sWhere);

				Base::$oResponse->addAssign('cart_total_'.$aCart['id'],'innerHTML'
				,Base::$oCurrency->PrintSymbol($aCart['number']*Base::$oCurrency->PrintPrice($aCart['price'],null,2,"<none>")));

				//$dSubTotal=Base::$db->getOne("select sum(number*price) from (".$_SESSION['cart']['table_sql'].") sc ");/
				$aCartList=Db::GetAll($_SESSION['cart']['table_sql']);
				if ($aCartList) foreach ($aCartList as $aValue) {
					$dSubTotal+=$aValue['number']*Base::$oCurrency->PrintPrice($aValue['price'],null,2,"none");
					$dSubTotalWeight+=$aValue['number']*$aValue['weight'];
				}
				Base::$oResponse->addAssign('cart_subtotal','innerHTML',Base::$oCurrency->PrintSymbol($dSubTotal));
				Base::$oResponse->addAssign('cart_subtotal_weight','innerHTML',$dSubTotalWeight);
				Base::$oResponse->AddAssign('icart_total_id','innerHTML',Base::$oCurrency->PrintSymbol($dSubTotal));
			}
		}
		elseif(Base::$aRequest['number']){
			Base::$oResponse->addAlert(Base::$language->getMessage('Error: not valid number.'));
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function OrderList()
	{
		Base::$aTopPageTemplate=array('panel/tab_customer_cart.tpl'=>'order');

		Base::$tpl->assign_by_ref("oCatalog", new Catalog());

		if (Base::$aRequest['is_post']) {

			//[----- UPDATE -----------------------------------------------------]
			$sQuery="update cart set
						customer_comment='".htmlspecialchars(strip_tags(Base::$aRequest['customer_comment']))."',
						customer_id='".htmlspecialchars(strip_tags(Base::$aRequest['customer_id']))."'
					where id='".Base::$aRequest['id']."' and type_='order' ".Auth::$sWhere;
			//[----- END UPDATE -------------------------------------------------]
			Base::$db->Execute($sQuery);
			//Form::AfterReturn('cart_order');
			Base::Redirect('/pages/cart_order/');

		}

		if ( Base::$aRequest['action']=='cart_order_edit') {
			Form::BeforeReturn('cart_order','cart_order_edit');

			if (Base::$aRequest['action']=='cart_order_edit') {
				$aUserCart=Db::GetRow("select * from cart where id='".Base::$aRequest['id']."'
					and type_='order'	".Auth::$sWhere);
				Base::$tpl->assign('aData',$aUserCart);
			}

			$aData=array(
			'sHeader'=>"method=post",
			'sTitle'=>"Cart item",
			'sContent'=>Base::$tpl->fetch('cart/form_order.tpl'),
			'sSubmitButton'=>'Apply',
			'sSubmitAction'=>'cart_order',
			'sReturnButton'=>'<< Return',
			'sReturnAction'=>'cart_order',
			'sError'=>$sError,
			);
			$oForm=new Form($aData);

			Base::$sText.=$oForm->getForm();

			return;
		}

		Base::$tpl->assign('aCartPackage',Db::GetAll("select * from cart_package where is_archive='0'
			".Auth::$sWhere." order by post_date desc"));
		Base::$tpl->assign('aAccesType',array(
		'own'=>Language::GetMessage('Own orders'),
		'subuser'=>Language::GetMessage('Subuser orders'),
		));
		Base::$tpl->assign('aOrderStatus',array(
		''=>Language::GetMessage('All'),
		'all_except_archive'=>Language::GetMessage('All except Archive'),
		'new'=>Language::GetMessage('new'),
		'work'=>Language::GetMessage('work'),
		'confirmed'=>Language::GetMessage('confirmed'),
		'road'=>Language::GetMessage('road'),
		'store'=>Language::GetMessage('store'),
		'end'=>Language::GetMessage('end'),
		'refused'=>Language::GetMessage('refused'),
        'pending'=>Language::GetMessage('pending'),
		));
		Base::$tpl->assign('aEndable',array(
		''=>Language::GetMessage('All'),
		'1'=>Language::GetMessage('Is Endable'),
		'0'=>Language::GetMessage('Not IsEndable'),
		));

		$aData=array(
		'sHeader'=>"method=get",
		//'sTitle'=>"Order Items",
		'sHint'=>"cart_order_form",
		'sContent'=>Base::$tpl->fetch('cart/form_order_search.tpl'),
		'sSubmitButton'=>'Search',
		'sSubmitAction'=>'cart_order',
		'sReturnButton'=>'Clear',
		'sReturnAction'=>'cart_order',
		'bIsPost'=>0,
		'sWidth'=>"750px",
		'sError'=>$sError,
		);
		$oForm=new Form($aData);
		$aData['sSearchForm']=$oForm->getForm();

		// --- search ---
		if (!Base::$aRequest['search']['archive']) $sWhere.=" and c.is_archive='0'";
		//if (Base::$aRequest['search']['customer_id']) $sWhere.=" and c.customer_id like
		//	'%".Base::$aRequest['search']['customer_id']."%'";

        if (Base::$aRequest['search']['name']) $sWhere.=" and c.name_translate like
			'%".Base::$aRequest['search']['name']."%'";
		if (Base::$aRequest['search']['code']) $sWhere.=" and c.code='".Base::$aRequest['search']['code']."'";
		if (Base::$aRequest['search']['id_cart_package'])
		$sWhere.=" and c.id_cart_package='".Base::$aRequest['search']['id_cart_package']."'";

		if (Base::$aRequest['search']['order_status']=='all_except_archive') {
			$sWhere.=" and c.order_status in ('pending','new','work','confirmed','road','store')";
		} elseif (Base::$aRequest['search']['order_status']) {
			$sWhere.=" and c.order_status='".Base::$aRequest['search']['order_status']."'";
		}

		if (Base::$aRequest['search']['id']) $sWhere.=" and c.id='".Base::$aRequest['search']['id']."'";
	    if(Base::$aRequest['search']['datestart']) {
		    $iDate=strtotime(Base::$aRequest['search']['datestart']);
		    $sWhere.=" and DATE(c.post_date) >= '".date("Y-m-d",$iDate)."' ";
		}
		if(Base::$aRequest['search']['dateend']) {
		    $iDate=strtotime(Base::$aRequest['search']['dateend']);
		    $sWhere.=" and DATE(c.post_date) <= '".date("Y-m-d",$iDate)."' ";
		}
		if (Base::$aRequest['search']['subuser_login']) $sWhere.=" and u.login='".Base::$aRequest['search']['subuser_login']."'";

		if (Base::$aRequest['search']['acces_type']=='own' || !Base::$aRequest['search']['acces_type']) {
			$sWhere.=" and c.id_user='".Auth::$aUser['id']."'";
		}
		else {
			Base::$aTopPageTemplate=array('panel/tab_customer_cart.tpl'=>'subuser_order');
			$aSubuserId=array_keys(Base::$db->GetAssoc(Base::GetSql('Customer/SubuserAssoc',array(
			'id_user'=>Auth::$aUser['id'],
			))));
			$sWhere.=" and c.id_user in(".implode(',',$aSubuserId).")";
		}
		if (Base::$aRequest['search']['is_endable']!='')
		$sWhere.=" and c.is_endable='".Base::$aRequest['search']['is_endable']."'";
		// --------------

		$oTable=new Table();
		$oTable->sWidth='99%';
		$oTable->sSql=Base::GetSql("Part/Search",array(
		"name"=>trim(Base::$aRequest['search']['name']),
		"where"=>$sWhere,
		));

		$_SESSION['customer_order']['current_sql']=$oTable->sSql;

		$oTable->aOrdered="order by c.post_date desc";
		$oTable->aColumn=array(
		'id'=>array('sTitle'=>'#'),
		'id_cart_package'=>array('sTitle'=>'Order #'),
		'code'=>array('sTitle'=>'CartCode'),
		'order_status'=>array('sTitle'=>'Order Status'),
		'name'=>array('sTitle'=>'Name/Customer_Id'),
		'term'=>array('sTitle'=>'Term'),
		'number'=>array('sTitle'=>'Number'),
		//'weight'=>array('sTitle'=>'Weight'),
		'price'=>array('sTitle'=>'Price'),
		'total'=>array('sTitle'=>'Total'),
		//'post'=>array('sTitle'=>'Date','sWidth'=>'10%'),
		'action'=>array(),
		);
		$oTable->sDataTemplate='cart/row_order.tpl';
		$oTable->sButtonTemplate='cart/button_order.tpl';
		$oTable->iRowPerPage=20;
		$oTable->bCheckVisible=true;
		$oTable->aCallback=array($this,'CallParseOrder');

		$aData['sOrderItem']=$oTable->getTable("Cart Order Items",'cart_order');

		Base::$tpl->assign('aData',$aData);

		Base::$sText.=Base::$tpl->fetch('cart/order.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	public function CallParseOrder(&$aItem)
	{
		if ($aItem) {
			foreach($aItem as $key => $value) {
				$aOrderId[]=$value['id'];
				/*$aItem[$key]['name']="<b>".$value['name'].
				"</b><br>".String::FirstNwords($value['customer_comment'],5);*/
				$aItem[$key]['total']=$value['number']*Currency::PrintPrice($value['price']);
			}
			$aHistory=Db::GetAll("select * from cart_log
				where id_cart in (".implode(',',$aOrderId).")");
			if ($aHistory) foreach($aHistory as $key => $value) {
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
	public static function ParseVinCode($sVinCode, $iCheckVinLen = 17)
	{
		$sParsedVinCode = '';
		$sParsedVinCode = strtoupper($sVinCode);
		$aFindChars = array('I', 'O', 'Q', ' ');
		$aReplChars = array('1', '0', '9', '');
		$sParsedVinCode = str_replace($aFindChars, $aReplChars, $sParsedVinCode);
		if( $iCheckVinLen == strlen($sParsedVinCode) ) {
			return $sParsedVinCode;
		} else {
			// wrong VIN code format! Look at ISO 3779-1983 for more information
			return '';
		}
	}
	//-----------------------------------------------------------------------------------------------
	/**
	 * Step1 - package confirm
	 */
	public function PackageConfirm()
	{
		Base::$tpl->assign('iPathStep',1);
		Base::$sText.=Base::$tpl->fetch("cart/path_cart_package.tpl");
		if (!$_SESSION['current_cart']['id_delivery_type']) $_SESSION['current_cart']['id_delivery_type']=1;

		/* hack for fixing back button on end step */
		$_SESSION['current_cart']['is_confirmed']=0;

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

		Base::$tpl->assign('aDeliveryType',Db::GetAll(Base::GetSql('DeliveryType',array('visible'=>1))));
		$aDeliveryTypeRow=Db::GetRow(Base::GetSql('DeliveryType',array(
		'id'=>$_SESSION['current_cart']['id_delivery_type'],
		'visible'=>1,
		)));
		Base::$tpl->assign('aDeliveryTypeRow',$aDeliveryTypeRow);

		Base::$tpl->assign('dSubtotal',$dSubtotal);
		Base::$tpl->assign('dTotal',$dSubtotal+Currency::PrintPrice($_SESSION['current_cart']['price_delivery']));


		Base::$sText.=Base::$tpl->fetch('cart/package_confirm.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	public function PackageDelete()
	{
		$aCartPackage=Db::GetRow("select * from cart_package where id='".Base::$aRequest['id']."' ".Auth::$sWhere);
		if (!$aCartPackage || $aCartPackage['order_status']!='new')						//30.12.2016
		Base::Redirect("/?action=cart_package_list&table_error=Error_deleting_package");

		Db::Execute("update cart set type_='cart',id_cart_package=0
			where id_cart_package='".Base::$aRequest['id']."' ".Auth::$sWhere);
		Db::Execute("delete from cart_package where id='".Base::$aRequest['id']."' ".Auth::$sWhere);

		if (Base::$aRequest['return_action']) $sReturnAction=Base::$aRequest['return_action'];
		else $sReturnAction='cart_package_list';

		Base::Redirect("/?action=".$sReturnAction);
	}
	//-----------------------------------------------------------------------------------------------
	/**
	 * Step2
	 */
	public function CheckAccount()
	{
		if (Auth::$aUser['type_']=='manager') Base::Redirect('/?action=cart_select_account');
		if (!Customer::IsChangeableLogin(Auth::$aUser['login'])) Base::Redirect('/?action=cart_shipment_detail');
		Base::$tpl->assign('iPathStep',2);
		Base::$sText.=Base::$tpl->fetch("cart/path_cart_package.tpl");

		$sCheckLoggedError=false;
		$sCheckNewAccountError=false;

		if (Base::$aRequest['is_post']) {
			if (Base::$aRequest['subaction']=='create_new_account'){
				$sCheckNewAccountError=$this->NewAccountError();
				if (!Base::$aRequest['data']['name'] || !Base::$aRequest['data']['city']
				|| !Base::$aRequest['data']['address'] || !Base::$aRequest['data']['phone']
				|| $sCheckNewAccountError
				) {
					if ($sCheckNewAccountError) {
						$sError=$sCheckNewAccountError;
					} else {
						$sError="Please, fill the required fields";
					}
					Base::$tpl->assign('aUser',Base::$aRequest['data']);
				}
				else {
					$aRequestUser=String::FilterRequestData(Base::$aRequest['data'],array('login','password','email'));
					$sSalt=String::GenerateSalt();
					$aRequestUser['password']=String::Md5Salt($aRequestUser['password'],$sSalt);
					$aRequestUser['salt']=$sSalt;
					$aRequestUser['password_temp']='';
					Db::Autoexecute('user',$aRequestUser,'UPDATE',"id='".Auth::$aUser['id']."'");

					$aRequestUserCustomer=String::FilterRequestData(Base::$aRequest['data'],array(
					'name','country','city','zip','company','address','phone','remark','id_region'
					));
					Db::Autoexecute('user_customer',$aRequestUserCustomer,'UPDATE',"id_user='".Auth::$aUser['id']."'");

					$aCartPackageUpdate['customer_comment']=Base::$aRequest['data']['customer_comment'];//$aRequestUserCustomer['remark'];	//28.12.2016
					$aCartPackageUpdate['name_manager']=Base::$aRequest['login'];				//28.12.2016
					$aCartPackageUpdate['date_delivery']=date("Y-m-d H:i:s",strtotime(Base::$aRequest['date_delivery']));				//29.12.2016
					Db::AutoExecute('cart_package',$aCartPackageUpdate,'UPDATE'
					," id='".$_SESSION['current_cart_package']['id']."' ".Auth::$sWhere);

					// send letter
					$aUser=Db::GetRow("SELECT * from user where id = ".Auth::$aUser['id']);
					$aManager=Db::GetRow("SELECT um.*, u2.login
					FROM user u
					INNER JOIN user_customer uc ON u.id = uc.id_user
					INNER JOIN user_manager um ON uc.id_manager = um.id_user
					INNER JOIN user u2 ON u2.id = uc.id_manager
					WHERE u.id ='".Auth::$aUser['id']."'");
					$sLink="<A href='http://".SERVER_NAME."/?action=user_confirm_registration&signature=".$aUser['signature']."'
						>".Base::$language->getMessage('Confirm')."</a>";
					$sUrl="http://".SERVER_NAME."/?action=user_confirm_registration&signature=".$aUser['signature'];

					$aData=array(
							'info'=>array(
									'link'=>$sLink,
									'url'=>$sUrl,
									'login'=>Base::$aRequest['data']['login'],
									'password'=>Base::$aRequest['data']['password'],
									'email'=>Base::$aRequest['data']['email'],
							),
							'aManager'=>$aManager
					);
					$aSmartyTemplate=String::GetSmartyTemplate('confirmation_letter', $aData);
					$sBody=$aSmartyTemplate['parsed_text'];

					Mail::AddDelayed(Base::$aRequest['data']['email'],Base::$language->getMessage('Confirmation Letter'),$sBody,'','',true,2);

					Base::Redirect("/?action=cart_payment_method");
				}

			}
			if (Base::$aRequest['subaction']=='check_logged') {
				if (!Base::$aRequest['data']['old_login'] || !Base::$aRequest['data']['old_password'])
				$sCheckLoggedError="Please, enter all the fields";
				else {
					$aOldUser=Auth::IsUser(Base::$aRequest['data']['old_login'], Base::$aRequest['data']['old_password']
					,false,Base::GetConstant('user:is_salt_password',1));
					if ($aOldUser) {
						//Syncronization
//05.01.2017
//в корзине надо проставить цены региона и группы контрагентов к которой относится выбранный логин
		if (Auth::IsAuth()) Cart::LogCart();

//type пользователя
		$sUserTypeSql="select type_ from user uc where uc.id='".$aOldUser['id']."'";
		$aUserType=Db::GetAll($sUserTypeSql);
		
		if (!$aUserType['type_']=='manager')
		$sUserCartSql="select c.id,pr.price 
			from cart c
			inner join ec_price pr on pr.id_product=c.id_product 
			inner join user_customer uc on uc.id_customer_group=pr.id_customer_group and uc.id_region=pr.id_region and uc.id_user='".$aOldUser['id']."'
			where type_='cart'and c.id_user='".Auth::$aUser['id']."'";
		else
		$sUserCartSql="select c.id,pr.price 
			from cart c
			inner join ec_price pr on pr.id_product=c.id_product 
			inner join user_manager um on um.id_customer_group=pr.id_customer_group and um.id_region=pr.id_region and um.id_user='".$aOldUser['id']."'
			where type_='cart'and c.id_user='".Auth::$aUser['id']."'";

// надо учесть проводимые акции!!!
			
		$aUserCart=Db::GetAll($sUserCartSql);
		if ($aUserCart) foreach ($aUserCart as $iKey => $aValue) {
			Db::Execute("update cart set price='".$aValue['price']."' where id='".$aValue['id']."'");
		}

//забираем корзину под выбранный логин
						Db::Execute("update cart set id_user='".$aOldUser['id']."' where id_user='".Auth::$aUser['id']."'");
						Db::Execute("update cart_package set id_user='".$aOldUser['id']."' where id_user='".Auth::$aUser['id']."'");
						Db::Execute("update user set visible='0' where id='".Auth::$aUser['id']."'");

						Auth::Login(Base::$aRequest['data']['old_login'], Base::$aRequest['data']['old_password'],false,true
						,Base::GetConstant('user:is_salt_password',1));
						Base::Redirect("/?action=cart_shipment_detail");
					}
					else $sCheckLoggedError="No user with such login and password";
				}
			}
		}

		$_SESSION['is_checked_account']=true;

		$aData=array(
		'sWidth'=>"450px;",
		'sHeader'=>"method=post",
		'sTitle'=>"Check Create New account",
		'sContent'=>Base::$tpl->fetch('cart/form_check_new_account.tpl'),
		'sSubmitButton'=>'Create and process',
		'sSubmitAction'=>'cart_check_account',
		'sError'=>$sError,
		'sHidden'=>" <input type=hidden name=subaction value='create_new_account' />",
		);
		$oForm=new Form($aData);
		Base::$tpl->assign('sCheckNewAccountForm',$oForm->getForm());

		$aData=array(
		'sWidth'=>"420px;",
		'sHeader'=>"method=post",
		'sTitle'=>"Check Logged",
		'sContent'=>Base::$tpl->fetch('cart/form_check_logged.tpl'),
		'sSubmitButton'=>'Login and process',
		'sSubmitAction'=>'cart_check_account',
		'sError'=>$sCheckLoggedError,
		'sHidden'=>" <input type=hidden name=subaction value='check_logged' />",
		);
		$oForm=new Form($aData);
		Base::$tpl->assign('sCheckLoggedForm',$oForm->getForm());

		Base::$sText.=Base::$tpl->fetch("cart/check_account.tpl");
	}
	//-----------------------------------------------------------------------------------------------
	/**
	 * Step2m
	 */
	public function SelectAccount()
	{
		if (Auth::$aUser['type_']!='manager') Base::Redirect('/?action=cart_check_account');
		Base::$tpl->assign('iPathStep',2);
		Base::$sText.=Base::$tpl->fetch("cart/path_cart_package.tpl");
		/*Base::$tpl->assign('aLogin',array(-1=>'')+Db::GetAssoc(Base::GetSql("Assoc/UserCustomer",
		array('where'=>" and uc.id_manager='".Auth::$aUser['id_user']."'")).' order by u.login'));*/
		Base::$tpl->assign('aName',array(-1=>'')+Db::GetAssoc("select id as id, concat(uc.name,' ( ',u.login,' )') name
		from user as u
		inner join user_customer as uc on u.id=uc.id_user
		where u.visible=1 and uc.name is not null and trim(uc.name)!=''
		and uc.id_manager='".Auth::$aUser['id_user']."'
		order by uc.name"));

		$sCheckLoggedError=false;
		$sCheckNewAccountError=false;

		if (Base::$aRequest['is_post']) {
			if (Base::$aRequest['subaction']=='create_new_account'){
				$sCheckNewAccountError=$this->NewAccountManagerError();
				if (!Base::$aRequest['data']['name'] || !Base::$aRequest['data']['phone']
				|| $sCheckNewAccountError
				) {
					if ($sCheckNewAccountError) {
						$sError=$sCheckNewAccountError;
					} else {
						$sError="Please, fill the required fields";
					}
					Base::$tpl->assign('aUser',Base::$aRequest['data']);
				}
				else {
					$aRequestUser=String::FilterRequestData(Base::$aRequest['data'],array('login','password','email'));
					Base::$aRequest['login']=$aRequestUser['login'];
					Base::$aRequest['password']=$aRequestUser['password'];
					Base::$aRequest['email']=$aRequestUser['email'];

					$_SESSION['current_cart_package']['new_user']=User::DoNewAccount(true);

					Base::Redirect("/?action=cart_payment_method");
				}

			}
			if (Base::$aRequest['subaction']=='select_account') {
				$bOk=(Base::$aRequest['data']['old_login']>0 || Base::$aRequest['data']['old_name']>0);
				if(Base::$aRequest['data']['old_login']>0 && Base::$aRequest['data']['old_name']>0
				&& Base::$aRequest['data']['old_login']!=Base::$aRequest['data']['old_name']) $bOk=FALSE;
				if ($bOk)
				{
					if ($aOldUser) {
						//Syncronization
						//Db::Execute("update cart set id_user='".$aOldUser['id']."' where id_user='".Auth::$aUser['id']."'");
						//Db::Execute("update cart_package set id_user='".$aOldUser['id']."' where id_user='".Auth::$aUser['id']."'");
						//Db::Execute("update user set visible='0' where id='".Auth::$aUser['id']."'");

						//if(Auth::IsAuth()) Cart::RefreshCartPackage(Auth::$aUser['id']);
						Base::Redirect("/?action=cart_shipment_detail");
					}
					if(Base::$aRequest['data']['old_login']>0)$_SESSION['current_cart_package']['new_user']=Base::$aRequest['data']['old_login'];
					else $_SESSION['current_cart_package']['new_user']=Base::$aRequest['data']['old_name'];
					Cart::RecalcCartUser(Auth::$aUser['id_user'],$_SESSION['current_cart_package']['new_user']);
					Base::Redirect("/?action=cart_payment_method");
				}else
				$sCheckLoggedError="Please, enter all the fields";
			}
		}

		$_SESSION['is_checked_account']=true;
		if(!Base::$aRequest['data']['login']) $_REQUEST['data']['login']='m'.Auth::GenerateLogin();
		if(!Base::$aRequest['data']['password']) $_REQUEST['data']['password']=Auth::GeneratePassword();
		if(!Base::$aRequest['data']['verify_password']) $_REQUEST['data']['verify_password']=$_REQUEST['data']['password'];

		$aData=array(
		'sWidth'=>"450px;",
		'sHeader'=>"method=post",
		'sTitle'=>"Create New account",
		'sContent'=>Base::$tpl->fetch('cart/form_select_new_account.tpl'),
		'sSubmitButton'=>'Create and process',
		'sSubmitAction'=>'cart_select_account',
		'sError'=>$sError,
		'sHidden'=>" <input type=hidden name=subaction value='create_new_account' />",
		);
		$oForm=new Form($aData);
		Base::$tpl->assign('sCheckNewAccountForm',$oForm->getForm());

		$aData=array(
		'sWidth'=>"420px;",
		'sHeader'=>"method=post",
		'sTitle'=>"Select account",
		'sContent'=>Base::$tpl->fetch('cart/form_select_account.tpl'),
		'sSubmitButton'=>'process',
		'sSubmitAction'=>'cart_select_account',
		'sError'=>$sCheckLoggedError,
		'sHidden'=>" <input type=hidden name=subaction value='select_account' />",
		);
		$oForm=new Form($aData);
		Base::$tpl->assign('sCheckLoggedForm',$oForm->getForm());

		Base::$sText.=Base::$tpl->fetch("cart/check_account.tpl");
	}
	//-----------------------------------------------------------------------------------------------
	/**
	 * Step3
	 */
	public function ShipmentDetail()
	{
		// for popup model
		Base::$aMessageJavascript = array(
		"MakeAuto_select"=> Language::GetMessage("Choose model"),
		"DetailAuto_select"=> Language::GetMessage("Choose year"),
		"add_auto_error"=>Language::GetMessage("error_add_auto"),
		"add_auto_17symbol"=> Language::GetMessage("vin_have_no_17_symbols"),
		"add_auto_model_empty"=> Language::GetMessage("model_and_series_empty"),
		"add_auto_volume_empty"=> Language::GetMessage("volume_empty"),
		);

		Base::$sText.=Base::$tpl->fetch('cart/popup.tpl');
		Base::$tpl->assign('iPathStep',3);
		Base::$sText.=Base::$tpl->fetch("cart/path_cart_package.tpl");

		Base::$tpl->assign('aUser',Auth::$aUser);
		if (Base::$aRequest['is_post']) {
			if ( (($_SESSION['current_cart']['price_delivery'] > 0) && (!Base::$aRequest['data']['name']
			|| !Base::$aRequest['data']['city'] || !Base::$aRequest['data']['address'] || !Base::$aRequest['data']['phone'])
			|| (Base::$aRequest['data']['chk_order'] == 1 && Base::$aRequest['data']['chk_order'] == 0))

			|| (($_SESSION['current_cart']['price_delivery'] == 0) && (!Base::$aRequest['data']['name']
			|| !Base::$aRequest['data']['phone'])
			|| (Base::$aRequest['data']['chk_order'] == 1 && Base::$aRequest['data']['own_auto_id'] == 0)) ) {
				$sError="Please, fill the required fields";
				Base::$tpl->assign('aUser',Base::$aRequest['data']);
			}
			else {
				$aRequestUserCustomer=String::FilterRequestData(Base::$aRequest['data'],array(
				'name','country','city','zip','company','address','phone','id_region'
				));
				$_SESSION['current_cart_package']['customer_comment']=Base::$aRequest['data']['customer_comment'];
				$_SESSION['current_cart']['chk_order'] = 0;
				if (isset(Base::$aRequest['chk_order']))
					$_SESSION['current_cart']['chk_order'] = Base::$aRequest['chk_order'];

				$_SESSION['current_cart']['own_auto_id'] = 0;
				if (isset(Base::$aRequest['own_auto_id']))
					$_SESSION['current_cart']['own_auto_id'] = Base::$aRequest['own_auto_id'];

				Db::Autoexecute('user_customer',$aRequestUserCustomer,'UPDATE',"id_user='".Auth::$aUser['id']."'");

				Base::Redirect("/?action=cart_payment_method");
			}
		}

		// check count cauto
		$iCountAuto = Db::GetOne("Select count(*) from user_auto where id_user=".Auth::$aUser['id']);
		Base::$tpl->assign('iCountAuto',$iCountAuto);
		Base::$tpl->assign('error_field_auto',Language::GetMessage('Your set check order. Please fill field auto.'));

		$aData=array(
		'sHeader'=>"method=post",
		'sTitle'=>"Shipment detail form",
		'sContent'=>Base::$tpl->fetch('cart/form_shipment_detail.tpl'),
		//'sSubmitButton'=>'Update and pay',
		'sAdditionalButtonTemplate' => 'cart/form_submit.tpl',
		'sSubmitAction'=>'cart_shipment_detail',
		'sError'=>$sError,
		);
		$oForm=new Form($aData);
		$oForm->sWidth='100%';
		Base::$sText.=$oForm->GetForm();
	}
	//-----------------------------------------------------------------------------------------------
	/**
	 * Step4
	 */
	public function PaymentMethod()
	{
		/* hack for fixing back button on end step */
		if ($_SESSION['current_cart']['is_confirmed']) Base::Redirect('/?action=cart_package_list');

		Base::$tpl->assign('iPathStep',4);
		Base::$sText.=Base::$tpl->fetch("cart/path_cart_package.tpl");

		if (Base::$aRequest['is_post']) {
			$aPaymentType=Db::GetRow(Base::GetSql('PaymentType',array('id'=>Base::$aRequest['data']['id_payment_type'])));
			Base::Redirect("/?action=cart_payment_end&data[id_payment_type]=".$aPaymentType['id']);
		}

		Base::$tpl->assign('aPaymentType',Db::GetAll(Base::GetSql('PaymentType',array(
		'where'=>' and pt.visible=1',
		'order'=>' order by pt.num',
		))));
		Base::$sText.=Base::$tpl->fetch('cart/payment_method.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	/**
	 * Step5
	 */
	public function PaymentEnd()
	{
		$iId_GeneralCurrencyCode = Db::getOne("Select id from currency where id=1");

		/* hack for fixing back button on end step */
		$_SESSION['current_cart']['is_confirmed']=1;

		//Check user info
		if(Auth::$aUser['type_']!='manager') {
		    if(/* !Auth::$aUser['email'] ||  */!Auth::$aUser['phone'] || !Auth::$aUser['name']) Base::Redirect("/pages/cart_check_account/");
		}

		//Base::$tpl->assign('iPathStep',5);
		//Base::$sText.=Base::$tpl->fetch("cart/path_cart_package.tpl");

		$iUserId=(Auth::$aUser['type_']=='manager'?$_SESSION['current_cart_package']['new_user']:Auth::$aUser['id']);
		$sUserCartSql=Base::GetSql("Part/Search",array(
		"type_"=>'cart',
		"where"=> " and c.id_user='".Auth::$aUser['id']."'",
		));
		$aUserCart=Db::GetAll($sUserCartSql);

		if (!$aUserCart) Base::Redirect('?action=cart_cart&table_error=cart_not_found');
		else {
			$aUserCartId=array();
			foreach ($aUserCart as $iKey => $aValue) {
				$dPriceTotal+=Currency::PrintPrice($aValue['price'],$iId_GeneralCurrencyCode,2,"<none>")*$aValue['number'];
				// field price_currency_user already sum by number and round
				$dPriceTotalCurrencyUser+=$aValue['price_currency_user'];

				//$dPriceTotal+=$aValue['price']*$aValue['number'];
				$aUserCartId[]=$aValue['id'];
				$aUserCart[$iKey]['print_price'] = Currency::PrintPrice($aValue['price'],$iId_GeneralCurrencyCode,2,"<none>");
				$aUserCart[$iKey]['print_price_user'] = Currency::PrintPrice($aValue['price'],null,2,"<none>");
			}
		}
//создание нового заказа
		//Debug::PrintPre($_SESSION);
		$aCartpackageInsert=array(
		'id_user'=>$iUserId,
		'price_total'=>$dPriceTotal + $_SESSION['current_cart']['price_delivery'],
		'price_total_currency_user'=>$dPriceTotalCurrencyUser + 
		Currency::PrintPrice($_SESSION['current_cart']['price_delivery'],null,2,"<none>") - $_SESSION['current_cart']['bonus'],
		'id_currency_user' => Auth::$aUser['id_currency'],
		'bonus' => $_SESSION['current_cart']['bonus'],
		'order_status'=>'new',													//30.12.2016
		'novaposta'=>$_SESSION['current_cart_package']['novaposta'],
		//'time'=>$_SESSION['current_cart_package']['time'],
		'id_time'=>$_SESSION['current_cart']['id_time'],
		'id_delivery_type'=>$_SESSION['current_cart']['id_delivery_type'],
		'id_payment_type'=>Base::$aRequest['data']['id_payment_type'],
		'price_delivery'=>$_SESSION['current_cart']['price_delivery'],
		'customer_comment'=>$_SESSION['current_cart_package']['customer_comment'],
		'is_need_check' => $_SESSION['current_cart']['is_need_check'],
		'name_manager' => Auth::$aUser['login'],								//28.12.2016
		'date_delivery' => $_SESSION['current_cart_package']['date_delivery'],	//29.12.2016
		'id_own_auto' => $_SESSION['current_cart']['own_auto_id'],
	    'id_addres' => $_SESSION['current_cart_package']['id_addres']
		);


		$aCartpackageInsert=String::FilterRequestData($aCartpackageInsert);
		Db::AutoExecute('cart_package',$aCartpackageInsert);
		$iCartPackageId=Base::$db->Insert_ID();
		$aCartPackage=Db::GetRow(Base::GetSql('CartPackage',array('id'=>$iCartPackageId,)));
		//30.12.2016
		Db::Execute("update cart set type_='order', id_cart_package='$iCartPackageId' ,order_status='new', id_user='$iUserId'
					where id in (".implode(',',$aUserCartId).")");

		Db::Execute("insert into ec_saleh (id_customer ,summa_all) values('".Auth::$aUser['id']."',
			'".-$_SESSION['current_cart']['bonus']."')");

		$aTextTemplate=String::GetSmartyTemplate('payment_end', array(
		'aCartPackage'=>$aCartPackage,
		'aCart'=>$aUserCart,
		));
		//Base::$sText.=$aTextTemplate['parsed_text'];

		$aPaymentType=Db::GetRow(Base::GetSql('PaymentType',array('id'=>Base::$aRequest['data']['id_payment_type'])));
		Base::$tpl->assign('aPaymentType',$aPaymentType);
		Base::$sText.=$aPaymentType['end_description'];

		$aCustomer=Db::GetRow( Base::GetSql('Customer',array('id'=>$aCartPackage['id_user'])) );
		
		$aSmartyTemplate=String::GetSmartyTemplate('cart_package_details', array(
		'aCartPackage'=>$aCartPackage,
		'aCart'=>$aUserCart,
		'aCustomer'=>$aCustomer,
		));

		/*$sUserrEmail=Auth::$aUser['type_']=='manager'?Db::GetOne("select email from user where id='".$_SESSION['current_cart_package']['new_user']."'"):Auth::$aUser['email'];
		Mail::AddDelayed($sUserrEmail
		,$aSmartyTemplate['name'].$aCartPackage['id'],
		$aSmartyTemplate['parsed_text']);*/

		if (Base::GetConstant("manager:enable_order_notification_on_email","1")) {
		      $aSmartyTemplate=String::GetSmartyTemplate('manager_mail_order', array(
				      'aCartPackage'=>$aCartPackage,
				      'aCart'=>$aUserCart,
		      ));
		      Mail::AddDelayed(Auth::$aUser['manager_email'].", ".Base::GetConstant('manager:email_recievers','info@moregoods.com.ua')
		      ,$aSmartyTemplate['name']." ".$aCartPackage['id'],
		      $aSmartyTemplate['parsed_text'],'',"info",false);
		}

		if ($aCartPackage['id'] && Finance::HaveMoney($aCartPackage['price_total'],$aCartPackage['id_user'])) {
			$this->SendPendingWork($aCartPackage['id']);
		}

		$_SESSION['current_cart_package']['price_total'] = Currency::PrintPrice($aCartPackage['price_total'],0,2,'<none>');
		Base::$sText.=Base::$tpl->fetch("index_include/success.tpl");
		Base::$sText.=Base::$tpl->fetch("cart/payment_end_button.tpl");
	}
	//-----------------------------------------------------------------------------------------------
	/**
	 * Methos for payment for cart package
	 */
	public function PaymentEndButton()
	{
		Base::$tpl->assign('iPathStep',5);
		Base::$sText.=Base::$tpl->fetch("cart/path_cart_package.tpl");

		$aCartPackage=Db::GetRow(Base::GetSql('CartPackage',array(
		'id'=>(Base::$aRequest['id_cart_package']? Base::$aRequest['id_cart_package']:-1),
		)));

		$aTextTemplate=String::GetSmartyTemplate('payment_end', array(
		'aCartPackage'=>$aCartPackage,
		));
		Base::$sText.=$aTextTemplate['parsed_text'];

		$aPaymentType=Db::GetRow(Base::GetSql('PaymentType',array('id'=>Base::$aRequest['data']['id_payment_type'])));
		Base::$tpl->assign('aPaymentType',$aPaymentType);
		Base::$sText.=$aPaymentType['end_description'];

		$_SESSION['current_cart_package']['price_total'] = Currency::PrintPrice($aCartPackage['price_total'],0,2,'<none>');

		Base::$sText.=Base::$tpl->fetch("cart/payment_end_button.tpl");
	}
	//-----------------------------------------------------------------------------------------------

	/**
	 * Main method to send carts to orders and withdraw money for that
	 *
	 * @param $iIdCartPackage
	 * @return unknown
	 */
	public function SendPendingWork($iIdCartPackage)
	{
		$aCartPackage=Db::GetRow( Base::GetSql('CartPackage',array('id'=>$iIdCartPackage)));
		$aUserCart=Db::GetAll("select * from cart
			where id_cart_package='$iIdCartPackage'
				and order_status='new'
				and type_='order'");		//30.12.2016
		$aCustomer=Db::GetRow( Base::GetSql('Customer',array('id'=>$aCartPackage['id_user'])) );

		if (!$aCartPackage || !$aUserCart) return false;

		$aUserCartId=array();
		$aFullPaymentCart=array();
		foreach ($aUserCart as $aValue) {
			$dPriceTotal+=$aValue['price']*$aValue['number'];
			$aUserCartId[]=$aValue['id'];
		}

		//		if (Finance::HaveMoney($aCartPackage['price_total'],$aCartPackage['id_user']) &&
		//			$aCartPackage['order_status']=="pending") {
		//			Finance::Deposit($aCartPackage['id_user'],-$aCartPackage['price_total'],
		//				Language::getMessage("Autopayment order #")." $aCartPackage[id]",$aCartPackage[id],
		//				'internal','internal','',9);
		//			Db::Execute("update cart set order_status='new',post_date=now()	where id in (".implode(',',$aUserCartId).")");
		//			Db::Execute("update cart_package set order_status='work',is_payed=1 where id='$iIdCartPackage'");
		//		}

		Db::Execute("update cart_package set order_status='work' where id='$iIdCartPackage'");
		Db::Execute("update cart set order_status='new',post_date=now()	where id in (".implode(',',$aUserCartId).")");
	}
	//-----------------------------------------------------------------------------------------------
	public function PackagePrint()
	{
		$aCartPackage=Db::GetRow(Base::GetSql('CartPackage',array(
		'where'=>"and cp.id='".Base::$aRequest['id']."' and cp.id_user='".Auth::$aUser['id']."'")));
		$aUserCart=Db::GetAll(Base::GetSql("Part/Search",array(
		"where"=>" and c.id_cart_package='".Base::$aRequest['id']."' and c.type_='order' and c.id_user='".Auth::$aUser['id']."'",
		)));
		$aCustomer=Db::GetRow(Base::GetSql('Customer',array(
		'id'=>($aCartPackage['id_user']? $aCartPackage['id_user']:-1),
		)));
		if (!$aUserCart || !$aCartPackage) Base::Redirect('?action=cart_package&table_error=cart_package_not_found');
		$aAccount=Db::GetRow(Base::GetSql('Account',array('where'=>" and is_active=1")));
		if (!$aAccount) Base::Redirect('?action=cart_package_list&table_error=cart_package_list_no_active_account');
		
		$aCartPackage['summa_fact']=$aCartPackage['summa_fact']-$aCartPackage['bonus'];
		$aCartPackage['price_total_string']=Currency::CurrecyConvert(Currency::PrintPrice($aCartPackage['summa_fact'],1,2,'<none>'),
		Base::GetConstant('global:base_currency'));
		$aCartPackage['nds']=round((Currency::PrintPrice($aCartPackage['price_total'],1,2,'<none>')/118*18),2);

		Base::$tpl->assign('aUserCart',$aUserCart);
		Base::$tpl->assign('aCartPackage',$aCartPackage);
		Base::$tpl->assign('aCustomer',$aCustomer);
		Base::$tpl->assign('aAccount',$aAccount);
		Base::$tpl->assign('aActiveAccount',$aAccount);

		PrintContent::Append(Base::$tpl->fetch('cart/package_print.tpl'));
		Base::Redirect('?action=print_content&return=cart_package_list');

	}
	//-----------------------------------------------------------------------------------------------
	public function PackageList()
	{
		
		/*Base::$aTopPageTemplate=array('panel/tab_customer_cart.tpl'=>'cart_package');

		//--------------------------------------------------------------------------
		if (Base::$aRequest['is_post'] && Base::$aRequest['action']!='cart_package_order') {
			//[----- UPDATE -----------------------------------------------------]
			if(Base::$aRequest['edit']) {
			    foreach (Base::$aRequest['edit'] as $iCart => $aEdit) {
			        if($aEdit['number'] && intval($aEdit['number'])>0 && intval($aEdit['number']) < 999) Db::Execute("update cart set number='".intval($aEdit['number'])."' where id='".$iCart."' ");
			        if($aEdit['delete']) Db::Execute("delete from cart where id='".$iCart."' ");
			    }

			    $iCartPackagePriceTotal=0;
			    $aUserCart=Db::GetAll("select * from cart where id_cart_package='".Base::$aRequest['id']."' ".Auth::$sWhere);
			    if($aUserCart) foreach ($aUserCart as $sKey => $aValue) {
			        $iTotal=$aValue['price']*$aValue['number'];
			        $aUserCart[$sKey]['total']=$iTotal;
			        $iCartPackagePriceTotal+=$iTotal;
			    }
			}

			$aCartPackageUpdate=String::FilterRequestData(Base::$aRequest['data'],array('id_payment_type','customer_comment'));
			if($iCartPackagePriceTotal) {
			    $aCartPackageUpdate['price_total']=$iCartPackagePriceTotal+$aCartPackageUpdate['price_delivery'];
			}
			Db::AutoExecute('cart_package',$aCartPackageUpdate,'UPDATE'," id='".Base::$aRequest['id']."' ".Auth::$sWhere);

			Base::Redirect("/?action=cart_package_list");
		}


		if (Base::$aRequest['action']=='cart_package_edit') {
			$aCartPackage=Db::GetRow("select * from cart_package where id='".Base::$aRequest['id']."'
						".Auth::$sWhere);
			Base::$tpl->assign('aCartPackage',$aCartPackage);
			if($aCartPackage['order_status']=='new') {						//30.12.2016
			    //allow change count etc
			    $aUserCart=Db::GetAll("select * from cart where id_cart_package='".$aCartPackage['id']."'
							 ".Auth::$sWhere);
			    if($aUserCart) foreach ($aUserCart as $sKey => $aValue) {
			        $aUserCart[$sKey]['total']=$aValue['price']*$aValue['number'];
			    }
			    Base::$tpl->assign('aUserCart',$aUserCart);
			}
			Base::$tpl->assign('aPaymentType',Db::GetAssoc('Assoc/PaymentType',array('where'=>" and pt.visible=1")));

			$aData=array(
			'sHeader'=>"method=post",
			'sTitle'=>"Cart Package",
			'sContent'=>Base::$tpl->fetch('cart/form_cart_package.tpl'),
			'sSubmitButton'=>'Apply',
			'sSubmitAction'=>'cart_package_list',
			'sReturnButton'=>'<< Return',
			'sReturnAction'=>'cart_package_list',
			'sError'=>$sError,
			'sWidth'=>'100%'
			);
			$oForm=new Form($aData);

			Base::$sText.=$oForm->getForm();

			return;
		}

		$aAdress=Db::GetAssoc("select a.id as adr,a.* from ec_addres as a
		    where a.id_user='".Auth::$aUser['id_user']."' ");
		Base::$tpl->assign('aAdress',$aAdress);

		$oTable=new Table();
		$oTable->sSql=Base::GetSql('CartPackage',array(
		'where'=>" and cp.is_archive='0'	and cp.id_user='".Auth::$aUser['id']."'",
		));
		$oTable->aOrdered="order by cp.post_date desc";
		$oTable->aColumn=array(
		'id'=>array('sTitle'=>'ID'),
		'order_status'=>array('sTitle'=>'Order Status'),
		'price_total'=>array('sTitle'=>'Total'),
		'customer_comment'=>array('sTitle'=>'Comment'),
		'post'=>array('sTitle'=>'Date'),
		'action'=>array(),
		);
		$oTable->sDataTemplate='cart/row_cart_package.tpl';
		$oTable->sButtonTemplate='cart/button_cart_package.tpl';
		$oTable->bCheckVisible=false;
		//$oTable->aCallback=array($this,'CallParseCartPackage');

		Base::$sText.=$oTable->getTable("Cart Packages",'cart_package_table');*/


	    Base::$aTopPageTemplate=array('panel/tab_customer_cart.tpl'=>'cart_package');

	    //--------------------------------------------------------------------------
	    if (Base::$aRequest['is_post'] && Base::$aRequest['action']!='cart_package_order') {
	        //[----- UPDATE -----------------------------------------------------]
	        $aCartPackageUpdate=String::FilterRequestData(Base::$aRequest['data'],array('id_payment_type','customer_comment'));
	        Db::AutoExecute('cart_package',$aCartPackageUpdate,'UPDATE'," id='".Base::$aRequest['id']."' ".Auth::$sWhere);

	        Base::Redirect("/?action=cart_package_list");
	    }

	    if (Base::$aRequest['action']=='cart_package_edit') {
	        if (Base::$aRequest['action']=='cart_package_edit') {
	            $aCartPackage=Db::GetRow("select * from cart_package where id='".Base::$aRequest['id']."'
							".Auth::$sWhere);
	            Base::$tpl->assign('aData',$aCartPackage);
	        }
	        Base::$tpl->assign('aPaymentType',Db::GetAssoc('Assoc/PaymentType',array('where'=>" and pt.visible=1")));

	        $aData=array(
	            'sHeader'=>"method=post",
	            'sTitle'=>"Cart Package",
	            'sContent'=>Base::$tpl->fetch('cart/form_cart_package.tpl'),
	            'sSubmitButton'=>'Apply',
	            'sSubmitAction'=>'cart_package_list',
	            'sReturnButton'=>'<< Return',
	            'sReturnAction'=>'cart_package_list',
	            'sError'=>$sError,
	        );
	        $oForm=new Form($aData);

	        Base::$sText.=$oForm->getForm();

	        return;
	    }

		$aData=array(
		'sHeader'=>"method=get",
		//'sTitle'=>"Order Items",
		'sContent'=>Base::$tpl->fetch('cart/form_cart_package_search.tpl'),
		'sSubmitButton'=>'Search',
		'sSubmitAction'=>'cart_package_list',
		'sReturnButton'=>'Clear',
		'bIsPost'=>0,
		//'sWidth'=>'90%',
		//'sError'=>$sError,
		);
		$oForm=new Form($aData);
		Base::$sText.=$oForm->getForm();

	   // $sWhere='';
	    if(Base::$aRequest['search']['order_status']) {
	        $sWhere.=" and cp.order_status='".Base::$aRequest['search']['order_status']."' ";
	    }
	    if(Base::$aRequest['search']['id_cart_package']) {
	        $sWhere.=" and cp.id='".Base::$aRequest['search']['id_cart_package']."' ";
	    }
	    if(Base::$aRequest['search']['code']) {
	        $sWhere.=" and cart.code like '%".Base::$aRequest['search']['code']."%' ";
	    }
	    if(Base::$aRequest['search']['datestart']) {
		    $iDate=strtotime(Base::$aRequest['search']['datestart']);
		    $sWhere.=" and DATE(cp.post_date) >= '".date("Y-m-d",$iDate)."' ";
		}
		if(Base::$aRequest['search']['dateend']) {
		    $iDate=strtotime(Base::$aRequest['search']['dateend']);
		    $sWhere.=" and DATE(cp.post_date) <= '".date("Y-m-d",$iDate)."' ";
		}
		if (Base::$aRequest['search']['status_liq']) {
			$sWhere.=" and cp.is_payed='".Base::$aRequest['search']['status_liq']."' ";
		}
		
	    $aCartPackage=Db::GetAll(Base::GetSql('CartPackage',array(
	    'join'=>" inner join cart on cart.id_cart_package=cp.id ",
	    'where'=>" and cp.is_archive='0' and cp.id_user='".Auth::$aUser['id']."'".$sWhere,
	    )));
//Debug::PrintPre(Base::$aRequest);

	    $sAlreadySent = Db::GetOne("select id from mail_delayed where subject  like '%Подтверждение заказа  ".$aCartPackage['id']."%'");
			
		Base::$tpl->assign('sAlreadySent',$sAlreadySent);
		
	    $aCartPackage= array_reverse($aCartPackage);
	    $this->CallParsePackage($aCartPackage);

	    include_once(SERVER_PATH.'/class/module/LiqPay.php'); 
	  
		$liqpay = new LiqPay('i54276112930', "R15mltUEp2UkL7pPI3FebTV10V0nsZ7w3DPoehz9");
       
		foreach ($aCartPackage as $key => $value) {		
		 $aCartPackage[$key]['html'] = $liqpay->cnb_form(array(
            'action'         => 'pay',
            'amount'         => $value['summa_fact'],
            'currency'       => 'UAH',
            'description'    => 'Замовлення: #'.$value['id'],
            'order_id'       => $value['id'],
            'version'        => '3'
            ));
		 }
	    Base::$tpl->assign('aCartPackage',$aCartPackage);
	    Base::$sText.=Base::$tpl->fetch('cart/package_list_new.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	public function CallParsePackage(&$aItem) {
	    //Debug::PrintPre($aItem);
	    if ($aItem) {
	        //$aImages=Db::GetAssoc("select ");
	        foreach($aItem as $sKey => $aValue) {
	            $aCart=Db::GetAll(Base::GetSql("Part/Search",array("id_cart_package"=>$aValue["id"])));

	            if ($aCart) foreach ($aCart as $sKeyItem=> $aCartItem) {
	                if ($aCartItem['order_status']=='reclamation') $aItem[$sKey]['is_reclamation']=1;
	                $aCart[$sKeyItem]['history']=Db::GetAssoc("select cl.* from cart_log as cl	where id_cart = ".$aCartItem["id"]);
	                $aCart[$sKeyItem]['image'] = Db::GetOne("select image from ec_products where id ='". $aCart[$sKeyItem]['id_product'] ."'");
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

	        }
	        Base::$tpl->assign('sHeader',Language::GetMessage("Cart Packages"));
	    }
	    //Debug::PrintPre($aItem);
	   // Base::$tpl->assign('sClass',"atp-table");
	}
	//-----------------------------------------------------------------------------------------------
	public function NewAccountError()
	{
		if (!Base::$aRequest['data']['user_agreement'])
		return "You need to apply user agreemnt";

		if (!Base::$aRequest['data']['login']||!Base::$aRequest['data']['password']||!Base::$aRequest['data']['email'])
		return "Please, enter all the fields";

		if (Base::$aRequest['data']['password']!=Base::$aRequest['data']['verify_password'])
		return "Passwosds are different. Please try again";

		if (Base::$aRequest['data']['password']==Base::$aRequest['data']['login'])
		return "Login and password must be different. Please try again";

		if (strlen(Base::$aRequest['data']['password'])<4)
		return "Password can't be less then 4 digits";

		if (!String::CheckEmail(Base::$aRequest['data']['email']))
		return "Please, check your email";

		$sQuery="select * from user where login='".Base::$aRequest['data']['login']."'";
		$aUser=Db::GetRow($sQuery);
		if ($aUser)	return "This login is already occupied. Please choose different one.";

		$sQuery="select * from user where email='".Base::$aRequest['data']['email']."'";
		$aUser=Db::GetRow($sQuery);
		if ($aUser)	return "This email is already registered. Please use the link \"Forgot password\".";

		return false;
	}
	//-----------------------------------------------------------------------------------------------
	public function NewAccountManagerError()
	{
		if (!Base::$aRequest['data']['login']||!Base::$aRequest['data']['password']||!Base::$aRequest['data']['name']||!Base::$aRequest['data']['phone'])
		return "Please, enter all the fields";

		if (Base::$aRequest['data']['password']!=Base::$aRequest['data']['verify_password'])
		return "Passwosds are different. Please try again";

		if (Base::$aRequest['data']['password']==Base::$aRequest['data']['login'])
		return "Login and password must be different. Please try again";

		if (strlen(Base::$aRequest['data']['password'])<4)
		return "Password can't be less then 4 digits";

		$sQuery="select * from user where login='".Base::$aRequest['data']['login']."'";
		$aUser=Db::GetRow($sQuery);
		if ($aUser)	return "This login is already occupied. Please choose different one.";

		return false;
	}
	//-----------------------------------------------------------------------------------------------
	public function PopUpGetOwnAuto() {
		Base::$oResponse->AddAssign('popup_caption_id','innerHTML', Language::GetMessage('Select your auto'));

		$oTable=new Table();
		$oTable->iRowPerPage=500;
		$oTable->sSql=Base::GetSql('UserAuto',array());
		$oTable->aOrdered="order by ua.id desc";
		$oTable->aColumn=array(
				'id_make'			=> array('sTitle'=>Language::GetMessage('Make auto')),
				'id_model'			=> array('sTitle'=>Language::GetMessage('Model auto')),
				'year'				=> array('sTitle'=>Language::GetMessage('Year')),
		);
		$oObject = new OwnAuto();
		$oTable->sDataTemplate='cart/row_user_auto.tpl';
		$oTable->aCallback=array($oObject,'CallParseUserAuto');
		$oTable->sTemplateName = 'cart/table_popup.tpl';
		$sText = $oTable->getTable("User auto");

		// add auto hidden form
		$oObject = new OwnAuto();
		$sText .= '<div id="add_form_auto" style="display:none;">' . $oObject->GetFormAddAuto($oObject, "Add auto", "") ."</div>";

		Base::$tpl->assign('sContent',$sText);
		Base::$oResponse->AddAssign('popup_content_id','innerHTML',Base::$tpl->fetch('cart/message.tpl'));
	}
	//-----------------------------------------------------------------------------------------------
	public function RecalcCartUser($iIdUser,$iIdUserNotManager = 0)
	{
			$aCart = Db::GetAll("Select * from cart where id_user=".$iIdUser." and type_='cart'");
			$aUser = Auth::$aUser;
	    
		if (Auth::$aUser['id'] && Auth::$aUser['type_']=='customer')
	    {
			$User_discount=Auth::$aUser['id'];
			$Discounts=Db::GetOne("select count( * ) from ec_discounts di where id_region='".$this->iIdRegion."' and id_user='".$User_discount."' ");
	    }
	    elseif (Auth::$aUser['id'] && Auth::$aUser['type_']=='manager')
	    {
			$User_discount=Db::GetOne("select id_customer_partner as user_discount from user_manager um where id_user='".Auth::$aUser['id']."' ");
			$Discounts=Db::GetOne("select count( * ) from ec_discounts di where id_region='".$this->iIdRegion."' and id_user='".$User_discount."' ");
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
				'discounts'=>$Discounts,
				'user_discount'=>$User_discount,
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
	//-----------------------------------------------------------------------------------------------
	public function GetBoardExpiredCartUser($iIdUser) {
		$aUser = Db::GetRow(Base::GetSql("Customer",array('id'=>$iIdUser)));
		if ($aUser['hours_expired_cart'])
			return $aUser['hours_expired_cart'];
		return 0;
	}
	//-----------------------------------------------------------------------------------------------
	public function CartExpiredCountPositions($iUserId = 0) {
		if ($iUserId == 0)
			$iUserId = Auth::$aUser['id'];

		if ($iUserId == 0)
			return 0;

		return Db::GetOne("select count(*) from cart_deleted where id_user = ".$iUserId);
	}
	//-----------------------------------------------------------------------------------------------
	public function CartExpiredInfo($iUserId = 0) {
		if ($iUserId == 0)
			$iUserId = Auth::$aUser['id'];

		if ($iUserId == 0) {
			Base::Redirect('/pages/cart_cart');
		}

		$oTable=new Table();
		$sWhere.=" and c.id_user=".$iUserId;
		$oTable->sSql=Base::GetSql("Part/SearchExpired",array(
				"type_"=>'cart',
				"where"=>$sWhere,
		));

		$oTable->aOrdered="order by c.post_delete desc";
		$oTable->iRowPerPage=30;
		$oTable->aColumn=array(
				'post_delete'=>array('sTitle'=>'Date delete'),
				'brand'=>array('sTitle'=>'Brand'),
				'code'=>array('sTitle'=>'CartCode'),
		);
		$oTable->sDataTemplate='cart/row_cart_expired.tpl';
		$oTable->sButtonTemplate='cart/button_cart_expired.tpl';
		$oTable->bCheckVisible=false;
		$oTable->bStepperVisible=false;

		Base::$sText.=$oTable->getTable("Cart Items Deleted");
		Base::$tpl->assign('aData',$aData);
	}
	//-----------------------------------------------------------------------------------------------
	public function OrderByPhone(){
		Base::$aRequest['phone']=Base::$aRequest['data']['order_by_phone'];
		Base::$aRequest['data']['phone']=Base::$aRequest['data']['order_by_phone'];
		Base::$aRequest['email']=Base::$aRequest['data']['email'];
		if (!Capcha::CheckMathematic()) {
//				$sError = "Check capcha value";
//							$oTable->sTableMessage=Language::GetText("exist_expired_cart");
//						Base::$tpl->assign('sTableMessageClass','warning_p');
//						Base::$tpl->assign('sTableMessage',$sError);
						$_SESSION['user_phone']=Base::$aRequest['phone'];
						$_SESSION['user_name']=Base::$aRequest['data']['name'];
						$_SESSION['user_email']=Base::$aRequest['data']['email'];
						$_SESSION['user_comment']=Base::$aRequest['data']['remark'];
						
						Base::Redirect("/?action=cart_onepage_order&capcha_error=check_capcha_value");
				}
			else {
			if(Base::$aRequest['phone']) {
				
			$sCustomerComment='New internet client.  phone: '.Base::$aRequest['phone'].' name: '.Base::$aRequest['data']['name'].' email: '.Base::$aRequest['data']['email'].' comment: '.Base::$aRequest['data']['remark'].' login: '.Auth::$aUser['login'];
				
			$aCartList=Db::GetAll(Base::GetSql("Part/Search",array(
				"type_"=>'cart',
				"where"=>" and c.id_user=".Auth::$aUser['id'],
			)));
//aRow.provider_name
			if (!$aCartList) Base::Redirect('/?action=cart_cart&table_error=cart_not_found');
			else {
				$aSmartyTemplate=String::GetSmartyTemplate('cart_order_by_phone', array(
					'sPhone'=>Base::$aRequest['phone'],
					'sCustomerComment'=>$sCustomerComment,
					'aCart'=>$aCartList,
				));

				if(!Customer::IsChangeableLogin(Auth::$aUser['login'])) {
					//normal user
					$iUserId=Auth::$aUser['id'];

					if(Auth::$aUser['type_']=='manager') {
						//manager
						$aOrderUser=Auth::AutoCreateUser();
						$iUserId=$aOrderUser['id'];

						// recalc cart
						User::RecalcCart($iUserId,1);
						// reload cart with new prices
						$aCartList=Db::GetAll(Base::GetSql("Part/Search",array(
								"type_"=>'cart',
								"where"=>" and c.id_user=".Auth::$aUser['id'],
						)));

					} else {
						//update user phone
						Db::Execute("update user_customer set phone='".Base::$aRequest['phone']."' where id_user='".$iUserId."' ");
					}
				} else {
					//guest
					$aOrderUser=Auth::AutoCreateUser();
					Db::Execute("update user_customer set is_order_by_phone_customer=1 where id_user=".$aOrderUser['id']);
						
					$aManager=Db::GetRow("select u.*,um.* from user_manager um,user u
					where u.id=um.id_user and u.visible=1 and um.has_customer=1 and um.has_order_by_phone_customer=1 and um.id_region='".$aOrderUser['id_region']."' and um.id_customer_group='".$aOrderUser['id_customer_group']."' order by rand()");
					
					if (!$aManager) $aManager=Db::GetRow("select u.*,um.* from user_manager um,user u
					where u.id=um.id_user and u.visible=1 and um.has_customer=1 and um.has_order_by_phone_customer=1 and um.id_region='".$aOrderUser['id_region']."'  order by rand()");
					
					if($aManager){
						Db::Execute("update user_customer set id_manager=".$aManager['id']." where id_user=".$aOrderUser['id']);
						$aOrderUser['id_manager']=$aManager['id'];
					}
					$iUserId=$aOrderUser['id'];
				}

				$dPriceTotal=0;
				$aUserCartId=array();
				foreach ($aCartList as $aValue) {
					$dPriceTotal+=Currency::PrintPrice($aValue['price'],null,2,"<none>")*$aValue['number'];
					$aUserCartId[]=$aValue['id'];
				}

			$sCustomerComment='Новий інтернет клієнт.'.PHP_EOL.'Телефон: '.Base::$aRequest['phone'].' '.PHP_EOL.'Ім\'я: '.Base::$aRequest['data']['name'].' '.PHP_EOL.'email: '.Base::$aRequest['data']['email'].' '.PHP_EOL.'Коментар:'.PHP_EOL.''.Base::$aRequest['data']['remark'];

				$aCartpackageInsert=array(
					'id_user'=>$iUserId,
					'price_total'=>$dPriceTotal + 0,
					'order_status'=>'new',												//30.12.2016
					'id_delivery_type'=>6,			//Нова Пошта
					'id_payment_type'=>3,			//Наложений платіж (Нова пошта)
					'price_delivery'=>0,
					'customer_comment'=>$sCustomerComment,
					'name_manager'=>Auth::$aUser['login'],				//28.12.2016
//					'date_delivery'=>date("Y-m-d",strtotime(Base::$aRequest['date_delivery'])),				//29.12.2016
					'is_need_check' => 0,
					'id_own_auto' => 0
				);
				$aCartpackageInsert=String::FilterRequestData($aCartpackageInsert);
				Db::AutoExecute('cart_package',$aCartpackageInsert);
				$iCartPackageId=Base::$db->Insert_ID();
				$aCartPackage=Db::GetRow(Base::GetSql('CartPackage',array('id'=>$iCartPackageId,)));
				//30.12.2016
				Db::Execute("update cart set type_='order', id_cart_package='$iCartPackageId' ,order_status='new', id_user='$iUserId'
				where id in (".implode(',',$aUserCartId).")");

				Mail::AddDelayed(Base::GetConstant('order_by_phone_email','info@moregoods.com.ua'),$aSmartyTemplate['name'].":".$aCartPackage['id']." - ".Base::$aRequest['phone'],$aSmartyTemplate['parsed_text']);

				if ($aCartPackage['id'] && Finance::HaveMoney($aCartPackage['price_total'],$aCartPackage['id_user'])) {
					$this->SendPendingWork($aCartPackage['id']);
				}
				$_SESSION['user_phone']='';
				$_SESSION['user_name']='';
				$_SESSION['user_email']='';
				$_SESSION['user_comment']='';

				Base::$tpl->assign('aCartPackage',$aCartPackage);

				$bSuccess_by_phone=1;
				Base::$tpl->assign('bSuccess_by_phone',$bSuccess_by_phone);
//				Base::$sText.=Language::GetText("order_by_phone_success");
				Base::$sText.=Base::$tpl->fetch("index_include/success.tpl");
				
		if (Auth::IsAuth()) Cart::LogCart();
			}
		}
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function AddToExistingOrder() {
	    if(!Base::$aRequest['id_order']) Base::Redirect("/pages/cart_cart/");

	    $aCartPackage=Db::GetRow(Base::GetSql('CartPackage',array('id'=>Base::$aRequest['id_order'])));
	    if($aCartPackage['order_status']=='new') {															//30.12.2016
	        //merge order
	        $aUserCart=Db::GetAll(Base::GetSql("Part/Search",array(
	            "type_"=>'cart',
	            "where"=> " and c.id_user='".Auth::$aUser['id']."'",
	        )));
	        if($aUserCart) {
	            $aUserCartId=array();
	            foreach ($aUserCart as $aValue) $aUserCartId[]=$aValue['id'];
	            //30.12.2016
	            Db::Execute("update cart set type_='order', id_cart_package='".$aCartPackage['id']."' ,order_status='new', id_user='".Auth::$aUser['id']."'
	            where id in (".implode(',',$aUserCartId).")");

	            //recalc total and update order
	            $iCartPackagePriceTotal=0;
	            $aUserCart=Db::GetAll("select * from cart where id_cart_package='".$aCartPackage['id']."' ".Auth::$sWhere);
	            if($aUserCart) foreach ($aUserCart as $sKey => $aValue) {
	                $iTotal=$aValue['price']*$aValue['number'];
	                $aUserCart[$sKey]['total']=$iTotal;
	                $iCartPackagePriceTotal+=$iTotal;
	            }

	            $iCartPackagePriceTotal=$iCartPackagePriceTotal+$aCartPackage['price_delivery'];
	            Db::Execute("update cart_package set price_total='".$iCartPackagePriceTotal."' where id='".$aCartPackage['id']."' ");
	        }

	        Base::Redirect("/?action=cart_package_edit&id=".$aCartPackage['id']);
	    } else {
	        //error
	        Base::Redirect("/pages/cart_cart/?aMessage[MT_ERROR]=".Language::GetMessage('can not add to order'));
	    }

	}
	//-----------------------------------------------------------------------------------------------
	public function LiqPayRequest(){

        $liqpay = new LiqPay('i54276112930', "R15mltUEp2UkL7pPI3FebTV10V0nsZ7w3DPoehz9");
            $html = $liqpay->cnb_form(array(
            'action'         => 'pay',
            'amount'         => Base::$aRequest['amount'],
            'currency'       => 'UAH',
            'description'    => 'Замовлення #'.Base::$aRequest['order_id'],
            'order_id'       => Base::$aRequest['order_id'],
            'version'        => '3'
            ));
        Base::$tpl->assign('html',$html);
    }
	/**
	* Возвращаем на первую страницу,
	* в случае отсутствии переданных переменных (прямого захода на страницу)
	*/
	/*if (empty($_POST)) {
	 header('http://moregoods.lc/pages/cart_package_list');
	 exit;
	}*/

	/**
	* 1. Страница проверки данных плательщиком.
	* 2. Формирование API 2.0 LiqPay для отправки на Ликпэй.
	*/

	/** Забираеем некоторые значения с предидущей страницы (из $_POST) **/
	/*$amount = $_POST['amount'];
	$description = $_POST['Description'];

	/** Выводим пользователю ранее введенные им данные (проверка). **/
	/*echo '<p>
	 <b>Сумма:</b>&nbsp;'. $amount . '&nbsp;$<br />
	 <b>Назначение платежа:</b>&nbsp;' . $description . '<br />
	 <b>e-mail:</b>&nbsp;' . $_POST['SenderMail'] . '</p>';*/

	/** Определение переменных для формы API 2.0 LiqPay **/
	/*$order_id = date("d/m/Y-H:i:s");//id заказа
	$merchant_id = 'i54276112930'; //ID мерчанта (прием платежей на карту/счет). Он же public_key
	$private_key = "R15mltUEp2UkL7pPI3FebTV10V0nsZ7w3DPoehz9"; //Подпись мерчанта
	$return_url = 'http://moregoods.lc/pages/cart_package_list';     //страница на которую вернется клиент
	$server_url = $return_url; //страница на которую придет ответ от сервера
	$currency = 'UAH'; //Валюта
	$order_id = array( // Берем необходимые значения платежа, для отсылки информации результата платежа (после платежа)
	                0 => date("d/m/Y_H:i:s"), //ID покупки в Вашем магазине. Должен быть УНИКАЛЬНЫМ для каждого платежа.
	                1 => $_POST['SenderMail'], //e-mail покупателя. Необходим для отсылки уведомления о статусе его платежа.
	                ); //print_r($order_id);
	$order_id = implode('~', $order_id); //преобразуем массив в строку
	$type = 'buy';//buy - покупка, donate - пожертвование, subscribe - подписка
	$sandbox = 0; //для теста-1, рабочий-0

	/**
	* Подпись запроса.
	* Внимание!!!
	* 1) Алгоритм формирования подписи, приведенный на https://www.liqpay.com/ru/doc#callback
	*    как 'Проверка Callback сигнатуры' здесь не работает. При отправке запроса - просто НЕизвестны
	*    переменные  status (статус платежа после оплаты), transaction_id (Id платежа в системе LiqPay),
	*    sender_phone (номер телефона плательщика)
	* 2) Также НЕ работает алгоритм - base64_encode(sha1(...));
	*    Он закомментирован ниже
	*/
	/*$signature = base64_encode(sha1(join('',compact(
	 'private_key',
	 'amount',
	 'currency',
	 'merchant_id',
	 'order_id',
	 'type',
	 'description',
	 'return_url',
	 'server_url'
	)),1));

	/** Нерабочий алгоритм **/
	// $signature = base64_encode(sha1(
	//          private_key .
	//          amount .
	//          currency .
	//          merchant_id . //public_key .
	//          order_id .
	//          type .
	//          description .
	//          return_url .
	//          server_url
	// ,1));

	/** Форма API 2.0 LiqPay **/
	/*echo '<form id="liqpay" method="POST" action="https://www.liqpay.com/api/pay" accept-charset="utf-8">
	      <input type="hidden" name="public_key" value="' . $merchant_id . '" />
	      <input type="hidden" name="amount" value="' . $amount . '" />
	      <input type="hidden" name="currency" value="' . $currency . '" />
	      <input type="hidden" name="description" value="' . $description . '" />
	      <input type="hidden" name="order_id" value="' . $order_id . '" />
	      <input type="hidden" name="result_url" value="' . $return_url . '" />
	      <input type="hidden" name="server_url" value="' . $server_url . '" />  
	      <input type="hidden" name="type" value="' . $type . '" />
	      <input type="hidden" name="signature" value="' . $signature . '" />
	      <input type="hidden" name="language" value="RU" />
	      <input type="hidden" name="sandbox" value="' . $sandbox . '" />';*/


      
      
	//-----------------------------------------------------------------------------------------------
}
?>