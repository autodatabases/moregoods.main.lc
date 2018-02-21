<table width=100% border=0>
	<tr>
		<td><b>{$oLanguage->GetMessage("webtopay confirm")}:</b></td>
		<td width=50%>
<b>{$smarty.request.amount}</b>&nbsp;&nbsp;<b>{$smarty.request.currency}</b>

{foreach from=$aHiddenInput item=aItem key=sKey}
<input type="hidden" name="{$sKey}" value="{$aItem}" />
{/foreach}


		</td>
	</tr>

</table>