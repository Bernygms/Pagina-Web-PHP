 <?php
session_start();
  unset($_SESSION["user"]); 
  session_destroy();
  echo '<SCRIPT LANGUAGE="javascript">location.href = "login.php";</SCRIPT>';
  exit;

?> 