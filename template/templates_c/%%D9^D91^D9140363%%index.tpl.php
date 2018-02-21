<?php /* Smarty version 2.6.18, created on 2018-02-19 23:24:26
         compiled from message/index.tpl */ ?>
<?php echo $this->_tpl_vars['sSearchForm']; ?>


<table cellpadding="0" cellspacing="1" border="0" style="padding-top: 5px; padding-bottom: 5px;" width="100%">
<tr>
	<td>
<div class="ak-taber-block">
	<a <?php if (! $_SESSION['message']['current_folder_id'] || $_SESSION['message']['current_folder_id'] == 1): ?>class="selected"<?php endif; ?> href="/?action=message_change_current_folder&id_message_folder=1"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Inbox'); ?>
 (<?php echo $this->_tpl_vars['aMessageNumber']['inbox']; ?>
)</a>
	<a <?php if ($_SESSION['message']['current_folder_id'] == 2): ?>class="selected"<?php endif; ?> href="/?action=message_change_current_folder&id_message_folder=2"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Outbox'); ?>
 (<?php echo $this->_tpl_vars['aMessageNumber']['outbox']; ?>
)</a>
	<a <?php if ($_SESSION['message']['current_folder_id'] == 3): ?>class="selected"<?php endif; ?> href="/?action=message_change_current_folder&id_message_folder=3"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Draft'); ?>
 (<?php echo $this->_tpl_vars['aMessageNumber']['draft']; ?>
)</a>
	<a <?php if ($_SESSION['message']['current_folder_id'] == 4): ?>class="selected"<?php endif; ?> href="/?action=message_change_current_folder&id_message_folder=4"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Archived'); ?>
 (<?php echo $this->_tpl_vars['aMessageNumber']['deleted']; ?>
)</a>
	<a 
	<?php if ($_SESSION['message']['is_starred']): ?>
		href="/?action=message_change_starred&is_starred=0"
			onclick="xajax_process_browse_url(this.href);return false;"><img src="/image/starred_on.png" align="absmiddle" />
	<?php else: ?>
		href="/?action=message_change_starred&is_starred=1"
			onclick="xajax_process_browse_url(this.href);return false;"><img src="/image/starred_off.png" align="absmiddle" />
	<?php endif; ?>&nbsp;
	</a>
	<div class="clear"></div>
</div>
	</td>
	<td align="right" style="padding-left:10px">
	</td>
</tr>
</table>

<form method="POST" enctype="multipart/form-data" name="message_form" id="message_form_id">
<input type="hidden" name="action" value="search">
<?php if ($this->_tpl_vars['compose']): ?>
	<input type="hidden" name="compose" value="1">
<?php endif; ?>
<?php echo $this->_tpl_vars['sMainSection']; ?>


</form>