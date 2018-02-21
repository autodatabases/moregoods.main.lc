{foreach key=sKey item=item from=$oTable->aColumn}
{if $sKey=='action'}
<td nowrap><img src="/image/comment.png" border=0  width=16 align=absmiddle />
<a href="/?action=store_log_history&id={$aRow.id}">{$oLanguage->getMessage("show history")}</a></td>
{elseif $sKey=='price'}
<td>{$oCurrency->PrintPrice($aRow.price)}</td>
{elseif $sKey=='tax'}
<td>{$oCurrency->PrintPrice($aRow.tax)}</td>
{else}<td>{$aRow.$sKey}</td>
{/if}
{/foreach}