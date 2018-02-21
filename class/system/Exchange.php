<?php
/**
 * @author Yuriy Korzun
 */

class Exchange extends Base
{
	var $sTempDir = '/imgbank/temp_upload/exchange/';
	var $iTimer;
	var $iTimerMinute;
	var $bAutoImport = 0;
	var $aType=array(
	'sale'=>'sale',
	'catalog'=>'catalog',
	);
	//-----------------------------------------------------------------------------------------------
	private function Auth()
	{
			header('WWW-Authenticate: Basic realm="Who are you?"');
			header('HTTP/1.0 401 Unauthorized');
			die('Access denied');
	}
	//-----------------------------------------------------------------------------------------------
	public function __construct()
	{
		if(isset($_SERVER['HTTP_AUTHORIZATION'])) {
			$aAuthParams = explode(":" , base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
			$_SERVER['PHP_AUTH_USER'] = $aAuthParams[0];
			unset($aAuthParams[0]);
			$_SERVER['PHP_AUTH_PW'] = implode('',$aAuthParams);
		}
		if(Base::$aRequest['session']){
			$aUser=Db::GetRow("select * from user where password='".Base::$aRequest['session']."' and type_='manager'");
			$_SESSION['user']['isUser'.Auth::$sProjectName]=1;
			$_SESSION['user']['id']=$aUser['id'];
			$_SESSION['user']['type_']=$aUser['type_'];
		}
		$bIsAuth=Auth::IsAuth();
		//Debug::PrintPre($_SERVER);
		if (!$bIsAuth && !isset($_SERVER['PHP_AUTH_USER'])) {
			$this->Auth();
		} elseif (!$bIsAuth) {
			$aUser=Auth::IsUser($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW'],false,true);
			if(!$aUser || $aUser['type_']!='manager') $this->Auth();
			Base::$aRequest['remember_me']=1;
			Auth::Login($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW'],false,true,true);
		}
		Db::Execute("SET @lng_id = 16");
		Db::Execute("SET @cou_id = 187");
		$this->iTimer=time();
		$this->iTimerMinute=time();
	}
	//-----------------------------------------------------------------------------------------------
	public function PrintFlush($s){
		print "progress\n";
		print $s;
		ob_end_flush();
		ob_flush();
		flush();
		ob_flush();
		flush();
		ob_start();
	}
	//-----------------------------------------------------------------------------------------------
	public function PrintFlush2($s){
		print $s;
		ob_end_flush();
		ob_flush();
		flush();
		ob_flush();
		flush();
		ob_start();
	}
	//-----------------------------------------------------------------------------------------------
	public function Progress($i,$iMax,$bTimer=true)
	{
		$iDef=time()-($this->iTimerMinute);
		if ($iDef<60 && $bTimer) return;
		$this->iTimerMinute=time();
		$this->PrintFlush("Continued:".floor($i/$iMax*100)."%\n");
		return true;
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		set_time_limit(0);
		header("Expires: Thu, 01 Jan 1970 00:00:01 GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		$oManager=new Manager;
		$sType=Base::$aRequest['type'];
		$sMode=Base::$aRequest['mode'];
		if(in_array($sType, $this->aType)){
			if($sMode=='checkauth'){//Начало сеанса
				die("success\n" . session_name() . "\n" . session_id());
			}
			if($sMode=='init'){//Запрос параметров от сайта
				$tmp_files = glob(SERVER_PATH.$this->sTempDir.'*.*');
				if(is_array($tmp_files))
				foreach($tmp_files as $v)
				{
					//unlink($v);
				}
				die("zip=no\nfile_limit=100000000\n");
				
			}
		}
		if($sType==$this->aType['sale']){// TYPE = SALE ************************************************************
			ob_start('ob_gzhandler');
			ob_implicit_flush(0); // отключаем неявную отправку буфера
			if($sMode == 'customers'){
				$no_spaces = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n".
					'<КоммерческаяИнформация ВерсияСхемы="2.04" ДатаФормирования="' . date ( 'Y-m-d' )  . '"></КоммерческаяИнформация>';
				$oXml = new SimpleXMLElement ( $no_spaces );

				$aCustomer=Db::GetAll(Db::GetSql("Customer",array(
				'where'=>" /*and u.visible=1*/ and uc.name is not null and uc.status_1c<2 /*and cp.post_date>SUBDATE(now(), INTERVAL 40 DAY)*/ "
				//'where'=>" and cp.id>'".$sLastId."'"
				)));
				//Debug::PrintPre($aCustomer);
				$doc0 = $oXml->addChild ("Контрагенты");
				if($aCustomer)
				foreach($aCustomer as $aValue)
				{
					if($sLastExportId<$aValue['id_user'])$sLastExportId=$aValue['id_user'];
					$doc = $doc0->addChild ("Контрагент");
					$doc->addAttribute ( "ID", $aValue['id_1c']);
					$doc->addAttribute ( "surname", $aValue['surname']);
					$doc->addAttribute ( "firstname", $aValue['firstname']);
					$doc->addAttribute ( "Логин", $aValue['login']);
					$doc->addAttribute ( "Телефон", $aValue['phone']);
					$doc->addAttribute ( "service_center", $aValue['service_center']);
					$doc->addAttribute ( "free_delivery", $aValue['free_delivery']);
					$doc->addAttribute ( "id_office_region", $aValue['id_office_region']);
					$doc->addAttribute ( "id_office_city", $aValue['id_office_city']);
					Db::Execute("update user_customer set status_1c=1 where id_user='".$aValue['id_user']."'");
				}
				//Base::UpdateConstant('exchange:last_order_export_id_tmp',$sLastExportId);
				header ( "Content-type: text/xml; charset=utf-8" );
				//$sOutput="\xEF\xBB\xBF" . $oXml->asXML();
				$sOutput=$oXml->asXML();
				print $sOutput;
				header('Content-Length: '.ob_get_length());
				ob_end_flush();
				die();
			}
			if($sMode == 'orders'){
				$no_spaces = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n".
					'<КоммерческаяИнформация ВерсияСхемы="2.04" ДатаФормирования="' . date ( 'Y-m-d' )  . '"></КоммерческаяИнформация>';
				$oXml = new SimpleXMLElement ( $no_spaces );
				//$sLastId=Base::GetConstant('exchange:last_order_export_id','1');
				$docs = $oXml->addChild ("Заказы");
				//---------------------------------------------------------------------------------------
				//$sLastId=Base::GetConstant('exchange:last_order_export_id','1');
				$aCartPackage=Db::GetAll(Db::GetSql("CartPackage",array(
				'where'=>" and cp.order_status='pending' and cp.status_1c<2 /*and cp.post_date>SUBDATE(now(), INTERVAL 40 DAY)*/ "
				//'where'=>" and cp.id>'".$sLastId."'"
				)));
				//Debug::PrintPre($aCartPackage);
				$aBrand1C=Base::$db->getAssoc("select pref,id from 1c_brand");
				if($aCartPackage)
				foreach($aCartPackage as $aValue)
				{
					$aCart=Db::GetAll(Db::GetSql("Cart",array(
					'where'=>" and c.id_cart_package='".$aValue['id']."'"
					)));
					//Debug::PrintPre($aCart,false);
					if($aCart){
					if($sLastExportId<$aValue['id'])$sLastExportId=$aValue['id'];
					$doc = $docs->addChild ("Заказ");
					$doc->addAttribute ( "ID", $aValue['id']);
					$doc->addAttribute ( "Date", date('Y-m-d',  strtotime($aValue['post_date'])));
					$doc->addAttribute ( "Time",  date('H:i:s',  strtotime($aValue['post_date'])));
					$doc->addAttribute ( "Total", $aValue['price_total']);
					$user = $doc->addChild ( 'Покупатель' );
					$user->addAttribute ( "Name", $aValue['name']);
					$user->addAttribute ( "Login", $aValue['login']);
					$user->addAttribute ( "Phone", $aValue['phone']);
					//$doc->addChild ( "Комментарий", $aValue['customer_comment']);
					Db::Execute("update cart_package set status_1c=1 where id='".$aValue['id']."'");

					foreach($aCart as $aValueCart)
					{
						$t1_1 = $doc->addChild ( 'Товар' );
						$t1_2 = $t1_1->addAttribute ( "ID", $aValueCart['code_in']);
						$t1_2 = $t1_1->addAttribute ( "Brand", $aBrand1C[$aValueCart['pref']]);
						$t1_2 = $t1_1->addAttribute ( "CodeCMS", $aValueCart['code']);
						$t1_2 = $t1_1->addAttribute ( "BrandCMS", $aValueCart['cat_name']);
						$t1_2 = $t1_1->addAttribute ( "Price", $aValueCart['price'] );
						$t1_2 = $t1_1->addAttribute ( "Qty", $aValueCart['number'] );
						$t1_2 = $t1_1->addAttribute ( "Total", $aValueCart['price']*$aValueCart['number'] );
					}
					}
				}
				Base::UpdateConstant('exchange:last_order_export_id_tmp',$sLastExportId);
				
				header ( "Content-type: text/xml; charset=utf-8" );
				//$sOutput="\xEF\xBB\xBF" . $oXml->asXML();
				$sOutput=$oXml->asXML();
				print $sOutput;
				header('Content-Length: '.ob_get_length());
				ob_end_flush();
				die();
			}
			if($sMode == 'file'){
				if(!Base::$aRequest['filename']) die("failure\nNo file.");
				die("error");
			}
			if($sMode == 'success'){
				Db::Execute("update user_customer set status_1c=2 where status_1c=1");
//				$a=Db::GetAssoc("select id,id as name from cart_package where status_1c=1");
//				if($a)
//				foreach ($a as $value) {
//					Cart::SendPendingWork($value);
//				}
				Db::Execute("update cart_package set status_1c=2 where status_1c=1");
				die();
				Base::UpdateConstant('exchange:last_export_date',date("Y-m-d H:i:s"));
				Base::UpdateConstant('exchange:last_order_export_id',Base::GetConstant('exchange:last_order_export_id_tmp','0'));
				die();
			}


		}elseif($sType==$this->aType['catalog']){// TYPE = CATALOG **********************************************************
			if($sMode == 'file'){
				if(!Base::$aRequest['filename']) die("failure\nNo file.");
				$sFileName = SERVER_PATH.$this->sTempDir.Base::$aRequest['filename'];
				$f = fopen($sFileName, 'w');
				fwrite($f, file_get_contents('php://input'));
				fclose($f);
				if(stripos(Base::$aRequest['filename'],'update')!==FALSE){
					Base::UpdateConstant('exchange:import_bra','0');
					Base::UpdateConstant('exchange:import_nom','0');
					Base::UpdateConstant('exchange:import_kon','0');
					Base::UpdateConstant('exchange:import_ski','0');
					Base::UpdateConstant('exchange:import_doc','0');
					Base::UpdateConstant('exchange:time_'.Base::$aRequest['filename'],date('Y-m-d H:i:s'));
					if($this->bAutoImport){
					$this->PrintFlush2("success\n");
					$url = 'http://'.$_SERVER['HTTP_HOST'];
					$params = array(
						'action' => 'exchange',
						'mode' => 'import',
						'type' => 'catalog',
						'filename' => Base::$aRequest['filename'],
						'session' => Auth::$aUser['password'],
					);
					$r=$this->SendRequest($url, $params);
					$params['return']=$r;
					Base::UpdateConstant('exchange:params_'.Base::$aRequest['filename'],print_r($params,true));
					$sNeedImport = 'import';
					die();
					}
				}
				elseif(stripos(Base::$aRequest['filename'],'sverka')!==FALSE){
					$sNeedImport = 'sverka';
				}
				if(!$this->bAutoImport) die("success");
			}

			if($sMode == 'import' || $sNeedImport == 'import'){
				if(!Base::$aRequest['filename']) die("failure\nNo file.");
				$sFileName = SERVER_PATH.$this->sTempDir.Base::$aRequest['filename'];
				if(!file_exists($sFileName)) die("failure\nFile not found.");
				$aNamePref=Base::$db->getAssoc("select upper(cp.name),cat.pref from cat_pref cp inner join cat on cat.id=cp.cat_id
					union select upper(title),pref from cat
					union select upper(pref),pref from cat");
				$aCat=Base::$db->getAssoc("select pref,c.* from cat c");
				$oXml = simplexml_load_file($sFileName);
				$iMax=10;
				$iProgress=1;
				$aProvider=Db::GetRow(Base::GetSql("Provider",array('id'=>Base::GetConstant('exchange:provider_id','241'))));

				//$this->PrintFlush2("success\n");

				$iMax++;
				if(Base::GetConstant('exchange:import_ski','0'))$iProgress++;
				$this->iTimerMinute=time();
				if(isset($oXml->Бренды) ){//&& !Base::GetConstant('exchange:import_bra','0')
					$oOffer=$oXml->Бренды;
					if($oOffer->Бренд){
						foreach($oOffer->Бренд as $aValue)
						{
							$aCart=json_decode(json_encode($aValue), TRUE); //(array)$aValue;
							$aCart=$aCart['@attributes'];
							$sName=trim(mb_strtoupper($aCart['Name']));
							$sPref=$aNamePref[$sName];
							if(!$sPref)$sPref=$aNamePref[trim(mb_strtoupper($aCart['ID']))];
							if(!$sPref){
								Db::Execute("insert ignore into cat_pref (name) values ('".mysql_escape_string ($sName)."')");
								continue;
							}
							$aBrand=array(
							'id'=>$aCart['ID'],
							'name'=>$aCart['Name'],
							'pref'=>$sPref,
							);
							Db::Execute(" insert into 1c_brand SET 
							id='".$aCart['ID']."', 
							name='".$aCart['Name']."', 
							pref='".$sPref."'
							on duplicate key update name=values(name),pref=values(pref)
							"
							);
						}
					}
				}
				if(isset($oXml->Товары) ){//&& !Base::GetConstant('exchange:import_nom','0')
					$oOffer=$oXml->Товары;
					if($oOffer->Товар){
					$aBrand1C=Base::$db->getAssoc("select id,pref from 1c_brand");
					$iProvider=Base::GetConstant('exchange:provider_id','241');
					Db::Execute(" delete from price where id_provider='".$iProvider."'");
					foreach($oOffer->Товар as $aValue)
					{
						$iProgress++;
						$aCart=json_decode(json_encode($aValue), TRUE); //(array)$aValue;
						if ($aCart['@attributes'])
							$aCart=$aCart['@attributes'];
						
						//Debug::PrintPre($aCart,false);
						$sBrand=trim($aCart['Brand']);
						$sPref=$aBrand1C[$sBrand];
						$sCode=Catalog::StripCode($aCart['ID']);
						$sCodeIn=str_replace( "'", "",$aCart['ID']);
						if(!$sPref) Db::Execute("insert ignore into cat_pref (name) values ('".mysql_escape_string ($sBrand)."')");
						if(!$sPref || !$sCode) continue;
						$sPrice=(string)$aCart['Price'];
						$sPrice=mb_ereg_replace ( '[^0-9\.,]*', '', $sPrice );
						$sPrice=str_replace( ',', '.', $sPrice );
						$sStock=$aCart['Rest']?$aCart['Rest']:'0';
						$sStock=(int)str_replace( ',', '.', $sStock );
						if($aCart['Удален']=='ложь' || !$aCart['Удален'])
						Db::Execute(" insert into price SET 
						item_code='".$sPref.'_'.$sCode."', 
						id_provider='".$iProvider."', 
						code='".$sCode."', 
						code_in='".$sCodeIn."',
						part_rus='".mysql_real_escape_string($aCart['Name'])."', 
						price='".$sPrice."', 
						pref='".$sPref."', 
						cat='".$sBrand."', 
						stock='".$sStock."'
						on duplicate key update code_in=values(code_in),price=values(price), part_rus=values(part_rus), stock=values(stock)
						"
						);
						else
						Db::Execute("delete from price where item_code='".$sPref.'_'.$sCode."' and id_provider='".$iProvider."'");
					}
					}
				}
				Base::UpdateConstant('exchange:import_nom','1');
				//if(self::Progress($iProgress,$iMax)) die();

				$this->iTimerMinute=time();
				if(isset($oXml->Контрагенты) /*&& !Base::GetConstant('exchange:import_kon','0')*/){
					$oOffer=$oXml->Контрагенты;
					if($oOffer->Контрагент)
					foreach($oOffer->Контрагент as $aValue)
					{
						$iProgress++;
						$aCustomer1C=json_decode(json_encode($aValue), TRUE);// (array)$aValue;//ID,ФИО
						$aCustomer1C=$aCustomer1C['@attributes'];
						foreach ($aCustomer1C as $key => $value) {
							$aCustomer1C[$key]=trim($value);
							//if(strpos($value,'Terra')!==false) Debug::PrintPre($aCustomer1C);
						}
						$aCustomer=Db::GetRow("select uc.*,u.login from user_customer uc inner join user u on u.id=uc.id_user
							where uc.id_1c='".$aCustomer1C['ID']."' or u.login='".$aCustomer1C['Логин']."'");
						if($aCustomer['id_user']){
							Db::Execute("update user_customer set status_1c=2,name='".mysql_escape_string($aCustomer1C['ФИО'])."',id_1c='"
									.$aCustomer1C['ID']."',address='".mysql_escape_string($aCustomer1C['Адрес'])."'
									,phone='".mysql_escape_string($aCustomer1C['Телефон'])."'
									where id_user='".$aCustomer['id_user']."'");
							if(trim($aCustomer1C['Email']) && ($aCustomer1C['head']=='' || $aCustomer1C['head']==$aCustomer1C['ID'] )){
								$sLogin=$aCustomer1C['Email'];
							}else{
								$sLogin=$aCustomer['login'];
							}
							$sLogin=trim($sLogin);
							if(!$sLogin){
								Debug::PrintPre($aCustomer,false);
								$aCustomer1C['error']='Empty login/email';
								Debug::PrintPre($aCustomer1C,false);
								continue;
							}
							Db::Execute("update user set email='".mysql_escape_string($aCustomer1C['Email'])."',
								login='".mysql_escape_string($sLogin)."' where id='".$aCustomer['id_user']."'");
						}else{
							Base::$aRequest['data']['name']=$aCustomer1C['ФИО'];
							$aCustomer=Auth::AutoCreateUser();
							$sPassword=Auth::GeneratePassword();
							$sSalt=String::GenerateSalt();
							$sLogin='am'.$aCustomer['login'];
							if(Db::GetOne($s="select count(*) from user where 
								login='".mysql_escape_string($sLogin)."' and id!='".$aCustomer['id_user']."'")){
								$aCustomer1C['error']='Dublicate login/email';
								Debug::PrintPre($aCustomer1C,false);
								continue;
							}
							Db::Execute("update user set 
								login='".mysql_escape_string($sLogin)."',
								email='".mysql_escape_string($aCustomer1C['Email'])."',
								password='".String::Md5Salt($sPassword,$sSalt)."',
								password_temp='".$sPassword."',
								salt='".$sSalt."',
								receive_notification='".Base::GetConstant("user:default_notification","0")."' 
								where id='".$aCustomer['id_user']."'");
							Db::Execute("update user_customer set status_1c=2,id_1c='".$aCustomer1C['ID']."'
								,address='".mysql_escape_string($aCustomer1C['Адрес'])."'
								,phone='".mysql_escape_string($aCustomer1C['Телефон'])."'
								where id_user='".$aCustomer['id_user']."'");
							
						}
					}
				}
				//$this->PrintFlush2("clients...\n");
				Base::UpdateConstant('exchange:import_kon','1');
				//if(self::Progress($iProgress,$iMax)) die();

				$this->iTimerMinute=time();
				if(isset($oXml->Документы)){
				//    [Наименование] => Масло моторное
				//    [Артикул] => 15W40 TS-4 SHPD 208L
				//    [Производитель] => MNN
				//    [Количество] => 1
				//    [Резервировать] => Ложь
				//    [ЦенаБезСкидки] => 9 333
				//    [Цена] => 9 333
				//    [Сумма] => 9 333
				//    [СуммаСкидки] => 0
				//    [Статус] => Заказан
				$oOffer=$oXml->Документы;
				$iDoc=0;
				$f = fopen(SERVER_PATH."/imgbank/temp_upload/exchange.log", "a");
				if($oOffer->Документ)
				foreach($oOffer->Документ as $aValue)
				{
					$iDoc++;
					$iProgress++;
					if(Base::GetConstant('exchange:import_doc','0')>=$iDoc) continue;
					if(self::Progress($iProgress,$iMax)){
						Base::UpdateConstant('exchange:import_doc',($iDoc-1));
						fclose($f);
						die();
					}
					$aOrder1C=json_decode(json_encode($aValue), TRUE); //(array)$aValue;//
					//Debug::PrintPre($aOrder1C);
					// --------------------------------------------------- Обработка Заказ товара
					if($aOrder1C['ХозОперация']=='Заказ товара'){
						$sStatus=(string)$aOrder1C['Статус'];
						switch ($sStatus) {//'new','work','confirmed','road','store','end','refused','pending','reclamation','reorder'
							case 'Зарезервирован':
								$sStatusOrder='work';
								$sStatusCart='confirmed';
								break;
							case 'Отправлен на упаковку':
								$sStatusOrder='work';
								$sStatusCart='road';
								break;
							case 'Упаковывается':
								$sStatusOrder='work';
								$sStatusCart='road';
								break;
							case 'Готов к выдаче':
								$sStatusOrder='work';
								$sStatusCart='store';
								break;
							case 'Выполнен':
								$sStatusOrder='end';
								$sStatusCart='end';
								break;
							case 'Отказано':
								$sStatusOrder='refused';
								$sStatusCart='refused';
								break;
							default:
								$sStatusOrder='work';
								$sStatusCart='work';
								break;
						}
						fwrite($f, "Doc id=".$aOrder1C['Номер']." 1c=".$aOrder1C['Ид']."\n");
						$aOrder=Db::GetRow("select * from cart_package where id='".$aOrder1C['Номер']."' or id_1c='".$aOrder1C['ID']."'");
						if($aOrder['id']){
							//заказ с сайта - надо проверить позиции
							$sPrice=(string)$aOrder1C['Сумма'];
							$sPrice=mb_ereg_replace ( '[^0-9\.,]*', '', $sPrice );
							$sPrice=str_replace( ',', '.', $sPrice );
							$aOrderUpdate=array(
									'price_total'=>$sPrice,
									'customer_comment'=>(string)$aOrder1C['Комментарий'],
									'id_1c'=>$aOrder1C['ID'],
									'order_status'=>$sStatusOrder,
									'status_1c'=>2
							);
							Db::AutoExecute("cart_package",$aOrderUpdate,'UPDATE'," id='".$aOrder['id']."'");
							$aCart=Db::GetAll("select * from cart where id_cart_package='".$aOrder['id']."'
									and type_='order'
									");
							$aItemCode=array();
							foreach($aCart as $iKey=>$aValueC){
								$aItemCode[$aValueC['item_code']]['id']=$aValueC['id'];
								$aItemCode[$aValueC['item_code']]['price']=$aValueC['price'];
								$aItemCode[$aValueC['item_code']]['price_rozn']=$aValueC['price_rozn'];
								$aItemCode[$aValueC['item_code']]['number']=$aValueC['number'];
								$aItemCode[$aValueC['item_code']]['order_status']=$aValueC['order_status'];
								$aItemCode[$aValueC['item_code']]['processed']=0;
							}
							$oCart1C=$aOrder1C['Товары'];
							if($oCart1C['Товар'])
							foreach($oCart1C['Товар'] as $aValueC)
							{
								//$aCart1C=json_decode(json_encode($aValueC), TRUE); //(array)$aValueC;
								$aCart1C=$aValueC;
								$aCart1CA=$aCart1C;
								$sPrice=(string)$aCart1CA['Цена'];
								$sPrice=mb_ereg_replace ( '[^0-9\.,]*', '', $sPrice );
								$sPrice=str_replace( ',', '.', $sPrice );
								//$sPriceRozn=(string)$aCart1CA['ЦенаБезСкидки'];
								//$sPriceRozn=mb_ereg_replace ( '[^0-9\.,]*', '', $sPriceRozn );
								//$sPriceRozn=str_replace( ',', '.', $sPriceRozn );
								$iNumber=(int)$aCart1CA['Количество'];
								$sCode=Catalog::StripCode($aCart1CA['Артикул']);
								$sBrand=strtoupper(trim($aCart1CA['Производитель']));
								$sPref=$aNamePref[$sBrand];
								$sItemCode=$sPref.'_'.$sCode;
								if(isset($aItemCode[$sItemCode])){
									fwrite($f, "Cart id=".$aItemCode[$sItemCode]['id']."\n");
									if($aItemCode[$sItemCode]['price']!=$sPrice){
										fwrite($f, "Price site=".$aItemCode[$sItemCode]['price']." 1c=".$sPrice."\n");
										if($sPrice>0){
											Base::$aRequest['ignore_confirm_growth']=1;
											$oManager->ProcessOrderStatus($aItemCode[$sItemCode]['id'],'change_price','','','','',$sPrice);
											$aItemCode[$sItemCode]['log'].='price,';
										}else{
											fwrite($f, "-- NotChangePrice\n");
										}
									}
									if($aItemCode[$sItemCode]['number']!=$iNumber){
										fwrite($f, "Number site=".$aItemCode[$sItemCode]['number']." 1c=".$iNumber."\n");
										$oManager->ProcessOrderStatus($aItemCode[$sItemCode]['id'],'change_quantity','','','','',$iNumber);
										$aItemCode[$sItemCode]['log'].='number,';
									}
									/*if($aItemCode[$sItemCode]['price_rozn']!=$sPriceRozn){
									 Db::Execute("UPDATE cart SET price_rozn='".$sPriceRozn."' where id='".$aItemCode[$sItemCode]['id']."'");
									$aItemCode[$sItemCode]['log'].='price_rozn,';
									}*/
									if($aItemCode[$sItemCode]['order_status']!=$sStatusCart){
										fwrite($f, "Status site=".$aItemCode[$sItemCode]['order_status']." 1c=".$sStatusCart."\n");
										$oManager->ProcessOrderStatus($aItemCode[$sItemCode]['id'],$sStatusCart);
										$aItemCode[$sItemCode]['log'].=$sStatusCart.',';
									}
									$aItemCode[$sItemCode]['processed']=1;
								}else{
									$aCart=array(
											'id_user'=>$aOrder['id_user'],
											'id_cart_package'=>$aOrder['id'],
											'code'=>$sCode,
											'pref'=>$sPref,
											'item_code'=>$sItemCode,
											'cat_name'=>(string)$aCart1CA['Производитель'],
											'number'=>$iNumber,
											'price'=>$sPrice,
											'price_original'=>$sPrice,
											//'price_rozn'=>$sPriceRozn,
											'post_date'=>$aOrder1C['Дата'].' '.$aOrder1C['Время'],
											'order_status'=>$sStatusCart,
											'id_provider'=>$aProvider['id'],
											'id_provider_ordered'=>$aProvider['id'],
											'provider_name'=>$aProvider['name'],
											'provider_name_ordered'=>$aProvider['name'],
											'type_'=>'order',
											'name_translate'=>(string)($aCart1CA['Наименование'].' '.$aCart1CA['Производитель'].' '.$aCart1CA['Артикул']),
									);
									Db::AutoExecute("cart",$aCart);
								}
							}
							foreach($aItemCode as $iKey=>$aValueIC){
								if(!$aValueIC['processed']){
									fwrite($f, "Refuced id=".$aValueIC['id']."\n");
									$oManager->ProcessOrderStatus($aValueIC['id'],'refused');
									$aItemCode[$iKey]['log'].='refused,';
								}
							}
							Cart::SendPendingWork($aOrder['id']);
						}else{
							//заказ новый из 1С - надо создать
							$aUser1C=json_decode(json_encode($aOrder1C['Контрагенты']['Контрагент']), TRUE);//(array)$aOrder1C['Контрагенты']->Контрагент;
							$aUser1CA=$aUser1C;
							$aCustomer=Db::GetRow($s="select uc.* from user_customer uc where uc.id_1c='".$aUser1CA['ID']."'");
							if(!$aCustomer['id_user']){
								Base::$aRequest['data']['name']=$aUser1CA['ПолноеНаименование'];
								$aCustomer=Auth::AutoCreateUser();
								Db::Execute("update user_customer set id_1c='".$aUser1CA['ID']."' where id_user='".$aCustomer['id_user']."'");
							}
							$sPrice=(string)$aOrder1C['Сумма'];
							$sPrice=mb_ereg_replace ( '[^0-9\.,]*', '', $sPrice );
							$sPrice=str_replace( ',', '.', $sPrice );
							$aOrder=array(
									'id_user'=>$aCustomer['id_user'],
									'price_total'=>$sPrice,
									'price_delivery'=>0.00,
									'post_date'=>$aOrder1C['Дата'].' '.$aOrder1C['Время'],
									'customer_comment'=>(string)$aOrder1C['Комментарий'],
									'order_status'=>$sStatusOrder,
									'id_1c'=>$aOrder1C['ID'],
									'status_1c'=>2
							);
							Db::AutoExecute("cart_package",$aOrder);
							$iCartPackage=Db::InsertId();
				
							$oCart=$aOrder1C['Товары'];
							if($oCart['Товар'])
							foreach($oCart['Товар'] as $aValueC)
							{
								//$aCart1C=json_decode(json_encode($aValueC), TRUE); //(array)$aValueC;
								$aCart1C=$aValueC;
								$aCart1CA=$aCart1C;
								$sPrice=(string)$aCart1CA['Цена'];
								$sPrice=mb_ereg_replace ( '[^0-9\.,]*', '', $sPrice );
								$sPrice=str_replace( ',', '.', $sPrice );
								/*	$sPriceRozn=(string)$aCart1CA['ЦенаБезСкидки'];
								 $sPriceRozn=mb_ereg_replace ( '[^0-9\.,]*', '', $sPriceRozn );
								$sPriceRozn=str_replace( ',', '.', $sPriceRozn );*/
								//Debug::PrintPre($aCart1CA);
								$sCode=Catalog::StripCode($aCart1CA['Артикул']);
								$sBrand=strtoupper(trim($aCart1CA['Производитель']));
								$sPref=$aNamePref[$sBrand];
								$aCart=array(
										'id_user'=>$aCustomer['id_user'],
										'id_cart_package'=>$iCartPackage,
										'code'=>$sCode,
										'pref'=>$sPref,
										'item_code'=>$sPref.'_'.$sCode,
										'cat_name'=>(string)$aCart1CA['Производитель'],
										'number'=>(int)$aCart1CA['Количество'],
										'price'=>$sPrice,
										'price_original'=>$sPrice,
										//'price_rozn'=>$sPriceRozn,
										'post_date'=>$aOrder1C['Дата'].' '.$aOrder1C['Время'],
										'order_status'=>$sStatusCart,
										'type_'=>'order',
										'id_provider'=>$aProvider['id'],
										'id_provider_ordered'=>$aProvider['id'],
										'provider_name'=>$aProvider['name'],
										'provider_name_ordered'=>$aProvider['name'],
										'name_translate'=>(string)($aCart1CA['Наименование'].' '.$aCart1CA['Производитель'].' '.$aCart1CA['Артикул']),
								);
								Db::AutoExecute("cart",$aCart);
							}
							Cart::SendPendingWork($iCartPackage);
						}
							
					}
					// --------------------------------------------------- Обработка Заказ товара
				}
				//Base::UpdateConstant('exchange:import_doc',$iDoc);
				fclose($f);
				}

				@copy($sFileName, SERVER_PATH.$this->sTempDir."log/".date('Y-m-d_H-i-s_').Base::$aRequest['filename']);
				die("success");
			}

		}
		die("failure\nNot implemented.");
		Debug::PrintPre(Base::$aRequest);
	}
	//-----------------------------------------------------------------------------------------------
	public function SendRequest($url, $params) {
		set_time_limit(0);
			foreach ($params as $key => &$val) {
				if (is_array($val)) $val = implode(',', $val);
				$post_params[] = $key.'='.urlencode($val);
			}
			if ($post_params)
				$post_string = implode('&', $post_params);
		
			$parts = parse_url($url);
		
			$fp = fsockopen($parts['host'],
					isset($parts['port'])?$parts['port']:80,
					$errno, $errstr, 30);
			stream_set_timeout($fp, 30000);
		
			$out = "GET /?".$post_string." HTTP/1.1\r\n";
			$out.= "Host: ".$parts['host']."\r\n";
			$out.= "Content-Type: application/x-www-form-urlencoded\r\n";
			$out.= "Content-Length: ".strlen($post_string)."\r\n";
			$out.= "Connection: Close\r\n\r\n";
			$out.= $post_string;
		
			fwrite($fp, $out);
			fclose($fp);
			return $errno;
	}
	//-----------------------------------------------------------------------------------------------
}
?>