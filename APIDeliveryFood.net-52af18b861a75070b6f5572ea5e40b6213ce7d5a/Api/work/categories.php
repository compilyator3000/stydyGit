<?php

require_once "../vendor/autoload.php";
require_once "../connectToDb.php";


$db=getConnection();
$dish = new \Brain\dish();

$id_cafe=$_SERVER['REQUEST_URI'];
$id_cafe=explode('/',$id_cafe);


if(is_numeric($id_cafe[count($id_cafe)-1])) {
    $cafes = json_encode($dish->getCategoriesByCafe($db,$id_cafe[count($id_cafe)-1]), JSON_UNESCAPED_UNICODE);
}else{

    $cafes = json_encode($dish->getAllCategories($db), JSON_UNESCAPED_UNICODE);
}


echo "<pre>";
print_r($cafes);
echo "</pre>";
//