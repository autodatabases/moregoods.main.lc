<td>{$aRow.id}</td>
<td>{$aRow.login}
<br><font color=green><b>$</b>{$aRow.current_account_amount}</font>
{assign var="user_id" value=$aRow.id}
{if $aCustomerDebtHash.$user_id.amount}
	<br><a href='?action=log_debt&customer_login={$aRow.login}' onclick="xajax_process_browse_url(this.href); return false;">
	<font color=red>(Debt: -${$aCustomerDebtHash.$user_id.amount})</font></a>
{/if}
</td>
<td>{$aRow.account_amount}
/<font color=gray>{$oLanguage->PrintPrice($aRow.debt_amount)}</font>
</td>
<td>{if $aRow.amount>=0}{$aRow.amount}{/if}</td>
<td>{if $aRow.amount<0}{$aRow.amount}{/if}</td>
<td>{$aRow.post_date|date_format:"%Y-%m-%d %H:%M:%S"}</td>
<td>{$aRow.pay_type}
</td>
<td>
{if $aRow.user_account_log_type_name}<b>{$aRow.user_account_log_type_name}</b><br>{/if}
{$aRow.description|truncate:130:"...":true}
	{if $aRow.data}<br>
	<font color=blue>{$aRow.data}</font>
	{/if}
<br>
{$aRow.account_title}
</td>
<td>
<nobr>
<a href="?action=customer_deposit&id={$aRow.id}&user_id={$aRow.id_user}&id_user_referer={$aRow.id_user_referer}&call_action=customer&return={$sReturn|escape:"url"}"
onclick="xajax_process_browse_url(this.href); return false;">
<img border=0 src="/libp/mpanel/images/small/inbox.png"  hspace=3 align=absmiddle/>{$oLanguage->getDMessage('Deposit')}</a>&nbsp;</nobr>
</td>