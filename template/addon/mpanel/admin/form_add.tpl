<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('Admin')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
  <tr>
   <td>{$oLanguage->getDMessage('Type')}:</td>
   <td>
   	{html_options name=data[type_] values=$aType output=$aType selected=$aData.type_}
   </td>
   {if $bHasLanguageAccessRules}
       <td rowspan="4">
       			{$oLanguage->getDMessage('Languages denied')}:<br/>
       			{html_options name=data[id_language][]  options=$aLocaleAll
    				selected=$aLocaleDenied style="width:$iAdminLangSelectWidth"
    				multiple='multiple' size=$iAdminLangCount}</td>
      </tr>
	{/if}
  <tr>
   <td width=100%>{$oLanguage->getDMessage('Login')}:</td>
   <td><input type=text name=data[login] value='{$aData.login}' ></td>
  </tr>
{if '4.5.0'==$oLanguage->GetConstant('module_version:aadmin')}
  <tr>
  	<td>{$oLanguage->getDMessage('Password')}:</td>
  	<td>
	  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		     <td><select name=data[pwd_type] style='width: 80px'>
					<option value="text">Text</option>
			     	<option value="md5">MD5</option>
				</select></td>
		     <td><input type=password name=data[passwd] value='{$aData.passwd}' style='width: 205px'></td>
		  </tr>
		</table>
  	</td>
  </tr>
{/if}
{if '4.5.1'==$oLanguage->GetConstant('module_version:aadmin')}
	{if !$aData.id}
<tr>
   <td>{$oLanguage->getDMessage('Password')}:</td>
   <td><input type='password' name='data[password]' value='' /></td>
</tr>
	{/if}
{/if}
  <tr>
   <td>{$oLanguage->getDMessage('FLName')}:</td>
   <td><input type=text name=data[name] value='{$aData.name}'></td>
  </tr>
  <tr>
   <td>{$oLanguage->getDMessage('Is base access denied')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_base_denied' bChecked=$aData.is_base_denied}</td>
  </tr>
  </table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">

{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}
</FORM>