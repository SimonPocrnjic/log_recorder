<?php

use Server\Classes\User as User;

class Log {
    private $content;
    private $created;
    private $auth;

    public function __construct(User $auth){
        $this->auth = $auth->authorized_user();
    }

    public static function log_save($mysqli, )
}