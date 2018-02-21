<?
function SqlCoreTranslateTextCall($aData) {

	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and t.id='".$aData['id']."'";
	}

	$sSql="select t.*
			from translate_text as t
			where 1=1 ".$sWhere."
			group by t.id";

	return $sSql;
}
?>