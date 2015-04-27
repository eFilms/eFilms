<?php
/****************  License **********************/
/*
The technology and most  of the code for this site was developed by Georg Kö 
( reads as Georg Koe in english) from 2011 to 2013 for the Project 
"Ephemeral Films:  National Socialism in Austria".
The technology and the code is available to be copied, distributed, transmited and adapted 
under the Creative  Commons License Attribution-NonCommercial-ShareAlike 2.0 Generic (CC BY-NC-SA 2.0)
See: http://creativecommons.org/licenses/by-nc-sa/2.0/
To comply with this license   agreement this license statement has to be attributed in any case of 
copying, distribution, transmission or adaption within the code and  Georg Kö (reads Georg Koe in english)
has to be publicly mentioned  particularly by name as its  inventor on any web site, in any publication or on the lable 
of any virtual or physical product resulting from copying, distributing, transmitting or adapting this code 
or the technological invention it represents.
*/
/**************** License  **********************/

$MovieID = preg_replace("/[^0-9]/", "", $_GET['movieID']);

require_once('/settings.php');
require_once('/includes/functions.php');
require_once(directoryAboveWebRoot().'/db_con.php');

$anfrage_JSON = "SELECT * FROM eFilm_Content_Movies_Annotations WHERE ID_Movies='".$MovieID."' ORDER BY startTime DESC, endTime DESC;";
$ergebnis_JSON = mysqli_query($localDatabase,$anfrage_JSON); 
$totalfound=mysqli_num_rows($ergebnis_JSON);
	$numbercounter=0;
	echo '{ "annotation": [';
	while ($row_JSON = mysqli_fetch_array($ergebnis_JSON)) {
	echo '{';
	echo '"ID_Movies":'.json_encode($row_JSON['ID_Movies']).', ';
	echo '"ID_Annotations":'.json_encode($row_JSON['ID_Annotations']).', ';
	echo '"eF_FILM_ID":'.json_encode($row_JSON['eF_FILM_ID']).', ';
	echo '"AnnotationType_L1":'.json_encode($row_JSON['AnnotationType_L1']).', ';
	echo '"AnnotationType_L2":'.json_encode($row_JSON['AnnotationType_L2']).', ';
	echo '"AnnotationType_L3":'.json_encode($row_JSON['AnnotationType_L3']).', ';
	echo '"startTime":'.json_encode($row_JSON['startTime']).', ';
	echo '"endTime":'.json_encode($row_JSON['endTime']).', ';
	echo '"timeAnnotation":'.json_encode($row_JSON['timeAnnotation']).', ';
	echo '"source":'.json_encode($row_JSON['source']).', ';
	echo '"ref":'.json_encode($row_JSON['ref']).', ';
	echo '"version":'.json_encode($row_JSON['version']).', ';
	echo '"annotation":'.json_encode($row_JSON['annotation']).', ';
	echo '"coverage":'.json_encode($row_JSON['coverage']).', ';
	echo '"coverageType":'.json_encode($row_JSON['coverageType']).', ';
	echo '"coverage_S_Longitude":'.json_encode($row_JSON['coverage_S_Longitude']).', ';
	echo '"coverage_S_Latitude":'.json_encode($row_JSON['coverage_S_Latitude']).', ';
	echo '"coverage_S_Geoname":'.json_encode($row_JSON['coverage_S_Geoname']).', ';
	echo '"coverage_T_From":'.json_encode($row_JSON['coverage_T_From']).', ';
	echo '"coverage_T_To":'.json_encode($row_JSON['coverage_T_To']).', ';
	echo '"subject":'.json_encode($row_JSON['subject']).', ';
	echo '"subjectType":'.json_encode($row_JSON['subjectType']).', ';
	echo '"subject_P_PersonName":'.json_encode($row_JSON['subject_P_PersonName']).', ';
	echo '"subject_P_PersonID":'.json_encode($row_JSON['subject_P_PersonID']).', ';
	echo '"subject_O_OrganizationType":'.json_encode($row_JSON['subject_O_OrganizationType']).', ';
	echo '"subject_O_OrganizationName":'.json_encode($row_JSON['subject_O_OrganizationName']).', ';
	echo '"subject_O_OrganizationID":'.json_encode($row_JSON['subject_O_OrganizationID']).', ';
	echo '"subject_HE_Title":'.json_encode($row_JSON['subject_HE_Title']).', ';
	echo '"subject_HE_Date":'.json_encode($row_JSON['subject_HE_Date']).', ';
	echo '"subject_HE_Type":'.json_encode($row_JSON['subject_HE_Type']).', ';
	echo '"subject_HE_ID":'.json_encode($row_JSON['subject_HE_ID']).', ';
	echo '"relation":'.json_encode($row_JSON['relation']).', ';
	echo '"relation_relationType":'.json_encode($row_JSON['relation_relationType']).', ';
	echo '"relation_relationIdentifier":'.json_encode($row_JSON['relation_relationIdentifier']).', ';
	echo '"relation_relationIdentifier_source":'.json_encode($row_JSON['relation_relationIdentifier_source']).', ';
	echo '"relation_relationIdentifier_ref":'.json_encode($row_JSON['relation_relationIdentifier_ref']).', ';
	echo '"relation_relationIdentifier_version":'.json_encode($row_JSON['relation_relationIdentifier_version']).', ';
	echo '"relation_relationIdentifier_annotation":'.json_encode($row_JSON['relation_relationIdentifier_annotation']).', ';
	echo '"description":'.str_replace("'", "´", json_encode($row_JSON['description'])).', ';
	echo '"description_descriptionType":'.json_encode($row_JSON['description_descriptionType']).', ';
	echo '"description_descriptionTypeSource":'.json_encode($row_JSON['description_descriptionTypeSource']).', ';
	echo '"description_descriptionTypeRef":'.json_encode($row_JSON['description_descriptionTypeRef']).', ';
	echo '"description_descriptionTypeVersion":'.json_encode($row_JSON['description_descriptionTypeVersion']).', ';
	echo '"description_descriptionTypeAnnotation":'.json_encode($row_JSON['description_descriptionTypeAnnotation']).', ';
	echo '"description_segmentType":'.json_encode($row_JSON['description_segmentType']).', ';
	echo '"description_segmentTypeSource":'.json_encode($row_JSON['description_segmentTypeSource']).', ';
	echo '"description_segmentTypeRef":'.json_encode($row_JSON['description_segmentTypeRef']).', ';
	echo '"description_segmentTypeVersion":'.json_encode($row_JSON['description_segmentTypeVersion']).', ';
	echo '"description_segmentTypeAnnotation":'.json_encode($row_JSON['description_segmentTypeAnnotation']).', ';
	echo '"FormID":'.json_encode($row_JSON['FormID']).', ';
	echo '"coverage_S_LandmarkID":'.json_encode($row_JSON['coverage_S_LandmarkID']).', ';
	echo '"language":'.json_encode($row_JSON['language']).', ';
	echo '"_empty":'.json_encode($row_JSON['_empty']).' ';
	$numbercounter=$numbercounter+1;
	if ($numbercounter == $totalfound) {
	echo '}';
	}
	else {
	echo '},';
	}
	}
	echo "]}";

/****************  License **********************/
/*
The technology and most  of the code for this site was developed by Georg Kö 
( reads as Georg Koe in english) from 2011 to 2013 for the Project 
"Ephemeral Films:  National Socialism in Austria".
The technology and the code is available to be copied, distributed, transmited and adapted 
under the Creative  Commons License Attribution-NonCommercial-ShareAlike 2.0 Generic (CC BY-NC-SA 2.0)
See: http://creativecommons.org/licenses/by-nc-sa/2.0/
To comply with this license   agreement this license statement has to be attributed in any case of 
copying, distribution, transmission or adaption within the code and  Georg Kö (reads Georg Koe in english)
has to be publicly mentioned  particularly by name as its  inventor on any web site, in any publication or on the lable 
of any virtual or physical product resulting from copying, distributing, transmitting or adapting this code 
or the technological invention it represents.
*/
/**************** License  **********************/

	?>
