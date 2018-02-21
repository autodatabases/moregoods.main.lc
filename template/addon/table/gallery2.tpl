<table class="catalog_top"><tr>
<td>
	<select style="width:110px;"
		onchange="xajax_process_browse_url('./?action=product_change_table_order&value='+this.value); return false;">
		{html_options options=$aTableOrder selected=$smarty.session.table.order}
	</select>

		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
		Товаров на странице
	<select onchange="xajax_process_browse_url('./?action=product_change_row_per_page&value='+this.value); return false;">
		{html_options options=$aRowPerPage selected=$smarty.session.table.row_per_page}
	</select>
</td>
<td>
{if $sStepper}
<div class="pager">
	{$sStepper}
</div>
{/if}
</td>
</tr></table>


<h4>Вы смотрите:
{if $aPath}
		{if $aPath.sex}
			{assign var='sSex' value="sex_long"|cat:$aPath.sex}
			<a href="./?action=product_search&search[sex]={$aPath.sex}">{$oLanguage->GetMessage($sSex)}</a>
			<img src="/image/design/pointer.gif" width="5" height="9" alt="" />
		{/if}

		{if $aPath.id_product_type}
			<a href="./?action=product_search&search[id_product_type]={$aPath.id_product_type}"
				>{$aPath.pt_name}</a>
			<img src="/image/design/pointer.gif" width="5" height="9" alt="" />
		{/if}

		{if $aPath.id_collection}
			<a href="./?action=product_search&search[id_collection]={$aPath.id_collection}"
				>{$aPath.c_name}</a>
			<img src="/image/design/pointer.gif" width="5" height="9" alt="" />
		{/if}

		{if $aPath.id_brand}
			<a href="./?action=product_search&search[id_brand]={$aPath.id_brand}"
				>{$aPath.brand_name}</a>
			<img src="/image/design/pointer.gif" width="5" height="9" alt="" />
		{/if}
{/if}
</h4>

<ul class="catalog">

{assign var=i value=0}
{section name=d loop=$aItem}
	{assign var=i value=$i+1}

	{assign var=aRow value=$aItem[d]}
	{include file=$sDataTemplate}

	{if !($i % $iGallery)}
	{/if}
{/section}

{if !$aItem}
<li>
	{if $sNoItem}
		{$oLanguage->getMessage($sNoItem)}
	{else}
		{$oLanguage->getMessage("No items found")}
	{/if}
</li>
{/if}
</ul>

{if $sStepper}
<div class="pager pager_bttm">
	{$sStepper}
</div>
{/if}