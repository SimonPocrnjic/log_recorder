<?php 

require_once "includes/header.php";

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

var_dump(getFileList('users/admin'));

echo "<br>".str_replace(' ', "_", "something sdwddd dwd");

// if(isset($_GET['test'])){
//   print_r($_SERVER['REQUEST_METHOD']);
  
// }

//openlog('CrawlerApp', LOG_CONS | LOG_NDELAY | LOG_PID, LOG_USER);
syslog(LOG_ERR, "User #14 is logged from two different places.");
//closelog();
//define_syslog_variables();
?>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
  <input type="text" name="test">
  <input type="submit" value="Submit">
</form>