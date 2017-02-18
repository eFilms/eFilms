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

require_once('settings.php');
require_once('includes/functions.php');
require_once(directoryAboveWebRoot().'/db_con.php');

$ID_R_L1 = (isset($_GET['ID_R_L1']) ? $_GET['ID_R_L1'] : "");
$uniquid = (isset($_GET['uniquid']) ? $_GET['uniquid'] : "");

$eFResourceSearchExtension = "";
$resourcecontentclass="eFResourcesContentNULL";
$displaynew="$('#eFResourcesNewObject').hide();";
$topcontent="";	
$eFShortM2="";
		
///////////////Relations-Arrays
		$anfrageR1 = "SELECT 
				 eFilm_ReSources_L1.*, eFilm_ReSources_RelationIndex.*
				FROM eFilm_ReSources_RelationIndex
				LEFT OUTER JOIN 
				eFilm_ReSources_L1
				ON 
				eFilm_ReSources_RelationIndex.ID_R_L1_B = eFilm_ReSources_L1.ID_R_L1
				WHERE eFilm_ReSources_RelationIndex.ID_R_L1_A='".$ID_R_L1."'
				;";
		$ergebnisR1 = mysqli_query($localDatabase, $anfrageR1); 
		$trefferzahlR1=mysqli_num_rows($ergebnisR1);
		$RelationListingA = Array ();
		while($rowR1 = mysqli_fetch_array($ergebnisR1)) {
			//print_r($rowR1);
			echo "<div class='efResourceUnit2linkscontainerContentEContainer'  data-ID_R_RelationIndex='".$rowR1['ID_R_RelationIndex']."'>";
				echo "<div class='efResourceUnit2linkscontainerContentETitle' data-ID_R_RelationIndex='".$rowR1['ID_R_RelationIndex']."' data-ID_R_L1_A='".$rowR1['ID_R_L1_A']."' data-ID_R_L1_B='".$rowR1['ID_R_L1_B']."'>";
									echo $rowR1['Type'];
									echo "</div>"; //efResourceUnit2linkscontainerContentETitle
									
									echo "<div class='efResourceUnit2linkscontainerContentEContentContainerObjectContainer'>";
										echo "<div class='efResourceUnit2linkscontainerContentEContentContainerObjectTitle'>Object_Key</div>";//efResourceUnit2linkscontainerContentEContentContainerObjectTitle
										echo "<div class='efResourceUnit2linkscontainerContentEContentContainerObjectContent'>";
										echo $rowR1['Object_Key'];
										echo "</div>";//efResourceUnit2linkscontainerContentEContentContainerObjectContent
									echo "</div>";//efResourceUnit2linkscontainerContentEContentContainerObjectContainer
									echo "<div class='efResourceUnit2linkscontainerContentEContentContainerObjectContainer'>";
										echo "<div class='efResourceUnit2linkscontainerContentEContentContainerObjectTitle'>Relation Type</div>";//efResourceUnit2linkscontainerContentEContentContainerObjectTitle
										echo "<div class='efResourceUnit2linkscontainerContentEContentContainerObjectContent'>";
										echo $rowR1['RelationType'];
										echo "</div>";//efResourceUnit2linkscontainerContentEContentContainerObjectContent
									echo "</div>";//efResourceUnit2linkscontainerContentEContentContainerObjectContainer
									echo "<div class='efResourceUnit2linkscontainerContentEContentContainerObjectContainer'>";
										echo "<div class='efResourceUnit2linkscontainerContentEContentContainerObjectTitle'>Relation Remarks</div>";//efResourceUnit2linkscontainerContentEContentContainerObjectTitle
										echo "<div class='efResourceUnit2linkscontainerContentEContentContainerObjectContent'>";
										echo $rowR1['RelationRemark'];
										echo "</div>";//efResourceUnit2linkscontainerContentEContentContainerObjectContent
									echo "</div>";//efResourceUnit2linkscontainerContentEContentContainerObjectContainer
			echo "<div class='efResourceUnit2linkscontainerContentEContentContainerDel' data-ID_R_RelationIndex='".$rowR1['ID_R_RelationIndex']."' data-idl1='".$ID_R_L1."'>-</div>"; 
			echo "</div>"; //efResourceUnit2linkscontainerContentEContainer
		}
		
