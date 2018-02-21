<?
function SqlEcPriceCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and pr.id='".$aData['id']."'";
	}

	$sSql="select pr.* , r.name as region, p.art as product
			from ec_price pr
	        left join ec_region as r on pr.id_region=r.id
			left join ec_products as p on pr.id_product=p.id
			where 1=1
				".$sWhere."
			group by pr.id";

	return $sSql;
}
?>