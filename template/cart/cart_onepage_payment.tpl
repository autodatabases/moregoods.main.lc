                <div class="head" id='payment_types' {if $aAuthUser.type_=='customer'} style='display:none'{/if}>{$oLanguage->getMessage("Способ оплаты")} </div>
<div class="block-labels js-block-label" id='payment_types_2' {if $aAuthUser.type_=='customer'} style='display:none'{/if}>
{foreach item=aItem from=$aPaymentType}
                    <label><div class="label {if !$bAlreadySelected}
			selected
		{/if} {if $aItem.id==3} nova {/if}">
          <input type="radio" style="-webkit-appearance: radio;" name=data[id_payment_type] type="radio" value='{$aItem.id}' 
          {if $aItem.description } onclick="show_payment_description('payment_description_{$aItem.id}');" {/if}
		{if !$bAlreadySelected}
			{assign var=bAlreadySelected value=1}
			checked
		{/if}>
                        <span class="caption">{$aItem.name}</span>
                    </div></label>
        <div width=78% class="payment_description payment_description_{$aItem.id}" style='display: none' valign=top>{$aItem.description}</div>
                    {/foreach}
                </div>
{literal}<script type="text/javascript">
function show_payment_description(id_show) {
    $('div.payment_description').hide();
    $('.'+id_show).show();
}</script>
{/literal}
