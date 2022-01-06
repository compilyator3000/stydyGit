<?php
require_once "../connectToDb.php";
include_once 'config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
require_once "../vendor/autoload.php";
include_once "../workWithArray.php";
use \Firebase\JWT\JWT;



$db=getConnection();
$orders=json_decode(file_get_contents("php://input"),true);//будет массив stdClass-ов
$orders=convertOrdersToArray($orders);

if(checkEdit($orders)){
    http_response_code(400);
    die (json_encode(array(
        "message"=>"Error! Edits is empty")
    ));
}

//по факту этот $uniqueCode мы должны отправить пользователю
$uniqueCode=rand(1000,9999);
$phone=$orders["phone"];
$name=$orders["name"];

$forLog="Number phone:$phone; Name:$name; VerifyCode:$uniqueCode\n";
file_put_contents("../../MustBeSend.txt",$forLog,FILE_APPEND);
$orders['uniqueCode']=$uniqueCode;

$jwt=JWT::encode($orders,configurate::$key);
echo json_encode(array(
    "exp"=>time()+300,
        "data"=>array(
            "message"=>"Verifying order ",
            "jwt"=>$jwt
        )
    )
);



//будет ещё айди самого заказа
//формируем заказ -- формируем его jwt и отравляем его пользователю-- пользователь с jwt отправит нам код подтверджения с телефона
function checkEdit($orders)//returns true if one of edits is empty
{
    //var_dump($orders);
    if($orders['name']=='' ||$orders['phone']=='') {

        return true;
    }
    foreach ($orders as $key=>$order) {
        if($key=="name"||$key=="phone"){
            continue;
        }

        if ($order['id_cafe'] =="" ||
            $order['price']=="" ||
           $order['count']=="" ||
            $order['id_dish']==""||
            $order['deadline']==""

          ) {
            return true;
        }
    }
    return false;
}

