<table width=100% border=0>
	<tr>
		<td><b>{$oLanguage->GetMessage("Liqpay confirm")}:</b></td>
		<td width=50%>
<b>{$smarty.request.amount}</b>&nbsp;&nbsp;<b>{$smarty.request.currency}</b>

<input type="hidden" name="operation_xml" value="{$sOperationXml}" />
<input type="hidden" name="signature" value="{$sSignature}" />

		</td>
	</tr>

</table>