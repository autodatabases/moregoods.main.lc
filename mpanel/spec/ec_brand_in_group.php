<?

/**
 * @author Mihail Starovoyt
 *
 */

class AEcBrandInGroup extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='ec_brand_in_group';
		$this->sTablePrefix='bigr';
		$this->sAction='ec_brand_in_group';
		$this->sWinHead=Language::getDMessage('brand_in_group');
		$this->sPath = Language::GetDMessage('>>Obriy >');
		$this->aCheckField=array('id_brand_group','id_brand');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['id']=array('sTitle'=>'Id','sOrder'=>'bigr.id');
		$oTable->aColumn ['brand_group']=array('sTitle'=>'brand group','sOrder'=>'bg.name');
		$oTable->aColumn ['brand']=array('sTitle'=>'brand','sOrder'=>'b.name');
		$oTable->aColumn ['image']=array('sTitle'=>'image');
		$oTable->aColumn ['post_date']=array('sTitle'=>'date','sOrder'=>'bigr.date');
		$oTable->aColumn ['visible']=array('sTitle'=>'Visible','sOrder'=>'bigr.visible');
		$oTable->aColumn ['action']=array();
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign($aData) {
 		Base::$tpl->assign('aBrandGroupList', Base::$db->getAssoc("select id, name from ec_brand_group order by name") );
 		Base::$tpl->assign('aBrandList', Base::$db->getAssoc("select id, name from ec_brand order by name") );
	}
	//-----------------------------------------------------------------------------------------------
}
?>