<?
/**
 * Loader price
 * @author Oleksandr Starovoit
 *
 */

class Price extends Base {
	var $sPrefix="price";
	var $oCatalog;
	var $rs;
	var $exchange_facrot;
	var $aPref;
	var $aParserPatern;
	var $aParserBefore;
	var $aParserAfter;
	var $aTrimLeft;
	var $aTrimRight;
	var $aPrefName;
	var $aPriceGrp;
	var $aValidateExtensions = array('csv','txt','xls','xlsx','zip','rar');

	//-----------------------------------------------------------------------------------------------
	public function __construct()
	{
		if (strpos(Base::$aRequest['action'],"cron_")===false) {
			Auth::NeedAuth('manager');
			Base::$aData['template']['bWidthLimit']=false;
		}
		require_once(SERVER_PATH.'/class/module/Catalog.php');
		$this->oCatalog = new Catalog();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		Base::Message();

		$this->sPrefixAction=$this->sPrefix;
		Base::$aTopPageTemplate=array('panel/tab_price.tpl'=>$this->sPrefixAction);

		$a[""]="";
		Base::$tpl->assign('aPrice_profile', Db::GetAssoc("Assoc/PriceProfile",array("order"=>" order by pp.name ")));

		if($this->GetArrayUnknownPref()){
			Base::$sText.="<div class='warning_p'>".Language::GetMessage('Price with empty pref')."</div>";
		}
		
		$iMaxSize = String::ParseSize(ini_get('post_max_size'));
		$iMaxSizeUpload = String::ParseSize(ini_get('upload_max_filesize'));
		if ($iMaxSizeUpload > 0 && $iMaxSizeUpload < $iMaxSize) {
			$iMaxSize = $iMaxSizeUpload;
		}
		Base::$tpl->assign('iMaxSize',String::FormatSize($iMaxSize));
		
		$aData=array(
		'sHeader'=>"method=post enctype=\"multipart/form-data\"" ,
		'sHidden'=>"<input type=hidden name=\"style\" value='segment'>",
		'sContent'=>Base::$tpl->fetch('price/index.tpl'),
		'sSubmitButton'=>'price_load',
		'sSubmitAction'=>'price_load',
		'sError'=>$sError,
		);
		
		$oForm=new Form($aData);
		Base::$sText.=$oForm->getForm();
		
		Base::$bXajaxPresent=true;
		// ajax refresh table	
		Base::$sText .= '<script type="text/javascript">
							$(document).ready(function() {
								var iIdInterval;
								iIdInterval = setInterval("refresh_queue();", 10000);
								document.cookie = "iIdInterval="+iIdInterval+";path=/";
							});
						</script>';
		
		$oPriceQueue = new PriceQueue();
		Base::$sText .=  '<div id="refresh_table">'. $oPriceQueue->GetQueueInfoTable() . '</div>'; // div - refresh

	}
	//-----------------------------------------------------------------------------------------------
	public function LoadFromFile()
	{
		static $aPriceProfileAll;
		
		mb_internal_encoding("UTF-8");
		
		$oPriceQueue = new PriceQueue();
		
		if (!$aPriceProfileAll)
			$aPriceProfileAll=Db::GetAll(Base::GetSql("Price/Profile",array('where'=>" and pp.name_file is not null and pp.name_file<>''")));
		
		set_time_limit(0);
		
        // check and create directory
        if (!file_exists(SERVER_PATH.$oPriceQueue->sPathToFile)) {
        	if (!mkdir(SERVER_PATH.$oPriceQueue->sPathToFile, 0770))
            	$sMessage="&aMessage[MF_ERROR]=".Language::GetMessage("Error save file to destination. Access denied create directory.");
        }
        if (!$sMessage && !is_writable(SERVER_PATH.$oPriceQueue->sPathToFile)) {
        	$sMessage="&aMessage[MF_ERROR]=".Language::GetMessage("Error save file to destination. Access denied.");
        }
                
        if ($sMessage && $sMessage != '') {
        	$this->Redirect("?action=price".$sMessage);
            return;
        }

        $aResult = File::CheckFileUpload($_FILES['excel_file']);
        if ($aResult['sMessage'] && $aResult['iError'] > 0) {
        	$this->Redirect("?action=price&aMessage[MF_ERROR]=".$aResult['sMessage']);
        	return;
        }
        
		if(isset($_FILES['excel_file']) && $_FILES['excel_file']['tmp_name'] != '') {
			$sUploadedFile = $_FILES['excel_file']['tmp_name'];
			$aUploadFilePart = pathinfo($_FILES['excel_file']['name']);
			$sUploadFileName=$aUploadFilePart['filename'].'.'.strtolower($aUploadFilePart['extension']);
			$sLocalFile = SERVER_PATH.$oPriceQueue->sPathToFile.Auth::$aUser['id'].$sUploadFileName;
			$sFileNameOriginal = $_FILES['excel_file']['name'];
			
			if (!@move_uploaded_file($sUploadedFile, $sLocalFile)) {
				$sMessage="&aMessage[MF_ERROR]=".Language::GetMessage("Error uploaded file to destination.");
				$this->Redirect("?action=price".$sMessage);
			}
			
            $aFilePart = pathinfo($sLocalFile);

            if (in_array(strtolower($aFilePart['extension']),array('zip','rar'))) {
            	$aFileExtract=File::ExtractForPrice($sLocalFile,SERVER_PATH.$oPriceQueue->sPathToFile);                
			}
			else {
				if (in_array(strtolower($aFilePart['extension']),$this->aValidateExtensions)) 
					$aFileExtract[0] = array(
						'name' 	=> basename($sLocalFile),
						'path'	=> $sLocalFile,
					);
			}
		}
        else {
        	$sMessage="&aMessage[MF_ERROR]=".Language::GetMessage("Not files for loading");
        	$this->Redirect("?action=price".$sMessage);
        	return;
        }
        $sValidExtensions = '';
        foreach ($this->aValidateExtensions as $sValue) {
			if ($sValidExtensions != '')
				$sValidExtensions .= ', ';
        	$sValidExtensions .= $sValue;
        }
        
        if (!$aFileExtract || count($aFileExtract) == 0) {	
        	$sMessage="&aMessage[MF_ERROR]=".Language::GetMessage("Not files for loading. Upload files this extensions") . 
        				": " . $sValidExtensions;
        	$this->Redirect("?action=price".$sMessage);
        	return;
        }
        $sErrorProfile = $this->SaveFilesToQueue($aFileExtract, $sSource = 'upload', $iProfile_id = Base::$aRequest['u']['id_price_profile']);
 
        // start asunc process
        PriceQueue::AsuncLoadQueuePrice(0);
        
        if ($sErrorProfile != "") {
        	$sMessage="&aMessage[MF_ERROR]=".Language::GetMessage("Not found profile for uploaded files") .":<br>". $sErrorProfile;
        	$this->Redirect("?action=price".$sMessage);
        	return;
        }

        $sMessage="&aMessage[MF_NOTICE]=".Language::GetMessage("Price uploaded successfully. Wait processing.");
        $this->Redirect("?action=price".$sMessage);
	}
	//-----------------------------------------------------------------------------------------------
	//TODO change logic
	//	public function LoadFromFileCron() {
	//		set_time_limit(0);
	//
	//		$fl=$this->getFilesFromDir("/imgbank/price/");
	//
	//		if (is_array($fl)) {
	//			sort($fl);
	//			foreach ($fl as $files) {
	//				$a=explode("_",$files['name']);
	//
	//				if (count($a)>1) {
	//					$aPrice_profile=Base::$db->getRow("select * from price_profile where name_file='".$a[0]."'");
	//					$iMax=Base::$db->getOne("select ifnull(max(id),0) as iMax from price_import");
	//
	//					switch ($aPrice_profile['type_']) {
	//						case "csv":
	//							$this->LoadFromCsv($files,$aPrice_profile,$iUser=0);
	//							break;
	//					}
	//
	//					Base::$db->Execute("delete from price_import where cat='' and id>".$iMax);
	//
	//					$this->removeFileToDir($files,"/imgbank/price/log/");
	//					//break;
	//				}
	//			}
	//		} else {
	//			return false;
	//		}
	//	}
	//-----------------------------------------------------------------------------------------------
	public function InitLoader($aPrice_profile)
	{
		$this->exchange_facrot=1;
		$aPrice_profile['replace_stock']=html_entity_decode($aPrice_profile['replace_stock']);
		if ($aPrice_profile['replace_stock'] && strpos($aPrice_profile['replace_stock'],"=>")) {
			$aReplace=explode("=>",$aPrice_profile['replace_stock']);
			$this->aReplaceStock1=explode(",",$aReplace[0]);
			$this->aReplaceStock2=explode(",",$aReplace[1]);
		}
		$this->rs=Base::$db->SelectLimit("select * from price_import",1);
		$this->aPref=Base::$db->getAssoc("select UPPER(cp.name),c.pref from cat_pref cp inner join cat c on c.id=cp.cat_id");
		$this->aParserPatern=Base::$db->getAssoc("select pref,parser_patern from cat");
		$this->aParserBefore=Base::$db->getAssoc("select pref,parser_before from cat");
		$this->aParserAfter=Base::$db->getAssoc("select pref,parser_after from cat");
		$this->aTrimLeft=Base::$db->getAssoc("select pref,trim_left_by from cat");
		$this->aTrimRight=Base::$db->getAssoc("select pref,trim_right_by from cat");
		$this->aPrefName=Base::$db->getAssoc("select id,UPPER(name) from cat_pref");
		if ($aPrice_profile['id_provider']) {
			$this->aPriceGrp=Db::GetAssoc("select concat(pref,'_',code) as id, coef
			from price_grp where id_user_provider=".$aPrice_profile['id_provider']);
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function LoadFromExcel($files,$aPrice_profile,$iUser=0,$iPriceQueue=0)
	{	
		register_shutdown_function("dbg_last_error",$iPriceQueue);
			
		ini_set("memory_limit",Base::GetConstant("global:price_load_excel_memory_limit","4G"));
		
		// for build message
		$iMaxCountCol = 0;

		$this->CheckStoppedLoadPrice($iPriceQueue);
		
		if ($aPrice_profile['id_provider']==0) {
			$aProvider=Base::$db->getAssoc("select login, id from user where type_='provider'");
		}
		
		// get data from first list
		if ($aPrice_profile['list_count'] == 0)
			$aPrice_profile['list_count'] = 1;
		
		$this->InitLoader($aPrice_profile);

		$sStep = Language::GetMessage('Get count input data');
		Db::Execute("update price_queue set date_progress = ".time().", step = '".$sStep."', progress = 0.01 where id = ".$iPriceQueue);
		$iAllStrings = 0;
/*
		if ($aPrice_profile['type_']=='excel95') {
			$oExcel= new Excel();
			$oExcel->ReadExcel5($files['path'],true);
			for ($iList=0;$iList<$aPrice_profile['list_count'];$iList++){
				$oExcel->SetActiveSheetIndex($iList);
				$aData=$oExcel->GetSpreadsheetData();
				foreach ($aData as $sKey => $aValue) {
					if ($aPrice_profile['row_start']>$sKey) continue;
					$this->LoadPrice($aValue,$aPrice_profile,$aProvider,$iUser,$iPriceQueue);
				}
			}
		} else*/
		if ($aPrice_profile['type_']=='xlsx'){
			switch (Base::GetConstant("price:type_load","all")) {
				case 'all':$iCountError = $this->LoadFromXlsxAll($iPriceQueue, $iMaxCountCol, $files, $aPrice_profile, $aProvider, $iUser);break;
				case 'partial':$iCountError = $this->LoadFromXlsxPartial($iPriceQueue, $iMaxCountCol, $files, $aPrice_profile, $aProvider, $iUser);break;
			}
		} else {
			require_once("excel/reader.php");
			unset($data);
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('UTF-8');
			$data->read($files['path']);
			
			if ($data->_ole->error) {
			    $sMessage = Language::GetMessage('error get data from file'); 
			    Db::Execute("insert into log_price_queue (id_price_queue, input_data, error_message, list, row) VALUES
				(".$iPriceQueue.",'','".$sMessage."','0','0')");
			    Db::Execute("update price_queue set date_progress = ".time().", progress = '100', sum_errors = '1', current_string = '0' where id = ".$iPriceQueue);
			    return 1;
			}
			// get count
			for ($iList=0;$iList<$aPrice_profile['list_count'];$iList++){
				if ($data->sheets[$iList]['numRows'] != 0)
					$tot = $data->sheets[$iList]['numRows']; 
				// numRows maybe = 0 
				else 
					$tot = count($data->sheets[$iList]['cells']);
				$iAllStrings += $tot;
			}
			// parse data
			$iAllStringsTotal = 0;
			$iCountError = 0;
			$sStep = Language::GetMessage('Get input data');
			Db::Execute("update price_queue set date_progress = ".time().", step = '".$sStep."', sum_all = ".$iAllStrings.
			" where id = ".$iPriceQueue);
			for ($iList=0;$iList<$aPrice_profile['list_count'];$iList++){
				$iAllStringsCurrentList = 0;
				$iAllStringsCurrentList += ($aPrice_profile['row_start'] == 0) ? 0 : ($aPrice_profile['row_start'] - 1);
				$iAllStringsTotal += ($aPrice_profile['row_start'] == 0) ? 0 : ($aPrice_profile['row_start'] - 1);
				for( $i=$aPrice_profile['row_start']; $i <= ($data->sheets[$iList]['numRows'] != 0 ? $data->sheets[$iList]['numRows'] : count($data->sheets[$iList]['cells'])); $i++) {
					$iAllStringsCurrentList += 1;
					$iAllStringsTotal += 1;
					if ($iMaxCountCol < ($j=count($data->sheets[$iList]['cells'][$i])))
						$iMaxCountCol = $j;
					$aResult = $this->LoadPrice($data->sheets[$iList]['cells'][$i],$aPrice_profile,$aProvider,$iUser,$iPriceQueue);
					$this->SaveToLog($aResult, $iAllStringsCurrentList, $iAllStringsTotal, $iAllStrings, $iCountError, $iList, $iPriceQueue, $data->sheets[$iList]['cells'][$i], $aPrice_profile);
				}
			}

		}
		Db::Execute("update price_queue set max_count_col = ".$iMaxCountCol." where id = ".$iPriceQueue);
		return $iCountError;
	}
	//-----------------------------------------------------------------------------------------------
	public function LoadFromCsv($files,$aPrice_profile,$iUser=0,$iPriceQueue=0) {
		$iMaxCountCol = 0;
		// check stopped
		$this->CheckStoppedLoadPrice($iPriceQueue);

		if ($aPrice_profile['id_provider']==0) {
			$aProvider=Base::$db->getAssoc("select login, id from user ");
		}

		$this->InitLoader($aPrice_profile);

		/*if (strtoupper($aPrice_profile['charset'])=="UTF-8"
		|| strtoupper($aPrice_profile['charset'])=="UTF8" ) {
			setlocale(LC_CTYPE,"ru_RU.utf8");
		}

		$handle = fopen($files['path'], "r");
		*/
		setlocale(LC_CTYPE,"ru_UA.utf8","ru_RU.utf8","utf8");
		$handle = fopen('php://memory', 'w+');
		if (strtoupper($aPrice_profile['charset'])=="UTF-8"
		|| strtoupper($aPrice_profile['charset'])=="UTF8" ) {
			fwrite($handle, file_get_contents($files['path']));
			rewind($handle);
		}else{
			fwrite($handle, iconv($aPrice_profile['charset'], 'UTF-8', file_get_contents($files['path'])));
			rewind($handle);
		}
		$aPrice_profile['charset'] = '';
		
		if ($aPrice_profile['delimiter']=="tab") {
			$sDelimiter="\t";
		} elseif ($aPrice_profile['delimiter']==",") {
			$sDelimiter=",";
		} elseif ($aPrice_profile['delimiter']=="|") {
			$sDelimiter="|";
		} else {
			$sDelimiter=";";
		}

		// get count
		$sStep = Language::GetMessage('Get count input data');
		Db::Execute("update price_queue set date_progress = ".time().", step = '".$sStep."', progress = 0.01 where id = ".$iPriceQueue);
		$iAllStrings = 0;
		while (($data = fgetcsv($handle, 2000, $sDelimiter)) !== FALSE) 
			$iAllStrings++;
		
		$iCountError = 0;
		$sStep = Language::GetMessage('Get input data');
		Db::Execute("update price_queue set date_progress = ".time().", step = '".$sStep."', sum_all = ".$iAllStrings.
						" where id = ".$iPriceQueue);
		fseek($handle, 0);
		$i = 0;
		while (($data = fgetcsv($handle, 2000, $sDelimiter)) !== FALSE) {
			$i++; if ($aPrice_profile['row_start']>$i) continue;
			if ($iMaxCountCol < ($j=count($data)))
				$iMaxCountCol = $j;
			$aResult = $this->LoadPrice($data,$aPrice_profile,$aProvider,$iUser,$iPriceQueue);
			$this->SaveToLog($aResult, $i, $i, $iAllStrings, $iCountError, $iList = -1, $iPriceQueue, $data, $aPrice_profile);
		}
		
		fclose($handle);
		Db::Execute("update price_queue set max_count_col = ".$iMaxCountCol." where id = ".$iPriceQueue);
		return $iCountError;
	}
	//-----------------------------------------------------------------------------------------------
	public function LoadFromText($files,$aPrice_profile,$iUser=0,$iPriceQueue=0) {
		$rs=Base::$db->SelectLimit("select * from price_import",1);
		$aPref=Base::$db->getAssoc("select UPPER(cp.name),c.pref from cat_pref cp inner join cat c on c.id=cp.cat_id");
		$aPrefName=Base::$db->getAssoc("select id,UPPER(name) from cat_pref");

		$handle = fopen($files['path'], "r");
		
		$i=0;
		while (($data = fgets($handle, 255)) !== FALSE) {
			$i++; if ($aPrice_profile['row_start']>$i) continue;
			unset($u);
			$u['pref']=trim(substr($data,0,9));
			$u['code']=str_replace(array(" ","-","#"), array("","",""), substr($data,9,21));

			$name=trim(substr($data,30,51));
			$u['part_eng']=trim(substr($data,103,100));
			if ($u['part_eng']=="") {
				if (preg_match('/[A-Za-z]+/',$name)) {
					$u['part_eng']=$name;
				} else {
					$u['part_rus']=$name;
				}
			} else {
				$u['part_rus']=$name;
			}

			$u['price']=trim(str_replace(",",".",substr($data,81,20)));
			$u['code_in']=trim(str_replace(",",".",substr($data,204,4)));
			$u['code'] = trim($u['code']);
			$u['item_code']=$u['pref']."_".$u['code'];

			$u['code_currency']='RUB';
			//$u['post']=time();
			//$u['id_provider']=$aPrice_profile['id_provider'];
			$u['id_user']=1;

			if ($u['code']!="" and $u['code_in']!="") {
				//Base::$db->AutoExecute("price_import",$u);
				Base::$db->Execute(Base::$db->GetInsertSQL($rs,$u));
			}
		}
		fclose($handle);
	}
	//-----------------------------------------------------------------------------------------------
	public function LoadPrice($data,$aPrice_profile,$aProvider,$iUser,$iPriceQueue) {
		static $sPrefMers, $aProviderCode, $aMassStock;

		$this->CheckStoppedLoadPrice($iPriceQueue);
		
		if (!$sPrefMers)
			$sPrefMers = Db::GetOne("SELECT pref FROM `cat` WHERE id_tof = 553"); // MERCEDES || MERCEDESBENZ

		if (!$aProviderCode){
			$aProviderCode = Db::GetAssoc("SELECT up.code_name, up.id_user
				FROM `user_provider` up
				INNER JOIN user u ON u.id = up.id_user
				WHERE u.type_ = 'provider'");
		}

		$ii=1;
		if ($aPrice_profile['type_']=="xls"||$aPrice_profile['type_']=="xlsx") {
			$ii=0;
			if (isset($data[0]))
				$ii = 1;
		}
		
		$iTermMulti = 0;
		$aTermMulti = explode(';',$aPrice_profile['col_term']);
		if (count($aTermMulti) > 1) {
			foreach($aTermMulti as $iKey => $sValue) {
				// rewrite value
				$aTermMulti[$iKey] = $this->ConvertToInteger($sValue);
			}
			$iTermMulti = 1;
		}
		
		foreach ($aPrice_profile as $k => $v) {
			if ($k == 'col_term' && $iTermMulti) {
				foreach($aTermMulti as $iKey => $iValue) {
					if($iValue!=0 && isset($data[$iValue-$ii])){
						if ($aPrice_profile['charset']) {
							$u['term'.$iKey]=iconv($aPrice_profile['charset'],Base::$aGeneralConf['Charset'],$data[$iValue-$ii]);
						} else
							$u['term'.$iKey]=$data[$iValue-$ii];
					}
				}
				// recheck all terms and set term end get min value
				$u['term'] = 0;
				foreach($aTermMulti as $iKey => $iValue) {
					if (isset($u['term'.$iKey]) && ($u['term'] == 0 || $u['term'] < $u['term'.$iKey]) )
						$u['term'] = $u['term'.$iKey]; 
				}
			}
			else {
				// rewrite value
				$v = $this->ConvertToInteger($v);
				
				if( strpos($k,"col_")!==false && $v!=0 && isset($data[$v-$ii])){
					if ($aPrice_profile['charset']) {
						$u[str_replace("col_","",$k)]=iconv($aPrice_profile['charset'],Base::$aGeneralConf['Charset'],$data[$v-$ii]);
					} else 
						$u[str_replace("col_","",$k)]=$data[$v-$ii];
				}
			}
		}

		//		Debug::PrintPre($u['price'],false);
		//		for ($i=0;$i<=strlen($u['price']);$i++){
		//			Debug::PrintPre(ord(substr($u['price'],$i,1)),false);
		//		}
		
		$u['price']=trim(str_replace(" ",'',str_replace(",",".",$u['price'])));
		$u['code']=$this->oCatalog->StripCode($u['code_name']);
		$u['code_name']=$this->oCatalog->StripCode($u['code_name']);
		$u['crs']=$this->oCatalog->StripCode($u['crs']);
		$u['code_price_group']=$this->oCatalog->StripCode($u['grp']);
		$u['update_group']=$aPrice_profile['update_group'];

		if ($aPrice_profile['pref']!="") {
			$u['pref']=$u['cat']=$aPrice_profile['pref'];
			$u['item_code']=$u['pref']."_".$u['code'];
		} else {
			$u['cat']=trim(mb_strtoupper($u['cat']));

			if (in_array($u['cat'],$this->aPrefName)) {

				$u['pref']=$this->aPref[$u['cat']];
				if ($u['pref']!="") {
					$u['item_code']=$u['pref']."_".$u['code'];
				}

			} else {

				$u['pref']="";
				$this->aPrefName[]=$u['cat'];
				$this->aPref[$u['cat']]="";
				if (trim($u['cat'])!="") Db::Execute("insert ignore into cat_pref (name) values (upper('".mysql_real_escape_string($u['cat'])."'))");
			}
		}
		if($this->aParserPatern[$u['pref']] || $this->aParserBefore[$u['pref']] || $this->aParserAfter[$u['pref']] 
			|| $this->aTrimLeft[$u['pref']] || $this->aTrimRight[$u['pref']]) {

			if($this->aParserPatern[$u['pref']])
			$sCode=trim(preg_replace('/.*('.$this->aParserPatern[$u['pref']].').*/','\1',$u['code_name']));
			if($this->aParserBefore[$u['pref']]){
				if(!$sCode) $sCode=$u['code_name'];
				$sCode=trim(preg_replace('/^('.$this->aParserBefore[$u['pref']].')(.*)/','\2',$sCode));
			}
			if($this->aParserAfter[$u['pref']]){
				if(!$sCode) $sCode=$u['code_name'];
				$sCode=trim(preg_replace('/('.$this->aParserAfter[$u['pref']].')(.*)/','\2',$sCode));
			}
			if($this->aTrimLeft[$u['pref']]){
				if(!$sCode) $sCode=$u['code_name'];
				$iPos=strpos($sCode,$this->aTrimLeft[$u['pref']]);
				if($iPos!==FALSE) $sCode=substr($sCode,$iPos+1);
			}
			if($this->aTrimRight[$u['pref']]){
				if(!$sCode) $sCode=$u['code_name'];
				$iPos=strpos($sCode,$this->aTrimRight[$u['pref']]);
				if($iPos!==FALSE) $sCode=substr($sCode,0,$iPos);
			}
			if($sCode){
				$u['code_name']=$sCode;
				$u['code']=$this->oCatalog->StripCode($u['code_name']);
				$u['item_code']=$u['pref']."_".$u['code'];
			}
		}

		if ($sPrefMers && $sPrefMers==$u['pref']) {
			$u['code']=ltrim($u['code'],'A');
			$u['crs']=ltrim($u['crs'],'A');
			$u['item_code']=$u['pref']."_".$u['code'];
		}

		if ($u['pref'] && $u['crs']) $u['item_code_crs']=$u['pref']."_".$u['crs'];

		//	$u['code_currency']=$aPrice_profile['code_currency'];
		//	if ($this->exchange_facrot!=1) $u['price']=$this->exchange_facrot*$u['price'];
		//  $u['post']=time();

		if ($aPrice_profile['id_provider']==0) $u['id_provider']=$aProvider[trim($u['provider'])];
		else $u['id_provider']=$aPrice_profile['id_provider'];

		$u['id_user']=$iUser;

		/*
		if (!$aPrice_profile['col_stock']) {
		$u['stock']=Base::GetConstant("price:stock",2);
		} elseif (!$u['stock']) {
		$u['stock']="0";
		}

		if ($this->aReplaceStock1 && $this->aReplaceStock2) {
		$u['stock']=str_replace($this->aReplaceStock1,$this->aReplaceStock2,$u['stock']);
		}

		if ($aPrice_profile['col_term_wait'] && !$u['term'] && $u['term_wait']) {
		$u['term']=Base::GetConstant("price:term_wait",30);
		}
		*/
		$u['id_price_queue']=$iPriceQueue;

 		// check associate with group
 		if ($aPrice_profile['is_check_assoc_group'] && $u['code_price_group'] == '') {
 			if(Base::GetConstant('price:delayed_associate','1'))
				$u['is_delayed_associate'] = 1; 
 			else
 				$u['code_price_group'] = $this->FindAssociate($u);
 		}

 		if ($aPrice_profile['assoc_stock'] != '' && !isset($aMassStock))
 			$aMassStock = explode(';',$aPrice_profile['assoc_stock']);

		if ($u['code']!="" && $u['cat']!="" && ($u['id_provider']>0 || count($aMassStock) > 0)) {
			$i=0;
			while (1) {
				// check
				if (count($aMassStock) > 0) {
					if ($i >= count($aMassStock))
						break;
					list($sCol,$sLogin) = explode("/",trim($aMassStock[$i]));
					$sCol = trim($sCol);
					$sLogin = trim($sLogin);
					// check exist code provider
					if (!$aProviderCode[$sLogin]) {
						$i += 1;
						continue;
					}

					$v = $this->ConvertToInteger($sCol);
					if( $v!=0 && isset($data[$v-$ii])){
						$u['stock']=trim($data[$v-$ii]);
						$u['id_provider']=$aProviderCode[$sLogin];
							
						if ($u['stock'] == '' or $u['stock'] == '0') {
							$u['stock'] = 0;
							//$i += 1;
							//continue;
						}
					}
					else {
						$i += 1;
						continue;
					}
				}			
				//$aTmp=array("supplier","price","price1","price2","price3","price4","price5","price6","discount","weight");
				$aTmp=array("supplier","price","price6","discount","weight");
				foreach ($aTmp as $v1) $u[$v1]=String::GetDecimal($u[$v1]);
	
				if ($aPrice_profile['is_grp'] && $u['price6']!='') {
					if ($u['grp'] && $this->aPriceGrp[$u['pref']."_".$u['grp']]) $dGrpCoef=$this->aPriceGrp[$u['pref']."_".$u['grp']];
					else $dGrpCoef=1;
	
					$u['price']=$aPrice_profile['coef_price']*$u['price6']*$dGrpCoef*$aPrice_profile['coef'];
	
					/*
					$u['price1']=$aPrice_profile['coef_price1']*$u['price6']*$dGrpCoef*$aPrice_profile['coef'];
	
					$u['price2']=$aPrice_profile['coef_price2']*$u['price1'];
					$u['price3']=$aPrice_profile['coef_price3']*$u['price1'];
					$u['price4']=$aPrice_profile['coef_price4']*$u['price1'];
					$u['price5']=$aPrice_profile['coef_price5']*$u['price1'];
					*/
					Base::$db->Execute(Base::$db->GetInsertSQL($this->rs,$u));
				} else {
					$u['price']=$aPrice_profile['coef']*$u['price'];
					$u['price1']=0;
					Base::$db->Execute(Base::$db->GetInsertSQL($this->rs,$u));
				}
				if (!$aMassStock)
					break;
				$i += 1;
			} // while
		}
		return $u;
	}

	//-----------------------------------------------------------------------------------------------
	public function Install($bRedirect=true) {
		set_time_limit(0);
	/*  work with all and ignore in process = 1
	 	if ($bCheckIsLoad && Base::GetConstant("price:is_load",0) == 1) {
			$sMessage="&aMessage[MI_ERROR]=Now is loading"; //or not files for loading
			if($bRedirect)$this->Redirect("?action=price".$sMessage);
		}
		else {
			if ($bCheckIsLoad && Base::GetConstant("price:is_load",0) == 0) 
				Base::UpdateConstant("price:is_load",1);
	*/		
			// not delete all records
			//Base::$db->Execute("delete from price_import where (pref='' or pref is null) and (id_user='".Auth::$aUser['id']."' or id_user=1)");

			Db::Execute("update price_import as pim
			inner join price_group as pg on pim.code_price_group=pg.code
			set pim.id_price_group=pg.id");


			/*-[- for add cross-zamena --*/
			if (0) {
				Db::Execute("
			insert ignore into cat_cross (pref, code, pref_crs, code_crs)
			select pref, code, pref, crs
			from price_import
			where crs<>'' and code<>crs and id_user=".Auth::$aUser['id']."
			union all
			select  pref, crs, pref, code
			from price_import
			where crs<>'' and code<>crs and id_user=".Auth::$aUser['id']
			);
			}
			/*-]- for add cross-zamena --*/

			Base::$db->Execute(" insert into price
				  (item_code, id_provider, code, cat, part_rus, part_eng, price, code_in, pref, description, stock, term, grp, number_min, is_restored, is_delayed_associate)
			select item_code, id_provider, code, cat, part_rus, part_eng, price, code_in, pref, description, stock, term, grp, number_min, is_restored, is_delayed_associate
			from price_import as t
			LEFT JOIN price_queue AS pq ON pq.id = t.id_price_queue 
			where (pq.is_processed is null or pq.is_processed != 1) and (t.id_user='".Auth::$aUser['id']."' or t.id_user=1) and (pref is not null and pref != '') 
			on duplicate key update price=values(price)
			, part_rus=values(part_rus), part_eng=values(part_eng), code_in=values(code_in), description=values(description)
			, term=values(term), stock=values(stock), grp=values(grp), number_min=values(number_min), is_restored=values(is_restored), is_delayed_associate=values(is_delayed_associate) "
			);

		/*add price group*/
		/* not use now - only price_group_assign Db::Execute("insert ignore into price_group_pref (id_price_group, pref)
		select id_price_group, pref
		from price_import as t
		LEFT JOIN price_queue AS pq ON pq.id = t.id_price_queue
		where (pq.is_processed is null or pq.is_processed != 1) and (t.id_user='".Auth::$aUser['id']."') and (pref is not null and pref != '') and id_price_group is not null and id_price_group<>'' group by id_price_group, pref");
		*/
		//if(!Base::GetConstant('price:delayed_associate','0')){
			Db::Execute("insert into price_group_assign (item_code,id_price_group) 
					select item_code,id_price_group from price_import where update_group>0 and is_delayed_associate=0 and id_price_group>0
					on duplicate key update id_price_group = values(id_price_group) ");
		//}
		
/*
			if ($bCheckIsLoad && Base::GetConstant("price:is_load",0) == 1) 
				Base::UpdateConstant("price:is_load",0);
*/
			$sMessage="&aMessage[MI_NOTICE]=Price installed successful";
			$this->ClearImport($sMessage,$bRedirect,$sType = 'ignore_empty');
	}
	//-----------------------------------------------------------------------------------------------
	public function ConformityApply() {

		if (is_array(Base::$aRequest['u'])) {
			foreach (Base::$aRequest['u'] as $k => $v) {
				if ($v!="") {
					$iCatId=Db::GetOne("select id from cat where pref='".$v."'");
					Base::$db->AutoExecute("cat_pref", array('pref'=>$v,'cat_id'=>$iCatId) , "UPDATE", "id=".$k, true, true);
				}
			}
		}elseif(Base::$aRequest['action']=='price_conformity_auto'){
			$a=Base::$db->getAssoc("select id, name from cat_pref where cat_id=0 order by name");
			foreach ($a as $iKey => $sValue) {
			    $sCatName=mb_strtoupper(str_replace(array(' ','-','#','.','/',',','_',':','[',']','(',')','*','&','+','`','\'','"','\\','<','>','?','!','$','%','^','@','~','|','=',';','{','}','№'), '', trim(Content::Translit($sValue))),'UTF-8');
				$iCatId=Db::GetOne("select id from cat where title like '".mysql_real_escape_string($sValue)."' or name like '".$sCatName."' ");
				if(!$iCatId){
				$sPref=String::GeneratePref();
				$iCatId=0;
				Db::AutoExecute("cat", array(
					'pref'=>$sPref,
					'name'=>$sCatName,
					'title'=>mysql_real_escape_string($sValue),
					) 
				);
				$iCatId=Db::InsertId();
				}
				Base::$db->AutoExecute("cat_pref", array('pref'=>$sPref,'cat_id'=>$iCatId) , "UPDATE", "id=".$iKey, true, true);
			}
			$sMessage="&aMessage[MT_NOTICE]=Brands added successful";
		}

		Base::$db->Execute("
		update price_import
		join cat_pref on price_import.cat=cat_pref.name
		join cat on cat_pref.cat_id=cat.id
		set price_import.pref=cat.pref, price_import.item_code=concat(cat.pref,'_',price_import.code)
		where cat.pref is not null and price_import.pref='' or price_import.pref is null
		");

		$this->Redirect("?action=price".$sMessage);
	}
	//-----------------------------------------------------------------------------------------------
	public function AutoAssocCat() {

        $a=Base::$db->getAssoc("select id, name from cat_pref where cat_id=0 order by name");
        foreach ($a as $iKey => $sValue) {
            $sCatName=mb_strtoupper(str_replace(array(' ','-','#','.','/',',','_',':','[',']','(',')','*','&','+','`','\'','"','\\','<','>','?','!','$','%','^','@','~','|','=',';','{','}','№'), '', trim(Content::Translit($sValue))),'UTF-8');
            $iCatId=Db::GetOne("select id from cat where title like '".mysql_real_escape_string($sValue)."' or name like '".$sCatName."' ");
            if(!$iCatId){
                $sPref=String::GeneratePref();
                $iCatId=0;
                Db::AutoExecute("cat", array(
                    'pref'=>$sPref,
                    'name'=>$sCatName,
                    'title'=>mysql_real_escape_string($sValue),
                )
                );
                $iCatId=Db::InsertId();
            }
            Base::$db->AutoExecute("cat_pref", array('pref'=>$sPref,'cat_id'=>$iCatId) , "UPDATE", "id=".$iKey, true, true);
        }
        $sMessage="&aMessage[MT_NOTICE]=Brands added successful";
	    
	    Base::$db->Execute("
		update price_import
		join cat_pref on price_import.cat=cat_pref.name
		join cat on cat_pref.cat_id=cat.id
		set price_import.pref=cat.pref, price_import.item_code=concat(cat.pref,'_',price_import.code)
		where cat.pref is not null and price_import.pref='' or price_import.pref is null
		");
	
	    $this->Redirect("?action=price".$sMessage);
	}
	//-----------------------------------------------------------------------------------------------
	public function Conformity() {
	    Resource::Get()->Add('/js/jquery.searchabledropdown-1.0.8.min.js',1);

		$a[""]="";
		Base::$tpl->assign('aPref', $a+Base::$db->getAssoc("select pref, title from cat where pref is not null order by name"));
		Base::$tpl->assign('aCat', $aCat=$this->GetArrayUnknownPref());
		if(!$aCat) Base::Message(array('MF_WARNING'=>'table is empty, please reload price'));
		$iAllCount = Db::GetOne("select count(*) from cat_pref where cat_id=0");
		if($iAllCount && $iAllCount > Language::getConstant('module_price::limit_count_unknown_pref', 1000)) 
			Base::Message(array('MF_WARNING_NT'=>Language::getMessage('Viewed only records from').' '.Language::getConstant('module_price::limit_count_unknown_pref', 1000).' - '.$iAllCount));
		
		$aData=array(
		'sHeader'=>"method=post id=\"form_conformity\"" ,
		'sTitle'=>"Price Conformity ",
		'sContent'=>Base::$tpl->fetch('price/conformity.tpl'),
		'sSubmitButton'=>'price_conformity',
		'sSubmitAction'=>'price_conformity_apply',
		'sReturnButton'=>'<< Return',
		'sReturnAction'=>'price',
		'sAdditionalButtonTemplate'=>"price/button_conformity.tpl",
		'sError'=>$sError,
		'sWidth'=>'99%',
		);
		$oForm=new Form($aData);

		Base::$sText.=$oForm->getForm();

	}
	//-----------------------------------------------------------------------------------------------
	// $sType - all delete all records from price_import (for button clear)
	//			ignore_empty - only fill pref (run from install, leave for work with empty pref records)
	public function ClearImport($sMessage='',$bRedirect=true, $sType = 'all',$iIdProvider=0) {
		if(!$iIdProvider) $iIdProvider=Base::$aRequest['id_provider'];
		if($iIdProvider) $sWhereProvider=" and id_provider='".$iIdProvider."' ";
		
		if ($sType == 'ignore_empty')
			Base::$db->Execute("delete from `price_import` where (pref is not null and pref != '') and (id_user='".Auth::$aUser['id']."' or id_user=1)".$sWhereProvider);
		else
			Base::$db->Execute("delete from `price_import` where (id_user='".Auth::$aUser['id']."' or id_user=1)".$sWhereProvider);
		
		//Base::$db->Execute("optimize table `price_import`");
		/*
		$aDirFile=File::GetFromDir("/imgbank/price/");
		if ($aDirFile) foreach ($aDirFile as $aFile) {
			File::RemoveToDir($aFile,"/imgbank/price/log/");
		}
		*/
		if($bRedirect)$this->Redirect("?action=price".$sMessage);
	}
	//-----------------------------------------------------------------------------------------------
	// $iPriceQueueId != 0 - for cron and auto upload (user_id unknown 1,2...)
	public function ClearProvider($bRedirect=true, $iPriceQueueId = 0) {
		if ($iPriceQueueId != 0)
			$sRow=Base::$db->GetOne("select group_concat(distinct(id_provider)) as id from price_import where (id_price_queue='".$iPriceQueueId."') group by id_user");
		else
			$sRow=Base::$db->GetOne("select group_concat(distinct(id_provider)) as id from price_import where (id_user='".Auth::$aUser['id']."' or id_user=1) group by id_user");
		
		if ($sRow) Base::$db->Execute("update price set price=0 where id_provider in (".$sRow.")");
		if ($bRedirect) $this->Redirect("?action=price");
	}
	//-----------------------------------------------------------------------------------------------
	public function ClearPref() {
		Base::$db->Execute("delete FROM `cat_pref` WHERE cat_id=0");
		$this->Redirect("?action=price");
	}
	//-----------------------------------------------------------------------------------------------
	/**
	 * Add item to price_import new price
	 *
	 * @param array(id_provider=>..,pref=>..,code=>..,item_code=>..) $aCart
	 * @param double $dPrice
	 */
	public function AddItem($aCart,$dPrice) {

		$aRow=Db::GetAssoc("
		select id_provider_virtual, id_provider
		 from provider_virtual
		 where id_provider<>id_provider_virtual"
		 );

		 if ($aRow and in_array($aCart['id_provider'],array_keys($aRow)))
		 $aData['id_provider']=$aRow[$aCart['id_provider']];
		 else
		 $aData['id_provider']=$aCart['id_provider'];

		 $aData['cat']=$aCart['pref'];
		 $aData['pref']=$aCart['pref'];
		 $aData['code']=$aCart['code'];
		 $aData['item_code']=$aCart['item_code'];
		 $aData['price']=$dPrice;
		 $aData['id_user']=Auth::$aUser['id'];

		 if ($aData['code']!="" and $aData['cat']!="" and $aData['id_provider']>0) {
		 	Db::AutoExecute("price_import",$aData);
		 }
	}
	//-----------------------------------------------------------------------------------------------
	public function Export(){
		$sUrl=SERVER_PATH."/imgbank/price/export/";
		$sNameZip="partmaster.zip";

		if (file_exists($sUrl.$sNameZip)) {
			Base::$tpl->assign("sFileTime", date ("d.m.Y H:i:s.", filemtime($sUrl.$sNameZip)));
		}

		$aData=array(
		'sTitle'=>"Price Export ",
		'sContent'=>Base::$tpl->fetch('price/form_export.tpl'),
		'sSubmitButton'=>'Export',
		'sSubmitAction'=>'price_file_export',
		'sError'=>$sError,
		);
		$oForm=new Form($aData);
		$oForm->sWidth="30%";
		//$oForm->bAutoReturn=true;
		//$oForm->sAdditionalButtonTemplate="price/button_export.tpl";

		Base::$sText.=$oForm->getForm();
	}
	//-----------------------------------------------------------------------------------------------
	public function ExportFile() {
		error_reporting(E_ALL ^ E_NOTICE);
		if (Base::$aRequest['search']['coef'])
		{
			$sUrl=SERVER_PATH."/imgbank/price/export/";
			$sName="partmaster.txt";
			$sNameZip="partmaster.zip";

			if (is_file($sUrl.$sName)) unlink($sUrl.$sName);
			$fp = fopen($sUrl.$sName, 'w');


			$r=mysql_query("select pref, code, price*".str_replace(",",".",Base::$aRequest['search']['coef'])." as price
			from price
			where id_provider=347");

			while ($aRow = mysql_fetch_row($r)) {
				fputcsv($fp, $aRow, ";");
			}
			fclose($fp);


			//			Db::Execute("select pref, code, price*".Base::$aRequest['search']['coef']." as price
			//			into outfile '".$sUrl.$sName."'
			//			fields terminated by ';'
			//			-- optionally enclosed by '\"'
			//			lines terminated by '\n'
			//			from price
			//			where id_provider=347");

			if (is_file($sUrl.$sNameZip)) unlink($sUrl.$sNameZip);

			$zip = new ZipArchive;
			$res = $zip->open($sUrl.$sNameZip, ZipArchive::CREATE);
			if ($res === TRUE) {
				$zip->addFile($sUrl.$sName, $sName);
				$zip->close();
			}
			if (is_file($sUrl.$sName)) unlink($sUrl.$sName);
			$sMessage="&aMessage[MI_NOTICE]=Price exported";
		}
		else $sMessage="&aMessage[MI_ERROR]=Set coefficient";

		Base::Redirect("?action=price_export");
	}
	//-----------------------------------------------------------------------------------------------
	public function AddRequest(){

		$aData['pref']=$aCart['pref'];
		$aData['code']=$aCart['code'];
		$aData['id_user']=Auth::$aUser['id'];

		if ($aData['code']!="" and $aData['pref']!="") {
			Db::AutoExecute("price_import",$aData);
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function AddCat(){
		$aData=String::FilterRequestData(Base::$aRequest);
		$aData['pref']=substr(mb_strtoupper(str_replace(array(' ','-','#','.','/',',','_',':','[',']','(',')','*','&','+','`','\'','"','\\','<','>','?','!','$','%','^','@','~','|','=',';','{','}','№'), '', trim(Content::Translit($aData['pref']))),'UTF-8'),0,3);
		$aData['name']=mb_strtoupper(str_replace(array(' ','-','#','.','/',',','_',':','[',']','(',')','*','&','+','`','\'','"','\\','<','>','?','!','$','%','^','@','~','|','=',';','{','}','№'), '', trim(Content::Translit($aData['name']))),'UTF-8');
		
		$a=Db::GetRow("select * from cat where name='".$aData['name']."' or pref='".$aData['pref']."' or title='".$aData['title']."'");
		if($a){
			$sRes=Language::GetMessage("Already exist")." \n\n".Language::GetMessage("Name").":".$a['name'].
					"\n".Language::GetMessage("Pref").":".$a['pref']."\n".Language::GetMessage("Title").":".$a['title']."";
		}else{
			Db::Autoexecute('cat',$aData);
			$sRes='<option value="'.$aData['pref'].'">'.$aData['title'].'</option>';
		}
		die($sRes);
	}
	//-----------------------------------------------------------------------------------------------
	// A => 1....
	public function ConvertToInteger($sNumber) {
		$sNumber = trim($sNumber);
		if (is_numeric($sNumber))
			return $sNumber;

		mb_internal_encoding("UTF-8");
		$sNumber = mb_strtoupper($sNumber);
		for($i = 1; $i <= mb_strlen($sNumber); $i+=1) 
			$iNumber += (ord($sNumber[$i-1]) - 64) * pow(26, (mb_strlen($sNumber) - $i));
		
		return $iNumber;
	}
	//- Ajax ----------------------------------------------------------------------------------------------
	public function RefreshQueue() {
		$oLanguage = new Language();
		Base::$tpl->assign('oLanguage',$oLanguage);
		$oPriceQueue = new PriceQueue();
		$sText = $oPriceQueue->GetQueueInfoTable();
		if(Base::$aRequest['xajax']){
			Base::$oResponse->AddAssign('refresh_table','innerHTML',$sText);
		}
	}
	//----------------------------------------------------------------------------------------------------
	public function getStoppedQueueFlag($id) {
		$is_processed = Base::$db->getOne("select is_processed from price_queue where id = ".$id);
		if (isset($is_processed) && $is_processed == 3)
			return true;	
		
		return false;
	}
	//----------------------------------------------------------------------------------------------------
	public function SaveToLog($aResult, $iAllStringsCurrentList, $iAllStringsTotal, $iAllStrings, &$iCountError, $iList, $iPriceQueue, $aData, $aPrice_profile) {
		// idex in array => index in profile col_
		$ii = 0;
		if (isset($aData[0]))
			$ii = 1;
		
		$sMessage = '';
		if ($aResult['pref'] == Null) {
			$sMessage .= Language::GetMessage('error get pref') . "; ";
		}
		if ($aResult['code'] == '') {
			$sMessage .= Language::GetMessage('error get code') . "; ";
			$iIndex = $this->ConvertToInteger($aPrice_profile['col_code_name']);
			$aData[$iIndex - $ii] = '<span style="color:red;">['.$aData[$iIndex - $ii].']</span>';
		}
		if ($aResult['cat'] == '') {
			$sMessage .= Language::GetMessage('error get category') . "; ";
			$iIndex = $this->ConvertToInteger($aPrice_profile['col_cat']);
			$aData[$iIndex - $ii] = '<span style="color:red;">['.$aData[$iIndex - $ii].']</span>';
		}
		if (!$aResult['id_provider'])
			$sMessage .= Language::GetMessage('error get id provider') . "; ";

		if ($iAllStrings == 0)
			$iAllStrings = 1;
		
		$fProgress = ($iAllStringsTotal / $iAllStrings) * 99;
		if ($fProgress > 99)
			$fProgress = 99;
		
		if ($sMessage != '') {
			// convert charset
			if ($aPrice_profile['charset']) {
				foreach($aData as $iKey => $sValue)
					if(is_string($sValue))
						$aData[$iKey]=iconv($aPrice_profile['charset'],Base::$aGeneralConf['Charset'],$sValue);
			}
			$iCountError += 1;
			if ($iCountError <= Base::GetConstant("price:view_count_error","200"))
				Db::Execute("insert into log_price_queue (id_price_queue, input_data, error_message, list, row) VALUES
							(".$iPriceQueue.",'".base64_encode(json_encode($aData))."','".$sMessage."','".$iList."','".$iAllStringsCurrentList."')");
		}
		Db::Execute("update price_queue set date_progress = ".time().", progress = ".$fProgress.", sum_errors = ".$iCountError.
		", current_string = ".$iAllStringsTotal.
		" where id = ".$iPriceQueue);
	}
	//----------------------------------------------------------------------------------------------------
	public function CheckStoppedLoadPrice($iPriceQueue) {
		// check stopped
		if ($this->getStoppedQueueFlag($iPriceQueue)) {
			Base::UpdateConstant("price:is_load",0);
			if(Auth::$aUser)
				Base::Redirect('/?action=price');
			else
				Base::Redirect('/');
			return;
		}
	}
	//----------------------------------------------------------------------------------------------------
	public function LoadFromXlsxAll($iPriceQueue, &$iMaxCountCol, $files, $aPrice_profile, $aProvider, $iUser) {
		$sLog = '/tmp/_'.Base::GetConstant("global:project_name").'_load_xlsx_file_All.'.basename($files['path']);

		file_put_contents($sLog, Date("Y-m-d H:i:s"). " Start...\n",FILE_APPEND);

		$iAllStrings = 0;
		$oExcel = new Excel();
		$oExcel->ReadExcel7($files['path'],true,false);
		// get count
		for ($iList=0;$iList<$aPrice_profile['list_count'];$iList++){
			$oExcel->SetActiveSheetIndex($iList);
			$aData=$oExcel->GetSpreadsheetData();
			$tot = count($aData);
			$iAllStrings += $tot;
		}
		// parse data
		$iAllStringsTotal = 0;
		$iCountError = 0;
		$sStep = Language::GetMessage('Get input data');
		Db::Execute("update price_queue set date_progress = ".time().", step = '".$sStep."', sum_all = ".$iAllStrings.
		" where id = ".$iPriceQueue);
		for ($iList=0;$iList<$aPrice_profile['list_count'];$iList++){
			$iAllStringsCurrentList = 0;
			$oExcel->SetActiveSheetIndex($iList);
			$aData=$oExcel->GetSpreadsheetData();
			foreach ($aData as $sKey => $aValue) {
				$iAllStringsCurrentList += 1;
				$iAllStringsTotal += 1;
				
				file_put_contents($sLog, Date("Y-m-d H:i:s"). " List: ".$iList." row: ".$iAllStringsCurrentList."\n",FILE_APPEND);
				
				if ($aPrice_profile['row_start']>$sKey) continue;
				if ($iMaxCountCol < ($j=count($aValue)))
					$iMaxCountCol = $j;
				$aResult = $this->LoadPrice($aValue,$aPrice_profile,$aProvider,$iUser,$iPriceQueue);
				$this->SaveToLog($aResult, $iAllStringsCurrentList, $iAllStringsTotal, $iAllStrings, $iCountError, $iList, $iPriceQueue, $aValue, $aPrice_profile);
			}
		}
		@unlink($sLog);
		return $iCountError;
	}
	//----------------------------------------------------------------------------------------------------
	public function LoadFromXlsxPartial($iPriceQueue, &$iMaxCountCol, $files, $aPrice_profile, $aProvider, $iUser) {
		$sLog = '/tmp/_'.Base::GetConstant("global:project_name").'_load_xlsx_file_Partial.'.basename($files['path']);
		$iAllStrings = 0;
		$iChunkSize = Base::GetConstant("price:chunk_size",10000);
		
		file_put_contents($sLog, Date("Y-m-d H:i:s"). " Start... Partial: ".$iChunkSize."\n",FILE_APPEND);
		
		$oExcel = new Excel();
		$objReader = $oExcel->CreateObjectExcel2007();
		$sMessage = Language::GetMessage('error get data from file');
		try {
		    $bResult = $objReader->canRead($files['path']);
		}
		catch (Exception $e) {
		    $sMessage = $e->getMessage();
		    $bResult=false;
		}
		if ($bResult===false) {
		    file_put_contents($sLog, Date("Y-m-d H:i:s"). " Error: ".$sMessage."\n",FILE_APPEND);
		    Db::Execute("insert into log_price_queue (id_price_queue, input_data, error_message, list, row) VALUES
			(".$iPriceQueue.",'','".$sMessage."','0','0')");
		    Db::Execute("update price_queue set date_progress = ".time().", progress = '100', sum_errors = '1', current_string = '0' where id = ".$iPriceQueue);
		    return 1; // count error
		}
		
		//$aExelInfo = $objReader->listWorksheetInfo($files['path']);
		$aExelInfo = $objReader->listWorksheetInfo_CorrectAllRows($files['path']);
		unset($objReader);
		
		// get count
		for ($iList=0;$iList<$aPrice_profile['list_count'];$iList++)
			$iAllStrings += $aExelInfo[$iList]['totalRows'];
			
		// get data from xlsx
		$iAllStringsTotal = 0;
		$iCountError = 0;
		$sStep = Language::GetMessage('Get input data');
		Db::Execute("update price_queue set date_progress = ".time().", step = '".$sStep."', sum_all = ".$iAllStrings.
				" where id = ".$iPriceQueue);
					
		for ($iList=0;$iList<$aPrice_profile['list_count'];$iList++){
			$iAllStringsTotal += ($aPrice_profile['row_start'] - 1);
			$iAllStringsCurrentList = ($aPrice_profile['row_start'] - 1);
			for($iStartRow = $aPrice_profile['row_start']; $iStartRow <= $aExelInfo[$iList]['totalRows']; $iStartRow += $iChunkSize) {
				$objReader = $oExcel->SetCreateReader();
				$oChunkFilter = new chunkReadFilter();
				$objReader->setReadFilter($oChunkFilter);

				$oChunkFilter->setRows($iStartRow,$iChunkSize);
				$objReader->setReadFilter($oChunkFilter);
				$objReader->setReadDataOnly(true);
				$objPHPExcel = $objReader->load($files['path']);
				$objPHPExcel->setActiveSheetIndex($iList);
				$sFromCell = 'A'.$iStartRow;
				$aData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,false,$sFromCell);
					
				// free memory
				unset($objPHPExcel);
				unset($objReader);
				unset($oChunkFilter);
					
				// parse data
				foreach ($aData as $sKey => $aValue) {
					$iAllStringsCurrentList += 1;
					$iAllStringsTotal += 1;
					
					file_put_contents($sLog, Date("Y-m-d H:i:s"). " List: ".$iList." row: ".$iAllStringsCurrentList."\n",FILE_APPEND);
						
					//if ($aPrice_profile['row_start']>$sKey) continue;
					if ($iMaxCountCol < ($j=count($aValue)))
						$iMaxCountCol = $j;
					$aResult = $this->LoadPrice($aValue,$aPrice_profile,$aProvider,$iUser,$iPriceQueue);
					$this->SaveToLog($aResult, $iAllStringsCurrentList, $iAllStringsTotal, $iAllStrings, $iCountError, $iList, $iPriceQueue, $aValue, $aPrice_profile);
				}
				// real data rows
				if (count($aData) < $iChunkSize) {
					unset($aData);
					break;
				}
				unset($aData);
				}
		}
		if ($iAllStringsTotal <= $iAllStrings)
			Db::Execute("update price_queue set sum_all = ".$iAllStringsTotal." where id = ".$iPriceQueue);
		@unlink($sLog);
		return $iCountError;
	}
	//-----------------------------------------------------------------------------------------------
	public function GetArrayUnknownPref() {
		return Base::$db->getAssoc("select id, name from cat_pref where cat_id=0 order by name limit ".Language::getConstant('module_price::limit_count_unknown_pref', 1000));
	}
	
	//-----------------------------------------------------------------------------------------------
	public function SaveFilesToQueue($aFileExtract, $sSource = 'upload', $iProfile_id = 0, $sSubject = '', $sFrom = '') {
		$oPriceQueue = new PriceQueue();
		
		mb_internal_encoding("UTF-8");
		
		$sErrorProfile = '';
		// for cron queue
		// upload = 2, else 3 (ftp,mail)
		if ($sSource == 'upload')
			$iWeightUploadCode = 2;
		else
			$iWeightUploadCode = 3;
		
		$aData['id_price_profile'] = 0;
		$aData['id_user_provider'] = 0;
		$aData['id_user'] = (Auth::$aUser[id]) ? Auth::$aUser[id] : 1;
		$aData['source'] = $sSource;
		$aData['weight'] = $iWeightUploadCode;
		if ($iProfile_id != 0) {
			$aPrice_profile=Base::$db->getRow("select * from price_profile where id='".$iProfile_id."'");
		//        Debug::PrintPre($aPrice_profile);
			if ($aPrice_profile['id']) {
				$aData['id_price_profile'] = $aPrice_profile['id'];
				$aData['id_user_provider'] = ($aPrice_profile['id_provider']) ? $aPrice_profile['id_provider'] : 0;
			}
		}
		
		foreach ($aFileExtract as $key => $aValue) {
			$aName = mb_substr($aValue['name'],strlen($aData['id_user']));
			$aData['file_name_original'] = ($aName ? $aName : $aValue['name']);
			 
			Db::AutoExecute("price_queue",$aData);
			$id=Db::InsertId();
			 
			$aData['file_name'] = $id."_".$aValue['name'];
			$aData['file_path'] = SERVER_PATH.$oPriceQueue->sPathToFile.$aData['file_name'];
			rename($aValue['path'],$aData['file_path']);
			 
			if ($iProfile_id == 0) {
				$aProfileInfo = $oPriceQueue->GetProfile($sSource, $aData['file_name_original'], $sSubject, $sFrom);
				if ($aProfileInfo['id']) {
					$aData['id_price_profile']=$aProfileInfo['id'];
					$aData['id_user_provider']=$aProfileInfo['id_provider'];
				}
			}
			
			Db::AutoExecute("price_queue",$aData,"UPDATE","id=".$id);
			
			if ($aData['id_price_profile'] == 0) {
				if ($sErrorProfile != "")
					$sErrorProfile .= "<br>";
				$sErrorProfile .= Language::GetMessage(" - file") . ": " . $aData['file_name_original'];
			}
		}
		
		return $sErrorProfile;
	}
	//-----------------------------------------------------------------------------------------------
	public function ClearOldQueueFiles() {
		$oPriceQueue = new PriceQueue();
		$aDirFile=File::GetFromDir($oPriceQueue->sPathToFile);
		
		$seconds_old = 60 * 60 * 24 * (int)Base::GetConstant('price:board_days_for_delete','90');		
		if ($aDirFile)
		foreach($aDirFile as $file) {
			$filemtime = @filemtime($file['path']);
			if ($filemtime && (time() - $filemtime <= $seconds_old)) continue;
			@unlink($file['path']);
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function ClearOldQueueImportRecords() {
		$iInterval = ((int)Base::GetConstant('price:board_days_for_del_records','7') * 24 * 60 * 60);
		Base::$db->Execute("delete FROM `price_import` where (unix_timestamp(now()) - unix_timestamp(post_date)) >= ".$iInterval);
		Base::$db->Execute("optimize table `price_import`");
	}
	//-----------------------------------------------------------------------------------------------
	public function RemovePref(){
		if(Base::$aRequest['pref']){
			Db::Execute("delete from cat_pref where id='".Base::$aRequest['pref']."' ");
			
			Base::$oResponse->AddScript('document.getElementById("tr_'.Base::$aRequest['pref'].'").parentNode.removeChild(tr_'.Base::$aRequest['pref'].');');
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function AddAutoPref(){
		if(Base::$aRequest['cat'] && Base::$aRequest['id']){
		    $sCatName=mb_strtoupper(str_replace(array(' ','-','#','.','/',',','_',':','[',']','(',')','*','&','+','`','\'','"','\\','<','>','?','!','$','%','^','@','~','|','=',';','{','}','№'), '', trim(Content::Translit(Base::$aRequest['cat']))),'UTF-8');
			$aCat=Db::GetRow("select id,pref from cat where title like '".Base::$aRequest['cat']."' or name like '".$sCatName."' order by id asc");
			$iCatId=$aCat['id'];
			$sPref=$aCat['pref'];
			if(!$iCatId){
			$sPref=String::GeneratePref();
			$aInsertData=array(
				'pref'=>$sPref,
				'name'=>$sCatName,
				'title'=>Base::$aRequest['cat'],
			);
			Base::$db->AutoExecute("cat", $aInsertData);
			$iCatId=Db::InsertId();
			}
			Base::$db->AutoExecute("cat_pref", array('pref'=>$sPref,'cat_id'=>$iCatId) , "UPDATE", "id=".Base::$aRequest['id'], true, true);
			$sResponse='<option value="'.$sPref.'">'.Base::$aRequest['cat'].'</option>';
			Base::$oResponse->addScript("addSelectWithPref(".Base::$aRequest['id'].",'".$sResponse."');");
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function GetAssociate() {
		//need refresh after interval
		$iNowDate=time();
		$iLastRefresh=Base::GetConstant("price:associate_data_last_update",time());
		if(($iLastRefresh+(Base::GetConstant("price:associate_data_interval","60")*60)) <= $iNowDate) {
			//need update
			$aResult = $this->BuildAssociateData();
			FileCache::SetValue('Associate', 'associate_data', $aResult);
		}
		else{
			if(!$aResult=FileCache::GetValue('Associate', 'associate_data')) {
				$aResult = $this->BuildAssociateData();
				FileCache::SetValue('Associate', 'associate_data', $aResult);
			}
		}
		
		return $aResult;
	}
	//-----------------------------------------------------------------------------------------------
	public function FindAssociate($aData) {
		static $aDataAssociate, $sSql;
		
		if (!$aDataAssociate) 
			$aDataAssociate = Price::GetAssociate();

		$sData_i_eng = str_replace("і","i", $aData['part_rus']);
		$sData_i_eng = str_replace("І","I", $sData_i_eng);
		foreach ($aDataAssociate as $sString => $sCodeGroup) {
			if (mb_stripos($aData['part_rus'],$sString) !== false) 
				return $sCodeGroup;
			// i symbol eng / ua
			if (mb_stripos($sData_i_eng,$sString) !== false)
				return $sCodeGroup;
		}
		return ''; 
	}
	// -------------------------------------------------------------------------------------------
	public function BuildAssociateData() {
		$aResult = array();
		$aData = Db::GetAll("Select code, link_name_group from price_group where link_name_group != ''");
		if (!$aData)
			return $aResult;
			
		foreach($aData as $aValue) {
			$aMass = explode(';',$aValue['link_name_group']);
			foreach ($aMass as $sLink) {
				if($sLink && trim($sLink)!='') {
					$sLink = str_replace("\\", "", trim($sLink));
					$sLink = str_replace("\n", "", $sLink);
					$sLink_i_eng = str_replace("І","I",str_replace("і","i", $sLink));
						
					//$aResult[$sLink] = $aValue['code'];
					$aMass=explode(" ",$sLink);
					$aTmpSort[] = count($aMass).'_'.$sLink;
					$aTmp[] = array('name' => $sLink, 'code' => $aValue['code']);
						
					if ($sLink_i_eng != $sLink) {
						$aTmpSort[] = count($aMass).'_'.$sLink_i_eng;
						$aTmp[] = array('name' => $sLink_i_eng, 'code' => $aValue['code']);
					}
				}
			}
		}
			
		// array count words string
		if ($aTmpSort) {
			array_multisort ($aTmpSort, SORT_DESC, SORT_STRING, $aTmp);
			foreach($aTmp as $aValue)
				$aResult[$aValue['name']] = $aValue['code'];
		}
		return $aResult;
	}	
}
function dbg_last_error($iPriceQueue = 0){
	$e=error_get_last();
	switch ($e['type']) {
		case E_COMPILE_ERROR:
		case E_ERROR:
		case E_CORE_ERROR:
		case E_RECOVERABLE_ERROR:
			$sError = Language::GetMessage('break process by fatal error') . " [id: ".$iPriceQueue." type error [".$e["type"]."] ".$e["file"].":".$e["line"]."\n".$e["message"]."\n";
			file_put_contents('/tmp/_log_fatal_error_'.Base::GetConstant("global:project_name"), date("Y-m-d H:i:s") ." ". $sError, FILE_APPEND);
			Db::AutoExecute("price_queue",array(
							'is_processed'=>2, 
							'date_stop' => time(),
							'step' => $sError,
							'date_progress' => time()),
							'UPDATE','id='.$iPriceQueue);
			Db::Execute("update price_queue set sum_errors = sum_errors+1 where id=".$iPriceQueue);
																			    
			Db::Execute("insert into log_price_queue (id_price_queue, input_data, error_message, list, row) VALUES
					(".$iPriceQueue.",'".base64_encode(json_encode(array()))."','". $sError ."','-1','0')");
			Base::UpdateConstant("price:is_load",0);
			exit;
	}
}
?>
