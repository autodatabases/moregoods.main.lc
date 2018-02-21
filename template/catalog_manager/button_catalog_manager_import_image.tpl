<table border=0 width=100%>
<tr align="left"><td>
	<input type=button class='btn' value="{$oLanguage->getMessage("Add All")}" 
	onclick="location.href='http://{$smarty.server.SERVER_NAME}/pages/catalog_manager_set_import_image/'">
	<input type=button class='btn' value="{$oLanguage->getMessage("Delete all")}" 
	onclick="location.href='http://{$smarty.server.SERVER_NAME}/?action=catalog_manager_delete_import_image&return={$sReturn|escape:"url"}'">
	{*<input type=button class='btn' value="{$oLanguage->getMessage("Delete last imported")}" 
	onclick="location.href='http://{$smarty.server.SERVER_NAME}/?action=accessory_delete_import&imported=1&return={$sReturn|escape:"url"}'">*}
	<input type=button class='btn' value="{$oLanguage->getMessage("set code")}" 
	onclick="location.href='http://{$smarty.server.SERVER_NAME}/?action=catalog_manager_set_item_code_image&return={$sReturn|escape:"url"}'">
	</td>
</tr>
</table>