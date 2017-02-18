<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

if (!isset($_SESSION))  {
    session_start();
}

if ($_SESSION["login"] != "true") {
    header("Location:login.php");
    $_SESSION["error"] = "<h1 style='color:red;'>You don't have privileges to see this page.</h1>";
    exit;
}

include_once('settings.php');
?>

<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8" />
	<title>Ephemeral Films</title>
	<!-- basis css -->
	<!-- eF EditorP css -->
	<link id="mainstylesheet" rel="stylesheet" type="text/css" href="_css/eFEditorV.css" media="screen" />
	<link id="mainstylesheet" rel="stylesheet" type="text/css" href="_css/eFEditorVResourcesInMovies_Movie.css" media="screen" />
	<!-- /eF EditorP css -->
	<!-- jquery ui tools-->
	<link rel="stylesheet" type="text/css" href="_css/smoothness/jquery-ui-1.8.17.custom.css" media="screen" />
	<!-- /basis css -->
	<!-- jquery -->
		<!-- jquery base-->
		<script>
		var storeURL = '/uploads/';
		</script>
		<script type="text/javascript" src="_js/jQBaseUI/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="_js/jQBaseUI/jquery-ui-1.8.17.custom.min.js"></script>
		<!-- <script type="text/javascript" src="_js/jQBaseUI/jquery.ui.touch-punch.min"></script>-->
		<!-- jquery ui tools-->
		<script type="text/javascript" src="_js/jQBaseUI/jquery.tools.min.js"></script>
		<!-- jquery media-->
		<script type="text/javascript" src="_js/jQMedia/jquery.media.core.js"></script>
		<script type="text/javascript" src="_js/jQMedia/jquery.media.timeline.js"></script>
		<script type="text/javascript" src="_js/jQMedia/plugins/syncwith.js"></script>
		<script type="text/javascript" src="_js/jQMedia/plugins/tocanvas.js"></script>
		<script type="text/javascript" src="_js/jQMedia/plugins/tracks.js"></script>
		<!-- jquery Editable -->
		<script type="text/javascript" src="_js/jQEditable/jquery.jeditable.mini.js"></script>
		<!-- jquery Forms -->
		<script type="text/javascript" src="_js/jQForms/jquery.form.js"></script>
		<!-- jquery ScrollTo -->
		<script type="text/javascript" src="_js/jQScrollTo/jquery.scrollTo-1.4.2-min.js"></script>
		<!-- /jquery -->
		<!-- OpenLayers -->
		<script type="text/javascript" src="_js/OpenLayers/OpenLayers.js"></script>
		<!-- /OpenLayers -->
		<!-- eF JS -->
		<script type="text/javascript" src="_js/eFEditorV/eFEditorV.js"></script>
		<!-- /eF JS -->
</head>
<body data-remip="<?php echo $_SERVER["REMOTE_ADDR"]; ?>">
<!-- eF Preview Container -->
<div id="eFPreviewsContainer">
	<div class="eFPreviewsContainerSelect" id="eFPreviewsContainerP1" data-demo="D1">1</div>
	<div class="eFPreviewsContainerSelect" id="eFPreviewsContainerP2" data-demo="D2">2</div>
	<div id="eFPreviewsContainerClose">X</div>
	<div id="eFPreviewsContainerContent"></div>
</div>
<!-- eF Preview Container -->
<!-- eF ReSources Container -->
<div id="eFResourcesContainer">
	<div id="eFResourcesContainerContent"></div>
	<div id="eFResourcesContainerClose">X</div>
</div>
<!-- /eF ReSources Container -->
<!-- eF eFResourcesPreviewWindowContainer Container -->
<div id="eFResourcesPreviewWindowContainer">
	<div id="eFResourcesPreviewWindowContainerContent"></div>
	<div id="eFResourcesPreviewWindowContainerClose">X</div>
</div>
<!-- /eF eFResourcesPreviewWindowContainer Container -->
<!-- eF Config Container -->
<div id="eFConfigContainer">
	<div id="eFConfigContainerContent"></div>
	<div id="eFConfigContainerClose">X</div>

</div>
<!-- /eF Config Container -->

<!-- eF ReSourcesFromMovie Container -->
<div id="eFReSourcesFromMovieContainer" data-formid="">
	<div id="eFReSourcesFromMovieContainerContent"></div>
	<div id="eFReSourcesFromMovieContainerTR"><div id="eFReSourcesFromMovieContainerClose">X</div></div>
	<div id="eFReSourcesFromMovieContainerSeeThrough"></div>
	<div id="eFReSourcesFromMovieContainerBR"></div>
	
</div>
<!-- /eF ReSourcesFromMovie Container -->
<div id="eFDelQuestion"></div>
<!-- eF Header -->
<div id="eFMovieSelectContainer">
	<div class="eFMoviesHeadline">Select Movie</div>
	<div id="eFMoviesSelectListContainer">
	<table>
	
	<?php include ("_ajax/eFEditorVMovieList.php"); ?>
	
	</table>
	</div>
</div>
<div id="eFHeader">
	 <div id="eFLogout"><a href="login.php" title="Logout">Logout</a></div>
                        <div id="eFCurrUser">
                            Current User: <?php echo $_SESSION["uname"]; ?> (<span id="eFUserNik"><?php echo $_SESSION["unik"]; ?></span>)
                        </div>
	<div id="eFOpenArea">
		<div id="eFPreviewOpen" class="eFOpen" onclick="">Preview</div>
<?php
require_once("includes/functions.php");
require_once(directoryAboveWebRoot()."/db_con.php");
$anfrage_ULDI = "SELECT * FROM eFilm_Config_Users WHERE ID_C_Users='".$_SESSION["efuid"]."';";
$ergebnis_ULDI = mysqli_query($localDatabase, $anfrage_ULDI);
$trefferzahl_ULDI=mysqli_num_rows($ergebnis_ULDI);
$row_ULDI = mysqli_fetch_array($ergebnis_ULDI);

if ($row_ULDI['RIGHTS_Resources'] == "NONE") {
    echo "";
} else {
    echo '<div id="eFResourcesOpen" class="eFOpen" onclick="">Resources</div>';
    echo '<div id="eFLog" class="eFOpen" onclick="">Log</div>';
    echo '<div id="eFPublish" class="eFOpen" onclick="">Publish</div>';
}

if ($row_ULDI['RIGHTS_Config'] == "NONE") {
    echo "";
} else {
    echo '<div id="eFConfigOpen" class="eFOpen" onclick="">Config</div>';
}
?>

	</div>
<div id="eFLogoOpen" onclick=""></div>

</div>
<!-- /eF Header -->
<div id="contentConatiner">
<!-- eF Movie Container HTML -->
<div id="eFMovieContainer" data-efposmodus="movie">

</div>
<!-- /eF Movie Container HTML -->
<!-- eF Annotations Container HTML -->
<div id="eFMovieAnnotationsContainer">

<div id="eFMovieAnnotationsContainerMovieID">
	<!--<div id="eFMovieMovieID">Movie ID</div> -->
	<!--<div id="eFMovieMovieIDopenAnotSelect">+</div> -->
</div>


<div id="eFMovieAnnotationsContainerScenarioSelect">
	<div id="eFMovieAnnotationsContainerScenarioSelectM">
		<div class="eFSCMButton" id="eFSCMCoverage" title="Coverage">C</div>
		<div class="eFSCMButton" id="eFSCMSubject" title="Subject">S</div>
		<div class="eFSCMButton" id="eFSCMLanguage" title="Language">L</div>
		<div class="eFSCMButton" id="eFSCMRelation" title="Relation">R</div>
		<div class="eFSCMButton" id="eFSCMDescription" title="Description">D</div>
	</div>
	
	<div class="eFMovieAnnotationsContainerScenarioSelectS" id="eFMovieAnnotationsContainerScenarioSelectSCoverage">
		<div class="eFSCDButton" id="eFSCSSpatial" title="Spatial">S</div>
		<div class="eFSCDButton" id="eFSCSTemporal" title="Temporal">T</div>
	</div>
	<div class="eFMovieAnnotationsContainerScenarioSelectS" id="eFMovieAnnotationsContainerScenarioSelectSSubject">
		<div class="eFSCDButton" id="eFSCSPerson" title="Person">P</div>
		<div class="eFSCDButton" id="eFSCSOrganization" title="Organization">O</div>
		<div class="eFSCDButton" id="eFSCSHistoricEvent" title="Historic Event">H</div>
	</div>
	<div class="eFMovieAnnotationsContainerScenarioSelectS" id="eFMovieAnnotationsContainerScenarioSelectSLanguage">
		<div class="eFSCDButton" id="eFSCSLanguage" title="Language">L</div>
	</div>
	<div class="eFMovieAnnotationsContainerScenarioSelectS" id="eFMovieAnnotationsContainerScenarioSelectSRelation">
		<div class="eFSCDButton" id="eFSCSRelation" title="Relation">R</div>
	</div>
	<div class="eFMovieAnnotationsContainerScenarioSelectS" id="eFMovieAnnotationsContainerScenarioSelectSDescription">
		<div class="eFSCDButton" id="eFSCSNumbering" title="Numbering">N</div>
		<div class="eFSCDButton" id="eFSCSImageContent" title="Image Content">C</div>
		<div class="eFSCDButton" id="eFSCSFilmAnalysis" title="Film Analysis">A</div>
		<div class="eFSCDButton" id="eFSCSInterpretation" title="Interpretation">I</div>
		<div class="eFSCDButton" id="eFSCSEducationalRemarks" title="Educational Remarks">P</div>
	</div>
	
	<div class="eFMovieAnnotationsContainerScenarioSelectD" id="eFMovieAnnotationsContainerScenarioSelectDCoverageSpatial">
		<div class="eFSCDetail" id="eFSCDLocationN" title="Location (Name)">Location (Name)</div>
		<div class="eFSCDetail" id="eFSCDLocationG" title="Location (Geoinfo)">Location (Geoinfo)</div>
		<div class="eFSCDetail" id="eFSCDLandmark" title="Landmark">Landmark</div>
	</div>
	
	<div class="eFMovieAnnotationsContainerScenarioSelectD" id="eFMovieAnnotationsContainerScenarioSelectDCoverageTemporal">
		<div class="eFSCDetail" id="eFSCDDate" title="Date">Date</div>
	</div>
	
	<div class="eFMovieAnnotationsContainerScenarioSelectD" id="eFMovieAnnotationsContainerScenarioSelectDSubjectPerson">
		<div class="eFSCDetail" id="eFSCDPerson" title="Person">Person</div>
	</div>
	<div class="eFMovieAnnotationsContainerScenarioSelectD" id="eFMovieAnnotationsContainerScenarioSelectDSubjectOrganization">
		<div class="eFSCDetail" id="eFSCDOrganisation" title="Organization">Organization</div>
	</div>
	<div class="eFMovieAnnotationsContainerScenarioSelectD" id="eFMovieAnnotationsContainerScenarioSelectDSubjectHistoricEvent">
		<div class="eFSCDetail" id="eFSCDHistoricEvent" title="Historic Event">Historic Event</div>
	</div>
	<div class="eFMovieAnnotationsContainerScenarioSelectD" id="eFMovieAnnotationsContainerScenarioSelectDLanguage">
		<div class="eFSCDetail" id="eFSCSLanguage" title="Language">Language</div>
	</div>
	<div class="eFMovieAnnotationsContainerScenarioSelectD" id="eFMovieAnnotationsContainerScenarioSelectDRelation">
		<div class="eFSCDetail" id="eFSCSRelation" title="Relation">Relation</div>
	</div>
	
	<div class="eFMovieAnnotationsContainerScenarioSelectD" id="eFMovieAnnotationsContainerScenarioSelectDDescriptionNumbering">
		<div class="eFSCDetail" id="eFSCSSequenceNumber" title="Sequence Number">Sequence Number</div>
		<div class="eFSCDetail" id="eFSCSSceneNumber" title="Scene Number">Scene Number</div>
		<div class="eFSCDetail" id="eFSCSShotNumber" title="Shot Number">Shot Number</div>
		<div class="eFSCDetail" id="eFSCSReelNumber" title="Reel Number">Reel Number</div>
	</div>
	
	<div class="eFMovieAnnotationsContainerScenarioSelectD" id="eFMovieAnnotationsContainerScenarioSelectDDescriptionImageContent">
		<div class="eFSCDetail" id="eFSCSSpacialType" title="Spacial Type">Spacial Type</div>
		<div class="eFSCDetail" id="eFSCSSpacialUse" title="Spacial Use">Spacial Use</div>
		<div class="eFSCDetail" id="eFSCSPersonsNumber" title="Persons Number">Persons Number</div>
		<div class="eFSCDetail" id="eFSCSPersonsGender" title="Persons Gender">Persons Gender</div>
		<div class="eFSCDetail" id="eFSCSPersonsAge" title="Persons Age">Persons Age</div>
		<div class="eFSCDetail" id="eFSCSPersonsAction" title="Persons Action">Persons Action</div>
		<div class="eFSCDetail" id="eFSCSVisualEventType" title="Visual Event Type">Visual Event Type</div>
		<div class="eFSCDetail" id="eFSCSVisualEvent" title="Visual Event">Visual Event</div>
		<div class="eFSCDetail" id="eFSCSAudioEventType" title="Audio Event Type">Audio Event Type</div>
		<div class="eFSCDetail" id="eFSCSAudioEvent" title="Audio Event">Audio Event</div>
		<div class="eFSCDetail" id="eFSCSIntertitleTranscript" title="Intertitle Transcript">Intertitle Transcript</div>
		<div class="eFSCDetail" id="eFSCSWrittenElementsTranscript" title="Written Elements Transcript">Written Elements Transcript</div>
		<div class="eFSCDetail" id="eFSCSWrittenElementsLanguage" title="Written Elements Language">Written Elements Language</div>
		<div class="eFSCDetail" id="eFSCSSpokenElementsTranscript" title="Spoken Elements Transcript">Spoken Elements Transcript</div>
		<div class="eFSCDetail" id="eFSCSPunctum" title="Punctum">Punctum</div>
	</div>
	
	<div class="eFMovieAnnotationsContainerScenarioSelectD" id="eFMovieAnnotationsContainerScenarioSelectDDescriptionFilmAnalysis">
		<div class="eFSCDetail" id="eFSCSShotType" title="Shot Type">Shot Type</div>
		<div class="eFSCDetail" id="eFSCSCameraPosition" title="Camera Position">Camera Position</div>
		<div class="eFSCDetail" id="eFSCSEditing" title="Editing">Editing</div>
	</div>
	
	<div class="eFMovieAnnotationsContainerScenarioSelectD" id="eFMovieAnnotationsContainerScenarioSelectDDescriptionInterpretation">
		<div class="eFSCDetail" id="eFSCSAmateurFilmCharacteristics" title="Amateur Film Characteristics">Amateur Film Characteristics</div>
		<div class="eFSCDetail" id="eFSCSIntention" title="Intention">Intention</div>
	</div>
	
	<div class="eFMovieAnnotationsContainerScenarioSelectD" id="eFMovieAnnotationsContainerScenarioSelectDDescriptionEducationalRemarks">
		<div class="eFSCDetail" id="eFSCSEducationalRemarks" title="Educational Remarks">Educational Remarks</div>
	</div>
	
</div>







<div id="eFMovieAnnotationsContainerINOUTContainer">
	<div id="eFMovieAnnotationsContainerINOUT">
		<span id="eFAFormINGET">IN:</span> <input type="text" name="IN" id="eFAFormIN" value="">
		<span id="eFAFormOUTGET">OUT:</span> <input type="text" name="IN" id="eFAFormOUT" value="">
		<span id="eFMovieAnnotationsContainerINOUTPlay"></span>
	</div>
	<div id="eFMovieAnnotationsContainerINOUTPlay"></div>
</div>
<div id="eFMovieAnnotationsContainerForms">
	<div id="eFMovieAnnotationsContainerFormsPop">
		<div id="eFMovieAnnotationsContainerFormsPopContent"></div>
		<div id="eFMovieAnnotationsContainerFormsPopClose">close</div>
	</div>
</div>
<div id="eFMovieAnnotationsEditBOOL">JA</div>
<div id="eFMovieAnnotationsContainerANList">

</div>

</div>
<!-- /eF Annotations Container HTML -->



<!-- eF Movie Container HTML -->
<!-- /eF Movie Container HTML -->
<!-- eF Movie Timeline Container HTML -->
<div id="eFTimelineContainer">
	<table class="eFTimelineContainerTable">
		<thead>
			<tr id="eFTimelineContainerTableFrameNumbers">
			<th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>
			<th id="eFTimelineContainerTableIN"><img id="efTLCIN" alt="in" src="_img/in.png" width="14" height="14"/></th><th id="eFTimelineContainerTableActual">&nbsp;</th><th id="eFTimelineContainerTableOUT"><img id="efTLCOUT" alt="out" src="_img/out.png" width="14" height="14"/></th>
			<th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<tr id="eFTimelineContainerTableFramePics">
			<td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td>
			<td colspan="3" id="eFTimelineContainerAFrame"><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td>
			<td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td>
			</tr>
		</tbody>
	</table>
</div>
<!-- /eF Movie Timeline Container HTML -->
<!-- eF Movie Controls Container HTML -->
<div id="eFMovieControlsContainerSloMo">
<div id="efMoviePlaybuttonsSloMoChoose" class="efMoviePlaybuttonsC">
		<select id="eFSloMoSpeedChooser">
			<option value="1000">1</option>
			<option value="500">2</option>
			<option value="333">3</option>
			<option value="250">4</option>
		</select>
	</div>
	<div id="efMoviePlaybuttonsSloMoB" class="efMoviePlaybuttons">&emsp;</div>
	<div id="efMoviePlaybuttonsSloMoF" class="efMoviePlaybuttons">&emsp;</div>
</div>
<div id="eFMovieControlsContainer">
	<!-- <div id="efMoviePlaybuttonsPlayPauseB" class="efMoviePlaybuttons">&emsp;</div> -->
	<div id="efMoviePlaybuttonsPlayPauseF" class="efMoviePlaybuttons">&emsp;</div>
	
	<div class="efMoviePlaybuttons">&emsp;</div>
	
	<div id="efMoviePlaybuttonsStart" class="efMoviePlaybuttons">&emsp;</div>
	<div id="efMoviePlaybuttonsEnd" class="efMoviePlaybuttons">&emsp;</div>
	
	<div class="efMoviePlaybuttons">&emsp;</div>
	
	<div class="efMoviePlaybuttons efMovieSpeedContainers">6</div>
	<div class="efMoviePlaybuttons efMovieSpeedContainers">12</div>
	<div class="efMoviePlaybuttons efMovieSpeedContainers">16</div>
	<div class="efMoviePlaybuttons efMovieSpeedContainers">18</div>
	<div class="efMoviePlaybuttons efMovieSpeedContainers">20</div>
	<div class="efMoviePlaybuttons efMovieSpeedContainers">22</div>
	<div class="efMoviePlaybuttons efMovieSpeedContainers">24</div>
	<div class="efMoviePlaybuttons efMovieSpeedContainers">25</div>
	<div class="efMoviePlaybuttons efMovieSpeedContainers">36</div>
	<div class="efMoviePlaybuttons efMovieSpeedContainers">48</div>
</div>
<!-- /eF Movie Controls Container HTML -->
<!-- eF Movie RangeInput Container HTML -->
<div id="eFMovieRangeInputContainer">

</div>
<!-- /eF Movie RangeInput Container HTML -->
<!-- eF Movie Timecodes Container HTML -->
<div id="eFMovieTimecodesContainer">
	<div class="eFTimecodesHeadline">Timing</div>
	<table class="timecodetable">
		<tr>
			<th><div class="eFMovieTimecodesContainerHeads">Frames</div></th><th><div class="eFMovieTimecodesContainerHeads">SMPTE</div></th>
		</tr>
		<tr>
			<td id="eFControlDataMovieTimecodeContainerFPS">000000</td><td id="eFControlDataMovieTimecodeContainerSMPTE">00:00:00:00</td>
		</tr>
		<tr>
			<th><div class="eFMovieTimecodesContainerHeads">HH:MM:SS</div></th><th><div class="eFMovieTimecodesContainerHeads">FLOAT</div></th>
		</tr>
		<tr>
			<td id="eFControlDataMovieTimecodeContainerHHMMSS">00:00:00</td><td id="eFControlDataMovieTimecodeContainerFLOAT">0.0</td>
		</tr>
		<tr>
			<th><div class="eFMovieTimecodesContainerHeads">Meter</div></th><th><div class="eFMovieTimecodesContainerHeads">Feet</div></th>
		</tr>
		<tr>
			<td id="eFControlDataMovieTimecodeContainerMETER">0000</td><td id="eFControlDataMovieTimecodeContainerFEET">0000</td>
		</tr>
	</table>
</div>
<!-- /eF Movie Timecodes Container HTML -->
</div>
<div id="eFMovieAnnotationsNewFormContainerWarning">
	<button id="eFAFormWarnOKButton">OK</button>
	<div id="eFMovieAnnotationsNewFormContainerWarningContent"></div>
</div>
<!-- eF Movie Realtions Second Timeline Container HTML -->
<div id="eFRelMovieTimelineB">

<div id="eFMovieControlsContainerSloMoRel">
<div id="efMoviePlaybuttonsSloMoChooseRel" class="efMoviePlaybuttonsC">
		<select id="eFSloMoSpeedChooserRel">
			<option value="1000">1</option>
			<option value="500">2</option>
			<option value="333">3</option>
			<option value="250">4</option>
		</select>
	</div>
	<div id="efMoviePlaybuttonsSloMoBRel" class="efMoviePlaybuttons">&emsp;</div>
	<div id="efMoviePlaybuttonsSloMoFRel" class="efMoviePlaybuttons">&emsp;</div>
</div>

<div id="eFMovieRangeInputContainerRel">

</div>

<div id="eFMovieControlsContainerRel">
	<!-- <div id="efMoviePlaybuttonsPlayPauseB" class="efMoviePlaybuttons">&emsp;</div> -->
	<div id="efMoviePlaybuttonsPlayPauseFRel" class="efMoviePlaybuttons">&emsp;</div>
	
	<div class="efMoviePlaybuttons">&emsp;</div>
	
	<div id="efMoviePlaybuttonsStartRel" class="efMoviePlaybuttons">&emsp;</div>
	<div id="efMoviePlaybuttonsEndRel" class="efMoviePlaybuttons">&emsp;</div>
	
	<div class="efMoviePlaybuttons">&emsp;</div>
	
	<div class="efMoviePlaybuttons efMovieSpeedContainers">6</div>
	<div class="efMoviePlaybuttons efMovieSpeedContainers">12</div>
	<div class="efMoviePlaybuttons efMovieSpeedContainers">16</div>
	<div class="efMoviePlaybuttons efMovieSpeedContainers">18</div>
	<div class="efMoviePlaybuttons efMovieSpeedContainers">20</div>
	<div class="efMoviePlaybuttons efMovieSpeedContainers">22</div>
	<div class="efMoviePlaybuttons efMovieSpeedContainers">24</div>
	<div class="efMoviePlaybuttons efMovieSpeedContainers">25</div>
	<div class="efMoviePlaybuttons efMovieSpeedContainers">36</div>
	<div class="efMoviePlaybuttons efMovieSpeedContainers">48</div>
</div>

<div id="eFTimelineContainerRel">
	<table class="eFTimelineContainerTableRel" style="margin-left: auto; ">
		<thead>
			<tr id="eFTimelineContainerTableFrameNumbersRel">
			<th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
			<th id="eFTimelineContainerTableINRel"><img id="efTLCINRel" alt="in" src="_img/in.png" width="18" height="14"></th><th id="eFTimelineContainerTableActualRel"></th><th id="eFTimelineContainerTableOUTRel"><img id="efTLCOUTRel" alt="out" src="_img/out.png" width="18" height="14"></th>
			<th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
			</tr>
		</thead>
		<tbody>
			<tr id="eFTimelineContainerTableFramePicsRel">
			<td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td>
			<td colspan="3" id="eFTimelineContainerAFrameRel"><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td>
			<td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td><td><img class="null" alt="null" src="_img/null.png" width="78px" height="1px"></td>
			</tr>
		</tbody>
	</table>
</div>
</div>
</body>
</html>
