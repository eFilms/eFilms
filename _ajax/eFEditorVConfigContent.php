<?php
if(!isset($_SESSION)) {
    session_start();
}

if ($_SESSION["login"] != "true") {
    header("Location:login.php");
    $_SESSION["error"] = "<h1 style='color:red;'>You don't have privileges to see this page.</h1>";
    exit();
}

require_once('../settings.php');
require_once('../includes/functions.php');
require_once(directoryAboveWebRoot().'/db_con.php');

$eFContentSelected = (isset($_GET['eFContentSelected']) ? $_GET['eFContentSelected'] : "");
$eFContentKat = (isset($_GET['eFContentKat']) ? $_GET['eFContentKat'] : "");

$uniqueUTS = time();

switch ($eFContentSelected) {
    case "Access":
        switch ($eFContentKat) {
            case "Users":
                echo "<div id='eFConfigAccessUsersList'>";
                echo "<div class='eFConfigTitle'>".$eFContentKat." <span style='float:right; padding-right: 10px; color: #ffffff; cursor: pointer;' onclick='showNewUserForm();'>+</span></div>";
                echo "<div id='eFConfigUsersList'>";
                $anfrage_UL = "SELECT * FROM eFilm_Config_Users WHERE 1;";
                $ergebnis_UL = mysqli_query($localDatabase, $anfrage_UL); 
                $trefferzahl_UL = mysqli_num_rows($ergebnis_UL);
                while ($row_UL = mysqli_fetch_array($ergebnis_UL)) {
                    $selfclass = ($row_UL['USER_Nik'] == $_SESSION["unik"] ? " eFConfigUserListEntrySelf" : "");
                    echo "<div class='eFConfigUserListEntry ".$selfclass."' data-idcusers='".$row_UL['ID_C_Users']."'>".$row_UL['USER_Name'];
                    // You can't delete yourself or User Zero from the system.
                    if ($row_UL['ID_C_Users'] != 1 && $row_UL['USER_Nik'] != $_SESSION["unik"]) { // You can delete anyone but yourself and User Zero.  User Zero can delete everyone else
                      echo "<span style='float:right; padding-right: 10px; color: #ffffff; cursor: pointer;' onclick='deleteUser(".$row_UL['ID_C_Users'].");'>x</span>";
                    }
                    if ($row_UL['USER_Nik'] == $_SESSION["unik"] || ($_SESSION["unik"] == "IZ" && $_SESSION["efuid"] == 1)) { // You can only edit yourself.  User Zero can edit everyone
                      echo "<span style='float:right; padding-right: 10px; color: #ffffff; cursor: pointer;' onclick='showEditUserForm(\"".$row_UL['ID_C_Users']."\",\"".$row_UL['USER_Name']."\",\"".$row_UL['USER_Nik']."\",\"".$row_UL['email']."\");'><img src='/_img/edit.png' height='12px' width='12px' style='padding-top: 3px;'></span>";
                    }
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>";
                echo "<div id='eFConfigAccessUsersDetails'>";
                echo "</div>";
                break;
        }
        break;
    case "Content":
        switch ($eFContentKat) {
            case "Naming":
                echo $eFContentSelected." 4 ".$eFContentKat;
                break;
        }
        break;
}
