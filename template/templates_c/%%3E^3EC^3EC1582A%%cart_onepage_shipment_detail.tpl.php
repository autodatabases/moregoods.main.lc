<?php /* Smarty version 2.6.18, created on 2018-02-19 21:03:48
         compiled from cart/cart_onepage_shipment_detail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'cart/cart_onepage_shipment_detail.tpl', 44, false),)), $this); ?>
<div class="block-form" id='step_2'>
	 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "cart/cart_onepage_delivery.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <div id="for_np">
                		</div></div>
		<?php if ($this->_tpl_vars['aBonus'] > 0): ?>
		<label><?php echo $this->_tpl_vars['oLanguage']->getMessage('Use_bonus'); ?>
:&nbsp;<input  onKeyUp="xajax_process_browse_url('?action=delivery_setbonus&xajax_request=1&bonus='+this.value);  return false;" type="text" name="bonus">
			<input type=hidden name="bonus" value=""></label>		
		<?php endif; ?>
               
           
			
			<div class="head"><?php if ($this->_tpl_vars['aAdress']): ?><?php echo $this->_tpl_vars['oLanguage']->getMessage('Point_delivery'); ?>
<?php endif; ?></div>
                <div class="block-labels js-block-label">
				<?php $_from = $this->_tpl_vars['aAdress']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aItem']):
?>
                    <div class="label <?php if (! $this->_tpl_vars['bAlreadySelectedPoint']): ?>selected<?php endif; ?>">
                        <input style="-webkit-appearance: radio;" type="radio" name="id_addres"<?php if (! $this->_tpl_vars['bAlreadySelectedPoint']): ?>
    				<?php $this->assign('bAlreadySelectedPoint', 1); ?>
    				checked    			<?php endif; ?> value="<?php echo $this->_tpl_vars['aItem']['id']; ?>
">
                        <span class="caption"><?php echo $this->_tpl_vars['aItem']['addresses']; ?>
</span>
                    </div>
				<?php endforeach; endif; unset($_from); ?>
                </div>
            </div>			
            <div class="block-info" id='step_2_2'>
                <div class="head"><?php echo $this->_tpl_vars['oLanguage']->getMessage('your_data'); ?>
</div>
            <table width="100%">
			<tr>
				<td ><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('FLName'); ?>
: <?php echo $this->_tpl_vars['sZir']; ?>
</b></td>
				<td><input type=text name=data[name] value='<?php echo ((is_array($_tmp=$this->_tpl_vars['aUser']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
' maxlength=50 style="width: 100%;"></td>
			</tr>
			<tr>
				<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('City'); ?>
:</b><?php if ($_SESSION['current_cart']['price_delivery'] > 0): ?><?php echo $this->_tpl_vars['sZir']; ?>
<?php endif; ?></td>
				<td><input type=text name=data[city] value='<?php echo ((is_array($_tmp=$this->_tpl_vars['aUser']['city'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
' maxlength=50 style="width: 100%;"></td>
			</tr>
			<tr>
				<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Zip'); ?>
:</b></td>
				<td><input type=text name=data[zip] value='<?php echo ((is_array($_tmp=$this->_tpl_vars['aUser']['zip'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
' maxlength=50 style="width: 100%;"></td>
			</tr>
			<tr>
				<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Address'); ?>
:<?php if ($_SESSION['current_cart']['price_delivery'] > 0): ?><?php echo $this->_tpl_vars['sZir']; ?>
<?php endif; ?></b></td>
				<td><textarea name=data[address] style="width: 100%;"><?php echo ((is_array($_tmp=$this->_tpl_vars['aUser']['address'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea></td>
			</tr>
			<tr>
				<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Phone'); ?>
: </b></td>
				<td><input type=text name=data[phone] value='<?php echo ((is_array($_tmp=$this->_tpl_vars['aUser']['phone'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
' maxlength=50 class='phone' style="width: 100%;"></td>
			</tr>
            <tr>
                <td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Remarks'); ?>
:</b></td>
                <td><textarea name=data[customer_comment] style="width: 100%;"><?php echo ((is_array($_tmp=$this->_tpl_vars['sCustomer_comment'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea></td>
            </tr>
			</table>
            </div>
			
            <div class="block-info" id='step_2_3'    style="margin:0 0 0 125px;">
				
           
            </div>
			
            <div class="clear"></div>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "cart/cart_onepage_payment.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <div class="block-summ">
                Доставка : <strong id='price_delivery'><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($_SESSION['current_cart']['price_delivery']); ?>
</strong>

                <div class="total" id='price_total'>
                    <span><?php echo $this->_tpl_vars['oLanguage']->getMessage('Total_sum'); ?>
:</span> <?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['dTotal']); ?>

                </div>
            </div>

            <div class="block-button">
                <a href="javascript:void(0);" class="gm-button" id='continue_cart'><?php echo $this->_tpl_vars['oLanguage']->getMessage("Продолжить оформление"); ?>
</a>
                <button class='gm-button' type='submit' id='end_cart' style='display:none'><?php echo $this->_tpl_vars['oLanguage']->getMessage("Завершить оформление"); ?>
</button>
            </div>
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
	 $(\'#datestart,#dateend\').datepicker({ dateFormat:"yy-mm-dd",
         minDate:+1,
         beforeShowDay: nonWorkingDates,
         firstDay: 1
  });
	     $(\'input.datetime\').datetime({
         userLang : \'ru\'
     });
</script>'; ?>