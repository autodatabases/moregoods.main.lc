<script type="text/javascript" src="/js/comment_tree.js"></script>

<b>{$oLanguage->getMessage('Leave comment')}</b>


{if $aAuthUser.id}
<a name="0">&nbsp;</a>
<form>

<p><input name="name" value="{$aAuthUser.login}" size="22" tabindex="1" type="text">
{$oLanguage->getMessage('Comment name')}</p>

<p><input name="email" value="" size="22" tabindex="2" type="text">
{$oLanguage->getMessage('Comment email (not published)')}</p>
<!-- 
<p><input name="site" value="" size="22" tabindex="3" type="text">
{$oLanguage->getMessage('Comment url')}</p>
 -->

<p><textarea name="content" cols="100" rows="5" tabindex="4" id="content"></textarea></p>

<p><input name="submit" tabindex="5" value="{$oLanguage->getMessage('Submit comment')}" type="button" class='btn'
	onclick="xajax_process_form(xajax.getFormValues(this.form));">

<input name="action" value="comment_post" type="hidden">

<input name="section" value="{$sSection}" type="hidden">
<input name="ref_id" value="{$sRefId}" type="hidden">
<input name="parent_id" value="0" type="hidden" id="parent_id">
</p>


{else}
<p>
{$oLanguage->getMessage("You need to <a href='/?action=user_login'>authorize</a> to leave a comment")}
{/if}

</div>