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

$eFResourcesCLMode = (isset($_GET['eFResourcesCLMode']) ? $_GET['eFResourcesCLMode'] : "");
$Landmark_Name = (isset($_GET['Landmark_Name']) ? $_GET['Landmark_Name'] : "");
$Landmark_Geoname = (isset($_GET['Landmark_Geoname']) ? $_GET['Landmark_Geoname'] : "");
$Longitude = (isset($_GET['Longitude']) ? $_GET['Longitude'] : "");
$Latitude = (isset($_GET['Latitude']) ? $_GET['Latitude'] : "");
$Group = (isset($_GET['Group']) ? $_GET['Group'] : "");

$eFResourcesCLEditID = (isset($_GET['eFResourcesDelID']) ? $_GET['eFResourcesDelID'] : "");

switch ($eFResourcesCLMode) {
	case 'NewLandmark':
				$L2_content = array( 'Landmark_Name'=> $Landmark_Name );
				$L2_content['Landmark_Geoname'] = $Landmark_Geoname;
				$L2_content['Longitude'] = $Longitude;
				$L2_content['Latitude'] = $Latitude;
				$L2_content['Group'] = $Group;
				
				$uniqueLMKUTS = time();
				$nameLMKUTS = str_replace(" ", "-", ereg_replace("[^A-Za-z0-9]", " ", str_replace("ß", "ss", str_replace("ä", "ae", str_replace("ü", "ue", str_replace("ö", "oe", $Landmark_Name)))) ));
				$L1_content_object_key = "COV_LMK_".$nameLMKUTS."_".$uniqueLMKUTS;
				//echo $L1_content_object_key;
				$anfrage_IDL0 = "INSERT INTO eFilm_ReSources_L1 (`Type`, `Object_Key`, `Category`, `Group`) VALUES ('Landmark', '".$L1_content_object_key."', 'Coverage', '".$Group."');";
				$ergebnis_IDL0 = mysqli_query($localDatabase, $anfrage_IDL0);

				$anfrage_IDL1 = "SELECT ID_R_L1 FROM  eFilm_ReSources_L1 WHERE Object_Key='".$L1_content_object_key."';";
				$ergebnis_IDL1 = mysqli_query($localDatabase, $anfrage_IDL1);
				$trefferzahl_IDL1=mysqli_num_rows($ergebnis_IDL1);
				if ($trefferzahl_IDL1 == 1 ) {
					while ($row_IDL1 = mysqli_fetch_array($ergebnis_IDL1)) {
						$ID_L1_for_L2 = $row_IDL1['ID_R_L1'];
					}
					foreach ($L2_content as $kL2 => $vL2) {
						$anfrage_IDL2 = "INSERT INTO eFilm_ReSources_L2 (`ID_R_L1`, `Fieldname`, `Fieldtype`, `Fieldcontent`)  VALUES ('".mysqli_real_escape_string($localDatabase, utf8_decode($ID_L1_for_L2))."', '".mysqli_real_escape_string($localDatabase, utf8_decode($kL2))."', 'text', '".mysqli_real_escape_string($localDatabase, utf8_decode($vL2))."');";
						$ergebnis_IDL2 = mysqli_query($localDatabase, $anfrage_IDL2);
					}
				}
	break;


}


?>
