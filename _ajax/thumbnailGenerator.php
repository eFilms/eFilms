<?php
require '/settings.php';
require '/includes/functions.php';
require '/usr/local/aws-php-sdk/aws-autoloader.php';

use App\Http\Controllers\Controller;
use Aws\Common\Aws;
use Aws\S3\S3Client;
use \File;

$amazonServices = Aws::factory('/data/sites/ee-efilms/s3-credentials/aws-efilms-credentials.php');
$s3 = $amazonServices->get('s3');
$parsePath = parse_url($storeURL);
$awsBucket = $parsePath['host'];

$filmFile = $_POST["location"];
$awsLocation = "http://".$awsBucket."/_media/movies_wm/".$filmFile;
$fps = $_POST["fps"] ?: 24;
$width = $_POST["width"] ?: 80;
$height = $_POST["height"] ?: 60;

$filmFileName = substr($filmFile, 0, strlen($filmFile)-4);  // remove file extension
$baseWritePath = "/_uploads/videoFrames/";
// the video file exists so we will make thumbnails out of the film at the specified frames per second and store them locally
exec("ffmpeg -i ".$awsLocation." -r ".$fps." -s ".$width."x".$height." -f image2 ".$baseWritePath."%06d.jpg");

// next we upload our generated thumbnails to the S3 store
$list = scandir($baseWritePath);
unset($list[array_search(".", $list)]);
unset($list[array_search("..", $list)]);
unset($list[array_search(".DS_Store", $list)]);
sort($list);
$uploadedImages = 0;

// Make the new folder on Amazon S3
$s3->upload($awsBucket, "/_media/shots/".$filmFileName."/", '', 'public-read');
// Copy the images over
foreach ($list as $tempImage) {
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
        echo "fail";
        exit();
    }
    // Unlink the temp image
    unlink($baseWritePath.$tempImage);
}

echo $uploadedImages." thumbnails created and uploaded";
