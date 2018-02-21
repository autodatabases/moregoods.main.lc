<?

class ACatModel extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='cat_model';
		$this->sTablePrefix='cm';
		$this->sAction='cat_model';
		$this->sSqlPath='Cat/Model';
		$this->sWinHead=Language::GetDMessage('Cat Model');
		$this->sPath = Language::GetDMessage('>>Catalog >');
		//$this->aCheckField=array('name');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn ['id']=array('sTitle'=>'Id','sOrder'=>$this->sTablePrefix.'.id');
		//$oTable->aColumn ['code']=array('sTitle'=>'Code','sOrder'=>$this->sTablePrefix.'.code');
		$oTable->aColumn ['brand']=array('sTitle'=>'Brand','sOrder'=>$this->sTablePrefix.'.brand');
		$oTable->aColumn ['name']=array('sTitle'=>'Name','sOrder'=>$this->sTablePrefix.'.name');
		$oTable->aColumn ['visible']=array('sTitle'=>'Visible','sOrder'=>$this->sTablePrefix.'.visible');
		$oTable->aColumn ['action']=array();
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign($aData) {
	}
	//-----------------------------------------------------------------------------------------------
}
?>