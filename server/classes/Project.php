<?php 

namespace Server\Classes;

use Server\Classes\User;

class Project {
    private $id;
    private $title; 
    private $desc;
    private $created;
    private $updated;

    public function __construct() {

    }

    public function setProject($id, $title, $desc, $created, $updated) {
        $this->id = $id;
        $this->title = $title;
        $this->desc = $desc;
        $this->created = $created;
        $this->updated = $update;
    }

    public function create($mysqli, $name, $desc, User $user){

        $userid = $user->id();
        $username = $user->username();
        if($stmt = $mysqli->prepare('SELECT * FROM projects WHERE title = ? AND user_id = ? LIMIT 1')){
            $stmt->bind_param('si', $name, $userid);
            $stmt->execute();
            $stmt->store_result();
            $stmt->fetch();

            if($stmt->num_rows() != 1) {
                if($proj = $mysqli->prepare('INSERT INTO projects(title, description, user_id) VALUES (?, ?, ?)')){
                    $proj->bind_param('ssi', $name, $desc, $userid);
                    $dirname = str_replace(' ', '_', $name);
                    if(!mkdir("../users/".$username."/".$dirname, 0777, true)) {
                        $success = "1";
                    } else {
                        $proj->execute();
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
                    array_push($proj_array, array(
                        'projid' => $id, 
                        'projtitle' => $title, 
                        'projdesc' => $desc, 
                        'projuser' => $userid, 
                        'projcreated' => $created, 
                        'projupdated' => $updated));
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

    public function getProj($mysqli, $id) {
        $success = false;
        $proj = [];
        if($stmt = $mysqli->prepare('SELECT * FROM projects WHERE id = ? LIMIT 1')) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $title, $desc, $userid, $created, $updated);
            if($stmt->num_rows() == 1) {
                $this->setProject($id, $title, $desc, $created, $updated);
                $success = true;
            }
        }
        return $success;
    }
}