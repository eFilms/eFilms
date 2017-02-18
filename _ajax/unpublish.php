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

$idm = (isset($_GET['idm']) ? $_GET['idm'] : "");

$query = "UPDATE `eFilm_ActiveFilms` SET `isLive` = 0 WHERE `filmNumber` = '".$idm."'";
$results = mysqli_query($localDatabase, $query);
echo "Publish";
