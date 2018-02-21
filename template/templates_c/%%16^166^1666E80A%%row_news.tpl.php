<?php /* Smarty version 2.6.18, created on 2018-02-19 12:09:10
         compiled from mpanel/news/row_news.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'mpanel/news/row_news.tpl', 2, false),array('modifier', 'strip_tags', 'mpanel/news/row_news.tpl', 5, false),array('modifier', 'date_format', 'mpanel/news/row_news.tpl', 6, false),)), $this); ?>
<td><?php echo $this->_tpl_vars['aRow']['id']; ?>
</td>
<td><?php echo ((is_array($_tmp=$this->_tpl_vars['aRow']['short'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 50, "") : smarty_modifier_truncate($_tmp, 50, "")); ?>
</td>
<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/image.tpl', 'smarty_include_vars' => array('aRow' => $this->_tpl_vars['aRow'],'sWidth' => 30)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
<td><?php echo $this->_tpl_vars['aRow']['section']; ?>
</td>
<td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['aRow']['full'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 80, "") : smarty_modifier_truncate($_tmp, 80, "")); ?>
</td>
<td><?php if ($this->_tpl_vars['aRow']['post_date'] != ''): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['aRow']['post_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y")); ?>
<?php endif; ?></td>
<td><?php echo $this->_tpl_vars['aRow']['customer_group_name']; ?>
</td>
<td><?php echo $this->_tpl_vars['aRow']['region']; ?>
</td>
<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/visible.tpl', 'smarty_include_vars' => array('aRow' => $this->_tpl_vars['aRow'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
<td><?php echo $this->_tpl_vars['aRow']['num']; ?>
</td>
<td nowrap><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/base_lang_select.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
<td nowrap><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/base_row_action.tpl', 'smarty_include_vars' => array('sBaseAction' => $this->_tpl_vars['sBaseAction'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>