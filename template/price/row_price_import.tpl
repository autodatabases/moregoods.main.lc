{foreach key=sKey item=item from=$oTable->aColumn}
{if $sKey=='action'}
<td><a href="/?action=price_item_edit&id={$aRow.id}"
	><img src="/image/edit.png" border=0 width=16 align=absmiddle hspace=1/>{$oLanguage->getMessage("Edit")}</a>

<a href="/?action=price_item_delete&id={$aRow.id}"
	onclick="if (!confirm('{$oLanguage->getMessage("Are you sure you want to delete this item?")}')) return false;"
	><img src="/image/delete.png" border=0  width=16 align=absmiddle hspace=1/>{$oLanguage->getMessage("Delete")}</a>
</td>
{else}
<td>{$aRow.$sKey}</td>
{/if}
{/foreach}