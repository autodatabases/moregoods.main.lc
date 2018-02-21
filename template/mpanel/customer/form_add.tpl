<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">
<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('Customer')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
  <tr>
   <td width=50%><font color='grey'>{$oLanguage->getDMessage('Manager')}:</font></td>
   <td>
	{html_options name=data[id_manager] options=$aManagerAssoc selected=$aData.id_manager}
   </td>
  </tr>
  <tr>
   <td>{$oLanguage->getDMessage('Customer Group')}:</td>
   <td>{html_options name=data[id_customer_group] options=$aCustomerGroupAssoc selected=$aData.id_customer_group}</td>
  </tr>
   <tr>
   <td>{$oLanguage->getDMessage('Customer Type')}:</td>
   <td>{html_options name=data[id_user_customer_type] options=$aCustomerType selected=$aData.id_user_customer_type}</td>
  </tr>
 <tr>
   <td>{$oLanguage->getDMessage('Login')}:{$sZir}</td>
   <td><input type=text name=data[login] value='{$aData.login}' style="width: 100px;">

   {if $aData.password_temp}
	{$oLanguage->getDMessage('Password Temp')}:
	<input type=text name=data[password_temp] value="{$aData.password_temp|escape}" style="width: 100px;" readonly>
	{/if}
   </td>
  </tr>
{if !$aData.id}
	<tr>
	   <td width=50%>{$oLanguage->getDMessage('Password')}:{$sZir}</td>
	   <td><input type=password name=data[password] value="{$aData.password|escape}">
	   </td>
	</tr>
{/if}
  <tr>
   <td>{$oLanguage->getDMessage('region')}:{$sZir}</td>
   <td>{html_options name=data[id_region] options=$aRegionList selected=$aData.id_region}</td>
  </tr>
    <tr>
        <td>{$oLanguage->getDMessage('id_geo')}:{$sZir}</td>
        <td>{html_options name=data[id_geo] options=$aRegionGeo selected=$aData.id_geo}</td>
    </tr>
  <tr>
   <td>{$oLanguage->getDMessage('Name')}:</td>
   <td><input type=text name=data[name] value='{$aData.name}'></td>
  </tr>
   <tr>
   <td>{$oLanguage->getDMessage('Discount Static')}:</td>
   <td><input type=text name=data[discount_static] value='{$aData.discount_static}'></td>
  </tr>
   <tr>
   <td>{$oLanguage->getDMessage('Discount Dynamic (%)')}:</td>
   <td><input type=text name=data[discount_dynamic] value='{$aData.discount_dynamic}'></td>
  </tr>
   <tr>
   <td>{$oLanguage->getDMessage('User Debt')}:</td>
   <td><input type=text name=data[user_debt] value='{$aData.user_debt}'></td>
  </tr>
   <tr>
   <td>{$oLanguage->getDMessage('Country')}:</td>
   <td><input type=text name=data[country] value='{$aData.country}'></td>
  </tr>
   <tr>
   <td>{$oLanguage->getDMessage('State')}:</td>
   <td><input type=text name=data[state] value='{$aData.state}'></td>
  </tr>
   <tr>
   <td>{$oLanguage->getDMessage('City')}:</td>
   <td><input type=text name=data[city] value='{$aData.city}'></td>
  </tr>
   <tr>
   <td>{$oLanguage->getDMessage('Zip')}:</td>
   <td><input type=text name=data[zip] value='{$aData.zip}'></td>
  </tr>
   <tr>
   <td>{$oLanguage->getDMessage('Company')}:</td>
   <td><input type=text name=data[company] value='{$aData.company}'></td>
  </tr>
   <tr>
   <td>{$oLanguage->getDMessage('Address')}:</td>
   <td><input type=text name=data[address] value='{$aData.address}'></td>
  </tr>
   <tr>
   <td>{$oLanguage->getDMessage('Email')}:{$sZir}</td>
   <td><input type=text name=data[email] value='{$aData.email}'></td>
  </tr>
   <tr>
   <td>{$oLanguage->getDMessage('Phone')}:</td>
   <td><input type=text name=data[phone] value='{$aData.phone}'></td>
  </tr>
   <tr>
   <td>{$oLanguage->getDMessage('Phone 2')}:</td>
   <td><input type=text name=data[phone2] value='{$aData.phone2}'></td>
  </tr>
   <tr>
   <td>{$oLanguage->getDMessage('Mobile Phone')}:</td>
   <td><input type=text name=data[phone3] value='{$aData.phone3}'></td>
  </tr>
   <tr>
   <td>{$oLanguage->getDMessage('Remarks')}:</td>
   <td><textarea name=data[remark] rows=3>{$aData.remark}</textarea></td>
  </tr>
  {include file='addon/mpanel/form_visible.tpl' aData=$aData}
  <tr>
   <td>{$oLanguage->getDMessage('Approved')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='approved' bChecked=$aData.approved}</td>
  </tr>
  <tr>
   <td>{$oLanguage->getDMessage('Is Test')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_test' bChecked=$aData.is_test}</td>
  </tr>
  <tr>
   <td>{$oLanguage->getDMessage('Receive Notification')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='receive_notification' bChecked=$aData.receive_notification}</td>
  </tr>

  <tr>
   <td>{$oLanguage->getDMessage('Is provider paid')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_provider_paid' bChecked=$aData.is_provider_paid}</td>
  </tr>
  
  <tr>
   <td>{$oLanguage->getDMessage('Ip')}:</td>
   <td>{$aData.ip}<input type=hidden name=data[ip] value="{$aData.ip|escape}"></td>
  </tr>

  </table>
</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}
</FORM>