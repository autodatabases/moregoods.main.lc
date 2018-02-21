<table class="gm-block-order-filter2 no-mobile" style="background-color: #f8f8f8;border-radius: 5px;margin: 0 0 20px 0;border: 1px solid #5fb7c1; padding: 20px 20px 20px 20px;position: relative;">
<tr>
		<td colspan="2" style="vertical-align: top;">{$oLanguage->getMessage("Order")} : {$smarty.request.id}&nbsp;&nbsp;&nbsp;{$oLanguage->getMessage("Date")}: {$aData.post_date}</td> 
    </tr>
    <tr><td colspan="2"><hr></td></tr>
    <tr>		
		<td style="vertical-align: top;">{$oLanguage->getMessage("Delivery point")}:</td> 
		
    	<td style="vertical-align: top;	border: 1px solid #cccccc;padding: 10px 10px 10px 10px; border-radius: 5px;background-color: white;">
    	{foreach from=$aAdress item=aItem}
    		<label>
    			<input class="bg-radio" type="radio" name="id_addres" value="{$aItem.id}"
    			 {if $aItem.id==$aData.id_addres} checked {/if}>
    			{$aItem.addresses}
    		</label>
    		<br />
    	{/foreach} 
    	</td>
    </tr>
    <tr><td colspan="2"><hr></td></tr>
{*<tr>
	<td valign="bottom">{$oLanguage->getMessage("Sum payment")}:</td>
	<td>
	{assign var="dPayTotal" value="0"}
	{foreach from=$aPayment item=aPay}
		{$aPay.date_payment} : {$oCurrency->PrintPrice($aPay.amount)}<br>
		{assign var="dPayTotal" value="`$dPayTotal+$aPay.amount`"}
	{/foreach}
	{$oCurrency->PrintPrice($dPayTotal)}
	<a {strip}href="/?action=buh_add_amount&search[id_buh_credit]=361&search[id_buh_credit_subconto1]={$aData.id_user}
&search[id_buh_debit]=311&search[id_buh_debit_subconto1]=7
&search[buh_section_id]={$aData.id}&return={$sReturn|escape:"url"}"
{/strip}><img src="/image/inbox.png" border=0 width=16 align=absmiddle />{$oLanguage->getMessage("Deposit for cart package")}</a>
	</td>
</tr>*}
<tr>
	<td>{$oLanguage->getMessage("delivery/payment type")}:</td>
	<td ><nobr>{html_options name=data[id_delivery_type] options=$aDeliveryType selected=$aData.id_delivery_type style="padding: 10px 10px 10px 10px;width:100%;"} 
	<br> {html_options name=data[id_payment_type] options=$aPaymentType selected=$aData.id_payment_type style="padding: 10px 10px 10px 10px;width:100%;"}</nobr>
	{*$aData.delivery_type_name} / {$aData.payment_type_name*}
	</td>
</tr>
<tr>
    	<td style="vertical-align: top;">{$oLanguage->getMessage("Date_delivery")}:</td> 
                <td>
				<input class="date"  id="datestart_time" name="date_delivery" type="text"
                value="{$aData.date_delivery|date_format:"%Y-%m-%d %H:%M:%S"}">
                <br>
		<div>
		{*foreach from=$aTime item=aTimeDel}
		 <div  class="label ">
				<label><input style="-webkit-appearance: radio;"  {if $aTimeDel.id==$aData.id_time} checked {/if} type="radio" name="id_name" value="{$aTimeDel.id}"
				 ><span>&nbsp;{$aTimeDel.name}</span></label></div>
		{/foreach*}
		</div>		
				</td>
		{*   <td>
 				<input id=date_delivery name=date_delivery  style='width:100px;'
				readonly value='{if $aData.date_delivery}{$aData.date_delivery}{else}
				{$smarty.now+$oLanguage->getConstant('popup_calendar:left_board',30)*2880|date_format:"%d.%m.%Y"}{/if}'
   			 	onclick="popUpCalendar(this, document.getElementById('date_delivery'), 'dd.mm.yyyy')">
			</td>
		*}
		{literal}<style type="text/css">
			#pickerplug{
				left: 827.5px !important;
			}
		</style>{/literal}
</tr>
<tr>
	<td>{$oLanguage->getMessage("Status")}:</td>
	<td><nobr>{html_options name=data[order_status] options=$aOrderStatus selected=$aData.order_status style="padding: 10px 10px 10px 10px;width:100%;"}</nobr></td>
</tr>
<tr>
	<td>{$oLanguage->getMessage("Sum delivery")}:</td>
	<td align="left"><input type=text name=data[price_delivery] value='{$aData.price_delivery|escape}' maxlength=50 style='width:100%'></td>
</tr>
<tr>
	<td>{$oLanguage->getMessage("Sum total")}:</td>
	 {if $aData.summa_fact != 0}
	<td><input id ="cart_subtotal_fact2" type=text name=data[summa_fact] value='{$aData.summa_fact|escape}' maxlength=50 style='width:100%'></td>
	{else}
	<td><input type=text name=data[price_total] value='{$aData.price_total|escape}' maxlength=50 style='width:100%'></td>
	{/if}
</tr>
<tr>
	<td>{$oLanguage->getMessage("Bonus")}:</td>
	<td><input type="text" name=data[bonus] style='width:100%' value='{$aData.bonus|escape}'></td>
</tr>
<tr>
	<td>{$oLanguage->getMessage("Remarks")}:</td>	{*Customer<br>Comment*}
	<td><textarea name=data[customer_comment] style='width:100%' rows="7">{$aData.customer_comment|escape}</textarea></td>
</tr>
<tr>
	<td>{$oLanguage->getMessage("Manager<br>Comment<br>invisble")}:</td>
	<td><textarea name=data[manager_comment] style='width:100%' rows="5">{$aData.manager_comment|escape}</textarea></td>
</tr>
{if $aData.user_contact_address}
<tr>
	<td>{$oLanguage->getMessage("Additional<br>Address")}:</td>
	<td><input type=text name=data[user_contact_address] style='width:290px'
		readonly value='{$aData.user_contact_address|escape}'
	></td>
</tr>
{/if}
</table>
{literal}<script type="text/javascript">

     function nonWorkingDates(date){
        var day = date.getDay(), Sunday = 0, Monday = 1, Tuesday = 2, Wednesday = 3, Thursday = 4, Friday = 5, Saturday = 6;
        var closedDates = [[7, 29, 2009], [8, 25, 2020]];
        var closedDays = [[Sunday]];
        for (var i = 0; i < closedDays.length; i++) {
            if (day == closedDays[i][0]) {
                return [false];
            }

        }

        for (i = 0; i < closedDates.length; i++) {
            if (date.getMonth() == closedDates[i][0] - 1 &&
            date.getDate() == closedDates[i][1] &&
            date.getFullYear() == closedDates[i][2]) {
                return [false];
            }
        }

        return [true];
    }
	 $('#datestart_time,#dateend').datepicker({ dateFormat:"yy-mm-dd",
         minDate:+1,
         beforeShowDay: nonWorkingDates,
         firstDay: 1
  });
	     $('input.datestart_time').datetime({
         userLang : 'ru'
     });
</script>{/literal}
