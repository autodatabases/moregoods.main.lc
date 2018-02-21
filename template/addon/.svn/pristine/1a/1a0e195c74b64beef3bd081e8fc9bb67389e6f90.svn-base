{if $not_add!=1}
<a href="?action={$sBaseAction}_add&amp;return={$sReturn|escape:"url"}"
	onclick="xajax_process_browse_url(this.href); return false;" class="submenu">
	<img hspace="3" border="0" align="absmiddle" src="/libp/mpanel/images/small/new.png"/
	>{$oLanguage->GetDMessage('Add new')}</a>
{/if}

{if $not_delete!=1 && !$aAdmin.is_base_denied}
<a href="?action={$sBaseAction}_delete&return={$sReturn|escape:"url"}"
	onclick="if (confirm_delete_glg())
	{ldelim}
		update_input('main_form','action','{$sBaseAction}_delete');
		update_input('main_form','return','{$sReturn|escape}');
		submit_form();
	{rdelim}   return false;" class="submenu">
	<img hspace="3" border="0" align="absmiddle" src="/libp/mpanel/images/small/delete.png"/
	>{$oLanguage->GetDMessage('Delete')}</a>
{include file='addon/mpanel/sub_menu_trash.tpl' sBaseAction=$sBaseAction}
{/if}

{if $is_trash==1}
{include file='addon/mpanel/sub_menu_trash.tpl' sBaseAction=$sBaseAction}
{/if}

{if $not_archive!=1}
{include file='addon/mpanel/sub_menu_archive.tpl' sBaseAction=$sBaseAction}
{include file='addon/mpanel/sub_menu_unarchive.tpl' sBaseAction=$sBaseAction}
{/if}