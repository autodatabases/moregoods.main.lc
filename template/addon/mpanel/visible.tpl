{if $aRow.visible}
	<font color=green><b>{$oLanguage->getDMessage('Visible')}</b></font>
{else}
	<font color=red><b>{$oLanguage->getDMessage('Invisible')}</b></font>
{/if}