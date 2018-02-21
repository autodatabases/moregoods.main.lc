<FORM id='main_form' action='javascript:void(null);'
	onsubmit="{strip}submit_form(this,Array('data_text'
		{if $oLanguage->GetConstant('mpanel:is_left_bottom_text_active')},'data_text_bottom','data_text_left'{/if}))
		{/strip}">

<table cellspacing=0 cellpadding=2 class=add_form style="width:705px;">
<tr>
 <th>
 {$oLanguage->getDMessage('Content editor')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
	<td width=50%>{$oLanguage->getDMessage('Select page for edit')}:</td>
	<td>
	<select name=data[id] id='drop_down_id' style="width: 500px;"
		onChange="xajax_process_browse_url('?action=content_editor_change&data[id]='+$('#drop_down_id').val());">
		{foreach from=$aDropDown item=aItem}
			<option value='{$aItem.id}' {if $aItem.id==$aData.id}selected{/if}>
			{if $aItem.level>1}&nbsp;&nbsp;{/if}{if $aItem.level>2}&nbsp;&nbsp;{/if}
			{$aItem.name}</option>
		{/foreach}
	</select>
	</td>
</tr>
<tr>
	<td colspan=2 id='text_editor_id'>
	{$sTextEditor}
	</td>
</tr>
{if $oLanguage->GetConstant('mpanel:is_left_bottom_text_active')}
<tr>
	<td colspan=2>
<hr>
	{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_text_left_visible' bChecked=$aData.is_text_left_visible
		sOnClick="$('#text_left_editor_id').toggle();"}
	<b>{$oLanguage->getDMessage('is_text_left_visible')}</b>

	<span id='text_left_editor_id' {if !$aData.is_text_left_visible}style="display: none;"{/if}>
		{$sTextLeftEditor}
	</span>
	</td>
</tr>

<tr>
	<td colspan=2 >
	<hr>
	{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_text_bottom_visible' bChecked=$aData.is_text_bottom_visible
		sOnClick="$('#text_bottom_editor_id').toggle();"}
	<b>{$oLanguage->getDMessage('is_text_bottom_visible')}</b>

	<span id='text_bottom_editor_id' {if !$aData.is_text_bottom_visible}style="display: none;"{/if}>
		{$sTextBottomEditor}
	</span>
	</td>
</tr>

{/if}
</table>

</td></tr>
</table>

<input type=hidden name=action value=content_editor_apply>

{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction bHideReturn=true}

</FORM>