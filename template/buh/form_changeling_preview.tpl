<script type='text/javascript' src='/libp/jquery/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='/libp/jquery/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.autocomplete.css" />

<script type="text/javascript">
{literal}
$().ready(function() {
	$("#id_buh").change(function() {
		if ($("#id_subconto").val()) document.getElementById("id_subconto").value="";
		if ($("#subconto").val()) document.getElementById("subconto").value="";
	});
	$("#subconto").click(function() {
		$("#subconto").autocomplete("/?action=buh_get_subconto&id_buh=" + $("#id_buh").val(), {
			width: 260,
			selectFirst: true
		});
	});
	$("#subconto").change(function() {
		$("#subconto").autocomplete("/?action=buh_get_subconto&id_buh=" + $("#id_buh").val(), {
			width: 260,
			selectFirst: true
		});
	});
	
	$("#subconto").result(function(event, data, formatted) {
		if (data)
			$("#id_subconto").val(data[1]);
	});
});
</script>
{/literal}

<table>
	<tr>
		<td><b>{$oLanguage->getMessage("DFrom")}</b></td>
		<td><input type="text" name=search[date_from] value="{$smarty.request.search.date_from}" readonly></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("DTo")}</b></td>
		<td><input type="text" name=search[date_to] value="{$smarty.request.search.date_to}" readonly></td>
	</tr>
	<tr>
	   	<td><b>{$oLanguage->getMessage("Buh account")}:</b></td>
   		<td><select id="id_buh" name=search[id_buh] style="width: 200px;">
			{html_options options=$oLanguage->getMessageArray($aBuhAccount) selected=$smarty.request.search.id_buh}
			</select>
		</td>
   	</tr> 	
	<tr>
	   	<td><b>{$oLanguage->getMessage("Buh subconto")}:{$sZir}</b></td>
   		<td nowrap>
			<input type="text" id="subconto" value="{$aSubconto.name}" style="width: 104px;"
   			{strip}onfocus="ready">{/strip}
			<input type="text" id="id_subconto" name="search[id_subconto1]" value="{$smarty.request.search.id_subconto1}" style="width: 39px;" readonly>
			<a href="#" onclick="$(#subconto).val('')">q</a>
		</td>
   	</tr> 	
</table>