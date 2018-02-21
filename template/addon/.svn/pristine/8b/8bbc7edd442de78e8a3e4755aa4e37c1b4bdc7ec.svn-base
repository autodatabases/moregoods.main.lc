<td><a href="./?action=message_preview&id={$aRow.id}"
	{if $aRow.is_read}class='normal'{/if}>{$aRow.subject}</a></td>
<td>{$aRow.from}</td>
<td>{$aRow.to}</td>
<td>{$oLanguage->getDateTime($aRow.timestamp)}</td>
<td nowrap>
<a href="./?action=message_preview&id={$aRow.id}"
	{if $aRow.is_read}class='normal'{/if} ><img src="/image/tooloptions.png" border=0 width=16 align=absmiddle
	/>{$oLanguage->getMessage("Preview")}</a>

{if $smarty.session.message.current_folder_id!=4}
<a href="./?action=message_delete&id={$aRow.id}"
	onclick="if (!confirm('{$oLanguage->getMessage("Are you sure you want to delete this item?")}')) return false;"
	{if $aRow.is_read}class='normal'{/if}><img src="/image/delete.png" border=0  width=16 align=absmiddle
	/>{$oLanguage->getMessage("To Archive")}</a>
{/if}
</td>
