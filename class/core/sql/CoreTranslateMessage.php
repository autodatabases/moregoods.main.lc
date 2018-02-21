<?
function SqlCoreTranslateMessageCall($aData) {

	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and t.id='".$aData['id']."'";
	}

	$sSql="select t.*
			from translate_message as t
			where 1=1 ".$sWhere."
			group by t.id";

	return $sSql;
}
?>