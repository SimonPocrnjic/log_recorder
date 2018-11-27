<?php 
    $trim_url = preg_replace("/\/+[a-zA-z0-9]+.php/","", $_SERVER['PHP_SELF']);

    if($trim_url == ""){
       require_once "server/functions.php";
       require_once 'server/autoload.php';
       require_once 'server/connection.php';

    } else {
       require_once "../server/functions.php";
       require_once '../server/autoload.php';
       require_once '../server/connection.php';
    }

    sec_session_start(); 

    if(isset($_SESSION['user'])){
        $logged = unserialize($_SESSION['user']);
    }

    //$user = User::getInstance();
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <div class="container">