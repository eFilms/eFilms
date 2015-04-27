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

//# test.php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//ini_set('display_errors','On');
$eFGeoLat = (isset($_GET['eFGeoLat']) ? $_GET['eFGeoLat'] : "");
$eFGeoLon = (isset($_GET['eFGeoLon']) ? $_GET['eFGeoLon'] : "");
header("content-type: application/json");
echo @file_get_contents("http://maps.google.com/maps/api/geocode/json?address=".$eFGeoLat.",".$eFGeoLon."&sensor=false");
?>
