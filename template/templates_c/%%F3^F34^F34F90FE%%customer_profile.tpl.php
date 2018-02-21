<?php /* Smarty version 2.6.18, created on 2017-05-18 17:02:50
         compiled from manager/customer_profile.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'manager/customer_profile.tpl', 63, false),array('modifier', 'stripslashes', 'manager/customer_profile.tpl', 95, false),)), $this); ?>
<table class="gm-block-order-filter2 " 
style=" background-color: #f8f8f8;
    border-radius: 5px;
    margin: 0 0 20px 0;
    border: 1px solid #5fb7c1;
    padding: 20px 20px 20px 20px;
    position: relative;">
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Your login'); ?>
:
		<?php if ($this->_tpl_vars['bLoginChange']): ?><?php echo $this->_tpl_vars['oLanguage']->getContextHint('customer_account_login_change'); ?>
<?php endif; ?></td>
		<td style="border: 1px solid #cccccc;padding: 10px 10px 10px 10px; border-radius: 5px;"><?php echo $this->_tpl_vars['aUser']['login']; ?>
&nbsp;&nbsp;
		<?php if ($this->_tpl_vars['bLoginChange']): ?>
		<a class="gm-link-dashed" href='/?action=manager_set_user_login&id_user=<?php echo $this->_tpl_vars['aUser']['id']; ?>
'><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Set New Login'); ?>

		<?php endif; ?> 
		</td>
	</tr>
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Your email'); ?>
:<?php if (! $this->_tpl_vars['bReadOnly']): ?><?php echo $this->_tpl_vars['sZir']; ?>
<?php endif; ?></td>
		<td style="padding: 10px 0;"><input type=text name=data[email] value='<?php echo $this->_tpl_vars['aUser']['email']; ?>
' maxlength=50 style='width:100%'
		<?php if ($this->_tpl_vars['bReadOnly']): ?>readonly<?php endif; ?>></td>
	</tr>
	<?php if ($this->_tpl_vars['bPasswChange']): ?>
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Password'); ?>
:</td>
		<td style="padding: 10px 0px 10px 0px;">******&nbsp;&nbsp;
		<a class="gm-link-dashed" style="float: right;border: 1px solid #cccccc;padding: 10px 20px 10px 20px; border-radius: 5px;background-color: white;" 
		href='/?action=manager_set_user_password&id_user=<?php echo $this->_tpl_vars['aUser']['id']; ?>
'><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Change Password'); ?>

		</td>
	</tr>
	<?php endif; ?>
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Basic Currency'); ?>
:
		<td>
		<div class="options">
		<select class="js-uniform" id="menu_select" name=data[id_currency] style='width:100%' class="gm-select">
		<?php unset($this->_sections['d']);
$this->_sections['d']['name'] = 'd';
$this->_sections['d']['loop'] = is_array($_loop=$this->_tpl_vars['aCurrency']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['d']['show'] = true;
$this->_sections['d']['max'] = $this->_sections['d']['loop'];
$this->_sections['d']['step'] = 1;
$this->_sections['d']['start'] = $this->_sections['d']['step'] > 0 ? 0 : $this->_sections['d']['loop']-1;
if ($this->_sections['d']['show']) {
    $this->_sections['d']['total'] = $this->_sections['d']['loop'];
    if ($this->_sections['d']['total'] == 0)
        $this->_sections['d']['show'] = false;
} else
    $this->_sections['d']['total'] = 0;
if ($this->_sections['d']['show']):

            for ($this->_sections['d']['index'] = $this->_sections['d']['start'], $this->_sections['d']['iteration'] = 1;
                 $this->_sections['d']['iteration'] <= $this->_sections['d']['total'];
                 $this->_sections['d']['index'] += $this->_sections['d']['step'], $this->_sections['d']['iteration']++):
$this->_sections['d']['rownum'] = $this->_sections['d']['iteration'];
$this->_sections['d']['index_prev'] = $this->_sections['d']['index'] - $this->_sections['d']['step'];
$this->_sections['d']['index_next'] = $this->_sections['d']['index'] + $this->_sections['d']['step'];
$this->_sections['d']['first']      = ($this->_sections['d']['iteration'] == 1);
$this->_sections['d']['last']       = ($this->_sections['d']['iteration'] == $this->_sections['d']['total']);
?>
		<option value=<?php echo $this->_tpl_vars['aCurrency'][$this->_sections['d']['index']]['id']; ?>

			<?php if ($this->_tpl_vars['aCurrency'][$this->_sections['d']['index']]['id'] == $this->_tpl_vars['aUser']['id_currency']): ?> selected <?php endif; ?>
			<?php if ($this->_tpl_vars['bReadOnly']): ?>disabled<?php endif; ?>
			><?php echo $this->_tpl_vars['aCurrency'][$this->_sections['d']['index']]['name']; ?>
</option>
		<?php endfor; endif; ?>
		</select>
		</div>
		</td>
	</tr>
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Group'); ?>
:<?php if ($this->_tpl_vars['bGroupChange']): ?><?php echo $this->_tpl_vars['sZir']; ?>
<?php endif; ?></td>
		<td valign=center width=280>
		<?php if ($this->_tpl_vars['bGroupChange']): ?>
        <div class="form-element">
        <?php $this->assign('iIdGroup', $this->_tpl_vars['aUser']['id_customer_group']); ?>
		<?php echo smarty_function_html_options(array('name' => "data[id_group]",'options' => $this->_tpl_vars['aGroupsG'],'selected' => $this->_tpl_vars['iIdGroup'],'class' => "js-uniform",'style' => 'width:100%'), $this);?>

         </div>
		<?php else: ?>	
		<input type=text name=data[id_group] value='<?php echo $this->_tpl_vars['aGroupSelected']; ?>
' style='width:100%' readonly></td>
				<?php endif; ?>
		</td>
	</tr>

	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Canal'); ?>
:<?php if ($this->_tpl_vars['bGroupChange']): ?><?php echo $this->_tpl_vars['sZir']; ?>
<?php endif; ?></td>
		<td valign=center width=280>
		<?php if ($this->_tpl_vars['bGroupChange']): ?>
        <div class="form-element">
        <?php $this->assign('iIdType', $this->_tpl_vars['aUser']['id_user_customer_type']); ?>
		<?php echo smarty_function_html_options(array('name' => "data[id_user_customer_type]",'options' => $this->_tpl_vars['aTypeG'],'selected' => $this->_tpl_vars['iIdType'],'class' => "js-uniform",'style' => 'width:100%'), $this);?>

         </div>
		<?php else: ?>	
		<input type=text name=data[id_user_customer_type] value='<?php echo $this->_tpl_vars['aTypeSelected']; ?>
' style='width:100%' readonly></td>
		<?php endif; ?>
		</td>
	</tr>

	<tr>
		<td colspan=2><i><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Delivery info'); ?>
</i><hr /></td>
	</tr>
    <script type="text/javascript" src="/js/user.js?2"></script>
	<tr>
		<td><nobr><?php echo $this->_tpl_vars['oLanguage']->GetMessage('FLName'); ?>
:<?php if (! $this->_tpl_vars['bReadOnly']): ?><?php echo $this->_tpl_vars['sZir']; ?>
<?php endif; ?></td>
		<td valign=center width=280>
		<input type=text name=data[name] value='<?php echo ((is_array($_tmp=$this->_tpl_vars['aUser']['name'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
' style='width:100%'
		<?php if ($this->_tpl_vars['bReadOnly']): ?>readonly<?php endif; ?>></td>
	</tr>
	<tr>
		<td><nobr><?php echo $this->_tpl_vars['oLanguage']->GetMessage('GeoRegion'); ?>
:<?php if ($this->_tpl_vars['bRegionChange']): ?><?php echo $this->_tpl_vars['sZir']; ?>
<?php endif; ?></td>
		<td valign=center width=280>
		
		<?php if ($this->_tpl_vars['bRegionChange']): ?>
        <div class="form-element">
        <?php $this->assign('iIdGeoRegion', $this->_tpl_vars['aUser']['id_geo']); ?>
		<?php echo smarty_function_html_options(array('name' => "data[id_geo]",'options' => $this->_tpl_vars['aGeoRegionList'],'selected' => $this->_tpl_vars['iIdGeoRegion'],'class' => "js-uniform",'style' => 'width:100%'), $this);?>

         </div>
		<?php else: ?>	
		<input type=text name=data[id_geo] value='<?php echo $this->_tpl_vars['aRegionGeoSelected']; ?>
' style='width:100%' readonly></td>
				<?php endif; ?>
		
		
		</td>
	</tr>

	<tr>
		<td><nobr><?php echo $this->_tpl_vars['oLanguage']->GetMessage('region'); ?>
:<?php if ($this->_tpl_vars['bRegionChange']): ?><?php echo $this->_tpl_vars['sZir']; ?>
<?php endif; ?></td>
		<td valign=center width=280>
		
		<?php if ($this->_tpl_vars['bRegionChange']): ?>
        <div class="form-element">
        <?php $this->assign('iIdRegion', $this->_tpl_vars['aUser']['id_region']); ?>
		<?php echo smarty_function_html_options(array('name' => "data[id_region]",'options' => $this->_tpl_vars['aRegionList'],'selected' => $this->_tpl_vars['iIdRegion'],'class' => "js-uniform",'style' => 'width:100%'), $this);?>

         </div>
		<?php else: ?>	
		<input type=text name=data[id_region] value='<?php echo $this->_tpl_vars['aRegionSelected']; ?>
' style='width:100%' readonly></td>
				<?php endif; ?>
		
		
		</td>
	</tr>
	


	<tr>
		<td><nobr><?php echo $this->_tpl_vars['oLanguage']->GetMessage('City'); ?>
:<?php if (! $this->_tpl_vars['bReadOnly']): ?><?php echo $this->_tpl_vars['sZir']; ?>
<?php endif; ?></td>
		<td valign=center width=280>
		<input type=text name=data[city] value='<?php echo ((is_array($_tmp=$this->_tpl_vars['aUser']['city'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
' style='width:100%'
		<?php if ($this->_tpl_vars['bReadOnly']): ?>readonly<?php endif; ?>></td>
	</tr>
  	<tr>
		<td><nobr><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Address'); ?>
:<?php if (! $this->_tpl_vars['bReadOnly']): ?><?php echo $this->_tpl_vars['sZir']; ?>
<?php endif; ?></td>
		<td valign=center width=280>
		<input type=text name=data[address] value='<?php echo ((is_array($_tmp=$this->_tpl_vars['aUser']['address'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
' style='width:100%'
		<?php if ($this->_tpl_vars['bReadOnly']): ?>readonly<?php endif; ?>></td>
	</tr>
	<tr>
		<td><nobr><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Phone'); ?>
:<?php if (! $this->_tpl_vars['bReadOnly']): ?><?php echo $this->_tpl_vars['sZir']; ?>
<?php endif; ?></td>
		<td valign=center width=280>
		<input type=text name=data[phone] value='<?php echo ((is_array($_tmp=$this->_tpl_vars['aUser']['phone'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
' style='width:100%' id='user_phone' placeholder="(___)___ __ __"
		<?php if ($this->_tpl_vars['bReadOnly']): ?>readonly<?php endif; ?>></td>
	</tr>
	
	<tr>
		<td valign=top><?php echo $this->_tpl_vars['oLanguage']->GetMessage('CustomerRemarks'); ?>
:<?php if (! $this->_tpl_vars['bReadOnly']): ?><?php echo $this->_tpl_vars['sZir']; ?>
<?php endif; ?></td>
		<td><textarea name=data[remark] style='width:100%' <?php if ($this->_tpl_vars['bReadOnly']): ?>disabled<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['aUser']['remark'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</textarea></td>
	</tr>
  	<tr>
		<td><nobr><?php echo $this->_tpl_vars['oLanguage']->GetMessage('is_bonus'); ?>
:</td>
		<td valign=center width=280>
		<input type=hidden name=data[is_bonus] value='0'>
		<input type=checkbox name=data[is_bonus] value='1' <?php if ($this->_tpl_vars['aUser']['is_bonus'] == 1): ?>checked<?php endif; ?>
		></td>
	</tr>
</table>