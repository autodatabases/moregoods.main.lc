<?

class AUserAccountLogType extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='user_account_log_type';
		$this->sTablePrefix='ualt';
		$this->sAction='user_account_log_type';
		$this->sWinHead=Language::getDMessage('User Account Log Types');
		$this->sPath=Language::GetDMessage('>>Customers >');
		$this->aCheckField=array('name');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();
		$oTable=new Table();
		$oTable->aColumn=array(
		'id'=>array('sTitle'=>'Id','sOrder'=>'ualt.id'),
		'name'=>array('sTitle'=>'Name','sOrder'=>'ualt.name'),
		'description'=>array('sTitle'=>'Description','sOrder'=>'ualt.description'),
		'method'=>array('sTitle'=>'Method','sOrder'=>'ualt.method'),
		'action'=>array(),
		);
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign(&$aData) {
		Base::$tpl->assign('aMethod', BaseTemp::EnumToArray('user_account_log_type','method'));
	}
	//-----------------------------------------------------------------------------------------------
}
?>