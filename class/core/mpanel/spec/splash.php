<?

class ASplash extends Admin{

	//-----------------------------------------------------------------------------------------------
	public function Index() {
		Base::$sText=Base::$tpl->fetch('addon/mpanel/splash.tpl');
		Base::$tpl->assign('sWinHead','>>Welcome');
		Base::$tpl->assign('sPath','Welcome');

		if (Base::$oResponse) {
			Base::$oResponse->addAssign('sub_menu','innerHTML','');
			Base::$oResponse->addAssign('path','innerHTML','');
			Base::$oResponse->addAssign('win_head','innerHTML','');
			Base::$oResponse->addAssign('win_text','innerHTML',Base::$tpl->fetch('addon/mpanel/splash.tpl'));
		}
	}
	//-----------------------------------------------------------------------------------------------
}
?>