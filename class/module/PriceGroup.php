<?
/**
 * @author Oleksandr Starovoit
 * @author Mikhail Starovoyt
 * @author Yuriy Korzun
 * @version 4.5.2
 */

class PriceGroup extends Catalog
{
	var $sPrefix="price_group";

	//-----------------------------------------------------------------------------------------------
	public function __construct()
	{
		Db::Execute("SET @lng_id = 16");
		Db::Execute("SET @cou_id = 187");
		if(Base::$aRequest['category']){
			$aRedirectLinks=Db::GetAssoc("select link_from,link_to from redirect where link_from like '/select/%'");
			if ($aRedirectLinks){
				$sRedirectLinkFrom = "/select/".Base::$aRequest['category']."/";
				$sRedirectLinkTo = $aRedirectLinks[$sRedirectLinkFrom];
				if ($sRedirectLinkTo && ($sRedirectLinkTo!=$sRedirectLinkFrom)){
					$sRedirectLinkTo .= Base::$aRequest['brand'] ? Base::$aRequest['brand']."/" : "";
					Base::Redirect(Language::GetConstant('global:project_url').$sRedirectLinkTo);
				}
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{

		Base::$bXajaxPresent=true;
		Base::$tpl->assign('sBaseAction',$this->sPrefix);

		/*if(strpos($_SERVER['REQUEST_URI'],'?')===FALSE && substr($_SERVER['REQUEST_URI'],-1)!='/')
		Base::Redirect($_SERVER['REQUEST_URI'].'/');*/
		
		if (
		(isset(Base::$aRequest["step"]) && Base::$aRequest["step"]==0)
		|| strpos($_SERVER['REQUEST_URI'],'?')!==FALSE
		) {
			if(Base::$aRequest["category"]) $sUrl.=Base::$aRequest["category"].'/';
			if(Base::$aRequest["brand"]) $sUrl.=Base::$aRequest["brand"].'/';
			elseif(Base::$aRequest["step"]) $sUrl.='0/';
			if(Base::$aRequest["step"]) $sUrl.=Base::$aRequest["step"].'/';
			if(Base::$aRequest["sort"]) $sUrl.='sort='.Base::$aRequest["sort"].'/';
			if(Base::$aRequest["way"]) $sUrl.='way='.Base::$aRequest["way"].'/';
			Base::Redirect('/select/'.$sUrl);
		}

		if (!Base::$aRequest["category"]) {
			$oTable=new Table();
			$oTable->sSql=Base::GetSql("Price/Group",array(
			'visible'=>1,
			"where"=>" and pg.code_name is not null",
			'order'=>' ORDER BY (code+0)'
			));

			$oTable->aColumn=array(
			'code'=>array('sTitle'=>'code'),
			'code_name'=>array('sTitle'=>'code_name'),
			'action'=>array(),
			);
			$oTable->sDataTemplate=$this->sPrefix."/row_".$this->sPrefix.".tpl";
			$oTable->iRowPerPage=500;
			$oTable->bStepperVisible=false;
			//$oTable->sButtonTemplate='price/button_price_import.tpl';

			Base::$sText.=$oTable->getTable("Category price");
			//Base::$oContent->AddCrumb(Language::GetMessage("home"),'/');
			Base::$oContent->AddCrumb(Language::GetMessage("price groups"));
		}elseif (Base::$aRequest["category"]){
			$aRowPriceGroup=Db::GetRow(Base::GetSql("Price/Group",array(
			'code_name'=>Base::$aRequest["category"]?Base::$aRequest["category"]:-1,
			'visible'=>1,
			)));

			if ($aRowPriceGroup) {
				if (1){
					$aChildsId=array();
					$aChilds=Db::GetAll("select * from price_group where id_parent='".$aRowPriceGroup['id']."' and visible=1");
					foreach ($aChilds as $sKey => $aValue){
						$action = "/select/".$aValue['code_name'];
						if (Language::getConstant('global:url_is_not_last_slash',0) == 0)
							$action .= "/";
						if (Language::getConstant('global:url_is_lower',0) == 1)
							$action = mb_strtolower($action,'utf-8');
						$aChildNavigator[$sKey]=array(
							'name'=>$aValue['name'],
							'url'=>$action,
						);
						$aChildsId[]=$aValue['id'];
					}
					
					$aChildsId[]=$aRowPriceGroup['id'];
					$aPriceGroupBrand=Db::GetAll(Base::GetSql("Price/GroupPref",array(
					    "id_price_group"=>implode(",", $aChildsId),
					    "join_price"=>1,
					    "order"=> " order by c.title",
					    "where"=>" and c.visible=1",
					)));
					$sPg_code_name=$aRowPriceGroup['code_name'];
					
					//----------------------------------------------------------------
					function GetGroupNavi($iParent,&$aNavigator=array()){
					    $aParent = Db::GetRow("Select * from price_group where visible=1 and id=".$iParent);
					    if ($aParent) {
					        if($aParent['id_parent']) GetGroupNavi($aParent['id_parent'],$aNavigator);
							$action = "/select/".$aParent['code_name'];
							if (Language::getConstant('global:url_is_not_last_slash',0) == 0)
								$action .= "/";
					        $aNavigator[]=array(
					            'name'=>$aParent['name'],
					            'url'=>$action,
					        );
					    }
					}
					GetGroupNavi($aRowPriceGroup['id'],$aNavigator);
					//----------------------------------------------------------------
				}
				
			}
			else {
				Form::Error404(true);
			}

			if (Base::$aRequest["brand"])
				$aRowCat=Db::GetRow(Base::GetSql('Catalog/CatPref',array(
				'brand'=>Base::$aRequest["brand"],
				'id_category'=>$aRowPriceGroup['id'],
				'childs'=>isset($aChilds),
				)));

			if ($aRowCat) {
				if(mb_strtolower(Base::$aRequest["brand"],'utf-8')!=mb_strtolower($aRowCat['name'],'utf-8')) Base::Redirect('/select/'.Base::$aRequest["category"].'/'.$aRowCat['name'].'/');
				$action = "/select/".$aRowPriceGroup['code_name']."/".$aRowCat['name'];
				if (Language::getConstant('global:url_is_not_last_slash',0) == 0) 
					$action .= "/";
				if (Language::getConstant('global:url_is_lower',0) == 1)
					$action = mb_strtolower($action,'utf-8');

				$aNavigator[]=array('name'=>$aRowCat['title']
				,'url'=> $action
				);

				
			}elseif(Base::$aRequest["brand"]){
				 Form::Error404(true);
			}

			//--------------------------------------------------------------
			//add brand sort $aPriceGroupBrand
			function cmp($a, $b) 
			{
			    if ($a['c_title'] == $b['c_title']) {
			        return 0;
			    }
			    return ($a['c_title'] < $b['c_title']) ? -1 : 1;
			}
			if($aPriceGroupBrand) usort($aPriceGroupBrand, "cmp");
			//--------------------------------------------------------------

			$aNavigator[count($aNavigator) - 1]['url'] = '';

			Base::$tpl->assign('aNavigator', $aNavigator);
			Base::$sText.=Base::$tpl->fetch ("catalog/navigator.tpl");
			Base::$tpl->assign('aChildNavigator', $aChildNavigator);
			Base::$tpl->assign('aPriceGroupBrand', $aPriceGroupBrand);
			Base::$tpl->assign('sPg_code_name',$sPg_code_name);

			Base::$tpl->assign('aBrand', $aRowCat);

			Base::$tpl->assign('aRowPriceGroup', $aRowPriceGroup);
			if ($aRowPriceGroup['description']) {
				Base::$tpl->assign('sSmartyTemplate', $aRowPriceGroup['description']);
				Base::$tpl->assign('sDescription',Base::$tpl->fetch('addon/smarty_template.tpl'));
			}
			Base::$sText.=Base::$tpl->fetch($this->sPrefix."/group_brand.tpl");

			if ($aRowPriceGroup['title']) {
				Base::$tpl->assign('sSmartyTemplate', $aRowPriceGroup['title']);
				Base::$aData['template']['sPageTitle'] = Base::$tpl->fetch('addon/smarty_template.tpl');
			}
			if ($aRowPriceGroup['page_description']) {
				Base::$tpl->assign('sSmartyTemplate', $aRowPriceGroup['page_description']);
				Base::$aData['template']['sPageDescription'] = Base::$tpl->fetch('addon/smarty_template.tpl');
			}
			if ($aRowPriceGroup['page_keyword']) {
				Base::$tpl->assign('sSmartyTemplate', $aRowPriceGroup['page_keyword']);
				Base::$aData['template']['sPageKeyword'] = Base::$tpl->fetch('addon/smarty_template.tpl');
			}
			
			if ($aRowPriceGroup['is_product_list_visible']){
				if (!Base::$aRequest['sort'] || Base::$aRequest['sort'] == 'price')
					$sOrder = " p.price ";
				elseif (Base::$aRequest['sort'] == 'brand')
					$sOrder = " c.title ";
				elseif (Base::$aRequest['sort'] == 'provider')
					$sOrder = " up.name ";
				elseif (Base::$aRequest['sort'] == 'term')
				$sOrder = " p.term ";
				elseif (Base::$aRequest['sort'] == 'stock')
				$sOrder = " CONVERT(replace(replace(replace(replace(replace(replace(replace(replace(p.stock,'>',''),'+',''),'++',''),'+++',''),'есть','1'),'X',''),'XX',''),'XXX',''), SIGNED) ";
				elseif (Base::$aRequest['sort'] == 'name_translate')
				$sOrder = " coalesce(cp.name_rus,p.part_rus,''),c.title,p.code ";
				elseif (Base::$aRequest['sort'] == 'code')
				$sOrder = " p.code ";
				
				if (Base::$aRequest['way'] && Base::$aRequest['way'] == 'down')
					$sOrder .= ' desc ';
				
				$oTable=new Table();
				$oTable->sSql=Base::GetSql("Catalog/Price",array(
				"customer_discount"=>Discount::CustomerDiscount(Auth::$aUser),
				"id_price_group"=>$aRowPriceGroup['id'],
				"pref"=>$aRowCat['pref'],
				"order"=>$sOrder,
				"childs"=>$aChilds,
				"where"=>" and p.price>0 ",
				"pgpf"=>1
				));

				$oTable->aCallback=array($this,'CallParse');
				$oTable->aColumn=array(
				//'brand'=>array('sTitle'=>'brand'),
				'name_translate'=>array('sTitle'=>'Name'),
				'code'=>array('sTitle'=>'code'),
				'img_path'=>array('sTitle'=>'image','nosort' => 1),
				'stock'=>array('sTitle'=>'Stock','sWidth'=>'5%'),
				'term'=>array('sTitle'=>'Term','sWidth'=>'5%'),
				'price'=>array('sTitle'=>'price'),
				'number'=>array('sTitle'=>'Number','sWidth'=>'5%','nosort' => 1),
				'action'=>array('nosort' => 1),
				);
				Auth::$aUser['type_']=='manager'?$oTable->aColumn['provider']=array('sTitle'=>'Provider','sWidth'=>'5%'):"";
				$oTable->sDataTemplate="catalog/row_catalog_search_advance.tpl";
				$oTable->iRowPerPage=Language::getConstant('price_group:limit_page_items',25);

				$oTable->iStartStep=1;
				$oTable->sTemplateName = 'catalog/search_table.tpl';
				Resource::Get()->Add('/css/thickbox.css');
				Resource::Get()->Add('/libp/jquery/jquery.thickbox.js');
				
				// macro sort table
				$this->SortTable();
				
				Base::$sText.=$oTable->GetTable();
				Base::$sText.=Base::$tpl->fetch('price_profile/popup.tpl');
			}
			if ($aRowPriceGroup['bottom_text'] && !Base::$aRequest["brand"] && !Base::$aRequest["step"]) {
				Base::$tpl->assign('sSmartyTemplate', $aRowPriceGroup['bottom_text']);
				//Base::$tpl->assign('sBottomText',Base::$tpl->fetch('addon/smarty_template.tpl'));
				Base::$sText.=Base::$tpl->fetch('addon/smarty_template.tpl');
			}
			//Base::$sText.=Base::$tpl->fetch($this->sPrefix."/group_brand.tpl");
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function CallParse(&$aItem)
	{
		foreach ($aItem as $sKey=>$aValue) {
			if($aValue['id_cat_part']){
				$aCatPart[]=$aValue['id_cat_part'];
				$aKeyPart[$aValue['id_cat_part']]=$sKey;
			}
		}
		
		$aCodes=array();
		foreach ($aItem as $sKey=>$aValue) {
		    $aCodes[]=$aValue['code'];
		}
		if($aCodes) $aArtIds=TecdocDb::GetArts($aCodes);
		if($aArtIds) foreach ($aItem as $sKey=>$aValue) {
		    $sArtId='';
		    $sArtId=$aArtIds[$aValue['item_code']];
		    if($sArtId) {
		        $aArtId[]=$sArtId;
		        $aKeyArt[$sArtId]=$sKey;
		        $aItem[$sKey]['art_id']=$sArtId;
		    }
		}

		$aGraphic=TecdocDb::GetImages(array(
		    'aIdGraphic'=>$aArtId,
		    'order'=>'gra_sort desc'
		));
		if($aGraphic){
			foreach ($aItem as $sKey=>$aValue) {
				if (array_key_exists($aValue['item_code'],$aGraphic))
				$aItem[$sKey]['image']=$aGraphic[$aValue['item_code']];
			}
		}

		$aGraphic=TecdocDb::GetImages(array(
		    'aIdCatPart'=>$aCatPart,
		    'order'=>'gra_sort desc'
		));
		if($aGraphic){
			foreach ($aItem as $sKey=>$aValue) {
				if (array_key_exists($aValue['item_code'],$aGraphic))
				$aItem[$sKey]['image']=$aGraphic[$aValue['item_code']];
			}
		}
		if ($aItem) {
			foreach($aItem as $key => $aValue) {
				if (!$aValue['id_provider'])
					continue;
				$aItem[$key]['history'] = '';
				$aProviderInfo = Base::$db->getAll("select * from user_provider up
						inner join user u ON u.id = up.id_user
						where id_user = ".$aValue['id_provider']);
				if ($aProviderInfo[0]) {
					Base::$tpl->assign('aProviderInfo',$aProviderInfo[0]);
					$aItem[$key]['history'] = Base::$tpl->fetch('catalog/row_provider_log.tpl');
				}
			}
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function GetTabsBrand($iIdGroup){
		$aBrands=Db::GetAll("select DISTINCT c.name as cat, p.pref , c.title from price_group_assign as p
							inner join cat as c on p.pref=c.pref and c.visible=1
							where id_price_group='".$iIdGroup."'");
		return $aBrands;
	}
	//-----------------------------------------------------------------------------------------------
	public function GetTabs(){
		//need refresh after interval
		$iNowDate=time();
		$iLastRefresh=Base::GetConstant("home:price_group_main_tabs_last_update",time());
// 		if(($iLastRefresh+(Base::GetConstant("home:price_group_pref_interval","60")*60)) <= $iNowDate) {
// 			//need update
// 			$aGroups=Db::GetAll("select * from price_group where level=0 and visible=1 and is_menu=1 order by name");
// 			FileCache::SetValue('Home', 'main_tabs', $aGroups);
// 		}
// 		else{
// 			if(!$aGroups=FileCache::GetValue('Home', 'main_tabs')) {
		  		$aGroups=Db::GetAll("select * from price_group where level=0 and visible=1 and is_menu=1 order by name");
// 		  		FileCache::SetValue('Home', 'main_tabs', $aGroups);
// 			}
// 		}	 
			
	    if($aGroups) {
    		foreach ($aGroups as $sBaseKey => $aBaseValue){
    			$aGroups[$sBaseKey]['childs']=Db::GetAll("select * from price_group where level=1 and id_parent='".$aBaseValue['id']."' and visible=1 order by name");
    			foreach ($aGroups[$sBaseKey]['childs'] as $sKey => $aValue){
    				$aGroups[$sBaseKey]['childs'][$sKey]['childs']=Db::GetAll("select * from price_group where level=2 and id_parent='".$aValue['id']."' and visible=1 order by name");
    				//$aGroups[$sBaseKey]['childs'][$sKey]['brand']=PriceGroup::GetTabsBrand($aValue['id']);
    				/*foreach ($aGroups[$sBaseKey]['childs'][$sKey]['childs'] as $sKeyChild => $aValueChild){
    					$aGroups[$sBaseKey]['childs'][$sKey]['childs'][$sKeyChild]['brand']=PriceGroup::GetTabsBrand($aValueChild['id']);
    				}*/
    			}
    		}
	    }
		
		Base::$tpl->assign('aGroups', $aGroups);
	}
	//-----------------------------------------------------------------------------------------------
	public function GetMainBrand($iIdGroup){
	    if(!file_exists(SERVER_PATH."/cache/")) {
	        @mkdir(SERVER_PATH."/cache/", 0777, true);
	    }
	    
	    //need refresh after interval
	    $iNowDate=time();
	    $iLastRefresh=Base::GetConstant("home:price_group_pref_last_update",time());
	    
// 	    if(($iLastRefresh+(Base::GetConstant("home:price_group_pref_interval","60")*60)) <= $iNowDate) {
	        //need update
	        $sSql="	select distinct c.title ,c.name
			from price_group_assign as pgs
			inner join cat as c on pgs.pref=c.pref and c.visible=1
			inner join price_group as pg on pgs.id_price_group=pg.id
			inner join price as p on (p.price>0 and pgs.pref=p.pref and pgs.item_code=p.item_code)
			where 1=1
			and pgs.id_price_group='".$iIdGroup."'
			group by pgs.id
			order by c.title
			limit 6";
	        
	        $aBrands=Db::GetAll($sSql);
// 	        FileCache::SetValue('Home', 'price_group_pref_'.$iIdGroup, $aBrands);
// 	    } else {
// 	        //from cache
// 	        if(!$aBrands=FileCache::GetValue('Home', 'price_group_pref_'.$iIdGroup)) {
// 	        $sSql="	select distinct c.title ,c.name
// 			from price_group_assign as pgs
// 			inner join cat as c on pgs.pref=c.pref and c.visible=1
// 			inner join price_group as pg on pgs.id_price_group=pg.id
// 			inner join price as p on (p.price>0 and pgs.pref=p.pref and pgs.item_code=p.item_code)
// 			where 1=1
// 			and pgs.id_price_group='".$iIdGroup."'
// 			group by pg.id
// 			order by c.title
// 			limit 6";
	             
// 	            $aBrands=Db::GetAll($sSql);
// 	            FileCache::SetValue('Home', 'price_group_pref_'.$iIdGroup, $aBrands);
// 	        }
// 	    }
							
		return $aBrands;
	}
	//-----------------------------------------------------------------------------------------------
	public function GetMainGroups(){
// 	    if(!$aGroups=FileCache::GetValue('Home', 'main_groups')) {
    		$aGroups=Db::GetAll("select * from price_group where is_main=1 and visible=1 ");
    		if ($aGroups) {
    			foreach ($aGroups as $sKey => $aValue){
    			    $aChildsId=array();
                    $aChilds=Db::GetAssoc("select id,id as iiid from price_group where visible=1 and level=1 and id_parent='".$aValue['id']."'");
    				$aChilds[]=$aValue['id'];
					
    				$aPriceGroupBrand=Db::GetAll(Base::GetSql("Price/GroupPref",array(
    				    "id_price_group"=>implode(",", $aChilds),
    				    "join_price"=>1,
    				    "order"=> " order by c.title",
    				    "where"=>" and c.visible=1",
    				))." limit 0,6");
    				$aGroups[$sKey]['brand']=$aPriceGroupBrand;
    			}
    			Base::UpdateConstant("home:price_group_pref_last_update",time());
    		}
//     		FileCache::SetValue('Home', 'main_groups', $aGroups);
// 	    }
		
		Base::$tpl->assign('aMainGroups', $aGroups);
	}
	//-----------------------------------------------------------------------------------------------
	public function GetPriceGroupBrand($iIdGroup){
	    if(!file_exists(SERVER_PATH."/cache/")) {
	        @mkdir(SERVER_PATH."/cache/", 0777, true);
	    }
	    
	    //need refresh after interval
	    $iNowDate=time();
	    $aPriceGroup = Db::GetRow("SELECT * FROM price_group WHERE id = ".$iIdGroup);
// 	    if($aPriceGroup && ($aPriceGroup['cache_update_timestamp']+(Base::GetConstant("price_group:price_group_pref_interval","60")*60)) <= $iNowDate) {
// 	        //need update
// 	        $sSql="	select c.title as c_title,c.name as c_name, pg.code_name as pg_code_name 
//     			from price_group_assign as pga
//     			inner join cat as c on pga.pref=c.pref and c.visible=1
//     			inner join price_group as pg on pga.id_price_group=pg.id
//     			inner join price as p on (p.price>0 and pga.item_code  = p.item_code)
//     			where 1=1
//     			and pga.id_price_group='".$iIdGroup."'
//     			group by pga.pref
//     			order by c.title";
	        
// 	        $aBrands=Db::GetAll($sSql);
// 	        FileCache::SetValue('PriceGroup', 'price_group_pref_'.$iIdGroup, $aBrands);
// 	        Db::Execute("UPDATE price_group SET cache_update_timestamp = '".time()."' WHERE id = ".$aPriceGroup['id']);
// 	    } else {
	        //from cache
// 	        if(!$aBrands=FileCache::GetValue('PriceGroup', 'price_group_pref_'.$iIdGroup)) {
				$sSql="	select c.title as c_title,c.name as c_name, pg.code_name as pg_code_name 
    			from price_group_assign as pga
    			inner join cat as c on pga.pref=c.pref and c.visible=1
    			inner join price_group as pg on pga.id_price_group=pg.id
    			inner join price as p on (p.price>0 and pga.item_code  = p.item_code)
    			where 1=1
    			and pga.id_price_group='".$iIdGroup."'
    			group by pga.pref
    			order by c.title";
	             
	            $aBrands=Db::GetAll($sSql);
// 	            FileCache::SetValue('PriceGroup', 'price_group_pref_'.$iIdGroup, $aBrands);
// 	        }
// 	    }
							
		return $aBrands;
	}
	//-----------------------------------------------------------------------------------------------
}
?>