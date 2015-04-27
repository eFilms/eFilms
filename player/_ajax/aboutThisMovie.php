<?php
require_once('db_con.php');
$language = $_COOKIE["language"]; 
$movieid = preg_replace("/[^0-9]/", "", $_GET['movieID']);

$filmInfoQuery = "SELECT * FROM eFilm_ActiveFilms WHERE `filmNumber` = '".$movieid."'";
$filmInfoResults = mysqli_query($localDatabase,$filmInfoQuery); 
$filmData = mysqli_fetch_array($filmInfoResults);

$filmTitleQuery = "SELECT `FILM_ID` FROM eFilm_Content_Movies WHERE `ID_Movies` = '".$filmData['filmNumber']."'";
$filmTitleResults = mysqli_query($localDatabase,$filmTitleQuery); 
$filmTitleData = mysqli_fetch_array($filmTitleResults);

switch ($language) {
    case "de":
        $titleText = "Filmtitel";
        $productionTitle = "Herstellungsiahr";
        $filmNumberTitle = "Filmnummer";
        $archiveTitle = "Archiv";
        $archiveNumberTitle = "Archivnummer";
        $genreTitle = "Genre";
        $formatTitle = "Format";
        $technicalTitle = "Technische Angaben";
        $languageTitle = "Sprache";
        $provenanceTitle = "Provenienz";
        $copyTitle = "Digitalisat";
        $frameRateTitle = "Bildrate";
        $framesTitle = "Bilder";
        $durationTitle = "Dauer";
        $filmTitle = $filmData['germanTitle'];
        $cinematography = "Cinematography";
        $filmGauge = "Film Gauge";
        $genre = $filmData['germanGenre'];
        $colorLabel = "Farbe";
        $color = $filmData['farbe'];
        $soundLabel = "Ton";
        $sound = $filmData['ton'];
        $filmLanguage = $filmData['sprache'];
        $fps = "Frames Per Second";
        $format = "Digital Format";
        $digitalCopy = "Digitalisat";
        $lab = $filmData['germanDigitalLab'];
        break;
    default:
        $titleText = "Title";
        $productionTitle = "Production Year";
        $filmNumberTitle = "Film Number";
        $archiveTitle = "Archive";
        $archiveNumberTitle = "Archive Number";
        $genreTitle = "Genre";
        $formatTitle = "Format";
        $technicalTitle = "Technical Specs";
        $languageTitle = "Language";
        $provenanceTitle = "Provenance";
        $copyTitle = "Digital Copy";
        $frameRateTitle = "Frame Rate";
        $framesTitle = "Frames";
        $durationTitle = "Duration";
        $filmTitle = $filmData['englishTitle'];
        $cinematography = "Cinematography";
        $filmGauge = "Film Gauge";
        $genre = $filmData['englishGenre'];
        $colorLabel = "Color";
        $color = $filmData['color'];
        $soundLabel = "Sound";
        $sound = $filmData['sound'];
        $filmLanguage = $filmData['language'];
        $fps = "Frames Per Second";
        $format = "Digital Format";
        $digitalCopy = "Digital Copy";
        $lab = $filmData['englishDigitalLab'];
        break;
}

echo "<div style='padding: 5px 10px; background-color: rgb(204, 204, 204); width: 250px; margin:10px 5px;'>";

echo "<p><span class='aboutMovieHeader' style='font-family: arial, sans-serif; font-style: bold; font-size: 12px;'>".$titleText."</span><br>";
echo "<span style='font-family: arial, sans-serif; font-style: normal; font-size: 10px;'>".$filmTitle."</span></p>";

echo "<p><span class='aboutMovieHeader' style='font-family: arial, sans-serif; font-style: bold; font-size: 12px;'>".$productionTitle."</span><br>";
echo "<span style='font-family: arial, sans-serif; font-style: normal; font-size: 10px;'>".$filmData['year']."</span></p>";

echo "<p><span class='aboutMovieHeader' style='font-family: arial, sans-serif; font-style: bold; font-size: 12px;'>".$filmNumberTitle."</span><br>";
echo "<span style='font-family: arial, sans-serif; font-style: normal; font-size: 10px;'>".$filmTitleData['FILM_ID']."</span></p>";

echo "<p><span class='aboutMovieHeader' style='font-family: arial, sans-serif; font-style: bold; font-size: 12px;'>".$archiveTitle."</span><br>";
echo "<span style='font-family: arial, sans-serif; font-style: normal; font-size: 10px;'>".$filmData['source']."</span></p>";

echo "<p><span class='aboutMovieHeader' style='font-family: arial, sans-serif; font-style: bold; font-size: 12px;'>".$archiveNumberTitle."</span><br>";
echo "<span style='font-family: arial, sans-serif; font-style: normal; font-size: 10px;'>".$filmData['archivalNumber']."</span></p>";

echo "<p><span class='aboutMovieHeader' style='font-family: arial, sans-serif; font-style: bold; font-size: 12px;'>".$genreTitle."</span><br>";
echo "<span style='font-family: arial, sans-serif; font-style: normal; font-size: 10px;'>".$genre."</span></p>";

echo "<p><span class='aboutMovieHeader' style='font-family: arial, sans-serif; font-style: bold; font-size: 12px;'>".$formatTitle."</span><br>";
echo "<span style='font-family: arial, sans-serif; font-style: normal; font-size: 10px;'>".$filmData['originalFilmGauge']." mm</span></p>";

echo "<p><span class='aboutMovieHeader' style='font-family: arial, sans-serif; font-style: bold; font-size: 12px;'>".$technicalTitle."</span><br>";
echo "<span style='font-family: arial, sans-serif; font-style: normal; font-size: 10px;'>".$color."</span><br>";
echo "<span style='font-family: arial, sans-serif; font-style: normal; font-size: 10px;'>".$sound."</span></p>";

echo "<p><span class='aboutMovieHeader' style='font-family: arial, sans-serif; font-style: bold; font-size: 12px;'>".$languageTitle."</span><br>";
echo "<span style='font-family: arial, sans-serif; font-style: normal; font-size: 10px;'>".$filmLanguage."</span></p>";

echo "<p><span class='aboutMovieHeader' style='font-family: arial, sans-serif; font-style: bold; font-size: 12px;'>".$provenanceTitle."</span><br>";
echo "<span style='font-family: arial, sans-serif; font-style: normal; font-size: 10px;'>".$filmData['provenance']."</span></p>";

echo "<p><span class='aboutMovieHeader' style='font-family: arial, sans-serif; font-style: bold; font-size: 12px;'>".$copyTitle."</span><br>";
echo "<span style='font-family: arial, sans-serif; font-style: normal; font-size: 10px;'>".$lab."</span><br>";
echo "<span style='font-family: arial, sans-serif; font-style: normal; font-size: 10px;'>".$filmData['digitalCopyDate']."</span><br>";
echo "<span style='font-family: arial, sans-serif; font-style: normal; font-size: 10px;'>".$filmData['digitalFormat']."</span></p>";

echo "<p><span class='aboutMovieHeader' style='font-family: arial, sans-serif; font-style: bold; font-size: 12px;'>".$frameRateTitle."</span><br>";
echo "<span style='font-family: arial, sans-serif; font-style: normal; font-size: 10px;'>".$filmData['fps']." fps</span></p>";

echo "<p><span class='aboutMovieHeader' style='font-family: arial, sans-serif; font-style: bold; font-size: 12px;'>".$framesTitle."</span><br>";
echo "<span style='font-family: arial, sans-serif; font-style: normal; font-size: 10px;'>".$filmData['frames']."</span></p>";

echo "<p><span class='aboutMovieHeader' style='font-family: arial, sans-serif; font-size: 12px;'>".$durationTitle."</span><br>";
echo "<span style='font-family: arial, sans-serif; font-style: normal; font-size: 10px;'>00:".sprintf("%02d", $filmData['minutes']).":".sprintf("%02d", $filmData['seconds'])."</span></p>";

echo "</div>";
?>
