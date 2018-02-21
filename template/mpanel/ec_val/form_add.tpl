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
   <td width=50%>{$oLanguage->getDMessage('id_variable')}:{$sZir}</td>
   <td><input type=text name=data[id_variable] value="{$aData.id_variable|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('id_product')}:</td>
   <td><input type=text name=data[id_product] value="{$aData.id_product|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('id_anval')}:</td>
   <td><input type=text name=data[id_anval] value="{$aData.id_anval|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('val')}:</td>
   <td><input type=text name=data[val] value="{$aData.val|escape}"></td>
</tr>


{include file='addon/mpanel/form_date.tpl' aData=$aData}
{include file='addon/mpanel/form_post_date.tpl' aData=$aData}

</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>