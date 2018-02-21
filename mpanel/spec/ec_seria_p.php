<?

/**
 * @author Mihail Starovoyt
 *
 */

class AEcSeriaP extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='ec_seria_p';
		$this->sTablePrefix='r';
		$this->sAction='ec_seria_p';
		$this->sWinHead=Language::getDMessage('seria_p');
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