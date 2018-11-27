<?php 

require_once "functions.php";
require_once "connection.php";
require_once "autoload.php";

use Server\Classes\User;

sec_session_start(); 

if(isset($_REQUEST['login'])){
    $error_msg = "";
    $validate = validate($_POST);
    if($validate != false) {
        $user = User::getInstance();
        $username = $validate['username'];
        $password = $validate['password'];

        if($user->login($con, $_POST['username'], $password) === true) {
            echo "Successfuly logged in";
            header('Location: '.$_SERVER['HTTP_REFERER']);
        } else {
            echo "Failed to validate user or password!<br>";
            echo "<a href=".$_SERVER['HTTP_REFERER'].">Return to login</a>";
        }
    } else {
    }
    
} 


if(isset($_REQUEST['logout'])){
    $logged = unserialize($_SESSION['user']);
    $logged->logout();
    unset($logged);
    header('Location: '. $_SERVER['HTTP_REFERER']);
}