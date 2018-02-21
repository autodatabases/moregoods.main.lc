<table width=100% border=0>
	<tr>
		<td><b>{$oLanguage->GetMessage("Bank amount")}:</b></td>
		<td>
		<input type="text" name="amount"
		value="{if $smarty.request.amount}{$smarty.request.amount}{elseif $iBillAmount}{$iBillAmount}{else}{$oLanguage->GetConstant('payment:default_amount','0.6')}{/if}">
		{html_options name=currency options=$aBankCurrency style='width:130px'}
		</td>
	</tr>
	<tr>
		<td><b />{$oLanguage->GetMessage("Bill type")}:</td></td>
		<td>
			<select name='bill_type' style='width:315px'>
				<option value='bill'>{$oLanguage->GetMessage("Bill")}</option>
				<option value='rect'>{$oLanguage->GetMessage("Receipt")}</option>
			</select>
		</td>
	</tr>
</table>
{if $iBillId}
	<input type="hidden" name="bill_id" value="{$iBillId}">
{/if}
