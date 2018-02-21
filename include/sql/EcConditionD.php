<?
function SqlEcConditionDCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and cd.id='".$aData['id']."'";
	}

	$sSql="select cd.* , p.art as product , ch.name as condition_h
			from ec_condition_d cd
			left join ec_condition_h as ch on cd.id_condition_h=ch.id
			left join ec_products as p on cd.id_product=p.id
			where 1=1
				".$sWhere."
			group by cd.id";

	return $sSql;
}
?>