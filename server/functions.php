<?php

function sec_session_start()
{
    $session_name = 'sec_session_id';
    $secure = false;
    $httponly = true;
    if (ini_set('session.use_only_cookies', 1) === false) {
        header("Location: ".URL('/index.php?err=Could not initiate a safe session (ini_set)')."");
        exit();
    }
    $cookieParams = session_get_cookie_params();

    session_set_cookie_params(
        "0",
        $cookieParams["path"],
        $cookieParams["domain"],
        $secure,
        $httponly
    );

    session_name($session_name);
    session_start();
    session_regenerate_id();
}

function validate($request){
    $request_array = [];
    $error_check_ok = true;
    foreach ($request as $key => $value) {
        if (!empty($value)) {
            if ($key == "password") {
                $new_value = hash("sha512", filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING));
            } elseif ($key == "email") {
                $new_value = filter_input(INPUT_POST, $key, FILTER_SANITIZE_EMAIL);
            } else {
                $new_value = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
            }
            $request_array[$key] = trim($new_value);
        } else {
            $error_check_ok = false;
        }
    }
    
    if ($error_check_ok == true) {
        return $request_array;
    } else {
        return false;
    }
}

function getFileList($dir, $recurse = false, $depth = fals{
     $retval = [];
      
     if (substr($dir, -1) != "/") {
         $dir .= "/";
     }
      
     $d = @dir($dir) or die("getFileList: Failed opening directory {$dir} for reading");
     while (false !== ($entry = $d->read())) {
         // skip hidden files
         if ($entry{0} == ".") {
             continue;
         }
         if (is_dir("{$dir}{$entry}")) {
             $retval[] = [
                'name' => "{$dir}{$entry}/",
                'type' => filetype("{$dir}{$entry}"),
                'size' => 0,
                'lastmod' => filemtime("{$dir}{$entry}")
              ];
             if ($recurse && is_readable("{$dir}{$entry}/")) {
                 if ($depth === false) {
                     $retval = array_merge($retval, getFileList("{$dir}{$entry}/", true));
                 } elseif ($depth > 0) {
                     $retval = array_merge($retval, getFileList("{$dir}{$entry}/", true, $depth-1));
                 }
             }
         } elseif (is_readable("{$dir}{$entry}")) {
             $filesize_mb = filesize("{$dir}{$entry}")/1000000;
             $retval[] = [
                'name' => "{$dir}{$entry}",
                'type' => mime_content_type("{$dir}{$entry}"),
                'size' => filesize("{$dir}{$entry}"),
                'lastmod' => filemtime("{$dir}{$entry}")
              ];
         }
     }
     $d->close();
      
     return $retval;
 }
