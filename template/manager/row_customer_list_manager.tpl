<td class="cell-name2" style="width:5%;padding: 0;">
<a style="padding-left: 10px;font-weight: bold;width:5%;font-size: 16px;" href="/?action=manager_customer_list_fill&id_list={$aRow.id}&return={$sReturn|escape:"url"}">{$aRow.sort}</a>
</td>
<td class="cell-name" style="width:30%;float: none;">{$aRow.name}</td>
<td class="cell-name no-mobile" style="width:20%;float: none;" >{$aRow.region}</td>
<td class="cell-name no-mobile" style="width:20%;float: none;">{$aRow.post_date}</td>
<td class="cell-name" style="width:25%;font-size: 14px;">
	<a href="/?action=manager_customer_list_edit&id={$aRow.id}">
	<img src="/image/edit.png" border=0 width=16 align=absmiddle hspace=1/>{$oLanguage->getMessage("Edit")}</a><br>
	<a href="/?action=manager_customer_list_delete&id={$aRow.id}"
	onclick="if (!confirm('{$oLanguage->getMessage("Are you sure you want to delete this item?")}')) return false;">
	<img src="/image/delete.png" border=0  width=16 align=absmiddle hspace=1/>{$oLanguage->getMessage("Delete")}</a>
</td>