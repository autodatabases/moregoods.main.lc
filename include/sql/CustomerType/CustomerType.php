<?
function SqlCustomerTypeCustomerTypeCall($aData) {
	$sWhere.=$aData['where'];
	
	if ($aData['id']) {
		$sWhere.=" and ct.id='{$aData['id']}'";
	}
	
	$sSql="select ct. *  ,ct.name as ct_name,  cg.name as customer_group_name
			from user_customer_type AS ct
			left join customer_group as cg on cg.id = ct.id_customer_group
			".$sJoin."
			where 1=1 
			".$sWhere." 
			group by ct.id";
			
	return $sSql;
}
?>