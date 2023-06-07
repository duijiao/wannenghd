<?php

//header('Content-type:text/json;charset=utf-8');
//session_start();
$num = $_GET['num'];
header('Content-type:text/json;charset=utf-8');
$result = file_get_contents("https://api.vvhan.com/api/phone?tel=" . $num);
echo $result;
?>