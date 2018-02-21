<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('Provider')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%>{$oLanguage->getDMessage('DirectoryCategoryName')}:</td>
   <td>{html_options name=data[id_directory_site_category] options=$aDirectorySiteCategory selected=$aData.id_directory_site_category}
   </td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('CreationTime')}:</td>
   <td><input type=text name=data[creation_time] value="{$aData.creation_time|date_format:"%d.%m.%Y %H:%M:%S"|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Name')}:{$sZir}</td>
   <td><input type=text name=data[name] value="{$aData.name|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Url')}:{$sZir}</td>
   <td><input type=text name=data[url] value="{$aData.url|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Description')}:{$sZir}</td>
   <td><input type=text name=data[description] value="{$aData.description|escape}"></td>
</tr>
<tr>
   <td>{$oLanguage->getDMessage('Visible')}:</td>
   <td><input type="hidden" name=data[visible] value="0">
   <input type=checkbox name=data[visible] value='1' style="width:22px;" {if $aData.visible}checked{/if}></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Num')}:</td>
   <td><input type=text name=data[num] value="{$aData.num|escape}"></td>
</tr>
<tr>
   <td>{$oLanguage->getDMessage('DirectLink')}:</td>
   <td>{html_options name=data[direct_link] options=$aDirectLink selected=$aData.direct_link}
   </td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Email')}:</td>
   <td><input type=text name=data[email] value="{$aData.email|escape}"></td>
</tr>
</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">

{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>