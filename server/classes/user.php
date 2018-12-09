<?php 

    namespace Server\Classes;

    class User {
        private $id;
        private $username;
        private $password;
        private $email;
        private $role;
        private $created;
        private $updated;
        private static $instance = NULL;

        static public function getInstance()
        {
            if (self::$instance === NULL)
                self::$instance = new User();
            return self::$instance;
        }

        protected function __construct(){

        }

        public function setUser($id, $username, $email, $role, $created, $updated) {
            $this->id = $id;
            $this->username = $username;
            $this->email = $email;
            $this->role = $role;
            $this->created = $created;
            $this->updated = $updated;
        }

        public function id() {
            return $this->id;
        }

        public function username() {
            return $this->username;
        }

        public function email() {
            return $this->email;
        }

        public function role() {
            return $this->role;
        }

        public function authorizedUser() {
            if($this->role != 1) {
                return false;
            } else {
                return true;
            }
        }


        public function create($mysqli, $username, $email, $password, $role) {
            $sql = "INSERT INTO users(username, password, email, role) VALUES (?,?,?,?)";
            if($stmt = $mysqli->prepare($sql)){
                $stmt->bind_param('sssi', $this->username, $this->password, $this->email, $this->role);
                $stmt->execute();

                return "User was created.";

            } else {
                return $mysqli->connect_error;
            }
        }

        public function getUser($mysqli, $id) {
            if($stmt = $mysqli->prepare("SELECT username FROM users WHERE id = ? LIMIT 1")){
                $stmt->bind_param('i', $id);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($username);
                if($stmt->num_rows == 1) {
                    $stmt->fetch();
                    return $username;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        public function login($mysqli, $username, $password) {
            //$sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
            if($stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ? LIMIT 1")){
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($user_id, $username, $dbpassword, $dbemail, $dbrole, $created, $updated);
                $stmt->fetch();

                if($stmt->num_rows == 1) {
                    if($dbpassword == $password) {
                        $user_browser = $_SERVER['HTTP_USER_AGENT'];
                        $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                        $_SESSION['user_id'] = $user_id;
                        $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);

                        $_SESSION['username'] = $username;
                        $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
                        $this->setUser($user_id, $username, $dbemail, $dbrole, $created, $updated);
                        $array = $this;
                        $serialized = serialize($array);
                        $_SESSION['user'] = $serialized;
                        
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }

        static function login_check($mysqli)
        {
            if (isset($_SESSION['user'])) {
                $logged = unserialize($_SESSION['user']);
                $user_id      = $logged->id();
                $login_string = $_SESSION['login_string'];
                $user_name     = $logged->username();

                // Get the user-agent string of the user.
                $user_browser = $_SERVER['HTTP_USER_AGENT'];

                if ($stmt = $mysqli->prepare("SELECT password
                                            FROM users
                                            WHERE id = ? AND username = ? LIMIT 1")) {
                    // Bind "$user_id" to parameter.
                    $stmt->bind_param('is', $user_id, $user_name);
                    $stmt->execute(); // Execute the prepared query.
                    $stmt->store_result();

                    if ($stmt->num_rows == 1) {
                        // If the user exists get variables from result.
                        $stmt->bind_result($password);
                        $stmt->fetch();
                        $login_check = hash('sha512', $password . $user_browser);

                        if ($login_check == $login_string) {
                            return true;
                        } else {
                            // Not logged in
                            return false;
                        }
                    } else {
                        // Not logged in
                        return false;
                    }
                } else {
                    // Not logged in
                    return false;
                }
            } else {
                // Not logged in
                return false;
            }
        }

        public function logout() {
            $_SESSION = array();
	
            $params = session_get_cookie_params();
            
            setcookie(session_name(),
                    '', time() - 86400, 
                    $params["path"], 
                    $params["domain"], 
                    $params["secure"], 
                    $params["httponly"]);
        
            session_destroy();
        }

        public function __destruct() {
        }

    }