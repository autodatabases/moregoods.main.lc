<?
/**
 * @author Mikhail Starovoyt
 */

class Home extends Base
{
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		Base::$bXajaxPresent=true; 

		Catalog::Index();
		Base::$sText.=Home::GetPopularProducts();
		$iNumber = Favourites::UpdateFavourites();
		Base::$tpl->assign('favNum', $iNumber);
		//Base::$sText.=Language::GetText('home bottom text');
	}
    //-----------------------------------------------------------------------------------------------
	public function GetPopularProducts($iGroup=0) {
		
		
		$aPopularProducts=Db::GetAll("select * from popular_products where visible=1 ORDER BY RAND() ");
		
		if($aPopularProducts) foreach ($aPopularProducts as $sKey => $aData){
		        $sSql=Base::GetSql('EcProductVidRegion',array(
		            'id_products'=>$aData['id_products'],
		            'id_brand_group'=>$iGroup
		        ));
		    //$sSql=str_replace("and 0=1", '', $sSql);
			$aPrice=Db::GetRow($sSql);
			if($aPrice) {
				if($aPrice['price']>0) {
					$aPopularProducts[$sKey]['price']=$aPrice['price'];
					$aPopularProducts[$sKey]['id_brand_group']=$aPrice['id_brand_group'];
					if(!$aData['image']) $aPopularProducts[$sKey]['image']=$aPrice['image'];
					//$aPopularProducts[$sKey]['id_provider']=$aPrice['id_provider'];
					//$aPopularProducts[$sKey]['cat_name']=$aPrice['cat_name'];
					//$aPopularProducts[$sKey]['code']=$aPrice['code'];
				}
				else {
					Db::Execute("update popular_products set visible=0 where id_products='".$aData['id_products']."' ");
					unset($aPopularProducts[$sKey]);
				}
			} else {
				//Db::Execute("update popular_products set visible=0 where id_products='".$aData['id_products']."' ");
				unset($aPopularProducts[$sKey]);
			}
		}
		$aCode=array();
		if($aPopularProducts) foreach ($aPopularProducts as $aValue){
		    $aCode[]=$aValue['code'];
		}
		$aCode=array_unique($aCode);
		$sCodes="'".implode("','", $aCode)."'";
		

		$oCatalog=New catalog();
		
	
		
		$aPopularProducts=Db::GetAll(Base::GetSql("EcProductVidRegion",array(
//				'id_group_p'=>5,
//				'where'=>" and p.id_parent = 0 and v.visible=1  ",
//				'id_region'=>$oCatalog->iIdRegion,
//				'limit'=> " limit 0,5 ",
//				'order'=>'order by (s.stock>=p.min_stock) desc,v.sort,b.sort,p.sort desc',				//ch.dt1 desc, ch.sort desc, 
//				'id_brand_group'=>Base::$aRequest['group'],
//				'id_customer_group' => $oCatalog->id_customer_group,						//Обрий 04.12.2016
//				'id_brand'=>Base::$aRequest['brand'],
				)));
				
		
		$oCatalog->CallProductParse($aPopularProducts);
//		Catalog::CallProductParse($aPopularProducts);
		Favourites::UpdateFavourites();
		Base::$tpl->assign('aPopularProducts',$aPopularProducts);
		return Base::$tpl->fetch("index_include/popular_products.tpl");
	}
	//-----------------------------------------------------------------------------------------------

}
?>