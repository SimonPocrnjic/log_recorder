<?php 

    require_once __DIR__.'/../server/functions.php';
    require_once __DIR__.'/../server/autoload.php';
    require_once __DIR__.'/../server/connection.php';

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
    <a class="navbar-brand" href="<?php echo URL ?>">Log Control</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav mr-auto">
            <a class="nav-item nav-link" href="<?php echo URL ?>">Home</a>
            <a class="nav-item nav-link" href="<?php echo URL."projects" ?>">Projects</a>
            <?php if($logged->authorizedUser()): ?>
            <a class="nav-item nav-link" href="<?php echo URL."users.php" ?>">Users</a>
            <?php endif; ?>
        </div>
        <form method="POST" class="form-inline my-2 my-lg-0" action="<?php echo URL."server/authcontroller.php" ?>">
            <span>Logged user: <?php echo ucfirst($logged->username()); ?>&nbsp;</span><input class="btn btn-outline-secondary my-2 my-sm-0" type="submit" name="logout" value="Logout">
        </form>
    </div>
    </nav>
    <?php endif; ?>
    <div class="container mt-3">