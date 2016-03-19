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

date_default_timezone_set('GMT');

$valid_characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_";

function get_random_string($valid_chars, $length)
{
    // start with an empty random string
    $random_string = "";

    // count the number of chars in the valid chars string so we know how many choices we have
    $num_valid_chars = strlen($valid_chars);

    // repeat the steps until we've created a string of the right length
    for ($i = 0; $i < $length; $i++)
    {
        // pick a random number from 1 up to the number of valid chars
        $random_pick = mt_rand(1, $num_valid_chars);

        // take the random character out of the string of valid chars
        // subtract 1 from $random_pick because strings are indexed starting at 0, and we started picking at 1
        $random_char = $valid_chars[$random_pick-1];

        // add the randomly-chosen char onto the end of our string so far
        $random_string .= $random_char;
    }

    // return our finished random string
    return $random_string;
}

require_once('settings.php');
require_once('includes/functions.php');
require_once(directoryAboveWebRoot().'/db_con.php');

$name = preg_replace("/[^\w\s\.\-\,_]/","",$_POST["name"]);
$nickname = preg_replace("/[^\w\s\.\-\,_]/","",$_POST["nickname"]);
if (isemail($_POST["email"])) {
    $email = $_POST["email"];
}
if (in_array($_POST["configRights"],array("EDIT","NONE"))) {
    $configRights = $_POST["configRights"];
}
if (in_array($_POST["resourceRights"],array("EDIT","NONE"))) {
    $resourceRights = $_POST["resourceRights"];
}

if (empty($name) || empty($nickname) || empty($email) || empty($configRights) || empty($resourceRights)) {
    echo "bad data";
    exit();
}

$select = "SELECT * from `eFilm_Config_Users` WHERE `USER_Name` = '".$name."'"; // USER_Name needs to be unique
$userList = mysqli_query($localDatabase, $select);
if ($row = mysqli_fetch_array($userList)) {
    echo "user exists";
    // This user exists, bail out so we don't get duplicates
    exit();
}

// We have all of our data and we don't have this person in the list yet, add them
$insert = "INSERT INTO `eFilm_Config_Users` (`_FM_CREATE`,`_FM_CHANGE`,`_FM_DATETIME_CREATE`,`_FM_DATETIME_CHANGE`,`USER_Name`,`USER_Nik`,`USER_Rights`,`USER_Pass`,`RIGHTS_Config`,`RIGHTS_Resources`,`RIGHTS_Publish`,`email`) VALUES ('Admin','Admin','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."','".$name."','".$nickname."','','','".$configRights."','".$resourceRights."','NONE','".$email."')";
mysqli_query($localDatabase, $insert);
echo mysqli_insert_id($localDatabase);
$newPassword = get_random_string($valid_characters, 16);
$fp = fopen(directoryAboveWebRoot()."/.htpasswd", "a");
fwrite($fp, $name.":".crypt($newPassword, base64_encode($newPassword))."\n");
fclose($fp);
