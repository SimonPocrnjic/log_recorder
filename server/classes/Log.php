<?php

namespace Server\Classes;

class Log
{
    private $content;
    private $created;
    const SEVERITY_LEVEL = array(
        "EMERG" => 'Emergency',
        "ALERT" => 'Alert',
        "CRIT" => 'Critical',
        "ERROR" => 'Error',
        "WARN" => 'Warning',
        "NOTICE" => 'Notice',
        "INFO" => 'Informational',
        "DEBUG" => 'Debug'
    );

    public function __construct($auth)
    {
        if ($auth == null || $auth->role() == 0) {
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }

    public static function saveLog($mysqli, $msg, $level, $type, $user, $proj)
    {
        if ($log = $mysqli->prepare('INSERT INTO logs(message, level, type, user_id, project_id) VALUES (?,?,?,?,?);')) {
            $log->bind_param("sssss", $msg, $level, $type, $user, $proj);
            $log->execute();
            $log->close();
            return true;
        } else {
            return false;
        }
    }

    public function getLog($mysqli, $getby = null, $level = null)
    {
        $sql = "SELECT message, level, type, user_id, project_id, created_at FROM logs";
        $array = [];
        switch ($getby) {
            case 1:
                $sql.= " WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 HOUR) ORDER BY id DESC";
                break;
            case 2:
                $sql.= " WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY id DESC";
                break;
            case 3:
                $sql.= " WHERE level = ? ORDER BY id DESC";
                break;
            default:
                $sql.= " ORDER BY id DESC";
        }

        if ($log = $mysqli->prepare($sql)) {
            if ($getby == 3) {
                $log->bind_param("s", $level);
            }

            $log->execute();
            $log->store_result();
            $log->bind_result($msg, $level, $type, $user, $proj, $created);
            if ($log->num_rows() > 0) {
                while ($log->fetch()) {
                    array_push($array, array(
                        'logmessage' => $msg,
                        'loglevel' => $level,
                        'logtype' => $type,
                        'user' => $user,
                        'project' => $proj,
                        'logcreated' => $created
                    ));
                }
                $log->close();
                return $array;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function clearLog($mysqli)
    {
        if ($stmt = $mysqli->prepare('TRUNCATE TABLE logs')) {
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function __destruct()
    {
    }
}
