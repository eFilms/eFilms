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

$uniqueUTS = time();
echo '<script type="text/javascript" src="_js/eFEditorV/eFEditorVResourcesInMovies.js?version='.$uniqueUTS.'"></script>';
echo '<link id="resourcesconfigstylesheet" rel="stylesheet" type="text/css" href="_css/eFEditorVResourcesInMovies.css" media="screen" />';

$eFContentSelected = (isset($_GET['eFContentSelected']) ? $_GET['eFContentSelected'] : "");
$eFContentKat = (isset($_GET['eFContentKat']) ? $_GET['eFContentKat'] : "");
$uniquid = (isset($_GET['uniquid']) ? $_GET['uniquid'] : "");

$eFResourceSearchExtension = " WHERE eFilm_ReSources_L1.Category='Resource'";
				$resourcecontentclass="eFResourcesContentNULL";
				$displaynew="";
				$topcontent="";
				$eFShortM2="PHO";

///////////////////////////////////////////////////////////////////////////////////////////////////Resources

///////////////TOPCONTAINER
echo $topcontent;
///////////////SUBCONTAINER
echo "<div id='eFResourcesContent'>";
echo "<div class='".$resourcecontentclass."'>";
		echo "<div id='efResourceUnitNewContainer'>
				<div id='efResourceUnitNewContainerNewObject'>test</div>
				<div id='efResourceUnitNewContainerClose'>X</div>
				<div id='efResourceUnitNewContainerSave'  data-type='".$eFContentSelected."' data-category='".$eFContentKat."'>Save</div>
			</div>
			<div id='eFResourcesFilterContainer'>Filter: <input id='eFResourcesFilterInput' name='eFResourcesFilterInput' type='text' value=''> Group: "; 
			$anfrageGroup = "SELECT DISTINCT `Group` FROM eFilm_ReSources_L1 WHERE NOT `Group`='' ORDER BY `Group` ASC;";
			$ergebnisGroup = mysqli_query($localDatabase, $anfrageGroup);
			echo "<select  id='eFResourcesFilterGroup' name='eFResourcesFilterGroup'><option selected></option>";
			while($row = mysqli_fetch_array($ergebnisGroup)) {
        echo "<option>".$row['Group']."</option>";
			}
			echo "</select>";
			echo "</div>";
		echo "<div id='eFResourcesSubContent'>";
		
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
		foreach ($parent_listing as $k => $v) {
			echo "<div class='efResourceUnit1' data-idl1='".$v['ID_R_L1']."' data-type='".$v['Type']."' data-category='".$v['Category']."' data-key='".$v['Object_Key']."'>
				<div data-delid='".$v['ID_R_L1']."' class='efResourceUnit1DeleteObjectWarning'>
					<div class='efResourceUnit1DeleteObjectWarningMessage'>Are you sure that you really want to delete this resource object?<br/>
					<button id='efResourceUnit1DeleteObjectWarningMessageButtonYES' class='efResourceUnit1DeleteObjectWarningMessageButton'>DELTE</button>
					<button id='efResourceUnit1DeleteObjectWarningMessageButtonNO' class='efResourceUnit1DeleteObjectWarningMessageButton'>CANCEL</button>
					</div>
				</div>
				<div class='efResourceUnit1Type'>".$v['Type']."&emsp;</div>
				<div class='efResourceUnit1Group'>".$v['Group']."&emsp;</div>
				<div class='efResourceUnit1Key'>".$v['Object_Key']."&emsp;</div><div class='efResourceUnitNewContainerAddRes'  data-id='".$v['ID_R_L1']."' data-type='".$v['Type']."' data-key='".$v['Object_Key']."'>add</div>";
			echo "<div class='efResourceUnit2container'>";
			foreach ($listing as $k2 => $v2) {
				if ($v2['ID'] == $v['ID_R_L1'] && $v2['content']['Fieldcontent'] != '') {
					
					switch ($v2['content']['Fieldtype']) {
						case 'text':
						echo "<div class='efResourceUnit2' data-idl2='".$v2['content']['ID_R_L2']."'><div class='efResourceUnit2fieldname'>".$v2['content']['Fieldname']."</div><div class='efResourceUnit2fieldcontent' data-idl2='".$v2['content']['ID_R_L2']."' id='".$v2['content']['ID_R_L2']."'>".$v2['content']['Fieldcontent']."</div><div class='efResourceUnitNewContainerAddResSub' data-id='".$v['ID_R_L1']."' data-type='".$v['Type']."' data-key='".$v['Object_Key']."' data-idl2='".$v2['content']['ID_R_L2']."' data-fieldnamel2='".$v2['content']['Fieldname']."'>add</div></div>";
						break;
						case 'image':
						$textfilepatharr = explode('.', $v2['content']['Fieldcontent']);
							$textfilepathabsolute= '/uploads/imagesLarge/'.$textfilepatharr[0].'.txt';
							if (file_exists($textfilepathabsolute)) {
								$previousfilename=file_get_contents($textfilepathabsolute);
								echo "<div class='efResourceUnit2' data-idl2='".$v2['content']['ID_R_L2']."'>";
								echo "<div class='efResourceUnit2fieldname' data-filename='".$v2['content']['Fieldcontent']."' data-filenameorig='".$previousfilename."'>".$v2['content']['Fieldname']."</div>";
								echo "<div class='efResourceUnit2fieldcontent' data-idl2='".$v2['content']['ID_R_L2']."' id='".$v2['content']['ID_R_L2']."'>";
								echo "<img src='/uploads/imagesSmall/".$v2['content']['Fieldcontent']."' alt='".$v2['content']['Fieldcontent']."' title='".$previousfilename."'/>";
								echo "</div>";//
								echo "</div>";//efResourceUnit2
								}
						break;
						case 'pdf':
						$textfilepatharr = explode('.', $v2['content']['Fieldcontent']);
							$textfilepathabsolute= '/uploads/pdf/'.$textfilepatharr[0].'.txt';
							if (file_exists($textfilepathabsolute)) {
								$previousfilename=file_get_contents($textfilepathabsolute);
								echo "<div class='efResourceUnit2' data-idl2='".$v2['content']['ID_R_L2']."'>";
								echo "<div class='efResourceUnit2fieldname' data-filename='".$v2['content']['Fieldcontent']."' data-filenameorig='".$previousfilename."'>".$v2['content']['Fieldname']."</div>";
								echo "<div class='efResourceUnit2fieldcontent' data-idl2='".$v2['content']['ID_R_L2']."' id='".$v2['content']['ID_R_L2']."'>";
								echo "<img src='_img/pdf-icon.png' alt='".$v2['content']['Fieldcontent']."' title='".$previousfilename."'/>";
								echo "</div>";//
								echo "</div>";//efResourceUnit2
								}
						break;
					}
					
					
				}
			}
			echo "</div>";
			echo "<div class='efResourceUnit2linkscontainer'><div class='efResourceUnit2linkscontainerTitle'>Relations</div>";
			echo "</div>";
			echo "</div>"; //efResourceUnit1
		}
		echo "</div>"; //eFRSubContent
echo "</div>"; //resourcecontentclass
echo "</div>"; //eFResourcesContent

