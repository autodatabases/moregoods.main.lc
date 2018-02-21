 {if !($aAuthUser.id && !($oContent->IsChangeableLogin($aAuthUser.login))) }

<table class='order-by-phone order-in-one-click'>
	{*<tr>
		<td><b>{$oLanguage->GetMessage('order by phone')}</b></td>
	</tr>
	<tr>
		<td>{$oLanguage->GetText('order by phone')}</td>
	</tr>*}
	
	<tr>
		{*<td>+38 <input type="text" placeholder="(___)___ __ __" value="{if $aAuthUser.phone}{$aAuthUser.phone}{/if}" id="user_phone" class="phone fast_order_phone"/>*}
		<a href="/?action=cart_order_by_phone"><span class="title" style="float: right;"><i class="icon-round-phone-black"></i>{$oLanguage->GetMessage('order by phone')}</span>
			</a>{*</td>*}
	</tr>
</table>

<script src="/js/check_phone.js?1"></script>
{/if}