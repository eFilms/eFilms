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

# test.php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors','On');
$movieid = (isset($_GET['MovieID']) ? $_GET['MovieID'] : "");
$moviefps = (isset($_GET['fps']) ? $_GET['fps'] : "");
$movietid = (isset($_GET['TID']) ? $_GET['TID'] : "");

?>
<style>
.pickerSelected {
    color: rgb(79, 109, 145);
}
.pickerSelected:hover {
    color: #699ad6;
}
.pickerUnselected {
    color: #cccccc;
}
.pickerUnselected:hover {
    color: #699ad6;
}
</style>
<script type="text/javascript">
$(document).ready(function () {
    $('.eFTabCellStill img').click(function(){
        $('#eFAFormIN').val($(this).parent().prev().prev().html());
        $('#eFAFormOUT').val($(this).parent().prev().html());
    });
    $('.eFTabCellIN').click(function(){
        var SeekPoint = parseInt($(this).html());
        var fps = parseInt($('#efMCVMovieFPS').html());
        var diepositiontTA = ((1/fps)*(SeekPoint)) + ((1/fps)/2);
        video.seek(diepositiontTA);
    });
    $('.eFTabCellOUT').click(function(){
        var SeekPoint = parseInt($(this).html());
        var fps = parseInt($('#efMCVMovieFPS').html());
        var diepositiontTA = ((1/fps)*(SeekPoint)) + ((1/fps)/2);
        video.seek(diepositiontTA);
    });
	
    //layout für View verändern
    var viewvaranonlist = $(document).find('#eFMovieMovieID').attr('data-ur');
    if ( viewvaranonlist == "VIEW" ) {
        $('#eFMovieAnnotationsContainerANList').css('top','55px');
        $('#eFMovieAnnotationsContainerINOUT').css('border-bottom-left-radius','0px');
    }
    else {
        $('#eFMovieAnnotationsContainerANList').removeAttr('style');
        $('#eFMovieAnnotationsContainerINOUT').removeAttr('style');
    }
});

function inArray(item, array) {
  for (var i = 0; i < array.length; i++) {
      if (array[i] === item) {
          return i;
      }
  }
  return -1;
}

function updateTable(id) {
    var category = id.substr(id.length-2);
    switch (category) {
        case "L1":
            var arrayIndex = inArray(id,selectedL1Values);
            if (arrayIndex > -1) {
              selectedL1Values.splice(arrayIndex,1);
            } else {
              selectedL1Values.push(id);
            }
            break;
        case "L2":
            var arrayIndex = inArray(id,selectedL2Values);
            if (arrayIndex > -1) {
              selectedL2Values.splice(arrayIndex,1);
            } else {
              selectedL2Values.push(id);
            }
            break;
        case "L3":
            var arrayIndex = inArray(id,selectedL3Values);
            if (arrayIndex > -1) {
              selectedL3Values.splice(arrayIndex,1);
            } else {
              selectedL3Values.push(id);
            }
            break;
        case "rs":
            // Users
            var arrayIndex = inArray(id,selectedUserValues);
            if (arrayIndex > -1) {
              selectedUserValues.splice(arrayIndex,1);
            } else {
              selectedUserValues.push(id);
            }
            break;
    }
    // Update L1 List
    if (document.getElementById('L1choiceBox').innerHTML != '') {
        if (selectedL1Values.length > 0) {
            for (var i = 0; i < choicesL1.length; ++i) {
                if (inArray(choicesL1[i]+"L1", selectedL1Values) < 0) {
                    // not in our picks
                    document.getElementById(choicesL1[i]+"L1").innerHTML = choicesL1[i];
                    document.getElementById(choicesL1[i]+"L1").className = 'pickerUnselected';
                } else {
                    // in our picks
                    document.getElementById(choicesL1[i]+"L1").innerHTML = '&#x2713; '+choicesL1[i];
                    document.getElementById(choicesL1[i]+"L1").className = 'pickerSelected';
                }
            }
        } else {
            for (var i = 0; i < choicesL1.length; ++i) {
                document.getElementById(choicesL1[i]+"L1").innerHTML = '&#x2713; '+choicesL1[i];
                document.getElementById(choicesL1[i]+"L1").className = 'pickerSelected';
            }
        }
    }
    // Update L2 List
    if (document.getElementById('L2choiceBox').innerHTML != '') {
        if (selectedL2Values.length > 0) {
            for (var i = 0; i < choicesL2.length; ++i) {
                if (inArray(choicesL2[i]+"L2", selectedL2Values) < 0) {
                    // not in our picks
                    document.getElementById(choicesL2[i]+"L2").innerHTML = choicesL2[i];
                    document.getElementById(choicesL2[i]+"L2").className = 'pickerUnselected';
                } else {
                    // in our picks
                    document.getElementById(choicesL2[i]+"L2").innerHTML = '&#x2713; '+choicesL2[i];
                    document.getElementById(choicesL2[i]+"L2").className = 'pickerSelected';
                }
            }
        } else {
            for (var i = 0; i < choicesL2.length; ++i) {
                document.getElementById(choicesL2[i]+"L2").innerHTML = '&#x2713; '+choicesL2[i];
                document.getElementById(choicesL2[i]+"L2").className = 'pickerSelected';
            }
        }
    }
    // Update L3 List
    if (document.getElementById('L3choiceBox').innerHTML != '') {
        if (selectedL3Values.length > 0) {
            for (var i = 0; i < choicesL3.length; ++i) {
                if (inArray(choicesL3[i]+"L3", selectedL3Values) < 0) {
                    // not in our picks
                    document.getElementById(choicesL3[i]+"L3").innerHTML = choicesL3[i];
                    document.getElementById(choicesL3[i]+"L3").className = 'pickerUnselected';
                } else {
                    // in our picks
                    document.getElementById(choicesL3[i]+"L3").innerHTML = '&#x2713; '+choicesL3[i];
                    document.getElementById(choicesL3[i]+"L3").className = 'pickerSelected';
                }
            }
        } else {
            for (var i = 0; i < choicesL3.length; ++i) {
                document.getElementById(choicesL3[i]+"L3").innerHTML = '&#x2713; '+choicesL3[i];
                document.getElementById(choicesL3[i]+"L3").className = 'pickerSelected';
            }
        }
    }
    // Update User List
    if (document.getElementById('UserChoiceBox').innerHTML != '') {
        if (selectedUserValues.length > 0) {
            for (var i = 0; i < choicesUsers.length; ++i) {
                if (inArray(choicesUsers[i]+"Users", selectedUserValues) < 0) {
                    // not in our picks
                    document.getElementById(choicesUsers[i]+"Users").innerHTML = choicesUsers[i];
                    document.getElementById(choicesUsers[i]+"Users").className = 'pickerUnselected';
                } else {
                    // in our picks
                    document.getElementById(choicesUsers[i]+"Users").innerHTML = '&#x2713; '+choicesUsers[i];
                    document.getElementById(choicesUsers[i]+"Users").className = 'pickerSelected';
                }
            }
        } else {
            for (var i = 0; i < choicesUsers.length; ++i) {
                document.getElementById(choicesUsers[i]+"Users").innerHTML = '&#x2713; '+choicesUsers[i];
                document.getElementById(choicesUsers[i]+"Users").className = 'pickerSelected';
            }
        }
    }
          
    // Sort Annotations
    var annotationArray = document.getElementById('tableBody').getElementsByTagName('tr');
    for (var i = 0; i < annotationArray.length; ++i) {
        var L1value = document.getElementById('annotation'+i+'L1').innerHTML+"L1";
        var L2value = document.getElementById('annotation'+i+'L2').innerHTML+"L2";
        var L3value = document.getElementById('annotation'+i+'L3').innerHTML+"L3";
        var Uservalue = document.getElementById('annotation'+i+'User').innerHTML+"Users";
        var StartTime = Math.floor(document.getElementById('annotation'+i+'startTime').innerHTML);
        var filterStartTime = Math.floor(document.getElementById('startTime').value);
        var EndTime = Math.floor(document.getElementById('annotation'+i+'endTime').innerHTML);
        var filterEndTime = Math.floor(document.getElementById('endTime').value);
        var Content = document.getElementById('annotation'+i+'Content').innerHTML;
        var filterContent = document.getElementById('filterContent').value;
        if ((inArray(L1value, selectedL1Values) >= 0 || selectedL1Values.length == 0 || selectedL1Values.length == choicesL1.length)
                && (inArray(L2value, selectedL2Values) >= 0 || selectedL2Values.length == 0 || selectedL2Values.length == choicesL2.length)
                && (inArray(L3value, selectedL3Values) >= 0 || selectedL3Values.length == 0 || selectedL3Values.length == choicesL3.length)
                && (inArray(Uservalue, selectedUserValues) >= 0 || selectedUserValues.length == 0 || selectedUserValues.length == choicesUsers.length)
                && (filterStartTime == '' || StartTime >= filterStartTime)
                && (filterEndTime == '' || EndTime <= filterEndTime)
                && (filterContent == '' || Content.indexOf(filterContent) > -1)) {
          annotationArray[i].style.display = 'block';
        } else {
          annotationArray[i].style.display = 'none';
        }
    }
}

var selectedL1Values = [];
function showL1choices() {
    document.getElementById('L1choiceBox').style.display = 'block';
    if (document.getElementById('L1choiceBox').innerHTML == '') {
        var choices = '';
        for (var i = 0; i < choicesL1.length; ++i) {
            choices += '<a id="'+choicesL1[i]+'L1" style="text-decoration: none;" onclick="updateTable(this.id); false;">'+choicesL1[i]+'</a><br>';
        }
        choices += '<div style="position: absolute; top: -6px; left: -6px; border-radius: 8px; height: 10px; width: 10px; padding: 2px; background-color: #fff; text-align: center; border: 1px solid #6C6C6C; cursor: pointer; font-size: 10px;" onclick="document.getElementById(\'L1choiceBox\').style.display = \'none\'; false;">X</a>';
        document.getElementById('L1choiceBox').innerHTML = choices;
    }
}

var selectedL2Values = [];
function showL2choices() {
    document.getElementById('L2choiceBox').style.display = 'block';
    if (document.getElementById('L2choiceBox').innerHTML == '') {
        var choices = '';
        for (var i = 0; i < choicesL2.length; ++i) {
            choices += '<a id="'+choicesL2[i]+'L2" style="text-decoration: none;" onclick="updateTable(this.id); false;">'+choicesL2[i]+'</a><br>';
        }
        choices += '<div style="position: absolute; top: -6px; left: -6px; border-radius: 8px; height: 10px; width: 10px; padding: 2px; background-color: #fff; text-align: center; border: 1px solid #6C6C6C; cursor: pointer; font-size: 10px;" onclick="document.getElementById(\'L2choiceBox\').style.display = \'none\'; false;">X</a>';
        document.getElementById('L2choiceBox').innerHTML = choices;
    }
}

var selectedL3Values = [];
function showL3choices() {
    document.getElementById('L3choiceBox').style.display = 'block';
    if (document.getElementById('L3choiceBox').innerHTML == '') {
        var choices = '';
        for (var i = 0; i < choicesL3.length; ++i) {
            choices += '<a id="'+choicesL3[i]+'L3" style="text-decoration: none;" onclick="updateTable(this.id); false;">'+choicesL3[i]+'</a><br>';
        }
        choices += '<div style="position: absolute; top: -6px; left: -6px; border-radius: 8px; height: 10px; width: 10px; padding: 2px; background-color: #fff; text-align: center; border: 1px solid #6C6C6C; cursor: pointer; font-size: 10px;" onclick="document.getElementById(\'L3choiceBox\').style.display = \'none\'; false;">X</a>';
        document.getElementById('L3choiceBox').innerHTML = choices;
    }
}

var selectedUserValues = [];
function showUserChoices() {
    document.getElementById('UserChoiceBox').style.display = 'block';
    if (document.getElementById('UserChoiceBox').innerHTML == '') {
        var choices = '';
        for (var i = 0; i < choicesUsers.length; ++i) {
            choices += '<a id="'+choicesUsers[i]+'Users" style="text-decoration: none;" onclick="updateTable(this.id); false;">'+choicesUsers[i]+'</a><br>';
        }
        choices += '<div style="position: absolute; top: -6px; right: -6px; border-radius: 8px; height: 10px; width: 10px; padding: 2px; background-color: #fff; text-align: center; border: 1px solid #6C6C6C; cursor: pointer; font-size: 10px;" onclick="document.getElementById(\'UserChoiceBox\').style.display = \'none\'; false;">X</a>';
        document.getElementById('UserChoiceBox').innerHTML = choices;
    }
}
</script>


<?php

$anfrage_ML = "SELECT * FROM eFilm_Content_Movies_Annotations WHERE ID_Movies='".$movietid."' ORDER BY startTime DESC, endTime DESC;";
$ergebnis_ML = mysqli_query($localDatabase, $anfrage_ML); 
$trefferzahl_ML=mysqli_num_rows($ergebnis_ML);

$anfrage_foundeFSCSReelNumbers = "SELECT `ID_Annotations` FROM eFilm_Content_Movies_Annotations WHERE ID_Movies='".$movietid."' AND FormID='eFSCSReelNumber';";
$ergebnis_foundeFSCSReelNumbers = mysqli_query($localDatabase, $anfrage_foundeFSCSReelNumbers); 
$foundeFSCSReelNumbers = mysqli_num_rows($ergebnis_foundeFSCSReelNumbers);

$anfrage_foundeFSCSSequenceNumbers = "SELECT `ID_Annotations` FROM eFilm_Content_Movies_Annotations WHERE ID_Movies='".$movietid."' AND FormID='eFSCSSequenceNumber';";
$ergebnis_foundeFSCSSequenceNumbers = mysqli_query($localDatabase, $anfrage_foundeFSCSSequenceNumbers); 
$foundeFSCSSequenceNumbers=mysqli_num_rows($ergebnis_foundeFSCSSequenceNumbers);

$anfrage_foundeFSCSSceneNumbers = "SELECT `ID_Annotations` FROM eFilm_Content_Movies_Annotations WHERE ID_Movies='".$movietid."' AND FormID='eFSCSSceneNumber';";
$ergebnis_foundeFSCSSceneNumbers = mysqli_query($localDatabase, $anfrage_foundeFSCSSceneNumbers); 
$foundeFSCSSceneNumbers=mysqli_num_rows($ergebnis_foundeFSCSSceneNumbers);

$anfrage_foundeFSCSShotNumbers = "SELECT `ID_Annotations` FROM eFilm_Content_Movies_Annotations WHERE ID_Movies='".$movietid."' AND FormID='eFSCSShotNumber';";
$ergebnis_foundeFSCSShotNumbers = mysqli_query($localDatabase, $anfrage_foundeFSCSShotNumbers); 
$foundeFSCSShotNumbers=mysqli_num_rows($ergebnis_foundeFSCSShotNumbers);

// populate the selections via JavaScript
$query = "SELECT DISTINCT `AnnotationType_L1` FROM `eFilm_Content_Movies_Annotations` WHERE `ID_Movies` = '".$movietid."'";
$myQuery = mysqli_query($localDatabase, $query);
while ($item = mysqli_fetch_array($myQuery,MYSQLI_ASSOC)) { // Must specify associate because default is 'both'
    $results[] = $item;
}
echo "<script>\n";
echo "var choicesL1 = [";
for ($i = 0; $i < count($results); $i++) {
    echo "'".$results[$i]['AnnotationType_L1']."'";
    if ($i < (count($results) - 1)) {
        echo ",";
    }
}
echo "];\n";
echo "choicesL1.sort();\n";
echo "</script>\n";
unset($results);
$query = "SELECT DISTINCT `AnnotationType_L2` FROM `eFilm_Content_Movies_Annotations` WHERE `ID_Movies` = '".$movietid."'";
$myQuery = mysqli_query($localDatabase, $query);
while ($item = mysqli_fetch_array($myQuery,MYSQLI_ASSOC)) { // Must specify associate because default is 'both'
    $results[] = $item;
}
echo "<script>\n";
echo "var choicesL2 = [";
for ($i = 0; $i < count($results); $i++) {
    echo "'".$results[$i]['AnnotationType_L2']."'";
    if ($i < (count($results) - 1)) {
        echo ",";
    }
}
echo "];\n";
echo "choicesL2.sort();\n";
echo "</script>\n";
unset($results);
$query = "SELECT DISTINCT `AnnotationType_L3` FROM `eFilm_Content_Movies_Annotations` WHERE `ID_Movies` = '".$movietid."'";
$myQuery = mysqli_query($localDatabase, $query);
while ($item = mysqli_fetch_array($myQuery,MYSQLI_ASSOC)) { // Must specify associate because default is 'both'
    $results[] = $item;
}
echo "<script>\n";
echo "var choicesL3 = [";
for ($i = 0; $i < count($results); $i++) {
    echo "'".$results[$i]['AnnotationType_L3']."'";
    if ($i < (count($results) - 1)) {
        echo ",";
    }
}
echo "];\n";
echo "choicesL3.sort();\n";
echo "</script>\n";
unset($results);
$query = "SELECT DISTINCT `_USER_INPUT` FROM `eFilm_Content_Movies_Annotations` WHERE `ID_Movies` = '".$movietid."'";
$myQuery = mysqli_query($localDatabase, $query);
while ($item = mysqli_fetch_array($myQuery,MYSQLI_ASSOC)) { // Must specify associate because default is 'both'
    $results[] = $item;
}
echo "<script>\n";
echo "var choicesUsers = [";
for ($i = 0; $i < count($results); $i++) {
    echo "'".$results[$i]['_USER_INPUT']."'";
    if ($i < (count($results) - 1)) {
        echo ",";
    }
}
echo "];\n";
echo "choicesUsers.sort();\n";
echo "</script>\n";
unset($results);

// Build table
echo "<table class=\"eFATable\" id=\"eFATableList\" data-anoncount=\"".$trefferzahl_ML."\">
    <thead>
        <tr>
                <th class='eFTabTHIN'>IN</th>
                <th class='eFTabTHOUT'>OUT</th>
                <th class='eFTabTHStill'>Still</th>
                <th class='eFTabTHL1'>L1</th>
                <th class='eFTabTHL2'>L2</th>
                <th class='eFTabTHL3'>L3</th>
                <th class='eFTabTHContent'>Content</th>
                <th class='eFTabTHU'>U</th>
                <th class='eFTabTHE'>E</th>
                <th class='eFTabTHD'>D</th>
        </tr>";
echo "        <tr>
            <td>
                <input type='text' id='startTime' onkeyup='updateTable(this.id); false;' style='width: 95%;'>
            </td>
            <td>
                <input type='text' id='endTime' onkeyup='updateTable(this.id); false;' style='width: 95%;'>
            </td>
            <td>&nbsp;</td>
            <td>
                <select id='filterL1' onclick='showL1choices();' style='width: 95%;'></select>\n";
echo "<div id='L1choiceBox' style='position: absolute; top: 26px; left: 142px; padding: 10px; z-index: 4000000; background-color: #fff; display: none; border: 1px solid #c6c6c6; text-align: left;'></div>\n";
echo "            </td>
            <td>
                <select id='filterL2' onclick='showL2choices();' style='width: 95%;'></select>\n";
echo "<div id='L2choiceBox' style='position: absolute; top: 26px; left: 209px; padding: 10px; z-index: 4000000; background-color: #fff; display: none; border: 1px solid #c6c6c6; text-align: left;'></div>\n";
echo "            </td>
            <td>
                <select id='filterL3' onclick='showL3choices();' style='width: 95%;'></select>\n";
echo "<div id='L3choiceBox' style='position: absolute; top: 26px; left: 275px; padding: 10px; z-index: 4000000; background-color: #fff; display: none; border: 1px solid #c6c6c6; text-align: left;'></div>\n";
echo "            </td>
            <td>
                <input type='text' id='filterContent' onkeyup='updateTable(this.id); false;' style='width: 95%;'>
            </td>
            <td>
                <select id='filterUser' onclick='showUserChoices();' style='width: 95%;'></select>\n";
echo "<div id='UserChoiceBox' style='position: absolute; top: 26px; right: 49px; padding: 10px; z-index: 4000000; background-color: #fff; display: none; border: 1px solid #c6c6c6; text-align: left;'></div>\n";
echo "            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>";
echo "
    </thead>
<tbody id='tableBody'>";	
	
$i = 0;
while ($row2 = mysqli_fetch_array($ergebnis_ML)) {

    $eFTableStart = "<tr class='".$row2['FormID']."Class' name='".$row2['ID_Annotations']."' data-recordid='".$row2['ID_Annotations']."' data-formid='".$row2['FormID']."'>
        <td id='annotation".$i."startTime' class='".$row2['FormID']."Class eFTabCellIN'>".$row2['startTime']."</td>
        <td id='annotation".$i."endTime' class='".$row2['FormID']."Class eFTabCellOUT'>".$row2['endTime']."</td>
        <td class='".$row2['FormID']."Class eFTabCellStill'><img src='".$storeURL."/_media/shots/".$row2['eF_FILM_ID']."/".sprintf ("%06d", $row2['startTime']).".jpg' width='48' height='36' alt='Frame Number ".sprintf ("%06d", $row2['startTime'])."' /></td>
        <td id='annotation".$i."L1' class='".$row2['FormID']."Class eFTabCellL1'>".$row2['AnnotationType_L1']."</td>
        <td id='annotation".$i."L2' class='".$row2['FormID']."Class eFTabCellL2'>".$row2['AnnotationType_L2']."</td>
        <td id='annotation".$i."L3' class='".$row2['FormID']."Class eFTabCellL3'>".$row2['AnnotationType_L3']."</td>";

    $eFTableEnd = "<td id='annotation".$i."User' class='".$row2['FormID']."Class eFTabCellUser'>".$row2['_USER_INPUT']."</td>
        <td class='".$row2['FormID']."Class eFTabCellEdit' title='Edit'>E</td>
        <td class='".$row2['FormID']."Class eFTabCellDelete' title='Delete'>D</td>
        </tr>";
    
    $userannotationextra = "";
    if (empty($row2['researchLog'])) {
        $notes = "Notes: ";
    } else {
        $notes = "Notes: ".$row2['researchLog'];
    }
    switch ($row2['FormID']) {
        case "eFSCDLocationN":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['coverage']."</td>".$eFTableEnd;
            break;					
        case "eFSCDLocationG":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>
                    Geoname:<br/>".$row2['coverage_S_Geoname']."<br/>
                    Longitude:<br/>".$row2['coverage_S_Longitude']."<br />
                    Latitude:<br/>".$row2['coverage_S_Latitude']."</td>".$eFTableEnd;
            break;
        case "eFSCDLandmark":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>
                    Name:<br/>".$row2['coverage']."<br/>
                    ID:<br/>".$row2['coverage_S_LandmarkID']."
                    </td>".$eFTableEnd;
            break;
        case "eFSCDDate":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>From: ".$row2['coverage_T_From']."<br/>To: ".$row2['coverage_T_To']."</td>".$eFTableEnd;
            break;
        case "eFSCDPerson":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>
                    Name:<br/>".$row2['subject_P_PersonName']."<br/>
                    ID:<br/>".$row2['subject_P_PersonID']."<br/>
                    </td>".$eFTableEnd;
            break;
        case "eFSCDOrganisation":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>
                    Type:<br/>".$row2['subject_O_OrganizationType']."<br/>
                    Name:<br/>".$row2['subject_O_OrganizationName']."<br/>
                    ID:<br/>".$row2['subject_O_OrganizationID']."
                    </td>".$eFTableEnd;
            break;
        case "eFSCDHistoricEvent":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>
                    Title:<br/>".$row2['subject_HE_Title']."<br/>
                    Date:<br/>".$row2['subject_HE_Date']."<br/>
                    Type:<br/>".$row2['subject_HE_Type']."<br/>
                    ID:<br/>".$row2['subject_HE_ID']."
                    </td>".$eFTableEnd;
            break;
        case "eFSCSLanguage":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['language']."</td>".$eFTableEnd;
            break;
        case "eFSCSRelation":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>Medium:<br/>".str_replace("_", " ", $row2['relation'])."<br/>
                    Identifier:<br/>".$row2['relation_relationIdentifier']."<br/>
                    From:<br/>".$row2['relation_relationIdentifier_from']."<br/>
                    To:<br/>".$row2['relation_relationIdentifier_to']."<br/>
                    </td>".$eFTableEnd;
            break;
        case "eFSCSSequenceNumber":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$foundeFSCSSequenceNumbers."</td>".$eFTableEnd;
            $foundeFSCSSequenceNumbers = $foundeFSCSSequenceNumbers -1;
            break;
        case "eFSCSSceneNumber":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$foundeFSCSSceneNumbers."</td>".$eFTableEnd;
            $foundeFSCSSceneNumbers = $foundeFSCSSceneNumbers -1;
            break;
        case "eFSCSShotNumber":
            if ($row2['annotation']) {
                $userannotationextra = "<br/>Annotation: ".$row2['annotation'];
            }
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$foundeFSCSShotNumbers.$userannotationextra."</td>".$eFTableEnd;
            $foundeFSCSShotNumbers = $foundeFSCSShotNumbers -1;
            break;
        case "eFSCSReelNumber":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$foundeFSCSReelNumbers."</td>".$eFTableEnd;
            $foundeFSCSReelNumbers = $foundeFSCSReelNumbers -1;
            break;
        case "eFSCSSpacialType":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['description']."</td>".$eFTableEnd;
            break;
        case "eFSCSSpacialUse":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['description']."</td>".$eFTableEnd;
            break;
        case "eFSCSPersonsNumber":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['description']."</td>".$eFTableEnd;
            break;
        case "eFSCSPersonsGender":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['description']."</td>".$eFTableEnd;
            break;
        case "eFSCSPersonsAge":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['description']."</td>".$eFTableEnd;
            break;
        case "eFSCSPersonsAction":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['description']."</td>".$eFTableEnd;
            break;
        case "eFSCSVisualEventType":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['description']."</td>".$eFTableEnd;
            break;
        case "eFSCSVisualEvent":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['description']."</td>".$eFTableEnd;
            break;
        case "eFSCSAudioEventType":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['description']."</td>".$eFTableEnd;
            break;
        case "eFSCSAudioEvent":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['description']."</td>".$eFTableEnd;
            break;
        case "eFSCSIntertitleTranscript":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['description']."</td>".$eFTableEnd;
            break;
        case "eFSCSWrittenElementsTranscript":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['description']."</td>".$eFTableEnd;
            break;
        case "eFSCSWrittenElementsLanguage":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['description']."</td>".$eFTableEnd;
            break;
        case "eFSCSPunctum":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['description']."</td>".$eFTableEnd;
            break;
        case "eFSCSShotType":
            if ($row2['annotation']) {
                $userannotationextra = "<br/>Annotation: ".$row2['annotation'];
            }
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['description'].$userannotationextra."</td>".$eFTableEnd;
            break;
        case "eFSCSCameraPosition":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['description']."</td>".$eFTableEnd;
            break;
        case "eFSCSEditing":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['description']."</td>".$eFTableEnd;
            break;
        case "eFSCSAmateurFilmCharacteristics":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['description']."</td>".$eFTableEnd;
            break;
        case "eFSCSIntention":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['description']."</td>".$eFTableEnd;
            break;
        case "eFSCSEducationalRemarks":
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'>".$row2['description']."</td>".$eFTableEnd;
            break;
        default:
            echo $eFTableStart."<td id='annotation".$i."Content' class='".$row2['FormID']."Class eFTabCellContent' title='$notes'></td>".$eFTableEnd;
    }
    $i++;
}

echo "        </tbody>\n";
echo "</table>\n";