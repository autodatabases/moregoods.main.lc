<?php /* Smarty version 2.6.18, created on 2018-02-19 23:31:10
         compiled from cart/cart_print.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'cart/cart_print.tpl', 26, false),array('modifier', 'date_format', 'cart/cart_print.tpl', 42, false),)), $this); ?>
<table width="800">
<tr>
<td>

<div align=center><h3><?php echo $this->_tpl_vars['oLanguage']->GetConstant('global:project_name','ProjectName'); ?>

	(<?php echo $this->_tpl_vars['oLanguage']->GetConstant('global:project_url','http://project.com'); ?>
)</h3></div>

<p><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('ProviderCart'); ?>
: </b> <?php echo $this->_tpl_vars['oLanguage']->GetConstant('global:project_name','ProjectName'); ?>

<p><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('CustomerCart'); ?>
: </b> <?php echo $this->_tpl_vars['aAuthUser']['name']; ?>
 (login: <?php echo $this->_tpl_vars['aAuthUser']['login']; ?>
)

<br>

<div align=center><h3><?php echo $this->_tpl_vars['oLanguage']->getMessage('Cart items'); ?>
:</h3></div>

<table width="99%" cellspacing=0 cellpadding=5 class="datatable">
<tr>
	<th><nobr><?php echo $this->_tpl_vars['oLanguage']->getMessage('CatName'); ?>
</th>
	<th><nobr><?php echo $this->_tpl_vars['oLanguage']->getMessage('CartCode'); ?>
</th>
	<th><nobr><?php echo $this->_tpl_vars['oLanguage']->getMessage('NameCart'); ?>
</th>
	<th><nobr><?php echo $this->_tpl_vars['oLanguage']->getMessage('TermCart'); ?>
</th>
	<th><nobr><?php echo $this->_tpl_vars['oLanguage']->getMessage('NumberCart'); ?>
</th>
	<th><nobr><?php echo $this->_tpl_vars['oLanguage']->getMessage('PriceCart'); ?>
</th>
	<th><nobr><?php echo $this->_tpl_vars['oLanguage']->getMessage('TotalCart'); ?>
</th>
</tr>
<?php $_from = $this->_tpl_vars['aCart']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aItem']):
?>
<tr class="<?php echo smarty_function_cycle(array('values' => "even,none"), $this);?>
">
	<td><?php echo $this->_tpl_vars['aItem']['cat_name']; ?>
</td>
	<td><?php if ($this->_tpl_vars['aItem']['code_visible']): ?> <?php echo $this->_tpl_vars['aItem']['code']; ?>
 <?php else: ?><i><?php echo $this->_tpl_vars['oLanguage']->getMessage('cart_invisible'); ?>
</i><?php endif; ?> </td>
	<td><?php echo $this->_tpl_vars['aItem']['name_translate']; ?>
 <font color=red><?php echo $this->_tpl_vars['aItem']['customer_id']; ?>
</font>	</td>
	<td><?php echo $this->_tpl_vars['aItem']['term']; ?>
</td>
	<td><?php echo $this->_tpl_vars['aItem']['number']; ?>
</td>
	<td><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aItem']['price']); ?>
</td>
	<td><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aItem']['number']*$this->_tpl_vars['aItem']['price']); ?>
</td>
</tr>
<?php endforeach; endif; unset($_from); ?>
<tr class="even">
	<td colspan=6 align=right><?php echo $this->_tpl_vars['oLanguage']->getMessage('SubtotalCart'); ?>
:</td>
	<td><b><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['dSubtotal']); ?>
</b></td>
</tr>
</table>

<p><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Current Date Cart'); ?>
: </b> <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>




</td>
</tr>
</table>