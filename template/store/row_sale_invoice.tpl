{foreach key=sKey item=item from=$oTable->aColumn}
{if $sKey=='action'}
<td nowrap><img src="/image/delete.png" border=0  width=16 align=absmiddle />
<a href="/?action=store_sale_invoice_delete&id={$aRow.id}"
	onclick="if (!confirm('{$oLanguage->getMessage("Are you sure you want to delete this item?")}')) return false;"
	>{$oLanguage->getMessage("Delete")}</a></td>
{elseif $sKey=='count'}
<td>{include file='store/editable_input.tpl' sTable='store_basket' sCol='count' iRowId=$aRow.id sValue=$aRow.count}</td>
{elseif $sKey=='price'}
<td>{$oCurrency->PrintPrice($aRow.price)}</td>
{else}<td>{$aRow.$sKey}</td>
{/if}
{/foreach}