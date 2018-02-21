<?
/**
 * @author Aleksandr Starovoyt
 */
class Catalog extends Base
{
	var $sPrefix="catalog";
	var $sPref;
	var $aCode=array();
	var $aCodeCross=array();
	var $aItemCodeCross=array();
	var $aExt=array(1=>"bmp", 2=>'pdf', 3=>'jpg', 4=>'jpg', 5=>'png');
	var $sPathToFile="/imgbank/";
	var $bShowSeparator=true;
	
	var $aCat=array();
	var $aCats=array();
	var $aModel=array();
	var $aModelDetail=array();
	var $id_customer_group = array();
	
	var $iIdRegion;
	//-----------------------------------------------------------------------------------------------
	public function __construct()
	{
		Base::$bRightSectionVisible=true;
		Base::$bXajaxPresent=true;
		
		if(Base::$aRequest['table']) 
			$_SESSION['table']=Base::$aRequest['table'];
		if(!Base::$aRequest['table'] && $_SESSION['table'])
			Base::$aRequest['table'] = $_SESSION['table'];
		if($_SESSION['table'])	
		$_REQUEST['table']=$_SESSION['table'];

		if (Auth::$aUser['id'] && Auth::$aUser['type_']=='customer')
		{
		    $sSql ="select id_customer_group from user_customer where id_user='".Auth::$aUser['id']."'";
		    $iCustomerGroup = Db::getOne($sSql);
		    $this->id_customer_group = $iCustomerGroup;
		}elseif (Auth::$aUser['id'] && Auth::$aUser['type_']=='manager')
	    {
	        $sSql ="select id_customer_group from user_manager where id_user='".Auth::$aUser['id']."'";
	        $iCustomerGroup = Db::getOne($sSql);
	        $this->id_customer_group = $iCustomerGroup;
	    }
		else
		{
		    $iCustomerGroup =1;
		    $this->id_customer_group = $iCustomerGroup;
		}
		$sCityByIp=Base::$oContent->GetSelectedCity();
		
		if(Auth::$aUser['id_region']){
		    $this->iIdRegion=Auth::$aUser['id_region'];
		}
		elseif($_SESSION['selected_city'] && !Auth::$aUser['id_region']){
		    $sOblasRegion=Db::GetOne("select ec_region from net_city where id='".$sCityByIp."'");
		    $this->iIdRegion=$sOblasRegion;
		}
		else{
		    $sOblasRegion=Db::GetOne("select ec_region from net_city where id='".$sCityByIp."'");
		    $this->iIdRegion=$sOblasRegion;
		}
		
		//Debug::PrintPre($_SESSION);
//		Base::$tpl->assign('aCatalog', Db::GetAll(Base::GetSql("Cat",array(
//    		'is_brand'=>1,
//    		'visible'=>1,
//		    'id_region'=>$this->iIdRegion,
//		))));

		$this->SortTable();

		if(Base::$aRequest['debug']) {
		    Db::Debug();
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		Base::$oContent->AddCrumb(Language::GetMessage('Catalog product'),'');

		/*$oTable=new Table();
		$oTable->iRowPerPage=100;
		$oTable->sSql = Base::GetSql("EcBrandGroup");
		$oTable->aOrdered=" order by name ";
		$oTable->sNoItem='No items';
		$oTable->aColumn['item']=array('sTitle'=>'Name','sWidth'=>'20%');
		$oTable->sDataTemplate = "catalog/row_index.tpl";
		Base::$sText.=$oTable->getTable("Choose group");
		*/
	}
	//-----------------------------------------------------------------------------------------------
	public function Promo()
	{
		$sPromoNm = Db::GetOne('select short_name from ec_group_p where id='.Base::$aRequest['promo']);
		
//		$aPage['name']=$aSelectedGroup['name'];
//		$aPage['name'].='  -  '.$sPromoNm;

		$aPage['name']=$sPromoNm;
		
//		Base::$tpl->assign('aPage',$aPage);
		
		 
		
		
//		Base::$oContent->AddCrumb($aSelectedGroup['name'],'');
//		$iIdRegion=1;
//		$iCustomerGroup=1;
		
	    if(Base::$aRequest['testsql'] == '1'){
	        Db::Debug();
	    }
	    if (Auth::$aUser['id'] && Auth::$aUser['type_']=='customer')
	    {
	        $sSql ="select id_customer_group from user_customer where id_user='".Auth::$aUser['id']."'";
	        $iCustomerGroup = Db::getOne($sSql);
	        $this->id_customer_group = $iCustomerGroup;
	    }
	    elseif (Auth::$aUser['id'] && Auth::$aUser['type_']=='manager')
	    {
	        $sSql ="select id_customer_group from user_manager where id_user='".Auth::$aUser['id']."'";
	        $iCustomerGroup = Db::getOne($sSql);
	        $this->id_customer_group = $iCustomerGroup;
	    }else
	    {
	        $iCustomerGroup =1;
	        $this->id_customer_group = $iCustomerGroup;
	    }
	    
	    if ($_SESSION['user'] && !$this->iCustomerGroup) {
	    	$this->iCustomerGroup=$_SESSION['user']['id_customer_group'];
	    }
	    if ($_SESSION['user'] && !$this->iIdRegion) {
	    	$this->iIdRegion=$_SESSION['user']['id_region'];
	    }
	     
	    if(!$this->iCustomerGroup)	$this->iCustomerGroup =1;
	    if(!$this->iIdRegion)	$this->iIdRegion=1;
	     
	    if($iCustomerGroup==1 || $iCustomerGroup==30)
	    	$iB2C_Interface=1;
	    	
	    $sClassBrand = Db::GetOne('select class from ec_brand_group where id='.Base::$aRequest['group']);
	    Base::$tpl->assign('sClassBrand',$sClassBrand);
	    
	    $aSelectedGroup=Db::GetRow(Base::GetSql('EcBrandGroup',array(
	        'id'=>Base::$aRequest['group']
	    )));
	    
	    if(Base::$aRequest['brand'])
	    $aSelectedBrand=Db::GetRow(Base::GetSql("EcBrand",array(
	        'id'=>Base::$aRequest['brand']
	    )));
	    
			if(Base::$aRequest['set_vid']){
				Base::$aRequest['vid']=Base::$aRequest['set_vid'];	    
				$aSelectedVid=Db::GetRow(Base::GetSql("EcVid",array(
	    			'id'=>Base::$aRequest['set_vid']
	    			)));	    			
			}
			elseif(Base::$aRequest['vid'])
				$aSelectedVid=Db::GetRow(Base::GetSql("EcVid",array(
				'id'=>Base::$aRequest['vid']
					)));
//	    09.12.2016
/*
		if(Base::$aRequest['group'])
	    $aPage['name']=$aSelectedGroup['name'];*/
	    if(Base::$aRequest['brand'])
	    $aPage['brand']=$aSelectedBrand['name'];
	     
/*		    	    
	    if(Base::$aRequest['set_vid'] || Base::$aRequest['vid'])    // && $iB2C_Interface==1)
	    $aPage['name']=$aSelectedVid['name'];*/
	    if(Base::$aRequest['promo']){
			$aPage['promo']=$sPromoNm;
		}

	    Base::$tpl->assign('aPage',$aPage);
	     
	     
	    
	     
	     
	    
	    /*
	    if(Base::$aRequest['action']=='catalog_vid' && Base::$aRequest['group'] && !Base::$aRequest['brand'] && !Base::$aRequest['vid']){
	        $aPage['name']=$aSelectedGroup['name'];
	        Base::$tpl->assign('aPage',$aPage);
	    }
	    else {
	    $aPage['name']=$aSelectedVid['name'];
	    Base::$tpl->assign('aPage',$aPage);
	    }
	    */
	    $sVidName=$aSelectedVid['name'];
	    if($aSelectedVid['id_parent']) {
	        $aSelectedVidParent=Db::GetRow(Base::GetSql("EcVid",array(
    	        'id'=>$aSelectedVid['id_parent']
    	    )));
	        $sVidName=$aSelectedVidParent['name'].' '.$sVidName;
	    }
	    
	    Base::$oContent->AddCrumb($aSelectedGroup['name'],'/?action=catalog_group&group='.$aSelectedGroup['id']);
	    if($aSelectedBrand['name'])
	    	Base::$oContent->AddCrumb($aSelectedBrand['name'],'/?action=catalog_brand&group='.$aSelectedGroup['id'].'&brand='.$aSelectedBrand['id']);
	    if($aSelectedVidParent['name'])
	    	Base::$oContent->AddCrumb($aSelectedVidParent['name'],'/?action=catalog_brand&group='.$aSelectedGroup['id'].'&vid='.$aSelectedVidParent['id']);

		
		
		
		
		
	    if(Base::$aRequest['brand']){
	       $sBrand=" and p.id_brand = ".Base::$aRequest['brand'];
	    }

			if(Base::$aRequest['set_vid']){
				$sVid="and (vi.id = '".Base::$aRequest['set_vid']."' or vi.id_parent ='".Base::$aRequest['set_vid']."')";
				Base::$aRequest['vid']=Base::$aRequest['set_vid'];	    
			}
			elseif(Base::$aRequest['vid']){
				$sVid="and (vi.id = '".Base::$aRequest['vid']."' or vi.id_parent ='".Base::$aRequest['vid']."')";
			}
//Обрий 02.12.2016	    
//	    else 
//	    	if(Base::$aRequest['filter']['vid'])
//	    		{
//					$sChecked_Vids = str_replace("#", "", Base::$aRequest['filter']['vid']);
//	    			$sVid="and piv.id_vid in (".$sChecked_Vids.")";
//	    		}
	    $iTime = time();
	    $sTime = date("Y-m-d H:i:s", $iTime);

	    if (Base::$aRequest['promo']){
	    	$sJoin="
		 	inner join (select distinct pp.id_parent from ec_products as pp 
			inner join ec_condition_d as cd on cd.id_product=pp.id
	        inner join ec_condition_h as ch on cd.id_condition_h=ch.id and (ch.is_all_region=1 or ch.id_region='". $this->iIdRegion ."') and (ch.dt1 < '".$sTime."' and '".$sTime."' < ch.dt2 )
	    			and ch.id_group_p in(2,3) 
	        		and (ch.id_customer_group='".  $this->id_customer_group ."' or ch.id_customer_group=0) and ch.id_group_p='".Base::$aRequest['promo']."'
			) as pp on pp.id_parent=p.id ";
	    			
	    }

	    if (Base::$aRequest['group']==0){
	    
	    	$sAllGroupPromo = "  p.id_brand_group in (select id from ec_brand_group) ";
	    }
	    else {
	    	$sAllGroupPromo = " p.id_brand_group = ".Base::$aRequest['group']." ";
	    }
 			

	    $aAtributeAll=Db::GetAll("select vr.id,vr.variable_nm, p.id_brand, piv.id_vid, p.id_brand_group
        from ec_products p
        inner join ec_val v on v.id_product=p.id
        inner join ec_variable vr on vr.id=v.id_variable and vr.in_filter=1
        inner join ec_antbl a on a.id=vr.id
        inner join ec_anval an on an.id_antbl=a.id and an.id=v.id_anval
        inner join ec_product_in_vid piv on piv.id_product=p.id
	    inner join ec_vid as vi on vi.id=piv.id_vid
	    		
 		".$sJoin."

			where ".$sAllGroupPromo." ".$sBrand." ".$sVid."
	        group by vr.id 
	    		order by vr.sort");		//Обрий 02.12.2016

	    $aTmpChoose = array();
	    
	    foreach ($aAtributeAll as $aKey => $aValue){
	        $sql="select an.anval_nm, p.id_brand, an.id, piv.id_vid, p.id_brand_group, v.id_product, COUNT(p.id) as qty
        from ec_products p
	    inner join ec_price as pr on pr.id_product=p.id
        inner join ec_val v on v.id_product=p.id
        inner join ec_variable vr on vr.id=v.id_variable and vr.in_filter=1
        inner join ec_antbl a on a.id=vr.id
        inner join ec_anval an on an.id_antbl=a.id and an.id=v.id_anval
        inner join ec_product_in_vid piv on piv.id_product=p.id
	    inner join ec_vid as vi on vi.id=piv.id_vid

 		".$sJoin."
	        		
	    where a.id='".$aAtributeAll[$aKey]['id']."' and ".$sAllGroupPromo."
	        ".$sBrand." ".$sVid." and pr.id_customer_group=". $this->id_customer_group ." and pr.id_region=". $this->iIdRegion ."
	        and p.visible=1
	        group by an.id
	        		order by an.anval_nm";	//Обрий 03.12.2016
	        $aAtribute=Db::GetAll($sql);
	         
	        if($aAtribute) foreach ($aAtribute as $sKey => $sValue) {
	            $aTmpChoose=explode(",", Base::$aRequest['choose']);
	             
	            if(in_array($sValue['id'], $aTmpChoose)) {
	                $aAtribute[$sKey]['checked']=1;
	            }
	            
	            foreach ($aTmpChoose as $sKeyChoose => $sValueChoose) {
	                $aChooseReplace=Db::GetRow("select anval_nm, id from ec_anval where id in ('".$sValueChoose."')  ");
	                if($aChooseReplace) $aTmpChoose[$sKeyChoose]=$aChooseReplace;
	            }
	        }
//Обрий 02.12.2016	    
	        if (!$aAtribute) unset($aAtributeAll[$aKey]);
	       else
	        $aAtributeAll[$aKey]['atrib']= $aAtribute;
	    }
	    $sUrl='';
	    $aUrl=array();
	   
	    $sUrl.='/?action=catalog_filter&group='.$aSelectedGroup['id'];
		
		if(Base::$aRequest['promo'] && !Base::$aRequest['remove_promo'])
	        $sUrl.="&promo=".Base::$aRequest['promo'];
	    
		if(Base::$aRequest['brand'] && !Base::$aRequest['remove_brand'])
	        $sUrl.='&brand='.$aSelectedBrand['id'];
	    
			if(Base::$aRequest['set_vid'])        $sUrl.='&vid='.Base::$aRequest['set_vid'];
			elseif(Base::$aRequest['vid'])        $sUrl.='&vid='.$aSelectedVid['id'];
	    
	    if(Base::$aRequest["choose"]) $sUrl.="&choose=".Base::$aRequest["choose"];
//	    if(Base::$aRequest["filter"]["vid"]) $sUrl.="&filter[vid]=".Base::$aRequest["filter"]["vid"];
	    if($aUrl) $sUrl.='&'.implode("&", $aUrl);
	    Base::$tpl->assign('sUrl',$sUrl);
	     
	    Base::$tpl->assign('aAtributeAll',$aAtributeAll);
	    Base::$tpl->assign('aTmpChoose',$aTmpChoose);

		if(!Base::$aRequest['sort'] || Base::$aRequest['sort']=='name'){
			$ParentOrder=" order by (s.stock>=p.min_stock) desc,v.sort,b.sort,p.name";
			$RealOrder=" order by (s.stock>=pri.min_stock) desc,v.sort,b.sort,p.name,pri.name";
		}
		elseif(Base::$aRequest['sort']=='price'){
			if(Base::$aRequest['way']=='up'){
				$ParentOrder=" order by (s.stock>=p.min_stock) desc,pr.price asc";
				$RealOrder=" order by (s.stock>=pri.min_stock) desc,pr.price asc";
			}
			else {
				$ParentOrder=" order by (s.stock>=p.min_stock) desc,pr.price desc";
				$RealOrder=" order by (s.stock>=pri.min_stock) desc,pr.price desc";
			}
		}
		elseif(Base::$aRequest['sort']=='new'){
			$ParentOrder=" order by (s.stock>=p.min_stock) desc,v.sort,b.sort,p.name";
			$RealOrder=" order by (s.stock>=pri.min_stock) desc,v.sort,b.sort,p.name,pri.name";
		}
		else{
			$ParentOrder=" order by (s.stock>=p.min_stock) desc,v.sort,b.sort,p.name";
			$RealOrder=" order by (s.stock>=pri.min_stock) desc,v.sort,b.sort,p.name,pri.name";
		}

	    
// 	    //procedura
// 	    $atrib =  Base::$aRequest['choose'];
// 	    $brand_group =  Base::$aRequest['group'];
	    
// 	    $ProcedTmp=array();
// 	    $link = mysqli_connect('127.0.0.1','obriy','Niin1vTF1xZT65w','obriy','3306');
// 	    $res = mysqli_query($link,"CALL get_filtered_products ('$brand_group','$atrib') ");
// 	    while ($row = mysqli_fetch_assoc($res)) {
// 	       $ProcedTmp[]=$row['id_product'];
// 	    }
// 	    //while($link->next_result()) $link->store_result();
// 	    mysqli_close($link);
	    
// 	    $aChoose=implode(",", $ProcedTmp);

	    //Debug::PrintPre($aChoose);
// 	    $connection = @new mysqli('localhost', 'root', '123456', 'obriy');
// 	    while($connection->next_result()) $connection->store_result();

	    //procedura
	    //filter OBR end
	    	   
	    $Num_Attr_In_Filter = Db::GetOne("select count( * ) from ec_antbl t where exists (select * from ec_anval a
	        where t.id=a.id_antbl and FIND_IN_SET (a.id, '".Base::$aRequest['choose']."')>0) ");


	    if (Auth::$aUser['id'] && Auth::$aUser['type_']=='customer')
	    {
			$User_discount=Auth::$aUser['id'];
			$Discounts=Db::GetOne("select count( * ) from ec_discounts di where id_region='".$this->iIdRegion."' and id_user='".$User_discount."' ");
	    }
	    elseif (Auth::$aUser['id'] && Auth::$aUser['type_']=='manager')
	    {
			$User_discount=Db::GetOne("select id_customer_partner as user_discount from user_manager um where id_user='".Auth::$aUser['id']."' ");
			$Discounts=Db::GetOne("select count( * ) from ec_discounts di where id_region='".$this->iIdRegion."' and id_user='".$User_discount."' ");
	    }
		





		$oTable=new Table();
		$oTable->sType='array';
		if(!Base::$aRequest['table'] || Base::$aRequest['table']!='line')
		$aDataParent=Db::GetAll(Base::GetSql("EcProductVidRegion",array(
				'id_brand_group'=>Base::$aRequest['group'],
				'id_group_p'=>Base::$aRequest['promo'],		//*****
				'id_brand'=>Base::$aRequest['brand'],
				'id_vid'=>Base::$aRequest['vid'],
				'id_region'=>$this->iIdRegion,
				'visible'=>1,
//				'vid'=>Base::$aRequest['filter']['vid'],
				'where'=>" and p.id_parent = 0 and v.visible=1 ",
				'discounts'=>$Discounts,
				'user_discount'=>$User_discount,
				'choose'=>Base::$aRequest['choose'],
				'price_min'=>Base::$aRequest['price_min'],
				'price_max'=>Base::$aRequest['price_max'],
				'num_atr'=>$Num_Attr_In_Filter,
				'id_customer_group' => $this->id_customer_group ,
				'order'=>$ParentOrder		//'order'=>" order by (s.stock>= 5) desc,v.sort,b.sort,p.name"	    	
		)));
		 
				
	    $aVidsFilter=Db::GetAll("select  
	           v.id as id_vid ,
	           v.name,
	           count(id_vid) as qty,
	    		v.sort
	        from ec_products as p
	        inner join ec_product_in_vid as piv on piv.id_product=p.id
	        inner join ec_vid as v on v.id=piv.id_vid
	        inner join ec_brand_in_group as big on big.id_brand=p.id_brand
	        inner join ec_brand_group as bg on bg.id=big.id_brand_group and p.id_brand_group=bg.id
	        inner join ec_brand as b on p.id_brand=b.id

	    
	        inner join ec_price as pr on pr.id_product=p.id
	        inner join ec_region as r on r.id=pr.id_region
	        inner join ec_brand_in_region as bir on bir.id_brand=b.id and bir.id_region=r.id
	        inner join ec_distributor_region as dr on dr.id_region=r.id
	        inner join ec_distributor as d on d.id=dr.id_distributor
	        inner join ec_stock as s on s.id_region=r.id and s.id_distributor=d.id and s.id_product=p.id

	        inner join (select distinct cd.id_product from ec_condition_d as cd 
	        inner join ec_condition_h as ch on cd.id_condition_h=ch.id and (ch.is_all_region=1 or ch.id_region='". $this->iIdRegion ."') and (ch.dt1 < '".$sTime."' and '".$sTime."' < ch.dt2 )
	    			and ch.id_group_p in(2,3) 
	    		and (ch.id_customer_group='".  $this->id_customer_group ."' or ch.id_customer_group=0)
	        and ch.id_group_p='".Base::$aRequest['promo']."'
			) as cd on cd.id_product =p.id
	        where big.id_brand_group = ".Base::$aRequest['group']." and pr.id_customer_group='". $this->id_customer_group ."' and pr.id_region='". $this->iIdRegion ."'
            and (b.id='".Base::$aRequest['brand']."' or '".Base::$aRequest['brand']."'='')
	    	and	(v.id_parent='".$aSelectedVid['id']."' )
	        and p.visible=1 and p.id_parent<>0 and v.visible=1 
	        group by v.id 
	    		
            union all
select  
               vp.id as id_vid,
               vp.name,
	           count(id_vid) as qty,
	    		vp.sort
                
	        from ec_products as p
	        inner join ec_product_in_vid as piv on piv.id_product=p.id
	        inner join ec_vid as v on v.id=piv.id_vid
	        inner join ec_vid as vp on vp.id=v.id_parent
	        inner join ec_brand_in_group as big on big.id_brand=p.id_brand
	        inner join ec_brand_group as bg on bg.id=big.id_brand_group and p.id_brand_group=bg.id
	        inner join ec_brand as b on p.id_brand=b.id

	        inner join ec_price as pr on pr.id_product=p.id
	        inner join ec_region as r on r.id=pr.id_region
	        inner join ec_brand_in_region as bir on bir.id_brand=b.id and bir.id_region=r.id
	        inner join ec_distributor_region as dr on dr.id_region=r.id
	        inner join ec_distributor as d on d.id=dr.id_distributor
	        inner join ec_stock as s on s.id_region=r.id and s.id_distributor=d.id and s.id_product=p.id

	        inner join (select distinct cd.id_product from ec_condition_d as cd 
	        inner join ec_condition_h as ch on cd.id_condition_h=ch.id and (ch.is_all_region=1 or ch.id_region='". $this->iIdRegion ."') and (ch.dt1 < '".$sTime."' and '".$sTime."' < ch.dt2 )
	    			and ch.id_group_p in(2,3) 
	    		and (ch.id_customer_group='".  $this->id_customer_group ."' or ch.id_customer_group=0)
	        inner join ec_group_p as gp on gp.id=ch.id_group_p and ch.id_group_p='".Base::$aRequest['promo']."'
			) as cd on cd.id_product =p.id
	    		
	        where big.id_brand_group = ".Base::$aRequest['group']." and pr.id_customer_group='". $this->id_customer_group ."' and pr.id_region='". $this->iIdRegion ."'
            and (b.id='".Base::$aRequest['brand']."' or '".Base::$aRequest['brand']."'='')
	    	and	(not vp.id='' and '".$aSelectedVid['id']."'='')
	        and p.visible=1 and p.id_parent<>0  and v.visible=1 
	        group by vp.id 
	    		order by sort");		//Обрий 03.12.2016
	    //Debug::PrintPre($aVidsFilter);  // $iB2C_Interface==1
/*	    
	    $sUrl='';
	    $aUrl=array();
	    if($aVidsFilter) foreach ($aVidsFilter as $sKey => $sValue) $aUrl[]='filter['.$sKey.']='.$sValue;
	     
	    if($aUrl) $sUrl.='&'.implode("&", $aUrl);
	    $aTmpChooseBra = array();
	    if($aVidsFilter) foreach ($aVidsFilter as $sKeyBra => $sValueBra) {
	        $aTmpChooseBra=explode(",", Base::$aRequest['filter']['vid']);
	    
	        if(in_array($sValueBra['id_vid'], $aTmpChooseBra)) {
	            $aVidsFilter[$sKeyBra]['checked']=1;
	        }
	        foreach ($aTmpChooseBra as $sKeyChooseBra => $sValueChooseBra) {
	            $aChooseReplaceBrand=Db::GetRow("select  
	           v.id, v.name, count(v.id) as qty from ec_vid as v 
	        	                where v.id in ('".$sValueChooseBra."')  ");
	            if($aChooseReplaceBrand) $aTmpChooseBra[$sKeyChooseBra]=$aChooseReplaceBrand;
	        }
	    }
	   // Debug::PrintPre($aTmpChooseBra);
	    Base::$tpl->assign('aTmpChooseBra',$aTmpChooseBra);
*/	    
		if($aSelectedVid){
		$aTmpChooseBra = array();
		$aTmpChooseBra[0]=$aSelectedVid;
	   // Debug::PrintPre($aTmpChooseBra);
	    Base::$tpl->assign('aTmpChooseBra',$aTmpChooseBra);
		}

	    Base::$tpl->assign('aVidsFilter',$aVidsFilter);				
				
		if(Base::$aRequest['table']=='line')
	    $aDataReal = Db::GetAll(Base::GetSql("EcProductVidRegionLine",array(
	        'id_brand_group'=>Base::$aRequest['group'],
			'id_group_p'=>Base::$aRequest['promo'],		//*****
	        'id_brand'=>Base::$aRequest['brand'],
	        'id_vid'=>Base::$aRequest['vid'],
	        'id_region'=>$this->iIdRegion,
	        'visible'=>1,
//	        'vid'=>Base::$aRequest['filter']['vid'],
	        'where'=>" and pri.id_parent <> 0 ",
			'discounts'=>$Discounts,
			'user_discount'=>$User_discount,
	        'choose'=>Base::$aRequest['choose'],
	        'price_min'=>Base::$aRequest['price_min'],
	        'price_max'=>Base::$aRequest['price_max'],
	        'num_atr'=>$Num_Attr_In_Filter,
	        'real'=>1,
	        'id_customer_group' => $this->id_customer_group, 
	    	'order'=>$RealOrder		//'order'=>" order by (s.stock>= 5) desc,v.sort,b.sort,p.name,pri.name"	    	//Обрий 03.12.2016		pri.sort   v.sort,b.sort,p.name
	    )));
				
				$oTable->sNoItem='No items';
				$oTable->aColumn['image']=array('sWidth'=>'1%');
				$oTable->aColumn['brand']=array('sTitle'=>'brand','sOrder'=>'b.name');
				$oTable->aColumn['art']=array('sTitle'=>'art','sOrder'=>'p.art');
				$oTable->aColumn['name']=array('sTitle'=>'name','sOrder'=>'p.name');
				$oTable->aColumn['weight']=array('sTitle'=>'weight','sOrder'=>'p.weight');
				$oTable->aColumn['volume']=array('sTitle'=>'volume','sOrder'=>'p.volume');
				$oTable->aColumn['pack_qty']=array('sTitle'=>'pack_qty','sOrder'=>'p.pack_qty');
				$oTable->aColumn['stock']=array('sTitle'=>'stock','sOrder'=>'s.stock');
				$oTable->aColumn['price']=array('sTitle'=>'price','sOrder'=>'pr.price');
				$oTable->aColumn['action']=array('sTitle'=>'buy');
				$oTable->iRowPerPage=20;
				// $oTable->bStepperVisible=true;
				$oTable->aCallbackAfter=array($this,'CallProductParse');
				//$oTable->aCallback=array($this,'CallProductParseNew');
				//$oTable->sDataTemplate = "catalog/row_product.tpl";
				//$oTable->sTemplateName = 'index_include/vid_table.tpl';
				if(Base::$aRequest['table']){					
					switch (Base::$aRequest['table']) {
						case 'thumb':
							$oTable->sDataTemplate="index_include/row_thumb.tpl";
							$oTable->sClass='nodatatable';
							$oTable->sTemplateName = 'index_include/thumb_vid_table.tpl';
							$oTable->aDataFoTable=$aDataParent;
							break;
						case 'line':
							$oTable->sDataTemplate="index_include/row_line.tpl";
							$oTable->sClass='nodatatable';
							$oTable->sTemplateName = 'index_include/line_vid_table.tpl';
							$oTable->aDataFoTable= $aDataReal;
							break;
						case 'list':
							$oTable->sDataTemplate="index_include/row_list.tpl";
							$oTable->sClass='nodatatable';
							$oTable->sTemplateName = 'index_include/list_vid_table.tpl';
							$oTable->aDataFoTable= $aDataParent;
							break;
					}
				}else{
					$oTable->sDataTemplate="index_include/row_thumb.tpl";
					$oTable->sTemplateName = 'index_include/thumb_vid_table.tpl';
					$oTable->sClass = 'nodatatable';
					$oTable->aDataFoTable= $aDataParent;
				}
				$aGetTable=$oTable->getTable();
				Base::$tpl->assign('sPriceTable',$aGetTable);
					
				$sGroupChangeTableUrl=$_SERVER['REQUEST_URI'];
				$iQstPos=strpos($sGroupChangeTableUrl, '?');
				if(!Base::$aRequest['table'] && $iQstPos!==false) $sGroupChangeTableUrl.='';
				elseif(!Base::$aRequest['table'] && $iQstPos===false) $sGroupChangeTableUrl.='?table=';
				elseif(Base::$aRequest['table']) {
					if(strpos($sGroupChangeTableUrl, "table=thumb")){
						if(strpos($sGroupChangeTableUrl, "&table=thumb")){ $sGroupChangeTableUrl=str_replace("&table=thumb", "", $sGroupChangeTableUrl);}
						if(strpos($sGroupChangeTableUrl, "?table=thumb&")){ $sGroupChangeTableUrl=str_replace("?table=thumb&", "", $sGroupChangeTableUrl)."&table=";}
						if(strpos($sGroupChangeTableUrl, "?table=thumb")){ $sGroupChangeTableUrl=str_replace("?table=thumb", "?table=", $sGroupChangeTableUrl);}
					}
					if(strpos($sGroupChangeTableUrl, "table=list")){
						if(strpos($sGroupChangeTableUrl, "&table=list")){ $sGroupChangeTableUrl=str_replace("&table=list", "", $sGroupChangeTableUrl);}
						if(strpos($sGroupChangeTableUrl, "?table=list&")){$sGroupChangeTableUrl=str_replace("?table=list&", "?", $sGroupChangeTableUrl)."&table=";}
						if(strpos($sGroupChangeTableUrl, "?table=list")){$sGroupChangeTableUrl=str_replace("?table=list", "?table=", $sGroupChangeTableUrl);}
					}
					if(strpos($sGroupChangeTableUrl, "table=line")){
						if(strpos($sGroupChangeTableUrl, "&table=line")){ $sGroupChangeTableUrl=str_replace("&table=line", "", $sGroupChangeTableUrl);}
						if(strpos($sGroupChangeTableUrl, "?table=line&")){ $sGroupChangeTableUrl=str_replace("?table=line&", "?", $sGroupChangeTableUrl)."&table=";}
						if(strpos($sGroupChangeTableUrl, "?table=line")){ $sGroupChangeTableUrl=str_replace("?table=line", "?table=", $sGroupChangeTableUrl);}
					}
				}
				Base::$tpl->assign('sGroupChangeTableUrl',$sGroupChangeTableUrl);
					

				Base::$sText.='';
//				Base::$sText.=$oTable->getTable("Choose promo");
		
		//Base::$oContent->AddCrumb(Language::GetMessage('Promo'),'');
		/*$oTable=new Table();
		$oTable->iRowPerPage=100;
		$oTable->sSql = Base::GetSql("EcBrandGroup");
		$oTable->aOrdered=" order by name ";
		$oTable->sNoItem='No items';
		$oTable->aColumn['item']=array('sTitle'=>'Name','sWidth'=>'20%');
		$oTable->sDataTemplate = "catalog/row_index.tpl";
		Base::$sText.=$oTable->getTable("Choose group");
		*/
		if (Base::$aRequest['catalog_export']==1){
			Catalog::Export($aDataReal);
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function CatalogGroup()
	{
	    $aSelectedGroup=Db::GetRow(Base::GetSql('EcBrandGroup',array(
	        'id'=>Base::$aRequest['group']
	    )));
	    $aPage['name']=$aSelectedGroup['name'];
	    Base::$tpl->assign('aPage',$aPage);
	    $sClassBrand = Db::GetOne('select class from ec_brand_group where id='.Base::$aRequest['group']);
	    Base::$tpl->assign('sClassBrand',$sClassBrand);
	    
 		Base::$oContent->AddCrumb($aSelectedGroup['name'],'');
		
		$oTable=new Table();
		$oTable->iRowPerPage=100;
		$oTable->sSql = Base::GetSql("EcBrandInGroup",array(
		    'id_brand_group'=>Base::$aRequest['group'],
		    'id_region'=>$this->iIdRegion,
	        'where'=>" and bigr.visible = 1 "
		));
		$oTable->aOrdered=" order by bigr.id";
		$oTable->sTemplateName = 'index_include/brand_table.tpl';
		$oTable->sNoItem='No items';
		$oTable->sClass='nodatatable';
		$oTable->aColumn['item']=array('sTitle'=>'Name','sWidth'=>'20%');
		$oTable->sDataTemplate = "catalog/row_catalog_group.tpl";
		Base::$sText.=$oTable->getTable("Choose brand");
		
	}

	//-----------------------------------------------------------------------------------------------
	public function CatalogBrand()
	{
	    $sClassBrand = Db::GetOne('select class from ec_brand_group where id='.Base::$aRequest['group']);
	    Base::$tpl->assign('sClassBrand',$sClassBrand);
	    
	    $aSelectedGroup=Db::GetRow(Base::GetSql('EcBrandGroup',array(
	        'id'=>Base::$aRequest['group']
	    )));
	    $aSelectedBrand=Db::GetRow(Base::GetSql("EcBrand",array(
	        'id'=>Base::$aRequest['brand']
	    )));
	    $aPage['name']=$aSelectedBrand['name'];
	    Base::$tpl->assign('aPage',$aPage);
	    
	    Base::$oContent->AddCrumb($aSelectedGroup['name'],'/?action=catalog_group&group='.$aSelectedGroup['id']);
	    Base::$oContent->AddCrumb($aSelectedBrand['name'],'');
	    
	    //select all vid
	    $aAllVid=Db::GetAll(Base::GetSql("EcVidInBrand",array(
	        'id_brand_group'=>Base::$aRequest['group'],
	        'id_brand'=>Base::$aRequest['brand'],
	        'id_region'=>$this->iIdRegion,
	        'where'=>" and p.visible=1 and v.visible=1 and p.id_parent<>0 and pr.id_customer_group='". $this->id_customer_group."'" ,
	    	'order'=>" order by v.sort"	    	//Обрий 15.12.2016		p.sort
	    )));
	    	  
	    
	    $aTreeVid=array();
	    $aParentNeed=array();
	    if($aAllVid) {
	    	$aTreeVid[0]=$aAllVid[0];
	    	$aTreeVid[0]['id']=0;
	    	$aTreeVid[0]['name']='<b>Весь товар</b>';
	    	$aTreeVid[0]['short_name']='Весь товар';
	    	$aTreeVid[0]['id']=0;
	    	$aTreeVid[0]['sort']=0;
	    	$aTreeVid[0]['id_parent']=0;
	    }	    
	    if($aAllVid) foreach ($aAllVid as $aValue) {
	        if($aValue['id_parent']==0) {
	            $aTreeVid[$aValue['id']]=$aValue;
	        } else {
	            $aTreeVid[$aValue['id_parent']]['child'][]=$aValue;
	            if(!$aTreeVid[$aValue['id_parent']]['id']) $aParentNeed[]=$aValue['id_parent'];
	        }
	    }
	    unset($aAllVid);
	    
	    if($aParentNeed) {
	        $aParentNeed=Db::GetAll(Base::GetSql("EcVid",array(
	            'where'=>" and r.id in ('".implode("','", array_unique($aParentNeed))."') "
    	    )));
	    }
	    if($aParentNeed) foreach ($aParentNeed as $aValue) {
	        $aChild=$aTreeVid[$aValue['id']];
	        if(!$aChild) $aChild=array();
	        $aTreeVid[$aValue['id']]=array_merge($aValue,$aChild);
	    }
	    
// 		Base::$oContent->AddCrumb(Language::GetMessage('Catalog product'),'');
		$oTable=new Table();
		$oTable->iRowPerPage=100;
		$oTable->sType='array';
		$oTable->aDataFoTable=$aTreeVid;
// 		$oTable->aOrdered=" order by name ";
		$oTable->sNoItem='No items';
		//$oTable->aColumn['item']=array('sTitle'=>'Name','sWidth'=>'20%');
		$oTable->sDataTemplate = "catalog/row_vid.tpl";
		$oTable->sTemplateName = 'index_include/brandvid_table.tpl';
		Base::$sText.=$oTable->getTable("Choose vid");
		
		Base::$sText.=Home::GetPopularProducts(Base::$aRequest['group']);

	}
	//-----------------------------------------------------------------------------------------------
	public function CatalogVid()
	{
	    if(Base::$aRequest['testsql'] == '1'){
	        Db::Debug();
	    }
	    if (Auth::$aUser['id'] && Auth::$aUser['type_']=='customer')
	    {
	        $sSql ="select id_customer_group from user_customer where id_user='".Auth::$aUser['id']."'";
	        $iCustomerGroup = Db::getOne($sSql);
	        $this->id_customer_group = $iCustomerGroup;
	    }
	    elseif (Auth::$aUser['id'] && Auth::$aUser['type_']=='manager')
	    {
	        $sSql ="select id_customer_group from user_manager where id_user='".Auth::$aUser['id']."'";
	        $iCustomerGroup = Db::getOne($sSql);
	        $this->id_customer_group = $iCustomerGroup;
	    }else
	    {
	        $iCustomerGroup =1;
	        $this->id_customer_group = $iCustomerGroup;
	    }
	    
	    if ($_SESSION['user'] && !$this->iCustomerGroup) {
	    	$this->iCustomerGroup=$_SESSION['user']['id_customer_group'];
	    }
	    if ($_SESSION['user'] && !$this->iIdRegion) {
	    	$this->iIdRegion=$_SESSION['user']['id_region'];
	    }
	     
	    if(!$this->iCustomerGroup)	$this->iCustomerGroup =1;
	    if(!$this->iIdRegion)	$this->iIdRegion=1;
	     
	    

	    if($iCustomerGroup==1 || $iCustomerGroup==30)
	    	$iB2C_Interface=1;
	    
	    $sClassBrand = Db::GetOne('select class from ec_brand_group where id='.Base::$aRequest['group']);
	    Base::$tpl->assign('sClassBrand',$sClassBrand);
	    
	    $aSelectedGroup=Db::GetRow(Base::GetSql('EcBrandGroup',array(
	        'id'=>Base::$aRequest['group']
	    )));
	    
	    if(Base::$aRequest['brand'])
	    $aSelectedBrand=Db::GetRow(Base::GetSql("EcBrand",array(
	        'id'=>Base::$aRequest['brand']
	    )));
	    
			if(Base::$aRequest['set_vid']){
				Base::$aRequest['vid']=Base::$aRequest['set_vid'];	    
	    	$aSelectedVid=Db::GetRow(Base::GetSql("EcVid",array(
	    			'id'=>Base::$aRequest['set_vid']
	    			)));	    			
			}
			elseif(Base::$aRequest['vid'])
				$aSelectedVid=Db::GetRow(Base::GetSql("EcVid",array(
				'id'=>Base::$aRequest['vid']
			)));
//	    09.12.2016
		if(Base::$aRequest['group'])
	    $aPage['name']=$aSelectedGroup['name'];
	    if(Base::$aRequest['brand'])
	    $aPage['brand']=$aSelectedBrand['name'];
	     
		    	    
	    if(Base::$aRequest['set_vid'] || Base::$aRequest['vid'])    // && $iB2C_Interface==1)
			$aPage['name']=$aSelectedVid['name'];
		
	    Base::$tpl->assign('aPage',$aPage);
	     
	    
	     
	     
	    
	    /*
	    if(Base::$aRequest['action']=='catalog_vid' && Base::$aRequest['group'] && !Base::$aRequest['brand'] && !Base::$aRequest['vid']){
	        $aPage['name']=$aSelectedGroup['name'];
	        Base::$tpl->assign('aPage',$aPage);
	    }
	    else {
	    $aPage['name']=$aSelectedVid['name'];
	    Base::$tpl->assign('aPage',$aPage);
	    }
	    */
	    $sVidName=$aSelectedVid['name'];
	    if($aSelectedVid['id_parent']) {
	        $aSelectedVidParent=Db::GetRow(Base::GetSql("EcVid",array(
    	        'id'=>$aSelectedVid['id_parent']
    	    )));
	        $sVidName=$aSelectedVidParent['name'].' '.$sVidName;
	    }
	    
	    Base::$oContent->AddCrumb($aSelectedGroup['name'],'/?action=catalog_group&group='.$aSelectedGroup['id']);
	    if($aSelectedBrand['name'])
	    	Base::$oContent->AddCrumb($aSelectedBrand['name'],'/?action=catalog_brand&group='.$aSelectedGroup['id'].'&brand='.$aSelectedBrand['id']);
	    if($aSelectedVidParent['name'])
	    	Base::$oContent->AddCrumb($aSelectedVidParent['name'],'/?action=catalog_brand&group='.$aSelectedGroup['id'].'&vid='.$aSelectedVidParent['id']);
	    	 		
	    	 		/*
	    
	    if (Base::$aRequest['action']=='catalog_vid' && Base::$aRequest['group'] && !Base::$aRequest['brand'] && !Base::$aRequest['vid']){
	        Base::$oContent->AddCrumb($aSelectedGroup['name'],'');
	        Base::$oContent->AddCrumb('');
	    } else {
	    Base::$oContent->AddCrumb($aSelectedGroup['name'],'/?action=catalog_group&group='.$aSelectedGroup['id']);
	    if($aSelectedBrand['name'])
	    Base::$oContent->AddCrumb($aSelectedBrand['name'],'/?action=catalog_brand&group='.$aSelectedGroup['id'].'&brand='.$aSelectedBrand['id']);
	    Base::$oContent->AddCrumb($sVidName,'');
	    }
	    */
	    //filter OBR start
	    if(Base::$aRequest['brand']){
	       $sBrand=" and p.id_brand = ".Base::$aRequest['brand'];
	    }

		if(Base::$aRequest['set_vid']){
				$sVid="and (vi.id = '".Base::$aRequest['set_vid']."' or vi.id_parent ='".Base::$aRequest['set_vid']."')";
				Base::$aRequest['vid']=Base::$aRequest['set_vid'];	    
			}
			elseif(Base::$aRequest['vid']){
				$sVid="and (vi.id = '".Base::$aRequest['vid']."' or vi.id_parent ='".Base::$aRequest['vid']."')";
			}
//Обрий 02.12.2016	    
//	    else 
//	    	if(Base::$aRequest['filter']['vid'])
//	    		{
//					$sChecked_Vids = str_replace("#", "", Base::$aRequest['filter']['vid']);
//	    			$sVid="and piv.id_vid in (".$sChecked_Vids.")";
//	    		}

	    $aAtributeAll=Db::GetAll("select vr.id,vr.variable_nm, p.id_brand, piv.id_vid, p.id_brand_group
        from ec_products p
        inner join ec_val v on v.id_product=p.id
        inner join ec_variable vr on vr.id=v.id_variable and vr.in_filter=1
        inner join ec_antbl a on a.id=vr.id
        inner join ec_anval an on an.id_antbl=a.id and an.id=v.id_anval
        inner join ec_product_in_vid piv on piv.id_product=p.id
	    inner join ec_vid as vi on vi.id=piv.id_vid
	    where p.id_brand_group = '".Base::$aRequest['group']."' '".$sBrand."' ".$sVid."
	        group by vr.id 
	    		order by vr.sort");		//Обрий 02.12.2016

	    $aTmpChoose = array();
	    
	    foreach ($aAtributeAll as $aKey => $aValue){
	        $sql="select an.anval_nm, p.id_brand, an.id, piv.id_vid, p.id_brand_group, v.id_product, COUNT(p.id) as qty
        from ec_products p
	    inner join ec_price as pr on pr.id_product=p.id
        inner join ec_val v on v.id_product=p.id
        inner join ec_variable vr on vr.id=v.id_variable and vr.in_filter=1
        inner join ec_antbl a on a.id=vr.id
        inner join ec_anval an on an.id_antbl=a.id and an.id=v.id_anval
        inner join ec_product_in_vid piv on piv.id_product=p.id
	    inner join ec_vid as vi on vi.id=piv.id_vid
	    where a.id='".$aAtributeAll[$aKey]['id']."' and p.id_brand_group = '".Base::$aRequest['group']."'
	        ".$sBrand." ".$sVid." and pr.id_customer_group='". $this->id_customer_group ."' and pr.id_region='". $this->iIdRegion ."'
	        and p.visible=1
	        group by an.id
	        		order by an.anval_nm";	//Обрий 03.12.2016
	        $aAtribute=Db::GetAll($sql);
	         
	        if($aAtribute) foreach ($aAtribute as $sKey => $sValue) {
	            $aTmpChoose=explode(",", Base::$aRequest['choose']);
	             
	            if(in_array($sValue['id'], $aTmpChoose)) {
	                $aAtribute[$sKey]['checked']=1;
	            }
	            
	            foreach ($aTmpChoose as $sKeyChoose => $sValueChoose) {
	                $aChooseReplace=Db::GetRow("select anval_nm, id from ec_anval where id in ('".$sValueChoose."')  ");
	                if($aChooseReplace) $aTmpChoose[$sKeyChoose]=$aChooseReplace;
	            }
	        }
//Обрий 02.12.2016	    
	        if (!$aAtribute) unset($aAtributeAll[$aKey]);
	       else
	        $aAtributeAll[$aKey]['atrib']= $aAtribute;
	    }
	    $sUrl='';
	    $aUrl=array();
	   
	    $sUrl.='/?action=catalog_filter&group='.$aSelectedGroup['id'];
	    
		if(Base::$aRequest['promo'] && !Base::$aRequest['remove_promo'])
			$sUrl.='&promo='.Base::$aRequest['promo'];
		if(Base::$aRequest['brand'] && !Base::$aRequest['remove_brand'])
	        $sUrl.='&brand='.$aSelectedBrand['id'];
	    
			if(Base::$aRequest['set_vid'])        $sUrl.='&vid='.Base::$aRequest['set_vid'];
			elseif(Base::$aRequest['vid'])        $sUrl.='&vid='.$aSelectedVid['id'];
	    
	    if(Base::$aRequest["choose"]) $sUrl.="&choose=".Base::$aRequest["choose"];
//	    if(Base::$aRequest["filter"]["vid"]) $sUrl.="&filter[vid]=".Base::$aRequest["filter"]["vid"];
	    if($aUrl) $sUrl.='&'.implode("&", $aUrl);
	    Base::$tpl->assign('sUrl',$sUrl);
	     
	    Base::$tpl->assign('aAtributeAll',$aAtributeAll);
	    Base::$tpl->assign('aTmpChoose',$aTmpChoose);


		if(!Base::$aRequest['sort'] || Base::$aRequest['sort']=='name'){
			$ParentOrder=" order by (s.stock>=p.min_stock) desc,v.sort,b.sort,p.name";
			$RealOrder=" order by (s.stock>=pri.min_stock) desc,v.sort,b.sort,p.name,pri.name";
		}
		elseif(Base::$aRequest['sort']=='price'){
			if(Base::$aRequest['way']=='up'){
				$ParentOrder=" order by (s.stock>=p.min_stock) desc,pr.price asc";
				$RealOrder=" order by (s.stock>=pri.min_stock) desc,pr.price asc";
			}
			else {
				$ParentOrder=" order by (s.stock>=p.min_stock) desc,pr.price desc";
				$RealOrder=" order by (s.stock>=pri.min_stock) desc,pr.price desc";
			}
		}
		elseif(Base::$aRequest['sort']=='new'){
			$ParentOrder=" order by (s.stock>=p.min_stock) desc,v.sort,b.sort,p.name";
			$RealOrder=" order by (s.stock>=pri.min_stock) desc,v.sort,b.sort,p.name,pri.name";
		}
		else{
			$ParentOrder=" order by (s.stock>=p.min_stock) desc,v.sort,b.sort,p.name";
			$RealOrder=" order by (s.stock>=pri.min_stock) desc,v.sort,b.sort,p.name,pri.name";
		}

	    
// 	    //procedura
// 	    $atrib =  Base::$aRequest['choose'];
// 	    $brand_group =  Base::$aRequest['group'];
	    
// 	    $ProcedTmp=array();
// 	    $link = mysqli_connect('127.0.0.1','obriy','Niin1vTF1xZT65w','obriy','3306');
// 	    $res = mysqli_query($link,"CALL get_filtered_products ('$brand_group','$atrib') ");
// 	    while ($row = mysqli_fetch_assoc($res)) {
// 	       $ProcedTmp[]=$row['id_product'];
// 	    }
// 	    //while($link->next_result()) $link->store_result();
// 	    mysqli_close($link);
	    
// 	    $aChoose=implode(",", $ProcedTmp);

	    //Debug::PrintPre($aChoose);
// 	    $connection = @new mysqli('localhost', 'root', '123456', 'obriy');
// 	    while($connection->next_result()) $connection->store_result();

	    //procedura
	    //filter OBR end
		
	    if (Auth::$aUser['id'] && Auth::$aUser['type_']=='customer')
	    {
			$User_discount=Auth::$aUser['id'];
			$Discounts=Db::GetOne("select count( * ) from ec_discounts di where id_region='".$this->iIdRegion."' and id_user='".$User_discount."' ");
	    }
	    elseif (Auth::$aUser['id'] && Auth::$aUser['type_']=='manager')
	    {
			$User_discount=Db::GetOne("select id_customer_partner as user_discount from user_manager um where id_user='".Auth::$aUser['id']."' ");
			$Discounts=Db::GetOne("select count( * ) from ec_discounts di where id_region='".$this->iIdRegion."' and id_user='".$User_discount."' ");
	    }
		
	    	   
	    $Num_Attr_In_Filter = Db::GetOne("select count( * ) from ec_antbl t where exists (select * from ec_anval a
	        where t.id=a.id_antbl and FIND_IN_SET (a.id, '".Base::$aRequest['choose']."')>0) ");
	    	    
	    $oTable=new Table();
	    $oTable->sType='array';
		if(!Base::$aRequest['table'] || Base::$aRequest['table']!='line')
	    $aDataParent=Db::GetAll(Base::GetSql("EcProductVidRegion",array(
	        'id_brand_group'=>Base::$aRequest['group'],
	        'id_brand'=>Base::$aRequest['brand'],
	        'id_vid'=>Base::$aRequest['vid'],
	        'id_region'=>$this->iIdRegion,
	        'visible'=>1,
//	        'vid'=>Base::$aRequest['filter']['vid'],
	        'where'=>" and p.id_parent = 0 and v.visible=1 ",
			'discounts'=>$Discounts,
			'user_discount'=>$User_discount,
	        'choose'=>Base::$aRequest['choose'],
	        'price_min'=>Base::$aRequest['price_min'],
	        'price_max'=>Base::$aRequest['price_max'],
	        'num_atr'=>$Num_Attr_In_Filter,
	        'id_customer_group' => $this->id_customer_group ,
	    	'order'=>$ParentOrder			//" order by (s.stock>= 5) desc,v.sort,b.sort,p.name"	    	//Обрий 15.12.2016		p.sort
	    )));
	    //Debug::PrintPre($aDataParent);
	    $aVidsFilter=Db::GetAll("select  
	           v.id as id_vid ,
	           v.name,
	           count(id_vid) as qty,
	    		v.sort
	        from ec_products as p
	        inner join ec_product_in_vid as piv on piv.id_product=p.id
	        inner join ec_vid as v on v.id=piv.id_vid
	        inner join ec_brand_in_group as big on big.id_brand=p.id_brand
	        inner join ec_brand_group as bg on bg.id=big.id_brand_group and p.id_brand_group=bg.id
	        inner join ec_brand as b on p.id_brand=b.id
	    
	        inner join ec_price as pr on pr.id_product=p.id
	        inner join ec_region as r on r.id=pr.id_region
	        inner join ec_brand_in_region as bir on bir.id_brand=b.id and bir.id_region=r.id
	        inner join ec_distributor_region as dr on dr.id_region=r.id
	        inner join ec_distributor as d on d.id=dr.id_distributor
	        inner join ec_stock as s on s.id_region=r.id and s.id_distributor=d.id and s.id_product=p.id
	        where big.id_brand_group = ".Base::$aRequest['group']." and pr.id_customer_group='". $this->id_customer_group ."' and pr.id_region='". $this->iIdRegion ."'
            and (b.id='".Base::$aRequest['brand']."' or '".Base::$aRequest['brand']."'='')
	    	and	(v.id_parent='".$aSelectedVid['id']."' )
	        and p.visible=1 and p.id_parent<>0 and v.visible=1 
	        group by v.id 
	    		
            union all
select  
               vp.id as id_vid,
               vp.name,
	           count(id_vid) as qty,
	    		vp.sort
                
	        from ec_products as p
	        inner join ec_product_in_vid as piv on piv.id_product=p.id
	        inner join ec_vid as v on v.id=piv.id_vid
	        inner join ec_vid as vp on vp.id=v.id_parent
	        inner join ec_brand_in_group as big on big.id_brand=p.id_brand
	        inner join ec_brand_group as bg on bg.id=big.id_brand_group and p.id_brand_group=bg.id
	        inner join ec_brand as b on p.id_brand=b.id
	    
	        inner join ec_price as pr on pr.id_product=p.id
	        inner join ec_region as r on r.id=pr.id_region
	        inner join ec_brand_in_region as bir on bir.id_brand=b.id and bir.id_region=r.id
	        inner join ec_distributor_region as dr on dr.id_region=r.id
	        inner join ec_distributor as d on d.id=dr.id_distributor
	        inner join ec_stock as s on s.id_region=r.id and s.id_distributor=d.id and s.id_product=p.id
	        where big.id_brand_group = ".Base::$aRequest['group']." and pr.id_customer_group='". $this->id_customer_group ."' and pr.id_region='". $this->iIdRegion ."'
            and (b.id='".Base::$aRequest['brand']."' or '".Base::$aRequest['brand']."'='')
	    	and	(not vp.id='' and '".$aSelectedVid['id']."'='')
	        and p.visible=1 and p.id_parent<>0  and v.visible=1 
	        group by vp.id 
	    		order by sort");		//Обрий 03.12.2016
	    //Debug::PrintPre($aVidsFilter);  // $iB2C_Interface==1
/*	    
	    $sUrl='';
	    $aUrl=array();
	    if($aVidsFilter) foreach ($aVidsFilter as $sKey => $sValue) $aUrl[]='filter['.$sKey.']='.$sValue;
	     
	    if($aUrl) $sUrl.='&'.implode("&", $aUrl);
	    $aTmpChooseBra = array();
	    if($aVidsFilter) foreach ($aVidsFilter as $sKeyBra => $sValueBra) {
	        $aTmpChooseBra=explode(",", Base::$aRequest['filter']['vid']);
	    
	        if(in_array($sValueBra['id_vid'], $aTmpChooseBra)) {
	            $aVidsFilter[$sKeyBra]['checked']=1;
	        }
	        foreach ($aTmpChooseBra as $sKeyChooseBra => $sValueChooseBra) {
	            $aChooseReplaceBrand=Db::GetRow("select  
	           v.id, v.name, count(v.id) as qty from ec_vid as v 
	        	                where v.id in ('".$sValueChooseBra."')  ");
	            if($aChooseReplaceBrand) $aTmpChooseBra[$sKeyChooseBra]=$aChooseReplaceBrand;
	        }
	    }
	   // Debug::PrintPre($aTmpChooseBra);
	    Base::$tpl->assign('aTmpChooseBra',$aTmpChooseBra);
*/	    
		if($aSelectedVid){
		$aTmpChooseBra = array();
		$aTmpChooseBra[0]=$aSelectedVid;
	   // Debug::PrintPre($aTmpChooseBra);
	    Base::$tpl->assign('aTmpChooseBra',$aTmpChooseBra);
		}

	    Base::$tpl->assign('aVidsFilter',$aVidsFilter);
		//if(Base::$aRequest['table']=='line')
	    $aDataReal = Db::GetAll(Base::GetSql("EcProductVidRegionLine",array(
	        'id_brand_group'=>Base::$aRequest['group'],
	        //'id_brand'=>Base::$aRequest['brand'],
	        //'id_vid'=>Base::$aRequest['vid'],
	        //'id_region'=>$this->iIdRegion,
	        'visible'=>1,
//	        'vid'=>Base::$aRequest['filter']['vid'],
	        'where'=>" and pri.id_parent <> 0 ",
			//'discounts'=>$Discounts,
			//'user_discount'=>$User_discount,
	        'choose'=>Base::$aRequest['choose'],
	        'price_min'=>Base::$aRequest['price_min'],
	        'price_max'=>Base::$aRequest['price_max'],
	        'num_atr'=>$Num_Attr_In_Filter,
	        'real'=>1,
	        //'id_customer_group' => $this->id_customer_group, 
	    	//'order'=>$RealOrder					//" order by (s.stock>= 5) desc,v.sort,b.sort,p.name,pri.name"	    	//Обрий 03.12.2016		pri.sort   v.sort,b.sort,p.name
	    )));
	
//ищем товар  в 	корзине!!!
		$sUserCartProdSql="select c.id_product,c.number
			from cart c
			where type_='cart'and c.id_user='".Auth::$aUser['id']."'";
		$aUserCartProd=Db::GetAll($sUserCartProdSql);

	    $Num_Attr_In_Filter = Db::GetOne("select count( * ) from ec_antbl t where exists (select * from ec_anval a
	        where t.id=a.id_antbl and FIND_IN_SET (a.id, '".Base::$aRequest['choose']."')>0) ");
	   
         if ($aDataReal) {
	            	foreach($aDataReal as $keyp => &$aValue) {
//товар есть в 	корзине!!!
	            		foreach($aUserCartProd as $keyp3 => &$aValue3) {
	            			if($aDataReal[$keyp]['id'] == $aValue3['id_product']){
	            					$aDataReal[$keyp]['in_cart']= $aValue3['number'];
	            			}
						}
						
	            	}
	            }
		
		
	    $oTable->sNoItem='No items';
	    $oTable->aColumn['image']=array('sWidth'=>'1%');
	    $oTable->aColumn['brand']=array('sTitle'=>'brand','sOrder'=>'b.name');
	    $oTable->aColumn['art']=array('sTitle'=>'art','sOrder'=>'p.art');
	    $oTable->aColumn['name']=array('sTitle'=>'name','sOrder'=>'p.name');
	    $oTable->aColumn['weight']=array('sTitle'=>'weight','sOrder'=>'p.weight');
	    $oTable->aColumn['volume']=array('sTitle'=>'volume','sOrder'=>'p.volume');
	    $oTable->aColumn['pack_qty']=array('sTitle'=>'pack_qty','sOrder'=>'p.pack_qty');
	    $oTable->aColumn['stock']=array('sTitle'=>'stock','sOrder'=>'s.stock');
	    $oTable->aColumn['price']=array('sTitle'=>'price','sOrder'=>'pr.price');
	    $oTable->aColumn['action']=array('sTitle'=>'buy');
	    $oTable->iRowPerPage=20;
 	   // $oTable->bStepperVisible=true;
	    $oTable->aCallbackAfter=array($this,'CallProductParse');
	    //$oTable->aCallback=array($this,'CallProductParseNew');
	    //$oTable->sDataTemplate = "catalog/row_product.tpl";
	    //$oTable->sTemplateName = 'index_include/vid_table.tpl';
				if(Base::$aRequest['table']){
					switch (Base::$aRequest['table']) {
        	        case 'thumb':
        	            $oTable->sDataTemplate="index_include/row_thumb.tpl";
        	            $oTable->sClass='nodatatable';
    	                $oTable->sTemplateName = 'index_include/thumb_vid_table.tpl';
    	                $oTable->aDataFoTable=$aDataParent;
        	            break;
        	        case 'line':
        	            $oTable->sDataTemplate="index_include/row_line.tpl";
        	            $oTable->sClass='nodatatable';
    	                $oTable->sTemplateName = 'index_include/line_vid_table.tpl';
    	                $oTable->aDataFoTable= $aDataParent;
        	            break;
        	        case 'list':
        	            $oTable->sDataTemplate="index_include/row_list.tpl";
        	            $oTable->sClass='nodatatable';
    	                $oTable->sTemplateName = 'index_include/list_vid_table.tpl';
    	                $oTable->aDataFoTable= $aDataParent;
        	            break;
        	    }
    	    }else{
    	        $oTable->sDataTemplate="index_include/row_thumb.tpl";
    	        $oTable->sTemplateName = 'index_include/thumb_vid_table.tpl';
    	        $oTable->sClass = 'nodatatable';
    	        $oTable->aDataFoTable= $aDataParent;
    	    }
    	    $aGetTable=$oTable->getTable();
    	    Base::$tpl->assign('sPriceTable',$aGetTable);
    	    
    	    $sGroupChangeTableUrl=$_SERVER['REQUEST_URI'];
    	    $iQstPos=strpos($sGroupChangeTableUrl, '?');
    	    if(!Base::$aRequest['table'] && $iQstPos!==false) $sGroupChangeTableUrl.='';
    	    elseif(!Base::$aRequest['table'] && $iQstPos===false) $sGroupChangeTableUrl.='?table=';
    	    elseif(Base::$aRequest['table']) {
    	        if(strpos($sGroupChangeTableUrl, "table=thumb")){
    	        if(strpos($sGroupChangeTableUrl, "&table=thumb")){ $sGroupChangeTableUrl=str_replace("&table=thumb", "", $sGroupChangeTableUrl);}
    	        if(strpos($sGroupChangeTableUrl, "?table=thumb&")){ $sGroupChangeTableUrl=str_replace("?table=thumb&", "", $sGroupChangeTableUrl)."&table=";}
    	        if(strpos($sGroupChangeTableUrl, "?table=thumb")){ $sGroupChangeTableUrl=str_replace("?table=thumb", "?table=", $sGroupChangeTableUrl);}
    	        }
    	        if(strpos($sGroupChangeTableUrl, "table=list")){
    	        if(strpos($sGroupChangeTableUrl, "&table=list")){ $sGroupChangeTableUrl=str_replace("&table=list", "", $sGroupChangeTableUrl);}
    	        if(strpos($sGroupChangeTableUrl, "?table=list&")){$sGroupChangeTableUrl=str_replace("?table=list&", "?", $sGroupChangeTableUrl)."&table=";}
    	        if(strpos($sGroupChangeTableUrl, "?table=list")){$sGroupChangeTableUrl=str_replace("?table=list", "?table=", $sGroupChangeTableUrl);}
    	        }
    	        if(strpos($sGroupChangeTableUrl, "table=line")){
    	        if(strpos($sGroupChangeTableUrl, "&table=line")){ $sGroupChangeTableUrl=str_replace("&table=line", "", $sGroupChangeTableUrl);}
    	        if(strpos($sGroupChangeTableUrl, "?table=line&")){ $sGroupChangeTableUrl=str_replace("?table=line&", "?", $sGroupChangeTableUrl)."&table=";}
    	        if(strpos($sGroupChangeTableUrl, "?table=line")){ $sGroupChangeTableUrl=str_replace("?table=line", "?table=", $sGroupChangeTableUrl);}
    	        }
    	    }
    	    Base::$tpl->assign('sGroupChangeTableUrl',$sGroupChangeTableUrl);
    	    
	    Base::$sText.='';
//Debug::PrintPre($aDataReal);
		if (Base::$aRequest['catalog_export']==1){
			Catalog::Export($aDataReal);
		}
	    	  
	}
	//-----------------------------------------------------------------------------------------------
	public function Filter()
	{
		// LNB-57 filter
		$sUrl='';
		$aUrl=array();
		if(!Base::$aRequest['promo'] || Base::$aRequest['remove_promo'])
			$sUrl.='/?action=catalog_vid&group='.Base::$aRequest['group'];
		elseif(Base::$aRequest['promo'])
			$sUrl.='/?action=catalog_promo&group='.Base::$aRequest['group'];
			
		if(Base::$aRequest['promo'] && !Base::$aRequest['remove_promo'])
			$sUrl.='&promo='.Base::$aRequest['promo'];
				
		if(Base::$aRequest['brand'] && !Base::$aRequest['remove_brand'])
			$sUrl.='&brand='.Base::$aRequest['brand'];
		
		if(!Base::$aRequest['remove']=='vid' && !Base::$aRequest['remove_all']) {
				if(Base::$aRequest['set_vid'])			$sUrl.='&vid='.Base::$aRequest['set_vid'];
				elseif(Base::$aRequest['vid'])			$sUrl.='&vid='.Base::$aRequest['vid'];
				}
					
		if(Base::$aRequest['table'])
		      $sUrl.='&table='.Base::$aRequest['table'];
		
		if(!Base::$aRequest['remove_all']) {
		
			unset(Base::$aRequest["vid"]);
		
			$aFilterParams=String::FilterRequestData(Base::$aRequest['filter']);
			$sWhereParams='';
			if($aFilterParams) foreach ($aFilterParams as $sKey => $sValue) {
				if($sKey==Base::$aRequest['add']) {
					$sValue.=','.Base::$aRequest['value'];
					$aFilterParams[$sKey]=$sValue;
				}
					
				if($sKey==Base::$aRequest['remove']) {
					$aTmpVal=explode(",", $sValue);
					if($aTmpVal) foreach ($aTmpVal as $sTmpValKey => $sTmpValVal) {
						if($sTmpValVal==Base::$aRequest['value']) unset($aTmpVal[$sTmpValKey]);
					}
					$sValue=implode(",", $aTmpVal);
					$aFilterParams[$sKey]=$sValue;
				}
				
				if($sValue) $aUrl[]='filter['.$sKey.']='.$sValue;
			}
			

					
    		
    		if(!in_array(Base::$aRequest['add'], array_keys($aFilterParams)) && Base::$aRequest['add'] && Base::$aRequest['add']!='choose') {
    		    $aUrl[]='filter['.Base::$aRequest['add'].']='.Base::$aRequest['value'];
    		} elseif(!in_array(Base::$aRequest['add'], array_keys($aFilterParams)) && Base::$aRequest['add'] && Base::$aRequest['add']=='choose') {
    		    if(Base::$aRequest["choose"]) Base::$aRequest["choose"].=",".Base::$aRequest['value'];
    		    else Base::$aRequest["choose"]=Base::$aRequest['value'];
    		}
    		
			if(Base::$aRequest['remove']=='choose') {
				//unset(Base::$aRequest["brand"]);
				$aTmpVal=explode(",", Base::$aRequest["choose"]);
				if($aTmpVal) foreach ($aTmpVal as $sTmpValKey => $sTmpValVal) {
					if($sTmpValVal==Base::$aRequest['value']) unset($aTmpVal[$sTmpValKey]);
				}
				Base::$aRequest["choose"]=implode(",", $aTmpVal);
			}
			if(Base::$aRequest['remove']=='vid') {
			
				unset(Base::$aRequest["vid"]);
			/*
			    //unset(Base::$aRequest["brand"]);
			    $aTmpValBra=explode(",", Base::$aRequest["filter"]["vid"]);
			    if($aTmpValBra) foreach ($aTmpValBra as $sTmpValKeyBra => $sTmpValValBra) {
			        if($aTmpValBra==Base::$aRequest['value']) unset($aTmpValBra[$sTmpValKeyBra]);
			    }
			    Base::$aRequest["vid"]=implode(",", $aTmpValBra);
				*/
			}
			
			if(Base::$aRequest["choose"]) {
				$aUrl[]="choose=".Base::$aRequest["choose"];
			}
			
		} 
		if($aUrl) $sUrl.='&'.implode("&", $aUrl);
		//if($aUrl) $sUrl.='?'.implode("&", $aUrl);
		
		Base::Redirect($sUrl);
	}
	//-----------------------------------------------------------------------------------------------
	public function CallProductParse(&$aItem)
	{
	    $sTitle="";
	    $aTmp=array();
	    if (Auth::$aUser['id'])
	    {
	        $sSql ="select f.id_product,'true' from favourites as f where f.id_user='".Auth::$aUser['id']."'";
	        $aFavorites = Db::getAssoc($sSql);
	    }
	    else
	    {
	        $sSql ="select f.id_product,'true' from favourites as f where f.id_session='".session_id()."'";
	        $aFavorites = Db::getAssoc($sSql);
	    }
	    if ($aItem) {
	        foreach($aItem as $key => &$aValue) {
	            if($aFavorites[$aValue['id_product']] ||$aFavorites[$aValue['id_products']]){
	                $aItem[$key]['is_fav'] = true;
	            }
	            else{
	                $aItem[$key]['is_fav'] = false;
	            }
	        }
	    }
	    
			if(Base::$aRequest['set_vid']){
				Base::$aRequest['vid']=Base::$aRequest['set_vid'];
			}
	     
	    $iTime = time();
	    $sTime = date("Y-m-d H:i:s", $iTime);
	     
	    $aCondition=Db::GetAll("select p.id_parent,p.id as id_product,ch.id as ch_id,concat_ws(' ', gp.name,ch.info) as name, gp.color,ch.skidka,ch.id_type_skidka from ec_condition_d as cd
        	        inner join ec_condition_h as ch on cd.id_condition_h=ch.id
        	        inner join ec_group_p as gp on ch.id_group_p=gp.id
	    			inner join ec_products p on p.id=cd.id_product
        	        where ch.dt1 < '".$sTime."' and ch.dt2 > '".$sTime."'
	    			and ch.id_group_p in(2,3) 
	    		    and (ch.id_customer_group='". $this->id_customer_group ."' or ch.id_customer_group=0)
        	        and (ch.is_all_region=1 or ch.id_region='".$this->iIdRegion."') and ch.visible=1");		//obriy 04.12.2016

					
	    if (Auth::$aUser['id'] && Auth::$aUser['type_']=='customer')
	    {
			$User_discount=Auth::$aUser['id'];
			$Discounts=Db::GetOne("select count( * ) from ec_discounts di where id_region='".$this->iIdRegion."' and id_user='".$User_discount."' ");
	    }
	    elseif (Auth::$aUser['id'] && Auth::$aUser['type_']=='manager')
	    {
			$User_discount=Db::GetOne("select id_customer_partner as user_discount from user_manager um where id_user='".Auth::$aUser['id']."' ");
			$Discounts=Db::GetOne("select count( * ) from ec_discounts di where id_region='".$this->iIdRegion."' and id_user='".$User_discount."' ");
	    }
					
		$sUserCartProdSql="select c.id_product,c.number
			from cart c
			where type_='cart'and c.id_user='".Auth::$aUser['id']."'";
		$aUserCartProd=Db::GetAll($sUserCartProdSql);

	    $Num_Attr_In_Filter = Db::GetOne("select count( * ) from ec_antbl t where exists (select * from ec_anval a
	        where t.id=a.id_antbl and FIND_IN_SET (a.id, '".Base::$aRequest['choose']."')>0) ");
	   
	    $aRealProducts=array();
	    if (Base::$aRequest['table']=='thumb' || Base::$aRequest['table']=='list' || !Base::$aRequest['table']=='line')  {
	         if ($aItem) {
	             foreach($aItem as $key => &$aValue) {			//?????????				 
	            $aRealProducts=Db::GetAll(Base::GetSql("EcProductVidRegionReal",array(
	                'id_brand_group'=>Base::$aRequest['group'],
	                'id_brand'=>Base::$aRequest['brand'],
	                'id_vid'=>Base::$aRequest['vid'],
	                'id_region'=>$this->iIdRegion,
	                'id_customer_group' => $this->id_customer_group,
	                'visible'=>1,
					'discounts'=>$Discounts,
					'user_discount'=>$User_discount,
	                'where'=>"  and v.visible=1 and p.id_parent='".$aItem[$key]['id']."' ",
					'order'=>" order by (s.stock>=p.min_stock) desc,p.sort,p.name "
					
	            )));
//проставляем 	промо на реальном товаре           
	            if ($aRealProducts) {
	            	foreach($aRealProducts as $keyp => &$aValue) {
	            		$keyPrR=0;
	            		foreach($aCondition as $keyp2 => &$aValue2) {
	            			if($aRealProducts[$keyp]['id'] == $aValue2['id_product']){
	            				if ($aValue2['color']=='red')
	            					$aValue2['color']= '#ba0000';
	            					elseif ($aValue2['color']=='green')
	            					$aValue2['color']= '#8cb366';
	            					elseif  ($aValue2['color']=='')
	            					$aValue2['color']= 'blue';
	            					$aValue2['i']=$keyPrR+1;
	            					$aRealProducts[$keyp]['promo'][$keyPrR]= $aValue2;
	            					$keyPrR=$keyPrR+1;
/*	            					
	            				$aRealProducts[$keyp]['condition']= $aRealProducts[$keyp]['condition'].' '.$aValue2['name'];
	            				$aRealProducts[$keyp]['color']= $aValue2['color'];
*/	            				
	            			}
	            		}
//товар есть в 	корзине!!!
	            		foreach($aUserCartProd as $keyp3 => &$aValue3) {
	            			if($aRealProducts[$keyp]['id'] == $aValue3['id_product']){
	            					$aRealProducts[$keyp]['in_cart']= $aValue3['number'];
	            			}
						}
						
	            	}
	            }

	            $aItem[$key]['child']= $aRealProducts;
	        }
	       }
	    }
	    else 
	    {
	    	
	         if ($aItem) {
	             foreach($aItem as $key => &$aValue) {
	            		$keyPrR=0;
	             	foreach($aCondition as $keyp2 => &$aValue2) {
	            		if($aItem[$key]['id'] == $aValue2['id_product']){
	            				if ($aValue2['color']=='red')
	            					$aValue2['color']= '#ba0000';
	            					elseif ($aValue2['color']=='green')
	            					$aValue2['color']= '#8cb366';
	            					elseif  ($aValue2['color']=='')
	            					$aValue2['color']= 'blue';
	            					$aValue2['i']=$keyPrR+1;
	            					$aItem[$key]['promo'][$keyPrR]= $aValue2;
	            					$keyPrR=$keyPrR+1;
/*	            					
	            				$aRealProducts[$keyp]['condition']= $aRealProducts[$keyp]['condition'].' '.$aValue2['name'];
	            				$aRealProducts[$keyp]['color']= $aValue2['color'];
*/	            				
	            		}
	    			}
	             }
	         }
	    }

//проверка установки check во вложенном товаре
	    if ($aItem) {
	    	foreach($aItem as $keyc => &$aValueC) {
				$check_OK=0;
	    		if($aValueC['child'] )
	    		foreach($aValueC['child'] as $keyc2 => &$aValueC2) {
	    			 if ($aValueC2['check_']==1)
	    			 {				
	    			 	$check_OK=$check_OK+1;
	    			 }
	    			 	
	    		}
	    		if ($check_OK==0)
	    		{
	    			$aItem[$keyc]['child'][0]['check_']=1    				;
	    		}
	    	}
	    	}
	    			 
	    			 
	    
	    //проставляем промо на плитке
	    if ($aItem) {
	    	foreach($aItem as $key => &$aValue) {
	    		$keyPr=0;
	    		foreach($aValue['child'] as $keych => &$aValuech) {
	    		if($aValuech['check_']==1)
	    		{
	    			if ($aValuech['promo'])
	    			{
	    				$aItem[$key]['promo']=$aValuech['promo'];
	    			}
/*	    			
	    		foreach($aCondition as $key2 => &$aValue2) {
	    			
	    				if($aValuech['id'] == $aValue2['id_product']){
	    					if ($aValue2['color']=='red')
	    						$aValue2['color']= '#ba0000';
	    						elseif ($aValue2['color']=='green')
	    						$aValue2['color']= '#8cb366';
	    						$aItem[$key]['promo'][$keyPr]= $aValue2;
	    						$keyPr=$keyPr+1;
	    				}
	    		}
	    		*/
	    		}
	    		}
	    	}
	    }
	     
	    Base::$tpl->assign('aRealProducts',$aRealProducts);
	    
	 
	}
	//---------------------------------------------------------------------------------------------------------------------
	public function ViewReviewShow(){
	    /*$aReview=array(
	     0=>array('name'=>'test','review_text'=>'Пример','post'=>1291712970),
	     1=>array('name'=>'test2','review_text'=>'Пример2','post'=>1296813055),
	    );*/
	    if(!Base::$aRequest['ref'])Base::$aRequest['ref']=Base::$aRequest['data']['ref'];
	    /*$aReview=Db::GetAll(Base::GetSql("Catalog/Review"
	     , array("reference"=>Base::$aRequest['ref']?strtoupper(Base::$aRequest['ref']):-1)
	    ));
	
	    if($aReview)
	        foreach ($aReview as $key => $value) {
	        $aReview[$key]['text']=  str_replace ("\n", '<br>', $value['text']);
	        }
	    Base::$tpl->assign('aReview',$aReview);*/
	    Base::$tpl->assign('sRef',strtoupper(Base::$aRequest['ref']));
	    if(Base::$aRequest['xajax']){
	        	
	        if(Base::$aRequest['ref']){
	            $sReviewContent = '';
	            $sCountReview=Db::GetOne("select count(*) c from review where reference='".Base::$aRequest['ref']."'
					and visible=1");
	
	            $aReview=Db::GetAll(Base::GetSql("Catalog/Review"
	                , array("reference"=>Base::$aRequest['ref'])
	            ));
	            if($aReview)
	                foreach ($aReview as $key => $value) {
	                    $aReview[$key]['text']=  str_replace ("\n", '<br>', $value['text']);
	                }
	            Base::$tpl->assign('iReviewCount', count($aReview));
	
	            $oTable=new Table();
	            $oTable->sType='array';
	            $oTable->aDataFoTable = $aReview;
	            $oTable->bHeaderVisible = false;
	            $oTable->aColumn['review']=array('sTitle'=>'review','sWidth'=>'15%');
	            $oTable->sClass = "comments-list";
	            $oTable->iRowPerPage=Base::GetConstant("info_part:review_count","20");
	            $oTable->sDataTemplate='catalog/review.tpl';
	           // $oTable->sNoItem='No reviews';
	            $oTable->bStepperVisible=false;
	            $oTable->iRowPerPage=999;
	            $sReviewContent .= $oTable->getTable();
	
	            Catalog::GetStars($aPartInfo['item_code']);
	        }
	        $sReviewContent.=Base::$tpl->fetch('catalog/review_bottom.tpl');
	
	        Base::$oResponse->AddAssign('review_count','innerHTML',
	            $sCountReview);
	        Base::$oResponse->AddAssign('review_table','innerHTML',
	            $sReviewContent);
	        Base::$oResponse->AddAssign('review_span','innerHTML',
	            Base::$tpl->fetch('catalog/review.tpl'));
	    }else{
	        Base::$sText.=Base::$tpl->fetch('catalog/review.tpl');
	        $aCode = explode('_', Base::$aRequest['data']['ref']);
	        $sCat = Db::GetOne("SELECT name FROM cat WHERE pref like '".$aCode[0]."'");
	       // Base::Redirect('/buy/'.$sCat.'_'.$aCode[1]);
	    }
	}
	//-----------------------------------------------------------------------------------------------
	public function EditReview(){
	    //if(!Base::$aRequest['xajax']) Base::Redirect('/buy/'.Base::$aRequest['data']['ref']);
	    if(Base::$aRequest['data']['id'])
	        $aReview=Db::GetRow(Base::GetSql("Catalog/Review", array("r.id"=>Base::$aRequest['data']['id']) ));
	    if(Base::$aRequest['is_post']){
	        if(!Base::$aRequest['data']['ref']) $sMess='Error!';
	        if(Base::$aRequest['capcha']){
	            $bCheckCapcha = false;
	            if (Base::$aRequest['capcha']['type'] && Base::$aRequest['capcha']['type'] == 'graph')
	                $bCheckCapcha = Capcha::CheckGraph();
	            else {
	                Base::$aRequest['capcha']['mathematic_formula']=str_replace(' ', '+', Base::$aRequest['capcha']['mathematic_formula']);
	                $bCheckCapcha = Capcha::CheckMathematic();
	            }
	            if($bCheckCapcha){
	                if(!trim(Base::$aRequest['data']['name'])) $sMess.=Language::getMessage('no valid name!');
	                if(!trim(Base::$aRequest['data']['text'])) $sMess.=Language::getMessage('no valid text!');
	                if(!trim(Base::$aRequest['data']['email']) or strlen(Base::$aRequest['data']['email'])<5)
	                    $sMess.=Language::getMessage('no valid email!');
	                if(trim($sMess)==''){
	                    if(Auth::$aUser['type_']=='manager'){
	                        $sCommentText = stripcslashes(trim(Base::$aRequest['data']['text']));
	                    }else
	                        $sCommentText = htmlspecialchars(trim(Base::$aRequest['data']['text']));
	                    $aReviewInsert=array(
	                        'id_user'=>Auth::$aUser['id'],
	                        'name'=>trim(Base::$aRequest['data']['name']),
	                        'email'=>trim(Base::$aRequest['data']['email']),
	                        'text'=>$sCommentText,
	                        'reference'=>Base::$aRequest['data']['ref']
	                    );
	                    Db::AutoExecute('review',$aReviewInsert);
	                    $aReviewInsert['text']=  str_replace ("\n", '<br>', $aReviewInsert['text']);
	                    if(Auth::$aUser['login'])
	                        $aReviewInsert['login']=Auth::$aUser['login'];
	                    else
	                        $aReviewInsert['login']=Base::$aRequest['data']['name'];
	                    //if(!Base::$aRequest['xajax']){
	                    $aCode = explode('_', Base::$aRequest['data']['ref']);
	                    $sCat = Db::GetOne("SELECT name FROM cat WHERE pref like '".$aCode[0]."'");
	                    $aReviewInsert['url']=Base::GetConstant('global:project_url').'/buy/'.$sCat.'_'.$aCode[1];
	                    //Debug::PrintPre($aReview['url']);
	                    //}else{
	                    //	$aReview['url']=Base::GetConstant('global:project_url').$_SERVER['REQUEST_URI'];
	                        ///}
	                        $aReviewInsert['url_remove']='http://autoklad.ua/?action=catalog_review_remove&id='.Db::InsertId();
	                        $sSubject=Base::$language->getMessage('отзыв на товар ').'('.Base::$aRequest['data']['ref'].')';
	                        $aBody=String::GetSmartyTemplate('review:letter', array('user_data'=>$aReviewInsert),false);
	                        Mail::AddDelayed(Base::GetConstant('review:email','zhen4ek@gmail.com'),$sSubject,$aBody['parsed_text']);
	                        Base::$aRequest['ref']=Base::$aRequest['data']['ref'];
	                        if(Base::$aRequest['xajax'])
	                            Base::$oResponse->AddScript("$('.js-add-comment-form').slideToggle(150);");
	                        self::ViewReviewShow();
	            }
	        }else{
	            $sMess=Language::getMessage('no valid capcha!');
	        }
	        $oCpacha= new Capcha();
	        //Base::$oResponse->AddAssign('review_capcha','innerHTML',$oCpacha->GetMathematic());
	        if(Base::$aRequest['xajax'])
	            Base::$oResponse->AddAssign('review_capcha','innerHTML',$oCpacha->GetGraphics());
	        if(Base::$aRequest['xajax'])
	            Base::$oResponse->AddAssign('review_message','innerHTML','<div class="error_p">'.$sMess.'</div>');
	        return 13;
	    }elseif($aReview){
	        if(Base::$aRequest['data']['edit']){
	            $aReviewInsert=array(
	                'text'=>htmlspecialchars(trim(Base::$aRequest['data']['text'])),
	            );
	            Db::AutoExecute('review',$aReviewInsert,'UPDATE'," id='".Base::$aRequest['data']['id']."'");
	            $sSubject=Base::$language->getMessage('редактирование отзыва о товаре ').'('.Base::$aRequest['data']['ref'].')';
	            //if(!Base::$aRequest['xajax']){
	            $aCode = explode('_', Base::$aRequest['data']['ref']);
	            $sCat = Db::GetOne("SELECT name FROM cat WHERE pref like '".$aCode[0]."'");
	            $aReview['url']=Base::GetConstant('global:project_url').'/buy/'.$sCat.'_'.$aCode[1];
	            //}else{
	            //	$aReview['url']=Base::GetConstant('global:project_url').$_SERVER['REQUEST_URI'];
	            ///}
	            $aText=String::GetSmartyTemplate('review:text_reply', array('user_data'=>$aReview),false);
	            Mail::AddDelayed($aReview['email'],$sSubject,htmlspecialchars($aText['parsed_text']
	                .trim(str_replace ("\n", '<br>', $aReview['text']))
	                .'<br>'.trim(str_replace ("\n", '<br>', Base::$aRequest['data']['text']))
	            ),
	                trim(Base::$aRequest['data']['email']),trim(Base::$aRequest['data']['name']));
	        }else{
	            if(Auth::$aUser['type_']=='manager')
	                $sCommentText = trim(Base::$aRequest['data']['text']);
	            else
	                $sCommentText = htmlspecialchars(trim(Base::$aRequest['data']['text']));
	            $aReviewInsert=array(
	                'id_user'=>Auth::$aUser['id'],
	                'name'=>trim(Base::$aRequest['data']['name']),
	                'email'=>trim(Base::$aRequest['data']['email']),
	                'text'=>$sCommentText,
	                'reference'=>Base::$aRequest['data']['ref'],
	                'parent_id'=>$aReview['id']
	            );
	            Db::AutoExecute('review',$aReviewInsert);
	            $sSubject=Base::$language->getMessage('ответ на отзыв о товаре ').'('.Base::$aRequest['data']['ref'].')';
	            //if(!Base::$aRequest['xajax']){
	            $aCode = explode('_', Base::$aRequest['data']['ref']);
	            $sCat = Db::GetOne("SELECT name FROM cat WHERE pref like '".$aCode[0]."'");
	            $aReview['url']=Base::GetConstant('global:project_url').'/buy/'.$sCat.'_'.$aCode[1];
	            //}else{
	            //	$aReview['url']=Base::GetConstant('global:project_url').$_SERVER['REQUEST_URI'];
	            //}
	            $aText=String::GetSmartyTemplate('review:text_reply', array('user_data'=>$aReview),false);
	            Mail::AddDelayed($aReview['email'],$sSubject,htmlspecialchars($aText['parsed_text'].
	                trim(str_replace ("\n", '<br>', Base::$aRequest['data']['text']))),
	                trim(Base::$aRequest['data']['email']),trim(Base::$aRequest['data']['name']));
	        }
	        if(Base::$aRequest['xajax'])
	            Base::$oResponse->AddScript("$('.js-add-comment-form').slideToggle(150);");
	        Catalog::ViewReviewShow();
	    }
	    Catalog::ViewReviewShow();
	}
	Base::$tpl->assign('sRef',strtoupper(Base::$aRequest['data']['ref']));
	if(Base::$aRequest['data']['id']){
	    if($aReview){
	        if(Base::$aRequest['data']['edit']){
	            Base::$aRequest['data']['text']=$aReview['text'];
	        }
	    }else{
	        if(Base::$aRequest['xajax'])
	            Base::$oResponse->AddAssign('popup_form','innerHTML',Language::getMessage('not found'));
	    }
	}
	Base::$tpl->assign('sRef',strtoupper(Base::$aRequest['data']['ref']));
	Base::$tpl->assign('aData',Base::$aRequest['data']);
	if(Auth::$aUser['id'])
	    Base::$tpl->assign('iStar',Db::GetOne("SELECT stars*20 as stars from rating_catalog WHERE id_user = ".Auth::$aUser['id']." and item_code like '".Base::$aRequest['data']['ref']."'"));
	else{
	    Base::$tpl->assign('iStar','80');
	}
	$oCpacha= new Capcha();
	//Base::$tpl->assign('sCapcha',$oCpacha->GetMathematic());
	Base::$tpl->assign('sCapcha',$oCpacha->GetGraphics());
	if(Base::$aRequest['xajax'])
	    Base::$oResponse->AddAssign('popup_form_2','innerHTML',Base::$tpl->fetch($this->sPrefix.'/form_review.tpl'));
	}
	//--------------------------------------------------------------------------------------------------------------------
	public function Stars()
	{
	    if(!Base::$aRequest['xajax'] || !Base::$aRequest['product']) return;
	    if(!Base::$aRequest['stars']){
	        Base::$tpl->assign('sItemCode',Base::$aRequest['product']);
	        Base::$oResponse->AddAssign('popup_form','innerHTML',Base::$tpl->fetch('catalog/form_stars.tpl'));
	    }else{
	       if(Base::$aRequest['stars']>0 && Base::$aRequest['stars']<6){
	            Base::$db->Execute($s="INSERT IGNORE rating_catalog set item_code='".Base::$aRequest['product']."',
					id_user='".Auth::$aUser['id']."', stars='".Base::$aRequest['stars']."'");
	         }
	        Catalog::GetStars(Base::$aRequest['product']);
	        Base::$oResponse->AddAssign('id_stars_'.Base::$aRequest['product'],'outerHTML',Base::$tpl->fetch('catalog/stars.tpl'));
	        Base::$tpl->assign('iStarPercent', Base::$aRequest['stars']*20);
	        Base::$oResponse->AddAssign('rating-new','innerHTML',Base::$tpl->fetch('catalog/stars_new.tpl'));
	        $aTextRating = array(
	            '1'=>Language::GetMessage('one star'),
	            '2'=>Language::GetMessage('two star'),
	            '3'=>Language::GetMessage('thee star'),
	            '4'=>Language::GetMessage('four star'),
	            '5'=>Language::GetMessage('five star')
	        );
	        Base::$oResponse->AddAssign('rating-text','innerHTML',$aTextRating[Base::$aRequest['stars']]);
	    }
	      //  Debug::PrintPre(Base::$aRequest['stars']);
	}
	//-----------------------------------------------------------------------------------------------
	public function GetStars()
	{
	    //$sItemCode=Base::$aRequest['product'];
	    $aStars=Db::GetRow("select avg(stars) a,count(stars) c from rating_catalog
			where item_code='".Base::$aRequest['product']."'");
	    if(!$aStars){
	        $sStars='00';
	        $sStarsCount=0;
	    }else{
	        $sStarsCount=$aStars['c'];
	        $sStars=round($aStars['a'],1)*10;
	        $sStars=str_pad($sStars,2,"0",STR_PAD_LEFT);
	        if($sStars[1]>0 && $sStars[1]<=3) $sStars[1]='0';
	        elseif($sStars[1]>3 && $sStars[1]<=7) $sStars[1]='5';
	        elseif($sStars[1]>7){
	            $sStars[1]='0';
	            $sStars[0]=$sStars[0]+1;
	        }
	        if(Auth::$aUser['id']){
	            $sMyStars=Db::GetOne("select stars from rating_catalog
				where item_code='".Base::$aRequest['product']."' and id_user='".Auth::$aUser['id']."'");
	            Base::$tpl->assign('sMyStars',$sMyStars);
	            //Debug::PrintPre($sMyStars);
 	        }
 	    }
	    
	    Base::$tpl->assign('sStars',$sStars);
	    Base::$tpl->assign('sStarsCount',$sStarsCount);
	    return array('sStars'=>$sStars,'sStarsCount'=>$sStarsCount,'sMyStars'=>$sMyStars);
	   
	}
	//-----------------------------------------------------------------------------------------------
	public function CatalogProduct()
	{
		//если выбран родитель
		$aChild=Db::getAssoc("select id, id_parent from ec_products where id_parent != 0");
		if(in_array(Base::$aRequest['product'], $aChild) === true){
			Base::Redirect('/?action=missing');
		}

		if(Base::$aRequest['testsql'] == '1') Db::Debug();		//Обрий 02.12.2016	    
	    PriceSearchLog::AddSearch();
	    //Favourites::AddFavourites();
	if (Auth::$aUser['id'] && Auth::$aUser['type_']=='customer')
	    {
	        $sSql ="select id_customer_group from user_customer where id_user='".Auth::$aUser['id']."'";
	        $iCustomerGroup = Db::getOne($sSql);
	        $this->id_customer_group = $iCustomerGroup;
	    }
	    elseif (Auth::$aUser['id'] && Auth::$aUser['type_']=='manager')
	    {
	        $sSql ="select id_customer_group from user_manager where id_user='".Auth::$aUser['id']."'";
	        $iCustomerGroup = Db::getOne($sSql);
	        $this->id_customer_group = $iCustomerGroup;
	    }else
	    {
	        $iCustomerGroup =1;
	        $this->id_customer_group = $iCustomerGroup;
	    }
	    if (Auth::$aUser['id'] && Auth::$aUser['type_']=='customer')
	    {
			$User_discount=Auth::$aUser['id'];
			$Discounts=Db::GetOne("select count( * ) from ec_discounts di where id_region='".$this->iIdRegion."' and id_user='".$User_discount."' ");
	    }
	    elseif (Auth::$aUser['id'] && Auth::$aUser['type_']=='manager')
	    {
			$User_discount=Db::GetOne("select id_customer_partner as user_discount from user_manager um where id_user='".Auth::$aUser['id']."' ");
			$Discounts=Db::GetOne("select count( * ) from ec_discounts di where id_region='".$this->iIdRegion."' and id_user='".$User_discount."' ");
	    }
	    
	    $aProduct=Db::GetRow(Base::GetSql("EcProductVidRegion",array(
	        'id'=>Base::$aRequest['product'],
	        'id_region'=>$this->iIdRegion,
	        'visible'=>1,
				'discounts'=>$Discounts,
				'user_discount'=>$User_discount,
	        'id_customer_group' => $iCustomerGroup
	    )));

	    $iTime = time();
	    $sTime = date("Y-m-d H:i:s", $iTime);
	     
	    $aCondition=Db::GetAll("select p.id_parent,p.id as id_product,ch.id as ch_id,concat_ws(' ', gp.name,ch.info) as name, gp.color,ch.skidka,ch.id_type_skidka  from ec_condition_d as cd
        	        inner join ec_condition_h as ch on cd.id_condition_h=ch.id
        	        inner join ec_group_p as gp on ch.id_group_p=gp.id
	    			inner join ec_products p on p.id=cd.id_product
        	        where ch.dt1 < '".$sTime."' and ch.dt2 > '".$sTime."'
	    			and ch.id_group_p in(2,3) 
	    			and (ch.id_customer_group='". $this->id_customer_group ."' or ch.id_customer_group=0)
        	        and (ch.is_all_region=1 or ch.id_region='".$this->iIdRegion."') and ch.visible=1");		//obriy 04.12.2016
	    if ($aProduct) {
	    		$keyPrR=0;
	    		foreach($aCondition as $keyp2 => &$aValue2) {
	    			if($aProduct['id'] == $aValue2['id_product']){
	    				if ($aValue2['color']=='red')
	    					$aValue2['color']= '#ba0000';
	    					elseif ($aValue2['color']=='green')
	    					$aValue2['color']= '#8cb366';
	    					elseif  ($aValue2['color']=='')
	    					$aValue2['color']= 'blue';
	    					$aValue2['i']=$keyPrR+1;
	    					$aProduct['promo'][$keyPrR]= $aValue2;
	    					$keyPrR=$keyPrR+1;
	    					/*
	    					 $aRealProducts[$keyp]['condition']= $aRealProducts[$keyp]['condition'].' '.$aValue2['name'];
	    					 $aRealProducts[$keyp]['color']= $aValue2['color'];
	    					 */
	    			}
	    		}
	    	}
	    
	     
	    
	    $sTitle="";
	    $aTmp=array();
	    if (Auth::$aUser['id'])
	    {
	        $sSql ="select f.id_product,'true' from favourites as f where f.id_user='".Auth::$aUser['id']."'";
	        $aFavorites = Db::getAssoc($sSql);
	    }
	    else
	    {
	        $sSql ="select f.id_product,'true' from favourites as f where f.id_session='".session_id()."'";
	        $aFavorites = Db::getAssoc($sSql);
	    }
	    if($aFavorites[Base::$aRequest['product']]){
	        $aProduct['is_fav'] = true;
	    }
	    else{
	        $aProduct['is_fav'] = false;
	    }
	    
	    //Debug::PrintPre($aProduct['id_brand_group']);
	    
	    $sClassBrand = Db::GetOne('select class from ec_brand_group where id='.$aProduct['id_brand_group']);
	    Base::$tpl->assign('sClassBrand',$sClassBrand);
	    
	    $iIdBrandGroup = $aProduct['id_brand_group'];
	    Base::$tpl->assign('iIdBrandGroup',$iIdBrandGroup);
	    
	    $aSelectedGroup=Db::GetRow(Base::GetSql('EcBrandGroup',array(
	        'id'=>$aProduct['id_brand_group']
	    )));
	    $aSelectedBrand=Db::GetRow(Base::GetSql("EcBrand",array(
	        'id'=>$aProduct['id_brand']
	    )));
	    $aSelectedVid=Db::GetRow(Base::GetSql("EcVid",array(
	        'id'=>$aProduct['id_vid']
	    )));
	    $sVidName=$aSelectedVid['name'];
	    if($aSelectedVid['id_parent']) {
	        $aSelectedVidParent=Db::GetRow(Base::GetSql("EcVid",array(
	            'id'=>$aSelectedVid['id_parent']
	        )));
	        $sVidName=$aSelectedVidParent['name'].' '.$sVidName;
	    }
	    //review add
	    //begin
	    if($aProduct['id']){
	        Base::$tpl->assign('sRef',strtoupper($aProduct['id']));
	        $sReviewContent = '';
	        $sCountReview=Db::GetOne("select count(*) c from review where reference='".strtoupper($aProduct['id'])."'
					and visible=1");
	        Base::$tpl->assign('sCountReview',$sCountReview);
	        $aReview=Db::GetAll(Base::GetSql("Catalog/Review"
	            , array("reference"=>$aProduct['id'])
	        ));
	        if($aReview)
	            foreach ($aReview as $key => $value) {
	                $aReview[$key]['text']=  str_replace ("\n", '<br>', $value['text']);
	            }
	        Base::$tpl->assign('iReviewCount', count($aReview));
	    
	        $oTable=new Table();
	        $oTable->sType='array';
	        $oTable->aDataFoTable = $aReview;
	        $oTable->bHeaderVisible = false;
	        $oTable->aColumn['review']=array('sTitle'=>'review','sWidth'=>'15%');
	        $oTable->sClass = "comments-list";
	        $oTable->iRowPerPage=Base::GetConstant("info_part:review_count","20");
	        $oTable->sDataTemplate='catalog/review.tpl';
	        //$oTable->sNoItem='No reviews';
	        $oTable->sNoItem='&nbsp;';
	        $oTable->bStepperVisible=false;
	        $oTable->iRowPerPage=999;
	        /*if(count($aReview)>1){
	         $oTable->sClass = "hidden_table";
	         $sReviewContent .= $oTable->getTable();
	         $oTable->sClass = "display_table";
	         $oTable->aDataFoTable = array(0=>$aReview[0]);
	         $sReviewContent .= $oTable->getTable();
	         $sReviewContent .= Base::$tpl->fetch('catalog/more_review.tpl');
	         }else{*/
	        $sReviewContent .= $oTable->getTable();
	        //}
	        Catalog::GetStars($aProduct['id']);
	    }
	    $sReviewContent.=Base::$tpl->fetch('catalog/review_bottom.tpl');
	    if(!$oTable->aItem[0]){
	        Base::$tpl->assign('bNoReview',true);
	    }
	    
	    Base::$tpl->assign('sReviewContent',$sReviewContent);
	    //end 
	    //Base::$oContent->AddCrumb($aSelectedGroup['name'],'/?action=catalog_group&group='.$aSelectedGroup['id']);
	    Base::$oContent->AddCrumb($aSelectedBrand['name'],'/?action=catalog_brand&group='.$aSelectedGroup['id'].'&brand='.$aSelectedBrand['id']);
	    Base::$oContent->AddCrumb($sVidName,'/?action=catalog_vid&group='.$aSelectedGroup['id'].'&brand='.$aSelectedBrand['id'].'&vid='.$aSelectedVid['id']);
	    Base::$oContent->AddCrumb($aProduct['name'],'');
	    
	    //уже в корзине//
	    $iInCartAlready=Db::GetOne("select count(*) from cart where id_product='".Base::$aRequest['product']."' and id_user='".Auth::$aUser['id']."'");
	    Base::$tpl->assign('iInCartAlready',$iInCartAlready);
	    
	    Base::$tpl->assign('aPartInfo',$aProduct);
	    
	    $iTime = time();
	    $sTime = date("Y-m-d H:i:s", $iTime);
	    
	    $aCondition=Db::GetRow("select cd.id_product, gp.name from ec_condition_d as cd 
	        inner join ec_condition_h as ch on cd.id_condition_h=ch.id
	        inner join ec_group_p as gp on ch.id_group_p=gp.id
	        where cd.id_product='".Base::$aRequest['product']."' 
	    	and ch.id_group_p in(2,3) 
	    	and (ch.id_customer_group='". $this->id_customer_group ."' or ch.id_customer_group=0)
	        and ch.dt1 < '".$sTime."' and ch.dt2 > '".$sTime."' 
	        and (ch.is_all_region=1 or ch.id_region='".$this->iIdRegion."') and ch.visible=1");		//Обрий 04.12.2016
	    Base::$tpl->assign('aCondition',$aCondition);    //Обрий 03.12.2016	    

	    $aProductAssigned=Db::GetAll(Base::GetSql("EcProductVidRegion",array(
	        'id_parent'=>$aProduct['id_parent'],
	        'id_region'=>$this->iIdRegion,
				'discounts'=>$Discounts,
				'user_discount'=>$User_discount,
        'order'=>'order by (s.stock>=p.min_stock) desc,p.short_name desc',
	        'visible'=>1
	    )));
	    Base::$tpl->assign('aProductAssigned',$aProductAssigned);
	    //if product is not in base
        if (Base::$aRequest['product'] !=$aProduct['id']){
           Base::Redirect('/');
        }
	    
       
	    $aLog=Db::GetRow("select * from favourites where id_product='".Base::$aRequest['product']."' and id_user='".Auth::$aUser['id']."'");
	    Base::$tpl->assign('aLog',$aLog);
	    
	    $aProductParent=Db::GetRow("SELECT * FROM ec_products WHERE id_parent=0 and id='".$aProduct['id_parent']."' and visible=1");
	    
	    $sFavour=Base::$db->GetAll("select id_product from favourites where id_product=".Base::$aRequest['product']."
	        and (id_user='".Auth::$aUser['id']."' or id_session='".session_id()."')");
	    Base::$tpl->assign('sFavour',$sFavour);
	    Base::$tpl->assign('aProductParent',$aProductParent);
	    
	    $oCpacha= new Capcha();
	    Base::$tpl->assign('sCapcha',$oCpacha->GetGraphics());
	    Favourites::UpdateFavourites();
	    
	    $aPage['name']=$aProductParent['name'];
	    Base::$tpl->assign('aPage',$aPage);

	    $aDelivery = Db::GetAll("select id, name, num, description from delivery_type where visible=1 order by num asc");
	    Base::$tpl->assign('aDelivery',$aDelivery);
	    $aOplata = Db::GetAll("select name, description from payment_type where visible=1 order by num asc");
	    Base::$tpl->assign('aOplata',$aOplata);

	    Base::$sText.=Base::$tpl->fetch('catalog/info_part.tpl');
	    Base::$sText.=Home::GetPopularProducts();
	}
	//-----------------------------------------------------------------------------------------------
	public function ViewPrice() {
	    
	    PriceSearchLog::AddSearch();
	    //Favourites::AddFavourites();
	    
	    require_once(SERVER_PATH.'/lib/sphinx/sphinxapi.php');
	    $sSphinxKeyword=$this->GetSphinxKeyword(Base::$aRequest['code']);
	    
	    $oSphinxClient = new SphinxClient();
	    //----------- settings ------------------
// 	    $oSphinxClient->SetMatchMode(SPH_MATCH_EXTENDED2);

	    $oSphinxClient->SetMatchMode(SPH_MATCH_ALL);
//	    $oSphinxClient->SetMatchMode(SPH_MATCH_ANY);
	     
	    $oSphinxClient->SetSortMode(SPH_SORT_RELEVANCE);
// 	    $oSphinxClient->SetLimits(0,6);
	     
	    $oSphinxClient->SetFieldWeights(array (
	        'art' => 40,
	        'name' => 40,
	        'brand_group' => 5,
	        'vid' => 5,
	        'brand' => 10,
	    ));
	    //----------- settings ------------------
	    
	    $aResult = $oSphinxClient->Query($sSphinxKeyword, 'price_group_'.Base::$aDbConf['Database']);
	    
// 	    $aResult['matches'][1]=2231;
// 	    $aResult['matches'][2]=2233;

	    Base::$oContent->AddCrumb(Language::GetMessage('искомая фраза:').' '.Base::$aRequest['code'],'');
	    
		if (Auth::$aUser['id'] && Auth::$aUser['type_']=='customer')
	    {
	        $sSql ="select id_customer_group from user_customer where id_user='".Auth::$aUser['id']."'";
	        $iCustomerGroup = Db::getOne($sSql);
	        $this->id_customer_group = $iCustomerGroup;
	    }
	    elseif (Auth::$aUser['id'] && Auth::$aUser['type_']=='manager')
	    {
	        $sSql ="select id_customer_group from user_manager where id_user='".Auth::$aUser['id']."'";
	        $iCustomerGroup = Db::getOne($sSql);
	        $this->id_customer_group = $iCustomerGroup;
	    }else
	    {
	        $iCustomerGroup =1;
	        $this->id_customer_group = $iCustomerGroup;
	    }


		if(!Base::$aRequest['sort'] || Base::$aRequest['sort']=='name'){
			$ParentOrder=" order by v.sort,b.sort,p.name";	//(s.stock>=p.min_stock) desc,
			$RealOrder=" order by v.sort,b.sort,p.name,pri.name";	//(s.stock>=pri.min_stock) desc,
		}
		elseif(Base::$aRequest['sort']=='price'){
			if(Base::$aRequest['way']=='up'){
				$ParentOrder=" order by (s.stock>=p.min_stock) desc,pr.price asc";
				$RealOrder=" order by (s.stock>=pri.min_stock) desc,pr.price asc";
			}
			else {
				$ParentOrder=" order by (s.stock>=p.min_stock) desc,pr.price desc";
				$RealOrder=" order by (s.stock>=pri.min_stock) desc,pr.price desc";
			}
		}
		elseif(Base::$aRequest['sort']=='new'){
			$ParentOrder=" order by (s.stock>=p.min_stock) desc,v.sort,b.sort,p.name";
			$RealOrder=" order by (s.stock>=pri.min_stock) desc,v.sort,b.sort,p.name,pri.name";
		}
		else{
			$ParentOrder=" order by (s.stock>=p.min_stock) desc,v.sort,b.sort,p.name";
			$RealOrder=" order by (s.stock>=pri.min_stock) desc,v.sort,b.sort,p.name,pri.name";
		}

	    if (Auth::$aUser['id'] && Auth::$aUser['type_']=='customer')
	    {
			$User_discount=Auth::$aUser['id'];
			$Discounts=Db::GetOne("select count( * ) from ec_discounts di where id_region='".$this->iIdRegion."' and id_user='".$User_discount."' ");
	    }
	    elseif (Auth::$aUser['id'] && Auth::$aUser['type_']=='manager')
	    {
			$User_discount=Db::GetOne("select id_customer_partner as user_discount from user_manager um where id_user='".Auth::$aUser['id']."' ");
			$Discounts=Db::GetOne("select count( * ) from ec_discounts di where id_region='".$this->iIdRegion."' and id_user='".$User_discount."' ");
	    }

	    
	    $aData=array();
	    if(count($aResult['matches'])>0) {
	/*
			$aData=Db::GetAll(Base::GetSql("EcProductVidRegion",array(
    	        'id_products'=>"'".implode("','",array_keys($aResult['matches']))."'",
    	        'id_region'=>$this->iIdRegion,
        		'visible'=>1,
				'order'=>'order by (s.stock>= 5) desc,v.sort,b.sort,p.name',
	       		'id_customer_group' => $this->id_customer_group
		    )));
	*/		
		if(!Base::$aRequest['table'] || Base::$aRequest['table']!='line')
	    $aData=Db::GetAll(Base::GetSql("EcProductVidRegion",array(
   	        'id_products'=>"'".implode("','",array_keys($aResult['matches']))."'",
	        'id_region'=>$this->iIdRegion,
	        'visible'=>1,
				'discounts'=>$Discounts,
				'user_discount'=>$User_discount,
	        'where'=>" and p.id_parent = 0 and v.visible=1 ",
	        'id_customer_group' => $this->id_customer_group ,
//			'order'=>'order by (s.stock>= 5) desc,v.sort,b.sort,p.name'
	    	'order'=>$ParentOrder			//" order by (s.stock>= 5) desc,v.sort,b.sort,p.name"	    	//Обрий 15.12.2016		p.sort
	    )));
		else			
		$aData = Db::GetAll(Base::GetSql("EcProductVidRegionLine",array(
//   	        'id_products'=>"'".implode("','",array_keys($aResult['matches']))."'",
   	        'id_parents'=>"'".implode("','",array_keys($aResult['matches']))."'",
			'id_region'=>$this->iIdRegion,
	        'visible'=>1,
				'discounts'=>$Discounts,
				'user_discount'=>$User_discount,
//	        'where'=>" and pri.id_parent <> 0 ",
//	        'real'=>1,
	        'id_customer_group' => $this->id_customer_group, 
//			'order'=>'order by (s.stock>= 5) desc,v.sort,b.sort,p.name'
	    	'order'=>$RealOrder					//" order by (s.stock>= 5) desc,v.sort,b.sort,p.name,pri.name"	    	//Обрий 03.12.2016		pri.sort   v.sort,b.sort,p.name
	    )));

	    }
	    if(count($aData)>0){
	    $oTable=new Table();
	    $oTable->sType='array';
	    $oTable->aDataFoTable=$aData;
	    $oTable->sNoItem='No items';
	    $oTable->aColumn['image']=array('sWidth'=>'1%');
	    $oTable->aColumn['brand']=array('sTitle'=>'brand','sOrder'=>'b.name');
	    $oTable->aColumn['art']=array('sTitle'=>'art','sOrder'=>'p.art');
	    $oTable->aColumn['name']=array('sTitle'=>'name','sOrder'=>'p.name');
	    $oTable->aColumn['weight']=array('sTitle'=>'weight','sOrder'=>'p.weight');
	    $oTable->aColumn['volume']=array('sTitle'=>'volume','sOrder'=>'p.volume');
	    $oTable->aColumn['pack_qty']=array('sTitle'=>'pack_qty','sOrder'=>'p.pack_qty');
	    $oTable->aColumn['stock']=array('sTitle'=>'stock','sOrder'=>'s.stock');
	    $oTable->aColumn['price']=array('sTitle'=>'price','sOrder'=>'pr.price');
	    $oTable->aColumn['action']=array('sTitle'=>'buy');
	     
	    $oTable->aCallback=array($this,'CallProductParse');
	    $oTable->iRowPerPage=40;
 	    $oTable->bStepperVisible=true;
	    $oTable->sDataTemplate = "catalog/row_product.tpl";
	    if(Base::$aRequest['table']){
    	    switch (Base::$aRequest['table']) {
    	        case 'thumb':
    	            $oTable->sDataTemplate="index_include/row_thumb.tpl";
    	            $oTable->sClass='nodatatable';
	                $oTable->sTemplateName = 'index_include/thumb_vid_table.tpl';
    	            break;
    	        case 'line':
    	            $oTable->sDataTemplate="index_include/row_line.tpl";
    	            $oTable->sClass='nodatatable';
	                $oTable->sTemplateName = 'index_include/line_vid_table.tpl';
    	            break;
    	        case 'list':
    	            $oTable->sDataTemplate="index_include/row_list.tpl";
    	            $oTable->sClass='nodatatable';
	                $oTable->sTemplateName = 'index_include/list_vid_table.tpl';
    	            break;
    	    }
	    }else{
	        $oTable->sDataTemplate="index_include/row_thumb.tpl";
	        $oTable->sClass='nodatatable';
	        $oTable->sTemplateName = 'index_include/thumb_vid_table.tpl';
	    }
	    $aGetTable=$oTable->getTable();
	    Base::$tpl->assign('sPriceTable',$aGetTable);
	    
				$sGroupChangeTableUrl=$_SERVER['REQUEST_URI'];
				$iQstPos=strpos($sGroupChangeTableUrl, '?');
				if(!Base::$aRequest['table'] && $iQstPos!==false) $sGroupChangeTableUrl.='';
				elseif(!Base::$aRequest['table'] && $iQstPos===false) $sGroupChangeTableUrl.='?table=';
				elseif(Base::$aRequest['table']) {
					if(strpos($sGroupChangeTableUrl, "table=thumb")){
						if(strpos($sGroupChangeTableUrl, "&table=thumb")){ $sGroupChangeTableUrl=str_replace("&table=thumb", "", $sGroupChangeTableUrl);}
						if(strpos($sGroupChangeTableUrl, "?table=thumb&")){ $sGroupChangeTableUrl=str_replace("?table=thumb&", "", $sGroupChangeTableUrl)."&table=";}
						if(strpos($sGroupChangeTableUrl, "?table=thumb")){ $sGroupChangeTableUrl=str_replace("?table=thumb", "?table=", $sGroupChangeTableUrl);}
					}
					if(strpos($sGroupChangeTableUrl, "table=list")){
						if(strpos($sGroupChangeTableUrl, "&table=list")){ $sGroupChangeTableUrl=str_replace("&table=list", "", $sGroupChangeTableUrl);}
						if(strpos($sGroupChangeTableUrl, "?table=list&")){$sGroupChangeTableUrl=str_replace("?table=list&", "?", $sGroupChangeTableUrl)."&table=";}
						if(strpos($sGroupChangeTableUrl, "?table=list")){$sGroupChangeTableUrl=str_replace("?table=list", "?table=", $sGroupChangeTableUrl);}
					}
					if(strpos($sGroupChangeTableUrl, "table=line")){
						if(strpos($sGroupChangeTableUrl, "&table=line")){ $sGroupChangeTableUrl=str_replace("&table=line", "", $sGroupChangeTableUrl);}
						if(strpos($sGroupChangeTableUrl, "?table=line&")){ $sGroupChangeTableUrl=str_replace("?table=line&", "?", $sGroupChangeTableUrl)."&table=";}
						if(strpos($sGroupChangeTableUrl, "?table=line")){ $sGroupChangeTableUrl=str_replace("?table=line", "?table=", $sGroupChangeTableUrl);}
					}
				}
				Base::$tpl->assign('sGroupChangeTableUrl',$sGroupChangeTableUrl);

	    Base::$sText.=Base::$tpl->fetch('index_include/custom_search.tpl');
	    }
	    else{
	            Base::$sText.=Base::$tpl->fetch('search/empty.tpl');
	            return;
	    }
	    $iNumber = Favourites::UpdateFavourites();
	    Base::$tpl->assign('favNum', $iNumber);
	   
	}
	//-----------------------------------------------------------------------------------------------
	public function GetSphinxKeyword($sQuery)
	{
	    //return $sQuery;
	    $sQuery=  str_replace('/', '\/', $sQuery);
	    $sQuery=  str_replace('-', '', $sQuery);
	    $aRequestString=preg_split('/[\s,]+/', $sQuery, 5);
	
	    if ($aRequestString) {
	        foreach ($aRequestString as $sValue)
	        {
	            if (strlen($sValue)>=3)
	            {
	                //$aKeyword[] .= "*".$sValue."*";
	                $aKeyword[] .= "(".$sValue." | *".$sValue."*)";
	                //$aKeyword[] .= $sValue;
	            }
	        }
	        if ($aKeyword) $sSphinxKeyword = implode(" & ", $aKeyword);
	    }
	    return $sSphinxKeyword;
	}
	//-----------------------------------------------------------------------------------------------
	/**
	 * Remove ' ','-','#','.','/',',','_',':','[',']','(',')','*','&','+' from code and UPER
	 *
	 * @param string $sCode
	 * @return string
	 */
	public static function StripCode($sCode)
	{
		return strtoupper(str_replace(array('=',' ','-','#','.','/',',','_',':','[',']','(',')','*','&','+','`','\'','"','\\',' ', '%'),"",trim($sCode)));
	}
	//-----------------------------------------------------------------------------------------------
	public static function StripLogin($sCode)
	{
		return str_replace(array(' ','#','.','/',',','_',':','[',']','(',')','*','&','+','`','\'','"','\\'),"",trim($sCode));
	}
	//-----------------------------------------------------------------------------------------------
	/* not del space and not upper symbols*/
	public static function StripCodeSearch($sCode)
	{
		return str_replace(array('%','-','#','.','/',',','_',':','[',']','(',')','*','&','+','`','\'','"','\\'),"",trim($sCode));
	}
	
	/**
	 * Add sql replace
	 *
	 * @param string $sField
	 * @return string Sql
	 */
	public static function StripCodeSql($sField)
	{
		return "replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(UPPER(".$sField."),' ',''),'-',''),'#',''),'.',''),'/',''),',',''),'_',''),':',''),'[',''),']',''),'(',''),')',''),'*',''),'&',''),'+',''),'`',''),'\"',''),'\'','') ";
	}
	//-----------------------------------------------------------------------------------------------
	public function SortTable() {
		Base::$tpl->assign('sTablePriceSort','name');
		Base::$tpl->assign('sTablePriceSortWay','asc');
	
		if (!Base::$aRequest['sort'])
			Base::$aRequest['sort'] = 'name';
			
		if (!Base::$aRequest['way'])
			Base::$aRequest['way'] = 'up';
			
		Base::$tpl->assign('sTablePriceSort',Base::$aRequest['sort']);
		Base::$tpl->assign('sTablePriceSortWay',Base::$aRequest['way']);
	
		// cut order table
		if (strpos($_SERVER['REQUEST_URI'],'?') !== false) {
			Base::$tpl->assign('iSeoUrlAmp',1);
			$aSeoUrl = explode("&",str_replace("?","",str_replace("/?","",$_SERVER['REQUEST_URI'])));
		}
		else
			$aSeoUrl = explode("/",$_SERVER['REQUEST_URI']);
	
		$aSeoUrlSave = $aSeoUrl;
		foreach($aSeoUrl as $iKey => $sValue) {
			if (strpos($sValue, 'sort=') !== false || strpos($sValue, 'way=') !== false)
				unset($aSeoUrlSave[$iKey]);
		}
		$aSeoUrl = $aSeoUrlSave;
	
		if (strpos($_SERVER['REQUEST_URI'],'?') !== false)
			$sSeoUrl = "/?".implode("&",$aSeoUrl);
		else
			$sSeoUrl = implode("/",$aSeoUrl);
	
		Base::$tpl->assign('sSeoUrl',$sSeoUrl);
	
	}
	//-----------------------------------------------------------------------------------------------
	public function Export($aExport){
		
	 	$iTime = time();
	    $sTime = date("Y-m-d H:i:s", $iTime);
	   
	    $aCondition=Db::GetAll("select p.id_parent,p.id as id_product,ch.id as ch_id,concat_ws(' ', gp.name,ch.info) as name, gp.color,ch.skidka,ch.id_type_skidka  from ec_condition_d as cd
        	        inner join ec_condition_h as ch on cd.id_condition_h=ch.id
        	        inner join ec_group_p as gp on ch.id_group_p=gp.id
	    			inner join ec_products p on p.id=cd.id_product
        	        where ch.dt1 < '".$sTime."' and ch.dt2 > '".$sTime."'
	    			and ch.id_group_p in(2,3) 
	    			and (ch.id_customer_group='". $this->id_customer_group ."' or ch.id_customer_group=0)
        	        and (ch.is_all_region=1 or ch.id_region='".$this->iIdRegion."') and ch.visible=1");		//obriy 04.12.2016
	    
	    if ($aExport) {
	    	foreach ($aExport as $keyexp => &$valueexp) {
	    		$keyPrR=0;
	    		foreach($aCondition as $keyp2 => &$aValue2) {
	    			if($aExport[$keyexp]['id'] == $aValue2['id_product']){
	    					$aExport[$keyexp]['promo'][$keyPrR]= $aValue2;
	    			}
	    		}
	    	}

	    	
	        $oExcel = new Excel();
	        $aHeader=array(
	            'A'=>array("value"=>'id'),
	            'B'=>array("value"=>'name'),
	            'C'=>array("value"=>'short_name'),
	            //'D'=>array("value"=>'art'),
	            'D'=>array("value"=>'barcode'),
	            //'F'=>array("value"=>'weight'),
	            //'G'=>array("value"=>'volume'),
	            //'H'=>array("value"=>'pack_qty'),
	            //'I'=>array("value"=>'image'),
	            //'I'=>array("value"=>'min_stock'),
	            //'J'=>array("value"=>'cat_name'),
	            //'K'=>array("value"=>'stock'),
	            //'L'=>array("value"=>'distributor'),
	            //'M'=>array("value"=>'brand_group'),
	            'E'=>array("value"=>'price'),
	            //'P'=>array("value"=>'base_price'),
	            //'O'=>array("value"=>'discount'),
	            //'P'=>array("value"=>'kf_discount'),
	        );
	        $oExcel->SetHeaderValue($aHeader,1,false);
	        $oExcel->SetAutoSize($aHeader);
	        $oExcel->DuplicateStyleArray("A1:U1");
	
	        $i=$j=2;

	        foreach ($aExport as $aValue)
	        {
	            /*$sMake=substr($aValue['item_code'],0,2);
	            if (strlen($aValue['cat_name'])==2) $sMake=$aValue['cat_name'];
	            $sMake=str_ireplace('LX','LS',$sMake);
	            $sMake=str_ireplace('HY','HU',$sMake);*/
	
	            $oExcel->setCellValue('A'.$i, $aValue['id']);
	            $oExcel->setCellValue('B'.$i, $aValue['name']);
	            $oExcel->setCellValue('C'.$i, $aValue['short_name']);
	           // $oExcel->setCellValue('D'.$i, $aValue['art']);
	            $oExcel->setCellValue('D'.$i, $aValue['barcode']);
	            //$oExcel->setCellValue('F'.$i, $aValue['weight']);
				//$oExcel->setCellValue('G'.$i, $aValue['volume']);
				//$oExcel->setCellValue('H'.$i, $aValue['pack_qty']);
				//$oExcel->setCellValue('I'.$i, 'http://www.moregoods.com.ua'.$aValue['image']);
				//$oExcel->setCellValue('I'.$i, $aValue['min_stock']);
				//$oExcel->setCellValue('J'.$i, $aValue['cat_name']);
				//$oExcel->setCellValue('K'.$i, $aValue['stock']);
				//$oExcel->setCellValue('L'.$i, $aValue['distributor']);
				//$oExcel->setCellValue('M'.$i, $aValue['brand_group']);

				if(Base::$aRequest['action']=='catalog_vid'){
					
					if($aValue['promo'][0]['skidka']==0){
					$oExcel->setCellValue('E'.$i, $aValue['price']);
					}
					else{
					if($aValue['promo'][0]['id_type_skidka']==3){
						
						$sNumber=$aValue['base_price']*$aValue['promo'][0]['skidka'];
						$oExcel->setCellValue('E'.$i, number_format($sNumber, 2, '.', ''));
					}
					else{
						$sNumber=$aValue['price']*$aValue['promo'][0]['skidka'];
						$oExcel->setCellValue('E'.$i, number_format($sNumber, 2, '.', ''));
					}
				}
				}else{
				//----
				if($aValue['skidka']==0){
					$oExcel->setCellValue('E'.$i, $aValue['price']);
				}
				else{
					if($aValue['id_group_p']==3){
						$sNumber=$aValue['base_price']*$aValue['skidka'];
						$oExcel->setCellValue('E'.$i, number_format($sNumber, 2, '.', ''));
					}
					else{
						$sNumber=$aValue['price']*$aValue['skidka'];
						$oExcel->setCellValue('E'.$i, number_format($sNumber, 2, '.', ''));
					}
				}
				//----
				}
				//$oExcel->setCellValue('P'.$i, $aValue['base_price']);
				//$oExcel->setCellValue('O'.$i, $aValue['discount']);
				//$oExcel->setCellValue('P'.$i, $aValue['kf_discount']);

	            $i++;
	        }
	        //end 
	        foreach ($aExport as $key => $value) {
	        	$aExport['brand_group']=$value['brand_group'];
	        	$aExport['vid']=$value['vid'];
	        }
	        if(Base::$aRequest['action']=='catalog_vid'){
	        $sFileName=$aExport['brand_group'].'_'.$aExport['vid'].'.xls';
	    	}else{
	    	$sFileName=$aExport['brand_group'].'_Акція'.'.xls';
	    	}
	        $oExcel->WriterExcel5(SERVER_PATH.'/imgbank/temp_upload/'.$sFileName, true);
	    }

	    else $sFileName='EmptyData.xls';
	    Base::$tpl->assign('sFileName',$sFileName);
	    Base::$sText.=Base::$tpl->fetch('manager/export.tpl');
	}
	//-----------------------------------------------------------------------------------------------
}
?>