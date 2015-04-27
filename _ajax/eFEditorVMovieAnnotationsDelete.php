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

# test.php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors','On');

$DELID = (isset($_GET['DELID']) ? $_GET['DELID'] : "");
$anfrage_DEL = "DELETE FROM eFilm_Content_Movies_Annotations WHERE ID_Annotations='".$DELID."';";
$ergebnis_DEL = mysqli_query($localDatabase, $anfrage_DEL); 
?>