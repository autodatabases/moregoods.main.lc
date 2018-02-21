<?php
$oObject = new Favourites();
$sPrefix = 'favourites_';

switch (Base::$aRequest['action'])
{
    case $sPrefix.'add':
        $oObject->AddFavourites();
        break;
        
    case $sPrefix.'delete':
        $oObject->DelFavourites();
        break;
    
    case $sPrefix.'manager':
        $oObject->Index();
        break;
    
    case $sPrefix.'update':
         $oObject->UpdateFavourites();
         break;
    
	default:
		$oObject->Index();
		break;
}
?>