<?

/**
 * @author Mihail Starovoyt
 *
 */

class ACatRegion extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='cat_region';
		$this->sTablePrefix='cr';
		$this->sAction='cat_region';
		$this->sWinHead=Language::getDMessage('Cat Region');
		$this->sPath = Language::GetDMessage('>>Auto catalog >');
		$this->aCheckField=array('id_region','id_cat');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['id']=array('sTitle'=>'Id','sOrder'=>'cr.id');
		$oTable->aColumn ['cat']=array('sTitle'=>'Cat','sOrder'=>'c.title');
		$oTable->aColumn ['region']=array('sTitle'=>'region','sOrder'=>'pr.name');
		$oTable->aColumn ['visible']=array('sTitle'=>'Visible','sOrder'=>'cr.visible');
		$oTable->aColumn ['action']=array();
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign($aData) {
		Base::$tpl->assign('aProviderRegionList', Base::$db->getAssoc("select id, name from provider_region  order by name") );
		Base::$tpl->assign('aCatList', Base::$db->getAssoc("select id, title from cat order by name") );
	}
	//-----------------------------------------------------------------------------------------------
}
?>