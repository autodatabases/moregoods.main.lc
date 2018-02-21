<script src="/js/popcalendar.js"></script>

<table width=100% border=0 class="gm-block-order-filter no-mobile">
	<tr>
		<td>{$oLanguage->getMessage("From")}:</td>
		<td><input type=text name=search_from value='{$smarty.request.search_from}' maxlength=20 style='width:176px'></td>
		<td>{$oLanguage->getMessage("To")}:</td>
		<td><input type=text name=search_to value='{$smarty.request.search_to}' maxlength=20 style='width:176px'></td>
	</tr>
	
</table>