<?
/**
 * Price loader from queue
 *
 */
class PriceQueue extends Price {
	var $sPrefix="price_queue";
	var $sPrefixAction;
	var $sPathToFile="/imgbank/price/queue/";
	//-----------------------------------------------------------------------------------------------
	public function PriceQueue()
	{
		$this->oCatalog = new Catalog();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		Auth::NeedAuth("manager");
		Base::$aData['template']['bWidthLimit']=false;

		$this->sPrefixAction=$this->sPrefix;
		Base::$aTopPageTemplate=array('panel/tab_price.tpl'=>$this->sPrefixAction);
		if (Base::$aRequest['is_post']){
			if (0) {
				Base::Message(array('MF_ERROR'=>'Required fields city, address'));
				Base::$aRequest['action']=$this->sPrefix.'_add';
				Base::$tpl->assign('aData',Base::$aRequest['data']);
			} else {
				$aData=String::FilterRequestData(Base::$aRequest['data']);

				Db::AutoExecute("price_queue",$aData,"UPDATE","id=".Base::$aRequest['id']);
				$sMessage="&aMessage[MI_NOTICE]=Price updated";
				
				// empty results by price if restart process
				if ($aData['is_processed'] == 0) {
					Db::Execute("delete from log_price_queue where id_price_queue = ".Base::$aRequest['id']);
					Db::Execute("Update price_queue set date_start = Null, sum_all = 0, sum_without_pref = 0, sum_errors = 0, 
									current_string = NULL, date_stop = Null, date_progress = Null, progress = 0, step = '' where id=".Base::$aRequest['id']);
					
					// start asunc process
					PriceQueue::AsuncLoadQueuePrice(0);
				}
				
				Form::RedirectAuto($sMessage);
			}
		}

		if (Base::$aRequest['action']==$this->sPrefix.'_add'||Base::$aRequest['action']==$this->sPrefix.'_edit') {
			$a[""]="";
			Base::$tpl->assign('aUserProvider',$a+Db::GetAssoc("Assoc/UserProvider"));
			Base::$tpl->assign('aPriceProfile',$a+Db::GetAssoc("Assoc/PriceProfile"));

			if (Base::$aRequest['action']==$this->sPrefix.'_edit') {
				$aData=Db::GetRow(Base::GetSql("Price/Queue",array("id"=>Base::$aRequest['id'])));
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
			$oForm->sWidth="470px";

			Base::$sText.= $oForm->getForm();

			return;
		}

		if (Base::$aRequest['action']==$this->sPrefix.'_delete' && Base::$aRequest['id']) {
			$aData['visible']=0;
			Db::AutoExecute("price_queue",$aData,"UPDATE","id=".Base::$aRequest['id']);
			$sMessage="&aMessage[MI_NOTICE_NT]=".Language::GetMessage('Price deleted');
			Form::RedirectAuto($sMessage);
		}

		if (Base::$aRequest['action']==$this->sPrefix.'_stop' && Base::$aRequest['id']) {
			// global flag stopped price			
			$aData['is_processed']=3;
			$aData['date_stop']=time();
			$aData['step'] = Language::GetMessage('stopped by user');			
			Db::AutoExecute("price_queue",$aData,"UPDATE","id=".Base::$aRequest['id']);
			$sMessage="&aMessage[MI_NOTICE_NT]=".Language::GetMessage("Price stopped upload process");
			Form::RedirectAuto($sMessage);
		}
		
		Base::$tpl->assign("sPathToFile",$this->sPathToFile);

		$oTable=new Table();
		$oTable->sSql=Base::GetSql("Price/Queue");
		$oTable->aOrdered="order by pq.id desc";

		$oTable->aColumn['id']=array('sTitle'=>'id','sWidth'=>'5%');
		$oTable->aColumn['up_name']=array('sTitle'=>'Provider','sWidth'=>'15%');
		$oTable->aColumn['pp_name']=array('sTitle'=>'Price profile','sWidth'=>'15%');
		$oTable->aColumn['file_path']=array('sTitle'=>'File','sWidth'=>'10%');
		$oTable->aColumn['post_date']=array('sTitle'=>'Date','sWidth'=>'15%');
		$oTable->aColumn['sum_all']=array('sTitle'=>'All','sWidth'=>'5%');
		$oTable->aColumn['sum_without_pref']=array('sTitle'=>'Need Check','sWidth'=>'5%');
		$oTable->aColumn['is_processed']=array('sTitle'=>'Processed','sWidth'=>'5%');
		$oTable->aColumn['action']=array();
		$oTable->iRowPerPage=50;

		$oTable->sDataTemplate=$this->sPrefix.'/row_index.tpl';
		$oTable->sButtonTemplate=$this->sPrefix.'/button_index.tpl';
		//$oTable->aCallback=array($this,'CallParsePrice');
		
		Base::$bXajaxPresent=true;
		
		Base::$sText.= $oTable->getTable("Price queue");
	}
	//-----------------------------------------------------------------------------------------------
	public function GetMailAttachment()
	{
		if (!(Base::$aGeneralConf['is_price_email_available'] && Base::$aGeneralConf['is_price_email_available'] == 1))
			return; // not blocked next process in cron !!!
		
		$oPrice = new Price();
		$iUserId = Auth::$aUser['id'] = 1;
		
		$this->sPrefixAction=$this->sPrefix."_get_mail_attachment";
		//$aPriceProfile=Db::GetAll(Base::GetSql("Price/Profile",array('where'=>" and pp.name_file is not null and pp.name_file<>''")));

		$oAccount=Mail::OpenAccount(Base::GetConstant("price:mail_server","pop.gmail.com"),Base::GetConstant("price:mail_port","993"),
		Base::GetConstant("price:mail_login","testprice@i.ua"),Base::GetConstant("price:mail_password","21f1990"),
		Base::GetConstant("price:mail_type","imap/ssl/novalidate-cert"));
		$iMailCount=Mail::GetEmailCount($oAccount);
		if(!$iMailCount) Debug::PrintPre("not mail");

		for ($iMes = 1; $iMes <= $iMailCount; $iMes++) {
		$iMessage=1;
		$aHeader=Mail::GetEmailHeader($oAccount,$iMessage);
		if(!$aHeader) {print("not mail");return;}
		$sSubject=Mail::DecodeMimeString($aHeader['subject']);
		$sFrom=Mail::GetSenderEmail($oAccount,$iMessage);

		$aAttachment=Mail::GetAttachment($oAccount,$iMessage);

		for ($i=0;$i<count($aAttachment);$i++){
			if ($aAttachment[$i]['is_attachment']) {
				unset($aData);

				//$sExt=strtolower(end(explode(".",$aAttachment[$i]['name'])));
				$aFilePart = pathinfo(mb_strtolower($aAttachment[$i]['name']));
				$sExt=$aFilePart['extension'];
				$sBasenameOriginal = $aAttachment[$i]['name'];
				if (!$sExt) {
					$aFilePart = pathinfo(mb_strtolower($aAttachment[$i]['filename']));
					$sExt=$aFilePart['extension'];
					$sBasenameOriginal = $aAttachment[$i]['filename'];
				}
				
				$aFile['path']=SERVER_PATH.$this->sPathToFile.$iUserId.$sBasenameOriginal;
				
				if (File::Write($aFile,$aAttachment[$i]['attachment'])) {
					$sLocalFile = SERVER_PATH.$this->sPathToFile.$iUserId.$sBasenameOriginal;				
					if (in_array(strtolower($aFilePart['extension']),array('zip','rar'))) {
						$aFileExtract=File::ExtractForPrice($sLocalFile,SERVER_PATH.$this->sPathToFile);
					}
					else {
						if (in_array($aFilePart['extension'],$oPrice->aValidateExtensions))
							$aFileExtract[0] = array(
									'name' 	=> basename($sLocalFile),
									'path'	=> $sLocalFile,
							);
					}

					$sError = $oPrice->SaveFilesToQueue($aFileExtract, $sSource = 'mail', 0, $sSubject, $sFrom);

					Mail::DeleteEmail($oAccount,$iMessage);
				}
				
				/*
				//$aData['id_user_provider']=$iPriceProfile;
				$aData['id_user']=1;
				$aData['file_name_original']=$aAttachment[$i]['name'];
				$aData['source'] = 'email';
				//$aData['id_price_profile']=$iPriceProfile;
				if(!$aData['file_name_original']) continue;

				Db::AutoExecute("price_queue",$aData);
				$id=Db::InsertId();

				if ($sExt=="zip" || $sExt=="rar") {

					$aFile['path']=SERVER_PATH.$this->sPathToFile.$id.".".$sExt;
					if (File::Write($aFile,$aAttachment[$i]['attachment'])) {
						$aFileExtract=File::ExtractForPrice($aFile['path'],SERVER_PATH.$this->sPathToFile);
					}
					
					if ($aFileExtract) foreach ($aFileExtract as $sKey => $aValue) {

						$aData['file_name_original']=$aFileExtract[$sKey]['name'];
						$aData['file_name']=$id."_".$sKey."_".$aFileExtract[$sKey]['name'];
						$aData['file_path']=SERVER_PATH.$this->sPathToFile.$aData['file_name'];
						rename($aFileExtract[$sKey]['path'],$aData['file_path']);

						$aData['id_price_profile']=0;
						$aData['id_user_provider']=0;
						$aProfileInfo = $this->GetProfile($sType = 'mail', $aData['file_name'], $sSubject, $sFrom);
						if ($aProfileInfo['id']) {
							$aData['id_price_profile']=$aProfileInfo['id'];
							$aData['id_user_provider']=$aProfileInfo['id_provider'];
						}
						
						if ($sKey==0) {
							Db::AutoExecute("price_queue",$aData,"UPDATE","id=".$id);
						} else {
							Db::AutoExecute("price_queue",$aData);
						}
						//unlink($aFile['path']);
					}

				} else {

					$aData['file_name_original']=$aAttachment[$i]['name'];
					$aData['file_name']=$id."_".$aAttachment[$i]['name'];
					$aData['file_path']=SERVER_PATH.$this->sPathToFile.$aData['file_name'];

					$aFile['path']=$aData['file_path'];
					File::Write($aFile,$aAttachment[$i]['attachment']);

					$aData['id_price_profile']=0;
					$aData['id_user_provider']=0;
					$aData['source'] = 'email';
					$aProfileInfo = $this->GetProfile($sType = 'mail', $aData['file_name'], $sSubject, $sFrom);
					if ($aProfileInfo['id']) {
						$aData['id_price_profile']=$aProfileInfo['id'];
						$aData['id_user_provider']=$aProfileInfo['id_provider'];
					}
					Db::AutoExecute("price_queue",$aData,"UPDATE","id=".$id);
				}
				*/
			}
		}

		}
		Mail::CloseAcount($oAccount);

		if ($sError != '')
			echo Language::GetMessage("Not found profile for uploaded files") . ":<br>\n" . $sError;
		
		echo "ok";

	}
	//-----------------------------------------------------------------------------------------------
	public function LoadQueuePrice()
	{
		$sLog = "/tmp/_log_upload_price_".Base::GetConstant("global:project_name",'');
		
		if (($iBoardTimeBreakGlobalLoad = Base::GetConstant("price:break_global_load_file_in_minutes","")) == "") {
			Base::UpdateConstant("price:break_global_load_file_in_minutes",60);
			$iBoardTimeBreakGlobalLoad = 60;
		}
		
		if (($iBoardTimeBreakProcess = Base::GetConstant("price:break_load_file_in_minutes","")) == "") {
			Base::UpdateConstant("price:break_load_file_in_minutes",5);
			$iBoardTimeBreakProcess = 5;
		}
		
		$iBoardTimeBreakProcess *= 60; // in seconds
		
		$iBoardTimeBreakGlobalLoad *= 60; // in seconds

		// check global pause
		if (Base::GetConstant("price:is_load",0) == 1) {
			$iIntervalStop=Db::GetRow("select (UNIX_TIMESTAMP() - date_progress) as seconds from `price_queue` order by date_progress desc limit 1");
			if ($iIntervalStop['seconds'] > $iBoardTimeBreakGlobalLoad) 
				Base::UpdateConstant("price:is_load",0);
			else 
				return;
		}
		
		Base::UpdateConstant("price:is_load",1); // set blocker flag

		print "Begin | ";
		set_time_limit(0);
		
		$this->sPrefixAction=$this->sPrefix."_load_price";
		/* is_processed:
		 *  0 - ready to work
		 *  1 - in process 
		 *	2 - work done
		 *	3 - stopped
		 */
		while (1) {
			$aRow=Db::GetRow(Base::GetSql("Price/Queue",array(
			//"where"=>" and pq.id_price_profile>0 and id_user_provider>0 and is_processed not in (2,3)",
			"where"=>" and pq.id_price_profile>0 and is_processed not in (2,3)",
			"order"=>"order by pq.weight,pq.post_date asc"
			)));

			// check bad process
			if ($aRow['is_processed'] == 1 && $aRow['date_process'] != Null && (time() - $aRow['date_progress']) > $iBoardTimeBreakProcess) {

				Db::AutoExecute("price_queue",array("is_processed"=>2, "date_stop" => time(), 
					'step' => Language::GetMessage('break process by board time'),
					'date_progress' => time(),
					'sum_errors' => 'sum_errors + 1'),
					"UPDATE","id=".$aRow['id']);
				
				Db::Execute("update price_queue set sum_errors = sum_errors+1 where id=".$aRow['id']);
				
				Db::Execute("insert into log_price_queue (id_price_queue, input_data, error_message, list, row) VALUES
							(".$aRow['id'].",'".base64_encode(json_encode(array()))."','".
							Language::GetMessage('break process by board time')."','-1','0')");
				
				continue;
			}
			break;
		}
		print "Get Queue | ";

		if ($aRow) {
			$aPriceProfile=Db::GetRow(Base::GetSql("Price/Profile",array('id'=>$aRow['id_price_profile'])));
			$aPriceProfile['id_provider']=$aRow['id_user_provider'];
			
			Base::$db->Execute("update price_profile set last_date_work=now() where id='".$aPriceProfile['id']."'");
			
			$iUser=1;
			if ($aRow['id_user'] && $aRow['id_user'] != 0) {
				$iUser = $aRow['id_user'];
				Auth::$aUser['id'] = $aRow['id_user'];
			}
			//$iUser=Auth::$aUser['id'];
			//if (!$iUser) $iUser=1;
			$aFile['path']=$aRow['file_path'];
			print "Get Profile | ";

				Db::AutoExecute("price_queue",array("is_processed"=>1,"date_start" => time()),"UPDATE","id=".$aRow['id']);
				// create new log
				Db::Execute("delete from log_price_queue where id_price_queue = ".$aRow['id']);
				
				print "Set processed | ";

				if ($aPriceProfile['delete_before']==1){
					//Base::UpdateConstant("price:is_load",1);
					Base::$db->Execute("update price set price=0 where id_provider='".$aPriceProfile['id_provider']."'");
					//Base::UpdateConstant("price:is_load",0);
				}
				
				// now check type by extension
				$aFilePart = pathinfo($aRow['file_path']);
				$aPriceProfile['type_'] = strtolower($aFilePart['extension']);
				
				file_put_contents($sLog,date("Y-m-d H:i:s")." Start file: ".$aRow['file_path']."\n",FILE_APPEND);
				
				switch ($aPriceProfile['type_']) {
					case "xls":
					case "xlsx":
						$iCountError = $this->LoadFromExcel($aFile,$aPriceProfile,$iUser,$aRow['id']);
						break;

					case "csv":
					case "txt":
						$iCountError = $this->LoadFromCsv($aFile,$aPriceProfile,$iUser,$aRow['id']);
						break;
/*
					case "txt":
						$this->LoadFromText($aFile,$aPriceProfile,$iUser,$aRow['id']);
						break;

					case "xml":
						$this->LoadFromXml($aFile,$aPriceProfile,$iUser,$aRow['id']);
						break;
*/
				}
				print "Load from file | ";
				
				// sum_all - update early in load_from...
				/*$aInfo=Db::GetRow("
				select count(*) as sum_all, sum(if(pref='',1,0)) as sum_without_pref 
				from `price_import`
				where id_price_queue=".$aRow['id']."
				group by id_price_queue;
				");*/
				$aInfo=Db::GetRow("
				select sum(if(pref='',1,0)) as sum_without_pref
				from `price_import`
				where id_price_queue=".$aRow['id']."
				group by id_price_queue;
				");
				
				if ($aInfo) {
					Db::AutoExecute("price_queue",$aInfo,"UPDATE","id=".$aRow['id']);
				}

				Db::AutoExecute("price_queue",array("progress" => 100,"is_processed"=> 2,"date_stop" => time(), 
									'step' => Language::GetMessage('work finished')),
									"UPDATE","id=".$aRow['id']);
				
				// update provider last date work
				Db::Execute("update user_provider set last_date_work=now() where id_user in (SELECT group_concat( DISTINCT (
					cast( id_provider AS char ) ) ) AS id FROM price_import where id_price_queue = ".$aRow['id'].")");
				
				if ($aPriceProfile['auto_set_price']==1){
					//Base::$db->Execute("update price_import set id_user=0 where (pref='' or pref is null) and (id_user='".Auth::$aUser['id']."' or id_user=1)");
					Base::$db->Execute("update price_import set id_user=0 where (pref='' or pref is null) and id_price_queue=".$aRow['id']);

					// check if need delete before upload -> need if > 1 file to 1 provider
					if ($aPriceProfile['delete_before']==1)
						$this->ClearProvider(false, $aRow['id']);

					$this->Install(false);
					Base::$db->Execute("update price_import set id_user=".$iUser." where (pref='' or pref is null) and id_user=0");
				}
				// check result
				if ($iCountError > 0) {
					$aMessageData = $this->BuildMessage($aRow['id'], true);
					$aTemplateData = String::GetTemplateRow('error_load_price');
					Mail::AddDelayed(Base::GetConstant("global:to_email"),
					$aTemplateData['name']." [id: ".$aRow['id']." file: ".$aRow['file_name_original']."]",
					$aMessageData['content']);
				}
				
				file_put_contents($sLog,date("Y-m-d H:i:s")." End file: ".$aRow['file_path']." Count error:".$iCountError."\n",FILE_APPEND);
				
				Debug::PrintPre("ok",false);
		} else {
			Debug::PrintPre("not file",false);
		}
		Base::UpdateConstant("price:is_load",0);
		
		$aRowNew=Db::GetRow(Base::GetSql("Price/Queue",array(
			"where"=>" and pq.id_price_profile>0 and is_processed not in (2,3)",
			"order"=>"order by pq.weight,pq.post_date asc"
			)));
		if($aRowNew)
			$this->AsuncLoadQueuePrice(0);

		if(Auth::$aUser && Auth::$aUser['id'] != 1) Base::Redirect('/?action=price');
	}
	//-----------------------------------------------------------------------------------------------
	public function GetFtpFile() {
		//set_time_limit(0);
		if (!(Base::$aGeneralConf['is_price_ftp_available'] && Base::$aGeneralConf['is_price_ftp_available'] == 1))
			return; // die blocked next process in cron!!!

		$oPrice = new Price();

		$iUserId = Auth::$aUser['id'] = 1;
		
		$aData=Db::GetAll(Base::GetSql("Price/Ftp", array("is_download"=>1)));

		foreach ($aData as $aValue) {
			Db::Execute("update price_ftp set last_download=now() where id=".$aValue['id']);
			
			if(strpos($aValue['code'],'http://')!==false){
				$sFileUrl=trim($aValue['code'],'/')."/".trim($aValue['name_folder'],'/')."/".trim($aValue['name_file'],'/');
				$sFileName=basename($sFileUrl);
				$sFilePath=SERVER_PATH.$this->sPathToFile.$sFileName;
				if(strpos($aValue['code'],'autoprodazh.com.ua')!==false){
					$params = array(
						'name' => $aValue['username'], 
						'pass' => $aValue['password'], 
						'form_id' => 'user_login_block',
						'op' => 'Вхід'
					);
					$dest_file = fopen($sFilePath, "w");
					$aRequest=$this->msoap($sFileUrl,$params,1,$dest_file);
					fclose($dest_file);
				}else{
					$dest_file = fopen($sFilePath, "w");
					$aRequest=$this->msoap($sFileUrl,array(),0,$dest_file);
					fclose($dest_file);
				}
				if(file_exists($sFilePath)){
					$sLocalFile = SERVER_PATH.$this->sPathToFile.$iUserId.$sFileName;
					rename($sFilePath,$sLocalFile);
					$aFilePart = pathinfo($sLocalFile);

					if (in_array(strtolower($aFilePart['extension']),array('zip','rar'))) {
						$aFileExtract=File::ExtractForPrice($sLocalFile,SERVER_PATH.$this->sPathToFile);
					}
					else {
						if (in_array($aFilePart['extension'],$oPrice->aValidateExtensions))
							$aFileExtract[0] = array(
									'name' 	=> basename($sLocalFile),
									'path'	=> $sLocalFile,
							);
					}
					
					$sError = $oPrice->SaveFilesToQueue($aFileExtract, $sSource = 'ftp');
					if ($sError != '')
						Debug::PrintPre(Language::GetMessage("Not found profile for uploaded files") . ":<br>\n" . $sError);
				}
				continue;
			}

			$sFtpServer=$aValue['code'];
			$oFtp = ftp_connect($sFtpServer);

			$oResult = ftp_login($oFtp, $aValue['username'], $aValue['password']);
			ftp_pasv($oFtp, true);
			unset($aRow);

			if ((!$oFtp) || (!$oResult)) {
				echo $sFtpServer .":".$aValue['username']." faild";
				return;
			} else {

				if ($aValue['name_folder'] && !$aValue['name_file']) {
					$aRow = ftp_nlist($oFtp, $aValue['name_folder']);
				} elseif ( $aValue['name_folder'] && $aValue['name_file'] ) {
					$aRow[] = $aValue['name_folder']."/".$aValue['name_file'];
				} else {
					$aRow[] = $aValue['name_file'];
				}
			}

			if ($aRow) foreach ($aRow as $sKey => $sValue) {
				$sServerFile=$sValue;
				$sLocalFile = SERVER_PATH.$this->sPathToFile.$iUserId.basename($sServerFile);

				if (ftp_get($oFtp, $sLocalFile, $sServerFile, FTP_BINARY)) {

					$aFilePart = pathinfo($sLocalFile);

					if (in_array(strtolower($aFilePart['extension']),array('zip','rar'))) {
						$aFileExtract=File::ExtractForPrice($sLocalFile,SERVER_PATH.$this->sPathToFile);
					}
					else {
						if (in_array($aFilePart['extension'],$oPrice->aValidateExtensions))
							$aFileExtract[0] = array(
									'name' 	=> basename($sLocalFile),
									'path'	=> $sLocalFile,
							);
					}
					if(Base::GetConstant("price:delete_from_ftp",'1') && $aFileExtract) ftp_delete($oFtp,$sServerFile);
					
					$sError = $oPrice->SaveFilesToQueue($aFileExtract, $sSource = 'ftp');
					if ($sError != '')
						echo Language::GetMessage("Not found profile for uploaded files") . ":<br>\n" . $sError;
				}
			}

			ftp_close($oFtp);
		}
		echo "ok";
	}
	//-----------------------------------------------------------------------------------------------
	public function GetQueueInfoTable() {
		Base::$tpl->assign('iNeedBoldPref', 1);
		$aCat=Price::GetArrayUnknownPref();
		if(!$aCat)
			Base::$tpl->assign('iNeedBoldPref', 0);
		
		$oTable=new Table();
		$oTable->sSql=Base::GetSql("Price/Queue");
		// in work, stopped, ready, done
		$oTable->aOrdered="order by 
				(CASE 
					WHEN is_processed = 1 THEN 0 
				 	WHEN is_processed = 3 THEN 1  
					WHEN is_processed = 0 THEN 2 
					ELSE 3 
				END), pq.post_date desc";
		
		$oTable->aColumn['file_path']=array('sTitle'=>'FileNameOriginal','sWidth'=>'10%');
		$oTable->aColumn['post_date']=array('sTitle'=>'Date','sWidth'=>'15%');
		$oTable->aColumn['pp_name']=array('sTitle'=>'Price profile','sWidth'=>'15%');		
		$oTable->aColumn['up_name']=array('sTitle'=>'Provider','sWidth'=>'15%');
		$oTable->aColumn['source']=array('sTitle'=>'Source','sWidth'=>'15%');
		$oTable->aColumn['progress']=array('sTitle'=>'Progress','sWidth'=>'20%');
		$oTable->aColumn['sum_all']=array('sTitle'=>'All','sWidth'=>'5%');
		$oTable->aColumn['current_string']=array('sTitle'=>'Processed','sWidth'=>'5%');
		$oTable->aColumn['action']=array();
		$oTable->iRowPerPage=50;
		
		$oTable->sDataTemplate=$this->sPrefix.'/row_index.tpl';
		$oTable->sButtonTemplate=$this->sPrefix.'/button_index.tpl';
		$oTable->aCallback=array($this,'CallParseQueue');
		$sQueueTable = $oTable->getTable("Price queue");
		
		//////
		$iUser=Auth::$aUser['id'];
		if (!$iUser) $iUser=1;
		
		$oTable=new Table();
		$oTable->sPrefix='second';
		$oTable->sSql=Base::GetSql("Price/Import",array(
				"id_user_with_1"=>$iUser,
				"where" => " and (pq.is_processed is null or pq.is_processed != 1)",
				"join" => "LEFT JOIN price_queue AS pq ON pq.id = pim.id_price_queue",
		));
		
		$oTable->aColumn=array(
				'code_price_group'=>array('sTitle'=>'price group'),
				'up_name'=>array('sTitle'=>'provider','sWidth'=>'150px'),
				'pref'=>array('sTitle'=>'pref','sWidth'=>'150px'),
				'code'=>array('sTitle'=>'code','sWidth'=>'150px'),
				'cat'=>array('sTitle'=>'cat','sWidth'=>'10%'),
				'part_name'=>array('sTitle'=>'Name','sWidth'=>'50%'),
				'price'=>array('sTitle'=>'Price','sWidth'=>'10%'),
				'post_date'=>array('sTitle'=>'Date','sWidth'=>'20%'),
		);
		$oTable->sDataTemplate='price/row_price_import.tpl';
		$oTable->sButtonTemplate='price/button_price_import.tpl';
		$sPriceImportTable = $oTable->getTable("Buffer price import");
		
		return $sQueueTable . $sPriceImportTable;
	}
	//-----------------------------------------------------------------------------------------------
	public function CallParseQueue(&$aItem)
	{
		$iProgressBarWidth = 200;
		//Debug::PrintPre($aItem);
		foreach ($aItem as $key => $aValue) {
			$aItem[$key]['file_name_original'] = preg_replace("![\\x00-\\x1F]!s","", $aValue['file_name_original']);
			// profile check
			if ($aValue['id_price_profile'] == 0)
				$aItem[$key]['pp_name'] = '<span style="color:red;">'.Language::GetMessage('profile_not_found').'</span>';
			$aItem[$key]['progress'] = '';
			// already worked
			if ($aValue['is_processed'] == 2 && $aValue['date_stop'] != Null and $aValue['date_start'] != Null ) {
				$aItem[$key]['progress'] = DateFormat::NameIntervalDate(DateFormat::Seconds2Times($aValue['date_stop'] - $aValue['date_start']));
				if ($aItem[$key]['progress'] == '')
					$aItem[$key]['progress'] = '1' . Language::GetMessage('sec');
			}
			elseif ($aValue['is_processed'] == 3)
				$aItem[$key]['progress'] .= '<span style="color:red;">' . Language::GetMessage('stopped') . '</span>';
			elseif ($aValue['is_processed'] == 1) {
				$iNewProgressBarWidth = round($aValue['progress'],2) * $iProgressBarWidth / 100;
				$sProgressBar = '<div id="progressBar" name="PB_'.$aValue['id'].'" class="default">
						<div style="width:'.$iNewProgressBarWidth.'px;">'.round($aValue['progress'],2) . '%&nbsp;</div></div>';
				$aItem[$key]['progress'] = $sProgressBar;
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function AsuncLoadQueuePrice($iRedirect = 1)
	{
		
		// start work
		$url = 'http://'.$_SERVER['HTTP_HOST'];
		$params = array('action' => 'cron_minutely_10','is_post' => 1);
		PriceQueue::SendRequest($url, $params);

		// redirect page
		if ($iRedirect == 1)
			Base::Redirect($url . '/?action=price');
	}
	/**
	 * Sends asynchronous post call
	 */
	public function SendRequest($url, $params) {
			foreach ($params as $key => &$val) {
				if (is_array($val)) $val = implode(',', $val);
				$post_params[] = $key.'='.urlencode($val);
			}
			if ($post_params)
				$post_string = implode('&', $post_params);
		
			$parts = parse_url($url);
		
			$fp = fsockopen($parts['host'],
					isset($parts['port'])?$parts['port']:80,
					$errno, $errstr, 30);
		
			$out = "GET /?".$post_string." HTTP/1.1\r\n";
			$out.= "Host: ".$parts['host']."\r\n";
			$out.= "Content-Type: application/x-www-form-urlencoded\r\n";
			$out.= "Content-Length: ".strlen($post_string)."\r\n";
			$out.= "Connection: Close\r\n\r\n";
			$out.= $post_string;
		
			fwrite($fp, $out);
			sleep(1);
			fclose($fp);
	}
	//-----------------------------------------------------------------------------------------------
	public function LoadMessageLog() {
		// get info 
		if (!Base::$aRequest['id'])
			Base::$aRequest['id'] = 0;

		$aResult = $this->BuildMessage(Base::$aRequest['id']);
		
		// build popup
		Base::$oResponse->AddAssign('popup_caption_id','innerHTML', Language::GetMessage('Message information'));
		if (isset($aResult['error']))
			Base::$tpl->assign('sError',$aResult['error']);

		Base::$tpl->assign('sContent',($aResult['content'] ? $aResult['content'] : ''));
		
		Base::$oResponse->AddAssign('popup_content_id','innerHTML',
		Base::$tpl->fetch('price_queue/message.tpl'));
	}
	//-----------------------------------------------------------------------------------------------
	public function BuildMessage($iId = 0,$bIsMailMessage = false) {
		$aResult = array();
		if ($iId == 0)
			$aResult['error'] = Language::GetMessage('Not found information, error id');
		else {
			$aQueueInfo=Base::$db->getRow("select * from price_queue where id='".$iId."'");
			if (!$aQueueInfo['id'])
				$aResult['error'] = Language::GetMessage('Not found information, error id');
			else {
				$aResult['file_name_original'] = $aQueueInfo['file_name_original'];
				$aResult['file_path'] = Base::GetConstant("global:project_url","") . $this->sPathToFile . basename($aQueueInfo['file_path']);
				$aResult['date_upload'] = date("d-m-Y H:i:s",strtotime($aQueueInfo['post_date']));
				$aResult['type_process'] = $aQueueInfo['source'];
				$aResult['date_start'] = '';
				$aResult['time_work'] = '';
				if ($aQueueInfo['date_start'] != Null) {
					$aResult['date_start'] = date("d-m-Y H:i:s",$aQueueInfo['date_start']);
					if ($aQueueInfo['date_stop'] != Null)
						$aResult['time_work'] = DateFormat::NameIntervalDate(DateFormat::Seconds2Times($aQueueInfo['date_stop'] - $aQueueInfo['date_start']));
				}
				$aResult['sum_all'] = $aQueueInfo['sum_all'];
				$aResult['sum_errors'] = $aQueueInfo['sum_errors'];
				$aResult['id_price_profile'] = $aQueueInfo['id_price_profile'];
				$aResult['name_profile'] = '';
				if ($aQueueInfo['id_price_profile'] != 0) {
					$sProfile = Base::$db->getRow("select * from price_profile where id=".$aQueueInfo['id_price_profile']);
					$aResult['name_profile'] .= $sProfile['name'];
				}	
	
				$sLimit = " limit ".Base::GetConstant("price:view_count_error","200");
				
				// get data
				$aData=Db::GetAll("Select * from log_price_queue where id_price_queue=".$iId.$sLimit);
				// build data table
				foreach ($aData as $iKey => $aValue) {
					if (is_array($aString = json_decode(base64_decode($aValue['input_data']),1))) {
						$sData = '';
						foreach ($aString as $iKey1 => $aValue1)
							$sData .= '['.$iKey1.'] => '.$aValue1.'<br>';
						$aData[$iKey]['table_data'] = $sData;
					}
				}
				$aTextTemplate=String::GetSmartyTemplate('error_load_price', array(
						'aInformation'=>$aResult,
						'aData'=>$aData,
				));
				$aResult['content'] = $aTextTemplate['parsed_text'];							
			}
		}
		return $aResult;
	}
	//-----------------------------------------------------------------------------------------------
	public function GetProfile($sType = 'mail', $sFileName = '', $sSubject = '', $sFrom = '') {
		$aPriceProfile=Db::GetAll(Base::GetSql("Price/Profile"));

		foreach ($aPriceProfile as $sKey1 => $aValue1) {
			if ($aValue1['file_name'] == '') 
				continue;
			
			if ($sType == 'mail') {
				if (($aValue1['email'] || $aValue1['email2']|| $aValue1['email3']|| $aValue1['email4']|| $aValue1['email5'])
					&& (mb_strpos(" ".$sSubject, $aValue1['email']) !== false 
						|| ($aValue1['email'] && mb_strpos(" ".$sFrom, $aValue1['email']) !== false)
						|| ($aValue1['email2'] && mb_strpos(" ".$sFrom, $aValue1['email2']) !== false)
						|| ($aValue1['email3'] && mb_strpos(" ".$sFrom, $aValue1['email3']) !== false)
						|| ($aValue1['email4'] && mb_strpos(" ".$sFrom, $aValue1['email4']) !== false)
						|| ($aValue1['email5'] && mb_strpos(" ".$sFrom, $aValue1['email5']) !== false)
					)
					&&  (mb_strpos($sFileName, $aValue1['file_name']) !== false)) 
				{
					return $aValue1;
				}	
			}
			elseif ($sType == 'ftp') {
				if (mb_strpos($sFileName, $aValue1['file_name']) !== false) {
					return $aValue1;
				}
			}	
		}
		return false;	
	}
}
?>
