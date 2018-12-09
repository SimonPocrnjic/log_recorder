<?php 
    require_once "functions.php";
    require_once 'autoload.php';
    require_once 'connection.php';

    use Server\Classes\Log as Log;
    
    sec_session_start(); 

    if(isset($_SESSION['user'])){
        $logged = unserialize($_SESSION['user']);
    }

    $output = "";

    if(isset($_POST['export_excel'])) {
        $logs = new Log($logged);

        if($array = $logs->getLog($con)) {
            $output .= 
                '<table class="table" bordered="1">
                    <tr>
                        <th>Message</th>
                        <th>Level</th>
                        <th>Type</th>
                        <th>User ID</th>
                        <th>Project ID</th>
                        <th>Created</th>
                    </tr>
                ';
            foreach($array as $log) {
                $output .= '
                    <tr>
                        <td>'.$log['logmessage'].'</td>
                        <td>'.$log['loglevel'].'</td>
                        <td>'.$log['logtype'].'</td>
                        <td>'.$log['user'].'</td>
                        <td>'.$log['project'].'</td>
                        <td>'.$log['logcreated'].'</td>
                    </tr>
                ';
            }
            $output .= '</table>';
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=log.xls");
            echo $output; 
        }
    }

?>