<?php
ini_set('post_max_size', '1024M');
ini_set('upload_max_filesize', '1024M');
set_time_limit(60*10); // 10 minutes max upload time

if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION["login"] != "true") {
    header("Location:login.php");
    $_SESSION["error"] = "<h1 style='color:red;'>You don't have privileges to see this page.</h1>";
    exit;
}

require 'settings.php';
require 'includes/functions.php';
include '/usr/local/aws-php-sdk/aws-autoloader.php';

use App\Http\Controllers\Controller;
use Aws\Common\Aws;
use Aws\S3\S3Client;
use \File;

$amazonServices = Aws::factory('/data/sites/ee-efilms/s3-credentials/aws-efilms-credentials.php');
$s3 = $amazonServices->get('s3');
$parsePath = parse_url($storeURL);
$awsBucket = $parsePath['host'];

/**
 * Original eFilms Uploader Script
 */
error_reporting(E_ALL);
ini_set('display_errors', 'On');

header('Content-Type: application/json');
/*     * *************** Bearbeitung des Files *************************** */
//Array für Ergebnis der Operation und JSON Ausgabe für jQuery
$result = array();
//var_dump($_POST); var_dump($_FILES);
//$_FILES Array auslesen
foreach ($_FILES as $file) {
    // Make sure all of our folders are in place
    $uploadFolder = "/_uploads";
    if (!file_exists($uploadFolder)) {
        mkdir($uploadFolder);
        chmod($uploadFolder, 0777);
    }
    if (!file_exists($uploadFolder . "/imagesLarge")) {
        mkdir($uploadFolder . "/imagesLarge");
        chmod($uploadFolder . "/imagesLarge", 0777);
    }
    if (!file_exists($uploadFolder . "/imagesSmall")) {
        mkdir($uploadFolder . "/imagesSmall");
        chmod($uploadFolder . "/imagesSmall", 0777);
    }

    $n = $file['name'];
    $s = $file['size'];
    if (!$n)
        continue;        
    //BAsic Metadaten aus dem File Auslesen
    $imagemetadata = getimagesize($file['tmp_name']);  //$imagemetadata = getimagesize($_FILES['hugotest']['tmp_name']);
    //mimetype
    $finfo = new finfo(FILEINFO_MIME);
    $type = $finfo->file($file['tmp_name']);
    $mime = substr($type, 0, strpos($type, ';'));

    $result['mime'] = $mime;
    if ($result['mime'] == 'image/png' || $result['mime'] == 'image/jpeg') {
        //Image Files verarbeiten
        switch ($result['mime']) {
            case 'image/png':
                $result['fileextension'] = '.png';
                $img = imagecreatefrompng($file['tmp_name']);  //$img = imagecreatefrompng($_FILES['hugotest']['tmp_name']);
                break;
            case 'image/jpeg':
                $result['fileextension'] = '.jpg';
                $img = imagecreatefromjpeg($file['tmp_name']);  //$img = imagecreatefromjpeg($_FILES['hugotest']['tmp_name']);
                break;
        }
        $result['width'] = $imagemetadata[0];
        $result['height'] = $imagemetadata[1];
        $result['path'] = $uploadFolder.'/';
    } else {
        $result['result'] = 'fail';
        echo json_encode($result);
        continue;
    }

    $target_path = $uploadFolder . '/' . basename($file['name']); //$target_path = $target_path . basename( $_FILES['hugotest']['name']);
    $target_path_image = $uploadFolder . "/imagesLarge/";

    if (move_uploaded_file($file['tmp_name'], $target_path)) {  //if(move_uploaded_file($_FILES['hugotest']['tmp_name'], $target_path)) {
        if ($result['mime'] != 'application/pdf') {
            $shellresult = shell_exec("/usr/local/bin/convert ".$target_path." -resize 640X640 ".$target_path_image.$file['name']." 2>&1");

            // Upload large resize to Amazon
            $awsLocation = '/_media/movies_wm/_img/PosterFrames/'.$file['name'];
            try {
                $resource = fopen($target_path_image.$file['name'], 'r');
                $s3->upload($awsBucket, $awsLocation, $resource, 'public-read');
                $result['path'] = "http://".$awsBucket.$awsLocation;
            } catch (S3Exception $e) {
                $result['result'] = 'amazon fail';
            }
            // Unlink the two temp resize files
            unlink($target_path_image.$file['name']);
        }
    } else {
        $result['result'] = 'fail';
    }

    unlink($target_path);
    if (isset($result['result'])) {
        echo json_encode($result);
    } else {
        echo "";
    }
}
    
