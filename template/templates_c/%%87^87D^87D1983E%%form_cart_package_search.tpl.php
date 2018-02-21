<?php /* Smarty version 2.6.18, created on 2018-02-19 23:18:04
         compiled from cart/form_cart_package_search.tpl */ ?>
<table style="width:100%;" border=0 class="gm-block-order-filter no-mobile">
 			
                <tr>
                   
<td><input type="text" name="search[id_cart_package]" value="<?php echo $_REQUEST['search']['id_cart_package']; ?>
" placeholder="<?php echo $this->_tpl_vars['oLanguage']->GetMessage('order number'); ?>
"></td>
    <td>
            <span class="status-wrap">
           <select name="search[order_status]" class="js-uniform">
            <option value=""><?php echo $this->_tpl_vars['oLanguage']->GetMessage('status'); ?>
</option>
            <option value="new" <?php if ($_REQUEST['search']['order_status'] == 'new'): ?>selected="selected"<?php endif; ?> label="<?php echo $this->_tpl_vars['oLanguage']->GetMessage('new'); ?>
"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('new'); ?>
</option>
            <option value="pending" <?php if ($_REQUEST['search']['order_status'] == 'pending'): ?>selected="selected"<?php endif; ?> label="<?php echo $this->_tpl_vars['oLanguage']->GetMessage('pending'); ?>
"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('pending'); ?>
</option>
            <option value="work" <?php if ($_REQUEST['search']['order_status'] == 'work'): ?>selected="selected"<?php endif; ?> label="<?php echo $this->_tpl_vars['oLanguage']->GetMessage('work'); ?>
"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('work'); ?>
</option>
            <option value="end" <?php if ($_REQUEST['search']['order_status'] == 'end'): ?>selected="selected"<?php endif; ?> label="<?php echo $this->_tpl_vars['oLanguage']->GetMessage('end'); ?>
"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('end'); ?>
</option>
            <option value="refused" <?php if ($_REQUEST['search']['order_status'] == 'refused'): ?>selected="selected"<?php endif; ?> label="<?php echo $this->_tpl_vars['oLanguage']->GetMessage('refused'); ?>
"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('refused'); ?>
</option>
        </select>
    </span></td>

  
                

            </tr>
                
</table>