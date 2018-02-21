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
   <td width=50%>{$oLanguage->getDMessage('id_antbl')}:{$sZir}</td>
   <td><input type=text name=data[id_antbl] value="{$aData.id_antbl|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('anval_nm')}:</td>
   <td><input type=text name=data[anval_nm] value="{$aData.anval_nm|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('anval_prnt')}:</td>
   <td><input type=text name=data[anval_prnt] value="{$aData.anval_prnt|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('kod')}:</td>
   <td><input type=text name=data[kod] value="{$aData.kod|escape}"></td>
</tr>
{include file='addon/mpanel/form_post_date.tpl' aData=$aData}

</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>