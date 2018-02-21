<?
function SqlEcValCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and el.id='".$aData['id']."'";
	}

	$sSql="select el.* 
			from ec_val el
			where 1=1
				".$sWhere."
			group by el.id";

	return $sSql;
}
?>