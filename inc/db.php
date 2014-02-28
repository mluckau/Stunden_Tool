<?php
include ('conf.inc.php');

$DbLocation = 'mysql:dbname='.$datenbank.';host='.$host.'';
$DbUser = $benutzer;
$DbPassword = $passwort;

try
{
  $db = new PDO($DbLocation, $DbUser, $DbPassword);
}
catch (PDOException $e)
{
  echo 'Datenbank-Fehler: ' . $e->getMessage();
  die();
}
?>
