<?

/**
 * @author Mihail Starovoyt
 *
 */

class AEcGroupP extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='ec_group_p';
		$this->sTablePrefix='gp';
		$this->sAction='ec_group_p';
		$this->sWinHead=Language::getDMessage('Group_p');
		$this->sPath = Language::GetDMessage('>>Obriy >');
		$this->aCheckField=array('name');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['id']=array('sTitle'=>'Id','sOrder'=>'gp.id');
		$oTable->aColumn ['name']=array('sTitle'=>'Name','sOrder'=>'gp.name');
		$oTable->aColumn ['short_name']=array('sTitle'=>'short name','sOrder'=>'gp.short_name');
		$oTable->aColumn ['post_date']=array('sTitle'=>'date','sOrder'=>'gp.date');
		$oTable->aColumn ['sort']=array('sTitle'=>'order','sOrder'=>'gp.sort');
		$oTable->aColumn ['visible']=array('sTitle'=>'Visible','sOrder'=>'gp.visible');
		$oTable->aColumn ['action']=array();
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign($aData) {
// 		Base::$tpl->assign('aRegionList', Base::$db->getAssoc("select id, name from office_region order by name") );
// 		Base::$tpl->assign('aCityList', Base::$db->getAssoc("select id, name from office_city order by name") );
	}
	//-----------------------------------------------------------------------------------------------
}
?>