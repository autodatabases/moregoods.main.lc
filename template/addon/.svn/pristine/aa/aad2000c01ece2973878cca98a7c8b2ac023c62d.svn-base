{if !$sFieldName}
	{assign var='sFieldName' value='image'}
{/if}

<tr>
<td>{$oLanguage->GetDMessage($sFieldName)}:</td>
<td>
{if $bShowImagePath}
	{$aData.$sFieldName}
{/if}
     <img id='{$sFieldName}' width=100 border=0 align=absmiddle hspace=5 src='{if $aData.$sFieldName}{$aData.$sFieldName}{/if}'>
     <input type={if $bNotHidden}text{else}hidden{/if} name=data[{$sFieldName}] id='{$sFieldName}_input' value='{$aData.$sFieldName}'>
     <table><tr>
        <td><img hspace=1 align=absmiddle src='/libp/mpanel/images/small/inbox.png'>
        	<a href="#" onclick="{strip}
				javascript:OpenFileBrowser('/libp/mpanel/imgmanager/browser/default/browser.php
				?Type=Image&Connector=php_connector/connector.php&return_id={$sFieldName}', 600, 400); return false;
				{/strip}"
				style='font-weight:normal'>{$oLanguage->GetDMessage('Change')}</a></td>
        <td><img hspace=1 align=absmiddle src='/libp/mpanel/images/small/outbox.png'>
        	<a href=# onclick="javascript:ClearImageURL('{$sFieldName}');return false;" style='font-weight:normal'
				>{$oLanguage->GetDMessage('Clear')}</a></td>
     </table>
</td>
</tr>