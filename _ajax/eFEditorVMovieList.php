<?php
if(!isset($_SESSION)) { 
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

$anfrage = "SELECT eFilm_Content_Movies.*, eFilm_Config_Users_MovieRights.RIGHTS_Movies FROM eFilm_Content_Movies LEFT JOIN eFilm_Config_Users_MovieRights ON eFilm_Content_Movies.ID_Movies = eFilm_Config_Users_MovieRights.ID_Movies AND eFilm_Config_Users_MovieRights.ID_C_Users = ".$_SESSION["efuid"]." WHERE eFilm_Content_Movies._eFWEB_EditorV = '1' ORDER BY eFilm_Content_Movies.FILM_ID ASC;";

$ergebnis = mysqli_query($localDatabase, $anfrage); 

while ($row = mysqli_fetch_array($ergebnis)) {
    $eFStatusFarbe = "";

    switch ($row['RIGHTS_Movies']) {
        case "NONE":
            $eFStatusFarbe = "";
            break;
        case "VIEW":
            $eFStatusFarbe = " style=\"color:#2B5DCE\"";
            break;
        case "SELFEDIT":
            $eFStatusFarbe = " style=\"color:#C67A0C\"";
            break;
        case "EDIT":
            $eFStatusFarbe = " style=\"color:#0B7D04\"";
            break;
    }

    if ($row['RIGHTS_Movies'] != "NONE") {
        $selectForFrameRate = "SELECT `fps` from `eFilm_ActiveFilms` WHERE `filmNumber` = '".$row['ID_Movies']."'";
        $fetchedFrameRate = mysqli_query($localDatabase, $selectForFrameRate);
        $fetchedFrameRateArray = mysqli_fetch_array($fetchedFrameRate);
        echo "<tr><td><img src=\"_img/movie.png\" /></td><td class=\"eFMovieSelectC\" name=\"".$fetchedFrameRateArray['fps']."\" data-fps=\"" . $row['_eFWEB_FPS'] . "\" data-format=\"" . $row['STAMMDATEN_Format'] . "\" title=\"" . $row['ID_Movies'] . "\" " . $eFStatusFarbe . "><span title=\"" . $row['STAMMDATEN_Archivsignatur'] . " : " . htmlspecialchars($row['STAMMDATEN_Displaytitel']) . "\">" . $row['FILM_ID'] . "</span></td></tr>";
		}
}
if ($_SESSION["unik"] == 'GK' || $_SESSION["unik"] == 'IZ' || $_SESSION["unik"] == 'ML') {
    echo "<tr><td><img src=\"_img/movie.png\" /></td><td class=\"eFMovieSelectC\" name=\"24\" title=\"00\">Frametest</td></tr>";
}
?>
