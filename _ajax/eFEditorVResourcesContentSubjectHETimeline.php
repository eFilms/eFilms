<?php
if(!isset($_SESSION)) 
{ 
session_start(); 
} 
if ($_SESSION["login"] != "true"){
  header("Location:login.php");
  $_SESSION["error"] = "<h1 style='color:red;'>You don't have privileges to see this page.</h1>";
  exit;
}

$eFResourcesCLMode = (isset($_GET['eFResourcesCLMode']) ? $_GET['eFResourcesCLMode'] : "");
$Landmark_Name = (isset($_GET['Landmark_Name']) ? $_GET['Landmark_Name'] : "");
$Landmark_Geoname = (isset($_GET['Landmark_Geoname']) ? $_GET['Landmark_Geoname'] : "");
$Longitude = (isset($_GET['Longitude']) ? $_GET['Longitude'] : "");
$Latitude = (isset($_GET['Latitude']) ? $_GET['Latitude'] : "");
$Group = (isset($_GET['Group']) ? $_GET['Group'] : "");

$eFResourcesCLEditID = (isset($_GET['eFResourcesDelID']) ? $_GET['eFResourcesDelID'] : "");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Ephemeral Films: Timeline of Historic Events</title>
	<script src="http://static.simile.mit.edu/timeline/api-2.3.0/timeline-api.js?bundle=true" type="text/javascript"></script>
	<script type="text/javascript">
	var tl;
 function onLoad() {
   var bandInfos = [
   	Timeline.createBandInfo({
         width:          "50%", 
         intervalUnit:   Timeline.DateTime.DAY, 
         intervalPixels: 100
     }),
   
     Timeline.createBandInfo({
         width:          "30%", 
         intervalUnit:   Timeline.DateTime.MONTH, 
         intervalPixels: 200
     }),
   
     Timeline.createBandInfo({
         width:          "20%", 
         intervalUnit:   Timeline.DateTime.YEAR, 
         intervalPixels: 300
     })
   ];
   bandInfos[1].syncWith = 0;
   bandInfos[1].highlight = true;
   tl = Timeline.create(document.getElementById("my-timeline"), bandInfos);
   Timeline.loadXML("example1.xml", function(xml, url) { eventSource.loadXML(xml, url); });
 }

 var resizeTimerID = null;
 function onResize() {
     if (resizeTimerID == null) {
         resizeTimerID = window.setTimeout(function() {
             resizeTimerID = null;
             tl.layout();
         }, 500);
     }
 }
	
</script>
</head>
<body onload="onLoad();" onresize="onResize();">
<div id="my-timeline" style="height: 150px; border: 1px solid #aaa"></div>
<noscript>
This page uses Javascript to show you a Timeline. Please enable Javascript in your browser to see the full page. Thank you.
</noscript>
</body>
</html>