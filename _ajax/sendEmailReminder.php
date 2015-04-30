<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//ini_set('display_errors','On');

if (!isset($_SESSION)) { 
    session_start(); 
}
if ($_SESSION["login"] != "true") {
    header("Location:login.php");
    $_SESSION["error"] = "<h1 style='color:red;'>You don't have privileges to see this page.</h1>";
    exit;
}

$valid_characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_";

function get_random_string($valid_chars, $length)
{
    // start with an empty random string
    $random_string = "";

    // count the number of chars in the valid chars string so we know how many choices we have
    $num_valid_chars = strlen($valid_chars);

    // repeat the steps until we've created a string of the right length
    for ($i = 0; $i < $length; $i++)
    {
        // pick a random number from 1 up to the number of valid chars
        $random_pick = mt_rand(1, $num_valid_chars);

        // take the random character out of the string of valid chars
        // subtract 1 from $random_pick because strings are indexed starting at 0, and we started picking at 1
        $random_char = $valid_chars[$random_pick-1];

        // add the randomly-chosen char onto the end of our string so far
        $random_string .= $random_char;
    }

    // return our finished random string
    return $random_string;
}

require_once('/settings.php');
require_once('/includes/functions.php');
require_once(directoryAboveWebRoot().'/db_con.php');

date_default_timezone_set('GMT');

$id = $_POST['id'];

if (!empty($id) && ctype_digit($id)) {
    $select = "SELECT `email`,`USER_Name` from `eFilm_Config_Users` WHERE `ID_C_Users` = '".$id."';";
    $userEmail = mysqli_query($localDatabase, $select);
    
    while($row = mysqli_fetch_array($userEmail)) {
        $sendTo = $row['email'];
        $randomFileName = get_random_string($valid_characters, 18).".php";
        $formProcessName = get_random_string($valid_characters, 18).".php";
        $headers = "From: webmaster@".$_SERVER['HTTP_HOST']."\r\n".
        "Reply-To: webmaster@".$_SERVER['HTTP_HOST']."\r\n" .
        "X-Mailer: PHP/".phpversion();
        $content = "\nHi ".$row['USER_Name'];
        $content .= "\n\nA password reset link has been created for you.  Please use this link to set a new password for the editor interface.\n\nThis link will expire 20 minutes from the time it was sent, if you did not request this from a system administrator please ignore this email and your password will remain unchanged.";
        $content .= "\n\nhttp://".$_SERVER['HTTP_HOST']."/reset/$randomFileName";
        if (mail($sendTo, "eFilms Editor Reset Link - ".date("m/d/Y"), $content, $headers)) {
            if (!file_exists($_SERVER['DOCUMENT_ROOT']."/reset")) {
                mkdir($_SERVER['DOCUMENT_ROOT']."/reset");
            }
            // Write the Password Update form file
            $content = "<?php\n";
            $content .= "\$expire=".(time() + (20 * 60)).";\n";
            $content .= "\$id = $id;\n";
            $content .= "if (time() > \$expire) {\n";
            $content .= "   unlink(\"".$_SERVER['DOCUMENT_ROOT']."/reset/$randomFileName\");\n";
            $content .= "   unlink(\"".$_SERVER['DOCUMENT_ROOT']."/reset/$formProcessName\");\n";
            $content .= "   exit();\n";
            $content .= "}\n";
            $content .= "echo '<html>';\n";
            $content .= "echo '<head>';\n";
            $content .= "echo '</head>';\n";
            $content .= "echo '<body>';\n";
            $content .= "echo '<script>';\n";
            $content .= "echo '    function passwordCheck() {';\n";
            $content .= "echo '        var pass1 = document.getElementById(\"pass1\").value;';\n";
            $content .= "echo '        var pass2 = document.getElementById(\"pass2\").value;';\n";
            $content .= "echo '        if (pass1 != pass2) {';\n";
            $content .= "echo '            alert(\"Passwords Do not match\");';\n";
            $content .= "echo '            document.getElementById(\"pass1\").style.borderColor = \"#E34234\";';\n";
            $content .= "echo '            document.getElementById(\"pass2\").style.borderColor = \"#E34234\";';\n";
            $content .= "echo '            return false;';\n";
            $content .= "echo '        } else {';\n";
            $content .= "echo '            return true;';\n";
            $content .= "echo '        }';\n";
            $content .= "echo '    }';\n";
            $content .= "echo '</script>';\n";
            $content .= "echo '<center>';\n";
            $content .= "echo '<form id=\"changeForm\" method=\"POST\" action=\"$formProcessName\" onsubmit=\"return passwordCheck()\">';\n";
            $content .= "echo '<input type=\"hidden\" name=\"id\" value=\"$id\">';\n";
            $content .= "echo 'New Password: <input id=\"pass1\" type=\"password\" name=\"password\" value=\"\">';\n";
            $content .= "echo '<br>';\n";
            $content .= "echo 'Verify Password: <input id=\"pass2\" type=\"password\" name=\"password1\" value=\"\">';\n";
            $content .= "echo '<br>';\n";
            $content .= "echo '<input type=\"submit\" value=\"Save\">';\n";
            $content .= "echo '</form>';\n";
            $content .= "echo '</center>';\n";
            $content .= "echo '</body>';\n";
            $content .= "echo '</html>';\n";
            $content .= "unlink(\"".$_SERVER['DOCUMENT_ROOT']."/reset/$randomFileName\");\n";
            $fp = fopen($_SERVER['DOCUMENT_ROOT']."/reset/".$randomFileName, 'w');
            fwrite($fp, $content);
            fclose($fp);
            // Write the Password Update Form processing script
            $content = "<?php\n";
            $content .= "\$expire=".(time() + (20 * 60)).";\n";
            $content .= "\$idCheck = ".$id.";\n";
            $content .= "if (time() > \$expire || \$idCheck != \$_POST['id'] || \$_POST['password'] != \$_POST['password1']) {\n";
            $content .= "   echo \"could not update password, please contact your system administrator\";\n";
            $content .= "   unlink(\"".$_SERVER['DOCUMENT_ROOT']."/reset/$randomFileName\");\n";
            $content .= "   unlink(\"".$_SERVER['DOCUMENT_ROOT']."/reset/$formProcessName\");\n";
            $content .= "   exit();\n";
            $content .= "}\n";
            $content .= "\$fp = fopen(\"".directoryAboveWebRoot()."/.htpasswd\", \"r\");\n";
            $content .= "if (\$fp) {\n";
            $content .= "    while ((\$line = fgets(\$fp)) !== false) {\n";
            $content .= "        list(\$key, \$value) = explode(\":\", trim(\$line));\n";
            $content .= "        \$loginArray[\$key] = \$value;\n";
            $content .= "    }\n";
            $content .= "} else {\n";
            $content .= "   echo \"could not update password, please contact your system administrator\";\n";
            $content .= "   unlink(\"".$_SERVER['DOCUMENT_ROOT']."/reset/$randomFileName\");\n";
            $content .= "   unlink(\"".$_SERVER['DOCUMENT_ROOT']."/reset/$formProcessName\");\n";
            $content .= "   exit();\n";
            $content .= "}\n";
            $content .= "fclose(\$fp);\n";
            $content .= "require_once(\"".directoryAboveWebRoot()."/db_con.php\");\n";
            $content .= "\$select = \"SELECT `email`,`USER_Name` from `eFilm_Config_Users` WHERE `ID_C_Users` = '\".\$idCheck.\"'\";\n";
            $content .= "\$userEmail = mysqli_query(\$localDatabase, \$select);\n";
            $content .= "while(\$row = mysqli_fetch_array(\$userEmail)) {\n";
            $content .= "   \$loginArray[\$row['USER_Name']] = crypt(\$_POST['password'], base64_encode(\$_POST['password']));\n";
            $content .= "}\n";
            $content .= "\$fp = fopen(\"".directoryAboveWebRoot()."/.htpasswd\", \"w\");\n";
            $content .= "foreach (\$loginArray as \$key => \$value) {\n";
            $content .= "   fwrite(\$fp, \$key.\":\".\$value.\"\\n\");\n";
            $content .= "}\n";
            $content .= "fclose(\$fp);\n";
            $content .= "echo '<center>';\n";
            $content .= "echo '<h2>Your password has been updated</h2>';\n";
            $content .= "echo '<a href=\"/\">Click Here to Login</a>';\n";
            $content .= "echo '</center>';\n";
            $content .= "unlink(\"".$_SERVER['DOCUMENT_ROOT']."/reset/$formProcessName\");\n";
            $fp = fopen($_SERVER['DOCUMENT_ROOT']."/reset/".$formProcessName, 'w');
            fwrite($fp, $content);
            fclose($fp);
        }
    }
    
}