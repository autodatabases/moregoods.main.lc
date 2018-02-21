<?
function SqlEcSeriaInCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and si.id='".$aData['id']."'";
	}

	$sSql="select si.* , sp.name as seria_p, p.art as product
			from ec_seria_in si
			left join ec_seria_p as sp on si.id_seria_p=sp.id
			left join ec_products as p on si.id_product=p.id
			where 1=1
				".$sWhere."
			group by si.id";

	return $sSql;
}
?>