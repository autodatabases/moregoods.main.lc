<table width=100% border=0>
	<tr>
		<td><b>{$oLanguage->GetMessage("webmoney amount")}:</b></td>
		<td>
<input type="text" name="LMI_PAYMENT_AMOUNT"  style='width:80px'
	value="{strip}{if $smarty.request.amount}{$smarty.request.amount}{elseif $iBillAmount}{$iBillAmount}
		{else}{$oLanguage->GetConstant('payment:default_amount','0.6')}{/if}{/strip}"
	/>

{if $aWebmoneyCardPurse}
<input type=hidden name=LMI_PAYEE_PURSE value="{$aWebmoneyCardPurse.sPurse}">
{$oLanguage->GetMessage($aWebmoneyCardPurse.sCurrency)}
{else}
<select name=LMI_PAYEE_PURSE style='width:120px'>
{foreach from=$aWebmoneyPurse item=aItem key=sKey}
	{if $sKey && $aItem}<option value='{$sKey}'>{$aItem}</option>
	{/if}
{/foreach}
</select>
{/if}

		</td>
	</tr>

<input type="hidden" name="LMI_PAYMENT_DESC"
	value="{strip}{$oLanguage->GetMessage('LMI_PAYMENT_DESC')} {if $iBillId}{$oLanguage->GetMessage('Bill Number')}
		{$iBillId}{/if}:{$aAuthUser.login}{/strip}">
<input type="hidden" name="LMI_PAYMENT_NO" value="{$LMI_PAYMENT_NO}">
<input type="hidden" name="LMI_SIM_MODE" value="0">
<input type="hidden" name="id_user" value="{$aAuthUser.id}">

</table>