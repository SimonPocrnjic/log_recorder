<?php 

    class User {
        protected $id, $username, $email, $role;

        function__construct($id, $username, $email, $role) {
            $this->$id = $id;
            $this->$username = $username;
            $this->$email = $email;
            $this->$role = $role;
        }

        public function create($mysqli) {
            
        }
    }