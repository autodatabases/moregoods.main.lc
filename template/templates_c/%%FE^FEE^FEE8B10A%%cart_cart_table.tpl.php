<?php /* Smarty version 2.6.18, created on 2017-05-15 18:46:27
         compiled from index_include/cart_cart_table.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'index_include/cart_cart_table.tpl', 13, false),)), $this); ?>
<script type="text/javascript" src="/libp/js/table.js"></script>

<?php if ($this->_tpl_vars['sTableMessage']): ?><div class="<?php echo $this->_tpl_vars['sTableMessageClass']; ?>
"><?php echo $this->_tpl_vars['sTableMessage']; ?>
</div><?php endif; ?>


<?php if ($this->_tpl_vars['bFormAvailable']): ?><form id="<?php echo $this->_tpl_vars['sIdForm']; ?>
" <?php echo $this->_tpl_vars['sFormHeader']; ?>
><?php endif; ?>
<?php if ($this->_tpl_vars['sPanelTemplateTop']): ?> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['sPanelTemplateTop'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> <?php endif; ?>

<div class="gm-product-line-list simple" <?php if ($this->_tpl_vars['sIdTable'] != ""): ?>id="<?php echo $this->_tpl_vars['sIdTable']; ?>
"<?php endif; ?> >

<?php if ($this->_tpl_vars['sStepper'] && $this->_tpl_vars['bTopStepper']): ?>
<tr class="<?php echo $this->_tpl_vars['sStepperClass']; ?>
">
	<td colspan="<?php echo count($this->_tpl_vars['aColumn']); ?>
" style="text-align:<?php echo $this->_tpl_vars['sStepperAlign']; ?>
;">
	<?php echo $this->_tpl_vars['sStepper']; ?>

	</td>
</tr>
<?php endif; ?>

<?php $this->assign('iTr', '0'); ?>
<?php unset($this->_sections['d']);
$this->_sections['d']['name'] = 'd';
$this->_sections['d']['loop'] = is_array($_loop=$this->_tpl_vars['aItem']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<?php $this->assign('aRow', $this->_tpl_vars['aItem'][$this->_sections['d']['index']]); ?>
<?php $this->assign('iTr', $this->_tpl_vars['iTr']+1); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['sDataTemplate'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endfor; endif; ?>

<?php if ($this->_tpl_vars['sSubtotalTemplate']): ?> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['sSubtotalTemplate'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> <?php endif; ?>

<?php if ($this->_tpl_vars['sStepper'] && ! $this->_tpl_vars['bStepperOutTable']): ?>
<tr class="<?php echo $this->_tpl_vars['sStepperClass']; ?>
">
	<td colspan="<?php echo count($this->_tpl_vars['aColumn']); ?>
" style="text-align:<?php echo $this->_tpl_vars['sStepperAlign']; ?>
;" class="<?php echo $this->_tpl_vars['sStepperClassTd']; ?>
">
	<?php echo $this->_tpl_vars['sStepper']; ?>

	<?php if ($this->_tpl_vars['bStepperInfo']): ?>
	<span class="<?php echo $this->_tpl_vars['sStepperInfoClass']; ?>
"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('showing row'); ?>
 <?php echo $this->_tpl_vars['iStartRow']+1; ?>
 - <?php if (( $this->_tpl_vars['iEndRow'] == 10000 && $this->_tpl_vars['iAllRow'] < 10000 ) || $this->_tpl_vars['iAllRow'] < $this->_tpl_vars['iEndRow']): ?><?php echo $this->_tpl_vars['iAllRow']; ?>
<?php else: ?><?php echo $this->_tpl_vars['iEndRow']; ?>
<?php endif; ?> of <?php echo $this->_tpl_vars['iAllRow']; ?>
</span>
	<?php endif; ?>
	</td>
</tr>
<?php endif; ?>
<?php if ($this->_tpl_vars['bShowRowPerPage']): ?>
<tr>
	<td colspan="<?php echo count($this->_tpl_vars['aColumn']); ?>
" style="text-align:right;">
	<?php echo $this->_tpl_vars['oLanguage']->getDMessage('Display #'); ?>

<select id=display_select_id name=display_select style="width: 50px;"
	onchange="<?php echo 'javascript:location.href=\'/?'; ?><?php echo $this->_tpl_vars['sActionRowPerPage']; ?><?php echo '&content=\'+document.getElementById(\'display_select_id\').options[document.getElementById(\'display_select_id\').selectedIndex].value;'; ?>
">
	<option value=10 <?php if ($this->_tpl_vars['iRowPerPage'] == 10): ?> selected<?php endif; ?>>10</option>
    <option value=20 <?php if ($this->_tpl_vars['iRowPerPage'] == 20 || ! $this->_tpl_vars['iRowPerPage']): ?> selected<?php endif; ?>>20</option>
    <option value=50 <?php if ($this->_tpl_vars['iRowPerPage'] == 50): ?> selected<?php endif; ?>>50</option>
    <option value=100 <?php if ($this->_tpl_vars['iRowPerPage'] == 100): ?> selected<?php endif; ?>>100</option>
    <?php if ($this->_tpl_vars['bShowPerPageAll']): ?><option value=10000 <?php if ($this->_tpl_vars['iRowPerPage'] == 10000): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['oLanguage']->getMessage('all'); ?>
</option><?php endif; ?>
</select>

<span class="stepper_results"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Results'); ?>
 <?php echo $this->_tpl_vars['iStartRow']; ?>
 - <?php if ($this->_tpl_vars['iEndRow'] == 10000 && $this->_tpl_vars['iAllRow'] < 10000): ?><?php echo $this->_tpl_vars['iAllRow']; ?>
<?php else: ?><?php echo $this->_tpl_vars['iEndRow']; ?>
<?php endif; ?> <?php echo $this->_tpl_vars['oLanguage']->getDMessage('of'); ?>
 <?php echo $this->_tpl_vars['iAllRow']; ?>
</span>
	</td>
</tr>
<?php endif; ?>

</table>

<?php if ($this->_tpl_vars['sStepper'] && $this->_tpl_vars['bStepperOutTable']): ?>
<div class="<?php echo $this->_tpl_vars['sStepperClass']; ?>
">
	<?php echo $this->_tpl_vars['sStepper']; ?>

	<?php if ($this->_tpl_vars['bStepperInfo']): ?>
	<span class="<?php echo $this->_tpl_vars['sStepperInfoClass']; ?>
"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('showing row'); ?>
 <?php echo $this->_tpl_vars['iStartRow']+1; ?>
 - <?php if (( $this->_tpl_vars['iEndRow'] == 10000 && $this->_tpl_vars['iAllRow'] < 10000 ) || $this->_tpl_vars['iAllRow'] < $this->_tpl_vars['iEndRow']): ?><?php echo $this->_tpl_vars['iAllRow']; ?>
<?php else: ?><?php echo $this->_tpl_vars['iEndRow']; ?>
<?php endif; ?> <?php echo $this->_tpl_vars['oLanguage']->getDMessage('of'); ?>
 <?php echo $this->_tpl_vars['iAllRow']; ?>
</span>
	<?php endif; ?>
</div>
<?php endif; ?>

<div style="padding: 5px;">
<?php if ($this->_tpl_vars['sButtonTemplate']): ?> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['sButtonTemplate'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> <?php endif; ?>

<?php if ($this->_tpl_vars['sAddButton']): ?>
<span <?php if ($this->_tpl_vars['sButtonSpanClass']): ?>class="button"<?php endif; ?>>
<input type=button class='btn' value="<?php echo $this->_tpl_vars['sAddButton']; ?>
" onclick="location.href='<?php if (! $this->_tpl_vars['bNoneDotUrl']): ?>.<?php endif; ?>/?action=<?php echo $this->_tpl_vars['sAddAction']; ?>
'" >
</span>
<?php endif; ?>
</div>


<?php if ($this->_tpl_vars['bFormAvailable']): ?>
<input type="hidden" name="action" id='action' value='<?php if ($this->_tpl_vars['sFormAction']): ?><?php echo $this->_tpl_vars['sFormAction']; ?>
<?php else: ?>empty<?php endif; ?>'>
<input type="hidden" name="return" id='return' value='<?php echo $this->_tpl_vars['sReturn']; ?>
'>
</form>
<?php endif; ?>