<?php
if(!isset($_SESSION)) 
{ 
session_start(); 
} 
if ($_SESSION["login"] != "true"){
  header("Location:login.php");
  $_SESSION["error"] = "<h1 style='color:red;'>You don't have privileges to see this page.</h1>";
  exit;
}

require_once('/settings.php');
require_once('/includes/functions.php');
require_once(directoryAboveWebRoot().'/db_con.php');

$anfrage = "UPDATE eFilm_ReSources_L2 SET Fieldcontent = '".utf8_decode($_POST['value'])."' WHERE ID_R_L2='".mysqli_real_escape_string($localDatabase, $_POST['id'])."';";
$ergebnis = mysqli_query($localDatabase, $anfrage);
?>