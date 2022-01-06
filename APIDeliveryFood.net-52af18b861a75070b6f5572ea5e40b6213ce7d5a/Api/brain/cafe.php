<?php
//сделать индексы на поля при создании таблицы заказов для кафе
namespace Brain;
require_once "../connectToDb.php";

include_once '../work/config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';

use Exception;
use \Firebase\JWT\JWT;
use PDO;

class cafe
{


    function valivdate($data){//передаём весь поток пост, оно само возьмёт то что нужно

        $data = (array)json_decode($data,true);


        $jwt = $data['jwt'];
        var_dump($jwt);
        try {
            if ($jwt) {

                $decoded = JWT::decode($jwt,  \configurate::$key, array('HS256'));
                // код ответа
                http_response_code(200);
                if ($decoded) {
                    //может вынести данные кафе в общие?
                    return true;
                }

            }
        } catch (Exception $e) {

            http_response_code(401);
            return false;

        }
    }
    function giveCafeHimOrders($connect,$id_cafe, $id_order = 1)
    {
        if ($id_order != 1) {
            $id_order = "`id`=$id_order";
        }
        $sql = $connect->prepare("Select * from `$id_cafe` where $id_order ");

        $errorInfo = $sql->execute();

        if ($errorInfo != PDO::ERR_NONE) {
            var_dump("Error add Cafe");
            return -1;
        }
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    function entry_cafe($connect,$id, $password)
    {
        $query = $connect->prepare("select `id`,`password` from `cafe` where `id`=:id ");
        $query->bindParam('id', $id);
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC)[0];

        $pass = password_verify($password, $data['password']);

        if ($pass) {
            return true;
        }
        return false;
    }
    function create_new_cafe($connect,string $name, string $password, string $location, int $status, string $description)
    {
        $sql = $connect->prepare("insert into cafe(`id`,`password`,`name`,`location`,`status`,`description`) value(:id, :password,:name, :location, :status,:description)");
        $value = rand(10000, 9999999);
        $mas = array('id' => $value, 'password' => password_hash($password, PASSWORD_BCRYPT), 'name' => $name, 'location' => $location, 'status' => $status, 'description' => $description);
        $errorInfo = $sql->execute($mas);
        if ($errorInfo != PDO::ERR_NONE) {
            var_dump("Error add Cafe");
            return -1;
        }
        $db=getConnection();
        database::createTableOrder($value);

    }
    function getCafes($connect)
    {

        $te = $connect->query("select * from `cafe` ");

        $res = $te->fetchAll(PDO::FETCH_ASSOC);

        foreach ($res as $key => $cafe) {
            unset($cafe['password']);
            $res[$key] = $cafe;

        }
        return $res;
    }

    function getCafesById($connect,$id)
    {

        $te = $connect->prepare("select * from `cafe` where `id`=:id ");
        $te->bindParam('id', $id);
        $te->execute();

        $res = $te->fetch(PDO::FETCH_ASSOC);
        unset($res['password']);
        return $res;
    }

    function getNameCafes()
    {
        $connect=getConnection();
        $te = $connect->query("select `name` from `cafe`  ");
        return $te->fetch(PDO::FETCH_ASSOC);
    }

}