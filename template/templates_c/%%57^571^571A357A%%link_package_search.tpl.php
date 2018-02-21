<?php /* Smarty version 2.6.18, created on 2017-05-16 19:39:39
         compiled from manager/link_package_search.tpl */ ?>
<b><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Status'); ?>
:</b>
<div class="ak-taber-block">
	<a <?php if (! $_REQUEST['search_order_status']): ?>class="selected"<?php endif; ?> href='/?action=manager_package_list'><?php echo $this->_tpl_vars['oLanguage']->GetMessage('All'); ?>
</a>
	<a <?php if ($_REQUEST['search_order_status'] == 'new'): ?>class="selected"<?php endif; ?> href='/?action=manager_package_list&search_order_status=new'><?php echo $this->_tpl_vars['oLanguage']->GetMessage('New'); ?>
</a>
	<a <?php if ($_REQUEST['search_order_status'] == 'pending'): ?>class="selected"<?php endif; ?> href='/?action=manager_package_list&search_order_status=pending'><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Pending'); ?>
</a>
	<a <?php if ($_REQUEST['search_order_status'] == 'work'): ?>class="selected"<?php endif; ?> href='/?action=manager_package_list&search_order_status=work'><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Work'); ?>
</a>
	<a <?php if ($_REQUEST['search_order_status'] == 'end'): ?>class="selected"<?php endif; ?> href='/?action=manager_package_list&search_order_status=end'><?php echo $this->_tpl_vars['oLanguage']->GetMessage('End'); ?>
</a>
	<a <?php if ($_REQUEST['search_order_status'] == 'refused'): ?>class="selected"<?php endif; ?> href='/?action=manager_package_list&search_order_status=refused'><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Refused'); ?>
</a>
	<div class="clear"></div>
</div>