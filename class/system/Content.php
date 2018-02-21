<?
/**
 * @author Mikhail Strovoyt
 */

class Content extends Base
{
	private $aDropdownMenu=array();
	private $aAccountMenu=array();
	public $aCrumbs=array();
	
	
	var $iIdRegion;
	var $iCustomerGroup;
	//-----------------------------------------------------------------------------------------------
	function __construct()
	{
		Base::$tpl->assign_by_ref('oContent',$this);
		$oCurrency=new Currency();
		Base::$tpl->assign_by_ref('oCurrency', $oCurrency);
		Base::$oCurrency=$oCurrency;
		
		if ($_SESSION['user'] ) {
			$this->iCustomerGroup=$_SESSION['user']['id_customer_group'];
		    $this->iIdRegion=$_SESSION['user']['id_region'];
		}
		elseif($_SESSION['selected_city']) {
		
		$selected_city= $_SESSION['selected_city'];
		
        }
		if(!$this->iCustomerGroup)	$this->iCustomerGroup =1;		
		if(!$this->iIdRegion)	$this->iIdRegion=1;

		if($this->iCustomerGroup==1 || $this->iCustomerGroup==30) $iB2C_Interface=1;


		
		Base::$tpl->assign('B2C_Interface',$iB2C_Interface);

//			старое основное меню с брендами		
		$EcBrandGroup = Db::GetAssoc(Base::GetSql("EcBrandGroup",array('where' => ' and visible = 1 ')));
		$EcBrandInGroup=Db::GetAll(Base::GetSql("EcBrandInGroup",array('where' => ' and bigr.visible = 1 ')));
		foreach ($EcBrandInGroup as $BrandInGroup){
		    $EcBrandGroup[$BrandInGroup['id_brand_group']]['sub'][]=$BrandInGroup;
		}
		
if(Base::$aRequest['brand'])
	$sAddBrand='&brand='.Base::$aRequest['brand'];
if(Base::$aRequest['promo']){
	$sAddPromo='&promo='.Base::$aRequest['promo'];
	$sAction='?action=catalog_promo&group=';
	}
	else
	$sAction='?action=catalog_vid&group=';
	
//Меню с видами для каждой группы товаров		
		if($EcBrandGroup){
    		foreach ($EcBrandGroup as $sBaseGrKey => $aBaseValue){

//правое боковое меню			
    			$iTime = time();
    			$sTime = date("Y-m-d H:i:s", $iTime);
			if($OLD_Interface)
    			$EcBrandGroup[$sBaseGrKey]['biglist']=Db::GetAll("select distinct g.id,g.short_name as name,concat('?action=catalog_promo&group=','".$sBaseGrKey."','".$sAddBrand."','".$sAddPromo."','&promo=',g.id) as href 
    					
 ,g.sort as sort , 1 as types,".$sBaseGrKey." as id_group_br   					FROM ec_group_p g
 inner join ec_condition_h ch on ch.id_group_p=g.id and ch.visible=1 and ch.dt1 < '".$sTime."' and ch.dt2 > '".$sTime."'
 inner join ec_condition_d cd on cd.id_condition_h=ch.id
 inner join ec_products p on p.id=cd.id_product
 inner join ec_brand_in_region br on br.id_brand=p.id_brand
 where ch.id_group_p<>5 and p.id_brand_group='".$sBaseGrKey."' and br.id_region='".$this->iIdRegion."' and (br.id_brand='".Base::$aRequest['brand']."' or '".Base::$aRequest['brand']."'='')
	order by sort");//order by g.sort
					else
//для B2B влючаем поставщиков				
 			$EcBrandGroup[$sBaseGrKey]['biglist']=Db::GetAll("select distinct g.id,g.short_name as name,concat('?action=catalog_promo&group=','".$sBaseGrKey."','".$sAddBrand."','".$sAddPromo."','&promo=',g.id) as href 
    					
 ,g.sort as sort, 1 as types ,".$sBaseGrKey." as id_group_br    					FROM ec_group_p g
 inner join ec_condition_h ch on ch.id_group_p=g.id and ch.visible=1 and ch.dt1 < '".$sTime."' and ch.dt2 > '".$sTime."'
 inner join ec_condition_d cd on cd.id_condition_h=ch.id
 inner join ec_products p on p.id=cd.id_product
 inner join ec_brand_in_region br on br.id_brand=p.id_brand
 where  ch.id_group_p<>5 and p.id_brand_group='".$sBaseGrKey."' and br.id_region='".$this->iIdRegion."' and (br.id_brand='".Base::$aRequest['brand']."' or '".Base::$aRequest['brand']."'='')

 union all  
 select null,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',null,98, 2 as types,".$sBaseGrKey." as id_group_br
 union all  
 select null,'<b>Виробники</b>','?action=catalog_group&group=".$sBaseGrKey."' as href ,99, 3 as types,".$sBaseGrKey." as id_group_br
 union all  
 select  b.id,concat('&nbsp;&nbsp;&nbsp;',b.name,'&nbsp;&nbsp;&nbsp;') as name ,concat('?action=catalog_brand&group=','".$sBaseGrKey."','&brand=',b.id,'".$sAddPromo."') as href
    					,b.sort, 4 as types,".$sBaseGrKey." as id_group_br
 from ec_brand b
 inner join ec_brand_in_region br on br.id_brand=b.id
 inner join ec_brand_in_group  bgr on bgr.id_brand=b.id
  where  bgr.id_brand_group='".$sBaseGrKey."' and br.id_region='".$this->iIdRegion."'  order by sort");//order by g.sort




	    if (Base::$aRequest['promo']){
	    	$sJoin="
			inner join ec_products as pp on pp.id_parent=p.id
	    	inner join ec_condition_d as cd on cd.id_product=pp.id
	        inner join ec_condition_h as ch on cd.id_condition_h=ch.id and (ch.is_all_region=1 or ch.id_region='". $this->iIdRegion ."') and (ch.dt1 < '".$sTime."' and '".$sTime."' < ch.dt2 )
	    		    and ch.id_group_p<>5 and (ch.id_customer_group='".  $this->iCustomerGroup ."' or ch.id_customer_group=0) and ch.id_group_p='".Base::$aRequest['promo']."'";
	    			
	    }
 			
//добавить тожк самое в фильтр			
//			$aCatalogFilter[$sBaseGrKey]['biglist']=$EcBrandGroup[$sBaseGrKey]['biglist'];
			$aMenuColumns=Db::GetAll("select distinct col 
			from(
			select v.col from ec_vid v 
				inner join ec_product_in_vid piv on piv.id_vid=v.id 
				inner join ec_products p on p.id=piv.id_product and p.visible=1
				inner join ec_brand_in_region br on br.id_brand=p.id_brand
	    		
 		".$sJoin."

					where v.level=0  and v.visible=1 and p.id_parent=0  and p.id_brand_group='".$sBaseGrKey."' and br.id_region='".$this->iIdRegion."' and (br.id_brand='".Base::$aRequest['brand']."' or '".Base::$aRequest['brand']."'='')
			union all
			select v.col
				from ec_vid v 
				inner join ec_vid vp on v.id=vp.id_parent 
				inner join ec_product_in_vid piv on piv.id_vid=vp.id
				inner join ec_products p on p.id=piv.id_product and p.visible=1
				inner join ec_brand_in_region br on br.id_brand=p.id_brand
	    		
 		".$sJoin."

					where v.level=0  and v.visible=1 and vp.level=1 and p.id_parent=0 and p.id_brand_group='".$sBaseGrKey."' and br.id_region='".$this->iIdRegion."' and (br.id_brand='".Base::$aRequest['brand']."' or '".Base::$aRequest['brand']."'='')
				)v
			order by col;");
			
	
// берем по колонкам				
    		foreach ($aMenuColumns as $sMenuColumnKey => $aMenuColumnValue){
			 if ($aMenuColumnValue['col'])		
			 {
// берем список видов нулевого уровня для данной колонки - только там где есть товар			 
    			$EcBrandGroup[$sBaseGrKey]['col'][$sMenuColumnKey]['list']=Db::GetAll("select distinct v.id,v.name as name,concat('".$sAction."','".$sBaseGrKey."','".$sAddBrand."','".$sAddPromo."','&vid=',v.id) as href,v.col,v.sort ,v.id_brand_group as id_brand_gr
				from(
				select v.*,p.id_brand_group,br.id_region 				from ec_vid v 
						inner join ec_product_in_vid piv on piv.id_vid=v.id 
						inner join ec_products p on p.id=piv.id_product and p.visible=1
						inner join ec_brand_in_region br on br.id_brand=p.id_brand
	    		
 						".$sJoin."

    					where v.level=0  and v.visible=1 and v.col=".$aMenuColumnValue['col']." and p.id_parent=0  and p.id_brand_group='".$sBaseGrKey."' and br.id_region='".$this->iIdRegion."' and (br.id_brand='".Base::$aRequest['brand']."' or '".Base::$aRequest['brand']."'='')
				
				union all
				select v.*,p.id_brand_group,br.id_region 				from ec_vid v 
						inner join ec_vid vp on v.id=vp.id_parent 
						inner join ec_product_in_vid piv on piv.id_vid=vp.id
						inner join ec_products p on p.id=piv.id_product and p.visible=1
						inner join ec_brand_in_region br on br.id_brand=p.id_brand
	    		
 						".$sJoin."

    					where v.level=0  and v.visible=1 and vp.level=1 and v.col=".$aMenuColumnValue['col']." and p.id_parent=0  and p.id_brand_group='".$sBaseGrKey."' and br.id_region='".$this->iIdRegion."' and (br.id_brand='".Base::$aRequest['brand']."' or '".Base::$aRequest['brand']."'='')
					
				)v 		order by v.col,v.sort");

  if($EcBrandGroup[$sBaseGrKey]['col'][$sMenuColumnKey]['list'])
 foreach ($EcBrandGroup[$sBaseGrKey]['col'][$sMenuColumnKey]['list'] as $sBrKey => $aBrValue){

 //список основных видов в бренде в боковой фильтр	level = 1
//****--- 
//$aCatalogFilter[$sBaseGrKey]['list'][$aBrValue['id']]['sublist']=Db::GetAll("select distinct v.id,v.name as name,concat('/group/".$sBaseGrKey."','/subcategory/',v.id) as href,v.col ,p.id_brand
													//from ec_vid v 
//						inner join ec_product_in_vid piv on piv.id_vid=v.id 
//						inner join ec_products p on p.id=piv.id_product and p.visible=1
//						where v.level=1 and p.id_brand='".$sBaseGrKey."' and p.id_brand_group='".$id_brand_gr."' and v.id_parent='".$aBrValue['id']."' order by v.sort");

 // берем список подвидов первого уровня для данного вида - только те подвиды где есть товар			 
						$aSublist=Db::GetAll("select distinct v.id,concat('&nbsp;' ,v.name) as name,concat('".$sAction."','".$sBaseGrKey."','".$sAddBrand."','".$sAddPromo."','&vid=',v.id) as href,v.col 
													from ec_vid v 
						inner join ec_product_in_vid piv on piv.id_vid=v.id 
						inner join ec_products p on p.id=piv.id_product and p.visible=1
						inner join ec_brand_in_region br on br.id_brand=p.id_brand
	    		
 						".$sJoin."

						where v.level=1 and v.visible=1 and p.id_brand_group='".$sBaseGrKey."'  and p.id_parent=0 and br.id_region='".$this->iIdRegion."'  and (br.id_brand='".Base::$aRequest['brand']."' or '".Base::$aRequest['brand']."'='') and v.id_parent='".$aBrValue['id']."' order by v.sort");
			
						if ($aSublist) 	
						$EcBrandGroup[$sBaseGrKey]['col'][$sMenuColumnKey]['list'][$sBrKey]['sublist']=$aSublist;  
				
 				}
			}
			else
			{
    			$EcBrandGroup[$sBaseGrKey]['col'][0]['list']=Db::GetAll("select distinct v.id,v.name as name,concat('".$sAction."','".$sBaseGrKey."','".$sAddBrand."','".$sAddPromo."','&vid=',v.id) as href,v.col,v.sort ,v.id_brand_group as id_brand_gr
				from(
				select v.*,p.id_brand_group ,br.id_region,br.id_brand 				from ec_vid v 
						inner join ec_product_in_vid piv on piv.id_vid=v.id 
						inner join ec_products p on p.id=piv.id_product and p.visible=1
					
						inner join ec_brand_in_region br on br.id_brand=p.id_brand
	    		
 						".$sJoin."

    					where v.level=0   and v.visible=1 and p.id_parent=0
				union all
				select v.*,p.id_brand_group,br.id_region,br.id_brand  				from ec_vid v 
						inner join ec_vid vp on v.id=vp.id_parent 
						inner join ec_product_in_vid piv on piv.id_vid=vp.id
						inner join ec_products p on p.id=piv.id_product and p.visible=1
					
						inner join ec_brand_in_region br on br.id_brand=p.id_brand
    					
 						".$sJoin."

    					where v.level=0  and v.visible=1 and vp.level=1 and p.id_parent=0
				)v
				where  v.id_brand_group='".$sBaseGrKey."'   and v.id_region='".$this->iIdRegion."'  and (v.id_brand='".Base::$aRequest['brand']."' or '".Base::$aRequest['brand']."'='') order by v.col,v.sort");
    			foreach ($EcBrandGroup[$sBaseGrKey]['col'][0]['list'] as $sBrKey => $aBrValue){
    				$EcBrandGroup[$sBaseGrKey]['col'][0]['list'][$sBrKey]['sublist']=Db::GetAll("select distinct v.id,concat(' ' ,v.name) as name,concat('".$sAction."','".$sBaseGrKey."','".$sAddBrand."','".$sAddPromo."','&vid=',v.id) as href,v.col 
													from ec_vid v 
						inner join ec_product_in_vid piv on piv.id_vid=v.id 
						inner join ec_products p on p.id=piv.id_product and p.visible=1
					
						inner join ec_brand_in_region br on br.id_brand=p.id_brand    						
	    		
 						".$sJoin."

    					where v.level=1  and v.visible=1 and p.id_brand_group='".$sBaseGrKey."'   and p.id_parent=0 and br.id_region='".$this->iIdRegion."'  and (br.id_brand='".Base::$aRequest['brand']."' or '".Base::$aRequest['brand']."'='') and v.id_parent='".$aBrValue['id']."' order by v.sort");
				
				}
			}	
    		}
			}
		
		}
	
		if(!$_SESSION['selected_city_first']){
		    $_SESSION['selected_city_first'] = 0;
		}	
		//Debug::PrintPre($EcBrandGroup);
		Base::$tpl->assign('sSelectedCityFirst',$_SESSION['selected_city_first']);
		Base::$tpl->assign('EcBrandGroup',$EcBrandGroup);
	}
	//-----------------------------------------------------------------------------------------------
	public function CreateMainMenu()
	{
		if(Auth::$aUser['type_']=='manager'){
			$sCustomerGroup=Db::GetOne("select cg.name from customer_group cg inner join user_manager uc on uc.id_customer_group=cg.id where uc.id_user='".Auth::$aUser['id']."'");
			Base::$tpl->assign('sCustomerGroup',$sCustomerGroup);
			$sCustomerPartner=Db::GetOne("select uc.name from user_customer uc inner join user_manager um on um.id_customer_partner=uc.id_user where um.id_user='".Auth::$aUser['id']."'");
			if(	$sCustomerPartner){
			$sCustomerPartner='<br>'.Language::GetMessage("Price Client").' :'.$sCustomerPartner.'';
			Base::$tpl->assign('sCustomerPartner',$sCustomerPartner);
			}
		}

		$this->AssignCrumb();
		$this->DropdownGetCustom();
		Base::$tpl->assign('aDropdownMenu',$this->aDropdownMenu);

		$iMenuLeft=Db::GetOne("select id from drop_down where code='menu_left'");
		if ($iMenuLeft) {
			$aMenuLeft=Db::GetAll("select * from drop_down where id_parent=".$iMenuLeft." order by num");
			Base::$tpl->assign('aMenuLeft',$aMenuLeft);
		}

		if (Auth::$aUser['id']) {
		    if(!$this->aAccountMenu=FileCache::GetValue('Home', 'account_menu_'.Auth::$aUser['type_'])) {
    			$aAccount=Db::GetRow("select * from drop_down where code='".Auth::$aUser['type_']."_account'");
    			Base::$tpl->assign('iTopAccountMenu',$aAccount['id']);
    
    			$this->AccountGetChilds($aAccount['id']);
    			FileCache::SetValue('Home', 'account_menu_'.Auth::$aUser['type_'], $this->aAccountMenu);
		    }   
			Base::$tpl->assign('aAccountMenu',$this->aAccountMenu);
		}

		Base::$tpl->assign('bRightSectionVisible',Base::$bRightSectionVisible);

		$aData=array(
		'table'=>'drop_down',
		'where'=>" and t.id_parent='204' and t.visible=1 order by t.num",
		);
		$aHelpMenu=Language::GetLocalizedAll($aData);
		Base::$tpl->assign('aHelpMenu',$aHelpMenu);

		$this->ParseTemplate();
		Base::$oContent->ShowTimer('FullPage');
		Base::$tpl->assign('sTimer',  $this->sTimer);
	}
	//-----------------------------------------------------------------------------------------------
	public function LoadBanners() {
	    $aBanner=Db::GetAll("select * from banner where visible=1 and is_main=1 order by sort asc");
	    $aBannerVid=Db::GetAll("select * from banner where visible=1 and id_brand='".Base::$aRequest['brand']."' 
	    and id_brand_group = '".Base::$aRequest['group']."' order by sort asc");
	    if ($aBanner || $aBannerVid){
	        Base::$tpl->assign('aBanner',$aBanner);
	        Base::$tpl->assign('aBannerVid',$aBannerVid);
	        Base::$tpl->assign('iBannerCount', count($aBanner));
	    }
	}
	//-----------------------------------------------------------------------------------------------
	public  function DropdownGetCustom(){
	    if(!$aDropdown=FileCache::GetValue('Home', 'drop_down')) {
    		$aData=array(
    		'table'=>'drop_down',
    		'where'=>" and t.id_parent=0 and t.visible=1 and t.is_menu_visible=1 order by t.num",
    		);
    		$aDropdown=Base::$language->GetLocalizedAll($aData);
    		foreach ($aDropdown as $sKey => $aValue){
    			$aData=array(
    			'table'=>'drop_down',
    			'where'=>" and t.id_parent='".$aValue['id']."' and t.visible=1 order by t.num",
    			);
    			$aDropdown[$sKey]['childs']=Base::$language->GetLocalizedAll($aData);
    			if ($aDropdown[$sKey]['childs']) $aDropdown[$sKey]['childs_count']=count($aDropdown[$sKey]['childs']);
    			else $aDropdown[$sKey]['childs_count']=0;
    		}
    		FileCache::SetValue('Home', 'drop_down', $aDropdown);
	    }
		$this->aDropdownMenu=$aDropdown;
	}
	//-----------------------------------------------------------------------------------------------
	function DropdownGetChilds($iIdParent)
	{
		$aData=array(
		'table'=>'drop_down',
		'where'=>" and t.id_parent='$iIdParent' and t.visible=1 order by t.num",
		);
		$aDropdown=Base::$language->GetLocalizedAll($aData);

		if ($aDropdown) foreach ($aDropdown as $aValue) {
			$aValue['level_']=$aValue['level']+1;
			$this->aDropdownMenu[]=$aValue;
			if ($aValue['level']<=1) $this->DropdownGetChilds($aValue['id']);
		}
	}
	//-----------------------------------------------------------------------------------------------
	function AccountGetChilds($iIdParent)
	{
		$aData=array(
		'table'=>'drop_down',
		'where'=>" and id_parent='$iIdParent' and is_menu_visible=1 and visible=1 order by num",
		);
		$aDropdown=Base::$language->getLocalizedAll($aData);

		if ($aDropdown) foreach ($aDropdown as $aValue) {
			$aValue['level_']=$aValue['level']-1;
			$this->aAccountMenu[]=$aValue;
			if ($aValue['level']<=3) $this->AccountGetChilds($aValue['id']);
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function AddCrumb($sName,$sLink='')
	{
		$this->aCrumbs[]=array('name'=>$sName,'link'=>$sLink);
	}
	//-----------------------------------------------------------------------------------------------
	private function AssignCrumb()
	{
		if(count($this->aCrumbs)<=1) return;
		Base::$tpl->assign('aCrumbs',$this->aCrumbs);
	}
	//-----------------------------------------------------------------------------------------------
	public function DelAllCrumbs() {
		$this->aCrumbs = array();
		Base::$oContent->AddCrumb(Language::GetMessage('main page'),'/');
	}
	//-----------------------------------------------------------------------------------------------
	public function setTableDefault(&$oTable){
	    if(strpos($_SERVER['REQUEST_URI'],'mpanel')===false) {
	         
	        if ($oTable->sClass == 'datatable' && $oTable->sTemplateName != 'index_include/brandvid_table.tpl'){
	            $oTable->sTemplateName = 'home/table_template.tpl';
	            //$oTable->sClass = "catalog-inner_block";
	        }
// 	        elseif ($oTable->sDataTemplate == "catalog/row_vid.tpl")
// 	        {
// 	            $oTable->sClass = "datatable";
// 	        }
// 	        elseif($oTable->sClass == 'datatable' &&  $oTable->sTemplateName == 'catalog/search_table.tpl' && Auth::$aUser['type_']=='manager'){
// 	            $oTable->sClass = "catalog-inner_block";
// 	            $oTable->sTemplateName = 'catalog/search_table.tpl';
// 	        } 
// 	        elseif($oTable->sDataTemplate == 'cart/row_cart.tpl'){
// 	            $oTable->sTemplateName = 'catalog/search_table.tpl';
// 	            $oTable->sClass = "catalog-inner_block";
// 	        }
// 	        // 	        elseif(Auth::$aUser['type_']=='manager'){
// 	        // 	            $oTable->sClass = "datatable";
// 	        // 	        }
// 	        elseif ($oTable->sDataTemplate=='manager/row_order.tpl'){
// 	            $oTable->sTemplateName = 'catalog/search_table.tpl';
// 	            $oTable->sClass = "catalog-inner_block";
// 	        }
// 	        else
// 	            $oTable->sTemplateName = 'addon/table/index.tpl';
	         
	    }
	}
	//-----------------------------------------------------------------------------------------------
	public function ParseTemplate($bRefreshCartAjax=false)
	{
		if (Auth::$aUser['type_']=='manager' || Auth::$aUser['type_']=='customer') {
				$aTemplateNumber['cart_number']=Db::GetOne("select count(*) from cart where type_='cart' ".Auth::$sWhere);
				// correct round
				$aMass = Db::GetAll("select number,price from cart where type_='cart'
						and is_archive=0 ".Auth::$sWhere);
				foreach ($aMass as $aValue) 
					$aTemplateNumber['cart_total'] += $aValue['number'] * Base::$oCurrency->PrintPrice($aValue['price'],null,2,"<none>");

					if(!$aTemplateNumber['cart_total'])$aTemplateNumber['cart_total']=0;
					
			if (!$bRefreshCartAjax){
				$aTemplateNumber['cart_package_number']=Db::GetOne("select count(*) from cart_package where is_archive=0
					".Auth::$sWhere);
				$aTemplateNumber['order_number']=Db::GetOne("select count(*) from cart where type_='order'".Auth::$sWhere);
				//$aTemplateNumber['payment_report_id']=Db::GetOne("select count(*) from payment_report where is_read='0' or is_read is null");
				$aTemplateNumber['message_number']=Db::GetOne("select count(*) from message where (is_read='0' or is_read is null)
					and id_message_folder=1 and is_old='0' ".Auth::$sWhere);
			}
		}
		else $aTemplateNumber['cart_number']=0;
		
		if (Auth::$aUser['type_']=='customer') {
		    $aTemplateNumber['payment_declaration_id']=Db::GetOne("select count(*) from payment_declaration
		        where (is_read='0' or is_read is null) and id_user='".Auth::$aUser['id']."'");
		}
		
		else $aTemplateNumber['payment_declaration_id']=0;

		if ($bRefreshCartAjax) {
			Base::$oResponse->AddAssign('icart_id','innerHTML',$aTemplateNumber['cart_total']);
			Base::$oResponse->AddAssign('icart_total_id','innerHTML'
			,Base::$oCurrency->PrintSymbol($aTemplateNumber['cart_total']));
			Base::$oResponse->AddAssign('icart_info','innerHTML',
			'('.$aTemplateNumber['cart_number'].') ' . Base::$oCurrency->PrintPrice($aTemplateNumber['cart_total'],1,0,'line'));
			Base::$oResponse->AddAssign('cart_subtotal','innerHTML',Base::$oCurrency->PrintPrice($aTemplateNumber['cart_total']));
			Content::GetCartItems(true);
		}
		else {
			$aTemplateNumber['message_number']=Db::GetOne("select count(*) from message where is_read=0
					and id_message_folder=1 and is_old='0' ".Auth::$sWhere);
			Base::$tpl->assign('aTemplateNumber',$aTemplateNumber);
		}
		
		if (Auth::$aUser['type_']=='manager' ) {
		    $Number=Db::GetAll("select cp.*, uc.* from cart_package as cp 
		        inner join user_customer as uc on cp.id_user=uc.id_user
		        where cp.is_viewed=0 and uc.id_region='".Auth::$aUser['id_region']."'");
			//$iNotViewedOrders=Db::GetOne("select count(*) from cart_package where is_viewed=0 and id_region='".Auth::$aUser['id_region']."'");
		    $iNotViewedOrders=count($Number);
			Base::$tpl->assign('iNotViewedOrders',$iNotViewedOrders);
			$iNotViewedVins=Db::GetOne("select count(*) from vin_request vr
			inner join user u on vr.id_user=u.id
			inner join user_customer uc on uc.id_user=u.id
			inner join customer_group cg on uc.id_customer_group=cg.id
			inner join user m on uc.id_manager=m.id
			where is_viewed=0");
			Base::$tpl->assign('iNotViewedVins',$iNotViewedVins);
		}
		$iNumber = Favourites::UpdateFavourites();
		Base::$tpl->assign('favNum', $iNumber);
	}
	//-----------------------------------------------------------------------------------------------
	public static function Init()
	{
		$aBonus = Db::GetRow("select
            0 as id,
            (select name from user_customer u where u.id_user = h.id_customer) as name,
            ' ' as addr,
            ' ' as manager,
            'Итого' as num,
            sum(summa) as summa ,
            null as dt,
            null as dt5,
            sum(summa_order) as summa_order,
            null as dt_pay,
            sum(summa_pay) as summa_pay,
            sum(summa_all) as summa_all,
            sum(summa_dolg) as summa_dolg,
            comment as comment ,
            move_id as move_id
            	    
            FROM ec_saleh h
            where h.id_customer='".Auth::$aUser['id']."'
            ");
		$aBonus=$aBonus['summa_all']-$aBonus['summa_dolg'];
		Base::$tpl->assign('aBonus',$aBonus);

		Base::$oContent->ClearTimer();
		Base::Message();
		
		if(Auth::$aUser['type_']=='customer' && !Customer::IsChangeableLogin(Auth::$aUser['login']) ) {
//		    $iRegion = Auth::$aUser['id_geo'];
			$sSql ="select id_customer_group from user_customer where id_user='".Auth::$aUser['id']."'";
			$iCustomerGroup = Db::getOne($sSql);
		    $iRegion=$_SESSION['user']['id_region'];
		} else{
//		    $iRegion= $_SESSION['selected_city'];
			$iCustomerGroup=$_SESSION['user']['id_customer_group'];
		    $iRegion=$_SESSION['user']['id_region'];
		}

		if (Auth::$aUser['id'] && Auth::$aUser['type_']=='manager')
		{
			$sSql ="select id_customer_group from user_manager where id_user='".Auth::$aUser['id']."'";
			$iCustomerGroup = Db::getOne($sSql);
		}
		
		if(!$iCustomerGroup)$iCustomerGroup=1;
	
		if(!$iRegion)
		{
			$iRegion=1;
		//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			$iSelectedRegion=Base::$oContent->GetSelectedRegion();
		
			if(!$iSelectedRegion) $iSelectedRegion=1;
		}
		else
			$iSelectedRegion=$iRegion;
				
		$sPhone1= Db::GetOne("select r.phone1 from ec_region as r where r.id='".$iSelectedRegion."'");
		Base::$tpl->assign('sPhone1',$sPhone1);
		$sPhone2= Db::GetOne("select r.phone2 from ec_region as r where r.id='".$iSelectedRegion."'");
		Base::$tpl->assign('sPhone2',$sPhone2);

		/*		
		$sPhone1= Db::GetOne("select r.phone1 from ec_region as r where r.id=".$iRegion);
		Base::$tpl->assign('sPhone1',$sPhone1);
		$sPhone2= Db::GetOne("select r.phone2 from ec_region as r where r.id=".$iRegion);
		Base::$tpl->assign('sPhone2',$sPhone2);
		*/
//		Base::$tpl->assign('userr',Auth::$aUser);
		
		//Base::$oContent->AddCrumb(Language::GetMessage('main page'),'/');

        //geoIP
        //  $sCity = Content::GetCityByIp($_SERVER['HTTP_X_REAL_IP']);
        //  Base::$tpl->assign('sCityByIp', $sCity);

		mb_internal_encoding("UTF-8");
		$aRewriteAssoc=Db::GetAssoc("select static_rewrite,url from drop_down_additional where visible=1");
		if ($aRewriteAssoc) {
			$aRewriteKeys=array_keys($aRewriteAssoc);
			Content::RedirectOnSlash();
			if(strpos($_SERVER['REQUEST_URI'],'/?')!==FALSE && count(Base::$aRequest)==1 && Base::$aRequest['action'] 
					&& !in_array(Base::$aRequest['action'], array('home')) 
			){
				Base::Redirect('/pages/'.Base::$aRequest['action']);
			}
			if(strpos($_SERVER['REQUEST_URI'],'/pages/')!==FALSE && count(Base::$aRequest)==1 && Base::$aRequest['action']=='home'
			){
				Base::Redirect('/');
			}
			if(strpos($_SERVER['REQUEST_URI'],'/pages/')!==FALSE && in_array(Base::$aRequest['action'], $aRewriteKeys) ){
				$sRewriteURL=$aRewriteAssoc[Base::$aRequest['action']];
				$re1='.*?';	# Non-greedy match on filler
				$re2='(action)';	# Word 1
				$re3='(=)';	# Any Single Character 1
				$re4='((?:[a-z][a-z0-9_]*))';	# Variable Name 1
				if ($c=preg_match_all ("/".$re1.$re2.$re3.$re4."/is", $sRewriteURL, $matches)){
				    $sRewriteAction=$matches[3][0];
				}
				Base::$aRequest['action']=$sRewriteAction;
			}
		}
		$sSEOText=Db::GetOne("select description from drop_down_additional where static_rewrite='".Base::$aRequest['action']."' OR url LIKE  '%".Base::$aRequest['action']."%'");
		if ($sSEOText && $sSEOText!="<p>&nbsp;</p>") Base::$tpl->Assign('sSEOText',$sSEOText);
		
		Base::$tpl->assign('bNoneDotUrl',1);
		
		Repository::InitDatabase('news');

		// add crumb & caption if page
		Content::AddCrumbAndCaption();
		
		$sFavicon = Language::getConstant('favicon','/favicon.ico'); 
		if ($sFavicon != '/favicon.ico') {
			$aFileInfo = @getimagesize('.'.$sFavicon); 
			if ($aFileInfo['mime'] != '')
				Base::$tpl->Assign('sFaviconType',$aFileInfo['mime']);
		}
		
		$aNews =Base::$language->GetLocalizedAll(array(
		'table'=>'news',
		'where'=>" and section='site' and (id_region=0 or id_region ='".$iRegion."') and (id_customer_group=0 or id_customer_group ='".$iCustomerGroup."') and visible=1 order by num asc,t.id desc  limit 0, ".Base::GetConstant('news:max_limit',6)."",
		));
		Base::$tpl->assign('aNews',$aNews);

		Base::$sZirHtml="<span class='red'>*</span>";
		Form::$sTitleDivHeader=" class='form_title_div'";

		$oCatalog=new Catalog();
		Content::GetLeftPanelProducts($oCatalog->iIdRegion);

		$USER_ID=Auth::$aUser['id'];
		/*$GoogleTegManager="GTM-MFC3TC"; /* pnp GTM-N9K684 moregoods GTM-MFC3TC */
		/*$GoogleAnalitics="UA-72897834-3";/* pnp UA-72897834-1 moregoods UA-72897834-3*/
/*
<script async='' src='//connect.facebook.net/en_US/fbevents.js'></script>
<script type='text/javascript' async='' src='//www.googleadservices.com/pagead/conversion_async.js'></script>
<script type='text/javascript' async='' src='http://www.google-analytics.com/analytics.js'></script>
<script type='text/javascript' async='' src='http://top-fwz1.mail.ru/js/code.js'></script>
*/

		/*$sGTMHeadJavascript="<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','".$GoogleTegManager."');
</script>
<!-- End Google Tag Manager -->
";
//ga('set', 'userId', {{USER_ID}}); 
		$sGTMBodyJavascript="<!-- Google Tag Manager -->
<noscript><iframe src='//www.googletagmanager.com/ns.html?id=".$GoogleTegManager."'
height='0' width='0' style='display:none;visibility:hidden'></iframe></noscript>
";
		$sGAJavascript="
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', '".$GoogleAnalitics."', { 'userId': '".$USER_ID."' });
  ga('send', 'pageview');
</script>
";

//  ga('create', 'UA-72897834-3', 'auto');
//  ga('send', 'pageview');
//  ga('set', 'userId', '".$USER_ID."'); 

		Base::$tpl->assign('sGAJavascript',$sGAJavascript);


		Base::$tpl->assign('sGTMBodyJavascript',$sGTMBodyJavascript);

		Base::$tpl->assign('sGTMHeadJavascript',$sGTMHeadJavascript);*/

		Base::$tpl->assign('aCurrencyAssoc',Db::GetAssoc('Assoc/Currency'));
		Base::$aData['template']['bWidthLimit']=false;

		PriceGroup::GetTabs();
		Table::$sStepperAlign='left';
		
		$oCpacha= new Capcha();
		$sContactCapcha=$oCpacha->GetGraphics();
		
		$sContactCapcha=  str_replace(
		    array(
		        'name="capcha[result]"',
		        'id="capcha"',
		        'onclick="reloadimg()"',
		    ),
		    array(
		        'name="capcha[result]" id="contact_c_result"',
		        'id="contact_capcha_img"',
		        'onclick="reloadimg(\'contact_capcha_img\')"',
		    ),
		    $sContactCapcha);
		Base::$tpl->assign('sContactCapcha',$sContactCapcha);
		
		if (Auth::$aUser['type_'] == manager) {
			// get price group user
			$aPriceGroup = Db::GetAssoc("Select id, name from customer_group where visible=1 order by name");
			Base::$tpl->assign('aPriceGroup',$aPriceGroup);
			
		 	$sWhereManager .= " and uc.id_user = '".Auth::$aUser['id_type_price_user']."'";
			Base::$tpl->assign('aNameManager',Db::GetAssoc("select id as id, 
			concat(uc.name,' ( ',u.login,' )', 
			IF(uc.phone is null or uc.phone='','',concat(' ".
		    Language::getMessage('tel.')." ',uc.phone))) name
			from user as u
			inner join user_customer as uc on u.id=uc.id_user
			where u.visible=1 and uc.name is not null and trim(uc.name)!=''
			".$sWhereManager."
			order by uc.name"));
		
			Base::$tpl->assign('sURI',$_SERVER['REDIRECT_URL']);
		}

        Base::$oContent->GetCityList();
		Base::$oContent->ParseTemplate();

		//Resource::Get()->Add('/js/jquery-1.9.1.js',3);
		//Resource::Get()->Add('/js/jquery-3.2.1.min.js',2);
		
		Resource::Get()->Add('/js/jquery-1.9.1.js',5);
		Resource::Get()->Add('/js/_js/slick.min.js',3);
		Resource::Get()->Add('/js/_js/jquery.uniform.min.js',2);
		Resource::Get()->Add('/js/_js/timepicker.js',6);
		Resource::Get()->Add('/css/chosen.css',7);
		//Resource::Get()->Add('/js/_js/main.min.js',2);
		Resource::Get()->Add('/css/_css/main.css',73);
       //
		Resource::Get()->Add('/css/_css/map_ua.css',2);
		Resource::Get()->Add('/js/jquery.maskedinput.min.js',2);
		Resource::Get()->Add('/js/jquery.jcarousellite.js',2);
		Resource::Get()->Add('/js/jquery-ui.js',3);
		
		Resource::Get()->Add('/css/jquery-ui.css',3);

		//Resource::Get()->Add('/js/jquery.reveal.js', 3);
		
		Resource::Get()->Add('/css/_css/timepicker.css',6);
		
		Resource::Get()->Add('/js/_js/main.js',25);
			
		//Resource::Get()->Add('/css/slick.css',2);
		/*Resource::Get()->Add('/css/main.css',26);

		Resource::Get()->Add('/css/main.css',27);
		Resource::Get()->Add('/css/ie7.css',0,'header',array('ie7'=>1));
		Resource::Get()->Add('/css/context_hint.css');
		Resource::Get()->Add('/css/jquery-ui.css',1);
		Resource::Get()->Add('/css/new.css',1);
		Resource::Get()->Add('/css/index.css');
		Resource::Get()->Add('/js/jquery-1.9.1.js',1);
		
		Resource::Get()->Add('/js/main.js',5);
		Resource::Get()->Add('/js/functions.js',9);
		Resource::Get()->Add('/js/jquery.validate.min.js');
		Resource::Get()->Add('/js/myscripts.js');
 		Resource::Get()->Add('/js/cart.js',6);
	
		Resource::Get()->Add('/css/responsive.css',2);
		Resource::Get()->Add('/js/responsive.js',2);
		
		Resource::Get()->Add('/js/call_me.js',3);
		Resource::Get()->Add('/css/call_me.css',1);
	*/	

		Resource::Get()->Add('/js/jquery.colorbox-min.js',1);
		
		Resource::Get()->Add('/css/colorbox.css',1);

		Resource::Get()->Add('/js/popupform.js',15);
		Resource::Get()->Add('/js/cart.js',9);

		Content::LoadBanners();
		if (Auth::$aUser) {
			Resource::Get()->Add('/css/datepick.css');
			//Resource::Get()->Add('/libp/popcalendar/popcalendar.js');
			Resource::Get()->Add('/libp/jquery/jquery.datepick.js');
				
				Resource::Get()->Add('/js/jquery.searchabledropdown-1.0.8.min.js',1);
				Resource::Get()->Add('/js/select2.min.js',1);
				Resource::Get()->Add('/css/select2.min.css');
		}
		$sUloginURI=urlencode(Base::GetConstant('global:project_url','http://moregoods.com.ua')."/?action=user_ulogin_login");
		Base::$tpl->assign('sUloginURI',$sUloginURI);
        
        $_timestampDate = time(); 

        $currentDate = date("d.m.Y", $_timestampDate); //из 1437556706 в 22.07.2015

        $_monthsList = array(
          ".01." => "Января",
          ".02." => "Февраля",
          ".03." => "Марта",
          ".04." => "Апреля",
          ".05." => "Мая",
          ".06." => "Июня",
          ".07." => "Июля",
          ".08." => "Августа",
          ".09." => "Сентября",
          ".10." => "Октября",
          ".11." => "Ноября",
          ".12." => "Декабря"
        );

        $_mD = date(".m."); 
        $currentDate = str_replace($_mD, " ".$_monthsList[$_mD]." ", $currentDate);

        Base::$tpl->assign("currentDate",$currentDate);
        
	}
	//-----------------------------------------------------------------------------------------------
	public function GetCartItems($bAjaxQuery=FALSE){
	    $oTable=new Table();
	    $sWhere.=" and c.id_user=".Auth::$aUser['id'];
	    $oTable->sSql=Base::GetSql("Part/Search",array(
	        "type_"=>'cart',
	        "where"=>$sWhere,
	    ));

	    $oTable->iRowPerPage=40;
	    $oTable->sClass.=" cart-table";
	    $oTable->aColumn=array(
	       	'image'=>array('sTitle'=>'Image'),
	        'name'=>array('sTitle'=>'Name/Customer_Id','sWidth'=>'100px'),
	        'price'=>array('sTitle'=>'Price'),
	        'number'=>array('sTitle'=>'Number'),	       
	        'total'=>array('sTitle'=>'Total'),
	        'action'=>array(),
	    );
	    $oTable->sDataTemplate='cart/row_cart_popup.tpl';
	    $oTable->bCheckVisible=false;
	    $oTable->bStepperVisible=false;
	    $oTable->aCallback=array($this,'CallParseCart');
	    $oTable->sClass = "";
	    //$oTable->sSubtotalTemplate='cart/subtotal_cart.tpl';
	    $oTable->sTemplateName = 'index_include/cart_cart_table.tpl';
	    Base::$aRequest['step']=0;
	    $sCartPopUpContent=$oTable->getTable();
	    
	    $_SESSION['cart']['table_sql']=$oTable->sTableSql;
	    if ($bAjaxQuery) {
	        Base::$oResponse->AddAssign('cart_popup_content','innerHTML',$sCartPopUpContent);
	        //Base::$oResponse->AddAssign('icart_total_id2','innerHTML',$dSubtotal);
	    } else {
	        Base::$tpl->assign("sCartPopUpContent",$sCartPopUpContent);
	    }
	}
	
	//-----------------------------------------------------------------------------------------------
	public function CallParseCart(&$aItem)
	{
	    if ($aItem) foreach($aItem as $key => $value) {
	    	 $aItem[$key]['image']=Db::GetOne("select image from ec_products where id ='". $aItem[$key]['id_product'] ."'");

	         $aItem[$key]['total']=$value['number']*$value['price'];
	    }
	}
	
    //-----------------------------------------------------------------------------------------------
    public function GetSelectedRegion(){
        $sSelectedFoRUser=Base::$oContent->GetSelectedCity();
        $idRegion=Db::GetOne("select r.* 
 								from net_city as nc 
 								inner join ec_region r on r.net_city_region=nc.region
								where nc.id='".$sSelectedFoRUser."'");
		return $idRegion;
	}
    //-----------------------------------------------------------------------------------------------
    public function GetSelectedCity(){
        $sIP=Base::$oContent->getUserHostAddress();
        $sCityByIp=Base::$oContent->GetCityByIp($sIP);

		if(Auth::$aUser['type_']=='manager')
        $aUserGeoId=Db::GetRow("select nc.id as id_geo, nc.name_ru 
 								from net_city as nc 
 								inner join ec_region r on r.net_city_region=nc.region
    							inner join user_manager as uc on uc.id_region=r.id
            where uc.id_user='".Auth::$aUser['id']."'");
		else
        $aUserGeoId=Db::GetRow("select uc.id_geo, nc.name_ru from user_customer as uc
            inner join net_city as nc on nc.id=uc.id_geo
            where uc.id_user='".Auth::$aUser['id']."'");
        
        if(Auth::$aUser['id_region']) return $aUserGeoId;
        elseif($_SESSION['selected_city']) return $_SESSION['selected_city'];
        else return $sCityByIp[1];
       // Debug::PrintPre($sCityByIp);

    }
    //-----------------------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------------------
    public function getUserHostAddress(){
        if (!empty($_SERVER['HTTP_X_REAL_IP']))   //check ip from share internet
        {
            $ip=$_SERVER['HTTP_X_REAL_IP'];
        }
        elseif (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }

        if($ip=='127.0.0.1') $ip='46.149.93.127';//chernigov
        return $ip;
    }
    //-----------------------------------------------------------------------------------------------
    public function GetCityByIp($sIp) {
        Base::$aRequest['uc']['ip'] = $sIp;
        // Преобразуем IP в число
        $iIp = sprintf("%u", ip2long($sIp));

        $sCountryName = "";
        $iCountryId = 0;

        $sCityName = "";
        $iCityId = 0;

        // Ищем по российским и украинским городам
        $sSql = "select * from (select * from net_ru where begin_ip<=$iIp order by begin_ip desc limit 1) as t where end_ip>=$iIp";
        $aResult = Db::GetAll($sSql);
        if ($aResult) foreach($aResult as $row) {
            $iCityId = $row['city_id'];
            $sSql = "select * from net_city where id='$iCityId'";
            $aResult = Db::GetAll($sSql);
            if ($aResult) foreach($aResult as $row) {
                $sCityName = $row['name_ru'];
                $iCountryId = $row['country_id'];
            } else {
                $iCityId = 0;
            }
        }

        // Если не нашли - ищем страну и город по всему миру
        if (!$iCityId) {
            // Ищем европейскую страну
            $sSql = "select * from (select * from net_euro where begin_ip<=$iIp order by begin_ip desc limit 1) as t where end_ip>=$iIp";
            $aResult = Db::GetAll($sSql);
            if (count($aResult) == 0) {
                // Ищем страну в мире
                $sSql = "select * from (select * from net_country_ip where begin_ip<=$iIp order by begin_ip desc limit 1) as t where end_ip>=$iIp";
                $aResult = Db::GetAll($sSql);
            }
            if ($aResult) foreach($aResult as $row) {
                $iCountryId = $row['country_id'];
            }

            // Ищем город
            $sCityName = "";
            $iCityId = 0;
            // Ищем город в глобальной базе
            $sSql = "select * from (select * from net_city_ip where begin_ip<=$iIp order by begin_ip desc limit 1) as t where end_ip>=$iIp";
            $aResult = Db::GetAll($sSql);
            if ($aResult) foreach($aResult as $row) {
                $iCityId = $row['city_id'];
                $sSql = "select * from net_city where id='$iCityId'";
                $aResult = Db::GetAll($sSql);
                if ($aResult) foreach($aResult as $row) {
                    $sCityName = $row['name_ru'];
                    $iCountryId = $row['country_id'];
                }
            }
        }

        // Выводим результат поиска

        if ($iCountryId == 0) {
            //echo "Страна не определена";
        } else {
            // Название страны
            $sSql = "select * from net_country where id='$iCountryId'";
            $aResult = Db::GetAll($sSql);
            if ($aResult) foreach($aResult as $row) {
                $sCountryName = $row['name_ru'];
            }
            // Выводим
            //	echo $iCountryId." ".$sCountryName;
        }

        Base::$aRequest['uc']['city'] = '';
        if ($iCityId == 0) {
            return 0;
        } else {
            Base::$aRequest['uc']['city'] = $sCityName;
            return array($sCityName,$iCityId);
        }
    }
    //-----------------------------------------------------------------------------------------------
    public function GetCityList() {
        $sSelectedFoRUser=Base::$oContent->GetSelectedCity();
        if(Auth::$aUser['id_region'] ){
            $_SESSION['selected_city']='';
            $sSelectedCity=$sSelectedFoRUser['name_ru'];
        }elseif($_SESSION['selected_city']){
            $sSelectedCity=Db::GetOne("select name_ru from net_city  where id='".$_SESSION['selected_city']."'");
        }else{
            $sSelectedCity=Base::$oContent->GetSelectedCity();
        }
        Base::$tpl->assign('sSelectedCity',$sSelectedCity);
        $aCity=Db::GetAssoc("select id, name_ru from net_city  order by name_ru");
        //Debug::PrintPre($aCity);
        Base::$tpl->assign('aCity',array(''=>$sSelectedCity)+$aCity);

    }
    //-----------------------------------------------------------------------------------------------
    public function GetMonthDay($iTimestamp='') {
        if (!$iTimestamp) $iTimestamp=time();
        $iTimestamp += $iTimeZone * 3600;
        return date('d.m',$iTimestamp);
    }
    //-----------------------------------------------------------------------------------------------
    public function GetYear($iTimestamp='') {
        if (!$iTimestamp) $iTimestamp=time();
        $iTimestamp += $iTimeZone * 3600;
        return date('Y',$iTimestamp);
    }
    //-----------------------------------------------------------------------------------------------
	public function GetLeftPanelProducts($iIdRegion) {
	    $aGroupP=Db::GetAll(Base::GetSql('EcGroupP'));
	    $sTextLeft='';
	    $counter=2;
//код группы клиента	//Обрий 04.12.2016
		if (Auth::$aUser['id'] && Auth::$aUser['type_']=='customer')
	    {
	        $sSql ="select id_customer_group from user_customer where id_user='".Auth::$aUser['id']."'";
	        $iCustomerGroup = Db::getOne($sSql);
//	        $this->id_customer_group = $iCustomerGroup;
	    }
	    elseif (Auth::$aUser['id'] && Auth::$aUser['type_']=='manager')
	    {
	        $sSql ="select id_customer_group from user_manager where id_user='".Auth::$aUser['id']."'";
	        $iCustomerGroup = Db::getOne($sSql);
//	        $this->id_customer_group = $iCustomerGroup;
	    }else
	    {
	        $iCustomerGroup =1;
//	        $this->id_customer_group = $iCustomerGroup;
	    }
    if($aGroupP) foreach ($aGroupP as $aValue) {
    	if ($aValue['id']!=5){
   		$sNow=date("Y-m-d H:i:s");
    	$aPromoList=Db::GetAll("select ch.* from ec_condition_h ch 
    				where (ch.id_region='".$iIdRegion."' or ch.is_all_region=1) and (ch.dt1 < '".$sNow."' and '".$sNow."' <  ch.dt2 ) 
						and (ch.id_customer_group='".$iCustomerGroup."' or ch.id_customer_group=0) 
    				and ch.id_group_p='".$aValue['id']."'
					order by ch.sort desc ,ch.dt1 desc
    				");
    	$aPromoListCount=Db::GetAll("select count(*) as number from ec_condition_h ch 
    				where (ch.id_region='".$iIdRegion."' or ch.is_all_region=1) and (ch.dt1 < '".$sNow."' and '".$sNow."' <  ch.dt2 ) 
						and (ch.id_customer_group='".$iCustomerGroup."' or ch.id_customer_group=0) 
    				and ch.id_group_p='".$aValue['id']."'
    				");
			$iCount=30;
			if($aPromoListCount[0]['number'])
				$iCount=intval(30/$aPromoListCount[0]['number'])+1;
			if($iCount<1) $iCount=1;
			
//			if ($aPromoList){
			$sLimit=" limit 0,".$iCount." ";
//			$sLimit=" limit 0,30 ";
			
			$aProductList=array();
    		if ($aPromoList) foreach ($aPromoList as $aValuePro){
     	
		
		
		
	        $aProdLst=Db::GetAll(Base::GetSql("EcProductVidRegion",array(
    	        'id_group_p'=>$aValue['id'],
	        	'where'=>" and p.id_parent = 0 and v.visible=1 ",
	        	'ch_id'=>$aValuePro['id'],
    	        'id_region'=>$iIdRegion,
	        	'limit'=> $sLimit,	
	            'order'=>'order by (s.stock>=p.min_stock) desc, p.sort desc',
                'id_brand_group'=>Base::$aRequest['group'],
				'id_customer_group' => $iCustomerGroup,						//Обрий 04.12.2016		
                'id_brand'=>Base::$aRequest['brand'],
    	    )));
	        $aProductList=array_merge($aProductList,$aProdLst);
    		}

				$oCatalog=New catalog();
				$oCatalog->CallProductParse($aProductList);
//			Favourites::UpdateFavourites();

			Base::$tpl->assign('aGroupP',$aValue);
	        Base::$tpl->assign('aProductList',$aProductList);

			
	        if($aProductList){
	        if($counter%2 ==0){
	        $sTextLeft.=Base::$tpl->fetch('index_include/home_chet.tpl');
	        }
	        else{
	            $sTextLeft.=Base::$tpl->fetch('index_include/home_nechet.tpl');
	        }
	        $counter++;
	        }
    	 }
    	}

	    Base::$tpl->assign('sTextLeft',$sTextLeft);
	}	
	//-----------------------------------------------------------------------------------------------
	public function IsChangeableLogin($sLogin)
	{
		return Customer::IsChangeableLogin($sLogin);
	}
	//-----------------------------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------------------
	public static function CallOldReplacer($sObject,$sOutput)
	{
		$aId=Language::$aOldParser[$sObject];

		switch ($sObject) {

			//================================================
			case 'customer':
				$aCustomer=Db::GetAll(Base::GetSql('Customer',array(
				'join_delivery_type'=> 1,
				'join_rating'=> 1,
				'join_rating_quality'=>1,
				'where'=>" and u.id in (".implode(',',$aId).")",
				)));
				if ($aCustomer) {
					foreach ($aCustomer as $aValue) $aCustomerId[]=$aValue['id_user'];
					$aCommentHash=Comment::GetCommentHash('customer',$aCustomerId);

					foreach ($aCustomer as $aValue) {
						$aValue['comment_list']=$aCommentHash[$aValue['id']];
						Base::$tpl->assign('aData',$aValue);
						$sOutput=str_replace('old_parser_'.$sObject.'_'.$aValue['id'].'_'
						,Base::$tpl->fetch('hint/customer.tpl'),$sOutput);
					}
				}
				break;
				//================================================
				case 'customer_uniq':
					foreach ($aId as $sValueId) {
						list($iRealId,$iUniqId)=explode("_",$sValueId);
						$aCustomer=Db::GetAll(Base::GetSql('Customer',array(
						'join_delivery_type'=> 1,
						'join_rating'=> 1,
						'join_rating_quality'=>1,
						'where'=>" and u.id = ".$iRealId
						)));
						if (!$aCustomer) 
							$aCustomer=Db::GetAll(Base::GetSql('CustomerNotManager',array(
									'join_delivery_type'=> 1,
									'join_rating'=> 1,
									'join_rating_quality'=>1,
									'where'=>" and u.id = ".$iRealId
							)));
						if ($aCustomer) {
							foreach ($aCustomer as $aValue) $aCustomerId[]=$aValue['id_user'];
							$aCommentHash=Comment::GetCommentHash('customer',$aCustomerId);
					
							foreach ($aCustomer as $aValue) {
								$aValue['comment_list']=$aCommentHash[$aValue['id']];
								$aValue['id'] = $iUniqId;
								Base::$tpl->assign('aData',$aValue);
								$sOutput=str_replace('old_parser_'.$sObject.'_'.$sValueId.'_'
										,Base::$tpl->fetch('hint/customer.tpl'),$sOutput);
							}
						}
						else {
							$sOutput=str_replace('old_parser_'.$sObject.'_'.$sValueId.'_'
									,$iRealId,$sOutput);
						}
					}
					break;
				//================================================
			case 'comment_customer_popup':
			case 'comment_cart_package_popup':
			case 'comment_cart_popup':
			case 'comment_provider_popup':
				if ($sObject=='comment_customer_popup') {
					$sSection='customer';
					$aRatingList=Db::GetAll(Base::GetSql('Rating',array(
					'section'=> 'user_quality',
					'order'=>'order by r.num'
					)));
				} elseif ($sObject=='comment_cart_package_popup') $sSection='cart_package';
				elseif ($sObject=='comment_cart_popup') $sSection='cart';
				elseif ($sObject=='comment_provider_popup') $sSection='provider';

				$aCommentHash=Comment::GetCommentHash($sSection,$aId);

				if($sObject=='comment_cart_popup'){
					$aCartSign=Db::GetAll(Base::GetSql('Cart',array(
					'id_array'=>$aId,
					'join_cart_delay'=>true)));
					$aCartSign=Language::Array2Hash($aCartSign,'id');
				}
				foreach ($aId as $iRefId) {
					Base::$tpl->assign('aComment',$aCommentHash[$iRefId]);
					Base::$tpl->assign('aRatingList',$aRatingList);
					if($sObject=='comment_cart_popup'){
						Base::$tpl->assign('aCartSign',$aCartSign[$iRefId]);
					}
					if ($sObject=='comment_customer_popup'){
						//set current rating value from last comment OR 3 BY DEFAULT
						$iNumRating=$aCommentHash[$iRefId][0]['num_rating']!=null?
						$aCommentHash[$iRefId][0]['num_rating']:
						Base::GetConstant('rating:user_default_quality',3);
						Base::$tpl->assign('iRatingNumCurrent',$iNumRating);
						Base::$tpl->assign('bCustomerPopup',true);
					}else
					Base::$tpl->assign('bCustomerPopup',false);
					Base::$tpl->assign('aData',$aCommentHash[$iRefId][0]);
					Base::$tpl->assign('sSection',$sSection);
					Base::$tpl->assign('iRefId',$iRefId);
					$sOutput=str_replace('old_parser_'.$sObject.'_'.$iRefId.'_',Base::$tpl->fetch('hint/comment.tpl'),$sOutput);
				}

				foreach ($aId as $aValue) {
					$sOutput=str_replace('old_parser_'.$sObject.'_'.$aValue,'',$sOutput);
				}
				break;
				//================================================
			case 'cart_store_end':
			case 'cart_work':
				if ($sObject=='cart_store_end') {
					$sWhere.=" and c.order_status in ('store','end','office_sent','office_received')
						and id_invoice_customer='0' and id_travel_sheet='0'
					";
				}
				elseif ($sObject=='cart_work') {
					$sWhere.=" and c.order_status in ('new','work','confirmed','road')";
				}
				else $sWhere.=" 1!=1";

				$aCart=Db::GetAll(Base::GetSql('Part/Search',array(
				'where'=>" and c.id_user in (".implode(',',$aId).") ".$sWhere,
				'order'=>" order by c.id",
				)));
				if ($aCart) foreach ($aCart as $aValue) $aCartHash[$aValue['id_user']][]=$aValue;

				foreach ($aId as $iRefId) {
					Base::$tpl->assign('aCart',$aCartHash[$iRefId]);
					Base::$tpl->assign('aData',$aCartHash[$iRefId][0]);
					Base::$tpl->assign('sSection',$sObject);
					Base::$tpl->assign('iRefId',$iRefId);

					$sOutput=str_replace('old_parser_'.$sObject.'_'.$iRefId.'_',Base::$tpl->fetch('hint/cart.tpl'),$sOutput);
				}

				foreach ($aId as $aValue) {
					$sOutput=str_replace('old_parser_'.$sObject.'_'.$aValue,'',$sOutput);
				}
				break;
				//================================================
			case 'provider':
				$aProvider=Db::GetAll(Base::GetSql('Provider',array(
				'join_provider_group'=>'1',
				'join_provider_region'=>'1',
				'where'=>" and u.id in (".implode(',',$aId).")",
				)));
				if ($aProvider) {
					foreach ($aProvider as $aValue) $aProviderId[]=$aValue['id'];
					$aCommentHash=Comment::GetCommentHash('provider',$aProviderId);

					foreach ($aProvider as $aValue) {
						$aValue['comment_list']=$aCommentHash[$aValue['id']];
						Base::$tpl->assign('aData',$aValue);
						$sOutput=str_replace('old_parser_'.$sObject.'_'.$aValue['id'].'_'
						,Base::$tpl->fetch('hint/provider_details.tpl'),$sOutput);
					}
				}
				break;
				//================================================

		}

		return $sOutput;
	}
	//-----------------------------------------------------------------------------------------------
	public function FirstNwords($sString, $iWord)
	{
		return String::FirstNwords($sString, $iWord);
	}
	//-----------------------------------------------------------------------------------------------
	public static function GetOrderStatus($sKey)
	{
		require(SERVER_PATH.'/include/order_status_config.php');

		switch ($sKey) {
			case 'new' :
				return '<b><font color='.$aOrderStatusColor[$sKey].'>'.Language::getMessage($sKey).'</font></b>';
				break;
			case 'work' :
				return '<b><font color='.$aOrderStatusColor[$sKey].'>'.Language::getMessage($sKey).'</font></b>';
				break;
			case 'confirmed' :
				return '<b><font color='.$aOrderStatusColor[$sKey].'>'.Language::getMessage($sKey).'</font></b>';
				break;
			case 'road' :
				return '<b><font color='.$aOrderStatusColor[$sKey].'>'.Language::getMessage($sKey).'</font></b>';
				break;
			case 'store' :
				return '<b><font color='.$aOrderStatusColor[$sKey].'>'.Language::getMessage($sKey).'</font></b>';
				break;
			case 'end' :
				return '<b><font color='.$aOrderStatusColor[$sKey].'>'.Language::getMessage($sKey).'</font></b>';
				break;
			case 'refused' :
			case 'store_refused' :
				return '<b><font color='.$aOrderStatusColor[$sKey].'>'.Language::getMessage($sKey).'</font></b>';
				break;
			case 'pending' :
				return '<b><font color='.$aOrderStatusColor[$sKey].'>'.Language::getMessage($sKey).'</font></b>';
				break;

			case 'parsed' :
				return '<b><font color=blue>' . Language::getMessage ( $sKey ) . '</font></b>';
				break;

			default :
				return '<b>' . Language::getMessage ( $sKey ) . '</b>';
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function PrintPartName($aRow)
	{
		return Catalog::PrintPartName($aRow);
	}
	//-----------------------------------------------------------------------------------------------
	public function CorrectSeoUrl($sText,$sType)
	{
		switch ($sType) {
			case 'price_group':
				$sText=preg_replace(
				"/\?action=price_group&category=([a-zA-Z0-9_-\s.]+)(&brand=0)?&step=0/",
				'select/${1}/',
				$sText);
				$sText=preg_replace(
				"/\?action=price_group&category=([a-zA-Z0-9_-\s.]+)(&brand=0)?&step=(\d+)/",
				'select/${1}/0/${3}/',
				$sText);
				break;

			case 'price_group_brand':
				$sText=preg_replace(
				"/\?action=price_group&category=([a-zA-Z0-9_-\s.]+)&brand=([a-zA-Z0-9_-\s.]+)&step=0/",
				'select/${1}/${2}/',
				$sText);
				$sText=preg_replace(
				"/\?action=price_group&category=([a-zA-Z0-9_-\s.]+)&brand=([a-zA-Z0-9_-\s.]+)&step=(\d+)/",
				'select/${1}/${2}/${3}/',
				$sText);
				break;

		}
		return $sText;
	}
	//-----------------------------------------------------------------------------------------------
	public function Translit($str) 
	{
	    $tr = array(
	        "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
	        "Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
	        "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
	        "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
	        "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
	        "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
	        "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
	        "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
	        "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
	        "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
	        "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
	        "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
	        "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
			"Ё"=>"E","Ë"=>"E","ё"=>"e","("=>"",")"=>"","'"=>"","?"=>"","´"=>"","`"=>"",
			chr(194)=>"",chr(160)=>"",
	    	"/"=>"_"," "=>"_","-"=>"_","["=>"","]"=>"","&"=>"and",
			"É"=>"E","È"=>"E","Ê"=>"E","è"=>"e","é"=>"e","ê"=>"e",
			"À"=>"A","Á"=>"A","Â"=>"A","Ã"=>"A","Ä"=>"A","à"=>"a","á"=>"a","â"=>"a","ã"=>"a","ä"=>"a",
			"Ӧ"=>"O","Ò"=>"O","Ó"=>"O","Ô"=>"O","Õ"=>"O","Ö"=>"O","ò"=>"o","ó"=>"o","ô"=>"o","õ"=>"o","ö"=>"o",
			"Ù"=>"U","Ú"=>"U","Û"=>"U","Ü"=>"U","ù"=>"u","ú"=>"u","û"=>"u","ü"=>"u",
	    );
	    return strtr($str,$tr);
	}	
	//-----------------------------------------------------------------------------------------------
	public function CreateSeoUrl($sAction,$aData,$bAbsolute=0)
	{
	    $aModel=$aData['model'];
	    $aModelDetail=$aData['model_detail'];
	    
		if($bAbsolute) $sUrl=Language::GetConstant('global:project_url');
		$sUrl.='/';
		if(!$aData['data[id_make]'] && $aData['data[id_model]']){
// 			$aData['data[id_make]']=Db::GetOne("select id from cat 
// 				inner join ".DB_OCAT."cat_alt_manufacturer man on man.ID_src=cat.id_tof
// 				inner join ".DB_OCAT."cat_alt_models m on m.ID_mfa=man.ID_mfa and m.ID_src='".$aData['data[id_model]']."'
// 					");
			
			$aData['data[id_make]']=TecdocDb::GetIdMakeByIdModel($aData['data[id_model]']);
		}
		if(!$aData['cat'] && $aData['data[id_make]']){
			if(!$aCat[$aData['data[id_make]']]){
				$aCat[$aData['data[id_make]']]=Db::GetOne("select name from cat where id='".$aData['data[id_make]']."'");
			}
			$aData['cat']=$aCat[$aData['data[id_make]']];
		}
		if(!$aData['model_translit'] && $aData['data[id_model]']){
			if(!$aModel[$aData['data[id_model]']]){
				/*$aModel[$aData['data[id_model]']]=Db::GetRow(Base::GetSql("OptiCatalog/Model",array(
				'id_model'=>$aData['data[id_model]'],
				'id_make'=>$aData['data[id_make]']
				)));*/
				
				$aModel[$aData['data[id_model]']]=TecdocDb::GetModel(array(
				'id_model'=>$aData['data[id_model]'],
				'id_make'=>$aData['data[id_make]']
				));
			}
			$aData['model_translit']=Content::Translit($aModel[$aData['data[id_model]']]['name']);
		}
		if(!$aData['model_detail_translit'] && $aData['data[id_model_detail]']){
			if(!$aModelDetail[$aData['data[id_model_detail]']]){
				/*$aModelDetail[$aData['data[id_model_detail]']]=Db::GetRow(Base::GetSql("OptiCatalog/ModelDetail",array(
				'id_model'=>$aData['data[id_model]'],
				'id_model_detail'=>$aData['data[id_model_detail]'],
				'id_make'=>$aData['data[id_make]']
				)));*/
			    $aModelDetail[$aData['data[id_model_detail]']]=TecdocDb::GetModelDetail(array(
				'id_model'=>$aData['data[id_model]'],
				'id_model_detail'=>$aData['data[id_model_detail]'],
				'id_make'=>$aData['data[id_make]']
				),$aData['aCat']);
			}
			$aData['model_detail_translit']=Content::Translit($aModelDetail[$aData['data[id_model_detail]']]['name']
					.' '.$aModelDetail[$aData['data[id_model_detail]']]['Name']);
		}
		if(is_numeric($aData['model_translit'])) $aData['model_translit']=$aData['cat']."_".$aData['model_translit'];
		if($aData['model_detail_translit'] && $aData['data[name_part]']) $sModel=$aData['model_detail_translit'].'_'
			.Content::Translit($aData['data[name_part]']).'-';
		elseif($aData['model_detail_translit']) $sModel=$aData['model_detail_translit'].'-';
		elseif($aData['model_translit']) $sModel=$aData['model_translit'].'-';
		else $sModel='';
		$aData['cat'] = Content::Translit($aData['cat']); 
		switch ($sAction) {
			case 'catalog_model_view':
				$sUrl.='cars/'.$aData['cat'].'/';
			break;
			case 'catalog_detail_model_view':
				$sUrl.='cars/'.$aData['cat'].'/'.$sModel.$aData['data[id_model]'].'/';
			break;
			case 'catalog_assemblage_view':
				$sUrl.='cars/'.$aData['cat'].'/'.$sModel.$aData['data[id_model]'].'-'.$aData['data[id_model_detail]'].'/';
			break;
			case 'catalog_part_view':
				$sUrl.='cars/'.$aData['cat'].'/'.$sModel
				.$aData['data[id_model]'].'-'.$aData['data[id_model_detail]'].'-'.$aData['data[id_part]'].'/';
			break;
			
			default:
				;
			break;
		}

		if (Language::getConstant('global:url_is_lower',0) == 1)
			$sUrl = mb_strtolower($sUrl,'utf-8');
		
		if (Language::getConstant('global:url_is_not_last_slash',0) == 1) {
			if (mb_substr($sUrl, -1, 1, 'utf-8') == "/")
				$sUrl = substr($sUrl, 0, -1);
		}	
			
		return $sUrl;
	}

	//-----------------------------------------------------------------------------------------------
	public function CustomizeTable ($oTable) {
		Base::$tpl->assign('bNoneDotUrl',1);
	}
	//-----------------------------------------------------------------------------------------------
	public function RedirectOnSlash()
	{
		return false;
		
		if(strpos($_SERVER['REQUEST_URI'],'?')===FALSE 
				&& strpos($_SERVER['REQUEST_URI'],'mpanel')===FALSE 
				&& substr($_SERVER['REQUEST_URI'],-1)!='/')
		Base::Redirect($_SERVER['REQUEST_URI'].'/');
	}
	//-----------------------------------------------------------------------------------------------
	public function ClearTimer()
	{
		$this->iTimer=microtime(true);
	}
	//-----------------------------------------------------------------------------------------------
	public function ShowTimer($sMessage='')
	{
		if(Auth::$aUser['type_']=='manager' && Language::getConstant('view_admin_time',0))
			$this->sTimer.=$sMessage.": <b>".round(microtime(true)-$this->iTimer,3)."</b>&nbsp;&nbsp;";
	}
	//-----------------------------------------------------------------------------------------------
	public function AddCrumbAndCaption() {
		if (/*Base::$aRequest['action'] != 'catalog' && */ Base::$aRequest['action'] != 'home' && Base::$aRequest['action']) {
			if (Base::$aRequest['action'] == 'news_preview')
				Base::$tpl->assign('sCaptionBlock',Language::GetMessage('news'));
			/*elseif (Base::$aRequest['action'] == 'catalog_part_view' || Base::$aRequest['action'] == 'catalog_model_view' ||
			 Base::$aRequest['action'] == 'catalog_detail_model_view' || Base::$aRequest['action'] == 'catalog_assemblage_view')
			Base::$tpl->assign('sCaptionBlock',Language::GetMessage('autoparts in store'));
			*/
			//elseif (Base::$aRequest['action'] == 'catalog_to') {}
			elseif (Base::$aRequest['action'] == 'catalog') {
			//Base::$oContent->AddCrumb(Language::GetMessage('catalog_auto'),'');
			}
			elseif (Base::$aRequest['action'] == 'catalog_price_view')
			Base::$tpl->assign('sCaptionBlock','<none>'); // for this page need empty caption for design
			elseif (Base::$aRequest['action'] == 'catalog_part_info_view') {
				Base::$tpl->assign('sCaptionBlock',Language::GetMessage('select universal autoparts'));
			}
			else {
				$sName = Db::GetOne("select name from drop_down where code='".Base::$aRequest['action']."'");
				if ($sName) {
					Base::$tpl->assign('sCaptionBlock',$sName);
	
					if (Base::$aRequest['action'] == 'brands')
						Base::$oContent->AddCrumb(Language::GetMessage('catalog_brands'),'');
					else
						Base::$oContent->AddCrumb($sName,'');
				}
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function CheckDashboard($sAction) {
	    $aDashboardAction=array(
	        'dashboard', 'customer_profile', 'cart_order', 'cart_package_list', 'finance', 'vin_request', 'own_auto',
	        'message_change_current_folder', 'payment_report', 'payment_declaration',
	         
	        'price', 'price_profile', 'manager_cat_pref', 'manager_package_list', 'manager_order', 'manager_profile','finance_user_discounts','manager_user_discounts',
			'manager_customer','manager_customer_list','manager_customer_list_add','manager_customer_list_edit','manager_customer_list_delete','manager_customer_list_fill',
			'customer_list_fill_add','customer_list_fill_delete','manager_customer_edit','set_user_login','set_user_password',
	        'manager_cart', 'message', 'vin_request_manager', 'finance_bill', 'manager_invoice_customer', 'manager_invoice_customer_invoice',
	        'manager_cat', 'manager_cart_delete','catalog_cross', 'payment_report_manager', 'payment_declaration_manager',  'manager_synonym',
	        'price_ftp', 'manager_package_edit', 'manager_order_edit', 'manager_edit_weight', 'manager_change_provider', 'message_change_current_folder',
	        'vin_request_manager_edit', 'vin_request_manager_send_preview', 'message_compose', 'finance_bill_edit', 'manager_cat_add', 'catalog_cross_stop',
	        'catalog_cross_stop_add', 'catalog_cross_add', 'catalog_cross_import', 'payment_declaration_manager_add', 'payment_declaration_manager_edit',
	         
	        'payment_report_add', 'payment_report_edit', 'finance_bill_add', 'cart_package_edit', 'user_change_password', 'price_profile_edit',
	        'own_auto_edit',
	        'favourites','finance_user_debt', 'cart_order_edit', 'own_auto_add', 'message_preview', 'message_delete','manager_cat_pref_add',
	        'favourites_manager'
	    );
	     
	    return in_array($sAction, $aDashboardAction);
	}
	//-----------------------------------------------------------------------------------------------
	public function getStepper($oTable,$aData) {
	    // 	    'iPage'=>$iPage,
	    // 	    'iPageNumber'=>$iPageNumber,
	    // 	    'iAllPageNumber'=>$iAllPageNumber,
	    // 	    'next'=>$next,
	    // 	    'previous'=>$previous,
	    // 	    'sQueryString'=>$sQueryString,
	    // 	    'sAjaxScript'=>$sAjaxScript,
	    // 	    'sPrefUrl'=>$sPrefUrl,
	    // 	    'iStartStep'=>$this->iStartStep,
	    // 	    'sLinkRewrite'=>$this->sLinkRewrite
	     
	     
	     
	    // 	    if ($iPage > 0) {
	    // 	        $start_text = "<a class=list href='".$sPrefUrl."/?" . $sQueryString . "&" . $this->sPrefix
	    // 	        . "step=0' $sAjaxScript>&lt;&lt;&nbsp;" . Language::GetMessage ( 'Start' ) . "</a>";
	    // 	        $previous_text = "<a class=list href='".$sPrefUrl."/?" . $sQueryString . "&" . $this->sPrefix
	    // 	        . "step=$previous' $sAjaxScript>&nbsp;&lt;&lt;&nbsp;" . Language::GetMessage ( 'Prev' ) . "</a>";
	    // 	    } else {
	    // 	        $start_text = "<span class=list>&lt;&lt;&nbsp;" . Language::GetMessage ( 'Start' ) . "</span>";
	    // 	        $previous_text = "<span class=list>&lt;&lt;&nbsp;" . Language::GetMessage ( 'Prev' ) . "</span>";
	    // 	    }
	    //------------------------------------------------------------------------------------------------------------------------
	    $aPageArray=$oTable->printPage($aData['iAllPageNumber'],$aData['iPage']);
	    if($aPageArray) foreach ($aPageArray as $i) {
	        if (strcmp($aData['iPage'],$i)==0) {
	            $sPageText .= "<a class='selected'>".($i+$this->iStartStep+1)."</a>";
	        }
	        elseif(strcmp($i,'...')==0) {
	            $sPageText .= "<a>...</a>";
	        }
	        else {
	            $sPageText .= "<a href='".$aData['sPrefUrl']."/?" . $aData['sQueryString'] . "&" . $this->sPrefix. "step=$i' ".$aData['sAjaxScript'].">".($i+$this->iStartStep+1)."</a>";
	        }
	    }
	    //------------------------------------------------------------------------------------------------------------------------
	    // 	    if ($iPage < $iAllPageNumber) {
	    // 	        $next_text="<a class=list href='".$sPrefUrl."/?".$sQueryString."&".$this->sPrefix
	    // 	        ."step=$next' $sAjaxScript>"
	    // 	        .Language::GetMessage('Next')."&nbsp;&gt;</a>";
	    // 	        $end_text = "<a class=list href='".$sPrefUrl."/?" . $sQueryString . "&" . $this->sPrefix
	    // 	        . "step=$iAllPageNumber' $sAjaxScript>" . Language::GetMessage ( 'StepEnd' ) . "&nbsp;&gt;&gt;</a>";
	    // 	    } else {
	    // 	        $next_text = "<span class=list>" . Language::GetMessage ( 'Next' ) . "&nbsp;&gt;</span>";
	    // 	        $end_text = "<span class=list>" . Language::GetMessage ( 'StepEnd' ) . "&nbsp;&gt;&gt;</span>";
// 	    }

	    //---------------------------------------------------
	     
	    // 	    if(!$aPageArray && $this->bStepperHideNoPages)
	        // 	        return ;
	        // 	    else
	            // 	        return $start_text . '&nbsp;&nbsp;' . $previous_text . '&nbsp;&nbsp;' . $sPageText . '&nbsp;&nbsp;' . $next_text
// 	        . '&nbsp;' . $end_text;

	     if($aData["previous"] >=0){
	         $sPrev = '<a href="'.$aData["sPrefUrl"].'/?'.$aData["sQueryString"].'&'.$this->sPrefix .'step='.$aData["previous"].'" class="prev"></a>';
	     }else{
	         $sPrev = '<a class="prev"></a>';
	     }  

	     if($aData["next"] <= $aData['iAllPageNumber']){
	        $sNext='<a href="'.$aData["sPrefUrl"].'/?'.$aData["sQueryString"].'&'.$this->sPrefix .'step='.$aData["next"].'" class="next"></a>';
	     }else{
	       $sNext=  '<a class="next"></a>';
	     }
	     
	     if(!$aPageArray)
	       return '';
	    else {
	    return '<div class="gm-block-stepper">
	        '. $sPrev.' '. $sNext .'	        
	        <div class="pages">
		               '.$sPageText.'
	                </div></div>';
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function GetImageThumb($sImage){
 	    if(!file_exists(SERVER_PATH.$sImage."_thumb")) {
 	        //return "/imgbank/Image/no_picture.gif";
 	        Content::makeSmaller(SERVER_PATH.$sImage, 200, 200, SERVER_PATH.$sImage."_thumb");
 	    }
	    return $sImage."_thumb";
	    
	    
	    
	    
// 	    if(!$aPgpbValue['subnail']) {
// 	        $sSubnail=pathinfo($aPgpbValue['image'], PATHINFO_DIRNAME)."/"."subnail_".pathinfo($aPgpbValue['image'], PATHINFO_BASENAME);
	    
// 	        if(file_exists(SERVER_PATH.$aPgpbValue['image']) && !file_exists(SERVER_PATH.$sSubnail)) {
// 	            $this->makeSmaller(SERVER_PATH.$aPgpbValue['image'], 60, 38, SERVER_PATH.$sSubnail);
// 	        }
// 	        if(file_exists(SERVER_PATH.$sSubnail)) $aPgpbValue['subnail']=$sSubnail;
// 	    }
	}
	//-----------------------------------------------------------------------------------------------
    public function getProportions($width, $height, $max_w, $max_h) {
	
		   // получаем соотношение
		   $ratio = $width / $height;
	
		if ( $ratio == 1 ) { // если стороны равны
			if ( $height > $max_h ) {
				$height = $width = min($max_w, $max_h);
			} else {
				$width = $max_w;
				$height = $max_h;
			}
		}
		else if ( $ratio > 1 ) { // если ширина больше высоты
			$height = ( $height * $max_w ) / $width;
			$width = $max_w;
					    
			if($height>$max_h) {
				$width = ( $width * $max_h ) / $height;
				$height = $max_h;
			}
		}
		else if ( $ratio < 1 ) { // если больше высота
			$width = ( $width * $max_h ) / $height;
			$height = $max_h;
						    
			if($width>$max_w) {
				$height = ( $height * $max_w ) / $width;
				$width = $max_w;
			}
		}
	
		return array('width' => $width, 'height' => $height);
	}
	//-----------------------------------------------------------------------------------------------
	public function makeSmaller($image_path, $width, $height, $smaller) {
	
	    // получаем тип изображения
	    $type = exif_imagetype($image_path);
	
	    if ( $type == IMAGETYPE_JPEG ) {
	        // создаем ресурс изображения, с которым мы будем работать, из файла $image_path
	        $im_res = imagecreatefromjpeg($image_path);
	    }
	    else if ( $type == IMAGETYPE_GIF ) {
	        $im_res = imagecreatefromgif($image_path);
	    }
	    else if ( $type == IMAGETYPE_PNG ) {
	        $im_res = imagecreatefrompng($image_path);
	    }
	    else // а если нам подкинули файл левого типа, то мы молча отстраняемся и забиваем на задачу
	        return false;
	
	    $imw = imagesx($im_res); // узнаем ширину полученного изображения
	    $imh = imagesy($im_res); // высоту
	
	    // и вот тут мы используем ту нашу первую функцию
	    $props = $this->getProportions($imw, $imh, $width, $height);
	
	    $small_res = imagecreatetruecolor($width, $height); // создаем ресурс изображения; лучше использовать imagecreatetruecolor вместо imagecreate, т.к. цветопередача, а следовательно и качество, пострадают. Можете сами поэкспериментировать
	    $grey = imagecolorallocate($small_res, 255, 255, 255); // чтобы использовать какой-то цвет в функциях gd2 (например imagefill), сначала нужно создать его "идентификатор", чем и занимается функция imagecolorallocate
	
	    // а здесь, собственно, заливаем нашим цветом уменьшенное изображение, ресурс которого недавно создали
	    imagefill($small_res, 0, 0, $grey);
	
	    imagecopyresampled($small_res, $im_res, round(($width - $props['width']) / 2), round(($height - $props['height']) / 2), 0, 0, $props['width'], $props['height'], $imw, $imh);
	
	    /*
	     К чему такие странные вычисления? Мне нужно узнать, с какой точки вставлять картинку, т.к. она может либо по ширине, либо по высоте оказаться меньше, чем задано. То есть если мы изображение размером 400х300 уменьшаем этой функцией до 200х200, то наше получится 200х150, но нам его хотелось бы отцентрировать, для этого и вычисляем точку отсчета.
	    */
	
	    if ( $type == IMAGETYPE_JPEG ) {
	        imagejpeg($small_res, $smaller, 100); // сохраняем в файл $smaller; 100 - это качество, указывается для jpeg
	    }
	    else if ( $type == IMAGETYPE_GIF ) {
	        imagegif($small_res, $smaller);
	    }
	    else if ( $type == IMAGETYPE_PNG ) {
	        imagepng($small_res, $smaller);
	    }
	}
	//-----------------------------------------------------------------------------------------------
	public function ProcessDropDownAdditional()
	{
	    if ($_SERVER['REQUEST_URI']) {
	        $aDropDownAdditional=Db::GetRow(Base::GetSql('CoreDropDownAdditional',array(
	            'visible'=>1,
	            'where'=>" and ('".$_SERVER['REQUEST_URI']."' like dda.url)",
	        )));
	    }
	
	    if ($aDropDownAdditional) {
	        if ($aDropDownAdditional['title'])
	            Base::$aData['template']['sPageTitle'] = $aDropDownAdditional['title'];
	        if ($aDropDownAdditional['page_description'])
	            Base::$aData ['template']['sPageDescription']=$aDropDownAdditional['page_description'];
	        if ($aDropDownAdditional['page_keyword'])
	            Base::$aData ['template']['sPageKeyword']=$aDropDownAdditional['page_keyword'];
	        if ($aDropDownAdditional['short_description'])
	            Base::$aData ['template']['sShortDescription']=$aDropDownAdditional['short_description'];
	        if ($aDropDownAdditional['description'])
	            Base::$aData ['template']['sDescription']=$aDropDownAdditional['description'];
	    }
	}
	//-----------------------------------------------------------------------------------------------
	public static function SetMetaTagsPage($sKey,$aData=array())
	{
	    if(!$sKey) return;
	    $aDropDownAdditional=Db::GetRow(Base::GetSql('CoreDropDownAdditional',array(
	        'visible'=>1,
	        'where'=>" and (dda.url='".$_SERVER['REQUEST_URI']."')",
	    )));
	    if(!Base::$aData['template']['sPageTitle']
	        || Base::$aData['template']['sPageTitle']!=$aDropDownAdditional['title']){
	        $aPageTitle=String::GetSmartyTemplate($sKey.'page_title', $aData,false);
	        Base::$aData['template']['sPageTitle']=strip_tags($aPageTitle['parsed_text']);
	    }
	    if(!Base::$aData['template']['sPageDescription']){
	        $aPageDescription=String::GetSmartyTemplate($sKey.'page_description', $aData,false);
	        Base::$aData['template']['sPageDescription']=strip_tags($aPageDescription['parsed_text']);
	    }
	    if(!Base::$aData['template']['sPageKeyword']){
	        $aPageKeyword=String::GetSmartyTemplate($sKey.'page_keyword', $aData,false);
	        Base::$aData['template']['sPageKeyword']=strip_tags($aPageKeyword['parsed_text']);
	    }
	}
	/*//-----------------------------------------------------------------------------------------------
	public static function SetH1($sKey, $aData=array(),$sName='')
	{
	    if ($sName != '') {
	        Base::$aData['template']['sBodyH1']=$sName;
	        return;
	    }
	
	    if(!$sKey) return;
	    $aBodyH1=String::GetSmartyTemplate($sKey.'body_h1', $aData,false);
	    Base::$aData['template']['sBodyH1']=strip_tags($aBodyH1['parsed_text']);
	}*/
	//-----------------------------------------------------------------------------------------------
}
?>