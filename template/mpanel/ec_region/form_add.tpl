<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)" >
<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('region')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%>{$oLanguage->getDMessage('name')}:{$sZir}</td>
   <td><input type=text name=data[name] value="{$aData.name|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('short_name')}:</td>
   <td><input type=text name=data[short_name] value="{$aData.short_name|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('order')}:</td>
   <td><input type=text name=data[sort] value="{$aData.sort|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Phone1')}:</td>
   <td><input type=text name=data[phone1] value="{$aData.phone1|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Phone2')}:</td>
   <td><input type=text name=data[phone2] value="{$aData.phone2|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Phone3')}:</td>
   <td><input type=text name=data[phone3] value="{$aData.phone3|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('email')}:</td>
   <td><input type=text name=data[email] value="{$aData.email|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('adress')}:</td>
   <td><textarea name=data[adress] rows=5>{$aData.adress|escape}</textarea></td>
</tr>

<tr>
   <td width=50%>{$oLanguage->getDMessage('google-link')}:</td>
   <td><textarea name=data[google_link] rows=15>{$aData.google_link|escape}</textarea></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('working hours')}:</td>
   <td><textarea name=data[working_hours] rows=5> {$aData.working_hours|escape}</textarea></td>
</tr>

{include file='addon/mpanel/form_visible.tpl' aData=$aData}
</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>