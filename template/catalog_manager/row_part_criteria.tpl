<td>{$aRow.krit_name}</td>
<td>{$aRow.krit_value}</td>
<td>{if $aRow.id_cat_info}<a href="http://{$smarty.server.SERVER_NAME}/?action=catalog_manager_delete_info&id={$aRow.id_cat_info}&return={$sReturn|escape:"url"}">
<img src="/image/delete.png" border=0  width=16 align=absmiddle /></a>
{else}&nbsp;{/if}
</td>

