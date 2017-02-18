<?php

if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION["login"] != "true") {
    header("Location:login.php");
    $_SESSION["error"] = "<h1 style='color:red;'>You don't have privileges to see this page.</h1>";
    exit;
}

require_once('../settings.php');
require_once('../includes/functions.php');
require_once(directoryAboveWebRoot().'/db_con.php');

$eFContentSelected = (isset($_GET['eFContentSelected']) ? $_GET['eFContentSelected'] : "");
$eFContentKat = (isset($_GET['eFContentKat']) ? $_GET['eFContentKat'] : "");
$uniquid = (isset($_GET['uniquid']) ? $_GET['uniquid'] : "");

switch ($eFContentKat) {
// Movies ///////////////////////////////////////////////////////////////////////////////////
    case 'Movies':
        // This is where the movie relationships form would exist

        break;
// Coverage /////////////////////////////////////////////////////////////////////////////////
    case 'Coverage':
        $eFShortM1 = "COV";
        switch ($eFContentSelected) {
            case 'Landmarks':
                $eFResourceSearchExtension = " WHERE eFilm_ReSources_L1.Category='Coverage' AND eFilm_ReSources_L1.Type='Landmark'";
                $resourcecontentclass = "eFResourcesContentZWEHUNDERTACHTZIG";
                $displaynew = "$('#eFResourcesNewObject').hide();";
                $topcontent = "<script  type='text/javascript'>\n";
                $topcontent .= "    function initmaps(){\n";
                $topcontent .= "        var latitude = 48.208727825206;\n";
                $topcontent .= "        var longitude = 16.372473763275;\n";
                $topcontent .= "        var proj4326 = new OpenLayers.Projection('EPSG:4326');\n";
                $topcontent .= "        var projmerc = new OpenLayers.Projection('EPSG:900913');\n";
                $topcontent .= "        var mapCenterPositionAsLonLat = new OpenLayers.LonLat(longitude, latitude);\n";
                $topcontent .= "        var mapCenterPositionAsMercator = mapCenterPositionAsLonLat.transform(proj4326, projmerc);\n";
                $topcontent .= "        var mapZoom = 13;\n";
                $topcontent .= "        osmMap = new OpenLayers.Map('eFResourcesContentTopContent', {\n";
                $topcontent .= "            controls: [\n";
                $topcontent .= "                new OpenLayers.Control.KeyboardDefaults(),\n";
                $topcontent .= "                 new OpenLayers.Control.Navigation(),\n";
                $topcontent .= "                 //new OpenLayers.Control.LayerSwitcher({'ascending':false}),\n";
                $topcontent .= "                new OpenLayers.Control.Zoom(),\n";
                $topcontent .= "                 new OpenLayers.Control.MousePosition()\n";
                $topcontent .= "            ],\n";
                $topcontent .= "            maxExtent:\n";
                $topcontent .= "                new OpenLayers.Bounds(-20037508.34, -20037508.34, 20037508.34, 20037508.34),\n";
                $topcontent .= "                numZoomLevels: 22,\n";
                $topcontent .= "                maxResolution: 156543,\n";
                $topcontent .= "                units: 'm',\n";
                $topcontent .= "                projection: projmerc,\n";
                $topcontent .= "                displayProjection: proj4326\n";
                $topcontent .= "            }\n";
                $topcontent .= "        );\n";
                $topcontent .= "        var osmLayer = new OpenLayers.Layer.OSM('OpenStreetMap');\n";
                $topcontent .= "        osmMap.addLayer(osmLayer);\n";
                $topcontent .= "        osmMap.setCenter(mapCenterPositionAsMercator, mapZoom);\n";
                $topcontent .= "        var locationPickerLayer = new OpenLayers.Layer.Vector('LocationPicker Marker');\n";
                $topcontent .= "        osmMap.addLayer(locationPickerLayer);\n";
                $topcontent .= "        var locationPickerPoint = new OpenLayers.Geometry.Point(mapCenterPositionAsMercator.lon, mapCenterPositionAsMercator.lat);\n";
                $topcontent .= "        var locationPickerMarkerStyle = {externalGraphic: '_img/mappointer.png', graphicHeight: 37, graphicWidth: 32, graphicYOffset: -37, graphicXOffset: -16 };\n";
                $topcontent .= "        var locationPickerVector = new OpenLayers.Feature.Vector(locationPickerPoint, null, locationPickerMarkerStyle);\n";
                $topcontent .= "        locationPickerLayer.addFeatures(locationPickerVector);\n";
                $topcontent .= "        var dragFeature = new OpenLayers.Control.DragFeature(locationPickerLayer, {\n";
                $topcontent .= "            onComplete: function( feature, pixel ) {\n";
                $topcontent .= "                var selectedPositionAsMercator = new OpenLayers.LonLat(locationPickerPoint.x, locationPickerPoint.y);\n";
                $topcontent .= "                var selectedPositionAsLonLat = selectedPositionAsMercator.transform(projmerc, proj4326);\n";
                $topcontent .= "                //$('#poiLatitude').val(selectedPositionAsLonLat.lat);\n";
                $topcontent .= "                //$('#poiLongitude').val(selectedPositionAsLonLat.lon);\n";
                $topcontent .= "                $('#eFResourcesContent').find('form[id=eFLPMRFormInput] input[name=Latitude]').val(selectedPositionAsLonLat.lat);\n";
                $topcontent .= "                $('#eFResourcesContent').find('form[id=eFLPMRFormInput] input[name=Longitude]').val(selectedPositionAsLonLat.lon);\n";
                $topcontent .= "                //Location Name von Google holen\n";
                $topcontent .= "                /* $.getJSON('http://maps.google.com/maps/api/geocode/json?address=' + selectedPositionAsLonLat.lat + ',' + selectedPositionAsLonLat.lon + '&sensor=false', function(data) { */\n";
                $topcontent .= "                $.getJSON('_ajax/eFEditorVFormTipGeoLocationNameGet.php?eFGeoLat=' + selectedPositionAsLonLat.lat + '&eFGeoLon=' + selectedPositionAsLonLat.lon, function(data) {\n";
                $topcontent .= "                    dataP = data.results;\n";
                $topcontent .= "                    dataPA = dataP[0];\n";
                $topcontent .= "                    //console.log(dataPA['formatted_address']);\n";
                $topcontent .= "                    //$('#poiAddress').val(dataPA['formatted_address']);\n";
                $topcontent .= "                    $('#eFResourcesContent').find('form[id=eFLPMRFormInput] input[name=Landmark_Geoname]').val(dataPA['formatted_address']);\n";
                $topcontent .= "                 }\n";
                $topcontent .= "                );\n";
                $topcontent .= "            }\n";
                $topcontent .= "         }\n";
                $topcontent .= "        );\n";
                $topcontent .= "        osmMap.addControl(dragFeature);\n";
                $topcontent .= "        dragFeature.activate();\n";
                $topcontent .= "    }\n";
                $topcontent .= "    initmaps();\n";
                $topcontent .= "</script>\n";
                $topcontent .= "<div id='eFResourcesContentTopContent'>\n";
                $topcontent .= "<div id='locationPickerMapResources'>\n";
                $topcontent .= "    <div id='locationPickerMapResourcesTitle'>Create Landmark</div>\n";
                $topcontent .= "    <form id='eFLPMRFormInput'>\n";
                $topcontent .= "    <div class='eFLPMRFormInput'><label for='Landmark_Name'>Landmark_Name</label><input type='text' name='Landmark_Name' value=''/></div>\n";
                $topcontent .= "    <div class='eFLPMRFormInput'><label for='Landmark_Geoname'>Landmark_Geoname</label><input type='text' name='Landmark_Geoname' value='' readonly='readonly'/></div>\n";
                $topcontent .= "    <div class='eFLPMRFormInput'><label for='Longitude'>Longitude</label><input type='text' name='Longitude' value='' readonly='readonly'/></div>\n";
                $topcontent .= "    <div class='eFLPMRFormInput'><label for='Latitude'>Latitude</label><input type='text' name='Latitude' value='' readonly='readonly'/></div>\n";
                $topcontent .= "    <div class='eFLPMRFormInput'><label for='Group'>Group</label><input type='text' name='Group' value=''/></div>\n";
                $topcontent .= "    <div id='locationPickerMapResourcesLandmarkAdd'>add</div>\n";
                $topcontent .= "    </form>\n";
                $topcontent .= "</div>\n";
                $topcontent .= "</div><div id='locationPickerMapResourcesLandmarkGroupTip'><div id='efResourceUnitNewContainerPopDownContent'></div><div id='efResourceUnitNewContainerPopDownClose'>close</div></div>";

                $eFShortM2 = "LAN";
                break;
        }
        break;
// Subject //////////////////////////////////////////////////////////////////////////////////
    case 'Subject':
        $eFShortM1 = "SUB";
        switch ($eFContentSelected) {
            case 'Persons':
                $eFResourceSearchExtension = " WHERE eFilm_ReSources_L1.Category='Subject' AND eFilm_ReSources_L1.Type='Person'";
                $resourcecontentclass = "eFResourcesContentNULL";
                $displaynew = "";
                $topcontent = "";
                $eFShortM2 = "PER";
                break;
            case 'Organisations':
                $eFResourceSearchExtension = " WHERE eFilm_ReSources_L1.Category='Subject' AND eFilm_ReSources_L1.Type='Organisation'";
                $resourcecontentclass = "eFResourcesContentNULL";
                $displaynew = "";
                $topcontent = "";
                $eFShortM2 = "ORG";
                break;
            case 'Historic Events':
                $eFResourceSearchExtension = " WHERE eFilm_ReSources_L1.Category='Subject' AND eFilm_ReSources_L1.Type='Historic Event'";
                $resourcecontentclass = "eFResourcesContentNULL";
                $displaynew = "";
                $topcontent = "";
                $eFShortM2 = "HEV";
                break;
        }
        break;
// Resource /////////////////////////////////////////////////////////////////////////////////
    case 'Resource':
        $eFShortM1 = "RES";
        switch ($eFContentSelected) {
            case 'Finding Aids':
                $eFResourceSearchExtension = " WHERE eFilm_ReSources_L1.Category='Resource' AND eFilm_ReSources_L1.Type='Finding Aid'";
                $resourcecontentclass = "eFResourcesContentNULL";
                $displaynew = "";
                $topcontent = "";
                $eFShortM2 = "FIA";
                break;
            case 'Archival Sources':
                $eFResourceSearchExtension = " WHERE eFilm_ReSources_L1.Category='Resource' AND eFilm_ReSources_L1.Type='Archival Source'";
                $resourcecontentclass = "eFResourcesContentNULL";
                $displaynew = "";
                $topcontent = "";
                $eFShortM2 = "ASO";
                break;
            case 'Publications':
                $eFResourceSearchExtension = " WHERE eFilm_ReSources_L1.Category='Resource' AND eFilm_ReSources_L1.Type='Publication'";
                $resourcecontentclass = "eFResourcesContentNULL";
                $displaynew = "";
                $topcontent = "";
                $eFShortM2 = "PUB";
                break;
            case 'Photos':
                $eFResourceSearchExtension = " WHERE eFilm_ReSources_L1.Category='Resource' AND eFilm_ReSources_L1.Type='Photo'";
                $resourcecontentclass = "eFResourcesContentNULL";
                $displaynew = "";
                $topcontent = "";
                $eFShortM2 = "PHO";
                break;
            case 'Other Documents':
                $eFResourceSearchExtension = " WHERE eFilm_ReSources_L1.Category='Resource' AND eFilm_ReSources_L1.Type='Other Document'";
                $resourcecontentclass = "eFResourcesContentNULL";
                $displaynew = "";
                $topcontent = "";
                $eFShortM2 = "OTD";
                break;
            case 'All Resources':
                $eFResourceSearchExtension = "";
                $resourcecontentclass = "eFResourcesContentNULL";
                $displaynew = "$('#eFResourcesNewObject').hide();";
                $topcontent = "";
                $eFShortM2 = "";
                break;
        }

        break;
}

if ($eFContentKat != 'Movies') {
    ///////////////////////////////////////////////////////////////////////////////////////////////////Resources
    echo '<script type="text/javascript">
                            $(document).ready(function () {
                                    $(".efResourceUnit2fieldcontent").editable("_ajax/eFEditorVResourcesContentSaveEdit.php", { 
                                            type      : "textarea",
                                            cancel    : "Cancel",
                                            submit    : "OK",
                                            indicator : "saving...",
                                            tooltip   : "Doubleclick to edit...",
                                    event     : "dblclick",
                                            cssclass  : "efResourceUnit2fieldcontentTextarea",
                                            width     : "99%",
                                            height    : "auto"
                                    });
                            ' . $displaynew . '
                            });  
                            </script>';
    ///////////////TOPCONTAINER
    echo $topcontent;
    ///////////////SUBCONTAINER
    echo "<div class='" . $resourcecontentclass . "'>";
    echo "<script>";
    echo "      function uploadGroup(id, value) {\n";
    echo "          var fd = new FormData();\n";
    echo "          fd.append(\"id\", id);\n";
    echo "          fd.append(\"group\", value);\n";
    echo "          var xhr = new XMLHttpRequest();\n";
    echo "          xhr.open(\"POST\", \"_ajax/changeGroupValue.php\");\n";
    echo "          xhr.send(fd);\n";
    echo "          alert('Group Changed');\n";
    echo "      }\n";
    echo "</script>";
    echo "<div id='efResourceUnitNewContainer'>
                    <div id='efResourceUnitNewContainerNewObject'>test</div>
                    <div id='efResourceUnitNewContainerClose'>X</div>
                    <div id='efResourceUnitNewContainerSave'  data-type='" . $eFContentSelected . "' data-category='" . $eFContentKat . "'>Save</div>
            </div>
            <div id='eFResourcesFilterContainer'>Filter: <input id='eFResourcesFilterInput' name='eFResourcesFilterInput' type='text' value='' data-filterregion='self'> Group: ";
    $anfrageGroup = "SELECT DISTINCT `Group` FROM eFilm_ReSources_L1 WHERE NOT `Group`='' ORDER BY `Group` ASC;";
    $ergebnisGroup = mysqli_query($localDatabase, $anfrageGroup);
    echo "<select  id='eFResourcesFilterGroup' name='eFResourcesFilterGroup'><option selected></option>";
    while ($row = mysqli_fetch_array($ergebnisGroup)) {
        echo "<option>" . $row['Group'] . "</option>";
    }
    echo "</select>";
    echo "</div><div id='eFResourcesNewObject' data-type='" . $eFContentSelected . "' data-category='" . $eFContentKat . "' data-eFShortM1='" . $eFShortM1 . "' data-eFShortM2='" . $eFShortM2 . "'>+</div>";
    echo "<div id='eFResourcesRelationAddContainer'></div>";
    echo "<div id='eFResourcesSubContent'>";

///////////////Relations-Arrays
    $anfrageR1 = "SELECT 
                     eFilm_ReSources_L1.*, eFilm_ReSources_RelationIndex.*
                    FROM eFilm_ReSources_RelationIndex
                    LEFT OUTER JOIN 
                    eFilm_ReSources_L1
                    ON 
                    eFilm_ReSources_RelationIndex.ID_R_L1_B = eFilm_ReSources_L1.ID_R_L1
                    ;";
    $ergebnisR1 = mysqli_query($localDatabase, $anfrageR1);
    $trefferzahlR1 = mysqli_num_rows($ergebnisR1);
    $RelationListingA = Array();
    while ($rowR1 = mysqli_fetch_array($ergebnisR1)) {
        //echo $rowR1['ID_R_RelationIndex']." | ".$rowR1['ID_R_L1_A']." | ".$rowR1['ID_R_L1_B']." || ".$rowR1['Type']." || ".$rowR1['Object_Key']." | ".$rowR1['RelationType']." | ".$rowR1['RelationRemark']."<br/>";
        $RelationListingA[] = array('ID_R_RelationIndex' => $rowR1['ID_R_RelationIndex'],
            'ID_R_L1_A' => $rowR1['ID_R_L1_A'],
            'content' => array(
                'ID_R_L1_A' => $rowR1['ID_R_L1_A'],
                'ID_R_L1_B' => $rowR1['ID_R_L1_B'],
                'Type' => $rowR1['Type'],
                'Object_Key' => $rowR1['Object_Key'],
                'RelationType' => $rowR1['RelationType'],
                'RelationRemark' => $rowR1['RelationRemark']
        ));
    }

    $anfrageR2 = "SELECT 
                     eFilm_ReSources_L1.*, eFilm_ReSources_RelationIndex.*
                    FROM eFilm_ReSources_RelationIndex
                    LEFT OUTER JOIN 
                    eFilm_ReSources_L1
                    ON 
                    eFilm_ReSources_RelationIndex.ID_R_L1_A = eFilm_ReSources_L1.ID_R_L1
                    ;";
    $ergebnisR2 = mysqli_query($localDatabase, $anfrageR2);
    $trefferzahlR2 = mysqli_num_rows($ergebnisR2);
    $RelationListingB = Array();
    while ($rowR2 = mysqli_fetch_array($ergebnisR2)) {
        //echo $rowR2['ID_R_RelationIndex']." | ".$rowR2['ID_R_L1_A']." | ".$rowR2['ID_R_L1_B']." || ".$rowR2['Type']." || ".$rowR2['Object_Key']." | ".$rowR2['RelationType']." | ".$rowR2['RelationRemark']."<br/>";
        $RelationListingB[] = array('ID_R_RelationIndex' => $rowR2['ID_R_RelationIndex'],
            'content' => array(
                'ID_R_L1_A' => $rowR2['ID_R_L1_A'],
                'ID_R_L1_B' => $rowR2['ID_R_L1_B'],
                'Type' => $rowR2['Type'],
                'Object_Key' => $rowR2['Object_Key'],
                'RelationType' => $rowR2['RelationType'],
                'RelationRemark' => $rowR2['RelationRemark']
        ));
    }

///////////////Content-Array
    $anfrage = "SELECT 
                     eFilm_ReSources_L1.*, eFilm_ReSources_L2.*
                    FROM eFilm_ReSources_L2
                    LEFT OUTER JOIN 
                    eFilm_ReSources_L1
                    ON 
                    eFilm_ReSources_L1.ID_R_L1 = eFilm_ReSources_L2.ID_R_L1
                    " . $eFResourceSearchExtension . " ORDER BY eFilm_ReSources_L2.ID_R_L2 ASC;";
    $ergebnis = mysqli_query($localDatabase, $anfrage);
    $trefferzahl = mysqli_num_rows($ergebnis);
    $listing = Array();
    while ($row = mysqli_fetch_array($ergebnis)) {
        $listing[] = array('ID' => $row['ID_R_L1'],
            'content' => array(
                /* 'ID_R_L1' => $row['ID_R_L1'],
                  'Type' => $row['Type'],
                  'Category' => $row['Category'], */
                'ID_R_L2' => $row['ID_R_L2'],
                'Object_Key' => $row['Object_Key'],
                'Fieldname' => $row['Fieldname'],
                'Fieldtype' => $row['Fieldtype'],
                'Fieldcontent' => $row['Fieldcontent']
        ));
        $parent_listing[$row['ID_R_L1']] = array(
            'ID_R_L1' => $row['ID_R_L1'],
            'Type' => $row['Type'],
            'Category' => $row['Category'],
            'Object_Key' => $row['Object_Key'],
            'Group' => $row['Group']
        );
    }
///////////////Anzeige
    $timer = 1;
    foreach ($parent_listing as $k => $v) {
        $timer = $timer + 1;
        echo "<div class='efResourceUnit1' data-idl1='" . $v['ID_R_L1'] . "' data-type='" . $v['Type'] . "' data-category='" . $v['Category'] . "' data-key='" . $v['Object_Key'] . "'>
                    <div data-delid='" . $v['ID_R_L1'] . "' class='efResourceUnit1DeleteObjectWarning'>
                            <div class='efResourceUnit1DeleteObjectWarningMessage'>Are you sure that you really want to delete this resource object?<br/>
                            <button id='efResourceUnit1DeleteObjectWarningMessageButtonYES' class='efResourceUnit1DeleteObjectWarningMessageButton'>DELETE</button>
                            <button id='efResourceUnit1DeleteObjectWarningMessageButtonNO' class='efResourceUnit1DeleteObjectWarningMessageButton'>CANCEL</button>
                            </div>
                    </div>
                    <div class='efResourceUnit1Type'>" . $v['Type'] . "&emsp;</div>
                    <div class='efResourceUnit1Group'>";

        $anfrageGroup = "SELECT DISTINCT `Group` FROM `eFilm_ReSources_L1` WHERE NOT `Group`='' ORDER BY `Group` ASC;";
        $ergebnisGroup = mysqli_query($localDatabase, $anfrageGroup);
        echo "<select style='padding: 2px; margin: 0px;' onchange='uploadGroup(" . $k . ",this.options[this.selectedIndex].text);'>"; // id='eFResourcesFilterGroup' name='eFResourcesFilterGroup'
        while ($row = mysqli_fetch_array($ergebnisGroup)) {
            if ($v['Group'] == $row['Group']) {
                echo "<option SELECTED>" . $row['Group'] . "</option>";
            } else {
                echo "<option>" . $row['Group'] . "</option>";
            }
        }
        echo "</select>";

        echo "</div>
                    <div class='efResourceUnit1Key'>" . $v['Object_Key'] . "&emsp;</div>
                    <div class='efResourceUnit1DeleteObject' data-idl1='" . $v['ID_R_L1'] . "'>-</div>";
// Not really sure what a SubObject is so disable this button for now
//                    <div class='efResourceUnit2NewSubObject' data-idl1='" . $v['ID_R_L1'] . "'>+</div>";
        echo "<div class='efResourceUnit2container'>";
        foreach ($listing as $k2 => $v2) {
            if ($v2['ID'] == $v['ID_R_L1']) {

                switch ($v2['content']['Fieldtype']) {
                    case 'text':
                        echo "<div class='efResourceUnit2' data-idl2='" . $v2['content']['ID_R_L2'] . "'><div class='efResourceUnit2fieldname'>" . $v2['content']['Fieldname'] . "</div><div class='efResourceUnit2fieldcontent' data-idl2='" . $v2['content']['ID_R_L2'] . "' id='" . $v2['content']['ID_R_L2'] . "'>" . $v2['content']['Fieldcontent'] . "</div></div>";
                        break;
                    case 'image':

												echo "<div class='efResourceUnit2' data-idl2='" . $v2['content']['ID_R_L2'] . "'>";
												echo "<div class='efResourceUnit2fieldname' data-filename='" . $v2['content']['Fieldcontent'] . "' data-filenameorig='" . $v2['content']['originalName'] . "'>" . $v2['content']['Fieldname'] . "</div>";
												echo "<div class='efResourceUnit2fieldcontent' data-idl2='" . $v2['content']['ID_R_L2'] . "' id='" . $v2['content']['ID_R_L2'] . "'>";
                        
                        if (file_exists($storeURL.'/_media/movies_wm/_img/Location-Shots_l/' . $v2['content']['originalName'])) {
                            echo "<img src='".$storeURL."/_media/movies_wm/_img/Location-Shots_l/" . $v2['content']['originalName'] . "' alt='" . $v2['content']['Fieldcontent'] . "' title='" . $v2['content']['originalName'] . "'/>";
                        } else {
                            $uniqueUTS = time();
                            $formidunique = $uniqueUTS + $timer;
                            $imagename_unique = $v['Object_Key'] . '_IMG_' . $formidunique;
                            echo '<input class="eFinput" type="text" value="' . $imagename_unique . '" name="' . $row['Resource_Field'] . '" readonly="readonly" />'; //Eingabefeld Bildname
                            echo "  <div name=\"files_div\" id=\"files_div\">\n";
                            echo "  Upload Image File: &nbsp; <input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\" size=\"30\" style=\"width: 200px;\" onChange=\"fileSelected();\"><br>\n";
                            echo "  <div style=\"display:block;\" id=\"fileName\"></div> <div style=\"display:block;\" id=\"fileSize\"></div> <div style=\"display:block;\" id=\"fileType\"></div><br>\n";
                            echo "  <input id=\"uploadProgress\" type=\"button\" value=\"Upload\" onclick=\"uploadFile(\"".$imagename_unique."\");\">\n";
                            echo "  </div>\n";
                            echo "  <script type=\"text/javascript\">\n";
                            echo "      function fileSelected() {\n";
                            echo "          var file = document.getElementById('fileToUpload').files[0];\n";
                            echo "          if (file) {\n";
                            echo "              var fileSize = 0;\n";
                            echo "              if (file.size > 1024 * 1024) fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString()+'MB';\n";
                            echo "              else fileSize = (Math.round(file.size * 100 / 1024) / 100).toString()+'KB';\n";
                            echo "              document.getElementById('fileName').innerHTML = file.name;\n";
                            echo "              document.getElementById('fileSize').innerHTML = fileSize;\n";
                            echo "              document.getElementById('fileType').innerHTML = file.type;\n";
                            echo "          }\n";
                            echo "      }\n";
                            echo "      function uploadFile(newFileName) {\n";
                            echo "          var fd = new FormData();\n";
                            echo "          fd.append(\"referenceName\", newFileName);\n";
                            echo "          fd.append(\"fileToUpload\", document.getElementById('fileToUpload').files[0]);\n";
                            echo "          var xhr = new XMLHttpRequest();\n";
                            echo "          xhr.upload.addEventListener(\"progress\", uploadProgress, false);\n";
                            echo "          xhr.addEventListener(\"load\", uploadComplete, false);\n";
                            echo "          xhr.addEventListener(\"error\", uploadFailed, false);\n";
                            echo "          xhr.addEventListener(\"abort\", uploadCanceled, false);\n";
                            echo "          xhr.open(\"POST\", \"_ajax/eFUploader.php\");\n";
                            echo "          xhr.send(fd);\n";
                            echo "      }\n";
                            echo "      function uploadProgress(evt) {\n";
                            echo "          if (evt.lengthComputable) {\n";
                            echo "              var percentComplete = Math.round(evt.loaded * 100 / evt.total);\n";
                            echo "              document.getElementById('uploadProgress').value = percentComplete.toString()+'%';\n";
                            echo "          }\n";
                            echo "      }\n";
                            echo "      function uploadComplete(evt) {\n";
                            echo "          // This event is raised when the server sends back a response\n";
                            echo "          document.getElementById('uploadProgress').value = \"Upload\";\n";
                            echo "          document.getElementById('fileToUpload').value = \"\";\n";
                            echo "          document.getElementById('fileName').innerHTML = \"\";\n";
                            echo "          document.getElementById('fileSize').innerHTML = \"\";\n";
                            echo "          document.getElementById('fileType').innerHTML = \"\";\n";
                            echo "					var oldfilename = $(document).find('form[id='+formularidentifikation+']').parent().find('input[class=eFinput]').val();\n";
                            echo "					var newfilename = oldfilename+uploadstatus.fileextension;\n";
                            echo "					$(document).find('form[id='+formularidentifikation+']').parent().html('<img src=\"".$storeURL."/_media/movies_wm/_img/Location-Shots_l/'+oldfilename+'\" />');\n";
                            echo "					$.ajax({\n";
                            echo "						type: 'post',\n";
                            echo "						url: '_ajax/eFEditorVResourcesContentSaveEdit.php',\n";
                            echo "						data: 'id='+idedit+'&value='+encodeURI(newfilename),\n";
                            echo "						cache: false\n";
                            echo "					});\n";
                            echo "					$.ajax({\n";
                            echo "						type: 'post',\n";
                            echo "						url: '_ajax/eFEditorVResourcesContentSaveEdit.php',\n";
                            echo "						data: 'id='+idedit+'&original='+encodeURI(oldfilename),\n";
                            echo "						cache: false\n";
                            echo "					});\n";
                            echo "          alert(evt.target.responseText);\n";
                            echo "      }\n";
                            echo "      function uploadFailed(evt) {\n";
                            echo "          alert(\"There was an error attempting to upload the file.\");\n";
                            echo "      }\n";
                            echo "      function uploadCanceled(evt) {\n";
                            echo "          alert(\"The upload has been canceled by the user or the browser dropped the connection.\");\n";
                            echo "      }\n";
                            echo "  </script>\n";

                        }
                        echo "</div>"; //efResourceUnit2fieldcontent
                        echo "</div>"; //efResourceUnit2
                        break;
                    case 'pdf':
                        if (file_exists($storeURL.'/_media/movies_wm/_img/Originals/'.$v2['content']['originalName'])) {
                            echo "<div class='efResourceUnit2' data-idl2='" . $v2['content']['ID_R_L2'] . "'>";
                            echo "<div class='efResourceUnit2fieldname' data-filename='" . $v2['content']['Fieldcontent'] . "' data-filenameorig='" . $v2['content']['originalName'] . "'>" . $v2['content']['Fieldname'] . "</div>";
                            echo "<div class='efResourceUnit2fieldcontent' data-idl2='" . $v2['content']['ID_R_L2'] . "' id='" . $v2['content']['ID_R_L2'] . "'>";
                            echo "<img src='".$storeURL."/_media/movies_wm/_img/pdf-icon.png' alt='" . $v2['content']['Fieldcontent'] . "' title='" . $v2['content']['originalName'] . "'/>";
                            echo "</div>"; //
                            echo "</div>"; //efResourceUnit2
                        } else {
                            echo "<div class='efResourceUnit2' data-idl2='" . $v2['content']['ID_R_L2'] . "'>
                                                    <div class='efResourceUnit2fieldname'>" . $v2['content']['Fieldname'] . "</div>";
                            echo "<div class='efResourceUnit2fieldcontent' data-idl2='" . $v2['content']['ID_R_L2'] . "' id='" . $v2['content']['ID_R_L2'] . "'>";

                            $uniqueUTS = time();
                            $formidunique = $uniqueUTS + $timer;
                            $imagename_unique = $v['Object_Key'] . '_PDF_' . $formidunique;
                            echo '<input class="eFinput" type="text" value="' . $imagename_unique . '" name="' . $row['Resource_Field'] . '" readonly="readonly" />'; //Eingabefeld Bildname
                            echo '<form id="' . $formidunique . '" action="_ajax/eFUploader.php" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" id="uploadResponseType" name="mimetype" value="html"><input type="hidden" name="effiletype" value="pdf">
                                                    <input type="hidden" name="efilmname" value="' . $imagename_unique . '"><input type="file" name="hugotest">
                                                    <input type="submit" value="Upload File">
                                                    </form>
                                                    <div class="progress" data-uniqueid="' . $formidunique . '">
                                                            <div class="bar" data-uniqueid="' . $formidunique . '"></div >
                                                            <div class="percent" data-uniqueid="' . $formidunique . '">0%</div >
                                                    </div>
                                                    ';

                            echo "</div>"; //efResourceUnit2fieldcontent
                            echo "</div>"; //efResourceUnit2
                        }
                        //Javascript dazu
                        echo "
                                             <script type='text/javascript'>
                                                    testomatinr('" . $formidunique . "','" . $v2['content']['ID_R_L2'] . "');

                                                    function testomatinr(formularidentifikation,idedit) { 
                                                    var bar = $(document).find('.bar[data-uniqueid=' + formularidentifikation + ']');
                                                    var percent = $(document).find('.percent[data-uniqueid=' + formularidentifikation + ']');
                                                    var status = $(document).find('.status[data-uniqueid=' + formularidentifikation + ']');

                                                    $(document).find('form[id=' + formularidentifikation + ']').ajaxForm({
                                                    beforeSend: function() {
                                                            status.empty();
                                                            var percentVal = '0%';
                                                            bar.width(percentVal);
                                                            percent.html(percentVal);
                                                            },
                                                    uploadProgress: function(event, position, total, percentComplete) {
                                                            var percentVal = percentComplete + '%';
                                                            bar.width(percentVal);
                                                            percent.html(percentVal);
                                                            },
                                                    complete: function(xhr) {
                                                            var uploadstatus = jQuery.parseJSON(xhr.responseText);
                                                            //console.log(uploadstatus);
                                                            //status.html(xhr.responseText);
                                                            //$(document).find('form[id=' + eFtempFormID + ']').parent().find('.status').remove();
                                                            var oldfilename = $(document).find('form[id=' + formularidentifikation + ']').parent().find('input[class=eFinput]').val();
                                                            var newfilename = oldfilename + uploadstatus.fileextension;
                                                            $(document).find('form[id=' + formularidentifikation + ']').parent().find('input[class=eFinput]').val(newfilename);
                                                            $(document).find('form[id=' + formularidentifikation + ']').parent().find('.progress').remove();
                                                            var smallheight = Math.round(250*(uploadstatus.height/uploadstatus.width));
                                                            $(document).find('form[id=' + formularidentifikation + ']').parent().html('<img src=\"_img/pdf-icon.png\" data-filename=' + newfilename + '/>');
                                                            $.ajax({
                                                                    type: 'post',
                                                                    url: '_ajax/eFEditorVResourcesContentSaveEdit.php',
                                                                    data: 'id=' + idedit + '&value=' + encodeURI(newfilename),
                                                                    cache: false
        				                                                    });
                                                            $.ajax({
                                                                    type: 'post',
                                                                    url: '_ajax/eFEditorVResourcesContentSaveEdit.php',
                                                                    data: 'id=' + idedit + '&original=' + encodeURI(oldfilename),
                                                                    cache: false
				                                                            });
                				                                    }
								                                    });
                                            } 
                                            </script>";
                        break;
                }
            }
        }
        echo "</div>";
///////////////Anzeige Relations
        echo "<div class='efResourceUnit2linkscontainer' data-idl1='" . $v['ID_R_L1'] . "'><div class='efResourceUnit2linkscontainerNewRelation'  data-idl1='" . $v['ID_R_L1'] . "'>+</div><div class='efResourceUnit2linkscontainerTitle'>Relations</div>";

        echo "<div class='efResourceUnit2linkscontainerContent' data-idl1='" . $v['ID_R_L1'] . "'>";

        foreach ($RelationListingA as $krelA1 => $vrelA1) {

            if ($vrelA1['ID_R_L1_A'] == $v['ID_R_L1']) {

                echo "<div class='efResourceUnit2linkscontainerContentEContainer'  data-ID_R_RelationIndex='" . $vrelA1['ID_R_RelationIndex'] . "'>";
                //print_r($vrelA1);

                echo "<div class='efResourceUnit2linkscontainerContentETitle' data-ID_R_RelationIndex='" . $vrelA1['ID_R_RelationIndex'] . "' data-ID_R_L1_A='" . $vrelA1['content']['ID_R_L1_A'] . "' data-ID_R_L1_B='" . $vrelA1['content']['ID_R_L1_B'] . "'>";
                echo $vrelA1['content']['Type'];
                echo "</div>"; //efResourceUnit2linkscontainerContentETitle

                echo "<div class='efResourceUnit2linkscontainerContentEContentContainerObjectContainer'>";
                echo "<div class='efResourceUnit2linkscontainerContentEContentContainerObjectTitle'>Object_Key</div>"; //efResourceUnit2linkscontainerContentEContentContainerObjectTitle
                echo "<div class='efResourceUnit2linkscontainerContentEContentContainerObjectContent'>";
                echo $vrelA1['content']['Object_Key'];
                echo "</div>"; //efResourceUnit2linkscontainerContentEContentContainerObjectContent
                echo "</div>"; //efResourceUnit2linkscontainerContentEContentContainerObjectContainer
                echo "<div class='efResourceUnit2linkscontainerContentEContentContainerObjectContainer'>";
                echo "<div class='efResourceUnit2linkscontainerContentEContentContainerObjectTitle'>Relation Type</div>"; //efResourceUnit2linkscontainerContentEContentContainerObjectTitle
                echo "<div class='efResourceUnit2linkscontainerContentEContentContainerObjectContent'>";
                echo $vrelA1['content']['RelationType'];
                echo "</div>"; //efResourceUnit2linkscontainerContentEContentContainerObjectContent
                echo "</div>"; //efResourceUnit2linkscontainerContentEContentContainerObjectContainer
                echo "<div class='efResourceUnit2linkscontainerContentEContentContainerObjectContainer'>";
                echo "<div class='efResourceUnit2linkscontainerContentEContentContainerObjectTitle'>Relation Remarks</div>"; //efResourceUnit2linkscontainerContentEContentContainerObjectTitle
                echo "<div class='efResourceUnit2linkscontainerContentEContentContainerObjectContent'>";
                echo $vrelA1['content']['RelationRemark'];
                echo "</div>"; //efResourceUnit2linkscontainerContentEContentContainerObjectContent
                echo "</div>"; //efResourceUnit2linkscontainerContentEContentContainerObjectContainer

                echo "<div class='efResourceUnit2linkscontainerContentEContentContainerDel' data-ID_R_RelationIndex='" . $vrelA1['ID_R_RelationIndex'] . "' data-idl1='" . $v['ID_R_L1'] . "'>-</div>";
                echo "</div>"; //efResourceUnit2linkscontainerContentEContainer
            }
        }
        echo "</div>"; //efResourceUnit2linkscontainerContent
        echo "</div>"; //efResourceUnit2linkscontainer
        echo "</div>"; //efResourceUnit1
    }
    echo "</div>"; //eFRSubContent
    echo "</div>"; //resourcecontentclass
} else {
    /**
     * eFilm Movies
     * 
     * This is the section that allows you to edit and add individual films.
     * You will edit by picking an existing movie in the dropdown menu
     * at the top of the page.
     */
    $anfrageFilms = "SELECT DISTINCT `FILM_ID` FROM `eFilm_Content_Movies` ORDER BY `FILM_ID` ASC;";
    $ergebnisFilms = mysqli_query($localDatabase, $anfrageFilms);
    echo "<div id='eFResourcesFilterContainer'>Redigieren (Edit): ";
    echo "<select  id='eFResourcesFilterFilm' name='eFResourcesFilterFilm' onchange='fetchFilmInfo(this.options[this.selectedIndex].value);'><option selected></option>";
    while ($row = mysqli_fetch_array($ergebnisFilms)) {
//        echo "\n<!-- ".var_dump($row)." -->\n";
        echo "<option value='".$row['FILM_ID']."'>".$row['FILM_ID']."</option>";
        $overallFilmList[] = $row['FILM_ID'];
    }
    echo "</select>\n";
    echo "<script>\n";
    echo "  function fetchFilmInfo(value) {\n";
    echo "      var xhr = new XMLHttpRequest();\n";
    echo "      xhr.onreadystatechange = function() {\n";
    echo "        if (xhr.readyState == 4 && xhr.status == 200) {\n";
    echo "        var filmNumberParts = value.split('_');\n";
    echo "          var dataArr = JSON.parse(xhr.responseText);\n";
    echo "          document.getElementById('newMovieTitleEn').value = ( typeof dataArr['newMovieTitleEn'] !== 'undefined' ) ? dataArr['newMovieTitleEn'] : '';\n"
                    . "document.getElementById('newMovieGenerationEn').value = ( typeof dataArr['newMovieGenerationEn'] !== 'undefined' ) ? dataArr['newMovieGenerationEn'] : '';\n"
                    . "document.getElementById('newMoviePosNegEn').value = ( typeof dataArr['newMoviePosNegEn'] !== 'undefined' ) ? dataArr['newMoviePosNegEn'] : '';\n"
                    . "document.getElementById('newMovieFilmBaseEn').value = ( typeof dataArr['newMovieFilmBaseEn'] !== 'undefined' ) ? dataArr['newMovieFilmBaseEn'] : '';\n"
                    . "document.getElementById('newMoviePrevGenEn').value = ( typeof dataArr['newMoviePrevGenEn'] !== 'undefined' ) ? dataArr['newMoviePrevGenEn'] : '';\n"
                    . "document.getElementById('newMovieColorEn').value = ( typeof dataArr['newMovieColorEn'] !== 'undefined' ) ? dataArr['newMovieColorEn'] : '';\n"
                    . "document.getElementById('newMovieSoundEn').value = ( typeof dataArr['newMovieSoundEn'] !== 'undefined' ) ? dataArr['newMovieSoundEn'] : '';\n"
                    . "document.getElementById('newMovieSoundProcessEn').value = ( typeof dataArr['newMovieSoundProcessEn'] !== 'undefined' ) ? dataArr['newMovieSoundProcessEn'] : '';\n"
                    . "document.getElementById('newMovieLanguageEn').value = ( typeof dataArr['newMovieLanguageEn'] !== 'undefined' ) ? dataArr['newMovieLanguageEn'] : '';\n"
                    . "document.getElementById('newMovieLabEn').value = ( typeof dataArr['newMovieLabEn'] !== 'undefined' ) ? dataArr['newMovieLabEn'] : '';\n"
                    . "document.getElementById('newMovieGenreEn').value = ( typeof dataArr['newMovieGenreEn'] !== 'undefined' ) ? dataArr['newMovieGenreEn'] : '';\n"
                    . "document.getElementById('newMovieTitleDe').value = ( typeof dataArr['newMovieTitleDe'] !== 'undefined' ) ? dataArr['newMovieTitleDe'] : '';\n"
                    . "document.getElementById('newMovieGenerationDe').value = ( typeof dataArr['newMovieGenerationDe'] !== 'undefined' ) ? dataArr['newMovieGenerationDe'] : '';\n"
                    . "document.getElementById('newMoviePosNegDe').value = ( typeof dataArr['newMoviePosNegDe'] !== 'undefined' ) ? dataArr['newMoviePosNegDe'] : '';\n"
                    . "document.getElementById('newMovieFilmBaseDe').value = ( typeof dataArr['newMovieFilmBaseDe'] !== 'undefined' ) ? dataArr['newMovieFilmBaseDe'] : '';\n"
                    . "document.getElementById('newMoviePrevGenDe').value = ( typeof dataArr['newMoviePrevGenDe'] !== 'undefined' ) ? dataArr['newMoviePrevGenDe'] : '';\n"
                    . "document.getElementById('newMovieColorDe').value = ( typeof dataArr['newMovieColorDe'] !== 'undefined' ) ? dataArr['newMovieColorDe'] : '';\n"
                    . "document.getElementById('newMovieSoundDe').value = ( typeof dataArr['newMovieSoundDe'] !== 'undefined' ) ? dataArr['newMovieSoundDe'] : '';\n"
                    . "document.getElementById('newMovieSoundProcessDe').value = ( typeof dataArr['newMovieSoundProcessDe'] !== 'undefined' ) ? dataArr['newMovieSoundProcessDe'] : '';\n"
                    . "document.getElementById('newMovieLanguageDe').value = ( typeof dataArr['newMovieLanguageDe'] !== 'undefined' ) ? dataArr['newMovieLanguageDe'] : '';\n"
                    . "document.getElementById('newMovieLabDe').value = ( typeof dataArr['newMovieLabDe'] !== 'undefined' ) ? dataArr['newMovieLabDe'] : '';\n"
                    . "document.getElementById('newMovieGenreDe').value = ( typeof dataArr['newMovieGenreDe'] !== 'undefined' ) ? dataArr['newMovieGenreDe'] : '';\n"
                    . "document.getElementById('newMovieDisplayTitle').value = ( typeof dataArr['newMovieDisplayTitle'] !== 'undefined' ) ? dataArr['newMovieDisplayTitle'] : '';\n"
                    . "document.getElementById('newMovieArchivalNumber').value = ( typeof dataArr['newMovieArchivalNumber'] !== 'undefined' ) ? dataArr['newMovieArchivalNumber'] : '';\n"
                    . "document.getElementById('newMovieFilmGauge').value = ( typeof dataArr['newMovieFilmGauge'] !== 'undefined' ) ? dataArr['newMovieFilmGauge'] : '';\n"
                    . "document.getElementById('newMovieFPS').value = ( typeof dataArr['newMovieFPS'] !== 'undefined' ) ? dataArr['newMovieFPS'] : '';\n"
                    . "document.getElementById('newMovieMinutes').value = ( typeof dataArr['newMovieMinutes'] !== 'undefined' ) ? dataArr['newMovieMinutes'] : '';\n"
                    . "document.getElementById('newMovieSeconds').value = ( typeof dataArr['newMovieSeconds'] !== 'undefined' ) ? dataArr['newMovieSeconds'] : '';\n"
                    . "document.getElementById('newMovieFrames').value = ( typeof dataArr['newMovieFrames'] !== 'undefined' ) ? dataArr['newMovieFrames'] : '';\n"
                    . "document.getElementById('newMovieYear').value = ( typeof dataArr['newMovieYear'] !== 'undefined' ) ? dataArr['newMovieYear'] : '';\n"
                    . "document.getElementById('newMovieEFNS').value = ( typeof dataArr['newMovieEFNS'] !== 'undefined' ) ? dataArr['newMovieEFNS'] : filmNumberParts[0]+'_'+filmNumberParts[1];\n"
                    . "document.getElementById('newMovieReel').value = ( typeof dataArr['newMovieReel'] !== 'undefined' ) ? dataArr['newMovieReel'] : '';\n"
                    . "document.getElementById('newMovieSource').value = ( typeof dataArr['newMovieSource'] !== 'undefined' ) ? dataArr['newMovieSource'] : filmNumberParts[2];\n"
                    . "document.getElementById('newMovieSeries').value = ( typeof dataArr['newMovieSeries'] !== 'undefined' ) ? dataArr['newMovieSeries'] : '';\n"
                    . "document.getElementById('newMovieFormat').value = ( typeof dataArr['newMovieFormat'] !== 'undefined' ) ? dataArr['newMovieFormat'] : '';\n"
                    . "document.getElementById('newMovieCopyDate').value = ( typeof dataArr['newMovieCopyDate'] !== 'undefined' ) ? dataArr['newMovieCopyDate'] : '';\n"
                    . "document.getElementById('newMovieProducer').value = ( typeof dataArr['newMovieProducer'] !== 'undefined' ) ? dataArr['newMovieProducer'] : '';\n"
                    . "document.getElementById('newMovieDirector').value = ( typeof dataArr['newMovieDirector'] !== 'undefined' ) ? dataArr['newMovieDirector'] : '';\n"
                    . "document.getElementById('newMovieCinematography').value = ( typeof dataArr['newMovieCinematography'] !== 'undefined' ) ? dataArr['newMovieCinematography'] : '';\n"
                    . "document.getElementById('newMovieCollection').value = ( typeof dataArr['newMovieCollection'] !== 'undefined' ) ? dataArr['newMovieCollection'] : '';\n"
                    . "document.getElementById('newMovieProvenance').value = ( typeof dataArr['newMovieProvenance'] !== 'undefined' ) ? dataArr['newMovieProvenance'] : '';\n"
                    . "document.getElementById('newMovieDescription').value = ( typeof dataArr['newMovieDescription'] !== 'undefined' ) ? dataArr['newMovieDescription'] : '';\n"
                    . "document.getElementById('newMoviePraktikantin').value = ( typeof dataArr['newMoviePraktikantin'] !== 'undefined' ) ? dataArr['newMoviePraktikantin'] : '';\n"
                    . "document.getElementById('newMovieEditorV').value = ( typeof dataArr['newMovieEditorV'] !== 'undefined' ) ? dataArr['newMovieEditorV'] : '';\n"
                    . "document.getElementById('newMovieStatus').value = ( typeof dataArr['newMovieStatus'] !== 'undefined' ) ? dataArr['newMovieStatus'] : '';\n"
                    . "document.getElementById('newMoviePOnline').value = ( typeof dataArr['newMoviePOnline'] !== 'undefined' ) ? dataArr['newMoviePOnline'] : '';\n";
    echo "        }\n";
    echo "      }\n";
    echo "      var params = 'film='+value;\n";
    echo "      xhr.open(\"POST\", \"_ajax/getFilmDetails.php\", true);\n";
    echo "      xhr.setRequestHeader(\"Content-type\", \"application/x-www-form-urlencoded\");\n";
    echo "      xhr.send(params);\n";
    echo "  }\n";
    echo "</script>\n";
    echo "</div>";
    echo "<div id='eFResourcesSubContent'>";
    echo "<table style='width: 90%; margin: 0px auto;'>";
    echo "<tr>";
    echo "  <th style='width: 49%; font-size: 1.5em;' colspan=2>Deutsch</th>";
    echo "  <th style='font-size: 1.5em;' colspan=2>English</th>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Filmtitel : </td><td><input id='newMovieTitleDe' style='width: 90%;'></td>";
    echo "  <td style='text-align: right;'>Film Title : </td><td><input id='newMovieTitleEn' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Generation : </td><td><input id='newMovieGenerationDe' style='width: 90%;'></td>";
    echo "  <td style='text-align: right;'>Generation : </td><td><input id='newMovieGenerationEn' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Pos/Neg : </td><td><input id='newMoviePosNegDe' style='width: 90%;'></td>";
    echo "  <td style='text-align: right;'>Pos/Neg : </td><td><input id='newMoviePosNegEn' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Film Base : </td><td><input id='newMovieFilmBaseDe' style='width: 90%;'></td>";
    echo "  <td style='text-align: right;'>Film Base : </td><td><input id='newMovieFilmBaseEn' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Previous Generation : </td><td><input id='newMoviePrevGenDe' style='width: 90%;'></td>";
    echo "  <td style='text-align: right;'>Previous Generation : </td><td><input id='newMoviePrevGenEn' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Farbe : </td><td><input id='newMovieColorDe' style='width: 90%;'></td>";
    echo "  <td style='text-align: right;'>Color : </td><td><input id='newMovieColorEn' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Ton : </td><td><input id='newMovieSoundDe' style='width: 90%;'></td>";
    echo "  <td style='text-align: right;'>Sound : </td><td><input id='newMovieSoundEn' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Tonverfahren : </td><td><input id='newMovieSoundProcessDe' style='width: 90%;'></td>";
    echo "  <td style='text-align: right;'>Sound Process : </td><td><input id='newMovieSoundProcessEn' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Sprache : </td><td><input id='newMovieLanguageDe' style='width: 90%;'></td>";
    echo "  <td style='text-align: right;'>Language : </td><td><input id='newMovieLanguageEn' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Digital Lab : </td><td><input id='newMovieLabDe' style='width: 90%;'></td>";
    echo "  <td style='text-align: right;'>Digital Lab : </td><td><input id='newMovieLabEn' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Genre : </td><td><input id='newMovieGenreDe' style='width: 90%;'></td>";
    echo "  <td style='text-align: right;'>Genre : </td><td><input id='newMovieGenreEn' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <th colspan=4>&nbsp;</th>";
    echo "</tr>";
    echo "<tr>";
    echo "  <th style='font-size: 1.5em;' colspan=2>Film Details</th>";
    echo "  <th style='font-size: 1.5em;' colspan=2>Upload m4v File</th>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Display Title : </td><td><input id='newMovieDisplayTitle' style='width: 90%;'></td>";
    echo "  <td style='text-align: left; vertical-align: top;' colspan=2 rowspan=25>";
        echo "<div style='margin: 10px 0px 0px 20px; width: 300px; float: left;'>";
        echo "  <div name=\"files_div\" id=\"files_div\"><br clear='both'>";
        echo "  <p><input type='checkbox' id='watermark'> Watermarked Copy</p>";
        echo "  <input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\" onclick=\"document.getElementById('saveNewFilmDetailsButton').disabled = true;\" onChange=\"fileSelected();\"><br clear='both'>\n";
        echo "  <table style=\"width: 100%;\"><tr><td><div style=\"display:block; font-size: 1.2em;\" id=\"fileName\"></div> <div style=\"display:block; font-size: 1.2em;\" id=\"fileSize\"></div> <div style=\"display:block; font-size: 1.2em;\" id=\"fileType\"></div></td><td width='80px;'><div id=\"spinner\" style=\"clear: both; margin: 20px auto;\"></div></td></tr></table><br>\n";
        echo "  <input id=\"uploadProgress\" type=\"button\" value=\"Upload\" onclick=\"uploadFile();\">";
        echo "  </div>\n";
        echo "</div>";
        echo "<div id='tempContainerForVideoUpload' style='display:none;'><video id=\"uploadedVideo\" height=\"240\" controls></video><br><button onclick=\"createPosterFrame();\">Capture Poster Frame</button></div>";
        echo "  <script type=\"text/javascript\">\n";
        echo "      function fileSelected() {\n";
        echo "          var file = document.getElementById('fileToUpload').files[0];\n";
        echo "          if (file) {\n";
        echo "              var fileSize = 0;\n";
        echo "              if (file.size > 1024 * 1024) fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString()+'MB';\n";
        echo "              else fileSize = (Math.round(file.size * 100 / 1024) / 100).toString()+'KB';\n";
        echo "              document.getElementById('fileName').innerHTML = file.name;\n";
        echo "              document.getElementById('fileSize').innerHTML = fileSize;\n";
        echo "              document.getElementById('fileType').innerHTML = file.type;\n";
        echo "          }\n";
        echo "      }\n";
        echo "      function uploadFile() {\n";
        echo "          var fd = new FormData();\n";
        echo "          fd.append(\"fileToUpload\", document.getElementById('fileToUpload').files[0]);\n";
        echo "          fd.append(\"watermarked\", document.getElementById('watermark').checked );\n";
        echo "          var xhr = new XMLHttpRequest();\n";
        echo "          xhr.upload.addEventListener(\"progress\", uploadProgress, false);\n";
        echo "          xhr.addEventListener(\"load\", uploadComplete, false);\n";
        echo "          xhr.addEventListener(\"error\", uploadFailed, false);\n";
        echo "          xhr.addEventListener(\"abort\", uploadCanceled, false);\n";
        echo "          xhr.open(\"POST\", \"_ajax/M4VUploader.php\");\n";
        echo "          xhr.send(fd);\n";
        echo "      }\n";
        echo "      function uploadProgress(evt) {\n";
        echo "          document.getElementById('fileToUpload').style.display = 'none';\n";
        echo "          document.getElementById('uploadProgress').disabled = true;\n";
        echo "          document.getElementById('uploadProgress').value = 'Processing';\n";
        echo "          if (document.getElementById('spinner').innerHTML == '') {\n";
        echo "            document.getElementById('spinner').innerHTML = \"<img src='_img/spinner.gif' width=75 height=58>\";\n";
        echo "          }\n";
        echo "      }\n";
        echo "      function createPosterFrame() {\n";
        echo "          var fd = new FormData();\n";
        echo "          var vid = document.getElementById('uploadedVideo');\n";
        echo "          fd.append(\"videoFileName\", document.getElementById('fileName').innerHTML);\n";
        echo "          fd.append(\"time\", vid.currentTime);\n";
        echo "          var xhr = new XMLHttpRequest();\n";
        echo "          xhr.addEventListener(\"load\", posterFrameComplete, false);\n";
        echo "          xhr.open(\"POST\", \"_ajax/createPosterFrame.php\");\n";
        echo "          xhr.send(fd);\n";
        echo "      }\n";
        echo "      function posterFrameComplete(evt) {\n";
        echo "          alert('Poster Frame Created');\n";
        echo "          document.getElementById('tempContainerForVideoUpload').innerHTML = '<img src=\"/_img/PosterFrames/'+evt.target.responseText+'\" style=\"max-width: 50%;\">';\n";
        echo "      }\n";
        echo "      function uploadComplete(evt) {\n";
        echo "          // This event is raised when the server sends back a response\n";
        echo "          document.getElementById('spinner').innerHTML = '';\n";
        echo "          if (evt.target.responseText != '') {\n";
        echo "              alert(evt.target.responseText);\n";
        echo "              document.getElementById('uploadProgress').value = \"Upload\";\n";
        echo "              document.getElementById('fileToUpload').value = \"\";\n";
        echo "              document.getElementById('fileName').innerHTML = \"\";\n";
        echo "              document.getElementById('fileSize').innerHTML = \"\";\n";
        echo "              document.getElementById('fileType').innerHTML = \"\";\n";
        echo "              return;\n";
        echo "          }\n";
        echo "          alert('Upload Complete');\n";
        echo "          document.getElementById('fileToUpload').style.display = 'none';\n";
        echo "          document.getElementById('uploadProgress').style.display = 'none';\n";
        echo "          document.getElementById('saveNewFilmDetailsButton').disabled = false;\n";
        echo "          if (!document.getElementById('watermark').checked) {\n";
        echo "              document.getElementById('uploadedVideo').src = '/uploads/video/'+document.getElementById('fileName').innerHTML;\n";
        echo "              document.getElementById('tempContainerForVideoUpload').style.display = 'block';\n";
        echo "          }\n";
        echo "      }\n";
        echo "      function uploadFailed(evt) {\n";
        echo "          alert(\"There was an error attempting to upload the file.\");\n";
        echo "      }\n";
        echo "      function uploadCanceled(evt) {\n";
        echo "          alert(\"The upload has been canceled by the user or the browser dropped the connection.\");\n";
        echo "      }\n";
        echo "  </script>\n";
    echo "  </td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Archival Number : </td><td><input id='newMovieArchivalNumber' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Film Gauge : </td><td><input id='newMovieFilmGauge' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>FPS : </td><td><input id='newMovieFPS' style='width: 90%;'></td>";
	echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Minutes : </td><td><input id='newMovieMinutes' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Seconds : </td><td><input id='newMovieSeconds' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Frames : </td><td><input id='newMovieFrames' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Year : </td><td><input id='newMovieYear' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>EF-NS # : </td><td><input id='newMovieEFNS' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Source : </td><td><input id='newMovieSource' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Reel : </td><td><input id='newMovieReel' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Series : </td><td><input id='newMovieSeries' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Digital Format : </td><td><input id='newMovieFormat' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Copy Date : </td><td><input id='newMovieCopyDate' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Producer : </td><td><input id='newMovieProducer' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Director : </td><td><input id='newMovieDirector' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Cinematographer : </td><td><input id='newMovieCinematography' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Collection : </td><td><input id='newMovieCollection' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Provenance : </td><td><input id='newMovieProvenance' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Description : </td><td><input id='newMovieDescription' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Praktikantin : </td><td><input id='newMoviePraktikantin' style='width: 90%;'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Show In Editor : </td><td><input id='newMovieEditorV' value='Ja (Yes)' style='width: 90%;' readonly></td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Status : </td><td><input id='newMovieStatus' style='width: 90%;' value='Unbearbeitet (Unfinished)' readonly></td>"; //0 ... unbearbeitet (unfinished), 1 ... Praktikant$
    echo "</tr>";
    echo "<tr>";
    echo "  <td style='text-align: right;'>Publish Online : </td><td><input id='newMoviePOnline' value='Nein (No)' style='width: 90%;' readonly></td>";
    echo "</tr>";
    echo "</table>";
    echo "<script type = \"text/javascript\">\n";
    echo "  function saveFilmDetails() {\n";
    echo "      var xhr = new XMLHttpRequest();\n";
    echo "      xhr.addEventListener(\"load\", saveComplete, false);\n";
    echo "      xhr.open(\"POST\", \"_ajax/saveNewFilm.php\");\n";
    echo "      xhr.setRequestHeader(\"Content-type\",\"application/x-www-form-urlencoded\");\n";
    echo "      xhr.send(\"newMovieTitleEn=\"+document.getElementById('newMovieTitleEn').value+"
            . "\"&newMovieGenerationEn=\"+document.getElementById('newMovieGenerationEn').value+"
            . "\"&newMoviePosNegEn=\"+document.getElementById('newMoviePosNegEn').value+"
            . "\"&newMovieFilmBaseEn=\"+document.getElementById('newMovieFilmBaseEn').value+"
            . "\"&newMoviePrevGenEn=\"+document.getElementById('newMoviePrevGenEn').value+"
            . "\"&newMovieColorEn=\"+document.getElementById('newMovieColorEn').value+"
            . "\"&newMovieSoundEn=\"+document.getElementById('newMovieSoundEn').value+"
            . "\"&newMovieSoundProcessEn=\"+document.getElementById('newMovieSoundProcessEn').value+"
            . "\"&newMovieLanguageEn=\"+document.getElementById('newMovieLanguageEn').value+"
            . "\"&newMovieLabEn=\"+document.getElementById('newMovieLabEn').value+"
            . "\"&newMovieGenreEn=\"+document.getElementById('newMovieGenreEn').value+"
            . "\"&newMovieTitleDe=\"+document.getElementById('newMovieTitleDe').value+"
            . "\"&newMovieGenerationDe=\"+document.getElementById('newMovieGenerationDe').value+"
            . "\"&newMoviePosNegDe=\"+document.getElementById('newMoviePosNegDe').value+"
            . "\"&newMovieFilmBaseDe=\"+document.getElementById('newMovieFilmBaseDe').value+"
            . "\"&newMoviePrevGenDe=\"+document.getElementById('newMoviePrevGenDe').value+"
            . "\"&newMovieColorDe=\"+document.getElementById('newMovieColorDe').value+"
            . "\"&newMovieSoundDe=\"+document.getElementById('newMovieSoundDe').value+"
            . "\"&newMovieSoundProcessDe=\"+document.getElementById('newMovieSoundProcessDe').value+"
            . "\"&newMovieLanguageDe=\"+document.getElementById('newMovieLanguageDe').value+"
            . "\"&newMovieLabDe=\"+document.getElementById('newMovieLabDe').value+"
            . "\"&newMovieGenreDe=\"+document.getElementById('newMovieGenreDe').value+"
            . "\"&newMovieDisplayTitle=\"+document.getElementById('newMovieDisplayTitle').value+"
            . "\"&newMovieArchivalNumber=\"+document.getElementById('newMovieArchivalNumber').value+"
            . "\"&newMovieFilmGauge=\"+document.getElementById('newMovieFilmGauge').value+"
            . "\"&newMovieFPS=\"+document.getElementById('newMovieFPS').value+"
            . "\"&newMovieMinutes=\"+document.getElementById('newMovieMinutes').value+"
            . "\"&newMovieSeconds=\"+document.getElementById('newMovieSeconds').value+"
            . "\"&newMovieFrames=\"+document.getElementById('newMovieFrames').value+"
            . "\"&newMovieYear=\"+document.getElementById('newMovieYear').value+"
            . "\"&newMovieEFNS=\"+document.getElementById('newMovieEFNS').value+"
            . "\"&newMovieReel=\"+document.getElementById('newMovieReel').value+"
            . "\"&newMovieSource=\"+document.getElementById('newMovieSource').value+"
            . "\"&newMovieSeries=\"+document.getElementById('newMovieSeries').value+"
            . "\"&newMovieFormat=\"+document.getElementById('newMovieFormat').value+"
            . "\"&newMovieCopyDate=\"+document.getElementById('newMovieCopyDate').value+"
            . "\"&newMovieProducer=\"+document.getElementById('newMovieProducer').value+"
            . "\"&newMovieDirector=\"+document.getElementById('newMovieDirector').value+"
            . "\"&newMovieCinematography=\"+document.getElementById('newMovieCinematography').value+"
            . "\"&newMovieCollection=\"+document.getElementById('newMovieCollection').value+"
            . "\"&newMovieProvenance=\"+document.getElementById('newMovieProvenance').value+"
            . "\"&newMovieDescription=\"+document.getElementById('newMovieDescription').value+"
            . "\"&newMoviePraktikantin=\"+document.getElementById('newMoviePraktikantin').value+"
            . "\"&newMovieEditorV=\"+document.getElementById('newMovieEditorV').value+"
            . "\"&newMovieStatus=\"+document.getElementById('newMovieStatus').value+"
            . "\"&newMoviePOnline=\"+document.getElementById('newMoviePOnline').value+"
            . "\"&iconicImage=\"+document.getElementById('fileName').value"
            . ");\n";
    echo "  }\n";
    echo "      function saveComplete(evt) {\n";
    echo "          // This event is raised when the server sends back a response\n";
    echo "          console.log(evt.target.responseText);";
    echo "          alert(evt.target.responseText);\n";
    echo "      }\n";
    echo "</script>\n";
    echo "<input id=\"saveNewFilmDetailsButton\" type=\"button\" value=\"Save Film Details\" onclick=\"saveFilmDetails();\" style=\"clear: both; float: right; margin: 25px 20px 0px 0px;\">\n";
    echo "</div>";
}
