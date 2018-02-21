<?
require_once (SERVER_PATH . '/class/core/Admin.php');
class ACat extends Admin {
	//-----------------------------------------------------------------------------------------------
	function ACat() {
		$this->sSqlPath = 'Cat';
		$this->sTableName = 'cat';
		$this->sTablePrefix = 'c';
		$this->sAction = 'cat';
		$this->sWinHead = Language::getDMessage ('Catalog list');
		$this->sPath = Language::GetDMessage('>>Auto catalog >');
		$this->aCheckField = array ('name', 'pref', 'title');
		$this->sBeforeAddMethod='BeforeAdd';
		$this->Admin ();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {
		$this->PreIndex();

		$oTable=new Table();
		$oTable->aColumn=array(
		'id' => array('sTitle'=>'Id', 'sOrder'=>$this->sTablePrefix.'.id'),
		'name' => array('sTitle'=>'Name', 'sOrder'=>$this->sTablePrefix.'.name'),
		//'description' => array('sTitle'=>'Description', 'sOrder'=>$this->sTablePrefix.'.description'),
		'pref' => array('sTitle'=>'Prefix', 'sOrder'=>$this->sTablePrefix.'.pref'),
		'title' => array('sTitle'=>'Title', 'sOrder'=>$this->sTablePrefix.'.title'),
		'image' => array('sTitle'=>'Image', 'sOrder'=>$this->sTablePrefix.'.image'),
		'id_tof' => array('sTitle'=>'Id tof', 'sOrder'=>$this->sTablePrefix.'.id_tof'),
		'is_brand' => array('sTitle'=>'Is brand', 'sOrder'=>$this->sTablePrefix.'.is_brand'),
		'is_vin_brand' => array('sTitle'=>'Is vin brand', 'sOrder'=>$this->sTablePrefix.'.is_vin_brand'),
		'is_main' => array('sTitle'=>'Is main', 'sOrder'=>$this->sTablePrefix.'.is_main'),
		'visible' => array('sTitle'=>'Visible', 'sOrder'=>$this->sTablePrefix.'.visible'),
		'action' => array(),
		);
		
		$this->SetDefaultTable($oTable);
		Base::$sText.=$oTable->getTable();

		$this->AfterIndex();
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeApply() {
		Base::$aRequest['data']['name']=$this->BrandReplace(Base::$aRequest['data']['name']);
		Base::$aRequest['data']['pref']=substr(mb_strtoupper(str_replace(array(' ','-','#','.','/',',','_',':','[',']','(',')','*','&','+','`','\'','"','\\','<','>','?','!','$','%','^','@','~','|','=',';','{','}','№'), '', trim(Content::Translit(Base::$aRequest['data']['pref']))),'UTF-8'),0,3);
		
		Base::$aRequest['data']['parser_patern']=mysql_real_escape_string(trim(Base::$aRequest['data']['parser_patern']));
		Base::$aRequest['data']['parser_before']=mysql_real_escape_string(trim(Base::$aRequest['data']['parser_before']));
		Base::$aRequest['data']['trim_left_by']=mysql_real_escape_string(trim(Base::$aRequest['data']['trim_left_by']));
		Base::$aRequest['data']['trim_right_by']=mysql_real_escape_string(trim(Base::$aRequest['data']['trim_right_by']));
		Base::$aRequest['data']['parser_after']=mysql_real_escape_string(trim(Base::$aRequest['data']['parser_after']));
	}
	//-----------------------------------------------------------------------------------------------
	public function AfterApply($aBeforeRow,$aAfterRow) {
		if($aAfterRow) {
			Base::$db->Execute("update cat set pref=upper(pref) where id=".$aAfterRow['id']);
			//Base::$db->Execute("insert ignore into `cat_pref` (`name`, `pref`) VALUES (upper('".$aAfterRow['name']."'), upper('".$aAfterRow['pref']."'));");
			Base::$db->Execute("insert ignore into `cat_pref` (`name`, `cat_id`) VALUES (upper('".$aAfterRow['name']."'), '".$aAfterRow['id']."');");
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function CheckField()
	{
		if ($this->aCheckField)
		foreach ( $this->aCheckField as $value ) {
			if (strlen(Base::$aRequest ['data'] [$value]) == 0) 
				return false;
			
			if ($value=='pref'){
				//check existing pref
				if (Base::$aRequest['data']['id']) $sWhere=" and id<>'".Base::$aRequest['data']['id']."'";
				$bExist=Db::GetOne("select count(*) from cat where pref='".Base::$aRequest['data']['pref']."' ".$sWhere);
				if ($bExist) {
					$this->Message('MT_ERROR',Language::getDMessage ( 'This pref already exists' ));
					$this->bAlreadySetMessage = true;
					return false;
				}
			}
		}
		return true;
	}
	//-----------------------------------------------------------------------------------------------
	public function BrandReplace($sBrand='') {
		return mb_strtoupper(str_replace(array(' ','-','#','.','/',',','_',':','[',']','(',')','*','&','+','`','\'','"','\\','<','>','?','!','$','%','^','@','~','|','=',';','{','}','№'), '', trim(Content::Translit($sBrand))),'UTF-8');
	}
	//-----------------------------------------------------------------------------------------------
	public function BeforeAddAssign(&$aData) {
		if ($aData['parser_patern'])
			$aData['parser_patern'] = stripslashes($aData['parser_patern']);
	}
}
?>