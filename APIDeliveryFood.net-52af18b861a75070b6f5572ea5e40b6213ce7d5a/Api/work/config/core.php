<?php
// показывать сообщения об ошибках
error_reporting(E_ALL);

// установить часовой пояс по умолчанию
date_default_timezone_set('Europe/Kiev');
class configurate{
    public static string $key="my_key";
    public static int $iat = 1356999524;
    public static int $nbf = 1357000000;

}


//// переменные, используемые для JWT
//$key = "my_key";
//$iat = 1356999524;
//$nbf = 1357000000;
?>