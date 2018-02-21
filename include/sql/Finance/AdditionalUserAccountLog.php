<?
function SqlFinanceAdditionalUserAccountLogCall($aData) {

	$sWhere.=$aData['where'];

	if ($aData['id_user']) {
		$sWhere.=" and ual.id_user='".$aData['id_user']."'";
	}

	if ($aData['sum_amount']) {
		$sField.=" sum(ual.amount)";
		$sGroup.=" group by aul.id";
	}
	else {
		$sField.=" ual.*,ica.id_invoice_customer";
	}

	$sSql = "
		select ".$sField."
		from user_account_log as ual
		left join invoice_customer_additional as ica on ica.in_user_account_log=ual.id
		where ica.id_invoice_customer IS NULL
		and ual.id_user_account_log_type='8'
			".$sWhere;

	return $sSql;
}
?>