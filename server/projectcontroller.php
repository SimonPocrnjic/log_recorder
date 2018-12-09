<?php 

    use Server\Classes\Project;

    $project = new Project($logged);

    $error_msg = "";

    if(isset($_REQUEST['newproj'])) {
        $validate = validate($_POST);
        if($validate) {
            $title = $validate['title'];
            $desc = $validate['desc'];
            if($project->create($con, $title, $desc, $logged) === true) {
                echo "Successfuly created project";
            } else {
                echo "The project already exists";
            }
        } else {
            $error_msg = "Login not successful!";
        }
    }

    if(isset($_REQUEST['delproj'])) {
        
        $validate = validate($_POST);
        if($validate){
            $title = $validate['title'];
            $id = $validate['id'];
            $dirname = str_replace(' ', '_', $title);
            $user = $logged->username();
            $path = "../users/".$user."/".$dirname;
            if(!$project->delPorject($con, $id, $path)){
                $error_msg = "Could not delete projects";
            }
        }
    }