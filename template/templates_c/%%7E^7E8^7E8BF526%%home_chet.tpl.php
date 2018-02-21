<?php /* Smarty version 2.6.18, created on 2017-05-15 18:45:44
         compiled from index_include/home_chet.tpl */ ?>
<?php if ($this->_tpl_vars['aProductList']): ?>
<div class="gm-mainer">
    <h2 class="line-through" style="margin:0 0 0 0;"><span><?php echo $this->_tpl_vars['aGroupP']['name']; ?>
</span></h2>

    <div class="gm-product-carousel js-product-carousel">
        <div class="wrapper">
        <?php $_from = $this->_tpl_vars['aProductList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aRow']):
?>
            <div>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'index_include/row_thumb.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

				
            </div>
        <?php endforeach; endif; unset($_from); ?>
        </div>
    </div>
</div>
<?php endif; ?>