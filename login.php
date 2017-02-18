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

$userName = preg_replace("/[^\w\s\.\-\,_]/","",$_POST['username']);
$password = $_POST['password'];
if (empty($userName) || $userName != $_POST['username']) {
    // illegal characters discovered, or no username provided
    echo "<center><form method='post'><input type='text' name='username' placeholder='Username'><br><input type='password' name='password' placeholder='Password'><br><input type='submit' value='Submit'></form></center>";
    exit();
}

require_once("includes/functions.php");
require_once(directoryAboveWebRoot()."/db_con.php");

$loginValid = false;
$fp = fopen(directoryAboveWebRoot()."/.htpasswd","r");
if ($fp) {
    while (($line = fgets($fp)) !== false) {
      $parts = explode(":",$line);
      if ($parts[0] == $userName && preg_replace('~[\r\n]+~', '', $parts[1]) == crypt($password, base64_encode($password))) {
        $loginValid = true;
        break;
      }
    }
}

if (!$loginValid) {
    header("Location:login.php");
}

$allLogins = mysqli_query($localDatabase,"SELECT `USER_Name`, `USER_Nik`, `ID_C_Users` FROM `eFilm_Config_Users`");
while ($row = mysqli_fetch_array($allLogins)) {
    if ($userName == $row['USER_Name']) {
        $_SESSION["login"] = "true";
        $_SESSION["uname"] = $row['USER_Name']; // $userName
        $_SESSION["unik"] = $row['USER_Nik'];
        $_SESSION["efuid"] = $row['ID_C_Users'];
	break;
    }
}
header("Location:index.php");
