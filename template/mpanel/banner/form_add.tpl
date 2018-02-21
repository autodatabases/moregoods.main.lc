<FORM id='main_form' action='javascript:void(null);'onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('Caorusel')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%>{$oLanguage->getDMessage('name')}:{$sZir}</td>
   <td><input type=text name=data[name] value="{$aData.name|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('link')}:{$sZir}</td>
   <td><input type=text name=data[link] value="{$aData.link|escape}"></td>
</tr>
<tr>
   <td>{$oLanguage->getDMessage('brand')}:{$sZir}</td>
   <td>{html_options name=data[id_brand] options=$aBrandList selected=$aData.id_brand}</td>
</tr>
    <tr>
        <td>{$oLanguage->getDMessage('Brand_group')}:{$sZir}</td>
        <td>{html_options name=data[id_brand_group] options=$aGroupList selected=$aData.id_brand_group}</td>
    </tr>
 <tr>
  <td>{$oLanguage->getDMessage('is_main')}:</td>
  <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_main' bChecked=$aData.is_main}</td>
 </tr>
 <tr>
   <td width=50%>{$oLanguage->getDMessage('sort')}:{$sZir}</td>
   <td><input type=text name=data[sort] value="{$aData.sort|escape}"></td>
</tr>
{include file='addon/mpanel/form_image.tpl' aData=$aData}
{include file='mpanel/banner/form_image.tpl' aData=$aData}
{include file='addon/mpanel/form_visible.tpl' aData=$aData}
</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">

{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>