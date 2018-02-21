<?
function SqlProviderCall($aData) {

	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and u.id='{$aData['id']}'";
	}
	if ($aData['login']) {
		$sWhere.=" and u.login='{$aData['login']}'";
	}

	$sSql="select u.*, up.*
				,pr.name as provider_region_name
				,pr.code_delivery as provider_region_code_delivery
				,ua.amount as account_amount
				,pg.name as pg_name
			from user u
			inner join user_provider up on u.id=up.id_user
			inner join provider_region pr on up.id_provider_region=pr.id
			inner join user_account as ua on u.id=ua.id_user
			inner join provider_group as pg on up.id_provider_group=pg.id
			where 1=1
				 ".$sWhere;//."
			//group by u.id";

	return $sSql;
}
?>