<?php
namespace Brain;
use PDO;

class database
{
private static  $instance;
  //  private static $connect = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
private function clone(){}

    static public function getInstance($host, $dbname, $username, $password){

    if(self::$instance===null){
        self::$instance=new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

        if (self::checkExistTable($dbname, 'cafe') == null) {
            self::createTableCafe();
        }
        if (self::checkExistTable($dbname, 'food') == null) {
            self::createTableFood();
        }



    }
    return self::$instance;
    }
    public function __wakeup(){}

    private  function __construct()
    {



//        if ($this->checkExistTable($dbname,'order') == null) {
//            $this->createTableOrder();
//        }


    }

    private static function checkExistTable($dbname, $nameTable)
    {
        global $instance;
        $res = self::$instance->prepare("SHOW TABLES FROM $dbname LIKE '$nameTable'");
        $res->execute();
        $res = $res->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

   private static function createTableCafe()
    {
        global $instance;
        //var_dump($connect);
        $sql = self::$instance->prepare('CREATE TABLE `cafe`(id int(11) NOT null,
 name varchar(100) not null,
 password text(1000) not null,
  location varchar(100) not null,
   status int(2) not null,
    description text(1000),
     PRIMARY KEY(id))');
        $errorInfo = $sql->execute();
        if ($errorInfo != PDO::ERR_NONE) {
            var_dump("Error create table");
            return -1;
        }

    }



      static function createTableFood()
    {
        global $instance;
        $sql = self::$instance->prepare('CREATE TABLE `food`(id int(11) NOT null ,
  id_cafe int(11) not null,
  categories varchar (100) not null,
  name varchar(100) not null,
  price int(11) not null,
 description text(1000),
     PRIMARY KEY(id))');
        $errorInfo = $sql->execute();
        if ($errorInfo != PDO::ERR_NONE) {
            var_dump("Error create food");
            return -1;
        }
    }

    static function createTableOrder($name)
    {
        $sql = self::$instance->prepare("CREATE TABLE `$name` (id int(11) NOT null AUTO_INCREMENT,
  id_dish int(11) not null,
  name varchar(100) not null,
  price int(11) not null,
  count int(5) not null,
   name_client varchar (100) not null,
      phone varchar (30) not null,

     PRIMARY KEY(id))");
        $errorInfo = $sql->execute();
        if ($errorInfo != PDO::ERR_NONE) {
            var_dump("Error create order");
            return -1;
        }
    }











}

function createNamePhoto($name, $newName)
{

    $str = "/.jpg$|.png$/";


    if (preg_match($str, $name)) {
        if (strpos($name, ".jpg")) {
            str_replace(".jpg", "", $name);
            $name = $newName;
            $name = $name . ".jpg";
        }
        if (strpos($name, ".png")) {
            str_replace(".png", "", $name);
            $name = $newName;
            $name = $name . ".png";
        }

    }
    return $name;
}


