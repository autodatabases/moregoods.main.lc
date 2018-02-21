<table class="gm-block-order-filter2 no-mobile">
{if $smarty.request.code_template=='order_bill'}
	<tr>
   		<td>{$oLanguage->getMessage("Id cart package")}:</td>
   		<td><input type=text name=data[id_cart_package] value='{$aData.id_cart_package}' style='width:352px'></td>
  	</tr>
{/if}

{if $aAuthUser.type_=='manager'}
	<tr>
   		<td width=50%>{$oLanguage->getMessage("Login")}:</td>
   		<td nowrap><input type=text name=data[login] value='{$aData.login}' maxlength=50 style='width:352px'></td>
  	</tr>
{/if}

  	<tr>
   		<td width=50%>{$oLanguage->getMessage("Account")}: {$sZir}</td>
   		<td>
   		 <div class="options">
   		{html_options class="js-uniform" id="menu_select" name=data[id_account] options=$aAccount selected=$aData.id_account}
   		</div>
   		</td>
  	</tr>

	<tr>
   		<td width=50%>{$oLanguage->getMessage("Amount")}:{$sZir}</td>
   		<td nowrap><input type=text name=data[amount]
			value='{if $aData.amount}{$aData.amount}{else}{$smarty.request.amount}{/if}'
			maxlength=50 style='width:429px'></td>
  	</tr>
</table>

<input type=hidden name=data[code_template] value='{$sCodeTemplate}'>