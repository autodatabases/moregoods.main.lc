<?
function SqlCartPackageCall($aData)
{
	$dTax=Base::GetConstant("price:tax", 19.6)/100;
	$sWhere.=$aData['where'];
	$sJoin.=$aData['join'];

	if ($aData['id'] && is_array($aData['id'])) {
		$sWhere.=" and cp.id in (".implode(",",$aData['id']).")";
	} elseif ($aData['id']) {
		$sWhere.=" and cp.id='".$aData['id']."'";
	}

	if ($aData['order_status'])
	{
		$sWhere.=" and cp.order_status='".$aData['order_status']."'";
	}

	if ($aData['id_user'])
	{
		$sWhere.=" and cp.id_user='".$aData['id_user']."'";
	}

	$sSql="select u.type_, u.login, u.email
			, uc.*, ad.addresses as delivery_point
			, m.login as manager_login, cp.name_manager as id_autor
			, cp.*, round((cp.price_total-cp.price_delivery)/(1+".$dTax."),2) as price_total_without_ttc
			, round(cp.price_total-cp.price_delivery-(cp.price_total-cp.price_delivery)/(1+".$dTax."),2) as price_ttc
			, round(cp.price_total-cp.price_delivery,2) as price_cart_ttc
			, round(".$dTax."*100,2) as tax
			, ".DateFormat::GetSqlDate("cp.post_date")." as date_bill
			, uc.zip, uc.address, uc.city, uc.phone, uc.phone2, uc.name
			, c.zip as user_contact_zip, c.address as user_contact_address, c.city as user_contact_city
			, c.phone as user_contact_phone, c.phone2 as user_contact_phone2, c.name as user_contact_name
			, concat(ifnull(concat(oc.name,' '),'')
				,ifnull(concat(c.street,' '),'')
				, ifnull(concat(c.house,' '),'')
				, ifnull(concat(c.apartment,' '),'')
				, ifnull(concat(c.office,' '),'')
			) as address_delivery
			,pt.name as payment_type_name
			,dt.name as delivery_type_name
			,et.name as time_delivery
			,cg.name as customer_group_name
			from cart_package cp
			inner join user as u on cp.id_user=u.id
			inner join user_customer as uc on u.id=uc.id_user
			inner join user m on uc.id_manager=m.id
			inner join ec_time et on et.id=cp.id_time 
			inner join customer_group cg on cg.id=uc.id_customer_group
			left join ec_addres as ad on cp.id_user=ad.id_user and cp.id_addres=ad.id
			left join user_contact as c on cp.id_user_contact=c.id
			left join office_city as oc on c.id_city=oc.id
			left join payment_type as pt on cp.id_payment_type=pt.id
			left join delivery_type as dt on cp.id_delivery_type=dt.id
				".$sJoin."
			where 1=1
				".$sWhere."
			group by cp.id";

	return $sSql;
}
?>
