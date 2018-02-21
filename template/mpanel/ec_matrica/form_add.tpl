<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)" >
<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('discount')}
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
<tr>
   <td width=50%>{$oLanguage->getDMessage('Region')}:{$sZir}</td>
    <td>
   {html_options name=data[id_region] options=$aRegionList selected=$aData.id_region}
  </td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('distributor')}:{$sZir}</td>
    <td>
   {html_options name=data[id_distributor] options=$aDistributorList selected=$aData.id_distributor}
  </td>
</tr> 
<tr>
   <td width=50%>{$oLanguage->getDMessage('customer_group')}:{$sZir}</td>
    <td>
   {html_options name=data[id_customer_group] options=$aCustomerGroup selected=$aData.id_customer_group}
  </td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('customer_type')}:{$sZir}</td>
    <td>
   {html_options name=data[id_user_customer_type] options=$aCustomerType selected=$aData.id_user_customer_type}
  </td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('mdiscounts')}:{$sZir}</td>
   <td><input type=text name=data[mdiscount] value="{$aData.mdiscount|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('type_discount')}:{$sZir}</td>
    <td>
   {html_options name=data[type_mdiscount] options=$aTypeDiscountList selected=$aData.type_mdiscount}
  </td>
</tr>


{include file='addon/mpanel/form_visible.tpl' aData=$aData}
</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>