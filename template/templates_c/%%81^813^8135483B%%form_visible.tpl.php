<?php /* Smarty version 2.6.18, created on 2017-05-24 22:40:28
         compiled from addon/mpanel/form_visible.tpl */ ?>
<tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Visible'); ?>
:</td>
   <td><input type="hidden" name=data[visible] value="0">
   <input type=checkbox name=data[visible] value='1' style="width:22px;" <?php if ($this->_tpl_vars['aData']['visible']): ?>checked<?php endif; ?>></td>
</tr>