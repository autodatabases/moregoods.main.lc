<FORM id='main_form' action='javascript:void(null);'
	onsubmit="submit_form(this,Array())">

<table cellspacing=0 cellpadding=2 class=add_form>
	<tr>
		<th>{$oLanguage->getDMessage('Template')}</th>
	</tr>
	<tr>
		<td>

		<table cellspacing=2 cellpadding=1>
			<tr>
				<td width="100%">{$oLanguage->getDMessage('Type')}:</td>
				<td><select name=data[type_]>
 					<option value=letter{if $aData.type_=='letter'} selected{/if}>{$oLanguage->getDMessage('Letter')}</option>
			 		<option value=bill{if $aData.type_=='bill'} selected{/if}>{$oLanguage->getDMessage('Bill')}</option>
			 		<option value=content{if $aData.type_=='content'} selected{/if}>{$oLanguage->getDMessage('Content')}</option>
				</select></td>
			</tr>
			<tr>
				<td width="100%">{$oLanguage->getDMessage('Code')}:{$sZir}</td>
				<td><input type=text name=data[code] value="{$aData.code|escape}"></td>
			</tr>
			<tr>
				<td width="100%">{$oLanguage->getDMessage('Priority')}:</td>
				<td><input type=text name=data[priority] value="{$aData.priority|escape}"></td>
			</tr>
			<tr>
				<td width="100%">{$oLanguage->getDMessage('Name')}:</td>
				<td><input type=text name=data[name] value="{$aData.name|escape}"></td>
			</tr>
			<tr>
				<td width="100%">{$oLanguage->getDMessage('Content')}:</td>
				<td>{$oAdmin->getCKEditor('data[content]',$aData.content,700,600)}</td>
			</tr>
			<!--deprecated tr>
			   <td>{$oLanguage->getDMessage('Is smarty')}:</td>
			   <td><input type="hidden" name=data[is_smarty] value="0">
			   <input type=checkbox name=data[is_smarty] value='1' style="width:22px;" {if $aData.is_smarty}checked{/if}></td>
			</tr-->
			{if $smarty.server.DOCUMENT_ROOT|cat:'/template/mpanel/template/form_add_ext.tpl'|file_exists}
				{include file='mpanel/template/form_add_ext.tpl'}
			{/if}
		</table>

		</td>
	</tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}
</FORM>