<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">
<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('Customer group')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
  <tr>
   <td width=50%>{$oLanguage->getDMessage('Name')}:</td>
   <td><input type=text name=data[name] value='{$aData.cg_name}' ></td>
  </tr>
  <tr>
   <td>{$oLanguage->getDMessage('Group Discount (%)')}{$sZir}:</td>
   <td><input type=text name=data[group_discount] value='{if $aData.group_discount}{$aData.group_discount}{else}0{/if}'></td>
  </tr>
  <!--tr>
   <td>{$oLanguage->getDMessage('Group Debt ($)')}{$sZir}:</td>
   <td><input type=text name=data[group_debt]
		value='{if $aData.group_debt}{$aData.group_debt}{else}0{/if}'></td>
  </tr>
  <tr>
   <td>{$oLanguage->getDMessage('Group Debt (%)')}{$sZir}:</td>
   <td><input type=text name=data[group_debt_percent]
		value='{if $aData.group_debt_percent}{$aData.group_debt_percent}{else}0{/if}'></td>
  </tr-->
  <tr>
   <td>{$oLanguage->getDMessage('Description')}:</td>
   <td>{$oAdmin->getCKEditor('data[description]',$aData.description, 650, 300)}</td>
  </tr>
  <tr>
   <td>{$oLanguage->getDMessage('Price rount')}:</td>
   <td><input type=text name=data[price_round] value='{$aData.price_round}'></td>
  </tr>
  <tr>
   <td>{$oLanguage->getDMessage('Hours expired cart')}:</td>
   <td><input type=text name=data[hours_expired_cart] value='{if $aData.hours_expired_cart}{$aData.hours_expired_cart}
   		{else}{$oLanguage->getConstant('customer_cart_expired_default','24')}{/if}'></td>
  </tr>
  <!--tr>
   <td>{$oLanguage->getDMessage('Debt Day Number')}:</td>
   <td><input type=text name=data[debt_day_number] value='{$aData.debt_day_number}'></td>
  </tr-->
  {include file='addon/mpanel/form_visible.tpl' aData=$aData}


  </table>
</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
<input type=hidden name=data[user_id] value="{$aData.id_user|escape}">

{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}
</FORM>