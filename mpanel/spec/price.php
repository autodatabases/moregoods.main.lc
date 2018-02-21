<?

/**
 * 
 *
 */
require_once (SERVER_PATH . '/class/core/Admin.php');
class APrice extends Admin
{
	//-----------------------------------------------------------------------------------------------
	function __construct()
	{
		$this->sTableName='price';
		$this->sTablePrefix='price';
		$this->sAction='price';
		$this->sWinHead=Language::getDMessage('Price');
		$this->sPath = Language::GetDMessage('>>Price >');
		$this->sSqlPath="Price";
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		$this->PreIndex();

		require_once(SERVER_PATH.'/class/core/Table.php');
		$oTable=new Table();
		$oTable->aColumn=array(
		'id'=>array('sTitle'=>'Id','sOrder'=>'price.id'),
		'id_price_group'=>array('sTitle'=>'id_price_group','sOrder'=>'pgs.id_price_group'),
		'id_provider'=>array('sTitle'=>'id_provider','sOrder'=>'price.id_provider'),
		'code'=>array('sTitle'=>'code','sOrder'=>'price.code'),
		'price'=>array('sTitle'=>'price','sOrder'=>'price.price'),
		'part_rus'=>array('sTitle'=>'part_rus','sOrder'=>'price.part_rus'),
		'pref'=>array('sTitle'=>'pref','sOrder'=>'price.pref'),
		'cat'=>array('sTitle'=>'cat','sOrder'=>'price.cat'),
		'post_date'=>array('sTitle'=>'post_date','sOrder'=>'price.post_date'),
		'term'=>array('sTitle'=>'term','sOrder'=>'price.term'),
		'stock'=>array('sTitle'=>'stock','sOrder'=>'price.stock'),
		'number_min'=>array('sTitle'=>'number_min','sOrder'=>'price.number_min'),
		'action'=>array(),
		);
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------


}
?>