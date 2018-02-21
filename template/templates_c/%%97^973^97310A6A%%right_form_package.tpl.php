<?php /* Smarty version 2.6.18, created on 2017-07-16 19:27:25
         compiled from manager/right_form_package.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'manager/right_form_package.tpl', 38, false),array('modifier', 'date_format', 'manager/right_form_package.tpl', 47, false),array('modifier', 'escape', 'manager/right_form_package.tpl', 76, false),)), $this); ?>
<table class="gm-block-order-filter2 no-mobile" style="background-color: #f8f8f8;border-radius: 5px;margin: 0 0 20px 0;border: 1px solid #5fb7c1; padding: 20px 20px 20px 20px;position: relative;">
<tr>
		<td colspan="2" style="vertical-align: top;"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Order'); ?>
 : <?php echo $_REQUEST['id']; ?>
&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['oLanguage']->getMessage('Date'); ?>
: <?php echo $this->_tpl_vars['aData']['post_date']; ?>
</td> 
    </tr>
    <tr><td colspan="2"><hr></td></tr>
    <tr>		
		<td style="vertical-align: top;"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Delivery point'); ?>
:</td> 
		
    	<td style="vertical-align: top;	border: 1px solid #cccccc;padding: 10px 10px 10px 10px; border-radius: 5px;background-color: white;">
    	<?php $_from = $this->_tpl_vars['aAdress']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aItem']):
?>
    		<label>
    			<input class="bg-radio" type="radio" name="id_addres" value="<?php echo $this->_tpl_vars['aItem']['id']; ?>
"
    			 <?php if ($this->_tpl_vars['aItem']['id'] == $this->_tpl_vars['aData']['id_addres']): ?> checked <?php endif; ?>>
    			<?php echo $this->_tpl_vars['aItem']['addresses']; ?>

    		</label>
    		<br />
    	<?php endforeach; endif; unset($_from); ?> 
    	</td>
    </tr>
    <tr><td colspan="2"><hr></td></tr>
<tr>
	<td><?php echo $this->_tpl_vars['oLanguage']->getMessage("delivery/payment type"); ?>
:</td>
	<td ><nobr><?php echo smarty_function_html_options(array('name' => "data[id_delivery_type]",'options' => $this->_tpl_vars['aDeliveryType'],'selected' => $this->_tpl_vars['aData']['id_delivery_type'],'style' => "padding: 10px 10px 10px 10px;width:100%;"), $this);?>
 
	<br> <?php echo smarty_function_html_options(array('name' => "data[id_payment_type]",'options' => $this->_tpl_vars['aPaymentType'],'selected' => $this->_tpl_vars['aData']['id_payment_type'],'style' => "padding: 10px 10px 10px 10px;width:100%;"), $this);?>
</nobr>
		</td>
</tr>
<tr>
    	<td style="vertical-align: top;"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Date_delivery'); ?>
:</td> 
                <td>
				<input class="date"  id="datestart_time" name="date_delivery" type="text"
                value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['date_delivery'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
">
                <br>
		<div>
				</div>		
				</td>
				<?php echo '<style type="text/css">
			#pickerplug{
				left: 827.5px !important;
			}
		</style>'; ?>

</tr>
<tr>
	<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Status'); ?>
:</td>
	<td><nobr><?php echo smarty_function_html_options(array('name' => "data[order_status]",'options' => $this->_tpl_vars['aOrderStatus'],'selected' => $this->_tpl_vars['aData']['order_status'],'style' => "padding: 10px 10px 10px 10px;width:100%;"), $this);?>
</nobr></td>
</tr>
<tr>
	<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Sum delivery'); ?>
:</td>
	<td align="left"><input type=text name=data[price_delivery] value='<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['price_delivery'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
' maxlength=50 style='width:100%'></td>
</tr>
<tr>
	<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Sum total'); ?>
:</td>
	 <?php if ($this->_tpl_vars['aData']['summa_fact'] != 0): ?>
	<td><input id ="cart_subtotal_fact2" type=text name=data[summa_fact] value='<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['summa_fact'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
' maxlength=50 style='width:100%'></td>
	<?php else: ?>
	<td><input type=text name=data[price_total] value='<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['price_total'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
' maxlength=50 style='width:100%'></td>
	<?php endif; ?>
</tr>
<tr>
	<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Bonus'); ?>
:</td>
	<td><input type="text" name=data[bonus] style='width:100%' value='<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['bonus'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
'></td>
</tr>
<tr>
	<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Remarks'); ?>
:</td>		<td><textarea name=data[customer_comment] style='width:100%' rows="7"><?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['customer_comment'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea></td>
</tr>
<tr>
	<td><?php echo $this->_tpl_vars['oLanguage']->getMessage("Manager<br>Comment<br>invisble"); ?>
:</td>
	<td><textarea name=data[manager_comment] style='width:100%' rows="5"><?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['manager_comment'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea></td>
</tr>
<?php if ($this->_tpl_vars['aData']['user_contact_address']): ?>
<tr>
	<td><?php echo $this->_tpl_vars['oLanguage']->getMessage("Additional<br>Address"); ?>
:</td>
	<td><input type=text name=data[user_contact_address] style='width:290px'
		readonly value='<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['user_contact_address'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
'
	></td>
</tr>
<?php endif; ?>
</table>
<?php echo '<script type="text/javascript">

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
	 $(\'#datestart_time,#dateend\').datepicker({ dateFormat:"yy-mm-dd",
         minDate:+1,
         beforeShowDay: nonWorkingDates,
         firstDay: 1
  });
	     $(\'input.datestart_time\').datetime({
         userLang : \'ru\'
     });
</script>'; ?>
