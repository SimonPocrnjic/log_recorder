<?php 

use Server\Classes\User as User;

if(isset($logged) && $logged->authorizedUser()) {

    $users = (!$logged->getUserList($con)) ? [] : $logged->getUserList($con);

    if(isset($_REQUEST['createuser'])) {
        $validate = validate($_POST);
        if($validate != false && !$logged->authorizedUser()) {
            echo "Failed to validate";
        } else {
            $newuser = User::getInstance();
            $username = $validate['username'];
            $password = $validate['password'];
            $email = $validate['email'];
            if($newuser->create($con, $username, $password, $email)) {
                echo "User created";
                $users = $logged->getUserList($con);
            } else {
                echo "Failed to create user";
            }
        }
    }


} else {
    header('Location: '.URL);
}