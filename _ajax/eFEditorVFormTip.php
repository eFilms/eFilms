<?php

if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION["login"] != "true") {
    header("Location:login.php");
    $_SESSION["error"] = "<h1 style='color:red;'>You don't have privileges to see this page.</h1>";
    exit;
}

/**
 * This script pulls the list of name suggestions from the Config_Naming table
 * in order to populate the field suggestions in the editor.
 */

require_once('/settings.php');
require_once('/includes/functions.php');
require_once(directoryAboveWebRoot().'/db_con.php');

error_reporting(0);
$eFFormTipVisual = (isset($_GET['eFFormTipVisual']) ? $_GET['eFFormTipVisual'] : "");
$eFFormID = (isset($_GET['eFFormID']) ? $_GET['eFFormID'] : "");
$eFFormTip = (isset($_GET['eFFormTip']) ? $_GET['eFFormTip'] : "");
$eFInputName = (isset($_GET['eFInputName']) ? $_GET['eFInputName'] : "");
$eFFormIDL1 = (isset($_GET['eFFormIDL1']) ? $_GET['eFFormIDL1'] : "");
$eFFormIDL2 = (isset($_GET['eFFormIDL2']) ? $_GET['eFFormIDL2'] : "");
$eFFormIDL3 = (isset($_GET['eFFormIDL3']) ? $_GET['eFFormIDL3'] : "");
$FilmID = (isset($_GET['FilmID']) ? $_GET['FilmID'] : "");

switch ($eFFormTipVisual) {
    case "List":
        echo "<table class='eFMovieAnnotationsContainerFormsPopContentTable' id='" . $eFFormTip . "'><tbody id='" . $eFFormID . "'>";

        $anfrage_TipL = "SELECT * FROM eFilm_Config_Naming WHERE eFFormTip='" . $eFFormTip . "' ORDER BY List_Entry_GID ASC;";
        $ergebnis_TipL = mysqli_query($localDatabase, $anfrage_TipL);
        $trefferzahl_TipL = mysqli_num_rows($ergebnis_TipL);

        while ($row_TipL = mysqli_fetch_array($ergebnis_TipL)) {

            echo "<tr><td class='eFTipTabCell eFTipTabCellBG" . $row_TipL['List_Entry_GID'] . "' name='" . $eFInputName . "'>" . $row_TipL['List_Entry'] . " / " . $row_TipL['List_Entry_EN'] . "</td></tr>";
        }
        echo "</tbody></table>";
        break;
    case "ListSelf":
        echo "<table class='eFMovieAnnotationsContainerFormsPopContentTable' id='" . $eFFormTip . "'><tbody id='" . $eFFormID . "'>";

        $anfrage_TipS = "SELECT DISTINCT(" . $eFInputName . ") FROM eFilm_Content_Movies_Annotations WHERE AnnotationType_L1='" . $eFFormIDL1 . "' AND AnnotationType_L2='" . $eFFormIDL2 . "' AND AnnotationType_L3='" . $eFFormIDL3 . "' ORDER BY " . $eFInputName . " ASC;";
        $ergebnis_TipS = mysqli_query($localDatabase, $anfrage_TipS);
        $trefferzahl_TipS = mysqli_num_rows($ergebnis_TipS);

        while ($row_TipS = mysqli_fetch_array($ergebnis_TipS)) {
            echo "<tr><td class='eFTipTabCell' name='" . $eFInputName . "'>" . $row_TipS[$eFInputName] . "</td></tr>";
        }
        echo "</tbody></table>";
        break;
    case "Helper":
        switch ($eFFormTip) {
            case "eFSCSRelation":
                //echo "<div id='eFTipHelper'>Relations are not implemented yet!</div>";
                echo "<div id='eFTipOpen' data-formid='" . $eFFormID . "' data-opentype='eFSCSRelation' data-filmid='" . $FilmID . "'>Open Relations Interface</div>";
                break;
            case "eFSCDLocationG":
                echo "<script  type='text/javascript'>
						function initmaps(){
	var latitude = 48.208727825206;
	var longitude = 16.372473763275;
	
        var proj4326 = new OpenLayers.Projection('EPSG:4326');
        var projmerc = new OpenLayers.Projection('EPSG:900913');

        var mapCenterPositionAsLonLat = new OpenLayers.LonLat(longitude, latitude);
        var mapCenterPositionAsMercator = mapCenterPositionAsLonLat.transform(proj4326, projmerc);
        var mapZoom = 13;

        osmMap = new OpenLayers.Map('locationPickerMap', {
    			controls: [
    				new OpenLayers.Control.KeyboardDefaults(),
    				new OpenLayers.Control.Navigation(),
    	            //new OpenLayers.Control.LayerSwitcher({'ascending':false}),
    				new OpenLayers.Control.PanZoomBar(),
                    new OpenLayers.Control.MousePosition()
                ],
    			maxExtent:
                    new OpenLayers.Bounds(-20037508.34,-20037508.34,
                                           20037508.34, 20037508.34),
    			numZoomLevels: 16,
                maxResolution: 156543,
                units: 'm',
                projection: projmerc,
                displayProjection: proj4326
        } );

        var osmLayer = new OpenLayers.Layer.OSM('OpenStreetMap');
        osmMap.addLayer(osmLayer);

        osmMap.setCenter(mapCenterPositionAsMercator, mapZoom);
        
        var locationPickerLayer = new OpenLayers.Layer.Vector('LocationPicker Marker');
        osmMap.addLayer(locationPickerLayer);
        var locationPickerPoint = new OpenLayers.Geometry.Point(mapCenterPositionAsMercator.lon, mapCenterPositionAsMercator.lat);
        var locationPickerMarkerStyle = {externalGraphic: '_img/mappointer.png', graphicHeight: 37, graphicWidth: 32, graphicYOffset: -37, graphicXOffset: -16 };
        var locationPickerVector = new OpenLayers.Feature.Vector(locationPickerPoint, null, locationPickerMarkerStyle);
        locationPickerLayer.addFeatures(locationPickerVector);
        
        var dragFeature = new OpenLayers.Control.DragFeature(locationPickerLayer, 
				{ 
        			onComplete:	function( feature, pixel ) {
        				var selectedPositionAsMercator = new OpenLayers.LonLat(locationPickerPoint.x, locationPickerPoint.y);
        			 	var selectedPositionAsLonLat = selectedPositionAsMercator.transform(projmerc, proj4326);
        				//$('#poiLatitude').val(selectedPositionAsLonLat.lat);
        		    	//$('#poiLongitude').val(selectedPositionAsLonLat.lon);
        		    	$('#eFMovieAnnotationsContainerForms').find('form[id=' + " . $eFFormID . " + '] input[name=coverage_S_Latitude]').val(selectedPositionAsLonLat.lat);
        		    	$('#eFMovieAnnotationsContainerForms').find('form[id=' + " . $eFFormID . " + '] input[name=coverage_S_Longitude]').val(selectedPositionAsLonLat.lon);
						//Location Name von Google holen
					    /*$.getJSON('http://maps.google.com/maps/api/geocode/json?address=' + selectedPositionAsLonLat.lat + ',' + selectedPositionAsLonLat.lon + '&sensor=false', function(data) {*/
					    $.getJSON('_ajax/eFEditorVFormTipGeoLocationNameGet.php?eFGeoLat=' + selectedPositionAsLonLat.lat + '&eFGeoLon=' + selectedPositionAsLonLat.lon , function(data) {
					    	dataP = data.results;
							dataPA = dataP[0];
					    	//console.log(dataPA['formatted_address']);
					    	//$('#poiAddress').val(dataPA['formatted_address']);
					    	$('#eFMovieAnnotationsContainerForms').find('form[id=' + " . $eFFormID . " + '] input[name=coverage_S_Geoname]').val(dataPA['formatted_address']);
					    });
        			}
   				}
        );
        osmMap.addControl(dragFeature);
        dragFeature.activate();        
    }
						
						initmaps();
						
						
						</script><div id='locationPickerMap' ></div>";
                break;
            case "eFSCDDate":
                echo "
						<table id='eFTipHelperTimeSelectTable' class='eFTipHelperTimeSelectTable'>
<tr><td class='eFTipTimeTableLegend'>Date From:</td><td class='eFTipTimeTableJJJJ'><select id='eFDateFromTipJJJJ' name='eFDateFromTipJJJJ'>
<option value='1934'>1934</option>
<option value='1935'>1935</option>
<option value='1936'>1936</option>
<option value='1937'>1937</option>
<option value='1938'>1938</option>
<option value='1939'>1939</option>
<option value='1940'>1940</option>
<option value='1941'>1941</option>
<option value='1942'>1942</option>
<option value='1943'>1943</option>
<option value='1944'>1944</option>
<option value='1945'>1945</option>
</select></td><td class='eFTipTimeTableJJJJ'><select id='eFDateFromTipMM' name='eFDateFromTipMM'>
<option value='01'>01</option>
<option value='02'>02</option>
<option value='03'>03</option>
<option value='04'>04</option>
<option value='05'>05</option>
<option value='06'>06</option>
<option value='07'>07</option>
<option value='08'>08</option>
<option value='09'>09</option>
<option value='10'>10</option>
<option value='11'>11</option>
<option value='12'>12</option>
</select></td><td class='eFTipTimeTableJJJJ'><select id='eFDateFromTipDD' name='eFDateFromTipDD'>
<option value='01'>01</option>
<option value='02'>02</option>
<option value='03'>03</option>
<option value='04'>04</option>
<option value='05'>05</option>
<option value='06'>06</option>
<option value='07'>07</option>
<option value='08'>08</option>
<option value='09'>09</option>
<option value='10'>10</option>
<option value='11'>11</option>
<option value='12'>12</option>
<option value='13'>13</option>
<option value='14'>14</option>
<option value='15'>15</option>
<option value='16'>16</option>
<option value='17'>17</option>
<option value='18'>18</option>
<option value='19'>19</option>
<option value='20'>20</option>
<option value='21'>21</option>
<option value='22'>22</option>
<option value='23'>23</option>
<option value='24'>24</option>
<option value='25'>25</option>
<option value='26'>26</option>
<option value='27'>27</option>
<option value='28'>28</option>
<option value='29'>29</option>
<option value='30'>30</option>
<option value='31'>31</option>
</select></td><td class='eFTipTimeTableJJJJ'><select id='eFDateFromTipHH' name='eFDateFromTipHH'>
<option value='00:00'>00:00</option>
<option value='01:00'>01:00</option>
<option value='02:00'>02:00</option>
<option value='03:00'>03:00</option>
<option value='04:00'>04:00</option>
<option value='05:00'>05:00</option>
<option value='06:00'>06:00</option>
<option value='07:00'>07:00</option>
<option value='08:00'>08:00</option>
<option value='09:00'>09:00</option>
<option value='10:00'>10:00</option>
<option value='11:00'>11:00</option>
<option value='12:00'>12:00</option>
<option value='13:00'>13:00</option>
<option value='14:00'>14:00</option>
<option value='15:00'>15:00</option>
<option value='16:00'>16:00</option>
<option value='17:00'>17:00</option>
<option value='18:00'>18:00</option>
<option value='19:00'>19:00</option>
<option value='20:00'>20:00</option>
<option value='21:00'>21:00</option>
<option value='22:00'>22:00</option>
<option value='23:00'>23:00</option>
</select></td>
</tr>
<tr>
<td class='eFTipTimeTableLegend'>Date To:</td><td class='eFTipTimeTableJJJJ'><select id='eFDateToTipJJJJ' name='eFDateToTipJJJJ'>
<option value='1934'>1934</option>
<option value='1935'>1935</option>
<option value='1936'>1936</option>
<option value='1937'>1937</option>
<option value='1938'>1938</option>
<option value='1939'>1939</option>
<option value='1940'>1940</option>
<option value='1941'>1941</option>
<option value='1942'>1942</option>
<option value='1943'>1943</option>
<option value='1944'>1944</option>
<option value='1945'>1945</option>
</select></td><td class='eFTipTimeTableJJJJ'><select id='eFDateToTipMM' name='eFDateToTipMM'>
<option value='01'>01</option>
<option value='02'>02</option>
<option value='03'>03</option>
<option value='04'>04</option>
<option value='05'>05</option>
<option value='06'>06</option>
<option value='07'>07</option>
<option value='08'>08</option>
<option value='09'>09</option>
<option value='10'>10</option>
<option value='11'>11</option>
<option value='12'>12</option>
</select></td><td class='eFTipTimeTableJJJJ'><select id='eFDateToTipDD' name='eFDateToTipDD'>
<option value='01'>01</option>
<option value='02'>02</option>
<option value='03'>03</option>
<option value='04'>04</option>
<option value='05'>05</option>
<option value='06'>06</option>
<option value='07'>07</option>
<option value='08'>08</option>
<option value='09'>09</option>
<option value='10'>10</option>
<option value='11'>11</option>
<option value='12'>12</option>
<option value='13'>13</option>
<option value='14'>14</option>
<option value='15'>15</option>
<option value='16'>16</option>
<option value='17'>17</option>
<option value='18'>18</option>
<option value='19'>19</option>
<option value='20'>20</option>
<option value='21'>21</option>
<option value='22'>22</option>
<option value='23'>23</option>
<option value='24'>24</option>
<option value='25'>25</option>
<option value='26'>26</option>
<option value='27'>27</option>
<option value='28'>28</option>
<option value='29'>29</option>
<option value='30'>30</option>
<option value='31'>31</option>
</select></td><td class='eFTipTimeTableJJJJ'><select id='eFDateToTipHH' name='eFDateToTipHH'>
<option value='00:00'>00:00</option>
<option value='01:00'>01:00</option>
<option value='02:00'>02:00</option>
<option value='03:00'>03:00</option>
<option value='04:00'>04:00</option>
<option value='05:00'>05:00</option>
<option value='06:00'>06:00</option>
<option value='07:00'>07:00</option>
<option value='08:00'>08:00</option>
<option value='09:00'>09:00</option>
<option value='10:00'>10:00</option>
<option value='11:00'>11:00</option>
<option value='12:00'>12:00</option>
<option value='13:00'>13:00</option>
<option value='14:00'>14:00</option>
<option value='15:00'>15:00</option>
<option value='16:00'>16:00</option>
<option value='17:00'>17:00</option>
<option value='18:00'>18:00</option>
<option value='19:00'>19:00</option>
<option value='20:00'>20:00</option>
<option value='21:00'>21:00</option>
<option value='22:00'>22:00</option>
<option value='23:00'>23:00</option>
</select></td>
</tr>
</table>
<table id='eFTipHelperTimeSelectTable2' class='eFTipHelperTimeSelectTable'>
<tr>
<td class='eFTipTimeTableLegend'>Type:</td><td rowspan='3' class='eFTipTimeTableRS3'>period <input type='radio' name='eFDateTypeTip' id='eFDateTypeTipPeriod' value='period'> point in time <input type='radio' name='eFDateTypeTip' id='eFDateTypeTipPIT' value='PIT'></td>
</tr>
</table>
<table id='eFTipHelperTimeSelectTable3' class='eFTipHelperTimeSelectTable'>
<tr>
<td rowspan='4' class='eFTipTimeTableOK'><button id='eFDateTipSelect'>ok</button></td>
</tr>
</table>
						
						
						
						";
                break;
            //no INPUT
            case "eFSCSSequenceNumber":
                echo "<div id='eFTipHelper'>Sequence Numbers will be automatically created by the system. Input N/A!</div>";
                break;
            case "eFSCSSceneNumber":
                echo "<div id='eFTipHelper'>Scene Numbers will be automatically created by the system. Input N/A!</div>";
                break;
            case "eFSCSShotNumber":
                echo "<div id='eFTipHelper'>Shot Numbers will be automatically created by the system. Input N/A!</div>";
                break;
            case "eFSCSReelNumber":
                echo "<div id='eFTipHelper'>Reel Numbers will be automatically created by the system. Input N/A!</div>";
                break;
        }

        break;
    case "Database":



        switch ($eFFormTip) {

            case "eFSCDLandmark":

                $eFResourceSearchExtension = " WHERE eFilm_ReSources_L1.Category='Coverage' AND eFilm_ReSources_L1.Type='Landmark'";
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
                    //print_r($row);
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
                //print_r($listing);
                echo "<table class='eFMovieAnnotationsContainerFormsPopContentTable' id='" . $eFFormTip . "'><tbody id='" . $eFFormID . "'>";
                foreach ($parent_listing as $k => $v) {

                    foreach ($listing as $k2 => $v2) {
                        if ($v2['ID'] == $v['ID_R_L1'] && $v2['content']['Fieldname'] == 'Landmark_Name') {
                            echo "<tr><td class='eFTipTabCell' name='" . $eFInputName . "' id='" . $v['ID_R_L1'] . "'>" . $v2['content']['Fieldcontent'] . "</td></tr>";
                        }
                    }
                }
                echo "</tbody></table>";
                break;
            case "eFSCDPerson":

                $eFResourceSearchExtension = " WHERE eFilm_ReSources_L1.Category='Subject' AND eFilm_ReSources_L1.Type='Person'";
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
                    //print_r($row);
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

                echo "<table class='eFMovieAnnotationsContainerFormsPopContentTable' id='" . $eFFormTip . "'><tbody id='" . $eFFormID . "'>";
                foreach ($parent_listing as $k => $v) {
                    foreach ($listing as $k2 => $v2) {

                        if ($v2['ID'] == $v['ID_R_L1'] && $v2['content']['Fieldname'] == 'Last Name') {
                            $nameArray[$v['ID_R_L1']] = $v2['content']['Fieldcontent'] . ", ";
                        }
                        if ($v2['ID'] == $v['ID_R_L1'] && $v2['content']['Fieldname'] == 'First Name') {
                            $nameArray[$v['ID_R_L1']] .= $v2['content']['Fieldcontent'];
                        }
                    }
                }
                asort($nameArray);
                foreach ($nameArray as $id => $name) {
                    echo "<tr><td class='eFTipTabCell' name='" . $eFInputName . "' id='" . $id . "'>";
                    echo $name;
                    echo "</td></tr>";
                }
                echo "</tbody></table>";

                break;
            case "eFSCDOrganisation":
                $eFResourceSearchExtension = " WHERE eFilm_ReSources_L1.Category='Subject' AND eFilm_ReSources_L1.Type='Organisation'";
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
                    //print_r($row);
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
                //print_r($listing);
                echo "<table class='eFMovieAnnotationsContainerFormsPopContentTable' id='" . $eFFormTip . "'><tbody id='" . $eFFormID . "'>";
                foreach ($parent_listing as $k => $v) {

                    foreach ($listing as $k2 => $v2) {

                        if ($v2['ID'] == $v['ID_R_L1'] && $v2['content']['Fieldname'] == 'Organisation Name') {
                            echo "<tr><td class='eFTipTabCell' name='" . $eFInputName . "' id='" . $v['ID_R_L1'] . "'>";
                            echo "<div id='eFOName'>" . $v2['content']['Fieldcontent'] . "</div>";
                        }
                        if ($v2['ID'] == $v['ID_R_L1'] && $v2['content']['Fieldname'] == 'Organization Type') {
                            echo "<div id='eFOType'>" . $v2['content']['Fieldcontent'] . "</div>";
                            echo "</td></tr>";
                        }
                    }
                }
                echo "</tbody></table>";

                break;
            case "eFSCDHistoricEvent":
                $eFResourceSearchExtension = " WHERE eFilm_ReSources_L1.Category='Subject' AND eFilm_ReSources_L1.Type='Historic Event'";
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
                    //print_r($row);
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
                //print_r($listing);
                echo "<table class='eFMovieAnnotationsContainerFormsPopContentTable' id='" . $eFFormTip . "'><tbody id='" . $eFFormID . "'>";
                foreach ($parent_listing as $k => $v) {

                    foreach ($listing as $k2 => $v2) {

                        if ($v2['ID'] == $v['ID_R_L1'] && $v2['content']['Fieldname'] == 'Event Title') {
                            echo "<tr><td class='eFTipTabCell' name='" . $eFInputName . "' id='" . $v['ID_R_L1'] . "'>";
                            echo "<div id='eFHETitle'>" . $v2['content']['Fieldcontent'] . "</div>";
                        }
                        if ($v2['ID'] == $v['ID_R_L1'] && $v2['content']['Fieldname'] == 'Event Category') {

                            echo "<div id='eFHEType'>" . $v2['content']['Fieldcontent'] . "</div>";
                        }
                        if ($v2['ID'] == $v['ID_R_L1'] && $v2['content']['Fieldname'] == 'startdate') {
                            echo "<div id='eFHEDate'>" . $v2['content']['Fieldcontent'] . " - ";
                        }
                        if ($v2['ID'] == $v['ID_R_L1'] && $v2['content']['Fieldname'] == 'enddate') {
                            echo $v2['content']['Fieldcontent'] . "</div>";
                            echo "</td></tr>";
                        }
                    }
                }
                echo "</tbody></table>";

                break;
        }

        break;
}
?>