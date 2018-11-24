<?php 

use Server\Classes\User;

    

if(isset($_REQUEST['login'])){
    $error_msg = "";
    $validate = validate($_POST);
    if($validate != false) {
        $user = User::getInstance();
        $username = $validate['username'];
        $password = $validate['password'];
        if($user->login($con, $_POST['username'], $password) === true) {
            echo "Successfuly logged in";
        } else {
            echo "Failed to validate user or password!";
        }
    } else {
        $error_msg = "Login not successful!";
    }
    
} 
if(isset($_REQUEST['logout'])){
    $logged->logout();
    unset($logged);
    header('Location: '. $_SERVER['HTTP_REFERER']);
}