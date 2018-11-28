<?php

use Server\Classes\User as User;
use Server\Classes\Project as Project;

class Log {
    private $content;
    private $created;
    private $admin = false;
    const SEVERITY_LEVEL = array(
        
    );

    }]

    public function __construct(User $auth){
        $this->admin = $auth->authorized_user();
    }

    public static function log_save($mysqli, $msg, $type, $info, $user_id, $project_id) {
        if($stmt = $mysqli->prepare('INSERT INTO logs(message, type, info, user_id, project_id) VALUES (?,?,?,?,?)')){
            $stmt->bind_param(ss)
        }
    }
}