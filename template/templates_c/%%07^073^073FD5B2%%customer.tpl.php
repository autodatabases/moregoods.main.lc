<?php /* Smarty version 2.6.18, created on 2018-02-19 22:57:39
         compiled from dashboard/customer.tpl */ ?>
<div class="gm-block-userdata personal">
                <div class="caption"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('personal_data'); ?>
</div>
                <div class="user-data">
                    <span><?php echo $this->_tpl_vars['oLanguage']->GetMessage('contact_person'); ?>
</span><br />
                    <?php echo $this->_tpl_vars['aAuthUser']['name']; ?>
<br />
                    <br />
                    <span><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Email'); ?>
</span><br />
                    <a href="mailto:<?php echo $this->_tpl_vars['aAuthUser']['email']; ?>
"><?php echo $this->_tpl_vars['aAuthUser']['email']; ?>
</a><br />
                    <br />
                    <span><?php echo $this->_tpl_vars['oLanguage']->GetMessage('phone'); ?>
</span><br />
                    +38<?php echo $this->_tpl_vars['aAuthUser']['phone']; ?>
<br />
                </div>
                <div class="user-data-edit">
                    <a href="/pages/customer_profile/" class="link-edit"><span class="gm-link-dashed"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('edit'); ?>
</span></a><br />
                    <a href="/pages/user_change_password/" class="link-password"><span class="gm-link-dashed"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('change_parol'); ?>
</span></a><br />
                                    </div>
            </div>
            