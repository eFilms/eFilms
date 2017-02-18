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

$uniqueUTS = time();
echo '<script type="text/javascript" src="_js/eFEditorV/eFEditorVConfig.js?version='.$uniqueUTS.'"></script>';
echo '<link id="resourcesconfigstylesheet" rel="stylesheet" type="text/css" href="_css/eFEditorVResourcesConfig.css" media="screen" />';
?>

<div id="eFConfigSelect">
	<ul>
		<li class="separator">Access</li>
		<li class="content" data-content="Access" data-kat="Users">Users</li>
		<li class="separator">Content</li>
		<li class="content" data-content="Content" data-kat="Naming">Naming</li>
	</ul>
</div>
<div id="eFConfigContent">
</div>