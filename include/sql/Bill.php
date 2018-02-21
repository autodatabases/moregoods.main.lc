<?
function SqlBillCall($aData) {

	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and b.id='{$aData['id']}'";
	}

	$sSql="select u.login
				, a.name as account_name
				, uc.name
				, b.*
			from bill as b
			inner join user as u on b.id_user=u.id
			inner join user_customer as uc on u.id=uc.id_user
			inner join account as a on b.id_account=a.id
			where 1=1
				".$sWhere."
			group by b.id
				";

	return $sSql;
}
?>