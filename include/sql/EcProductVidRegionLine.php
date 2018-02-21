<?
function SqlEcProductVidRegionLineCall($aData)
{
	$sWhere.=$aData['where'];   //лишнее //Обрий 03.12.2016	

	Db::SetWhere($sWhere,$aData,'id_brand_group','big');
	Db::SetWhere($sWhere,$aData,'id_brand','big');
	Db::SetWhere($sWhere,$aData,'id_region','pr');
	Db::SetWhere($sWhere,$aData,'id','pri');
//	Db::SetWhere($sWhere,$aData,'id_vid','piv');
	Db::SetWhere($sWhere,$aData,'id_parent','pri');
	Db::SetWhere($sWhere,$aData,'visible','pri');
	Db::SetWhere($sWhere,$aData,'id_customer_group','pr');
//	$sWhere.=" and pr.id_customer_group='27' ";

	if($aData['id_products']) {
//	    $sWhere.=" and pri.id in ('".$aData['id_products']."') ";
	    $sWhere.=" and pri.id in (".$aData['id_products'].") ";
	}
	if($aData['id_parents']) {
	    $sWhere.=" and p.id in (".$aData['id_parents'].") ";
	}
	if($aData['id_vid']) {
	    $sWhere.=" and (v.id ='".$aData['id_vid']."' or v.id_parent = '".$aData['id_vid']."' ) ";
	}
//	if($aData['vid']) {				//20.12.2016
//	    $sWhere.=" and piv.id_vid in (".$aData['vid'].") ";
//	}
// 	if($aData['choose']) {
// 	    $sWhere.=" and p.id_brand_group = '".$aData['id_brand_group']."'
// 	    and (FIND_IN_SET (p.id_brand, '".$aData['brand_choose']."')>0 or '".$aData['brand_choose']."' = '')
// 	    and (FIND_IN_SET (va.id_anval, '".$aData['choose']."')>0 or '".$aData['choose']."' = '')";
// 	    $sJoin="
// 	        left join ec_val as va on p.id=va.id_product 
// 	        inner join ec_variable vb on vb.id=va.id_variable
// 	    ";
// 		$sHaving=" having count( * )= '".$aData['num_atr']."' ";
// 	}
	if($aData['num_atr']) {
	    $sHaving= " having count( * )= '".$aData['num_atr']."'";
	}
	if($aData['price_min'] && $aData['price_max']) {
	    $sWhere.=" and pr.price >= '".$aData['price_min']."' and pr.price <= '".$aData['price_max']."'";
	}
	
	if($aData['id_group_p']) {
	    $sNow=date("Y-m-d H:i:s");
	    $sField=" ,ch.name as condition_d,concat_ws(' ', gp.name,ch.info) as 'condition',  ch.dt1, ch.dt2,ch.skidka,ch.id_type_skidka, ch.id_group_p";
	    $sJoin.="
	    	inner join ec_products pp on p.id=pp.id_parent
	        inner join ec_condition_d as cd on cd.id_product=pp.id
	        inner join ec_condition_h as ch on cd.id_condition_h=ch.id and (ch.is_all_region=1 or ch.id_region=r.id) and (ch.dt1 < '".$sNow."' and '".$sNow."' < ch.dt2 )
	    		    and (ch.id_customer_group='". $aData['id_customer_group'] ."' or ch.id_customer_group=0)
	        inner join ec_group_p as gp on gp.id=ch.id_group_p and ch.id_group_p='".$aData['id_group_p']."'
	    ";		
	}
	if($aData['id_group_p2']) {
	    $sNow=date("Y-m-d H:i:s");
	    $sField=" ,ch.name as condition_d,concat_ws(' ', gp.name,ch.info) as 'condition',  ch.dt1, ch.dt2,ch.skidka,ch.id_type_skidka, ch.id_group_p";
	    $sJoin.="
	        inner join ec_condition_d as cd on cd.id_product=p.id
	        inner join ec_condition_h as ch on cd.id_condition_h=ch.id and (ch.is_all_region=1 or ch.id_region=r.id) and (ch.dt1 < '".$sNow."' and '".$sNow."' < ch.dt2 )
	    		    and (ch.id_customer_group='". $aData['id_customer_group'] ."' or ch.id_customer_group=0)
	        inner join ec_group_p as gp on gp.id=ch.id_group_p and ch.id_group_p='".$aData['id_group_p2']."'
	    ";			
	}

//скидки клиента и матрици скидок (групповые и канальные) для группы B2B
if ($aData['id_customer_group']=27)
{
	if($aData['user_discount'] && $aData['discounts']>=1) {
		$sField.=" ,round((pr.price*case when di.id is null then (100.00-ifnull(ma.mdiscount,ifnull(ma2.mdiscount,0)))/100.00 else (100.00-di.discount)/100.00 end) /1.2,2)*1.2 as price
		,pr.price as base_price
		,ifnull(di.type_discount,ifnull(ma.type_mdiscount,ifnull(ma2.type_mdiscount,0))) as type_discount
		,ifnull(di.discount,ifnull(ma.mdiscount,ifnull(ma2.mdiscount,0))) as discount
		,case when di.id is null then 1 else 0 end as from_matrica
		,case when di.id is null then (100.00-ifnull(ma.mdiscount,ifnull(ma2.mdiscount,0)))/100.00 else (100.00-di.discount)/100.00 end as kf_discount ";
	    $sJoin.="
	        left join ec_discounts as di on di.id_brand_group=p.id_brand_group and di.id_brand=p.id_brand and di.id_region=r.id and id_user='".$aData['user_discount']."'
			left join ec_matrica   as ma on ma.id_brand_group=p.id_brand_group and ma.id_brand=p.id_brand and ma.id_region=r.id 
									and exists(select * from user_customer uc where uc.id_user='".$aData['user_discount']."' and uc.id_customer_group=ma.id_customer_group and uc.id_user_customer_type=ma.id_user_customer_type) 
			left join ec_matrica as ma2 on ma2.id_brand_group=p.id_brand_group and ma2.id_brand=p.id_brand and ma2.id_region=r.id 
									and exists(select * from user_customer uc where uc.id_user='".$aData['user_discount']."' and uc.id_customer_group=ma2.id_customer_group  and ma2.id_user_customer_type=0) 
	    ";			
	}else
	{	//без скидок или незарег.клиент
		    $sField.=" ,round((pr.price* (100.00-ifnull(ma.mdiscount,ifnull(ma2.mdiscount,0)))/100.00) /1.2,2)*1.2 as price 
			,pr.price as base_price
			,ifnull(ma.type_mdiscount,ifnull(ma2.type_mdiscount,0)) as type_discount
			, 1  as from_matrica
			,ifnull(ma.mdiscount,ifnull(ma2.mdiscount,0)) as discount
			,(100.00-ifnull(ma.mdiscount,ifnull(ma2.mdiscount,0)))/100.00 as kf_discount ";
	    $sJoin.="
			left join ec_matrica   as ma on ma.id_brand_group=p.id_brand_group and ma.id_brand=p.id_brand and ma.id_region=r.id 
									and ( exists(select * from user_customer uc where uc.id_user='".$aData['user_discount']."' and uc.id_customer_group=ma.id_customer_group and uc.id_user_customer_type=ma.id_user_customer_type) /* left 1 - Матрица по группе и каналу сбыта */
									   or '".$aData['user_discount']."'='0' and ma.id_customer_group=27 and ma.id_user_customer_type=0) /*Менеджер смотрит группу B2B - матрица B2B */

			left join ec_matrica as ma2 on ma2.id_brand_group=p.id_brand_group and ma2.id_brand=p.id_brand and ma2.id_region=r.id 
									and ( exists(select * from user_customer uc where uc.id_user='".$aData['user_discount']."' and uc.id_customer_group=ma2.id_customer_group and ma2.id_user_customer_type=0)  /* left 2 - Матрица по группе БЕЗ канала сбыта */
									      or '".$aData['user_discount']."'='' and ma2.id_customer_group=1 and ma2.id_user_customer_type=0) /* Менеджер смотрит группу B2C - матрица B2C */
	    ";								

	}

}



	
	if($aData['order']) {
	    $sOrder=$aData['order'];
	}
	
	if($aData['where']) {
	    $sWhere.=$aData['where'];
	}
	$sSql="select 
	           pri.*,
	           pri.id as id_product,
	           pri.art as code,
	           b.name as cat_name,
	           pri.name as name_translate,
    	       FLOOR(s.stock) as stock,
pr.price,
    	       pr.id_region,
    	     
	           bg.name as brand_group,
	  
	           b.name as brand
	   
	         
	    
	  
	        
	        FROM ec_products pri
            inner join ec_products p on p.id=pri.id_parent 
        
			
	        inner join ec_price as pr on pr.id_product=pri.id
	        inner join ec_stock as s on s.id_product=pri.id
			
	        inner join ec_brand as b on p.id_brand=b.id
	        inner join ec_brand_group as bg on p.id_brand_group=bg.id
	        inner join ec_brand_in_group as big on bg.id=big.id_brand_group and big.id_brand=p.id_brand
	        inner join ec_brand_in_region as bir on bir.id_brand=b.id
			
	        inner join ec_region as r on r.id=pr.id_region and r.id=s.id_region and r.id=bir.id_region
		   	inner join ec_distributor_region as dr on dr.id_region=r.id
	    	inner join ec_distributor as d on d.id=dr.id_distributor and d.id=s.id_distributor
	    
	        left join ec_val as va on p.id=va.id_product 
	        
	  
	    
			where 1=1 
				".$sWhere."
	   
				    
			group by pri.id ".$sHaving.$sOrder;

		//	        inner join ec_stock as s on s.id_region=pr.id_region and s.id_distributor=d.id and s.id_product=pri.id
		//	        left join ec_variable vb on vb.id=va.id_variable

	return $sSql;
}
?>