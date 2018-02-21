<HTML>
<HEAD>
<title>Print</title>
<META http-equiv=content-type content="text/html; charset={$oLanguage->GetConstant('global:default_encoding','UTF-8')}">


{if $bNoFollow && !$bNoIndex}
	<meta name="robots" content="noindex, nofollow"/>
{elseif $bNoFollow && $bNoIndex}
	<meta name="robots" content="noindex, follow"/>
{else}
	<meta name="robots" content="index, follow"/>
{/if}
</HEAD>
<BODY {$sOnloadPrint}>
{if $iBeforeContentButtonsPrint}
{if !$bHideButtonTable}
<table border=0 width=700 class='noPrint'>
	<TR>
		<TD align=center colspan=3>
			{if !$sOnloadPrint}
			<INPUT onclick="javascript:window.print();" style='width=100' type=button class='btn'
				value="{$oLanguage->GetMessage('Print')}">

			{if $iCloseButton==1}
			<input type=button class='btn' name=submit value='{$oLanguage->GetMessage('Close')}'
				style='width=100' onclick="{if $bCloseButtonAsReturn}history.back(){else}window.close(){/if};">
			{/if}

			{if $smarty.get.return}
			<input type=button class='btn' name=submit value='{$oLanguage->GetMessage('Return')}'
				style='width=100' onclick="location.href='/?action={$smarty.get.return}'">
			{/if}
			{/if}
		</TD>

	</TR>
</table>
{/if}
{/if}
{$sContent}

{literal}
<style type="text/css">
@media print {
	.noPrint {
	    display:none;
	}
}
</style>
{/literal}


{if !$bHideButtonTable}
<table border=0 width=700 class='noPrint'>
	<TR>
		<TD align=center colspan=3>
			{if !$sOnloadPrint}
			<INPUT onclick="javascript:window.print();" style='width=100' type=button class='btn'
				value="{$oLanguage->GetMessage('Print')}">

			{if $iCloseButton==1}
			<input type=button class='btn' name=submit value='{$oLanguage->GetMessage('Close')}'
				style='width=100' onclick="{if $bCloseButtonAsReturn}history.back(){else}window.close(){/if};">
			{/if}

			{if $smarty.get.return}
			<input type=button class='btn' name=submit value='{$oLanguage->GetMessage('Return')}'
				style='width=100' onclick="location.href='/?action={$smarty.get.return}'">
			{/if}
			{/if}
		</TD>

	</TR>
</table>
{/if}

</BODY>
</HTML>
