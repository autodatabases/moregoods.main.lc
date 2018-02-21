{foreach key=sKey item=item from=$oTable->aColumn}
{if $sKey=='tax'}
<td>{$oCurrency->PrintPrice($aRow.tax)}</td>
{elseif $sKey=='price'}
<td>{$oCurrency->PrintPrice($aRow.price)}</td>
{else}<td>{$aRow.$sKey}</td>{/if}
{/foreach}