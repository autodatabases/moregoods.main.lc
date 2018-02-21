<?
function SqlEcProductsCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and p.id='".$aData['id']."'";
	}

	$sSql="select p.* , bg.name as brand_group, b.name as brand, v.name as vt
			from ec_products p
	        left join ec_brand_group as bg on p.id_brand_group=bg.id
			left join ec_brand as b on p.id_brand=b.id
			left join ec_vt as v on p.id_vt=v.id
			where 1=1
				".$sWhere."
			group by p.id";

	return $sSql;
}
?>