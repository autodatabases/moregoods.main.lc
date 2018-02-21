<?
require_once(SERVER_PATH.'/class/core/Admin.php');
class ACatPart extends Admin {

	//-----------------------------------------------------------------------------------------------
	function ACatPart() {
		$this->sTableName='cat_part';
		$this->sTablePrefix='cp';
		$this->sTableId='id';
		$this->sAction='cat_part';
		$this->sWinHead=Language::getDMessage('Parts parameters');
		$this->sPath=Language::GetDMessage('>>Auto catalog >');
		$this->aCheckField=array('code');

		$this->sBeforeAddMethod='BeforeAdd';
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		require_once(SERVER_PATH.'/class/core/Table.php');
		$oTable=new Table();
		$oTable->aColumn=array(
		'id'=>array('sTitle'=>Language::getDMessage('Id'), 'sOrder'=>'cp.id', 'sWidth'=>5, 'sMethod'=>'exact'),
		'pref'=>array('sTitle'=>Language::getDMessage('Pref'), 'sOrder'=>'cp.pref', 'sWidth'=>10),
		'code'=>array('sTitle'=>Language::getDMessage('Code'), 'sOrder'=>'cp.code', 'sWidth'=>10),
		//'name'=>array('sTitle'=>'Name',Language::getDMessage('Name'), 'sOrder'=>'cp.name', 'sWidth'=>'40%'),
		'name_rus'=>array('sTitle'=>Language::getDMessage('Name Rus'), 'sOrder'=>'cp.name_rus', 'sWidth'=>'40%'),
		'weight'=>array('sTitle'=>Language::getDMessage('Weight'), 'sOrder'=>'cp.weight', 'sWidth'=>10),
		//'size_name'=>array('sTitle'=>Language::getDMessage('Size Name'), 'sOrder'=>'cp.size_name', 'sWidth'=>10),
		'action' => array ()
		);

		$this->SetDefaultTable ( $oTable);

		$oTable->bCheckVisible=false;
		$oTable->bCacheStepper=true;

		//$oTable->sSql=Base::GetSql('CatPart',array('where'=>$sWhere ));

		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAdd() {
		Base::$tpl->assign('aPref',Base::$db->getAssoc("select pref, concat(pref,' ',title) as name from cat order by name"));
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeApply() {
		Base::$aRequest['data']['item_code']=Base::$aRequest['data']['pref']."_".Base::$aRequest['data']['code'];
		if (!Base::$aRequest['data']['name_rus']){
			Base::$aRequest['data']['name_rus']=DB::GetOne("select part_rus from price where item_code='".Base::$aRequest['data']['item_code']."'");
		}
	}
	//-----------------------------------------------------------------------------------------------
}
?>
