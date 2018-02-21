<script language="javascript" type="text/javascript" src="/js/form.js?3284"></script>
<script type="text/javascript">
$(document).ready(function(){ldelim}
	mf.SetFocus("search_scan");
{rdelim}
);
</script>
<table width=100% border=0>
	<tr>
		<td><b>{$oLanguage->getMessage("Id Provider Invoice")}:</b></td>
		<td><input type=text name=search[id_provider_invoice] value='{$smarty.request.search.id_provider_invoice}'
			maxlength=20 style='width:110px'></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Id cart")} ({$oLanguage->getMessage("example 12354/5")}):</b></td>
		<td> <input id="search_scan" type=text name=search[id_cart] value='' maxlength=20 style='width:110px'>
		<b>{$smarty.request.search.id_cart}</b></td>
	</tr>
</table>


<input type=hidden name=id_user value='{$smarty.request.id_user}'>
<input type=hidden name=id_cart_invoice value='{$smarty.request.id_cart_invoice}'>