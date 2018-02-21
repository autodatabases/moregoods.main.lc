<?
/**
 * @author Mikhail Starovoyt
 *
 */

require_once(SERVER_PATH.'/mpanel/spec/user.php');
class AManager extends AUser
{
	//-----------------------------------------------------------------------------------------------
	function __construct()
	{
		$this->sSqlPath = 'Manager';
		$this->sTableName = 'user';
		$this->sAdditionalLink='_manager';
		$this->sTablePrefix = 'ug';
		$this->sAction = 'manager';
		$this->sWinHead = Language::getDMessage ( 'Manager' );
		$this->sPath = Language::GetDMessage('>>Users >');
		$this->aCheckField = array ('login');
		$this->aChildTable = array(
		array('sTableName'=>'user_manager', 'sTablePrefix'=>'um', 'sTableId'=>'id_user'),
		);
		$this->Admin ();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		$this->PreIndex();

		$oTable=new Table();
		$oTable->aColumn=array(
		'id' => array('sTitle'=>'Id', 'sOrder'=>'u.id'),
		'login' => array('sTitle'=>'Login', 'sOrder'=>'u.login'),
		'name' => array('sTitle'=>'Name', 'sOrder'=>'um.name'),
		'email' => array('sTitle'=>'Email', 'sOrder'=>'u.email'),
		'visible' => array('sTitle'=>'Visible', 'sOrder'=>'u.visible'),
		'has_customer' => array('sTitle'=>'Has customers', 'sOrder'=>'um.has_customer'),
		'id_region' => array('sTitle'=>'Регион','sOrder'=>'um.id_region'),
		'id_customer_group' => array('sTitle'=>'Группа клиента','sOrder'=>'um.id_customer_group'),      
		'action' => array(),
		);
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign(&$aData)
	{
	    Base::$tpl->assign('aRegionList',Db::GetAssoc("select id, name from ec_region order by name"));
	    $aRegionGeo=Db::GetAssoc("select id, name_ru from net_city order by name_ru");
	    Base::$tpl->assign('aRegionGeo',$aRegionGeo);
	    Base::$tpl->assign('aCustomerGroup',Db::GetAssoc("select id, name from customer_group order by name"));
	}
	//-----------------------------------------------------------------------------------------------
	public function AfterApply($aBeforeRow,$aAfterRow) {
		//Db::Execute("delete from user_manager_region where id_user='".$aAfterRow['id']."'");
		if (Base::$aRequest['data']['user_manager_region']) {
			$aUserManagerRegion=array('id_user'=>$aAfterRow['id']);
			foreach (Base::$aRequest['data']['user_manager_region'] as $sKey => $sValue) {
				if ($sValue) {
					$aUserManagerRegion['id_provider_region']=$sKey;
					Db::AutoExecute('user_manager_region',$aUserManagerRegion);
				}
			}
		}
		/*if (Base::$aRequest['data']['customer_group']) {
		    $aUserManagerRegion=array('id_user'=>$aAfterRow['id']);
		    foreach (Base::$aRequest['data']['customer_group'] as $sKey => $sValue) {
		        if ($sValue) {
		            $aUserManagerRegion['id_customer_group']=$sKey;
		            Db::AutoExecute('user_manager_region',$aUserManagerRegion);
		        }
		    }
		}*/
	}
	//-----------------------------------------------------------------------------------------------


}

?>