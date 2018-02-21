<?
/**
 * @author Alexander Belogura
 */

class CommentTree extends Comment
{
	//-----------------------------------------------------------------------------------------------
	public function __construct()
	{
	}
	//-----------------------------------------------------------------------------------------------
	public function GetCommentListTree($sSection,$sId,$bXajaxResponse=false)
	{
		Base::$tpl->assign('sRefId',$sId);
		Base::$tpl->assign('sSection',$sSection);
		Base::$tpl->assign('bXajaxResponse',$bXajaxResponse);

		Base::$bXajaxPresent=true;

		$sQuery="select * from comment where section='".$sSection."' and ref_id='".$sId."' order by post";
		$aComments=Base::$db->getAll($sQuery);
		$iCommentNumber = Base::$db->getOne ('SELECT FOUND_ROWS()');
		$aCommentTree=$this->convertArrayToTree($aComments);
		
		Base::$tpl->assign('iCommentNumber',$iCommentNumber);
		$sCommentText.=Base::$tpl->fetch('comment_tree/list.tpl');
		
		Base::$tpl->assign('aCommentTree',$aCommentTree);
		$sCommentText.=Base::$tpl->fetch('comment_tree/catlist.tpl');

		$sCommentText.=Base::$tpl->fetch('comment_tree/new_comment.tpl');
		
		return $sCommentText;
	}
	//-----------------------------------------------------------------------------------------------
	public function Post()
	{
		Base::$db->Execute("insert into comment (section,ref_id,name,email,site,content,post,ip,parent_id)
			value('".Base::$aRequest['section']."','".Base::$aRequest['ref_id']."','".Base::$aRequest['name']."'
				,'".Base::$aRequest['email']."',
				'".Base::$aRequest['site']."','".nl2br(strip_tags(Base::$aRequest['content']))
		."',UNIX_TIMESTAMP(),'".Auth::GetIp()."','".Base::$aRequest['parent_id']."')");

		//Base::$oResponse->addAlert(Language::getMessage('Your comment successfully added.'));

		$sCommentList=$this->GetCommentListTree(Base::$aRequest['section'],Base::$aRequest['ref_id'],true);
		Base::$oResponse->addAssign('comment_div','innerHTML', $sCommentList);
	}
	//-----------------------------------------------------------------------------------------------
	public function convertArrayToTree($aSourceArray, $sParentId='0', $sKeyChildren='child', 
	$aKeyId='id', $sKeyParentId='parent_id') {
		$aTree=array();
		if (empty($aSourceArray))
			return $aTree;
		$this->doConvertArrayToTree($aSourceArray, $aTree, $sParentId, $sParentId, $sKeyChildren, 
		$aKeyId, $sKeyParentId);
		return $aTree;
	}
	//-----------------------------------------------------------------------------------------------
	private function doConvertArrayToTree($aSourceArray, &$aThisTree, $sParentId, $sThisId, $sKeyChildren, 
	$aKeyId, $sKeyParentId) {
		foreach ($aSourceArray as $value)
		if ($value[$sKeyParentId]===$sThisId)
		$aThisTree[$sKeyChildren][$value[$aKeyId]]=$value;

		if (isset($aThisTree[$sKeyChildren]))
		foreach ($aThisTree[$sKeyChildren] as $value)
		$this->doConvertArrayToTree($aSourceArray, $aThisTree[$sKeyChildren][$value[$aKeyId]], $sParentId,
		$value[$aKeyId], $sKeyChildren, $aKeyId, $sKeyParentId);
		if ($sThisId===$sParentId)
		$aThisTree=$aThisTree[$sKeyChildren];
	}
}
?>