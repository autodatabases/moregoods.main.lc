<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">
<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('Price group')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Code')}:{$sZir}</td>
   <td><input type=text name=data[code] value="{$aData.code|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Code name')}:{$sZir}</td>
   <td><input type=text name=data[code_name] value="{$aData.code_name|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Name')}:{$sZir}</td>
   <td><input type=text name=data[name] value="{$aData.name|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Level')}:</td>
   <td>{html_options name=data[level] options=$aBaseLevels selected=$sBaseLevels}</td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('ID Parent')}:</td>
   <td>{html_options name=data[id_parent] options=$aBaseLevelGroups selected=$sBaseLevelGroups}</td>
</tr>

<tr>
	<td>{$oLanguage->getDMessage('title')}:</td>
	<td><input type=text name=data[title] value="{$aData.title|escape}"></td>
</tr>
<tr>
	<td>{$oLanguage->getDMessage('page_description')}:</td>
	<td><textarea name=data[page_description] rows='5'>{$aData.page_description|escape}</textarea></td>
</tr>
<tr>
	<td>{$oLanguage->getDMessage('page_keyword')}:</td>
	<td><textarea name=data[page_keyword] rows='5'>{$aData.page_keyword|escape}</textarea></td>
</tr>
<tr>
	<td>{$oLanguage->getDMessage('associate data')}:</td>
	<td><textarea name=data[link_name_group] rows='5'>{$aData.link_name_group|escape}</textarea></td>
</tr>
<tr>
	<td width="100%">{$oLanguage->getDMessage('Description')}:</td>
	<td>{$oAdmin->getCKEditor('data[description]',$aData.description)}</td>
</tr>
<tr>
	<td width="100%">{$oLanguage->getDMessage('bottom_text')}:</td>
	<td>{$oAdmin->getCKEditor('data[bottom_text]',$aData.bottom_text)}</td>
</tr>
<tr>
	<td width="100%">{$oLanguage->getDMessage('Handbooks for filter')}:</td>
	<td><select name="data[handbook][]" multiple="multiple" size="6">
		<option value="">Выберите параметры</option>
		{foreach from=$aHandbook key=iKey item=aValue}
			<option value="{$aValue.id}" 
		  	{if $aValue.id==$aSelectedHandbook[$aValue.id]}
		  		selected
		  	{/if}
		  	>{$aValue.name}</option>
		{/foreach}
		</select>
	</td>
</tr>
<tr>
   <td>{$oLanguage->getDMessage('is_product_list_visible')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_product_list_visible'
   		bChecked=$aData.is_product_list_visible}</td>
</tr>
{include file='addon/mpanel/form_image.tpl' aData=$aData}
<tr>
   <td>{$oLanguage->getDMessage('is menu')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_menu'
   		bChecked=$aData.is_menu}</td>
</tr>
<tr>
   <td>{$oLanguage->getDMessage('is main')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_main'
   		bChecked=$aData.is_main}</td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Weight')}:</td>
   <td><input type=text name=data[weight] value="{$aData.weight|escape}"></td>
</tr>
{include file='addon/mpanel/form_visible.tpl' aData=$aData}
<tr>
   <td width=50%>{$oLanguage->getDMessage('Alternate url')}:</td>
   <td><input type=text name=data[alternate_url] value="{$aData.alternate_url|escape}"></td>
</tr>
</table>
</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}
</FORM>
