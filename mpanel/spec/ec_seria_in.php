<?

/**
 * @author Mihail Starovoyt
 *
 */

class AEcSeriaIn extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='ec_seria_in';
		$this->sTablePrefix='si';
		$this->sAction='ec_seria_in';
		$this->sWinHead=Language::getDMessage('seria_in');
		$this->sPath = Language::GetDMessage('>>Obriy >');
		$this->aCheckField=array('id_seria_p','id_product');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['id']=array('sTitle'=>'Id','sOrder'=>'si.id');
		$oTable->aColumn ['seria_p']=array('sTitle'=>'seria_p','sOrder'=>'sp.name');
		$oTable->aColumn ['product']=array('sTitle'=>'Name','sOrder'=>'p.art');
		$oTable->aColumn ['post_date']=array('sTitle'=>'date','sOrder'=>'si.date');
		$oTable->aColumn ['visible']=array('sTitle'=>'Visible','sOrder'=>'si.visible');
		$oTable->aColumn ['action']=array();
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign($aData) {
		Base::$tpl->assign('aProductList', Base::$db->getAssoc("select id, art from ec_products order by name") );
		Base::$tpl->assign('aSeriaPList', Base::$db->getAssoc("select id, name from ec_seria_p order by name") );
	}
	//-----------------------------------------------------------------------------------------------
}
?>