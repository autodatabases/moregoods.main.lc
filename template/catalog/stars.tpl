<span id="id_stars_{$aPartInfo.id}" class="tgp-rating">
<div style="float:left;" class="ak-rating r-{$sStars}" 
{if $aAuthUser.id}{if !$sMyStars}onclick="xajax_process_browse_url('/?action=catalog_stars&item_code={$aPartInfo.id}'); 
ShowPopup('100px');return false;"{/if}{else}onclick="alert('{$oLanguage->getMessage("vote nonreg")}');return false;"{/if}>
</div>
</span>
{$sStars/10} / 5