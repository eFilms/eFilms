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

$ID_R_L1_A = (isset($_POST['ID_R_L1_A']) ? $_POST['ID_R_L1_A'] : "");
$ID_R_L1_B = (isset($_POST['ID_R_L1_B']) ? $_POST['ID_R_L1_B'] : "");
$RelationType = (isset($_POST['RelationType']) ? $_POST['RelationType'] : "");
$RelationRemark = (isset($_POST['RelationRemark']) ? $_POST['RelationRemark'] : "");

$anfrage_RELN = "INSERT INTO eFilm_ReSources_RelationIndex (`RelationType`, `RelationRemark`, `ID_R_L1_A`, `ID_R_L1_B`) VALUES ('".mysqli_real_escape_string($localDatabase, utf8_decode($RelationType))."', '".mysqli_real_escape_string($localDatabase, utf8_decode($RelationRemark))."', '".mysqli_real_escape_string($localDatabase, utf8_decode($ID_R_L1_A))."', '".mysqli_real_escape_string($localDatabase, utf8_decode($ID_R_L1_B))."');";
$ergebnis_RELN = mysqli_query($localDatabase, $anfrage_RELN);
?>
