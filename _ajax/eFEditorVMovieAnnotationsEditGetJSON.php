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

$Editid = (isset($_GET['Editid']) ? $_GET['Editid'] : "");

$anfrage_JSON = "SELECT * FROM eFilm_Content_Movies_Annotations WHERE ID_Annotations='".$Editid."';";
$ergebnis_JSON = mysqli_query($localDatabase, $anfrage_JSON); 
$trefferzahl_JSON=mysqli_num_rows($ergebnis_JSON);

$Contenarray = array();
	
while ($row_JSON = mysqli_fetch_array($ergebnis_JSON)) {
$Contenarray['ID_Movies'] = $row_JSON['ID_Movies'];
$Contenarray['ID_Annotations'] = $row_JSON['ID_Annotations'];
$Contenarray['_FM_CREATE'] = $row_JSON['_FM_CREATE'];
$Contenarray['_FM_CHANGE'] = $row_JSON['_FM_CHANGE'];
$Contenarray['_FM_DATETIME_CREATE'] = $row_JSON['_FM_DATETIME_CREATE'];
$Contenarray['_FM_DATETIME_CHANGE'] = $row_JSON['_FM_DATETIME_CHANGE'];
$Contenarray['eF_FILM_ID'] = $row_JSON['eF_FILM_ID'];
$Contenarray['AnnotationType_L1'] = $row_JSON['AnnotationType_L1'];
$Contenarray['AnnotationType_L2'] = $row_JSON['AnnotationType_L2'];
$Contenarray['AnnotationType_L3'] = $row_JSON['AnnotationType_L3'];
$Contenarray['startTime'] = $row_JSON['startTime'];
$Contenarray['endTime'] = $row_JSON['endTime'];
$Contenarray['timeAnnotation'] = $row_JSON['timeAnnotation'];
$Contenarray['source'] = $row_JSON['source'];
$Contenarray['ref'] = $row_JSON['ref'];
$Contenarray['version'] = $row_JSON['version'];
$Contenarray['annotation'] = $row_JSON['annotation'];
$Contenarray['coverage'] = $row_JSON['coverage'];
$Contenarray['coverageType'] = $row_JSON['coverageType'];
$Contenarray['coverage_S_Longitude'] = $row_JSON['coverage_S_Longitude'];
$Contenarray['coverage_S_Latitude'] = $row_JSON['coverage_S_Latitude'];
$Contenarray['coverage_S_Geoname'] = $row_JSON['coverage_S_Geoname'];
$Contenarray['coverage_T_From'] = $row_JSON['coverage_T_From'];
$Contenarray['coverage_T_To'] = $row_JSON['coverage_T_To'];
$Contenarray['subject'] = $row_JSON['subject'];
$Contenarray['subjectType'] = $row_JSON['subjectType'];
$Contenarray['subject_P_PersonName'] = $row_JSON['subject_P_PersonName'];
$Contenarray['subject_P_PersonID'] = $row_JSON['subject_P_PersonID'];
$Contenarray['subject_O_OrganizationType'] = $row_JSON['subject_O_OrganizationType'];
$Contenarray['subject_O_OrganizationName'] = $row_JSON['subject_O_OrganizationName'];
$Contenarray['subject_O_OrganizationID'] = $row_JSON['subject_O_OrganizationID'];
$Contenarray['subject_HE_Title'] = $row_JSON['subject_HE_Title'];
$Contenarray['subject_HE_Date'] = $row_JSON['subject_HE_Date'];
$Contenarray['subject_HE_Type'] = $row_JSON['subject_HE_Type'];
$Contenarray['subject_HE_ID'] = $row_JSON['subject_HE_ID'];
$Contenarray['relation'] = $row_JSON['relation'];
$Contenarray['relation_relationType'] = $row_JSON['relation_relationType'];
$Contenarray['relation_relationIdentifier'] = $row_JSON['relation_relationIdentifier'];
$Contenarray['relation_relationIdentifier_source'] = $row_JSON['relation_relationIdentifier_source'];
$Contenarray['relation_relationIdentifier_ref'] = $row_JSON['relation_relationIdentifier_ref'];
$Contenarray['relation_relationIdentifier_version'] = $row_JSON['relation_relationIdentifier_version'];
$Contenarray['relation_relationIdentifier_annotation'] = $row_JSON['relation_relationIdentifier_annotation'];
$Contenarray['description'] = $row_JSON['description'];
$Contenarray['description_descriptionType'] = $row_JSON['description_descriptionType'];
$Contenarray['description_descriptionTypeSource'] = $row_JSON['description_descriptionTypeSource'];
$Contenarray['description_descriptionTypeRef'] = $row_JSON['description_descriptionTypeRef'];
$Contenarray['description_descriptionTypeVersion'] = $row_JSON['description_descriptionTypeVersion'];
$Contenarray['description_descriptionTypeAnnotation'] = $row_JSON['description_descriptionTypeAnnotation'];
$Contenarray['description_segmentType'] = $row_JSON['description_segmentType'];
$Contenarray['description_segmentTypeSource'] = $row_JSON['description_segmentTypeSource'];
$Contenarray['description_segmentTypeRef'] = $row_JSON['description_segmentTypeRef'];
$Contenarray['description_segmentTypeVersion'] = $row_JSON['description_segmentTypeVersion'];
$Contenarray['description_segmentTypeAnnotation'] = $row_JSON['description_segmentTypeAnnotation'];
$Contenarray['FormID'] = $row_JSON['FormID'];
$Contenarray['coverage_S_LandmarkID'] = $row_JSON['coverage_S_LandmarkID'];
$Contenarray['language'] = $row_JSON['language'];
$Contenarray['_empty'] = $row_JSON['_empty'];
$Contenarray['_USER_INPUT'] = $row_JSON['_USER_INPUT'];
$Contenarray['researchLog'] = $row_JSON['researchLog'];
}
//print_r($Contenarray);
echo json_encode($Contenarray)
?>
