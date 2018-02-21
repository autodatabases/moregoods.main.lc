<a href="?action={$sBaseAction}_check_name&amp;return={$sReturn|escape:"url"}"
	onclick="xajax_process_browse_url(this.href); return false;" class="submenu">
	<img hspace="3" border="0" align="absmiddle" src="/libp/mpanel/images/small/view.png"/
	>{$oLanguage->GetDMessage('Check catname')}</a>

{include file='addon/mpanel/base_sub_menu.tpl' sBaseAction=$sBaseAction not_delete=1}