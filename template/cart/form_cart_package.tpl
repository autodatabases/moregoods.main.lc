<table>
	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Payment type")}:</b></td>
   		<td>
   		{html_options name=data[id_payment_type] options=$aPaymentType selected=$aCartPackage.id_payment_type}
   		</td>
  	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Customer comment")}:</b></td>
		<td><textarea name=data[customer_comment] style='width:270px'>{$aCartPackage.customer_comment}</textarea></td>
	</tr>
</table>
{if $aUserCart}
<table width="99%" class="datatable">
  <tr>
        <th>{$oLanguage->GetMessage('#')}</th>
        <th>{$oLanguage->GetMessage('CartCode')}</th>
        <th>{$oLanguage->GetMessage('Name/Customer_Id')}</th>
        <th>{$oLanguage->GetMessage('Term')}</th>
        <th>{$oLanguage->GetMessage('Number')}</th>
        <th>{$oLanguage->GetMessage('Price')}</th>
        <th>{$oLanguage->GetMessage('Total')}</th>
        <th>{$oLanguage->GetMessage('Delete')}</th>
  </tr>
  {foreach from=$aUserCart item=aRow}
  <tr>
        <td>{$aRow.id}</td>
        <td>{$aRow.code}</td>
        <td>{$aRow.name}</td>
        <td>{$aRow.term}</td>
        <td><input type="text" value="{$aRow.number}" name="edit[{$aRow.id}][number]" style="width:50px !important" maxlength="3"></td>
        <td>{$oCurrency->PrintPrice($aRow.price)}</td>
        <td>{$oCurrency->PrintPrice($aRow.total)}</td>
        <td><input type="checkbox" value="1" name="edit[{$aRow.id}][delete]"></td>
  </tr>
  {/foreach}
</table>
{/if}