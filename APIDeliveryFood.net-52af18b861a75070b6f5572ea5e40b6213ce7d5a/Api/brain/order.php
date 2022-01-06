<?php
namespace Brain;

use Exception;
use Firebase\JWT\JWT;
require_once "../connectToDb.php";
include_once '../work/config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';

class order
{
//    private $id_food;
//    private $price;
//    private $nameClient;
//    private $count;
//    private $numberPhone;
//    private $deadline;


//$id_food, $price, $nameClient, $count,$deadline, $numberPhone
    public function __construct()
    {
//        $this->count = $count;
//        $this->id_food = $id_food;
//        $this->nameClient = $nameClient;
//        $this->price = $price;
//        $this->numberPhone = $numberPhone;
//        $this->deadline = $deadline;
    }
//    function giveOrder():array{
//        return array('id_food'=>$this->id_food,'price'=>$this->price,'nameClient'=>$this->nameClient,'deadline'=>$this->deadline,'count'=>$this->count,'numberPhone'=>$this->numberPhone);
//
//    }

    function validation($id_food, $price, $nameClient,$deadline, $count, $numberPhone){
        if(empty($id_food)||empty($price)||empty($nameClient)||empty($count)||empty($numberPhone)){
            var_dump("Fields are not filled");
            return -1;
        }
    }


    function execute__order($valid){

        try {
            $data = (array)JWT::decode($valid['jwt'], \configurate::$key, array('HS256'));
            if ($valid['exp'] < time()) {
                throw new Exception("token is no longer valid");
            }
            //var_dump($data['uniqueCode']);
            if ($data['uniqueCode'] == $valid["uniqueCode"]) {
                //отправляем заказ
                //  var_dump("agree");
                unset($data['uniqueCode']);
                $data = convertStdClasesToArray($data);

                echo json_encode(array(
                    "message"=>"Done!"));
                $this->create_order($data);
            }


        } catch (Exception $e) {

            // код ответа
            http_response_code(401);

            // сообщить пользователю отказано в доступе и показать сообщение об ошибке
            echo json_encode(array(
                "message" => "entry is closed",
                "error" => $e->getMessage()
            ));

        }
    }
    private  function create_order($arrayOrders)
    {
        $db=getConnection();

        $phone = $arrayOrders['phone'];
        $name = $arrayOrders['name'];
        unset($arrayOrders['phone']);
        unset($arrayOrders['name']);
        extract($arrayOrders);
        // var_dump($arrayOrders);

        foreach ($arrayOrders as $order) {
            extract($order);
            $sql = $db->prepare("Insert  into `$id_cafe`(`id_dish`,`dedline`,`price`,`count`,`name`,`phone`) values(:id_dish,:dedline,:price,:count,:name,:phone) ");
            $mac = array("id_dish" => $id_dish, "dedline" => $deadline, "price" => $price, "count" => $count, "name" => $name, "phone" => $phone);
            //var_dump($sql);
            $sql->execute($mac);


        }

    }


}