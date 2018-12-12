<?php 
  include_once "includes/header.php";
?>

<?php 

use Server\Classes\Log;
use Server\Classes\Project;


//var_dump(getFileList('users/admin/simons_projects'));


//echo "<br>".str_replace(' ', "_", "something sdwddd dwd");


// if(isset($_GET['test'])){
//   print_r($_SERVER['REQUEST_METHOD']);
  
// }

//Log::saveLog($con, "create", 1, "POST DATA", 1, 1);


$logs = new Log($logged);

$code = hash('sha512', 'password');

echo $code;

//define_syslog_variables();
?>



      <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" id="file">
        <input type="submit" name="upload" value="Submit">
      </form>

