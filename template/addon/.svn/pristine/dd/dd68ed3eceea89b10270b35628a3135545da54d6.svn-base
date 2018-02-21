{assign var=bAlreadySelected value=0}

{foreach item=aItem from=$aFrom}
<nobr>
<input name=data[{$sFieldName}] type="radio" value='{$aItem}'
	{if $aItem==$sSelected || (!$sSelected && !$bAlreadySelected)}
		{assign var=bAlreadySelected value=1}
		checked
	{/if}
	> {$aItem}</nobr>&nbsp;
{/foreach}