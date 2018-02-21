<?php /* Smarty version 2.6.18, created on 2017-05-15 18:53:00
         compiled from user/new_account_delivery_info.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'user/new_account_delivery_info.tpl', 9, false),)), $this); ?>
<?php if ($_REQUEST['action'] == 'user_new_account'): ?>
<div class="form-element">
					<div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Region'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</div>
    <?php if ($this->_tpl_vars['aUser']['id_region']): ?>
        <?php $this->assign('iIdRegion', $this->_tpl_vars['aUser']['id_region']); ?>
    <?php else: ?>
        <?php $this->assign('iIdRegion', $_REQUEST['data']['id_region']); ?>
    <?php endif; ?>
   <?php echo smarty_function_html_options(array('name' => "data[id_region]",'options' => $this->_tpl_vars['aRegionList'],'selected' => $this->_tpl_vars['iIdRegion'],'style' => 'width: 92% !important;max-width: 400px;'), $this);?>

</div>
<?php endif; ?>
<div class="form-element">
					<div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('FLName'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</div>
	<input type=text name=data[name] value='<?php if ($this->_tpl_vars['aUser']['name']): ?><?php echo $this->_tpl_vars['aUser']['name']; ?>
<?php else: ?><?php echo $_REQUEST['data']['name']; ?>
<?php endif; ?>' style='width:100%'>
</div>
<div class="form-element">
					<div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('City'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</div>
	<input type=text name=data[city] value='<?php if ($this->_tpl_vars['aUser']['name']): ?><?php echo $this->_tpl_vars['aUser']['city']; ?>
<?php else: ?><?php echo $_REQUEST['data']['city']; ?>
<?php endif; ?>' style='width:100%'>
	</div>
<div class="form-element">
					<div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Address'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</div>
	<input type=text name=data[address] value='<?php if ($this->_tpl_vars['aUser']['name']): ?><?php echo $this->_tpl_vars['aUser']['address']; ?>
<?php else: ?><?php echo $_REQUEST['data']['address']; ?>
<?php endif; ?>' style='width:100%'>
	</div>
<?php if ($_REQUEST['action'] != 'user_new_account' && $_REQUEST['action'] != 'cart_onepage_order'): ?>
<div class="form-element">
					<div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Phone'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</div>
	<input type=text name=data[phone] value='<?php if ($this->_tpl_vars['aUser']['phone']): ?><?php echo $this->_tpl_vars['aUser']['phone']; ?>
<?php else: ?><?php echo $_REQUEST['data']['phone']; ?>
<?php endif; ?>' style='width:100%' class='phone'>
	</div>
<?php endif; ?>
<div class="form-element">
					<div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Remarks'); ?>
:</div>
					<textarea name=data[remark] style='width:100%'><?php if ($this->_tpl_vars['aUser']['name']): ?><?php echo $this->_tpl_vars['aUser']['remark']; ?>
<?php else: ?><?php echo $_REQUEST['data']['remark']; ?>
<?php endif; ?></textarea>
	</div>