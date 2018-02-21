<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('Delivery Type')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Code')}:{$sZir}</td>
   <td><input type=text name=data[code] value="{$aData.code|escape}"></td>
</tr>

<tr>
   <td width=50%>{$oLanguage->getDMessage('Name')}:{$sZir}</td>
   <td><input type=text name=data[name] value="{$aData.name|escape}"></td>
</tr>

<tr>
   <td width=50%>{$oLanguage->getDMessage('Price')}:{$sZir}</td>
   <td><input type=text name=data[price] value="{$aData.price|escape}"></td>
</tr>
{include file='addon/mpanel/form_image.tpl' aData=$aData}
<tr>
   <td width=50%>{$oLanguage->getDMessage('Url')}:</td>
   <td><input type=text name=data[url] value="{$aData.url|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Url additional')}:</td>
   <td><input type=text name=data[url_additional] value="{$aData.url_additional|escape}"></td>
</tr>

<tr>
   <td width=50%>{$oLanguage->getDMessage('Description')}:</td>
   <td>{$oAdmin->getCKEditor('data[description]',$aData.description)}</td>
</tr>

{include file='addon/mpanel/form_visible.tpl' aData=$aData}

<tr>
   <td width=50%>{$oLanguage->getDMessage('Num')}:</td>
   <td><input type=text name=data[num] value="{$aData.num|escape}"></td>
</tr>

<tr>
   <td width=50%>{$oLanguage->getDMessage('is phone')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_show_phone' bChecked=$aData.is_show_phone}</td>
</tr>

<tr>
   <td width=50%>{$oLanguage->getDMessage('is city')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_show_city' bChecked=$aData.is_show_city}</td>
</tr>

<tr>
   <td width=50%>{$oLanguage->getDMessage('is department')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_show_department' bChecked=$aData.is_show_department}</td>
</tr>


</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">

{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>