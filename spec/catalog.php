<?php

$oObject=new Catalog();
$sPrefix='catalog_';

switch (Base::$aRequest['action'])
{

	case $sPrefix."price_view":
		$oObject->ViewPrice();
		break;

    case $sPrefix."product":
        $oObject->CatalogProduct();
        break;

    case $sPrefix."vid":
        $oObject->CatalogVid();
        break;

	case $sPrefix."brand":
	    $oObject->CatalogBrand();
	    break;
	    
	case $sPrefix."group":
        $oObject->CatalogGroup();
        break;
        
    case $sPrefix.'review_view_show':
        $oObject->ViewReviewShow();
        break;
    
    case $sPrefix.'review_edit':
        $oObject->EditReview();
        break;
    
    case $sPrefix.'review_remove':
        $oObject->RemoveReview();
        break;
    
    case $sPrefix."stars":
        $oObject->Stars();
        break;
            
    case $sPrefix."filter":
        $oObject->Filter();
        break;

    case $sPrefix."promo":
       	$oObject->Promo();
       	break;
        
	default:
		$oObject->Index();
		break;
}
?>