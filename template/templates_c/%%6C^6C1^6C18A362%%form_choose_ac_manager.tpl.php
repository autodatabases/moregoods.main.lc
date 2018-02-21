<?php /* Smarty version 2.6.18, created on 2017-05-18 11:39:42
         compiled from cart/form_choose_ac_manager.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'cart/form_choose_ac_manager.tpl', 8, false),)), $this); ?>

			<tr>
				<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('City'); ?>
:</b><?php if ($_SESSION['current_cart']['price_delivery'] > 0): ?><?php echo $this->_tpl_vars['sZir']; ?>
<?php endif; ?></td>
				<td><input type=text id="city" name=data[city] readonly value='<?php echo $this->_tpl_vars['aDataAlready']['city']; ?>
' maxlength=50 style="width: 150%;"></td>
			</tr>
			<tr>
				<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Zip'); ?>
:</b></td>
				<td><input type=text name=data[zip] readonly value='<?php echo ((is_array($_tmp=$this->_tpl_vars['aDataAlready']['zip'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
' maxlength=50 style="width: 150%;"></td>
			</tr>
			<tr>
				<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Address'); ?>
:<?php if ($_SESSION['current_cart']['price_delivery'] > 0): ?><?php echo $this->_tpl_vars['sZir']; ?>
<?php endif; ?></b></td>
				<td><textarea name=data[address] readonly style="width: 150%;"><?php echo ((is_array($_tmp=$this->_tpl_vars['aDataAlready']['address'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea></td>
			</tr>
			<tr>
				<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Phone'); ?>
: </b></td>
				<td><input type=text name=data[phone] readonly value='<?php echo ((is_array($_tmp=$this->_tpl_vars['aDataAlready']['phone'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
' maxlength=50 class='phone' style="width: 150%;"></td>
			</tr>
		