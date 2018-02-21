<?

/**
 * @author Mihail Starovoyt
 *
 */

class AEcPrice extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='ec_price';
		$this->sTablePrefix='pr';
		$this->sAction='ec_price';
		$this->sWinHead=Language::getDMessage('price');
		$this->sPath = Language::GetDMessage('>>Obriy >');
		$this->aCheckField=array('id_region','id_product','price');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['id']=array('sTitle'=>'Id','sOrder'=>'pr.id');
		$oTable->aColumn ['region']=array('sTitle'=>'region','sOrder'=>'r.name');
		$oTable->aColumn ['id_product']=array('sTitle'=>'id_product','sOrder'=>'pr.id_product');
		$oTable->aColumn ['price']=array('sTitle'=>'price','sOrder'=>'pr.price');
		$oTable->aColumn ['post_date']=array('sTitle'=>'date','sOrder'=>'pr.date');
		$oTable->aColumn ['visible']=array('sTitle'=>'Visible','sOrder'=>'pr.visible');
        $oTable->aColumn ['id_customer_group']=array('sTitle'=>'id_customer_group','sOrder'=>'pr.id_customer_group');
		$oTable->aColumn ['action']=array();
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign($aData) {
		Base::$tpl->assign('aRegionList', Base::$db->getAssoc("select id, name from ec_region order by name") );
		//Base::$tpl->assign('aProductList', Base::$db->getAssoc("select id, art from ec_products order by name") );
	}
	//-----------------------------------------------------------------------------------------------
}
?>