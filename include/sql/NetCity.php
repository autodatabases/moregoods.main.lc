<?
function SqlNetCityCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and n.id='".$aData['id']."'";
	}

	$sSql="select n.* 
			from net_city n
			where 1=1
				".$sWhere."
			group by n.id";

	return $sSql;
}
?>