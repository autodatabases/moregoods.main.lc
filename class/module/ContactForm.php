<?

/**
 * @author Mikhail Starovoyt
 */

class ContactForm extends Base
{
	//-----------------------------------------------------------------------------------------------
	function __construct()
	{
		$oCpacha= new Capcha();
		Base::$tpl->assign('sCapcha',$oCpacha->GetMathematic('contact_form/mathematic.tpl'));
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		if (Base::$aRequest['is_post']) {
			if (!Capcha::CheckMathematic()) 
				$sError = "Check capcha value";
			else {
				if (Base::$aRequest['data']['name'] && Base::$aRequest['data']['email']) {

					foreach (Base::$aRequest['data'] as $sKey => $aValue) {
						$sMessage.=Language::GetMessage($sKey).' : '.$aValue.'<br />';
					}

					Mail::AddDelayed(Base::GetConstant('global:to_email','info@morefoods.com.ua'),Language::GetMessage('contact_form'),
					$sMessage);

					Base::$sText.=Language::GetText('Message is successfully sent.');
					return;
				}
				else $sError = "Please, fill the required fields";
			}
		}

		$aData=array(
		'sHeader'=>"method=post",
		//'sTitle'=>"Static Contact Form",
		'sContent'=>Base::$tpl->fetch('contact_form/form_static.tpl'),
		//'sSubmitButton'=>'Send',
		'sSubmitAction'=>'contact_form',
		'sError'=>$sError,
		'sWidth'=>'100%',
		'sClass'=>'',
		);
		$oForm=new Form($aData);
	/*	
		if(Auth::$aUser['type_']=='customer' && !Customer::IsChangeableLogin(Auth::$aUser['login']) ) {
		    $sCityByIp = Auth::$aUser['id_geo'];
		} else{
		    $sCityByIp= $_SESSION['selected_city'];
		}
	*/		
		$sCityByIp=Base::$oContent->GetSelectedCity();
		
		if(Auth::$aUser['id_region']){
		    $iRegion=Auth::$aUser['id_region'];
		}
		elseif($_SESSION['selected_city'] && !Auth::$aUser['id_region']){
		    $sOblasRegion=Db::GetOne("select ec_region from net_city where id='".$sCityByIp."'");
		    $iRegion=$sOblasRegion;
		}
		else{
		    $sOblasRegion=Db::GetOne("select ec_region from net_city where id='".$sCityByIp."'");
		    $iRegion=$sOblasRegion;
		}
		if(!$iRegion)$iRegion=1;

		
		$aContacts= Db::GetRow("select r.* from ec_region as r where r.id =".$iRegion);
		Base::$tpl->assign('aContacts',$aContacts);
		
		Base::$tpl->assign('sCityByIp',$sCityByIp);
		

		Base::$tpl->assign('sContactForm',$oForm->getForm());
		Base::$sText.=Base::$tpl->fetch('contact_form/template.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	public function Call()
	{
		if (Base::$aRequest['is_post']) {
			if (!Capcha::CheckMathematic()) Form::ShowError("Check capcha value");
			else {
				if (Base::$aRequest['data']['name'] && Base::$aRequest['data']['phone']) {
					foreach (Base::$aRequest['data'] as $sKey => $aValue) {
						$sMessage.=$sKey.' : '.$aValue.'<br />';
					}

					Mail::AddDelayed(Base::GetConstant('global:to_email','mstarrr@gmail.com'),Language::GetMessage('contact_call'),
					$sMessage);

					Base::$sText.=Language::GetText('Message is successfully sent.');
					return;
				}
				else Form::ShowError("Please, fill the required fields");
			}
		}

		$aData=array(
		'sHeader'=>"method=post",
		'sTitle'=>"Contact Form Call",
		'sContent'=>Base::$tpl->fetch('contact_form/form_call.tpl'),
		'sSubmitButton'=>'Send',
		'sSubmitAction'=>'contact_form_call',
		'sError'=>$sError,
		);
		$oForm=new Form($aData);
		
		Base::$sText.=$oForm->getForm();
	}
	//-----------------------------------------------------------------------------------------------

}
?>