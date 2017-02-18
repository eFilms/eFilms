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

$idm = preg_replace("/[^\d]/","",$_GET['idm']);
$anfrage = "SELECT eFilm_Content_Movies.*, eFilm_Config_Users_MovieRights.RIGHTS_Movies FROM eFilm_Content_Movies LEFT JOIN eFilm_Config_Users_MovieRights ON eFilm_Content_Movies.ID_Movies = eFilm_Config_Users_MovieRights.ID_Movies AND eFilm_Config_Users_MovieRights.ID_C_Users = ".$_SESSION["efuid"]." WHERE eFilm_Content_Movies.ID_Movies='".$idm."' ORDER BY eFilm_Content_Movies.FILM_ID ASC;";
$ergebnis = mysqli_query($localDatabase, $anfrage); 
$trefferzahl=mysqli_num_rows($ergebnis);


while ($row = mysqli_fetch_array($ergebnis)) {
	$arringer = array("RIGHTS_Movies" => $row['RIGHTS_Movies'], "UNIKINGER" => $_SESSION["unik"]);
	echo json_encode($arringer);
}
