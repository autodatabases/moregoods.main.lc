<?
require_once(SERVER_PATH.'/class/core/Base.php');
class Cron extends Base {

	//-----------------------------------------------------------------------------------------------
	public function Cron()
	{
	}
	//-----------------------------------------------------------------------------------------------
	public function CloseCartPackage($iId,$sOrderStatus='refused')
	{
		if (!in_array($sOrderStatus,array('refused','end'))) return false;
		$bCheck=true;
		$aCart=Base::$db->getAll("select cp.*,c.* from cart c
			inner join cart_package cp on c.id_cart_package=cp.id
			where c.id_cart_package='$iId' and type_='order'
			order by c.order_status
			");
		if (!$aCart) return false;

		foreach ($aCart as $value) {
			if ($value['order_status']=='end') $sOrderStatus='end';
			if (!in_array($value['order_status'],array('refused','end'))) {
				$bCheck=false;
				break;
			}
		}
		if ($bCheck) {
			Base::$db->Execute("update cart_package set order_status='$sOrderStatus' where id='$iId'");

			//Close debts for closed cart apckages
			Base::$db->Execute("update log_debt set pay_date=UNIX_TIMESTAMP()
				where custom_id='$iId' and is_payed=0");
			//			require_once(SERVER_PATH.'/class/module/Debt.php');
			//			Debt::CheckPayDebt();

			if ($value['price_total']>0){
				$aData['id_buh_debit_subconto1']=$value['id_user'];
				$aData['id_buh_debit']=361;
				$aData['id_buh_credit']=703;
				$aData['amount']=$value['price_total'];
				$aData['id_buh_section']=1;
				$aData['buh_section_id']=$iId;
				$aEntry[]=$aData;
				$oBuh = new Buh();
				$oBuh->EntryMany($aEntry);
			}

			// return delivery money
			//if ($aCart['0']['price_delivery']!=0)
			//	Finance::Deposit($aCart['0']['id_user'],$aCart['0']['price_delivery'],
			//		Language::getMessage("Refused delivery for cart package #").
			//		" ".$aCart['0']['id_cart_package'],$aCart['0']['id_cart_package'],
			//		'internal','cart','',4);

		}
	}
	//-----------------------------------------------------------------------------------------------
	public function SendAutopayPackage($iIdUser)
	{
		$aCartPackage=Base::$db->getAll("select cp.* from cart_package cp
				inner join user_account ua on ua.id_user=cp.id_user
			where cp.id_user='$iIdUser' and cp.autopay='1'
				and cp.order_status='pending'
			order by cp.post");
		if (!$aCartPackage) return false;

		require_once(SERVER_PATH.'/class/module/Cart.php');
		foreach ($aCartPackage as $value) {
			if (Finance::HaveMoney($value['price_total'],$value['id_user'],$value['full_payment'])) Cart::SendPendingWork($value['id']);
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function ClearOldData()
	{
//		Base::$db->Execute("delete from log_visit where post<".(time() -7*86400));
//		Base::$db->Execute("delete from log_admin where post_date<DATE_SUB(CURDATE() , INTERVAL 60 DAY )");
		Base::$db->Execute("delete from mail_delayed where post<".(time() -10*86400));
		Base::$db->Execute("TRUNCATE TABLE print_content");

		Base::$db->Execute("update `message` set is_old=1 WHERE post_date<DATE_SUB(CURDATE() , INTERVAL 60 DAY )");
		Base::$db->Execute("update `message` set is_old=1 WHERE is_read=0 and post_date<DATE_SUB(CURDATE() , INTERVAL 30 DAY )");

		Base::$db->Execute("delete from price_search_log where post_date<DATE_SUB(CURDATE() , INTERVAL 30 DAY)");
	}
	//-----------------------------------------------------------------------------------------------
	public function SendDbBackup()
	{
		// DB dump sending -------
		Mail::SendAttach('mikhail.starovojt@gmail.com','[DB Dump]: '.date('Y-m-d'),'DB dump: '.'allavto_backup_'.date('Y-m-d').'.zip'
		,array(
		'/home/mstar/backup/allavto.com.ua/allavto_backup_'.date('Y-m-d').'.sql.zi_'=>'')
		);
		Base::$sText.="<br>".'/home/mstar/backup/allavto.com.ua/allavto_backup_'.date('Y-m-d').'.sql.zi_';
		//------------------------
	}
	//-----------------------------------------------------------------------------------------------
	public function NotifyPendingOrder()
	{
		require_once(SERVER_PATH.'/class/core/Mail.php');
		$aCartPackage=Base::$db->GetAll("select u.*, uc.*, cp.* from cart_package cp
			inner join user u on cp.id_user=u.id
			inner join user_customer uc on uc.id_user=u.id
			where cp.order_status='pending'
				and cp.post<".(time() - 5*86400)." and cp.post>".(time() - 6*86400)  );
		if ($aCartPackage) {
			require_once(SERVER_PATH.'/class/system/Content.php');
			foreach ($aCartPackage as $value) {
				$aData=array(
				'cart_package'=>$value,
				);
				$sBody=Content::getTemplate('pending_cart_package',$aData);
				Mail::AddDelayed($value['email'],Language::getMessage('Pending Cart Package'),$sBody);
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function NotifyLastVisit()
	{
		require_once(SERVER_PATH.'/class/core/Mail.php');
		$aUser=Base::$db->GetAll("select * from user where receive_notification='1' and is_last_visit_notified='0'
					and last_visit_date<DATE_SUB(CURDATE() , INTERVAL 30 DAY )");
		if ($aUser) {
			require_once(SERVER_PATH.'/class/system/Content.php');
			foreach ($aUser as $aValue) {
				$aUserId[]=$aValue['id'];
				$aData=array(
				'aUser'=>$aValue,
				);
				$aTemplate=Content::GetSmartyTemplate('last_visit_notification',$aData);
				$sBody=$aTemplate['parsed_text'];
				$sSubject=$aTemplate['name'];
				if ($aValue['email']) {
					Mail::AddDelayed($aValue['email'],$sSubject,$sBody,'','',true,$aTemplate['priority']);
				}
			}

			Base::$db->Execute("update user set is_last_visit_notified='1' where id in (".implode(',',$aUserId).")");
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function DeleteTemporaryCustomer()
	{
		if (!Base::GetConstant('user:clear_autocreated_customer',1)) return;

		$sSql="select u.id, u.login
			from user as u
			left join cart_package as cp on cp.id_user=u.id
			left join vin_request as vr on vr.id_user=u.id
			where cp.id IS NULL and vr.id IS NULL  and u.login REGEXP  '^a[0-9]*$'
				and u.post_date<DATE_SUB(NOW(),INTERVAL ".Base::GetConstant('user:old_temporary_customer_hour',12)." HOUR)
		";
		$aUserIdAssoc=Db::GetAssoc($sSql);

		if ($aUserIdAssoc) {
			Db::Execute("delete from user where id in (".implode(',',array_keys($aUserIdAssoc)).")");
			Db::Execute("delete from user_customer where id_user in (".implode(',',array_keys($aUserIdAssoc)).")");
			Db::Execute("delete from cart where id_user in (".implode(',',array_keys($aUserIdAssoc)).")");
			Db::Execute("delete from user_account where id_user in (".implode(',',array_keys($aUserIdAssoc)).")");
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function ClearCustomerData()
	{
		set_time_limit(0);
		$aCustomer=Db::GetAssoc("select id_user as id,id_user from user_customer");
		if(!$aCustomer) die('Not found!');
		$inCustomer="'".implode("','", $aCustomer)."'";
		$aCart=Db::GetAssoc("select id as i,id  from cart where id_user in (".$inCustomer.")");
		$aCartInvoice=Db::GetAssoc("select id as i,id  from cart_invoice where id_user_customer in (".$inCustomer.")");
		$aMessage=Db::GetAssoc("select id as i,id  from message where id_user in (".$inCustomer.")");

		$sSqlDelete['Customer']="delete from user_customer where id_user in (".$inCustomer.")";
		$sSqlDelete['User']="delete from user where id in (".$inCustomer.")";
		$sSqlDelete['Cart']="delete from cart where id_user in (".$inCustomer.")";
		$sSqlDelete['CartLog']="delete from cart_log where id_cart in ('".implode("','", $aCart)."')";
		$sSqlDelete['CartPackage']="delete from cart_package where id_user in (".$inCustomer.")";
		$sSqlDelete['CartInvoice']="delete from cart_invoice where id_user_customer in (".$inCustomer.")";
		$sSqlDelete['CartInvoiceLog']="delete from cart_invoice_log where id_cart_invoice in ('".implode("','", $aCartInvoice)."')";
		$sSqlDelete['InvoiceCustomer']="delete from invoice_customer where id_user in (".$inCustomer.")";
		$sSqlDelete['Message']="delete from message where id_user in (".$inCustomer.")";
		$sSqlDelete['MessageAttachment']="delete from message_attachment where id_message in ('".implode("','", $aMessage)."')";
		$sSqlDelete['UserAccount']="delete from user_account where id_user in (".$inCustomer.")";
		$sSqlDelete['UserAccountLog']="delete from user_account_log where id_user in (".$inCustomer.")";
		$sSqlDelete['VinRequest']="delete from vin_request where id_user in (".$inCustomer.")";
		$sSqlDelete['LogFinance']="delete from log_finance where id_user in (".$inCustomer.")";
		$sSqlDelete['CartUnlinks']="delete FROM cart where id_cart_package != 0";
		$sSqlDelete['UserAuto']="delete from user_auto where id_user in (".$inCustomer.")";
		$sSqlDelete['CartPackageUnlinks']="delete FROM cart_package";
		$sSqlDelete['Declaration']="delete FROM payment_declaration";
		$sSqlDelete['PaymentReport']="delete FROM payment_report";
		$sSqlDelete['CartInvoice']="delete FROM cart_invoice";
		$sSqlDelete['MessageUnlinks']="delete from message";
		$sSqlDelete['MessageAttachmentUnlinks']="delete from message_attachment";
		
		foreach ($sSqlDelete as $sKey => $sValue) {
			print "<b>".$sKey."</b><br>".$sValue;
			Debug::PrintPre(Db::Execute($sValue),false);
			print "<hr>";
		}
		die();
	}
	//-----------------------------------------------------------------------------------------------
	public function MoveExpiredCart() {
		// delete from expired cart
		$iDelExpiredSec = Base::GetConstant('hours_expired_cart_delete',24) * 60 * 60;
		Db::Execute("DELETE from cart_deleted where (UNIX_TIMESTAMP() - post_delete) > ".$iDelExpiredSec);
		
		// add to expired cart positions
		$aMass = DB::GetAll("Select c.*, UNIX_TIMESTAMP(c.post_date) as pd_post, cg.hours_expired_cart 
				from cart c
				inner join user_customer uc on uc.id_user = c.id_user    
				left join customer_group cg on cg.id = uc.id_customer_group
				where type_ = 'cart' order by post_date asc");
		$iExpiredSec_def = Base::GetConstant('hours_expired_cart',24) * 60 * 60;
		foreach ($aMass as $aValue) {
			if ($aValue['hours_expired_cart'] != 0)
				$iExpiredSec = $aValue['hours_expired_cart'] * 60 * 60;
			else
				$iExpiredSec = $iExpiredSec_def;
			
			if ((time() - $aValue['pd_post']) < $iExpiredSec )
				continue;
			
			$aValue['post_delete'] = time();
			
			$sInfo = json_encode($aValue);
			
			Base::$db->Execute("delete from cart_deleted where id='".$aValue['id']."' and type_='cart'");
			
			Db::Execute("insert into cart_deleted (id, id_user, code, post_delete, type_, item_code, pref, info) 
					VALUES (".$aValue['id'].",".$aValue['id_user'].",'".$aValue['code']."',".$aValue['post_delete'].",'".
							$aValue['type_']."','".$aValue['item_code']."','".$aValue['pref']."','".$sInfo."')");
			Base::$db->Execute("delete from cart where id='".$aValue['id']."' and type_='cart'");
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function ClearOldPriceQueue() {
		$iBoardDayForClear = Language::GetConstant('global:BoardDayForClearPriceQueue',30);
		$iBoardDayLeftForClear = Language::GetConstant('global:BoardDayLeftForClearPriceQueue',10);
		// all, only_worked - if position not worked - not delete
		$sTypeClear = Language::GetConstant('global:ClearPriceQueue','all');
		if ($sTypeClear == 'all')
			$aData = Db::GetAll("SELECT * FROM price_queue where 
				DATEDIFF(now(),post_date) > ".$iBoardDayForClear."
				and id not in (select id from (select id from price_queue where visible = 1
				ORDER BY `price_queue`.`id` DESC limit ".$iBoardDayLeftForClear." )as a )");
		else 
			$aData = Db::GetAll("SELECT * FROM price_queue where is_processed != 0 and  
				DATEDIFF(now(),post_date) > ".$iBoardDayForClear."
				and id not in (select id from (select id from price_queue where visible = 1
				ORDER BY `price_queue`.`id`  DESC limit ".$iBoardDayLeftForClear." )as a )");
		if ($aData) {
			foreach ($aData as $aValue) {
				@unlink($aValue['file_path']);
				$aMass[] = $aValue['id'];
			}
			Db::Execute("Delete from price_queue where id in (".implode(",",$aMass).")");
			Db::Execute("Delete from log_price_queue where id_price_queue in (".implode(",",$aMass).")");
		}
		// check and clear other unknown files
		$oPriceQueue = new PriceQueue();
		$aData = glob(SERVER_PATH.$oPriceQueue->sPathToFile."*.*");
		if ($aData) {
			foreach($aData as $sFilePath) {
				$sBasename = basename($sFilePath);
				$iId = Db::GetOne("Select id from price_queue where file_name = '".$sBasename."'");
				if (!$iId) {
					$iTime = filemtime($sFilePath);
					if ((time() - $iTime) > $iBoardDayForClear * 24 * 60 * 60)
						@unlink($sFilePath);
				}
			}
		}
		Db::Execute("delete FROM `log_price_queue` where id_price_queue not in (select id from price_queue)");
		// defragmentation - very good clear space
		//Db::Execute("ALTER TABLE `log_price_queue` ENGINE = InnoDB");
	}
	//-----------------------------------------------------------------------------------------------
	public function ClearOldServiceLog() {
		$iBoardDayForClear = Language::GetConstant('global:BoardDayForClearServiceLog',30);
		Db::Execute("Delete from service_log where DATEDIFF(now(),post_date) > ".$iBoardDayForClear);
	}
	//-----------------------------------------------------------------------------------------------
	public function ClearOldMailDelayed() {
		$iBoardDayForClear = Language::GetConstant('global:BoardDayForClearMailDelayed',30);
		Db::Execute("Delete from mail_delayed where DATEDIFF(now(),post_date) > ".$iBoardDayForClear);
	}
	//-----------------------------------------------------------------------------------------------
	public function ClearOldUserNotification() {
		$iBoardDayForClear = Language::GetConstant('global:BoardDayForClearUserNotification',30);
		Db::Execute("Delete from user_notification where DATEDIFF(now(),post_date) > ".$iBoardDayForClear);
	}
	//-----------------------------------------------------------------------------------------------
	public function ClearAllOld() {
		Cron::ClearOldPriceQueue();
		Cron::ClearOldServiceLog();
		Cron::ClearOldMailDelayed();
		Cron::ClearOldUserNotification();
	}
	//-----------------------------------------------------------------------------------------------
	public function AssociateDelayedPrices(){
		set_time_limit(0);
		$aPriceGroupAssoc = Db::GetAssoc("Select code,id from price_group");
		$iCount = Db::GetOne("SELECT Count(*) FROM price WHERE is_delayed_associate = 1");
		$oPrice = new Price();
		//$oPrice->InitAssociate();
		for($i=0; $i<$iCount; $i= $i+5000){
			$aPrices = Db::GetAll("SELECT * FROM price WHERE is_delayed_associate = 1 LIMIT ".$i.", 5000");
			if($aPrices)
				foreach($aPrices as $aPrice){
					$aPrice['id_price_group'] = $oPrice->FindAssociate($aPrice);
					if($aPrice['id_price_group']!='' && $aPrice['id_price_group'] && $aPriceGroupAssoc[$aPrice['id_price_group']]) {
						$aPrice['id_price_group'] = $aPriceGroupAssoc[$aPrice['id_price_group']];
						Db::Execute("insert into price_group_assign (item_code,id_price_group) 
							values('".$aPrice['item_code']."','".$aPrice['id_price_group']."')
							on duplicate key update id_price_group = values(id_price_group) ");
					}
				}
		}
		Db::Execute("UPDATE price SET is_delayed_associate = 0, post_date = post_date WHERE is_delayed_associate = 1");
	}
	//-----------------------------------------------------------------------------------------------
	public function AssociateDelayedPricesMinutely(){
		if (Language::GetConstant('cron_associate_stop','0'))
			return;
				
		$aPriceGroupAssoc = Db::GetAssoc("Select code,id from price_group");
		
		$iStart = time();
		//file_put_contents('/tmp/_inc',"\n Start: ".$iStart,FILE_APPEND);
		set_time_limit(0);
		$oPrice = new Price();
		$aPrices = Db::GetAll("SELECT id,part_rus,item_code,code,pref,is_delayed_associate FROM price WHERE is_delayed_associate = 1 LIMIT 0, ".Base::GetConstant('delayed_associate:minutely_count', 10));
		$aPriceId = array();
		$aInsert = array();
		$aDelete = array();
		if($aPrices){
			foreach($aPrices as $aPrice){
				$aPrice['id_price_group'] = $oPrice->FindAssociate($aPrice);					
				if($aPrice['id_price_group']!='' && $aPrice['id_price_group']!=0 && $aPriceGroupAssoc[$aPrice['id_price_group']]) { 
					$aPrice['id_price_group'] = $aPriceGroupAssoc[$aPrice['id_price_group']];
					$aInsert[]= " ('".$aPrice['item_code']."','".$aPrice['id_price_group']."','".$aPrice['pref']."')";
				}
                $aPriceId[] = $aPrice['item_code'];
			}
			
			if($aInsert) {
				Db::Execute("insert into price_group_assign (item_code,id_price_group,pref) 
				    values ".implode(',', $aInsert)."
		    		    on duplicate key update id_price_group = values(id_price_group), pref = values(pref) ");
			}
			if($aPriceId) {
			    Db::Execute("UPDATE price SET is_delayed_associate = 0, post_date = post_date WHERE item_code in ('".implode("','", $aPriceId)."')");
			}
		}
		$iEnd = time();
		//file_put_contents('/tmp/_inc',"\n Stop: ".$iEnd." interval=".($iEnd-$iStart)." Use count items: ".Base::GetConstant('delayed_associate:minutely_count', 10)."\n",FILE_APPEND);
	}
}
?>
