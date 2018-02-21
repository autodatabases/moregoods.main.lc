<table width=100% border=0>
	<tr>
		<td><b>{$oLanguage->GetMessage("Uniteller amount")}:</b></td>
		<td>
		{$smarty.request.amount} {$smarty.request.currency}
		</td>
	</tr>
</table>

{foreach from=$aHiddenInput item=aItem key=sKey}
	<input type="hidden" name="{$sKey}" value="{$aItem}" />
{/foreach}
