
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr class="text" valign="top">
	<td height="100%" width="80%">
<h3>{$aDirectorySite.name}</h3>

{if $aDirectorySite.direct_link}
<a href='{$aDirectorySite.url}' target=_blank>
{else}
<a href='#' onclick='window.open("{$aDirectorySite.url}");'>
{/if}

{$aDirectorySite.name} </a> ({$aDirectorySite.url}) - {$aDirectorySite.description}


	</td>
</tr>
</table>