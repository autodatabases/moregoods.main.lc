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
   <td width=50%>{$oLanguage->getDMessage('name')}:{$sZir}</td>
   <td><input type=text name=data[name] value="{$aData.name|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Region')}:{$sZir}</td>
    <td>
   {html_options name=data[id_region] options=$aRegionList selected=$aData.id_region}
  </td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Group_p')}:{$sZir}</td>
    <td>
   {html_options name=data[id_group_p] options=$aGroupPList selected=$aData.id_group_p}
  </td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('dt1')}:{$sZir}</td>
   <td><input type=text name=data[dt1] value="{if !$aData.dt1}{$smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}{else}{$aData.dt1|escape}{/if}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('dt2')}:{$sZir}</td>
   <td><input type=text name=data[dt2] value="{if !$aData.dt2}{$smarty.now+86400|date_format:"%Y-%m-%d %H:%M:%S"}{else}{$aData.dt2|escape}{/if}"></td>
</tr>


{include file='addon/mpanel/form_visible.tpl' aData=$aData}
</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>