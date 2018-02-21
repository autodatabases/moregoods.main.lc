<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)" >
<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('price')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%>{$oLanguage->getDMessage('product')}:{$sZir}</td>
    <td><input type=text name=data[id_product] value="{$aData.id_product|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('region')}:{$sZir}</td>
    <td>
   {html_options name=data[id_region] options=$aRegionList selected=$aData.id_region}
  </td>
</tr>

<tr>
   <td width=50%>{$oLanguage->getDMessage('price')}:{$sZir}</td>
   <td><input type=text name=data[price] value="{$aData.price|escape}"></td>
</tr>
<tr>
    <td width=50%>{$oLanguage->getDMessage('id_customer_group')}:{$sZir}</td>
    <td><input type=text name=data[id_customer_group] value="{$aData.id_customer_group|escape}"></td>
</tr>

{include file='addon/mpanel/form_visible.tpl' aData=$aData}
</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>