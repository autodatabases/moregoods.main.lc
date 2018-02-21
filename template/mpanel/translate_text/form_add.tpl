<FORM id='main_form' action='javascript:void(null);'
	onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
	<tr>
		<th>{$oLanguage->getDMessage('Translation')}</th>
	</tr>
	<tr>
		<td>

		<table cellspacing=2 cellpadding=1>
			<tr>
				<td width="100%">{$oLanguage->getDMessage('Code')}: {$sZir}</td>
				<td><textarea name=data[code]>{$aData.code}</textarea></td>
			</tr>
			<tr>
				<td width="100%">{$oLanguage->getDMessage('Translation')}:</td>
				<td>{$oAdmin->getCKEditor('data[content]',$aData.content)}</td>
			</tr>
		    <tr>
		   		<td>{$oLanguage->getDMessage('Use code html')}:</td>
		   		<td><input type="hidden" name=data[use_code_html] value="0">
		   			<input type=checkbox name=data[use_code_html] value='1' style="width:22px;"></td>
		  	</tr>
			<tr>
				<td width="100%">{$oLanguage->getDMessage('Translation html')}:</td>
				<td><textarea style="width: 700px;height: 300px;" name=data[content_html]>{$aData.content}</textarea></td>
			</tr>
		</table>

		</td>
	</tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}</FORM>