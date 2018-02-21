<?
/**
 * @author Mikhail Strovoyt
 */

class CallMe extends Base
{
	public function Send()
	{
	   $date=date('d.m.Y h:i');
	   $sToEmail=Base::GetConstant('global:to_email');
      $sSubject=Language::GetText('Call me request')." ".SERVER_NAME.$_SERVER['REQUEST_URI'];
      $sBodyHtml="<h5>".$date."</h5><br>";
      $sBodyHtml.=Language::GetText('Client name').": <b>".Base::$aRequest['name']."</b><br>";
      $sBodyHtml.=Language::GetText('Phone').": <b>".Base::$aRequest['phone']."</b><br>";
      $sFromEmail=Base::GetConstant('global:email_from');
      Mail::$bAddedNoRply=false;
	   $bSendResult=Mail::SendNow($sToEmail,$sSubject,$sBodyHtml,$sFromEmail);
	   
	   $aCallMe['fio']= Base::$aRequest['name'];
	   $aCallMe['phone']= Base::$aRequest['phone'];
	   
	   Db::autoExecute('call_me', $aCallMe);
	   
	   if($bSendResult) {
			Base::$sText.=Language::GetText('Your message is successfully sent.');
			return; 		    
		}
	}
	
	public function ShowManager()
	{
	    Auth::NeedAuth('manager');
	    if(Base::$aRequest['id']){
	        Db::Execute("UPDATE call_me SET resolved = 1 WHERE id =".Base::$aRequest['id']);
	    }
	    $oTable = new Table();
	    $oTable->iRowPerPage=10000;
	    $oTable->sStepperAlign='center';
	    $oTable->bStepperVisible = false;
	    $oTable->sSql = "SELECT * FROM call_me";
	    $oTable->aColumn['id']=array('sTitle'=>'#', 'sOrder'=>'id');
	    $oTable->aColumn['fio']=array('sTitle'=>'fio', 'sOrder'=>'fio');
	    $oTable->aColumn['phone']=array('sTitle'=>'phone', 'sOrder'=>'phone');
	    $oTable->aColumn['post_date']=array('sTitle'=>'post date', 'sOrder'=>'post_date');
	    $oTable->aColumn['resolved']=array('sTitle'=>'Resolution', 'sOrder'=>'resolved');
	    $oTable->aColumn['action']=array();
	
	    $oTable->sDataTemplate = "call_me/row_call.tpl";
	     
	    Base::$sText.=$oTable->getTable("Calls");
	     
	}
}
?>