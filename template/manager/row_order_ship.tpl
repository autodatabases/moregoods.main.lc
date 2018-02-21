{foreach key=sKey item=item from=$oTable->aColumn}
{if $sKey=='action'}

{elseif $sKey=='total'}
<td>{$oCurrency->PrintSymbol($aRow.total)}</td>

{else}<td>{$aRow.$sKey}</td>
{/if}
{/foreach}