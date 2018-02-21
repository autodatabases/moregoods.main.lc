<td class="cell-name_m">{$aRow.name}</td>
<td class="cell-name_m">{$aRow.addr}</td>
<td class="cell-name_m">{$aRow.dist}</td>

<td class="cell-name_m">{$aRow.num}</td>
<td class="cell-name_m"><nobr><a style="font-weight: 400; text-decoration: underline;" {if $aAuthUser.type_=='manager'} href="/?action=manager_order_ship&id={$aRow.move_id}"{else}
href="/?action=finance_order_ship&id={$aRow.move_id}" {/if}>{$oCurrency->PrintPrice($aRow.summa,0,2,'span')}</a></nobr></td>
<td class="cell-name_m">{if $aRow.dt=='0000-00-00 00:00:00'} &nbsp; {else}{$aRow.dt|date_format:"%d.%m.%Y"}{/if}</td>
<td class="cell-name_m">{if $aRow.dt5=='0000-00-00 00:00:00'} &nbsp; {else}{$aRow.dt5|date_format:"%d.%m.%Y"}{/if}</td>
<td class="cell-name_m"><a style="font-weight: 400; text-decoration: underline;" {if $aAuthUser.type_=='manager'} href="/?action=manager_payment_ship&id={$aRow.move_id}"{else}
href="/?action=finance_payment_ship&id={$aRow.move_id}" {/if}>{$aRow.summa_pay}</a></td>
<td class="cell-name_m">{if $aRow.dt_pay=='0000-00-00 00:00:00'} &nbsp; {else}{$aRow.dt_pay|date_format:"%d.%m.%Y"}{/if}</td>

<td class="cell-name_m" style="font-size: 13px;"><b>{$aRow.summa_all}</b></td>
<td class="cell-name_m" style="font-size: 13px; color: red;"><b>{$aRow.summa_dolg}</b></td>

{*<td class="cell-name_m">{$aRow.dist}</td>*}


