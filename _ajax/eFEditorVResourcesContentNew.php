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

require_once('/settings.php');
require_once('/includes/functions.php');
require_once(directoryAboveWebRoot().'/db_con.php');

$eFNewResourceType = (isset($_GET['eFNewResourceType']) ? $_GET['eFNewResourceType'] : "");
$eFNewResourceCategory = (isset($_GET['eFNewResourceCategory']) ? $_GET['eFNewResourceCategory'] : "");
$eFShortM1 = (isset($_GET['eFShortM1']) ? $_GET['eFShortM1'] : "");
$eFShortM2 = (isset($_GET['eFShortM2']) ? $_GET['eFShortM2'] : "");

$anfrage = "SELECT * FROM  eFilm_ReSources_Templates WHERE Resource_Type='".mysqli_real_escape_string($localDatabase, $eFNewResourceType)."' ORDER BY Resource_Index;";
$ergebnis = mysqli_query($localDatabase, $anfrage);

$uniqueUTS = time();

echo "<div id='efResourceUnitNewContainerPopDown'><div id='efResourceUnitNewContainerPopDownContent'></div><div id='efResourceUnitNewContainerPopDownClose'>close</div></div>";
echo "<div id='eFResourcesNewObjectFormContainer' data-resourcetype=''>";
echo "<div id='eFResourcesNewObjectFormContainerTitle' >New ".substr($eFNewResourceType, 0, -1)."</div>";
echo "<div class='eFResourcesNewObjectFormContainerTemplate'>";

echo "<div class='eFResourcesNewObjectFormNewL2'>";
echo "<div class='eFResourcesNewObjectFormNewL2Fieldname' data-fieldtype='text'>Type</div><div class='eFResourcesNewObjectFormNewL2Fieldcontent'><input class='eFinput' type='text' value='".substr($eFNewResourceType, 0, -1)."' name='Type' data-tiptabstatus='' readonly/></div>";
echo "</div>";
echo "<div class='eFResourcesNewObjectFormNewL2'>";
echo "<div class='eFResourcesNewObjectFormNewL2Fieldname' data-fieldtype='text'>Category</div><div class='eFResourcesNewObjectFormNewL2Fieldcontent'><input class='eFinput' type='text' value='".$eFNewResourceCategory."' name='Category' data-tiptabstatus='' readonly/></div>";
echo "</div>";
echo "<div class='eFResourcesNewObjectFormNewL2'>";
echo "<div class='eFResourcesNewObjectFormNewL2Fieldname' data-fieldtype='text'>Group</div><div class='eFResourcesNewObjectFormNewL2Fieldcontent'><input class='eFinput' type='text' value='' name='Group' data-tiptabstatus=''/></div>";
echo "</div>";//eFResourcesNewObjectFormNewL2
echo "<div class='eFResourcesNewObjectFormNewL2'>";
$uniqueobjectkey= $eFShortM1."_".$eFShortM2."_".$uniqueUTS;
echo "<div class='eFResourcesNewObjectFormNewL2Fieldname' data-fieldtype='text'>Object_Key</div><div class='eFResourcesNewObjectFormNewL2Fieldcontent'><input class='eFinput' type='text' value='".$uniqueobjectkey."' name='Object_Key' data-tiptabstatus='' readonly /></div>";
echo "</div>";//eFResourcesNewObjectFormNewL2

while ($row = mysqli_fetch_array($ergebnis)) {
    echo "<div class='eFResourcesNewObjectFormNewL2'>";
    switch ($row['Resource_Fieldtype']) {
        case 'text':
            echo "<div class='eFResourcesNewObjectFormNewL2Fieldname' data-fieldtype='".$row['Resource_Fieldtype']."'>".$row['Resource_Field']."</div><div class='eFResourcesNewObjectFormNewL2Fieldcontent'><input class='eFinput' type='text' value='' name='".$row['Resource_Field']."' data-tiptabstatus=''/></div>";
            break;
        case 'image':
            echo "<div class='eFResourcesNewObjectFormNewL2Fieldname' data-fieldtype='".$row['Resource_Fieldtype']."'>".$row['Resource_Field']."</div>";
            $formidunique = ($uniqueUTS+3)*10;
            $imagename_unique= $uniqueobjectkey.'_IMG_'.$formidunique; 
            echo '<div class="eFResourcesNewObjectFormNewL2Fieldcontent">';
            echo '  <input class="eFinput" type="text" value="'.$imagename_unique.'" name="'.$row['Resource_Field'].'" readonly="readonly" />';
            echo '  <form id="'.$formidunique.'" action="_ajax/eFUploader.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="uploadResponseType" name="mimetype" value="html">
                            <input type="hidden" name="effiletype" value="img">
                            <input type="hidden" name="efilmname" value="'.$imagename_unique.'">
                            <input type="file" name="hugotest">
                            <input type="submit" value="Upload File">
                        </form>
                        <div class="progress" data-uniqueid="'.$formidunique.'">
                            <div class="bar" data-uniqueid="'.$formidunique.'"></div >
                            <div class="percent" data-uniqueid="'.$formidunique.'">0%</div >
                        </div>
                        <div class="status" data-uniqueid="'.$formidunique.'">';
            echo "  </div>";//eFResourcesNewObjectFormNewL2Fieldcontent
            echo "</div>";//eFResourcesNewObjectFormNewL2Fieldname
            //Javascript dazu
            echo "<script type='text/javascript'>
                testomat('".$formidunique."');
                function testomat(formularidentifikation) {
                    var bar = $(document).find('.bar[data-uniqueid=' + formularidentifikation + ']');
                    var percent = $(document).find('.percent[data-uniqueid=' + formularidentifikation + ']');
                    var status = $(document).find('.status[data-uniqueid=' + formularidentifikation + ']');
                    $(document).find('form[id=' + formularidentifikation + ']').ajaxForm({
                        beforeSend: function() {
                                status.empty();
                                var percentVal = '0%';
                                bar.width(percentVal)
                                percent.html(percentVal);
                            },
                        uploadProgress: function(event, position, total, percentComplete) {
                                var percentVal = percentComplete + '%';
                                bar.width(percentVal)
                                percent.html(percentVal);
                            },
                        complete: function(xhr) {
                                console.log(xhr.responseText);
                                var uploadstatus = jQuery.parseJSON(xhr.responseText);
                                //console.log(uploadstatus);
                                //status.html(xhr.responseText);
                                //$(document).find('form[id=' + eFtempFormID + ']').parent().find('.status').remove();
                                var oldfilename = $(document).find('form[id=' + formularidentifikation + ']').parent().find('input[class=eFinput]').val();
                                var newfilename = oldfilename + uploadstatus.fileextension;
                                $(document).find('form[id=' + formularidentifikation + ']').parent().find('input[class=eFinput]').val(newfilename);
                                $(document).find('form[id=' + formularidentifikation + ']').parent().find('.progress').remove();
                                var smallheight = Math.round(250*(uploadstatus.height/uploadstatus.width));
                                $(document).find('form[id=' + formularidentifikation + ']').css('text-align','center').html('<img src=\"".$storeURL."/Location-Shots_sm/' + newfilename + '\" />');
                            }
                    });
                } 
            </script>";
            break;
        case 'pdf':
            echo "<div class='eFResourcesNewObjectFormNewL2Fieldname' data-fieldtype='".$row['Resource_Fieldtype']."'>".$row['Resource_Field']."</div>";
            $formidunique = ($uniqueUTS+3)*10;
            $imagename_unique= $uniqueobjectkey.'_PDF_'.$formidunique; 
            echo '<div class="eFResourcesNewObjectFormNewL2Fieldcontent">';
            echo '<input class="eFinput" type="text" value="'.$imagename_unique.'" name="'.$row['Resource_Field'].'" readonly="readonly" />'; //Eingabefeld Bildname
            echo '<form id="'.$formidunique.'" action="_ajax/eFUploader.php" method="post" enctype="multipart/form-data">
                <input type="hidden" id="uploadResponseType" name="mimetype" value="html"><input type="hidden" name="effiletype" value="pdf">
                <input type="hidden" name="efilmname" value="'.$imagename_unique.'"><input type="file" name="hugotest">
                <input type="submit" value="Upload File">
                </form>
                <div class="progress" data-uniqueid="'.$formidunique.'">
                <div class="bar" data-uniqueid="'.$formidunique.'"></div >
                <div class="percent" data-uniqueid="'.$formidunique.'">0%</div >
                </div>
                <div class="status" data-uniqueid="'.$formidunique.'">';
            echo "</div>";//eFResourcesNewObjectFormNewL2Fieldcontent
            echo "</div>";//eFResourcesNewObjectFormNewL2Fieldname
            //Javascript dazu
            echo "<script type='text/javascript'>
                testomat('".$formidunique."');
                function testomat(formularidentifikation) { 
                    var bar = $(document).find('.bar[data-uniqueid=' + formularidentifikation + ']');
                    var percent = $(document).find('.percent[data-uniqueid=' + formularidentifikation + ']');
                    var status = $(document).find('.status[data-uniqueid=' + formularidentifikation + ']');
                    $(document).find('form[id=' + formularidentifikation + ']').ajaxForm({
                        beforeSend: function() {
                            status.empty();
                            var percentVal = '0%';
                            bar.width(percentVal)
                            percent.html(percentVal);
                        },
                        uploadProgress: function(event, position, total, percentComplete) {
                            var percentVal = percentComplete + '%';
                            bar.width(percentVal)
                            percent.html(percentVal);
                        },
                        complete: function(xhr) {
                            console.log(xhr.responseText);
                            var uploadstatus = jQuery.parseJSON(xhr.responseText);
                            //console.log(uploadstatus);
                            //status.html(xhr.responseText);
                            //$(document).find('form[id=' + eFtempFormID + ']').parent().find('.status').remove();
                            var oldfilename = $(document).find('form[id=' + formularidentifikation + ']').parent().find('input[class=eFinput]').val();
                            var newfilename = oldfilename + uploadstatus.fileextension;
                            $(document).find('form[id=' + formularidentifikation + ']').parent().find('input[class=eFinput]').val(newfilename);
                            $(document).find('form[id=' + formularidentifikation + ']').parent().find('.progress').remove();
                            var smallheight = Math.round(250*(uploadstatus.height/uploadstatus.width));
                            $(document).find('form[id=' + formularidentifikation + ']').css('text-align','center').html('<img src=\"/_img/pdf-icon.png\" />');
                        }
                    });
                }
            </script>";
            break;
    }
    echo "</div>";//eFResourcesNewObjectFormNewL2
}
echo "<div id='eFResourcesNewObjectFormNewL2Additional'></div>";		
echo "<div id='eFResourcesNewObjectFormNewSubObjectContainer'><div id='eFResourcesNewObjectFormNewSubObject'>+</div>
    <div id='eFResourcesNewObjectFormNewSubObjectConfig'><form id='eFResourcesNewObjectFormNewSubObjectConfigForm'>To add a new field please give it a Name: <input type='text' name='eFResourcesNewObjectFormNewSubObjectNAME' value=''> and assign a Type: <input type='radio' name='eFResourcesNewObjectFormNewSubObjectTYPE' value='text'> Text <input type='radio' name='eFResourcesNewObjectFormNewSubObjectTYPE' value='image'> Image <input type='radio' name='eFResourcesNewObjectFormNewSubObjectTYPE' value='pdf'> PDF. Then klick the plus-button. </form></div>
    </div>";
//echo "<div id='testefsave'>Test:<pre id='movimento'>Monster</pre></div>";
echo "</div>";//eFResourcesNewObjectFormContainerTemplate
echo "</div>";//eFResourcesNewObjectFormContainer
