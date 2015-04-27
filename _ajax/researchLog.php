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

$idm = (isset($_GET['idm']) ? $_GET['idm'] : "");

$query = "SELECT `researchLog` FROM `eFilm_ActiveFilms` WHERE `filmNumber` = '".$idm."'";
$results = mysqli_query($localDatabase, $query);
$log = '';
while ($row = mysqli_fetch_array($results)) {
    $log = base64_decode($row['researchLog']);
}
echo "<div id=\"researchLogHistory\" style=\"position: relative; margin: 10px 20px; overflow: auto;\">";
echo "<center><b>Notes</b></center>";
echo $log;
echo "</div>";
echo "<div style=\"position: absolute; left: 20px; bottom: 20px; right: 20px;\">";
echo "<form id=\"researchNotes\" action=\"\" method=\"post\">";
echo "<input name=\"film\" type=\"hidden\" value=\"".$idm."\">";
echo "<textarea id=\"comments\" name=\"comments\" style=\"width: 98%; height: 60px; resize: none;\"></textarea><br>";
echo "<input type=\"submit\" value=\"Save\">";
echo "</div>";
echo "<div id=\"logClose\">X</div>";