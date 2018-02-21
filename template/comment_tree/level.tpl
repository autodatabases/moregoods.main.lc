<ul class="comments">
{foreach from=$root item=aRow}
	<li>
	<div class="chd">
	<span>
		<a href=""><img src="image/design/avatar.gif" class="avatar" /></a>
		<a href="">{$aRow.name}</a>
		<label>{$aRow.post_date}</label>
		<a onclick="ct.NewComment({$aRow.id})" href="#0">{$oLanguage->getMessage('add unswer')}</a>
	</span>
	</div>
	{$aRow.content}	
	
	{if (!empty($aRow.child))}
		{include file="comment_tree/level.tpl" root=$aRow.child}
	{/if}
	</li>
{/foreach}
</ul>