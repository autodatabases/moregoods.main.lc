{ include file=cart/popup_dolg.tpl }
<div class="gm-makeorder-delivery">
<div class="loggedForm">
	<div class="block-form" id="step_2">
		{ include file="cart/cart_onepage_delivery.tpl" }
		<div id="for_np" style="display: block;">
                <div class="head">{$oLanguage->getMessage("Date delivery")} :</div>
                <div class="label ">
                   <b> 
				<input class="date"  id="datestart_time2" name="date_delivery"  type="text"
				readonly 
                value='{strip}{if $sDateDelivery}{$sDateDelivery}{elseif $smarty.now|date_format:"%A"== 'Saturday'}
                {$smarty.now+$oLanguage->getConstant('popup_calendar:left_board_satur',60)*2880|date_format:"%Y-%m-%d %H:%M:%S"}{else}
				{$smarty.now+$oLanguage->getConstant('popup_calendar:left_board',30)*2880|date_format:"%Y-%m-%d %H:%M:%S"}
				{/if}{/strip}'>
<input class="date"  id="datestart_time3" name="date_delivery"  type="text"
				readonly >
				<br>
					</b>
					{*foreach from=$aTime item=aTimeDel}
		 <div  class="label {if !$bAlreadySelectedPointTime}selected{/if}">
<label><input style="-webkit-appearance: radio;" type="radio" name="id_time" 
 value="{$aTimeDel.id}"><span>&nbsp;{$aTimeDel.name}</span></label></div>
		{/foreach*}
                </div>
            </div>
                <label id="bonus"></label>
	

	<div class="head" id='delivery'><b>{$oLanguage->getMessage("Delivery point")}:</b></div>
	<div id="id_delivery_point">{ include file="cart/cart_onepage_user_delivery_point.tpl" }</div>

	</div>
	<div class="block-info" id='step_2_2'>
	
		<div class="head">{$oLanguage->getMessage("your_data")}</div>
		<table width="100%">
			<tr>
				<td ><b>{$oLanguage->getMessage("InList")}:</b></td>
				<td>{html_options name="data[id_list]" options=$aList selected=$aData.id_list id="select_list" style="height:29px;     margin-left: 11px; width: 265px"
					onchange="javascript:
				xajax_process_browse_url('?action=manager_customer_recalc_cart&id_list='+this.options[this.selectedIndex].value);
				return false;"}</td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td ><b>{$oLanguage->getMessage("FLName")}: {$sZir}</b></td>
				<td>{html_options name="data[old_name]" options=$aName selected=$aData.old_name id="select_name" style="height:29px;     margin-left: 11px; width: 265px"
					onchange="javascript:
				xajax_process_browse_url('?action=manager_customer_recalc_cart&id='+this.options[this.selectedIndex].value);
				return false;"}</td>
			</tr>
		</table>
		<table id="table_id"></table>
		<div class="head">{$oLanguage->getMessage("additionally")}</div>
		<table id="customer_comment" style="width:300px">
			<tr>
				<td><b>{$oLanguage->getMessage("Remarks")}:</b></td>
				<td><textarea name=data[customer_comment] style="width: 150%;">{$aData.customer_comment|escape}</textarea></td>
			</tr>
		</table>
	{ include file="cart/cart_onepage_payment.tpl" }
	</div>
	<div class="clear"></div>
</div></div>
<script type="text/javascript">
{literal}
$(document).ready(function() {
	$("#select_name").searchable({
	maxListSize: 50,
	maxMultiMatch: 25,
	wildcards: true,
	ignoreCase: true,
	latency: 1000,
	warnNoMatch: 'no matches ...',
	zIndex: 'auto'
	});
});
{/literal}
</script>
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
	 	 $('#datestart_time2,#dateend').datepicker({ dateFormat:"yy-mm-dd",
         minDate:+1,
         beforeShowDay: nonWorkingDates,
         firstDay: 1
  			});
	     $('#datestart_time3').timepicker();
	     $('input.datetime').datetime({
         userLang : 'ru'
     });
</script>{/literal}
