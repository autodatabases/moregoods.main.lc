<?
function SqlEcStockCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and s.id='".$aData['id']."'";
	}

	$sSql="select s.* , d.name as distributor, r.name as region, p.art as product
			from ec_stock as s
	        left join ec_region as r on s.id_region=r.id
			left join ec_products as p on s.id_product=p.id
			left join ec_distributor as d on s.id_distributor=d.id
			where 1=1
				".$sWhere;

	return $sSql;
}
?>