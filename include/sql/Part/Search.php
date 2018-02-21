<?
function SqlPartSearchCall($aData) {

	$sWhere=$aData['where'];
	$dTax=Base::GetConstant("price:tax", 19.6)/100;

	Db::SetWhere($sWhere,$aData,'id','c');
	Db::SetWhere($sWhere,$aData,'id_cart','c','id');
	//Db::SetWhere($sWhere,$aData,'id_cart_package','c');
	if ($aData['id_provider_ordered']) {
		$sWhere.=" and c.id_provider_ordered=".$aData['id_provider_ordered'];
	} else {
		Db::SetWhere($sWhere,$aData,'id_provider','c');
	}

	Db::SetWhere($sWhere,$aData,'number','c');
	Db::SetWhere($sWhere,$aData,'pref','c');
	Db::SetWhere($sWhere,$aData,'login','u');
	Db::SetWhere($sWhere,$aData,'id_provider_region_way','pr');
	Db::SetWhere($sWhere,$aData,'id_cart_store','csc');


	if ($aData['id_cart_package']) {
		$sWhere.=" and id_cart_package in (".$aData['id_cart_package'].")";
	}

	if ($aData["cart_notconfirm"])
	{
		$sWhere.=" and ifnull(csc.id,'')=''";
	}

	if ($aData["id_user_manager"])
	{
		$aData['cart_log_join']=1;
		if ($aData['order_status_type']=='whose') {
			$sTableField='uc.id_manager';
		} else {
			$sTableField='cl.id_user_manager';
		}
		$sWhere.=" and ".$sTableField."='".$aData["id_user_manager"]."'";
	}

	if ($aData['code'])
	{
		if ($aData['inReplacement'])
		{
			$sWhere.=" and c.code in ('".$aData['code']."',".$aData['inReplacement'].")";
		}
		else
		{
			$sWhere.=" and '".$aData['code']."' in (c.code,c.code_changed) ";
		}
	}

	if ($aData['uc_name']) {
		$sWhere.=" and (u.login='".$aData['uc_name']."'
		or uc.name like '".$aData['uc_name']."%'
		)
		";
	}

	if ($aData['cart_log_join']) {
		$sJoin.=" left join cart_log as cl on (cl.id_cart=c.id and cl.order_status=c.order_status) ";
	}

	if ($aData['type_']!='cart') {
		$sWhere.=" and c.type_='order'";
		//		if ($aData['is_confirm']) {
		//			$sWhere.=" and cp.is_confirm=1";
		//		}
		$sJoin.=" inner join cart_package as cp on cp.id=c.id_cart_package";
		$sField.=" , cp.* , ".Db::GetDateFormat('cp.post_date',"%d.%m %H:%m")." as cp_post_date_f
				, (c.term - datediff(now(), cp.post_date)) as term_last ";
		if ($aData['cp_date_from']) {
			$sWhere.=" and cp.post_date>=".Db::GetStrToDate($aData['cp_date_from']);
		}

		if ($aData['cp_date_to']) {
			$sWhere.=" and cp.post_date<=".Db::GetStrToDate($aData['cp_date_to'])." +interval 1 day - interval 1 second";
		}

	} else {
		$sWhere.=" and c.type_='cart'";
	}

	if ($aData['date_from']) {
		$sWhere.=" and c.post_date>=".Db::GetStrToDate($aData['date_from']);
	}

	if ($aData['date_to']) {
		$sWhere.=" and c.post_date<=".Db::GetStrToDate($aData['date_to'])." +interval 1 day - interval 1 second";
	}

	if ($aData['is_buh_balance']) {
		$sField.=", ifnull(bem.amount_credit_end-bem.amount_debit_end,0) as buh_balance";
		$sCurrentPeriod=Base::GetConstant("buh:current_period");
		$sJoin.=" left join buh_entry_month as bem on bem.date_month='".$sCurrentPeriod."'
			and bem.id_buh=361 and u.id=bem.id_buh_subconto1 ";
	}

	$sSql="select cg.*,ua.*, u.*,uc.*, uc.name as customer_name, ecp.image
				".$sField."
				, c.*, c.price/(1+".$dTax.") as price_without_ttc
				, c.price_original*c.number as total_original
				, c.price*c.number-c.price_original*c.number as total_profit
				, c.price*c.number as total
				, m.login as manager_login
				, c.name_translate
				, uc.name as customer_name, uc.manager_comment as customer_manager_comment
				, cat_changed.title as cat_name_changed
			 from cart c
			 inner join user as u on c.id_user=u.id
			 left join user_customer as  uc on uc.id_user=u.id
			 left join customer_group as  cg on uc.id_customer_group=cg.id
			 left join user as m on uc.id_manager=m.id
			 left join user_account as ua on ua.id_user=u.id
			 left join ec_products as ecp on ecp.id=c.id_product


			 left join user_customer as ucp on uc.id_parent=ucp.id_user
			 left join cat as cat_changed on cat_changed.pref=c.pref_changed
			".$sJoin."
			where 1=1
			".$sWhere."
			group by c.id ";

	return $sSql;


	//	, pr.name as pr_name, prw.name as prw_name, prw.code as prw_code
	//
	//	inner join provider_region as pr on pr.id=up.id_provider_region
	//	inner join provider_region_way as  prw on prw.id=pr.id_provider_region_way

}
?>