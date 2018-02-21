<td class="cell-name2" style="width:5%;padding: 0;"><a style="padding-left: 10px;font-weight: bold;font-size: 12px;">{$aRow.id}</a></td>
{*<td class="cell-price">{$aRow.id}</td>*}
{*<td class="cell-name">{$aRow.code}</td>*}
<td class="cell-name" style="width:25%;float: none;">
{assign var="Id" value=$aRow.id_user|cat:"_"|cat:$aRow.id}
{$oLanguage->AddOldParser('customer_uniq',$Id)}
{*<br>*}
{*$aRow.user_post_date*}
</td>

<td class="cell-name" style="width:45%;float: none;">
	{if $aRow.is_archive} <font color=silver>{/if}
<a target="_blank" href="/?action=catalog_product&product={$aRow.id_product}">{$aRow.name_translate}&nbsp;&nbsp; {$aRow.post_date}</a>
<span>(ID: {$aRow.id_product})&nbsp;(Apt: {$aRow.code}) (Barcod: {$aRow.barcode})   &nbsp;&nbsp; {$aRow.cat_name}</span>
</td>

{*<td class="cell-name">{$aRow.term}</td>*}
<td class="cell-name" style="padding-left: 10px;width:5%;"><b>{$aRow.number}</b></td>
<td class="cell-name" style="width:12%;float: none;">{$oCurrency->PrintPrice($aRow.price)}</td>
{*<td class="cell-name">{$oCurrency->PrintPrice($aRow.total)}</td>*}
{*<td class="cell-name">{$aRow.post_date}</td>*}

<td class="cell-name" style="width:8%;font-size: 14px;white-space:nowrap;">
{*<a href="/?action=manager_cart_edit&id={$aRow.id}"
	><img src="/image/edit.png" border=0 width=16 align=absmiddle />{$oLanguage->getMessage("EEdit")}</a>
<br>*}
<a href="/?action=manager_cart_delete&id={$aRow.id}"
	onclick="if (!confirm('{$oLanguage->getMessage("Are you sure you want to delete this item?")}')) return false;"
	><img src="/image/delete.png" border=0  width=16 align=absmiddle />{$oLanguage->getMessage("Delete")}</a>
</td>
