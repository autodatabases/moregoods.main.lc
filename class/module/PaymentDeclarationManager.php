<?
/**
 * @author Vladimir Fedorov
 * 
 */

class PaymentDeclarationManager extends Base
{
	//-----------------------------------------------------------------------------------------------
	public function __construct()
	{
		Auth::NeedAuth('manager');
		Base::$bXajaxPresent = true;
		Base::$aData['template']['bWidthLimit']=true;
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		if (!Auth::$aUser['id'])
			Base::Redirect('/');
			
		if (Auth::$aUser['type_'] != 'manager')
			Base::Redirect('/pages/payment_declaration');
		
		$oTable=new Table();
		$oTable->sSql="Select pd.*,pd.id as pd_id from payment_declaration pd 
				left join user as u ON u.id = pd.id_user
				left join user_customer as uc ON uc.id_user = pd.id_user";
		$oTable->aOrdered="order by date_send desc";
		$oTable->aColumn=array(
			'date_send'=>array('sTitle'=>'Date send'),
			'user' =>array('sTitle' => 'Customer'), 
			'recipient'=>array('sTitle'=>'Recipient'),
			'carrier'=>array('sTitle'=>'Carrier'),
			'number_declaration'=>array('sTitle'=>'Number declaration'),
			'number_places'=>array('sTitle' => 'Number places' ),
			'action'=>array(),
		);
		$oTable->sDataTemplate='payment_declaration/row_payment_declaration_manager.tpl';
		$oTable->sButtonTemplate='payment_declaration/button_payment_declaration_manager.tpl';
		$oTable->bStepperVisible=true;
		$oTable->bHeaderVisible=true;
		$oTable->iRowPerPage=10;
		$oTable->bCountStepper=true;
		Base::$sText.=$oTable->getTable();
	}
	//-----------------------------------------------------------------------------------------------
	public function Add()
	{
		Base::$bXajaxPresent=true;
		$oCurrency = new Currency();
		$sError = '';
		$aData = array();

		if (Base::$aRequest['is_post']) {
			$aData = Base::$aRequest['data'];
			if (!Base::$aRequest['data']['date_send'] || Base::$aRequest['data']['date_send'] == '') {
				$iTime = time();
				$sTime = date("Y-m-d H:i:s", $iTime);
				$aData['date_send'] = date("d-m-Y H:i:s", $iTime);
			}
			elseif (($sTime=strtotime(Base::$aRequest['data']['date_send'])) === false) {
				$sError .= Language::GetMessage("Incorrect format date and time. Use format: d-m-Y H:i:s");
			}
			else
				$sTime = date("Y-m-d H:i:s",$sTime);
				
			if (!$aData['date_send'] && Base::$aRequest['data']['date_send'])
				$aData['date_send'] = Base::$aRequest['data']['date_send'];
				
			if (!Base::$aRequest['data']['login'] || trim(Base::$aRequest['data']['login']) == '') {
				$sError .= Language::GetMessage("Incorrect select user.");
			}
			else {
				$aUser = Db::GetRow("select * from user u 
						inner join user_customer uc ON uc.id_user = u.id  
						where login = '".Base::$aRequest['data']['login']."'");
				if (!$aUser || $aUser['login'] != Base::$aRequest['data']['login'])
					$sError .= Language::GetMessage("Incorrect select user.");
			}
			
			if (!Base::$aRequest['data']['number_declaration'] || trim(Base::$aRequest['data']['number_declaration']) == '') {
				if ($sError != '')
					$sError .= "<br>";
				$sError .= language::GetMessage("Incorrect value number declaration. Please fill this field.");
			}
			if (!Base::$aRequest['data']['number_places'] || (int)Base::$aRequest['data']['number_places'] == 0) {
				if ($sError != '')
					$sError .= "<br>";
				$sError .= language::GetMessage("Incorrect value number places. Please fill this field.");
			}
				
			if ($sError == '') {
				if (!isset(Base::$aRequest['id'])) {
					$sQuery = "Insert into payment_declaration (id_user, date_send, recipient, carrier, number_declaration, number_places) VALUES
							(".$aUser['id'].",'".$sTime."','".strip_tags(Base::$aRequest['data']['recipient'])."',
							 '".strip_tags(Base::$aRequest['data']['carrier'])."','".
								strip_tags(Base::$aRequest['data']['number_declaration'])."','".
								strip_tags(Base::$aRequest['data']['number_places'])."')";
				}
				else {
					$sQuery = "Update payment_declaration set date_send = '".$sTime."', id_user = ".$aUser['id'].", recipient = '".
								strip_tags(Base::$aRequest['data']['recipient'])."', carrier = '".
								strip_tags(Base::$aRequest['data']['carrier'])."', number_declaration = '".
								strip_tags(Base::$aRequest['data']['number_declaration'])."', number_places = '".
								strip_tags(Base::$aRequest['data']['number_places'])."' where id = ".Base::$aRequest['id'];
								
				}
				$sMessage="Declaration created";
				$sSubject = Language::GetMessage('created new declaration');
				Base::$db->Execute($sQuery);
	
				$aData['aUser'] = Auth::$aUser;
				$aData['payment_declaration'] = array(
						'date' => $sTime,
						'recipient' => Base::$aRequest['data']['recipient'],
						'carrier' => Base::$aRequest['data']['carrier'],
						'number_declaration' => Base::$aRequest['data']['number_declaration'],
						'number_places' => Base::$aRequest['data']['number_places'],
				);
		
				Message::CreateDelayedNotification($aUser['id_user'],'create_new_payment_declaration'
					,$aData,true);

				
				Base::Redirect("/pages/payment_declaration/?aMessage[MT_NOTICE]=".$sMessage);
			}
		}

		$sButtonSubmit = 'Add';
		if (Base::$aRequest['id']) {
			$aInfo = Db::GetRow("Select pd.*,u.login from payment_declaration pd  
					inner join user u on u.id = pd.id_user 
					where pd.id =".Base::$aRequest['id']);
			if ($aInfo['id']) {
				$aData = $aInfo;
				$sButtonSubmit = 'Edit';
			}
		}
	
		Base::$tpl->assign('aData',$aData);

		$aData=array(
				'sHeader'=>"method=post",
				'sTitle'=>"Create declaration",
				'sContent'=>Base::$tpl->fetch('payment_declaration/form_add_payment_declaration_manager.tpl'),
				'sSubmitButton'=>$sButtonSubmit,
				'sSubmitAction'=>'payment_declaration_manager_add',
				'sErrorNT'=>$sError,
				'sReturnButton'=>'<< Return',
				'sReturnAction'=>'payment_declaration_manager',
				'sReturnButtonClass' => '',
				'sSubmitButtonClass' => '',
		);
		$oForm=new Form($aData);
		Base::$sText.=$oForm->getForm();
	}
	//-----------------------------------------------------------------------------------------------
	public function Delete()
	{
		if (Auth::$aUser['type_'] != 'manager') {
			$sUrl = "/pages/payment_declaration";
			Base::Redirect($sUrl);
		}
		
		if (!Base::$aRequest['id'])
			$sMessage = 'Not found payment declaration item for delete';
		else {
			$aInfo = Db::GetRow("Select * from payment_declaration where id =".Base::$aRequest['id']);
			if (!$aInfo['id'])
				$sMessage = 'Not found payment declaration item for delete';
			else {
			 	$aUser = Db::GetRow("select * from user u 
							inner join user_customer uc ON uc.id_user = u.id
							where id = '".$aInfo['id_user']."'");
			
				Db::Execute("Delete from payment_declaration where id =".Base::$aRequest['id']);
	
				$aData['aUser'] = Auth::$aUser;
				$aData['payment_declaration'] = array(
						'date' => date("d-m-Y H:i:s",strtotime($aInfo['date_send'])),
						'recipient' => $aInfo['recipient'],
						'carrier' => $aInfo['carrier'],
						'number_declaration' => $aInfo['number_declaration'],
						'number_places' => $aInfo['number_places'],
				);
				
				Message::CreateDelayedNotification($aUser['id_user'],'delete_new_payment_declaration'
						,$aData,true);

				$sMessage = 'Declaration item delete';
			}
		}
		$sUrl = "/pages/payment_declaration/?aMessage[MT_NOTICE]=".$sMessage;
		Base::Redirect($sUrl);
	}
	//-----------------------------------------------------------------------------------------------
	public function SelectUser()
	{
		$aResult=array();
		if (Base::$aRequest['term']) {
			$aUsers = Db::GetAll("Select * from user u 
					inner join user_customer uc ON uc.id_user = u.id   
					where login like '%".Base::$aRequest['term']."%'");
			foreach($aUsers as $aValue)
				$aResult[] = array('label' => $aValue['login'] . ($aValue['name'] != '' ? ' - '. $aValue['name'] : ''), 'value' => $aValue['login'], 'id'=>$aValue['id']);	
		}
		echo json_encode($aResult);
		exit();
	}
}
?>