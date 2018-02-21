<div class="block-form" id='step_2'>
	 { include file="cart/cart_onepage_delivery.tpl" }
                <div id="for_np">
                {*<div class="head">{$oLanguage->getMessage("dostavka time")}:</div>
                    
<input class="date"  id="datestart" name="date_delivery"  type="text"
				readonly 
                value='{strip}{if $sDateDelivery}{$sDateDelivery}{elseif $smarty.now|date_format:"%A"== 'Saturday'}
                {$smarty.now+$oLanguage->getConstant('popup_calendar:left_board_satur',60)*2880|date_format:"%d.%m.%Y"}{else}
				{$smarty.now+$oLanguage->getConstant('popup_calendar:left_board',30)*2880|date_format:"%d.%m.%Y"}
				{/if}{/strip}'><br>
		<div>
			<br>
		{foreach from=$aTime item=aTimeDel}
		 <div  class="label {if !$bAlreadySelectedPointTime}selected{/if}">
<label><input style="-webkit-appearance: radio;" type="radio" name="id_time" 
 value="{$aTimeDel.id}"><span>&nbsp;{$aTimeDel.name}</span></label></div>
		{/foreach*}
		</div></div>
		{if $aBonus > 0}
		<label>{$oLanguage->getMessage("Use_bonus")}:&nbsp;<input  onKeyUp="xajax_process_browse_url('?action=delivery_setbonus&xajax_request=1&bonus='+this.value);  return false;" type="text" name="bonus">
			<input type=hidden name="bonus" value=""></label>		
		{/if}
               
           
			
			<div class="head">{if $aAdress}{$oLanguage->getMessage("Point_delivery")}{/if}</div>
                <div class="block-labels js-block-label">
				{foreach from=$aAdress item=aItem}
                    <div class="label {if !$bAlreadySelectedPoint}selected{/if}">
                        <input style="-webkit-appearance: radio;" type="radio" name="id_addres"{if !$bAlreadySelectedPoint}
    				{assign var=bAlreadySelectedPoint value=1}
    				checked    			{/if} value="{$aItem.id}">
                        <span class="caption">{$aItem.addresses}</span>
                    </div>
				{/foreach}
                </div>
            </div>			
            <div class="block-info" id='step_2_2'>
                <div class="head">{$oLanguage->getMessage("your_data")}</div>
            <table width="100%">
			<tr>
				<td ><b>{$oLanguage->getMessage("FLName")}: {$sZir}</b></td>
				<td><input type=text name=data[name] value='{$aUser.name|escape}' maxlength=50 style="width: 100%;"></td>
			</tr>
			<tr>
				<td><b>{$oLanguage->getMessage("City")}:</b>{if $smarty.session.current_cart.price_delivery>0}{$sZir}{/if}</td>
				<td><input type=text name=data[city] value='{$aUser.city|escape}' maxlength=50 style="width: 100%;"></td>
			</tr>
			<tr>
				<td><b>{$oLanguage->getMessage("Zip")}:</b></td>
				<td><input type=text name=data[zip] value='{$aUser.zip|escape}' maxlength=50 style="width: 100%;"></td>
			</tr>
			<tr>
				<td><b>{$oLanguage->getMessage("Address")}:{if $smarty.session.current_cart.price_delivery>0}{$sZir}{/if}</b></td>
				<td><textarea name=data[address] style="width: 100%;">{$aUser.address|escape}</textarea></td>
			</tr>
			<tr>
				<td><b>{$oLanguage->getMessage("Phone")}: </b></td>
				<td><input type=text name=data[phone] value='{$aUser.phone|escape}' maxlength=50 class='phone' style="width: 100%;"></td>
			</tr>
            <tr>
                <td><b>{$oLanguage->getMessage("Remarks")}:</b></td>
                <td><textarea name=data[customer_comment] style="width: 100%;">{$sCustomer_comment|escape}</textarea></td>
            </tr>
			</table>
            </div>
			
            <div class="block-info" id='step_2_3'    style="margin:0 0 0 125px;">
				
           
            </div>
			
            <div class="clear"></div>

            { include file="cart/cart_onepage_payment.tpl" }
            <div class="block-summ">
                Доставка : <strong id='price_delivery'>{$oCurrency->PrintPrice($smarty.session.current_cart.price_delivery)}</strong>

                <div class="total" id='price_total'>
                    <span>{$oLanguage->getMessage("Total_sum")}:</span> {$oCurrency->PrintPrice($dTotal)}
                </div>
            </div>

            <div class="block-button">
                <a href="javascript:void(0);" class="gm-button" id='continue_cart'>{$oLanguage->getMessage("Продолжить оформление")}</a>
                <button class='gm-button' type='submit' id='end_cart' style='display:none'>{$oLanguage->getMessage("Завершить оформление")}</button>
            </div>
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
	 $('#datestart,#dateend').datepicker({ dateFormat:"yy-mm-dd",
         minDate:+1,
         beforeShowDay: nonWorkingDates,
         firstDay: 1
  });
	     $('input.datetime').datetime({
         userLang : 'ru'
     });
</script>{/literal}