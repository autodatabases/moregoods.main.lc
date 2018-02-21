<LINK href="/libp/css/message.css" rel=stylesheet type=text/css>

{$sSearchForm}

<table cellpadding="0" cellspacing="1" border="0" style="padding-top: 5px; padding-bottom: 5px;" >
<tr>
	<td>
<ul class="secodary_tabs">
	<li {if !$smarty.session.message.current_folder_id || $smarty.session.message.current_folder_id==1}class="sel"{/if}>
<a href='?action=message_change_current_folder&id_message_folder=1'>&nbsp;
		{$oLanguage->getMessage("Inbox")}({$aMessageNumber.inbox})</a></li>
	<li {if $smarty.session.message.current_folder_id==2}class="sel"{/if}>
<a href='?action=message_change_current_folder&id_message_folder=2'>{$oLanguage->getMessage("Outbox")}
		({$aMessageNumber.outbox})</a>
	</li>
	<li {if $smarty.session.message.current_folder_id==3}class="sel"{/if}>
<a href='?action=message_change_current_folder&id_message_folder=3'>{$oLanguage->getMessage("Draft")}
		({$aMessageNumber.draft})</a>
	</li>
	<li {if $smarty.session.message.current_folder_id==4}class="sel"{/if}>
<a href='?action=message_change_current_folder&id_message_folder=4'>{$oLanguage->getMessage("Archived")}
		({$aMessageNumber.deleted})</a>
	</li>
</ul>
	</td>
	<td align="right" style="padding-left:10px">
		<!--input type=button class='btn' value='{$oLanguage->getMessage("Empty")}'
			onclick="change_form_action('message_form_id','message_clear');"-->
	</td>
</tr>
</table>

<form method="POST" enctype="multipart/form-data" name="message_form" id="message_form_id">
<input type="hidden" name="action" value="search">

{$sMainSection}

</form>