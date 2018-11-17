<?php 

require "config.php";

try {
    $con = new mysqli(SERVER, USER, PASSWORD, DATABASE);
    
    if($con->connect_errno){
        throw new Exception($con->connect_error);
    } else {
        print "It works!";
    }

} catch (Exception $e) {
    print_r($e);
    die();
}