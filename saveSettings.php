<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

include_once('includes/functions.php');

$s3Lurl = $_POST['s3Lurl'] ?: '/_uploads/';

$content = "<?php\n";
$content .= "\$storeURL = \"".$s3Lurl."\";\n";
$fp = fopen("settings.php", "a");
fwrite($fp, $content);
fclose($fp);

$results['complete'] = 'yes';
$results['setting'] = 's3L';
$results['reason'] = 'Settings saved';
echo json_encode($results);

unlink('saveSettings.php');
