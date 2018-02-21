<script type='text/javascript' src='/libp/jquery/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='/libp/jquery/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.autocomplete.css" />

<script type="text/javascript">
{literal}
$().ready(function() {
	$("#id_buh_debit").change(function() {
		$("#id_buh_debit_subconto1").val("");
		$("#debit_subconto1").val("");
	});
	
	$("#debit_subconto1").autocomplete("/?action=buh_get_subconto", {
			width: 260,
			selectFirst: true,
			extraParams:{id_buh:function(){return $('#id_buh_debit').val();}}
		});
	
	$("#debit_subconto1").result(function(event, data, formatted) {
		if (data) $("#id_buh_debit_subconto1").val(data[1]);
	});
		
	$("#id_buh_credit").change(function() {
		$("#id_buh_credit_subconto1").val("");
		$("#credit_subconto1").val("");
	});
	
	$("#credit_subconto1").autocomplete("/?action=buh_get_subconto", {
			width: 260,
			selectFirst: true,
			extraParams:{id_buh:function(){return $('#id_buh_credit').val();}}
		});
	
	$("#credit_subconto1").result(function(event, data, formatted) {
		if (data) $("#id_buh_credit_subconto1").val(data[1]);
	});
});
{/literal}
</script>

<table>
	<tr>
	   	<td ><b>{$oLanguage->getMessage("Buh account from")}:{$sZir}</b></td>
   		<td><select id="id_buh_debit" name="aData[id_buh_debit]" style="width: 300px;">
			{html_options options=$oLanguage->getMessageArray($aBuh) selected=$aData.id_buh_debit}
			</select>
		</td>
   	</tr> 	
	<tr>
	   	<td><b>{$oLanguage->getMessage("Buh subconto from")}:{$sZir}</b></td>
   		<td>
			<input type="text" id="debit_subconto1" value="{$aSubcontoD.name}" autocomplete="off" style="width: 204px;">
			<input type="text" id="id_buh_debit_subconto1" name="aData[id_buh_debit_subconto1]" value="{$aSubcontoD.id}" style="width: 39px;" readonly>
			<a href="#" onclick="javascript: $('#debit_subconto1').val(''); $('#id_buh_debit_subconto1').val(''); return false;"><img src="/image/design/cancel.png"></a>
		</td>
   	</tr> 	
	<tr>
	   	<td><b>{$oLanguage->getMessage("Buh account to")}:{$sZir}</b></td>
   		<td><select id="id_buh_credit" name=aData[id_buh_credit] style="width: 300px;">
			{html_options options=$aBuh selected=$aData.id_buh_credit}
			</select>
		</td>
   		<!--td><select id="ctlBuhAccountK" name="aData[id_buh_credit]" style="width: 200px;">
			{html_options options=$aBuhAccountK selected=$aData.id_buh_credit}
			</select>
		</td-->
   	</tr> 	
	<tr>
	   	<td><b>{$oLanguage->getMessage("Buh subconto to")}:{$sZir}</b></td>
   		<td>
			<input type="text" id="credit_subconto1" value="{$aSubcontoC.name}" autocomplete="off" style="width: 204px;">
			<input type="text" id="id_buh_credit_subconto1" name="aData[id_buh_credit_subconto1]" value="{$aData.id_buh_credit_subconto1}" style="width: 39px;" readonly>
			<a href="#" onclick="javascript: $('#credit_subconto1').val(''); $('#id_buh_credit_subconto1').val(''); return false;"><img src="/image/design/cancel.png"></a>
		</td>
   		<!--td><select id="ctlSubcontoK" name="aData[id_buh_credit_subconto1]" style="width: 200px;">
			{html_options options=$aSubcontoK selected=$aData.id_buh_credit_subconto1}
			</select>
		</td-->
   	</tr> 	
	<tr>
	   	<td><b>{$oLanguage->getMessage("Buh section")}:</b></td>
   		<td><select id="id_buh_section" name="aData[id_buh_section]" style="width: 300px;">
			{html_options options=$aBuhSection selected=$aData.id_buh_section}
			</select>
		</td>
   	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Buh number section")}:</b></td>
		<td><input name=aData[buh_section_id] value='{$aData.buh_section_id}' style='width:220px'></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Buh amount")}:{$sZir}</b></td>
		<td><input type=text name=aData[amount] value='{$aData.amount}' maxlength=10 style='width:220px'></td>
	</tr>
	<tr>
		<td valign="top"><b>{$oLanguage->getMessage("Buh description")}:</b></td>
		<td><textarea name=aData[description] rows=4 style='width:300px'>{$aData.description}</textarea>
		</td>
	</tr>
	<!--tr>
		<td><b>{$oLanguage->getMessage("Currency sum")}:</b></td>
		<td nowrap>{html_options name=aData[id_currency] options=$aCurrency selected=$aData.id_currency} <input type=text name=aData[currency_sum] value='{$aData.currency_sum}' maxlength=10 style='width:120px'></td>
	</tr-->
	<tr>
		<td><b>{$oLanguage->getMessage("Date")}:</b></td>
   		<td><input id=post_date name=aData[post_date]  style="width:120px;"
			readonly value='{$aData.post_date}' onclick="popUpCalendar(this, this, 'yyyy-mm-dd')">
   		</td>
	</tr>
</table>