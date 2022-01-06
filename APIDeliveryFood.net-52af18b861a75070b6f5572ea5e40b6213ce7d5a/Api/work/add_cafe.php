<?php
require_once "../connectToDb.php";
require_once "../vendor/autoload.php";
$db = getConnection();
$cafe2=new \Brain\cafe();
$cafe = (array)json_decode(file_get_contents("php://input"));

if (isset($cafe['name']) &&
    isset($cafe['location']) &&
    isset($cafe['status']) &&
    isset($cafe['description']) &&
    isset($cafe['password'])
) {

    http_response_code(200);
    $cafe2->create_new_cafe($db,$cafe['name'], $cafe['password'], $cafe['location'], $cafe['status'], $cafe['description']);

    echo json_encode(array("message" => "Cafe is complete."));
} else {
    http_response_code(400);


    echo json_encode(array("message" => "Error! Can not add cafe."));

}