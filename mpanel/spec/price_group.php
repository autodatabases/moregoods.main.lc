<?
/**
 * @author Oleksandr Starovoit
 * @author Mikhail Starovoyt
 * @version 4.5.2
 */
class APriceGroup extends Admin {
	//-----------------------------------------------------------------------------------------------
	public function __construct()
	{
		$this->sTableName='price_group';
		$this->sTablePrefix='pg';
		$this->sAction='price_group';
		$this->sSqlPath="Price/Group";
		$this->sWinHead=Language::getDMessage('Price group');
		$this->sPath=Language::GetDMessage('>>Auto catalog >');
		$this->aCheckField=array('code','name');
		$this->Admin();
		$this->sBeforeAddMethod='BeforeAdd';
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal ();
		$oTable=new Table();
		$sTablePref = 'pg.';
		$oTable->aColumn=array(
		'id'=>array('sTitle'=>'Id','sOrder'=>$sTablePref.'id'),
		'code'=>array('sTitle'=>'Code','sOrder'=>$sTablePref.'code'),
		'code_name'=>array('sTitle'=>'Code name','sOrder'=>$sTablePref.'code_name'),
		'name'=>array('sTitle'=>'Name','sOrder'=>$sTablePref.'name'),
		'level'=>array('sTitle'=>'Level','sOrder'=>$sTablePref.'level'),
		'id_parent'=>array('sTitle'=>'ID Parent','sOrder'=>$sTablePref.'id_parent'),
		'is_product_list_visible'=>array('sTitle'=>'Product visible','sOrder'=>$sTablePref.'is_product_list_visible'),
		'image' => array('sTitle'=>'Image', 'sOrder'=>$sTablePref.'image'),
		'is_menu'=>array('sTitle'=>'is menu','sOrder'=>$sTablePref.'is_menu'),
		'weight'=>array('sTitle'=>'weight','sOrder'=>$sTablePref.'weight'),
		'is_main'=>array('sTitle'=>'is main','sOrder'=>$sTablePref.'is_main'),
		'visible'=>array('sTitle'=>'Visible','sOrder'=>$sTablePref.'visible'),
		'language'=>array('sTitle' => 'Lang' ),
		'action'=>array(),
		);
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign($aData) {
		$aBaseLevelGroups =  array('0'=>'not selected')+Base::$db->getAssoc("select id, CONCAT(id,' - ',name) as name_group
			from price_group where level in ('0','2') order by name");
		$aBaseLevels = array(0=>0,1=>1,2=>2);
		
		
		Base::$tpl->assign ( 'aBaseLevelGroups', $aBaseLevelGroups );
		Base::$tpl->assign ( 'sBaseLevelGroups', $aData['id_parent'] );
		Base::$tpl->assign ( 'aBaseLevels', $aBaseLevels );
		Base::$tpl->assign ( 'sBaseLevels', $aData['level'] );
	}
	//-----------------------------------------------------------------------------------------------
	public function AfterApply ($aBeforeRow,$aAfterRow) {
	    //remove cache
	    if(file_exists(SERVER_PATH."/cache/Home/main_groups.cache")) unlink(SERVER_PATH."/cache/Home/main_groups.cache");
	    if(file_exists(SERVER_PATH."/cache/Home/main_tabs.cache")) unlink(SERVER_PATH."/cache/Home/main_tabs.cache");
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAdd() {
		$aHandbook=Base::$db->GetAll('select * from handbook');
		Base::$tpl->assign('aHandbook',$aHandbook);
	
		$aPriceGroupFilter=Base::$db->GetAll("select * from price_group_filter
			where id_price_group='".Base::$aRequest['id']."'");
		//Base::$tpl->assign('aPriceGroupFilter',$aPriceGroupFilter);
	
		$aSelectedHandbook=array();
		if ($aPriceGroupFilter)
		foreach($aPriceGroupFilter as $key=>$value){
			$aSelectedHandbook[$value['id_handbook']]=$value['id_handbook'];
		}
		Base::$tpl->assign('aSelectedHandbook',$aSelectedHandbook);
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeApply() {
		Base::$db->Execute("delete from price_group_filter where id_price_group='".Base::$aRequest['data']['id']."'");
		$aHandBook=Base::$aRequest['data']['handbook'];
		if ($aHandBook){
			foreach ($aHandBook as $aItem){
				$aData=array(
					'id_handbook'=>$aItem,
					'id_price_group'=>Base::$aRequest['data']['id'],
				);
				Db::AutoExecute('price_group_filter',$aData);
			}
		}
	}
	//-----------------------------------------------------------------------------------------------

}
?>