<?php /* Smarty version 2.6.18, created on 2017-07-04 00:02:17
         compiled from addon/form/index.tpl */ ?>
<?php if ($this->_tpl_vars['sTitle'] || $this->_tpl_vars['sAdditionalTitle']): ?>
	<!--div class="title"><?php echo $this->_tpl_vars['sTitle']; ?>
<?php echo $this->_tpl_vars['sAdditionalTitle']; ?>
<?php echo $this->_tpl_vars['sHint']; ?>
</div-->
<div <?php echo $this->_tpl_vars['sTitleDivHeader']; ?>
>
<table width="<?php echo $this->_tpl_vars['sWidth']; ?>
"  class="title_table" cellspacing="0" cellpadding="0" border="0">
<tr><td>
   <div class="red_box">
      <?php echo $this->_tpl_vars['sTitle']; ?>
<?php echo $this->_tpl_vars['sAdditionalTitle']; ?>
<?php echo $this->_tpl_vars['sHint']; ?>

   </div>
</td></tr>
</table>
</div>
<?php endif; ?>
	<?php if ($this->_tpl_vars['sFormError'] || $_GET['form_error']): ?><div class=error_message><?php echo $this->_tpl_vars['sFormError']; ?>

		<?php echo $this->_tpl_vars['oLanguage']->getMessage($_GET['form_error']); ?>
</div><?php endif; ?>

	<?php if ($this->_tpl_vars['sFormMessage']): ?><div class="<?php echo $this->_tpl_vars['sFormMessageClass']; ?>
"><?php echo $this->_tpl_vars['sFormMessage']; ?>
</div><?php endif; ?>

<FORM <?php echo $this->_tpl_vars['sHeader']; ?>
>
<?php echo $this->_tpl_vars['sHidden']; ?>


<?php if ($this->_tpl_vars['sRightTemplate']): ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
<td width="<?php echo $this->_tpl_vars['sWidth']; ?>
" valign="top">
<?php endif; ?>

<div class="<?php echo $this->_tpl_vars['sClass']; ?>
" style="<?php if ($this->_tpl_vars['sWidth']): ?>width:<?php echo $this->_tpl_vars['sWidth']; ?>
;<?php endif; ?>text-align:left;">
<?php echo $this->_tpl_vars['sBeforeContent']; ?>

	<?php echo $this->_tpl_vars['sContent']; ?>

<?php echo $this->_tpl_vars['sAfterContent']; ?>

</div>

<?php if ($this->_tpl_vars['sButtonDivClass']): ?><div class="<?php echo $this->_tpl_vars['sButtonDivClass']; ?>
"><?php endif; ?>

<?php if ($this->_tpl_vars['sReturnButton'] && ! $this->_tpl_vars['bReturnAfterSubmit']): ?>
<span <?php if ($this->_tpl_vars['sButtonSpanClass']): ?>class="button"<?php else: ?> style="padding:<?php echo $this->_tpl_vars['sButtonsPadding']; ?>
px 0 0 0;" <?php endif; ?>>
<input type=button class='<?php echo $this->_tpl_vars['sReturnButtonClass']; ?>
' value="<?php echo $this->_tpl_vars['sReturnButton']; ?>
"
	onclick="location.href='<?php if (! $this->_tpl_vars['bNoneDotUrl']): ?>.<?php endif; ?>/<?php if (! $this->_tpl_vars['bAutoReturn']): ?>?action=<?php endif; ?><?php echo $this->_tpl_vars['sReturnAction']; ?>
'" >
</span>
<?php endif; ?>


<span <?php if ($this->_tpl_vars['sButtonSpanClass'] && $this->_tpl_vars['sSubmitButton']): ?>class="button"<?php else: ?> style="padding:<?php echo $this->_tpl_vars['sButtonsPadding']; ?>
px 0 0 0;" <?php endif; ?>>
<?php if ($this->_tpl_vars['sSubmitButton']): ?>
<input type=submit class='<?php echo $this->_tpl_vars['sSubmitButtonClass']; ?>
' value="<?php echo $this->_tpl_vars['sSubmitButton']; ?>
"
	<?php if ($this->_tpl_vars['bConfirmSubmit']): ?>
		onclick="if (!confirm('<?php echo $this->_tpl_vars['oLanguage']->getMessage($this->_tpl_vars['sConfirmText']); ?>
')) return false;"
	<?php endif; ?>
	 >
<?php endif; ?>

<?php if ($this->_tpl_vars['sReturnButton'] && $this->_tpl_vars['bReturnAfterSubmit']): ?>
<span <?php if ($this->_tpl_vars['sButtonSpanClass']): ?>class="button"<?php else: ?> style="padding:<?php echo $this->_tpl_vars['sButtonsPadding']; ?>
px 0 0 0;" <?php endif; ?>>
<input type=button class='<?php echo $this->_tpl_vars['sReturnButtonClass']; ?>
' value="<?php echo $this->_tpl_vars['sReturnButton']; ?>
"
	onclick="location.href='<?php if (! $this->_tpl_vars['bNoneDotUrl']): ?>.<?php endif; ?>/<?php if (! $this->_tpl_vars['bAutoReturn']): ?>?action=<?php endif; ?><?php echo $this->_tpl_vars['sReturnAction']; ?>
'" >
</span>
<?php endif; ?>




<?php if ($this->_tpl_vars['sSubmitAction']): ?><input type=hidden name=action value='<?php echo $this->_tpl_vars['sSubmitAction']; ?>
'><?php endif; ?>

<?php if ($this->_tpl_vars['bAutoReturn']): ?>
	<input type=hidden name=return value='<?php echo $this->_tpl_vars['sReturnAction']; ?>
'>
<?php endif; ?>

<?php if ($this->_tpl_vars['sAdditionalButtonTemplate']): ?> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['sAdditionalButtonTemplate'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> <?php endif; ?>

<?php echo $this->_tpl_vars['sAdditionalButton']; ?>

</span>

<?php if ($this->_tpl_vars['bIsPost']): ?>
<input type=hidden name=is_post value='1'>
<?php endif; ?>

<?php if ($this->_tpl_vars['sRightTemplate']): ?>
</td>
<td valign="top" style="padding:0 15px">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['sRightTemplate'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</td>
</tr>
</table>
<?php endif; ?>

<?php if ($this->_tpl_vars['sButtonDivClass']): ?></div><?php endif; ?>

<?php if ($this->_tpl_vars['bShowBottomForm']): ?>
</FORM>
<?php endif; ?>