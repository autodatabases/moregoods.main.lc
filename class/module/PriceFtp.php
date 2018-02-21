<?
/**
 * @author Oleksandr Starovoit
 * @version 0.1
 */

class PriceFtp extends Base {
	var $sPrefix="price_ftp";
	var $sPrefixAction;
	//-----------------------------------------------------------------------------------------------
	public function __construct()
	{
		Auth::NeedAuth('manager');
		
		$a[""]="";
		//Base::$tpl->assign('aPref',$a+Db::GetAssoc("Assoc/Pref", array("all"=>1)));
		//Base::$tpl->assign('aUserProvider',$a+Db::GetAssoc("Assoc/UserProvider"));
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		Base::Message();
		Base::$aData['template']['bWidthLimit']=true;
		$this->sPrefixAction=$this->sPrefix;
		Base::$tpl->assign('sBaseAction',$this->sPrefixAction);
		Base::$aTopPageTemplate=array('panel/tab_price.tpl'=>$this->sPrefix);

		if (Base::$aRequest['is_post']){
			if (!Base::$aRequest['data']['name']
			|| !Base::$aRequest['data']['code']
			) {
				Base::Message(array('MF_ERROR'=>'Required fields name, code'));
				Base::$aRequest['action']=$this->sPrefix.'_add';
				Base::$tpl->assign('aData',Base::$aRequest['data']);
			} else {
				$aData=String::FilterRequestData(Base::$aRequest['data']);

				if (Base::$aRequest['id']) {
					Db::AutoExecute("price_ftp",$aData,"UPDATE","id=".Base::$aRequest['id']);
					$sMessage="&aMessage[MT_NOTICE]=Ftp updated";
				} else {
					Db::AutoExecute("price_ftp",$aData);
					$sMessage="&aMessage[MT_NOTICE]=Ftp added";
				}

				Form::RedirectAuto($sMessage);
			}
		}

		if (Base::$aRequest['action']==$this->sPrefix.'_add'||Base::$aRequest['action']==$this->sPrefix.'_edit') {

			$a[""]="";
			Base::$tpl->assign('aPref',$a+Db::GetAssoc("Assoc/Pref"));

			if (Base::$aRequest['action']==$this->sPrefix.'_edit') {
				$aData=Db::GetRow(Base::GetSql("Price/Ftp",array("id"=>Base::$aRequest['id'])));
				Base::$tpl->assign('aData',$aData);
			} else {
				$aData['coef']=1;
				Base::$tpl->assign('aData',$aData);
			}

			$oForm=new Form();
			$oForm->sHeader="method=post";
			$oForm->sTitle="Edit";
			$oForm->sContent=Base::$tpl->fetch($this->sPrefix.'/form_'.$this->sPrefix.'_add.tpl');
			$oForm->sSubmitButton='Apply';
			$oForm->sSubmitAction=$this->sPrefixAction;
			$oForm->sReturnButton='<< Return';
			$oForm->bAutoReturn=true;
			$oForm->bIsPost=true;
			//$oForm->sWidth="470px";

			Base::$sText.=$oForm->getForm();

			return;
		}

		if (Base::$aRequest['action']==$this->sPrefix.'_delete' && Base::$aRequest['id']) {
			//$aData['visible']=0;
			//Db::AutoExecute("price_grp",$aData,"UPDATE","id=".Base::$aRequest['id']);
			Db::Execute("delete from price_ftp where id=".Base::$aRequest['id']);
			$sMessage="&aMessage[MT_NOTICE]=Ftp deleted";
			Form::RedirectAuto($sMessage);
		}
		
		$oForm= new Form();
		//$oForm->sTitle="Catalog Cross";
		$oForm->sContent=Base::$tpl->fetch($this->sPrefix."/form_price_ftp.tpl");
		$oForm->sSubmitButton="Search";
		$oForm->sSubmitAction=$this->sPrefixAction;
		$oForm->sReturnButton="Clear";
		$oForm->sReturnAction=$this->sPrefixAction;
		//$oForm->sReturn=Base::RemoveMessageFromUrl($_SERVER ['QUERY_STRING']);
		//$oForm->bAutoReturn=true;
		//$oForm->sAdditionalButtonTemplate=$this->sPrefix."/button_price_request_view.tpl";
		$oForm->bIsPost=0;
		$oForm->sWidth="350px";
		//Base::$sText.=$oForm->getForm();		

		$oTable=new Table();
		$oTable->sSql=Base::GetSql("Price/Ftp", Base::$aRequest['search']);
		$oTable->iRowPerPage=50;
		//$oTable->aOrdered="order by post desc";
		$oTable->aColumn=array(
		'name'=>array('sTitle'=>'name','sWidth'=>'20%'),
		'code'=>array('sTitle'=>'Code','sWidth'=>'20%'),
		'name_folder'=>array('sTitle'=>'Name Folder','sWidth'=>'20%'),
		'name_file'=>array('sTitle'=>'Name File','sWidth'=>'20%'),
		'action'=>array(),
		);
		$oTable->sDataTemplate=$this->sPrefix.'/row_'.$this->sPrefix.'.tpl';
		//$oTable->aCallback=array($this,'CallParsePrice');

		Base::$sText.=$oTable->getTable("Price Ftp");
		Base::$sText.=Base::$tpl->fetch($this->sPrefix.'/button_'.$this->sPrefix.'.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	/* now 2013-09-16 from queue import
	public function Import()
	{
		$this->sPrefixAction=$this->sPrefix."_import";
		Base::$aTopPageTemplate=array('panel/tab_price.tpl'=>$this->sPrefix);
		Base::Message();
		
		if (Base::$aRequest['is_post'] ) {
			if (is_uploaded_file($_FILES['import_file']['tmp_name'])) {
				if (Base::$aRequest['data']['id_user_provider'] && Base::$aRequest['data']['pref']) {

					$oExcel= new Excel();
					$oExcel->ReadExcel5($_FILES['import_file']['tmp_name'],true);
					$oExcel->SetActiveSheetIndex();
					$oExcel->GetActiveSheet();

					$aResult=$oExcel->GetSpreadsheetData();
					if ($aResult) foreach ($aResult as $sKey=>$aValue) {
						if ($sKey>1)
						{
							$aData['id_user_provider']=Base::$aRequest['data']['id_user_provider'];
							$aData['pref']=Base::$aRequest['data']['pref'];
							$aData['code']=trim($aValue[1]);
							$aData['coef']=trim($aValue[2]);

							if ($aData['pref'] && $aData['code']){
								Db::Execute("insert into price_grp (id_user_provider, pref, code, coef)
								 values (".$aData['id_user_provider'].",'".$aData['pref']."','".$aData['code']."','".$aData['coef']."')
								 on duplicate key update coef=values(coef)");
							}
						}
					}
					$sMessage="&aMessage[MI_NOTICE]=Upload and processing sucsessfuly";
					Form::RedirectAuto($sMessage);
					
				} else Base::Message(array('MI_ERROR'=>'Required fields provider, pref'));
			} else Base::Message(array('MI_ERROR'=>'Possible file upload attack'));
		}

		$aData=array(
		'sHeader'=>"method=post enctype='multipart/form-data'",
		//'sTitle'=>"Import cross",
		'sContent'=>Base::$tpl->fetch($this->sPrefix.'/form_price_grp_import.tpl'),
		'sSubmitButton'=>'Load',
		'sSubmitAction'=>$this->sPrefixAction,
		'sReturnButton'=>'<< Return',
		'bAutoReturn'=>true,
		'sWidth'=>"400px",
		);
		$oForm=new Form($aData);
		Base::$sText.=$oForm->getForm();
	}
	*/
}