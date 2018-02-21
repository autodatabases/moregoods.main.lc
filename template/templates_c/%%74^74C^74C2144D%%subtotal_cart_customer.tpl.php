<?php /* Smarty version 2.6.18, created on 2017-07-09 10:38:28
         compiled from manager/subtotal_cart_customer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'manager/subtotal_cart_customer.tpl', 2, false),)), $this); ?>
        <div class="gm-basket-control-line">
            <a href="/?action=manager_customer_cart_print&where=<?php echo $this->_tpl_vars['sWhere']; ?>
&id_region=<?php echo $this->_tpl_vars['aRow']['id_region']; ?>
&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
" class="link-edit"><span class="gm-link-dashed"><?php echo $this->_tpl_vars['oLanguage']->getMessage('print_cart'); ?>
</span></a>
            <div class="block-total" >
                <span><?php echo $this->_tpl_vars['oLanguage']->getMessage('Total_sum'); ?>
: &nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['dSubtotalCount']; ?>
&nbsp;<?php echo $this->_tpl_vars['oLanguage']->getMessage("sht."); ?>
</span>
               <div class="block-total" id='cart_subtotal'><?php echo $this->_tpl_vars['oCurrency']->PrintSymbol($this->_tpl_vars['dSubtotalGrn']); ?>
</div>
            </div>
            <div class="clear"></div>
        </div>
		