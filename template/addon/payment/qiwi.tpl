<table width=100% border=0>
	<tr>
		<td><b>{$oLanguage->GetMessage("phone in 10 digits format")}:</b></td>
		<td>
			<input type="text" name="phone" value="{$aUser.phone|escape}">
		</td>
	</tr>
	<tr>
		<td><b>{$oLanguage->GetMessage("qiwi amount")}:</b></td>
		<td>
		<input type="text" name="amount"
		value="{if $smarty.request.amount}{$smarty.request.amount}{elseif $iBillAmount}{$iBillAmount}{else}{$oLanguage->GetConstant('payment:default_amount','0.6')}{/if}">
		{html_options name=currency_code options=$aQiwiCurrency style='width:130px'}
		</td>
	</tr>
</table>