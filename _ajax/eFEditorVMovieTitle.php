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

$idcusers = (isset($_GET['idcusers']) ? $_GET['idcusers'] : "");
$idm = (isset($_GET['idm']) ? $_GET['idm'] : "");

$anfrage = "SELECT eFilm_Content_Movies.*, eFilm_Config_Users_MovieRights.RIGHTS_Movies FROM eFilm_Content_Movies LEFT JOIN eFilm_Config_Users_MovieRights ON eFilm_Content_Movies.ID_Movies = eFilm_Config_Users_MovieRights.ID_Movies AND eFilm_Config_Users_MovieRights.ID_C_Users = ".$_SESSION["efuid"]." WHERE eFilm_Content_Movies.ID_Movies='".$idm."' ORDER BY eFilm_Content_Movies.FILM_ID ASC;";
//$anfrage = "SELECT * FROM eFilm_Content_Movies WHERE _eFWEB_EditorV='1' ORDER BY FILM_ID ASC;";
$ergebnis = mysqli_query($localDatabase, $anfrage); 
$trefferzahl=mysqli_num_rows($ergebnis);

$query = "SELECT `isLive` FROM `eFilm_ActiveFilms` WHERE `filmNumber` = '".$idm."'";
$results = mysqli_query($localDatabase, $query);
while ($row = mysqli_fetch_array($results)) {
    $isLive = $row['isLive'];
}
if ($isLive == 0) {
    $isLive = 'false';
    $publishButtonTitle = 'Publish';
} else {
    $isLive = 'true';
    $publishButtonTitle = 'Unpublish';
}

while ($row = mysqli_fetch_array($ergebnis)) {
echo "<div id='eFMovieMovieID' data-ur='".$row['RIGHTS_Movies']."'>".$row['FILM_ID']."</div>";

	switch ($row['RIGHTS_Movies']) {
		case "NONE":
			echo "";
		break;
		
		case "VIEW":
			echo "";
		break;
		
		case "SELFEDIT":
			echo "<div id='eFMovieMovieIDopenAnotSelect'>+</div>";
                                                      echo "<script>var isLive = ".$isLive."; var currentFilmID = ".$idm."; document.getElementById('eFPublish').innerHTML = '".$publishButtonTitle."';</script>";
		break;
		
		case "EDIT":
			echo "<div id='eFMovieMovieIDopenAnotSelect'>+</div>";
                                                      echo "<script>var isLive = ".$isLive."; var currentFilmID = ".$idm."; document.getElementById('eFPublish').innerHTML = '".$publishButtonTitle."';</script>";
		break;
	
	}
}
?>
