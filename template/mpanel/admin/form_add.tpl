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
  </tr>

  <tr>
   <td width=100%>{$oLanguage->getDMessage('Login')}:</td>
   <td><input type=text name=data[login] value='{$aData.login}' ></td>
  </tr>
  <tr>
  	<td>{$oLanguage->getDMessage('Password')}:</td>
  	<td>
	  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		     <td><select name=data[pwd_type] style='width: 80px'>
					<option value="md5">MD5</option>
					<option value="text">Text</option>
				</select></td>
		     <td><input type=password name=data[passwd] value='' style='width: 205px'></td>
		  </tr>
		</table>
  	</td>
  </tr>
  <tr>
   <td>{$oLanguage->getDMessage('Èìÿ')}:</td>
   <td><input type=text name=data[name] value='{$aData.name}'></td>
  </tr>
  </table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">

{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}
</FORM>