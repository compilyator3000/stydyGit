<?php
function convertOrdersToArray($orders/*stdClassArray*/){
    $orders=(array)$orders;
    //var_dump($orders);
   $orders[]=$orders['name'];
   $orders[]=$orders["phone"];
    $orders['order']=(array)$orders["order"];

    foreach ($orders['order'] as $order){
        $NewOrders[]=(array)$order;
    }
    $NewOrders['name']=$orders['name'];
    $NewOrders['phone']=$orders['phone'];

    return $NewOrders;
}
function convertStdClasesToArray($orders){

    foreach ($orders as $key=>$order){
       // var_dump(gettype($order)=='object');
        if(gettype($order)=='object') {
            $NewOrders[] = (array)$order;
        }else{
            $NewOrders[$key] = $order;
        }

    }
   // $NewOrders['name']=$orders['name'];
   // $NewOrders['phone']=$orders['phone'];

    return $NewOrders;
    
}

