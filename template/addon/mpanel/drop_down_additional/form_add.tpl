<FORM id='main_form' action='javascript:void(null);'
	onsubmit="submit_form(this,Array('data_description'))">

<table cellspacing=0 cellpadding=2 class=add_form>
	<tr>
		<th>{$oLanguage->getDMessage('Drop down additional')}</th>
	</tr>
	<tr>
		<td>

		<table cellspacing=2 cellpadding=1>
			<tr>
				<td>{$oLanguage->getDMessage('url')}: {$sZir}</td>
				<td><input type=text name=data[url] value="{$aData.url|escape}"></td>
			</tr>
			<tr>
				<td>{$oLanguage->getDMessage('title')}:</td>
				<td><input type=text name=data[title] value="{$aData.title|escape}"></td>
			</tr>
			<tr>
				<td>{$oLanguage->getDMessage('page_description')}:</td>
				<td><textarea name=data[page_description]>{$aData.page_description|escape}</textarea></td>
			</tr>
			<tr>
				<td>{$oLanguage->getDMessage('page_keyword')}:</td>
				<td><input type=text name=data[page_keyword] value="{$aData.page_keyword|escape}"></td>
			</tr>

			<tr>
				<td>{$oLanguage->getDMessage('Short description')}: </td>
				<td><textarea name=data[short_description]>{$aData.short_description|escape}</textarea></td>
			</tr>
			<tr>
				<td>{$oLanguage->getDMessage('Desription')}:</td>
				<td>{$oAdmin->getFCKEditor('data_description',$aData.description)}</td>
			</tr>
			<tr>
				<td>{$oLanguage->getDMessage('static_rewrite')}:</td>
				<td><input type=text name=data[static_rewrite] value="{$aData.static_rewrite|escape}"></td>
			</tr>
			{include file='addon/mpanel/form_visible.tpl' aData=$aData}
		</table>

		</td>
	</tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}</FORM>