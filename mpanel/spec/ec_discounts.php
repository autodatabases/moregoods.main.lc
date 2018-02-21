<?

/**
 * @author 
 *
 */

class AEcDiscounts extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='ec_discounts';
		$this->sTablePrefix='dis';
		$this->sAction='ec_discounts';
		$this->sWinHead=Language::getDMessage('discounts');
		$this->sPath = Language::GetDMessage('>>Obriy >');
		$this->aCheckField=array('id_brand_group','id_brand','id_region','id_distributor','id_user','discount','type_discount');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();
		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['id']=array('sTitle'=>'Id','sOrder'=>'dis.id');
		$oTable->aColumn ['brand_group']=array('sTitle'=>'brand group','sOrder'=>'bgr.name');
		$oTable->aColumn ['brand']=array('sTitle'=>'brand','sOrder'=>'b.name');
		$oTable->aColumn ['region']=array('sTitle'=>'region','sOrder'=>'r.name');
		$oTable->aColumn ['distributor']=array('sTitle'=>'distributor','sOrder'=>'d.name');
		$oTable->aColumn ['user_name']=array('sTitle'=>'user','sOrder'=>'uc.name');
		$oTable->aColumn ['discount']=array('sTitle'=>'discounts','sOrder'=>'dis.discount');
		$oTable->aColumn ['type_discount']=array('sTitle'=>'type_discount','sOrder'=>'dis.type_discount');
		$oTable->aColumn ['visible']=array('sTitle'=>'Visible','sOrder'=>'dis.visible');
		$oTable->aColumn ['post_date']=array('sTitle'=>'date','sOrder'=>'dis.date');
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
 		Base::$tpl->assign('aUserList', Base::$db->getAssoc("select id, login from user where type_='customer' order by login") );
 		Base::$tpl->assign('aTypeDiscountList', array(1));//Base::$db->getAssoc("select id, name from ec_type order by name") );
	}
	//-----------------------------------------------------------------------------------------------
}
?>