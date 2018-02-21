{foreach key=sKey item=item from=$oTable->aColumn}
{if $sKey=='action'}
<td nowrap class="cell-name">
	{if $aRow.order_status=='pending'}
		<a href="/?action=manager_order_refuse_pending&id={$aRow.id}&return={$sReturn|escape:"url"}"
			onclick="if (!confirm('{$oLanguage->getMessage("Are you sure?")}')) return false;"
			><img src="/image/delete.png" border=0 width=16 align=absmiddle alt="{$oLanguage->getMessage("Refuse pending")}" title="{$oLanguage->getMessage("Refuse pending")}" /> </a>

	{else}
		{if $aAuthUser.is_super_manager}
	<a href="/?action=manager_order_edit&id={$aRow.id}&return={$sReturn|escape:"url"}"
		><img src="/image/edit.png" border=0 width=16 align=absmiddle alt="{$oLanguage->getMessage("Status")}" title="{$oLanguage->getMessage("Status")}" /></a>
		{/if}
	{/if}
</td>
{elseif $sKey=='id_cart_package'}
<td class="cell-name"><a href="/?action=manager_package_edit&id={$aRow.id_cart_package}&return=action%3Dmanager_package_list">{$aRow.id_cart_package}</a><br>
{$aRow.id}
</td>
{elseif $sKey=='name'}
<td class="cell-name">
<div style="overflow:overlay;font-size:11px;">
<span>
	<a href="/?action=manager_edit_weight&id_cart={$aRow.id}&item_code={$aRow.item_code}&return={$sReturn|escape:"url"}"
	><img src="/image/edit.png" border=0 width=16 align=absmiddle /></a>
	{$aRow.name_translate}
	<br><font color="#9B9B9B">{$aRow.customer_comment}</font>
</span>
</div>
</td>
{elseif $sKey=='provider'}
<td class="cell-name">
	<a href="/?action=manager_change_provider&id_cart={$aRow.id}&return={$sReturn|escape:"url"}"
		><img src="/image/edit.png" border=0 width=16 align=absmiddle /></a>
	<a href="/?action=manager_order&search[id_provider]={$aRow.id_provider_ordered}">{$aRow.provider_name_ordered}</a>
</td>
{elseif $sKey=='user'}
<td class="cell-name">
{assign var="Id" value=$aRow.id_user|cat:"_"|cat:$aRow.id}
{$oLanguage->AddOldParser('customer_uniq',$Id)}
</td>
{elseif $sKey=='date'}
<td class="cell-name">{$oLanguage->getDateTime($aRow.post)}</td>
{elseif $sKey=='term'}
<td class="cell-name"> {*$aRow.term_last*}{$aRow.term}</td>
{elseif $sKey=='buh_balance'}
<td class="cell-name"> <a href='/?action=buh_changeling&search[id_buh]=361&search[id_subconto1]={$aRow.id_user}' target=_blank>
	<font color="red">{$oCurrency->PrintPrice($aRow.buh_balance)}</font></a>
</td>
{elseif $sKey=='debt'}
<td class="cell-name"> {if $aRow.buh_balance<$aRow.total}{$oCurrency->PrintPrice($aRow.total-$aRow.buh_balance)}{else}0{/if}</td>
{elseif $sKey=='total_original'}
<td class="cell-name"> {$oCurrency->PrintPrice($aRow.total_original)}</td>
{elseif $sKey=='total_profit'}
<td class="cell-name"> {$oCurrency->PrintPrice($aRow.total_profit)}</td>
{elseif $sKey=='price'}
<td class="cell-name">
	{$oCurrency->PrintPrice($aRow.price)}<br>
	<font color=blue>{$oCurrency->PrintSymbol($aRow.price_original,$aRow.id_currency_provider)}</font>
</td>
{elseif $sKey=='total'}
<td class="cell-name">{$aRow.number}<br>{$oCurrency->PrintSymbol($aRow.total)}</td>
{elseif $sKey=='order_status'}
<td class="cell-name">
	{$oContent->getOrderStatus($aRow.order_status)}
	{if $aRow.history}
	<br><nobr>
	<strong><a href="#" onmouseover="show_hide('history_{$aRow.id}','inline')" onmouseout="show_hide('history_{$aRow.id}','none')"
		onclick="return false"><img src='/image/comment.png' border=0 align=absmiddle hspace=0>
		{$oLanguage->getMessage("History")}</a>&nbsp;</strong></nobr>
	<div style="display: none; " align=left class="status_div" id="history_{$aRow.id}">
		{foreach from=$aRow.history item=aHistory}
			<div>
			 {$oContent->getOrderStatus($aHistory.order_status)} - {$oLanguage->getDateTime($aHistory.post)}<br>
			{$aHistory.comment}
			</div>
		{/foreach}

		{if $aRow.csc_post_date && ($aAuthUser.is_super_manager || $aAuthUser.manager) }
			<div><b>----</b></div>
			<div><b>{$oLanguage->GetMessage('Sticker confirmed')}</b> {$aRow.manager_name}<br>{$aRow.csc_post_date}</div>
			<div><b>{$oLanguage->GetMessage('Box')}</b> {$aRow.cpc_id_cart_packing_box}
			&nbsp;<b>{$oLanguage->GetMessage('Sending')}</b> {$aBoxSending[$aRow.cpc_id_cart_packing_box]}</div>
		{/if}
	</div>
	{/if}
</td>
{elseif $sKey=='code'}
<td class="cell-name">{$aRow.$sKey}<br><font color=red>ZZZ_{$aRow.zzz_code}</font></td>
{else}<td class="cell-name">{$aRow.$sKey}</td>
{/if}
{/foreach}