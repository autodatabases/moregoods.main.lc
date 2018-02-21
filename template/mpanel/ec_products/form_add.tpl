<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)" >
<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('products')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
{include file='addon/mpanel/form_image.tpl' aData=$aData}
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
   <td width=50%>{$oLanguage->getDMessage('vt')}:{$sZir}</td>
    <td>
   {html_options name=data[id_vt] options=$aVtList selected=$aData.id_vt}
  </td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('type')}:{$sZir}</td>
    <td>
   {html_options name=data[id_type] options=$aTypeList selected=$aData.id_type}
  </td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('name')}:{$sZir}</td>
   <td><input type=text name=data[name] value="{$aData.name|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('short_name')}:</td>
   <td><input type=text name=data[short_name] value="{$aData.short_name|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('art')}:{$sZir}</td>
   <td><input type=text name=data[art] value="{$aData.art|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('barcode')}:</td>
   <td><input type=text name=data[barcode] value="{$aData.barcode|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('unit')}:</td>
   <td><input type=text name=data[unit] value="{$aData.unit|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('weight')}:</td>
   <td><input type=text name=data[weight] value="{$aData.weight|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('volume')}:</td>
   <td><input type=text name=data[volume] value="{$aData.volume|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('pack_qty')}:</td>
   <td><input type=text name=data[pack_qty] value="{$aData.pack_qty|escape}"></td>
</tr>
{include file='addon/mpanel/form_image.tpl' aData=$aData sFieldName='img'}

{include file='addon/mpanel/form_image.tpl' aData=$aData sFieldName='img2'}
<tr>
   <td width=50%>{$oLanguage->getDMessage('id_parent')}:</td>
   <td><input type=text name=data[id_parent] value="{$aData.id_parent|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('check')}:</td>
   <td><input type=text name=data[check_] value="{$aData.check_|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('select_type')}:</td>
   <td><input type=text name=data[select_type] value="{$aData.select_type|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('order')}:</td>
   <td><input type=text name=data[sort] value="{$aData.sort|escape}"></td>
</tr>


{include file='addon/mpanel/form_visible.tpl' aData=$aData}
</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>