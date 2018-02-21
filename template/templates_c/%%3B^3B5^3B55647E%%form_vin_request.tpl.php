<?php /* Smarty version 2.6.18, created on 2018-02-07 21:04:39
         compiled from vin_request/customer/form_vin_request.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'vin_request/customer/form_vin_request.tpl', 18, false),array('function', 'html_select_date', 'vin_request/customer/form_vin_request.tpl', 96, false),)), $this); ?>
<input type="hidden" value="<?php echo $this->_tpl_vars['oLanguage']->getMessage('Form errors'); ?>
" id="jsGTform">
<input type="hidden" value="<?php echo $this->_tpl_vars['oLanguage']->getMessage('VIN must contain 17 symbols'); ?>
" id="jsGTvin">
<input type="hidden" value="<?php echo $this->_tpl_vars['oLanguage']->getMessage('Model and serie empty'); ?>
" id="jsGTmodel">
<input type="hidden" value="<?php echo $this->_tpl_vars['oLanguage']->getMessage('Fill the spareparts list needed'); ?>
" id="jsGTazpDescript1">
<input type="hidden" value="<?php echo $this->_tpl_vars['oLanguage']->getMessage('Mobile phone format is incorrect'); ?>
" id="jsGTmobile">
<?php if ($this->_tpl_vars['oLanguage']->GetConstant('vin_request:is_email_necessary',1)): ?>
	<input type="hidden" value="<?php echo $this->_tpl_vars['oLanguage']->getMessage('Email is empty'); ?>
" id="jsGTemail">
<?php endif; ?>


<table style="width:100%">
<?php if (! $this->_tpl_vars['aAuthUser']['id']): ?>
<tr>
   	<td style="width:40%"><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Mobile'); ?>
:</b><?php echo $this->_tpl_vars['sZir']; ?>
</td>
	<td>
	<?php if ($this->_tpl_vars['oLanguage']->GetConstant('vin_request:operator_type_select',1)): ?>
	<select name="operator" style="width: 70px;">
		<?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['aVinOperator'],'output' => $this->_tpl_vars['aVinOperator'],'selected' => $this->_tpl_vars['aData']['operator']), $this);?>

	</select>
	<?php else: ?>
	<input type=text name=operator value='<?php echo $this->_tpl_vars['aData']['operator']; ?>
' style="width: 55px;">
	<?php endif; ?>

	<input type=text id=mobile name=mobile value='<?php echo $this->_tpl_vars['aData']['mobile']; ?>
'
		maxlength="<?php echo $this->_tpl_vars['oLanguage']->GetConstant('vin_request:phone_digit','9'); ?>
" style="width: 185px !important;"><br>
	<?php echo $this->_tpl_vars['oLanguage']->GetMessage('Example'); ?>
:<?php echo $this->_tpl_vars['oLanguage']->GetText('vin_request phone example'); ?>

	</td>
</tr>
<tr>
	<td><b><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Email'); ?>
:</b>
		<?php if ($this->_tpl_vars['oLanguage']->GetConstant('vin_request:is_email_necessary',1)): ?><?php echo $this->_tpl_vars['sZir']; ?>
<?php endif; ?>
		</td>
	<td><input type=text name=email value='<?php echo $this->_tpl_vars['aData']['email']; ?>
' ></td>
</tr>
<?php endif; ?>
	<?php if ($this->_tpl_vars['aListOwnAuto']): ?>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Select own auto'); ?>
:</b></td>
		<td>
				<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['aListOwnAuto'],'selected' => $this->_tpl_vars['aData']['id_own_auto'],'name' => 'id_own_auto','style' => "width: 260px;",'onchange' => "javascript:
			       	xajax_process_browse_url('?action=vin_request_change_select_own_auto&amp;id_own_auto='+this.options[this.selectedIndex].value);
			       return false;"), $this);?>

		</td>
	</tr>
	<?php endif; ?>
  	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('VIN'); ?>
:</b><?php echo $this->_tpl_vars['sZir']; ?>
</td>
		<td><input type=text id=vin name=vin value='<?php echo $this->_tpl_vars['aData']['vin']; ?>
' maxlength=17></td>
	</tr>

	<?php if ($this->_tpl_vars['oLanguage']->GetConstant('vin_request:has_capcha',0)): ?>
	 	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Capcha field'); ?>
:</b><?php echo $this->_tpl_vars['sZir']; ?>
</td>
		<td valign=top><?php echo $this->_tpl_vars['sCapcha']; ?>
</td>
	</tr>
	<?php endif; ?>

	<tr>
   		<td style="width:40%"><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Marka'); ?>
:</b><?php echo $this->_tpl_vars['sZir']; ?>
</td>
   		<td style="width:60%">
		    <?php echo smarty_function_html_options(array('name' => 'marka','options' => $this->_tpl_vars['aVinMarka'],'selected' => $this->_tpl_vars['aData']['marka'],'id' => 'marka','style' => "width: 260px;",'onchange' => "javascript:
	       		xajax_process_browse_url('?action=vin_request_change_select&amp;data[id_make]='+this.options[this.selectedIndex].value);
	    	    return false;"), $this);?>

		</td>
  	</tr>
  	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage("Model/Serie"); ?>
:</b><?php echo $this->_tpl_vars['sZir']; ?>
</td>
		<td>
			<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['aModel'],'selected' => $this->_tpl_vars['aData']['model'],'name' => 'model','id' => 'id_model','style' => "width: 260px;"), $this);?>

		</td>
	</tr>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Wheel'); ?>
:</b></td>
		<td>
		<select name="wheel" id='wheel' style="width: 120px;">
		<?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['aVinWheel'],'output' => $this->_tpl_vars['aVinWheel'],'selected' => $this->_tpl_vars['aData']['wheel']), $this);?>

		</select>
		</td>
	</tr>
  	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Engine'); ?>
:</b></td>
		<td><input type=text id=engine name=engine value='<?php echo $this->_tpl_vars['aData']['engine']; ?>
' ></td>
	</tr>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Country producer'); ?>
:</b></td>
		<td><input type=text id=country_producer name=country_producer value='<?php echo $this->_tpl_vars['aData']['country_producer']; ?>
' >
   		</td>
  	</tr>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage("Month/Year"); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</b></td>
		<td>
			<?php echo smarty_function_html_options(array('name' => 'Month','options' => $this->_tpl_vars['aVinMonth'],'selected' => $this->_tpl_vars['aData']['Month']), $this);?>
 /

			<?php echo smarty_function_html_select_date(array('prefix' => "",'year_extra' => "style='width:67px'",'display_days' => false,'time' => $this->_tpl_vars['aData']['date'],'start_year' => '1959','field_order' => 'Y','reverse_years' => true), $this);?>

		</td>
	</tr>
  	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Volume'); ?>
:</b></td>
		<td><input type=text id="volume_auto" name=volume value='<?php echo $this->_tpl_vars['aData']['volume']; ?>
' ></td>
	</tr>
  	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Body'); ?>
:</b></td>
		<td>
		    <select id="body_auto" name="body" style="width: 120px;">
			<?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['aVinBody'],'output' => $this->_tpl_vars['aVinBody'],'selected' => $this->_tpl_vars['aData']['body']), $this);?>

		    </select>
   		</td>
  	</tr>
  	<!-- ���  -->
  	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('KPP'); ?>
:</b></td>
		<td>
			<select id="kpp" name="kpp" style="width: 120px;">
			<?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['aVinKpp'],'output' => $this->_tpl_vars['aVinKpp'],'selected' => $this->_tpl_vars['aData']['kpp']), $this);?>

			</select>
   		</td>
  	</tr>
  	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Additional'); ?>
</b></td>
		<td>
			<input type=checkbox id='add_abs' name='additional[]' value='ABS'
				<?php if ($_REQUEST['additional'] && in_array ( 'ABS' , $_REQUEST['additional'] )): ?> checked
				<?php elseif ($this->_tpl_vars['aData']['is_abs']): ?> checked <?php endif; ?>
				>&nbsp;<?php echo $this->_tpl_vars['oLanguage']->getMessage('ABS'); ?>

			<input type=checkbox id='add_hyd' name='additional[]' value='Hydromultiplier'
				<?php if ($_REQUEST['additional'] && in_array ( 'Hydromultiplier' , $_REQUEST['additional'] )): ?> checked 
				<?php elseif ($this->_tpl_vars['aData']['is_hyd_weel']): ?> checked <?php endif; ?>
				>&nbsp;<?php echo $this->_tpl_vars['oLanguage']->getMessage('Hydromultiplier'); ?>

			<input type=checkbox id='add_cond' name='additional[]' value='Conditioner'
				<?php if ($_REQUEST['additional'] && in_array ( 'Conditioner' , $_REQUEST['additional'] )): ?> checked 
				<?php elseif ($this->_tpl_vars['aData']['is_conditioner']): ?> checked <?php endif; ?>
				>&nbsp;<?php echo $this->_tpl_vars['oLanguage']->getMessage('Conditioner'); ?>

		</td>
	</tr>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Customer Comment'); ?>
:</b>
		<?php echo $this->_tpl_vars['oLanguage']->getContextHint('vin_request_customer_comment'); ?>

		</td>
		<td><textarea id=customer_comment name=customer_comment style='width:270px'><?php echo $this->_tpl_vars['aData']['customer_comment']; ?>
</textarea></td>
	</tr>
	<tr>
   		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage("Passport image (jpg, gif)"); ?>
:</b></td>
   		<td><input type=file name=passport_image[1] style='width:270px'></td>
  	</tr>
	<tr>
		<td colspan=2 style="text-align:center;"><hr><?php echo $this->_tpl_vars['oLanguage']->getText('describe spare parts'); ?>

		</td>
	</tr>

	<tr>
		<td colspan=2 style="text-align:center">

<table id="queryByVIN" style="text-align:center;">
    <tbody>
	<?php if (! $this->_tpl_vars['aData']['RowCount']): ?>
      <tr style="text-align:right;">
        <td>1</td>
        <td><input type="text" name="azpDescript1" maxlength="100" style="width:330px !important;" value=""></td>

        <td><input type="text" name="azpCnt1" maxlength="2" style="width:25px !important;" value="1"></td>
      </tr>
	<?php else: ?>
		<?php $_from = $this->_tpl_vars['azp']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['zp']):
?>
      <tr style="text-align:right;">
        <td><?php echo $this->_tpl_vars['key']; ?>
</td>
        <td><input type="text" name="azpDescript<?php echo $this->_tpl_vars['key']; ?>
" maxlength="100" style="width:330px;" value="<?php echo $this->_tpl_vars['zp']['name']; ?>
"></td>

        <td><input type="text" name="azpCnt<?php echo $this->_tpl_vars['key']; ?>
" maxlength="2" style="width:25px;" value="<?php echo $this->_tpl_vars['zp']['cnt']; ?>
"></td>
      </tr>
		<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
    </tbody>
</table>

	<br>
      <input type="button" class='btn' value="<?php echo $this->_tpl_vars['oLanguage']->getMessage('Add line'); ?>
"
				onclick="javascript:mvr.AddRow(this.form);" />&nbsp;&nbsp;
      <input type="button" class='btn' value="<?php echo $this->_tpl_vars['oLanguage']->getMessage('Delete line'); ?>
"
				onclick="javascript:mvr.DeleteRow(this.form);" /><br />&nbsp;

		</td>
	</tr>

</table>

<input type="hidden" name="RowCount" value="<?php if ($this->_tpl_vars['aData']['RowCount'] > 1): ?><?php echo $this->_tpl_vars['aData']['RowCount']; ?>
<?php else: ?>1<?php endif; ?>">
<input type="hidden" id="isUserAuth" name="isUserAuth" value="<?php if ($_SESSION['user']['id']): ?>1<?php else: ?>0<?php endif; ?>">