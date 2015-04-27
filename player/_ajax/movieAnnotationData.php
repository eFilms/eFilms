<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

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
session_start();
$moviefps = preg_replace("/[^0-9]/", "", $_GET['movieSpeed']);
$movietid = preg_replace("/[^0-9]/", "", $_GET['movieID']);
$language = (isset($_COOKIE["language"]) ? $_COOKIE["language"] : "en");

?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="/_js/jQTableFilter/picnet.table.filter.min.js"></script>
<?php 
require_once('/settings.php');
require_once('/includes/functions.php');
require_once(directoryAboveWebRoot().'/db_con.php');

$anfrage_ML = "SELECT FormID,ID_Annotations,AnnotationType_L3,startTime,endTime,ID_Movies,eF_FILM_ID,coverage,coverage_S_Geoname,coverage_S_Longitude,coverage_S_Latitude,coverage_T_From,coverage_T_To,subject_P_PersonName,subject_O_OrganizationName,subject_HE_Title,subject_HE_Date,language,description FROM eFilm_Content_Movies_Annotations WHERE ID_Movies='".$movietid."' AND AnnotationType_L2 != 'Numbering' AND AnnotationType_L1 != 'Relation' ORDER BY startTime ASC, endTime ASC;";
$ergebnis_ML = mysqli_query($localDatabase,$anfrage_ML); 
$trefferzahl_ML=mysqli_num_rows($ergebnis_ML);

switch ($language) {
    case "de":
        $typeTH = "Typ";
        $InhaltTH = "Inhalt";
        $PlayTH = "Play";
        break;
    default:
        $typeTH = "Type";
        $InhaltTH = "Content";
        $PlayTH = "Play";
        break;
}
	
echo "<table class=\"eFATableMini\" id=\"eFATableListMini\" data-anoncount=\"".$trefferzahl_ML."\"><thead><tr><th class='eFTabTHL3Mini' filter-type='ddl'>".$typeTH."</th><th class='eFTabTHContentMini'>".$InhaltTH."</th><th class='eFTabTHUMini' filter='false'>".$PlayTH."</th></tr></thead><tbody>";
	
while ($row2 = mysqli_fetch_array($ergebnis_ML)) {
    if ($row2['AnnotationType_L1'] == 'Relation') {
            echo "";
    } else {
        $eFTableStart = "<tr class='".$row2['FormID']."Class' name='".$row2['ID_Annotations']."' data-recordid='".$row2['ID_Annotations']."' data-formid='".$row2['FormID']."'>
                                        <td class='".$row2['FormID']."Class eFTabCellL3Mini'>".$row2['AnnotationType_L3']."</td>";
        $eFTableEnd = "<td class='".$row2['FormID']."Class eFTabCellPlayMini' data-start='".$row2['startTime']."' data-stop='".$row2['endTime']."' data-movieid='".$row2['ID_Movies']."' data-moviesig='".$row2['eF_FILM_ID']."'><img src='/images/controls/play.svg' height='12' width='12'></td></tr>";
        $userannotationextra = "";
        switch ($row2['FormID']) {
            case "eFSCDLocationN":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['coverage']."</td>".$eFTableEnd;
                break;					
            case "eFSCDLocationG":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['coverage_S_Geoname']."<br/>Lon:".$row2['coverage_S_Longitude']."<br/>Lat:".$row2['coverage_S_Latitude']."</td>".$eFTableEnd;
                break;
            case "eFSCDLandmark":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['coverage']."<br/></td>".$eFTableEnd;
                break;
            case "eFSCDDate":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>From: ".$row2['coverage_T_From']."<br/>To: ".$row2['coverage_T_To']."</td>".$eFTableEnd;
                break;
            case "eFSCDPerson":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['subject_P_PersonName']."</td>".$eFTableEnd;
                break;
            case "eFSCDOrganisation":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['subject_O_OrganizationName']."</td>".$eFTableEnd;
                break;
            case "eFSCDHistoricEvent":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['subject_HE_Title']."<br/>(".$row2['subject_HE_Date'].")</td>".$eFTableEnd;
                break;
            case "eFSCSLanguage":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['language']."</td>".$eFTableEnd;
                break;
            case "eFSCSSpacialType":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['description']."</td>".$eFTableEnd;
                break;
            case "eFSCSSpacialUse":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['description']."</td>".$eFTableEnd;
                break;
            case "eFSCSPersonsNumber":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['description']."</td>".$eFTableEnd;
                break;
            case "eFSCSPersonsGender":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['description']."</td>".$eFTableEnd;
                break;
            case "eFSCSPersonsAge":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['description']."</td>".$eFTableEnd;
                break;
            case "eFSCSPersonsAction":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['description']."</td>".$eFTableEnd;
                break;
            case "eFSCSVisualEventType":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['description']."</td>".$eFTableEnd;
                break;
            case "eFSCSVisualEvent":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['description']."</td>".$eFTableEnd;
                break;
            case "eFSCSAudioEventType":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['description']."</td>".$eFTableEnd;
                break;
            case "eFSCSAudioEvent":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['description']."</td>".$eFTableEnd;
                break;
            case "eFSCSIntertitleTranscript":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['description']."</td>".$eFTableEnd;
                break;
            case "eFSCSWrittenElementsTranscript":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['description']."</td>".$eFTableEnd;
                break;
            case "eFSCSWrittenElementsLanguage":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['description']."</td>".$eFTableEnd;
                break;
            case "eFSCSPunctum":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['description']."</td>".$eFTableEnd;
                break;
            case "eFSCSShotType":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['description']."</td>".$eFTableEnd;
                break;
            case "eFSCSCameraPosition":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['description']."</td>".$eFTableEnd;
                break;
            case "eFSCSEditing":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['description']."</td>".$eFTableEnd;
                break;
            case "eFSCSAmateurFilmCharacteristics":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['description']."</td>".$eFTableEnd;
                break;
            case "eFSCSIntention":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['description']."</td>".$eFTableEnd;
                break;
            case "eFSCSEducationalRemarks":
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'>".$row2['description']."</td>".$eFTableEnd;
                break;
            default:
                echo $eFTableStart."<td class='".$row2['FormID']."Class eFTabCellContent'></td>".$eFTableEnd;
        }
    }
}
	?>
<script type="text/javascript">
$('#eFATableListMini').tableFilter();
</script>
	</tbody>
</table>
