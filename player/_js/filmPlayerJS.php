<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

$content = file_get_contents('https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js')."\n\n";
$content .= file_get_contents('jquery.app-folders.js')."\n\n";
$content .= file_get_contents('popcorn-complete.js')."\n\n";
$content .= file_get_contents('http://maps.google.com/maps/api/js?sensor=false')."\n\n";
$content .= file_get_contents('jquery.gmap.min.js')."\n\n";
$content .= file_get_contents('jQBaseUI/jquery-ui-1.8.17.custom.min.js')."\n\n";

header('Content-Type: application/javascript');
echo $content;