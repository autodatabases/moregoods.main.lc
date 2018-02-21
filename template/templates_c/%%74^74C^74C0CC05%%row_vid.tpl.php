<?php /* Smarty version 2.6.18, created on 2018-01-13 13:13:56
         compiled from catalog/row_vid.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'catalog/row_vid.tpl', 3, false),)), $this); ?>
<?php if ($this->_tpl_vars['aRow']['name'] && ! $this->_tpl_vars['aRow']['child']): ?>
<li>
    <a class="without-sub" id="<?php echo $this->_tpl_vars['aPage']['name']; ?>
=><?php echo $this->_tpl_vars['aRow']['name']; ?>
" href="/?action=catalog_vid&group=<?php echo $this->_tpl_vars['aRow']['id_brand_group']; ?>
&brand=<?php echo $this->_tpl_vars['aRow']['id_brand']; ?>
<?php if (! $this->_tpl_vars['aRow']['id'] == 0): ?>&vid=<?php echo $this->_tpl_vars['aRow']['id']; ?>
<?php endif; ?>"><span><?php echo ((is_array($_tmp=$this->_tpl_vars['aRow']['name'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</span></a>
</li>
<?php elseif ($this->_tpl_vars['aRow']['name'] && $this->_tpl_vars['aRow']['child']): ?>
<li class="with-sub" id="<?php echo $this->_tpl_vars['aPage']['name']; ?>
=><?php echo $this->_tpl_vars['aRow']['name']; ?>
"><a><span><?php echo ((is_array($_tmp=$this->_tpl_vars['aRow']['name'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</span></a>
<?php endif; ?>
<?php if ($this->_tpl_vars['aRow']['child']): ?>
<ul>
<?php $_from = $this->_tpl_vars['aRow']['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aChild']):
?>
<li><a class="with-child" id="<?php echo $this->_tpl_vars['aPage']['name']; ?>
=><?php echo $this->_tpl_vars['aRow']['name']; ?>
=><?php echo $this->_tpl_vars['aChild']['name']; ?>
" href="/?action=catalog_vid&group=<?php echo $this->_tpl_vars['aChild']['id_brand_group']; ?>
&brand=<?php echo $this->_tpl_vars['aChild']['id_brand']; ?>
&vid=<?php echo $this->_tpl_vars['aChild']['id']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['aChild']['name'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</a>
</li>
<?php endforeach; endif; unset($_from); ?>
</ul></li><?php endif; ?>