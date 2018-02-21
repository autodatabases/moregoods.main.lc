{if $aCustomer}
<br>{$oLanguage->getMessage("Customer Name")}: {$aCustomer.name}
<br>{$oLanguage->getMessage("Customer group name")}: {$aCustomer.customer_group_name}
<hr width="60%" align="left" />
<table style="border:2px solid #FF0000;" width="60%"><tr><td>
{$oLanguage->getMessage("cash account")}: {$oCurrency->PrintPrice($aCustomer.buh_balance)}<br>
{$oLanguage->getMessage("debt on orders")}: {$oCurrency->PrintPrice($aCustomer.debt_order)}<br>
{$oLanguage->getMessage("fund balance")}: {$oCurrency->PrintPrice($aCustomer.fund_balance)}
</td></tr></table>
{/if}