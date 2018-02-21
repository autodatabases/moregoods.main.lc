<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('Constant')}
 </th>
</tr>
<tr><td>

<input type=hidden name=data[type] value='{$sType}'>
<table cellspacing=2 cellpadding=1>
  <tr>
   <td width=50%>{$oLanguage->getDMessage('Key')}:{$sZir}</td>
   <td><input style="font-weight:bold;" readonly="readonly" type=text name=data[key_] value="{$aData.key_|escape}"></td>
  </tr>
  <tr>
   <td>{$oLanguage->getDMessage('Value')}:{$sZir}</td>
   <td>{if $sType == 'checkbox'}
	    <div>
		<input type=hidden name=data[value] value='{$aData.value}'>
		<input style="width: 13px;" type=checkbox name=data[new_value] value='1' {if $aData.value=='1'}checked{/if}>
	    </div>
	  	{elseif $sType == 'enum'}
	  		{foreach item=aItem from=$aOptions}
	  			<input style="width: 13px;" type="radio" name="data[value]" value="{$aItem}" {if $aItem == $sOptionCheck}checked{/if}> {$aItem}<br>
			{/foreach} 
		{elseif $sType == 'text'}
			{$oAdmin->getCKEditor('data[value]',$aData.value)}
		{elseif $sType == 'only_text'}
			<textarea rows="16" cols="50" style="width:500px;" name="data[value]">{$aData.value}</textarea>
		{elseif $sType == 'favicon'}
			<tr>
			<td>&nbsp;</td>
			{*<td>{$oLanguage->GetDMessage($sType)}:</td>*}
			<td>
			     <img id='{$sType}' style="max-width:100px" border=0 align=absmiddle hspace=5 src='{if $aData.value}{$aData.value}{else}favicon.ico{/if}'>
			     <input type=hidden name=data[value] id='{$sType}_input' value='{$aData.value}'>
			     <table><tr>
			        <td><img hspace=1 align=absmiddle src='/libp/mpanel/images/small/inbox.png'>
			        	<a href="#" onclick="{strip}
							javascript:OpenFileBrowser('/libp/mpanel/imgmanager/browser/default/browser.php
							?Type=Image&Connector=php_connector/connector.php&return_id={$sType}', 600, 400); return false;
							{/strip}"
							style='font-weight:normal'>{$oLanguage->GetDMessage('Change')}</a></td>
			        <td><img hspace=1 align=absmiddle src='/libp/mpanel/images/small/outbox.png'>
			        	<a href=# onclick="javascript:ClearImageURL('{$sType}');return false;" style='font-weight:normal'
							>{$oLanguage->GetDMessage('Clear')}</a></td>
			     </table>
			</td>
			</tr>
			
		{else}
		    <input type=text name=data[value] value="{$aData.value|escape}">
		{/if}
    </td>
  </tr>
  {if $aData.id > 0}
  <tr>
	<td width="100%">{$oLanguage->getDMessage('Description')}: {$sZir}</td>
	<td><textarea name=data[description]>{$aData.description}</textarea></td>
  </tr>
  {/if}
  </table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">

{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

{if $aData.id == -2}
	<a href="http://manual.mstarproject.com/index.php/%D0%A7%D1%82%D0%BE_%D1%82%D0%B0%D0%BA%D0%BE%D0%B5_robots.txt" target="_blank">{$oLanguage->getMessage('What is robots.txt?')}</a>
{/if}

</FORM>