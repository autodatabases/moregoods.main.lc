<script type='text/javascript'>
    $('.gm-block-page').addClass('gm-block-registration');
</script>
{if $sSecondTime}
<input type="hidden" value="1" name="second_time">
{/if}
 <div class="wrap-left">
            <div class="gm-block-form">
                {*if $smarty.request.action=='user_new_account'}
                <div class="form-element">
                    <div class="element-name"><br>{$oLanguage->getDMessage('Region')}:{$sZir}</div>
                    {if $aUser.id_region}
                        {assign var=iIdRegion value=$aUser.id_region}
                    {else}
                        {assign var=iIdRegion value=$smarty.request.data.id_region}
                    {/if}
                {html_options name=data[id_geo] options=$aRegionList selected=$iIdRegion class=js-uniform}
                </div>
                {/if*}
                <div class="form-element">
                    <div class="element-name">Имя:{$sZir}</div>
                    <input type=text name=data[name] value='{if $aUser.name}{$aUser.name}{else}{$smarty.request.data.name}{/if}' >
                </div>
                <div class="form-element">
                    <div class="element-name">{$oLanguage->getMessage("Email")}:{$sZir}</div>
                    <input name=email type=email value='{$smarty.request.email}' />
                </div>
                <div class="form-element">
                    <div class="element-name">{$oLanguage->getMessage("Phone")}:{$sZir}<span id='check_login_image_id'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                    <div class="phone-wrapper">
                        <span class="code">+38</span>
                        <input type=text name=data[phone] class="phone" value='{if $aUser.name}{$aUser.phone}{else}{$smarty.request.data.phone}{/if}'>
                    </div>
                </div>
                <div class="form-element">
                    <div class="element-name">{$oLanguage->getMessage("Login")}:{$sZir}</div>
                    <input name=login type=text id=user_login value='{$smarty.request.login}' />
                </div>
                <div class="form-element">
                    <div class="element-name">{$oLanguage->getMessage("Password")}:{$sZir}</div>
                    <input type=password name=password value='{$smarty.request.password}' maxlength=50 id="pass1" />
                </div>
                <div class="form-element">
                    <div class="element-name">{$oLanguage->getMessage("Retype Password")}:{$sZir}</div>
                    <input type=password name=verify_password value='{$smarty.request.verify_password}' maxlength=50 id="pass2" />
                </div>
                <div class="form-element">
                    <div class="verify" id="pass-strength-result">	{$oLanguage->GetMessage('password strength')}</div>
                </div>

                <div class="form-element">
                    <div class="element-name">{$oLanguage->getMessage("City")}:{$sZir}</div>
                    <input type=text name=data[city] value='{if $aUser.name}{$aUser.city}{else}{$smarty.request.data.city}{/if}'>
                </div>
                <div class="form-element">
                    <div class="element-name">{$oLanguage->getMessage("Address")}:{$sZir}</div>
                    <input type=text name=data[address] value='{if $aUser.name}{$aUser.address}{else}{$smarty.request.data.address}{/if}'>
                </div>
                <div class="form-element">
                    <div class="capcha">
{$oLanguage->getMessage("Capcha field")}:{$sZir}
                        <div class="formula">
                            {$sCapcha}
                        </div>
                    </div>
                </div>
                <div class="form-element">
                    <label class="long">
                        <input style='-webkit-appearance: checkbox;' type=checkbox name=user_agreement>
                        {$oLanguage->GetMessage('iam_agree')}
                        <a class="gm-link-dashed global" href="/pages/agreement">{$oLanguage->GetMessage('polzovat_sogl')}</a>
                    </label>
                </div>
                <div class="form-element">
                    <input class="gm-button" type="submit" value="{$oLanguage->GetMessage('register')}">
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
var aPasswordMessage = {ldelim}
	empty: "{$oLanguage->GetMessage('password strength')}",
	short: "{$oLanguage->GetMessage('password strength:short')}",
	bad: "{$oLanguage->GetMessage('password strength:bad')}",
	good: "{$oLanguage->GetMessage('password strength:good')}",
	strong: "{$oLanguage->GetMessage('password strength:strong')}",
	mismatch: "{$oLanguage->GetMessage('password strength:mismatch')}"
{rdelim};

jQuery(document).ready(function($) {ldelim}
	$('#pass1').keyup(oUser.CheckPasswordStrength);
	$('#pass2').keyup(oUser.CheckPasswordStrength);
	$('#pass-strength-result').show();
{rdelim});
</script>