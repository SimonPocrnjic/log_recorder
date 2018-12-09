<?php 

namespace Server\Classes;

use Server\Classes\User as User;
use Server\Classes\Log as Log;

class Project {
    private $id;
    private $title; 
    private $desc;
    private $created;
    private $updated;

    public function __construct($auth) {
        if($auth == null) {
            header('Location: ../');
        }
    }

    public function setProject($id, $title, $desc, $created, $updated) {
        $this->id = $id;
        $this->title = $title;
        $this->desc = $desc;
        $this->created = $created;
        $this->updated = $updated;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDesc() {
        return $this->desc;
    }

    public function getCreated() {
        return $this->created;
    }

    public function getUpdated() {
        return $this->updated;
    }

    public function create($mysqli, $name, $desc, User $user){

        $userid = $user->id();
        $username = $user->username();
        $msg = "User ".$username." created new projects named ".$name;
        if($stmt = $mysqli->prepare('SELECT * FROM projects WHERE title = ? AND user_id = ? LIMIT 1')){
            $stmt->bind_param('si', $name, $userid);
            $stmt->execute();
            $stmt->store_result();
            $stmt->fetch();

            if($stmt->num_rows() != 1) {
                if($proj = $mysqli->prepare('INSERT INTO projects(title, description, user_id) VALUES (?, ?, ?);')){
                    $proj->bind_param('ssi', $name, $desc, $userid);
                    $dirname = str_replace(' ', '_', $name);
                    if(!mkdir("../users/".$username."/".$dirname, 0777, true)) {
                        $success = "1";
                    } else {
                        $proj->execute();
                        if($lastid = $mysqli->prepare("SELECT LAST_INSERT_ID()")){
                            $lastid->execute();
                            $lastid->store_result();
                            $lastid->bind_result($proj_id);
                            $lastid->fetch();
                            $level = Log::SEVERITY_LEVEL['INFO'];
                            Log::saveLog($mysqli, $msg, $level, 'DATABASE INSERT POST DATA', $userid, $proj_id);
                            $lastid->close();
                        }
                        $proj->close();
                        return true;
                    }
                } else {
                    return "2";
                }
            } else {
                return "3";
            }
            $stmt->close();
        } else {
            return "4";
        }
    }

    public function getUserProjs($mysqli, User $user) {
        $success = false;
        $proj_array = [];
        $userid = $user->id();
        if($stmt = $mysqli->prepare('SELECT * FROM projects WHERE user_id = ?')) {
            $stmt->bind_param('i', $userid);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $title, $desc, $userid, $created, $updated);
            if($stmt->num_rows() > 0) {
                while($stmt->fetch()) {
                    $dirname = str_replace(' ', '_',  $title);
                    $dirpath = "../users/".$user->username()."/".$dirname."/";
                    array_push($proj_array, array(
                        'projid' => $id, 
                        'projtitle' => $title, 
                        'projdesc' => $desc, 
                        'projuser' => $userid, 
                        'projcreated' => $created, 
                        'projupdated' => $updated,
                        'projpath' => $dirpath
                    ));
                }
                $success = true;
            }
        }
        if($success == true) {
            return $proj_array;
        } else {
            return false;
        }
    }

    public function delPorject($mysqli, $id, $dir) {
        $success = false;
        if($stmt = $mysqli->prepare('DELETE FROM projects WHERE id = ?')) {
            $stmt->bind_param('i', $id);
            $files = array_diff(scandir($dir), array('.','..')); 
            foreach ($files as $file) { 
                (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
            } 
            if(rmdir($dir)) {
                $stmt->execute();
                $success = true;
            }
        }
        return $success;
    }

    public function getProject($mysqli, $id) {
        $success = false;
        if($stmt = $mysqli->prepare('SELECT * FROM projects WHERE id = ? LIMIT 1')) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($proj_id, $title, $desc, $userid, $created, $updated);
            if($stmt->num_rows() == 1) {
                $stmt->fetch();
                $this->setProject($proj_id, $title, $desc, $userid, $created, $updated);
                $success = true;
            } 
        }

        return $success ;
    }

    public getProjectTitle($mysqli, $id) {
        if($stmt = $mysqli->prepare('SELECT title FROM projects WHERE id = ? LIMIT 1')) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($title);
            if($stmt->num_rows() == 1) {
                $stmt->fetch();
                return $title;
            } else {
                return false;
            } 
        } else {
            return false;
        }
    }

    public function __destruct() {
        
    }    
}