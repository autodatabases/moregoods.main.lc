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
   <td width=50%>{$oLanguage->getDMessage('antbl_nm')}:{$sZir}</td>
   <td><input type=text name=data[antbl_nm] value="{$aData.antbl_nm|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('tbl_nm')}:</td>
   <td><input type=text name=data[tbl_nm] value="{$aData.tbl_nm|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('id_fld')}:</td>
   <td><input type=text name=data[id_fld] value="{$aData.id_fld|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('nm_fld')}:</td>
   <td><input type=text name=data[nm_fld] value="{$aData.nm_fld|escape}"></td>
</tr>
{include file='addon/mpanel/form_post_date.tpl' aData=$aData}

</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>