<?
function SqlEcDistributorRegionCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and dr.id='".$aData['id']."'";
	}

	$sSql="select dr.* , d.name as distributor, r.name as region
			from ec_distributor_region dr
			left join ec_distributor as d on dr.id_distributor=d.id
			left join ec_region as r on dr.id_region=r.id
			where 1=1
				".$sWhere."
			group by dr.id";

	return $sSql;
}
?>