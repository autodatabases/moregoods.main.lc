<?

/**
 * @author Mihail Starovoyt
 *
 */

class AEcVariable extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='ec_variable';
		$this->sTablePrefix='ev';
		$this->sAction='ec_variable';
		$this->sWinHead=Language::getDMessage('Ec_variable');
		$this->sPath = Language::GetDMessage('>>Obriy >');
		$this->aCheckField=array('variable_nm');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['id']=array('sTitle'=>'Id','sOrder'=>'ev.id');
		$oTable->aColumn ['variable_nm']=array('sTitle'=>'Name','sOrder'=>'ev.variable_nm');
		$oTable->aColumn ['id_antbl']=array('sTitle'=>'Antbl','sOrder'=>'ev.id_antbl');
		$oTable->aColumn ['in_filter']=array('sTitle'=>'Filter','sOrder'=>'ev.in_filter');
		$oTable->aColumn ['view_info']=array('sTitle'=>'Viewinfo','sOrder'=>'ev.view_info');
		$oTable->aColumn ['sort']=array('sTitle'=>'order','sOrder'=>'ev.sort');
		$oTable->aColumn ['visible']=array('sTitle'=>'Visible','sOrder'=>'ev.visible');
		$oTable->aColumn ['date']=array('sTitle'=>'Postdate','sOrder'=>'ev.post_date');
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