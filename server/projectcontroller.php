<?php 
    require_once 'autoload.php';

    use Server\Classes\Project;

    $project = new Project();

    if(isset($_REQUEST['newproj'])) {
        $validate = validate($_POST);
        if($validate != false) {
            $title = $validate['title'];
            $desc = $validate['desc'];
            if($project->create($con, $title, $desc, $logged) === true) {
                echo "Successfuly created project ".$logged->username();
            } else {
                echo "The project already exists";
            }
        } else {
            $error_msg = "Login not successful!";
        }
    }