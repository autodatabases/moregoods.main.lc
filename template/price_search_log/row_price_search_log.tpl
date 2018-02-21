<td>{$aRow.brand}</td>
<td>{$aRow.code}</td>
<td>{$aRow.post_date}</td>
<td><a href="{if $aRow.id_product}/?action=catalog_product&product={$aRow.id_product}{else}/?action=catalog_price_view&code={$aRow.code}{/if}">
{$oLanguage->getMessage('View')}</a></td>
