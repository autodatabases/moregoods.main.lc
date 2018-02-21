
{if $aGeneralConf.IsLive}
	

{/if}

{if $aAuthUser.type_=='manager'}
    <script type="text/javascript">
    {literal}
    $(document).ready(function() {
	if ($('#select_name_user').length) {
	    $("#select_name_user").searchable({
	    maxListSize: 50,
	    maxMultiMatch: 25,
	    wildcards: true,
	    ignoreCase: true,
	    latency: 1000,
	    {/literal}warnNoMatch: '{$oLanguage->getMessage('no matches')} ...',{literal}
	    zIndex: 'auto'
	    });
	}
    });
    {/literal}
    </script>
{/if}
<!-- WhatsHelp.io widget -->
{literal}
<!-- Мессенджер -->
<!-- WhatsHelp.io widget -->
<script type="text/javascript">
    (function () {
        var options = {
            whatsapp: "+380933455826", // WhatsApp number
            vkontakte: "coffe88", // VKontakte page name
            email: "lysenkoalexa@ukr.net", // Email
            sms: "+380933455826", // Sms phone number
            company_logo_url: "//static.whatshelp.io/img/flag.png", // URL of company logo (png, jpg, gif)
            greeting_message: "Здравствуйте! Отправьте нам сообщение через любой из мессенджеров.", // Text of greeting message
            call_to_action: "Напишите нам", // Call to action
            button_color: "#FF6550", // Color of button
            position: "right", // Position may be 'right' or 'left'
            order: "whatsapp,email,sms,vkontakte" // Order of buttons
        };
        var proto = document.location.protocol, host = "whatshelp.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script>
<!-- /WhatsHelp.io widget -->
	{/literal}
<!-- /WhatsHelp.io widget -->
</body>
</html>