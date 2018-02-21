<?
function SqlCatalogPriceCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['sId'])
		$sWhere .= ' and p.id = '.$aData['sId'];
	
	if(!$aData['aCode']) $aData['aCode']=array();
	$inCode = "'".implode("','",$aData['aCode'])."'";

	if(!$aData['aItemCode']) $aData['aItemCode']=array();
	$inItemCode = "'".implode("','",$aData['aItemCode'])."'";

	if (!$aData["customer_discount"]) $aData["customer_discount"]=0;

	if (!$aData['aCode'])
	{
		if (strpos($aData['aItemCode'][0],"ZZZ_")!==false) {
			$sField.=" , 0 as code_visible";
			$sWhere.=" and p.id='".str_replace("ZZZ_","",$aData['aItemCode'][0])."'";
		} else {
			if ($aData['childs']){
				//level 0
				$sInParam=" and pgs.id_price_group in (";
				foreach ($aData['childs'] as $sKey => $aValue){
					$sInParam.=$aValue['id'];
					if (next($aData['childs'])) $sInParam.=",";
				}
				if(isset($aData['id_price_group'])) $sInParam.=",".$aData['id_price_group'];
				$sWhere.=$sInParam.")";
			}
			else {
				//level 1
				if (isset($aData['id_price_group']) || $aData['all_price_group']) {
					if (!$aData['all_price_group']){
						if ($aData['id_price_group'] == 0)
							$sWhere.=" and pgs.id_price_group is null";
						else
							$sWhere.=" and pgs.id_price_group='".$aData['id_price_group']."'";
					}
				} elseif ($inItemCode !="''") {
					$sWhere.=" and p.item_code in (".$inItemCode.")";
				}
				elseif (!$aData['is_not_check_item_code'])
					$sWhere .= ' and 0=1';
			}
		}




	} else {
		if ($aData['is_advance'] && $aData['pref'] && $aData['aCode']) {
			$sWhere.=" and p.item_code like '".$aData['pref']."\_%".$aData['aCode'][0]."%' and p.price>0";
			$sGroup.=" group by p.item_code ";
		} elseif ($inItemCode != "''") {
			$sWhere.=" and (p.code in (".$inCode.") or p.item_code in (".$inItemCode."))";
		}
		else
			$sWhere.=" and p.code in (".$inCode.")";
	}

	if ($aData['id_provider'])
	{
		$sWhere.=" and p.id_provider=".$aData['id_provider'];
	}

	//$dTax=Base::GetConstant("price:tax",0)/100;
	//$dDiscountDefault=Base::GetConstant("price:discount_default",0)/100;
	$dMarginMin=String::GetDecimal(Base::GetConstant("price:margin_min",1));
	if (!$dCatMargin) $dCatMargin=0;

	$iNotChangeRecalc = 0;
	if ($aData['not_change_recalc'])
		$iNotChangeRecalc = $aData['not_change_recalc'];
		
	if (Auth::$aUser['type_'] == 'manager' && $iNotChangeRecalc == 0) {
		$aData["customer_discount"] = 0;
		$aCustomer = Auth::$aUser;
		$aCustomer['type_'] = 'customer';
		$aCustomer['discount_static'] = 0;
		$aCustomer['discount_dynamic'] = 0;
		$aCustomer['group_discount'] = 0;
		if (Auth::$aUser['type_price'] == 'group' || Auth::$aUser['type_price'] == 'none') {
			$aGroup = Db::GetRow(Base::GetSql('CustomerGroup',array('id'=>Auth::$aUser['id_type_price_group'])));
			if (!$aGroup) {
				Auth::$aUser['id_type_price_group'] = Language::getConstant('IdDefaultPriceGroupManager',1);
				$aGroup = Db::GetRow(Base::GetSql('CustomerGroup',array('id'=>Auth::$aUser['id_type_price_group'])));
			}
			if ($aGroup)
					$aCustomer['group_discount'] = $aGroup['group_discount'];
		}
		elseif (Auth::$aUser['type_price'] == 'user' && Auth::$aUser['id_type_price_user']) {
			$aUser = Base::$db->GetRow( Base::GetSql('Customer',array('id'=>Auth::$aUser['id_type_price_user'])));
			if ($aUser)
				$aCustomer = $aUser;
		}
		$aData['customer_discount'] = Discount::CustomerDiscount($aCustomer);
	}
	
	$sPriceCalc="p.price/cu.value*(1+pg.group_margin/100+".$dCatMargin.")*(100-".$aData["customer_discount"].")/100";
	$sPriceMinCalc="(p.price/cu.value)*".$dMarginMin;
	$sFieldPrice=", round(if(".$sPriceCalc.">".$sPriceMinCalc.",".$sPriceCalc.", ".$sPriceMinCalc."),2) as price";


	$sField.=$sFieldPrice.$sFieldPrice."_order ";

	//	if ($aData['id_part'])
	//	{
	//		$dCatMargin=Db::GetOne("select margin/100 from cat_group_margin where id=".$aData['id_part']);
	//	}
	//	else
	//	{
	//		$dCatMargin=Db::GetOne("select cgm.margin/100
	//								from ".DB_TOF."tof__link_la_typ_view as lltv
	//								join ".DB_TOF."tof__link_ga_str as lgs on lltv.lat_ga_id=lgs.lgs_ga_id
	//								join cat_group_margin as cgm on lgs.lgs_str_id=cgm.id
	//								where lltv.art_article_nr in (".$inCode.") and cgm.margin>0
	//								");
	//	}


	//$sField.=", p.price+p.price*".($aData["customer_margin"]+$aData['dPublicMinMargin'])."/100 as price";

	if ($aData['sId']!="" || (Base::GetConstant("global:hide_code",1) && !Auth::$aUser['id'])) {
		$sField.=" , if(p.code in (".$inCode."),p.code, INSERT(ifnull(cp.code, p.code), 2, 20, '***')) as code
		, if(p.code in (".$inCode."),p.item_code,concat('ZZZ_',p.id)) as item_code
		, if(p.code in (".$inCode."),concat(p.item_code,'::',up.id_user),concat('ZZZ_',p.id,'::',up.id_user)) as code_provider
		, if(p.code in (".$inCode."),0,1) as hide_code";
	} else {
		$sField.=" , p.code as code, concat(p.item_code,'::',up.id_user) as code_provider";
	}

	if (!$aData['sCode']) {
		$aData['sCode']=0;
	}

	if ($aData['pref']) {
		if( $aData['pgpf']){
			$sWhere.=" and p.pref='".$aData['pref']."'";
		}
		else {
			$sWhere.=" and p.item_code like '".$aData['pref']."\\_%'";
		}
	}

	if ($aData['term_to']) {
		$sWhere.=" and pg.term_to<=".$aData['term_to'];
	}

	if ($aData['group_pref']) {
		$sGroup.=" group by p.pref ";
	}

	if ($aData['pref_order']) {
		$sField.=" , if(p.pref='".$aData['pref_order']."',0,1) as pref_order ";
	} else {
		$sField.=" , 0 as pref_order ";
	}

	if ($aData['code_order']) {
		$sField.=" , if(p.code='".$aData['code_order']."',0,1) as code_order ";
	} else {
		$sField.=" , 0 as code_order ";
	}

	if ($aData['order']) {
		$sOrder=" order by ".$aData['order']." ";
	}

	if ($aData['sort_stock_filtered'])
		$sOrder = " ,if ((CONVERT(replace(replace(replace(replace(replace(replace(replace(replace(p.stock,'>',''),'+',''),'++',''),'+++',''),'есть','1'),'X',''),'XX',''),'XXX',''), SIGNED)) > 0,1,0) desc " . $sOrder;

	if ($aData['stock_exist']) {
		$sWhere .=" and CONVERT(replace(replace(replace(replace(replace(replace(replace(replace(p.stock,'>',''),'+',''),'++',''),'+++',''),'есть','1'),'X',''),'XX',''),'XXX',''), SIGNED) > 0 ";
	}
	
	$sSql="select p.*, p.price as price_original
	 , c.title as make , c.name as cat_name, c.id_tof as id_brand, c.title as brand, c.image as image_logo
	 , concat(ifnull(cp.name,''),' ',ifnull(p.part_eng,'')) as name
	 , coalesce(cp.name_rus,p.part_rus,'') as name_translate, ifnull(cp.id, '') as id_cat_part
	 , p.code as code_, p.item_code as item_code_
	 , concat(ifnull(cp.information, ''), ' ', ifnull(p.description,'')) as information
	 , ifnull(concat('ZZZ_',p.id),'') as zzz_code
	 , if(p.code in (".$aData['sCode']."),0,1) as crsord
	 , up.name as provider, up.name as provider_name, up.code_name as provider_code_name, up.code_delivery, up.is_our_store
	 , up.term as term_day, up.id_currency, cu.code as code_currency
	 , ifnull(prg.name,'') as price_group_name
	 , ifnull(prg.code_name,'') as price_group_code_name
	 , CONVERT(replace(replace(replace(replace(replace(replace(replace(replace(p.stock,'>',''),'+',''),'++',''),'+++',''),'есть','1'),'X',''),'XX',''),'XXX',''), SIGNED) as stock_filtered	 		
	 "
	.$sField.
	" from price as p
	 left join price_group_assign as pgs on pgs.item_code=p.item_code
	 left join cat_part as cp on cp.item_code=p.item_code
	 inner join cat as c on p.pref=c.pref and c.visible=1
	 inner join provider_virtual as pv on p.id_provider=pv.id_provider
	 inner join user_provider as up on pv.id_provider_virtual=up.id_user
	 inner join provider_group as pg on up.id_provider_group=pg.id
	 inner join user as u on up.id_user=u.id and u.visible=1
	 inner join currency as cu FORCE INDEX (PRIMARY) on up.id_currency=cu.id 
	 left join price_group prg on prg.id=pgs.id_price_group
	 where 1=1
	 ".$sWhere
	.$sGroup
	.$sOrder
	;

	return $sSql;
}
?>
