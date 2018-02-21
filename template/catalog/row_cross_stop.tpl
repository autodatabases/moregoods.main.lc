{foreach key=sKey item=item from=$oTable->aColumn}
{if $sKey=='action'}
<td nowrap>
<a href="/?action=catalog_cross_stop_edit&id={$aRow.id}&return={$sReturn|escape:"url"}"
><img src="/image/edit.png" border=0 width=16 align=absmiddle />{$oLanguage->getMessage("Edit")}</a>

<a href="/?action=catalog_cross_stop_delete&id={$aRow.id}&return={$sReturn|escape:"url"}"
onclick="if (!confirm('{$oLanguage->getMessage("Are you sure you want to delete this item?")}')) return false;"
><img src="/image/delete.png" border=0 width=16 align=absmiddle />{$oLanguage->getMessage("Delete")}</a>
</td>

{elseif $sKey=='pref'}
<td>{$aPref[$aRow.pref]}</td>

{elseif $sKey=='pref_crs'}
<td>{$aPref[$aRow.pref_crs]}</td>

{else}<td>{$aRow.$sKey}</td>
{/if}
{/foreach}

