<?php
session_start();
define('ROOT_PATH', dirname(__FILE__));
require 'code.class.php';
$_mulin = new ValidateCode();
$_mulin->doimg();
$_SESSION['captcha'] = $_mulin->getCode();
?>