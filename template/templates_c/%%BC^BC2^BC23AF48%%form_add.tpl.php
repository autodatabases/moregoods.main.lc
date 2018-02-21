<?php /* Smarty version 2.6.18, created on 2018-01-13 20:18:29
         compiled from mpanel/general_constant/form_add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'mpanel/general_constant/form_add.tpl', 15, false),)), $this); ?>
<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 <?php echo $this->_tpl_vars['oLanguage']->getDMessage('Constant'); ?>

 </th>
</tr>
<tr><td>

<input type=hidden name=data[type] value='<?php echo $this->_tpl_vars['sType']; ?>
'>
<table cellspacing=2 cellpadding=1>
  <tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Key'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
   <td><input style="font-weight:bold;" readonly="readonly" type=text name=data[key_] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['key_'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
  </tr>
  <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Value'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
   <td><?php if ($this->_tpl_vars['sType'] == 'checkbox'): ?>
	    <div>
		<input type=hidden name=data[value] value='<?php echo $this->_tpl_vars['aData']['value']; ?>
'>
		<input style="width: 13px;" type=checkbox name=data[new_value] value='1' <?php if ($this->_tpl_vars['aData']['value'] == '1'): ?>checked<?php endif; ?>>
	    </div>
	  	<?php elseif ($this->_tpl_vars['sType'] == 'enum'): ?>
	  		<?php $_from = $this->_tpl_vars['aOptions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aItem']):
?>
	  			<input style="width: 13px;" type="radio" name="data[value]" value="<?php echo $this->_tpl_vars['aItem']; ?>
" <?php if ($this->_tpl_vars['aItem'] == $this->_tpl_vars['sOptionCheck']): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['aItem']; ?>
<br>
			<?php endforeach; endif; unset($_from); ?> 
		<?php elseif ($this->_tpl_vars['sType'] == 'text'): ?>
			<?php echo $this->_tpl_vars['oAdmin']->getCKEditor('data[value]',$this->_tpl_vars['aData']['value']); ?>

		<?php elseif ($this->_tpl_vars['sType'] == 'only_text'): ?>
			<textarea rows="16" cols="50" style="width:500px;" name="data[value]"><?php echo $this->_tpl_vars['aData']['value']; ?>
</textarea>
		<?php elseif ($this->_tpl_vars['sType'] == 'favicon'): ?>
			<tr>
			<td>&nbsp;</td>
						<td>
			     <img id='<?php echo $this->_tpl_vars['sType']; ?>
' style="max-width:100px" border=0 align=absmiddle hspace=5 src='<?php if ($this->_tpl_vars['aData']['value']): ?><?php echo $this->_tpl_vars['aData']['value']; ?>
<?php else: ?>favicon.ico<?php endif; ?>'>
			     <input type=hidden name=data[value] id='<?php echo $this->_tpl_vars['sType']; ?>
_input' value='<?php echo $this->_tpl_vars['aData']['value']; ?>
'>
			     <table><tr>
			        <td><img hspace=1 align=absmiddle src='/libp/mpanel/images/small/inbox.png'>
			        	<a href="#" onclick="<?php echo 'javascript:OpenFileBrowser(\'/libp/mpanel/imgmanager/browser/default/browser.php?Type=Image&Connector=php_connector/connector.php&return_id='; ?><?php echo $this->_tpl_vars['sType']; ?><?php echo '\', 600, 400); return false;'; ?>
"
							style='font-weight:normal'><?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Change'); ?>
</a></td>
			        <td><img hspace=1 align=absmiddle src='/libp/mpanel/images/small/outbox.png'>
			        	<a href=# onclick="javascript:ClearImageURL('<?php echo $this->_tpl_vars['sType']; ?>
');return false;" style='font-weight:normal'
							><?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Clear'); ?>
</a></td>
			     </table>
			</td>
			</tr>
			
		<?php else: ?>
		    <input type=text name=data[value] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
		<?php endif; ?>
    </td>
  </tr>
  <?php if ($this->_tpl_vars['aData']['id'] > 0): ?>
  <tr>
	<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Description'); ?>
: <?php echo $this->_tpl_vars['sZir']; ?>
</td>
	<td><textarea name=data[description]><?php echo $this->_tpl_vars['aData']['description']; ?>
</textarea></td>
  </tr>
  <?php endif; ?>
  </table>

</td></tr>
</table>

<input type=hidden name=data[id] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/base_add_button.tpl', 'smarty_include_vars' => array('sBaseAction' => $this->_tpl_vars['sBaseAction'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['aData']['id'] == -2): ?>
	<a href="http://manual.mstarproject.com/index.php/%D0%A7%D1%82%D0%BE_%D1%82%D0%B0%D0%BA%D0%BE%D0%B5_robots.txt" target="_blank"><?php echo $this->_tpl_vars['oLanguage']->getMessage('What is robots.txt?'); ?>
</a>
<?php endif; ?>

</FORM>