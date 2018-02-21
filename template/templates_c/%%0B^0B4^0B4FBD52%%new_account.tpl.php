<?php /* Smarty version 2.6.18, created on 2018-02-20 12:21:03
         compiled from user/new_account.tpl */ ?>
<script type='text/javascript'>
    $('.gm-block-page').addClass('gm-block-registration');
</script>
<?php if ($this->_tpl_vars['sSecondTime']): ?>
<input type="hidden" value="1" name="second_time">
<?php endif; ?>
 <div class="wrap-left">
            <div class="gm-block-form">
                                <div class="form-element">
                    <div class="element-name">Имя:<?php echo $this->_tpl_vars['sZir']; ?>
</div>
                    <input type=text name=data[name] value='<?php if ($this->_tpl_vars['aUser']['name']): ?><?php echo $this->_tpl_vars['aUser']['name']; ?>
<?php else: ?><?php echo $_REQUEST['data']['name']; ?>
<?php endif; ?>' >
                </div>
                <div class="form-element">
                    <div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Email'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</div>
                    <input name=email type=email value='<?php echo $_REQUEST['email']; ?>
' />
                </div>
                <div class="form-element">
                    <div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Phone'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
<span id='check_login_image_id'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                    <div class="phone-wrapper">
                        <span class="code">+38</span>
                        <input type=text name=data[phone] class="phone" value='<?php if ($this->_tpl_vars['aUser']['name']): ?><?php echo $this->_tpl_vars['aUser']['phone']; ?>
<?php else: ?><?php echo $_REQUEST['data']['phone']; ?>
<?php endif; ?>'>
                    </div>
                </div>
                <div class="form-element">
                    <div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Login'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</div>
                    <input name=login type=text id=user_login value='<?php echo $_REQUEST['login']; ?>
' />
                </div>
                <div class="form-element">
                    <div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Password'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</div>
                    <input type=password name=password value='<?php echo $_REQUEST['password']; ?>
' maxlength=50 id="pass1" />
                </div>
                <div class="form-element">
                    <div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Retype Password'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</div>
                    <input type=password name=verify_password value='<?php echo $_REQUEST['verify_password']; ?>
' maxlength=50 id="pass2" />
                </div>
                <div class="form-element">
                    <div class="verify" id="pass-strength-result">	<?php echo $this->_tpl_vars['oLanguage']->GetMessage('password strength'); ?>
</div>
                </div>

                <div class="form-element">
                    <div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('City'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</div>
                    <input type=text name=data[city] value='<?php if ($this->_tpl_vars['aUser']['name']): ?><?php echo $this->_tpl_vars['aUser']['city']; ?>
<?php else: ?><?php echo $_REQUEST['data']['city']; ?>
<?php endif; ?>'>
                </div>
                <div class="form-element">
                    <div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Address'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</div>
                    <input type=text name=data[address] value='<?php if ($this->_tpl_vars['aUser']['name']): ?><?php echo $this->_tpl_vars['aUser']['address']; ?>
<?php else: ?><?php echo $_REQUEST['data']['address']; ?>
<?php endif; ?>'>
                </div>
                <div class="form-element">
                    <div class="capcha">
<?php echo $this->_tpl_vars['oLanguage']->getMessage('Capcha field'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>

                        <div class="formula">
                            <?php echo $this->_tpl_vars['sCapcha']; ?>

                        </div>
                    </div>
                </div>
                <div class="form-element">
                    <label class="long">
                        <input style='-webkit-appearance: checkbox;' type=checkbox name=user_agreement>
                        <?php echo $this->_tpl_vars['oLanguage']->GetMessage('iam_agree'); ?>

                        <a class="gm-link-dashed global" href="/pages/agreement"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('polzovat_sogl'); ?>
</a>
                    </label>
                </div>
                <div class="form-element">
                    <input class="gm-button" type="submit" value="<?php echo $this->_tpl_vars['oLanguage']->GetMessage('register'); ?>
">
                </div>
            </div>
        </div>
        <div class="wrap-right">
            <div class="features">
               <img src="/image/_images/success-bg-bird.jpg">
            </div>
        </div>
        <div class="clear"></div>
        


<LINK href="/css/user.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="/js/user.js"></script>

<script type='text/javascript'>
var aPasswordMessage = {
	empty: "<?php echo $this->_tpl_vars['oLanguage']->GetMessage('password strength'); ?>
",
	short: "<?php echo $this->_tpl_vars['oLanguage']->GetMessage('password strength:short'); ?>
",
	bad: "<?php echo $this->_tpl_vars['oLanguage']->GetMessage('password strength:bad'); ?>
",
	good: "<?php echo $this->_tpl_vars['oLanguage']->GetMessage('password strength:good'); ?>
",
	strong: "<?php echo $this->_tpl_vars['oLanguage']->GetMessage('password strength:strong'); ?>
",
	mismatch: "<?php echo $this->_tpl_vars['oLanguage']->GetMessage('password strength:mismatch'); ?>
"
};

jQuery(document).ready(function($) {
	$('#pass1').keyup(oUser.CheckPasswordStrength);
	$('#pass2').keyup(oUser.CheckPasswordStrength);
	$('#pass-strength-result').show();
});
</script>