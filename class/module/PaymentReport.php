<?
/**
 * @author Vladimir Fedorov
 * 
 */

class PaymentReport extends Base
{
	//-----------------------------------------------------------------------------------------------
	public function __construct()
	{
		Base::$bXajaxPresent = true;
		Base::$aData['template']['bWidthLimit']=true;
		Base::Message();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		$oTable=new Table();
		$oTable->sSql="Select pr.* from payment_report as pr where pr.id_user = ".Auth::$aUser['id'];
		$oTable->aOrdered="order by pr.payment_date desc";
		$oTable->aColumn=array(
			'payment_date'=>array('sTitle'=>'Date payment'),
			'method'=>array('sTitle'=>'Method'),
			'price'=>array('sTitle'=>'Price payment report'),
			'comment'=>array('sTitle'=>'Comment'),
			'action' =>array(), 
		);
		$oTable->sDataTemplate='payment_report/row_payment_report.tpl';
		$oTable->bStepperVisible=true;
		$oTable->bHeaderVisible=true;
		$oTable->iRowPerPage=25;
		$oTable->bCountStepper=true;
		$oTable->sButtonTemplate='payment_report/button_payment_report.tpl';
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
			if (!Base::$aRequest['data']['payment_date'] || Base::$aRequest['data']['payment_date'] == '') {
				$iTime = time();
				$sTime = date("Y-m-d H:i:s", $iTime);
				$aData['payment_date'] = date("d-m-Y H:i:s", $iTime);
			}
			elseif (($sTime=strtotime(Base::$aRequest['data']['payment_date'])) === false) {
				$sError .= Language::GetMessage("Incorrect format date and time. Use format: d-m-Y H:i:s"); 
			}
			else 
				$sTime = date("Y-m-d H:i:s",$sTime);
			
			if (!$aData['payment_date'] && Base::$aRequest['data']['payment_date'])
				$aData['payment_date'] = Base::$aRequest['data']['payment_date'];
			
			if (!is_numeric(Base::$aRequest['data']['price']) || floatval(Base::$aRequest['data']['price']) <= 0) {
				if ($sError != '')
					$sError .= "<br>";
				$sError .= language::GetMessage("Incorrect value price. Need fill integer value > 0");
			}
			
			if ($sError == '') {
				$sComment = strip_tags(Base::$aRequest['data']['comment']);
				$fPrice = floatval(Base::$aRequest['data']['price']);
				if (!isset(Base::$aRequest['id'])) {
					$sQuery = "Insert into payment_report (id_user, payment_date, method, price, comment) VALUES
							(".Auth::$aUser['id'].",'".$sTime."','".Base::$aRequest['data']['method']."',
							 ".$fPrice.",'".$sComment."')";
					$sMessage="Payment report created";
					$sSubject = Language::GetMessage('created new payment report');
				}
				else { 
					$sQuery = "Update payment_report set payment_date = '".$sTime."', method = '".Base::$aRequest['data']['method']."',
								price = ".$fPrice.", comment = '".$sComment."' where id = ".Base::$aRequest['id'];
					$sMessage='Payment report updated';
					$sSubject = Language::GetMessage('updated payment report');
				}
				Base::$db->Execute($sQuery);
				
				$aData['aUser'] = Auth::$aUser;
				$aData['payment_report'] = array(
					'date' => $sTime,
					'method' => Base::$aRequest['data']['method'],
					'comment' => $sComment,
					'price' => $oCurrency->PrintPrice($fPrice)
				);
				
				$aTemplate=String::GetSmartyTemplate('create_new_payment_report', $aData);
				$sBody=$aTemplate['parsed_text'];
				
				Mail::SendNow(
					Base::GetConstant('payment_report:to_email','mstarrr@gmail.com'),
					Language::GetMessage('User') .': '. Auth::$aUser['name'] . '(login: '.Auth::$aUser['login'] .') '. $sSubject,
					$sBody
				);
					
				Base::Redirect("/pages/payment_report/?aMessage[MT_NOTICE]=".$sMessage);
			}
		}
		$sButtonSubmit = 'Add';
		if (Base::$aRequest['id']) {
			$aInfo = Db::GetRow("Select * from payment_report where id =".Base::$aRequest['id']." and id_user=".Auth::$aUser['id']);
			if ($aInfo['id']) {
				$aData = $aInfo;
				$sButtonSubmit = 'Edit';
			}
		}
		
		Base::$tpl->assign('aData',$aData);
		
		Base::$tpl->assign('aMethods',array(
			Language::GetMessage('method:other'),
			Language::GetMessage('method:card account'),
			Language::GetMessage('method:current account')
		));
		
		$aData=array(
				'sHeader'=>"method=post",
				'sTitle'=>"Create payment info",
				'sContent'=>Base::$tpl->fetch('payment_report/form_add_payment_report.tpl'),
				'sSubmitButton'=>$sButtonSubmit,
				'sSubmitAction'=>'payment_report_add',
				'sErrorNT'=>$sError,
				'sReturnButton'=>'<< Return',
				'sReturnAction'=>'payment_report',
				'sReturnButtonClass' => '',
				'sSubmitButtonClass' => '',
		);
		$oForm=new Form($aData);
		Base::$sText.=$oForm->getForm();
	}
	//-----------------------------------------------------------------------------------------------
	public function Delete()
	{
		if (!Base::$aRequest['id'])
			$sMessage = 'Not found payment report item for delete';
		else {
			$aInfo = Db::GetRow("Select * from payment_report where id =".Base::$aRequest['id']." and id_user=".Auth::$aUser['id']);
			if (!$aInfo['id'])
				$sMessage = 'Not found payment report item for delete';
			else {
				$oCurrency = new Currency();
				Db::Execute("Delete from payment_report where id =".Base::$aRequest['id']." and id_user=".Auth::$aUser['id']);
				
				$aData['aUser'] = Auth::$aUser;
				$aData['payment_report'] = array(
						'date' => date("d-m-Y H:i:s",strtotime($aInfo['payment_date'])),
						'method' => $aInfo['method'],
						'comment' => $aInfo['comment'],
						'price' => $oCurrency->PrintPrice($aInfo['price'])
				);
				
				$aTemplate=String::GetSmartyTemplate('create_new_payment_report', $aData);
				$sBody=$aTemplate['parsed_text'];
				
				$sToEmail = Base::GetConstant('payment_report:to_email','mstarrr@gmail.com');
				
				Mail::SendNow($sToEmail,
				Language::GetMessage('User') .': '. Auth::$aUser['name'] . '(login: '.Auth::$aUser['login'] .') '. Language::GetMessage('delete payment report'),
				$sBody
				);
				$sMessage = 'Payment report item delete';
			}
		}
		$sUrl = "/pages/payment_report/?aMessage[MT_NOTICE]=".$sMessage;
		Base::Redirect($sUrl);
	}
}
?>