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

require_once('/settings.php');
require_once('/includes/functions.php');
require_once(directoryAboveWebRoot().'/db_con.php');

$id = preg_replace("/[^\d]/","",$_POST["id"]);
if (!ctype_digit($id)) {
    echo "nan";
    exit();
}
$name = preg_replace("/[^\w\s\.\-\,_]/","",$_POST["name"]);
$nickname = preg_replace("/[^\w\s\.\-\,_]/","",$_POST["nickname"]);
if (isemail($_POST["email"])) {
    $email = $_POST["email"];
} else {
    echo "bad data";
    exit();
}

if (empty($name) || empty($nickname) || empty($email)) {
    echo "bad data";
    exit();
}

$select = "UPDATE `eFilm_Config_Users` SET `USER_Name` = '".$name."', `USER_Nik` = '".$nickname."', `email` = '".$email."', `_FM_DATETIME_CHANGE` = '".date("Y-m-d H:i:s")."', `USER_Pass` = '' WHERE `ID_C_Users` = '".$id."'"; // Always reset the database password field to nothing
if (!mysqli_query($localDatabase, $select)) {
    echo "could not update";
    exit();
} else {
    if ($_SESSION["unik"] != $nickname) {
        $_SESSION["unik"] = $nickname;
    }
    if ( $_SESSION["uname"] != $name) {
         $_SESSION["uname"] = $name;
    }
    echo "success";
    exit();
}
