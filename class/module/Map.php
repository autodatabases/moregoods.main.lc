<?
/**
 * @author Oleksandr Starovoit
 * 
 */

class Map extends Base 
{

	var $sPrefix="map";
	var $aMap=array();

	//-----------------------------------------------------------------------------------------------
	public function __construct() 
	{
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() 
	{

		$this->DropdownGetChilds(0);

		Base::$tpl->assign('aMap',$this->aMap);
		Base::$sText.=Base::$tpl->fetch('map/index.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	function DropdownGetChilds($iIdParent)
	{
		//              $sQuery="select * from drop_down where id_parent='$iIdParent' and visible=1 order by num";
		//              $aDropdown=Base::$db->getAll($sQuery);

		$aDropdown=Base::$language->getLocalizedAll(array(
		'table'=>'drop_down',
		'where'=>" and id_parent='$iIdParent' and visible=1 and invisible_map=0 order by num",));

		if ($aDropdown) foreach ($aDropdown as $aValue) {
			$aValue['level_']=$aValue['level']+1;
			$this->aMap[]=$aValue;
			if ($aValue['level']<=2) $this->DropdownGetChilds($aValue['id']);
		}
	}
	//-----------------------------------------------------------------------------------------------

}
?>