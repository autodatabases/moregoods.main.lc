<?

/**
 * @author Mikhail Starovoyt
 */

class RequestForm extends Base
{
	//-----------------------------------------------------------------------------------------------
	function __construct()
	{

	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		if (Base::$aRequest['is_post']) {
			if (Base::$aRequest['data']['name'] && Base::$aRequest['data']['phone'] && Base::$aRequest['data']['auto_make']
			&& Base::$aRequest['data']['auto_model'] && Base::$aRequest['data']['year']&& Base::$aRequest['data']['volume']) {

				foreach (Base::$aRequest['data'] as $sKey => $aValue) {
					$sMessage.=$sKey.' : '.$aValue.'<br />';
				}

				Mail::AddDelayed(Base::GetConstant('contact_email','mstarrr@gmail.com'),Language::GetMessage('request_form braz'),
				$sMessage);

				Base::$sText.=Language::GetText('Request is successfully sent.');
				return;
			}
			else Form::ShowError("Please, fill the required fields");
		}

		$aData=array(
		'sHeader'=>"method=post",
		'sTitle'=>"Static Request Form",
		'sContent'=>Base::$tpl->fetch('request_form/form_static.tpl'),
		'sSubmitButton'=>'Send',
		'sSubmitAction'=>'request_form',
		'sError'=>$sError,
		);
		$oForm=new Form($aData);

		Base::$sText.=$oForm->getForm();
	}
	//-----------------------------------------------------------------------------------------------

}
?>