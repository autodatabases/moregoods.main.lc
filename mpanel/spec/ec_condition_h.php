<?

/**
 * @author Mihail Starovoyt
 *
 */

class AEcConditionH extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='ec_condition_h';
		$this->sTablePrefix='ch';
		$this->sAction='ec_condition_h';
		$this->sWinHead=Language::getDMessage('condition_h');
		$this->sPath = Language::GetDMessage('>>Obriy >');
		$this->aCheckField=array('id_region','id_group_p','name','dt1','dt2');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['id']=array('sTitle'=>'Id','sOrder'=>'ch.id');
		$oTable->aColumn ['region']=array('sTitle'=>'region','sOrder'=>'r.name');
		$oTable->aColumn ['group_p']=array('sTitle'=>'group_p','sOrder'=>'gp.name');
		$oTable->aColumn ['name']=array('sTitle'=>'name','sOrder'=>'ch.name');
		$oTable->aColumn ['dt1']=array('sTitle'=>'dt1','sOrder'=>'ch.dt1');
		$oTable->aColumn ['dt2']=array('sTitle'=>'dt2','sOrder'=>'ch.dt2');
		$oTable->aColumn ['visible']=array('sTitle'=>'Visible','sOrder'=>'ch.visible');
		$oTable->aColumn ['action']=array();
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign($aData) {
        Base::$tpl->assign('aRegionList', Base::$db->getAssoc("select id, name from ec_region order by name") );
        Base::$tpl->assign('aGroupPList', Base::$db->getAssoc("select id, name from ec_group_p order by name") );
	}
	//-----------------------------------------------------------------------------------------------
}
?>