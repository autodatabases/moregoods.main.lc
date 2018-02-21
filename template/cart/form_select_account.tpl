<table>
<tr>
	<td><b>{$oLanguage->getMessage("Name")}:{$sZir}</b>{$oLanguage->GetContextHint('SelectSearchable')}</td>
	<td>{html_options name="data[old_name]" options=$aName selected=$aData.old_name id="select_name" style="width: 300px"
		onchange="javascript:
			xajax_process_browse_url('?action=manager_customer_info_show&id='+this.options[this.selectedIndex].value);
 			return false;"}</td>
</tr>
<tr><td colspan="2">
		<span id="customer_info"></span>
</td></tr>
</table>
<script type="text/javascript">
{literal}
$(document).ready(function() {
	$("#select_name").searchable({
	maxListSize: 50,
	maxMultiMatch: 25,
	wildcards: true,
	ignoreCase: true,
	latency: 100,
	warnNoMatch: 'no matches ...',
	zIndex: 'auto'
	});
});
{/literal}
</script>