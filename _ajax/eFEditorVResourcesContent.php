<?php

if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION["login"] != "true") {
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
                                                            bar.width(percentVal)
                                                            percent.html(percentVal);
                                                            },
                                                    uploadProgress: function(event, position, total, percentComplete) {
                                                            var percentVal = percentComplete + '%';
                                                            bar.width(percentVal)
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
    
    echo "<span style='margin: 20px 0px 0px 20px; width: 200px; float: left;'>English</span><br clear='both'>";
    echo "<input id='newMovieTitleEn' placeholder='New Movie Title' style='margin: 10px 0px 0px 20px; width: 200px; float: left;'>";
    echo "<input id='newMovieGenerationEn' placeholder='Generation' style='margin: 10px 0px 0px 20px; width: 100px; float: left;'>";
    echo "<input id='newMoviePosNegEn' placeholder='Pos/Neg' style='margin: 10px 0px 0px 20px; width: 100px; float: left;'>";
    echo "<input id='newMovieFilmBaseEn' placeholder='Film Base' style='margin: 10px 0px 0px 20px; width: 100px; float: left;'>";
    echo "<input id='newMoviePrevGenEn' placeholder='Previous Gen' style='margin: 10px 0px 0px 20px; width: 100px; float: left;'>";
    echo "<input id='newMovieColorEn' placeholder='Color' style='margin: 10px 0px 0px 20px; width: 45px; float: left;'>";
    echo "<input id='newMovieSoundEn' placeholder='Sound' style='margin: 10px 0px 0px 20px; width: 45px; float: left;'>";
    echo "<input id='newMovieSoundProcessEn' placeholder='Sound Process' style='margin: 10px 0px 0px 20px; width: 100px; float: left;'>";
    echo "<input id='newMovieLanguageEn' placeholder='Language' style='margin: 10px 0px 0px 20px; width: 55px; float: left;'>";
    echo "<input id='newMovieLabEn' placeholder='Digital Lab' style='margin: 10px 0px 0px 20px; width: 100px; float: left;'>";
    echo "<input id='newMovieGenreEn' placeholder='Genre' style='margin: 10px 0px 0px 20px; width: 55px; float: left;'>";

    echo "<br clear='both'>";

    echo "<span style='margin: 20px 0px 0px 20px; width: 200px; float: left;'>Deutsch</span><br clear='both'>";
    echo "<input id='newMovieTitleDe' placeholder='New Movie Title' style='margin: 10px 0px 0px 20px; width: 200px; float: left;'>";
    echo "<input id='newMovieGenerationDe' placeholder='Generation' style='margin: 10px 0px 0px 20px; width: 100px; float: left;'>";
    echo "<input id='newMoviePosNegDe' placeholder='Pos/Neg' style='margin: 10px 0px 0px 20px; width: 100px; float: left;'>";
    echo "<input id='newMovieFilmBaseDe' placeholder='Film Base' style='margin: 10px 0px 0px 20px; width: 100px; float: left;'>";
    echo "<input id='newMoviePrevGenDe' placeholder='Previous Gen' style='margin: 10px 0px 0px 20px; width: 100px; float: left;'>";
    echo "<input id='newMovieColorDe' placeholder='Farbe' style='margin: 10px 0px 0px 20px; width: 45px; float: left;'>";
    echo "<input id='newMovieSoundDe' placeholder='Ton' style='margin: 10px 0px 0px 20px; width: 45px; float: left;'>";
    echo "<input id='newMovieSoundProcessDe' placeholder='Tonverfahren' style='margin: 10px 0px 0px 20px; width: 100px; float: left;'>";
    echo "<input id='newMovieLanguageDe' placeholder='Sprache' style='margin: 10px 0px 0px 20px; width: 55px; float: left;'>";
    echo "<input id='newMovieLabDe' placeholder='Digital Lab' style='margin: 10px 0px 0px 20px; width: 100px; float: left;'>";
    echo "<input id='newMovieGenreDe' placeholder='Genre' style='margin: 10px 0px 0px 20px; width: 55px; float: left;'>";

    echo "<br clear='both'>";

    echo "<span style='margin: 20px 0px 0px 20px; width: 200px; float: left;'>Film Details</span><br clear='both'>";
    echo "<input id='newMovieDisplayTitle' placeholder='Display Title' style='margin: 10px 0px 0px 20px; width: 150px; float: left;'>";
    echo "<input id='newMovieArchivalNumber' placeholder='Archival Number' style='margin: 10px 0px 0px 20px; width: 150px; float: left;'>";
    echo "<input id='newMovieFilmNumber' placeholder='Film Number' style='margin: 10px 0px 0px 20px; width: 75px; float: left;'>";
    echo "<input id='newMovieFilmGauge' placeholder='Film Gauge' style='margin: 10px 0px 0px 20px; width: 150px; float: left;'>";
    echo "<input id='newMovieFPS' placeholder='FPS' style='margin: 10px 0px 0px 20px; width: 20px; float: left;'>";
    echo "<input id='newMovieMinutes' placeholder='Minutes' style='margin: 10px 0px 0px 20px; width: 45px; float: left;'>";
    echo "<span style='margin: 12px 0px 0px 5px; float: left;'>:</span>";
    echo "<input id='newMovieSeconds' placeholder='Seconds' style='margin: 10px 0px 0px 5px; width: 45px; float: left;'>";
    echo "<input id='newMovieFrames' placeholder='Frames' style='margin: 10px 0px 0px 20px; width: 45px; float: left;'>";
    echo "<input id='newMovieYear' placeholder='Year' style='margin: 10px 0px 0px 20px; width: 45px; float: left;'>";

    echo "<br clear='both'>";

    echo "<input id='newMovieEFNS' placeholder='EF-NS #' style='margin: 10px 0px 0px 20px; width: 45px; float: left;'>";
    echo "<span style='margin: 12px 0px 0px 5px; float: left;'>-</span>";
    echo "<input id='newMovieReel' placeholder='Reel' style='margin: 10px 0px 0px 5px; width: 45px; float: left;'>";
    echo "<span style='margin: 12px 0px 0px 5px; float: left;'>-</span>";
    echo "<input id='newMovieSource' placeholder='Source' style='margin: 10px 0px 0px 5px; width: 45px; float: left;'>";
    echo "<input id='newMovieSeries' placeholder='Series' style='margin: 10px 0px 0px 20px; width: 45px; float: left;'>";
    echo "<input id='newMovieFormat' placeholder='Digital Format' style='margin: 10px 0px 0px 20px; width: 80px; float: left;'>";
    echo "<input id='newMovieCopyDate' placeholder='Copy Date' style='margin: 10px 0px 0px 20px; width: 80px; float: left;'>";
    echo "<input id='newMovieProducer' placeholder='Producer' style='margin: 10px 0px 0px 20px; width: 150px; float: left;'>";
    echo "<input id='newMovieDirector' placeholder='Director' style='margin: 10px 0px 0px 20px; width: 150px; float: left;'>";
    echo "<input id='newMovieCinematography' placeholder='Cinematographer' style='margin: 10px 0px 0px 20px; width: 150px; float: left;'>";
    echo "<input id='newMovieCollection' placeholder='Collection' style='margin: 10px 0px 0px 20px; width: 150px; float: left;'>";
    echo "<input id='newMovieProvenance' placeholder='Provenance' style='margin: 10px 0px 0px 20px; width: 150px; float: left;'>";
    echo "<input id='newMovieDescription' placeholder='Description' style='margin: 10px 0px 0px 20px; width: 150px; float: left;'>";
    echo "<input id='newMoviePraktikantin' placeholder='Praktikantin' style='margin: 10px 0px 0px 20px; width: 65px; float: left;'>";
    echo "<input id='newMovieEditorV' placeholder='EditorV' style='margin: 10px 0px 0px 20px; width: 65px; float: left;'>";
    echo "<input id='newMovieStatus' placeholder='Status' style='margin: 10px 0px 0px 20px; width: 65px; float: left;'>";
    echo "<input id='newMoviePOnline' placeholder='POnline' style='margin: 10px 0px 0px 20px; width: 65px; float: left;'>";

    echo "<br clear='both'>";

    echo "<script type = \"text/javascript\">\n";
    echo "  function enableSaveButton() {\n";
    echo "      if (document.getElementById('fileName').value == \"\" || document.getElementById('M4VfileName').value == \"\" || document.getElementById('OGGfileName').value == \"\" || document.getElementById('ThumbnailBuilder').value != 'Done! :)') {\n";
    echo "          return;\n";
    echo "      }\n";
    echo "      document.getElementById('saveNewFilmDetailsButton').disabled = false;\n";
    echo "  }\n";
    echo "  function saveFilmDetails() {\n";
    echo "      if (document.getElementById('fileName').value == \"\" || document.getElementById('M4VfileName').value == \"\" || document.getElementById('OGGfileName').value == \"\" || document.getElementById('ThumbnailBuilder').value != 'Done! :)') {\n";
    echo "          return;\n";
    echo "      }\n";
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
            . "\"&newMovieFilmNumber=\"+document.getElementById('newMovieFilmNumber').value+"
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
            . "\"&iconicImage=\"+document.getElementById('fileName').value+"
            . "\"&m4vFilename=\"+document.getElementById('M4VfileName').value+"
            . "\"&oggFilename=\"+document.getElementById('OGGfileName').value"
            . ");\n";
    echo "  }\n";
    echo "      function saveComplete(evt) {\n";
    echo "          // This event is raised when the server sends back a response\n";
    echo "          console.log(evt.target.responseText);";
    echo "          document.getElementById('saveNewFilmDetailsButton').disabled = true;\n";
    echo "          alert(evt.target.responseText);\n";
    echo "      }\n";
    echo "</script>\n";
    
    echo "<div style='margin: 10px 0px 0px 20px; width: 300px; float: left;'>";
    echo "  <div name=\"files_div\" id=\"files_div\"><br clear='both'>";
    echo "  Upload Image File: <br clear='both'><br clear='both'><input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\" size=\"30\" style=\"width: 200px;\" onChange=\"fileSelected();\"><br clear='both'>\n";
    echo "  <div style=\"display:block;\" id=\"fileName\"></div> <div style=\"display:block;\" id=\"fileSize\"></div> <div style=\"display:block;\" id=\"fileType\"></div><br>\n";
    echo "  <input id=\"uploadProgress\" type=\"button\" value=\"Upload\" onclick=\"uploadFile();\">\n";
    echo "  </div>\n";
    echo "</div>";
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
    echo "          var xhr = new XMLHttpRequest();\n";
    echo "          xhr.upload.addEventListener(\"progress\", uploadProgress, false);\n";
    echo "          xhr.addEventListener(\"load\", uploadComplete, false);\n";
    echo "          xhr.addEventListener(\"error\", uploadFailed, false);\n";
    echo "          xhr.addEventListener(\"abort\", uploadCanceled, false);\n";
    echo "          xhr.open(\"POST\", \"_ajax/iconicImageUploader.php\");\n";
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
    echo "          console.log(evt.target.responseText);";
    echo "          if (evt.target.responseText != '') {\n";
    echo "              alert(evt.target.responseText);\n";
    echo "              document.getElementById('uploadProgress').value = \"Upload\";\n";
    echo "              document.getElementById('fileToUpload').value = \"\";\n";
    echo "              document.getElementById('fileName').innerHTML = \"\";\n";
    echo "              document.getElementById('fileSize').innerHTML = \"\";\n";
    echo "              document.getElementById('fileType').innerHTML = \"\";\n";
    echo "              return;\n";
    echo "          }\n";
    echo "          alert('Image Upload Complete');\n";
    echo "          enableSaveButton();\n";
    echo "          document.getElementById('fileToUpload').disabled = true;\n";
    echo "          document.getElementById('uploadProgress').disabled = true;\n";
    echo "      }\n";
    echo "      function uploadFailed(evt) {\n";
    echo "          alert(\"There was an error attempting to upload the file.\");\n";
    echo "      }\n";
    echo "      function uploadCanceled(evt) {\n";
    echo "          alert(\"The upload has been canceled by the user or the browser dropped the connection.\");\n";
    echo "      }\n";
    echo "  </script>\n";

    echo "<div style='margin: 10px 0px 0px 20px; width: 300px; float: left;'>";
    echo "  <div name=\"files_div\" id=\"files_div\"><br clear='both'>";
    echo "  Upload M4V Video File: <br clear='both'><br clear='both'><input type=\"file\" name=\"M4VfileToUpload\" id=\"M4VfileToUpload\" size=\"30\" style=\"width: 200px;\" onChange=\"M4VfileSelected();\"><br clear='both'>\n";
    echo "  <div style=\"display:block;\" id=\"M4VfileName\"></div> <div style=\"display:block;\" id=\"M4VfileSize\"></div> <div style=\"display:block;\" id=\"M4VfileType\"></div><br>\n";
    echo "  <input id=\"M4VuploadProgress\" type=\"button\" value=\"Upload\" onclick=\"uploadM4VFile();\">\n";
    echo "  </div>\n";
    echo "</div>";
    echo "  <script type=\"text/javascript\">\n";
    echo "      function M4VfileSelected() {\n";
    echo "          var file = document.getElementById('M4VfileToUpload').files[0];\n";
    echo "          if (file) {\n";
    echo "              var fileSize = 0;\n";
    echo "              if (file.size > 1024 * 1024) fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString()+'MB';\n";
    echo "              else fileSize = (Math.round(file.size * 100 / 1024) / 100).toString()+'KB';\n";
    echo "              document.getElementById('M4VfileName').innerHTML = file.name;\n";
    echo "              document.getElementById('M4VfileSize').innerHTML = fileSize;\n";
    echo "              document.getElementById('M4VfileType').innerHTML = file.type;\n";
    echo "          }\n";
    echo "      }\n";
    echo "      function uploadM4VFile() {\n";
    echo "          var fd = new FormData();\n";
    echo "          fd.append(\"M4VfileToUpload\", document.getElementById('M4VfileToUpload').files[0]);\n";
    echo "          var xhr = new XMLHttpRequest();\n";
    echo "          xhr.upload.addEventListener(\"progress\", M4VuploadProgress, false);\n";
    echo "          xhr.addEventListener(\"load\", M4VuploadComplete, false);\n";
    echo "          xhr.addEventListener(\"error\", M4VuploadFailed, false);\n";
    echo "          xhr.addEventListener(\"abort\", M4VuploadCanceled, false);\n";
    echo "          xhr.open(\"POST\", \"_ajax/M4VUploader.php\");\n";
    echo "          xhr.send(fd);\n";
    echo "      }\n";
    echo "      function M4VuploadProgress(evt) {\n";
    echo "          if (evt.lengthComputable) {\n";
    echo "              var percentComplete = Math.round(evt.loaded * 100 / evt.total);\n";
    echo "              document.getElementById('M4VuploadProgress').value = percentComplete.toString()+'%';\n";
    echo "          }\n";
    echo "      }\n";
    echo "      function M4VuploadComplete(evt) {\n";
    echo "          // This event is raised when the server sends back a response\n";
    echo "          console.log(evt.target.responseText);";
    echo "          if (evt.target.responseText != '') {\n";
    echo "              alert(evt.target.responseText);\n";
    echo "              document.getElementById('M4VuploadProgress').value = \"Upload\";\n";
    echo "              document.getElementById('M4VfileToUpload').value = \"\";\n";
    echo "              document.getElementById('M4VfileName').innerHTML = \"\";\n";
    echo "              document.getElementById('M4VfileSize').innerHTML = \"\";\n";
    echo "              document.getElementById('M4VfileType').innerHTML = \"\";\n";
    echo "              return;\n";
    echo "          }\n";
    echo "          alert('M4V Upload Complete');\n";
    echo "          enableSaveButton();\n";
    echo "          document.getElementById('M4VfileToUpload').disabled = true;\n";
    echo "          document.getElementById('M4VuploadProgress').disabled = true;\n";
    echo "          document.getElementById('ThumbnailBuilder').disabled = false;\n";
    echo "      }\n";
    echo "      function M4VuploadFailed(evt) {\n";
    echo "          alert(\"There was an error attempting to upload the file.\");\n";
    echo "      }\n";
    echo "      function M4VuploadCanceled(evt) {\n";
    echo "          alert(\"The upload has been canceled by the user or the browser dropped the connection.\");\n";
    echo "      }\n";
    echo "  </script>\n";

    echo "<div style='margin: 10px 0px 0px 20px; width: 300px; float: left;'>";
    echo "  <div name=\"files_div\" id=\"files_div\"><br clear='both'>";
    echo "  Upload OGG Video File: <br clear='both'><br clear='both'><input type=\"file\" name=\"OGGfileToUpload\" id=\"OGGfileToUpload\" size=\"30\" style=\"width: 200px;\" onChange=\"OGGfileSelected();\"><br clear='both'>\n";
    echo "  <div style=\"display:block;\" id=\"OGGfileName\"></div> <div style=\"display:block;\" id=\"OGGfileSize\"></div> <div style=\"display:block;\" id=\"OGGfileType\"></div><br>\n";
    echo "  <input id=\"OGGuploadProgress\" type=\"button\" value=\"Upload\" onclick=\"uploadOGGFile();\">\n";
    echo "  </div>\n";
    echo "</div>";
    echo "  <script type=\"text/javascript\">\n";
    echo "      function OGGfileSelected() {\n";
    echo "          var file = document.getElementById('OGGfileToUpload').files[0];\n";
    echo "          if (file) {\n";
    echo "              var fileSize = 0;\n";
    echo "              if (file.size > 1024 * 1024) fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString()+'MB';\n";
    echo "              else fileSize = (Math.round(file.size * 100 / 1024) / 100).toString()+'KB';\n";
    echo "              document.getElementById('OGGfileName').innerHTML = file.name;\n";
    echo "              document.getElementById('OGGfileSize').innerHTML = fileSize;\n";
    echo "              document.getElementById('OGGfileType').innerHTML = file.type;\n";
    echo "          }\n";
    echo "      }\n";
    echo "      function uploadOGGFile() {\n";
    echo "          var fd = new FormData();\n";
    echo "          fd.append(\"fileToUpload\", document.getElementById('OGGfileToUpload').files[0]);\n";
    echo "          var xhr = new XMLHttpRequest();\n";
    echo "          xhr.upload.addEventListener(\"progress\", OGGuploadProgress, false);\n";
    echo "          xhr.addEventListener(\"load\", OGGuploadComplete, false);\n";
    echo "          xhr.addEventListener(\"error\", OGGuploadFailed, false);\n";
    echo "          xhr.addEventListener(\"abort\", OGGuploadCanceled, false);\n";
    echo "          xhr.open(\"POST\", \"_ajax/OGGUploader.php\");\n";
    echo "          xhr.send(fd);\n";
    echo "      }\n";
    echo "      function OGGuploadProgress(evt) {\n";
    echo "          if (evt.lengthComputable) {\n";
    echo "              var percentComplete = Math.round(evt.loaded * 100 / evt.total);\n";
    echo "              document.getElementById('OGGuploadProgress').value = percentComplete.toString()+'%';\n";
    echo "          }\n";
    echo "      }\n";
    echo "      function OGGuploadComplete(evt) {\n";
    echo "          // This event is raised when the server sends back a response\n";
    echo "          console.log(evt.target.responseText);";
    echo "          if (evt.target.responseText != '') {\n";
    echo "              alert(evt.target.responseText);\n";
    echo "              document.getElementById('OGGuploadProgress').value = \"Upload\";\n";
    echo "              document.getElementById('OGGfileToUpload').value = \"\";\n";
    echo "              document.getElementById('OGGfileName').innerHTML = \"\";\n";
    echo "              document.getElementById('OGGfileSize').innerHTML = \"\";\n";
    echo "              document.getElementById('OGGfileType').innerHTML = \"\";\n";
    echo "              return;\n";
    echo "          }\n";
    echo "          alert('OGG Upload Complete');\n";
    echo "          enableSaveButton();\n";
    echo "          document.getElementById('OGGfileToUpload').disabled = true;\n";
    echo "          document.getElementById('OGGuploadProgress').disabled = true;\n";
    echo "      }\n";
    echo "      function OGGuploadFailed(evt) {\n";
    echo "          alert(\"There was an error attempting to upload the file.\");\n";
    echo "      }\n";
    echo "      function OGGuploadCanceled(evt) {\n";
    echo "          alert(\"The upload has been canceled by the user or the browser dropped the connection.\");\n";
    echo "      }\n";
    echo "  </script>\n";
    
    echo "<div style='margin: 10px 0px 0px 20px; width: 300px; clear: both; float: left;'>";
    echo "  <div name=\"files_div\" id=\"files_div\"><br clear='both'>";
    echo "  Generate Thumbnails: <br clear='both'><br clear='both'><input id=\"ThumbnailBuilder\" type=\"button\" value=\"Start\" onclick=\"makeThumbnails();\" style=\"width: 80px;\" disabled>\n";
    echo "  </div>\n";
    echo "</div>";
    echo "  <script type=\"text/javascript\">\n";
    echo "      function makeThumbnails() {\n";
    echo "          var xhr = new XMLHttpRequest();\n";
    echo "          xhr.addEventListener(\"load\", thumbnailsComplete, false);\n";
    echo "          xhr.open(\"POST\", \"_ajax/thumbnailGenerator.php\");\n";
    echo "          xhr.setRequestHeader(\"Content-type\",\"application/x-www-form-urlencoded\");\n";
    echo "          xhr.send(\"location=\"+document.getElementById('M4VfileName').innerText+\"&fps=\"+document.getElementById('newMovieFPS').value);\n";
    echo "          document.getElementById('ThumbnailBuilder').value = '...';\n";
    echo "          document.getElementById('ThumbnailBuilder').disabled = true;\n";
    echo "          showThumbnailActivity();\n";
    echo "      }\n";
    echo "      function showThumbnailActivity() {\n";
    echo "          var thumbnailTimer = setInterval(function() {\n";
    echo "                  if (document.getElementById('ThumbnailBuilder').value == '...') {\n";
    echo "                      document.getElementById('ThumbnailBuilder').value = '.';\n";
    echo "                  } else if (document.getElementById('ThumbnailBuilder').value == '..') {\n";
    echo "                      document.getElementById('ThumbnailBuilder').value = '...';\n";
    echo "                  } else if (document.getElementById('ThumbnailBuilder').value == '.') {\n";
    echo "                      document.getElementById('ThumbnailBuilder').value = '..';\n";
    echo "                  } else {\n";
    echo "                      clearInterval(thumbnailTimer);\n";
    echo "                  }\n";
    echo "              }, 600);\n";
    echo "      }\n";
    echo "      function thumbnailsComplete(evt) {\n";
    echo "          // This event is raised when the server sends back a response\n";
    echo "          console.log(evt.target.responseText);";
    echo "          if (evt.target.responseText == 'fail') {\n";
    echo "              alert(evt.target.responseText);\n";
    echo "              document.getElementById('ThumbnailBuilder').value = 'Start';\n";
    echo "              document.getElementById('ThumbnailBuilder').disabled = false;\n";
    echo "              return;\n";
    echo "          }\n";
    echo "          alert(evt.target.responseText);\n";
    echo "          document.getElementById('ThumbnailBuilder').value = 'Done! :)';\n";
    echo "          enableSaveButton();\n";
    echo "      }\n";
    echo "  </script>\n";
    
    echo "<input id=\"saveNewFilmDetailsButton\" type=\"button\" value=\"Save Film Details\" onclick=\"saveFilmDetails();\" style=\"clear: both; float: right; margin: 25px 20px 0px 0px;\" disabled>\n";
}
