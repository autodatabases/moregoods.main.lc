<a class=submenu href="?action={$sBaseAction}_trash&return={$sReturn|escape:"url"}" onclick="

if (confirm_delete_glg())
{ldelim}
	update_input('main_form','action','{$sBaseAction}_trash');
	update_input('main_form','return','{$sReturn|escape}');
	submit_form();
{rdelim}  return false;">

<IMG border=0 src="/libp/mpanel/images/small/trashcan_empty.png" hspace=3 align=absmiddle>{$oLanguage->getDMessage('Move to Trash')}</A>