<?php

    use Server\Classes\Log as Log;
    $getlogs = [];
    $logs = new Log($logged);

    if(isset($_REQUEST['clearlog'])) {
        if($logs->clearLog($con)) {
            echo "Cleared log";
        } else {
            echo "Failed to clear log";
        }
    }


    if(isset($_GET['getlog']) && !empty($_GET['getlog'])){
        if(isset($_GET['level']) && !empty($_GET['level']) && $_GET['getlog'] == 3) {
           if(!$logs->getLog($con, $_GET['getlog'], $_GET['level'])){
                $getlogs = [];
           } else {
                $getlogs = $logs->getLog($con, $_GET['getlog'], $_GET['level']);
           }
        } else {
            if(!$logs->getLog($con, $_GET['getlog'])){
                $getlogs = [];
            } else {
                $getlogs = $logs->getLog($con, $_GET['getlog']);
            }
        }
    } else {
        if($logs->getLog($con)) {
            $getlogs = $logs->getLog($con);
        }
    }

    
?>