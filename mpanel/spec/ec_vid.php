<?

/**
 * @author Mihail Starovoyt
 *
 */

class AEcVid extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='ec_vid';
		$this->sTablePrefix='r';
		$this->sAction='ec_vid';
		$this->sWinHead=Language::getDMessage('vid');
		$this->sPath = Language::GetDMessage('>>Obriy >');
		$this->aCheckField=array('name');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['id']=array('sTitle'=>'Id','sOrder'=>'r.id');
		$oTable->aColumn ['name']=array('sTitle'=>'Name','sOrder'=>'r.name');
		$oTable->aColumn ['short_name']=array('sTitle'=>'short name','sOrder'=>'r.short_name');
		$oTable->aColumn ['level']=array('sTitle'=>'level','sOrder'=>'r.level');
		$oTable->aColumn ['id_parent']=array('sTitle'=>'id_parent','sOrder'=>'r.id_parent');
		$oTable->aColumn ['col']=array('sTitle'=>'col','sOrder'=>'r.col');
		$oTable->aColumn ['post_date']=array('sTitle'=>'date','sOrder'=>'r.date');
		$oTable->aColumn ['sort']=array('sTitle'=>'order','sOrder'=>'r.sort');
		$oTable->aColumn ['visible']=array('sTitle'=>'Visible','sOrder'=>'r.visible');
		$oTable->aColumn ['action']=array();
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign($aData) {
// 		Base::$tpl->assign('aRegionList', Base::$db->getAssoc("select id, name from office_region order by name") );
// 		Base::$tpl->assign('aCityList', Base::$db->getAssoc("select id, name from office_city order by name") );
	}
	//-----------------------------------------------------------------------------------------------
}
?>