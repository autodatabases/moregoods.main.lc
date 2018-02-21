<?
function SqlEcVariableCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and ev.id='".$aData['id']."'";
	}

	$sSql="select ev.* 
			from ec_variable ev
			where 1=1
				".$sWhere."
			group by ev.id";

	return $sSql;
}
?>