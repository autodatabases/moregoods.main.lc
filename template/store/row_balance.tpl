{foreach key=sKey item=item from=$oTable->aColumn}
{if $sKey=='action'}
<td>aaa</td>
{elseif $sKey=='summ_before'}
<td>{$oCurrency->PrintPrice($aRow.summ_before)}</td>
{elseif $sKey=='summ_add'}
<td>{$oCurrency->PrintPrice($aRow.summ_add)}</td>
{elseif $sKey=='summ_remove'}
<td>{$oCurrency->PrintPrice($aRow.summ_remove)}</td>
{elseif $sKey=='summ_last'}
<td>{$oCurrency->PrintPrice($aRow.summ_last)}</td>
{else}<td>{if $aRow.$sKey}{$aRow.$sKey}{else}0{/if}</td>
{/if}
{/foreach}