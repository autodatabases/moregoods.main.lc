<?

/**
 * @author Mihail Starovoyt
 *
 */

class AEcDiscount extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='ec_discount';
		$this->sTablePrefix='dis';
		$this->sAction='ec_discount';
		$this->sWinHead=Language::getDMessage('vt');
		$this->sPath = Language::GetDMessage('>>Obriy >');
		$this->aCheckField=array('id_region','id_user','id_vt','id_product','id_condition_h','id_condition_d','type_discount','discount');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['id']=array('sTitle'=>'Id','sOrder'=>'dis.id');
		
		$oTable->aColumn ['region']=array('sTitle'=>'region','sOrder'=>'r.name');
		$oTable->aColumn ['id_user']=array('sTitle'=>'user','sOrder'=>'u.id_user');
		$oTable->aColumn ['vt']=array('sTitle'=>'vt','sOrder'=>'v.name');
		$oTable->aColumn ['product']=array('sTitle'=>'product','sOrder'=>'p.art');
		$oTable->aColumn ['condition_h']=array('sTitle'=>'condition_h','sOrder'=>'ch.name');
		$oTable->aColumn ['id_condition_d']=array('sTitle'=>'id_condition_d','sOrder'=>'cd.name');
		$oTable->aColumn ['type_discount']=array('sTitle'=>'type_discount','sOrder'=>'dis.type_discount');
		$oTable->aColumn ['discount']=array('sTitle'=>'discount','sOrder'=>'dis.discount');
		$oTable->aColumn ['visible']=array('sTitle'=>'Visible','sOrder'=>'dis.visible');
		$oTable->aColumn ['action']=array();
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign($aData) {
 		Base::$tpl->assign('aRegionList', Base::$db->getAssoc("select id, name from ec_region order by name") );
 		Base::$tpl->assign('aUserList', Base::$db->getAssoc("select id, login from user where type_='customer' order by login") );
 		Base::$tpl->assign('aVtList', Base::$db->getAssoc("select id, name from ec_vt order by name") );
 		Base::$tpl->assign('aProductList', Base::$db->getAssoc("select id, art from ec_products order by name") );
 		Base::$tpl->assign('aConditionHList', Base::$db->getAssoc("select id, name from ec_condition_h order by name") );
 		Base::$tpl->assign('aConditionDList', Base::$db->getAssoc("select id, id as name from ec_condition_d order by id") );
 		Base::$tpl->assign('aTypeDiscountList', array(1));//Base::$db->getAssoc("select id, name from ec_type order by name") );
	}
	//-----------------------------------------------------------------------------------------------
}
?>