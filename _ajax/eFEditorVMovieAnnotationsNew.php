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

//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//ini_set('display_errors','On');

require_once('/settings.php');
require_once('/includes/functions.php');
require_once(directoryAboveWebRoot().'/db_con.php');

//Variablen
$ID_Movies = (isset($_GET['ID_Movies']) ? $_GET['ID_Movies'] : "");
$eF_FILM_ID = (isset($_GET['eF_FILM_ID']) ? $_GET['eF_FILM_ID'] : "");
$FormID = (isset($_GET['FormID']) ? $_GET['FormID'] : "");
$FormEditID = (isset($_GET['FormEditID']) ? $_GET['FormEditID'] : "");
$action = (isset($_GET['action']) ? $_GET['action'] : "");
$AnnotationType_L1 = (isset($_GET['AnnotationType_L1']) ? $_GET['AnnotationType_L1'] : "");
$AnnotationType_L2 = (isset($_GET['AnnotationType_L2']) ? $_GET['AnnotationType_L2'] : "");
$AnnotationType_L3 = (isset($_GET['AnnotationType_L3']) ? $_GET['AnnotationType_L3'] : "");
$startTime = (isset($_GET['startTime']) ? $_GET['startTime'] : "");
$endTime = (isset($_GET['endTime']) ? $_GET['endTime'] : "");
$timeAnnotation = (isset($_GET['timeAnnotation']) ? $_GET['timeAnnotation'] : "");
$source = (isset($_GET['source']) ? $_GET['source'] : "");
$source_from = (isset($_GET['source_from']) ? $_GET['source_from'] : "");
$source_to = (isset($_GET['source_to']) ? $_GET['source_to'] : "");
$ref = (isset($_GET['ref']) ? $_GET['ref'] : "");
$version = (isset($_GET['version']) ? $_GET['version'] : "");
$annotation = (isset($_GET['annotation']) ? $_GET['annotation'] : "");
$coverage = (isset($_GET['coverage']) ? $_GET['coverage'] : "");
$coverageType = (isset($_GET['coverageType']) ? $_GET['coverageType'] : "");
$coverage_S_Longitude = (isset($_GET['coverage_S_Longitude']) ? $_GET['coverage_S_Longitude'] : "");
$coverage_S_Latitude = (isset($_GET['coverage_S_Latitude']) ? $_GET['coverage_S_Latitude'] : "");
$coverage_S_Geoname = (isset($_GET['coverage_S_Geoname']) ? $_GET['coverage_S_Geoname'] : "");
$coverage_S_LandmarkID = (isset($_GET['coverage_S_LandmarkID']) ? $_GET['coverage_S_LandmarkID'] : "");
$coverage_T_From = (isset($_GET['coverage_T_From']) ? $_GET['coverage_T_From'] : "");
$coverage_T_To = (isset($_GET['coverage_T_To']) ? $_GET['coverage_T_To'] : "");
$subject = (isset($_GET['subject']) ? $_GET['subject'] : "");
$subjectType = (isset($_GET['subjectType']) ? $_GET['subjectType'] : "");
$subject_P_PersonName = (isset($_GET['subject_P_PersonName']) ? $_GET['subject_P_PersonName'] : "");
$subject_P_PersonID = (isset($_GET['subject_P_PersonID']) ? $_GET['subject_P_PersonID'] : "");
$subject_O_OrganizationType = (isset($_GET['subject_O_OrganizationType']) ? $_GET['subject_O_OrganizationType'] : "");
$subject_O_OrganizationName = (isset($_GET['subject_O_OrganizationName']) ? $_GET['subject_O_OrganizationName'] : "");
$subject_O_OrganizationID = (isset($_GET['subject_O_OrganizationID']) ? $_GET['subject_O_OrganizationID'] : "");
$subject_HE_Title = (isset($_GET['subject_HE_Title']) ? $_GET['subject_HE_Title'] : "");
$subject_HE_Date = (isset($_GET['subject_HE_Date']) ? $_GET['subject_HE_Date'] : "");
$subject_HE_Type = (isset($_GET['subject_HE_Type']) ? $_GET['subject_HE_Type'] : "");
$subject_HE_ID = (isset($_GET['subject_HE_ID']) ? $_GET['subject_HE_ID'] : "");
$language = (isset($_GET['language']) ? $_GET['language'] : "");
$relation = (isset($_GET['relation']) ? $_GET['relation'] : "");
$relation_relationType = (isset($_GET['relation_relationType']) ? $_GET['relation_relationType'] : "");
$relation_relationIdentifier = (isset($_GET['relation_relationIdentifier']) ? $_GET['relation_relationIdentifier'] : "");
$relation_relationIdentifier_from = (isset($_GET['relation_relationIdentifier_from']) ? $_GET['relation_relationIdentifier_from'] : "");
$relation_relationIdentifier_to = (isset($_GET['relation_relationIdentifier_to']) ? $_GET['relation_relationIdentifier_to'] : "");
$relation_relationIdentifier_source = (isset($_GET['relation_relationIdentifier_source']) ? $_GET['relation_relationIdentifier_source'] : "");
$relation_relationIdentifier_ref = (isset($_GET['relation_relationIdentifier_ref']) ? $_GET['relation_relationIdentifier_ref'] : "");
$relation_relationIdentifier_version = (isset($_GET['relation_relationIdentifier_version']) ? $_GET['relation_relationIdentifier_version'] : "");
$relation_relationIdentifier_annotation = (isset($_GET['relation_relationIdentifier_annotation']) ? $_GET['relation_relationIdentifier_annotation'] : "");
$description = (isset($_GET['description']) ? $_GET['description'] : "");
$description_descriptionType = (isset($_GET['description_descriptionType']) ? $_GET['description_descriptionType'] : "");
$description_descriptionTypeSource = (isset($_GET['description_descriptionTypeSource']) ? $_GET['description_descriptionTypeSource'] : "");
$description_descriptionTypeRef = (isset($_GET['description_descriptionTypeRef']) ? $_GET['description_descriptionTypeRef'] : "");
$description_descriptionTypeVersion = (isset($_GET['description_descriptionTypeVersion']) ? $_GET['description_descriptionTypeVersion'] : "");
$description_descriptionTypeVersion = (isset($_GET['description_descriptionTypeVersion']) ? $_GET['description_descriptionTypeVersion'] : "");
$description_descriptionTypeAnnotation = (isset($_GET['description_descriptionTypeAnnotation']) ? $_GET['description_descriptionTypeAnnotation'] : "");
$description_segmentType = (isset($_GET['description_segmentType']) ? $_GET['description_segmentType'] : "");
$description_segmentTypeSource = (isset($_GET['description_segmentTypeSource']) ? $_GET['description_segmentTypeSource'] : "");
$description_segmentTypeRef = (isset($_GET['description_segmentTypeRef']) ? $_GET['description_segmentTypeRef'] : "");
$description_segmentTypeVersion = (isset($_GET['description_segmentTypeVersion']) ? $_GET['description_segmentTypeVersion'] : "");
$description_segmentTypeAnnotation = (isset($_GET['description_segmentTypeAnnotation']) ? $_GET['description_segmentTypeAnnotation'] : "");
$USER_INPUT = (isset($_GET['_USER_INPUT']) ? $_GET['_USER_INPUT'] : "");
$researchNotes = (isset($_GET['researchNotes']) ? $_GET['researchNotes'] : "");

$anfrage_NE = "SELECT * FROM eFilm_Content_Movies WHERE _eFWEB_EditorV='1';";

switch ($action) {
	case "NEW":
	$anfrage_NE = "INSERT INTO eFilm_Content_Movies_Annotations (_FM_CREATE, _FM_CHANGE, _FM_DATETIME_CREATE, _FM_DATETIME_CHANGE, ID_Movies, eF_FILM_ID, FormID, AnnotationType_L1, AnnotationType_L2, AnnotationType_L3, startTime, endTime, timeAnnotation, source, source_from, source_to, ref, version, annotation, coverage, coverageType, coverage_S_Longitude, coverage_S_Latitude, coverage_S_Geoname, coverage_S_LandmarkID, coverage_T_From, coverage_T_To, subject, subjectType, subject_P_PersonName, subject_P_PersonID, subject_O_OrganizationType, subject_O_OrganizationName, subject_O_OrganizationID, subject_HE_Title, subject_HE_Date, subject_HE_Type, subject_HE_ID, language, relation, relation_relationType, relation_relationIdentifier, relation_relationIdentifier_from, relation_relationIdentifier_to, relation_relationIdentifier_source, relation_relationIdentifier_ref, relation_relationIdentifier_version, relation_relationIdentifier_annotation, description, description_descriptionType, description_descriptionTypeSource, description_descriptionTypeRef, description_descriptionTypeVersion, description_descriptionTypeAnnotation, description_segmentType, description_segmentTypeSource, description_segmentTypeRef, description_segmentTypeVersion, description_segmentTypeAnnotation, _USER_INPUT, researchLog) VALUES 
	('".$_SESSION["unik"]."', '".$_SESSION["unik"]."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."', '".$ID_Movies."', '".$eF_FILM_ID."', '".$FormID."', '".$AnnotationType_L1."', '".$AnnotationType_L2."', '".$AnnotationType_L3."', '".$startTime."', '".$endTime."', '".$timeAnnotation."', '".$source."', '".$source_from."', '".$source_to."', '".$ref."', '".$version."', '".$annotation."', '".$coverage."', '".$coverageType."', '".$coverage_S_Longitude."', '".$coverage_S_Latitude."', '".$coverage_S_Geoname."', '".$coverage_S_LandmarkID."', '".$coverage_T_From."', '".$coverage_T_To."', '".$subject."', '".$subjectType."', '".$subject_P_PersonName."', '".$subject_P_PersonID."', '".$subject_O_OrganizationType."', '".$subject_O_OrganizationName."', '".$subject_O_OrganizationID."', '".$subject_HE_Title."', '".$subject_HE_Date."', '".$subject_HE_Type."', '".$subject_HE_ID."', '".$language."', '".$relation."', '".$relation_relationType."', '".$relation_relationIdentifier."', '".$relation_relationIdentifier_from."', '".$relation_relationIdentifier_to."', '".$relation_relationIdentifier_source."', '".$relation_relationIdentifier_ref."', '".$relation_relationIdentifier_version."', '".$relation_relationIdentifier_annotation."', '".$description."', '".$description_descriptionType."', '".$description_descriptionTypeSource."', '".$description_descriptionTypeRef."', '".$description_descriptionTypeVersion."', '".$description_descriptionTypeAnnotation."', '".$description_segmentType."', '".$description_segmentTypeSource."', '".$description_segmentTypeRef."', '".$description_segmentTypeVersion."', '".$description_segmentTypeAnnotation."', '".$USER_INPUT."', '".$researchNotes."');	
	";
	break;
	case "EDIT":
	$anfrage_NE = "UPDATE eFilm_Content_Movies_Annotations SET
	_FM_CHANGE='".$_SESSION["unik"]."', 
	_FM_DATETIME_CHANGE='".date("Y-m-d H:i:s")."', 
	ID_Movies='".$ID_Movies."', 
	eF_FILM_ID='".$eF_FILM_ID."', 
	FormID='".$FormID."', 
	AnnotationType_L1='".$AnnotationType_L1."', 
	AnnotationType_L2='".$AnnotationType_L2."', 
	AnnotationType_L3='".$AnnotationType_L3."', 
	startTime='".$startTime."', 
	endTime='".$endTime."', 
	timeAnnotation='".$timeAnnotation."', 
	source='".$source."', 
	ref='".$ref."', 
	version='".$version."', 
	annotation='".$annotation."', 
	coverage='".$coverage."', 
	coverageType='".$coverageType."', 
	coverage_S_Longitude='".$coverage_S_Longitude."', 
	coverage_S_Latitude='".$coverage_S_Latitude."', 
	coverage_S_Geoname='".$coverage_S_Geoname."', 
	coverage_S_LandmarkID='".$coverage_S_LandmarkID."', 
	coverage_T_From='".$coverage_T_From."', 
	coverage_T_To='".$coverage_T_To."', 
	subject='".$subject."', 
	subjectType='".$subjectType."', 
	subject_P_PersonName='".$subject_P_PersonName."', 
	subject_P_PersonID='".$subject_P_PersonID."', 
	subject_O_OrganizationType='".$subject_O_OrganizationType."', 
	subject_O_OrganizationName='".$subject_O_OrganizationName."', 
	subject_O_OrganizationID='".$subject_O_OrganizationID."', 
	subject_HE_Title='".$subject_HE_Title."', 
	subject_HE_Date='".$subject_HE_Date."', 
	subject_HE_Type='".$subject_HE_Type."', 
	subject_HE_ID='".$subject_HE_ID."', 
	language='".$language."', 
	relation='".$relation."', 
	relation_relationType='".$relation_relationType."', 
	relation_relationIdentifier='".$relation_relationIdentifier."', 
	relation_relationIdentifier_source='".$relation_relationIdentifier_source."', 
	relation_relationIdentifier_ref='".$relation_relationIdentifier_ref."', 
	relation_relationIdentifier_version='".$relation_relationIdentifier_version."', 
	relation_relationIdentifier_annotation='".$relation_relationIdentifier_annotation."', 
	description='".$description."', 
	description_descriptionType='".$description_descriptionType."', 
	description_descriptionTypeSource='".$description_descriptionTypeSource."', 
	description_descriptionTypeRef='".$description_descriptionTypeRef."', 
	description_descriptionTypeVersion='".$description_descriptionTypeVersion."', 
	description_descriptionTypeVersion='".$description_descriptionTypeVersion."', 
	description_descriptionTypeAnnotation='".$description_descriptionTypeAnnotation."', 
	description_segmentType='".$description_segmentType."', 
	description_segmentTypeSource='".$description_segmentTypeSource."', 
	description_segmentTypeRef='".$description_segmentTypeRef."', 
	description_segmentTypeVersion='".$description_segmentTypeVersion."', 
	description_segmentTypeAnnotation='".$description_segmentTypeAnnotation."', 
	_USER_INPUT='".$USER_INPUT."',
                  researchLog = '".$researchNotes."'
	WHERE ID_Annotations='".$FormEditID."';";
	break;
}
$ergebnis_NE = mysqli_query($localDatabase, $anfrage_NE); 
$trefferzahl_NE=mysqli_num_rows($ergebnis_NE);
?>