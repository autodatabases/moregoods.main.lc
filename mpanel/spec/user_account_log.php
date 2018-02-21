<?

/**
 * @author Mikhail Starovoyt
 */
require_once(SERVER_PATH.'/mpanel/spec/account_log.php');
class AUserAccountLog extends AAccountLog
{
	public $sPathToFile='/imgbank/temp_upload/';

	//-----------------------------------------------------------------------------------------------
	function __construct() {
		$this->sTableName='user_account_log';
		$this->sTablePrefix='ual';
		$this->sAction='user_account_log';
		$this->sWinHead=Language::getDMessage('User account log');
		$this->sPath = Language::GetDMessage('>>Users >');
		//$this->aCheckField=array('login','name','passwd');
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		$this->PreIndex();

		Base::$tpl->assign('aPayType', BaseTemp::EnumToArray("user_account_log","pay_type"));
		Base::$tpl->assign('aSection', BaseTemp::EnumToArray("user_account_log","section"));

		// type
		$aType = array( '' 	 => 'All',
		'debet' => 'Debet',
		'credit' => 'Credit',
		);
		Base::$tpl->assign('aType', $aType);
		$aUserType = array(
		'customer'=>'Customer',
		'provider'=>'Provider',
		'vip'=>'VipRep',
		);
		Base::$tpl->assign('aUserType', $aUserType);

		Base::$tpl->assign('sForDate', strtotime('+1 day'));
		Base::$tpl->assign('sFromDate', mktime(0, 0, 0, date("m")-6, date("d"), date("Y")));

		Base::$tpl->assign('aUserAccountLogType',Base::$db->GetAssoc(Base::GetSql('Finance/UserAccountLogTypeAssoc')));
		// search form
		//User::AssignPartnerRegion();

		//Base::$tpl->assign('aAccount', array(''=>'All')+Db::GetAssoc("Assoc/Account"));

		$this->SearchForm();

		if ($this->aSearch) {
			$this->aSearch['login'] = trim($this->aSearch [login]);
			if ($this->aSearch['login'] && $this->aSearch['user_type']!='vip') {
				$this->sSearchSQL.= " and u.login = '".$this->aSearch['login']."'";
			}

			if ($this->aSearch[date_from])
			$this->sSearchSQL.= " and ual.post_date>='".DateFormat::FormatSearch($this->aSearch['date_from'])."' ";
			if ($this->aSearch[date_to])
			$this->sSearchSQL.= " and ual.post_date<='".DateFormat::FormatSearch($this->aSearch['date_to'])."'";
			if ($this->aSearch[custom_id])
			$this->sSearchSQL.= " and custom_id='".$this->aSearch['custom_id']."' ";
			if ($this->aSearch[amount])
			$this->sSearchSQL.= " and ual.amount ='".trim($this->aSearch['amount'])."'";
			if ($this->aSearch[pay_type])
			$this->sSearchSQL.= " and ual.pay_type='".$this->aSearch['pay_type']."' ";
			if ($this->aSearch[description])
			$this->sSearchSQL.= " and ual.description like '%".trim($this->aSearch['description'])."%'";
			if ($this->aSearch[type_]){
				switch ($this->aSearch['type_']){
					case "debet":
						$this->sSearchSQL.=" and ual.amount>=0 ";
						break;
					case "credit":
						$this->sSearchSQL.=" and ual.amount<0 ";
						break;
				}
			}

			if ($this->aSearch['section'])
			$this->sSearchSQL .= " and ual.section='".$this->aSearch['section']."' ";

			if ($this->aSearch['id_provider_invoice']){
				$aWhereData = array();
				$aWhereData['join1'] = "inner join cart as c on (ual.custom_id=c.id and ual.section in ('cart','debt')
					    and c.id_provider_invoice ='".$this->aSearch['id_provider_invoice']."')";
				$aWhereData['join2'] ="inner join cart_package as cp on (cp.id=ual.custom_id and ual.section in ('cart_package'))
						inner join cart as c on (cp.id=c.id_cart_package
					    and c.id_provider_invoice ='".$this->aSearch['id_provider_invoice']."')";
			}

			if ($this->aSearch['id_user_account_log_type'])
			$this->sSearchSQL .= " and ual.id_user_account_log_type='".$this->aSearch['id_user_account_log_type']."'";

			switch ($this->aSearch['user_type']) {
				case 'provider':
					$this->sSqlPath="Finance/UserAccountLog";
					$this->sSearchSQL.= " and u.type_='provider'";
					break;
				case 'vip':
					if ($this->aSearch['login']) $aVipRepresentative=Base::$db->getRow(Base::GetSql('Customer',
					array('login'=>$this->aSearch['login'])));
					if ($aVipRepresentative) {
						$aIdVipUser=array_keys(Db::GetAssoc('Assoc/UserCustomer'
						,array('where'=>" and uc.id_parent='".$aVipRepresentative['id']."'")));
						$aIdVipUser[]=$aVipRepresentative['id'];
						$this->sSearchSQL.=" and ual.id_user in(".implode(',',$aIdVipUser).")";
					}
					else $this->sSearchSQL.=" and 1!=1";
					break;
			}

			if ($this->aSearch['id_account'])
			$this->sSearchSQL .= " and ual.id_account='".$this->aSearch['id_account']."'";
		}

		if ($this->aSearch){
			$aData = $aWhereData;
			if ($this->sSearchSQL) {
				$aDataDebet['where'] = $aData['where'].$this->sSearchSQL.' and ual.amount>0';
				$aDataCredit['where'] = $aData['where'].$this->sSearchSQL.' and ual.amount<0';
			}
			$aDataDebet['sum'] = 'ual.amount';
			$aDataCredit['sum'] = 'ual.amount';

			Base::$tpl->assign('dTotalAmountDebet', Base::$db->GetOne(Base::GetSql('UserAccountLog',$aDataDebet)));
			Base::$tpl->assign('dTotalAmountCredit', Base::$db->GetOne(Base::GetSql('UserAccountLog',$aDataCredit)));
		}

		Base::$sText .= $this->SearchForm();

		$oTable=new Table();
		$oTable->aColumn=array(
		'id'=>array('sTitle'=>'Id','sOrder'=>'ual.id'),
		'login'=>array('sTitle'=>'Login','sOrder'=>'u.login'),
		'account_amount'=>array('sTitle'=>'Account Amount/DebtAmount','sOrder'=>'account_amount'),
		'debet'=>array('sTitle'=>'admin debet','sOrder'=>'ual.amount'),
		'credit'=>array('sTitle'=>'admin credit','sOrder'=>'ual.amount'),
		'post_date'=>array('sTitle'=>'Post date','sOrder'=>'post_date'),
		'pay_type'=>array('sTitle'=>'Pay Type','sOrder'=>'pay_type'),
		'description'=>array('sTitle'=>'Description','sOrder'=>'description'),
		'action'=>array(),
		);

		// show search result form if find only 1 user by like criteria
		$aData = $aWhereData;
		$this->GetResultByFindLogin('login', $aData);

		$aWhereData['join_account']=1;
		// debt
		$aCustomerDebt=Base::$db->GetAll(Base::GetSql('CustomerDebt'));
		$aCustomerDebtHash=Language::Array2Hash($aCustomerDebt,'id_user');
		Base::$tpl->assign('aCustomerDebtHash', $aCustomerDebtHash);

		$this->SetDefaultTable($oTable, $aWhereData);
		$_SESSION['mpanel']['user_account_log']['sql']=$oTable->sSql;
		//$oTable->bCountStepper=true;
		Base::$sText.=$oTable->getTable();
		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function Export()
	{
		$aUserAccountLog=Db::GetAll($_SESSION['mpanel']['user_account_log']['sql']);

		if ($aUserAccountLog)
		{
			$sFileName=DateFormat::GetFileDateTime(time(),'',false)."_ual.xls";

			$oExcel = new Excel();

			$aHeader=array(
			'A'=>array("value"=>"id"),
			'B'=>array("value"=>"login", "autosize"=>true),
			'C'=>array("value"=>"current_account_amount", "autosize"=>true),
			'D'=>array("value"=>"account_amount", "autosize"=>true),
			'E'=>array("value"=>"amount_debet", "autosize"=>true),
			'F'=>array("value"=>"amount_credit", "autosize"=>true),
			'G'=>array("value"=>"post_date", "autosize"=>true),
			'H'=>array("value"=>"user_account_log_type_name", "autosize"=>true),
			'I'=>array("value"=>"description", "autosize"=>true),
			'J'=>array("value"=>"data", "autosize"=>true),
			'K'=>array("value"=>"pay_type", "autosize"=>true),
			);

			$oExcel->SetHeaderValue($aHeader,1);
			$oExcel->SetAutoSize($aHeader);
			$oExcel->DuplicateStyleArray("A1:K1");

			$i=$j=2;
			foreach ($aUserAccountLog as $aValue)
			{
				$oExcel->SetCellValue('A'.$i, $aValue['id']);
				$oExcel->SetCellValue('B'.$i, $aValue['login']);
				$oExcel->SetCellValue('C'.$i, $aValue['current_account_amount']);
				$oExcel->SetCellValue('D'.$i, $aValue['account_amount']);
				$oExcel->SetCellValue('E'.$i, ($aValue['amount']>0 ? $aValue['amount']:'') );
				$oExcel->SetCellValue('F'.$i, ($aValue['amount']<0 ? $aValue['amount']:''));
				$oExcel->SetCellValue('G'.$i, $aValue['post_date']);
				$oExcel->SetCellValue('H'.$i, String::UtfEncode($aValue['user_account_log_type_name']));
				$oExcel->SetCellValue('I'.$i, String::UtfEncode($aValue['description']));
				$oExcel->SetCellValue('J'.$i, String::UtfEncode($aValue['data']));
				$oExcel->SetCellValue('K'.$i, String::UtfEncode($aValue['pay_type']));
				$i++;
			}

			$oExcel->WriterExcel5(SERVER_PATH.$this->sPathToFile.$sFileName);
		}
		else {
			Base::$oResponse->addAlert(Language::GetMessage("No data to export"));
			return;
		}

		Base::$tpl->assign('sFileName',$sFileName);
		Base::$tpl->assign('sFilePath',$this->sPathToFile.$sFileName);

		$this->sFileContent=Base::$tpl->fetch('mpanel/user_account_log/export_file.tpl');
		//$this->Index();
		Base::$oResponse->addAssign('export_file_id','innerHTML',$this->sFileContent);
	}
	//-----------------------------------------------------------------------------------------------
}
?>