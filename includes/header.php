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
    <?php if(Server\Classes\User::login_check($con)): ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">Dashboard</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav mr-auto">
            <a class="nav-item nav-link" href="/">Home</a>
            <a class="nav-item nav-link" href="/projects">Projects</a>
        </div>
        <form method="POST" class="form-inline my-2 my-lg-0" action="server/authcontroller.php">
            <span>Logged user: <?php echo ucfirst($logged->username()); ?>&nbsp;</span><input class="btn btn-outline-secondary my-2 my-sm-0" type="submit" name="logout" value="Logout">
        </form>
    </div>
    </nav>
    <?php endif; ?>
    <div class="container">