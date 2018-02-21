<?
function SqlAccountCall($aData) {

	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and a.id='".$aData['id']."'";
	}
	if ($aData['is_active']) {
		$sWhere.=" and a.is_active='1'";
	}

	$sSql="select a.*
			from account as a
			where 1=1
				".$sWhere;

	return $sSql;
}
?>