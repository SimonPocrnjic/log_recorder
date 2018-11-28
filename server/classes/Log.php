<?php

use Server\Classes\User as User;
use Server\Classes\Project as Project;

class Log {
    private $content;
    private $created;
    private $admin = false;

    public function __construct(User $auth){
        $this->admin = $auth->authorized_user();
    }

    public static function log_save($mysqli, $user_id, $project_id, $msg, $type, $info) {
        if($)
    }
}