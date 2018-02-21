<td>{$aRow.id}</td>
<td>{$aRow.login}</td>
<td>{$aRow.name}</td>
<td>{$aRow.last_login}</td>
<td>{$aRow.now_login}</td>
<td>{$aRow.last_referer}</td>
<td>{$aRow.now_referer}</td>
<td>{$aRow.type_}</td>
<td>{include file='addon/mpanel/yes_no.tpl' bData=$aRow.is_base_denied}</td>
<td>{include file='addon/mpanel/base_row_action.tpl' sBaseAction=$sBaseAction}

{if '4.5.1'==$oLanguage->GetConstant('module_version:aadmin')}
<a href="{strip}
		?action=admin_change_password&id={$aRow.id}&return={$sReturn|escape:"url"}
	{/strip}"
	onclick="xajax_process_browse_url(this.href); return false;">
	<img border=0 src="/libp/mpanel/images/small/copy.png"  hspace=3 align=absmiddle
		/>{$oLanguage->getDMessage('Change password')}</a>
{/if}
</td>
