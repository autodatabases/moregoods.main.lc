<?

/**
 * @author Mihail Starovoyt
 *
 */

class AEcDistributorRegion extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='ec_distributor_region';
		$this->sTablePrefix='dr';
		$this->sAction='ec_distributor_region';
		$this->sWinHead=Language::getDMessage('distributor region');
		$this->sPath = Language::GetDMessage('>>Obriy >');
		$this->aCheckField=array('id_distributor','id_region');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['id']=array('sTitle'=>'Id','sOrder'=>'dr.id');
		$oTable->aColumn ['distributor']=array('sTitle'=>'distributor','sOrder'=>'d.name');
		$oTable->aColumn ['region']=array('sTitle'=>'region','sOrder'=>'r.name');
		$oTable->aColumn ['post_date']=array('sTitle'=>'date','sOrder'=>'dr.date');
		$oTable->aColumn ['action']=array();
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign($aData) {
 		Base::$tpl->assign('aRegionList', Base::$db->getAssoc("select id, name from ec_region order by name") );
 		Base::$tpl->assign('aDistributorList', Base::$db->getAssoc("select id, name from ec_distributor order by name") );
	}
	//-----------------------------------------------------------------------------------------------
}
?>