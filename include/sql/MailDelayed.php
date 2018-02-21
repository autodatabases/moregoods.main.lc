<?
function SqlMailDelayedCall($aData) {

	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and md.id='{$aData['id']}'";
	}

	$sSql="select md.*
		from mail_delayed as md
		where 1=1
		".$sWhere.$aData['order'].$aData['limit'];

	return $sSql;
}
?>