<?
/**
 * @author Vladimir Fedorov
 */

class OwnAuto extends Base
{
	var $sPrefix="own_auto";
	var $aTypeDrive = array();
	var $aTypeFuel = array();
	var $aTypeTransmission = array();
	var $aTypeBody = array();
	var $aTypeWheel = array();
	var $aVinMonth = array();
	//-----------------------------------------------------------------------------------------------
	public function __construct()
	{
		Base::$aData['template']['bWidthLimit']=false;
		
		$this->aTypeBody 			= VinRequest::Get_aTypeBody();
		$this->aTypeDrive 			= $this->Get_aTypeDrive();
		$this->aTypeFuel 			= $this->Get_aTypeFuel();
		$this->aTypeTransmission 	= VinRequest::Get_aTypeKpp();
		$this->aTypeWheel 			= VinRequest::Get_aTypeWheel();
		$this->aVinMonth 			= VinRequest::Get_Months();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		if (Auth::$aUser['id'] == 0)
			Base::Redirect("/");
			
		Base::Message();
		if (Base::$aRequest['is_post']) {
			$aData=String::FilterRequestData(Base::$aRequest['data']);
			if (Base::$aRequest['Year'])
				$aData['year'] = Base::$aRequest['Year'];
			
			// errors
			$iErrors = 0;
			if (Auth::$aUser['id_user'] == 0) {
				Base::Message(array('MF_ERROR'=> Language::GetMessage('This method allow only registered users')));
				$iErrors = 1;
			} elseif ($aData['id_make'] == 0 || $aData['id_model'] == 0 ||
				$aData['vin'] == "" || $aData['volume'] == "") {
				
				Base::Message(array('MF_ERROR'=> Language::GetMessage('Please fill all required fields')));
				$iErrors = 1;
			}
			elseif (mb_strlen(trim($aData['vin']),'UTF-8') != Base::GetConstant('vin_request:length',17)) {
				Base::Message(array('MF_ERROR'=> Language::GetMessage("vin_have_no_17_symbols")));
				$iErrors = 1;
			}
			
			if ($iErrors == 0) {	
				// add all id => data
				$aData['body'] = $this->aTypeBody[$aData['body']];
				//$aData['type_drive'] = $this->aTypeDrive[$aData['id_type_drive']];
				//$aData['type_fuel'] = $this->aTypeFuel[$aData['id_type_fuel']];
				$aData['kpp'] = $this->aTypeTransmission[$aData['kpp']];
				$aData['wheel'] = $this->aTypeWheel[$aData['wheel']];
				
				$aData['id_user'] = Auth::$aUser['id_user'];
				if (Base::$aRequest['id']) {
					$aData['modified'] = time(); 
					Db::AutoExecute("user_auto",$aData,"UPDATE","id=".Base::$aRequest['id']);
					Base::Message(array('MF_NOTICE' => Language::getMessage('Your auto updated')));
				} else {
					$aData['post'] = $aData['modified'] = time();
					Db::AutoExecute("user_auto",$aData);
					Base::Message(array('MF_NOTICE' => Language::getMessage('Your auto added')));
				}
			}
			else {
				Base::$aRequest['action']=$this->sPrefix.'_add';
				Base::$aRequest['data']['date'] = $aData['year'] .'-01-01';
				Base::$tpl->assign('aData', Base::$aRequest['data']);
				$this->GetInfoAuto($aData);
			}
		}
		
		if (Base::$aRequest['action']==$this->sPrefix.'_add'|| Base::$aRequest['action']==$this->sPrefix.'_edit') {
			
			if (Base::$aRequest['log_id']) {
				$aLog=Db::GetRow("Select asl.* from auto_search_log asl
						where asl.id=".Base::$aRequest['log_id']." and asl.id_user=".Auth::$aUser['id']);
				if($aLog) {
				    $aModelDetail=TecdocDb::GetModelDetail(array(
				        'id_model_detail'=>$aLog['id_model_detail']
				    ));
				    if($aModelDetail) {
				        $aLog['cat_id']=$aModelDetail['id_make'];
				        $aLog['id_model']=$aModelDetail['mod_id'];
				    }
				}
				
				if ($aLog) {
					$aData['id_make'] = $aLog['cat_id'];
					$aData['id_model'] = $aLog['id_model'];
					Base::$tpl->assign('aData', $aData);
					$this->GetInfoAuto($aData);
				}
			}
				
			Base::$tpl->assign('aMake', array(""=>Language::getMessage('choose make'))+Db::GetAssoc("Assoc/Cat",array(
			'is_brand'=>1,
			//'is_main'=>1,
			)));
			
			// edit
			if (Base::$aRequest['id']) {
				$aData = Db::GetRow("select * from user_auto where id=".Base::$aRequest['id']);
				if (!$aData['id'] || $aData['id_user'] != Auth::$aUser['id_user'])
					$aData = array();
				
				$aData['body'] = array_search($aData['body'],$this->aTypeBody);
				$aData['id_type_drive'] = array_search($aData['type_drive'],$this->aTypeDrive);
				$aData['id_type_fuel'] = array_search($aData['type_fuel'],$this->aTypeFuel);
				$aData['kpp'] = array_search($aData['kpp'],$this->aTypeTransmission);
				$aData['wheel'] = array_search($aData['wheel'],$this->aTypeWheel);
				$aData['date'] = $aData['year'] .'-01-01';
				Base::$tpl->assign('aData', $aData);
				$this->GetInfoAuto($aData);
			}
			// not move to GetFormAddAuto - becouse ajax used not work in popup - create order
			Base::$aMessageJavascript = array(
			"MakeAuto_select"=> Language::GetMessage("Choose model"),
			"DetailAuto_select"=> Language::GetMessage("Choose year"),
			);
			
			Base::$sText.=$this->GetFormAddAuto($this);
			
			return;
		}
		
		$oTable=new Table();
		$oTable->iRowPerPage=500;
		$oTable->sSql=Base::GetSql('UserAuto',array());
		$oTable->aOrdered="order by ua.id desc";
		$oTable->aColumn=array(
			'id_make'			=> array('sTitle'=>Language::GetMessage('Make auto')),
			'id_model'			=> array('sTitle'=>Language::GetMessage('Model auto')),
			'year'				=> array('sTitle'=>Language::GetMessage('Year')),
			'action'			=> array('sTitle'=>'&nbsp;','sWidth'=>'5%'),
		);
		$oTable->sDataTemplate=$this->sPrefix . '/row_user_auto.tpl';
		$oTable->sButtonTemplate=$this->sPrefix . '/button_user_auto.tpl';
		$oTable->aCallback=array($this,'CallParseUserAuto');

		Base::$sText.=$oTable->getTable("User auto");
	}
	
	//-----------------------------------------------------------------------------------------------
	public function CallParseUserAuto(&$aItem)
	{
		if (is_array($aItem) && count($aItem) > 0) {
			foreach ($aItem as $ikey => $aValue) {

				$aItem[$ikey]['tecdoc_url'] = Content::CreateSeoUrl('catalog_detail_model_view',array(
						'data[id_make]'=>$aItem[$ikey]['id_make'],
						'data[id_model]'=>$aItem[$ikey]['id_model'],
						'model_translit'=>Content::Translit($aValue['name_model'])
				));
				$aItem[$ikey]['month'] = $this->aVinMonth[$aValue['month']];
				// change values
				$aItem[$ikey]['id_make'] = Db::GetOne("select title from cat where id='".$aValue['id_make']."'");
				$aItem[$ikey]['id_model'] = Db::GetOne("select name from cat_model where tof_mod_id='".$aValue['id_model']."'");
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function CallParseLogUserAuto(&$aItem)
	{
		if($aItem) {
		    foreach ($aItem as $ikey => $aValue) {
		        $aModelDetail=TecdocDb::GetModelDetail(array(
		            'id_model_detail'=>$aValue['id_model_detail']
		        ));
		        
		        $aItem[$ikey]['id_model']=$aModelDetail['mod_id'];
		        $aItem[$ikey]['id_make']=$aModelDetail['id_make'];
		        $aItem[$ikey]['name']=$aModelDetail['mane'];
		    }
		}
		
		if (is_array($aItem) && count($aItem) > 0) {
			$aMass = array();
			if (Auth::$aUser['id'])
				$aMass = Db::GetAssoc("Select ua.id_model, ua.id from user_auto ua
					where id_user = ".Auth::$aUser['id']);
				
			foreach ($aItem as $ikey => $aValue) {
				if ($aMass[$aValue['id_model']])
					$aItem[$ikey]['ua_id'] = $aMass[$aValue['id_model']];
				
				$aItem[$ikey]['tecdoc_url'] = Content::CreateSeoUrl('catalog_assemblage_view',array(
						'data[id_make]'=>$aItem[$ikey]['id_make'],
						'data[id_model]'=>$aItem[$ikey]['id_model'],
						'data[id_model_detail]'=>$aItem[$ikey]['id_model_detail'],
						'model_translit'=>Content::Translit($aValue['name'])
				));
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	function GetJson()
	{
		if (Base::$aRequest['id_make'] && !Base::$aRequest['id_model']) {
// 			$aData=Db::GetAll(Base::GetSql("OptiCatalog/Model",array("id_make"=>Base::$aRequest['id_make']))
// 					." order by name ");
			$aData=TecdocDb::GetModels(array("id_make"=>Base::$aRequest['id_make']));
	
			$aRet=array();
			if ($aData) foreach ($aData as $sKey => $aValue) {
				$aRet[$sKey]['id']=$aValue['id'];
				$aRet[$sKey]['name']=$aValue['name'];
			}
			
			echo json_encode($aRet);
		}/* else {
			$aData = array('id_make' => Base::$aRequest['id_make'], 'id_model' => Base::$aRequest['id_model']); 
			//opti
			$aModelDetailAll=Db::GetAll(Base::GetSql("OptiCatalog/ModelDetail",$aData));
			foreach ($aModelDetailAll as $sKey => $aValue) {
				$aModelDetail[$aValue['id_model_detail']]=$aValue['name']." ".$aValue['year_start']
				."-".$aValue['year_end']; 
			}
	
			$aRet=array();
			if ($aData) foreach ($aModelDetail as $sKey => $aValue) {
				$aRet[]=array('id' => $sKey, 'name' => $aValue);
			}
	
			echo json_encode($aRet);
		}
		*/
		die();
	}
	//-----------------------------------------------------------------------------------------------
	public function Del()
	{
		if (!Base::$aRequest['id']) {
			$sMessage = '&aMessage[MT_ERROR]=' . Language::GetMessage('Not found record with own auto to del.');
		}
		else {
			$aRow = Db::GetRow("select * from user_auto where id=".Base::$aRequest['id']);
			if (!$aRow['id'] || $aRow['id_user'] != Auth::$aUser['id_user']) {
				$sMessage = '&aMessage[MT_ERROR]='.Language::GetMessage('Not found or access denied record in user auto.');
			}
			else {
				Db::Execute("delete from user_auto where id=".Base::$aRequest['id']);
				$sMessage = '&aMessage[MT_NOTICE]='.Language::GetMessage('Own auto record delete successfully.');
			}
		}
		Base::Redirect('/?action='.$this->sPrefix.$sMessage);
	}
	
	//-----------------------------------------------------------------------------------------------
	public function GetInfoAuto($aData) {
		if ($aData['id_make'] != 0) {
// 			$aModelAll=Db::GetAll(Base::GetSql("OptiCatalog/Model",array("id_make"=>$aData['id_make']))
// 					." order by name ");
			$aModelAll=TecdocDb::GetModels(array("id_make"=>$aData['id_make']));
			$aModel=array();
			if ($aModelAll) foreach ($aModelAll as $sKey => $aValue) {
				$aModel[$aValue['id']] = $aValue['name'];
			}
			Base::$tpl->assign('aModel',$aModel);
		}
		/*
		if ($aData['id_make'] != 0 && $aData['id_model'] != 0) {
			$aRec = array('id_model' => $aData['id_model'], 'id_make' => $aData['id_make']);
			$aModelDetailAll=Db::GetAll(Base::GetSql("OptiCatalog/ModelDetail",$aRec));
			foreach ($aModelDetailAll as $sKey => $aValue) {
				$aModelDetail[$aValue['id_model_detail']]=$aValue['name']." ".$aValue['year_start']
				."-".$aValue['year_end'];
			}
			Base::$tpl->assign('aModelDetail',$aModelDetail);
		}*/
	}
	//-----------------------------------------------------------------------------------------------
	// for use in other module
	public function Get_aTypeFuel() {
		// use count from 1! in smarty tlp check 0 and not set equal
		return array(
			1 => Language::GetMessage('Petrol/Ethanol'),
			2 => Language::GetMessage('Petrol/Natural Gas (CNG)'),
			3 => Language::GetMessage('Petrol/Petroleum Gas (LPG)'),
			4 => Language::GetMessage('бензин'),
			5 => Language::GetMessage('био-горючее'),
			6 => Language::GetMessage('водород'),
			7 => Language::GetMessage('газ'),
			8 => Language::GetMessage('дизель'),
			9 => Language::GetMessage('природный газ'),
			10 => Language::GetMessage('сжиженный газ'),
			11 => Language::GetMessage('смесь'),
			12 => Language::GetMessage('эластичное топливо'),
			13 => Language::GetMessage('электрическ. - бензин'),
			14 => Language::GetMessage('электрическ. - дизельное топливо'),
			15 => Language::GetMessage('электричество'),
		);
	}
	//-----------------------------------------------------------------------------------------------
	// for use in other module
	public function Get_aTypeDrive() {
		// use count from 1! in smarty tlp check 0 and not set equal
		return array(
			1 => Language::GetMessage('Привод на все колеса'),
			2 => Language::GetMessage('Привод на все колеса постоянный'),
			3 => Language::GetMessage('Привод на задние колеса'),
			4 => Language::GetMessage('Привод на передние колеса'),
		);
	}
	//-----------------------------------------------------------------------------------------------
	// for use in other module
	public function GetFormAddAuto($oObject, $sTitle = "Edit", $iSubmitNotPopUp = 1) {
		Base::$tpl->assign('aTypeBody',$oObject->aTypeBody);
		Base::$tpl->assign('aTypeTransmission',$oObject->aTypeTransmission);
		Base::$tpl->assign('aTypeWheel',$oObject->aTypeWheel);
		/*
		 Base::$tpl->assign('aTypeBody',array(""=>Language::getMessage('choose type body'))+$this->aTypeBody);
		Base::$tpl->assign('aTypeDrive',array(""=>Language::getMessage('choose type drive'))+$this->aTypeDrive);
		Base::$tpl->assign('aTypeFuel',array(""=>Language::getMessage('choose type fuel'))+$this->aTypeFuel);
		Base::$tpl->assign('aTypeTransmission',array(""=>Language::getMessage('choose type transmission'))+$this->aTypeTransmission);
		Base::$tpl->assign('aTypeWheel',array(""=>Language::getMessage('choose type wheel'))+$this->aTypeWheel);
		*/
		Base::$tpl->assign('aVinMonth',$oObject->aVinMonth);
			
		$oForm=new Form();
		$oForm->sHeader="method=post";
		$oForm->sTitle= $sTitle;
		$oForm->sContent=Base::$tpl->fetch($oObject->sPrefix.'/form_'.$oObject->sPrefix.'_add.tpl');
		if ($iSubmitNotPopUp) {
			$oForm->sSubmitButton='Apply';
			$oForm->sSubmitAction=$oObject->sPrefixAction;
			$oForm->sReturnButton = '<< Return';
		}
		else{
			$oForm->sAdditionalButtonTemplate = $oObject->sPrefix.'/popup_'.$oObject->sPrefix.'_submit.tpl';
		}
		$oForm->bIsPost=true;
		$oForm->sWidth="600px";
		$oForm->sReturnAction=$oObject->sPrefix;
			
		return $oForm->getForm();
	}
	//-----------------------------------------------------------------------------------------------
	function AddJson()
	{
		if (Auth::$aUser['id'] != 0 && Base::$aRequest['id_make'] && Base::$aRequest['id_model'] && Base::$aRequest['vin'] 
			&& Base::$aRequest['volume'] && Base::$aRequest['month'] && Base::$aRequest['year']) {
			
			$aData = array(
				'vin' => Base::$aRequest['vin'],
				'id_user' => Auth::$aUser['id'],
				'id_make' => Base::$aRequest['id_make'],
				'id_model' => Base::$aRequest['id_model'],
				'volume' => Base::$aRequest['volume'],
				'month' => Base::$aRequest['month'],
				'year' => Base::$aRequest['year'],
				'body' => ((Base::$aRequest['body'] && $this->aTypeBody[Base::$aRequest['body']]) ? $this->aTypeBody[Base::$aRequest['body']] : ''),
				'engine' => ((Base::$aRequest['engine']) ? Base::$aRequest['engine'] : ''),
				'country_producer' => ((Base::$aRequest['country_producer']) ? Base::$aRequest['country_producer'] : ''),
				'kpp' => ((Base::$aRequest['kpp'] && $this->aTypeTransmission[Base::$aRequest['kpp']]) ? $this->aTypeTransmission[Base::$aRequest['kpp']] : ''),
				'wheel' => 	( (Base::$aRequest['wheel'] && $this->aTypeWheel[Base::$aRequest['wheel']]) ? $this->aTypeWheel[Base::$aRequest['wheel']] : ''),
				'is_abs' => (Base::$aRequest['is_abs'] ? Base::$aRequest['is_abs'] : 0),
				'is_hyd_weel' => (Base::$aRequest['is_hyd_weel'] ? Base::$aRequest['is_hyd_weel'] : 0),
				'is_conditioner' => (Base::$aRequest['is_conditioner'] ? Base::$aRequest['is_conditioner'] : 0),
				'customer_comment' => (Base::$aRequest['customer_comment'] ? Base::$aRequest['customer_comment'] : ''),
			);
			
			$aData['post'] = $aData['modified'] = time();
			
			$aData=String::FilterRequestData($aData);
			Db::AutoExecute("user_auto",$aData);
			$iId = Db::InsertId();
				
			$sStringAuto = Db::GetOne("select title from cat where id='".Base::$aRequest['id_make']."'");
			$sStringAuto .= ', '.Db::GetOne("select name from cat_model where tof_mod_id='".Base::$aRequest['id_model']."'");
			$sStringAuto .= ', '.Base::$aRequest['month']." ".Base::$aRequest['year'];
			$aRet = array(
				'status' => 'ok',
				'string_auto' => $sStringAuto,
				'id' => $iId,
			);
				
			echo json_encode($aRet);
			exit; //die();
		}
		echo json_encode(array('status' => 'error'));
		exit;//die();
	}
	
	//-----------------------------------------------------------------------------------------------
	// for use in other module
	public function GetAutoInfoTip($iOrderId) {
		// get auto info
		$iAutoId = Db::GetOne("Select id_own_auto from cart_package where id=".$iOrderId);
		$aOwnAuto = Db::GetRow("Select * from user_auto where id = ".$iAutoId);
		if ($aOwnAuto['id']) {
			$aOwnAuto['marka'] = Db::GetOne("select title from cat where id='".$aOwnAuto['id_make']."'");
			$aOwnAuto['model'] = Db::GetOne("select name from cat_model where tof_mod_id='".$aOwnAuto['id_model']."'");
			if ($aOwnAuto['is_abs'])
				$aOwnAuto['additional'] .= Language::GetMessage('ABS').', ';
			if ($aOwnAuto['is_conditioner'])
				$aOwnAuto['additional'] .= Language::GetMessage('is_conditioner').', ';
			if ($aOwnAuto['is_hyd_weel'])
				$aOwnAuto['additional'] .= Language::GetMessage('is_hyd_weel');
		
			Base::$tpl->assign('aData',$aOwnAuto);
		}
		$aData=array(
				'sTitle'=>Language::GetMessage("user_auto"),
				'sContent'=>Base::$tpl->fetch('own_auto/form_own_auto.tpl'),
				'bShowBottomForm'=>false,
				'sWidth' => 500,
				'sError'=>'',
		);
		Base::$tpl->clear_assign('sHint');
		$oForm=new Form($aData);
		return $oForm->getForm();
	}
	//-----------------------------------------------------------------------------------------------
	public function GetListOwnAuto() {
		if (!Auth::$aUser['id'] || Auth::$aUser['id'] == 0)
			return array();
		return Db::GetAssoc("Select ua.id, concat(c.title,' ',cm.name,' vin:',ua.vin) from user_auto ua
				inner join cat c on c.id = ua.id_make
				inner join cat_model cm ON cm.tof_mod_id = ua.id_model
				where id_user = ".Auth::$aUser['id']);
	}
	//-----------------------------------------------------------------------------------------------
	public function GetInfoById($iId = 0) {
		if ($iId == 0) 
			return array();
			
		$aInfo=Db::GetRow("Select ua.*, /*coalesce(cm.name,m.Name)*/ cm.name name_model
					from user_auto ua  
					left join cat_model as cm on ua.id_model=cm.tof_mod_id
					/*left join ".DB_OCAT."cat_alt_models m on m.ID_src=cm.tof_mod_id*/
					where ua.id=".$iId);
		if (!$aInfo)
			return array();
		
		return $aInfo;
	}
	//-----------------------------------------------------------------------------------------------
	public function SearchLog()
	{
		Base::$oContent->AddCrumb(Language::GetMessage('auto_search_log'),'');
	
		$oTable=new Table();
		$oTable->iRowPerPage=20;
		$oTable->iStartStep=1;

		$oTable->sSql="select asl.* from auto_search_log as asl ";

		if (Auth::$aUser['id'])
		{
			$oTable->sSql.="where asl.id_user='".Auth::$aUser['id']."'";
		}
		else
		{
			$oTable->sSql.="where asl.id_session='".session_id()."'";
		}
		
		$oTable->aOrdered="order by asl.post_date desc";
		$oTable->aColumn=array(
				'auto_name'=>array('sTitle'=>'Name auto'),
				'post'=>array('sTitle'=>'Date'),
				'action'=>array('sTitle'=>''),
		);
		$oTable->aCallback=array($this,'CallParseLogUserAuto');
		
		$oTable->sDataTemplate='own_auto/row_auto_search_log.tpl';
	
		Base::$sText.=$oTable->getTable("Auto Search Log",'Auto Search Log');
	}
	//-----------------------------------------------------------------------------------------------
	public function AddSearchAuto()
	{
		if (!Base::GetConstant('auto_search_log:is_available',1)) return;
		if (!Base::$aRequest['data']['id_model_detail']) return;
		// check exist
		if (!Auth::$aUser['id'])
		{
			$sWhere = " id_session='".session_id()."'";
		}
		else 
			$sWhere = " id_user='".Auth::$aUser['id']."'";
		
		$iExist = Db::GetOne("Select count(*) from auto_search_log where id_model_detail = ".Base::$aRequest['data']['id_model_detail']." and ".$sWhere);
		if ($iExist)
			return;
		
		$aLog=array(
				'id_user'=>Auth::$aUser['id']
				,'id_model_detail'=>Base::$aRequest['data']['id_model_detail']
		);
		if (!Auth::$aUser['id'])
		{
			$aLog['id_session']=session_id();
		}
		//$aAutoInfo=Db::GetRow(Base::GetSql("OptiCatalog/ModelInfo",array("id_model_detail"=>Base::$aRequest['data']['id_model_detail'])));
		$aAutoInfo=TecdocDb::GetModelInfo(array("id_model_detail"=>Base::$aRequest['data']['id_model_detail']));
		if ($aAutoInfo['type_auto']) 
			$aLog['auto_name'] = $aAutoInfo['type_auto']; 
			
		Db::AutoExecute('auto_search_log', $aLog, 'INSERT');
	
	}
	//-----------------------------------------------------------------------------------------------
	public function DelFromAutoLog()
	{
		if (!Auth::$aUser['id'])
			Base::Redirect('/pages/own_auto_search_log/');
					
		Db::Execute('Delete from auto_search_log where id_user='.Auth::$aUser['id'].' and id='.Base::$aRequest['id']);
		Base::Redirect('/pages/own_auto_search_log/?aMessage[MT_NOTICE]=auto delete from log');
	}
}
?>