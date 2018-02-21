<?php /* Smarty version 2.6.18, created on 2017-05-15 18:45:46
         compiled from cart/order_by_phone.tpl */ ?>
 <?php if (! ( $this->_tpl_vars['aAuthUser']['id'] && ! ( $this->_tpl_vars['oContent']->IsChangeableLogin($this->_tpl_vars['aAuthUser']['login']) ) )): ?>

<table class='order-by-phone order-in-one-click'>
		
	<tr>
				<a href="/?action=cart_order_by_phone"><span class="title" style="float: right;"><i class="icon-round-phone-black"></i><?php echo $this->_tpl_vars['oLanguage']->GetMessage('order by phone'); ?>
</span>
			</a>	</tr>
</table>

<script src="/js/check_phone.js?1"></script>
<?php endif; ?>