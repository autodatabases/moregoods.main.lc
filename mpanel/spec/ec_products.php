<?

/**
 * @author Mihail Starovoyt
 *
 */

class AEcProducts extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='ec_products';
		$this->sTablePrefix='p';
		$this->sAction='ec_products';
		$this->sWinHead=Language::getDMessage('products');
		$this->sPath = Language::GetDMessage('>>Obriy >');
		$this->aCheckField=array('name','id_brand_group','id_brand','id_type','art');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['id']=array('sTitle'=>'Id','sOrder'=>'p.id');
		$oTable->aColumn ['image']=array('sTitle'=>'image','sOrder'=>'p.image');
		$oTable->aColumn ['brand_group']=array('sTitle'=>'brand group','sOrder'=>'bg.name');
		$oTable->aColumn ['brand']=array('sTitle'=>'brand','sOrder'=>'b.name');
		$oTable->aColumn ['vt']=array('sTitle'=>'vt','sOrder'=>'vt.name');
		$oTable->aColumn ['id_type']=array('sTitle'=>'type','sOrder'=>'t.name');
		$oTable->aColumn ['name']=array('sTitle'=>'Name','sOrder'=>'p.name');
		$oTable->aColumn ['short_name']=array('sTitle'=>'short name','sOrder'=>'p.short_name');
		$oTable->aColumn ['art']=array('sTitle'=>'art','sOrder'=>'p.art');
		$oTable->aColumn ['barcode']=array('sTitle'=>'barcode','sOrder'=>'p.barcode');
		$oTable->aColumn ['unit']=array('sTitle'=>'unit','sOrder'=>'p.unit');
		$oTable->aColumn ['weight']=array('sTitle'=>'weight','sOrder'=>'p.weight');
		$oTable->aColumn ['volume']=array('sTitle'=>'volume','sOrder'=>'p.volume');
		$oTable->aColumn ['pack_qty']=array('sTitle'=>'pack_qty','sOrder'=>'p.pack_qty');
		$oTable->aColumn ['img']=array('sTitle'=>'img','sOrder'=>'p.img');
		$oTable->aColumn ['img2']=array('sTitle'=>'img2','sOrder'=>'p.img2');
		$oTable->aColumn ['id_parent']=array('sTitle'=>'id_parent','sOrder'=>'p.id_parent');
		$oTable->aColumn ['check']=array('sTitle'=>'check','sOrder'=>'p.check');
		$oTable->aColumn ['select_type']=array('sTitle'=>'select_type','sOrder'=>'p.select_type');
		$oTable->aColumn ['post_date']=array('sTitle'=>'date','sOrder'=>'p.date');
		$oTable->aColumn ['sort']=array('sTitle'=>'order','sOrder'=>'p.sort');
		$oTable->aColumn ['visible']=array('sTitle'=>'Visible','sOrder'=>'p.visible');
		$oTable->aColumn ['action']=array();
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign($aData) {
		Base::$tpl->assign('aBrandGroupList', Base::$db->getAssoc("select id, name from ec_brand_group order by name") );
		Base::$tpl->assign('aBrandList', Base::$db->getAssoc("select id, name from ec_brand order by name") );
 		Base::$tpl->assign('aVtList', Base::$db->getAssoc("select id, name from ec_vt order by name") );
 		Base::$tpl->assign('aTypeList', array(1));//Base::$db->getAssoc("select id, name from ec_type order by name") );
	}
	//-----------------------------------------------------------------------------------------------
}
?>