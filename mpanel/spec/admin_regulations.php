<?

/**
 * @author Vladimir Fedorov
 *
 */
require_once(SERVER_PATH.'/class/core/Admin.php');
class AAdminRegulations extends Admin
{
	//-----------------------------------------------------------------------------------------------
	function AAdminRegulations()
	{
		$this->sAdminRegulationsUrl = 'http://moregoods.com.ua';
		if (Base::$aGeneralConf['AdminRegulationsUrl'])
			$this->sAdminRegulationsUrl = Base::$aGeneralConf['AdminRegulationsUrl'];
		
		Base::$tpl->assign("sAdminRegulationsUrl",$this->sAdminRegulationsUrl);
		
		$this->sTableName='admin_regulations';
		$this->sTablePrefix='ar';
		$this->sAction='admin_regulations';
		$this->sWinHead=Language::getDMessage('Admin regulations');
		//$this->sPath = Language::GetDMessage('>> Admin regulations >');

		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		$this->PreIndex();
				
		$oTable=new Table();
		$oTable->aColumn=array(
		'code'=>array('sTitle'=>'Code','sOrder'=>'ar.code'),
		'date_modified'=>array('sTitle'=>'Date modified','sOrder'=>'ar.date_modified'),
		'info'=>array('sTitle'=>'Information'),
		'description'=>array('sTitle'=>'Description','sOrder'=>'ar.description'),
		'action'=>array(),
		);
		$this->SetDefaultTable($oTable);
		$oTable->aCallback=array($this,'CallParse');
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeApply()
	{
		
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign(&$aData)
	{

	}
	//-----------------------------------------------------------------------------------------------
	public function Sinxronize()
	{
		switch (Base::$aRequest['code']) {
			case 'translate':$this->SinxronizeTranslate(Base::$aRequest['code']);break;
			case 'cat_model':$this->UpdateCatModel(Base::$aRequest['code']);break;
			case 'cat':$this->UpdateCat(Base::$aRequest['code']);break;
			case 'cat-cat_model-type_auto':$this->UpdateTypeAuto(Base::$aRequest['code']);break;
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function SinxronizeTranslate($sCode) {
		$aInfo = array(
			'constant' => array('update' => 0, 'total' => Db::GetOne("select count(*) from constant")),
			'context_hint' => array('update' => 0, 'total' => Db::GetOne("select count(*) from context_hint")),
			'template' => array('update' => 0 , 'total' => Db::GetOne("select count(*) from template")),
			'translate_message'=> array('update' => 0 , 'total' => Db::GetOne("select count(*) from translate_message")),
			'translate_text' => array('update' => 0, 'total' => Db::GetOne("select count(*) from translate_text")),
		);
		// get data from irbis
		$sUrl = $this->sAdminRegulationsUrl . '/pages/admin_regulations_sinxro_translate/';
		$sData = file_get_contents($sUrl);
		$aData = json_decode($sData,true);
		$iTime = date("Y-m-d H:i:s");
		if ($aData['constant']) {
			$sValues = '';
			foreach($aData['constant'] as $aValue) {
				if ($sValues != '')
					$sValues .= ',';
				$sValues .= "('".mysql_real_escape_string($aValue['key_'])."','".mysql_real_escape_string($aValue['value'])."','".mysql_real_escape_string($aValue['description'])."','".$aValue['is_general']."','".$aValue['type_data']."','".$iTime."')";
			}
			if ($sValues != '') {
				Db::Execute("Delete from constant where key_ = value");
				$iCnt = Db::GetOne("select count(*) from constant"); 
				Db::Execute("insert ignore into constant (key_, value, description, is_general, type_data, post_date) values ".$sValues);
				$iCntInserted = Db::GetOne("select count(*) from constant");
				$aInfo['constant']['total'] = $iCntInserted;
				$iCntInserted -= $iCnt; 
				if ($iCntInserted > 0)
					$aInfo['constant']['update'] = $iCntInserted; 
			}
		} 
		if ($aData['context_hint']) {
			$sValues = '';
			foreach($aData['context_hint'] as $aValue) {
				if ($sValues != '')
					$sValues .= ',';
				$sValues .= "('".mysql_real_escape_string($aValue['key_'])."','".mysql_real_escape_string($aValue['content'])."','".$aValue['visible']."')";
			}
			if ($sValues != '') {
				Db::Execute("Delete from context_hint where key_ = content");
				$iCnt = Db::GetOne("select count(*) from context_hint");
				Db::Execute("insert ignore into context_hint (key_, content, visible) values ".$sValues);
				$iCntInserted = Db::GetOne("select count(*) from context_hint");
				$aInfo['context_hint']['total'] = $iCntInserted;
				$iCntInserted -= $iCnt;
				if ($iCntInserted > 0)
					$aInfo['context_hint']['update'] = $iCntInserted;
			}
		}
		if ($aData['translate_message']) {
			$sValues = '';
			foreach($aData['translate_message'] as $aValue) {
				if ($sValues != '')
					$sValues .= ',';
				$sValues .= "('".mysql_real_escape_string($aValue['code'])."','".mysql_real_escape_string($aValue['content'])."','".$aValue['page']."','".$iTime."')";
			}
			if ($sValues != '') {
				Db::Execute("Delete from translate_message where code = content");
				$iCnt = Db::GetOne("select count(*) from translate_message");
				Db::Execute("insert ignore into translate_message (code, content, page, post_date) values ".$sValues);
				$iCntInserted = Db::GetOne("select count(*) from translate_message");
				$aInfo['translate_message']['total'] = $iCntInserted;
				$iCntInserted -= $iCnt;
				if ($iCntInserted > 0)
					$aInfo['translate_message']['update'] = $iCntInserted;
			}
		}
		if ($aData['template']) {
			$sValues = '';
			foreach($aData['template'] as $aValue) {
				if ($sValues != '')
					$sValues .= ',';
				$sValues .= "('".mysql_real_escape_string($aValue['code'])."','".mysql_real_escape_string($aValue['name'])."','".mysql_real_escape_string($aValue['content'])."','".$aValue['type_']."','".
						$aValue['is_smarty']."','".$aValue['priority']."','".$iTime."')";
			}
			if ($sValues != '') {
				Db::Execute("Delete from template where code = content");
				$iCnt = Db::GetOne("select count(*) from template");
				Db::Execute("insert ignore into template (code, name, content, type_, is_smarty, priority, post_date) values ".$sValues);
				$iCntInserted = Db::GetOne("select count(*) from template");
				$aInfo['template']['total'] = $iCntInserted;
				$iCntInserted -= $iCnt;
				if ($iCntInserted > 0)
					$aInfo['template']['update'] = $iCntInserted;
			}
		}
		if ($aData['translate_text']) {
			$sValues = '';
			foreach($aData['translate_text'] as $aValue) {
				if ($sValues != '')
					$sValues .= ',';
				$sValues .= "('".mysql_real_escape_string($aValue['code'])."','".mysql_real_escape_string($aValue['content'])."','".$iTime."')";
			}
			if ($sValues != '') {
				Db::Execute("Delete from translate_text where code = content");
				$iCnt = Db::GetOne("select count(*) from translate_text");
				Db::Execute("insert ignore into translate_text (code, content, post_date) values ".$sValues);
				$iCntInserted = Db::GetOne("select count(*) from translate_text");
				$aInfo['translate_text']['total'] = $iCntInserted;
				$iCntInserted -= $iCnt;
				if ($iCntInserted > 0)
					$aInfo['translate_text']['update'] = $iCntInserted;
			}
		}
		$sInfo = json_encode($aInfo);
		Db::Execute("update admin_regulations set date_modified=now(), info='".$sInfo."' where code='".$sCode."'");
		//Admin::Message('MT_NOTICE','SinxronizeTranslateDone');
		$this->AdminRedirect ( $this->sAction ); // but not found message
	}
	//-----------------------------------------------------------------------------------------------
	public function CallParse(&$aItem) {
		foreach($aItem as $iKey => $aValue) {
			switch ($aValue['code']) {
				case 'translate':$aItem[$iKey]['info'] = $this->ViewTranslate($aValue);break;
				case 'cat_model':$aItem[$iKey]['info'] = $this->CatModelStatus($aValue);break;
				case 'cat':$aItem[$iKey]['info'] = $this->CatStatus($aValue);break;
				case 'cat-cat_model-type_auto':$aItem[$iKey]['info'] = $this->TypeAutoStatus($aValue);break;
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function TypeAutoStatus($aData) {
		if (!$aData['info'])
			return Language::getDMessage('not update');
	
		$aInfo = json_decode($aData['info'],true);
		if (!$aInfo)
			return '';
	
		$aMass[] = array(
				'version' => $aInfo['version'],
				'version_db_tof' => $aInfo['version_db_tof'],
				'update_cat' => $aInfo['update_cat'],
				'update_model' => $aInfo['update_model'],
		);
	
		Base::$tpl->assign("aDataColumn",array(
		'version'=>array('sTitle'=>Language::getDMessage('Version Tecdoc')),
		'version_db_tof'=>array('sTitle'=>Language::getDMessage('Version original Tecdoc')),		
		'update_cat'=>array('sTitle'=>Language::getDMessage('Cat car/truck/mixed')),
		'update_model'=>array('sTitle'=>Language::getDMessage('Model car/truck')),
		));
	
		Base::$tpl->assign("aData",$aMass);
		Base::$tpl->assign("sDataTemplateName",'mpanel/admin_regulations/row_admin_regulations_translate.tpl');
		return Base::$tpl->fetch('mpanel/admin_regulations/only_table.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	public function CatStatus($aData) {
		if (!$aData['info'])
			return Language::getDMessage('not update');
	
		$aInfo = json_decode($aData['info'],true);
		if (!$aInfo)
			return '';
	
		$aMass[] = array(
			'version' => $aInfo['version'], 
			'update' => $aInfo['update'], 
			'total' => $aInfo['total'],
			'update_link' => $aInfo['update_link'],
			'update_adres' => $aInfo['update_adres'],
		);
		
		Base::$tpl->assign("aDataColumn",array(
		'version'=>array('sTitle'=>Language::getDMessage('Version Tecdoc')),
		'update'=>array('sTitle'=>Language::getDMessage('Status update unknown')),
		'update_link'=>array('sTitle'=>Language::getDMessage('Status update link')),
		'update_adres'=>array('sTitle'=>Language::getDMessage('Status update adres')),
		'total'=>array('sTitle'=>Language::getDMessage('Total count')),
		));
	
		Base::$tpl->assign("aData",$aMass);
		Base::$tpl->assign("sDataTemplateName",'mpanel/admin_regulations/row_admin_regulations_translate.tpl');
		return Base::$tpl->fetch('mpanel/admin_regulations/only_table.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	public function CatModelStatus($aData) {
		if (!$aData['info'])
			return Language::getDMessage('not update');

		$aInfo = json_decode($aData['info'],true);
		if (!$aInfo)
			return '';
		
		$aMass[] = array('version' => $aInfo['version'], 'inserted' => $aInfo['inserted'], 'total' => $aInfo['total']);

		Base::$tpl->assign("aDataColumn",array(
		'version'=>array('sTitle'=>Language::getDMessage('Version Tecdoc')),
		'inserted'=>array('sTitle'=>Language::getDMessage('Status update')),
		'total'=>array('sTitle'=>Language::getDMessage('Total count')),
		));
		
		Base::$tpl->assign("aData",$aMass);
		Base::$tpl->assign("sDataTemplateName",'mpanel/admin_regulations/row_admin_regulations_translate.tpl');
		return Base::$tpl->fetch('mpanel/admin_regulations/only_table.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	public function ViewTranslate($aData) {
		if (!$aData['info'])
			return '';
		
		$aInfo = json_decode($aData['info'],true);
		if (!$aInfo)
			return '';
		
		$aData=$this->CallParseTranslate($aInfo);
		Base::$tpl->assign("aDataColumn",array(
			'name'=>array('sTitle'=>Language::getDMessage('Name table')),
			'info'=>array('sTitle'=>Language::getDMessage('Status update')),
			'total'=>array('sTitle'=>Language::getDMessage('Total count')),
		));
		
		Base::$tpl->assign("aData",$aData);
		Base::$tpl->assign("sDataTemplateName",'mpanel/admin_regulations/row_admin_regulations_translate.tpl');
		return Base::$tpl->fetch('mpanel/admin_regulations/only_table.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	public function CallParseTranslate(&$aItem) {
		$aData = array();
		foreach($aItem as $iKey => $aValue) {
			$aData[] = array('name' => $iKey, 'info' => $aValue['update'], 'total' => $aValue['total']);
		}
		return $aData;
	}
	//-----------------------------------------------------------------------------------------------
	public function UpdateCatModel($sCode) {
		$aInfo = array(
			'version' => DB_OCAT,
			'inserted' => 0,
			'total' => Db::GetOne("select count(*) from cat_model")
		);
		$iTotal = $aInfo['total']; 
		if (defined('REMOTE_TECDOC')) {
			$aInfo['version'] = REMOTE_TECDOC;
			$aMassIdTof = Db::GetAssoc("Select tof_mod_id as id, tof_mod_id from cat_model order by tof_mod_id");
			$aMassInsert = TecdocDb::GetAll("Select om.ID_src tof_mod_id,man.Name brand, om.Name name
			,SUBSTRING(om.DateStart, 1, 2) month_start,SUBSTRING(om.DateStart, 4, 4) year_start
			,SUBSTRING(om.DateEnd, 1, 2) month_end,SUBSTRING(om.DateEnd, 4, 4) year_end
			,1 visible
			FROM ".DB_OCAT."cat_alt_models om
			inner join ".DB_OCAT."cat_alt_manufacturer man on om.ID_mfa=man.ID_mfa
			where om.ID_src not in (".implode(",",$aMassIdTof).")");
			$aDataInsert = array();
			foreach($aMassInsert as $aValue) 
				$aDataInsert[] = "('".$aValue['tof_mod_id']."','".mysql_escape_string($aValue['brand'])."','".
					mysql_escape_string($aValue['name'])."','".
					$aValue['month_start']."','".$aValue['year_start']."','".$aValue['month_end']."','".
					$aValue['year_end']."','1')";
			Db::Execute("insert ignore into cat_model (tof_mod_id,brand,name,month_start,year_start,month_end,year_end,visible) 
					values ".implode(", ", $aDataInsert));
		}
		else
			Db::Execute("INSERT IGNORE INTO cat_model (tof_mod_id,brand,name,month_start,year_start,month_end,year_end,visible)
			SELECT om.ID_src tof_mod_id,man.Name brand, om.Name name
			,SUBSTRING(om.DateStart, 1, 2) month_start,SUBSTRING(om.DateStart, 4, 4) year_start
			,SUBSTRING(om.DateEnd, 1, 2) month_end,SUBSTRING(om.DateEnd, 4, 4) year_end
			,1 visible
			FROM ".DB_OCAT."cat_alt_models om
			inner join ".DB_OCAT."cat_alt_manufacturer man on om.ID_mfa=man.ID_mfa
			left join cat_model m on m.tof_mod_id=om.ID_src
			where m.id is null
			order by om.ID_src");
		
		$iTotalInserted = Db::GetOne("select count(*) from cat_model");
		$aInfo['total'] = $iTotalInserted;
		$iTotalInserted -= $iTotal;
		if ($iTotalInserted > 0)
			$aInfo['inserted'] = $iTotalInserted;
		
		$sInfo = json_encode($aInfo);
		Db::Execute("update admin_regulations set date_modified=now(), info='".$sInfo."' where code='".$sCode."'");
		$this->AdminRedirect ( $this->sAction );
	}
	//-----------------------------------------------------------------------------------------------
	public function UpdateCat($sCode) {
		// first check cat_name
		require_once(SERVER_PATH.'/mpanel/spec/cat.php');
		$oCat = new ACat();
		$oCat->CheckName();
		
		$aInfo = array(
				'version' => DB_OCAT,
				'update' => 0,
				'total' => Db::GetOne("select count(*) from cat"),
				'update_link' => 0,
				'update_adres' => 0,
		);
		$iTotal = $aInfo['total'];
		
		if (defined('REMOTE_TECDOC')) {
			$aInfo['version'] = REMOTE_TECDOC; 
			$aMassIdTof = Db::GetAssoc("Select id_tof as id, id_tof from cat where id_tof > 0");
			$sSql = "SELECT *  FROM ".DB_OCAT."cat_alt_manufacturer Where ID_src not in (".implode(",",$aMassIdTof).")";
			$aUnknown = TecdocDb::GetAll($sSql);
		}
		else
			$aUnknown = Db::GetAll("SELECT *  FROM ".DB_OCAT."cat_alt_manufacturer WHERE ID_src not in (select id_tof from cat)");
		
		if ($aUnknown) {
			foreach ($aUnknown as $aValue) {
				$sNameFiltered = mb_strtoupper(str_replace(array(' ','-','#','.','/',',','_',':','[',']','(',')','*','&','+','`','\'','"','\\','<','>','?','!','$','%','^','@','~','|','=',';','{','}','№'), '',trim(Content::Translit($aValue['Name']))),'UTF-8'); 
				$aRow = Db::GetRow("Select * from cat where name='".$sNameFiltered."'");
				// change id_tof
				if ($aRow)
					Db::Execute("Update cat set id_tof = ".$aValue['ID_src']." where id=".$aRow['id']);
				else {
					// generate pref
					$sPref=String::GeneratePref();
					$aInsertData=array(
						'pref'=>$sPref,
						'name'=>$sNameFiltered,
						'title'=>$aValue['Name'],
						'id_tof'=>$aValue['ID_src'],
					);
					Db::AutoExecute("cat", $aInsertData);
					$iCatId=Db::InsertId();
					$aCatPref = Db::GetRow("Select * from cat_pref where name='".$sNameFiltered."'");
					if ($aCatPref)
						DB::Execute("update cat_pref set cat_id=".$iCatId." where id=".$aCatPref['id']);
					else
						DB::Execute("insert into cat_pref (name, cat_id) values ('".$sNameFiltered."','".$iCatId."')");
				}	
			}
		}
		$iTotalUpdate = count($aUnknown);

		if (defined('REMOTE_TECDOC')) {
			$iTotalUpdateLink = 0;
			$aMassIdTofEmptyLink = Db::GetAssoc("Select id_tof as id, id_tof from cat where id_tof > 0 and cat.link is null");
				
		    $sSql = "Select DISTINCT(t.WEB),t.ID_src FROM ".DB_OCAT."cat_alt_suppliers AS t
			WHERE t.ID_src in (".implode(",",$aMassIdTofEmptyLink).")";
		    $aWebs = TecdocDb::GetAll($sSql);
		    $aWebsAssoc = array();
		    foreach($aWebs as $aValue) { 
		    	if (!$aWebsAssoc[$aValue['ID_src']] && $aValue['WEB'] != '')
		    		$aWebsAssoc[$aValue['ID_src']] = $aValue['WEB'];
		    }
		    foreach($aMassIdTofEmptyLink as $iValue) {
		    	if ($aWebsAssoc[$iValue]) {
		    		Db::Execute("update cat set link = '".$aWebsAssoc[$iValue]."' where id_tof=".$iValue);
		    		$iTotalUpdateLink += 1;
		    	}
		    }
		    $iTotalUpdateAdres = 0;
		    $aMassIdTofEmptyAdres = Db::GetAssoc("Select id_tof as id, id_tof from cat where id_tof > 0 and cat.addres is null");
		    
		    $sSql = "Select DISTINCT (CONCAT( t.PostalCountry, ' ', t.City, ' ', t.Street ) ) as adres, t.ID_src FROM 
		    		".DB_OCAT."cat_alt_suppliers AS t
					WHERE t.ID_src in (".implode(",",$aMassIdTofEmptyAdres).")";
		    $aWebs = TecdocDb::GetAll($sSql);
		    $aWebsAssoc = array();
		    foreach($aWebs as $aValue) {
		    	if (!$aWebsAssoc[$aValue['ID_src']] && $aValue['adres'] != '')
		    		$aWebsAssoc[$aValue['ID_src']] = $aValue['adres'];
		    }
		    foreach($aMassIdTofEmptyAdres as $iValue) {
		    	if ($aWebsAssoc[$iValue]) {
		    		Db::Execute("update cat set addres = '".mysql_escape_string($aWebsAssoc[$iValue])."' where id_tof=".$iValue);
		    		$iTotalUpdateAdres += 1;
		    	}
		    }
		    
		}
		else {
		// update data cat
		Db::Execute("UPDATE `cat` c SET link = ( 
			SELECT DISTINCT (t.WEB)
			FROM ".DB_OCAT."cat_alt_suppliers AS t
			WHERE t.ID_src = c.id_tof ) where c.link is null");
		$iTotalUpdateLink = Db::GetOne("SELECT ROW_COUNT()");
				
		Db::Execute("UPDATE `cat` c SET addres = ( SELECT DISTINCT (
			CONCAT( t.PostalCountry, ' ', t.City, ' ', t.Street ) )
			FROM ".DB_OCAT."cat_alt_suppliers AS t
			WHERE t.ID_src = c.id_tof
			) where addres is null");
		$iTotalUpdateAdres = Db::GetOne("SELECT ROW_COUNT()");
		
		Db::Execute("UPDATE `cat` c SET country = ( SELECT DISTINCT (t.PostalCountry)
			FROM ".DB_OCAT."cat_alt_suppliers AS t
			WHERE t.ID_src = c.id_tof ) where country is null") ;
	
	}

		$iTotal = Db::GetOne("select count(*) from cat");
		$aInfo['total'] = $iTotal;
		$aInfo['update'] = $iTotalUpdate;
		$aInfo['update_link'] = ($iTotalUpdateLink > 0 ? $iTotalUpdateLink : 0);
		$aInfo['update_adres'] = ($iTotalUpdateAdres > 0 ? $iTotalUpdateAdres : 0);
		
		$sInfo = json_encode($aInfo);
		Db::Execute("update admin_regulations set date_modified=now(), info='".$sInfo."' where code='".$sCode."'");
		$this->AdminRedirect ( $this->sAction );
	}
	//-----------------------------------------------------------------------------------------------
	public function UpdateTypeAuto($sCode) {
		$aInfo = array(
				'version' => DB_OCAT,
				'version_db_tof' => DB_TOF,
				'update_cat' => 0,
				'update_model' => 0,
		);

		$aMassTruck = Db::GetAssoc(
			"SELECT m.ID_src, concat(mf.name, ' ', m.Name) as name
			FROM ".DB_OCAT."cat_alt_models m
			INNER JOIN ".DB_OCAT."cat_alt_manufacturer mf ON mf.ID_mfa = m.ID_mfa
			WHERE m.ID_src
			IN (
			SELECT MOD_ID
			FROM ".DB_TOF."`tof__models`
			WHERE MOD_CV =1
			)");

		if ($aMassTruck) {
			Db::Execute("Update cat_model set is_type_auto=2 where tof_mod_id in (".implode(',',array_keys($aMassTruck)).")");
			$iTotalCar = Db::GetOne("Select count(*) from cat_model where is_type_auto=1");
			$iTotalTruck = Db::GetOne("Select count(*) from cat_model where is_type_auto=2");
			$aInfo['update_model'] = $iTotalCar."/".$iTotalTruck;
			
			$aMass = Db::GetAll("SELECT c1.ID_src, c1.Name, ca.Name, cm . *
				FROM `cat_model` cm
				INNER JOIN ".DB_OCAT."cat_alt_models ca ON ca.ID_src = cm.tof_mod_id
				INNER JOIN ".DB_OCAT."cat_alt_manufacturer c1 ON c1.ID_mfa = ca.ID_mfa
				GROUP BY c1.ID_src, is_type_auto
				ORDER BY c1.ID_src");
			
			$aData = array();
			foreach($aMass as $aValue) {
				if (!$aData[$aValue['ID_src']])
					$aData[$aValue['ID_src']] = $aValue['is_type_auto'];
				elseif ($aData[$aValue['ID_src']] && $aData[$aValue['ID_src']] != $aValue['is_type_auto'])
					$aData[$aValue['ID_src']] = 3;
			}
			
			foreach($aData as $iKey => $sValue)
				Db::Execute("Update cat set is_type_auto=".$sValue." where id_tof=".$iKey);		
	
			$iTotalCar = Db::GetOne("Select count(*) from cat where is_type_auto=1");
			$iTotalTruck = Db::GetOne("Select count(*) from cat where is_type_auto=2");
			$iTotalCarTruck = Db::GetOne("Select count(*) from cat where is_type_auto=3");
			$aInfo['update_cat'] = $iTotalCar."/".$iTotalTruck."/".$iTotalCarTruck;
		}
				
		$sInfo = json_encode($aInfo);
		Db::Execute("update admin_regulations set date_modified=now(), info='".$sInfo."' where code='".$sCode."'");
		$this->AdminRedirect ( $this->sAction );
	}
}
?>