<?php /* Smarty version 2.6.18, created on 2017-07-16 21:49:33
         compiled from cart/cart_onepage_select_account.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'cart/cart_onepage_select_account.tpl', 12, false),array('modifier', 'escape', 'cart/cart_onepage_select_account.tpl', 60, false),array('function', 'html_options', 'cart/cart_onepage_select_account.tpl', 40, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "cart/popup_dolg.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="gm-makeorder-delivery">
<div class="loggedForm">
	<div class="block-form" id="step_2">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "cart/cart_onepage_delivery.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<div id="for_np" style="display: block;">
                <div class="head"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Date delivery'); ?>
 :</div>
                <div class="label ">
                   <b> 
				<input class="date"  id="datestart_time2" name="date_delivery"  type="text"
				readonly 
                value='<?php echo ''; ?><?php if ($this->_tpl_vars['sDateDelivery']): ?><?php echo ''; ?><?php echo $this->_tpl_vars['sDateDelivery']; ?><?php echo ''; ?><?php elseif (((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%A") : smarty_modifier_date_format($_tmp, "%A")) == 'Saturday'): ?><?php echo ''; ?><?php echo ((is_array($_tmp=time()+$this->_tpl_vars['oLanguage']->getConstant('popup_calendar:left_board_satur',60)*2880)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?><?php echo ''; ?><?php else: ?><?php echo ''; ?><?php echo ((is_array($_tmp=time()+$this->_tpl_vars['oLanguage']->getConstant('popup_calendar:left_board',30)*2880)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?><?php echo ''; ?><?php endif; ?><?php echo ''; ?>
'>
<input class="date"  id="datestart_time3" name="date_delivery"  type="text"
				readonly >
				<br>
					</b>
					                </div>
            </div>
                <label id="bonus"></label>
	

	<div class="head" id='delivery'><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Delivery point'); ?>
:</b></div>
	<div id="id_delivery_point"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "cart/cart_onepage_user_delivery_point.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>

	</div>
	<div class="block-info" id='step_2_2'>
	
		<div class="head"><?php echo $this->_tpl_vars['oLanguage']->getMessage('your_data'); ?>
</div>
		<table width="100%">
			<tr>
				<td ><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('InList'); ?>
:</b></td>
				<td><?php echo smarty_function_html_options(array('name' => "data[id_list]",'options' => $this->_tpl_vars['aList'],'selected' => $this->_tpl_vars['aData']['id_list'],'id' => 'select_list','style' => "height:29px;     margin-left: 11px; width: 265px",'onchange' => "javascript:
				xajax_process_browse_url('?action=manager_customer_recalc_cart&id_list='+this.options[this.selectedIndex].value);
				return false;"), $this);?>
</td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td ><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('FLName'); ?>
: <?php echo $this->_tpl_vars['sZir']; ?>
</b></td>
				<td><?php echo smarty_function_html_options(array('name' => "data[old_name]",'options' => $this->_tpl_vars['aName'],'selected' => $this->_tpl_vars['aData']['old_name'],'id' => 'select_name','style' => "height:29px;     margin-left: 11px; width: 265px",'onchange' => "javascript:
				xajax_process_browse_url('?action=manager_customer_recalc_cart&id='+this.options[this.selectedIndex].value);
				return false;"), $this);?>
</td>
			</tr>
		</table>
		<table id="table_id"></table>
		<div class="head"><?php echo $this->_tpl_vars['oLanguage']->getMessage('additionally'); ?>
</div>
		<table id="customer_comment" style="width:300px">
			<tr>
				<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Remarks'); ?>
:</b></td>
				<td><textarea name=data[customer_comment] style="width: 150%;"><?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['customer_comment'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea></td>
			</tr>
		</table>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "cart/cart_onepage_payment.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</div>
	<div class="clear"></div>
</div></div>
<script type="text/javascript">
<?php echo '
$(document).ready(function() {
	$("#select_name").searchable({
	maxListSize: 50,
	maxMultiMatch: 25,
	wildcards: true,
	ignoreCase: true,
	latency: 1000,
	warnNoMatch: \'no matches ...\',
	zIndex: \'auto\'
	});
});
'; ?>

</script>
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
	 	 $(\'#datestart_time2,#dateend\').datepicker({ dateFormat:"yy-mm-dd",
         minDate:+1,
         beforeShowDay: nonWorkingDates,
         firstDay: 1
  			});
	     $(\'#datestart_time3\').timepicker();
	     $(\'input.datetime\').datetime({
         userLang : \'ru\'
     });
</script>'; ?>
