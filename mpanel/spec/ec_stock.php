<?

/**
 * @author Mihail Starovoyt
 *
 */

class AEcStock extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='ec_stock';
		$this->sTablePrefix='s';
		$this->sAction='ec_stock';
		$this->sWinHead=Language::getDMessage('stock');
		$this->sPath = Language::GetDMessage('>>Obriy >');
		$this->aCheckField=array('id_region','id_distributor','id_product','stock');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['region']=array('sTitle'=>'region','sOrder'=>'r.name');
		$oTable->aColumn ['distributor']=array('sTitle'=>'distributor','sOrder'=>'d.name');
		$oTable->aColumn ['product']=array('sTitle'=>'product','sOrder'=>'p.art');
		$oTable->aColumn ['stock']=array('sTitle'=>'stock','sOrder'=>'s.stock');
		$oTable->aColumn ['post_date']=array('sTitle'=>'date','sOrder'=>'s.date');
		$oTable->aColumn ['visible']=array('sTitle'=>'Visible','sOrder'=>'s.visible');
		$oTable->aColumn ['action']=array();
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign($aData) {
		Base::$tpl->assign('aRegionList', Base::$db->getAssoc("select id, name from ec_region order by name") );
		Base::$tpl->assign('aProductList', Base::$db->getAssoc("select id, art from ec_products order by name") );
 		Base::$tpl->assign('aDistributorList', Base::$db->getAssoc("select id, name from ec_distributor order by name") );
	}
	//-----------------------------------------------------------------------------------------------
}
?>