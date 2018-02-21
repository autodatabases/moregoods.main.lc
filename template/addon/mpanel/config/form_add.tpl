<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('Config')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
  <tr>
   <td width=100%>{$oLanguage->getDMessage('Page Title')}:</td>
   <td><input type=text name=data[title] value="{$aData.title|escape}" ></td>
  </tr>
  <tr>
   <td>{$oLanguage->getDMessage('Meta Keywords')}:</td>
   <td><input type=text name=data[meta_k] value="{$aData.meta_k|escape}"></td>
  </tr>
  <tr>
   <td>{$oLanguage->getDMessage('Meta Description')}:</td>
   <td><input type=text name=data[meta_d] value="{$aData.meta_d|escape}" ></td>
  </tr>
  <tr>
   <td>{$oLanguage->getDMessage('Default Charset')}:</td>
   <td><input type=text name=data[meta_charset] value="{$aData.meta_charset|escape}" ></td>
  </tr>
  <tr>
   <td>{$oLanguage->getDMessage('Copyright')}:</td>
   <td><input type=text name=data[copy] value="{$aData.copy|escape}" ></td>
  </tr>
  <tr>
   <td>{$oLanguage->getDMessage('License')}:</td>
   <td><input type=text name=data[license] value="{$aData.license|escape}" ></td>
  </tr>
  <tr>
   <td>{$oLanguage->getDMessage('From email')}:</td>
   <td><input type=text name=data[from_email] value="{$aData.from_email|escape}" ></td>
  </tr>
  <tr>
   <td>{$oLanguage->getDMessage('From Name')}:</td>
   <td><input type=text name=data[from_name] value="{$aData.from_name|escape}"></td>
  </tr>
  <tr>
   <td>{$oLanguage->getDMessage('To Email (Contact)')}:</td>
   <td><input type=text name=data[to_email] value="{$aData.to_email|escape}" ></td>
  </tr>
  </table>

</td></tr>
</table>

<input type=hidden name=action value=config_apply>
<input type=hidden name=data[id] value="{$aData.id|escape}">

{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction bHideReturn=true}

</FORM>