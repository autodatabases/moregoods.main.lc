<?

/**
 * @author Mihail Starovoyt
 *
 */

class AEcConditionD extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='ec_condition_d';
		$this->sTablePrefix='cd';
		$this->sAction='ec_condition_d';
		$this->sWinHead=Language::getDMessage('condition_d');
		$this->sPath = Language::GetDMessage('>>Obriy >');
		$this->aCheckField=array('id_condition_h','id_product');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['id']=array('sTitle'=>'Id','sOrder'=>'cd.id');
		$oTable->aColumn ['condition_h']=array('sTitle'=>'condition_h','sOrder'=>'ch.name');
		$oTable->aColumn ['product']=array('sTitle'=>'product','sOrder'=>'p.art');
		$oTable->aColumn ['visible']=array('sTitle'=>'Visible','sOrder'=>'cd.visible');
		$oTable->aColumn ['action']=array();
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign($aData) {
 		Base::$tpl->assign('aProductList', Base::$db->getAssoc("select id, art from ec_products order by name") );
 		Base::$tpl->assign('aConditionHList', Base::$db->getAssoc("select id, name from ec_condition_h order by name") );
	}
	//-----------------------------------------------------------------------------------------------
}
?>