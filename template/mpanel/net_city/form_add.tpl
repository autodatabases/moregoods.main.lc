<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)" >
<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('net_city')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%>{$oLanguage->getDMessage('name_ru')}:{$sZir}</td>
   <td><input type=text name=data[name_ru] value="{$aData.name_ru|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('ec_region')}:</td>
   <td><input type=text name=data[ec_region] value="{$aData.ec_region|escape}"></td>
</tr>

</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>