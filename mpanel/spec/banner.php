<?
/**
 * @author 
 *
 */
class ABanner extends Admin
{
	//-----------------------------------------------------------------------------------------------
	function __construct()
	{
		$this->sTableName = 'banner';
		$this->sTablePrefix = 'b';
		$this->sAction = 'banner';
		$this->sWinHead = Language::getDMessage('Caorusel');
		$this->sPath = Language::GetDMessage('>>Content >');
		$this->aCheckField = array ('name','link','image');
		$this->sBeforeAddMethod = "BeforeAdd";
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		$this->PreIndex();
		$oTable=new Table();
		$oTable->aColumn=array(
		'id'=> array('sTitle'=>'Id', 'sOrder'=>'b.id'),
		'name' => array('sTitle'=>'name', 'sOrder'=>'b.name'),
		'link' => array('sTitle'=>'link', 'sOrder'=>'b.link'),
		'image'=>array('sTitle'=>'Image','sOrder'=>'b.image'),
		'image_small'=>array('sTitle'=>'Image small','sOrder'=>'b.image'),
		'visible' => array('sTitle'=>'visible', 'sOrder'=>'b.visible'),
	    'id_brand' => array('sTitle'=>'id_brand', 'sOrder'=>'b.id_brand'),
        'id_brand_group' => array('sTitle'=>'id_brand_group', 'sOrder'=>'b.id_brand_group'),
        'sort'=> array('sTitle'=>'order','sOrder'=>'b.sort'),
		'action' => array(),
		);
				
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
		
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAdd()
	{
	    Base::$tpl->assign('aBrandList',array(""=>"Бренди")+Db::GetAssoc("select id, name from ec_brand where visible=1 order by name"));
        Base::$tpl->assign('aGroupList',array(""=>"Групи")+Db::GetAssoc("select id, name from ec_brand_group where visible=1 order by name"));
	}
	//-----------------------------------------------------------------------------------------------
}
?>