<?

class ElitRoma extends Base
{
	var $sPathToFile="/imgbank/temp_upload/";
	
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		/*$iTimer=microtime(true);
		$this->GetPrice();
		Debug::PrintPre(round(microtime(true)-$iTimer,3),false);*/
		
		
		$iAllCount=Db::GetOne("select count(*) from elit_roma");
		$iProcessedCount=Db::GetOne("select count(*) from elit_roma where is_processed='1'");

		$iOut=Db::GetOne("select count(*) from elit_roma_out");
		$iOutPrice=Db::GetOne("select count(*) from elit_roma_out where price>0");
		
		Base::$sText.=$iAllCount."/".$iProcessedCount." ".round((($iProcessedCount / $iAllCount) * 100),4)."%<br>";
		Base::$sText.=$iOut."/".$iOutPrice." ".round((($iOutPrice / $iOut) * 100),4)."%<br>";
		Base::$sText.="Wait for ".date( 'Y-m-d H:i:s', Base::GetConstant("elit_roma:wait_price_error") )."<br>";
		Base::$sText.="Current ".date( 'Y-m-d H:i:s', time() )."<br><br>";
		
		$oTable=new Table();
		$oTable->sSql="select * from elit_roma where start='1'";
		$oTable->aColumn['brand']=array('sTitle'=>'brand','sWidth'=>'25%');
		$oTable->aColumn['code']=array('sTitle'=>'code','sWidth'=>'25%');
		
		$oTable->bFormAvailable=false;
		$oTable->iRowPerPage=50;
		$oTable->sDataTemplate='elit_roma/row_table.tpl';
		$oTable->sButtonTemplate='elit_roma/button.tpl';
		Base::$sText.=$oTable->GetTable();
	}
	//-----------------------------------------------------------------------------------------------
	public function Export($bPrice=false) {
		set_time_limit(0);
		
		$oExcel = new Excel();
		$aHeader=array(
			'A'=>array("value"=>'brand', "autosize"=>true),
			'B'=>array("value"=>'code', "autosize"=>true),
			'C'=>array("value"=>'art', "autosize"=>true),
			'D'=>array("value"=>'status', "autosize"=>true),
			'E'=>array("value"=>'price', "autosize"=>true),
			'F'=>array("value"=>'stock', "autosize"=>true),
			'G'=>array("value"=>'image', "autosize"=>true),
			'H'=>array("value"=>'name', "autosize"=>true),
			'I'=>array("value"=>'cross_brand', "autosize"=>true),
			'J'=>array("value"=>'cross_code', "autosize"=>true),
			'K'=>array("value"=>'date', "autosize"=>true),
		);
		$oExcel->SetHeaderValue($aHeader,1);
		$oExcel->SetAutoSize($aHeader);
		$oExcel->DuplicateStyleArray("A1:K1");
		
		if($bPrice) $sWhere="where price>0";
		else $sWhere='';
		$aPrice=Db::GetAll("select * from elit_roma_out ".$sWhere." order by brand,code,price,status");
		
		$i=2;
		if($aPrice) foreach ($aPrice as $aValue)
		{
			$oExcel->SetCellValueExplicit('A'.$i, $aValue['brand']);
			$oExcel->SetCellValueExplicit('B'.$i, $aValue['code']);
			$oExcel->SetCellValueExplicit('C'.$i, $aValue['art']);
			$oExcel->SetCellValueExplicit('D'.$i, $aValue['status']);
			$oExcel->SetCellValueExplicit('E'.$i, $aValue['price']);
			$oExcel->SetCellValueExplicit('F'.$i, $aValue['stock']);
			$oExcel->SetCellValueExplicit('G'.$i, $aValue['image']);
			$oExcel->SetCellValueExplicit('H'.$i, $aValue['name']);
			$oExcel->SetCellValueExplicit('I'.$i, $aValue['cross_brand']);
			$oExcel->SetCellValueExplicit('J'.$i, $aValue['cross_code']);
			$oExcel->SetCellValueExplicit('K'.$i, $aValue['date']);
			$i++;
		}
		
		$sFileName=uniqid().'.xls';
		$oExcel->WriterExcel5(SERVER_PATH.'/imgbank/temp_upload/'.$sFileName, true);
		
	}
	//-----------------------------------------------------------------------------------------------
	public function CronSecond() {
		$sSID=ElitRoma::GetSessionID();
		Base::UpdateConstant("elit_roma:sid",$sSID);
		
		$iParts=ceil(60/Base::GetConstant("elit_roma:sleep","3"));
		
		$i=0;
		while ($i<$iParts){
			$i++;
			$url = 'http://'.$_SERVER['HTTP_HOST'];
			$params = array('action' => 'elit_roma_cron_load','is_post' => 1);
			PriceQueue::SendRequest($url, $params);
			
			sleep(Base::GetConstant("elit_roma:sleep","3"));
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function CronLoad() {
		ElitRoma::GetPrice();
	}
	//-----------------------------------------------------------------------------------------------
	public function GetPrice() {
		if(Base::GetConstant("elit_roma:wait_price_error")>time()) return;
		
		$aRow=Db::GetRow("select * from elit_roma where is_processed='0' and start='0'");
		Db::Execute("update elit_roma set start='1' where id='".$aRow['id']."' ");
		/*$aRow=array(
			'code'=>'0450904149',
			'brand'=>'BOSCH'
		);*/
		$sSID=Base::GetConstant("elit_roma:sid");
		if(!$sSID) {
			$sSID=ElitRoma::GetSessionID();
			Base::UpdateConstant("elit_roma:sid",$sSID);
		}
		
		$client = new SoapClient("http://wsvc11.carparts-cat.com/v31/Parts.asmx?WSDL", 	array('encoding'=>'utf-8','connection_timeout' => 2) );
		
		$ns="http://tempuri.org/";
		
		$headerbody = array(
			'_SID' => $sSID,
		);
		
		//Create Soap Header.
		$header = new SOAPHeader($ns, 'ManagedSoapHeader', $headerbody);
		
		//set the Headers of Soap Client.
		$client->__setSoapHeaders($header);
		
		$aParams=array(
			'SprNr'=>'16',
			'SuchStr'=>$aRow['code'],
			'Mode'=>'2',
			'KatTyp'=>'1',
			'HKatNr'=>'112',
			'FltNr'=>'64',
			'Lkz'=>'RO',
			'Wkz'=>'RON',
		);
		$oResponse=$client->GetArtVglNr($aParams);
		//Debug::PrintPre($oResponse,false);
		
		if($oResponse->GetArtVglNrResult->ErrorCode!=0){	
			//terminate and block
			Base::UpdateConstant("elit_roma:wait_price_error",(time()+(60*Base::GetConstant("elit_roma:wait_constant_minute","5"))) );
			return;
		}
		
		$aResultInfo=array();
		$aResult=array();
		if(count($oResponse->GetArtVglNrResult->Items->OutPartsArticle)>0)
		foreach ($oResponse->GetArtVglNrResult->Items->OutPartsArticle as $oValue) {
			if($oValue->KARTNR || $oValue->ARTNR){
				if($oValue->KARTNR) $sCode=$oValue->KARTNR;
				else $sCode=$oValue->ARTNR;
				
				//Debug::PrintPre($oValue);
				$aResultInfo[]=array(
					'WholesalerArtNr'=>$sCode,
					'EinspNr'=>$oValue->EINSPNR,
					'EinspArtNr'=>$oValue->EARTNR,
					'RequestedQuantity'=>array('Value'=>"100"),
					'AvailState'=>'unbekannt',
				);
				
				$aResult[]=array(
					'code'=>$oValue->EARTNR,
					'brand'=>$oValue->EINSPBEZ,
					'image'=>$oValue->THUMB,
					'name'=>$oValue->GENBEZ,
					'art'=>$oValue->ARTNR,
					'cross_code'=>$oValue->FARTNR,
					'cross_brand'=>$oValue->OEBEZ
				);
			}
		}
		
		if(count($aResultInfo)>0) {
			//get prices
			$client = new SoapClient("http://ws.autototal.ro/DVSE.WebApp.ErpService/ATTErp.asmx?WSDL", 
					array(
							'encoding'=>'utf-8',
							'connection_timeout' => 1,
							'proxy_host'     => "ws.autototal.ro",
	                        'proxy_port'     => 30080,
							"trace" => 1,
							"exceptions" => 1,
	                       'location'=>'http://ws.autototal.ro/DVSE.WebApp.ErpService/ATTErp.asmx'
					) 
			);
			
			$aParams=array(
				'user'=>array(
					'CustomerId'=>'1381',
					'PassWord'=>'12565521',
					'UserName'=>'cormar',
					),
				'items'=>array(
						'Item'=>$aResultInfo
				),
			);
			
			
			try{
				$oResponse=$client->GetArticleInformation($aParams);
			}catch(SoapFault $e){
				//Debug::PrintPre($e,true);
				
				//catch error
				//need wait
				Base::UpdateConstant("elit_roma:wait_price_error",time()+(60*Base::GetConstant("elit_roma:wait_constant_minute","5")));
				return;
			}		
			//Debug::PrintPre($oResponse,false);
			
			$aPriceResult=array();
			if(count($oResponse->GetArticleInformationResult->Items->Item->Item)>0)
			foreach ($oResponse->GetArticleInformationResult->Items->Item->Item as $oValue) {
				//Debug::PrintPre($oValue,false);
				
				$aPrice=array();
				if($oValue->Prices->Price) {
					$aPriceArray=(array)$oValue->Prices->Price;
					
					$aKeys=array_keys($aPriceArray);
					$aKeys=array_flip($aKeys);
					if(isset($aKeys['Text'])) {
						//single array, need convert
						$aPrice[]=$aPriceArray;
					} else {
						//multi object, need convert
						foreach ($aPriceArray as $aPriceObj) $aPrice[]=(array)$aPriceObj;
					}
				}
				
				$aData=array(
					'code'=>$oValue->EinspArtNr,
					'art'=>$oValue->WholesalerArtNr,
					'status'=>$oValue->AvailState,
					'price'=>$aPrice[0]['Value']
				);
				
				if($oValue->AvailState=='alternativlagerverfuegbar' || $oValue->AvailState=='verfuegbar') {
					$aQuantity=array();
					$aQuantityArray=(array)$oValue->Quantity->Quantity;
					
					$aKeys=array_keys($aQuantityArray);
					$aKeys=array_flip($aKeys);
					if(isset($aKeys['Text'])) {
						//single array, need convert
						$aQuantity[]=$aQuantityArray;
					} else {
						//multi object, need convert
						foreach ($aQuantityArray as $aQntObj) $aQuantity[]=(array)$aQntObj;
					}
				}
				
				if($aQuantity[0]['Value']) $aData['stock']=$aQuantity[0]['Value'];
				else $aData['stock']=0;
				
				$aPriceResult[]=$aData;
			}
			else {
				Base::UpdateConstant("elit_roma:wait_price_error",time()+(60*Base::GetConstant("elit_roma:wait_constant_minute","5")));
				return;
			}
			
			//merge
			if($aResult && $aPriceResult) {
				Db::Execute("update elit_roma set is_processed='1' where id='".$aRow['id']."' ");
				foreach ($aResult as $sKey => $aValue) {
					$aData=array_merge($aValue,$aPriceResult[$sKey]);
					Db::AutoExecute("elit_roma_out",$aData);
				}
				Db::Execute("update elit_roma set start='0' where id='".$aRow['id']."' ");
			}
		}
		
	}
	//-----------------------------------------------------------------------------------------------
	public function Load()
	{
		if(Base::$aRequest['is_post']) {
			mb_internal_encoding("UTF-8");
			set_time_limit(0);
				
			if($_FILES['excel_file']) {
				$excel_file = $_FILES['excel_file']['tmp_name'];
	
				if($excel_file) {
					$sPathToFileOu=$this->sPathToFile;
					$sLocalFile=SERVER_PATH.$sPathToFileOu.Auth::$aUser['id'].$_FILES['excel_file']['name'];
					@move_uploaded_file($excel_file, $sLocalFile);
					$aFileExtract=File::ExtractForPrice($sLocalFile,SERVER_PATH.$sPathToFileOu);
						
					if($aFileExtract && count($aFileExtract)>0) {
						unlink($sLocalFile);
					}
	
					if(!$aFileExtract) {
						$aFilePart = pathinfo($sLocalFile);
	
						$aFileExtract=array();
						$aFileExtract[0]['name']=$aFilePart['basename'];
						$aFileExtract[0]['path']=$sLocalFile;
					}
						
					//file exist, import to table
					if($aFileExtract && count($aFileExtract)>0) {
						set_time_limit(0);
						$aFilePart = pathinfo($aFileExtract[0]['path']);
							
						switch ($aFilePart['extension']) {
							case "xls":
							case "xlsx":
								$this->LoadFromExcel($aFileExtract[0]['path'],'elit_roma');
								break;
						}
						
						Base::Redirect("/pages/elit_roma/");
					}
				} else {
					$sError='file not selected';
				}
			} else {
				$sError='file not selected';
			}
		}
	
		$aData=array(
				'sHeader'=>"method=post enctype=\"multipart/form-data\"" ,
				'sHidden'=>"<input type=hidden name=\"style\" value='segment'>",
				'sContent'=>Base::$tpl->fetch('elit_roma/form_load.tpl'),
				'sSubmitButton'=>'elit_roma_load',
				'sSubmitAction'=>'elit_roma_load',
				'sError'=>$sError,
		);
	
		$oForm=new Form($aData);
		Base::$sText.=$oForm->getForm();
	}
	//-----------------------------------------------------------------------------------------------
	public function LoadFromExcel($sFilePath,$sTable='') {
		//clear table
		Db::Execute("truncate table ".$sTable);
		$aFilePart = pathinfo($sFilePath);
		$k = 1;
		$aInsert = array ();
		
		if ($aFilePart ['extension'] == 'xlsx') {
			// -------------------------------- partial begin ------------------------------------
			$iAllStrings = 0;
			$iChunkSize = 10000;
			
			$oExcel = new Excel ();
			$objReader = $oExcel->CreateObjectExcel2007 ();
			$aExelInfo = $objReader->listWorksheetInfo_CorrectAllRows ( $sFilePath );
			unset ( $objReader );
			
			// get count
			for($iList = 0; $iList < 1; $iList ++)
				$iAllStrings += $aExelInfo [$iList] ['totalRows'];
				
				// get data from xlsx
			$iAllStringsTotal = 0;
			$iCountError = 0;
			
			for($iList = 0; $iList < 1; $iList ++) {
				$iAllStringsTotal += (3 - 1);
				$iAllStringsCurrentList = (3 - 1);
				$i = 0;
				for($iStartRow = 3; $iStartRow <= $aExelInfo [$iList] ['totalRows']; $iStartRow += $iChunkSize) {
					$objReader = $oExcel->SetCreateReader ();
					$oChunkFilter = new chunkReadFilter ();
					$objReader->setReadFilter ( $oChunkFilter );
					
					$oChunkFilter->setRows ( $iStartRow, $iChunkSize );
					$objReader->setReadFilter ( $oChunkFilter );
					$objReader->setReadDataOnly ( true );
					$objPHPExcel = $objReader->load ( $sFilePath );
					$objPHPExcel->setActiveSheetIndex ( $iList );
					$sFromCell = 'A' . $iStartRow;
					$aData = $objPHPExcel->getActiveSheet ()->toArray ( null, true, true, false, $sFromCell );
					
					// free memory
					unset ( $objPHPExcel );
					unset ( $objReader );
					unset ( $oChunkFilter );
					
					// parse data
					foreach ( $aData as $sKey => $aValue ) {
						$i ++;
						$iAllStringsCurrentList += 1;
						$iAllStringsTotal += 1;
						if ($iMaxCountCol < ($j = count ( $aValue )))
							$iMaxCountCol = $j;
						
						$sTmp = $this->LoadPrice ( $aValue, $sTable );
						if ($sTmp != '')
							$aInsert [] = $sTmp;
						
						if (($i - 100) >= $k) {
							$this->Insert ( $aInsert, $sTable );
							
							$k = $i;
						}
					}
					// insert tail
					$this->Insert ( $aInsert, $sTable );
					
					// real data rows
					if (count ( $aData ) < $iChunkSize) {
						unset ( $aData );
						break;
					}
					unset ( $aData );
				}
			}
			// ----------------------------------------------- partial end --------------------------
		} else {
			require_once ("excel/reader.php");
			unset ( $data );
			$data = new Spreadsheet_Excel_Reader ();
			$data->setOutputEncoding ( 'UTF-8' );
			$data->read ( $sFilePath );
			
			// get count
			for($iList = 0; $iList < 1; $iList ++) {
				if ($data->sheets [$iList] ['numRows'] != 0)
					$tot = $data->sheets [$iList] ['numRows'];
					// numRows maybe = 0
				else
					$tot = count ( $data->sheets [$iList] ['cells'] );
				$iAllStrings += $tot;
			}
			// parse data
			$iAllStringsTotal = 0;
			$iCountError = 0;
			
			for($iList = 0; $iList < 1; $iList ++) {
				$iAllStringsCurrentList = 0;
				$iAllStringsCurrentList += (3 == 0) ? 0 : (3 - 1);
				$iAllStringsTotal += (3 == 0) ? 0 : (3 - 1);
				for($i = 3; $i <= ($data->sheets [$iList] ['numRows'] != 0 ? $data->sheets [$iList] ['numRows'] : count ( $data->sheets [$iList] ['cells'] )); $i ++) {
					$iAllStringsCurrentList += 1;
					$iAllStringsTotal += 1;
					if ($iMaxCountCol < ($j = count ( $data->sheets [$iList] ['cells'] [$i] )))
						$iMaxCountCol = $j;
					
					$sTmp = $this->LoadPrice ( $data->sheets [$iList] ['cells'] [$i], $sTable );
					if ($sTmp != '')
						$aInsert [] = $sTmp;
					
					if (($i - 100) >= $k) {
						$this->Insert ( $aInsert, $sTable );
						
						$k = $i;
					}
				}
				// insert tail
				$this->Insert ( $aInsert, $sTable );
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function Insert(&$aInsert=array(),$sTable='') {
		$sInsertSQL="INSERT INTO ".$sTable."
		(`brand`, `code`) VALUES ".
		implode(", ", $aInsert);
	
		$aInsert=array();
		Db::Execute($sInsertSQL);
	}
	//-----------------------------------------------------------------------------------------------
	public function LoadPrice($aItem,$sTable='') {
		$aData=array(
			'brand'	=>	trim(str_replace(array("'","\\"), "", $aItem[0])),
			'code'	=>	trim(str_replace(array("'","\\"), "", $aItem[1])),
		);
		$sRow="('".$aData['brand']."',
				'".$aData['code']."'
		)";
	
		return $sRow;
	}
	//-----------------------------------------------------------------------------------------------
	public function GetSessionID() {
		$client = new SoapClient("http://wsvc11.carparts-cat.com/v31/login.asmx?WSDL", 	array('encoding'=>'utf-8','connection_timeout' => 1) );
	
		$aParams=array(
			'Username'=>'cormar',
			'Password'=>'12565521',
			'KatalogId'=>'137',
			'LanguageId'=>'16',
		);
		
		try{
			$oResponse=$client->GetSession($aParams);
		}catch(SoapFault $e){
			//Debug::PrintPre($e,false);
		}
		
		return $oResponse->GetSessionResult->Item;
	}
	//-----------------------------------------------------------------------------------------------


}
?>