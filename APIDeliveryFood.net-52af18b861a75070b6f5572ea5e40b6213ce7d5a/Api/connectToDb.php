<?php
require_once 'vendor/autoload.php';

$db=  Brain\database::getInstance('localhost','crud','root','');//('localhost','crud','root','');
function getConnection(){
    global $db;
    return $db;
}
