{if !$aAdmin.is_base_denied}
<nobr>
<A href="?action={$sBaseAction}_get_from_irbis&id={$aRow.id}&return={$sReturn|escape:"url"}" onclick="
xajax_process_browse_url(this.href); return false;">
<IMG class=action_image border=0 src="/libp/mpanel/images/small/arrow_down_blue.png"
	hspace=3 align=absmiddle>{$oLanguage->getDMessage('Get from irbis')}</A>
</nobr>
{/if}
{if !$aAdmin.is_base_denied and $aAdmin.login == $CheckLogin}
<nobr>
<A href="?action={$sBaseAction}_send_irbis&id={$aRow.id}&return={$sReturn|escape:"url"}" onclick="
xajax_process_browse_url(this.href);  return false;">
<IMG border=0 class=action_image src="/libp/mpanel/images/small/arrow_up_blue.png" hspace=3 align=absmiddle>{$oLanguage->getDMessage('Send to irbis')}</A>
</nobr>
{/if}