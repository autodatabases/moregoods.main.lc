<?

$aOrderStatusConfig=array(
'new'=>array('new','work','confirmed', 'road', 'store', 'end', 'refused',),
'work'=>array('work','confirmed', 'road', 'store', 'end', 'refused',),
'confirmed'=>array('confirmed','road', 'store', 'end', 'refused',),
'road'=>array('road','store', 'end', 'refused',),
'store'=>array('store','end','refused',),
'pending'=>array('refused'),
'refused'=>array('refused'),
'end'=>array('end'),
);


$aUnstateOrderStatus=array('change_price','change_quantity','change_code');

$aOrderStatusColor=array(
'new'=>'broun',
'work'=>'green',
'confirmed'=>'#0000A0',
'road'=>'#1589FF',
'store'=>'blue',
'end'=>'black',
'refused'=>'red',
'pending'=>'blue',
);

?>