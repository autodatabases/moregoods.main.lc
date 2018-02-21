<input type="hidden" name="id_message" value="{$id_message}">

<table class="datatable" cellpadding="5" cellspacing="0" border="0">
		<tr>
		<th align="left">{$oLanguage->getMessage("Date")}:</th>
		<td width="90%">{$post_date}</td>
		</tr>
		<tr>
		<th align="left">{$oLanguage->getMessage("From")}:</th>
		<td>{$aMessage.from}</td>
		</tr>
		<tr>
		<th align="left">{$oLanguage->getMessage("To")}:</th>
		<td>
		{if $to_input} <input type=text name=to value="{$aMessage.to}{$smarty.request.compose_to}" class='message_to_input' />
			<span class='error_message'>*{$oLanguage->getMessage("Enter Nickname Only")}</span>{/if}
		{if $to_text}{$aMessage.to}{/if}
		</td>
		</tr>
		<tr>
		<th align="left">{$oLanguage->getMessage("Subject")}:</th>
		<td>
			{if $subject_input } <input type=text name=subject value="{$aMessage.subject}" style="width:472px;"> {/if}
			{if $subject_text } {$aMessage.subject}{/if}

		</td>
		</tr>
		<tr>
		<td colspan="2" class="even">

<div style="font-size:12px;margin-bottom:0">
{if $textarea_begin }<textarea rows=6 cols=60 name=text style="width:531px;">{/if}{$text}{if $textarea_end }</textarea>{/if}

{if $textarea_reply }<br /><b>{$oLanguage->getMessage("Reply to message")}</b>:<br /><textarea rows=6 cols=60 name=reply_text
	readonly style="width:531px;"
	>{$reply_text}</textarea>{/if}
</div>

		</td>
		</tr>
</table>

<div class="mt10" style="margin-left:2px"></div>

	<table cellpadding="0" cellspacing="10" border="0" width="544" align="center">
		<tr>

	{if $compose_button } <td><input class=btn type=button value='{$oLanguage->getMessage("Compose")}'
		onclick="change_form_action('message_form_id','message_compose');"></td>
	{/if}
	{if $reply_button } <td><input class=btn type=button value='{$oLanguage->getMessage("Reply")}'
		onclick="change_form_action('message_form_id','message_reply');"></td>
	{/if}
	{if $delete_button } <td><input class=btn type=button value='{$oLanguage->getMessage("Delete")}'
		onclick="change_form_action('message_form_id','message_delete');"></td>
	{/if}
	{if $send_button } <td><input class=btn type=button value='{$oLanguage->getMessage("Send")}'
		onclick="change_form_action('message_form_id','message_send');"></td>
	{/if}
	{if $draft_button } <td><input class=btn type=button value='{$oLanguage->getMessage("Save Draft")}'
		onclick="change_form_action('message_form_id','message_draft');"></td>
	{/if}
	{if $forward_button } <td><input class=btn type=button value='{$oLanguage->getMessage("Forward")}'
		onclick="change_form_action('message_form_id','message_forward');"></td>
	{/if}
	{if $discard_button } <td><input class=btn type=button value='{$oLanguage->getMessage("Discard")}'
		onclick=" location.href='/?action=message';"></td>
	{/if}

		<td nowrap width="50%" align="right">{$oLanguage->getMessage("Move to folder")}</td>
		<td width="99%">
		<select name=move_to_folder>
			<option value=1>{$oLanguage->getMessage("Inbox")}</option>
			<option value=2>{$oLanguage->getMessage("Outbox")}</option>
			<option value=3>{$oLanguage->getMessage("Draft")}</option>
			<option value=4>{$oLanguage->getMessage("Deleted")}</option>
		</select>
		</td>
		<td valign="top">
		<input class=btn type=button class='btn' value='{$oLanguage->getMessage("Move")}'
			onclick="change_form_action('message_form_id','message_move_to_folder');">
		</td>
		</tr>
</table>
