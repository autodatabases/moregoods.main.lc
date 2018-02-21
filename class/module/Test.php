<?

class Test extends Base
{
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		Cron::ClearCustomerData();
		Cron::ClearAllOld();
		
		Base::$sText.= "<br>Test module finished Ok.<br>";		
	}
	//-----------------------------------------------------------------------------------------------
	public function SetElitParams() {
		set_time_limit(0);
		$aItems=Db::GetAll("select * from elit_params where done='1'");
		$aPref=Base::$db->getAssoc("select UPPER(cp.name),c.pref from cat_pref cp inner join cat c on c.id=cp.cat_id");
		
		foreach ($aItems as $aValue) {
			//insert cat_part
				
			$sPref=$aPref[$aValue['brand']];
			$iCatPartId=Db::GetOne("select id from cat_part where item_code='".$sPref.'_'.$aValue['code']."' ");

			if($iCatPartId) {
				Db::AutoExecute("cat_info",array(
					'id_cat_part'=>$iCatPartId, 
					'name'=>$aValue['name_ru'], 
					'code'=>$aValue['value']
				));
				
				Db::Execute("update elit_params set done='2' where id='".$aValue['id']."' ");
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function SetElitImage() {
		set_time_limit(0);
		$aItems=Db::GetAll("select * from elit_image where done='1'");
		$aPref=Base::$db->getAssoc("select UPPER(cp.name),c.pref from cat_pref cp inner join cat c on c.id=cp.cat_id");
		
		foreach ($aItems as $aValue) {
			//insert cat_part
			
			$sPref=$aPref[$aValue['brand']];
			
			if($sPref) {
				Db::Execute("insert ignore into cat_part (item_code,code,pref) values ('".$sPref.'_'.$aValue['code']."','".$aValue['code']."','".$sPref."') ");
				
				$iCatPartId=Db::GetOne("select id from cat_part where item_code='".$sPref.'_'.$aValue['code']."' ");
				if($iCatPartId) {
					//add image to cat_pic
					$aFilePart = pathinfo(SERVER_PATH.$aValue['path']);
					
					Db::Autoexecute('cat_pic',array(
						'id_cat_part'=>$iCatPartId,
						'image'=>$aValue['path'],
						'pic'=>$aFilePart['basename'],
						'extension'=>$aFilePart['extension']
					));
					
					Db::Execute("update elit_image set done='2' where id='".$aValue['id']."' ");
				}
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function GetElitImages(){
		set_time_limit(0);
		$aItems=Db::GetAll("select * from elit_image where done='0'");
		$sImagePath="/imgbank/Image/elit_pic/";
		if (!file_exists(SERVER_PATH.$sImagePath)) {
			mkdir(SERVER_PATH.$sImagePath, true);
		}
		
		foreach ($aItems as $aValue) {
			
			$handle = @fopen($aValue['image'], "rb");
			$sContents = stream_get_contents($handle);
			fclose($handle);
			
			if($sContents){
				$aPathInfo=end(explode(".", $aValue['image']));
				$sFilename = $aValue['brand']."_".$aValue['code'].'.'.$aPathInfo;
				$handle = fopen(SERVER_PATH.$sImagePath.$sFilename, 'wb');
				fwrite($handle, $sContents);
				fclose($handle);
				
				Db::Execute("update elit_image set done='1', path='".$sImagePath.$sFilename."' where id='".$aValue['id']."' ");
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function ProcessExcel($iTimer) {
		set_time_limit(0);
		
		$sFileName=SERVER_PATH."/imgbank/temp_upload/price.xlsx";
		$sFileNameOut=SERVER_PATH."/imgbank/temp_upload/price_out.csv";
		
		$oExcel = new Excel();
		$oExcel->ReadExcel7($sFileName,true,false);
		$oExcel->SetActiveSheetIndex();

		ini_set('soap.wsdl_cache_enabled',0);
		ini_set('soap.wsdl_cache_ttl',0);
		$sSID=Test::GetSessionID();
		
		$iMaxRows=$oExcel->GetActiveSheet()->getHighestRow();
		Exchange::PrintFlush2("<br>Excel readed = ".$iMaxRows);
		
		$fp = fopen($sFileNameOut, 'w');
		$aHeader=array(
			"#",
			"brand",
			"code",
			"price",
			"stock",
		);
		fputcsv($fp, $aHeader,";");
		
		for ($i = 2; $i < $iMaxRows; $i++) {
			$sBrand = $oExcel->GetActiveSheet()->getCellByColumnAndRow(0, $i)->getValue();
			$sCode = $oExcel->GetActiveSheet()->getCellByColumnAndRow(1, $i)->getValue();
			
			$aPrice=Test::GetCodePrice($sSID,$sCode,$sBrand);
			//$oExcel->setCellValue('C'.$i, $aPrice['price']);
			//$oExcel->setCellValue('D'.$i, $aPrice['avail']);
			
			fputcsv($fp, array(
				$i-1,$sBrand,$sCode,$aPrice['price'],$aPrice['avail']
			),";");
			
			//Exchange::PrintFlush2("<br>Row: ".$i." ".$sBrand." ".$sCode." ".print_r($aPrice,true));
			Exchange::PrintFlush2("<br>#".($i-1)."  Time ".round(microtime(true)-$iTimer,3)." percent ".round(($i/$iMaxRows)*100)."%");
			
			sleep(2);
		}
		
		//$oExcel->WriterExcel7($sFileNameOut);
		
		fclose($sFileNameOut);
	}
	//-----------------------------------------------------------------------------------------------
	public function GetPriceTableByCode() {
		ini_set('soap.wsdl_cache_enabled',0);
		ini_set('soap.wsdl_cache_ttl',0);
		$sSid=Test::GetSessionID();
		$aCodes=Test::GetCodesByCode($sSid,Base::$aRequest['code']?Base::$aRequest['code']:'600001600');
		
		$aItem=array();
		foreach ($aCodes as $aValue) {
		$aResult=Test::GetPriceByCode($aValue['info']);
			
		unset($aValue['info']);
		$aItem[]=array_merge($aResult,$aValue);
		}
		
		
		$sText.="<table class='datatable'>";
		
		if($aItem[0]) $aHeader=array_keys($aItem[0]);
		if($aHeader) foreach ($aHeader as $sCol){
		$sText.="<th>".$sCol."</th>";
		}
		
		if($aItem) foreach ($aItem as $aValue) {
		$sText.="<tr>";
		
		if($aValue) foreach ($aValue as $sCol) {
		if(is_array($sCol)){
		$sText.="<td><table>";
		foreach ($sCol as $aSubcol) {
		$sText.="<tr>";
		
		foreach ($aSubcol as $sSubcol) {
		if(!is_object($sSubcol)) $sText.="<td>".$sSubcol."</td>";
		}
		
		$sText.="</tr>";
		}
		$sText.="</table></td>";
		} else {
		$sText.="<td>".$sCol."</td>";
		}
		}
		
		$sText.="</tr>";
		}
		
		$sText.="</table><br>";
		Base::$sText.=$sText;
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
			Debug::PrintPre($e,false);
		}
		
		return $oResponse->GetSessionResult->Item;
	}
	//-----------------------------------------------------------------------------------------------
	public function GetCodePrice($sSID,$sCode,$sBrand='') {
		//filter by brand
		switch ($sBrand) {
			case 'NGK':
				$sCode=str_replace("NGK", "", $sCode);
				break;
				
			case "Robert Bosch":
				$sBrand="Bosch";
				break;
				
			case "KYB":
				$sCode=str_replace("K", "", $sCode);
				break;
				
			case "Febi":
				$sBrand="FEBI BILSTEIN";
				break;
				
		}
		
		$client = new SoapClient("http://wsvc11.carparts-cat.com/v31/Parts.asmx?WSDL", 	array('encoding'=>'utf-8','connection_timeout' => 1) );
		$ns="http://tempuri.org/";
		$headerbody = array(
			'_SID' => $sSID,
		);
	
		$header = new SOAPHeader($ns, 'ManagedSoapHeader', $headerbody);
		$client->__setSoapHeaders($header);
	
		$aParams=array(
			'SprNr'=>'16',
			'SuchStr'=>$sCode,
			'Mode'=>'2',
			'KatTyp'=>'1',
			'HKatNr'=>'112',
			'FltNr'=>'64',
			'Lkz'=>'RO',
			'Wkz'=>'RON',
		);
		
		try{
			$oResponse=$client->GetArtVglNr($aParams);
		}catch(SoapFault $e){
			Debug::PrintPre($e,false);
		}
	
		$aResult=array();
		if($oResponse->GetArtVglNrResult->Items->OutPartsArticle)
		foreach ($oResponse->GetArtVglNrResult->Items->OutPartsArticle as $oValue) {
			if($oValue->KARTNR){
				//Debug::PrintPre($oValue,false);
				
				if(Catalog::StripCode($oValue->EARTNR)==Catalog::StripCode($sCode) && strtoupper($sBrand)==strtoupper($oValue->EINSPBEZ)) {
					$aResult=array(
						'info'=>array(
							'WholesalerArtNr'=>$oValue->KARTNR,
							'EinspNr'=>$oValue->EINSPNR,
							'EinspArtNr'=>$oValue->EARTNR,
							'RequestedQuantity'=>array('Value'=>"1"),
							'AvailState'=>'unbekannt',
						),
						'brand'=>$oValue->EINSPBEZ,
						'image'=>"<img src=\"".$oValue->THUMB."\">",
						'name'=>$oValue->GENBEZ,
						'status'=>$oValue->ARTSTATBEZ
					);
					break;
				}
			}
		}
		if($aResult['info']) $aPrice=Test::GetPriceByCode($aResult['info']);
			
		unset($aResult['info']);
		$aResult['avail']=$aPrice['stock'];
		$aResult['price']=$aPrice['price'][0]['Value'];
		$aResult['code']=$aPrice['Code'];
		$aResult['art']=$aPrice['Art'];
	
		//Debug::PrintPre($aResult,false);
		return $aResult;
	}
	//-----------------------------------------------------------------------------------------------
	public function GetCodesByCode($sSID,$sCode) {
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
			'SuchStr'=>$sCode,
			'Mode'=>'2',
			'KatTyp'=>'1',
			'HKatNr'=>'112',
			'FltNr'=>'64',
			'Lkz'=>'RO',
			'Wkz'=>'RON',
		);
		$oResponse=$client->GetArtVglNr($aParams);
		
		$aResult=array();
		foreach ($oResponse->GetArtVglNrResult->Items->OutPartsArticle as $oValue) {
			if($oValue->KARTNR){
				//Debug::PrintPre($oValue);
				$aResult[]=array(
					'info'=>array(
							'WholesalerArtNr'=>$oValue->KARTNR,
							'EinspNr'=>$oValue->EINSPNR,
							'EinspArtNr'=>$oValue->EARTNR,
							'RequestedQuantity'=>array('Value'=>"50"),
							'AvailState'=>'unbekannt',
					),
					'Brand'=>$oValue->EINSPBEZ,
					'Image'=>"<img src=\"".$oValue->THUMB."\">",
					'Name'=>$oValue->GENBEZ,
					'Text'=>$oValue->TXT_ARTINF,
					'Status'=>$oValue->ARTSTATBEZ
				);
			}
		}
		
		return $aResult;
	}
	//-----------------------------------------------------------------------------------------------
	public function GetPriceByCode($aCodes) {
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
				'Item'=>array($aCodes)
			),
		);
		
		
		try{
			$oResponse=$client->GetArticleInformation($aParams);
		}catch(SoapFault $e){
			Debug::PrintPre($e,false);
		}		
		
		$aResult=array();
		//foreach ($oResponse->GetArticleInformationResult->Items->Item->Item as $oValue) {
		$oValue=$oResponse->GetArticleInformationResult->Items->Item->Item;
		{
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
			
			$aResult=array(
				'Code'=>$oValue->EinspArtNr,
				'Art'=>$oValue->WholesalerArtNr,
				'Avail'=>$oValue->AvailState,
				'price'=>$aPrice
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
			
			if($aQuantity[0]['Value']) $aResult['stock']=$aQuantity[0]['Value'];
			else $aResult['stock']=0;
		}
	
		return $aResult;
	}
	//-----------------------------------------------------------------------------------------------


}
?>