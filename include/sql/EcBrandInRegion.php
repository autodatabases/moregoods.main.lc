<?
function SqlEcBrandInRegionCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and bir.id='".$aData['id']."'";
	}

	$sSql="select bir.* , b.name as brand, r.name as region
			from ec_brand_in_region bir
			left join ec_brand as b on bir.id_brand=b.id
			left join ec_region as r on bir.id_region=r.id
			where 1=1
				".$sWhere."
			group by bir.id";

	return $sSql;
}
?>