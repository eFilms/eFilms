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

require_once('/settings.php');
require_once('/includes/functions.php');
require_once(directoryAboveWebRoot().'/db_con.php');

$eFContentSelected = (isset($_GET['eFContentSelected']) ? $_GET['eFContentSelected'] : "");
$eFContentKat = (isset($_GET['eFContentKat']) ? $_GET['eFContentKat'] : "");
$uniquid = (isset($_GET['uniquid']) ? $_GET['uniquid'] : "");
$eFRelIDA = (isset($_GET['eFRelIDA']) ? $_GET['eFRelIDA'] : "");

$eFResourceSearchExtension = "";
				$resourcecontentclass="eFResourcesContentNULL";
				$displaynew="$('#eFResourcesNewObject').hide();";
				$topcontent="";	
				$eFShortM2="";

///////////////////////////////////////////////////////////////////////////////////////////////////Resources Relation

///////////////TOPCONTAINER
echo $topcontent;
///////////////SUBCONTAINER
echo "<div class='".$resourcecontentclass."'>";
		echo "<div id='eFResourcesSubContentRelations'>";
		

///////////////Content-Array
		$anfrage = "SELECT 
				 eFilm_ReSources_L1.*, eFilm_ReSources_L2.*
				FROM eFilm_ReSources_L2
				LEFT OUTER JOIN 
				eFilm_ReSources_L1
				ON 
				eFilm_ReSources_L1.ID_R_L1 = eFilm_ReSources_L2.ID_R_L1
				".$eFResourceSearchExtension." ORDER BY eFilm_ReSources_L2.ID_R_L2 ASC;";
		$ergebnis = mysqli_query($localDatabase, $anfrage); 
		$trefferzahl=mysqli_num_rows($ergebnis);
		$listing = Array ();
		while($row = mysqli_fetch_array($ergebnis)) {
			$listing[] = array( 'ID' => $row['ID_R_L1'],
				'content' => array(
				/*'ID_R_L1' => $row['ID_R_L1'],
				'Type' => $row['Type'],
				'Category' => $row['Category'],*/
				'ID_R_L2' => $row['ID_R_L2'],
				'Object_Key' => $row['Object_Key'],
				'Fieldname' => $row['Fieldname'],
				'Fieldtype' => $row['Fieldtype'],
				'Fieldcontent' => $row['Fieldcontent']
				));
			$parent_listing[$row['ID_R_L1']]= array(
				'ID_R_L1' => $row['ID_R_L1'],
				'Type' => $row['Type'],
				'Category' => $row['Category'],
				'Object_Key' => $row['Object_Key'],
				'Group' => $row['Group']
				);
		}
///////////////Anzeige
		foreach ($parent_listing as $k => $v) {
			echo "<div class='efResourceUnit1' data-idl1='".$v['ID_R_L1']."' data-type='".$v['Type']."' data-category='".$v['Category']."' data-key='".$v['Object_Key']."'>
				
				<div class='efResourceUnit1Type'>".$v['Type']."</div>
				<div class='efResourceUnit1Group'>".$v['Group']."</div>
				<div class='efResourceUnit1KeyRelations'>".$v['Object_Key']."</div>";
			echo "<div class='efResourceUnit1RelationsAddFormConatiner'>
					Relation Type: 
						<select name='eFResRelType'>
							<option selected></option>
							<option>Reference</option>
							<option>Affiliation</option>
							<option>Location</option>
						</select>
					&emsp;&emsp;Relation Remark: <input name='eFResRelRef' type='text' value='' style='width:55%' />
						</div><div class='efResourceUnit1RelationsAdd' data-eFRelIDA='".$eFRelIDA."' data-eFRelIDB='".$v['ID_R_L1']."'>add</div>";
			echo "<div class='efResourceUnit2containerRelations'>";
			foreach ($listing as $k2 => $v2) {
				if ($v2['ID'] == $v['ID_R_L1'] && $v2['content']['Fieldcontent'] != '') {
					
					switch ($v2['content']['Fieldtype']) {
						case 'text':
						echo "<div class='efResourceUnit2' data-idl2='".$v2['content']['ID_R_L2']."'><div class='efResourceUnit2fieldnameRelations'>".$v2['content']['Fieldname']."</div><div class='efResourceUnit2fieldcontentRelations' data-idl2='".$v2['content']['ID_R_L2']."' id='".$v2['content']['ID_R_L2']."'>".$v2['content']['Fieldcontent']."</div></div>";
						break;
						case 'image':
						echo "<div class='efResourceUnit2' data-idl2='".$v2['content']['ID_R_L2']."'><div class='efResourceUnit2fieldnameRelations'>".$v2['content']['Fieldname']."</div><div class='efResourceUnit2fieldcontentRelations' data-idl2='".$v2['content']['ID_R_L2']."' id='".$v2['content']['ID_R_L2']."'>".$v2['content']['Fieldcontent']."</div></div>";
						break;
						case 'pdf':
						echo "<div class='efResourceUnit2' data-idl2='".$v2['content']['ID_R_L2']."'><div class='efResourceUnit2fieldnameRelations'>".$v2['content']['Fieldname']."</div><div class='efResourceUnit2fieldcontentRelations' data-idl2='".$v2['content']['ID_R_L2']."' id='".$v2['content']['ID_R_L2']."'>".$v2['content']['Fieldcontent']."</div></div>";
						break;
					}
					
					
				}
			}
			echo "</div>";
			echo "</div>"; //efResourceUnit1
		}
		echo "</div>"; //eFRSubContent
echo "</div>"; //resourcecontentclass
