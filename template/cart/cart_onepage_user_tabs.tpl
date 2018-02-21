<div class="ak-taber-block js-client-tabs">
	{if $aAuthUser.type_=='manager'}
		<a href="#" class="{if !isset($bFromCheckLogged)}selected{/if}">{$oLanguage->getMessage("Create New account")}</a>
		<a href="#" class="{if isset($bFromCheckLogged)}selected{/if}">{$oLanguage->getMessage("Select account")}</a>
	{else}
		<a href="#" class="{if !isset($bFromCheckLogged)}selected{/if}">{$oLanguage->getMessage("Im new customer")}</a>
		<a href="#" class="{if isset($bFromCheckLogged)}selected{/if}">{$oLanguage->getMessage("Im regular customer")}</a>
	{/if}
	<div class="clear"></div>
</div> 
{literal}
	<script type="text/javascript">
		$(function() {
			$('.js-client-tabs a').click(function(){
			$('.js-client-tabs a').removeClass('selected');
			$(this).addClass('selected');
			$('.js-client-change').toggle();
			return false;
			});
		});
	</script>
{/literal}