<?

class Store extends Base
{
	var $sPreffix='store_';
	var $bTransferFlag=true;
	
	/* store_basket types
	 * 
	 * 1 - incoming
	 * 2 - transfer
	 * 3 - sale
	 */
	
	
	//-----------------------------------------------------------------------------------------------
	function __construct()
	{
		Auth::NeedAuth('manager');
		Base::$sText.=Base::$tpl->fetch('store/tab_store.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		Base::$tpl->assign('sActionPrefix','store');
		$aStores=Db::GetAssoc("select id,name from store where visible=1 and is_virtual=0 and is_return=0 and is_sale=0");
		if(count($aStores==1) && !Base::$aRequest['store']) Base::Redirect("/?action=store&store=".key($aStores));
		Base::$tpl->assign('aStores',$aStores);
		Base::$sText.=Base::$tpl->fetch('store/tab_stores.tpl');
		
		if(Base::$aRequest['store']){
			Base::$tpl->assign("aBrand", array("0"=>'')+Db::GetAssoc("select pref,title from cat where visible=1"));
			$aData=array(
				'sHeader'=>"method=get",
				'sContent'=>Base::$tpl->fetch('store/form_store_search.tpl'),
				'sSubmitButton'=>'Search',
				'sSubmitAction'=>'store',
				'sReturnButton'=>'Clear',
				'bIsPost'=>0,
				'sWidth'=>'550px',
			);
			$oForm=new Form($aData);
			Base::$sText.=$oForm->getForm();

			// --- search ---
			if (Base::$aRequest['search']['code']) $sWhere.=" and p.code like '%".Base::$aRequest['search']['code']."%'";
			if (Base::$aRequest['search']['pref']) $sWhere.=" and p.pref = '".Base::$aRequest['search']['pref']."'";
			// --------------
			
			$oTable=new Table();
			$oTable->sType='array';
			$oTable->aDataFoTable=Db::GetAll(Base::GetSql('Store/Log',array(
				'store'=>Base::$aRequest['store'],
				'where'=>$sWhere,
			)));
			$oTable->aColumn=array(
				'id'=>array('sTitle'=>'id'),
				//'id_user'=>array('sTitle'=>'id_user'),
				'store_from'=>array('sTitle'=>'store_from'),
				'product'=>array('sTitle'=>'product'),
				'tax'=>array('sTitle'=>'tax'),
				'price'=>array('sTitle'=>'price'),
				'count'=>array('sTitle'=>'count'),
				//'action'=>array(),
			);
			$oTable->bCheckVisible=true;
			$oTable->bDefaultChecked=false;
			$oTable->sFormAction="store";
			$oTable->sDataTemplate='store/row_store.tpl';
			$oTable->sButtonTemplate='store/button_store_tables.tpl';
			
			Base::$sText.=$oTable->getTable();
		}
		
	}
	//-----------------------------------------------------------------------------------------------
	public function AddToSale() {
		if(Base::$aRequest['is_post']){
			$aRows=Base::$aRequest['row_check'];
				
			if ($aRows) foreach($aRows as $iId){
				$aProduct=Db::GetRow("select id_product,price from store_log where id='".$iId."'");
				if($aProduct) {
					$aData=array();
					$aData['id_product']=$aProduct['id_product'];
					$aData['price']=$aProduct['price'];
					$aData['count']=1;
					$aData['id_from']=Base::$aRequest['store'];
					$aData['id_user']=Auth::$aUser['id'];
					$aData['type']='3';
					Db::AutoExecute("store_basket",$aData);
				}
			}
			Base::Redirect("/pages/store_sale_invoice/");
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function AddToTransfer() {
		if(Base::$aRequest['is_post']){
			$aRows=Base::$aRequest['row_check'];
				
			if ($aRows) foreach($aRows as $iId){
				$aProduct=Db::GetRow("select id_product,price,count,id_to as store,tax from store_log where id='".$iId."'");
				if($aProduct) {
					$aData=array();
					$aData['id_product']=$aProduct['id_product'];
					$aData['price']=$aProduct['price'];
					$aData['count']=$aProduct['count'];
					$aData['id_from']=$aProduct['store'];
					$aData['id_user']=Auth::$aUser['id'];
					$aData['tax']=$aProduct['tax'];
					$aData['type']='2';
					Db::AutoExecute("store_basket",$aData);
				}
			}
			Base::Redirect("/pages/store_transfer/");
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function InputInvoiceScanner() {
		if (Base::$aRequest['is_post']) {
			$aData=String::FilterRequestData(Base::$aRequest);
			$aCodes=explode("\r\n", $aData['item_codes']);
			if($aCodes) foreach ($aCodes as $sValue){
				$aProduct=Db::GetOne("select id from store_products where item_code='".strtoupper($sValue)."' ");
				if($aProduct) {
					$iExistId=Db::GetOne("select id from store_basket where id_product='".$aProduct['id']."' and type=1");
					if($iExistId) {
						Db::Execute("update store_basket set count=count+1 where id='".$iExistId."' ");
					} else {
						Db::AutoExecute('store_basket',array(
							"id_user"=>Auth::$aUser['id'],
							"id_product"=>$aProduct['id'],
							"count"=>'1',
							"type"=>'1'
						));
					}
				}
			}
			Base::Redirect("/pages/store_input_invoice_manual/");
		}
		Base::$sText.=Base::$tpl->fetch("store/form_input_invoice_scanner.tpl");
	}
	//-----------------------------------------------------------------------------------------------
	public function InputInvoiceManual() {
		if (Base::$aRequest['is_post']) {
			if (Base::$aRequest['action']==$this->sPreffix."input_invoice_manual_add") {
				$aData=String::FilterRequestData(Base::$aRequest['data']);
				
				if(!$aData['id_product'] && $aData['code'] && $aData['pref'] && $aData['count'] && $aData['name']) {
					$aData['code']=Catalog::StripCode($aData['code']);
					$aData['item_code']=$aData['pref']."_".$aData['code'];
					$aData['type']='1';
					
					Db::AutoExecute("store_products", $aData);
					$aData['id_product']=Db::InsertId();
				}
				Db::Execute("insert into store_basket (id_user,id_product,count,price,tax,type) values 
					('".Auth::$aUser['id']."','".$aData['id_product']."','".$aData['count']."','".$aData['price']."','".$aData['tax']."','1') ");
				Base::Redirect("/pages/store_input_invoice_manual/");
			}
		}
		
		if (Base::$aRequest['action']==$this->sPreffix."input_invoice_manual_delete"){
			if(Base::$aRequest['id']) Db::Execute("delete from store_basket where id='".Base::$aRequest['id']."' ");
			Base::Redirect("/pages/store_input_invoice_manual/");
		}
		
		$oTable=new Table();
		$oTable->sSql=Base::GetSql('Store/Basket',array('type'=>'1'));
		$oTable->aColumn=array(
				'id'=>array('sTitle'=>'id'),
				//'id_user'=>array('sTitle'=>'id_user'),
				'product'=>array('sTitle'=>'product'),
				'tax'=>array('sTitle'=>'tax'),
				'price'=>array('sTitle'=>'price'),
				'count'=>array('sTitle'=>'count'),
				'action'=>array(),
		);
		$oTable->sDataTemplate='store/row_input_invoice_manual.tpl';
		Base::$sText.=$oTable->getTable("Input Invoice");
		
		Base::$tpl->assign("aProducts", array("0"=>'')+Db::GetAssoc("select sp.id,
			concat(c.name,' ',sp.code,' ',sp.name) as product_name 
			from store_products as sp
			inner join cat as c on c.pref=sp.pref"));
		Base::$tpl->assign("aBrand", array("0"=>'')+Db::GetAssoc("select pref,title from cat where visible=1"));
		Base::$tpl->assign('sFormManual',Base::$tpl->fetch("store/form_input_invoice.tpl"));
		Base::$tpl->assign('sFormByScanner',Base::$tpl->fetch("store/form_input_invoice_scanner.tpl"));
		Base::$sText.=Base::$tpl->fetch("store/index_input_invoice.tpl");
		
		Base::$tpl->assign("aStoresFrom", Db::GetAssoc("select id,name from store where is_return=0 and is_sale=0 and is_virtual=1"));
		Base::$tpl->assign("aStoresTo", Db::GetAssoc("select id,name from store where is_return=0 and is_sale=0 and is_virtual=0"));
		Base::$sText.=Base::$tpl->fetch("store/form_input_invoice_process.tpl");
	}
	//-----------------------------------------------------------------------------------------------
	public function InputInvoiceProcess(){
		$aData=String::FilterRequestData(Base::$aRequest['data']);
		
		$aProducts=Db::GetAll("select b.id, '".$aData['id_from']."' as id_from,
						'".$aData['id_to']."' as id_to,
						b.id_user as id_user,
						b.count as count,
                        p.id as id_product,
						b.price as price,
						b.tax
						from store_basket b
						inner join store_products as p on p.id=b.id_product
				where type=1 and id_user='".Auth::$aUser['id']."'");
		if($aProducts) foreach ($aProducts as $aValue) {
			//remove from store_basket
			Db::Execute("delete from store_basket where id='".$aValue['id']."'");
			unset($aValue['id']);
			
			//inser into store_log
			$aValue['post_date']=date("Y-m-d H:i:s", time());
			$aValue['md5_code']=$this->GetMd5($aValue);
			
			Db::AutoExecute("store_log",$aValue);
		}
		Base::Redirect("/pages/store_input_invoice_manual/");
	}
	//-----------------------------------------------------------------------------------------------
	public function Sale() {
		Base::$tpl->assign('sActionPrefix','store_sale');
		$aStores=Db::GetAssoc("select id,name from store where visible=1 and is_virtual=0 and is_return=0 and is_sale=1");
		if(count($aStores==1) && !Base::$aRequest['store']) Base::Redirect("/?action=store_sale&store=".key($aStores));
		Base::$tpl->assign('aStores',$aStores);
		Base::$sText.=Base::$tpl->fetch('store/tab_stores.tpl');
		
		if(Base::$aRequest['is_post']){
			$aRows=Base::$aRequest['row_check'];
				
			if ($aRows) foreach($aRows as $iId){
				$aProduct=Db::GetRow("select * from store_log where id='".$iId."'");
				if($aProduct) {
					// log return
					$aProductSale=array();
					$aProductSale['id_user']=Auth::$aUser['id'];
					$aProductSale['id_from']=Base::$aRequest['store'];
					$aProductSale['id_to']=$aProduct['id_from'];
					$aProductSale['id_order']=$aProduct['id_order'];
					$aProductSale['id_product']=$aProduct['id_product'];
					$aProductSale['price']=$aProduct['price'];
					$aProductSale['count']=$aProduct['count'];
					$aProductSale['tax']=$aProduct['tax'];
					$aProductSale['post_date']=date("Y-m-d H:i:s", time());
					$aProductSale['is_reserved']=0;
					$aProductSale['md5_code']=$aProduct['md5_code'];
					Db::AutoExecute('store_log',$aProductSale);
					
					//remove in  sale 
					Db::Execute("delete from store_log where id='".$iId."' ");
				}
			}
			Base::Redirect("/?".Base::$aRequest['return']);
		}
		
		if(Base::$aRequest['store']){
			Base::$tpl->assign("aBrand", array("0"=>'')+Db::GetAssoc("select pref,title from cat where visible=1"));
			$aData=array(
				'sHeader'=>"method=get",
				'sContent'=>Base::$tpl->fetch('store/form_store_search.tpl'),
				'sSubmitButton'=>'Search',
				'sSubmitAction'=>'store_sale',
				'sReturnButton'=>'Clear',
				'bIsPost'=>0,
				'sWidth'=>'550px',
			);
			$oForm=new Form($aData);
			Base::$sText.=$oForm->getForm();
			
			// --- search ---
			if (Base::$aRequest['search']['code']) $sWhere.=" and p.code like '%".Base::$aRequest['search']['code']."%'";
			if (Base::$aRequest['search']['pref']) $sWhere.=" and p.pref = '".Base::$aRequest['search']['pref']."'";
			// --------------
			
			$oTable=new Table();
			$oTable->sType='array';
			$oTable->aDataFoTable=Db::GetAll(Base::GetSql('Store/Log',array(
				'store'=>Base::$aRequest['store'],
				'order'=>" order by sl.post_date desc ",
				'no_group'=>1,
				'where'=>$sWhere,
			)));
			$oTable->aColumn=array(
					'id'=>array('sTitle'=>'id'),
					//'id_user'=>array('sTitle'=>'id_user'),
					'id_order'=>array('sTitle'=>'id_order'),
					'store_from'=>array('sTitle'=>'store_from'),
					'product'=>array('sTitle'=>'product'),
					'tax'=>array('sTitle'=>'tax'),
					'price'=>array('sTitle'=>'price'),
					'count'=>array('sTitle'=>'count'),
					//'action'=>array(),
			);
			$oTable->bCheckVisible=true;
			$oTable->bDefaultChecked=false;
			$oTable->sFormAction="store_sale";
			$oTable->sDataTemplate='store/row_store.tpl';
			$oTable->sButtonTemplate='store/button_sale_tables.tpl';
				
			Base::$sText.=$oTable->getTable();
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function SaleInvoice() {
		if (Base::$aRequest['action']==$this->sPreffix."sale_invoice_delete"){
			if(Base::$aRequest['id']) Db::Execute("delete from store_basket where id='".Base::$aRequest['id']."' ");
			Base::Redirect("/pages/store_sale_invoice/");
		}
		
		$oTable=new Table();
		$oTable->sSql=Base::GetSql('Store/Basket',array('type'=>'3'));
		$oTable->aColumn=array(
				'id'=>array('sTitle'=>'id'),
				//'id_user'=>array('sTitle'=>'id_user'),
				'store_from'=>array('sTitle'=>'store_from'),
				'product'=>array('sTitle'=>'product'),
				'price'=>array('sTitle'=>'price'),
				'count'=>array('sTitle'=>'count'),
				'action'=>array(),
		);
		$oTable->sDataTemplate='store/row_sale_invoice.tpl';
		
		Base::$tpl->assign("aStoresTo", Db::GetAssoc("select id,name from store where is_return=0 and is_sale=1 and is_virtual=0"));

		Base::$sText.=$oTable->getTable("Sale Invoice");
		Base::$sText.=Base::$tpl->fetch("store/form_sale_invoice_process.tpl");
	}
	//-----------------------------------------------------------------------------------------------
	public function SaleInvoiceProcess() {
		$aData=String::FilterRequestData(Base::$aRequest['data']);
		$aProductsFromSaleBasket=Db::GetAll("select * from store_basket where type=3 and id_user='".Auth::$aUser['id']."'");
		
		if($aProductsFromSaleBasket) foreach ($aProductsFromSaleBasket as $aValue) {
			$this->bTransferFlag=true;
			while ($this->bTransferFlag) {
				$aProductFromLog=Db::GetRow("
					select t.* from (
					select sl.id, sl.id_user, sl.id_from, sl.id_to, sl.id_order, sl.id_product,
					sl.price, sl.tax, sl.md5_code, sl.post_date, sl.is_reserved, sum(sl.count) as count
					from store_log as sl
					where sl.id_product='".$aValue['id_product']."' 
					and sl.id_to='".$aValue['id_from']."'
					and sl.price='".$aValue['price']."'
					group by sl.id_from,sl.id_to,sl.id_product,sl.price
					order by sl.post_date asc
				) as t where count>0");
				$this->bTransferFlag=$this->TransferProcessTry($aProductFromLog,$aValue,$aData,'3');
			}
		}
		Base::Redirect("/pages/store_sale_invoice/");
	}
	//-----------------------------------------------------------------------------------------------
	public function ReturnStore() {
		Base::$tpl->assign('sActionPrefix','store_sale');
		$aStores=Db::GetAssoc("select id,name from store where visible=1 and is_virtual=0 and is_return=1 and is_sale=0");
		if(count($aStores==1) && !Base::$aRequest['store']) Base::Redirect("/?action=store_return&store=".key($aStores));
		Base::$tpl->assign('aStores',$aStores);
		Base::$sText.=Base::$tpl->fetch('store/tab_stores.tpl');
		
		if(Base::$aRequest['store']){
			Base::$tpl->assign("aBrand", array("0"=>'')+Db::GetAssoc("select pref,title from cat where visible=1"));
			$aData=array(
				'sHeader'=>"method=get",
				'sContent'=>Base::$tpl->fetch('store/form_store_search.tpl'),
				'sSubmitButton'=>'Search',
				'sSubmitAction'=>'store_return',
				'sReturnButton'=>'Clear',
				'bIsPost'=>0,
				'sWidth'=>'550px',
			);
			$oForm=new Form($aData);
			Base::$sText.=$oForm->getForm();
				
			// --- search ---
			if (Base::$aRequest['search']['code']) $sWhere.=" and p.code like '%".Base::$aRequest['search']['code']."%'";
			if (Base::$aRequest['search']['pref']) $sWhere.=" and p.pref = '".Base::$aRequest['search']['pref']."'";
			// --------------
			
			$aSaleStores=Db::GetAssoc("select name,id from store where visible=1 and is_virtual=0 and is_return=0 and is_sale=1");
			$sSaleStores=implode("','",$aSaleStores);
			
			$oTable=new Table();
			$oTable->sSql=Base::GetSql('Store/LogBalanse',array(
				'direction'=>0,
				'stores'=>$sSaleStores,
				'where'=>$sWhere,
			));
			$oTable->aColumn=array(
				'id'=>array('sTitle'=>'id'),
				//'id_product'=>array('sTitle'=>'id_product'),
				'store_to'=>array('sTitle'=>'store_to'),
				'product'=>array('sTitle'=>'product'),
				'tax'=>array('sTitle'=>'tax'),
				'price'=>array('sTitle'=>'price'),
				'count'=>array('sTitle'=>'count'),
				'summ'=>array('sTitle'=>'summ price'),
				'summ_tax'=>array('sTitle'=>'summ tax'),
				//'action'=>array(),
			);
			$oTable->sDataTemplate='store/row_return.tpl';
			Base::$sText.=$oTable->getTable("return log");
		}
	}
	//-----------------------------------------------------------------------------------------------
	public function Log(){
		Base::$tpl->assign("aBrand", array("0"=>'')+Db::GetAssoc("select pref,title from cat where visible=1"));
		$aData=array(
				'sHeader'=>"method=get",
				'sContent'=>Base::$tpl->fetch('store/form_store_search.tpl'),
				'sSubmitButton'=>'Search',
				'sSubmitAction'=>'store_log',
				'sReturnButton'=>'Clear',
				'bIsPost'=>0,
				'sWidth'=>'550px',
		);
		$oForm=new Form($aData);
		Base::$sText.=$oForm->getForm();
			
		// --- search ---
		if (Base::$aRequest['search']['code']) $sWhere.=" and p.code like '%".Base::$aRequest['search']['code']."%'";
		if (Base::$aRequest['search']['pref']) $sWhere.=" and p.pref = '".Base::$aRequest['search']['pref']."'";
		// --------------
		
		$oTable=new Table();
		$oTable->sSql=Base::GetSql('Store/History',array(
			'order'=>"sl.id desc",
			'where'=>$sWhere,
		));
		$oTable->aColumn=array(
				'id'=>array('sTitle'=>'id'),
				'id_user'=>array('sTitle'=>'id_user'),
				'store_from'=>array('sTitle'=>'store_from'),
				'store_to'=>array('sTitle'=>'store_to'),
				'id_order'=>array('sTitle'=>'id_order'),
				'product'=>array('sTitle'=>'product'),
				'tax'=>array('sTitle'=>'tax'),
				'price'=>array('sTitle'=>'price'),
				'count'=>array('sTitle'=>'count'),
				'post_date'=>array('sTitle'=>'post_date'),
				//'is_reserved'=>array('sTitle'=>'is_reserved'),
				//'md5_code'=>array('sTitle'=>'md5_code'),
				'action'=>array(),
		);
		$oTable->iRowPerPage=50;
		$oTable->sDataTemplate='store/row_log.tpl';
		Base::$sText.=$oTable->getTable("Log");
	}
	//-----------------------------------------------------------------------------------------------
	public function LogHistory(){
		if(!Base::$aRequest['id']) Base::Redirect("/pages/store_log/");
		$aMd5Code=Db::GetOne("select md5_code from store_log where id='".Base::$aRequest['id']."' ");
		if(!$aMd5Code) Base::Redirect("/pages/store_log/");
		
		$oTable=new Table();
		$oTable->sSql=Base::GetSql('Store/History',array(
			'where'=>"and md5_code='".$aMd5Code."'",
			'order'=>"sl.post_date desc, sl.id desc",
		));
		$oTable->aColumn=array(
				'id'=>array('sTitle'=>'id'),
				'id_user'=>array('sTitle'=>'id_user'),
				'store_from'=>array('sTitle'=>'store_from'),
				'store_to'=>array('sTitle'=>'store_to'),
				'id_order'=>array('sTitle'=>'id_order'),
				'product'=>array('sTitle'=>'product'),
				'tax'=>array('sTitle'=>'tax'),
				'price'=>array('sTitle'=>'price'),
				'count'=>array('sTitle'=>'count'),
				'post_date'=>array('sTitle'=>'post_date'),
				//'is_reserved'=>array('sTitle'=>'is_reserved'),
				//'md5_code'=>array('sTitle'=>'md5_code'),
				'action'=>array(),
		);
		$oTable->iRowPerPage=Db::GetOne(Base::GetSql('Store/History',array(
			'count'=>1,
			'where'=>"and md5_code='".$aMd5Code."'",
			'order'=>"sl.post_date desc, sl.id desc",
		)));
		$oTable->bStepperVisible=false;
		$oTable->sDataTemplate='store/row_log_history.tpl';
		Base::$sText.=$oTable->getTable("Log history");
	}
	//-----------------------------------------------------------------------------------------------
	public function GetMd5($aValue){
		return md5($aValue['id_from'].$aValue['id_to'].$aValue['id_order'].$aValue['id_product'].$aValue['price'].$aValue['count'].$aValue['post_date'].$aValue['post_date']);
	}
	//-----------------------------------------------------------------------------------------------
	public function UpdateNumber(){
		Db::Execute("update ".Base::$aRequest['table']." set ".Base::$aRequest['col']."='".Base::$aRequest['number']."' where id='".Base::$aRequest['row']."'");
	}
	//-----------------------------------------------------------------------------------------------
	public function Transfer() {	
		if (Base::$aRequest['action']==$this->sPreffix."transfer_delete"){
			if(Base::$aRequest['id']) Db::Execute("delete from store_basket where id='".Base::$aRequest['id']."' ");
			Base::Redirect("/pages/store_transfer/");
		}
	
		$oTable=new Table();
		$oTable->sSql=Base::GetSql('Store/Basket',array('type'=>'2'));
		$oTable->aColumn=array(
				'id'=>array('sTitle'=>'id'),
				//'id_user'=>array('sTitle'=>'id_user'),
				'store_from'=>array('sTitle'=>'store_from'),
				'product'=>array('sTitle'=>'product'),
				'tax'=>array('sTitle'=>'tax'),
				'price'=>array('sTitle'=>'price'),
				'count'=>array('sTitle'=>'count'),
				'action'=>array(),
		);
		$oTable->sDataTemplate='store/row_transfer.tpl';
		Base::$sText.=$oTable->getTable("Transfer Invoice");
	
		Base::$tpl->assign("aStoresFrom", Db::GetAssoc("select id,name from store where is_return=0 and is_sale=0 and is_virtual=0"));
		Base::$tpl->assign("aStoresTo", Db::GetAssoc("select id,name from store where is_return=0 and is_sale=0 and is_virtual=0"));
		Base::$sText.=Base::$tpl->fetch("store/form_transfer_process.tpl");
	}
	//-----------------------------------------------------------------------------------------------
	public function TransferProcess(){
		$aData=String::FilterRequestData(Base::$aRequest['data']);
		if($aData['id_from']==$aData['id_to']) Base::Redirect("/pages/store_transfer/");
		
		$aProductsFromBasket=Db::GetAll("select * from store_basket where type=2 and id_user='".Auth::$aUser['id']."'");
		if($aProductsFromBasket) foreach ($aProductsFromBasket as $aValue) {
			$this->bTransferFlag=true;
			while ($this->bTransferFlag) {
				$aProductFromLog=Db::GetRow("
					select t.* from (
					select sl.id, sl.id_user, sl.id_from, sl.id_to, sl.id_order, sl.id_product,
					sl.price, sl.tax, sl.md5_code, sl.post_date, sl.is_reserved, sum(sl.count) as count
					from store_log as sl
					where sl.id_product='".$aValue['id_product']."' 
					and sl.id_to='".$aValue['id_from']."'
					and sl.price='".$aValue['price']."'
					group by sl.id_from,sl.id_to,sl.id_product,sl.price
					order by sl.post_date asc
				) as t where count>0");
				$this->bTransferFlag=$this->TransferProcessTry($aProductFromLog,$aValue,$aData,'2');
			}
		}
		Base::Redirect("/pages/store_transfer/");
	}
	//-----------------------------------------------------------------------------------------------
	public function TransferProcessTry($aProductFromLog=array(),&$aValue=array(),$aData=array(),$iType='2'){
		if ($aProductFromLog){
			if(($aProductFromLog['count']-$aValue['count'])>=0) {
				//normal count
				$iTmpCount=$aProductFromLog['count']-$aValue['count'];
				
				unset($aProductFromLog['id']);
				$aProductFromLog['count']=-$aValue['count'];
				$aProductFromLog['post_date']=date("Y-m-d H:i:s", time());
				Db::AutoExecute('store_log',$aProductFromLog);
					
				// log transfer
				$aProductSale=array();
				$aProductSale['id_user']=Auth::$aUser['id'];
				$aProductSale['id_from']=$aValue['id_from'];
				$aProductSale['id_to']=$aData['id_to'];
				$aProductSale['id_order']=$aData['id_order']?$aData['id_order']:0;
				$aProductSale['id_product']=$aProductFromLog['id_product'];
				$aProductSale['price']=$aProductFromLog['price'];
				$aProductSale['count']=$aValue['count'];
				$aProductSale['tax']=$aProductFromLog['tax'];
				$aProductSale['post_date']=date("Y-m-d H:i:s", time());
				$aProductSale['is_reserved']=0;
				$aProductSale['md5_code']=$aProductFromLog['md5_code'];
				Db::AutoExecute('store_log',$aProductSale);
					
				Db::Execute("delete from store_basket where id='".$aValue['id']."' ");
				return false;
			} else {
				// not have much products
				$iAvalibleCount=$aProductFromLog['count'];
				
				unset($aProductFromLog['id']);
				$aProductFromLog['count']=-$iAvalibleCount;
				$aProductFromLog['post_date']=date("Y-m-d H:i:s", time());
				Db::AutoExecute('store_log',$aProductFromLog);
					
				// log transfer
				$aProductSale=array();
				$aProductSale['id_user']=Auth::$aUser['id'];
				$aProductSale['id_from']=$aValue['id_from'];
				$aProductSale['id_to']=$aData['id_to'];
				$aProductSale['id_order']=$aData['id_order']?$aData['id_order']:0;
				$aProductSale['id_product']=$aProductFromLog['id_product'];
				$aProductSale['price']=$aProductFromLog['price'];
				$aProductSale['count']=$iAvalibleCount;
				$aProductSale['tax']=$aProductFromLog['tax'];
				$aProductSale['post_date']=date("Y-m-d H:i:s", time());
				$aProductSale['is_reserved']=0;
				$aProductSale['md5_code']=$aProductFromLog['md5_code'];
				Db::AutoExecute('store_log',$aProductSale);
			
				$aValue['count']=$aValue['count']-$iAvalibleCount;
				Db::Execute("update store_basket set count='".($aValue['count'])."' where id='".$aValue['id']."' and id_from='".$aValue['id_from']."' and type='".$iType."'");
				return true;
			}
		} else return false;
	}
	//-----------------------------------------------------------------------------------------------
	public function Balance(){
		$aStores=Db::GetAssoc("select id,name from store where visible=1 and is_virtual=0 and is_return=0 and is_sale=0");
		Base::$tpl->assign('aStores',$aStores);
		
		$aData=array(
			'sHeader'=>"method=get",
			'sContent'=>Base::$tpl->fetch('store/form_search_balance.tpl'),
			'sSubmitButton'=>'View',
			'sSubmitAction'=>'store_balance',
			'sReturnButton'=>'Clear',
			'bIsPost'=>0,
			'sWidth'=>'600px',
		);
		$oForm=new Form($aData);
		Base::$sText.=$oForm->getForm();
		
		// --- search ---
		if (Base::$aRequest['search']['store']) $sStores=Base::$aRequest['search']['store'];
		else $sStores=implode("','",array_keys($aStores));
		
		if (Base::$aRequest['search']['date_to']) $sDateTo=Base::$aRequest['search']['date_to'];
		if (Base::$aRequest['search']['date_from']) $sDateFrom=Base::$aRequest['search']['date_from'];
		// --------------
		if(!$sDateTo || !$sDateFrom) {
			Base::$sText.=Language::GetText('store select period');
			return ;
		}
		
		/* ,sl.id_product, sl.price, GROUP_CONCAT(sl.id SEPARATOR ',') as log_rows */ 
		$aProducts=Db::GetAssoc("select concat(p.id,'_',sl.price) as product  , p.item_code
			 , concat(c.name,' ',p.code,' ',p.name) as name
			from store_products as p 
			inner join store_log as sl on sl.id_product=p.id
			left join cat as c on c.pref=p.pref
			WHERE 1=1 
			and SUBSTR( sl.post_date, 1, 10 ) >=  '".$sDateFrom."' and SUBSTR( sl.post_date, 1, 10 ) <=  '".$sDateTo."'
			and sl.id_to in ('".$sStores."')
			group by p.id,sl.price");
		
		if($aProducts){
			// get count before period
			$aBeforeCount=Db::GetAssoc("SELECT CONCAT( p.id,  '_', sl.price ) AS product, sl.id_product, sl.price, SUM( sl.count ) AS count
				FROM store_log AS sl
				INNER JOIN store_products AS p ON p.id = sl.id_product
				WHERE SUBSTR( sl.post_date, 1, 10 ) <  '".$sDateFrom."' AND sl.id_to IN ( '".$sStores."') 
				GROUP BY sl.id_product, sl.price");
			// set count before
			if($aBeforeCount)
			foreach ($aProducts as $sKey => $aValue){
				$aProducts[$sKey]['count_before']=$aBeforeCount[$sKey]['count'];
				$aProducts[$sKey]['summ_before']=$aBeforeCount[$sKey]['count']*$aBeforeCount[$sKey]['price'];
			}
			
			// get count add
			$aAddCount=Db::GetAssoc("SELECT CONCAT( p.id,  '_', sl.price ) AS product, sl.id_product, sl.price, SUM( sl.count ) AS count
				FROM store_log AS sl
				INNER JOIN store_products AS p ON p.id = sl.id_product
				WHERE SUBSTR( sl.post_date, 1, 10 ) >=  '".$sDateFrom."' and SUBSTR( sl.post_date, 1, 10 ) <=  '".$sDateTo."' AND sl.id_to IN ( '".$sStores."' ) and sl.count>0
				GROUP BY sl.id_product, sl.price");
			// set count add
			if($aAddCount)
			foreach ($aProducts as $sKey => $aValue){
				$aProducts[$sKey]['count_add']=$aAddCount[$sKey]['count'];
				$aProducts[$sKey]['summ_add']=$aAddCount[$sKey]['count']*$aAddCount[$sKey]['price'];
			}
			
			// get count remove
			$aRemoveCount=Db::GetAssoc("SELECT CONCAT( p.id,  '_', sl.price ) AS product, sl.id_product, sl.price, SUM( sl.count ) AS count
				FROM store_log AS sl
				INNER JOIN store_products AS p ON p.id = sl.id_product
				WHERE SUBSTR( sl.post_date, 1, 10 ) >=  '".$sDateFrom."' and SUBSTR( sl.post_date, 1, 10 ) <=  '".$sDateTo."' AND sl.id_to IN ( '".$sStores."' ) and sl.count<0
				GROUP BY sl.id_product, sl.price");
			// set count remove
			if($aRemoveCount)
			foreach ($aProducts as $sKey => $aValue){
				$aProducts[$sKey]['count_remove']=abs($aRemoveCount[$sKey]['count']);
				$aProducts[$sKey]['summ_remove']=abs($aRemoveCount[$sKey]['count'])*$aRemoveCount[$sKey]['price'];
			}
			
			// get count last period
			$aLastCount=Db::GetAssoc("SELECT CONCAT( p.id,  '_', sl.price ) AS product, sl.id_product, sl.price, SUM( sl.count ) AS count
				FROM store_log AS sl
				INNER JOIN store_products AS p ON p.id = sl.id_product
				WHERE SUBSTR( sl.post_date, 1, 10 ) <=  '".$sDateTo."'/* and SUBSTR( sl.post_date, 1, 10 ) >=  '".$sDateFrom."'*/ AND sl.id_to IN ( '".$sStores."' )
				GROUP BY sl.id_product, sl.price");
			// set count last
			if($aLastCount)
			foreach ($aProducts as $sKey => $aValue){
				$aProducts[$sKey]['count_last']=$aLastCount[$sKey]['count'];
				$aProducts[$sKey]['summ_last']=$aLastCount[$sKey]['count']*$aLastCount[$sKey]['price'];
			}
		}
		if($aProducts) {
			$dTotalBefore=0;
			$dTotalAdd=0;
			$dTotalRemove=0;
			$dTotalLast=0;
			
			foreach ($aProducts as $aValue){
				$dTotalBefore+=$aValue['summ_before'];
				$dTotalAdd+=$aValue['summ_add'];
				$dTotalRemove+=$aValue['summ_remove'];
				$dTotalLast+=$aValue['summ_last'];
			}
			Base::$tpl->assign('aSubtotalBalance',array(
				'before'=>$dTotalBefore,
				'add'=>$dTotalAdd,
				'remove'=>$dTotalRemove,
				'last'=>$dTotalLast,
			));
			sort($aProducts);
		}
		
		$oTable=new Table();
		$oTable->sType='array';
		$oTable->aDataFoTable=$aProducts;
		$oTable->aColumn=array(
			'name' => array ( 'sTitle' => 'name' ),
			'count_before' => array ( 'sTitle' => 'count_before' ),
			'summ_before' => array ( 'sTitle' => 'summ_before' ),
			'count_add' => array ( 'sTitle' => 'count_add' ),
			'summ_add' => array ( 'sTitle' => 'summ_add' ),
			'count_remove' => array ( 'sTitle' => 'count_remove' ),
			'summ_remove' => array ( 'sTitle' => 'summ_remove' ),
			'count_last' => array ( 'sTitle' => 'count_last' ),
			'summ_last' => array ( 'sTitle' => 'summ_last' ),
		);
		$oTable->bStepperVisible=false;
		$oTable->iRowPerPage=count($aProducts);
		$oTable->sDataTemplate='store/row_balance.tpl';
		$oTable->sSubtotalTemplate='store/row_balance_subtotal.tpl';
		Base::$sText.=$oTable->getTable("balance");
	}
	//-----------------------------------------------------------------------------------------------
	public function ExportToPrice(){
		$iStore=Base::$aRequest['store'];
		
		$sSql="select p.item_code, p.name as part_rus, p.code, p.pref, sl.price, sl.count as stock, s.id_provider
			from store_log as sl
			inner join store_products as p on p.id=sl.id_product
			inner join store as s on sl.id_to=s.id
			where sl.id_to='".$iStore."'
			and sl.count>0";
		$aAllStoreProducts=Db::GetAll($sSql);
		
		$aPrefAssoc=Db::GetAssoc("select c.pref,UPPER(cp.name) from cat_pref cp inner join cat c on c.id=cp.cat_id");
		
		$aExportProducts=array();
		if($aAllStoreProducts) foreach ($aAllStoreProducts as $aValue){
			//list($aValue['pref'],$aValue['code'])=explode('_',$aValue['item_code']);
			$aValue['cat']=$aPrefAssoc[$aValue['pref']];
			
			if(!array_key_exists($aValue['item_code']."_".$aValue['price'],$aExportProducts)){
				$aExportProducts[$aValue['item_code']."_".$aValue['price']]=$aValue;
			} else {
				$aExportProducts[$aValue['item_code']."_".$aValue['price']]['stock']+=$aValue['stock'];
			}
		}
		
		if($aExportProducts) foreach ($aExportProducts as $aValue) {
			$sImportSql="insert into price (item_code, id_provider, code, cat, part_rus, price, pref, stock)
			 values ('".$aValue['item_code']."','".$aValue['id_provider']."','".$aValue['code']."','".$aValue['cat']."','".$aValue['part_rus']."','".$aValue['price']."','".$aValue['pref']."','".$aValue['stock']."')
			 on duplicate key update price=values(price),  part_rus=values(part_rus), stock=values(stock)";
			
			Db::Execute($sImportSql);
		}
		
		Base::Redirect("/?action=store&store=".$iStore);
	}
	//-----------------------------------------------------------------------------------------------
	public function Products(){
		if(Base::$aRequest['is_post']){
			Base::$aRequest['data']['item_code']=Base::$aRequest['data']['pref']."_".Base::$aRequest['data']['code'];
			
			if (Base::$aRequest['data']['id']) {
				$sMode = 'UPDATE';
				$sWhere = "id ='" . Base::$aRequest['data']['id'] . "'";
			} else {
				$sMode = 'INSERT';
				$sWhere = false;
			}
			Db::AutoExecute('store_products', Base::$aRequest ['data'], $sMode, $sWhere);
			Base::Redirect("/pages/store_products/");
		}
		
		
		if(Base::$aRequest['action']=='store_products_edit'){
			Base::$tpl->assign('aData',Db::GetRow(Base::GetSql('StoreProducts',array(
				'id'=>Base::$aRequest['id'],
			))));
		}
		
		if(Base::$aRequest['action']=='store_products_add' || Base::$aRequest['action']=='store_products_edit'){
			Base::$tpl->assign('aPref',Base::$db->getAssoc("select pref, concat(title,' [',pref,']') as name from cat order by name"));
			
			$aData=array(
				'sHeader'=>"method=get",
				'sContent'=>Base::$tpl->fetch('store/form_add_product.tpl'),
				'sSubmitButton'=>'save',
				'sSubmitAction'=>'store_products_add',
				'bIsPost'=>1,
			);
			$oForm=new Form($aData);
			Base::$sText.=$oForm->getForm();
			return;
		}
		
		Base::$tpl->assign("aBrand", array("0"=>'')+Db::GetAssoc("select pref,title from cat where visible=1"));
		$aData=array(
			'sHeader'=>"method=get",
			'sContent'=>Base::$tpl->fetch('store/form_store_search.tpl'),
			'sSubmitButton'=>'Search',
			'sSubmitAction'=>'store_products',
			'sReturnButton'=>'Clear',
			'bIsPost'=>0,
			'sWidth'=>'550px',
		);
		$oForm=new Form($aData);
		Base::$sText.=$oForm->getForm();
		
		// --- search ---
		if (Base::$aRequest['search']['code']) $sWhere.=" and sp.code like '%".Base::$aRequest['search']['code']."%'";
		if (Base::$aRequest['search']['pref']) $sWhere.=" and sp.pref = '".Base::$aRequest['search']['pref']."'";
		// --------------
		
		$oTable=new Table();
		$oTable->sSql=Base::GetSql('StoreProducts',array(
			'where'=>$sWhere,
		));
		$oTable->aColumn=array(
			'id'=>array('sTitle'=>'Id','sWidth'=>'5%'),
			'cat'=>array('sTitle'=>'cat'),
			'code'=>array('sTitle'=>'code','sWidth'=>'10%'),
			'name'=>array('sTitle'=>'Name','sWidth'=>'30%'),
			'item_code'=>array('sTitle'=>'item_code'),
			'action' => array ()
		);
		$oTable->sDataTemplate='store/row_store_products.tpl';
		$oTable->sButtonTemplate='store/button_store_products.tpl';
		Base::$sText.=$oTable->getTable('store products');
	}
	//-----------------------------------------------------------------------------------------------
}
?>