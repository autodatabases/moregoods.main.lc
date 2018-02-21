<?
/**
 * @author Aleksandr Starovoyt
 */
class CatalogManager extends Catalog
{
	var $sPrefix="catalog_manager";
	var $sPrefixAction="";
	var $sPathToFile="/imgbank/Image/pic/";
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{

	}
	//-----------------------------------------------------------------------------------------------
	public function EditName()
	{
		$aCats=Db::GetAssoc("select c.id_tof,c.id,c.pref,c.title,c.image,c.name from cat as c where c.visible=1");
		
		Auth::NeedAuth('manager');
		if (!(CATALOG_MANAGER === true)) {
			Base::$sText .= Language::GetText('This module unavailable in standart version');
			return;
		}
		Base::Message();
		$this->sPrefixAction=$this->sPrefix."_edit_name";
		Base::$tpl->assign('sBaseAction',$this->sPrefixAction);
		//Base::$aTopPageTemplate=array('panel/tab_price.tpl'=>$this->sPrefix);
		//Debug::PrintPre(Base::$aRequest);

		if (Base::$aRequest['is_post']){

			if (!Base::$aRequest['data']['item_code']['id_price_group']
			) {
				
				Base::Message(array('MF_ERROR'=>'Required fields code'));
				Base::$aRequest['action']=$this->sPrefixAction;
				Base::$tpl->assign('aData',Base::$aRequest['data']);

			} else {
				
				$aData=Base::$aRequest['data'];
				list($aData['pref'],$aData['code'])=explode('_',$aData['item_code']);

				if (trim($aData['name_rus'])) {
					$aData['name_rus']=stripslashes($aData['name_rus']);
					$aData['comment']='edit';
					Manager::AddWeightName($aData);
				}
		
				
				Db::AutoExecute('cat_part',array(
				'information'=>$aData['information'],
				'hide_tof_image'=>$aData['hide_tof_image'],
				'catalog'=>$aData['catalog'],
				'catalog_size1'=>str_replace(',','.',$aData['catalog_size1']),
				'catalog_size2'=>str_replace(',','.',$aData['catalog_size2']),
				'catalog_size3'=>str_replace(',','.',$aData['catalog_size3']),
				),'UPDATE',"item_code='".$aData['item_code']."'");
				
				if (!Base::$aRequest['item_code']) {
					Db::Execute("delete from price_group_assign where item_code='"
							.$aData['item_code']."'");
				}
				Db::Execute("insert into price_group_assign
					(id_price_group, item_code) values
					('".$aData['id_price_group']."','".$aData['item_code']."')");
				$sMessage="&aMessage[MT_NOTICE]=Data updated";

				Form::RedirectAuto($sMessage);
			}
		}

		//if (Base::$aRequest['action']==$this->sPrefix.'_add'||Base::$aRequest['action']==$this->sPrefix.'_edit') {
		//Debug::PrintPre(Base::$aRequest);

		if (Base::$aRequest['data']['item_code'] ) {
	
			$aData=Db::GetRow(Base::GetSql("CatPart",array("item_code"=>Base::$aRequest['data']['item_code'])));
			if (!$aData) {
				$aData['item_code']=Base::$aRequest['data']['item_code'];
				list($aData['pref'],$aData['code'])=explode('_',$aData['item_code']);
				Db::AutoExecute('cat_part',$aData);
				$aData['id_cat_part']=Db::InsertId();
			
			}
		}

		//$aData=Db::GetRow(Base::GetSql("CatPart",array("item_code"=>Base::$aRequest['data']['item_code'])));
		Base::$tpl->assign('aData',$aData);

		//$aPartInfo=Db::GetRow(Base::GetSql("Catalog/PartInfo",array("art_id"=>Base::$aRequest['data']['art_id'])));
		//Base::$tpl->assign('aPartInfo',$aPartInfo);
		$aPartInfo=TecdocDb::GetPartInfo(array(
			'item_code'=>Base::$aRequest['data']['item_code']
		), $aCats);
		if ($aPartInfo) {
			if (!$aPartInfo['art_id']) {
				$sArtId = Catalog::GetArtId($aPartInfo['item_code']);
				if ($sArtId)
					$aPartInfo['art_id'] = $sArtId;
			}
			
			if ($aPartInfo['art_id'] && !Base::$aRequest['data']['art_id'])
				Base::$aRequest['data']['art_id']=$aPartInfo['art_id'];
		}

		Base::$tpl->assign('aCatalog',array(
		''=>  Language::GetMessage('Catalog all'),
		'clips'=>  Language::GetMessage('Catalog clips'),
		));

		Base::$tpl->assign("aPriceGroup2",array(""=>"")+Db::GetAssoc("
				select  id , name FROM price_group"));

		Base::$tpl->assign("aselectPrice",Db::GetOne("
				select  id_price_group 
				FROM price_group_assign where item_code like '".Base::$aRequest['data']['item_code']."'"));
		
		$oForm=new Form();
		$oForm->sHeader="method=post";
		$oForm->sTitle="Edit";
		$oForm->sContent=Base::$tpl->fetch($this->sPrefix.'/form_'.$this->sPrefix.'_edit_name.tpl');
		$oForm->sSubmitButton='Apply';
		$oForm->sSubmitAction=$this->sPrefixAction;
		$oForm->sReturnButton='<< Return';
		$oForm->bAutoReturn=true;
		$oForm->bIsPost=true;
		//$oForm->sWidth="470px";
		//$oForm->sRightTemplate=$this->sPrefix.'/right_'.$this->sPrefix.'_edit_name.tpl';
		//$oForm->sReturn=Base::RemoveMessageFromUrl($_SERVER ['QUERY_STRING']);
		
		Base::$sText.=$oForm->getForm();
		
		$oTable=new Table();
		$oTable->sType='array';
		/*$oTable->aDataFoTable=Db::GetAll(Base::GetSql("Catalog/PartCriteria",array(
		'aId'=>array($aPartInfo['art_id']),
		'aIdCatPart'=>array($aData['id_cat_part']),
		"type_"=>"all_edit"
		)));
		*/
		$oTable->aDataFoTable=TecdocDb::GetCriterias(array(
			'aId'=>array(Base::$aRequest['data']['art_id']),
			'aIdCatPart'=>array($aPartInfo['id_cat_part']),
			"type_"=>"all_edit"
		));

		//$oTable->sSql=Base::GetSql("Catalog/Part",Base::$aRequest['data']);
		$oTable->aColumn['name']=array('sTitle'=>'Parametre','sWidth'=>'40%');
		$oTable->aColumn['value']=array('sTitle'=>'Description','sWidth'=>'50%');
		$oTable->aColumn['action']=array('sTitle'=>'','sWidth'=>'5%');

		$oTable->iRowPerPage=500;
		$oTable->sDataTemplate=$this->sPrefix.'/row_part_criteria.tpl';
		//$oTable->aCallback=array($this,'CallParsePart');
		//$oTable->aOrdered=" ";
		$oTable->sNoItem='No description';
		$oTable->bStepperVisible=false;
		$oTable->sSubtotalTemplateTop=$this->sPrefix."/subtotal_part_criteria_top.tpl";
		//Base::$tpl->assign('sTableCriteria',$oTable->getTable());
		
		Base::$sText.=$oTable->GetTable();

		return;

	}
	//-----------------------------------------------------------------------------------------------
	
	public function EditPic()
	{
		Auth::NeedAuth('manager');
		Base::Message();
		if (!(CATALOG_MANAGER === true)) {
			Base::$sText .= Language::GetText('This module unavailable in standart version');
			return;
		}
		Base::$bXajaxPresent=true;

		$this->sPrefixAction=$this->sPrefix."_edit_pic";
		Base::$tpl->assign('sBaseAction',$this->sPrefixAction);

		if (Base::$aRequest['action']==$this->sPrefix."_delete_pic" && Base::$aRequest['id']) {
			Db::Execute("delete from cat_pic where id=".Base::$aRequest['id']);
			$sMessage="&aMessage[MT_NOTICE]=Image delete";
			Form::RedirectAuto($sMessage);
		}

		if (Base::$aRequest['data']['item_code'] ) {

			$aData=Db::GetRow(Base::GetSql("CatPart",array("item_code"=>Base::$aRequest['data']['item_code'])));
			if (!$aData) {
				$aData['item_code']=Base::$aRequest['data']['item_code'];
				list($aData['pref'],$aData['code'])=explode('_',$aData['item_code']);
				Db::AutoExecute('cat_part',$aData);
				$aData['id']=Db::InsertId();
			}
			Base::$tpl->assign('aData',$aData);
			
			$aDataForm=array(
			'sHeader'=>"method=post enctype='multipart/form-data'",
			//'sTitle'=>"Import cross",
			'sContent'=>Base::$tpl->fetch($this->sPrefix."/form_".$this->sPrefix."_import_image.tpl"),
			'sSubmitButton'=>'Load',
			'sSubmitAction'=>$this->sPrefix.'_upload_many_pics',
			'sReturnButton'=>'<< Return',
			'bAutoReturn'=>true,
			'sWidth'=>"400px",
			);
			$oForm=new Form($aDataForm);
			Base::$sText.=$oForm->getForm();

			//$aPartInfo=Db::GetRow(Base::GetSql("Catalog/PartInfo",array("art_id"=>Base::$aRequest['data']['art_id'])));
			//Base::$tpl->assign('aPartInfo',$aPartInfo);

			/*$aGraphic=Db::GetAll(Base::GetSql("OptiCatalog/Graphic",array(
			'aIdGraphic'=>array(Base::$aRequest['data']['art_id']),
			'aIdCatPart'=>array($aData['id']),
			)));
			*/
			$aGraphic=TecdocDb::GetImages(array(
				'aIdGraphic'=>array(Base::$aRequest['data']['art_id']),
				'aIdCatPart'=>array($aData['id'])
			),$this->aCats,false);

			Base::$tpl->assign('aGraphic',$aGraphic);

			/*$aPdf=Db::GetAll(Base::GetSql("Catalog/Graphic",array(
			'aIdGraphic'=>array(Base::$aRequest['data']['art_id']),
			'aIdCatPart'=>array($aData['id']),
			"type_image"=>"pdf"
			)));*/
			$aPdf=TecdocDb::GetImages(array(
				'aIdGraphic'=>array(Base::$aRequest['data']['art_id']),
				'aIdCatPart'=>array($aData['id']),
				"type_image"=>"pdf"
			),false,false);
				
			Base::$tpl->assign('aPdf',$aPdf);
			Base::$tpl->assign('sReturn',Base::RemoveMessageFromUrl($_SERVER ['QUERY_STRING']));

			$oForm=new Form();
			$oForm->sHeader="method=post";
			$oForm->sTitle="Edit Image";
			$oForm->sContent=Base::$tpl->fetch($this->sPrefix.'/form_'.$this->sPrefix.'_edit_pic.tpl');
			//$oForm->sSubmitButton='Apply';
			//$oForm->sSubmitAction=$this->sPrefixAction;
			$oForm->sReturnButton='<< Return';

			$oForm->bAutoReturn=true;
			$oForm->bIsPost=true;
			$oForm->sWidth="300px";

			Base::$sText.=$oForm->getForm();


			return;
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function UploadManyPics(){
		//Debug::PrintPre($_FILES, false);
		if ($_FILES['import_file']['name']) {
			foreach($_FILES['import_file']['name'] as $sKey=>$sValue){
				//Debug::PrintPre($sValue, false);
				$uploaddir = '/imgbank/Image/pic/';
				if (!is_dir(SERVER_PATH.$uploaddir)) {
					mkdir(SERVER_PATH.$uploaddir, 0777);
				}
	
				Db::AutoExecute("cat_pic",array('width'=>150));
				$id_file=Db::InsertId();
	
				$aFilePart = pathinfo($sValue);
				$sFullPath = $uploaddir . $id_file . "_" . $aFilePart['basename'];
				$file = SERVER_PATH.$sFullPath;
	
				if (move_uploaded_file($_FILES['import_file']['tmp_name'][$sKey], $file)) {
					//Debug::PrintPre($_FILES['import_file']['tmp_name'][$sKey], false);
					$aData['image']=$sFullPath;
					$aData['pic']=$aFilePart['filename'];
					$aData['extension']=$aFilePart['extension'];
					$aData['id_cat_part']=Base::$aRequest['id_cat_part'];
	//Debug::PrintPre($aData);
					Db::AutoExecute("cat_pic",Db::Escape($aData), "UPDATE", "id=".$id_file);
	
					//echo $id_file;
				} else {
					echo 0;
				}
			}
		} else {
			echo 0;
		}
		CatalogManager::EditPic();
		//die();
	}
	//-----------------------------------------------------------------------------------------------
	/**
	 * upload file
	 */
	public function UploadPic(){
		if ($_FILES['uploadfile']['name']) {
			$uploaddir = '/imgbank/Image/pic/';
			if (!is_dir(SERVER_PATH.$uploaddir)) {
				mkdir(SERVER_PATH.$uploaddir, 0777);
			}

			Db::AutoExecute("cat_pic",array('width'=>150));
			$id_file=Db::InsertId();

			$aFilePart = pathinfo($_FILES['uploadfile']['name']);
			$sFullPath = $uploaddir . $id_file . "_" . $aFilePart['basename'];
			$file = SERVER_PATH.$sFullPath;

			if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {
				$aData['image']=$sFullPath;
				$aData['pic']=$aFilePart['filename'];
				$aData['extension']=$aFilePart['extension'];
				$aData['id_cat_part']=Base::$aRequest['id_cat_part'];

				Db::AutoExecute("cat_pic",Db::Escape($aData), "UPDATE", "id=".$id_file);

				echo $id_file;
			} else {
				echo 0;
			}
		} else {
			echo 0;
		}

		die();
	}
	//-----------------------------------------------------------------------------------------------
	public function ViewPicList(){
		Auth::NeedAuth('manager');
		Base::$oContent->NeedRole('tab_pic');
		Base::Message();
		
		Base::$sText.=Base::$tpl->fetch ("catalog_manager/pic_list.tpl");
		
		Base::$tpl->assign('aData',$aData);

		
		
		$oTable=new Table();
		$oTable->sType='array';
		$oTable->aDataFoTable=Db::GetAll(Base::GetSql("Manager/Pic",array(
		//empty
		)));

		$oTable->aColumn['id']=array('sTitle'=>'Id','sWidth'=>'5%');
		$oTable->aColumn['make']=array('sTitle'=>'Make');
		$oTable->aColumn['pref']=array('sTitle'=>'Pref');
		$oTable->aColumn['code']=array('sTitle'=>'Code');
		$oTable->aColumn['pic_name']=array('sTitle'=>'Pic name');
		$oTable->aColumn['extension']=array('sTitle'=>'Extension','sWidth'=>'5%');
		$oTable->aColumn['action']=array('sTitle'=>'','sWidth'=>'15%');

		$oTable->iRowPerPage=50;
		$oTable->sDataTemplate=$this->sPrefix.'/row_images.tpl';
		$oTable->sNoItem='No description';
		$oTable->bStepperVisible=true;
		//Base::$tpl->assign('sTableCriteria',$oTable->getTable());
		
		Base::$sText.=$oTable->GetTable();

		return;
	}
	//-----------------------------------------------------------------------------------------------
	public function UploadMakeCodePic(){
		$iFilesCount=count($_FILES['file']['error']);
		
		for ($iFile=0;$iFile<$iFilesCount;$iFile++){
			$name = $_FILES['file']['name'][$iFile];
			
			if(!preg_match("/(image)(\\/)(jpg|png|jpeg|gif)/",$_FILES['file']['type'][$iFile])) break;
			
			if ($_FILES['file']['name'][$iFile]) {
			$uploaddir = '/imgbank/Image/pic/';
			if (!is_dir(SERVER_PATH.$uploaddir)) {
				mkdir(SERVER_PATH.$uploaddir, 0777);
			}

			$aFilePart = pathinfo($_FILES['file']['name'][$iFile]);
			
			//$aMakeCode=explode("_",$aFilePart['filename'],2);
			$iIdCatPart=Db::GetOne("select id from cat_part where `item_code`='".$aFilePart['filename']."'");
			if(!$iIdCatPart) {
				break;
			}
			
			Db::AutoExecute("cat_pic",array('width'=>150));
			$id_file=Db::InsertId();
			
			$sFullPath = $uploaddir . $id_file . "_" . $aFilePart['basename'];
			$file = SERVER_PATH.$sFullPath;

			if (move_uploaded_file($_FILES['file']['tmp_name'][$iFile], $file)) {
				$aData['image']=$sFullPath;
				$aData['pic']=$aFilePart['filename'];
				$aData['extension']=$aFilePart['extension'];
				$aData['id_cat_part']=$iIdCatPart;

				Db::AutoExecute("cat_pic",Db::Escape($aData), "UPDATE", "id=".$id_file);

			//	echo $id_file;
			} else {
			//	echo 0;
			}
		} else {
		//	echo 0;
		}
		}

	//	die();
		Form::RedirectAuto("action=catalog_manager_pic_list&aMessage[MT_NOTICE]=item addded");
	}
	//-----------------------------------------------------------------------------------------------
	public function AddInfo($aData=array()) {
		Auth::NeedAuth('manager');

		if (!$aData) {
			$aData=String::FilterRequestData(Base::$aRequest['data']);
		}

		if ($aData['id_cat_part'] && $aData['name']) {
			Db::AutoExecute("cat_info",$aData);
			$sMessage="&aMessage[MF_NOTICE]=item addded";
		} else {
			$sMessage="&aMessage[MF_ERROR]=need name";
		}

		if (Base::$aRequest['return']) Form::RedirectAuto($sMessage);

	}
	//-----------------------------------------------------------------------------------------------
	public function DeleteInfo($aData=array()) {
		Auth::NeedAuth('manager');

		if (!$aData) {
			$aData['id']=Base::$aRequest['id'];
		}

		if ($aData['id']) {
			Db::Execute("delete from cat_info where id=".$aData['id']);
			$sMessage="&aMessage[MF_NOTICE]=item deleted";
		} else {
			$sMessage="&aMessage[MF_ERROR]=error";
		}

		if (Base::$aRequest['return']) Form::RedirectAuto($sMessage);

	}
	//-----------------------------------------------------------------------------------------------
	public function SetItemCodeImage()
	{
		Auth::NeedAuth("manager");

		Db::Execute("
			update cat_pic_import as cpi
			inner join cat_pref as cp on cpi.brand=cp.name
			set cpi.code=".Catalog::StripCodeSql('cpi.code_in')."
			, cpi.pref=cp.pref
			, item_code=concat(cp.pref,'_',".Catalog::StripCodeSql('cpi.code_in').")
		");

		Db::Execute("
			insert ignore into cat_part (item_code, pref, code )
			select cpi.item_code, cpi.pref, cpi.code 
			from cat_pic_import as cpi 
			where cpi.item_code is not null and cpi.item_code<>''
		");

		Db::Execute("
			update cat_pic_import as cpi
			inner join cat_part as cp on cpi.item_code=cp.item_code
			set id_cat_part=cp.id, image=concat('/imgbank/Image/pic/',folder,'/',pic,'.',extension)
		");

		Form::RedirectAuto("&aMessage[MT_NOTICE]=Item code set sucsessfuly");
	}
	//-----------------------------------------------------------------------------------------------
	public function ImportImage()
	{
		Auth::NeedAuth("manager");
		$this->sPrefixAction=$this->sPrefix."_import_image";
		//Base::$aTopPageTemplate=array('panel/tab_price.tpl'=>$this->sPrefix);
		Base::Message();

		if (Base::$aRequest['is_post'] ) {
			if (is_uploaded_file($_FILES['import_file']['tmp_name'])) {
				//if (Base::$aRequest['data']['id_user_provider'] && Base::$aRequest['data']['pref']) {

				$oExcel= new Excel();
				$oExcel->ReadExcel5($_FILES['import_file']['tmp_name'],true);
				$oExcel->SetActiveSheetIndex();
				$oExcel->GetActiveSheet();

				$aResult=$oExcel->GetSpreadsheetData();

				if ($aResult) foreach ($aResult as $sKey=>$aValue) {

					if ($sKey==1) $aKey=$aValue;
					elseif ($sKey>1)
					{
						unset($aData);
						foreach ($aKey as $sKey1 => $aValue1) $aData[$aValue1]=mysql_escape_string($aValue[$sKey1]);
						//if ($aData['brand']) $aData['pref']=trim($aPref[strtoupper($aData['brand'])]);
						//$aData['id_oil_type']=Accessory::GetIdOilType($aData['oil_type']);
						//$aData['id_oil_composition']=Accessory::GetIdOilComposition($aData['composition']);

						if (1 || $aData['item_code']) {
							Db::AutoExecute("cat_pic_import",$aData);
						}
					}
				}
				$sMessage="&aMessage[MI_NOTICE]=Upload and processing sucsessfuly";
				Form::Redirect("?action=catalog_manager_import_image".$sMessage);

				//} else Base::Message(array('MI_ERROR'=>'Required fields provider, pref'));
			} else Base::Message(array('MI_ERROR'=>'Possible file upload attack'));
		}

		$aData=array(
		'sHeader'=>"method=post enctype='multipart/form-data'",
		//'sTitle'=>"Import cross",
		'sContent'=>Base::$tpl->fetch($this->sPrefix."/form_".$this->sPrefix."_import_image.tpl"),
		'sSubmitButton'=>'Load',
		'sSubmitAction'=>$this->sPrefixAction,
		'sReturnButton'=>'<< Return',
		'bAutoReturn'=>true,
		'sWidth'=>"400px",
		);
		$oForm=new Form($aData);
		Base::$sText.=$oForm->getForm();

		$oTable=new Table();
		$oTable->sSql=Base::GetSql("CatPicImport", Base::$aRequest['search']);
		$oTable->iRowPerPage=50;
		//$oTable->aOrdered="order by aoi.id";
		$oTable->aColumn=array(
		'id_cat_part'=>array('sTitle'=>'id cat part','sWidth'=>'5%'),
		'item_code'=>array('sTitle'=>'item_code','sWidth'=>'15%'),
		'brand'=>array('sTitle'=>'Brand','sWidth'=>'10%'),
		'code_in'=>array('sTitle'=>'Code_in','sWidth'=>'10%'),
		'folder'=>array('sTitle'=>'Folder','sWidth'=>'10%'),
		'pic'=>array('sTitle'=>'pic','sWidth'=>'10%'),
		'extension'=>array('sTitle'=>'extension','sWidth'=>'10%'),
		'image'=>array('sTitle'=>'image','sWidth'=>'30%'),
		//'width'=>array('sTitle'=>'width image','sWidth'=>'10%'),
		//'action'=>array(),
		);
		$oTable->sDataTemplate=$this->sPrefix.'/row_'.$this->sPrefix.'_import_image.tpl';

		//$oTable->aCallback=array($this,'CallParsePrice');

		Base::$sText.=$oTable->getTable("Catalog manager Image Import");
		Base::$sText.=Base::$tpl->fetch($this->sPrefix.'/button_'.$this->sPrefix.'_import_image.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	public function DeleteImportImage()
	{
		Auth::NeedAuth("manager");
		if (Base::$aRequest['imported'] )
		{
			/*
			$aRow=Db::GetAssoc("select adi.id, adi.id as name
			from accessory_disk_import as adi
			left join accessory_disk as ad on adi.item_code=ad.item_code
			where ad.id is null");

			if ($aRow) Db::Execute("delete from accessory_disk_import where id not in(".implode(",",$aRow).")");
			else Db::Execute("TRUNCATE accessory_disk_import");
			*/

		} else {
			Db::Execute("TRUNCATE cat_pic_import");
		}

		Form::RedirectAuto();
	}
	//-----------------------------------------------------------------------------------------------
	public function SetImportImage()
	{
		Auth::NeedAuth("manager");

		Db::Execute("
		insert ignore into cat_pic (id_cat_part, image, pic, extension, width)
		select id_cat_part, image, pic, extension, width
		from cat_pic_import as cpi
		");

		Db::Execute("truncate cat_pic_import");
		Base::Redirect("?action=".$this->sPrefix."_import_image&aMessage[MT_NOTICE]=Added sucsessfuly");
	}
	//-----------------------------------------------------------------------------------------------
	public function ModelType()
	{
		Base::$tpl->assign("sBaseAction", $this->sPrefix."_model_type");
		
		/* [ apply  */
		if (Base::$aRequest['is_post'])
		{
			if (!Base::$aRequest['data']['pref'] || !Base::$aRequest['data']['code_name'])
			{
				Base::Message(array('MF_ERROR'=>'Required fields brand and code'));
				Base::$tpl->assign('aData', Base::$aRequest['data']);
			}
			else
			{
				//Debug::PrintPre(Base::$aRequest);
				$aData=Base::$aRequest['data'];
				
				$aData["code"]=Catalog::StripCode(strtoupper($aData["code_name"]));
				$aData["item_code"]=$aData['pref']."_".$aData['code'];
				$aRow=Db::GetRow("select * from cat_part where item_code='".$aData['item_code']."'");
				
				if (!$aRow)
				{
					Db::AutoExecute('cat_part',$aData);
					$aRow['id']=Db::InsertId();
				}
								
				Db::Execute("insert ignore into cat_model_type_link (id_cat_model_type, id_cat_part) 
				values ('".$aData['id_model_detail']."','".$aRow['id']."')");
				
				Db::Execute("insert ignore into cat_group_icon_link (id_cat_group_icon, id_cat_part) 
				values ('".$aData['id_part']."','".$aRow['id']."')");
				
				$sMessage="&aMessage[MF_NOTICE]=Part added";
				
				Form::RedirectAuto($sMessage);
			}
		}
		/* ] apply */


		if (Base::$aRequest['data']['id_model_detail'] && Base::$aRequest['data']['id_part']) {

			Auth::NeedAuth("manager");
			Base::$tpl->assign("aPref",array(""=>"")+Db::GetAssoc("Assoc/Pref", array('id_sync'=>'>0')));
			$oCatalog = new Catalog();
			$oCatalog->GetNavigator(Base::$aRequest['data']);
			$aTree=Db::GetAll(Base::GetSql("Catalog/Assemblage",Base::$aRequest['data']));

			$sGroup=$aTree[0]['data'];
			Base::$tpl->assign("sGroup",$sGroup);




			$aData=array(
			'sHeader'=>"method=post",
			'sTitle'=>"Add new part to group",
			'sContent'=>Base::$tpl->fetch($this->sPrefix.'/form_model_type.tpl'),
			'sSubmitButton'=>'add',
			'sSubmitAction'=>$this->sPrefix."_model_type",
			'sReturnButton'=>'<< Return',
			'bAutoReturn'=>true,
			'sWidth'=>"300px",
			);
			$oForm=new Form($aData);
			Base::$sText.=$oForm->getForm();



			$oTable=new Table();
			$oTable->sType='array';
			$oTable->aDataFoTable=Db::GetAll(Base::GetSql("Catalog/PartDetail",array(
			'id_cat_model_type'=>Base::$aRequest['data']['id_model_detail'],
			'id_part'=>Base::$aRequest['data']['id_part'],
			"type_"=>"all_edit"
			)));

			//$oTable->sSql=Base::GetSql("Catalog/Part",Base::$aRequest['data']);
			$oTable->aColumn['brand']=array('sTitle'=>'Brand','sWidth'=>'40%');
			$oTable->aColumn['art_article_nr']=array('sTitle'=>'Code','sWidth'=>'50%');
			$oTable->aColumn['action']=array('sTitle'=>'','sWidth'=>'5%');

			$oTable->iRowPerPage=500;
			$oTable->sDataTemplate=$this->sPrefix.'/row_model_type.tpl';
			//$oTable->aCallback=array($this,'CallParsePart');
			//$oTable->aOrdered=" ";
			$oTable->sNoItem='No description';
			$oTable->bStepperVisible=false;
			Base::$sText.=$oTable->GetTable();
			//Debug::PrintPre($oTable->aDataFoTable);

			//Base::$tpl->assign('sTableCriteria',$oTable->getTable());

		}
	}
	//-----------------------------------------------------------------------------------------------
	public function ModelTypeDelete($aData=array()) {
		Auth::NeedAuth('manager');

		if (!$aData) {
			$aData['id_cat_part']=Base::$aRequest['id'];
			$aData['id_cat_model_type']=Base::$aRequest['data']['id_model_detail'];
			$aData['id_cat_group_icon']=Base::$aRequest['data']['id_part'];
		}
		
		if ($aData['id_cat_part']) {
			Db::Execute("delete from cat_model_type_link
			where id_cat_part='".$aData['id_cat_part']."' and id_cat_model_type='".$aData['id_cat_model_type']."'");
			
			Db::Execute("delete from cat_group_icon_link 
			where id_cat_part='".$aData['id_cat_part']."' and id_cat_group_icon='".$aData['id_cat_group_icon']."'");
			
			$sMessage="&aMessage[MT_NOTICE]=item deleted";
		} else {
			$sMessage="&aMessage[MT_ERROR]=error";
		}

		if (Base::$aRequest['return']) Form::RedirectAuto($sMessage);

	}
	//-----------------------------------------------------------------------------------------------
	public function AddCatInfo($aData)
	{
		set_time_limit(0);

		$oCatalog = new Catalog();

		$aPartInfo=Db::GetRow(Base::GetSql("Catalog/PartInfo",array(
		'sCode'=>$aData['code'],
		'pref'=>$aData['pref']
		)));

		$aPartInfoFrom=Db::GetRow(Base::GetSql("Catalog/PartInfo",array(
		'sCode'=>$aData['code_from'],
		'pref'=>$aData['pref_from']
		)));

		//Debug::PrintPre($aPartInfo,false);
		//Debug::PrintPre($aPartInfoFrom);

		if ($aPartInfoFrom['art_id'] && $aPartInfo['id_cat_part']) {

			$aDataOriginal=Db::GetAll(Base::GetSql("Catalog/PartOriginal",array(
			'art_id'=>$aPartInfoFrom['art_id']
			)));

			if ($aDataOriginal) {
				foreach ($aDataOriginal as $sKey => $aValue) {
					$aData['pref']=$aPartInfo['pref'];
					$aData['code']=Catalog::StripCode($aPartInfo['code']);
					$aData['pref_crs']=Db::GetOne("select pref from cat where title='".$aValue['name']."'");
					$aData['code_crs']=Catalog::StripCode($aValue['number']);

					$oCatalog->InsertCross($aData);
				}
			}

			$aDataCriteria=Db::GetAll(Base::GetSql("Catalog/PartCriteria",array(
			'aId'=>array($aPartInfoFrom['art_id']),
			"type_"=>"all"
			)));

			if ($aDataCriteria) {
				foreach ($aDataCriteria as $sKey => $aValue) {
					$aValue=Db::Escape($aValue);
					Db::Execute("
					insert ignore into cat_info (id_cat_part, name, code)
					values ('".$aPartInfo['id_cat_part']."','".$aValue['krit_name']."','".$aValue['krit_value']."')
					");
				}
			}

			$aGraphic=Db::GetAll(Base::GetSql("Catalog/Graphic",array(
			'aIdGraphic'=>array($aPartInfoFrom['art_id']),
			)));

			if ($aGraphic) {
				foreach ($aGraphic as $sKey => $aValue) {
					$aFilePart = pathinfo($aValue['img_path']);
					$aValue=Db::Escape($aValue);
					if ($aPartInfo['id_cat_part']) {
						Db::Execute("
						insert ignore into cat_pic (id_cat_part, image, pic, extension, width)
						values ('".$aPartInfo['id_cat_part']."','".$aValue['img_path']."','".$aFilePart['filename']."'
						,'".$aFilePart['extension']."','".$aValue['img_width']."')
						");
					}
				}
			}

			$aType=Db::GetAll(Base::GetSql("Catalog/ModelDetail",array(
			'code'=>Catalog::StripCode($aPartInfoFrom['code']),
			'art_id'=>$aPartInfoFrom['art_id'],
			)));

			if ($aType) foreach ($aType as $sKey => $aValue) {
				Db::Execute("insert ignore into cat_model_type_link (id_cat_model_type,id_cat_part)
				values ('".$aValue['typ_id']."','".$aPartInfo['id_cat_part']."')
				");
			}
		} else {
			return false;
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function UpdateNumber(){
		if(Base::$aRequest['table']=='cat_pic_tecdoc') {
			$bExist=Db::GetOne("select path from cat_pic_tecdoc where path='".Base::$aRequest['row_id']."'");
			if(!$bExist) Db::Execute("insert ignore into cat_pic_tecdoc (path) values ('".Base::$aRequest['row_id']."') ");
		}
			
		Db::Execute("update ".Base::$aRequest['table']." set ".Base::$aRequest['col']."='".Base::$aRequest['number']."' where ".Base::$aRequest['row']."='".Base::$aRequest['row_id']."'");
	}
	//-----------------------------------------------------------------------------------------------
}
?>