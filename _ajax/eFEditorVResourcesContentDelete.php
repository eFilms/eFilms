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

require_once('../settings.php');
require_once('../includes/functions.php');
require_once(directoryAboveWebRoot().'/db_con.php');

$eFResourcesDelID = (isset($_GET['eFResourcesDelID']) ? $_GET['eFResourcesDelID'] : "");
$anfrage1 = "DELETE FROM eFilm_ReSources_L1 WHERE ID_R_L1='".$eFResourcesDelID."';";
$ergebnis1 = mysqli_query($localDatabase, $anfrage1);
$anfrage2 = "DELETE FROM eFilm_ReSources_L2 WHERE ID_R_L1='".$eFResourcesDelID."';";
$ergebnis2 = mysqli_query($localDatabase, $anfrage2);
$anfrage3 = "DELETE FROM eFilm_ReSources_LinkIndex WHERE ID_R_L1_A='".$eFResourcesDelID."' OR ID_R_L1_B='".$eFResourcesDelID."';";
$ergebnis3 = mysqli_query($localDatabase, $anfrage3);
?>
