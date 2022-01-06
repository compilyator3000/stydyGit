<?php

namespace Brain;
use PDO;


require_once "../vendor/autoload.php";
require_once "../connectToDb.php";
class dish
{

    function addFood($connect,$id_cafe, string $nameFood, $price, $categories, $description, $photo)
    {


        $sql = $connect->prepare("Insert into `food`(`id`,`id_cafe`,`categories`, `name`, `price`,  `description`) VALUES (:id, :id_cafe, :categories, :name, :price, :description) ");
        $id = rand(500000, 1000000);
        $mas = array('id' => $id, 'id_cafe' => $id_cafe, 'categories' => $categories, 'name' => $nameFood, 'price' => $price, 'description' => $description);

        $newName = "PhotoFood/" . $mas['id'] . ".png";
        move_uploaded_file($photo, $newName);


        $errorInfo = $sql->execute($mas);
        if ($errorInfo != PDO::ERR_NONE) {
            var_dump("Error add Food");
            return -1;
        }


    }
    function getAllDishByCategories($connect,string $categories)
    {

        $sql = $connect->prepare("Select * from `food` where categories=:categories");
        $sql->bindParam('categories', $categories);
        $errorInfo = $sql->execute();

        if ($errorInfo != PDO::ERR_NONE) {
            var_dump("Error add Cafe");
            return -1;
        }
        return $sql->fetch(PDO::FETCH_ASSOC);

    }

    function getAllDishes($connect): array
    {

        $categories = array();
        $te = $connect->query("select * from `food` ");
        $ret = $te->fetchALL(PDO::FETCH_ASSOC);
        foreach ($ret as $cafe) {
            if (!isset($categories[$cafe['id_cafe']])) {
                $categories[$cafe['id_cafe']] = array();
            }
            if (!isset($categories[$cafe['id_cafe']][$cafe['categories']])) {
                $categories[$cafe['id_cafe']][$cafe['categories']] = array();
            }

            $categories[$cafe['id_cafe']][$cafe['categories']][] = array('id' => $cafe['id'], 'name' => $cafe['name'], 'price' => $cafe['price'], 'photo' => $this->getImage($cafe['id']), 'description' => $cafe['description']);

        }
        return $categories;
    }


    function getDishById($connect,$idDish)
    {

        $sql = $connect->prepare("Select * from `food` where `id`=:id");
        $sql->bindParam('id', $idDish);
        $sql->execute();
        $arr = $sql->fetch(PDO::FETCH_ASSOC);

        $arr += ['photo' => $this->getImage($arr['id'])];
        return $arr;

    }
    function getCategoriesByCafe($connect,$idCafe)
    {

        $sql =$connect->prepare("Select `categories` from `food` where `id_cafe`=:id_cafe");

        $sql->bindParam('id_cafe', $idCafe);
        $sql->execute();
        $temp = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $this->parseCategories($temp);

    }

    function getAllCategories($connect)
    {
      //  $connect=getConnection();
        $sql = $connect->prepare("Select `categories` from `food` where 1");
        $sql->execute();
        $temp = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $this->parseCategories($temp);

    }




    function getImage($idIMG)
    {//759464.png
        $file = "../../PhotoFood/" . $idIMG . ".png";
        return base64_encode(file_get_contents($file));
    }

    function parseCategories(array $categories)
    {
        $newCategories = array();
        foreach ($categories as $cat) {
            $temp = $cat['categories'];
            if (!in_array($temp, $newCategories)) {
                $newCategories[] = $temp;

            }

        }
        return $newCategories;
    }

}