<?
/**
 * @author Mikhail Starovoyt
 */

class Finance extends Base
{
	private static $aHaveMoney=array();
	public static $aUserAccountLogTypeAssoc=array();

	//-----------------------------------------------------------------------------------------------
	public function __construct()
	{
		if (Base::$aRequest['action']!='finance_payforaccount') {
			Auth::NeedAuth();
			Base::$aTopPageTemplate=array('panel/tab_'.Auth::$aUser['type_'].'.tpl'=>'finance');
		}
		Base::$aData['template']['bWidthLimit']=false;
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		$aUserAccount=Base::$db->getRow("select * from user_account where 1=1 ".Auth::$sWhere);
		$aUserAccount['amount']=Currency::PrintPrice($aUserAccount['amount'],Auth::$aUser['code_currency']);
		Base::$tpl->assign('aUserAccount',$aUserAccount);
		Base::$tpl->assign('sDiscount', Discount::CustomerDiscount(Auth::$aUser));
		Base::$tpl->assign('sDebt',Currency::PrintPrice(
		max(array(Auth::$aUser['user_debt'], Auth::$aUser['group_debt']))),Auth::$aUser['code_currency']);

		Base::$tpl->assign('aAccesType',array(
		'own'=>Language::GetMessage('Own finance'),
		'subuser'=>Language::GetMessage('Subuser finance'),
		));
		Base::$tpl->assign('aUserAccountLogType',Base::$db->GetAssoc(Base::GetSql('Finance/UserAccountLogTypeAssoc')));

		$aData=array(
		'sHeader'=>"",
		'sTitle'=>"Finance info",
		'sContent'=>Base::$tpl->fetch('finance/form_user_account_log_search.tpl'),
		'sSubmitButton'=>'Search',
		'sSubmitAction'=>'finance',
		'sReturnButton'=>'Clear',
		'bIsPost'=>0,
		'sError'=>$sError,
		);
		$oForm=new Form($aData);

		Base::$sText.=$oForm->getForm();


		// --- search ---
		if (Base::$aRequest['search']['date']) {
			$sWhere.=" and ual.post>='".strtotime(Base::$aRequest['date_from'])."'
				and ual.post<='".strtotime(Base::$aRequest['date_to'])."'";
		}
		if (Base::$aRequest['search']['subuser_login']) $sWhere.=" and u.login='".Base::$aRequest['search']['subuser_login']."'";

		if (Base::$aRequest['search']['acces_type']=='own' || !Base::$aRequest['search']['acces_type']) {
			$sWhere.=" and ual.id_user='".Auth::$aUser['id']."'";
		}
		else {
			$aSubuserId=array_keys(Base::$db->GetAssoc(Base::GetSql('Customer/SubuserAssoc',array(
			'id_user'=>Auth::$aUser['id'],
			))));
			$sWhere.=" and ual.id_user in(".implode(',',$aSubuserId).")";
		}
		if (Base::$aRequest['search']['id_user_account_log_type']) {
			$sWhere.=" and ual.id_user_account_log_type='".Base::$aRequest['search']['id_user_account_log_type']."'";
		}
		if (Base::$aRequest['search']['id']) {
			$sWhere.=" and ual.id='".Base::$aRequest['search']['id']."'";
		}
		// --------------

		$oTable=new Table();
		$oTable->iRowPerPage=20;
		$oTable->sSql=Base::GetSql('UserAccountLog',array('where'=>$sWhere));
		$_SESSION['finance']['current_sql']=$oTable->sSql;
		$oTable->aOrdered="order by id desc";
		$oTable->aColumn=array(
		'current_account_amount'=>array('sTitle'=>'PostAccountAmount'),
		'account_amount'=>array('sTitle'=>'AccountAmount/DebtAmount'),
		'debet'=>array('sTitle'=>'finance debet'),
		'credit'=>array('sTitle'=>'finance credit'),
		'post'=>array('sTitle'=>'Date'),
		'description'=>array('sTitle'=>'UalDescription'),
		);
		$oTable->sDataTemplate='finance/row_user_account_log.tpl';
		$oTable->sButtonTemplate='finance/button_finance.tpl';
		$oTable->aCallback=array($this,'CallParseLog');

		Base::$sText.=$oTable->getTable("Account Log",'customer_account_log');
	}
	//-----------------------------------------------------------------------------------------------
	public function CallParseLog(&$aItem)
	{
		$aCustomerDebt=Base::$db->GetAll(Base::GetSql('CustomerDebt'));
		$aCustomerDebtHash=Language::Array2Hash($aCustomerDebt,'id_user');
		//Base::$tpl->assign('aCustomerDebtHash',$aCustomerDebtHash);

		if ($aItem) foreach($aItem as $key => $value) {
			$aItem[$key]['current_debt_amount']=$aCustomerDebtHash[$value['id_user']]['amount'];
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function ExportAll()
	{

		$sFileName=Finance::CreateFinanceExcel($_SESSION['finance']['current_sql'].' order by ual.id desc');
		Base::$tpl->assign('sFileName',$sFileName);

		Base::$sText.=Base::$tpl->fetch('finance/export.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	public static function CreateFinanceExcel($sSql,$bShowCustomer=false)
	{
		set_include_path(SERVER_PATH.'/lib/PHPExcel/');
		require_once(SERVER_PATH.'/lib/PHPExcel/PHPExcel.php');
		require_once(SERVER_PATH.'/lib/PHPExcel/PHPExcel/Writer/Excel2007.php');
		require_once(SERVER_PATH.'/lib/PHPExcel/PHPExcel/Writer/Excel5.php');

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setCellValue('A2', iconv('windows-1251','utf-8',Language::getMessage('LOG_CurrentAmount')));
		$objPHPExcel->getActiveSheet()->setCellValue('B2', iconv('windows-1251','utf-8',Language::getMessage('LOG_AccountAmount')));
		$objPHPExcel->getActiveSheet()->setCellValue('C2', iconv('windows-1251','utf-8',Language::getMessage('LOG_Amount')));
		$objPHPExcel->getActiveSheet()->setCellValue('D2', iconv('windows-1251','utf-8',Language::getMessage('LOG_CustomId')));
		$objPHPExcel->getActiveSheet()->setCellValue('E2', iconv('windows-1251','utf-8',Language::getMessage('LOG_POST')));
		$objPHPExcel->getActiveSheet()->setCellValue('F2', iconv('windows-1251','utf-8',Language::getMessage('LOG_Type')));
		$objPHPExcel->getActiveSheet()->setCellValue('G2', iconv('windows-1251','utf-8',Language::getMessage('LOG_PayType')));
		$objPHPExcel->getActiveSheet()->setCellValue('H2', iconv('windows-1251','utf-8',Language::getMessage('LOG_Description')));

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

		$objPHPExcel->getActiveSheet()->duplicateStyleArray(
		array('font'    => array('bold'      => true),
		'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		'borders' => array('top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
		),
		'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID  ,'rotation'   => 90,
		'startcolor' => array('argb' => 'FFA0A0A0'),'endcolor'   => array('argb' => 'FFFFFFFF'
		))),'A2:M2');

		$objPHPExcel->getActiveSheet()->setTitle('Account Logs');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		$aLog=Base::$db->getAll($sSql);
		if ($aLog) {
			$i=3;
			foreach ($aLog as $aValue) {
				if ($bShowCustomer) $sCsutomerLogin=$aValue['login'];

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$i,
				iconv('windows-1251','utf-8',strip_tags(Language::PrintPrice($aValue['current_account_amount'])).' '.$sCsutomerLogin ));

				if (Auth::$aUser['type_']=='manager') $aValue['account_amount']=str_replace('.',',',$aValue['account_amount']);
				else $aValue['account_amount']=iconv('windows-1251','utf-8',strip_tags(Language::PrintPrice($aValue['account_amount'])));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$i,$aValue['account_amount']);

				if (Auth::$aUser['type_']=='manager') $aValue['amount']=str_replace('.',',',$aValue['amount']);
				else $aValue['amount']=iconv('windows-1251','utf-8',strip_tags(Language::PrintPrice($aValue['amount'])));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $aValue['amount']);

				$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $aValue['custom_id']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $aValue['post_date']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, iconv('windows-1251','utf-8',$aValue['type_']));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, iconv('windows-1251','utf-8',$aValue['pay_type']));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, iconv('windows-1251','utf-8',$aValue['description']));
				$i++;
				if ($i>=500) break;
			}

			$sFileName=uniqid().'.xls';
			$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
			$objWriter->save(SERVER_PATH.'/imgbank/temp_upload/'.$sFileName);
		}
		else $sFileName='EmptyData.xls';

		return $sFileName;
	}
	//-----------------------------------------------------------------------------------------------
	public function Bill()
	{
		if (Base::$aRequest['is_post']) {
			$bCheckManagerLogin=true;
			if (Auth::$aUser['type_']=='manager') {
				if (!Base::$aRequest['data']['login']) $bCheckManagerLogin=false;
				else {
					$aUser=Db::GetRow(Base::GetSql('Customer',array('login'=>Base::$aRequest['data']['login'])));
					if ($aUser) $iIdUser=$aUser['id'];
					else $bCheckManagerLogin=false;
				}
			}

			if (!Base::$aRequest['data']['amount'] || !Base::$aRequest['data']['id_account'] || !$bCheckManagerLogin) {
				Form::ShowError("Please, fill the required fields");
				Base::$aRequest['action']='finance_bill_add';
				Base::$tpl->assign('aData',Base::$aRequest['data']);
			}
			else {
				if (!Base::$aRequest['id']) {
					//[----- INSERT -----------------------------------------------------]
					$aBill=String::FilterRequestData(Base::$aRequest['data']
					,array('code_template','amount','id_cart_package','id_account'));
					if (!$aBill['id_account']) {
						$aActiveAccount=Db::GetRow(Base::GetSql('Account',array('is_active'=>1)));
						$aBill['id_account']=$aActiveAccount['id'];
					}

					if (Auth::$aUser['type_']=='customer') $aBill['id_user']=Auth::$aUser['id'];
					else $aBill['id_user']=$iIdUser;

					Db::AutoExecute('bill',$aBill);
					//[----- END INSERT -------------------------------------------------]
				} else {
					//[----- UPDATE -----------------------------------------------------]
					$sQuery="update bill set
						amount='".Base::$aRequest['data']['amount']."'
						".(Base::$aRequest['data']['id_account'] ? ",id_account='".Base::$aRequest['data']['id_account']."'":"")."
                        		where id='".Base::$aRequest['id']."'";
					Base::$db->Execute($sQuery);
					//[----- END UPDATE -------------------------------------------------]
				}
				Base::Redirect("/?action=finance_bill");
			}
		}

		if (Base::$aRequest['action']=='finance_bill_add' || Base::$aRequest['action']=='finance_bill_edit') {
			if (Base::$aRequest['action']=='finance_bill_edit') {
				$aBill=Db::GetRow(Base::GetSql('Bill',array('id'=>Base::$aRequest['id'])));
				Base::$tpl->assign('aData',$aBill);
			}
			if (Base::$aRequest['data']['amount']) Base::$tpl->assign('aData',Base::$aRequest['data']);

			if (!Base::$aRequest['code_template'] || Base::$aRequest['code_template']=='simple_bill') $sCodeTemplate='simple_bill';
			else $sCodeTemplate='order_bill';

			Base::$tpl->assign('sCodeTemplate',$sCodeTemplate);
			Finance::AssignAccount(Auth::$aUser);

			$sReturnAction = 'finance_bill';
			if (Base::$aRequest['return_action'])
				$sReturnAction = Base::$aRequest['return_action'];
			
			$aData=array(
			'sHeader'=>"method=post",
			'sTitle'=> $sCodeTemplate,
			'sContent'=>Base::$tpl->fetch('finance/form_bill.tpl'),
			'sSubmitButton'=>'Apply',
			'sSubmitAction'=>'finance_bill',
			'sReturnButton'=>'<< Return',
			'sReturnAction'=>$sReturnAction,
			'sError'=>$sError,
			);
			$oForm=new Form($aData);

			Base::$sText.=Language::GetText('finance bill add desctiption');
			Base::$sText.=$oForm->getForm();
			return;
		}

		if (Base::$aRequest['action']=='finance_bill_delete') {
			if (Auth::$aUser['type_']=='customer') $sWhere=Auth::$sWhere; else $sWhere='';
			if (Base::$aRequest['row_check']) {
				Base::$db->Execute("delete from bill where id in (".implode(',',Base::$aRequest['row_check']).")
					".$sWhere);
			}
			else {
				Base::$db->Execute("delete from bill where id='".Base::$aRequest['id']."'
				".$sWhere);
			}
		}
		
		$aData=array(
				'sHeader'=>"method=get",
				'sContent'=>Base::$tpl->fetch('finance/form_bill_search.tpl'),
				'sSubmitButton'=>'Search',
				'sSubmitAction'=>'finance_bill',
				'sReturnButton'=>'Clear',
				'bIsPost'=>0,
				'sError'=>$sError,
		);
		$oForm=new Form($aData);
		
		//Base::$tpl->assign('sForm',$oForm->getForm());
		Base::$sText .= $oForm->getForm();
		
		$oTable=new Table();
		if (Auth::$aUser['type_']=='customer') $sWhere=Auth::$sWhere;
		else $sWhere='';
		
		$sWhere = str_replace('and id_user','and b.id_user', $sWhere);
		
		// --- search ---
		if (Base::$aRequest['search']['login']) $sWhere.=" and u.login like '%".Base::$aRequest['search']['login']."%'";
		if (Base::$aRequest['search']['fio']) $sWhere.=" and uc.name like '%".Base::$aRequest['search']['fio']."%'";
		
		$oTable->sSql=Base::GetSql('Bill',array(
		"where"=>$sWhere,
		));
		$oTable->aColumn=array(
		'id'=>array('sTitle'=>'id'),
		'amount'=>array('sTitle'=>'Amount'),
		'amount'=>array('sTitle'=>'Amount'),
		'template'=>array('sTitle'=>'Template'),
		'post'=>array('sTitle'=>'Date'),
		'action'=>array(),
		);
		$oTable->aOrdered="order by b.post_date desc";
		$oTable->sDataTemplate='finance/row_bill.tpl';
		$oTable->sButtonTemplate='finance/button_bill.tpl';
		$oTable->bCheckVisible=true;
		Base::$sText.=$oTable->getTable("Customer Bills",'customer_bill');
	}
	//-----------------------------------------------------------------------------------------------
	public function BillPrint($iIdBill='')
	{
		if ($iIdBill) Base::$aRequest['id']=$iIdBill;

		$aBill=Base::$db->getRow("select * from bill where id='".Base::$aRequest['id']."' ".$sWhere);
		$aBill['amount']=Currency::BillRound($aBill['amount']);
		$aBill['amount_string']=String::GetUcfirst(Currency::CurrecyConvert($aBill['amount'],
			Base::GetConstant('global:base_currency')));
		$aUser=Db::GetRow(Base::GetSql('Customer',array('id'=>$aBill['id_user'])));

		Base::$tpl->assign('aActiveAccount',Db::GetRow(Base::GetSql('Account',array('id'=>$aBill['id_account']))));

		Base::$tpl->assign('sDate', date ("d.m.Y", strtotime( $aBill['post_date'])));
		Base::$tpl->assign('aBill',$aBill);
		Base::$tpl->assign('aUser',$aUser);

		$sContent=Base::$tpl->fetch('finance/print_'.$aBill['code_template'].'.tpl');

		if (Base::$aRequest['send_file']) {
			header("Content-Type: application/force-download");
			header("Content-Disposition: attachment; filename=\"finance_bill.html\"");
			Base::$tpl->assign('sContent',$sContent);
			Base::$tpl->assign('bHideButtonTable', true);
			die(Base::$tpl->fetch('addon/print_content/index.tpl'));
		}
		PrintContent::Append($sContent);
		Base::Redirect('?action=print_content');
	}
	//-----------------------------------------------------------------------------------------------
	/**
	 * The sigle method for money transactions
	 *
	 * @param  $iIdUser - user which acount is aupdated
	 * @param  $dAmount - amount of money
	 * @param  $sDescription - Transaction description
	 * @param  $iCustomId - ref_id for Section
	 * @param  $sPayType - internal, webmoney, nal, beznal
	 * @param  $sSection - ref table for links
	 * @param  $sData - additional text info
	 * @param  $iIdUserAccountLogType - strict transaction type, reference key to user_aaccount_log_type table
	 * @return Insert_ID into user_account_log table
	 */
	public function Deposit($iIdUser,$dAmount,$sDescription='',$iCustomId='',$sPayType='internal',$sSection='internal',$sData=''
	,$iIdUserAccountLogType='')
	{
		if ($dAmount > 0) $sTransactionType='debet';
		else $sTransactionType='credit';

		Base::$db->StartTrans();

		$aSerialData=array($iIdUser,$dAmount,$sDescription,$iCustomId,$sPayType,$sSection,$sData,$iIdUserAccountLogType);
		if ($dAmount == 0) {
			Finance::TransactionError($aSerialData,$iIdUser,Language::GetMessage('Zero amount'));
		}

		$bResult = Base::$db->Execute("insert user_account_log(id_user,amount,post,type_,description,custom_id,pay_type
			,section,data,id_user_account_log_type)
			values ('$iIdUser','$dAmount',UNIX_TIMESTAMP(),'$sTransactionType','".mysql_real_escape_string($sDescription)."'
			,'$iCustomId','$sPayType'
			,'$sSection','".mysql_real_escape_string($sData)."','".$iIdUserAccountLogType."')");
		if (!$bResult) Finance::TransactionError($aSerialData,$iIdUser,Language::GetMessage('failed insert'));

		$iInsertId=Base::$db->Insert_ID();
		$bResult = Base::$db->Execute("update user_account set amount=(amount + $dAmount) where id_user='$iIdUser'");
		if (!$bResult) Finance::TransactionError($aSerialData,$iIdUser,Language::GetMessage('failed amount update'));

		$bResult = Base::$db->Execute("update user_account_log
			set account_amount='".Finance::AccountAmount($iIdUser)."'
			,debt_amount='".Finance::DebtAmount($iIdUser)."'
			where id='$iInsertId' ");
		if (!$bResult) Finance::TransactionError($aSerialData,$iIdUser,Language::GetMessage('failed account_amount update'));

		//--------------- General Account Log ---------------
		//		$aUser=Base::$db->GetRow(Base::GetSql('User',array('id'=>$iIdUser)));
		//		$aUserAccountLogTypeAssoc=Finance::GetUserAccountLogTypeAssoc();
		//		if (!$aUser['is_test'] && $aUserAccountLogTypeAssoc[$iIdUserAccountLogType]['method']=='inner') {
		//			$bResult = Base::$db->Execute("insert into general_account_log
		//				(id_user_account_log,account_amount,debt_amount,customer_sum_amount,provider_sum_amount)
		//			values ('$iInsertId','".(0+Finance::GetGeneralAccountAmount()-$dAmount)."','".Finance::DebtAmount(0)."'
		//				,'".Finance::GetSumAmount('customer')."','".Finance::GetSumAmount('provider')."')");
		//			if (!$bResult) Finance::TransactionError($aSerialData,$iIdUser,Language::GetMessage('failed general log insert'));
		//		}
		//---------------------------------------------------

		Base::$db->CompleteTrans();

		if ($sTransactionType == 'debet' && !Base::$db->HasFailedTrans()){
			Cron::SendAutopayPackage($iIdUser);
		}
		return $iInsertId;
	}
	//-----------------------------------------------------------------------------------------------
	private function TransactionError($aData, $iIdUser='', $sDescription='')
	{
		Base::$db->FailTrans();
		Log::FinanceAdd($aData, 'finance_transaction', $iIdUser, $sDescription);
	}
	//-----------------------------------------------------------------------------------------------
	public function AccountAmount($iIdUser){
		return Base::$db->getOne("select amount from user_account where id_user='$iIdUser'");
	}
	//-----------------------------------------------------------------------------------------------
	public function DebtAmount($iIdUser){
		if ($iIdUser) $sWhere.=" and ld.id_user='$iIdUser'";
		return Base::$db->getOne("select sum(amount) from log_debt as ld where ld.is_payed='0' ".$sWhere);
	}
	//-----------------------------------------------------------------------------------------------
	public function HaveMoney($dAmount,$iIdUser='',$bFullPayment=false)
	{
		if (!$iIdUser) $iIdUser=Auth::$aUser['id'];
		$aUser=Base::$db->GetRow( Base::GetSql('Customer',array('id'=>$iIdUser)));
		if (!$aUser) return false;

		if (!$bFullPayment) {
			//percent debt
			if (($aUser['amount']* (1 + $aUser['group_debt_percent']/100)) >= $dAmount)
			return true;
		}
		//usual debt
		if (($aUser['amount'] + max($aUser['user_debt'],$aUser['group_debt'])) >= $dAmount) return true;

		return false;
	}
	//-----------------------------------------------------------------------------------------------
	public function PayForAccount()
	{
		Base::$aData['template']['bWidthLimit']=true;
		/**
		 * Creating currency exchange table
		 */
		Base::$tpl->assign('aCurrency',Base::$db->getAll("select * from currency where visible=1 order by num"));
		Base::$sText=str_replace('[$currency]',Base::$tpl->fetch('finance/currency_exchange.tpl'),Base::$sText);
	}
	//-----------------------------------------------------------------------------------------------
	public function GetGeneralAccountAmount(){
		return Base::$db->GetOne("select account_amount from general_account_log order by id desc");
	}
	//-----------------------------------------------------------------------------------------------
	public function GetUserAccountLogTypeAssoc(){
		if (Finance::$aUserAccountLogTypeAssoc) return Finance::$aUserAccountLogTypeAssoc;
		Finance::$aUserAccountLogTypeAssoc=Base::$db->GetAssoc(Base::GetSql('Finance/UserAccountLogTypeAssoc',array(
		'assoc_value'=>'all',
		)));
		return Finance::$aUserAccountLogTypeAssoc;
	}
	//-----------------------------------------------------------------------------------------------
	public function GetSumAmount($sUserType='customer'){
		return Base::$db->GetOne("
			select sum(ua.amount)
			from user_account as ua
			inner join user as u on (u.id=ua.id_user and u.type_='$sUserType')");
	}
	//-----------------------------------------------------------------------------------------------
	public function AssignAccount($aUser)
	{
		if (Auth::$aUser['type_']=='customer') $bIsActive=1;

		$aAccount=Db::GetAssoc('Assoc/Account',array(
		'visible'=>1,
		'is_active'=>$bIsActive,
		));

		if (Auth::$aUser['type_']=='manager') {
			//All other accounts, if no regional visible account
			$aAccount=array(0=>Language::GetMessage('Choose any account'))+Db::GetAssoc('Assoc/Account');
		}
		Base::$tpl->assign('aAccount',$aAccount);
	}
	//-----------------------------------------------------------------------------------------------
	public function AssignSubtotal($sWhere)
	{
		$aDataDebet['where']=$sWhere.' and ual.amount>0';
		$aDataCredit['where']=$sWhere.' and ual.amount<0';
		$aDataDebet['sum']='ual.amount';
		$aDataCredit['sum']='ual.amount';
		Base::$tpl->assign('dTotalAmountDebet',Base::$db->GetOne(Base::GetSql('UserAccountLog',$aDataDebet)));
		Base::$tpl->assign('dTotalAmountCredit',Base::$db->GetOne(Base::GetSql('UserAccountLog',$aDataCredit)));
	}
//-----------------------------------------------------------------------------------------------
	public function GetMyDebt(){
	    if (Base::$aRequest['action']=='finance_user_debt') {
	        
	        Base::$tpl->assign('aNameDistr',array(0=>'')+Db::GetAssoc("select ed.id, ed.name as dist
				from ec_distributor as ed
				inner join ec_distributor_region as edr on edr.id_distributor=ed.id
                where edr.id_region='".Auth::$aUser['id_region']."' 
		order by ed.name"));
        $aData=array(
            'sHeader'=>"method=get",
            'sContent'=>Base::$tpl->fetch('manager/form_distribute.tpl'),
            'sSubmitButton'=>'Search',
            'sSubmitAction'=>'finance_user_debt',
            'sReturnButton'=>'Clear',
            'bIsPost'=>0,
            'sWidth'=>'800px',
        );
        $oForm=new Form($aData);
        
        Base::$sText.=$oForm->getForm();
        // --- search ---
        if (Base::$aRequest['search_dist']) $sWhere.=" and h.id_dist=".Base::$aRequest['search_dist']." ";
        if (Base::$aRequest['search']['is_debt']=='is') $sWhere.=" and ( 1=0 OR ( NOT(h.summa_all=0 AND h.summa_dolg=0) or h.summa_order<>0 OR h.num in ('Начальный долг')))";
        // --------------
	    $oTable=new Table();
	    if(Base::$aRequest['search_dist']){
	    $oTable->sSql="
            select 
            0 as id,
            (select name from user_customer u where u.id_user='".Auth::$aUser['id_user']."') as name,
            ' ' as addr,
            ' ' as dist,
            'Всього' as num,
            sum(summa) as summa,
            null as dt,
            null as dt5,
            sum(summa_pay) as summa_pay,
            null as dt_pay,
            sum(summa_all) as summa_all,
            sum(summa_dolg) as summa_dolg,
            move_id as move_id 
                FROM ec_saleh h
                where h.id_customer='".Auth::$aUser['id_user']."'
                and h.id_region='".Auth::$aUser['id_region']."' 
                    ".$sWhere."
            union all
            SELECT 
            h.id,
            (select name from user_customer u where u.id_user=h.id_customer) as name,
            h.addr as addr,
            (select name from ec_distributor ed where ed.id=h.id_dist) as dist, 
            h.num as num,
            h.summa as summa,
            h.dt as dt,
            h.dt5 as dt5,
            h.summa_pay as summa_pay,
            h.dt_pay as dt_pay,
            h.summa_all as summa_all,
            h.summa_dolg as summa_dolg,
            h.move_id as move_id	
            FROM ec_saleh h  
            where h.id_customer='".Auth::$aUser['id_user']."'
            and h.id_region='".Auth::$aUser['id_region']."' and 1=1
                ".$sWhere;
			}
          else {
            	$oTable->sSql="
            select 
            0 as id,
            (select name from user_customer u where u.id_user='".Auth::$aUser['id_user']."') as name,
            ' ' as addr,
            ' ' as dist,
            'Всього' as num,
            sum(summa) as summa,
            null as dt,
            null as dt5,
            sum(summa_pay) as summa_pay,
            null as dt_pay,
            sum(summa_all) as summa_all,
            sum(summa_dolg) as summa_dolg,
            move_id as move_id 
                FROM ec_saleh h
                where h.id_customer='".Auth::$aUser['id_user']."'
                and h.id_region='".Auth::$aUser['id_region']."' 
                    ".$sWhere."
            union all
            SELECT 
            h.id,
            (select name from user_customer u where u.id_user=h.id_customer) as name,
            h.addr as addr,
            (select name from ec_distributor ed where ed.id=h.id_dist) as dist, 
            h.num as num,
            h.summa as summa,
            h.dt as dt,
            h.dt5 as dt5,
            h.summa_pay as summa_pay,
            h.dt_pay as dt_pay,
            h.summa_all as summa_all,
            h.summa_dolg as summa_dolg,
            h.move_id as move_id	
            FROM ec_saleh h  
            where h.id_customer='".Auth::$aUser['id_user']."'
            and h.id_region='".Auth::$aUser['id_region']."' and 1=1
            and num != 'Начальный долг'
                ".$sWhere."
          
            union all
            SELECT
            h.id,
            (select name from user_customer u where u.id_user=h.id_customer) as name,
            h.addr as addr,
            (select name from ec_distributor ed where ed.id=h.id_dist) as dist, 
            h.num as num,
            h.summa as summa,
            h.dt as dt,
            h.dt5 as dt5,
            h.summa_pay as summa_pay,
            h.dt_pay as dt_pay,
            h.summa_all as summa_all,
            h.summa_dolg as summa_dolg,
            h.move_id as move_id	
            FROM ec_saleh h  
            where h.id_customer='".Auth::$aUser['id_user']."'
            and h.id_region='".Auth::$aUser['id_region']."' 
            and num = 'Начальный долг'
         
            ";
            }
	    
	    $oTable->iRowPerPage=100;
	    $oTable->aColumn=array(
	        'name'=>array('sTitle'=>'user_debt'),
	        'addr'=>array('sTitle'=>'addr'),
	        'dist'=>array('sTitle'=>'dist'),
	        'num'=>array('sTitle'=>'#'),
	        'summa'=>array('sTitle'=>'summa'),
	        'dt'=>array('sTitle'=>'dt'),
	        'dt5'=>array('sTitle'=>'dt5_wait'),
	        'summa_pay'=>array('sTitle'=>'summa_pay'),
	        'dt_pay'=>array('sTitle'=>'dt_pay_fact'),
	        'summa_All'=>array('sTitle'=>'summa_All'),
	        'summa_Dolg'=>array('sTitle'=>'summa_Dolg'),
	        //'comment'=>array('sTitle'=>'comment'),
	        //'id_dist'=>array('sTitle'=>'id_dist'),
	    );
	    
	    $oTable->sDataTemplate='manager/row_debt.tpl';
	    //$oTable->sSubtotalTemplate='manager/subtotal_debt.tpl';
	    $sTable=$oTable->getTable();
	    Base::$sText.=$sTable;
	    
	    }
	    if (Base::$aRequest['action']=='finance_order_ship') {
	        $oTable=new Table();
	        $oTable->sSql="select esd.* from ec_saled as esd
	            where esd.move_id='".Base::$aRequest['id']."' ";
	        $oTable->aCallback=array($this,'CallParseMyOrder');
	        
	        $oTable->aColumn=array(
	            'name'=>array('sTitle'=>'name',),
	           // 'id_product'=>array('sTitle'=>'Code'),
	            'id_product'=>array('sTitle'=>'Articule'),
	            'qty'=>array('sTitle'=>'qty','sWidth'=>'30%'),
	            'unit'=>array('sTitle'=>'unit'),
	            'price'=>array('sTitle'=>'price'),
	            'total'=>array('sTitle'=>'total'),
	        );
	        
	        $oTable->iRowPerPage=200;
	        $oTable->sDataTemplate='manager/row_order_ship.tpl';
	        $oTable->bStepperVisible=false;
	        Base::$sText.=$oTable->getTable();
	        
	        return;
	    }
	    if (Base::$aRequest['action']=='finance_payment_ship') {
	        $oTable=new Table();
	         
	        $oTable->sSql="select ep.dt, ep.summa from ec_payments as ep
	            where ep.move_id='".Base::$aRequest['id']."' ";
	         
	        //$oTable->aOrdered="order by c.post desc";
	        $oTable->aCallback=array($this,'CallParseMyOrderPayment');
	         
	        $oTable->aColumn=array(
	            'dt'=>array('sTitle'=>'dt',),
	            'summa'=>array('sTitle'=>'summa'),
	        );
	         
	        $oTable->iRowPerPage=200;
	        $oTable->sDataTemplate='manager/row_payment_ship.tpl';
	        $oTable->bStepperVisible=false;
	        Base::$sText.=$oTable->getTable();
	         
	        return;
	    }
	
	}
	//-----------------------------------------------------------------------------------------------
	public function CallParseMyOrder(&$aItem){
	    if ($aItem) {
	        foreach($aItem as $key => $value) {
	            $aOrderId[]=$value['id'];
	    
	            $aItem[$key]['name']=$value['name'];
	            $aItem[$key]['id_product']=$value['id_product'];
	            $aItem[$key]['qty']=$value['qty'];
	            $aItem[$key]['unit']=$value['unit'];
	            $aItem[$key]['price']=$value['price'];
	            $aItem[$key]['total']=$value['qty']*Currency::PrintPrice($value['price']);
	        }
	    }
	}
	//-----------------------------------------------------------------------------------------------
	public function CallParseMyOrderPayment(&$aItem){
	    if ($aItem) {
	        foreach($aItem as $key => $value) {
	            $aOrderId[]=$value['id'];
	             
	            $aItem[$key]['dt']=$value['dt'];
	            $aItem[$key]['summa']=$value['summa'];
	        }
	    }
	}

	//*******************
		public function GetMyDiscounts(){
	    if (Base::$aRequest['action']=='finance_user_discounts') {

//for manager
/*
        Base::$tpl->assign('aNameUser',array(0 =>'')+Db::GetAssoc("select u.id, uc.name as name
		from user as u
		inner join user_customer as uc on u.id=uc.id_user
         and uc.id_region ='".Auth::$aUser['id_region']."'
		order by uc.name"));

	    $aGroupsG=Db::GetAssoc("select 0 as id, 'Всі' as name 
			union all
			select id,name from customer_group where visible=1");
		Base::$tpl->assign('aGroupsG',$aGroupsG);

		$aList=Db::GetAssoc("select 0 as id_list, '' as name
			union all
			select id as id_list,name
            from ec_list_of_users_h where id_manager='".Auth::$aUser['id_user']."'");
		Base::$tpl->assign('aList',$aList);
*/		
//for manager

		
	        Base::$tpl->assign('aNameDistr',array(0=>'')+Db::GetAssoc("select ed.id, ed.name as dist
				from ec_distributor as ed
				inner join ec_distributor_region as edr on edr.id_distributor=ed.id
                where edr.id_region='".Auth::$aUser['id_region']."' 
				order by ed.name"));

	        Base::$tpl->assign('aNameBrandGroup',array(0=>'')+Db::GetAssoc("select bgr.id, bgr.name as brand_group
				from ec_brand_group as bgr
				order by bgr.sort"));

	        Base::$tpl->assign('aNameBrand',array(0=>'')+Db::GetAssoc("select b.id, b.name as brand
				from ec_brand as b
				order by b.sort"));

        $aData=array(
            'sHeader'=>"method=get",
            'sContent'=>Base::$tpl->fetch('manager/form_discounts.tpl'),
            'sSubmitButton'=>'Search',
            'sSubmitAction'=>'finance_user_discounts',
            'sReturnButton'=>'Clear',
            'bIsPost'=>0,
            'sWidth'=>'800px',
        );
        $oForm=new Form($aData);
        
        Base::$sText.=$oForm->getForm();
        // --- search ---
        if (Base::$aRequest['search_dist']) $sWhere.=" and ds.id_distributor=".Base::$aRequest['search_dist']." ";
        if (Base::$aRequest['search_brand_group']) $sWhere.=" and ds.id_brand_group=".Base::$aRequest['search_brand_group']." ";
        if (Base::$aRequest['search_brand']) $sWhere.=" and ds.id_brand=".Base::$aRequest['search_brand']." ";
        if (Base::$aRequest['search_group']) $sWhere.=" and uc.id_customer_group=".Base::$aRequest['search_group']." ";
        if (Base::$aRequest['search_list']) $sWhere.=" and ds.id_brand=".Base::$aRequest['search_list']." ";

        // --------------
	    $oTable=new Table();
	    
	    $oTable->sSql="
            SELECT 
            ds.id,
            uc.name as name,
            bgr.name as brand_group,
            b.name as brand,
            r.name as region,
            d.name as distr,
            cg.name as group_name,
            ds.discount as discount
            FROM ec_discounts ds
			inner join ec_brand_group bgr on bgr.id=ds.id_brand_group
			inner join ec_brand b on b.id=ds.id_brand
			inner join ec_region r on r.id=ds.id_region
			left join ec_distributor d on d.id=ds.id_distributor
			inner join user_customer uc on uc.id_user=ds.id_user
            inner join customer_group cg on cg.id=uc.id_customer_group
            where uc.id_user='".Auth::$aUser['id_user']."'
            and ds.id_region='".Auth::$aUser['id_region']."' and 1=1
                ".$sWhere."
            order by id";
	    
	    $oTable->iRowPerPage=100;
	    $oTable->aColumn=array(
	        'name'=>array('sTitle'=>'user_debt'),
	        'brand_group'=>array('sTitle'=>'brand group'),
	        'brand'=>array('sTitle'=>'brand'),
	        'discount'=>array('sTitle'=>'discount'),
	        'distr'=>array('sTitle'=>'distributor'),
//	        'region'=>array('sTitle'=>'region'),
//	        'group_name'=>array('sTitle'=>'group_name'),
	        //'id_dist'=>array('sTitle'=>'id_dist'),
	    );
	    
	    $oTable->sDataTemplate='manager/row_discount.tpl';
	    //$oTable->sSubtotalTemplate='manager/subtotal_debt.tpl';
	    $sTable=$oTable->getTable();
	    Base::$sText.=$sTable;
	    
	    }
	
	}


	
	
}
?>