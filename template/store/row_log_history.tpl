{foreach key=sKey item=item from=$oTable->aColumn}
{if $sKey=='price'}
<td>{$oCurrency->PrintPrice($aRow.price)}</td>
{elseif $sKey=='tax'}
<td>{$oCurrency->PrintPrice($aRow.tax)}</td>
{else}<td>{$aRow.$sKey}</td>{/if}
{/foreach}