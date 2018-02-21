<?php /* Smarty version 2.6.18, created on 2018-02-19 16:25:10
         compiled from home/banner_right.tpl */ ?>
<div class="gm-banner-index js-banner-index">
<div class="gm-mainer">
<div class="wrapper">
<?php $_from = $this->_tpl_vars['aBanner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aSingleBanner']):
?>
<?php if ($this->_tpl_vars['aSingleBanner']['is_main']): ?>
<div><a href="<?php echo $this->_tpl_vars['aSingleBanner']['link']; ?>
">
<img src="<?php echo $this->_tpl_vars['aSingleBanner']['image']; ?>
"
	alt="<?php echo $this->_tpl_vars['aSingleBanner']['name']; ?>
" style="width:1140px; height: 200px;"/>
	<img class="small" src="<?php echo $this->_tpl_vars['aSingleBanner']['image_small']; ?>
" alt="">
	</a>
</div><?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</div>
</div>
</div>

