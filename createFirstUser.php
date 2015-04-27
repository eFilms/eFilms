<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 'On');

include_once('includes/functions.php');

$adminName = preg_replace("/[^\w\s\.\-\,_]/","",$_POST['adminName']);
$adminNickname = preg_replace("/[^\w\s\.\-\,_]/","",$_POST['adminNickname']);
$adminEmail = $_POST['adminEmail'];
$adminPassword = preg_replace("/[^\w\s\.\-\,_]/","",$_POST['adminPassword']);

if (!isemail($adminEmail)) {
	// bad email, try again
	$results['complete'] = 'no';
	$results['reason'] = 'email does not validate';
	echo json_encode($results);
	exit();
}

if (empty($adminName) || empty($adminNickname) || empty($adminPassword)) {
	// bad data, try again
	$results['complete'] = 'no';
	$results['reason'] = 'you must fill in all of the fields';
	echo json_encode($results);
	exit();
}

include_once(directoryAboveWebRoot().'/db_con.php');

$select = "SELECT * from `eFilm_Config_Users` WHERE `USER_Name` = '".$adminName."'";
$userList = mysqli_query($localDatabase, $select);
if ($row = mysqli_fetch_array($userList)) {
	// user exists... weird, try again
	$results['complete'] = 'no';
	$results['reason'] = 'somehow this user name already exists';
	echo json_encode($results);
	exit();
}

date_default_timezone_set('GMT');
$insert = "INSERT INTO `eFilm_Config_Users` (`_FM_CREATE`, `_FM_CHANGE`, `_FM_DATETIME_CREATE`, `_FM_DATETIME_CHANGE`, `USER_Name`, `USER_Nik`, `USER_Rights`, `USER_Pass`, `RIGHTS_Config`, `RIGHTS_Resources`, `RIGHTS_Publish`, `email`) VALUES ('Admin', 'Admin', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."', '".$adminName."', '".$adminNickname."', '', '', 'EDIT', 'EDIT', 'EDIT', '".$adminEmail."')";
mysqli_query($localDatabase, $insert);
mysqli_close($localDatabase);

$fp = fopen(directoryAboveWebRoot()."/.htpasswd", "a");
fwrite($fp, $adminName.":".crypt($adminPassword, base64_encode($adminPassword))."\n");
fclose($fp);

// don't overwrite this, only prepend it
$fp = @file_get_contents(".htaccess");
file_put_contents(".htaccess", "AuthUserFile ".directoryAboveWebRoot()."/.htpasswd"."\nAuthType Basic\nAuthName \"Restricted Area\"\nRequire valid-user\n\n".$fp);

$results['complete'] = 'yes';
$results['setting'] = 'admin';
$results['reason'] = 'You will now login with your Name and Password';

echo json_encode($results);

unlink('createFirstUser.php');
