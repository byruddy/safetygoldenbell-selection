<?php 
include_once('../connection.php');
include_once('../config.php');

if(isset($_SESSION)){
 session_start();
 session_destroy();
 header('Location: http://172.21.77.185/safetygoldenbell/welcome/'); exit;
}