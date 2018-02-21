<?

/**
 * @author Mikhail Starovoyt
 *
 */
class ACustomerType extends Admin {

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='user_customer_type';
		$this->sTablePrefix='ct';
		$this->sSqlPath = 'CustomerType/CustomerType';
		$this->sAction='customer_type';
		$this->sWinHead=Language::getDMessage('Customer type');
		$this->sPath = Language::GetDMessage('>>Users >');
//		$this->aCheckField=array('group_discount');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$this->initLocaleGlobal();
		$oTable=new Table();
		$oTable->aColumn=array(
		'id'=>array('sTitle'=>'Id','sOrder'=>'ct.id'),
		'customer_group_name'=>array('sTitle'=>'Name group','sOrder'=>'cg.name'),
		'name'=>array('sTitle'=>'Name','sOrder'=>'ct.name'),
		'visible'=>array('sTitle'=>'Visible','sOrder'=>'ct.visible'),
//		'group_discount'=>array('sTitle'=>'Group discount','sOrder'=>'ct.group_discount'),
//		'hours_expired_cart'=>array('sTitle'=>'Hours expired cart','sOrder'=>'ct.hours_expired_cart'),
		//'price_type'=>array('sTitle'=>'Price Type','sOrder'=>'cg.price_type'),
		//'customer_group_margin'=>array('sTitle'=>'Group Margin','sOrder'=>'cg.customer_group_margin'),
		//'language'=>array('sTitle' => 'Lang'),
		'action'=>array(),
		);
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}

	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign(&$aData) {
		Base::$tpl->assign('aCustomerGroupAssoc', DB::GetAssoc('Assoc/CustomerGroup',array('where'=>' and visible=1 ','order'=>' order by id ')));

//		Base::$tpl->assign('aPriceType', BaseTemp::EnumToArray('customer_type','price_type'));

		//		if (Base::$aData['id'] || Base::$aRequest['id']){
		//			//$aData=Base::GetSql('CustomerType/WithUserProvider',array('id'=>Base::$aRequest['id']));
		//			$aData = Base::$db->GetRow("select cg. * , dp. * , up. *,
		//		    cg.name as cg_name
		//			from customer_type AS cg
		//			  inner join discount_provider AS dp ON cg.code = dp.code_customer_group
		//			  inner join user_provider AS up ON dp.id_user_provider = up.id_user
		//			where cg.id=".Base::$aRequest['id']." order by up.name");
		//		}else{
		//			$aData = Base::$db->GetAll("select up. * from user_provider as up group by up.name");
		//		}

	}
	//-----------------------------------------------------------------------------------------------
	public function AfterApply($aBeforeRow,$aAfterRow) {
		//		if (Base::$aRequest['data']['id']){
		//			if (Base::$aRequest['provider_discount']){
		//				$provider_discount = Base::$aRequest['provider_discount'];
		//				foreach ($provider_discount as $key => $value){
		//					$sQuery = "insert into discount_provider (code_customer_group,id_user_provider,value) values
		//							('".Base::$aRequest['data']['code']."','".$key."','".$value."')
		//						on duplicate key update value='".$value."';";
		//					$res = Base::$db->Execute ( $sQuery );
		//				}
		//			}
		//			if ($res){
		//				$this->Message('MT_NOTICE', $this->sWinHead.' '.Language::getDMessage('was added'));
		//			}else{
		//				$this->Message('MT_ERROR', $this->sWinHead.' '.Language::getDMessage('was not added'));
		//			}
		//		}
	}
	//-----------------------------------------------------------------------------------------------
}
?>