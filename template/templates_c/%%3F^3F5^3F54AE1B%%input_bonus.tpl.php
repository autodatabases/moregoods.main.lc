<?php /* Smarty version 2.6.18, created on 2017-05-19 11:24:56
         compiled from cart/input_bonus.tpl */ ?>
<?php echo $this->_tpl_vars['oLanguage']->getMessage('Use_bonus'); ?>
:&nbsp;<input  onKeyUp="xajax_process_browse_url('?action=delivery_setbonus&xajax_request=1&bonus='+this.value);  return false;" type="text" name="bonus">
			<input type=hidden name="bonus" value="">