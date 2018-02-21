<?
function SqlUserAccountLogCall($aData) {

	$sWhere.=$aData['where'];

	if ($aData['login']) {
		$sWhere.=" and u.login='{$aData['login']}'";
	}

	if ($aData['order']) {
		$sOrder.=" '{$aData['order']}'";
	}

	if ($aData['sum']) {
		$sSelectedRow = " sum(".$aData['sum'].") as total ";
	}else {
		$sSelectedRow = " uc.id_user_referer, u.login, ual.*, u.login as user, ua.amount as current_account_amount
			, ualt.name as user_account_log_type_name";
		$sJoin = "left join user_account_log_type as ualt on ual.id_user_account_log_type=ualt.id  ";
	}

	if ($aData['join_additional']) {
		$sJoin.="inner join invoice_customer_additional as ica on (ica.in_user_account_log=ual.id
			and ica.id_invoice_customer='".$aData['id_invoice_customer']."')";
	}

	if ($aData['join_account']) {
		$sJoin.="left join account as a on ual.id_account=a.id";
		$sField.=" , a.title as account_title, a.name as account_name";
	}

	$query = "select ".$sSelectedRow.$sField."
			from user_account_log ual
			inner join user as u on ual.id_user=u.id
			inner join user_account as ua on ua.id_user=u.id
			inner join user_customer as uc on uc.id_user=u.id
			".$sJoin;

	if ($aData['join1']) {
		$sqlPart1 = $aData['join1'];
	}

	if ($aData['join2']) {
		$sqlPart2 =" union ".$query." ".$aData['join2']." where 1=1 ".$sWhere;
	}

	$sSql = $query." ".$sqlPart1." where 1=1 ".$sWhere.$sqlPart2;

	return $sSql;
}
?>