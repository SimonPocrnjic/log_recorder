<?php 

function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = FALSE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ".URL('/index.php?err=Could not initiate a safe session (ini_set)')."");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params("0",
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session 
    session_regenerate_id();    // regenerated the session, delete the old one. 
}

function validate($request) {
            $request_array = [];
            $error_check_ok = true;
            foreach($request as $key => $value) {
                if(!empty($value)){
                    if($key == "password") {
                        $new_value = hash("sha512", filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING));
                    } else {
                        $new_value = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
                    }
                    $request_array[$key] = $new_value;
                } else {
                     $error_check_ok = false;
                } 
            }
    
            if($error_check_ok == true) {
                return $request_array;
            } else {
                return "Inputs can't be empty";
            }
        }

        function getFileList($dir, $recurse = FALSE, $depth = FALSE)
        {
          $retval = [];
      
          // add trailing slash if missing
          if(substr($dir, -1) != "/") {
            $dir .= "/";
          }
      
          // open pointer to directory and read list of files
          $d = @dir($dir) or die("getFileList: Failed opening directory {$dir} for reading");
          while(FALSE !== ($entry = $d->read())) {
            // skip hidden files
            if($entry{0} == ".") continue;
            if(is_dir("{$dir}{$entry}")) {
              $retval[] = [
                'name' => "{$dir}{$entry}/",
                'type' => filetype("{$dir}{$entry}"),
                'size' => 0,
                'lastmod' => filemtime("{$dir}{$entry}")
              ];
              if($recurse && is_readable("{$dir}{$entry}/")) {
                if($depth === FALSE) {
                  $retval = array_merge($retval, getFileList("{$dir}{$entry}/", TRUE));
                } elseif($depth > 0) {
                  $retval = array_merge($retval, getFileList("{$dir}{$entry}/", TRUE, $depth-1));
                }
              }
            } elseif(is_readable("{$dir}{$entry}")) {
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