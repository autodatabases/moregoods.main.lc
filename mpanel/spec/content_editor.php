<?

/**
 * @author Mikhail Starovoyt
 * @version 0.2
 *
 * alter table script for update from @version 0.1
ALTER TABLE `drop_down`
ADD COLUMN `text_bottom` longtext NULL AFTER `is_featured`,
ADD COLUMN `text_left` longtext NULL AFTER `text_bottom`,
ADD COLUMN `is_text_bottom_visible` int(11) NULL DEFAULT 0 AFTER `text_left`,
ADD COLUMN `is_text_left_visible` int(11) NULL DEFAULT 0 AFTER `is_text_bottom_visible`;
 */

class AContentEditor extends Admin
{
	//-----------------------------------------------------------------------------------------------
	function __construct()
	{
		Repository::InitDatabase('news');

		$this->sTableName='drop_down';
		$this->sAction='content_editor';
		$this->sWinHead=Language::getDMessage('Content editor');
		$this->sPath = Language::GetDMessage('>>Content >');
		$this->sAddonPath='';
		$this->Admin();
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		$this->PreIndex();

		require_once(SERVER_PATH.'/class/core/mpanel/spec/drop_down.php');
		$oADropDown=new ADropDown();
		$oADropDown->iDataLevel=3;
		$aDropDown=$oADropDown->GetPageManagerData();
		Base::$tpl->assign('aDropDown',$aDropDown);

		if (!Base::$aRequest['data']['id']) Base::$aRequest['data']['id']=$aDropDown[0]['id'];
		$aDropDownRow=Db::GetRow(Base::GetSql('CoreDropDown',array('id'=>Base::$aRequest['data']['id'])));
		Base::$tpl->assign('aData',$aDropDownRow);

		Base::$tpl->assign('sTextEditor',Admin::GetCKEditor('data_text',$aDropDownRow['text'],700,500));
		if (Base::GetConstant('mpanel:is_left_bottom_text_active',0)) {
			Base::$tpl->assign('sTextLeftEditor',Admin::GetCKEditor('data_text_left',$aDropDownRow['text_left'],700,300));
			Base::$tpl->assign('sTextBottomEditor',Admin::GetCKEditor('data_text_bottom',$aDropDownRow['text_bottom'],700,300));
		}
		Base::$tpl->assign('sBaseAction', $this->sAction);
		Base::$sText.=Base::$tpl->fetch('mpanel/'.$this->sAction.'/form_add.tpl');
		

		$this->AfterIndex();
		Base::$oResponse->addScript("CKEDITOR.replaceAll('ckeditor');");
	}
	//-----------------------------------------------------------------------------------------------
	public function Apply()
	{
//  		$this->ProcessFCKEditors();
        foreach (Base::$aRequest as $sName => $sValue) {
            if($sName=='data_text' || $sName=='data_text_left' || $sName=='data_text_bottom') Base::$aRequest['data'][str_replace("data_", "", $sName)]=$sValue;
        }
	    
		Db::AutoExecute($this->sTableName,Base::$aRequest['data'],'UPDATE'," id='".Base::$aRequest['data']['id']."'");

		Admin::Message("MT_NOTICE", Language::GetDMessage("The page is saved."));
	}
	//-----------------------------------------------------------------------------------------------
}
?>