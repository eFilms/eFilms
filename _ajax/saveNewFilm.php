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

$newMovieTitleEn = $_POST["newMovieTitleEn"] ?: '';
$newMovieGenerationEn = $_POST["newMovieGenerationEn"] ?: '';
$newMoviePosNegEn = $_POST["newMoviePosNegEn"] ?: '';
$newMovieFilmBaseEn = $_POST["newMovieFilmBaseEn"] ?: '';
$newMoviePrevGenEn = $_POST["newMoviePrevGenEn"] ?: '';
$newMovieColorEn = $_POST["newMovieColorEn"] ?: '';
$newMovieSoundEn = $_POST["newMovieSoundEn"] ?: '';
$newMovieSoundProcessEn = $_POST["newMovieSoundProcessEn"] ?: '';
$newMovieLanguageEn = $_POST["newMovieLanguageEn"] ?: '';
$newMovieLabEn = $_POST["newMovieLabEn"] ?: '';
$newMovieGenreEn = $_POST["newMovieGenreEn"] ?: '';
$newMovieTitleDe = $_POST["newMovieTitleDe"] ?: '';
$newMovieGenerationDe = $_POST["newMovieGenerationDe"] ?: '';
$newMoviePosNegDe = $_POST["newMoviePosNegDe"] ?: '';
$newMovieFilmBaseDe = $_POST["newMovieFilmBaseDe"] ?: '';
$newMoviePrevGenDe = $_POST["newMoviePrevGenDe"] ?: '';
$newMovieColorDe = $_POST["newMovieColorDe"] ?: '';
$newMovieSoundDe = $_POST["newMovieSoundDe"] ?: '';
$newMovieSoundProcessDe = $_POST["newMovieSoundProcessDe"] ?: '';
$newMovieLanguageDe = $_POST["newMovieLanguageDe"] ?: '';
$newMovieLabDe = $_POST["newMovieLabDe"] ?: '';
$newMovieGenreDe = $_POST["newMovieGenreDe"] ?: '';
$newMovieDisplayTitle = $_POST["newMovieDisplayTitle"] ?: '';
$newMovieArchivalNumber = $_POST["newMovieArchivalNumber"] ?: '';
$newMovieFilmNumber = $_POST["newMovieFilmNumber"] ?: '';
$newMovieFilmGauge = $_POST["newMovieFilmGauge"] ?: '';
$newMovieFPS = $_POST["newMovieFPS"] ?: '';
$newMovieMinutes = $_POST["newMovieMinutes"] ?: '';
$newMovieSeconds = $_POST["newMovieSeconds"] ?: '';
$newMovieFrames = $_POST["newMovieFrames"] ?: '';
$newMovieYear = $_POST["newMovieYear"] ?: '';
$newMovieEFNS = $_POST["newMovieEFNS"] ?: '';
$newMovieReel = $_POST["newMovieReel"] ?: '';
$newMovieSource = $_POST["newMovieSource"] ?: '';
$newMovieSeries = $_POST["newMovieSeries"] ?: '';
$newMovieFormat = $_POST["newMovieFormat"] ?: '';
$newMovieCopyDate = $_POST["newMovieCopyDate"] ?: '';
$newMovieProducer = $_POST["newMovieProducer"] ?: '';
$newMovieDirector = $_POST["newMovieDirector"] ?: '';
$newMovieCinematography = $_POST["newMovieCinematography"] ?: '';
$newMovieCollection = $_POST["newMovieCollection"] ?: '';
$newMovieProvenance = $_POST["newMovieProvenance"] ?: '';
$newMovieDescription = $_POST["newMovieDescription"] ?: '';
$newMoviePraktikantin = $_POST["newMoviePraktikantin"] ?: '';
$newMovieEditorV = $_POST["newMovieEditorV"] ?: '1';
$newMovieStatus = $_POST["newMovieStatus"] ?: '';
$newMoviePOnline = $_POST["newMoviePOnline"] ?: '';
$iconicImage = $_POST["fileName"] ?: '';
$m4vFilename = str_replace(".m4v", "", $_POST["M4VfileName"]) ?: '';
$oggFilename = $_POST["OGGfileName"] ?: '';

if (substr($newMovieFilmGauge, -2) != "mm") {
    $newMovieFilmGauge = $newMovieFilmGauge."mm";
}

// Combined values
$filmID = "EF-NS_".str_pad($newMovieEFNS, 3, "0", STR_PAD_LEFT)."_".$newMovieSource;
if (!empty($newMovieReel)) {
    $filmID .= "_R".str_pad($newMovieReel, 2, "0", STR_PAD_LEFT);
}

$filmSearch = "SELECT `EF-NS` FROM `eFilm_ActiveFilms` WHERE `EF-NS` = '".$newMovieEFNS."';";
$searchResults = mysqli_query($localDatabase, $filmSearch);
if (mysqli_num_rows($searchResults) > 0) {
    // Update existing records
    $moviesUpdate = "UPDATE `eFilm_Content_Movies` SET `STAMMDATEN_Archivsignatur` = '".$newMovieArchivalNumber."',`STAMMDATEN_Format` = '".$newMovieFilmGauge."',`STAMMDATEN_Displaytitel` = '".$newMovieDisplayTitle."',`_eFWEB_Praktikantin` = '".$newMoviePraktikantin."',`_eFWEB_EditorV` = '".$newMovieEditorV."',`_eFWEB_FPS` = '".$newMovieFPS."',`_eFWEB_Status` = '".$newMovieStatus."',`_eFWEB_Speed` = '".$newMovieFPS."',`_eFWEB_POnline` = '".$newMoviePOnline."' WHERE `FILM_ID` = '".$filmID."';";
    mysqli_query($localDatabase, $moviesUpdate);
    $activeFilmsUpdate = "UPDATE `eFilm_ActiveFilms` SET `filmNumber` = '".$newFilmId."',`reel` = '".$newMovieReel."',`source` = '".$newMovieSource."',`germanTitle` = '".$newMovieTitleDe."',`englishTitle` = '".$newMovieTitleEn."',`year` = '".$newMovieYear."',`series` = '".$newMovieSeries."',`archivalNumber` = '".$newMovieArchivalNumber."',`germanGeneration` = '".$newMovieGenerationDe."',`englishGeneration` = '".$newMovieGenerationEn."',`germanPosNeg` = '".$newMoviePosNegDe."',`englishPosNeg` = '".$newMoviePosNegEn."',`germanFilmBase` = '".$newMovieFilmBaseDe."',`englishFilmBase` = '".$newMovieFilmBaseEn."',`germanPreviousGenerations` = '".$newMoviePrevGenDe."',`englishPreviousGenerations` = '".$newMoviePrevGenEn."',`originalFilmGauge` = '".$newMovieFilmGauge."',`farbe` = '".$newMovieColorDe."',`color` = '".$newMovieColorEn."',`ton` = '".$newMovieSoundDe."',`sound` = '".$newMovieSoundEn."',`tonverfahren` = '".$newMovieSoundProcessDe."',`soundProcess` = '".$newMovieSoundProcessEn."',`frames` = '".$newMovieFrames."',`fps` = '".$newMovieFPS."',`minutes` = '".$newMovieMinutes."',`seconds` = '".$newMovieSeconds."',`sprache` = '".$newMovieLanguageDe."',`language` = '".$newMovieLanguageEn."',`digitalFormat` = '".$newMovieFormat."',`germanDigitalLab` = '".$newMovieLabDe."',`englishDigitalLab` = '".$newMovieLabEn."',`digitalCopyDate` = '".$newMovieCopyDate."',`germanGenre` = '".$newMovieGenreDe."',`englishGenre` = '".$newMovieGenreEn."',`producer` = '".$newMovieProducer."',`director` = '".$newMovieDirector."',`cinematography` = '".$newMovieCinematography."',`collection` = '".$newMovieCollection."',`provenance` = '".$newMovieProvenance."',`description` = '".$newMovieDescription."',`isLive` = '0',`researchLog` = '' WHERE `EF-NS` = '".$newMovieEFNS."';";
    mysqli_query($localDatabase, $activeFilmsUpdate);
} else {
    $moviesInsert = "INSERT INTO `eFilm_Content_Movies` (`FILM_ID`, `originalFileName`, `STAMMDATEN_Archivsignatur`, `STAMMDATEN_Format`, `STAMMDATEN_Displaytitel`, `_eFWEB_Praktikantin`, `_eFWEB_EditorV`, `_eFWEB_FPS`, `_eFWEB_Status`, `_eFWEB_Speed`, `_eFWEB_POnline`) VALUES ('".$filmID."', '".$m4vFilename."', '".$newMovieArchivalNumber."', '".$newMovieFilmGauge."', '".$newMovieDisplayTitle."','".$newMoviePraktikantin."','".$newMovieEditorV."','".$newMovieFPS."','".$newMovieStatus."', '".$newMovieFPS."', '".$newMoviePOnline."')";
    mysqli_query($localDatabase, $moviesInsert);

    $newFilmId = mysqli_insert_id($localDatabase);

    $activeFilmsInsert = "INSERT INTO `eFilm_ActiveFilms` (`filmNumber`, `EF-NS`, `reel`, `source`, `germanTitle`, `englishTitle`, `year`, `series`, `archivalNumber`, `germanGeneration`, `englishGeneration`, `germanPosNeg`, `englishPosNeg`, `germanFilmBase`, `englishFilmBase`, `germanPreviousGenerations`, `englishPreviousGenerations`, `originalFilmGauge`, `farbe`, `color`, `ton`, `sound`, `tonverfahren`, `soundProcess`, `frames`, `fps`, `minutes`, `seconds`, `sprache`, `language`,`digitalFormat`, `germanDigitalLab`, `englishDigitalLab`, `digitalCopyDate`, `germanGenre`, `englishGenre`, `producer`, `director`, `cinematography`, `collection`, `provenance`, `description`, `isLive`, `researchLog`) VALUES ('".$newFilmId."','".$newMovieEFNS."','".$newMovieReel."','".$newMovieSource."','".$newMovieTitleDe."','".$newMovieTitleEn."','".$newMovieYear."','".$newMovieSeries."','".$newMovieArchivalNumber."','".$newMovieGenerationDe."','".$newMovieGenerationEn."','".$newMoviePosNegDe."','".$newMoviePosNegEn."','".$newMovieFilmBaseDe."','".$newMovieFilmBaseEn."','".$newMoviePrevGenDe."','".$newMoviePrevGenEn."','".$newMovieFilmGauge."','".$newMovieColorDe."','".$newMovieColorEn."','".$newMovieSoundDe."','".$newMovieSoundEn."','".$newMovieSoundProcessDe."','".$newMovieSoundProcessEn."','".$newMovieFrames."','".$newMovieFPS."','".$newMovieMinutes."','".$newMovieSeconds."','".$newMovieLanguageDe."','".$newMovieLanguageEn."','".$newMovieFormat."','".$newMovieLabDe."','".$newMovieLabEn."','".$newMovieCopyDate."','".$newMovieGenreDe."','".$newMovieGenreEn."','".$newMovieProducer."','".$newMovieDirector."','".$newMovieCinematography."','".$newMovieCollection."','".$newMovieProvenance."','".$newMovieDescription."','0','')";
    mysqli_query($localDatabase, $activeFilmsInsert);

    // Select all users
    $userIDs = "SELECT DISTINCT `ID_C_Users` from `eFilm_Config_Users`";
    $userIDResults = mysqli_query($localDatabase, $userIDs);
    while ($row = mysqli_fetch_array($userIDResults)) {
        // Assign rights to this movie
        if ($row['ID_C_Users'] == 0) {
            $permissions = 'EDIT';
        } else {
            $permissions = 'NONE';
        }
        $newPermissions = "INSERT INTO `eFilm_Config_Users_MovieRights` (`_FM_CREATE`, `_FM_CHANGE`, `_FM_DATETIME_CREATE`, `_FM_DATETIME_CHANGE`, `ID_C_Users`, `ID_Movies`, `RIGHTS_Movies`) VALUES ('".$_SESSION["unik"]."','".$_SESSION["unik"]."','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."','".$row['ID_C_Users']."','".$newFilmId."','".$permissions."')";
        mysqli_query($localDatabase, $newPermissions);
    }
}
