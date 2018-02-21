<b>{$oLanguage->GetMessage('Status')}:</b>
<div class="ak-taber-block">
	<a {if !$smarty.request.search_order_status}class="selected"{/if} href='/?action=manager_package_list'>{$oLanguage->GetMessage('All')}</a>
	<a {if $smarty.request.search_order_status=='new'}class="selected"{/if} href='/?action=manager_package_list&search_order_status=new'>{$oLanguage->GetMessage('New')}</a>
	<a {if $smarty.request.search_order_status=='pending'}class="selected"{/if} href='/?action=manager_package_list&search_order_status=pending'>{$oLanguage->GetMessage('Pending')}</a>
	<a {if $smarty.request.search_order_status=='work'}class="selected"{/if} href='/?action=manager_package_list&search_order_status=work'>{$oLanguage->GetMessage('Work')}</a>
	<a {if $smarty.request.search_order_status=='end'}class="selected"{/if} href='/?action=manager_package_list&search_order_status=end'>{$oLanguage->GetMessage('End')}</a>
	<a {if $smarty.request.search_order_status=='refused'}class="selected"{/if} href='/?action=manager_package_list&search_order_status=refused'>{$oLanguage->GetMessage('Refused')}</a>
	<div class="clear"></div>
</div>