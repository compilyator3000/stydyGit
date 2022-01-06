<?php
require_once "../connectToDb.php";
include_once 'config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
include_once "../workWithArray.php";

use \Firebase\JWT\JWT;

$db = getConnection();
$order=new Brain\order();
$valid = (array)json_decode(file_get_contents("php://input"));//jwt+ id-order
$order->execute__order($valid);


