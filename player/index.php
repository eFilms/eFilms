<?php
	include_once("../settings.php");
	include_once("../includes/functions.php");
?>
<!DOCTYPE html>
<html>
    <head>
      <title>Sample Film Player</title>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <link rel="stylesheet" type="text/css" href="style.css" />
			<script>var storeURL = '<?php echo $storeURL; ?>'</script>
      <script type="text/javascript" src="javascript/navigation.js"></script>
			<script type="text/javascript" src="javascript/hammer.js"></script>
			<script type="text/javascript" src="_js/filmPlayerJS.php"></script>
    	<script type="text/javascript" src="_js/jQBaseUI/jquery.tools.min.js"></script>
    	<script type="text/javascript" src="_js/jQMedia/jquery.media.core.js"></script>
    	<script type="text/javascript" src="_js/jQMedia/jquery.media.timeline.js"></script>
    	<script type="text/javascript" src="_js/jQMedia/plugins/syncwith.js"></script>
    	<script type="text/javascript" src="_js/jQMedia/plugins/tocanvas.js"></script>
    	<script type="text/javascript" src="_js/jQMedia/plugins/tracks.js"></script>
    	<script type="text/javascript" src="_js/jQScrollTo/jquery.scrollTo-1.4.2-min.js"></script>
    	<script type="text/javascript" src="_js/jquery.cycle.all.js"></script>
    </head>
    <body data-movielocationprefix="<?php echo $storeURL; ?>/_media/movies_wm/">
        <div class="pageContent">
            <div class="moviePlayer">
<?php
		$language = (isset($_COOKIE["language"]) ? $_COOKIE["language"] : "en");
		$movieID = preg_replace("/[^0-9]/", "", $_GET['movieID']);
		$movieSig = preg_replace("/[^a-z0-9_\-]/i", "", $_GET['movieSig']);
		$movieStart = preg_replace("/[^0-9.]/", "", $_GET['movieStart']);
		$movieStop = preg_replace("/[^0-9.]/", "", $_GET['movieStop']);
		$content = "";
		include(directoryAboveWebRoot()."/db_con.php");
		$filmDetailsQuery = "SELECT `englishTitle`,`germanTitle`,`year`,`fps` FROM `eFilm_ActiveFilms` WHERE `filmNumber` = '".$movieID."'";
		$filmDetailsResults = mysqli_query($localDatabase, $filmDetailsQuery);
		$filmDetails = mysqli_fetch_array($filmDetailsResults);
		if ($language == 'de') {
				$filmTitle = $filmDetails['germanTitle'];
		} else {
				$filmTitle = $filmDetails['englishTitle'];
		}
		$movieSpeed = $filmDetails['fps'];
		if (!empty($filmTitle)) {
				$content .= "<div class='filmPlayerFilmTitle'>".$filmTitle."</div>";
		} else {
				$content .= "<div class='filmPlayerFilmTitle'>&nbsp;</div>";
		}
		$content .= "<div class='filmPlayerFilmNumber'>".$movieSig."</div>";
		$content .= "<div id='efPIMovieCurrentContainer' data-movieid='".$movieID."' data-moviesig='".$movieSig."'></div><div id='efPIMovieCurrentAnnotationsContainer' data-movieid='".$movieID."' data-moviesig='".$movieSig."'></div>";
		$content .= "<script>$(window).load(function () {showefmovie('".$movieID."', '".$movieSig."', '".$movieSpeed."', '".$movieStart."', '".$movieStop."');});</script>";
		if (!empty($movieID) && !empty($movieSig)) {
				echo $content;
		} else {
				// if no film is specified, redirect to home page
				echo "<script>window.location = '/';</script>";
		}
?>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="_js/eFPIBasic.js"></script>
</html>