<?php
if (!isset($_SESSION)) { 
    session_start(); 
}
if ($_SESSION["login"] != "true") {
    header("Location:login.php");
    $_SESSION["error"] = "<h1 style='color:red;'>You don't have privileges to see this page.</h1>";
    exit;
}

/* 
 * United States Holocaust Memorial Museum
 * All Rights Reserved
 */

$id = $_POST['id'];
$newGroup = $_POST['group'];

if (!empty($id) && !empty($newGroup) && ctype_digit($id)) {
	require_once('settings.php');
	require_once('includes/functions.php');
	require_once(directoryAboveWebRoot().'/db_con.php');
	$update = "UPDATE `eFilm_ReSources_L1` SET `Group`='".$newGroup."' WHERE `ID_R_L1` = '".$id."';";
	$ergebnisGroup = mysqli_query($localDatabase, $update);
}
