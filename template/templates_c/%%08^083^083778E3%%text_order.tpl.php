<?php /* Smarty version 2.6.18, created on 2017-05-18 11:39:42
         compiled from cart/text_order.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'cart/text_order.tpl', 13, false),)), $this); ?>
		<h2><?php echo $this->_tpl_vars['oLanguage']->getMessage('My order'); ?>
</h2>
		<table width="100%" cellspacing=0 cellpadding=5 class="datatable">
		<tr>
			<th><nobr><?php echo $this->_tpl_vars['oLanguage']->getMessage('CatName'); ?>
</th>
			<th><nobr><?php echo $this->_tpl_vars['oLanguage']->getMessage('CartCode'); ?>
</th>
			<th><nobr><?php echo $this->_tpl_vars['oLanguage']->getMessage('Name'); ?>
</th>
			<th><nobr><?php echo $this->_tpl_vars['oLanguage']->getMessage('Number'); ?>
</th>
			<th><nobr><?php echo $this->_tpl_vars['oLanguage']->getMessage('Price'); ?>
</th>
			<th><nobr><?php echo $this->_tpl_vars['oLanguage']->getMessage('Total'); ?>
</th>

		</tr>
		<?php $_from = $this->_tpl_vars['aUserCart']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aItem']):
?>
		<tr class="<?php echo smarty_function_cycle(array('values' => "even,none"), $this);?>
">
			<td><?php echo $this->_tpl_vars['aItem']['cat_name']; ?>
</td>
			<td><?php if ($this->_tpl_vars['aItem']['code_visible']): ?>
				<?php echo $this->_tpl_vars['aItem']['code']; ?>

			<?php else: ?>
				<i><?php echo $this->_tpl_vars['oLanguage']->getMessage('cart_invisible'); ?>
</i>
			<?php endif; ?></td>
			<td><div style="overflow:overlay;">
			    <?php echo $this->_tpl_vars['aItem']['name_translate']; ?>

			    </div>
			</td>
			<td><?php echo $this->_tpl_vars['aItem']['number']; ?>
</td>
			<td><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aItem']['price']); ?>
</td>
			<td><?php echo $this->_tpl_vars['oCurrency']->PrintSymbol($this->_tpl_vars['aItem']['number_price']); ?>
</td>
		</tr>
		<?php endforeach; endif; unset($_from); ?>
		<tr>
			<td colspan=6><hr></td>
		</tr>

		<tr>
			<td colspan=5 align=right><?php echo $this->_tpl_vars['oLanguage']->getMessage('Subtotal'); ?>
:</td>
			<td><?php echo $this->_tpl_vars['oCurrency']->PrintSymbol($this->_tpl_vars['dSubtotal']); ?>
</td>
		</tr>
		<tr>
			<td colspan=5 align=right><?php echo $this->_tpl_vars['oLanguage']->getMessage('Shipment Included'); ?>
:</td>
			<td><span id='price_delivery'><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($_SESSION['current_cart']['price_delivery']); ?>
</span></td>
		</tr>
		 <tr>
			<td colspan=5 align=right><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Total'); ?>
</b>:</td>
			<td><b><span id='price_total'><?php echo $this->_tpl_vars['oCurrency']->PrintSymbol($this->_tpl_vars['dTotal']); ?>
</span></b></td>
		 </tr>
		</table>