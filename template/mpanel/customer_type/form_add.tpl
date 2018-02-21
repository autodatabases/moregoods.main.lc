<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">
<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('Customer group')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
  <tr>
   <td>{$oLanguage->getDMessage('Customer Group')}:</td>
   <td>{html_options name=data[id_customer_group] options=$aCustomerGroupAssoc selected=$aData.id_customer_group}</td>
  </tr>
  <tr>
   <td width=50%>{$oLanguage->getDMessage('Name')}:</td>
   <td><input type=text name=data[name] value='{$aData.ct_name}' ></td>
  </tr>
  {include file='addon/mpanel/form_visible.tpl' aData=$aData}


  </table>
</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
<input type=hidden name=data[user_id] value="{$aData.id_user|escape}">

{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}
</FORM>