<FORM id='main_form' action='javascript:void(null);'
      onsubmit="submit_form(this,Array({$sFCKArray}))">

    <table cellspacing=0 cellpadding=2 class=add_form>
        <tr>
            <th>Роли</th>
        </tr>
        <tr>
            <td>

                <table cellspacing=2 cellpadding=1>
                    {foreach key=sFieldName item=sFieldType from=$aMap}
                        {if $sFieldType == 'textarea'}
                            <tr>
                                <td width="100%">{$oLanguage->getDMessage($sFieldName)}:</td>
                                <td><textarea name=data[{$sFieldName}]>{$aData.$sFieldName}</textarea></td>
                            </tr>
                        {elseif $sFieldType == 'editor'}
                            <tr>
                                <td width="100%">{$oLanguage->getDMessage($sFieldName)}:</td>
                                <td>{$oAdmin->getFCKEditor("data_$sFieldName",$aData.$sFieldName)}</td>
                            </tr>
                        {elseif $sFieldType == 'checkbox'}
                            <tr>
                                <td width="100%">{$oLanguage->getDMessage($sFieldName)}:</td>
                                <td>
                                    {include file='addon/mpanel2/form_checkbox.tpl' sFieldName=$sFieldName bChecked=$aData.$sFieldName}
                                </td>
                            </tr>
                        {else}
                            <tr>
                                <td width="100%">{$oLanguage->getDMessage($sFieldName)}:</td>
                                <td><input name=data[{$sFieldName}] value="{$aData.$sFieldName|escape}"></td>
                            </tr>
                        {/if}
                    {/foreach}
                </table>

            </td>
        </tr>
    </table>

    <input type="hidden" name=data[i] value="{$aData.i|escape}">

    <input type="hidden" name=table_name value="{$sTableName}">

    {include file='addon/mpanel2/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>
