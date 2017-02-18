<?php
if (!isset($_SESSION)) {
	session_start();
}
if ($_SESSION["login"] != "true") {
	header("Location=login.php");
	$_SESSION["error"] = "<h1 style='color:red;'>You don't have privileges to see this page.</h1>";
	exit;
}

require_once('../settings.php');
require_once('../includes/functions.php');
require_once(directoryAboveWebRoot().'/db_con.php');

$filmID = preg_replace("/[^\w_-]/","",$_POST['film']);
$idParts = explode("_",$filmID);
$efns = $idparts[1];

$userIDs = "SELECT `eFilm_Content_Movies`.`STAMMDATEN_Archivsignatur`,`eFilm_Content_Movies`.`STAMMDATEN_Format`,`eFilm_Content_Movies`.`STAMMDATEN_Displaytitel`,`eFilm_Content_Movies`.`_eFWEB_Praktikantin`,`eFilm_Content_Movies`.`_eFWEB_EditorV`,`eFilm_Content_Movies`.`_eFWEB_FPS`,`eFilm_Content_Movies`.`_eFWEB_Status`,`eFilm_Content_Movies`.`_eFWEB_Speed`,`eFilm_Content_Movies`.`_eFWEB_POnline`,`eFilm_Content_Movies`.`DESCRIPTION_DE`,`eFilm_Content_Movies`.`DESCRIPTION_EN`,`eFilm_Content_Movies`.`TITLE_EN`,`eFilm_ActiveFilms`.`reel`,`eFilm_ActiveFilms`.`source`,`eFilm_ActiveFilms`.`germanTitle`,`eFilm_ActiveFilms`.`englishTitle`,`eFilm_ActiveFilms`.`year`,`eFilm_ActiveFilms`.`series`,`eFilm_ActiveFilms`.`archivalNumber`,`eFilm_ActiveFilms`.`germanGeneration`,`eFilm_ActiveFilms`.`englishGeneration`,`eFilm_ActiveFilms`.`germanPosNeg`,`eFilm_ActiveFilms`.`englishPosNeg`,`eFilm_ActiveFilms`.`germanFilmBase`,`eFilm_ActiveFilms`.`englishFilmBase`,`eFilm_ActiveFilms`.`germanPreviousGenerations`,`eFilm_ActiveFilms`.`englishPreviousGenerations`,`eFilm_ActiveFilms`.`originalFilmGauge`,`eFilm_ActiveFilms`.`farbe`,`eFilm_ActiveFilms`.`color`,`eFilm_ActiveFilms`.`ton`,`eFilm_ActiveFilms`.`sound`,`eFilm_ActiveFilms`.`tonverfahren`,`eFilm_ActiveFilms`.`soundProcess`,`eFilm_ActiveFilms`.`frames`,`eFilm_ActiveFilms`.`fps`,`eFilm_ActiveFilms`.`minutes`,`eFilm_ActiveFilms`.`seconds`,`eFilm_ActiveFilms`.`sprache`,`eFilm_ActiveFilms`.`language`,`eFilm_ActiveFilms`.`digitalFormat`,`eFilm_ActiveFilms`.`germanDigitalLab`,`eFilm_ActiveFilms`.`englishDigitalLab`,`eFilm_ActiveFilms`.`digitalCopyDate`,`eFilm_ActiveFilms`.`germanGenre`,`eFilm_ActiveFilms`.`englishGenre`,`eFilm_ActiveFilms`.`producer`,`eFilm_ActiveFilms`.`director`,`eFilm_ActiveFilms`.`cinematography`,`eFilm_ActiveFilms`.`collection`,`eFilm_ActiveFilms`.`provenance`,`eFilm_ActiveFilms`.`description`,`eFilm_ActiveFilms`.`isLive`,`eFilm_ActiveFilms`.`researchLog` FROM `eFilm_Content_Movies` JOIN `eFilm_ActiveFilms` ON `eFilm_ActiveFilms`.`EF-NS` = '".$efns."' WHERE `eFilm_Content_Movies`.`FILM_ID` = '".$filmID."';";
$userIDResults = mysqli_query($localDatabase, $userIDs);
$value = mysqli_fetch_array($userIDResults);

$dataArr['newMovieTitleEn'] = $value['englishTitle'];
$dataArr['newMovieGenerationEn'] = $value['englishGeneration'];
$dataArr['newMoviePosNegEn'] = $value['englishPosNeg'];
$dataArr['newMovieFilmBaseEn'] = $value['englishFilmBase'];
$dataArr['newMoviePrevGenEn'] = $value['englishPreviousGenerations'];
$dataArr['newMovieColorEn'] = $value['color'];
$dataArr['newMovieSoundEn'] = $value['sound'];
$dataArr['newMovieSoundProcessEn'] = $value['soundProcess'];
$dataArr['newMovieLanguageEn'] = $value['language'];
$dataArr['newMovieLabEn'] = $value['englishDigitalLab'];
$dataArr['newMovieGenreEn'] = $value['englishGenre'];
$dataArr['newMovieTitleDe'] = $value['germanTitle'];
$dataArr['newMovieGenerationDe'] = $value['germanGeneration'];
$dataArr['newMoviePosNegDe'] = $value['germanPosNeg'];
$dataArr['newMovieFilmBaseDe'] = $value['germanFilmBase'];
$dataArr['newMoviePrevGenDe'] = $value['germanPreviousGenerations'];
$dataArr['newMovieColorDe'] = $value['farbe'];
$dataArr['newMovieSoundDe'] = $value['ton'];
$dataArr['newMovieSoundProcessDe'] = $value['tonverfahren'];
$dataArr['newMovieLanguageDe'] = $value['sprache'];
$dataArr['newMovieLabDe'] = $value['germanDigitalLab'];
$dataArr['newMovieGenreDe'] = $value['germanGenre'];
$dataArr['newMovieDisplayTitle'] = $value['STAMMDATEN_Displaytitel'];
$dataArr['newMovieArchivalNumber'] = $value['STAMMDATEN_Archivsignatur'];
$dataArr['newMovieFilmGauge'] = $value['originalFilmGauge'];
$dataArr['newMovieFPS'] = $value['fps'];
$dataArr['newMovieMinutes'] = $value['minutes'];
$dataArr['newMovieSeconds'] = $value['seconds'];
$dataArr['newMovieFrames'] = $value['frames'];
$dataArr['newMovieYear'] = $value['year'];
$dataArr['newMovieEFNS'] = $efns;
$dataArr['newMovieReel'] = $value['reel'];
$dataArr['newMovieSource'] = $value['source'];
$dataArr['newMovieSeries'] = $value['series'];
$dataArr['newMovieFormat'] = $value['STAMMDATEN_Format'];
$dataArr['newMovieCopyDate'] = $value['digitalCopyDate'];
$dataArr['newMovieProducer'] = $value['producer'];
$dataArr['newMovieDirector'] = $value['director'];
$dataArr['newMovieCinematography'] = $value['cinematography'];
$dataArr['newMovieCollection'] = $value['collection'];
$dataArr['newMovieProvenance'] = $value['provenance'];
$dataArr['newMovieDescription'] = $value['description'];
$dataArr['newMoviePraktikantin'] = $value['_eFWEB_Praktikantin'];
$dataArr['newMovieEditorV'] = $value['_eFWEB_EditorV'];
$dataArr['newMovieStatus'] = $value['_eFWEB_Status'];
$dataArr['newMoviePOnline'] = $value['_eFWEB_POnline'];

echo json_encode($dataArr);