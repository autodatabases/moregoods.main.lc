<?
function SqlEcAntblCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and ea.id='".$aData['id']."'";
	}

	$sSql="select ea.* 
			from ec_antbl ea
			where 1=1
				".$sWhere."
			group by ea.id";

	return $sSql;
}
?>