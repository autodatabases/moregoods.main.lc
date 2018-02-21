<?
function SqlEcProductInVidCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and piv.id='".$aData['id']."'";
	}

	$sSql="select piv.* , v.name as vid, p.art as product
			from ec_product_in_vid piv
			left join ec_vid as v on piv.id_vid=v.id
			left join ec_products as p on piv.id_product=p.id
			where 1=1
				".$sWhere."
			group by piv.id";

	return $sSql;
}
?>