{*<ul class="secodary_tabs">
	<li class="{if $aTemplateParameter=='price'}sel{/if}"
		><a href='/?action=price'
		>{$oLanguage->GetMessage('tab price')}</a></li>

	<li class="{if $aTemplateParameter=='price_profile'}sel{/if}"
		><a href='/?action=price_profile'
		>{$oLanguage->GetMessage('price profile')}</a></li>

	<li class="{if $aTemplateParameter=='manager_cat_pref'}sel{/if}"
		><a href='/?action=manager_cat_pref'
		>{$oLanguage->GetMessage('managercatpref')}</a></li>
	
	<li class="{if $aTemplateParameter=='manager_synonym'}sel{/if}"
		><a href='/?action=manager_synonym'
		>{$oLanguage->GetMessage('managersynonym')}</a></li>
	
	<li class="{if $aTemplateParameter=='price_ftp'}sel{/if}"
		><a href='./?action=price_ftp'
		>{$oLanguage->GetMessage('price ftp')}</a></li>

</ul>
*}

<div class="ak-taber-block">
	<a {if $aTemplateParameter=='price'}class="selected"{/if} href='/?action=price'>{$oLanguage->GetMessage('tab price')}</a>
	<a {if $aTemplateParameter=='price_profile'}class="selected"{/if} href='/?action=price_profile'>{$oLanguage->GetMessage('price profile')}</a>
	<a {if $aTemplateParameter=='manager_cat_pref'}class="selected"{/if} href='/?action=manager_cat_pref'>{$oLanguage->GetMessage('managercatpref')}</a>
	<a {if $aTemplateParameter=='manager_synonym'}class="selected"{/if} href='/?action=manager_synonym'>{$oLanguage->GetMessage('managersynonym')}</a>
	<a {if $aTemplateParameter=='price_ftp'}class="selected"{/if} href='/?action=price_ftp'>{$oLanguage->GetMessage('price ftp')}</a>
	<div class="clear"></div>
</div>