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

require_once('settings.php');
require_once('includes/functions.php');
require_once(directoryAboveWebRoot().'/db_con.php');

$idcusers = (isset($_GET['idcusers']) ? $_GET['idcusers'] : "");
$idm = (isset($_GET['idm']) ? $_GET['idm'] : "");
$eFConfigChangeAction = (isset($_GET['eFConfigChangeAction']) ? $_GET['eFConfigChangeAction'] : "");
$eFConfigChangeValue = (isset($_GET['eFConfigChangeValue']) ? $_GET['eFConfigChangeValue'] : "");

switch ($eFConfigChangeAction) {

	case "CUserRightsConfig":
		$anfrage = "UPDATE eFilm_Config_Users SET RIGHTS_Config = '".utf8_decode($eFConfigChangeValue)."' WHERE ID_C_Users='".mysqli_real_escape_string($localDatabase, $idcusers)."';";
		$ergebnis = mysqli_query($localDatabase, $anfrage);
	break;
	
	case "CUserRightsRes":
		$anfrage = "UPDATE eFilm_Config_Users SET RIGHTS_Resources = '".utf8_decode($eFConfigChangeValue)."' WHERE ID_C_Users='".mysqli_real_escape_string($localDatabase, $idcusers)."';";
		$ergebnis = mysqli_query($localDatabase, $anfrage);
	break;
	
	case "CUserRightsPub":
		$anfrage = "UPDATE eFilm_Config_Users SET RIGHTS_Publish = '".utf8_decode($eFConfigChangeValue)."' WHERE ID_C_Users='".mysqli_real_escape_string($localDatabase, $idcusers)."';";
		$ergebnis = mysqli_query($localDatabase, $anfrage);
	break;
	
	case "CUserRightsMoviesSetAll":
		$anfrage_alreadyset = "SELECT * FROM eFilm_Config_Users_MovieRights WHERE ID_C_Users='".mysqli_real_escape_string($localDatabase, $idcusers)."';";
		$ergebnis_alreadyset = mysqli_query($localDatabase, $anfrage_alreadyset);
		$checkcount_alreadyset = mysqli_num_rows($ergebnis_alreadyset);		
		if ( $checkcount_alreadyset > 0 ) {
			//Alte Einträge entfernen
			$anfrage_alreadyset_killold = "DELETE FROM eFilm_Config_Users_MovieRights WHERE ID_C_Users='".mysqli_real_escape_string($localDatabase, $idcusers)."';";
			$ergebnis_alreadyset_killold = mysqli_query($localDatabase, $anfrage_alreadyset_killold);
			}
			//Neue hinzufügen
			$anfrage_setall = "SELECT * FROM eFilm_Content_Movies WHERE _eFWEB_EditorV='1' ORDER BY FILM_ID ASC;";
			$ergebnis_setall = mysqli_query($localDatabase, $anfrage_setall);
			while ($row_setall = mysqli_fetch_array($ergebnis_setall)) {
				$anfrage_setall_usertable = "INSERT INTO eFilm_Config_Users_MovieRights (`_FM_CREATE`, `_FM_CHANGE`, `_FM_DATETIME_CREATE`, `_FM_DATETIME_CHANGE`, `ID_C_Users`, `ID_Movies`, `RIGHTS_Movies`)  VALUES ('".$_SESSION['unik']."', '".$_SESSION['unik']."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."', '".$idcusers."', '".$row_setall['ID_Movies']."', '".$eFConfigChangeValue."');";
				$ergebnis_setall_usertable = mysqli_query($localDatabase, $anfrage_setall_usertable);
			}			
	break;
	
	case "CUserRightsMoviesSetRefresh":
		echo "<table>";
		$anfrage = "SELECT eFilm_Content_Movies.*, eFilm_Config_Users_MovieRights.RIGHTS_Movies FROM eFilm_Content_Movies LEFT JOIN eFilm_Config_Users_MovieRights ON eFilm_Content_Movies.ID_Movies = eFilm_Config_Users_MovieRights.ID_Movies WHERE eFilm_Config_Users_MovieRights.ID_C_Users = ".$idcusers." AND eFilm_Content_Movies._eFWEB_EditorV='1' ORDER BY eFilm_Content_Movies.FILM_ID ASC;";
		$ergebnis = mysqli_query($localDatabase, $anfrage); 
		$trefferzahl=mysqli_num_rows($ergebnis);
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
		<td name='".$row['_eFWEB_FPS']."' data-fps='".$row['_eFWEB_FPS']."' data-format='".$row['STAMMDATEN_Format']."' title='".$row['ID_Movies']."' ".$eFStatusFarbe.">".$row['FILM_ID']."</td>
		<td>".$row['STAMMDATEN_Archivsignatur']."</td>
		<td>".$row['STAMMDATEN_Displaytitel']."</td>
		<td>";
		$UrightsMoviesSetterNONE="";
		$UrightsMoviesSetterVIEW="";
		$UrightsMoviesSetterSELFEDIT="";
		$UrightsMoviesSetterEDIT="";
		switch ($row['RIGHTS_Movies']) {
			case "NONE":
				$UrightsMoviesSetterNONE=" checked='checked'";
			break;
			case "VIEW":
				$UrightsMoviesSetterVIEW=" checked='checked'";
			break;
			case "SELFEDIT":
				$UrightsMoviesSetterSELFEDIT=" checked='checked'";
			break;
			case "EDIT":
				$UrightsMoviesSetterEDIT=" checked='checked'";
			break;	
		}	
		echo "<input type='radio' name='USERMOVIERIGHTS_".$row['ID_Movies']."' value='NONE'".$UrightsMoviesSetterNONE." data-idm='".$row['ID_Movies']."' data-idu='".$idcusers."'> NONE 
			<input type='radio' name='USERMOVIERIGHTS_".$row['ID_Movies']."' value='VIEW'".$UrightsMoviesSetterVIEW." data-idm='".$row['ID_Movies']."' data-idu='".$idcusers."'> VIEW 
			<input type='radio' name='USERMOVIERIGHTS_".$row['ID_Movies']."' value='SELFEDIT'".$UrightsMoviesSetterSELFEDIT." data-idm='".$row['ID_Movies']."' data-idu='".$idcusers."'> SELFEDIT 
			<input type='radio' name='USERMOVIERIGHTS_".$row['ID_Movies']."' value='EDIT'".$UrightsMoviesSetterEDIT." data-idm='".$row['ID_Movies']."' data-idu='".$idcusers."'> EDIT";
		echo "</td>
		</tr>";
		}
		echo "</table>";
	break;

	case "CUserRightsMoviesSetI":
		$anfrage_alreadyset_i = "SELECT * FROM eFilm_Config_Users_MovieRights WHERE ID_C_Users='".mysqli_real_escape_string($localDatabase, $idcusers)."' AND ID_Movies='".mysqli_real_escape_string($localDatabase, $idm)."';";
		$ergebnis_alreadyset_i = mysqli_query($localDatabase, $anfrage_alreadyset_i);
		$checkcount_alreadyset_i = mysqli_num_rows($ergebnis_alreadyset_i);		
		if ( $checkcount_alreadyset_i > 0 ) {
			//Alte Einträge entfernen
			$anfrage_alreadyset_killold_i = "DELETE FROM eFilm_Config_Users_MovieRights WHERE ID_C_Users='".mysqli_real_escape_string($localDatabase, $idcusers)."' AND ID_Movies='".mysqli_real_escape_string($localDatabase, $idm)."';";
			$ergebnis_alreadyset_killold_i = mysqli_query($localDatabase, $anfrage_alreadyset_killold_i);
			}
			//Neue hinzufügen
			$anfrage_setall_usertable_i = "INSERT INTO eFilm_Config_Users_MovieRights (`_FM_CREATE`, `_FM_CHANGE`, `_FM_DATETIME_CREATE`, `_FM_DATETIME_CHANGE`, `ID_C_Users`, `ID_Movies`, `RIGHTS_Movies`)  VALUES ('".$_SESSION['unik']."', '".$_SESSION['unik']."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."', '".$idcusers."', '".$idm."', '".$eFConfigChangeValue."');";
			$ergebnis_setall_usertable_i = mysqli_query($localDatabase, $anfrage_setall_usertable_i);		
			
	break;
	
	case "CUserRightsMoviesSetRefreshIndividual":
		$anfrage_alreadyset_ishow = "SELECT * FROM eFilm_Config_Users_MovieRights WHERE ID_C_Users='".mysqli_real_escape_string($localDatabase, $idcusers)."' AND ID_Movies='".mysqli_real_escape_string($localDatabase, $idm)."';";
		$ergebnis_alreadyset_ishow = mysqli_query($localDatabase, $anfrage_alreadyset_ishow);
		while ($row_ishow = mysqli_fetch_array($ergebnis_alreadyset_ishow)) {
		echo "<td>";
		$UrightsMoviesSetterNONE="";
		$UrightsMoviesSetterVIEW="";
		$UrightsMoviesSetterSELFEDIT="";
		$UrightsMoviesSetterEDIT="";
			switch ($row_ishow['RIGHTS_Movies']) {
				case "NONE":
					$UrightsMoviesSetterNONE=" checked='checked'";
				break;
				case "VIEW":
					$UrightsMoviesSetterVIEW=" checked='checked'";
				break;
				case "SELFEDIT":
					$UrightsMoviesSetterSELFEDIT=" checked='checked'";
				break;
				case "EDIT":
					$UrightsMoviesSetterEDIT=" checked='checked'";
				break;	
			}	
		echo "<input type='radio' name='USERMOVIERIGHTS_".$row_ishow['ID_Movies']."' value='NONE'".$UrightsMoviesSetterNONE." data-idm='".$row_ishow['ID_Movies']."' data-idu='".$idcusers."'> NONE 
			<input type='radio' name='USERMOVIERIGHTS_".$row_ishow['ID_Movies']."' value='VIEW'".$UrightsMoviesSetterVIEW." data-idm='".$row_ishow['ID_Movies']."' data-idu='".$idcusers."'> VIEW 
			<input type='radio' name='USERMOVIERIGHTS_".$row_ishow['ID_Movies']."' value='SELFEDIT'".$UrightsMoviesSetterSELFEDIT." data-idm='".$row_ishow['ID_Movies']."' data-idu='".$idcusers."'> SELFEDIT 
			<input type='radio' name='USERMOVIERIGHTS_".$row_ishow['ID_Movies']."' value='EDIT'".$UrightsMoviesSetterEDIT." data-idm='".$row_ishow['ID_Movies']."' data-idu='".$idcusers."'> EDIT";
			echo " hugo";
		echo "</td>";
		}
	break;

}





?>
