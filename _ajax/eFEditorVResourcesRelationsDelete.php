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

require_once('settings.php');
require_once('includes/functions.php');
require_once(directoryAboveWebRoot().'/db_con.php');

$eFRelDelId = (isset($_POST['eFRelDelId']) ? $_POST['eFRelDelId'] : "");

$anfrage_RELD = "DELETE FROM eFilm_ReSources_RelationIndex WHERE ID_R_RelationIndex='".$eFRelDelId."';";
$ergebnis_RELD = mysqli_query($localDatabase, $anfrage_RELD);
?>
