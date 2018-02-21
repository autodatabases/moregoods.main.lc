<?
function SqlEcDiscountCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and dis.id='".$aData['id']."'";
	}

	$sSql="select dis.* , p.art as product , ch.name as condition_h, v.name as vt, r.name as region
			from ec_discount dis
			left join ec_vt as v on dis.id_vt=v.id
			left join ec_condition_h as ch on dis.id_condition_h=ch.id
			left join ec_products as p on dis.id_product=p.id
			left join ec_region as r on dis.id_region=r.id
			where 1=1
				".$sWhere."
			group by dis.id";

	return $sSql;
}
?>