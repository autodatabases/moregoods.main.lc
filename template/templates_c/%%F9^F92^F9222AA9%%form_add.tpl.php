<?php /* Smarty version 2.6.18, created on 2018-02-07 21:05:58
         compiled from mpanel/drop_down_additional/form_add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'mpanel/drop_down_additional/form_add.tpl', 14, false),)), $this); ?>
<FORM id='main_form' action='javascript:void(null);'
	onsubmit="submit_form(this,Array('data_description'))">

<table cellspacing=0 cellpadding=2 class=add_form>
	<tr>
		<th><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Drop down additional'); ?>
</th>
	</tr>
	<tr>
		<td>

		<table cellspacing=2 cellpadding=1>
			<tr>
				<td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('url'); ?>
: <?php echo $this->_tpl_vars['sZir']; ?>
</td>
				<td><input type=text name=data[url] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['url'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
			</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('title'); ?>
:</td>
				<td><input type=text name=data[title] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
			</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('page_description'); ?>
:</td>
				<td><textarea name=data[page_description]><?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['page_description'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea></td>
			</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('page_keyword'); ?>
:</td>
				<td><input type=text name=data[page_keyword] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['page_keyword'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
			</tr>

						<tr>
				<td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Desription'); ?>
:</td>
				<td><?php echo $this->_tpl_vars['oAdmin']->getFCKEditor('data_description',$this->_tpl_vars['aData']['description']); ?>
</td>
			</tr>
						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_visible.tpl', 'smarty_include_vars' => array('aData' => $this->_tpl_vars['aData'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</table>

		</td>
	</tr>
</table>

<input type=hidden name=data[id] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/base_add_button.tpl', 'smarty_include_vars' => array('sBaseAction' => $this->_tpl_vars['sBaseAction'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></FORM>