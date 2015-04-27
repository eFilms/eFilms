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

//echo '<script type="text/javascript" src="_js/eFEditorV/eFEditorVResources.js?version='.$uniqueUTS.'"></script>';
echo '<link id="resourcesconfigstylesheet" rel="stylesheet" type="text/css" href="_css/eFEditorVResourcesConfig.css" media="screen" />';
?>
<div id="eFResourcesSelect">
	<ul>
		<li class="separator">Movies</li>
		<li class="content" data-content="Movies" data-kat="Movies">eFilm Movies</li>
		<li class="separator">Coverage</li>
		<li class="content" data-content="Landmarks" data-kat="Coverage">Landmarks</li>
		<li class="separator">Subjects</li>
		<li class="content" data-content="Persons" data-kat="Subject">Persons</li>
		<li class="content" data-content="Organisations" data-kat="Subject">Organisations</li>
		<li class="content" data-content="Historic Events" data-kat="Subject">Historic Events</li>
		<li class="separator">Sources</li>
		<li class="content" data-content="Finding Aids" data-kat="Resource">Finding Aids</li>
		<li class="content" data-content="Archival Sources" data-kat="Resource">Archival Sources</li>
		<li class="content" data-content="Publications" data-kat="Resource">Publications</li>
		<li class="content" data-content="Photos" data-kat="Resource">Photos</li>
		<li class="content" data-content="Other Documents" data-kat="Resource">Other Documents</li>
		<li class="content" data-content="All Resources" data-kat="Resource">All Resources</li>
	</ul>
</div>
<div id="eFResourcesContent">
</div>