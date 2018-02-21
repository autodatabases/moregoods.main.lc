{if $aRow.separator}<td class="separator" colspan="9"><b>{$aRow.separator_header}</b></td>
{else}

{if $aAuthUser.type_=='manager'}
<td class={$aRow.td_class} style="white-space:nowrap;">
	<strong><a href="#" onmouseover="show_hide('history_{$aRow.id}','inline')" onmouseout="show_hide('history_{$aRow.id}','none')"
		onclick="return false" style="color:gray;"><b>{$aRow.provider}</b></a></strong>
	<div style="display: none; " align=left class="tip_div" id="history_{$aRow.id}">
			<div>
			{$aRow.history}
			</div>
	</div>
</td>
{/if}

<td class="cell-logo {$aRow.td_class}">{if $aRow.image_logo}<a href='#' rel="nofollow" 
	onclick="xajax_process_browse_url('/?action=catalog_view_brand&amp;pref={$aRow.pref}');$('#popup_id').show();return false;">
	<img src="{$aRow.image_logo}" alt="{$aRow.brand}" title="{$aRow.brand}"></a>
	{else}
		<a href="#" rel="nofollow" style="text-decoration:none;"
			onclick="xajax_process_browse_url('/?action=catalog_view_brand&amp;pref={$aRow.pref}');$('#popup_id').show();return false;"
	><b>{$aRow.brand}</b></a>
	{/if}
{if $aRow.pn!=""}
<br><span class="hov" style="white-space:nowrap;">
<a href="javascript: mt.ShowTr('{$aRow.pn}','{$aRow.iGrp}')" style="text-decoration:underline;"
title="{$oLanguage->getMessage("Show Cross")}">{$oLanguage->GetMessage("PriceCross")}&nbsp;&gt;&gt;</a>
	<a href="javascript: mt.ShowTr('{$aRow.pn}','{$aRow.iGrp}')" title="{$oLanguage->getMessage("Show Cross")}">
	<img src="/image/expandall.png" alt="" /></a>
	<a href="javascript: mt.HideTr('{$aRow.pn}')" title="{$oLanguage->getMessage("Hide Cross")}">
	<img src="/image/collapseall.png" alt="" /></a>
	</span>
{/if}
</td>
<td class="cell-code {$aRow.td_class}">
{if $aRow.hide_code<>1 && $aRow.cat_name != ''}
	{if $oLanguage->getConstant('global:url_is_lower',0)}
		<a href="/buy/{$oContent->Translit($aRow.cat_name)|@lower}_{$aRow.code|@lower}{if $oLanguage->getConstant('global:url_is_not_last_slash',0)}{else}/{/if}">
	{else}
		<a href="/buy/{$oContent->Translit($aRow.cat_name)}_{$aRow.code}{if $oLanguage->getConstant('global:url_is_not_last_slash',0)}{else}/{/if}">
	{/if}
{/if}
{$aRow.code}
{if $aRow.hide_code<>1 && $aRow.cat_name != ''}</a>{/if}
{if $aAuthUser.type_=='manager'}<br><span style="color:red;">{$aRow.zzz_code}{*<br>{$aRow.code_}*}</span>{/if}
{*<br><b>{$aRow.brand}</b>
<br><a href='/?action=catalog_part_info_view&code={$aRow.code}&id_brand={$aRow.id_brand}&item_code={$aRow.item_code}&id_provider={$aRow.id_provider}&return={$sReturn|escape:"url"}'>
<font size="3"><b>{$oLanguage->getMessage("Show info")}</b></font></a>*}
</td>
<td class="cell-title {$aRow.td_class}">{*{$aRow.name}<br><a href='/?action=catalog_part_info_view&code={$aRow.code}&id_brand={$aRow.id_brand}&item_code={$aRow.item_code}&id_provider={$aRow.id_provider}&return={$sReturn|escape:"url"}'>*}
{$aRow.name_translate}  <i>{$aRow.information}</i>{*</a>*}
<br>{if $aRow.store_number}<b>{$oLanguage->GetMessage('at store')}: {$aRow.store_number}</b>{/if}
{if $aRow.store_reserve_number} <b>{$oLanguage->GetMessage('reserved')}: {$aRow.store_reserve_number}</b>{/if}

<input type='hidden' name='r[{$aRow.code_provider}]' id='reference_{$aRow.item_code}_{$aRow.id_provider}' value=''>
</td>

<td class="cell-photo {$aRow.td_class}">
{if $aRow.image}
<div class="bg-product-photo">
	<div class="bg-photo-popup">
		<span>
			<img src="{if $aRow.image.img_path}{$aRow.image.img_path}{else}{$aRow.image}{/if}"
			alt="{if $aRow.price_group_name}{$aRow.price_group_name} {/if}{if $aRow.name_translate}{$aRow.name_translate} {/if}{if $aRow.brand}{$aRowPrice.brand} {/if}{$oLanguage->GetMessage('art.')} {$aRow.code}"
			title="{if $aRow.price_group_name}{$aRow.price_group_name} {/if}{if $aRow.name_translate}{$aRow.name_translate} {/if}{if $aRow.brand}{$aRowPrice.brand} {/if}{$oLanguage->GetMessage('art.')} {$aRow.code}">
		</span>
	</div>
</div>
{/if}
</td>
<td class="cell-stock {$aRow.td_class}">{$aRow.stock}</td>
<td class="cell-term {$aRow.td_class}">{$aRow.term}</td>
<td class="cell-price {$aRow.td_class}">
{if $aRow.price>0}
	{$oCurrency->PrintPrice($aRow.price)}
	{if $aAuthUser.type_=='manager'}
	<br><span style="color:grey;">{$oCurrency->PrintSymbol($aRow.price_original,$aRow.id_currency)}</span>
	{/if}
	{*if $aAuthUser.type_=='manager'}	
	<br><input id="price{$aRow.id}" type="text" value="" style="width:61px">
<input type="button" class='btn' value="{$oLanguage->getMessage('Set New price')}"
onclick="mf.Location('?action=catalog_price_update&id_provider={$aRow.id_provider}&item_code={$aRow.item_code}&return={$sReturn|escape:"url"}',['data[price]','price{$aRow.id}'])">
{/if*}
{else}---{/if}
</td>
{*<td class={$aRow.td_class}><input type=text name='r[{$aRow.code_provider}]' id='reference_{$aRow.code}_{$aRow.id_provider}'
	value="{if $aRow.request_reference}{$aRow.request_reference}{/if}" size=15></td>*}
{*if $aAuthUser.type_!='manager'*}
<td class="cell-count {$aRow.td_class}">
{if $aRow.price>0}
<input type=text name='n[{$aRow.code_provider}]' id='number_{$aRow.item_code}_{$aRow.id_provider}'
		value="{if $aRow.request_number}{$aRow.request_number}{else}1{/if}" size=4 style="width:30px">
{if $aRow.weight}
<br><nobr><span style="font-size: 9px;">{$oLanguage->GetMessage('weight')}: {$aRow.weight|string_format:"%.2f"}</span></nobr>
{/if}
{else}---{/if}
</td>
<td class="cell-buy" style="white-space:nowrap;">
{if $aRow.price>0}
{assign var='bAddCartVisible' value=true}

{if $smarty.request.action=='catalog_part_opt'
}
{* $aAuthUser.type_=='manager' || *}
{*|| ($smarty.get.price_type=='retail' && $aAuthUser.price_type=='margin')
|| (!$smarty.get.price_type && $aAuthUser.price_type=='discount')*}

{assign var='bAddCartVisible' value=false}
{/if}

{if $bAddCartVisible }
<span id='add_link_{$aRow.item_code}_{$aRow.id_provider}'>

{include file="catalog/link_add_cart.tpl"}

{*if $aRow.id_provider==$smarty.request.id_excluded}<span style="color:red;">{$oLanguage->getMessage("Add to cart")</span>{else}{$oLanguage->getMessage("Add to cart")</a>*}

{if $aRow.is_our_store}<span style="color:red;">{$oLanguage->GetMessage('Our store in price online')}</span>{/if}
</span>
<br>
{/if}
{*<a href="/?action=catalog_partapply&code={$aRow.code}&cat={$aRow.cat_name}"
	><img src="/image/viewmagfit.png" border=0 align=absmiddle />{$oLanguage->getMessage("Show Image")}</a>*}
{else}---{/if}
</td>
{*/if*}

{/if}