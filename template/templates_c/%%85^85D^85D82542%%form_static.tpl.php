<?php /* Smarty version 2.6.18, created on 2018-02-07 16:30:06
         compiled from contact_form/form_static.tpl */ ?>
<div class="gm-block-form">
		<div class="form-element">
			<div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage("Ваше имя"); ?>
<?php echo $this->_tpl_vars['sZir']; ?>
</div>
			<input class="form-control grey" type="text" name=data[name] value="<?php echo $_REQUEST['data']['name']; ?>
">
		</div>
		<div class="form-element">
			<div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage("Ваш e-mail"); ?>
<?php echo $this->_tpl_vars['sZir']; ?>
</div>
			<input class="form-control grey" type="text" name=data[email] value="<?php echo $_REQUEST['data']['email']; ?>
">
		</div>
		<div class="form-element">
			<div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage("Номер вашего телефона"); ?>
</div>
			<input class="form-control grey phone" type="text" name=data[phone] value="<?php echo $_REQUEST['data']['phone']; ?>
">
		</div>
		<div class="form-element">
			<div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage("Тема"); ?>
</div>
			<input class="form-control grey" type="text" name=data[subject] value="<?php echo $_REQUEST['data']['subject']; ?>
">
		</div>
		<div class="form-element">
			<div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Capcha field'); ?>
<?php echo $this->_tpl_vars['sZir']; ?>
</div>
			<?php echo $this->_tpl_vars['sCapcha']; ?>

		</div>

		<div class="form-element">
			<div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage("Ваш запрос"); ?>
</div>
			<textarea class="form-control" name=data[description]><?php echo $_REQUEST['data']['description']; ?>
</textarea>
		</div>


	<div class="submit">
		<button type="submit" name="submitMessage" id="submitMessage" class="button btn btn-default button-medium">
			<span>
				<?php echo $this->_tpl_vars['oLanguage']->getMessage('Send'); ?>

				<i class="icon-chevron-right right"></i>
			</span>
		</button>
	</div>
</div>
<br>
<br>