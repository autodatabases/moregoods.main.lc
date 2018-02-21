{foreach key=sKey item=item from=$oTable->aColumn}
<td class="cell-name2">
{if ($sKey == 'action')}

<a href="/?action=manager_export_bill&id={$aRow.id}">Export</a>
{elseif ($sKey == 'payment_date')}
	<nobr>{$aRow.$sKey}</nobr>
{*elseif ($sKey == 'method')}
	{if $aRow.liqpay_order_id}
	<nobr>LiqPay</nobr>
	{else}
	<nobr>{$aRow.method}</nobr>
	{/if}
{elseif ($sKey == 'amount')}
	{if !$aRow.order_id}
	<nobr>{$aRow.price}</nobr>
	{else}
	<nobr>{$aRow.$sKey}</nobr>
	{/if}
{elseif ($sKey == 'receiver_commission')}
	{if !$aRow.order_id}
	<nobr>0</nobr>
	{else}
	<nobr>{$aRow.$sKey}</nobr>
	{/if*}
{else}
    {if $sKey=='user'}
	{$oLanguage->AddOldParser('customer',$aRow.id_user)}
    {else}
	{$aRow.$sKey}
    {/if}
{/if}
</td>
{/foreach}
