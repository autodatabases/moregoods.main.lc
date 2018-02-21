<?
function SqlEcGroupPCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and gp.id='".$aData['id']."'";
	}

	$sSql="select gp.* 
			from ec_group_p gp
			where 1=1
				".$sWhere."
			group by gp.id order by gp.sort";

	return $sSql;
}
?>