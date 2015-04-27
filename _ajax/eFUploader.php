<?php

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

require '/usr/local/aws-php-sdk/aws-autoloader.php';

use App\Http\Controllers\Controller;
use Aws\Common\Aws;
use Aws\S3\S3Client;
use \File;

$amazonServices = Aws::factory(directoryAboveWebRoot().'amazonCredentials.php');
$s3 = $amazonServices->get('s3');
$parsePath = parse_url($storeURL);
$awsBucket = $parsePath['host'];

/**
 * Original eFilms Uploader Script
 */
error_reporting(E_ALL);
ini_set('display_errors', 'On');
$type = $_POST['mimetype'];
$xhr = $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';

if ($type == 'xml') {
    header('Content-type: text/xml');
    echo "<address attr1=\"value1\" attr2=\"value2\">\n";
    echo "    <street attr=\"value\">A &amp; B</street>\n";
    echo "    <city>Palmyra</city>\n";
    echo "</address>\n";
} else if ($type == 'json') {
    // wrap json in a textarea if the request did not come from xhr 
    if (!$xhr)
        echo '<textarea>';
    echo "{ \n";
    echo "    \"library\": \"jQuery\", \n";
    echo "    \"plugin\":  \"form\", \n";
    echo "    \"hello\":   \"goodbye\", \n";
    echo "    \"tomato\":  \"tomoto\" \n";
    echo "} \n";
    if (!$xhr)
        echo '</textarea>';
} else if ($type == 'script') {
    // wrap script in a textarea if the request did not come from xhr 
    if (!$xhr)
        echo '<textarea>';
    echo "for (var i=0; i < 2; i++) \n";
    echo "    alert('Script evaluated!'); \n";
    if (!$xhr)
        echo '</textarea>';
} else {
    header('Content-Type: application/json');
    /*     * *************** Bearbeitung des Files *************************** */
    //Array für Ergebnis der Operation und JSON Ausgabe für jQuery
    $result = array();
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
        //Basic Metadaten aus dem File Auslesen
        $imagemetadata = getimagesize($file['tmp_name']);
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
                    $img = imagecreatefrompng($file['tmp_name']);
                    break;
                case 'image/jpeg':
                    $result['fileextension'] = '.jpg';
                    $img = imagecreatefromjpeg($file['tmp_name']);
                    break;
            }
            $result['width'] = $imagemetadata[0];
            $result['height'] = $imagemetadata[1];
            $result['path'] = $uploadFolder.'/';
        } else {
            $result['result'] = 'fail';
            echo json_encode($result);
        }

        $target_path = $uploadFolder . '/' . basename($_POST['efilmname'] . $result['fileextension']);
        $target_path_image = $uploadFolder . "/imagesLarge/";
        $target_path_thumb = $uploadFolder . "/imagesSmall/";

        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            if ($result['mime'] != 'application/pdf') {
                $shellresult = shell_exec("/usr/local/bin/convert ".$target_path." -resize 640X640 ".$target_path_image.$file['name']." 2>&1");
                $shellresult2 = shell_exec("/usr/local/bin/convert ".$target_path." -resize 131X131 ".$target_path_thumb.$file['name']." 2>&1");

                // Upload large resize to Amazon
                $awsLocation = '/_media/movies_wm/_img/Location-Shots_l/'.$_POST['efilmname'] . $result['fileextension'];
                try {
                    $resource = fopen($target_path_image.$file['name'], 'r');
                    $s3->upload($awsBucket, $awsLocation, $resource, 'public-read');
                    $result['path'] = "http://".$awsBucket.$awsLocation;
                } catch (S3Exception $e) {
                    $result['result'] = 'amazon fail';
                }

                // Upload small resize to Amazon
                $awsLocation = '/_media/movies_wm/_img/Location-Shots_sm/'.$_POST['efilmname'] . $result['fileextension'];
                try {
                    $resource = fopen($target_path_thumb.$file['name'], 'r');
                    $s3->upload($awsBucket, $awsLocation, $resource, 'public-read');
                    $result['thumbnail'] = "http://".$awsBucket.$awsLocation;
                } catch (S3Exception $e) {
                    $result['result'] = 'amazon fail';
                }
                // Unlink the two temp resize files
                unlink($target_path_image.$file['name']);
                unlink($target_path_thumb.$file['name']);
                
                // Scan Original Filename and create annotations if the format matches
                $re = "/\\d{4}-([^\\d_]+)[^_]*_EF([^_]+)_\\d{5}_(\\d{5})-(\\d{5})(.*)/i";
                if (preg_match($re, $file['name'], $match) !== false) {
                    // This file name has details about a specific annotation, so add it
                    $photoName = trim(str_replace("-"," ",$match[1]));
                    $filmSplit = explode("-",$match[2]);
                    if (count($filmSplit) > 1) {
                        $filmNumber = $filmSplit[0];
                        $reelNumber = $filmSplit[1];
                    } else {
                        $filmNumber = $match[2];
                        $reelNumber = "R01";
                    }
                    $startFrame = $match[3];
                    $endFrame = $match[4];
                        $fileNameInfo = explode(".",$match[5]);
                    $photographer = substr($fileNameInfo[0], -2);

                    if (isset($localDatabase)) {
                        // We have a database connection so continue, otherwise skip this step
                        $query = "SELECT `filmNumber` FROM `eFilm_ActiveFilms` WHERE `EF-NS` = '".$filmNumber."' AND `reel` = '".$reelNumber."'";
                        $result = mysqli_query($localDatabase, $query);
                        $movieID = mysqli_fetch_assoc($result);
                        $query = "SELECT `FILM_ID` FROM `eFilm_Content_Movies` WHERE `ID_Movies` = '".$movieID."'";
                        $result = mysqli_query($localDatabase, $query);
                        $filmID = mysqli_fetch_assoc($result);
                        $query = "INSERT INTO `eFilm_Content_Movies_Annotations` (`ID_Movies`,`_FM_CREATE`,`_FM_CHANGE`,`FM_DATETIME_CREATE`,`FM_DATETIME_CHANGE`,`eF_FILM_ID`,`FormID`,`AnnotationType_L1`,`AnnotationType_L2`,`AnnotationType_L3`,`startTime`,`endTime`,`relation`,`_f_sorter`,`_USER_INPUT`) VALUES ('".$movieID."','".$_SESSION["unik"]."','".$_SESSION["unik"]."','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."','".$filmID."','eFSCSRelation','Relation','Relation','Relation','".$startFrame."','".$endFrame."','".$_POST['efilmname'] . $result['fileextension']."','5','".$_SESSION["unik"]."')";
                        mysqli_query($localDatabase, $query);
                    }
                }
            }
        } else {
            $result['result'] = 'fail';
        }

        // Upload full size to Amazon
        $awsLocation = '/_media/movies_wm/_img/Originals/'.$file['name'];
        try {
            $resource = fopen($target_path, 'r');
            $s3->upload($awsBucket, $awsLocation, $resource, 'public-read');
            $result['original'] = "http://".$awsBucket.$awsLocation;
        } catch (S3Exception $e) {
            $result['result'] = 'amazon fail';
        }
        unlink($target_path);

        echo json_encode($result);
    }
}
    