<?php /* Smarty version 2.6.18, created on 2018-02-07 21:04:01
         compiled from finance/currency_exchange.tpl */ ?>
<table width="500px" cellspacing=0 cellpadding=0 class="datatable" align=left style="margin: 10px;">
<tr>
<?php $_from = $this->_tpl_vars['aCurrency']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aItem']):
?>
	<th style="padding: 5px;"><?php echo $this->_tpl_vars['aItem']['code']; ?>
 - <?php echo $this->_tpl_vars['aItem']['name']; ?>
</th>
<?php endforeach; endif; unset($_from); ?>
</tr>
<tr>
<?php $_from = $this->_tpl_vars['aCurrency']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aItem']):
?>
	<td style="padding: 5px;"><?php echo $this->_tpl_vars['aItem']['value']; ?>
</td>
<?php endforeach; endif; unset($_from); ?>

</tr>
</table><br><br>