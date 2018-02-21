<?

/**
 * @author Mihail Starovoyt
 *
 */

class AEcBrandInRegion extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='ec_brand_in_region';
		$this->sTablePrefix='bir';
		$this->sAction='ec_brand_in_region';
		$this->sWinHead=Language::getDMessage('brand in region');
		$this->sPath = Language::GetDMessage('>>Obriy >');
		$this->aCheckField=array('id_brand','id_region');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['id']=array('sTitle'=>'Id','sOrder'=>'bir.id');
		$oTable->aColumn ['brand']=array('sTitle'=>'brand','sOrder'=>'b.name');
		$oTable->aColumn ['region']=array('sTitle'=>'region','sOrder'=>'r.name');
		$oTable->aColumn ['post_date']=array('sTitle'=>'date','sOrder'=>'bir.date');
		$oTable->aColumn ['action']=array();
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign($aData) {
 		Base::$tpl->assign('aRegionList', Base::$db->getAssoc("select id, name from ec_region order by name") );
 		Base::$tpl->assign('aBrandList', Base::$db->getAssoc("select id, name from ec_brand order by name") );
	}
	//-----------------------------------------------------------------------------------------------
}
?>