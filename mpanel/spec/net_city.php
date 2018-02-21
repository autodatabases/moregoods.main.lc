<?

/**
 * @author Mihail Starovoyt
 *
 */

class ANetCity extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='net_city';
		$this->sTablePrefix='n';
		$this->sAction='net_city';
		$this->sWinHead=Language::getDMessage('Region');
		$this->sPath = Language::GetDMessage('>>Obriy >');
		$this->aCheckField=array('name_ru');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['id']=array('sTitle'=>'Id','sOrder'=>'n.region');
		$oTable->aColumn ['name_ru']=array('sTitle'=>'Name','sOrder'=>'n.name_ru');
		$oTable->aColumn ['ec_region']=array('sTitle'=>'dist_region','sOrder'=>'n.ec_region');
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