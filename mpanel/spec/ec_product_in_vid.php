<?

/**
 * @author Mihail Starovoyt
 *
 */

class AEcProductInVid extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='ec_product_in_vid';
		$this->sTablePrefix='piv';
		$this->sAction='ec_product_in_vid';
		$this->sWinHead=Language::getDMessage('product in vid');
		$this->sPath = Language::GetDMessage('>>Obriy >');
		$this->aCheckField=array('id_product','id_vid');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['id']=array('sTitle'=>'Id','sOrder'=>'piv.id');
		$oTable->aColumn ['product']=array('sTitle'=>'product','sOrder'=>'p.art');
		$oTable->aColumn ['vid']=array('sTitle'=>'vid','sOrder'=>'v.name');
		$oTable->aColumn ['post_date']=array('sTitle'=>'date','sOrder'=>'piv.date');
		$oTable->aColumn ['action']=array();
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign($aData) {
 		//Base::$tpl->assign('aProductList', Base::$db->getAssoc("select id, art from ec_products order by name") );
 		Base::$tpl->assign('aVidList', Base::$db->getAssoc("select id, name from ec_vid order by name") );
	}
	//-----------------------------------------------------------------------------------------------
}
?>