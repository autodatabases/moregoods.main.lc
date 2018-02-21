<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)" >
<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('Vt')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%>{$oLanguage->getDMessage('variable_nm')}:{$sZir}</td>
   <td><input type=text name=data[variable_nm] value="{$aData.variable_nm|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('id_antbl')}:</td>
   <td><input type=text name=data[id_antbl] value="{$aData.id_antbl|escape}"></td>
</tr>
<tr>
   <td>{$oLanguage->getDMessage('in_filter')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='in_filter'
   		bChecked=$aData.in_filter}</td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('view_info')}:</td>
   <td><input type=text name=data[view_info] value="{$aData.view_info|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('sort')}:</td>
   <td><input type=text name=data[sort] value="{$aData.sort|escape}"></td>
</tr>

{include file='addon/mpanel/form_visible.tpl' aData=$aData}

{include file='addon/mpanel/form_date.tpl' aData=$aData sFieldName='post_date' value='post_date'}

</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>