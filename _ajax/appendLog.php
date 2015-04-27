<?php
if (!isset($_SESSION)) { 
    session_start(); 
}
if ($_SESSION["login"] != "true") {
  header("Location:login.php");
  $_SESSION["error"] = "<h1 style='color:red;'>You don't have privileges to see this page.</h1>";
  exit;
}

/**
 * We are going to take the current film ID (filmNumber in the ActiveFilms table) and append
 * a base64 encoded version of the comment string. Encoding the string helps eliminate the
 * majority of issues with unexpected characters going into our SQL Statement.
 * 
 * This feature shouldn't be available to anyone without a login to the admin section and should
 * be separate from the public site if possible.
 */

$currentFilmID = (isset($_POST['film']) ? $_POST['film'] : exit());
$comments = (isset($_POST['comments']) ? $_POST['comments'] : exit());

// We are expecting an integer value, so remove everything that isn't
$currentFilmID = preg_replace("/[^\d]/","",$currentFilmID);

if ($currentFilmID != $_POST['film']) {
    // There were characters replaced, this isn't our expected behavior
    // so let's bail out just in case
    exit();
}

require_once('/settings.php');
require_once('/includes/functions.php');
require_once(directoryAboveWebRoot().'/db_con.php');

// Get and unencode the current log for this film
$query = "SELECT `researchLog` FROM `eFilm_ActiveFilms` WHERE `filmNumber` = '".$currentFilmID."'";
$results = mysqli_query($localDatabase, $query);
$log = '';
while ($row = mysqli_fetch_array($results)) {
    $log = base64_decode($row['researchLog']);
}

// Add our new entry to the log string
$log .= "<p><b>".$_SESSION["uname"]."</b> &nbsp; (".date("F d, Y").")<br>".$comments."</p>";

// Update the log record in the database
$query = "UPDATE `eFilm_ActiveFilms` SET `researchLog` = '".base64_encode($log)."' WHERE `filmNumber` = '".$currentFilmID."'";
mysqli_query($localDatabase, $query);

// Return the new comment so it can be added into the current log display
echo "<p><b>".$_SESSION["uname"]."</b> &nbsp; (".date("F d, Y").")<br>".$comments."</p>";