<?php /* Smarty version 2.6.18, created on 2018-01-13 14:52:47
         compiled from mpanel/banner/form_image.tpl */ ?>
<?php if (! $this->_tpl_vars['sFieldName']): ?>
	<?php $this->assign('sFieldName', 'image_small'); ?>
<?php endif; ?>

<tr>
<td><?php echo $this->_tpl_vars['oLanguage']->GetDMessage($this->_tpl_vars['sFieldName']); ?>
:</td>
<td>
<?php if ($this->_tpl_vars['bShowImagePath']): ?>
	<?php echo $this->_tpl_vars['aData'][$this->_tpl_vars['sFieldName']]; ?>

<?php endif; ?>
     <img id='<?php echo $this->_tpl_vars['sFieldName']; ?>
' width=100 border=0 align=absmiddle hspace=5 src='<?php if ($this->_tpl_vars['aData'][$this->_tpl_vars['sFieldName']]): ?><?php echo $this->_tpl_vars['aData'][$this->_tpl_vars['sFieldName']]; ?>
<?php endif; ?>'>
     <input type=<?php if ($this->_tpl_vars['bNotHidden']): ?>text<?php else: ?>hidden<?php endif; ?> name=data[<?php echo $this->_tpl_vars['sFieldName']; ?>
] id='<?php echo $this->_tpl_vars['sFieldName']; ?>
_input' value='<?php echo $this->_tpl_vars['aData'][$this->_tpl_vars['sFieldName']]; ?>
'>
     <table><tr>
        <td><img hspace=1 align=absmiddle src='/libp/mpanel/images/small/inbox.png'>
        	<a href="#" onclick="<?php echo 'javascript:OpenFileBrowser(\'/libp/mpanel/imgmanager/browser/default/browser.php?Type=Image&Connector=php_connector/connector.php&return_id='; ?><?php echo $this->_tpl_vars['sFieldName']; ?><?php echo '\', 600, 400); return false;'; ?>
"
				style='font-weight:normal'><?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Change'); ?>
</a></td>
        <td><img hspace=1 align=absmiddle src='/libp/mpanel/images/small/outbox.png'>
        	<a href=# onclick="javascript:ClearImageURL('<?php echo $this->_tpl_vars['sFieldName']; ?>
');return false;" style='font-weight:normal'
				><?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Clear'); ?>
</a></td>
     </table>
</td>
</tr>