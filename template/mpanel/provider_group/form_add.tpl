<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('Provider Group')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<!--tr>
   <td width=50%>{$oLanguage->getDMessage('Type')}:{$sZir}</td>
   <td><input type=text name=data[id_provider_group_type] value="{$aData.id_provider_group_type|escape}"></td>
</tr-->

<tr>
   <td width=50%>{$oLanguage->getDMessage('Code')}:{$sZir}</td>
   <td><input type=text name=data[code] value="{$aData.code|escape}"></td>
</tr>

<tr>
   <td width=50%>{$oLanguage->getDMessage('Name')}:{$sZir}</td>
   <td><input type=text name=data[name] value="{$aData.name|escape}"></td>
</tr>

<tr>
   <td width=50%>{$oLanguage->getDMessage('Group Margin')}:{$sZir}</td>
   <td><input type=text name=data[group_margin] value="{$aData.group_margin|escape}"></td>
</tr>

<!--tr>
   <td width=50%>{$oLanguage->getDMessage('Group Discount')}:{$sZir}</td>
   <td><input type=text name=data[group_discount] value="{$aData.group_discount|escape}"></td>
</tr-->

<!--tr>
   <td width=50%>{$oLanguage->getDMessage('Opt Margin')}:</td>
   <td><input type=text name=data[opt_margin] value="{$aData.opt_margin|escape}"></td>
</tr-->
<!--tr>
   <td width=50%>{$oLanguage->getDMessage('Group Term')}:</td>
   <td><input type=text name=data[group_term] value="{$aData.group_term|escape}"></td>
</tr-->

<!--tr>
   <td width=50%>{$oLanguage->getDMessage('Term From')}:</td>
   <td><input type=text name=data[term_from] value="{$aData.term_from|escape}"></td>
</tr>

<tr>
   <td width=50%>{$oLanguage->getDMessage('Term To')}:</td>
   <td><input type=text name=data[term_to] value="{$aData.term_to|escape}"></td>
</tr-->

<tr>
   <td width=50%>{$oLanguage->getDMessage('Description')}:</td>
   <td><textarea name=data[description]>{$aData.description}</textarea></td>
</tr>

{include file='addon/mpanel/form_visible.tpl' aData=$aData}

</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">

{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>