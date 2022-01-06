<?php

use Firebase\JWT\JWT;

require_once "../vendor/autoload.php";

require_once "../connectToDb.php";
include_once 'config/core.php';
//include_once '../libs/php-jwt-master/src/BeforeValidException.php';
//include_once '../libs/php-jwt-master/src/ExpiredException.php';
//include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
//include_once '../libs/php-jwt-master/src/JWT.php';
//use \Firebase\JWT\JWT;


$db=getConnection();
$cafe=new Brain\cafe();

$data=(array)json_decode(file_get_contents("php://input"));

if(!isset($data['login']) &&
    !isset($data['password'])

) {
    http_response_code(400);
    echo json_encode(array("message" => "Error! Data is not correctly."));
}



$res= $cafe->entry_cafe($db,$data['login'],$data['password']);

if( $res){
    $token=array("id"=>$data['login']);
    $jwt=JWT::encode($token,configurate::$key);

    http_response_code(200);
    echo json_encode(
        array(
            "message" => "Entry is successful .",
            "jwt" => $jwt
        )
    );
}





