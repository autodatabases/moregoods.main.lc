<?
function SqlNewsCall($aData) {

	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and n.id='{$aData['id']}'";
	}

	$sSql="select n.* 
				, cg.name as customer_group_name
	            , r.name as region
			from news as n
				left join customer_group cg on cg.id=n.id_customer_group
				left join ec_region as r on r.id=n.id_region
			where 1=1 ".$sWhere."
			group by n.id";

	return $sSql;
}
?>