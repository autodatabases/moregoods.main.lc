<?
function SqlEcMatricaCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and ma.id='".$aData['id']."'";
	}

	$sSql="select ma.* , bgr.name as brand_group , b.name as brand,  r.name as region,ma.id_customer_group,ma.id_user_customer_type, cg.name as customer_group ,ct.name as customer_type, d.name as distributor
			from ec_matrica ma
			inner join ec_brand_group as bgr on ma.id_brand_group=bgr.id
			inner join ec_brand as b on ma.id_brand=b.id
			inner join ec_region as r on ma.id_region=r.id
			left join ec_distributor as d on ma.id_distributor=d.id
			inner join customer_group as cg on ma.id_customer_group=cg.id
			left join(select 0 as id,'All' as name union all select id,name from user_customer_type) as ct on ma.id_user_customer_type=ct.id
			where 1=1
				".$sWhere."
			group by ma.id";

	return $sSql;
}
?>