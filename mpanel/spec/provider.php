<?

/**
 * @author Mikhail Starovoyt
 *
 * @version 4.5.1
 * - fixed:AT-138 customer creation with password was incorrect
 *
 * @version 4.5.0
 * Initial admin module from base auto box: AT-114
 */

require_once(SERVER_PATH.'/mpanel/spec/user.php');
class AProvider extends AUser {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sSqlPath = 'Provider';
		$this->sTableName = 'user';
		$this->sAdditionalLink='_provider';
		$this->sTablePrefix = 'u';
		$this->sAction = 'provider';
		$this->sWinHead = Language::getDMessage ( 'Providers' );
		$this->sPath = Language::GetDMessage('>>Users >');
		$this->aCheckField = array ('login');
		$this->aChildTable = array(
		array('sTableName'=>'user_provider', 'sTablePrefix'=>'up', 'sTableId'=>'id_user'),
		);
		$this->Admin ();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		//$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn=array(
		'id' => array('sTitle'=>'Id', 'sOrder'=>'u.id'),
		'login' => array('sTitle'=>'Login', 'sOrder'=>'u.login'),
		//'code_name' => array('sTitle'=>'CodeName', 'sOrder'=>'up.code_name'),
		'name' => array('sTitle'=>'Name', 'sOrder'=>'up.name'),
		'pg_name' => array('sTitle'=>'Provider Group', 'sOrder'=>'up.id_provider_group'),
		//'provider_region_name' => array('sTitle'=>'Region','sOrder'=>'pr.name'),
		//'email' => array('sTitle'=>'Email', 'sOrder'=>'u.email'),
		'is_our_store' => array('sTitle'=>'Is Our Store', 'sOrder'=>'up.is_our_store'),
		'visible' => array('sTitle'=>'Visible', 'sOrder'=>'u.visible'),
		//'language'=>array('sTitle' => 'Lang'),
		'action' => array(),
		);
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function AfterApply($aBeforeRow,$aAfterRow) {
		if(!$aBeforeRow)
		{
			Base::$db->AutoExecute ('provider_virtual',	array(
			'id_provider' => $aAfterRow[$this->sTableId],
			'id_provider_virtual' => $aAfterRow[$this->sTableId],
			),'INSERT');
			Base::$db->AutoExecute ('user_account',	array(
			'id_user' => $aAfterRow[$this->sTableId],
			),'INSERT');
		}

		if (Base::$aRequest['provider_statistic']){
			foreach (Base::$aRequest['provider_statistic'] as $key => $value){
				if (!$value['manual_delivery_term'] && Base::$aRequest['manual_delivery_term_all'])
				$value['manual_delivery_term']=Base::$aRequest['manual_delivery_term_all'];

				if (!$value['manual_refuse_percent'] && Base::$aRequest['manual_refuse_percent_all'])
				$value['manual_refuse_percent']=Base::$aRequest['manual_refuse_percent_all'];

				if (!$value['manual_confirm_term'] && Base::$aRequest['manual_confirm_term_all'])
				$value['manual_confirm_term']=Base::$aRequest['manual_confirm_term_all'];

				if ($value['manual_delivery_term'] || $value['manual_refuse_percent'] || $value['manual_confirm_term'] ) {
					$sQuery = "insert into provider_statistic
							(make,id_user,manual_delivery_term,manual_refuse_percent,manual_confirm_term) values
							('$key','".$aAfterRow['id_user']."','".$value['manual_delivery_term']."'
								,'".$value['manual_refuse_percent']."','".$value['manual_confirm_term']."')
						on duplicate key update
							manual_delivery_term='".$value['manual_delivery_term']."'
							,manual_refuse_percent='".$value['manual_refuse_percent']."'
							,manual_confirm_term='".$value['manual_confirm_term']."';";
					Db::Execute($sQuery);
				}
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign($aData) {
		$aProviderGroupList = Base::$db->getAssoc("select id, concat(name,' ',group_margin,'% ') as name
			from provider_group order by name");
		if($aProviderGroupList) {
			Base::$tpl->assign ( 'aProviderGroupList', $aProviderGroupList );
			Base::$tpl->assign ( 'sProviderGroupSelected', $aData['id_provider_group'] );
		}

		Base::$tpl->assign('aCodeCurrency', Db::GetAssoc("Assoc/Currency"));
		Base::$tpl->assign('aCurrency', Db::GetAssoc("Assoc/Currency",array("type_"=>"id")));

		//Base::$tpl->assign ( 'sUserSelected', 4326 );
		$aProviderRegionList = Base::$db->getAssoc("select id, concat(name, ' ', code_delivery) as name from provider_region
			order by name, code_delivery");
		if($aProviderRegionList) {
			Base::$tpl->assign ( 'aProviderRegionList', $aProviderRegionList );
			Base::$tpl->assign ( 'sProviderRegionSelected', $aData['id_provider_region'] );
		}
		/*$aCat=Base::$db->GetAll(Base::GetSql("Cat",array('order'=>" c.name")));
		if ($aData['id'] && $aCat) {
			$aProviderMakeStatistic=Base::$db->GetAssoc(Base::GetSql("ProviderMakeStatistic",array('id_user'=>$aData['id'])));
			foreach ($aCat as $key => $value) {
				$aCat[$key]['manual_delivery_term']=$aProviderMakeStatistic[$value['name']]['manual_delivery_term'];
				$aCat[$key]['manual_refuse_percent']=$aProviderMakeStatistic[$value['name']]['manual_refuse_percent'];
				$aCat[$key]['manual_confirm_term']=$aProviderMakeStatistic[$value['name']]['manual_confirm_term'];
			}
		}
		Base::$tpl->assign('aCat',$aCat);*/
	}
	//-----------------------------------------------------------------------------------------------
	public function Clear() {
		if(Base::$aRequest['id']){
			Db::Execute("update price set price=0 where id_provider ='".Base::$aRequest['id']."' ");
		}
	}
	//-----------------------------------------------------------------------------------------------
	
}
?>
