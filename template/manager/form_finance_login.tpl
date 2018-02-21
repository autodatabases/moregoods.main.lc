<table width=100% border=0>
	<tr>
		<td><b>{$oLanguage->GetMessage("Login")}:</b></td>
		<td><font color=blue size=+1><b>{$aCustomer.login}</b></font></td>
		<td><b>{$oLanguage->GetMessage("Email")}:</b></td>
		<td>{$aCustomer.email}</td>
		<td><b>{$oLanguage->GetMessage("Phone")}:</b></td>
		<td>{$aCustomer.phone}</td>
		<td><b>{$oLanguage->GetMessage("GDiscount")}:</b></td>
		<td>{$aCustomer.group_discount} %</td>
	</tr>
	<tr>
		<td><b>{$oLanguage->GetMessage("Group")}:</b></td>
		<td>{$aCustomer.customer_group_name}</td>
		<td><b>{$oLanguage->GetMessage("Amount")}:</b></td>
		<td>{$oLanguage->PrintPrice($aCustomer.amount)}</td>
		<td><b>{$oLanguage->GetMessage("DiscountStatic")}:</b></td>
		<td>{$aCustomer.discount_static} %</td>
		<td><b>{$oLanguage->GetMessage("DiscountDinamic")}:</b></td>
		<td>{$aCustomer.discount_dynamic} %</td>
	</tr>
	<tr>
		<td colspan=2>&nbsp;</td>
		<td colspan=2><input type=button class='btn' value="{$oLanguage->GetMessage("Deposit money")}"
				onclick="{strip}
		location.href='/?action=manager_finance_add
			&id_user={$aCustomer.id}
			{if $aCartPackage}&custom_id={$aCartPackage.id}{/if}
			&login={$aCustomer.login}
			&return={$sReturn|escape:"url"}'
				{/strip}">
			</td>
		<td colspan=4>&nbsp;</td>
	</tr>
</table>