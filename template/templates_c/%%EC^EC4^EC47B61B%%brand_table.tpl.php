<?php /* Smarty version 2.6.18, created on 2017-06-14 19:03:50
         compiled from index_include/brand_table.tpl */ ?>
<script type="text/javascript" src="/libp/js/table.js"></script>

<?php if ($_GET['table_error']): ?>
<div class="error_message"><?php echo $this->_tpl_vars['oLanguage']->getMessage($_GET['table_error']); ?>
</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['sTableMessage']): ?><div class="<?php echo $this->_tpl_vars['sTableMessageClass']; ?>
"><?php echo $this->_tpl_vars['sTableMessage']; ?>
</div><?php endif; ?>


<?php if ($this->_tpl_vars['bFormAvailable']): ?><form id="<?php echo $this->_tpl_vars['sIdForm']; ?>
" <?php echo $this->_tpl_vars['sFormHeader']; ?>
><?php endif; ?>

<div <?php if ($this->_tpl_vars['sIdTable'] != ""): ?>id="<?php echo $this->_tpl_vars['sIdTable']; ?>
"<?php endif; ?> style="width:<?php echo $this->_tpl_vars['sWidth']; ?>
;border-spacing:<?php echo $this->_tpl_vars['sCellSpacing']; ?>
;padding:0px;">

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


<?php if (! $this->_tpl_vars['aItem']): ?>
<a class="child-element">
	<?php if ($this->_tpl_vars['sNoItem']): ?>
		<?php echo $this->_tpl_vars['oLanguage']->getMessage($this->_tpl_vars['sNoItem']); ?>

	<?php else: ?>
		<?php echo $this->_tpl_vars['oLanguage']->getMessage('No items found'); ?>

	<?php endif; ?>
</a>
<?php endif; ?>
            <span class="child-empty"></span>
            <span class="child-empty"></span>
            <span class="child-empty"></span>
            <span class="child-empty"></span>
            <span class="child-empty"></span>
</div>

<?php if ($this->_tpl_vars['sStepper'] && ! $this->_tpl_vars['bStepperOutTable'] && $this->_tpl_vars['aStepperData']['iPageCount'] > 1): ?>
	<?php echo $this->_tpl_vars['sStepper']; ?>

<?php endif; ?>
<?php if ($this->_tpl_vars['bFormAvailable']): ?>
<input type="hidden" name="action" id='action' value='<?php if ($this->_tpl_vars['sFormAction']): ?><?php echo $this->_tpl_vars['sFormAction']; ?>
<?php else: ?>empty<?php endif; ?>'>
<input type="hidden" name="return" id='return' value='<?php echo $this->_tpl_vars['sReturn']; ?>
'>
</form>
<?php endif; ?>