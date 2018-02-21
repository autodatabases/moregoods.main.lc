<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->GetDMessage('Provider Region')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%>{$oLanguage->GetDMessage('CodeDelivery')}:{$sZir}</td>
   <td><input type=text name=data[code_delivery] value="{$aData.code_delivery|escape}"></td>
</tr>

<tr>
   <td width=50%>{$oLanguage->GetDMessage('Name')}:{$sZir}</td>
   <td><input type=text name=data[name] value="{$aData.name|escape}"></td>
</tr>

<tr>
   <td width=50%>{$oLanguage->GetDMessage('Code')}:</td>
   <td><input type=text name=data[code] value="{$aData.code|escape}"></td>
</tr>

<!--tr>
   <td width=50%>{$oLanguage->GetDMessage('additional_delivery')}:</td>
   <td><input type=text name=data[additional_delivery] value="{$aData.additional_delivery|escape}"></td>
</tr>

<tr>
   <td>{$oLanguage->GetDMessage('is always additional')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_always_additional' bChecked=$aData.is_always_additional}</td>
</tr>

<tr>
   <td width=50%>{$oLanguage->GetDMessage('Way')}:</td>
    <td>
   {html_options name=data[id_provider_region_way] options=$oLanguage->GetMessageArray($aProviderRegionWayList) selected=$aData.id_provider_region_way}
  </td>
</tr-->

<tr>
   <td width=50%>{$oLanguage->GetDMessage('Description')}:</td>
   <td><textarea name=data[description]>{$aData.description}</textarea></td>
</tr>

<!--tr>
   <td width=50%>{$oLanguage->GetDMessage('Delivery Cost')}:</td>
   <td><input type=text name=data[delivery_cost] value="{$aData.delivery_cost|escape}"></td>
</tr-->


<!--tr>
	<td width="100%">{$oLanguage->GetDMessage('Description')}:</td>
	<td>{$oAdmin->getCKEditor('data[description]',$aData.description,600,300)}</td>
</tr-->

<tr>
	<td width="100%">{$oLanguage->GetDMessage('Full')}:</td>
	<td>{$oAdmin->getCKEditor('data[full]',$aData.full)}</td>
</tr>

{include file='addon/mpanel/form_visible.tpl' aData=$aData}

<!--tr>
	<td>{$oLanguage->GetDMessage('is calculator')}:</td>
	<td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_calculator' bChecked=$aData.is_calculator}</td>
</tr-->

</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">

{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>