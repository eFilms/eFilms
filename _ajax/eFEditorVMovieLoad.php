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

include_once("/settings.php");

 // header("Cache-Control: no-cache, must-revalidate");
 // header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

$movieid = (isset($_GET['MovieID']) ? $_GET['MovieID'] : "");
$moviefps = (isset($_GET['fps']) ? $_GET['fps'] : "");
$uniqueUTS = time();
$eFServerChoiceURLPrefix=$storeURL;

echo '<script type="text/javascript" src="_js/eFEditorV/eFEditorVMovie.js?version='.$uniqueUTS.'"></script>';

echo "<div id=\"efMovieControllVars\">\n";
echo "<div id=\"efMCVMovieID\">".$_GET['MovieID']."</div>\n";
echo "<div id=\"efMCVMovieFPS\">".$_GET['fps']."</div>\n";
echo "<div id=\"efMCVLoadData\">".$_GET['fps']."</div>\n";
echo "<div id=\"efDelRowActive\">false</div>\n";
echo "<div id=\"efDelRowActiveID\"></div>\n";
$currentDirectory = getcwd();
echo "<div id=\"efPATH\">".$currentDirectory."</div>\n";
echo "</div>\n";
echo "<video autobuffer preload=\"auto\" id=\"videoAktuell\">\n";
echo "<source src=\"".$eFServerChoiceURLPrefix."_media/movies/".$movieid.".m4v\" type=\"video/mp4\"></source>\n";
echo "<source src=\"".$eFServerChoiceURLPrefix."_media/movies_wm/".$movieid.".m4v\" type=\"video/mp4\"></source>\n";
echo "<source src=\"".$eFServerChoiceURLPrefix."_media/movies/".$movieid.".ogg\" type=\"video/ogg\"></source>\n";
echo "<source src=\"".$eFServerChoiceURLPrefix."_media/movies_wm/".$movieid.".ogg\" type=\"video/ogg\"></source>\n";
echo "</video>\n";
echo "<div id=\"videoaktuellprogressbar\" style=\"height: 4px; margin: 0px 10px;\"></div>\n";