<?
function SqlManagerCall($aData) {

	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and u.id='{$aData['id']}'";
	}
	if ($aData['login']) {
		$sWhere.=" and u.login='{$aData['login']}'";
	}
	if ($aData['id_array']) {
		$sWhere.=" and u.id in (".implode(',',$aData['id_array']).")";
	}

	$sSql="select u.*,um.*,er.name as region_name, cg.name as customer_group_name
			from user_manager um
			inner join user as u on u.id=um.id_user
	    left join customer_group as cg on cg.id=um.id_customer_group
	    left join ec_region as er on er.id=um.id_region
			where 1=1
				 ".$sWhere."
			group by u.id";

	return $sSql;
}
?>