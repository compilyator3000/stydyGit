<?php

use Brain\cafe;

require_once "../connectToDb.php";
//require_once "valid_entry_cafe.php";
require_once "../vendor/autoload.php";
$cafe=new cafe();

if($cafe->valivdate(file_get_contents("php://input"))==false) {

    http_response_code(400);
        die(
json_encode(array("message" => "Error! Data is not correctly."))
        );
}


$db = getConnection();
$query = $_SERVER['REQUEST_URI'];
$query = explode('/', $query);
$id_cafe=is_numeric($query[count($query) - 2])? $query[count($query) - 2] :  $query[count($query) - 1] ;
$id_order=!is_numeric($query[count($query) - 2])? 1:  $query[count($query) - 1];



if (is_numeric($id_order)) {

        $dish = json_encode($cafe->giveCafeHimOrders($db,$id_cafe,$id_order),JSON_UNESCAPED_UNICODE);
        echo $dish;


} else {
    $dish = json_encode($cafe->giveCafeHimOrders($db,$id_cafe),JSON_UNESCAPED_UNICODE);
    echo $dish;
}


