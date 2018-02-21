<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)" >
<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('Catalog')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Name')}:{$sZir}</td>
   <td><input type=text name=data[name] value="{$aData.name|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Pref')}:{$sZir} {$oLanguage->getContextHint("catalog_pref")}</td>
   <td><input type=text name=data[pref] value="{$aData.pref|escape}" maxlength="3"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Title')}:{$sZir}</td>
   <td><input type=text name=data[title] value="{$aData.title|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('is brand view')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_brand_view' bChecked=$aData.is_brand_view}</td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Link')}:</td>
   <td><input type=text name=data[link] value="{$aData.link|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Description')}:</td>
   <td><textarea name=data[description]>{$aData.description}</textarea></td>
</tr>
{include file='addon/mpanel/form_image.tpl' aData=$aData}
<tr>
	<td width="100%">{$oLanguage->getDMessage('Descr')}:</td>
	<td>{$oAdmin->getCKEditor('data[descr]',$aData.descr, 650, 300)}</td>
</tr>
<tr><td colspan="2"><hr></td></tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('parser_patern')}:</td>
   <td><input type=text name=data[parser_patern] value="{$aData.parser_patern}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('parser_before')}:</td>
   <td><input type=text name=data[parser_before] value="{$aData.parser_before}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('parser_after')}:</td>
   <td><input type=text name=data[parser_after] value="{$aData.parser_after}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('trim_left_by')}:</td>
   <td><input type=text name=data[trim_left_by] value="{$aData.trim_left_by}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('trim_right_by')}:</td>
   <td><input type=text name=data[trim_right_by] value="{$aData.trim_right_by}"></td>
</tr>
<tr><td colspan="2"><hr></td></tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('id_sync')}:</td>
   <td><input type=text name=data[id_sync] value="{$aData.id_sync|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('id tof')}:</td>
   <td><input type=text name=data[id_tof] value="{$aData.id_tof|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('is brand')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_brand' bChecked=$aData.is_brand}</td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('is main')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_main' bChecked=$aData.is_main}</td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('is vin brand')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_vin_brand' bChecked=$aData.is_vin_brand}</td>
</tr>
<!--tr>
   <td width=50%>{$oLanguage->getDMessage('is car')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_car' bChecked=$aData.is_car}</td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('is truck')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_truck' bChecked=$aData.is_truck}</td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('is industrial')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_industrial' bChecked=$aData.is_industrial}</td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('is trailer')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_trailer' bChecked=$aData.is_trailer}</td>
</tr-->
{include file='addon/mpanel/form_visible.tpl' aData=$aData}
</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>