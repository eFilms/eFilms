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

require_once('../settings.php');
require_once('../includes/functions.php');
require_once(directoryAboveWebRoot().'/db_con.php');

$eFNewObjektL1L2_Array = (isset($_GET['eFNewObjektL1L2_Array']) ? $_GET['eFNewObjektL1L2_Array'] : "");

echo $eFNewObjektL1L2_Array;

$teile = explode("|",$eFNewObjektL1L2_Array);
print_r($teile);
$i=0;
foreach ($teile as $item) {
        $hugo = explode( ',', $item );
        if (!empty($item)) {
        	foreach  ($hugo as $subhugo) {
        		$subsubhugo = explode( ':', $subhugo );
        		$contents[$i][$subsubhugo[0]] = $subsubhugo[1];
        	}
        }
        $i=$i+1;
    }
print_r($contents);

$L1_content = array();
$L2_content = array();
$i=0;
foreach ($contents as $key=>$value) {
	
	echo $value['Fieldname']." | ".$value['Fieldcontent']."<br/>";
	
	switch ($value['Fieldname']) {
	case 'Type':
	$L1_content['Type'] = $value['Fieldcontent'];
	break;
	case 'Object_Key':
	echo $value['Fieldcontent'];
	$L1_content['Object_Key'] = $value['Fieldcontent'];
	break;
	case 'Category':
	$L1_content['Category'] = $value['Fieldcontent'];
	break;
	case 'Group':
	$L1_content['Group'] = $value['Fieldcontent'];
	break;
	default:
	$L2_content[$i] = $value;
	$i=$i+1;
	break;
	}
}


print_r($L1_content);

$anfrage_IDL0 = "INSERT INTO eFilm_ReSources_L1 (`Type`, `Object_Key`, `Category`, `Group`) VALUES ('".mysqli_real_escape_string($localDatabase, utf8_decode($L1_content['Type']))."', '".mysqli_real_escape_string($localDatabase, utf8_decode($L1_content['Object_Key']))."', '".mysqli_real_escape_string($localDatabase, utf8_decode($L1_content['Category']))."', '".mysqli_real_escape_string($localDatabase, utf8_decode($L1_content['Group']))."');";
$ergebnis_IDL0 = mysqli_query($localDatabase, $anfrage_IDL0);

$anfrage_IDL1 = "SELECT ID_R_L1 FROM  eFilm_ReSources_L1 WHERE Object_Key='".$L1_content['Object_Key']."';";
$ergebnis_IDL1 = mysqli_query($localDatabase, $anfrage_IDL1);
$trefferzahl_IDL1=mysqli_num_rows($ergebnis_IDL1);
if ($trefferzahl_IDL1 == 1 ) {
	while ($row_IDL1 = mysqli_fetch_array($ergebnis_IDL1)) {
		//echo $row_IDL1['ID_R_L1'];
		
		$ID_L1_for_L2 = $row_IDL1['ID_R_L1'];
		
	}
	foreach ($L2_content as $kL2 => $vL2) {
		if (isset($vL2['originalName'])) {
			$anfrage_IDL2 = "INSERT INTO eFilm_ReSources_L2 (`ID_R_L1`, `Fieldname`, `Fieldtype`, `Fieldcontent`, `originalName`)  VALUES ('".mysqli_real_escape_string($localDatabase, utf8_decode($ID_L1_for_L2))."', '".mysqli_real_escape_string($localDatabase, utf8_decode($vL2['Fieldname']))."', '".mysqli_real_escape_string($localDatabase, utf8_decode($vL2['Fieldtype']))."', '".mysqli_real_escape_string($localDatabase, utf8_decode($vL2['Fieldcontent']))."', '".mysqli_real_escape_string($localDatabase, utf8_decode($vL2['originalName']))."');";
		} else {
			$anfrage_IDL2 = "INSERT INTO eFilm_ReSources_L2 (`ID_R_L1`, `Fieldname`, `Fieldtype`, `Fieldcontent`)  VALUES ('".mysqli_real_escape_string($localDatabase, utf8_decode($ID_L1_for_L2))."', '".mysqli_real_escape_string($localDatabase, utf8_decode($vL2['Fieldname']))."', '".mysqli_real_escape_string($localDatabase, utf8_decode($vL2['Fieldtype']))."', '".mysqli_real_escape_string($localDatabase, utf8_decode($vL2['Fieldcontent']))."');";
		}
		$ergebnis_IDL2 = mysqli_query($localDatabase, $anfrage_IDL2);
	
	}
}
