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

$eFResL2ContPopDownSearch = (isset($_GET['eFResL2ContPopDownSearch']) ? $_GET['eFResL2ContPopDownSearch'] : "");
if ($eFResL2ContPopDownSearch != 'Group') {

			$anfrageGroup = "SELECT DISTINCT Fieldcontent FROM eFilm_ReSources_L2 WHERE Fieldname='".$eFResL2ContPopDownSearch."' ORDER BY Fieldcontent ASC;";
			$ergebnisGroup = mysqli_query($localDatabase, $anfrageGroup);
			echo "<table>";
			while($row = mysqli_fetch_array($ergebnisGroup)) {
			echo "<tr><td class='eFTipTabCell'>".$row['Fieldcontent']."</td></tr>";
			}
			echo "</table>";
}
else {

			$anfrageGroup = "SELECT DISTINCT `Group` FROM eFilm_ReSources_L1 WHERE NOT `Group`='' ORDER BY `Group` ASC;";
			$ergebnisGroup = mysqli_query($localDatabase, $anfrageGroup);
			echo "<table>";
			while($row = mysqli_fetch_array($ergebnisGroup)) {
			echo "<tr><td class='eFTipTabCell'>".$row['Group']."</td></tr>";
			}
			echo "</table>";

}
?>
