<?php
ini_set('memory_limit','10000M');
set_time_limit(12*3600); // set time limit of 12 hour(s)
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION["login"] != "true") {
    header("Location:../login.php");
    $_SESSION["error"] = "<h1 style='color:red;'>You don't have privileges to see this page.</h1>";
    exit;
}

$uploadFolder = "../uploads";
if (!file_exists($uploadFolder)) {
  mkdir($uploadFolder);
  chmod($uploadFolder, 0755);
}
if (!file_exists($uploadFolder . "/video")) {
  mkdir($uploadFolder . "/video");
  chmod($uploadFolder . "/video", 0755);
}
if (!file_exists($uploadFolder . "/videoFrames")) {
  mkdir($uploadFolder . "/videoFrames");
  chmod($uploadFolder . "/videoFrames", 0755);
}
$baseWritePath = "../uploads/video/";
$baseThumbnailPath = "../uploads/videoFrames/";

//Get the temp file path, file name and extension
$tmpFilePath = $_FILES['fileToUpload']['tmp_name'];
$name = $_FILES['fileToUpload']['name'];
$nameParts = explode('.',$name);
$extension = end($nameParts);
$ext = strtolower($extension);
$acceptedExtensions = array("m4v","mp4","mov");
if ($tmpFilePath != "" && in_array($ext,$acceptedExtensions)) {
  $newFileName = array_shift($nameParts);
  $newFilePath = $baseWritePath.$newFileName.".".$ext;
  move_uploaded_file($tmpFilePath, $newFilePath);

  // make OGG File
  exec("ffmpeg -i ".$newFilePath." -acodec libvorbis -ac 2 -ab 96k -ar 44100 -b 5130k -s 960x720 ".$baseWritePath.$newFileName.".ogv");

  // Generate Thumbnails Here
  $fps = 24;
  $width = 80;
  $height = 60;
  if (!file_exists($baseThumbnailPath.$newFileName)) {
    mkdir($baseThumbnailPath.$newFileName);
    chmod($baseThumbnailPath.$newFileName, 0755);
  }
  exec("ffmpeg -i ".$newFilePath." -r ".$fps." -s ".$width."x".$height." -f image2 ".$baseThumbnailPath.$newFileName."/%06d.jpg");
}
unset($_FILES['fileToUpload']['name']);

header('Content-Type: application/json');
exit();

/*
//Array für Ergebnis der Operation und JSON Ausgabe für jQuery
$result = array();
//echo "mp4 uploader...\n";
//var_dump($_FILES);

//$_FILES Array auslesen
$content = "";
foreach ($_FILES as $file) {
    // Make sure all of our folders are in place
    $uploadFolder = "../uploads";
    if (!file_exists($uploadFolder)) {
        mkdir($uploadFolder);
        chmod($uploadFolder, 0777);
    }
    if (!file_exists($uploadFolder . "/video")) {
        mkdir($uploadFolder . "/video");
        chmod($uploadFolder . "/video", 0777);
    }
    if (!file_exists($uploadFolder . "/videoFrames")) {
        mkdir($uploadFolder . "/videoFrames");
        chmod($uploadFolder . "/videoFrames", 0777);
    }
    $baseWritePath = "../uploads/video/";

    $n = $file['name'];
    $s = $file['size'];
    if (!$n) continue;

    if (substr($file['name'], -4) != '.m4v') {
        $content .=  'Please upload a video in m4v format.';
        continue;
    }

    $isWatermarked = (isset($_POST['watermarked']) && $_POST['watermarked'] == 'true') ? true : false;
    
    $target_path = $baseWritePath.$file['name'];

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
      if (isset($s3)) {
        // Upload large resize to Amazon
        if ($isWatermarked) {
            $awsLocation = '/_media/movies_wm/'.$file['name'];
        } else {
            $awsLocation = '/_media/movies/'.$file['name'];
        }
        try {
            $resource = fopen($target_path, 'r');
            $s3->upload($awsBucket, $awsLocation, $resource, 'public-read');
//            $result['path'] = "http://".$awsBucket.$awsLocation;
        } catch (S3Exception $e) {
            $content .=  'Transfer to Amazon failed: '.$e;
            exit();
        }
      }
    } else {
	    $content .=  'There was an error uploading the file, please try again.';
      exit();
    }
    
    $filmFileName = substr($file['name'], 0, strlen($file['name'])-4);  // remove file extension
    
    // make OGG File
    exec("ffmpeg -i ".$target_path." -acodec libvorbis -ac 2 -ab 96k -ar 44100 -b 5130k -s 960x720 ".$baseWritePath.$filmFileName.".ogv");
    
    if (isset($s3)) {
      if ($isWatermarked) {
        $awsLocation = '/_media/movies_wm/'.$filmFileName.".ogg";
      } else {
        $awsLocation = '/_media/movies/'.$filmFileName.".ogg";
      }
      try {
      $resource = fopen($baseWritePath.$filmFileName.".ogv", 'r');
          $s3->upload($awsBucket, $awsLocation, $resource, 'public-read');
  //            $result['path'] = "http://".$awsBucket.$awsLocation;
      } catch (S3Exception $e) {
          $content .=  'OGG Transfer to Amazon failed: '.$e;
          exit();
      }
      unlink($baseWritePath.$filmFileName.".ogv");  // Done with the ogg file
    }
    
    if ($isWatermarked) {
        // We are done with the watermarked copies
        exit();
    }
    
    $fps = 24;
    $width = 80;
    $height = 60;

    $baseWritePath = "../uploads/videoFrames/";
    // the video file exists so we will make thumbnails out of the film at the specified frames per second and store them locally
    exec("ffmpeg -i ".$target_path." -r ".$fps." -s ".$width."x".$height." -f image2 ".$baseWritePath."%06d.jpg");

    // next we upload our generated thumbnails to the S3 store
    $list = scandir($baseWritePath);
    unset($list[array_search(".", $list)]);
    unset($list[array_search("..", $list)]);
    unset($list[array_search(".DS_Store", $list)]);
    sort($list);
    $uploadedImages = 0;

    if (isset($s3)) {
      // Make the new folder on Amazon S3
      $s3->upload($awsBucket, "/_media/shots/".$filmFileName."/", '', 'public-read');
      // Copy the images over
      foreach ($list as $tempImage) {
        $i = 0;
        $time = date('s');
        while ($i > 2 && $time == date('s')) {
            // do nothing, we only want to send 3/sec
        }
        if (!file_exists($baseWritePath.$tempImage)) {
            continue;
        }
    // upload image to Amazon
        $awsLocation = "/_media/shots/".$filmFileName."/".str_pad($uploadedImages, 6,"0",STR_PAD_LEFT).".jpg";
        try {
            $resource = fopen($baseWritePath.$tempImage, 'r');
            $s3->upload($awsBucket, $awsLocation, $resource, 'public-read');
            $uploadedImages++;
        } catch (S3Exception $e) {
            echo "fail: ".$e;
            exit();
        }
    // Unlink the temp image
        unlink($baseWritePath.$tempImage);
        $i++;
      }
      unlink($target_path);   // Done with the m4v file
    }
}
header('Content-Type: application/json');
exit();
