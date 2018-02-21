<?
/**
 * @author Vladimir Fedorov
 * 
 */

class PaymentDeclaration extends Base
{
	//-----------------------------------------------------------------------------------------------
	public function __construct()
	{
		Base::$bXajaxPresent = true;
		Base::$aData['template']['bWidthLimit']=true;
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		if (!Auth::$aUser['id'])
			Base::Redirect('/');
		
		if (Auth::$aUser['type_'] == 'manager')
			Base::Redirect('/pages/payment_declaration_manager');
		
		$oTable=new Table();
		$oTable->sSql="Select * from payment_declaration where id_user = ".Auth::$aUser['id'];
		$oTable->aOrdered="order by date_send desc";
		$oTable->aColumn=array(
			'date_send'=>array('sTitle'=>'Date send'),
			'recipient'=>array('sTitle'=>'Recipient'),
			'carrier'=>array('sTitle'=>'Carrier'),
			'number_declaration'=>array('sTitle'=>'Number declaration'),
			'number_places'=>array('sTitle' => 'Number places' ),
		);
		$oTable->sDataTemplate='payment_declaration/row_payment_declaration.tpl';
		$oTable->bStepperVisible=true;
		$oTable->bHeaderVisible=true;
		$oTable->iRowPerPage=10;
		$oTable->bCountStepper=true;
		Base::$sText.=$oTable->getTable();
	}
	//-----------------------------------------------------------------------------------------------

}
?>