{assign var="print_language_prefix" value=$oLanguage->GetConstant('global:print_language_prefix','ua')}
<center><table width="677px" border="0" cellspacing="0"><tbody><tr><td>
<table width="100%" border="0"><tbody><tr>
<td width="133px">&nbsp;</td>
<td><span style='font-family: Arial;font-size: 8pt;font-style: normal'>
{assign var="desc_lang" value=$print_language_prefix|cat:"_doc_print::cart package print description"}
{$oLanguage->GetMessage($desc_lang)}
</span></td>
</tr></tbody></table>

<br>
<div align="left">
  	<span style='font-family: Arial; font-size: 14pt; font-style: normal;font-weight: bold;'>
	{assign var="variable_lang" value=$print_language_prefix|cat:"_doc_print::Рахунок на оплату №"}
	{assign var="variable_lang2" value=$print_language_prefix|cat:"_doc_print::від"}
    {$oLanguage->GetMessage($variable_lang)} {$aCartPackage.id} {$oLanguage->GetMessage($variable_lang2)} {$oLanguage->GetPostDate($aCartPackage.post_date)}
    </span>
</div>
<br>
<hr color='#000000' size='2px'>

<center>
</center>

<table border="0">
	<tr>
		<td>
			<span style='font-family: Arial; font-size: 10pt; font-style: normal;'>
			{assign var="variable_lang" value=$print_language_prefix|cat:"_doc_print::Recipient_2"}
			{$oLanguage->GetMessage($variable_lang)}:
			</span>
		</td>
		<td>
			<span style='font-family: Arial; font-size: 10pt; font-style: normal;font-weight: bold;'>
			{$aActiveAccount.holder_name},{$aActiveAccount.description}
			</span>
		</td>
	</tr>
	<tr><td style='height: 7pt;' colspan="1">&nbsp;</td></tr>
	<tr>
		<td>
			<span style='font-family: Arial; font-size: 10pt; font-style: normal;'>
			{assign var="variable_lang" value=$print_language_prefix|cat:"_doc_print::Buyer"}
			{$oLanguage->GetMessage($variable_lang)}:
			</span>
		</td>
		<td>
			<span style='font-family: Arial; font-size: 10pt; font-style: normal;font-weight: bold;'>
			{$aCustomer.name}, {$aCustomer.phone}, {$aCustomer.city}, {$aCustomer.address}
			</span>
		</td>
	</tr>
</table>
<br>
<table border="0" width="100%" cellspacing="0" >
	<tr >
    	<td align="center" style='border-top:2px solid #000000;border-left:2px solid #000000;
			border-bottom:1px solid #000000;' >
			<span style='font-family: Arial; font-size: 10pt; font-style: normal;font-weight: bold;'>
			{assign var="variable_lang" value=$print_language_prefix|cat:"_doc_print::№"}
			{$oLanguage->GetMessage($variable_lang)}
			</span>
		</td>
		<td align="center" style='border-top:2px solid #000000;border-left:1px solid #000000;
			border-bottom:1px solid #000000;'>
			<span style='font-family: Arial; font-size: 10pt; font-style: normal;font-weight: bold;'>
			{assign var="variable_lang" value=$print_language_prefix|cat:"_doc_print::Товар"}
			{$oLanguage->GetMessage($variable_lang)}
			</span>
		</td>
		<td align="center" style='border-top:2px solid #000000;border-left:1px solid #000000;
			border-bottom:1px solid #000000;'>
			<span style='font-family: Arial; font-size: 10pt; font-style: normal;font-weight: bold;'>
			{assign var="variable_lang" value=$print_language_prefix|cat:"_doc_print::Бренд"}
			{$oLanguage->GetMessage($variable_lang)}
		</td>
		<td align="center" style='border-top:2px solid #000000;border-left:1px solid #000000;
			border-bottom:1px solid #000000;'>
			<span style='font-family: Arial; font-size: 10pt; font-style: normal;font-weight: bold;'>
			{assign var="variable_lang" value=$print_language_prefix|cat:"_doc_print::№ кат."}
			{$oLanguage->GetMessage($variable_lang)}
			</span>
		</td>
		<td align="center" style='border-top:2px solid #000000;border-left:1px solid #000000;
			border-bottom:1px solid #000000;'>
			<span style='font-family: Arial; font-size: 10pt; font-style: normal;font-weight: bold;'>
			{assign var="variable_lang" value=$print_language_prefix|cat:"_doc_print::Кол-во"}
			{$oLanguage->GetMessage($variable_lang)}
			</span>
		</td>
		<td align="center" style='border-top:2px solid #000000;border-left:1px solid #000000;
			border-bottom:1px solid #000000;'>
			<span style='font-family: Arial; font-size: 10pt; font-style: normal;font-weight: bold;'>
			{assign var="variable_lang" value=$print_language_prefix|cat:"_doc_print::Ед."}
			{$oLanguage->GetMessage($variable_lang)}
			</span>
		</td>
		<td align="center" style='border-top:2px solid #000000;border-left:1px solid #000000;
			border-bottom:1px solid #000000;'>
			<span style='font-family: Arial; font-size: 10pt; font-style: normal;font-weight: bold;'>
			{assign var="variable_lang" value=$print_language_prefix|cat:"_doc_print::Цена"}
			{$oLanguage->GetMessage($variable_lang)}
			</span>
		</td>
		<td align="center" style='border-top:2px solid #000000;border-left:1px solid #000000;
			border-bottom:1px solid #000000;border-right:2px solid #000000;'>
			<span style='font-family: Arial; font-size: 10pt; font-style: normal;font-weight: bold;'>
			{assign var="variable_lang" value=$print_language_prefix|cat:"_doc_print::Сумма"}
			{$oLanguage->GetMessage($variable_lang)}
			</span>
		</td>

		{foreach from=$aUserCart item=aItem key=iKey}
			<tr class="{cycle values="even,none"}">
				<td align="center" style='border-left:2px solid #000000;
					border-bottom:1px solid #000000;'>
					<span style='font-family: Arial; font-size: 8pt; font-style: normal;'>
					{$iKey+1}
					</span>
				</td>
				<td style='border-left:1px solid #000000; border-bottom:1px solid #000000;'>
					<span style='font-family: Arial; font-size: 8pt; font-style: normal;'>
					{$aItem.name_translate}
					</span>
				</td>
				<td style='border-left:1px solid #000000; border-bottom:1px solid #000000;'>
					<span style='font-family: Arial; font-size: 8pt; font-style: normal;'>
					{$aItem.cat_name}{if $aItem.cat_name_changed} => {$aItem.cat_name_changed}{/if}
					</span>
				</td>
				<td style='border-left:1px solid #000000; border-bottom:1px solid #000000;'>
					<span style='font-family: Arial; font-size: 8pt; font-style: normal;'>
					{if $aItem.code_visible} {$aItem.code} {if $aItem.code_changed}=> {$aItem.code_changed}{/if}{else}<i>{$oLanguage->getMessage("cart_invisible")}</i>{/if}
					</span>
				</td>
				<td align="center" style='border-left:1px solid #000000; border-bottom:1px solid #000000;'>
					<span style='font-family: Arial; font-size: 8pt; font-style: normal;'>
					{$aItem.count_fact}
					</span>
				</td>
				<td align="center" style='border-left:1px solid #000000; border-bottom:1px solid #000000;'>
					<span style='font-family: Arial; font-size: 8pt; font-style: normal;'>
					{assign var="variable_lang" value=$print_language_prefix|cat:"_doc_print::шт."}
					{$oLanguage->GetMessage($variable_lang)}
					</span>
				</td>
				<td align="right" style='border-left:1px solid #000000; border-bottom:1px solid #000000;'>
					<span style='font-family: Arial; font-size: 8pt; font-style: normal;'>
					{$oCurrency->PrintPrice($aItem.price_fact,1)}
					</span>
				</td>
				<td align="right" style='border-left:1px solid #000000;
					border-bottom:1px solid #000000;border-right:2px solid #000000;'>
					<span style='font-family: Arial; font-size: 8pt; font-style: normal;'>
					{assign var="price_fact" value=$oCurrency->PrintPrice($aItem.price_fact,1,2,'<none>')}
					{assign var="count_fact" value=$price_fact*$aItem.count_fact}
					{$oCurrency->PrintSymbol($count_fact,1)}
					</span>
				</td>
			</tr>
		{/foreach}
			<tr>
				<td colspan="8" style='border-top:1px solid #000000;'>&nbsp;</td>
			</tr>
	{if $aCartPackage.price_delivery>0}
	<tr>
	    <td colspan="7" align="right" >
	    	<span style='font-family: Arial; font-size: 10pt; font-style: normal;font-weight: bold;'>
			{assign var="variable_lang" value=$print_language_prefix|cat:"_doc_print::Доставка"}
			{$oLanguage->GetMessage($variable_lang)}
	    	</span>
	    </td>
	    <td align="center">
	    	<span style='font-family: Arial; font-size: 10pt; font-style: normal;font-weight: bold;'>
	    	{$oCurrency->PrintPrice($aCartPackage.price_delivery,1)}
	    	</span>
	    </td>
    </tr>
    {/if}
    <tr>
	    <td colspan="7" align="right">
	    	<span style='font-family: Arial; font-size: 10pt; font-style: normal;font-weight: bold;'>
			{assign var="variable_lang" value=$print_language_prefix|cat:"_doc_print::Итого:"}
			{$oLanguage->GetMessage($variable_lang)}
	    	</span>
	    </td>
	    <td align="center">
	    	<span style='font-family: Arial; font-size: 10pt; font-style: normal;font-weight: bold;'>
	    	{$oCurrency->PrintPrice($aCartPackage.summa_fact,1)}
	    	</span>
	    </td>
    </tr>
    <tr>
	    <td colspan="7" align="right">
	    	<span style='font-family: Arial; font-size: 10pt; font-style: normal;font-weight: bold;'>
			{assign var="variable_lang" value=$print_language_prefix|cat:"_doc_print::Без НДС"}
			{$oLanguage->GetMessage($variable_lang)}
	    	</span>
	    </td>
	    <td align="center">&nbsp;</td>
    </tr>
</table>

<span style='font-family: Arial; font-size: 10pt; font-style: normal;'>
{assign var="variable_lang" value=$print_language_prefix|cat:"_doc_print::Всего наименований"}
{assign var="variable_lang2" value=$print_language_prefix|cat:"_doc_print::на сумму"}
{$oLanguage->GetMessage($variable_lang)} {$iKey+1}, {$oLanguage->GetMessage($variable_lang2)} {$oCurrency->PrintPrice($aCartPackage.summa_fact,1)}
</span>
<br>
<span style='font-family: Arial; font-size: 10pt; font-style: normal;font-weight: bold;'>
{$aCartPackage.price_total_string}
</span>
{if $aCartPackage.bonus>0}
<br>
<span style='font-family: Arial; font-size: 10pt; font-style: normal;font-weight: bold;'>
{$oLanguage->GetMessage("bonus")}: {$oCurrency->PrintPrice($aCartPackage.bonus,1)}
</span>{/if}

<br>
<hr color='#000000' size='2px'>

<div style="position: relative; height: 140px;">
	<div style="position: absolute; z-index: 10; font-family: Arial; font-size: 10pt; font-style: normal;">
		<br><br><br>
		{assign var="variable_lang" value=$print_language_prefix|cat:"_doc_print::Руководитель"}
		{$oLanguage->GetMessage($variable_lang)} _______________________ ({$aActiveAccount.holder_sign})
	</div>

		<!--img src="{$aActiveAccount.holder_stamp}" style="position: absolute; z-index: 5; left: 80px; top: 0px;"-->
</div>
	<div style="position: relative; height: 100px;"></div>

</td></tr></tbody></table></center>