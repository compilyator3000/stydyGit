<?php
require_once "../connectToDb.php";
require_once "../vendor/autoload.php";


$db = getConnection();
$id_dish = $_SERVER['REQUEST_URI'];
$id_dish = explode('/', $id_dish);
$dish=new \Brain\dish();

$id_check=is_numeric($id_dish[count($id_dish) - 1]);

if ($id_check) {


        $dish = json_encode($dish->getDishById($db,$id_dish[count($id_dish) - 1]), JSON_UNESCAPED_UNICODE);
        echo $dish;

} else {

    $dish = json_encode($dish->getAllDishes($db), JSON_UNESCAPED_UNICODE);
}


echo "<pre>";

echo $dish;
echo "</pre>";
