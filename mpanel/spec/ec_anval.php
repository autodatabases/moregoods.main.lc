<?

/**
 * @author Mihail Starovoyt
 *
 */

class AEcAnval extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='ec_anval';
		$this->sTablePrefix='ean';
		$this->sAction='ec_anval';
		$this->sWinHead=Language::getDMessage('ec_anval');
		$this->sPath = Language::GetDMessage('>>Obriy >');
		//$this->aCheckField=array('id_variable');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['id']=array('sTitle'=>'Id','sOrder'=>'ean.id');
		$oTable->aColumn ['id_antbl']=array('sTitle'=>'id_antbl','sOrder'=>'ean.id_antbl');
		$oTable->aColumn ['anval_nm']=array('sTitle'=>'anval_nm','sOrder'=>'ean.anval_nm');
		$oTable->aColumn ['anval_prnt']=array('sTitle'=>'anval_prnt','sOrder'=>'ean.anval_prnt');
		$oTable->aColumn ['kod']=array('sTitle'=>'kod','sOrder'=>'ean.kod');
		$oTable->aColumn ['post_date']=array('sTitle'=>'Postdate','sOrder'=>'ean.post_date');
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