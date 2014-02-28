<?php
//ob_start (); 
//session_start ();
//
//session_unset (); 
//session_destroy ();
//
//header ("Location: ../index.php?logout=true"); 
//ob_end_flush (); 

$logout = new user();
$logout->logout();

?>
