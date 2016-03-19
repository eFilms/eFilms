<?php

if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION["login"] != "true") {
    header("Location:login.php");
    $_SESSION["error"] = "<h1 style='color:red;'>You don't have privileges to see this page.</h1>";
    exit;
}

require_once('settings.php');
require_once('includes/functions.php');
require_once(directoryAboveWebRoot().'/db_con.php');

$idcusers = (isset($_GET['idcusers']) ? $_GET['idcusers'] : "");

$uniqueUTS = time();

$anfrage_ULD = "SELECT * FROM eFilm_Config_Users WHERE ID_C_Users='" . $idcusers . "';";
$ergebnis_ULD = mysqli_query($localDatabase, $anfrage_ULD);
$trefferzahl_ULD = mysqli_num_rows($ergebnis_ULD);
$row_ULD = mysqli_fetch_array($ergebnis_ULD);

//Basic User rights
echo "<table class='eFConfigAccessUsersCredentialsTable' data-idcusers='" . $row_ULD['ID_C_Users'] . "'>";
echo "<tr>";
echo "		<td class='unameing'>User Name</td><td class='ucontent'>" . $row_ULD['USER_Name'] . "</td>";
echo "			<td class='unameing'>Rights Config</td><td class='ucontent'>";
$selfnot = ($row_ULD['USER_Nik'] == $_SESSION["unik"] ? "1" : "0");
$UrightsConfigSetterNONE = "";
$UrightsConfigSetterVIEW = "";
$UrightsConfigSetterEDIT = "";

switch ($row_ULD['RIGHTS_Config']) {
    case "NONE":
        $UrightsConfigSetterNONE = " checked='checked'";
        break;
    case "VIEW":
        $UrightsConfigSetterVIEW = " checked='checked'";
        break;
    case "EDIT":
        $UrightsConfigSetterEDIT = " checked='checked'";
        break;
}
if ($selfnot == 0) {
    echo "<input type='radio' name='USERRIGHTSCONFIG' value='NONE'" . $UrightsConfigSetterNONE . " data-idcusers='" . $row_ULD['ID_C_Users'] . "'> NONE ";
    //<input type='radio' name='USERRIGHTSCONFIG' value='VIEW'".$UrightsConfigSetterVIEW." data-idcusers='".$row_ULD['ID_C_Users']."'> VIEW 
    echo "<input type='radio' name='USERRIGHTSCONFIG' value='EDIT'" . $UrightsConfigSetterEDIT . " data-idcusers='" . $row_ULD['ID_C_Users'] . "'> EDIT";
} else {
    echo $row_ULD['RIGHTS_Config'];
}
echo "</td>";
echo "	</tr>";
echo "	<tr>";
echo "		<td class='unameing'>Nickname</td><td class='ucontent'>" . $row_ULD['USER_Nik'] . "</td>";
echo "			<td class='unameing'>Rights Resources</td><td class='ucontent'>";
$UrightsResSetterNONE = "";
$UrightsResSetterVIEW = "";
$UrightsResSetterEDIT = "";

switch ($row_ULD['RIGHTS_Resources']) {
    case "NONE":
        $UrightsResSetterNONE = " checked='checked'";
        break;
    case "VIEW":
        $UrightsResSetterVIEW = " checked='checked'";
        break;
    case "EDIT":
        $UrightsResSetterEDIT = " checked='checked'";
        break;
}
if ($selfnot == 0) {
    echo "<input type='radio' name='USERRIGHTSRES' value='NONE'" . $UrightsResSetterNONE . " data-idcusers='" . $row_ULD['ID_C_Users'] . "'> NONE ";
    //<input type='radio' name='USERRIGHTSRES' value='VIEW'".$UrightsResSetterVIEW." data-idcusers='".$row_ULD['ID_C_Users']."'> VIEW 
    echo "<input type='radio' name='USERRIGHTSRES' value='EDIT'" . $UrightsResSetterEDIT . " data-idcusers='" . $row_ULD['ID_C_Users'] . "'> EDIT";
} else {
    echo $row_ULD['RIGHTS_Resources'];
}
echo "</td>";
echo "	</tr>";
echo "	<tr>";
echo "		<td class='unameing'>Password</td><td class='ucontent'>******** &nbsp; &nbsp; <a href='#' onclick='sendPasswordReset(" . $row_ULD['ID_C_Users'] . ");'>Send Reset</a></td>"; // $row_ULD['USER_Pass']
echo "			<td class='unameing'>Rights Publish</td><td class='ucontent'>";
$UrightsResSetterNONE = "";
$UrightsResSetterVIEW = "";
$UrightsResSetterEDIT = "";

switch ($row_ULD['RIGHTS_Publish']) {
    case "NONE":
        $UrightsPubSetterNONE = " checked='checked'";
        break;
    case "EDIT":
        $UrightsPubSetterEDIT = " checked='checked'";
        break;
}
if ($selfnot == 0) {
    echo "<input type='radio' name='USERRIGHTSPUB' value='NONE'" . $UrightsPubSetterNONE . " data-idcusers='" . $row_ULD['ID_C_Users'] . "'> NONE ";
    echo "<input type='radio' name='USERRIGHTSPUB' value='EDIT'" . $UrightsPubSetterEDIT . " data-idcusers='" . $row_ULD['ID_C_Users'] . "'> EDIT";
} else {
    echo $row_ULD['RIGHTS_Publish'];
}
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<div id='eFUCOK'>OK</div>";

echo "<div id='eFConfigUserDetailMovieListTitle'>Rights Movies</div>";
echo "<div id='eFConfigUserDetailSetAllMovieRights'>
Set all to <input type='radio' name='USERMOVIERIGHTS_SETALL' value='NONE' data-idcusers='" . $row_ULD['ID_C_Users'] . "'> NONE <input type='radio' name='USERMOVIERIGHTS_SETALL' value='VIEW' data-idcusers='" . $row_ULD['ID_C_Users'] . "'> VIEW <input type='radio' name='USERMOVIERIGHTS_SETALL' value='SELFEDIT' data-idcusers='" . $row_ULD['ID_C_Users'] . "'> SELFEDIT <input type='radio' name='USERMOVIERIGHTS_SETALL' value='EDIT' data-idcusers='" . $row_ULD['ID_C_Users'] . "'> EDIT
</div>";
echo "<div id='eFConfigUserDetailMovieListHeader'><table><tr><td>E-ID</td><td>A-ID</td><td>Title</td><td>Rights</td></tr></table></div>";

echo "<div id='eFConfigUserDetailMovieList'><table>";

require_once('db_con.php');

$anfrage = "SELECT eFilm_Content_Movies.*, eFilm_Config_Users_MovieRights.RIGHTS_Movies FROM eFilm_Content_Movies LEFT JOIN eFilm_Config_Users_MovieRights ON eFilm_Content_Movies.ID_Movies = eFilm_Config_Users_MovieRights.ID_Movies AND eFilm_Config_Users_MovieRights.ID_C_Users = " . $row_ULD['ID_C_Users'] . " WHERE eFilm_Content_Movies._eFWEB_EditorV='1' ORDER BY eFilm_Content_Movies.FILM_ID ASC;";


$ergebnis = mysqli_query($localDatabase, $anfrage);
$trefferzahl = mysqli_num_rows($ergebnis);


while ($row = mysqli_fetch_array($ergebnis)) {
//if ($row['_eFWEB_Praktikantin'] == 1) { $PraktikantInnenfarbe = " style=\"color:#FF0000\"";} else {$PraktikantInnenfarbe = "";}

    switch ($row['_eFWEB_Status']) {

        case "0":
            $eFStatusFarbe = "";
            break;
        case "1":
            $eFStatusFarbe = " style=\"color:#FF0000\"";
            break;
        case "2":
            $eFStatusFarbe = " style=\"color:#6666FF\"";
            break;
    }


    echo "<tr>
		<td name='" . $row['_eFWEB_FPS'] . "' data-fps='" . $row['_eFWEB_FPS'] . "' data-format='" . $row['STAMMDATEN_Format'] . "' title='" . $row['ID_Movies'] . "' " . $eFStatusFarbe . ">" . $row['FILM_ID'] . "</td>
		<td>" . $row['STAMMDATEN_Archivsignatur'] . "</td>
		<td>" . $row['STAMMDATEN_Displaytitel'] . "</td>
		<td>";

    $UrightsMoviesSetterNONE = "";
    $UrightsMoviesSetterVIEW = "";
    $UrightsMoviesSetterSELFEDIT = "";
    $UrightsMoviesSetterEDIT = "";

    switch ($row['RIGHTS_Movies']) {
        case "NONE":
            $UrightsMoviesSetterNONE = " checked='checked'";
            break;
        case "VIEW":
            $UrightsMoviesSetterVIEW = " checked='checked'";
            break;
        case "SELFEDIT":
            $UrightsMoviesSetterSELFEDIT = " checked='checked'";
            break;
        case "EDIT":
            $UrightsMoviesSetterEDIT = " checked='checked'";
            break;
    }


    echo "<input type='radio' name='USERMOVIERIGHTS_" . $row['ID_Movies'] . "' value='NONE'" . $UrightsMoviesSetterNONE . " data-idm='" . $row['ID_Movies'] . "' data-idu='" . $row_ULD['ID_C_Users'] . "'> NONE 
	<input type='radio' name='USERMOVIERIGHTS_" . $row['ID_Movies'] . "' value='VIEW'" . $UrightsMoviesSetterVIEW . " data-idm='" . $row['ID_Movies'] . "' data-idu='" . $row_ULD['ID_C_Users'] . "'> VIEW 
	<input type='radio' name='USERMOVIERIGHTS_" . $row['ID_Movies'] . "' value='SELFEDIT'" . $UrightsMoviesSetterSELFEDIT . " data-idm='" . $row['ID_Movies'] . "' data-idu='" . $row_ULD['ID_C_Users'] . "'> SELFEDIT 
	<input type='radio' name='USERMOVIERIGHTS_" . $row['ID_Movies'] . "' value='EDIT'" . $UrightsMoviesSetterEDIT . " data-idm='" . $row['ID_Movies'] . "' data-idu='" . $row_ULD['ID_C_Users'] . "'> EDIT";
    echo "</td></tr>";
}


echo "</table>";

echo "</div>";
?>
