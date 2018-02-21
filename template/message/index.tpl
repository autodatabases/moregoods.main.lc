{$sSearchForm}

<table cellpadding="0" cellspacing="1" border="0" style="padding-top: 5px; padding-bottom: 5px;" width="100%">
<tr>
	<td>
<div class="ak-taber-block">
	<a {if !$smarty.session.message.current_folder_id || $smarty.session.message.current_folder_id==1}class="selected"{/if} href="/?action=message_change_current_folder&id_message_folder=1">{$oLanguage->getMessage("Inbox")} ({$aMessageNumber.inbox})</a>
	<a {if $smarty.session.message.current_folder_id==2}class="selected"{/if} href="/?action=message_change_current_folder&id_message_folder=2">{$oLanguage->getMessage("Outbox")} ({$aMessageNumber.outbox})</a>
	<a {if $smarty.session.message.current_folder_id==3}class="selected"{/if} href="/?action=message_change_current_folder&id_message_folder=3">{$oLanguage->getMessage("Draft")} ({$aMessageNumber.draft})</a>
	<a {if $smarty.session.message.current_folder_id==4}class="selected"{/if} href="/?action=message_change_current_folder&id_message_folder=4">{$oLanguage->getMessage("Archived")} ({$aMessageNumber.deleted})</a>
	<a 
	{if $smarty.session.message.is_starred}
		href="/?action=message_change_starred&is_starred=0"
			onclick="xajax_process_browse_url(this.href);return false;"><img src="/image/starred_on.png" align="absmiddle" />
	{else}
		href="/?action=message_change_starred&is_starred=1"
			onclick="xajax_process_browse_url(this.href);return false;"><img src="/image/starred_off.png" align="absmiddle" />
	{/if}&nbsp;
	</a>
	<div class="clear"></div>
</div>
	</td>
	<td align="right" style="padding-left:10px">
	</td>
</tr>
</table>

<form method="POST" enctype="multipart/form-data" name="message_form" id="message_form_id">
<input type="hidden" name="action" value="search">
{if $compose}
	<input type="hidden" name="compose" value="1">
{/if}
{$sMainSection}

</form>