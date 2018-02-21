<a class=submenu href="?action={$sBaseAction}_approve&return={$sReturn|escape:"url"}" onclick="
	update_input('main_form','action','{$sBaseAction}_approve');
	update_input('main_form','return','{$sReturn|escape}');
	submit_form();
	return false;">

<IMG border=0 src="/libp/mpanel/images/medium/ok.png" hspace=3 align=absmiddle>{$oLanguage->getDMessage('Approve')}</A>

{include file='addon/mpanel/base_sub_menu.tpl' sBaseAction=$sBaseAction}