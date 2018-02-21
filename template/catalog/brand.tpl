<table>
<tr><td width="20%"><b style="color:#8EBB2B">{$oLanguage->getMessage("Name Brand")}</b></td><td><b>{$aRow.title}</b>
		{if $aAuthUser.type_=='manager'}
<a target="_blank" href="/?action=catalog_manager_edit_brand&pref={$aRow.pref}&return={$sReturn|escape:"url"}">
<img src="/image/design/edit.png" title="edit"></a>
		{/if}
</td>
<td rowspan="3"><img src="{$aRow.image}" alt="{$aRow.title}" title="{$aRow.title}"> 
		{if $aAuthUser.type_=='manager'}
<a target="_blank" href="/?action=catalog_manager_edit_pic_brand&pref={$aRow.pref}&return={$sReturn|escape:"url"}">
<img src="/image/design/edit.png" title="edit"></a>
		{/if}
</td></tr>
<tr><td width="20%"><b style="color:#8EBB2B">{$oLanguage->getMessage("Addres")}</b></td><td><b>{$aRow.addres}</b></td></tr>
<tr><td width="20%"><b style="color:#8EBB2B">{$oLanguage->getMessage("Site")}</b></td><td><b><a href="http://{$aRow.link}" rel="nofollow" target="_blank">{$aRow.link}</a></b></td></tr>
<tr><td width="20%" colspan="3">{$aRow.descr}</td></tr>
</table>