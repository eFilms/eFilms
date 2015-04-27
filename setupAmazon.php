<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 'On');

include_once('includes/functions.php');

$s3Key = preg_replace("/[^\w]/","",$_POST['s3Key']);
$s3Secret = preg_replace("/[^\w\/\.\-\,_]/","",$_POST['s3Secret']);
$s3Region = preg_replace("/[^\w\/\.\-\,_]/","",$_POST['s3Region']);
$skip = $_POST['skip'];

if ($skip == 'false') {
	$content = "<?php\n";
	$content .= "return array(\n";
	$content .= "	'includes' => array('_aws'),\n";
	$content .= "	'services' => array(\n";
	$content .= "		'default_settings' => array(\n";
	$content .= "			'params' => array(\n";
	$content .= "				'key' => '".$s3Key."',\n";
	$content .= "				'secret' => '".$s3Secret."',\n";
	$content .= "				'region' => '".$s3Region."'\n";
	$content .= "			)\n";
	$content .= "		)\n";
	$content .= "	)\n";
	$content .= ");\n";
	$fp = fopen(directoryAboveWebRoot()."/amazonCredentials.php", "a");
	fwrite($fp, $content);
	fclose($fp);

	$results['complete'] = 'yes';
	$results['setting'] = 's3';
	$results['reason'] = 'S3 Connection created...';
	echo json_encode($results);

} else {
	$results['complete'] = 'yes';
	$results['setting'] = 's3';
	$results['reason'] = 'Skipping Amazon S3 setup';
	echo json_encode($results);
}

unlink('setupAmazon.php');
