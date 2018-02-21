<?php /* Smarty version 2.6.18, created on 2017-05-15 18:53:00
         compiled from cart/cart_onepage_payment.tpl */ ?>
                <div class="head" id='payment_types' <?php if ($this->_tpl_vars['aAuthUser']['type_'] == 'customer'): ?> style='display:none'<?php endif; ?>><?php echo $this->_tpl_vars['oLanguage']->getMessage("Способ оплаты"); ?>
 </div>
<div class="block-labels js-block-label" id='payment_types_2' <?php if ($this->_tpl_vars['aAuthUser']['type_'] == 'customer'): ?> style='display:none'<?php endif; ?>>
<?php $_from = $this->_tpl_vars['aPaymentType']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aItem']):
?>
                    <label><div class="label <?php if (! $this->_tpl_vars['bAlreadySelected']): ?>
			selected
		<?php endif; ?> <?php if ($this->_tpl_vars['aItem']['id'] == 3): ?> nova <?php endif; ?>">
          <input type="radio" style="-webkit-appearance: radio;" name=data[id_payment_type] type="radio" value='<?php echo $this->_tpl_vars['aItem']['id']; ?>
' 
          <?php if ($this->_tpl_vars['aItem']['description']): ?> onclick="show_payment_description('payment_description_<?php echo $this->_tpl_vars['aItem']['id']; ?>
');" <?php endif; ?>
		<?php if (! $this->_tpl_vars['bAlreadySelected']): ?>
			<?php $this->assign('bAlreadySelected', 1); ?>
			checked
		<?php endif; ?>>
                        <span class="caption"><?php echo $this->_tpl_vars['aItem']['name']; ?>
</span>
                    </div></label>
        <div width=78% class="payment_description payment_description_<?php echo $this->_tpl_vars['aItem']['id']; ?>
" style='display: none' valign=top><?php echo $this->_tpl_vars['aItem']['description']; ?>
</div>
                    <?php endforeach; endif; unset($_from); ?>
                </div>
<?php echo '<script type="text/javascript">
function show_payment_description(id_show) {
    $(\'div.payment_description\').hide();
    $(\'.\'+id_show).show();
}</script>
'; ?>
