<?php /* Smarty version 2.6.18, created on 2017-05-18 11:39:02
         compiled from cart/cart_onepage_user_delivery_point.tpl */ ?>
<div  class="block-labels js-block-label2">
<?php $_from = $this->_tpl_vars['aAdress']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aItem']):
?>
	<label class="label ">
		<input style="-webkit-appearance: radio;" type="radio" name="id_addres" value='<?php echo $this->_tpl_vars['aItem']['id']; ?>
'
		>
		<span class="caption"><?php echo $this->_tpl_vars['aItem']['addresses']; ?>
</span>
	</label>

<?php endforeach; endif; unset($_from); ?></div>