<?php /* Smarty version 2.6.18, created on 2018-01-13 20:20:46
         compiled from mpanel/translate_text/form_add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'mpanel/translate_text/form_add.tpl', 35, false),)), $this); ?>
<FORM id='main_form' action='javascript:void(null);'
	onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
	<tr>
		<th><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Translation'); ?>
</th>
	</tr>
	<tr>
		<td>

		<table cellspacing=2 cellpadding=1>
			<tr>
				<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Code'); ?>
: <?php echo $this->_tpl_vars['sZir']; ?>
</td>
				<td><textarea name=data[code]><?php echo $this->_tpl_vars['aData']['code']; ?>
</textarea></td>
			</tr>
			<tr>
				<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Translation'); ?>
:</td>
				<td><?php echo $this->_tpl_vars['oAdmin']->getCKEditor('data[content]',$this->_tpl_vars['aData']['content']); ?>
</td>
			</tr>
		    <tr>
		   		<td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Use code html'); ?>
:</td>
		   		<td><input type="hidden" name=data[use_code_html] value="0">
		   			<input type=checkbox name=data[use_code_html] value='1' style="width:22px;"></td>
		  	</tr>
			<tr>
				<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Translation html'); ?>
:</td>
				<td><textarea style="width: 700px;height: 300px;" name=data[content_html]><?php echo $this->_tpl_vars['aData']['content']; ?>
</textarea></td>
			</tr>
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