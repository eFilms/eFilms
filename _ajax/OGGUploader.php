<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

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

//Array für Ergebnis der Operation und JSON Ausgabe für jQuery
$result = array();
//$_FILES Array auslesen
$content = "";
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

    if (substr($file['name'], -4) != '.ogg') {
        $content .=  'fail - bad mime';
        continue;
    }

    $target_path = $uploadFolder.'/'.$file['name']; //$target_path = $target_path . basename( $_FILES['hugotest']['name']);

    if (move_uploaded_file($file['tmp_name'], $target_path)) {  //if(move_uploaded_file($_FILES['hugotest']['tmp_name'], $target_path)) {
        // Upload large resize to Amazon
        $awsLocation = '/_media/movies_wm/'.$file['name'];
        try {
            $resource = fopen($target_path, 'r');
            $s3->upload($awsBucket, $awsLocation, $resource, 'public-read');
//            $result['path'] = "http://".$awsBucket.$awsLocation;
        } catch (S3Exception $e) {
            $content .=  'amazon fail: '.$e;
        }
    } else {
        $content .=  'fail - no copy';
    }
    unlink($target_path);
}
header('Content-Type: application/json');
echo $content;
