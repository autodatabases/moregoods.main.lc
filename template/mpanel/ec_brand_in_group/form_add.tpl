<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)" >
<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('brand in group')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%>{$oLanguage->getDMessage('brand group')}:{$sZir}</td>
    <td>
   {html_options name=data[id_brand_group] options=$aBrandGroupList selected=$aData.id_brand_group}
  </td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('brand')}:{$sZir}</td>
    <td>
   {html_options name=data[id_brand] options=$aBrandList selected=$aData.id_brand}
  </td>
</tr>
{include file='addon/mpanel/form_image.tpl' aData=$aData}

{include file='addon/mpanel/form_visible.tpl' aData=$aData}
</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>