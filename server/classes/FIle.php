<?php

use Server\Classes\User as User;
use Server\Classes\Project as Project;
use Server\Classes\Log as Log;

class File {
    private $filename;
    private $fullfilename;
    private $type;
    private $size;
    private $created;
    private $updated;

    public function __construct($auth) {
        if($auth == null) {
            header('Location: ../');
        }
    }

    public function uploadFile($mysqli, $uploadFile, User $auth, Project $proj) {
        $user = $auth->username();
        $project = $proj->getTitle();
        $dirname = str_replace(' ', '_', $project);
        $level = Log::SEVERITY_LEVEL;
        $upload_dir = "../users/".$user."/".$dirname."/";
        $upload_filename =  $uploadFile['name'];
        $error_msg = "";
        $error_type = "";
        $file_limit = 5000000;
        $target_file = $upload_dir . basename($uploadFile["name"]);
        $data = explode(".", $uploadFile['name']);
        $extenstion = (array_key_exists(1, $data))? $data[1] : null;
        $allowed_extens = array('jpg', 'png', 'gif', 'html', 'css', 'js', 'txt');
            
        if(!in_array($extenstion, $allowed_extens)) {
            $error_msg = "User ".$user." tried to upload illegal file ".$upload_filename;
            $error_type = "NOTICE";         
        } else if (file_exists($target_file)) {
            $error_msg = "User ".$user." tried to upload file ".$upload_filename." that already exists";
            $error_type = "NOTICE";
        } else if ($uploadFile['size'] > $file_limit) {
            $error_msg = "User ".$user." tried to upload file ".$upload_filename." that's bigger than the limit";
            $error_type = "NOTICE";
        }
        
        if($error_msg == "" && $error_type == "") {
           if(move_uploaded_file($uploadFile["tmp_name"], $upload_dir.$upload_filename)){
               $msg = "User ".$user." uploaded file ".$upload_filename." to project ".$project;
               Log::saveLog($mysqli, $msg, $level['INFO'], 'FILE UPLOAD', $auth->id(), $proj->getId());
               return true;
           } else {
               Log::saveLog($mysqli, "User ".$user." tried to upload file ".$upload_filename." but it failed", $level['ERROR'], 'FILE UPLOAD', $auth->id(), $proj->getId());
               return false;
           }
        } else {
            Log::saveLog($mysqli, $error_msg, $level[$error_type], 'FILE UPLOAD', $auth->id(), $proj->getId());
            return false;
        }
    }

    public function deleteFile($mysqli, $file, User $auth, Project $proj){
        if($auth->authorizedUser()){
            $user = $auth->getUser($mysqli, $proj->getUserid());
        } else {
            $user = $auth->username();
        }
        $project = $proj->getTitle();
        $dirname = str_replace(' ', '_', $project);
        $level = Log::SEVERITY_LEVEL;
        $dir = "../users/".$user."/".$dirname."/";
        $log_msg = "";

        if(unlink($dir.$file)) {
            $log_msg = "User ".$user." deleted file ".$file;
            Log::saveLog($mysqli, $log_msg, $level['NOTICE'], 'FILE DELETE', $auth->id(), $proj->getId());
            return true;
        } else {
            $log_msg = "User ".$user." tried to delete file ".$file." but it failed";
            Log::saveLog($mysqli, $log_msg, $level['ERROR'], 'FILE DELETE', $auth->id(), $proj->getId());
            return false;
        }
    }

    public function __destruct() {

    }        

}