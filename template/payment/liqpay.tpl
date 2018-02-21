<table width=100% border=0>
	<tr>
		<td><b>{$oLanguage->GetMessage("liqpay amount")}:</b></td>
		<td>
<input type="text" name="amount"
	value="{if $smarty.request.amount}{$smarty.request.amount}{else}{$oLanguage->GetConstant('payment:default_amount','0.6')}{/if}">
{html_options name=currency options=$aLiqpayCurrency style='width:130px'}
<input type="hidden" name="version" value="1.1" />
<input type="hidden" name="merchant_id" value="{$oLanguage->GetConstant('payment:liqpay_merchant_id','i9477382803')}" />
<input type="hidden" name="description"
	value="{$oLanguage->GetConstant('payment:liqpay_description','Liqpay description')} {$aAuthUser.login}:{$aAuthUser.id}" />
<input type="hidden" name="order_id"  value="{$aAuthUser.id}_{$sUniqid}" />

<input type="hidden" name="result_url" value="http://{$SERVER_NAME}/?action=payment_liqpay_success" />
<input type="hidden" name="server_url" value="http://{$SERVER_NAME}/?action=payment_liqpay_result" />
		</td>
	</tr>

</table>