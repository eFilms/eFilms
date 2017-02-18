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

$uniqueUTS = time();

echo '<script type="text/javascript" src="_js/eFEditorV/eFEditorVResourcesInMovies_Movie.js?version='.$uniqueUTS.'"></script>';
echo '<link id="resourcesconfigstylesheet" rel="stylesheet" type="text/css" href="_css/eFEditorVResourcesInMovies_Movie.css" media="screen" />';
?>
<div id='eFRelMovieBGTop'><div id="eFMovieRelATitle"></div><div id="eFMovieRelBSelect">
<select name="eFRelMovieBSelect" id="eFRelMovieBSelect">
<option></option>
<?php

$anfrage = "SELECT * FROM eFilm_Content_Movies WHERE _eFWEB_EditorV='1';";
$ergebnis = mysqli_query($localDatabase, $anfrage); 
$trefferzahl=mysqli_num_rows($ergebnis);

while ($row = mysqli_fetch_array($ergebnis)) {
	echo "<option data-fps=".$row['_eFWEB_FPS']." data-id=".$row['ID_Movies'].">".$row['FILM_ID']."</option>";
}
?>
</select>
</div></div>
<div id='eFRelMovieBGMovieA'></div>
<div id='eFRelMovieBGM2'></div>
<div id='eFRelMovieBGMovieB'></div>
<div id='eFRelMovieBGM3'></div>
<div id='eFRelMovieBGBottom'></div>
