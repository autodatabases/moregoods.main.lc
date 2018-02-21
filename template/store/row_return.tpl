{foreach key=sKey item=item from=$oTable->aColumn}
{if $sKey=='action'}
<td>aaa</td>
{elseif $sKey=='price'}
<td>{$oCurrency->PrintPrice($aRow.price)}</td>
{elseif $sKey=='tax'}
<td>{$oCurrency->PrintPrice($aRow.tax)}</td>
{elseif $sKey=='summ'}
<td>{$oCurrency->PrintPrice($aRow.summ)}</td>
{elseif $sKey=='summ_tax'}
<td>{$oCurrency->PrintPrice($aRow.summ_tax)}</td>
{else}<td>{$aRow.$sKey}</td>
{/if}
{/foreach}