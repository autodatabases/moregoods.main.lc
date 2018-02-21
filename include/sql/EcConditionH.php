<?
function SqlEcConditionHCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and ch.id='".$aData['id']."'";
	}

	$sSql="select ch.* , r.name as region, gp.name as group_p
			from ec_condition_h ch
			left join ec_region as r on ch.id_region=r.id
			left join ec_group_p as gp on ch.id_group_p=gp.id
			where 1=1
				".$sWhere."
			group by ch.id";

	return $sSql;
}
?>