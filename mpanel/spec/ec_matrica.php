<?

/**
 * @author 
 *
 */

class AEcMatrica extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='ec_matrica';
		$this->sTablePrefix='ma';
		$this->sAction='ec_matrica';
		$this->sWinHead=Language::getDMessage('matrica');
		$this->sPath = Language::GetDMessage('>>Obriy >');
		$this->aCheckField=array('id_brand_group','id_brand','id_region','id_distributor','id_customer_group','mdiscount','type_mdiscount');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();
		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['id']=array('sTitle'=>'Id','sOrder'=>'ma.id');
		$oTable->aColumn ['brand_group']=array('sTitle'=>'brand group','sOrder'=>'bgr.name');
		$oTable->aColumn ['brand']=array('sTitle'=>'brand','sOrder'=>'b.name');
		$oTable->aColumn ['region']=array('sTitle'=>'region','sOrder'=>'r.name');
		$oTable->aColumn ['distributor']=array('sTitle'=>'distributor','sOrder'=>'d.name');
		$oTable->aColumn ['customer_group']=array('sTitle'=>'customer_group','sOrder'=>'cg.name');
		$oTable->aColumn ['customer_type']=array('sTitle'=>'customer_type','sOrder'=>'ct.name');
		$oTable->aColumn ['mdiscount']=array('sTitle'=>'discount','sOrder'=>'ma.mdiscount');
		$oTable->aColumn ['type_mdiscount']=array('sTitle'=>'type_discount','sOrder'=>'ma.type_mdiscount');
		$oTable->aColumn ['visible']=array('sTitle'=>'Visible','sOrder'=>'ma.visible');
		$oTable->aColumn ['post_date']=array('sTitle'=>'date','sOrder'=>'ma.date');
		$oTable->aColumn ['action']=array();
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign($aData) {
 		Base::$tpl->assign('aBrandGroupList', Base::$db->getAssoc("select id, name from ec_brand_group order by name") );
 		Base::$tpl->assign('aBrandList', Base::$db->getAssoc("select id, name from ec_brand order by name") );
 		Base::$tpl->assign('aRegionList', Base::$db->getAssoc("select id, name from ec_region order by name") );
 		Base::$tpl->assign('aDistributorList', Base::$db->getAssoc("select id, name from ec_distributor order by name") );
 		Base::$tpl->assign('aCustomerGroup', Base::$db->getAssoc("select id,name from customer_group where visible=1 order by id") );
 		Base::$tpl->assign('aCustomerType', Base::$db->getAssoc("select 0 as id,'All' as name union all select id,name from user_customer_type where visible=1 order by id") );
 		Base::$tpl->assign('aTypeDiscountList', array(1));//Base::$db->getAssoc("select id, name from ec_type order by name") );
	}
	//-----------------------------------------------------------------------------------------------
}
?>