<?

require_once(SERVER_PATH.'/class/core/Admin.php');
class AConfig extends Admin {

	//-----------------------------------------------------------------------------------------------
	function AConfig() {
		$this->sTableName='config';
		$this->sAction='config';
		$this->sWinHead=Language::getDMessage('Config');
		$this->sPath=Language::GetDMessage('>>Configuration >');
		//$this->sAddonPath='';
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		$this->PreIndex();

		$aData=Db::getRow(Base::GetSql('CoreConfig'));
		if (!$aData) {
			$aData=array('id'=>1,'title'=>'Sample title','meta_charset'=>'windows-1251');
			Db::AutoExecute('config',$aData);
		}
		Base::$tpl->assign('aData',$aData);
		Base::$sText.=Base::$tpl->fetch('addon/mpanel/'.$this->sAction.'/form_add.tpl');

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
}
?>