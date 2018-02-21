<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">

<table width=800 border=0 cellspacing=0 cellpadding=0>
<tr>
   <td valign=top>


<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('Manager')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Login')}:{$sZir}</td>
   <td><input type=text name=data[login] value="{$aData.login|escape}"></td>
</tr>
{if !$aData.id}
<tr>
   <td width=50%>{$oLanguage->getDMessage('Password')}:{$sZir}</td>
   <td><input type=password name=data[password] value="{$aData.password|escape}">
   </td>
</tr>
{/if}
<tr>
   <td width=50%>{$oLanguage->getDMessage('Name')}:</td>
   <td><input type=text name=data[name] value="{$aData.name|escape}"></td>
</tr>
<tr>
 <td>{$oLanguage->getDMessage('region')}:{$sZir}</td>
 <td>{html_options name=data[id_region] options=$aRegionList selected=$aData.id_region}</td>
</tr>
{*
<tr>
        <td>{$oLanguage->getDMessage('id_geo')}:{$sZir}</td>
        <td>{html_options name=data[id_geo] options=$aRegionGeo selected=$aData.id_geo}</td>
    </tr>*}
  <tr>
  <tr>
        <td>{$oLanguage->getDMessage('customer_group')}:{$sZir}</td>
        <td>{html_options name=data[id_customer_group] options=$aCustomerGroup selected=$aData.id_customer_group}</td>
    </tr>
  <tr>
{include file='addon/mpanel/form_image.tpl' aData=$aData}

<tr>
   <td width=50%>{$oLanguage->getDMessage('Address')}:</td>
   <td><input type=text name=data[address] value="{$aData.address|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Email')}:</td>
   <td><input type=text name=data[email] value="{$aData.email|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Phone')}:</td>
   <td><input type=text name=data[phone] value="{$aData.phone|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Phone 2')}:</td>
   <td><input type=text name=data[phone2] value="{$aData.phone2|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Mobile Phone')}:</td>
   <td><input type=text name=data[phone3] value="{$aData.phone3|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Skype')}:</td>
   <td><input type=text name=data[skype] value="{$aData.skype|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Icq')}:</td>
   <td><input type=text name=data[icq] value="{$aData.icq|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Remarks')}:</td>
   <td><textarea name=data[remark]>{$aData.remark}</textarea></td>
</tr>

{include file='addon/mpanel/form_visible.tpl' aData=$aData}

<tr>
   <td>{$oLanguage->getDMessage('Approved')}:</td>
   <td><input type="hidden" name=data[approved] value="0">
   <input type=checkbox name=data[approved] value='1' style="width:22px;" {if $aData.approved}checked{/if}></td>
</tr>
<tr>
   <td>{$oLanguage->getDMessage('Has Customers')}:</td>
   <td><input type="hidden" name=data[has_customer] value="0">
   <input type=checkbox name=data[has_customer] value='1' style="width:22px;"
		{if $aData.has_customer || !$aData.id}checked{/if}></td>
</tr>
<tr>
   <td>{$oLanguage->getDMessage('Is Super Manager')}:</td>
   <td><input type="hidden" name=data[is_super_manager] value="0">
   <input type=checkbox name=data[is_super_manager] value='1' style="width:22px;" {if $aData.is_super_manager}checked{/if}></td>
</tr>
<tr>
    <td>
        <b>Роли</b>
        <hr>
    </td>
    <td></td>
</tr>
{foreach from=$aRoles item=aRole}
<tr>
    <td>{$aRole.name}</td>
    <td><input name="roles[{$aRole.id}]" type="checkbox" {if ($aRole.id|in_array:$aBindedRoles)}checked="checked"{/if}></td>
</tr>
{/foreach}


</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
<input type=hidden name=data[type_] value="manager">

{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}



</td>


{*
<!-- ------------------------------- Right section ------------------------------- -->
<td valign=top>

{if $aProviderRegion}
<table  id='provider_make_statistic_id' cellspacing=0 cellpadding=2 class=add_form
	style="width: 250px;">
<tr>
 <th>
 {$oLanguage->getDMessage('Managed regions')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
{foreach from=$aProviderRegion item=aItem}
<tr>
	<td>
<input type=checkbox name=data[user_manager_region][{$aItem.id}] value='1' style="width:22px;"
	{if $aItem.region_allowed}checked{/if}>

		</td>
	<td>{$aItem.code} - {$aItem.name}</td>
</tr>
{/foreach}
</table>

</td></tr>
</table>
{/if}


</td>
*}


</tr>
</table>

</FORM>