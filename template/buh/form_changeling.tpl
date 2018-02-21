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
{/literal}
</script>


<table width=100% border=0>
  	<tr>	
   		<td><b>{$oLanguage->getMessage("DFrom")}:</b></td>
   		<td><input id=date_from name=search[date_from]  style='width:100px;'
			readonly value='{if $smarty.request.search.date_from}{$smarty.request.search.date_from}
			{else}{$date_from}{/if}'
   			onclick="popUpCalendar(this, this, 'dd.mm.yyyy')">
   		</td>
  	</tr>
	<tr>
	   	<td><b>{$oLanguage->getMessage("DTo")}:</b></td>
   		<td><input id=date_to name=search[date_to]  style='width:100px;'
			readonly value='{if $smarty.request.search.date_to}{$smarty.request.search.date_to}
			{else}{$date_to}{/if}'
   			onclick="popUpCalendar(this, this, 'dd.mm.yyyy')">
   		</td>
   	</tr>	 	
	<tr>
	   	<td><b>{$oLanguage->getMessage("Buh account")}:</b></td>
   		<td><select id="id_buh" name=search[id_buh] style="width: 200px;">
			{html_options options=$aBuhAccount selected=$smarty.request.search.id_buh}
			</select>
		</td>
   	</tr> 	
	<tr>
	   	<td><b>{$oLanguage->getMessage("Subconto1")}:</b></td>
   		<td nowrap>
			<input type="text" id="subconto" value="{$aSubconto.name}" style="width: 104px;"
   			{strip}onfocus="ready">{/strip}
			<input type="text" id="id_subconto" name="search[id_subconto1]" value="{$smarty.request.search.id_subconto1}" style="width: 39px;" readonly>
			<a href="#" onclick="javascript: $('#id_subconto').val(''); $('#subconto').val(''); return false;"><img src="/image/design/cancel.png"></a>
		</td>
   	</tr>
<!--	<tr>
	   	<td><b>{$oLanguage->getMessage("Subconto2")}:</b></td>
   		<td><select id="ctlSubconto" name="search[id_subconto2]" style="width: 200px;">
			{html_options options=$aSubconto selected=$smarty.request.search.id_subconto2}
			</select>
		</td>
   	</tr>	
	<tr>
	   	<td><b>{$oLanguage->getMessage("Subconto3")}:</b></td>
   		<td><select id="ctlSubconto" name="search[id_subconto3]" style="width: 200px;">
			{html_options options=$aSubconto selected=$smarty.request.search.id_subconto3}
			</select>
		</td>
   	</tr>-->
</table>