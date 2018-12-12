<?php 

    $file = new File($logged);

    if(isset($_REQUEST['upload'])) {
        $empty = false;
        if(isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
            if($file->uploadFile($con, $_FILES['file'], $logged, $project)){
                echo "Success uploading file";
            } else {
                echo "something went wrong";
            }
        } else {
            echo "empty";
        }
    }

    if(isset($_REQUEST['delfile'])) {
        if($file->deleteFile($con, $_POST['filename'], $logged, $project)) {
            echo "Success deleting file";
        } else {
            echo "Something went wrong deleting file";
        } 
    }

