<?

/**
 * @author Mihail Starovoyt
 *
 */

class AEcAntbl extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='ec_antbl';
		$this->sTablePrefix='ea';
		$this->sAction='ec_antbl';
		$this->sWinHead=Language::getDMessage('Ec_antbl');
		$this->sPath = Language::GetDMessage('>>Obriy >');
		$this->aCheckField=array('antbl_nm');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['id']=array('sTitle'=>'Id','sOrder'=>'ea.id');
		$oTable->aColumn ['antbl_nm']=array('sTitle'=>'Name','sOrder'=>'ea.antbl_nm');
		$oTable->aColumn ['tbl_nm']=array('sTitle'=>'tbl_nm','sOrder'=>'ea.tbl_nm');
		$oTable->aColumn ['id_fld']=array('sTitle'=>'id_fld','sOrder'=>'ea.id_fld');
		$oTable->aColumn ['nm_fld']=array('sTitle'=>'nm_fld','sOrder'=>'ea.nm_fld');
		$oTable->aColumn ['post_date']=array('sTitle'=>'Postdate','sOrder'=>'ea.post_date');
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