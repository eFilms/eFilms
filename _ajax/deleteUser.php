<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//ini_set('display_errors','On');

if (!isset($_SESSION)) { 
    session_start(); 
}
if ($_SESSION["login"] != "true") {
    header("Location:login.php");
    $_SESSION["error"] = "<h1 style='color:red;'>You don't have privileges to see this page.</h1>";
    exit;
}

require_once('/settings.php');
require_once('/includes/functions.php');
require_once(directoryAboveWebRoot().'/db_con.php');

$id = preg_replace("/[^\d]/","",$_POST["id"]);
if (!ctype_digit($id)) {
    // id is not a number
    echo "nan";
    exit();
}
if (empty($id)) {
    echo "bad data";
    exit();
}

$fp = fopen(directoryAboveWebRoot()."/.htpasswd", "r");
if ($fp) {
    while (($line = fgets($fp)) !== false) {
        list($key, $value) = explode(":", trim($line));
        $loginArray[$key] = $value;
    }
    $select = "SELECT `USER_Name` from `eFilm_Config_Users` WHERE `ID_C_Users` = '".$id."'";
    $userList = mysqli_query($localDatabase, $select);
    while($row = mysqli_fetch_array($userList)) {
       unset($loginArray[$row['USER_Name']]);
    }
} else {
   echo "read/write error";
   exit();
}
fclose($fp);
$fp = fopen(directoryAboveWebRoot()."/.htpasswd", "w");
foreach ($loginArray as $key => $value) {
   fwrite($fp, $key.":".$value."\n");
}
fclose($fp);

$delete = "DELETE FROM `eFilm_Config_Users` WHERE `ID_C_Users` = '".$id."'";
if (mysqli_query($localDatabase, $delete)) {
    echo 'user deleted';
} else {
    echo 'fail';
}
