<td>{$aRow.name}</td>
<td>{$aRow.cat__pref}&nbsp;</td>
<td>{$aRow.col_code_name}</td>
<!--<td>{$aRow.col_part_eng}</td>
<td>{$aRow.col_part_rus}</td>-->
<td>{if $aRow.col_price}{$aRow.col_price}{else}{$aRow.col_price6}{/if}</td>
<td>{$aRow.last_date_work|date_format:"%d.%m.%Y %H:%M"}</td>
<td>{$aRow.file_name}</td>
<td align=right><nobr>
<a href="/?action=price_profile_edit&id={$aRow.id}&return={$sReturn|escape:"url"}"
	><img src="/image/edit.png" border=0 width=16 align=absmiddle hspace=1/>{$oLanguage->getMessage("Edit")}</a>

<a href="/?action=price_profile_delete&id={$aRow.id}&return={$sReturn|escape:"url"}"
	onclick="if (!confirm('{$oLanguage->getMessage("Are you sure you want to delete this item?")}')) return false;"
	><img src="/image/delete.png" border=0  width=16 align=absmiddle hspace=1/>{$oLanguage->getMessage("Delete")}</a>
</td>
