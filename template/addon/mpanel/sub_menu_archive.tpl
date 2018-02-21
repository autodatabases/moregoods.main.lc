<a class=submenu href="?action={$sBaseAction}_archive&return={$sReturn|escape:"url"}" onclick="

if (confirm_archive_glg())
{ldelim}
	update_input('main_form','action','{$sBaseAction}_archive');
	update_input('main_form','return','{$sReturn|escape}');
	submit_form();
{rdelim}  return false;">

<IMG border=0 src="/libp/mpanel/images/small/archive.png" hspace=3 align=absmiddle>{$oLanguage->getDMessage('Move to Archive')}</A>