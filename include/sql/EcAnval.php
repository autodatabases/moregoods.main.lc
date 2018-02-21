<?
function SqlEcAnvalCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and ean.id='".$aData['id']."'";
	}

	$sSql="select ean.* 
			from ec_anval ean
			where 1=1
				".$sWhere."
			group by ean.id";

	return $sSql;
}
?>