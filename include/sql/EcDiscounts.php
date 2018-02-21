<?
function SqlEcDiscountsCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and dis.id='".$aData['id']."'";
	}

	$sSql="select dis.* , bgr.name as brand_group , b.name as brand,  r.name as region, uc.name as user_name , d.name as distributor
			from ec_discounts dis
			inner join ec_brand_group as bgr on dis.id_brand_group=bgr.id
			inner join ec_brand as b on dis.id_brand=b.id
			inner join ec_region as r on dis.id_region=r.id
			left join ec_distributor as d on dis.id_distributor=d.id
			inner join user_customer as uc on dis.id_user=uc.id_user
			where 1=1
				".$sWhere."
			group by dis.id";

	return $sSql;
}
?>