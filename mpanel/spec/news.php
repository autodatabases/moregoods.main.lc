<?

/**
 * @author Mikhail Starovoyt
 */

class ANews extends Admin
{
	//-----------------------------------------------------------------------------------------------
	function __construct()
	{
		$this->sTableName = 'news';
		$this->sTablePrefix = 'n';
		$this->sAction = 'news';
		$this->sWinHead = Language::getDMessage('News');
		$this->sPath = Language::GetDMessage('>>Content >');
		$this->aCheckField = array('short','id_region','id_customer_group');
		//$this->sAddonPath='addon/';
		$this->sSqlPath='News';
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		$this->PreIndex ();

		$oTable = new Table ( );
		$oTable->aColumn = array ();
		$oTable->aColumn ['id'] = array ('sTitle' => 'Id', 'sOrder' => 'n.id' );
		$oTable->aColumn ['short'] = array ('sTitle' => 'Short', 'sOrder' => 'n.short' );
		$oTable->aColumn ['image'] = array ('sTitle' => 'Image', 'sOrder' => 'n.image' );
		$oTable->aColumn ['section'] = array ('sTitle' => 'Section', 'sOrder' => 'n.section' );
		$oTable->aColumn ['full'] = array ('sTitle' => 'Full', 'sOrder' => 'n.full' );
		$oTable->aColumn ['date'] = array ('sTitle' => 'Date', 'sOrder' => 'n.post_date' );
		$oTable->aColumn ['customer_group_name'] =	array('sTitle'=>'Gustomer group','sOrder'=>'cg.name');
		$oTable->aColumn ['region'] = array('sTitle'=>'region','sOrder'=>'r.name');
		$oTable->aColumn ['visible'] = array ('sTitle' => 'Visible', 'sOrder' => 'n.visible' );
		$oTable->aColumn ['num'] = array ('sTitle' => 'Num', 'sOrder' => 'n.num' );
		$this->initLocaleGlobal ();
		$oTable->aColumn ['language'] = array ('sTitle' => 'Lang' );
		$oTable->aColumn ['action'] = array ();
		$this->SetDefaultTable($oTable );
		Base::$sText .= $oTable->getTable ();

		$this->AfterIndex ();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeApply()
	{
		if (date('Y-m-d', strtotime(Base::$aRequest['data']['post_date'])) != '1970-01-01')
		    Base::$aRequest['data']['post_date'] = date('Y-m-d', strtotime(Base::$aRequest['data']['post_date']));
		else
		    Base::$aRequest['data']['post_date'] = '';
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign(&$aData)
	{
		if (!$aData['post_date']) $iTime=time();
		else $iTime=strtotime($aData['post_date']);

		$aData['post_date'] = date(Base::GetConstant('date_format:post_date'),$iTime);

		Base::$tpl->assign('aCustomerGroupAssoc', DB::GetAssoc('Assoc/CustomerGroup'));
		Base::$tpl->assign('aCustomerGroup', $aCustomerGroup);
		Base::$tpl->assign('aRegionList',Db::GetAssoc("select  0 as id, 'All' as name union all	select id, name from ec_region order by name"));
	}
	//-----------------------------------------------------------------------------------------------
}
?>