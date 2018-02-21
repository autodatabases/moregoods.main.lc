<?php /* Smarty version 2.6.18, created on 2017-05-16 19:39:39
         compiled from own_auto/form_own_auto.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'upper', 'own_auto/form_own_auto.tpl', 8, false),)), $this); ?>
<table>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Marka'); ?>
:</b></td>
		<td><?php echo $this->_tpl_vars['aData']['marka']; ?>
</td>
	</tr>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('VIN'); ?>
:</b></td>
		<td><?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['vin'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
</td>
	</tr>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Model'); ?>
:</b></td>
		<td><?php echo $this->_tpl_vars['aData']['model']; ?>
</td>
	</tr>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Engine'); ?>
:</b></td>
		<td><?php echo $this->_tpl_vars['aData']['engine']; ?>
</td>
	</tr>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Country producer'); ?>
:</b></td>
		<td><?php echo $this->_tpl_vars['aData']['country_producer']; ?>
</td>
	</tr>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage("Month/Year"); ?>
:</b></td>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage($this->_tpl_vars['aData']['month']); ?>
 / <?php echo $this->_tpl_vars['aData']['year']; ?>
 </td>
	</tr>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Volume'); ?>
:</b></td>
		<td><?php echo $this->_tpl_vars['aData']['volume']; ?>
</td>
	</tr>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Body'); ?>
:</b></td>
		<td><?php echo $this->_tpl_vars['aData']['body']; ?>
</td>
	</tr>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('KPP'); ?>
:</b></td>
		<td><?php echo $this->_tpl_vars['aData']['kpp']; ?>
</td>
	</tr>

<?php if ($this->_tpl_vars['aData']['wheel']): ?>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Wheel'); ?>
:</b></td>
		<td><?php echo $this->_tpl_vars['aData']['wheel']; ?>
</td>
	</tr>
<?php endif; ?>

<?php if ($this->_tpl_vars['aData']['utable']): ?>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('VinUtable'); ?>
:</b></td>
		<td><?php echo $this->_tpl_vars['aData']['utable']; ?>
</td>
	</tr>
<?php endif; ?>

<?php if ($this->_tpl_vars['aData']['engine_number']): ?>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('VinEngineNumber'); ?>
:</b></td>
		<td><?php echo $this->_tpl_vars['aData']['engine_number']; ?>
</td>
	</tr>
<?php endif; ?>

<?php if ($this->_tpl_vars['aData']['engine_code']): ?>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('engine_code'); ?>
:</b></td>
		<td><?php echo $this->_tpl_vars['aData']['engine_code']; ?>
</td>
	</tr>
<?php endif; ?>

<?php if ($this->_tpl_vars['aData']['engine_volume']): ?>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('engine_volume'); ?>
:</b></td>
		<td><?php echo $this->_tpl_vars['aData']['engine_volume']; ?>
</td>
	</tr>
<?php endif; ?>

<?php if ($this->_tpl_vars['aData']['kpp_number']): ?>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('kpp_number'); ?>
:</b></td>
		<td><?php echo $this->_tpl_vars['aData']['kpp_number']; ?>
</td>
	</tr>
<?php endif; ?>

	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Additional'); ?>
:</b></td>
		<td><?php echo $this->_tpl_vars['aData']['additional']; ?>
</td>
	</tr>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Customer Comment'); ?>
:</b></td>
		<td><?php echo $this->_tpl_vars['aData']['customer_comment']; ?>
</td>
	</tr>
</table>