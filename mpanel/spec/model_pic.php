<?

/**
 * @author Yuriy Korzun
 */

class AModelPic extends Admin
{
	//-----------------------------------------------------------------------------------------------
	function __construct()
	{
		$this->sTableName = 'model_pic';
		$this->sTablePrefix = 'mp';
		$this->sAction = 'model_pic';
		$this->sWinHead = Language::getDMessage('Model picture');
		$this->sPath = Language::GetDMessage('>>Auto catalog >');
		$this->aCheckField = array('id_tof','id_model');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		$this->PreIndex ();

		$oTable = new Table ( );
		$oTable->aColumn = array ();
		$oTable->aColumn ['id'] = array ('sTitle' => 'Id', 'sOrder' => 'mp.id' );
		$oTable->aColumn ['make'] = array ('sTitle' => 'Make', 'sOrder' => 'c.title');
		$oTable->aColumn ['model'] = array ('sTitle' => 'Model', 'sOrder' => 'ca.Name');
		$oTable->aColumn ['description'] = array ('sTitle' => 'description');
		$oTable->aColumn ['image'] = array ('sTitle' => 'Image');
		$oTable->aColumn ['size'] = array ('sTitle' => 'Size');
		$oTable->aColumn ['action'] = array ();
		$oTable->aCallback=array($this,'CallParseModelPic');
		$this->SetDefaultTable($oTable );
		Base::$sText .= $oTable->getTable ();

		$this->AfterIndex ();
	}
	//-----------------------------------------------------------------------------------------------
	public function CallParseModelPic(&$aItem=array()){
		foreach ($aItem as $sKey => $aValue) {
			if (file_exists(SERVER_PATH.'/imgbank/Image/model/'.$aValue['image']) && $aValue['image']){
				$aSize=getimagesize(SERVER_PATH.'/imgbank/Image/model/'.$aValue['image']);
				$aItem[$sKey]['size']=$aSize[0]."x".$aSize[1];
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign(&$aData)
	{
		$this->Make($aData['id_tof']);
		Base::$tpl->assign('aMakeTof', array(""=>Language::getMessage('choose make'))+Db::GetAssoc("Assoc/CatTof",
			array('is_brand' => '1')));
	}
	//-----------------------------------------------------------------------------------------------
	public function Apply() {
		$sUploadDir = '/imgbank/temp_upload/mpanel/';
		$sFile = SERVER_PATH.$sUploadDir.Base::$aRequest['data']['upload_img'];
		$sFileName=Base::$aRequest['data']['id_tof'].'_'.Base::$aRequest['data']['id_model'].'.jpg';
		if (Base::$aRequest['data']['upload_img'] && file_exists($sFile)) {
			rename ( $sFile, SERVER_PATH.'/imgbank/Image/model/'.$sFileName);
			Base::$aRequest['data']['image']=$sFileName;
		}

		parent::Apply ();
	}
	//-----------------------------------------------------------------------------------------------
	public function Make($sIdTof=0) {
		if(!$sIdTof) $sIdTof=Base::$aRequest['data']['id_tof'];
		if(!$sIdTof) return;
		$aModel=Db::GetAssoc("Assoc/OptiCatModelPic",array("id_tof"=>$sIdTof,"sOrder"=>" order by name "	));
		if(Base::$aRequest['xajax']){
			Base::$tpl->assign('aModel',array(""=>Language::getMessage('choose model'))+$aModel);
			Base::$oResponse->addAssign('id_model','outerHTML',
			Base::$tpl->fetch('mpanel/model_pic/selector_model.tpl'));
		}else{
			Base::$tpl->assign('aModel',$aModel);
		}
	}
	//-----------------------------------------------------------------------------------------------
}
?>