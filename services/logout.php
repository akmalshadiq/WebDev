<?php
session_start();
session_unset(); 
session_destroy(); 
header("Location: https://memskolomee.rf.gd/logoutmsg.php");
exit();
?>
