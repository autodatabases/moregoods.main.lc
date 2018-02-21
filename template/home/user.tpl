            {if $aAuthUser.id && !($oContent->IsChangeableLogin($aAuthUser.login)) }
                <div class="user-login-block">
                    <span class="top-decorative">&nbsp;</span>
                    <h2 class="at-caption">{$oLanguage->GetMessage('personal menu')}:</h2>
                    <div class="hello">
                        <span>{$oLanguage->GetMessage('Hello,')}</span>
                        <br />
                        <a href="/pages/{$aAuthUser.type_}_profile" class="user">{$aAuthUser.login}</a>
{if $aAuthUser.type_=='manager'}
<br>
{if $iNotViewedOrders>0}<span style="color:red; font-weight: bold;">{$oLanguage->GetMessage('NotViewedOrders')} {$iNotViewedOrders}</span>{else}{$oLanguage->GetMessage('NotViewedOrders')} {$iNotViewedOrders}{/if}
<br>
{if $iNotViewedVins>0}<span style="color:red; font-weight: bold;">{$oLanguage->GetMessage('NotViewedVins')} {$iNotViewedVins}</span>{else}{$oLanguage->GetMessage('NotViewedVins')} {$iNotViewedVins}{/if}
{/if}
{if $sVersionTecDoc && $aAuthUser.type_=='manager'}
	<br><span style="font-weight: bold;">{$oLanguage->GetMessage('VersionTecDoc')}: {$sVersionTecDoc}</span>
{/if}
                    </div>
                    <div class="user-navigation">
                        <div class="inner">
                            <a href="/pages/{$aAuthUser.type_}_profile" >
                                <span class="user-pick-bg">&nbsp;</span>
                                {$oLanguage->GetMessage('profile')}
                            </a>
                            <a href="/pages/messages">
                                <span class="message-bg">&nbsp;</span>
                                {$oLanguage->GetMessage('messages')} <sup>{$aTemplateNumber.message_number}</sup>
                            </a>
                        </div>
                        {if $aAuthUser.type_ == 'manager'}
                        <div class="inner">
                        	<form action="/">
	                        	<span style="margin: auto;display: table;"><b>{$oLanguage->getMessage("Select level price")}</b></span><br>
	                        	<input type="radio" name="type_price" class="css-checkbox" value="user" {if $aAuthUser.type_price == 'user'}checked{/if}>
	                        	<label class="css-label">{$oLanguage->getMessage("user")}:<br>
	                        	{html_options name=data[id_type_price_user] options=$aNameManager selected=$aAuthUser.id_type_price_user id="select_name_user"
								style="width:179px;"}</label><br>
	                        	<input type="radio" name="type_price" class="css-checkbox" value="group" {if $aAuthUser.type_price == 'group' || $aAuthUser.type_price == 'none'}checked{/if}>
	                        	<label class="css-label">{$oLanguage->getMessage("group user")}:<br>
									{if $aAuthUser.id_type_price_group!=0}
										{assign var='id_type_price_group' value=$aAuthUser.id_type_price_group}
	                        		{else}
	                        			{assign var='id_type_price_group' value=$oLanguage->getConstant('IdDefaultPriceGroupManager',1)}
	                        		{/if}                        		
	                        		{html_options name=data[id_type_price_group] id="select_group_user" options=$aPriceGroup selected=$id_type_price_group style="width:179px;"} 
	                        	</label>
	                        	<input name="action" value="user_change_level_price" type="hidden">
	                        	<input name="uri" value="{$sURI}" type="hidden">
	                        	<span style="margin: auto;display: table;"><input type="submit" value="{$oLanguage->getMessage('Apply')}"></span>
                        	</form>
                        	{literal}
								<script type="text/javascript">    
								    $(document).ready(function() {
								    	 $('#select_name_user').select2({
								    		    minimumInputLength: 2,
								    		    ajax: {
								    		      url: "/?action=manager_get_user_select",
								    		      dataType: 'json',
								    		      data: function (term, page) {
								    		        return {
								    		          data: term
								    		        };
								    		      },
								    		      processResults: function (data) {
								    		            return {
								    		                results: $.map(data, function (item) {
								    		                    return {
								    		                        text: item.name,
								    		                        id: item.id
								    		                    }
								    		                })
								    		            };
								    		        }
								    		    }
								    		  });
								    	 $('#select_group_user').select2();
								    });									
							    </script>
								{/literal}
                        </div>
                        {/if}
                    </div>
                    <div class="clear">&nbsp;</div>
                    <div class="user-settings">
                        {foreach from=$aAccountMenu item=aItem}
							<a href="/pages/{if !$aItem.link}{$aItem.code}{else}{$aItem.code}{/if}">{$aItem.name}</a>
							{if $aAuthUser.type_=='manager'}
								{if $aItem.code=="message"}{if $aTemplateNumber.message_number} <font color="red">({$aTemplateNumber.message_number})</font>{/if}{/if}
								{if $aItem.code=="message_change_current_folder"}{if $aTemplateNumber.message_number} <font color="red">({$aTemplateNumber.message_number})</font>{/if}{/if}
								{if $aItem.code=="vin_request_manager"}{if $iNotViewedVins} <font color="red">({$iNotViewedVins})</font>{/if}{/if}
								{if $aItem.code=="manager_package_list"}{if $iNotViewedOrders} <font color="red">({$iNotViewedOrders})</font>{/if}{/if}
							{/if}
							<br>
						{/foreach}
                    </div>
                    <input type="button" value="Выйти" class="at-login-button"
						onclick="javascript: location.href='/pages/user_logout'" />
                </div>
                {if $aAuthUser.type_=='customer'}
                <div class="at-manager-block">
                    <a href="/?action=message_compose&compose_to={$aAuthUser.manager_login}"
						>{$oLanguage->GetMessage('Your personal manager')}</a>
                </div>
                {/if}
                {else}
				<div class="user-login-block">
                    <span class="top-decorative">&nbsp;</span>
                    <form action="/" method='post'>
                        <label class="login-label">
                            <span>{$oLanguage->GetMessage('login/email')}:</span>
                            <input type="text" name="login" class='' />
                        </label>
                        <label class="login-label">
                            <span>{$oLanguage->GetMessage('password')}:</span>
                            <input type="password" name="password" />
                        </label>
                        <div class="clear">&nbsp;</div>
                        <input type="submit" value="{$oLanguage->GetMessage('enter')}" class="at-login-button" />
                        <input name="action" value="user_do_login" type="hidden">

<div style="margin-left: 5px; margin-top: 5px;">
<script src="http://ulogin.ru/js/ulogin.js" type="text/javascript"></script>
<div id="uLogin" x-ulogin-params="display=small;fields={$oLanguage->GetConstant('ulogin:fields','first_name,last_name,email,nickname')};providers={$oLanguage->GetConstant('ulogin:providers','vkontakte,facebook,twitter,google')};hidden=other;redirect_uri={$sUloginURI}"></div>
</div>
                    </form>
                    <div class="forgot">
                        <a href="/pages/user_restore_password">{$oLanguage->GetMessage('lost password')}</a> |
                        <a href="/pages/user_new_account">{$oLanguage->GetMessage('register')}</a>
                    </div>
                    <div class="clear">&nbsp;</div>
                </div>
                {/if}