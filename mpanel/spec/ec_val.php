<?

/**
 * @author Mihail Starovoyt
 *
 */

class AEcVal extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='ec_val';
		$this->sTablePrefix='el';
		$this->sAction='ec_val';
		$this->sWinHead=Language::getDMessage('Ec_val');
		$this->sPath = Language::GetDMessage('>>Obriy >');
		$this->aCheckField=array('id_variable');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['id']=array('sTitle'=>'Id','sOrder'=>'el.id');
		$oTable->aColumn ['id_variable']=array('sTitle'=>'id_variable','sOrder'=>'el.id_variable');
		$oTable->aColumn ['id_product']=array('sTitle'=>'id_product','sOrder'=>'el.id_product');
		$oTable->aColumn ['id_anval']=array('sTitle'=>'id_anval','sOrder'=>'el.id_anval');
		$oTable->aColumn ['val']=array('sTitle'=>'val','sOrder'=>'el.val');
		$oTable->aColumn ['date']=array('sTitle'=>'dt','sOrder'=>'el.dt');
		$oTable->aColumn ['post_date']=array('sTitle'=>'Postdate','sOrder'=>'el.post_date');
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