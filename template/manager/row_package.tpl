<td class="cell-name2"><nobr><a href="/?action=manager_package_edit&id={$aRow.id}&return={$sReturn|escape:"url"}">{$aRow.id}</a>
{*if $aRow.is_need_check}
	&nbsp;
	<span id="auto_{$aRow.id}" onclick="set_checked_auto(this,{if ($aRow.is_checked_auto)}'0'{else}'1'{/if})" onmouseover="$('#tip_auto_{$aRow.id}').show();" onmouseout="$('#tip_auto_{$aRow.id}').hide();">
	{if $aRow.is_checked_auto == 0}
		<a><img src="/image/design/not_sel_chk.png"></img></a>
	{else}
		<a><img src="/image/design/sel_chk.png"></img></a>
	{/if}
	<div align="left" style="width: 500px;" class="tip_div" id="tip_auto_{$aRow.id}">{$aRow.sAutoInfo}</div>
	</span>
{/if}
<br><br>{if $aRow.price_delivery==0 && $aRow.is_payed}
<a href="/?action=manager_package_merge&id={$aRow.id}&return={$sReturn|escape:"url"}">
{$oLanguage->getMessage("Merge")}</a>
{/if*}
</nobr></td>
{* Дата - Заказчик*}
<td class="cell-name_new">{*$aRow.code*}<b><a href="/?action=manager_package_list&search_login={$aRow.login}'><img src="/image/info.png" /></a></b>
{assign var="Id" value=$aRow.id_user|cat:"_"|cat:$aRow.id}
{$oLanguage->AddOldParser('customer_uniq',$Id)}
{if $aRow.date_delivery} На: {$aRow.date_delivery} <br> {$aRow.time_delivery} {/if}
{* Адрес *}
{if $aRow.delivery_point}<br>Адрес:&nbsp;{$aRow.delivery_point}{/if}
{if $aRow.city_address_delivery}<br>{$aRow.city_address_delivery}{/if}
{if $aRow.address_delivery}<br>{$aRow.address_delivery}{/if}
{*<br>
<b><a href="/?action=buh_changeling&search[id_buh]=361&search[id_subconto1]={$aRow.id_user}' target=_blank
	>{$oLanguage->getMessage("Balance")}{$oCurrency->PrintPrice($aRow.amount)}</a></b>*}
</td>
{* Автор *}
<td class="cell-name_new"><b>
{$aRow.id_autor}<br>
{$oLanguage->getPostDateTime($aRow.post_date)}
</b>
</td>
{* Група контрагентов *}
<td class="cell-name_new"><b>
{assign var="Id_G" value=$aRow.id_customer_group}
{$aGroupsG[$Id_G]|@debug_print_var}</b>
</td>
{*
<td class="cell-name">
<div style="width:245px;overflow:overlay;">
{if $aRow.aCart}
{foreach key=iCart item=aCart from=$aRow.aCart}
{if $aCart.history}
<nobr>
<strong><a href="#" onmouseover="show_hide('history_{$aCart.id}','inline')" onmouseout="show_hide('history_{$aCart.id}','none')"
	onclick="return false"><img src='/image/comment.png' border=0 align=absmiddle hspace=0>
	</a></strong></nobr>
<div style="display: none; " align=left class="tip_div" id="history_{$aCart.id}">
	{foreach from=$aCart.history item=aHistory}
		<div>
		 {$oLanguage->getOrderStatus($aHistory.order_status)} - {$oLanguage->getDateTime($aHistory.post)}<br>
		{$aHistory.comment}
		</div>
	{/foreach}
</div>
{/if}
&nbsp;
{if $aCart.order_status=='refused'}<strike>{/if}
{$aCart.code} {if $aCart.code_changed}=>({$aCart.code_changed}){/if} <b>{$aCart.cat_name}
	[ <font color="red">{$aCart.number}</font> ] </b><font color=green>{$aCart.name_translate}</font>
{if $aCart.order_status=='refused'}</strike>{/if}
<br>
{/foreach}
{/if}
{if $aRow.order_status=="pending" || $aRow.order_status=="work" && $aRow.is_payed==0}
<a href="/?action=manager_empty_package_delete&id={$aRow.id}&return={$sReturn|escape:"url"}"
		onclick="if (!confirm('{$oLanguage->getMessage("Are you sure?")}')) return false;"
		><img src="/image/delete.png" border=0 width=16 align=absmiddle /> {$oLanguage->getMessage("Delete Package")}</a>
{/if}
</div>
</td>
*}
{* Статус  *}
<td class="cell-name_new"><b>{$oLanguage->getOrderStatus($aRow.order_status)} </b>
{*if $aRow.is_reclamation}<b>{$oLanguage->getMessage('reclamation')}</b>{/if}
{if $aRow.vin}<br><nobr>{if $aRow.vin_check}<img src="/image/apply.png" border=0 width=16 align=absmiddle /> {/if}{$aRow.vin}</nobr>{/if}
{if $aRow.delivery_link}<br><a href="{$aRow.delivery_link}" target="_blank">{$oLanguage->getMessage('delivery link')}</a>{/if}
{if $aRow.file}<hr>{/if}
{foreach key=key item=item from=$aRow.file}
	<a target=blaank href="{$item.file_path}">{$item.file_name}</a><br />
{/foreach*}
{* addr
<br>{$aRow.delivery_point}
{if $aRow.city_address_delivery}<br>{$aRow.city_address_delivery}{/if}
{if $aRow.address_delivery}<br>{$aRow.address_delivery}{/if}*}
</td>
{if $aRow.is_payed==1}
<td class="cell-name_new"><font color=green><b>{$oLanguage->getMessage('is_payed')} </b></font></td>
{else}
<td class="cell-name_new"><font color=red><b>{$oLanguage->getMessage('not_payed')} </b></font></td>
{/if}
{*Ціна
<td class="cell-name">{$oLanguage->getMessage("Parts")}  {$oCurrency->PrintPrice($aRow.price_total-$aRow.price_delivery)}
<br>{$oLanguage->getMessage("Delivery")}  {$oCurrency->PrintPrice($aRow.price_delivery)}
{if $aRow.price_additional>0}
<br><font color="Red"><u>{$oLanguage->getMessage("Additional payment")}</u></font>
<br>{$oCurrency->PrintPrice($aRow.price_additional)}
{/if}
</td>*}
{* Сумма  *}
<td class="cell-name"> <b><nobr>{if $aRow.summa_fact !=0}{$oCurrency->PrintPrice($aRow.summa_fact-$aRow.bonus)}
	{else}{$oCurrency->PrintPrice($aRow.price_total-$aRow.bonus)}{/if}</nobr></b>
{*<br>
{$aRow.delivery_type_name} / {$aRow.payment_type_name}
<br>{$oLanguage->getMessage("Is payed")}:{include file='addon/mpanel/yes_no.tpl' bData=$aRow.is_payed}*}
</td>
 
{*<td>{$aRow.name_manager}&nbsp;</td>*}

{*  последняя колонка 
<td style="text-align:left;white-space:nowrap" class="cell-name">
{if $aAuthUser.is_super_manager}
	{if $aRow.order_status=='pending'}
	<a href="/?action=manager_package_order&id={$aRow.id}&confirm=1"
		><img src="/image/apply.png" border=0 width=16 align=absmiddle />{$oLanguage->getMessage("Send Package to Work")}</a>
	<br>
	{/if}
{/if}
<a href="/?action=manager_order_print&id={$aRow.id}&id_user={$aRow.id_user}" target=_blank
	><img src="/image/fileprint.png" border=0 width=16 align=absmiddle hspace=1/>{$oLanguage->getMessage("Print")}</a>
<br>
<a href="/?action=manager_order&search[id_cart_package]={$aRow.id}"
	><img src="/image/tooloptions.png" border=0 width=16 align=absmiddle />{if $aRow.is_viewed==0}<b>{$oLanguage->getMessage("Browse Detals")}</b>{else}{$oLanguage->getMessage("Browse Detals")}{/if}</a>
*}
{*<br>
<a href="/?action=manager_package_edit&id={$aRow.id}"
	><img src="/image/edit.png" border=0 width=16 align=absmiddle />{$oLanguage->getMessage("Edit")}</a>
<br>
<a {strip}href="/?action=buh_add_amount&search[id_buh_credit]=361&&search[id_buh_credit_subconto1]={$aRow.id_user}
&search[id_buh_debit]=311&search[id_buh_debit_subconto1]=7
&search[buh_section_id]={$aRow.id}&return={$sReturn|escape:"url"}"
{/strip}><img src="/image/inbox.png" border=0 width=16 align=absmiddle />{$oLanguage->getMessage("Deposit for cart package")}</a>*}
{*
<br>
<a href="{strip}/?action=finance_bill_add&code_template=order_bill
&data[amount]={$oCurrency->PrintPrice($aRow.price_total,'',2,'<none>')}
&data[id_cart_package]={$aRow.id}
&data[login]={$aRow.login}&return_action=manager_package_list
{/strip}"
	><img src="/image/tooloptions.png" border=0 width=16 align=absmiddle />{$oLanguage->getMessage("Order Bill")}</a>
{if !$aRow.is_payed}
<br>
<a {strip}href="/?action=manager_package_payed&id={$aRow.id}&return={$sReturn|escape:"url"}"
{/strip}><img src="/image/inbox.png" border=0 width=16 align=absmiddle />{$oLanguage->getMessage("Set cart package payed")}</a>
{/if}
<br>
<a href="/?action=manager_package_edit&id={$aRow.id}&return={$sReturn|escape:"url"}"
	><img src="/image/tooloptions.png" border=0 width=16 align=absmiddle />{if $aRow.is_viewed==0}<b>{$oLanguage->getMessage("комментарии")}</b>{else}{$oLanguage->getMessage("комментарии")}{/if}</a>
<br>
{if $aRow.order_status=="pending" || $aRow.order_status=="work" && $aRow.is_payed==0}
<a href="/?action=manager_empty_package_delete&id={$aRow.id}&return={$sReturn|escape:"url"}"
		onclick="if (!confirm('{$oLanguage->getMessage("Are you sure?")}')) return false;"
		><img src="/image/delete.png" border=0 width=16 align=absmiddle /> {$oLanguage->getMessage("Delete Package")}</a>
{/if}
</td>
*}
