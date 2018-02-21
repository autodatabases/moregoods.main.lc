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
				<td><textarea name=data[content]>{$aData.content}</textarea></td>
			</tr>
			<tr>
				<td width="100%">{$oLanguage->getDMessage('Page')}:</td>
				<td><input type=text name=data[page] value="{$aData.page|escape}"></td>
			</tr>
		</table>

		</td>
	</tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>