<div  class="block-labels js-block-label2">
{foreach from=$aAdress item=aItem}
	<label class="label ">
		<input style="-webkit-appearance: radio;" type="radio" name="id_addres" value='{$aItem.id}'
		>
		<span class="caption">{$aItem.addresses}</span>
	</label>

{/foreach}</div>