<?php
/*
 * 05/09/2014
 * Updated login form to handle it's own processing.
 * Added input filtering and removed direct user interaction
 * with the database.
 * Upgraded SQL calls to mysqli
 */

if (!isset($_SESSION)) {
    session_start(); 
}

unset($_SESSION["login"]);
unset($_SESSION["uname"]);
unset($_SESSION["unik"]);
unset($_SESSION["efuid"]);

$userName = preg_replace("/[^\w\s\.\-\,_]/","",$_SERVER['PHP_AUTH_USER']);
if (empty($userName) || $userName != $_SERVER['PHP_AUTH_USER']) {
    // illegal characters discovered, or no username provided
    header("Location:index.php");
}

require_once("includes/functions.php");
require_once(directoryAboveWebRoot()."/db_con.php");

$allLogins = mysqli_query($localDatabase,"SELECT `USER_Name`, `USER_Nik`, `ID_C_Users` FROM `eFilm_Config_Users`");
while ($row = mysqli_fetch_array($allLogins)) {
    if ($userName == $row['USER_Name']) {
        $_SESSION["login"] = "true";
        $_SESSION["uname"] = $row['USER_Name']; // $userName
        $_SESSION["unik"] = $row['USER_Nik'];
        $_SESSION["efuid"] = $row['ID_C_Users'];
    }
}
header("Location:index.php");
