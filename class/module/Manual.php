<?
/**
 * @author Alexander Belogura
 */

require_once(SERVER_PATH.'/class/core/Base.php');
class Manual extends Base {

	//-----------------------------------------------------------------------------------------------
	public function Manual() {
		Repository::InitDatabase('manual',false);
		Base::$aData['template']['bWidthLimit']=true;
	}
	//-----------------------------------------------------------------------------------------------
	public function Index() {

	}
	//-----------------------------------------------------------------------------------------------
	public function Show() {
		$sRequestCode=substr(Base::$aRequest['code'],0,3);
		switch ($sRequestCode){
			case "CUS":
				$sRequestCodeType="customer";
				break;
			case "MAN":
				$sRequestCodeType="manager";
				break;
			case "GST":
				$sRequestCodeType="customer";
				break;
			default:
				$sRequestCodeType="";
				break;
		}

		if (Auth::$aUser['type_'])
		$sUserType=Auth::$aUser['type_'];
		else
		$sUserType='customer';

		if ($sUserType==$sRequestCodeType)
		if (Base::$aRequest['code'])
		$sWhere.=" and code='".Base::$aRequest['code']."'";
		else
		$sWhere.=" and id=-1";
		else
		$sWhere.=" and id=-1";

		$aData=array(
		'table'=>'manual',
		'where'=>" and t.visible='1' ".$sWhere." order by num",
		);
		$aManual=Base::$language->getLocalizedAll($aData);
		Base::$tpl->assign('aManual',$aManual);

		Base::$sText.=Base::$tpl->fetch('manual/show.tpl');

		$this->CommentList($aManual[0]['id']);
	}
	//-----------------------------------------------------------------------------------------------
	public function ShowShort($sRequesCode) {
		if (strlen($sRequesCode)==3)
		$sWhere.=" and code_manual_category='".$sRequesCode."'";
		else
		$sWhere.=" and code='".$sRequesCode."'";

		$aData=array(
		'table'=>'manual',
		'where'=>" and t.visible='1' ".$sWhere." order by num",
		);
		$aManual=Base::$language->getLocalizedAll($aData);
		Base::$tpl->assign('aManual',$aManual);
	}
	//-----------------------------------------------------------------------------------------------
	public function CommentList($sManualId)
	{
		$oComment=new CommentTree();
		if (Base::$aRequest['xajaxr'])
		Base::$oResponse->addAssign('comment_div','innerHTML',$oComment->GetCommentList('manual',$sManualId,true));
		else Base::$sText.=$oComment->GetCommentListTree('manual',$sManualId);
	}

}
?>