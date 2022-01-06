<?php

require_once "../connectToDb.php";
require_once "../vendor/autoload.php";
//$db= new database('localhost','crud','root','');

$db=getConnection();

$cafeObject= new \Brain\cafe();
$id_cafe=$_SERVER['REQUEST_URI'];
$id_cafe=explode('/',$id_cafe);

if(is_numeric($id_cafe[count($id_cafe) - 1])) {

    $cafe = json_encode($cafeObject->getCafesById($db, $id_cafe[count($id_cafe) - 1]), JSON_UNESCAPED_UNICODE);
    echo ($cafe);
}else{

    $cafes=json_encode($cafeObject->getCafes($db));
    echo ($cafes);}





