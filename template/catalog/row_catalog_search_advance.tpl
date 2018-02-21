{foreach key=sKey item=item from=$oTable->aColumn}
{if $aRow}
{if $sKey=='action'}
<td class="cell-action">
	<div class="buy_block">
	<input type='hidden' name='r[{$aRow.code_provider}]' id='reference_{$aRow.item_code}_{$aRow.id_provider}' value=''>
	{*<input type=text name='n[{$aRow.code_provider}]' id='number_{$aRow.item_code}_{$aRow.id_provider}'
	value="{if $aRow.request_number}{$aRow.request_number}{else}1{/if}" class="buy_text" style="display:none;">*}

	{assign var='bAddCartVisible' value=true}
	{if $bAddCartVisible && $aRow.price>0}
		<span id='add_link_{$aRow.item_code}_{$aRow.id_provider}'>
		{include file="catalog/link_add_cart.tpl"}
		</span>
	{/if}
	</div>
</td>

{elseif $sKey=='img_path'}
<td class="cell-img">
{if $aRow.image.img_path || $aRow.img_path}
	<a href="{if $aRow.image.img_path}{$aRow.image.img_path}{else}{$aRow.img_path}{/if}" class="thickbox"><img
		style="text-align:left;"
		src="{if $aRow.image.img_path}{$aRow.image.img_path}{else}{$aRow.img_path}{/if}"
		alt="{if $aRow.image.alt}{$aRow.image.alt}{else}{$aRow.name_translate} {$aRow.brand} {$aRow.code}{/if}"
		title="{if $aRow.image.title}{$aRow.image.title}{else}{$aRow.name_translate} {$aRow.brand} {$aRow.code}{/if}"
		class="tovar_img"
		></a>&nbsp;
{/if}
</td>

{elseif $sKey=='provider'}
{if $aAuthUser.type_=='manager'}
<td class="{$aRow.td_class} cell-history">
	<nobr>
	<strong><a href="#" onmouseover="show_hide('history_{$aRow.id}','inline')" onmouseout="show_hide('history_{$aRow.id}','none')"
		onclick="return false" style="color:gray;"><b>{$aRow.provider}</b></a></strong></nobr>
	<div style="display:none;text-align:left;" class="tip_div" id="history_{$aRow.id}">
			<div>
			{$aRow.history}
			</div>
	</div>
</td>
{/if}

{elseif $sKey=='price'}
<td class="cell-price" style="text-align:right;white-space:nowrap;"><b>
{if $aRow.price>0}
 {$oCurrency->PrintPrice($aRow.price)}
 {if $aAuthUser.type_=='manager'}<br><span style="color:grey;float:right;">{$oCurrency->PrintSymbol($aRow.price_original,$aRow.id_currency)}</span>{/if}
{else}
 {$oLanguage->getMessage("not available")}
{/if}
</b>&nbsp;&nbsp;</td>

{elseif $sKey=='brand'}
<td class="cell-brand">{$aRow.$sKey}</td>

{elseif $sKey=='code'}
<td class="cell-code" style="text-align:center;">
	{if $aRow.cat_name}
		{if $oLanguage->getConstant('global:url_is_lower',0)}
			<a href="/buy/{$aRow.cat_name|@lower}_{$aRow.code|@lower}">{$aRow.code}</a>{if $oLanguage->getConstant('global:url_is_not_last_slash',0)}{else}/{/if}
		{else}
			<a href="/buy/{$aRow.cat_name}_{$aRow.code}">{$aRow.code}</a>{if $oLanguage->getConstant('global:url_is_not_last_slash',0)}{else}/{/if}
		{/if}
	{else}
		{$aRow.$sKey}
	{/if}
</td>

{elseif $sKey=='term'}
<td class="cell-term" style="text-align:center;">{if $aRow.price>0}{$aRow.$sKey}{else}&nbsp;{/if}</td>

{elseif $sKey=='number'}
<td class="cell-number" style="text-align:center;">{if $aRow.price>0}
<input type=text name='n[{$aRow.code_provider}]' id='number_{$aRow.item_code}_{$aRow.id_provider}'
		value="{if $aRow.request_number}{$aRow.request_number}{else}1{/if}" size=4 style="width:30px">{/if}</td>

{elseif $sKey=='name_translate'}
<td class="cell-name"><!--a href="/?action=catalog_part_info_view&code={$aRow.code}&item_code={$aRow.cat_name}_{$aRow.code}"-->
	{$aRow.name_translate} {$aRow.brand} {$aRow.code}<!--/a-->
{if $aRow.criteria}<br>{$aRow.criteria}
{elseif $aRow.description}<br>{$aRow.description}
{/if}
</td>

{else}<td class="cell-{$sKey}">{$aRow.$sKey}</td>
{/if}
{/if}
{/foreach}
