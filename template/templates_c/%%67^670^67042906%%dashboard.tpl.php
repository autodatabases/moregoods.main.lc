<?php /* Smarty version 2.6.18, created on 2018-02-20 12:05:00
         compiled from index_include/dashboard.tpl */ ?>
<section class="gm-section-content" <?php if ($this->_tpl_vars['aAuthUser']['type_'] == 'manager'): ?><?php echo $this->_tpl_vars['sStyleForm']; ?>
<?php endif; ?>>

<?php echo $this->_tpl_vars['sText']; ?>

</section>
<?php if ($this->_tpl_vars['aAuthUser']): ?>
<aside class="gm-aside-left">

            <nav class="gm-cabinet-menu">
                <div class="caption js-cabinet-menu-toggle">МЕНЮ КАБИНЕТА</div>
                <ul>
	<?php $_from = $this->_tpl_vars['aAccountMenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aItem']):
?>
		<li <?php if ($_REQUEST['action'] == $this->_tpl_vars['aItem']['code']): ?>class='selected' <?php endif; ?>><a href="<?php if (! $this->_tpl_vars['aItem']['link']): ?>/pages/<?php echo $this->_tpl_vars['aItem']['code']; ?>
<?php else: ?><?php echo $this->_tpl_vars['aItem']['code']; ?>
<?php endif; ?>"><?php echo $this->_tpl_vars['aItem']['name']; ?>

		<?php if ($this->_tpl_vars['aAuthUser']['type_'] == 'manager'): ?>
			<?php if ($this->_tpl_vars['aItem']['code'] == 'message'): ?><?php if ($this->_tpl_vars['aTemplateNumber']['message_number']): ?> <font color="red">(<?php echo $this->_tpl_vars['aTemplateNumber']['message_number']; ?>
)</font><?php endif; ?><?php endif; ?>
			<?php if ($this->_tpl_vars['aItem']['code'] == 'payment_report_manager'): ?><?php if ($this->_tpl_vars['aTemplateNumber']['payment_report_id']): ?> <font color="red">(<?php echo $this->_tpl_vars['aTemplateNumber']['payment_report_id']; ?>
)</font><?php endif; ?><?php endif; ?>
			<?php if ($this->_tpl_vars['aItem']['code'] == 'vin_request_manager'): ?><?php if ($this->_tpl_vars['iNotViewedVins']): ?> <font color="red">(<?php echo $this->_tpl_vars['iNotViewedVins']; ?>
)</font><?php endif; ?><?php endif; ?>
			<?php if ($this->_tpl_vars['aItem']['code'] == 'manager_package_list'): ?><?php if ($this->_tpl_vars['iNotViewedOrders']): ?> <font color="red">(<?php echo $this->_tpl_vars['iNotViewedOrders']; ?>
)</font><?php endif; ?><?php endif; ?>
			<?php if ($this->_tpl_vars['aItem']['code'] == 'call_me_show_manager'): ?><?php if ($this->_tpl_vars['aTemplateNumber']['resolved']): ?> <font color="red">(<?php echo $this->_tpl_vars['aTemplateNumber']['resolved']; ?>
)</font><?php endif; ?><?php endif; ?>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['aAuthUser']['type_'] == 'customer'): ?>
			<?php if ($this->_tpl_vars['aItem']['code'] == 'payment_declaration'): ?><?php if ($this->_tpl_vars['aTemplateNumber']['payment_declaration_id']): ?> <font color="red">(<?php echo $this->_tpl_vars['aTemplateNumber']['payment_declaration_id']; ?>
)</font><?php endif; ?><?php endif; ?>
			<?php if ($this->_tpl_vars['aItem']['code'] == 'message_change_current_folder'): ?><?php if ($this->_tpl_vars['aTemplateNumber']['message_number']): ?> <font color="red">(<?php echo $this->_tpl_vars['aTemplateNumber']['message_number']; ?>
)</font><?php endif; ?><?php endif; ?>
		<?php endif; ?>
		</a></li>
	<?php endforeach; endif; unset($_from); ?>
	    <li class="exit"><a href="/pages/user_logout/"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('exit'); ?>
</a></li>
	</ul>
	</nav>

<?php if ($this->_tpl_vars['aAuthUser']['type_'] == 'customer'): ?>
            <div class="gm-block-manager">
                <div class="caption"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('your manager'); ?>
</div>
                <div class="name"><?php echo $this->_tpl_vars['aAuthUser']['manager_name']; ?>
</div>
                <div class="contacts">
                    <?php if ($this->_tpl_vars['aAuthUser']['manager_phone']): ?><span ><i class="fa fa-phone-square" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $this->_tpl_vars['aAuthUser']['manager_phone']; ?>
</span> <br><?php endif; ?>
                    <?php if ($this->_tpl_vars['aAuthUser']['manager_email']): ?><a  href="mailto:<?php echo $this->_tpl_vars['aAuthUser']['manager_email']; ?>
"><i class="fa fa-at" ></i>&nbsp;&nbsp;<?php echo $this->_tpl_vars['aAuthUser']['manager_email']; ?>
</a><?php endif; ?>
                 </div>
            </div>
 <?php elseif ($this->_tpl_vars['aAuthUser']['type_'] == 'manager'): ?>
            <div class="gm-block-manager">
                <div class="caption" style="font-size:16px"><b><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Мои данные'); ?>
</b></div>
                <?php if ($this->_tpl_vars['sRegion']): ?><div  class="caption" style="font-size:14px" ><?php echo $this->_tpl_vars['sRegion']; ?>
</div><?php endif; ?>
                <?php if ($this->_tpl_vars['sCustomerGroup']): ?><div  class="caption" style="font-size:14px" >Група: <?php echo $this->_tpl_vars['sCustomerGroup']; ?>
</div ><?php endif; ?>
                <br>
				<div class="name"><?php echo $this->_tpl_vars['aAuthUser']['name']; ?>
</div>
                <div class="contacts">
                    <?php if ($this->_tpl_vars['aAuthUser']['phone']): ?><span ><i class="fa fa-phone-square" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $this->_tpl_vars['aAuthUser']['phone']; ?>
</span> <br><?php endif; ?>
                    <?php if ($this->_tpl_vars['aAuthUser']['email']): ?><a class="email" style="font-size:14px" href="mailto:<?php echo $this->_tpl_vars['aAuthUser']['email']; ?>
"><?php echo $this->_tpl_vars['aAuthUser']['email']; ?>
</a><?php endif; ?>
                 </div>
            </div>
 <?php endif; ?>
</aside>
<?php endif; ?>
<div class="clear"></div>