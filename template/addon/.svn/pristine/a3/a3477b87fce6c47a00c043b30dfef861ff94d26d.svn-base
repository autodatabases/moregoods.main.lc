<table width=100% border=0>
	<tr>
		<td><b>{$oLanguage->GetMessage("webtopay amount")}:</b></td>
		<td>
<input type="text" name="amount"
	value="{if $smarty.request.amount}{$smarty.request.amount}{else}{$oLanguage->GetConstant('payment:default_amount','0.6')}{/if}">
{html_options name=currency options=$aWebtopayCurrency style='width:130px'}


{foreach from=$aHiddenInput item=aItem key=sKey}
<input type="hidden" name="{$sKey}" value="{$aItem}" />
{/foreach}


		</td>
	</tr>

</table>