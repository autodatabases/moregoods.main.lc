<?php /* Smarty version 2.6.18, created on 2017-05-17 00:15:44
         compiled from addon/mpanel/template/form_add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'addon/mpanel/template/form_add.tpl', 22, false),array('modifier', 'cat', 'addon/mpanel/template/form_add.tpl', 41, false),array('modifier', 'file_exists', 'addon/mpanel/template/form_add.tpl', 41, false),)), $this); ?>
<FORM id='main_form' action='javascript:void(null);'
	onsubmit="submit_form(this,Array())">

<table cellspacing=0 cellpadding=2 class=add_form>
	<tr>
		<th><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Template'); ?>
</th>
	</tr>
	<tr>
		<td>

		<table cellspacing=2 cellpadding=1>
			<tr>
				<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Type'); ?>
:</td>
				<td><select name=data[type_]>
 					<option value=letter<?php if ($this->_tpl_vars['aData']['type_'] == 'letter'): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Letter'); ?>
</option>
			 		<option value=bill<?php if ($this->_tpl_vars['aData']['type_'] == 'bill'): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Bill'); ?>
</option>
			 		<option value=content<?php if ($this->_tpl_vars['aData']['type_'] == 'content'): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Content'); ?>
</option>
				</select></td>
			</tr>
			<tr>
				<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Code'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
				<td><input type=text name=data[code] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['code'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
			</tr>
			<tr>
				<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Priority'); ?>
:</td>
				<td><input type=text name=data[priority] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['priority'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
			</tr>
			<tr>
				<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Name'); ?>
:</td>
				<td><input type=text name=data[name] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
			</tr>
			<tr>
				<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Content'); ?>
:</td>
				<td><?php echo $this->_tpl_vars['oAdmin']->getCKEditor('data[content]',$this->_tpl_vars['aData']['content'],700,600); ?>
</td>
			</tr>
			<!--deprecated tr>
			   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Is smarty'); ?>
:</td>
			   <td><input type="hidden" name=data[is_smarty] value="0">
			   <input type=checkbox name=data[is_smarty] value='1' style="width:22px;" <?php if ($this->_tpl_vars['aData']['is_smarty']): ?>checked<?php endif; ?>></td>
			</tr-->
			<?php if (((is_array($_tmp=((is_array($_tmp=$_SERVER['DOCUMENT_ROOT'])) ? $this->_run_mod_handler('cat', true, $_tmp, '/template/mpanel/template/form_add_ext.tpl') : smarty_modifier_cat($_tmp, '/template/mpanel/template/form_add_ext.tpl')))) ? $this->_run_mod_handler('file_exists', true, $_tmp) : file_exists($_tmp))): ?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'mpanel/template/form_add_ext.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endif; ?>
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
 ?>
</FORM>