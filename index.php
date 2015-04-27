<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

include 'includes/functions.php';
?>

<script>
	function createDatabase() {
		createFile("makeDatabase.php","databaseName="+document.getElementById('databaseName').value+"&databaseLocation="+document.getElementById('databaseLocation').value+"&databaseUsername="+document.getElementById('databaseUsername').value+"&databasePassword="+document.getElementById('databasePassword').value);
	}

	function createAdmin() {
		createFile("createFirstUser.php","adminName="+document.getElementById('adminName').value+"&adminNickname="+document.getElementById('adminNickname').value+"&adminEmail="+document.getElementById('adminEmail').value+"&adminPassword="+document.getElementById('adminPassword').value);
	}
	
	function createS3() {
		createFile("setupAmazon.php","skip=false&s3Key="+document.getElementById('s3Key').value+"&s3Secret="+document.getElementById('s3Secret').value+"&s3Region="+document.getElementById('s3Region').value);
	}
	
	function skipS3() {
		createFile("setupAmazon.php","skip=true");
	}
	
	function createS3L() {
		createFile("saveSettings.php","s3Lurl="+document.getElementById('s3Lurl').value);
	}

	function storeLocally() {
		createFile("saveSettings.php","");
	}
	
	function createFile(fileScript, data) {
		var xhr = new XMLHttpRequest();
		xhr.addEventListener("load", updateComplete, false);
		xhr.open("POST", fileScript);
		xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xhr.send(data);
	}

	function updateComplete(evt) {
		var response = JSON.parse(evt.target.responseText);
		if (response['complete'] == 'yes') {
			document.getElementById(response['setting']+'Done').display = 'block';
			document.getElementById(response['setting']+'Table').display = 'none';
			alert(response['reason']);
			location.reload();
		} else {
			alert('Please try again: '+response['reason']);
		}
	}
</script>

<?php

echo "<center><h2>Film Editor Setup</h2></center>";

if (file_exists('makeDatabase.php') && !file_exists(directoryAboveWebRoot().'/db_con.php')) {
	// need mysql credentials to create db_con.php file
	echo "<div style=\"margin: 0px auto; width: 295px;\">";
	echo "<center><h3>MySQL Database Setup</h3></center>";
	echo "<center><span id=\"databaseDone\" style=\"color: green; margin: 45px 45px; display: none;\">Database Complete!</span></center>";
	echo "<table id=\"databaseTable\">";
	echo "<tr><td>Database Name:</td><td><input type=\"text\" id=\"databaseName\" name=\"databaseName\" placeholder=\"eFilms\"></td></tr>";
	echo "<tr><td>Database Location:</td><td><input type=\"text\" id=\"databaseLocation\" name=\"databaseLocation\" placeholder=\"localhost\"></td></tr>";
	echo "<tr><td>Database Username:</td><td><input type=\"text\" id=\"databaseUsername\" name=\"databaseUsername\"></td></tr>";
	echo "<tr><td>Database Password:</td><td><input type=\"text\" id=\"databasePassword\" name=\"databasePassword\"></td></tr>";
	echo "<tr><td colspan=2 style=\"text-align: center;\">";
	echo "<button type=\"button\" onclick=\"createDatabase();\">Create</button>";
	echo "</td></tr>";
	echo "</table>";
	echo "</div>";
	exit();
}

if (file_exists('createFirstUser.php') && !file_exists(directoryAboveWebRoot().'/.htpasswd') && !file_exists('.htaccess')) {
	// need to set up first user and create password requirement on server
	echo "<div style=\"margin: 0px auto; width: 295px;\">";
	echo "<center><h3>Admin User Setup</h3></center>";
	echo "<center><span id=\"adminDone\" style=\"color: green; margin: 45px 45px; display: none;\">Admin Setup Complete!</span></center>";
	echo "<table id=\"adminTable\">";
	echo "<tr><td>Name:</td><td><input type=\"text\" id=\"adminName\" name=\"adminName\"></td></tr>";
	echo "<tr><td>Nickname:</td><td><input type=\"text\" id=\"adminNickname\" name=\"adminNickname\"></td></tr>";
	echo "<tr><td>Email:</td><td><input type=\"text\" id=\"adminEmail\" name=\"adminEmail\"></td></tr>";
	echo "<tr><td>Password:</td><td><input type=\"password\" id=\"adminPassword\" name=\"adminPassword\"></td></tr>";
	echo "<tr><td colspan=2 style=\"text-align: center;\">";
	echo "<button type=\"button\" onclick=\"createAdmin();\">Create</button>";
	echo "</td></tr>";
	echo "</table>";
	echo "</div>";
	exit();
}

if (file_exists('setupAmazon.php')) {
	// need Amazon credentials if S3 is going to be used
	echo "<div style=\"margin: 0px auto; width: 295px;\">";
	echo "<center><h3>Amazon S3 Setup</h3></center>";
	echo "<center><span id=\"s3Done\" style=\"color: green; margin: 45px 45px; display: none;\">S3 Setup Complete!</span></center>";
	echo "<table id=\"s3Table\">";
	echo "<tr><td>S3 Key:</td><td><input type=\"text\" id=\"s3Key\" name=\"s3Key\"></td></tr>";
	echo "<tr><td>S3 Secret:</td><td><input type=\"text\" id=\"s3Secret\" name=\"s3Secret\"></td></tr>";
	echo "<tr><td>S3 Region:</td><td><input type=\"text\" id=\"s3Region\" name=\"s3Region\"></td></tr>";
	echo "<tr><td colspan=2 style=\"text-align: center;\">";
	echo "<button type=\"button\" onclick=\"createS3();\">Create</button>";
	echo " &emsp; ";
	echo "<button type=\"button\" onclick=\"skipS3();\">Skip</button>";
	echo "</td></tr>";
	echo "</table>";
	echo "</div>";
	exit();
}

// To create a basic player we will need the paths to the assets
if (file_exists(directoryAboveWebRoot().'/amazonCredentials.php') && !file_exists('settings.php')) {
	// need path to images and films
	echo "<div style=\"margin: 0px auto; width: 295px;\">";
	echo "<center><h3>Amazon S3 Location</h3></center>";
	echo "<center><span id=\"s3LDone\" style=\"color: green; margin: 45px 45px; display: none;\">S3 Location Set!</span></center>";
	echo "<table id=\"s3LTable\">";
	echo "<tr><td>Amazon URL: </td><td><input type=\"text\" id=\"s3Lurl\"></td></tr>";
	echo "<tr><td colspan=2 style=\"text-align: center;\"><button type=\"button\" onclick=\"createS3L();\">Set</button></td></tr>";
	echo "</table>";
	echo "</div>";
	exit();
} else if (!file_exists('settings.php')) {
	// set up the image paths for the local site
?>
	<script>
		storeLocally();
	</script>
<?php	
}

include('buildIndex.php');

echo "<center><h3>You are done! Reload the page to begin!</h3></center>";

