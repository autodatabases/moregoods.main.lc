<?
/**
 * @author Oleksandr Starovoit
 * @version 0.1
 */

class PriceProfile extends Base {
	var $sPrefix="price_profile";
	//-----------------------------------------------------------------------------------------------
	public function __construct()
	{
		Auth::NeedAuth('manager');
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		Base::$sText.=Base::$tpl->fetch($this->sPrefix.'/popup.tpl');
		Base::Message();
		$this->sPrefixAction=$this->sPrefix;
		Base::$aTopPageTemplate=array('panel/tab_price.tpl'=>$this->sPrefixAction);

		$aUserAccount=Base::$db->getRow("select * from user_account where 1=1 ".Auth::$sWhere);
		Base::$tpl->assign('aUserAccount',$aUserAccount);
		Base::$tpl->assign('sUrlItemNew',"?action=".$this->sPrefix."_item_edit");

		if (Base::$aRequest['is_post']){
			if (0) {
				Base::Message(array('MF_ERROR'=>'Required fields city, address'));
				Base::$aRequest['action']=$this->sPrefix.'_add';
				Base::$tpl->assign('aData',Base::$aRequest['data']);
			} else {
				$aData=String::FilterRequestData(Base::$aRequest['data']);

				if (Base::$aRequest['id']) {
					Db::AutoExecute("price_profile",$aData,"UPDATE","id=".Base::$aRequest['id']);
					$sMessage="&aMessage[MT_NOTICE]=Price profile updated";
				} else {
					Db::AutoExecute("price_profile",$aData);
					$sMessage="&aMessage[MT_NOTICE]=Price profile added";
				}

				Form::RedirectAuto($sMessage);
			}
		}

		if (Base::$aRequest['action']==$this->sPrefix.'_add'||Base::$aRequest['action']==$this->sPrefix.'_edit') {

			$a[""]="";
			//Base::$tpl->assign('aType_',array("excel"=>"excel","excel95"=>"excel95","excel07"=>"excel07","csv"=>"csv"));
			//Base::$tpl->assign('aType_',array("excel"=>"excel","csv"=>"csv","excel07"=>"excel07"));
			Base::$tpl->assign('aDelimiter',$a+array(";"=>";","tab"=>"tab",","=>",","|"=>"|"));
			Base::$tpl->assign('aProvider',$a+Base::$db->getAssoc("select id_user as id, name from user_provider "));
			Base::$tpl->assign('aPref',$a+Base::$db->getAssoc("select pref as id, title from cat order by title "));
			Base::$tpl->assign('aCodeCurrency',Base::$db->getAssoc("select code as id, concat(code,' ',name) as name from currency "));

			if (Base::$aRequest['action']==$this->sPrefix.'_edit') {
				$aData=Db::GetRow(Base::GetSql("Price/Profile",array("id"=>Base::$aRequest['id'])));
				Base::$tpl->assign('aData',$aData);
			} else {
				$aData['coef']=1;
				$aData['list_count']=1;
				$aData['num']=1+Db::GetOne("select max(num) from price_profile");
				Base::$tpl->assign('aData',$aData);
			}

			$oForm=new Form();
			$oForm->sHeader="method=post";
			$oForm->sTitle="Edit profile";
			$oForm->sContent=Base::$tpl->fetch($this->sPrefix.'/form_'.$this->sPrefix.'_add.tpl');
			$oForm->sSubmitButton='Apply';
			$oForm->sSubmitAction=$this->sPrefixAction;
			$oForm->sReturnButton='<< Return';
			$oForm->bAutoReturn=true;
			$oForm->bIsPost=true;
			$oForm->sWidth="600px";

			Base::$sText.=$oForm->getForm();

			return;
		}

		if (Base::$aRequest['action']==$this->sPrefix.'_delete' && Base::$aRequest['id']) {
			//$aData['visible']=0;
			//Db::AutoExecute("price_profile",$aData,"UPDATE","id=".Base::$aRequest['id']);
			Db::Execute("delete from price_profile where id=".Base::$aRequest['id']);
			$sMessage="&aMessage[MT_NOTICE]=Price profile deleted";
			Form::RedirectAuto($sMessage);
		}

		$oTable=new Table();
		$oTable->sSql=Base::GetSql("Price/Profile");
		$oTable->iRowPerPage=50;
		//$oTable->aOrdered="order by post desc";
		$oTable->aColumn=array(
		'name'=>array('sTitle'=>'Name','sWidth'=>'20%'),
		//'name_file'=>array('sTitle'=>'Name Template of File','sWidth'=>'20%'),
		//'type_'=>array('sTitle'=>'Type','sWidth'=>'20%'),
		'pref'=>array('sTitle'=>'Pref/Col Pref','sWidth'=>'20%'),
		'col_code_name'=>array('sTitle'=>'Code','sWidth'=>'20%'),
		//'col_part_eng'=>array('sTitle'=>'Name Eng','sWidth'=>'20%'),
		//'col_part_rus'=>array('sTitle'=>'Name Rus','sWidth'=>'20%'),
		'col_price'=>array('sTitle'=>'Price','sWidth'=>'20%'),
		'last_date_work'=>array('sTitle'=>'Date','sWidth'=>'20%'),
		'file_name'=>array('sTitle'=>'FileName on mail','sWidth'=>'20%'),
		//'email'=>array('sTitle'=>'email','sWidth'=>'20%'),
		'action'=>array(),
		);
		$oTable->sDataTemplate=$this->sPrefix.'/row_'.$this->sPrefix.'.tpl';
		//$oTable->aCallback=array($this,'CallParsePrice');

		Base::$sText.=$oTable->getTable("Price Profiles");
		Base::$sText.=Base::$tpl->fetch($this->sPrefix.'/button_'.$this->sPrefix.'.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	public function ReloadViewPrice() {
		if (Base::$aRequest['data']['file']) {
			$oPriceQueue = new PriceQueue();
			$oPrice = new Price();
			mb_internal_encoding("UTF-8");
			set_time_limit(0);
			$sLocalFile = SERVER_PATH.$oPriceQueue->sPathToFile.Base::$aRequest['data']['file'];
			if (@file_exists($sLocalFile)) {
				$aFilePart = pathinfo($sLocalFile);
				if (in_array(strtolower($aFilePart['extension']),$oPrice->aValidateExtensions))
					$aFileExtract[0] = array(
							'name' 	=> basename($sLocalFile),
							'path'	=> $sLocalFile,
							'ext'	=> $aFilePart['extension']
					);
				// get data from file
				$aInData = $this->GetDataFromFile($aFileExtract[0]);
				if (count($aInData) > 0)
					$aData['aInData'] = $aInData;
					
				Base::$tpl->assign('aData',$aData);
				Base::$tpl->assign('sLocalFile',basename($sLocalFile));
				
				if(Base::$aRequest['data']['row_start'] && (int)Base::$aRequest['data']['row_start'] > 0) 
					Base::$tpl->assign('see_offset_cols',Base::$aRequest['data']['row_start']);
				
				if(Base::$aRequest['data']['charset'] && Base::$aRequest['data']['charset'] != '')
					Base::$tpl->assign('see_codepage',Base::$aRequest['data']['charset']);
				
				if(Base::$aRequest['data']['delimiter'] && Base::$aRequest['data']['delimiter'] != '')
					Base::$tpl->assign('see_delimiter',Base::$aRequest['data']['delimiter']);
				
				$a[""]="";
				Base::$tpl->assign('aDelimiter',$a+array(";"=>";","tab"=>"tab",","=>",","|"=>"|"));
				Base::$tpl->assign('aProvider',$a+Base::$db->getAssoc("select id_user as id, name from user_provider "));
				Base::$tpl->assign('aPref',$a+Base::$db->getAssoc("select pref as id, title from cat order by title "));
				Base::$tpl->assign('aCodeCurrency',Base::$db->getAssoc("select code as id, concat(code,' ',name) as name from currency "));
				
				$aSelectCol = array(
						''						=> Language::getMessage("Not use"),
						'data[col_provider]' 	=> Language::getMessage("Col Provider if provider blank"),
						'data[col_cat]' 		=> Language::getMessage("Col Name of Catalog"),
						'data[col_code_name]'	=> Language::getMessage("Col Code Name"),
						'data[col_part_rus]'	=> Language::getMessage("Col Name of Part Rus"),
						'data[col_part_eng]'	=> Language::getMessage("Col Name of Part Eng"),
						'data[col_number_min]'	=> Language::getMessage("Col Number min"),
						'data[col_price]'		=> Language::getMessage("Col Price Purchase"),
						'data[col_term]'		=> Language::getMessage("Col Term"),
						'data[col_stock]'		=> Language::getMessage("Col Stock"),
						'data[col_code_in]'		=> Language::getMessage("Col Code In"),
						'data[col_description]'	=> Language::getMessage("Col Description"),
						'data[col_grp]'			=> Language::getMessage("Group col")
				);
				Base::$tpl->assign('aSelectCol',$aSelectCol);
				
				Base::$oResponse->addAssign('in_data','innerHTML',
				Base::$tpl->fetch($this->sPrefix."/in_data.tpl"));
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function ProviderAddFromFile() {
		Base::$sText.=Base::$tpl->fetch($this->sPrefix.'/popup.tpl');
		if (Base::$aRequest['is_post'] == 1) {
			unset(Base::$aRequest['aMessage']);
			
			Base::$aRequest['data']['send_to_queue'] = 0;
			if (Base::$aRequest['action'] == 'price_profile_add_from_file_submit_queue') {
				Base::$aRequest['action'] = 'price_profile_add_from_file_submit';
				Base::$aRequest['data']['send_to_queue'] = 1;
			}
			
			// submit check configuration
			if (Base::$aRequest['action'] == 'price_profile_add_from_file_submit') {
				$this->CreateProfileFromFile();
			}
			
			$oPriceQueue = new PriceQueue();
			$oPrice = new Price();
			mb_internal_encoding("UTF-8");
			set_time_limit(0);
							
			// from already uploaded - local file
			if (Base::$aRequest['sLocalFile'] && @file_exists(SERVER_PATH.$oPriceQueue->sPathToFile.Base::$aRequest['sLocalFile'])) {
				$sLocalFile = SERVER_PATH.$oPriceQueue->sPathToFile.Base::$aRequest['sLocalFile'];
				$aFilePart = pathinfo($sLocalFile);
				if (in_array(strtolower($aFilePart['extension']),$oPrice->aValidateExtensions)) 
					$aFileExtract[0] = array(
						'name' 	=> basename($sLocalFile),
						'path'	=> $sLocalFile,
						'ext'	=> $aFilePart['extension']
					);
			}
			// from upload file
			else {
				$aResult = File::CheckFileUpload($_FILES['price_file']);
				if ($aResult['sMessage'] && $aResult['iError'] > 0) {
					//Form::RedirectAuto($aResult['sMessage']);
					$this->Redirect("?action=price_profile_add_from_file&aMessage[MF_ERROR]=".$aResult['sMessage']);
					return;
				}
				
				// check and create directory
				if (!file_exists(SERVER_PATH.$oPriceQueue->sPathToFile)) {
					if (!mkdir(SERVER_PATH.$oPriceQueue->sPathToFile, 0770))
						$sMessage="&aMessage[MF_ERROR]=".Language::GetMessage("Error save file to destination. Access denied create directory.");
				}
				if (!$sMessage && !is_writable(SERVER_PATH.$oPriceQueue->sPathToFile)) {
					$sMessage="&aMessage[MF_ERROR]=".Language::GetMessage("Error save file to destination. Access denied.");
				}
				
				if ($sMessage && $sMessage != '') {
					$this->Redirect("?action=price_profile_add_from_file".$sMessage);
					return;
				}
				
				if(isset($_FILES['price_file']) && $_FILES['price_file']['tmp_name'] != '') {
					$sUploadedFile = $_FILES['price_file']['tmp_name'];
					$aUploadFilePart = pathinfo($_FILES['price_file']['name']);
					$sUploadFileName=$aUploadFilePart['filename'].'.'.strtolower($aUploadFilePart['extension']);
					$sLocalFile = SERVER_PATH.$oPriceQueue->sPathToFile.Auth::$aUser['id'].$sUploadFileName;
					$sFileNameOriginal = $_FILES['price_file']['name'];
					
					if (!@move_uploaded_file($sUploadedFile, $sLocalFile)) {
						$sMessage="&aMessage[MF_ERROR]=".Language::GetMessage("Error uploaded file to destination.");
						$this->Redirect("?action=price_profile_add_from_file".$sMessage);
					}
					
		            $aFilePart = pathinfo($sLocalFile);
		
		            if (in_array(strtolower($aFilePart['extension']),array('zip','rar'))) {
		            	$aFileExtract=File::ExtractForPrice($sLocalFile,SERVER_PATH.$oPriceQueue->sPathToFile);
		            	if ($aFileExtract[0]['path']) { 
		            		$aFilePart = pathinfo($aFileExtract[0]['path']);
		            		$sLocalFile = $aFileExtract[0]['path'];
		            		$aFileExtract[0]['ext'] = $aFilePart['extension'];
		            	}
					}
					else {
						if (in_array(strtolower($aFilePart['extension']),$oPrice->aValidateExtensions)) 
							$aFileExtract[0] = array(
								'name' 	=> basename($sLocalFile),
								'path'	=> $sLocalFile,
								'ext'	=> $aFilePart['extension']
							);
					}
				}
		        else {
		        	$sMessage="&aMessage[MF_ERROR]=".Language::GetMessage("Not files for loading");
		        	$this->Redirect("?action=price_profile_add_from_file".$sMessage);
		        	return;
		        }
		        $sValidExtensions = '';
		        foreach ($oPrice->aValidateExtensions as $sValue) {
					if ($sValidExtensions != '')
						$sValidExtensions .= ', ';
		        	$sValidExtensions .= $sValue;
		        }
		        
		        if (!$aFileExtract || count($aFileExtract) == 0) {	
		        	$sMessage="&aMessage[MF_ERROR]=".Language::GetMessage("Not files for loading. Upload files this extensions") . 
		        				": " . $sValidExtensions;
		        	$this->Redirect("?action=price_profile_add_from_file".$sMessage);
		        	return;
		        }
			}
				        
	        Base::$tpl->assign('sLocalFile',basename($sLocalFile));
	        
	        if (Base::$aRequest['action'] == 'price_profile_add_from_file_submit') {
	        	$aData = Base::$aRequest['data'];
	        	$aData['aCol'] = Base::$aRequest['col'];
	        }
	        else { 
		        $aData['name'] = Base::$aRequest['name_profile'];
		        $aData['coef']=1;
		        $aData['list_count']=1;
	        }
	        $a[""]="";
	        Base::$tpl->assign('aDelimiter',$a+array(";"=>";","tab"=>"tab",","=>",","|"=>"|"));
	        Base::$tpl->assign('aProvider',$a+Base::$db->getAssoc("select id_user as id, name from user_provider "));
	        Base::$tpl->assign('aPref',$a+Base::$db->getAssoc("select pref as id, title from cat order by title "));
	        Base::$tpl->assign('aCodeCurrency',Base::$db->getAssoc("select code as id, concat(code,' ',name) as name from currency "));

	        $aData['num']=1+Db::GetOne("select max(num) from price_profile");
	        
	        // get data from file
	        $aInData = $this->GetDataFromFile($aFileExtract[0]);
	        if (count($aInData) > 0)
	        	$aData['aInData'] = $aInData;
	        
	        Base::$tpl->assign('aData',$aData);

        	$aSelectCol = array(
        		''						=> Language::getMessage("Not use"),
        		'data[col_provider]' 	=> Language::getMessage("Col Provider if provider blank"),
       			'data[col_cat]' 		=> Language::getMessage("Col Name of Catalog"),
        		'data[col_code_name]'	=> Language::getMessage("Col Code Name"),
        		'data[col_part_rus]'	=> Language::getMessage("Col Name of Part Rus"),
        		'data[col_part_eng]'	=> Language::getMessage("Col Name of Part Eng"),
        		'data[col_number_min]'	=> Language::getMessage("Col Number min"),
        		'data[col_price]'		=> Language::getMessage("Col Price Purchase"),
        		'data[col_term]'		=> Language::getMessage("Col Term"),
        		'data[col_stock]'		=> Language::getMessage("Col Stock"),
        		'data[col_code_in]'		=> Language::getMessage("Col Code In"),
        		'data[col_description]'	=> Language::getMessage("Col Description"),
        		'data[col_grp]'			=> Language::getMessage("Group col")
        	); 
        	Base::$tpl->assign('aSelectCol',$aSelectCol);
        	
        	if(Base::$aRequest['data']['row_start'] && (int)Base::$aRequest['data']['row_start'] > 0)
        		Base::$tpl->assign('see_offset_cols',Base::$aRequest['data']['row_start']);
        	
        	if(Base::$aRequest['data']['charset'] && Base::$aRequest['data']['charset'] != '')
        		Base::$tpl->assign('see_codepage',Base::$aRequest['data']['charset']);
        	
        	if(Base::$aRequest['data']['delimiter'] && Base::$aRequest['data']['delimiter'] != '')
        		Base::$tpl->assign('see_delimiter',Base::$aRequest['data']['delimiter']);
        	
	        $oForm=new Form();
	        $oForm->sHeader="method=post";
	        $oForm->sTitle="Edit";
	        $oForm->sContent=Base::$tpl->fetch($this->sPrefix.'/form_price_profile_add_from_file.tpl');
	        $oForm->sSubmitButton='Apply';
	        $oForm->sSubmitAction='price_profile_add_from_file_submit';
	        $oForm->sReturnAction='pages/price_profile_add_from_file';
	        $oForm->sReturnButton='<< Return';
	        $oForm->sAdditionalButtonTemplate=$this->sPrefix.'/button_form_add.tpl';
	        $oForm->bAutoReturn=true;
	        $oForm->bIsPost=true;
	        //$oForm->sWidth="600px";
	        $oForm->sWidth='100%';
	        
	        Base::$sText.=$oForm->getForm();
		}
		else {
			Base::Message();
			$iMaxSize = String::ParseSize(ini_get('post_max_size'));
			$iMaxSizeUpload = String::ParseSize(ini_get('upload_max_filesize'));
			if ($iMaxSizeUpload > 0 && $iMaxSizeUpload < $iMaxSize) {
				$iMaxSize = $iMaxSizeUpload;
			}
			Base::$tpl->assign('iMaxSize',String::FormatSize($iMaxSize));
	
			$aData=array(
			'sHeader'=>"method=post enctype=\"multipart/form-data\"" ,
			'sHidden'=>"<input type=hidden name=\"style\" value='segment'>",
			'sContent'=>Base::$tpl->fetch('price_profile/upload_file.tpl'),
			'sSubmitButton'=>'price_load_file',
			'sSubmitAction'=>'price_profile_add_from_file',
			'sReturnButton' => '<< Return',
			'sReturnAction'=>'pages/price_profile',
			'bAutoReturn' => 1,
			'sError'=>$sError,
			);
			
			$oForm=new Form($aData);
			Base::$sText.=$oForm->getForm();
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function PopUpProviderAdd() {
		
		if (Base::$aRequest['is_post'] == 1) {
			$aData = Base::$aRequest['data'];
			$aResult = $this->CreateProvider();
			// close popup
			if ($aResult) {
				Base::$oResponse->AddScript("
					$('#provider_select').append($('<option></option>').attr('value', '".Base::$aRequest['data']['id']."').text('".Base::$aRequest['data']['name']."'));
					$('#provider_select').val('".Base::$aRequest['data']['id']."');
					$('.pt-popup-block .close').parent().parent().parent().hide();
				");		
				return;	
			}
			//Base::$tpl->assign ( 'aData', $aData );
		}
		else 
			$aData['visible'] = 1;
		
		Base::$tpl->assign ( 'aData', $aData );
		
		$this->ProviderMakroInfo($aData);
		
		Base::$oResponse->AddAssign('popup_caption_id','innerHTML', Language::GetMessage('Create new provider'));
		Base::$tpl->assign('sContent',Base::$tpl->fetch('price_profile/provider_form_add.tpl'));
		Base::$oResponse->AddAssign('popup_content_id','innerHTML',
		Base::$tpl->fetch('price_queue/message.tpl'));
		
	}
	//-----------------------------------------------------------------------------------------------
	public function CreateProvider() {
		require_once(SERVER_PATH.'/mpanel/spec/provider.php');
		$oProvider = new AProvider();
		$oProvider->aCheckField[] = 'name';
		// provider apply copyed code
		if (!Base::$aRequest['data']['id']){
			$aData = Base::$db->GetAll("select * from user where login='".Base::$aRequest['data']['login']."' and id<>'".
					Base::$aRequest['data']['id']."'");
			if (count($aData) > 0){
				Base::Message(array('MT_ERROR'=>Base::$aRequest['data']['login'].Language::GetDMessage(' login is occupied.' )),false);
				return false;
			}
			if (Base::$aRequest['data']['login']==Base::$aRequest['data']['password']){
				Base::Message(array('MT_ERROR' => Language::getDMessage('Login and password are the same. Please choose another password')));
				return false;
			}
		}
		// admin apply copyed code
		$oProvider->ProcessFCKEditors ();
		$oProvider->BeforeApply ();
		if (! $oProvider->CheckField ()) {
			Base::Message (array('MT_ERROR' => Language::getDMessage ( 'Please fill out all fields' ) ));
			return false;
		} else {
			if($oProvider->aChildTable) {
				if (Base::$aRequest ['data'] [$oProvider->sTableId]) {
					$sMode = 'UPDATE';
					//------------------------
					$sWhereMain = $oProvider->sTableId . "='" . Base::$aRequest ['data'] [$oProvider->sTableId] . "'";
					$aBeforeRowMain = Db::GetRow("select * from ".$oProvider->sTableName."
						where ".$oProvider->sTableId."='".Base::$aRequest ['data'] [$oProvider->sTableId]."'");
					//------------------------
					foreach ($oProvider->aChildTable as $aTable) {
						$aBeforeRows[$aTable['sTableName']]	= Db::GetRow("select * from ".$aTable['sTableName']."
						where ".$aTable['sTableId']."='".Base::$aRequest ['data'] [$oProvider->sTableId]."'");
					}
				} else {
					$sMode = 'INSERT';
					//Unset(Base::$aRequest['data'][$this->sTableId]);
					$sWhereMain = false;
					//$aBeforeRowMain = false;
					foreach(Db::GetAll("desc ".$oProvider->sTableName) as $aRow)
						$aBeforeRowMain[$aRow['Field']] = false;
					foreach ($oProvider->aChildTable as $aTable) {
						foreach(Db::GetAll("desc ".$aTable['sTableName']) as $aRow)
							$aBeforeRows[$aTable['sTableName']][$aRow['Field']] = false;
					}
				};
				//------------------------
				Db::AutoExecute($oProvider->sTableName, array_intersect_key(Base::$aRequest ['data'], $aBeforeRowMain)
				, $sMode, $sWhereMain, true, true );
				if ($sMode=='INSERT')
					Base::$aRequest ['data'] [$oProvider->sTableId]=Db::InsertId();
				//------------------------
				foreach ($oProvider->aChildTable as $aTable) {
					$sWhere = ($sMode=='INSERT') ? false : $aTable['sTableId']."='".Base::$aRequest ['data'] [$oProvider->sTableId]."'";
					Base::$aRequest ['data'] [$aTable['sTableId']]=Base::$aRequest ['data'] [$oProvider->sTableId];
					Db::AutoExecute($aTable['sTableName'], array_intersect_key(Base::$aRequest ['data']
					, $aBeforeRows[$aTable['sTableName']]), $sMode, $sWhere, true, true );
				}
				//------------------------
				$aAfterRowMain = Db::GetRow("select * from ".$oProvider->sTableName."
						where ".$oProvider->sTableId."='".Base::$aRequest ['data'] [$oProvider->sTableId]."'");
				//------------------------
				foreach ($oProvider->aChildTable as $aTable)
					$aAfterRows[$aTable['sTableName']]	= Db::GetRow("select * from ".$aTable['sTableName']."
					where ".$aTable['sTableId']."='".Base::$aRequest ['data'] [$oProvider->sTableId]."'");
				//------------------------
				if($sMode!='INSERT') {
					$aBeforeRow=$aBeforeRowMain;
					foreach ($aBeforeRows as $aRow)
						$aBeforeRow=array_merge($aBeforeRow, $aRow);
				}
				else
					$aBeforeRow = false;
				//------------------------
				$aAfterRow=$aAfterRowMain;
				foreach ($aAfterRows as $aRow)
					$aAfterRow=array_merge($aAfterRow, $aRow);
			}
			else {
				if (Base::$aRequest ['data'] [$oProvider->sTableId]) {
					$sMode = 'UPDATE';
					$sWhere = $oProvider->sTableId . "='" . Base::$aRequest ['data'] [$oProvider->sTableId] . "'";
					$aBeforeRow=Db::GetRow("select * from ".$oProvider->sTableName."
					where ".$oProvider->sTableId."='".Base::$aRequest ['data'] [$oProvider->sTableId]."'");
				} else {
					$sMode = 'INSERT';
					$sWhere = false;
				}
				Db::AutoExecute($oProvider->sTableName, Base::$aRequest ['data'], $sMode, $sWhere);
				if ($sMode=='INSERT') Base::$aRequest ['data'] [$oProvider->sTableId]=Db::InsertId();
				$aAfterRow=Db::GetRow("select * from ".$oProvider->sTableName."
						where ".$oProvider->sTableId."='".Base::$aRequest ['data'] [$oProvider->sTableId]."'");
			}
		}
		// apply after copy
		if(!$aBeforeRow)
		{
			Base::$db->AutoExecute ('provider_virtual',	array(
			'id_provider' => $aAfterRow[$oProvider->sTableId],
			'id_provider_virtual' => $aAfterRow[$oProvider->sTableId],
			),'INSERT');
			Base::$db->AutoExecute ('user_account',	array(
			'id_user' => $aAfterRow[$oProvider->sTableId],
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
		// apply after copy - end
		
		if (Base::$aGeneralConf['LogAdmin']) {
			require_once(SERVER_PATH.'/class/core/Log.php');
			Log::AdminAdd(Base::$aRequest['xajaxargs'][0],$oProvider->sTableName);
		}
		return true;
	}
	//-----------------------------------------------------------------------------------------------
	public function GetDataFromFile($aData) {
		$aResult = array();
		switch ($aData['ext']) {
			case "xls":
			case "xlsx":
				$aResult = $this->LoadFromExcelLimit($aData,Base::GetConstant('limit_load_lines_view_create_profile',10));
				break;

			case "csv":
			case "txt":
				$aResult = $this->LoadFromCsvLimit($aData,Base::GetConstant('limit_load_lines_view_create_profile',10));
				break;
		}
		return $aResult;
	}
	//-----------------------------------------------------------------------------------------------
	public function LoadFromCsvLimit($aFile,$iLimit=10) {
		$aData=array();
		
		setlocale(LC_CTYPE,"ru_UA.utf8");
		
		$handle = fopen('php://memory', 'w+');

		$sCharset = '';
		if (Base::$aRequest['data']['charset'])
			$sCharset = Base::$aRequest['data']['charset'];
			
		if (strtoupper($sCharset)=="UTF-8" || strtoupper($sCharset)=="UTF8" ) {
			fwrite($handle, file_get_contents($aFile['path']));
			rewind($handle);
		}else{
			fwrite($handle, iconv($sCharset, 'UTF-8', file_get_contents($aFile['path'])));
			rewind($handle);
		}
		
		$sDelimiter = ';';
		if (Base::$aRequest['data']['delimiter'])
			$sDelimiter = Base::$aRequest['data']['delimiter'];

		if ($sDelimiter=="tab") 
			$sDelimiter="\t";
	
		fseek($handle, 0);
		$i = 0;
		while (($data = fgetcsv($handle, 2000, $sDelimiter)) !== FALSE) {
			$i++;
			if ($iLimit < $i) break;
			$aData[] = $data;
		}
	
		fclose($handle);
		return $aData;
	}
	//-----------------------------------------------------------------------------------------------
	public function LoadFromExcelLimit($aFile,$iLimit=10)
	{
		$aData = array();
		ini_set("memory_limit",Base::GetConstant("global:price_load_excel_memory_limit","4G"));

		$iListCount = 1;
		if (Base::$aRequest['data']['list_count'])
			$iListCount = Base::$aRequest['data']['list_count'];

		$iRowStart = 1;
		if (Base::$aRequest['data']['row_start'])
			$iRowStart = Base::$aRequest['data']['row_start'];
		
		if ($aFile['ext']=='xlsx'){
			//$aData = $this->LoadFromXlsxPartialLimit($aFile, $iLimit);
			$oExcel = new Excel();
			$objReader = $oExcel->CreateObjectExcel2007();
			$aExelInfo = $objReader->listWorksheetInfo_CorrectAllRows($aFile['path']);
			unset($objReader);
			
			for ($iList=0;$iList<$iListCount;$iList++){
				for($iStartRow = $iRowStart; $iStartRow <= $aExelInfo[$iList]['totalRows']; $iStartRow += $iLimit) {
					if ($iStartRow >= $iLimit)
						break;
					$objReader = $oExcel->SetCreateReader();
					$oChunkFilter = new chunkReadFilter();
					$objReader->setReadFilter($oChunkFilter);
			
					$oChunkFilter->setRows($iStartRow,$iLimit);
					$objReader->setReadFilter($oChunkFilter);
					$objReader->setReadDataOnly(true);
					$objPHPExcel = $objReader->load($aFile['path']);
					$objPHPExcel->setActiveSheetIndex($iList);
					$sFromCell = 'A'.$iStartRow;
					$aData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,false,$sFromCell);
						
					// free memory
					unset($objPHPExcel);
					unset($objReader);
					unset($oChunkFilter);
				}
			}
		} else {
			require_once("excel/reader.php");
			unset($data);
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('UTF-8');
			$data->read($aFile['path']);
				
			// parse data
			$iCnt=0;
			for ($iList=0;$iList<$iListCount;$iList++){
				for( $i=$iRowStart; $i <= ($data->sheets[$iList]['numRows'] != 0 ? $data->sheets[$iList]['numRows'] : count($data->sheets[$iList]['cells'])); $i++) {
					$iCnt += 1;
					if ($iLimit < $iCnt)
						break;
					$aData[] = $data->sheets[$iList]['cells'][$i];
				}
			}
	
		}
		return $aData;
	}
	
	//-----------------------------------------------------------------------------------------------
	public function CreateProfileFromFile() {
		$aSelectCol = array(
				''						=> Language::getMessage("Not use"),
				'data[col_provider]' 	=> Language::getMessage("Col Provider if provider blank"),
				'data[col_cat]' 		=> Language::getMessage("Col Name of Catalog"),
				'data[col_code_name]'	=> Language::getMessage("Col Code Name"),
				'data[col_part_rus]'	=> Language::getMessage("Col Name of Part Rus"),
				'data[col_part_eng]'	=> Language::getMessage("Col Name of Part Eng"),
				'data[col_number_min]'	=> Language::getMessage("Col Number min"),
				'data[col_price]'		=> Language::getMessage("Col Price Purchase"),
				'data[col_term]'		=> Language::getMessage("Col Term"),
				'data[col_stock]'		=> Language::getMessage("Col Stock"),
				'data[col_code_in]'		=> Language::getMessage("Col Code In"),
				'data[col_description]'	=> Language::getMessage("Col Description"),
				'data[col_grp]'			=> Language::getMessage("Group col")
		);
		
		$sError = '';
		if (!Base::$aRequest['data']['name'] || Base::$aRequest['data']['name'] == '')
			$sError .= Language::GetMessage('not_fill_name_profile')."<br>";
		else {
			$iCnt = Db::GetOne("Select count(*) from price_profile where name='".Base::$aRequest['data']['name']."'");
			if ($iCnt > 0)
				$sError .= Language::GetMessage('name_profile_exist')."<br>";
		}  
		// check if empty data
		if (!Base::$aRequest['col'] || !is_array(Base::$aRequest['col']) || count(Base::$aRequest['col'])== 0)
			$sError .= Language::GetMessage('empty_data_col')."<br>";
		else {
		// check if not one selected
			$iExist = 0;
			$aDoubleCheck = array();
			foreach (Base::$aRequest['col'] as $iKey => $sValue) {
				if ($sValue != '') {
					$iExist = 1;
					$aDoubleCheck[$sValue] += 1;
				}
			}
			if ($iExist == 0)
				$sError .= Language::GetMessage('not select data col')."<br>";
			else {
				// check if double selected
				foreach ($aDoubleCheck as $sKey => $iCount) {
					if ($iCount > 1)
						$sError .= Language::GetMessage('select not unique field col').": ".$aSelectCol[$sKey]."<br>";
				}
			}
		}
		if ($sError != '') {
			$aMessage = array('MF_ERROR_NT' => $sError);
			Base::Message($aMessage);
		}
		// create new profile
		else {
			$aData=String::FilterRequestData(Base::$aRequest['data']);
			if (Base::$aRequest['col']) {
				foreach (Base::$aRequest['col'] as $iKey => $sValue) {
					$sValue = str_replace('data[','',$sValue);
					$sValue = str_replace(']','',$sValue);
					$aData[$sValue] = $iKey;
				}
			}
			Db::AutoExecute("price_profile",$aData);
			$iIdProfile = Db::GetOne("Select id from price_profile where name='".$aData['name']."'");
			if (!$iIdProfile) {
				$this->Redirect("?action=price_profile&aMessage[MT_ERROR]=Price profile not added");
				return;
			}
			// check need add to queue?
			if (Base::$aRequest['data']['send_to_queue']) {
				$oPrice = new Price();
				$oPriceQueue = new PriceQueue();
				if (Base::$aRequest['sLocalFile'] && @file_exists(SERVER_PATH.$oPriceQueue->sPathToFile.Base::$aRequest['sLocalFile'])) {
					$sLocalFile = SERVER_PATH.$oPriceQueue->sPathToFile.Base::$aRequest['sLocalFile'];
					$aFilePart = pathinfo($sLocalFile);
					if (in_array(strtolower($aFilePart['extension']),$oPrice->aValidateExtensions))
						$aFileExtract[0] = array(
								'name' 	=> basename($sLocalFile),
								'path'	=> $sLocalFile,
								'ext'	=> $aFilePart['extension']
						);
				}
				else {
					$this->Redirect("?action=price&aMessage[MT_NOTICE]=Price profile added but not add to queue");
					return;
				}				
				 $sErrorProfile = $oPrice->SaveFilesToQueue($aFileExtract, $sSource = 'upload', $iIdProfile);
				
				// start asunc process
				PriceQueue::AsuncLoadQueuePrice(0);

				if ($sErrorProfile != "") {
					$sMessage="&aMessage[MF_ERROR]=".Language::GetMessage("Not found profile for uploaded files") .":<br>". $sErrorProfile;
					$this->Redirect("?action=price".$sMessage);
					return;
				}
				
				$this->Redirect("?action=price&aMessage[MT_NOTICE]=Price profile added and add to queue");
				return;
			}
			else {
				$this->Redirect("?action=price_profile&aMessage[MT_NOTICE]=Price profile added");
				return;
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function ProviderEdit() {
		Base::$tpl->assign ( 'isEdit', '1');
		Base::$aTopPageTemplate=array('panel/tab_price.tpl'=>$this->sPrefixAction);
		
		if (Base::$aRequest['is_post'] == 1) {
			$aData = Base::$aRequest['data'];
			$aResult = $this->CreateProvider();
			if ($aResult) 
				$aMessage=array('MT_NOTICE'=>'User provider updated');
			else
				$aMessage=array('MT_ERROR'=>'User provider error updated');
				
			//Form::RedirectAuto($sMessage);
			Base::Message($aMessage);
		}
		
		$aProvider=Db::GetRow(Base::GetSql('Provider',array(
				'join_provider_group'=>'1',
				'join_provider_region'=>'1',
				'where'=>" and u.id = ".Base::$aRequest['id'],
		)));
		if (!Base::$aRequest['id'] || !$aProvider) {
			if (Base::$aRequest['return'])
				Base::Redirect(Base::$aRequest['return']);
			Base::Redirect('/pages/price');
		}
			
		if ($aProvider)
			Base::$tpl->assign ( 'aData', $aProvider );

		$this->ProviderMakroInfo($aProvider);
		Base::$tpl->assign ( 'sReturnActionBtn', Base::$aRequest['return'] );
		Base::$tpl->assign ( 'sReturnBtn', Language::getMessage('<< Return'));
		$oForm=new Form();
		$oForm->sHeader="method=post";
		$oForm->sTitle="Edit provider";
		$oForm->sContent=Base::$tpl->fetch($this->sPrefix.'/provider_form_add.tpl');
	/*	$oForm->sReturnButton='<< Return';
		$oForm->sSubmitButton='Apply';
		$oForm->sSubmitAction=$this->sPrefixAction;
		$oForm->sReturnAction=Base::$aRequest['return'];*/
		$oForm->bAutoReturn=true;
		$oForm->bIsPost=true;
		$oForm->sWidth="600px";
		

		
		Base::$sText=$oForm->getForm();
		
		return;
		
	}
	//-----------------------------------------------------------------------------------------------
	// code from mpanel/spec/provider-> BeforeAddAssign($aData)
	public function ProviderMakroInfo($aData) {
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
		if ($aData['id']) {
			$aCat=Base::$db->GetAll(Base::GetSql("Cat",array('order'=>" c.name")));
			if ($aCat) {
				$aProviderMakeStatistic=Base::$db->GetAssoc(Base::GetSql("ProviderMakeStatistic",array('id_user'=>$aData['id'])));
				foreach ($aCat as $key => $value) {
					$aCat[$key]['manual_delivery_term']=$aProviderMakeStatistic[$value['name']]['manual_delivery_term'];
					$aCat[$key]['manual_refuse_percent']=$aProviderMakeStatistic[$value['name']]['manual_refuse_percent'];
					$aCat[$key]['manual_confirm_term']=$aProviderMakeStatistic[$value['name']]['manual_confirm_term'];
				}
				Base::$tpl->assign('aCat',$aCat);
			}
		}
	}
}