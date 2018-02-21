<?
/**
 * @author Oleg Makienko
 *
 */

class Sound extends Base
{
	private static $aSound;
	private static $iAudio=1;

	public static function GetSound($sKey, $sDefault = "")
	{
		if (!$sKey) return;
		if(!Sound::$aSound){
			Sound::$aSound =Db::GetAll ("SELECT * FROM sound");
			Sound::$aSound=Language::Array2Hash ( Sound::$aSound, 'code' );
		}
		
		if (!Sound::$aSound [$sKey] ['content']) {
			Base::$db->Execute ( "insert ignore into sound (code,content)
				value('" . mysql_real_escape_string ( $sKey ) . "','" . mysql_real_escape_string ( $sDefault ) . "') " );
			Sound::$aSound [$sKey] ['content'] = $sKey;
			return $sDefault;
		}
		return Sound::$aSound [$sKey] ['content'];
	}
	//----------------------------------------------------------------------
	public static function InsertIntoPage($sCode,$sDefault=""){
		$sFilename=Base::GetConstant('sound:files_path','/imgbank/sound/').Sound::GetSound($sCode,$sDefault);
		if($sFilename)
		    return self::GetHtmlCode($sFilename);
	}
    //----------------------------------------------------------------------
    public static function InsertIntoPageCustomerByLogin($sLogin){
        if(!$sLogin) return;
        $sSoundDir = Base::GetConstant('sound:customer_files_path','/imgbank/sound/customer/');
		$sFilename=$sSoundDir.strtolower("customer_".$sLogin).".wav";
		if(file_exists(SERVER_PATH.$sFilename))
		    return self::GetHtmlCode($sFilename);
		else
		{
		    $sFilename=$sSoundDir.strtolower(Base::GetConstant('sound:customer_none_file','customer_none.wav'));
		    return self::GetHtmlCode($sFilename);
		}
	}
	//----------------------------------------------------------------------
    public static function InsertIntoPageCustomerById($sId){
        if(!$sId) return;
        $sLogin=Db::GetOne("select login from user where id=".$sId);
		return Sound::InsertIntoPageCustomerByLogin($sLogin);
	}
	/*
	 * action from user dashboard from manager.
	 */
	public function UploadCustomerSound(){
	    $aDataIncome=String::FilterRequestData(Base::$aRequest['sound'],array(
	        'login','onlyclean'
	    ));
	    if(!$aDataIncome['login'])
	        return;
	    $sFilename=Sound::GetCustomerFileNamePath($aDataIncome['login']);
	    if($aDataIncome['onlyclean'] && is_file($sFilename)){
	        unlink($sFilename);
	        return;
	    }
	    if($_FILES['filename'] && $_FILES['filename']['tmp_name']){
	        if(is_file($sFilename))
	            unlink($sFilename);
	        @move_uploaded_file($_FILES['filename']['tmp_name'], $sFilename);
	    }
	}
	//----------------------------------------------------------------------
	private static function GetHtmlCode($sFilename){
	    return
		"<script TYPE=\"text/javascript\">
				 var filename='"
		.$sFilename
		."';
		if (navigator.appName == 'Microsoft Internet Explorer')
		   	document.writeln (\"<BGSOUND SRC='\"+ filename + \"'>\");
		else if (navigator.appName == 'Netscape')
		    document.writeln (\"<EMBED SRC='\" + filename + \"' AUTOSTART=TRUE WIDTH=0 HEIGHT=0 loop=false />\");
		</script>";
	}
	/*
	 * array('login','action');
	 */
	public function GetHtmlCodeCustomer($aData){
	    Base::$tpl->assign('sLogin',$aData['login']);
	    Base::$tpl->assign('sAction',$aData['action']);
	    $sRealPath=Sound::GetCustomerFileNamePath($aData['login']);
	    $bIsFileExist = is_file($sRealPath);
	    if($bIsFileExist){
	        Base::$tpl->assign('bIsFileExist',$bIsFileExist);
	    }
	    return  Base::$tpl->fetch("sound/customer.tpl");
	}
	
	private static function GetCustomerFileNamePath($sLogin,$bIsUrl=false){
	    $sSoundDir = Base::GetConstant('sound:customer_files_path','/imgbank/sound/customer/');
	    return ($bIsUrl?"":SERVER_PATH).$sSoundDir."customer_".strtolower($sLogin).".wav";
	}
}

?>