$(document).ready(function () {
    var Seitenverh = 4 / 3;

    /* Movie Auswahl */

    /**************** Auswahlmenü *****************/
    $(document).on('click', '#eFLogoOpen', function () {
        console.log("eFEditorV.js #45");
        $('#eFMovieSelectContainer').fadeToggle("fast", "linear");
    });
    /**************** /Auswahlmenü *****************/

    /**************** Movie Aufrufen und Variablen setzen *****************/
    $('.eFMovieSelectC').click(function () {
        console.log("eFEditorV.js #52");
        $('#contentConatiner').show();
        $('#eFMovieMovieID').html($(this).text());
        $('.eFMovieSelectC').removeClass('eFMovieSelectCSelected');
        $(".efMovieSpeedContainers").removeClass("efMovieSpeedContainersActive");
        $(this).addClass('eFMovieSelectCSelected');
        //Garbage Collection für den Movie Container
        var $video = $('#videoAktuell');
        if ($video !== undefined) {
            $video.find('source').attr('src', '');
            $video.remove();
        }

        $('#videoAktuell').empty();

        $('#eFMovieContainer').load('_ajax/eFEditorVMovieLoad.php?MovieID=' + $(this).text() + '&fps=' + $(this).attr('name') + '&TID=' + $(this).attr('title') + '&UNUM=' + uniqid());
        $('#eFMovieAnnotationsContainerMovieID').load('_ajax/eFEditorVMovieTitle.php?MovieID=' + $(this).text() + '&fps=' + $(this).attr('name') + '&idm=' + $(this).attr('title') + '&UNUM=' + uniqid());

        $('#eFMovieAnnotationsContainerANList').load('_ajax/eFEditorVMovieAnnotationsList.php?MovieID=' + $(this).text() + '&fps=' + $(this).attr('name') + '&TID=' + $(this).attr('title') + '&UNUM=' + uniqid());

        //Reset Timeline
        $("#eFTimelineContainerTableFrameNumbers th").html('');
        $('#eFTimelineContainerTableIN').html('<img id="efTLCIN" alt="in" src="_img/in.png" width="18" height="14">');
        $('#eFTimelineContainerTableOUT').html('<img id="efTLCOUT" alt="out" src="_img/out.png" width="18" height="14">');
        $("#eFTimelineContainerTableFramePics td").removeAttr('style');
        $('#eFTimelineContainerTableActual').html('');
        //Reset Timecodes
        $('#eFControlDataMovieTimecodeContainerFPS').html('000000');
        $('#eFControlDataMovieTimecodeContainerSMPTE').html('00:00:00:00');
        $('#eFControlDataMovieTimecodeContainerHHMMSS').html('00:00:00');
        $('#eFControlDataMovieTimecodeContainerFLOAT').html('0.0');
        $('#eFAFormIN').val('');
        $('#eFAFormOUT').val('');
        $('.eFMovieAnnotationsContainerScenarioSelectS').fadeOut('fast');
        $('.eFMovieAnnotationsContainerScenarioSelectD').fadeOut('fast');
        $('#eFMovieAnnotationsContainerForms').find('form').remove();
        //Hide Movie Menue
        $('#eFMovieSelectContainer').hide();

    });
    /**************** /Movie Aufrufen und Variablen setzen *****************/

    /* Previews */
    $('#eFPreviewOpen').click(function () {
        console.log("eFEditorV.js #121");
        $('#eFPreviewsContainer').show();
    });

    $('#eFPreviewsContainerClose').click(function () {
        console.log("eFEditorV.js #126");
        $('#eFPreviewsContainer').hide();
        $('#eFPreviewsContainerContent').html(' ').hide();
        $('.eFPreviewsContainerSelect').css('background-image', 'url(_img/white-square-10-percent.png)');
    });

    $('.eFPreviewsContainerSelect').click(function () {
        console.log("eFEditorV.js #133");
        $('.eFPreviewsContainerSelect').css('background-image', 'url(_img/white-square-10-percent.png)');
        $(this).css('background-image', 'url(_img/white-square-40-percent.png)');
        $('#eFPreviewsContainerContent').html(' ');
        var previewpath = $(this).attr('data-demo');
        var pcabstandrechtslinks = ($(window).width() - 900) / 2;
        var pcabstandobenunten = (($(window).height() - 700) / 2);
        var movieidfordemos = $('.eFMovieSelectCSelected').attr('title');
        var filmidfordemos = $('#eFMovieMovieID').html();
        $('#eFPreviewsContainerContent').css('top', pcabstandobenunten + 'px').css('left', pcabstandrechtslinks + 'px');
        $('#eFPreviewsContainerContent').show();
        $('#eFPreviewsContainerContent').html('<iframe src="_previews/' + previewpath + '/?MovieID=' + movieidfordemos + '&FilmID=' + filmidfordemos + '" width="100%" height="100%" name="' + previewpath + '"><p>Your browser is not capable of handling iframes"</p></iframe>');
    });

    /* Position Frames Tabelle */
//Statics
    setframescontainerwidth();
//dynamics
    $(window).resize(function () {
        console.log("eFEditorV.js #159");
        setframescontainerwidth();
    });

    function setframescontainerwidth() {
        console.log("eFEditorV.js -setframescontainerwidth()");
        var FramesContainerWidth = $(window).width() - 194;
        //console.log(FramesContainerWidth);
        if (FramesContainerWidth < 1724) {
            var FramesContainerWidthDifference = (1724 - FramesContainerWidth) / 2;
            $('.eFTimelineContainerTable').css('margin-left', '-' + FramesContainerWidthDifference + 'px');
            $('.eFTimelineContainerTableRel').css('margin-left', '-' + FramesContainerWidthDifference + 'px');
        }
        else {
            $('.eFTimelineContainerTable').css('margin-left', 'auto');
            $('.eFTimelineContainerTableRel').css('margin-left', 'auto');
        }
    }

    /* Formularelemente ein und ausblenden */
    $(document).on('click', '#eFMovieMovieIDopenAnotSelect', function () {
        console.log("eFEditorV.js #185");
        $('#eFMovieAnnotationsContainerScenarioSelect').fadeToggle("fast", "linear");
    });
    $(document).on('click', '#eFMovieAnnotationsContainerANListTitle', function () {
        console.log("eFEditorV.js #189");
        $('#eFMovieAnnotationsContainerANListFilter').fadeToggle("fast", "linear");
    });

    /* Movie Playback Buttons */
// PlayPause
    $("#efMoviePlaybuttonsPlayPauseF").on('click', function () {
        console.log("eFEditorV.js #203");
        //console.log('clicked play');
        var video = $.media('#videoAktuell');
        if (video.playing() == true) {
            $(this).css("background-position", "-36px 0");
            video.pause();
        } else {
            $(this).css("background-position", "0px 0");
            if (typeof diepositiontB == "undefined") {
                video.play();
            }
            else {
                video.timeline(diepositiontB, function () {
                    //console.log('reached B');
                    video.play();
                });
                video.play();
            }
        }

    });
// PlayPause Annotationsauswahl	
    $(document).on('click', "#eFMovieAnnotationsContainerINOUTPlay", function () {
        console.log("eFEditorV.js #226");
        if (parseInt($('#eFAFormIN').val()) == 0) {
            var INSEEKER = '0.0001';
        }
        else {
            var INSEEKER = parseInt($('#eFAFormIN').val());
        }
        var OUTSEEKER = parseInt($('#eFAFormOUT').val());
        var fps = parseInt($('#efMCVMovieFPS').html());
        if (INSEEKER == 0) {
            var diepositiontA = (1 / fps) / 2;
        }
        else {
            var diepositiontA = ((1 / fps) * (INSEEKER)) + ((1 / fps) / 2);
        }
        diepositiontB = ((1 / fps) * (OUTSEEKER)) + ((1 / fps) / 2);

        if ((INSEEKER) && (OUTSEEKER)) {
            var videoVP = $.media('#videoAktuell');
            videoVP.seek(diepositiontA);
            videoVP.play();
            videoVP.timeline(diepositiontB, function () {
                this.pause();
                videoVP.seek(diepositiontB);
            });
        }
    });
// Start
    $("#efMoviePlaybuttonsStart").on('click', function () {
        console.log("eFEditorV.js #273");
        video.seek('0');
    });

    // End
    $("#efMoviePlaybuttonsEnd").on('click', function () {
        console.log("eFEditorV.js #279");
        var eFRelVideoAEnd = $(document).find('#videoAktuell').attr('data-totaltime');
        var eFRelVideoAFramecount = $(document).find('#videoAktuell').attr('data-framecount');
        var eFRelVideoAFPS = $(document).find('#videoAktuell').attr('data-fps');
        var eFRelVideoAFPSRealend = (1 / eFRelVideoAFPS) * eFRelVideoAFramecount;
        video.seek(eFRelVideoAFPSRealend);
    });
//Slow Motion F
    $("#efMoviePlaybuttonsSloMoF").click(function () {
        console.log("eFEditorV.js #289");
        $("#efMoviePlaybuttonsPlayPauseF").css("background-position", "-36px 0");
        video.pause();
        Klassentest = $(this).hasClass('SloMo');
        if (Klassentest == false) {
            $(this).toggleClass("SloMo");
            $(this).css("background-color", "#66CCFF");
            var speedtoslow = $('#eFSloMoSpeedChooser option:selected').val();
            videoslomoF = setInterval(dotheslomo, speedtoslow);
        }
        else {
            $(this).removeClass("SloMo");
            $(this).css("background-color", "");
            clearInterval(videoslomoF);
        }
    });
    function dotheslomo() {
        console.log("eFEditorV.js -dotheslomo()");
        var progressusslomo = '+' + (1 / 24);
        video.seek(progressusslomo);
    }
//Slow Motion B
    $("#efMoviePlaybuttonsSloMoB").click(function () {
        console.log("eFEditorV.js #312");
        $("#efMoviePlaybuttonsPlayPauseF").css("background-position", "-36px 0");
        video.pause();
        Klassentest = $(this).hasClass('SloMo');
        if (Klassentest == false) {
            $(this).toggleClass("SloMo");
            $(this).css("background-color", "#66CCFF");
            var speedtoslow = $('#eFSloMoSpeedChooser option:selected').val();
            videoslomoB = setInterval(dotheslomoback, speedtoslow);
        }
        else {
            $(this).removeClass("SloMo");
            $(this).css("background-color", "");
            clearInterval(videoslomoB);
        }
    });
    function dotheslomoback() {
        console.log("eFEditorV.js -dotheslomoback()");
        var progressusslomo = '-' + (1 / 24);
        video.seek(progressusslomo);
    }

    /* Movie Playback Buttons Relations Movie B*/
// PlayPause
    $("#efMoviePlaybuttonsPlayPauseFRel").on('click', function () {
        console.log("eFEditorV.js #344");
        //console.log('clicked play');
        var eFRelVideoB = $.media('#eFRelVideoB');
        if (eFRelVideoB.playing() == true) {
            $(this).css("background-position", "-36px 0");
            eFRelVideoB.pause();
        } else {
            $(this).css("background-position", "0px 0");
            if (typeof diepositiontB == "undefined") {
                eFRelVideoB.play();
            }
            else {
                video.timeline(diepositiontB, function () {
                    //console.log('reached B');
                    eFRelVideoB.play();
                });
                eFRelVideoB.play();
            }
        }

    });

// Start
    $("#efMoviePlaybuttonsStartRel").on('click', function () {
        console.log("eFEditorV.js #368");
        eFRelVideoB.seek('0');
    });

    // End
    $("#efMoviePlaybuttonsEndRel").on('click', function () {
        console.log("eFEditorV.js #374");
        var eFRelVideoBEnd = $(document).find('#eFRelVideoB').attr('data-totaltime');
        var eFRelVideoBFramecount = $(document).find('#eFRelVideoB').attr('data-framecount');
        var eFRelVideoBFPS = $(document).find('#eFRelVideoB').attr('data-fps');
        var eFRelVideoBFPSRealend = (1 / eFRelVideoBFPS) * eFRelVideoBFramecount;
        eFRelVideoB.seek(eFRelVideoBFPSRealend);
    });
//Slow Motion F
    $("#efMoviePlaybuttonsSloMoFRel").click(function () {
        console.log("eFEditorV.js #383");
        $("#efMoviePlaybuttonsPlayPauseFRel").css("background-position", "-36px 0");
        eFRelVideoB.pause();
        Klassentest = $(this).hasClass('SloMo');
        if (Klassentest == false) {
            $(this).toggleClass("SloMo");
            $(this).css("background-color", "#66CCFF");
            var speedtoslow = $('#eFSloMoSpeedChooserRel option:selected').val();
            videoslomoFRel = setInterval(dotheslomoRel, speedtoslow);
        }
        else {
            $(this).removeClass("SloMo");
            $(this).css("background-color", "");
            clearInterval(videoslomoFRel);
        }
    });
    function dotheslomoRel() {
        console.log("eFEditorV.js -dotheslomoRel()");
        var progressusslomo = '+' + (1 / 24);
        eFRelVideoB.seek(progressusslomo);
    }
//Slow Motion B
    $("#efMoviePlaybuttonsSloMoBRel").click(function () {
        console.log("eFEditorV.js #406");
        $("#efMoviePlaybuttonsPlayPauseFRel").css("background-position", "-36px 0");
        eFRelVideoB.pause();
        Klassentest = $(this).hasClass('SloMo');
        if (Klassentest == false) {
            $(this).toggleClass("SloMo");
            $(this).css("background-color", "#66CCFF");
            var speedtoslow = $('#eFSloMoSpeedChooserRel option:selected').val();
            videoslomoBRel = setInterval(dotheslomobackRel, speedtoslow);
        }
        else {
            $(this).removeClass("SloMo");
            $(this).css("background-color", "");
            clearInterval(videoslomoBRel);
        }
    });
    function dotheslomobackRel() {
        console.log("eFEditorV.js -dotheslomobackRel()");
        var progressusslomo = '-' + (1 / 24);
        eFRelVideoB.seek(progressusslomo);
    }

    /* Annotations Scenario Navigation */
    /* Scenario Navigation Main */
    $('#eFSCMCoverage').click(function () {
        console.log("eFEditorV.js #440");
        $('.eFSCMButton').removeClass('eFSCDButtonBG');
        $('.eFSCDButton').removeClass('eFSCDButtonBG');
        $(this).addClass('eFSCDButtonBG');
        $('.eFMovieAnnotationsContainerScenarioSelectS').fadeOut('fast');
        $('.eFMovieAnnotationsContainerScenarioSelectD').fadeOut('fast');
        $('#eFMovieAnnotationsContainerScenarioSelectSCoverage').fadeIn("fast");
    });
    $('#eFSCMSubject').click(function () {
        console.log("eFEditorV.js #449");
        $('.eFSCMButton').removeClass('eFSCDButtonBG');
        $('.eFSCDButton').removeClass('eFSCDButtonBG');
        $(this).addClass('eFSCDButtonBG');
        $('.eFMovieAnnotationsContainerScenarioSelectS').fadeOut('fast');
        $('.eFMovieAnnotationsContainerScenarioSelectD').fadeOut('fast');
        $('#eFMovieAnnotationsContainerScenarioSelectSSubject').fadeIn("fast");
    });
    $('#eFSCMLanguage').click(function () {
        console.log("eFEditorV.js #458");
        $('.eFSCMButton').removeClass('eFSCDButtonBG');
        $('.eFSCDButton').removeClass('eFSCDButtonBG');
        $(this).addClass('eFSCDButtonBG');
        $('.eFMovieAnnotationsContainerScenarioSelectS').fadeOut('fast');
        $('.eFMovieAnnotationsContainerScenarioSelectD').fadeOut('fast');
        $('#eFMovieAnnotationsContainerScenarioSelectSLanguage').fadeIn("fast");
    });
    $('#eFSCMRelation').click(function () {
        console.log("eFEditorV.js #467");
        $('.eFSCMButton').removeClass('eFSCDButtonBG');
        $('.eFSCDButton').removeClass('eFSCDButtonBG');
        $(this).addClass('eFSCDButtonBG');
        $('.eFMovieAnnotationsContainerScenarioSelectS').fadeOut('fast');
        $('.eFMovieAnnotationsContainerScenarioSelectD').fadeOut('fast');
        $('#eFMovieAnnotationsContainerScenarioSelectSRelation').fadeIn("fast");
    });
    $('#eFSCMDescription').click(function () {
        console.log("eFEditorV.js #476");
        $('.eFSCMButton').removeClass('eFSCDButtonBG');
        $('.eFSCDButton').removeClass('eFSCDButtonBG');
        $(this).addClass('eFSCDButtonBG');
        $('.eFMovieAnnotationsContainerScenarioSelectS').fadeOut('fast');
        $('.eFMovieAnnotationsContainerScenarioSelectD').fadeOut('fast');
        $('#eFMovieAnnotationsContainerScenarioSelectSDescription').fadeIn("fast");
    });
    /* Scenario Navigation Sub */
    $('#eFSCSSpatial').click(function () {
        console.log("eFEditorV.js #486");
        $('.eFSCDButton').removeClass('eFSCDButtonBG');
        $(this).addClass('eFSCDButtonBG');
        $('.eFMovieAnnotationsContainerScenarioSelectD').fadeOut('fast');
        $('#eFMovieAnnotationsContainerScenarioSelectDCoverageSpatial').fadeIn("fast");
    });
    $('#eFSCSTemporal').click(function () {
        console.log("eFEditorV.js #493");
        $('.eFSCDButton').removeClass('eFSCDButtonBG');
        $(this).addClass('eFSCDButtonBG');
        $('.eFMovieAnnotationsContainerScenarioSelectD').fadeOut('fast');
        $('#eFMovieAnnotationsContainerScenarioSelectDCoverageTemporal').fadeIn("fast");
    });

    $('#eFSCSPerson').click(function () {
        console.log("eFEditorV.js #501");
        $('.eFSCDButton').removeClass('eFSCDButtonBG');
        $(this).addClass('eFSCDButtonBG');
        $('.eFMovieAnnotationsContainerScenarioSelectD').fadeOut('fast');
        $('#eFMovieAnnotationsContainerScenarioSelectDSubjectPerson').fadeIn("fast");
    });
    $('#eFSCSOrganization').click(function () {
        console.log("eFEditorV.js #508");
        $('.eFSCDButton').removeClass('eFSCDButtonBG');
        $(this).addClass('eFSCDButtonBG');
        $('.eFMovieAnnotationsContainerScenarioSelectD').fadeOut('fast');
        $('#eFMovieAnnotationsContainerScenarioSelectDSubjectOrganization').fadeIn("fast");
    });
    $('#eFSCSHistoricEvent').click(function () {
        console.log("eFEditorV.js #515");
        $('.eFSCDButton').removeClass('eFSCDButtonBG');
        $(this).addClass('eFSCDButtonBG');
        $('.eFMovieAnnotationsContainerScenarioSelectD').fadeOut('fast');
        $('#eFMovieAnnotationsContainerScenarioSelectDSubjectHistoricEvent').fadeIn("fast");
    });

    $('#eFSCSLanguage').click(function () {
        console.log("eFEditorV.js #523");
        $('.eFSCDButton').removeClass('eFSCDButtonBG');
        $(this).addClass('eFSCDButtonBG');
        $('.eFMovieAnnotationsContainerScenarioSelectD').fadeOut('fast');
        $('#eFMovieAnnotationsContainerScenarioSelectDLanguage').fadeIn("fast");
    });

    $('#eFSCSRelation').click(function () {
        console.log("eFEditorV.js #531");
        $('.eFSCDButton').removeClass('eFSCDButtonBG');
        $(this).addClass('eFSCDButtonBG');
        $('.eFMovieAnnotationsContainerScenarioSelectD').fadeOut('fast');
        $('#eFMovieAnnotationsContainerScenarioSelectDRelation').fadeIn("fast");
    });

    $('#eFSCSNumbering').click(function () {
        console.log("eFEditorV.js #539");
        $('.eFSCDButton').removeClass('eFSCDButtonBG');
        $(this).addClass('eFSCDButtonBG');
        $('.eFMovieAnnotationsContainerScenarioSelectD').fadeOut('fast');
        $('#eFMovieAnnotationsContainerScenarioSelectDDescriptionNumbering').fadeIn("fast");
    });
    $('#eFSCSImageContent').click(function () {
        console.log("eFEditorV.js #546");
        $('.eFSCDButton').removeClass('eFSCDButtonBG');
        $(this).addClass('eFSCDButtonBG');
        $('.eFMovieAnnotationsContainerScenarioSelectD').fadeOut('fast');
        $('#eFMovieAnnotationsContainerScenarioSelectDDescriptionImageContent').fadeIn("fast");
    });
    $('#eFSCSFilmAnalysis').click(function () {
        console.log("eFEditorV.js #553");
        $('.eFSCDButton').removeClass('eFSCDButtonBG');
        $(this).addClass('eFSCDButtonBG');
        $('.eFMovieAnnotationsContainerScenarioSelectD').fadeOut('fast');
        $('#eFMovieAnnotationsContainerScenarioSelectDDescriptionFilmAnalysis').fadeIn("fast");
    });
    $('#eFSCSInterpretation').click(function () {
        console.log("eFEditorV.js #560");
        $('.eFSCDButton').removeClass('eFSCDButtonBG');
        $(this).addClass('eFSCDButtonBG');
        $('.eFMovieAnnotationsContainerScenarioSelectD').fadeOut('fast');
        $('#eFMovieAnnotationsContainerScenarioSelectDDescriptionInterpretation').fadeIn("fast");
    });
    $('#eFSCSEducationalRemarks').click(function () {
        console.log("eFEditorV.js #567");
        $('.eFSCDButton').removeClass('eFSCDButtonBG');
        $(this).addClass('eFSCDButtonBG');
        $('.eFMovieAnnotationsContainerScenarioSelectD').fadeOut('fast');
        $('#eFMovieAnnotationsContainerScenarioSelectDDescriptionEducationalRemarks').fadeIn("fast");
    });

    /* Annotations Scenario Input Forms New and Edit*/
    //NEW
    $('.eFSCDetail').click(function () {
        console.log("eFEditorV.js #583");
        eFcreateForm($(this).attr("id"), $(this).html(), 'NEW', '')
        //console.log($(this).attr("id") + " / " + $(this).html() + " / NEW / ");
    });

    //EDIT
    $(document).on('click', '.eFTabCellEdit', function () {
        console.log("eFEditorV.js #590");

        var viewvaranoncedit = $(document).find('#eFMovieMovieID').attr('data-ur');

        if (viewvaranoncedit == "VIEW") {
            alert('You are not allowed to edit this movie\'s annotations!')
        }
        else {
            //console.log('EDIT Clicked: ' + $('#eFMovieAnnotationsEditBOOL').html());
            var FormIDEdit_str = $(this).parent().attr("class");
            var FormIDEdit = FormIDEdit_str.replace("Class", "");
            var FormLegendEdit = $(this).prev().prev().prev().html();
            FormEditID = $(this).parent().attr("data-recordid");
            //console.log(FormIDEdit + " / " + FormLegendEdit + " / EDIT / " + FormEditID);
            //In Out setzen

            $('#eFAFormIN').val($(this).parent().find('.eFTabCellIN').html());
            $('#eFAFormOUT').val($(this).parent().find('.eFTabCellOUT').html());


            //R-Check
            var nikeditabiliter = $(this).parent().find('.eFTabCellUser').html();
            var idmgetit = $('.eFMovieSelectCSelected').attr('title');
            $.ajax({
                async: false,
                type: "GET",
                url: "_ajax/eFEditorVMovieRCK.php",
                data: "idm=" + idmgetit + "&uniquid=" + uniqid(),
                success: function (data) {
                    console.log(data);
                    CUserRightsMoviesSetAlljson = $.parseJSON(data);
                    switch (CUserRightsMoviesSetAlljson.RIGHTS_Movies) {
                        case "NONE":
                            alert('You are not allowed to edit this annotation!');
                            break;

                        case "VIEW":
                            alert('You are not allowed to edit this annotation!');
                            break;

                        case "SELFEDIT":
                            if (nikeditabiliter == CUserRightsMoviesSetAlljson.UNIKINGER) {
                                eFcreateForm(FormIDEdit, FormLegendEdit, 'EDIT', FormEditID);
                            } else {
                                alert('You are only allowed to edit your own annotations!');
                            }
                            break;

                        case "EDIT":
                            eFcreateForm(FormIDEdit, FormLegendEdit, 'EDIT', FormEditID);
                            break;
                    }
                    //console.log(CUserRightsMoviesSetAlljson);

                },
                cache: false
            });
        }
    });


    function eFcreateForm(FormID, FormLegend, Mode, eFEditID) {
        console.log("eFEditorV.js -eFcreateForm()");
        //Leeres Array für nicht edit ... nicht sehr elegant aber funktioniert ...
        ANEDITjson = new Array();
        ANEDITjson['ID_Movies'] = "";
        ANEDITjson['ID_Annotations'] = "";
        ANEDITjson['_FM_CREATE'] = "";
        ANEDITjson['_FM_CHANGE'] = "";
        ANEDITjson['_FM_DATETIME_CREATE'] = "";
        ANEDITjson['_FM_DATETIME_CHANGE'] = "";
        ANEDITjson['eF_FILM_ID'] = "";
        ANEDITjson['AnnotationType_L1'] = "";
        ANEDITjson['AnnotationType_L2'] = "";
        ANEDITjson['AnnotationType_L3'] = "";
        ANEDITjson['startTime'] = "";
        ANEDITjson['endTime'] = "";
        ANEDITjson['timeAnnotation'] = "";
        ANEDITjson['source'] = "";
        ANEDITjson['source_from'] = "";
        ANEDITjson['source_to'] = "";
        ANEDITjson['ref'] = "";
        ANEDITjson['version'] = "";
        ANEDITjson['annotation'] = "";
        ANEDITjson['coverage'] = "";
        ANEDITjson['coverageType'] = "";
        ANEDITjson['coverage_S_Longitude'] = "";
        ANEDITjson['coverage_S_Latitude'] = "";
        ANEDITjson['coverage_S_Geoname'] = "";
        ANEDITjson['coverage_T_From'] = "";
        ANEDITjson['coverage_T_To'] = "";
        ANEDITjson['subject'] = "";
        ANEDITjson['subjectType'] = "";
        ANEDITjson['subject_P_PersonName'] = "";
        ANEDITjson['subject_P_PersonID'] = "";
        ANEDITjson['subject_O_OrganizationType'] = "";
        ANEDITjson['subject_O_OrganizationName'] = "";
        ANEDITjson['subject_O_OrganizationID'] = "";
        ANEDITjson['subject_HE_Title'] = "";
        ANEDITjson['subject_HE_Date'] = "";
        ANEDITjson['subject_HE_Type'] = "";
        ANEDITjson['subject_HE_ID'] = "";
        ANEDITjson['relation'] = "";
        ANEDITjson['relation_relationType'] = "";
        ANEDITjson['relation_relationIdentifier'] = "";
        ANEDITjson['relation_relationIdentifier_from'] = "";
        ANEDITjson['relation_relationIdentifier_to'] = "";
        ANEDITjson['relation_relationIdentifier_source'] = "";
        ANEDITjson['relation_relationIdentifier_ref'] = "";
        ANEDITjson['relation_relationIdentifier_version'] = "";
        ANEDITjson['relation_relationIdentifier_annotation'] = "";
        ANEDITjson['description'] = "";
        ANEDITjson['description_descriptionType'] = "";
        ANEDITjson['description_descriptionTypeSource'] = "";
        ANEDITjson['description_descriptionTypeRef'] = "";
        ANEDITjson['description_descriptionTypeVersion'] = "";
        ANEDITjson['description_descriptionTypeAnnotation'] = "";
        ANEDITjson['description_segmentType'] = "";
        ANEDITjson['description_segmentTypeSource'] = "";
        ANEDITjson['description_segmentTypeRef'] = "";
        ANEDITjson['description_segmentTypeVersion'] = "";
        ANEDITjson['description_segmentTypeAnnotation'] = "";
        ANEDITjson['FormID'] = "";
        ANEDITjson['coverage_S_LandmarkID'] = "";
        ANEDITjson['language'] = "";
        ANEDITjson['_empty'] = "";
        ANEDITjson['_USER_INPUT'] = "";
        ANEDITjson['researchLog'] = "";

        Level1 = $('#eFMovieAnnotationsContainerScenarioSelectM .eFSCDButtonBG').attr('title');
        Level2 = $('.eFMovieAnnotationsContainerScenarioSelectS:visible div.eFSCDButtonBG').attr('title');
        Level3 = FormLegend;
        eF_FILM_ID = $('#eFMovieMovieID').html();
        ID_Movies = $('.eFMovieSelectCSelected').attr('title');

        EditBOOL = $('#eFMovieAnnotationsEditBOOL').html();
        if ((Mode == 'EDIT') && (EditBOOL == 'JA')) {
            eFEditClass = " class='eFEditForm'";
            eFEditName = " name='eFEditForm'";
            $('#eFMovieAnnotationsContainerANList').find('tbody tr[data-recordid=' + eFEditID + '] td').css('background-color', '#FF9900');
            //Daten holen
            $.ajax({
                async: false,
                type: "GET",
                url: "_ajax/eFEditorVMovieAnnotationsEditGetJSON.php",
                data: "Editid=" + eFEditID,
                success: function (data) {
                    ANEDITjson = $.parseJSON(data);
                },
                cache: false
            });
            hiddenFormVars = "<input type='hidden' name='AnnotationType_L1' value='" + ANEDITjson.AnnotationType_L1 + "'><input type='hidden' name='AnnotationType_L2' value='" + ANEDITjson.AnnotationType_L2 + "'><input type='hidden' name='AnnotationType_L3' value='" + ANEDITjson.AnnotationType_L3 + "'><input type='hidden' name='_USER_INPUT' value='" + ANEDITjson._USER_INPUT + "'>";
        }
        else {
            eFEditClass = " class='eFNewForm'";
            eFEditName = " name='eFNewForm'";
            hiddenFormVars = "<input type='hidden' name='AnnotationType_L1' value='" + Level1 + "'><input type='hidden' name='AnnotationType_L2' value='" + Level2 + "'><input type='hidden' name='AnnotationType_L3' value='" + Level3 + "'><input type='hidden' name='_USER_INPUT' value='" + $('#eFUserNik').html() + "'>";
        }
        FormStart = "<form id='" + uniqid() + "'" + eFEditClass + "><legend class='" + FormID + "Legend'>" + FormLegend + "</legend><div id='" + FormID + "AddContent' class='AddContent'></div>";
        formVars = "<div class='eFhiddenFormVars'><div id='eFFormLevel1'>" + Level1 + "</div><div id='eFFormLevel2'>" + Level2 + "</div><div id='eFFormLevel3'>" + Level3 + "</div><div id='eFFormID'>" + FormID + "</div><div id='FormEditID'>" + eFEditID + "</div></div>";
        FormNotes = eFFormInput("Notes", "researchNotes", FormID, "textarea", "visible", ANEDITjson.researchLog);
        FormEnd = "</form>";
        FormControlls = "<div class='eFFormResetButton' title='reset'>r</div><div class='eFFormSaveButton' title='save'" + eFEditName + ">s</div><div class='eFFormCloseButton'  title='remove'" + eFEditName + ">x</div>";

        /* Verhindern, dass Form submitted wird */
        $(document).on('keypress', '#eFMovieAnnotationsContainerForms form input,select', function (e) {
            return e.keyCode != 13;
        });
        /* /Verhindern, dass Form submitted wird */

        /* Formulare zum Formcontainer hinzufügen */
        if ((Mode != 'EDIT') || ((Mode == 'EDIT') && (EditBOOL == 'JA'))) {
            $('#eFMovieAnnotationsEditBOOL').html('NEIN');
            $('#eFMovieAnnotationsContainerForms').append(function () {
                switch (FormID) {
                    case "eFSCDLocationN":
                        var eFFormContent = eFFormInput("Location Name", "coverage", FormID, "text", "visible", ANEDITjson.coverage);
                        break;
                    case "eFSCDLocationG":
                        var eFFormContent = eFFormInput("Location Geoname", "coverage_S_Geoname", FormID, "text", "visible", ANEDITjson.coverage_S_Geoname) + eFFormInput("Longitude", "coverage_S_Longitude", FormID, "text", "visible", ANEDITjson.coverage_S_Longitude) + eFFormInput("Latitude", "coverage_S_Latitude", FormID, "text", "visible", ANEDITjson.coverage_S_Latitude);
                        break;
                    case "eFSCDLandmark":
                        var eFFormContent = eFFormInput("Landmark Name", "coverage", FormID, "text", "visible", ANEDITjson.coverage) + eFFormInput("Landmark ID", "coverage_S_LandmarkID", FormID, "text", "visible", ANEDITjson.coverage_S_LandmarkID);
                        break;
                    case "eFSCDDate":
                        var eFFormContent = eFFormInput("Date From", "coverage_T_From", FormID, "text", "visible", ANEDITjson.coverage_T_From) + eFFormInput("Date To", "coverage_T_To", FormID, "text", "visible", ANEDITjson.coverage_T_To);
                        break;
                    case "eFSCDPerson":
                        var eFFormContent = eFFormInput("Person Name", "subject_P_PersonName", FormID, "text", "visible", ANEDITjson.subject_P_PersonName) + eFFormInput("Person ID", "subject_P_PersonID", FormID, "text", "visible", ANEDITjson.subject_P_PersonID) + eFFormInput("Source", "source", FormID, "text", "readonly", ANEDITjson.source);
                        break;
                    case "eFSCDOrganisation":
                        var eFFormContent = eFFormInput("Organization Type", "subject_O_OrganizationType", FormID, "text", "visible", ANEDITjson.subject_O_OrganizationType) + eFFormInput("Organization Name", "subject_O_OrganizationName", FormID, "text", "visible", ANEDITjson.subject_O_OrganizationName) + eFFormInput("Organization ID", "subject_O_OrganizationID", FormID, "text", "visible", ANEDITjson.subject_O_OrganizationID) + eFFormInput("Source", "source", FormID, "text", "readonly", ANEDITjson.source);
                        break;
                    case "eFSCDHistoricEvent":
                        var eFFormContent = eFFormInput("Historic Event Title", "subject_HE_Title", FormID, "text", "visible", ANEDITjson.subject_HE_Title) + eFFormInput("Historic Event Date", "subject_HE_Date", FormID, "text", "visible", ANEDITjson.subject_HE_Date) + eFFormInput("Historic Event Type", "subject_HE_Type", FormID, "text", "visible", ANEDITjson.subject_HE_Type) + eFFormInput("Historic Event Event ID", "subject_HE_ID", FormID, "text", "visible", ANEDITjson.subject_HE_ID) + eFFormInput("Source", "source", FormID, "text", "readonly", ANEDITjson.source);
                        break;
                    case "eFSCSLanguage":
                        var eFFormContent = eFFormInput("Language", "language", FormID, "text", "visible", ANEDITjson.language);
                        break;
                    case "eFSCSRelation":
                        var eFFormContent = eFFormInput("Relation Medium", "relation", FormID, "text", "readonly", ANEDITjson.relation) + eFFormInput("Relation Type", "relation_relationType", FormID, "text", "readonly", ANEDITjson.relation_relationType) + eFFormInput("Relation Identifier", "relation_relationIdentifier", FormID, "text", "readonly", ANEDITjson.relation_relationIdentifier) + eFFormInput("From", "relation_relationIdentifier_from", FormID, "text", "readonly", ANEDITjson.relation_relationIdentifier_from) + eFFormInput("To", "relation_relationIdentifier_to", FormID, "text", "readonly", ANEDITjson.relation_relationIdentifier_to);
                        break;
                    case "eFSCSSequenceNumber":
                        var eFFormContent = eFFormInput("Sequence Number", "description", FormID, "text", "visible", ANEDITjson.description) + eFFormInput("Annotation", "annotation", FormID, "textarea", "visible", ANEDITjson.annotation);
                        break;
                    case "eFSCSSceneNumber":
                        var eFFormContent = eFFormInput("Scene Number", "description", FormID, "text", "visible", ANEDITjson.description) + eFFormInput("Annotation", "annotation", FormID, "textarea", "visible", ANEDITjson.annotation);
                        break;
                    case "eFSCSShotNumber":
                        var eFFormContent = eFFormInput("Shot Number", "description", FormID, "text", "visible", ANEDITjson.description) + eFFormInput("Annotation", "annotation", FormID, "textarea", "visible", ANEDITjson.annotation);
                        break;
                    case "eFSCSReelNumber":
                        var eFFormContent = eFFormInput("Reel Number", "description", FormID, "text", "visible", ANEDITjson.description) + eFFormInput("Annotation", "annotation", FormID, "textarea", "visible", ANEDITjson.annotation);
                        break;
                    case "eFSCSSpacialType":
                        var eFFormContent = eFFormInput("Spacial Type", "description", FormID, "text", "visible", ANEDITjson.description);
                        break;
                    case "eFSCSSpacialUse":
                        var eFFormContent = eFFormInput("Spacial Use", "description", FormID, "text", "visible", ANEDITjson.description);
                        break;
                    case "eFSCSPersonsNumber":
                        var eFFormContent = eFFormInput("Persons Number", "description", FormID, "text", "visible", ANEDITjson.description);
                        break;
                    case "eFSCSPersonsGender":
                        var eFFormContent = eFFormInput("Persons Gender", "description", FormID, "text", "visible", ANEDITjson.description);
                        break;
                    case "eFSCSPersonsAge":
                        var eFFormContent = eFFormInput("Persons Age", "description", FormID, "text", "visible", ANEDITjson.description);
                        break;
                    case "eFSCSPersonsAction":
                        var eFFormContent = eFFormInput("Persons Action", "description", FormID, "text", "visible", ANEDITjson.description);
                        break;
                    case "eFSCSVisualEventType":
                        var eFFormContent = eFFormInput("Visual Event Type", "description", FormID, "text", "visible", ANEDITjson.description);
                        break;
                    case "eFSCSVisualEvent":
                        var eFFormContent = eFFormInput("Visual Event", "description", FormID, "textarea", "visible", ANEDITjson.description);
                        break;
                    case "eFSCSAudioEventType":
                        var eFFormContent = eFFormInput("Audio Event Type", "description", FormID, "text", "visible", ANEDITjson.description);
                        break;
                    case "eFSCSAudioEvent":
                        var eFFormContent = eFFormInput("Audio Event", "description", FormID, "textarea", "visible", ANEDITjson.description);
                        break;
                    case "eFSCSIntertitleTranscript":
                        var eFFormContent = eFFormInput("Intertitle Transcript", "description", FormID, "textarea", "visible", ANEDITjson.description);
                        break;
                    case "eFSCSWrittenElementsTranscript":
                        var eFFormContent = eFFormInput("Written Elements Transcript", "description", FormID, "textarea", "visible", ANEDITjson.description);
                        break;
                    case "eFSCSWrittenElementsLanguage":
                        var eFFormContent = eFFormInput("Written Elements Language", "description", FormID, "text", "visible", ANEDITjson.description);
                        break;
                    case "eFSCSSpokenElementsTranscript":
                        var eFFormContent = eFFormInput("Spoken Elements Transcript", "description", FormID, "textarea", "visible", ANEDITjson.description);
                        break;
                    case "eFSCSPunctum":
                        var eFFormContent = eFFormInput("Punctum", "description", FormID, "textarea", "visible", ANEDITjson.description);
                        break;
                    case "eFSCSShotType":
                        var eFFormContent = eFFormInput("Shot Type", "description", FormID, "text", "visible", ANEDITjson.description) + eFFormInput("Annotation", "annotation", FormID, "textarea", "visible", ANEDITjson.annotation);
                        break;
                    case "eFSCSCameraPosition":
                        var eFFormContent = eFFormInput("Camera Position", "description", FormID, "text", "visible", ANEDITjson.description);
                        break;
                    case "eFSCSEditing":
                        var eFFormContent = eFFormInput("Editing", "description", FormID, "text", "visible", ANEDITjson.description);
                        break;
                    case "eFSCSAmateurFilmCharacteristics":
                        var eFFormContent = eFFormInput("Amateur Film Characteristics", "description", FormID, "text", "visible", ANEDITjson.description);
                        break;
                    case "eFSCSIntention":
                        var eFFormContent = eFFormInput("Intention", "description", FormID, "text", "visible", ANEDITjson.description);
                        break;
                    case "eFSCSEducationalRemarks":
                        var eFFormContent = eFFormInput("Educational Remarks", "description", FormID, "textarea", "visible", ANEDITjson.description);
                        break;
                    default:
                        var eFFormContent = "Test";
                }
                return FormStart + formVars + eFFormContent + FormNotes + hiddenFormVars + FormControlls + FormEnd;
            });
        }

    }
    /* /Formulare zum Formcontainer hinzufügen */

    /* Formulare im Formcontainer canceln */
    $(document).on('click', '.eFFormCloseButton', function () {
        console.log("eFEditorV.js #856");
        //console.log($(this).parent().html());
        $(this).parent().remove();
        $('#eFMovieAnnotationsContainerFormsPop').removeAttr('class').fadeOut();
        $('#eFMovieAnnotationsContainerFormsPopContent').html('').empty();
        if ($(this).attr('name') == 'eFEditForm') {
            $('#eFMovieAnnotationsEditBOOL').html('JA');
            $('#eFMovieAnnotationsContainerANList').find('tbody tr td').removeAttr('style');
        }
        else {
            if ($('#eFMovieAnnotationsContainerForms').find('form').attr('id') > 0) {
                $('#eFMovieAnnotationsEditBOOL').html('NEIN');
            }
            else {
                $('#eFMovieAnnotationsEditBOOL').html('JA');
            }
        }
    });
    /* Formulare im Formcontainer resetten */
    $(document).on('click', '.eFFormResetButton', function () {
        console.log("eFEditorV.js #876");
        $(this).parent()[0].reset();

    });
    /* /Formulare im Formcontainer canceln */

    /* Formulare aus dem Formcontainer abschicken */
    $(document).on('click', '.eFFormSaveButton', function () {
        console.log("eFEditorV.js #885");
        /************************* Vorbereitung auf Abschicken *************************/
        startTime = $("#eFAFormIN").val();
        endTime = $("#eFAFormOUT").val();
        FormIDS = $(this).parent().children('.eFhiddenFormVars').children('#eFFormID').html();
        Level1S = $(this).parent().children('.eFhiddenFormVars').children('#eFFormLevel1').html();
        Level2S = $(this).parent().children('.eFhiddenFormVars').children('#eFFormLevel2').html();
        Level3S = $(this).parent().children('.eFhiddenFormVars').children('#eFFormLevel3').html();
        //String für Ajax Save Call
        eFFormInputValuesArr = $(this).parent().serializeArray();
        eFAjaxString = "";
        jQuery.each(eFFormInputValuesArr, function (i, field) {
            eFAjaxString += "&" + escape(field.name) + "=" + encodeURIComponent(field.value);
        });
        eFAjaxString += "&ID_Movies=" + escape(ID_Movies);
        eFAjaxString += "&FormID=" + escape(FormIDS);
        eFAjaxString += "&startTime=" + escape(startTime);
        eFAjaxString += "&endTime=" + escape(endTime);

        switch ($(this).attr('name')) {
            case 'eFEditForm':
                FormEditID = $(this).parent().children('.eFhiddenFormVars').children('#FormEditID').html();
                eFAddVarsHere = '&action=EDIT&FormEditID=' + FormEditID;
                //console.log(eFAddVarsHere);
                break;
            case 'eFNewForm':
                eFAddVarsHere = '&action=NEW';
                break;
        }

        eFNewAnnSaveString = "eF_FILM_ID=" + escape(eF_FILM_ID) + eFAjaxString + '&UNUM=' + uniqid() + eFAddVarsHere;
        /******************** Ende Vorbereitung auf Abschicken *************************/

        /******************** Kontrollstruktur und Abschicken *************************/

        //Sind die Formulardaten vorhanden? Vielleich split eFNewAnnSaveString und sehen, ob etwas leer ist?

        var Dasganzezeug = eFNewAnnSaveString.split("&");
        var DasganzezeugDetail = [];
        var a = 0;
        DasganzezeugDetail[a] = {};
        jQuery.each(Dasganzezeug, function (i, field) {
            var DetailinfoA = field;
            var Detailinfo = DetailinfoA.split("=");
            DasganzezeugDetail[a][Detailinfo[0]] = Detailinfo[1];
        });

        //Ist In und OUT ok (leer, In < out)
        if (!((DasganzezeugDetail[0]["startTime"] && DasganzezeugDetail[0]["endTime"]) && (parseInt(DasganzezeugDetail[0]["startTime"]) <= parseInt(DasganzezeugDetail[0]["endTime"])))) {
            eFAWarning('IN and OUT values must be set and IN has to be less or equal OUT!');
            return false;
        }
        else if (DasganzezeugDetail[0]["FormID"] == "eFSCDLocationN" && !(DasganzezeugDetail[0]["coverage"])) {
            eFAWarning('Please enter all required field values!');
            return false;
        }
        else if (DasganzezeugDetail[0]["FormID"] == "eFSCDLocationG" && (!(DasganzezeugDetail[0]["coverage_S_Geoname"]) || !(DasganzezeugDetail[0]["coverage_S_Latitude"]) || !(DasganzezeugDetail[0]["coverage_S_Longitude"]))) {
            eFAWarning('Please enter all required field values!');
            return false;
        }
        else if (DasganzezeugDetail[0]["FormID"] == "eFSCDLandmark" && (!(DasganzezeugDetail[0]["coverage"]) || !(DasganzezeugDetail[0]["coverage_S_LandmarkID"]))) {
            eFAWarning('Please enter all required field values!');
            return false;
        }
        else if (DasganzezeugDetail[0]["FormID"] == "eFSCDDate" && (!(DasganzezeugDetail[0]["coverage_T_From"]) || !(DasganzezeugDetail[0]["coverage_T_To"]))) {
            eFAWarning('Please enter all required field values!');
            return false;
        }
        else if (DasganzezeugDetail[0]["FormID"] == "eFSCDPerson" && (!(DasganzezeugDetail[0]["subject_P_PersonID"]) || !(DasganzezeugDetail[0]["subject_P_PersonName"]))) {
            eFAWarning('Please enter all required field values!');
            return false;
        }
        else if (DasganzezeugDetail[0]["FormID"] == "eFSCDOrganisation" && (!(DasganzezeugDetail[0]["subject_O_OrganizationID"]) || !(DasganzezeugDetail[0]["subject_O_OrganizationName"]) || !(DasganzezeugDetail[0]["subject_O_OrganizationType"]))) {
            eFAWarning('Please enter all required field values!');
            return false;
        }
        else if (DasganzezeugDetail[0]["FormID"] == "eFSCDHistoricEvent" && (!(DasganzezeugDetail[0]["subject_HE_Date"]) || !(DasganzezeugDetail[0]["subject_HE_ID"]) || !(DasganzezeugDetail[0]["subject_HE_Title"]) || !(DasganzezeugDetail[0]["subject_HE_Type"]))) {
            eFAWarning('Please enter all required field values!');
            return false;
        }
        else if (DasganzezeugDetail[0]["FormID"] == "eFSCSLanguage" && !(DasganzezeugDetail[0]["language"])) {
            eFAWarning('Please enter all required field values!');
            return false;
        }
        else if (DasganzezeugDetail[0]["AnnotationType_L1"] == "Description" && !(DasganzezeugDetail[0]["description"]) && !((DasganzezeugDetail[0]["FormID"] == "eFSCSShotNumber") || (DasganzezeugDetail[0]["FormID"] == "eFSCSSequenceNumber") || (DasganzezeugDetail[0]["FormID"] == "eFSCSSceneNumber") || (DasganzezeugDetail[0]["FormID"] == "eFSCSReelNumber"))) {
            eFAWarning('Please enter all required field values!');
            return false;
        }

        else {
            //Ajax Call

            $.ajax({
                async: false,
                type: "GET",
                url: "_ajax/eFEditorVMovieAnnotationsNew.php",
                data: eFNewAnnSaveString,
                success: function () {
                    $('#eFMovieAnnotationsContainerANList').load('_ajax/eFEditorVMovieAnnotationsList.php?MovieID=' + eF_FILM_ID + '&fps=' + $('.eFMovieSelectCSelected').attr('name') + '&TID=' + ID_Movies + '&UNUM=' + uniqid());
                },
                cache: false
            });
            if ($(this).attr('name') == 'eFEditForm') {
                $('#eFMovieAnnotationsEditBOOL').html('JA');
                $('#eFMovieAnnotationsContainerANList').delay(1200).find('tbody tr td').removeAttr('style');
                $('#eFMovieAnnotationsContainerFormsPop').removeAttr('class').fadeOut();
                $('#eFMovieAnnotationsContainerFormsPopContent').html('').empty();
                $(this).parent().remove();
            }
        }
        //Warnfenster
        function eFAWarning(Message) {
            console.log("eFEditorV.js -eFAWarning()");
            $('#eFMovieAnnotationsNewFormContainerWarning').fadeIn('fast', function () {
                $('#eFMovieAnnotationsNewFormContainerWarningContent').html(Message);
                $('#eFAFormWarnOKButton').click(function () {
                    $('#eFMovieAnnotationsNewFormContainerWarning').fadeOut('fast', function () {
                        $('#eFMovieAnnotationsNewFormContainerWarningContent').html('');
                    })
                });
            });
        }
    });
    /* /Formulare aus dem Formcontainer abschicken */
    function eFFormInput(Lable, Name, Classis, InputType, Visibility, DATA) {
        console.log("eFEditorV.js -eFFormInput()");
        if (Visibility == 'invisible') {
            var eFFormInputVisibility = " style='display:none' ";
            var eFFormInputReadonly = "";
        }
        else if (Visibility == 'readonly') {
            var eFFormInputVisibility = "";
            var eFFormInputReadonly = " readonly='readonly' ";
        }
        else {
            var eFFormInputVisibility = "";
            var eFFormInputReadonly = "";
        }
        if (InputType == "text") {
            var eFFormInputDetail = "<input class='" + Classis + "' type='text' name='" + Name + "' value='" + DATA + "' " + eFFormInputReadonly + ">";
        }
        else if (InputType == "textarea") {
            var eFFormInputDetail = "<textarea class='" + Classis + "' name='" + Name + "' " + eFFormInputReadonly + ">" + DATA + "</textarea>";
        }
        var eFFormInputP = "<div class='eFFormInput'" + eFFormInputVisibility + "><label for='" + Name + "'>" + Lable + ":</label>" + eFFormInputDetail + "</div>";
        return eFFormInputP;
    }

    /* Annotations Scenario Input Forms Input Lists */
//Popdown aufrufen
    $(document).on('click', '#eFMovieAnnotationsContainerForms form input', function () {
        console.log("eFEditorV.js #1061");
        var position = $(this).offset();
        var position2 = $(this).position();
        var eFPopWeite = $(this).width() + 2;
        var eFFormID = $(this).parent().parent().attr('id');
        var eFInputType = $(this).attr('class');
        var eFInputName = $(this).attr('name');
        var eFFormIDL1 = $(this).parent().parent().find('input[name=AnnotationType_L1]').val();
        var eFFormIDL2 = $(this).parent().parent().find('input[name=AnnotationType_L2]').val();
        var eFFormIDL3 = $(this).parent().parent().find('input[name=AnnotationType_L3]').val();
        var filmidfortips = $('#eFMovieMovieID').html();
        //Verschiedene Formulartypen unterscheiden
        switch (eFInputType) {
            case "eFSCDLocationN":
                var eFFormTip = "eFSCDLocationN";
                var eFFormTipVisual = "ListSelf";
                break;
            case "eFSCDLocationG":
                var eFFormTip = "eFSCDLocationG";
                var eFFormTipVisual = "Helper";
                break;
            case "eFSCDLandmark":
                var eFFormTip = "eFSCDLandmark";
                var eFFormTipVisual = "Database";
                break;
            case "eFSCDDate":
                var eFFormTip = "eFSCDDate";
                var eFFormTipVisual = "Helper";
                break;
            case "eFSCDPerson":
                var eFFormTip = "eFSCDPerson";
                var eFFormTipVisual = "Database";
                break;
            case "eFSCDOrganisation":
                var eFFormTip = "eFSCDOrganisation";
                var eFFormTipVisual = "Database";
                break;
            case "eFSCDHistoricEvent":
                var eFFormTip = "eFSCDHistoricEvent";
                var eFFormTipVisual = "Database";
                break;
            case "eFSCSLanguage":
                var eFFormTip = "eFSCSLanguage";
                var eFFormTipVisual = "List";
                break;
            case "eFSCSRelation":
                var eFFormTip = "eFSCSRelation";
                var eFFormTipVisual = "Helper";
                break;
            case "eFSCSSequenceNumber":
                var eFFormTip = "eFSCSSequenceNumber";
                var eFFormTipVisual = "Helper";
                break;
            case "eFSCSSceneNumber":
                var eFFormTip = "eFSCSSceneNumber";
                var eFFormTipVisual = "Helper";
                break;
            case "eFSCSShotNumber":
                var eFFormTip = "eFSCSShotNumber";
                var eFFormTipVisual = "Helper";
                break;
            case "eFSCSReelNumber":
                var eFFormTip = "eFSCSReelNumber";
                var eFFormTipVisual = "Helper";
                break;
            case "eFSCSSpacialType":
                var eFFormTip = "eFSCSSpacialType";
                var eFFormTipVisual = "List";
                break;
            case "eFSCSSpacialUse":
                var eFFormTip = "eFSCSSpacialUse";
                var eFFormTipVisual = "List";
                break;
            case "eFSCSPersonsNumber":
                var eFFormTip = "eFSCSPersonsNumber";
                var eFFormTipVisual = "List";
                break;
            case "eFSCSPersonsGender":
                var eFFormTip = "eFSCSPersonsGender";
                var eFFormTipVisual = "List";
                break;
            case "eFSCSPersonsAge":
                var eFFormTip = "eFSCSPersonsAge";
                var eFFormTipVisual = "List";
                break;
            case "eFSCSPersonsAction":
                var eFFormTip = "eFSCSPersonsAction";
                var eFFormTipVisual = "List";
                break;
            case "eFSCSVisualEventType":
                var eFFormTip = "eFSCSVisualEventType";
                var eFFormTipVisual = "List";
                break;
            case "eFSCSVisualEvent":
                var eFFormTip = "eFSCSVisualEvent";
                var eFFormTipVisual = "FreeText";
                break;
            case "eFSCSAudioEventType":
                var eFFormTip = "eFSCSAudioEventType";
                var eFFormTipVisual = "List";
                break;
            case "eFSCSAudioEvent":
                var eFFormTip = "eFSCSAudioEvent";
                var eFFormTipVisual = "FreeText";
                break;
            case "eFSCSIntertitleTranscript":
                var eFFormTip = "eFSCSIntertitleTranscript";
                var eFFormTipVisual = "FreeText";
                break;
            case "eFSCSWrittenElementsLanguage":
                var eFFormTip = "eFSCSWrittenElementsLanguage";
                var eFFormTipVisual = "List";
                break;
            case "eFSCSPunctum":
                var eFFormTip = "eFSCSPunctum";
                var eFFormTipVisual = "FreeText";
                break;
            case "eFSCSShotType":
                var eFFormTip = "eFSCSShotType";
                var eFFormTipVisual = "List";
                break;
            case "eFSCSCameraPosition":
                var eFFormTip = "eFSCSCameraPosition";
                var eFFormTipVisual = "FreeText";
                break;
            case "eFSCSEditing":
                var eFFormTip = "eFSCSEditing";
                var eFFormTipVisual = "List";
                break;
            case "eFSCSAmateurFilmCharacteristics":
                var eFFormTip = "eFSCSAmateurFilmCharacteristics";
                var eFFormTipVisual = "List";
                break;
            case "eFSCSIntention":
                var eFFormTip = "eFSCSIntention";
                var eFFormTipVisual = "List";
                break;
            case "eFSCSEducationalRemarks":
                var eFFormTip = "eFSCSEducationalRemarks";
                var eFFormTipVisual = "FreeText";
                break;
            default:
                var eFFormTip = "Test";
        }
        //Entsprechend der Variablen Tip Anzeigen
        if (eFFormTipVisual != "FreeText") {
            if ($("#mainstylesheet").attr("href") == "_css/eFEditorV_mini.css") {
                $('#eFMovieAnnotationsContainerFormsPop').css('top', position.top - 197 + 'px').css('left', position2.left + 8 + 'px').css('width', eFPopWeite + 'px').addClass(eFFormID);
            }
            else {
                $('#eFMovieAnnotationsContainerFormsPop').css('top', position.top - 80 + 'px').css('left', position2.left + 8 + 'px').css('width', eFPopWeite + 'px').addClass(eFFormID);
            }
            //Source ausnehmen
            if ($(this).attr('name') == 'source') {

                var eFRelFormId = $(this).parent().parent().attr('id');
                var eFRelFilmID = $('#eFMovieMovieID').html();

                $('#eFReSourcesFromMovieContainer').show();
                //ursprünglich TR
                $('#eFReSourcesFromMovieContainerBR').html('<div id="eFResRelIMFormContainer"><div id="eFResRelIMFormContainerTitle">Sources</div><div class="eFResRelIMFormContainerLine"><div class="eFResRelIMFormContainerLineKey">Source Type</div><div class="eFResRelIMFormContainerLineValue"><input type="text" name="eFResIMsourcetype" value="" readonly="readonly" /></div></div><div class="eFResRelIMFormContainerLine"><div class="eFResRelIMFormContainerLineKey">Source ID</div><div class="eFResRelIMFormContainerLineValue"><input type="text" name="eFResIMsourceid" value="" readonly="readonly" /></div></div><div class="eFResRelIMFormContainerLine"><div class="eFResRelIMFormContainerLineKey">Source Key</div><div class="eFResRelIMFormContainerLineValue"><input type="text" name="eFResIMsourcekey" value="" readonly="readonly" /></div></div><div class="eFResRelIMFormContainerLine"><div class="eFResRelIMFormContainerLineKey">Source Field</div><div class="eFResRelIMFormContainerLineValue"><input type="text" name="eFResIMsourcefield" value="" readonly="readonly" /></div></div><div class="eFResRelIMFormContainerLine"><div class="eFResRelIMFormContainerLineKey">Source Field ID</div><div class="eFResRelIMFormContainerLineValue"><input type="text" name="eFResIMsourcefieldid" value="" readonly="readonly" /></div></div><div class="eFResRelIMFormContainerLine"><div class="eFResRelIMFormContainerLineKey">From</div><div class="eFResRelIMFormContainerLineValue"><input type="text" name="eFResIMsourcefrom" value="" /></div></div><div class="eFResRelIMFormContainerLine"><div class="eFResRelIMFormContainerLineKey">To</div><div class="eFResRelIMFormContainerLineValue"><input type="text" name="eFResIMsourceto" value="" /></div></div><div id="eFResRelIMFormContainerSet"><div class="eFResRelIMOKButton" data-formid="' + eFRelFormId + '" data-filmid="' + eFRelFilmID + '">Set Form</div></div></div>');
                $('#eFRelMovieTimelineB').hide();
                $('#eFReSourcesFromMovieContainerContent').removeAttr('style');
                $('#eFReSourcesFromMovieContainerContent').load('_ajax/eFEditorVResourcesInMovie.php');
            }
            //Relations ausnehmen
            else if ($(this).parent().parent().find('legend').attr('class') == 'eFSCSRelationLegend') {

                var eFRelFormId = $(this).parent().parent().attr('id');
                var eFRelFilmID = $('#eFMovieMovieID').html();

                $('#eFReSourcesFromMovieContainer').show();
                //ursprünglich TR
                $('#eFReSourcesFromMovieContainerTR').html('<div id="eFRelationsInterfaceChoice"><span class="Movie-Relation" data-medium="Movie" data-formid="' + eFRelFormId + '" data-filmid="' + eFRelFilmID + '">Movie-Relation</span><span class="Image-Relation" data-medium="Image" data-formid="' + eFRelFormId + '" data-filmid="' + eFRelFilmID + '">Image-Relation</span></div><div id="eFReSourcesFromMovieContainerClose">X</div>');
                $('#eFReSourcesFromMovieContainerBR').html('<table id="eFRelationsInterfaceChoiceTable"><tr><td>Relationtype:</td><td><select name="eFRelationsInterfaceRelationType"><option selected="selected"></option><option>Has Format</option><option>Is Format Of</option><option>Has Part</option><option>Is Part Of</option><option>Has Version</option><option>Is Version Of</option><option>References</option><option>Is Referenced By</option><option>Replaces</option><option>Is Replaced By</option><option>Requires</option><option>Is Required By</option></select></td><td>From:</td><td><input type="text" name="eFRelationsInterfaceRelationFrom" value="" /></td><td rowspan="2"><span id="eFRelationsInterfaceRelationOKButton" data-formid="' + eFRelFormId + '" data-filmid="' + eFRelFilmID + '">Set Form</span></td></tr><tr><td>RelationIdentifier:</td><td><input type="text" name="eFRelationsInterfaceRelationIdentifier" value="" /></td><td>To:</td><td><input type="text" name="eFRelationsInterfaceRelationTo" value="" /></td></tr></table>');
                $('#eFRelMovieTimelineB').hide();
                $('#eFReSourcesFromMovieContainerContent').removeAttr('style');
            }
            else {
                $('#eFMovieAnnotationsContainerFormsPop').fadeIn();
                $('#eFMovieAnnotationsContainerFormsPopContent').load('_ajax/eFEditorVFormTip.php?eFFormTipVisual=' + eFFormTipVisual + '&eFFormID=' + eFFormID + '&FilmID=' + filmidfortips + '&eFFormTip=' + eFFormTip + '&eFInputName=' + eFInputName + '&eFFormIDL1=' + escape(eFFormIDL1) + '&eFFormIDL2=' + escape(eFFormIDL2) + '&eFFormIDL3=' + escape(eFFormIDL3) + '&UNIQID=' + uniqid());
            }
        }

    }).on('keyup', '#eFMovieAnnotationsContainerForms form input', function () {
        console.log("eFEditorV.js #1252");
        //Tabellenfilter
        if (event.keyCode == 27 || $(this).val() == '') {
            //esc löscht den filter
            $(this).val('');
            //Alle sichtbar machen, da nichts im Filter steht
            $('#eFMovieAnnotationsContainerFormsPop').find('tbody tr').removeClass('visible').show().addClass('visible');
        }
        //Wenn Input vorhanden, dann Filtern
        else {
            filterPOPdownA($('#eFMovieAnnotationsContainerFormsPop').find('tbody tr'), $(this).val());
        }
    });
    function filterPOPdownA(inputtext, anfrage) {
        console.log("eFEditorV.js -filterPOPdownA()");
        anfrage = $.trim(anfrage); //white spaces raus
        anfrage = anfrage.replace(/ /gi, '|'); // Leerzeichen wird OR für regex suche
        $(inputtext).each(function () {
            ($(this).text().search(new RegExp(anfrage, "i")) < 0) ? $(this).hide().removeClass('visible') : $(this).show().addClass('visible');
        });
    }

//PopDown schließen
    $(document).on('click', '#eFMovieAnnotationsContainerFormsPopClose', function () {
        console.log("eFEditorV.js #1278");
        $('#eFMovieAnnotationsContainerFormsPopContent').html(' ');
        $(this).parent().removeAttr('class').fadeOut();

    });
//Ausgelesene Values in Formular schreiben
    $(document).on('click', '.eFTipTabCell', function () {
        console.log("eFEditorV.js #1285");
        var eFTargetForm = $(this).parent().parent().attr('id');
        var eFTargetType = $(this).parent().parent().parent().attr('id');
        var eFTargetInput = $(this).attr('name');
        var eFTargetValue = $(this).html();
        switch (eFTargetType) {
            case "eFSCDLandmark":
                $('#eFMovieAnnotationsContainerForms').find('form[id=' + eFTargetForm + '] input[name=coverage]').val(eFTargetValue);
                $('#eFMovieAnnotationsContainerForms').find('form[id=' + eFTargetForm + '] input[name=coverage_S_LandmarkID]').val($(this).attr('id'));
                break;
            case "eFSCDPerson":
                $('#eFMovieAnnotationsContainerForms').find('form[id=' + eFTargetForm + '] input[name=subject_P_PersonName]').val(eFTargetValue);
                $('#eFMovieAnnotationsContainerForms').find('form[id=' + eFTargetForm + '] input[name=subject_P_PersonID]').val($(this).attr('id'));
                break;
            case "eFSCDOrganisation":
                $('#eFMovieAnnotationsContainerForms').find('form[id=' + eFTargetForm + '] input[name=subject_O_OrganizationType]').val($(this).children('#eFOType').html());
                $('#eFMovieAnnotationsContainerForms').find('form[id=' + eFTargetForm + '] input[name=subject_O_OrganizationName]').val($(this).children('#eFOName').html());
                $('#eFMovieAnnotationsContainerForms').find('form[id=' + eFTargetForm + '] input[name=subject_O_OrganizationID]').val($(this).attr('id'));
                break;
            case "eFSCDHistoricEvent":
                $('#eFMovieAnnotationsContainerForms').find('form[id=' + eFTargetForm + '] input[name=subject_HE_Title]').val($(this).children('#eFHETitle').html());
                $('#eFMovieAnnotationsContainerForms').find('form[id=' + eFTargetForm + '] input[name=subject_HE_Date]').val($(this).children('#eFHEDate').html());
                $('#eFMovieAnnotationsContainerForms').find('form[id=' + eFTargetForm + '] input[name=subject_HE_Type]').val($(this).children('#eFHEType').html());
                $('#eFMovieAnnotationsContainerForms').find('form[id=' + eFTargetForm + '] input[name=subject_HE_ID]').val($(this).attr('id'));
                break;
            default:
                $('#eFMovieAnnotationsContainerForms').find('form[id=' + eFTargetForm + '] input[name=' + eFTargetInput + ']').val(eFTargetValue);
        }

        $('#eFMovieAnnotationsContainerFormsPopContent').html('').empty();
        $('#eFMovieAnnotationsContainerFormsPop').removeAttr('class').fadeOut();
    });

    /* Annotations Delete */
    $(document).on('click', '.eFTabCellDelete', function (e) {
        console.log("eFEditorV.js #1326");

        var viewvaranonde = $(document).find('#eFMovieMovieID').attr('data-ur');
        if (viewvaranonde == "VIEW") {
            alert("You are not allowed to delete this movie's annotations");
        }
        else {
            //ID holen
            var eFDelID = $(this).parent().attr('data-recordid');

            //console.log(nikeditabiliter);
            //Löschfenster zeigen         $('#eFDelQuestion').html(tip);
            $('#eFDelQuestion').fadeIn();
            //R-Check
            var nikeditabiliter = $(this).parent().find('.eFTabCellUser').html();
            var idmgetit = $('.eFMovieSelectCSelected').attr('title');
            $.ajax({
                async: false,
                type: "GET",
                url: "_ajax/eFEditorVMovieRCK.php",
                data: "idm=" + idmgetit + "&uniquid=" + uniqid(),
                success: function (data) {
                    CUserRightsMoviesSetAlljson = $.parseJSON(data);
                    switch (CUserRightsMoviesSetAlljson.RIGHTS_Movies) {
                        case "NONE":
                            $('#eFDelQuestion').html('<div class="eFDelButtonText">You are not allowed to delete this annotation!<span class="eFDelButton" id="eFDelButtonNo">ok</span></div>');
                            break;

                        case "VIEW":
                            $('#eFDelQuestion').html('<div class="eFDelButtonText">You are not allowed to delete this annotation!<span class="eFDelButton" id="eFDelButtonNo">ok</span></div>');
                            break;

                        case "SELFEDIT":
                            if (nikeditabiliter == CUserRightsMoviesSetAlljson.UNIKINGER) {
                                $('#eFDelQuestion').html('<div class="eFDelButtonText">Delete for real? &emsp;<span class="eFDelButton" id="eFDelButtonYes" name="' + eFDelID + '">yes</span><span class="eFDelButton" id="eFDelButtonNo">no</span></div>');
                            }
                            else {
                                $('#eFDelQuestion').html('<div class="eFDelButtonText">You are only allowed to delete your own annotations!<span class="eFDelButton" id="eFDelButtonNo">ok</span></div>');
                            }
                            break;

                        case "EDIT":
                            $('#eFDelQuestion').html('<div class="eFDelButtonText">Delete for real? &emsp;<span class="eFDelButton" id="eFDelButtonYes" name="' + eFDelID + '">yes</span><span class="eFDelButton" id="eFDelButtonNo">no</span></div>');
                            break;
                    }
                },
                cache: false
            });
            var position = $(this).parent().offset();
            //Position setzten ... verdammt!!! Musste es von document ableiten, weil mir die Pos im Div immer falsch angegeben wurde ...
            if ($("#mainstylesheet").attr("href") == "_css/eFEditorV_mini.css") {
                if ($(this).outerHeight(true) > 40) {
                    hoehenparameter = 40;
                    topabstand = (position.top + 1) + (($(this).outerHeight(true) / 2) - 20)
                }
                else {
                    hoehenparameter = $(this).outerHeight(true) - 1;
                    topabstand = position.top + 1;
                }
                $('#eFDelQuestion').css('top', topabstand).css('right', '18px').css('width', '332px').css('height', hoehenparameter);
                $('.eFDelButtonText').css('margin-top', Math.floor((hoehenparameter - 8) / 2));
            }
            else {
                $('#eFDelQuestion').css('top', position.top).css('right', '25px').css('width', '573px').css('height', $(this).outerHeight(true));
                $('.eFDelButtonText').css('margin-top', Math.floor(($(this).outerHeight(true) - 15) / 2))
            }
        }
    });
    $('#eFMovieAnnotationsContainerANList').scroll(function () {
        console.log("eFEditorV.js #1406");
        $('#eFDelQuestion').hide();
    });
    $(document).on('click', '#eFDelButtonYes', function () {
        console.log("eFEditorV.js #1411");
        rowID = $(this).attr('name');
        $.ajax({
            url: "_ajax/eFEditorVMovieAnnotationsDelete.php",
            data: 'DELID=' + rowID,
            success: function () {
                $('#eFMovieAnnotationsContainerANList').load('_ajax/eFEditorVMovieAnnotationsList.php?MovieID=' + $('.eFMovieSelectCSelected').text() + '&fps=' + $('.eFMovieSelectCSelected').attr('name') + '&TID=' + $('.eFMovieSelectCSelected').attr('title') + '&UNUM=' + uniqid());
                $('#efDelRowActive').html('false');
                $('#eFDelQuestion').fadeOut();
            },
            cache: false
        });
    });
    $(document).on('click', '#eFDelButtonNo', function () {
        console.log("eFEditorV.js #1426");
        $('#eFDelQuestion').fadeOut();
    });

    /* Time Picker */
    $(document).on('click', '#eFDateTipSelect', function () {
        console.log("eFEditorV.js #1439");
        var eFTargetForm = $(this).parent().parent().parent().parent().parent().parent().parent().find('div[id=eFMovieAnnotationsContainerFormsPop]').attr('class');
        //console.log(eFTargetForm);
        //TimeValues in Target Form schreiben
        var eFDateFromTipJJJJ = $(this).parent().parent().parent().parent().parent().find('select[id=eFDateFromTipJJJJ]').val();
        var eFDateFromTipMM = $(this).parent().parent().parent().parent().parent().find('select[id=eFDateFromTipMM]').val();
        var eFDateFromTipDD = $(this).parent().parent().parent().parent().parent().find('select[id=eFDateFromTipDD]').val();
        var eFDateFromTipHH = $(this).parent().parent().parent().parent().parent().find('select[id=eFDateFromTipHH]').val();
        var eFDateToTipJJJJ = $(this).parent().parent().parent().parent().parent().find('select[id=eFDateToTipJJJJ]').val();
        var eFDateToTipMM = $(this).parent().parent().parent().parent().parent().find('select[id=eFDateToTipMM]').val();
        var eFDateToTipDD = $(this).parent().parent().parent().parent().parent().find('select[id=eFDateToTipDD]').val();
        var eFDateToTipHH = $(this).parent().parent().parent().parent().parent().find('select[id=eFDateToTipHH]').val();
        var eFDateTypeTip = $(this).parent().parent().parent().parent().parent().find('input[name=eFDateTypeTip]:checked').val();
        //console.log(eFDateTypeTip);
        if (typeof eFDateTypeTip != 'undefined') {
            $(this).parent().parent().parent().parent().parent().parent().parent().find('form[id=' + eFTargetForm + ']').find('input[name=coverage_T_From]').val(eFDateFromTipJJJJ + '-' + eFDateFromTipMM + '-' + eFDateFromTipDD + ' ' + eFDateFromTipHH);
            if (eFDateTypeTip == 'PIT') {
                $(this).parent().parent().parent().parent().parent().parent().parent().find('form[id=' + eFTargetForm + ']').find('input[name=coverage_T_To]').val(eFDateFromTipJJJJ + '-' + eFDateFromTipMM + '-' + eFDateFromTipDD + ' ' + eFDateFromTipHH);
            }
            else {
                $(this).parent().parent().parent().parent().parent().parent().parent().find('form[id=' + eFTargetForm + ']').find('input[name=coverage_T_To]').val(eFDateToTipJJJJ + '-' + eFDateToTipMM + '-' + eFDateToTipDD + ' ' + eFDateToTipHH);
            }
            $('#eFMovieAnnotationsContainerFormsPopContent').html('').empty();
            $('#eFMovieAnnotationsContainerFormsPop').removeAttr('class').fadeOut();
        }
    });

    /* Relations & Sources for Movies */
    $(document).on('click', '#eFReSourcesFromMovieContainerClose', function () {
        console.log("eFEditorV.js #1487");
        //var für ansichtsmodus movie setzten
        $('#eFMovieContainer').attr('data-efposmodus', 'movie');
        initialPosMainMovie();
        $('#eFReSourcesFromMovieContainerTR').empty().html('<div id="eFReSourcesFromMovieContainerClose">X</div>');
        $('#eFReSourcesFromMovieContainerBR').empty();
        $('#eFReSourcesFromMovieContainerContent').empty();
        $('#eFReSourcesFromMovieContainer').hide();
        $('#eFRelMovieTimelineB').hide();
        $('#eFMovieRangeInputContainerRel').empty();
        $('#eFRelMovieTimelineB .efMoviePlaybuttons').removeClass('efMovieSpeedContainersActive');
        $('#eFTimelineContainerTableFrameNumbersRel th').empty();
        $('#eFTimelineContainerTableINRel').html('<img id="efTLCINRel" alt="in" src="_img/in.png" width="18" height="14">');
        $('#eFTimelineContainerTableOUTRel').html('<img id="efTLCOUTRel" alt="out" src="_img/out.png" width="18" height="14">');
        $('#eFTimelineContainerTableFramePicsRel td').removeAttr('style');
        $('#eFReSourcesFromMovieContainerContent').removeAttr('style');
    });
    $(document).on('click', '.Movie-Relation', function () {
        console.log("eFEditorV.js #1505");
        $(document).find('#eFRelationsInterfaceRelationOKButton').attr('data-savemode', 'movie');
        //var für ansichtsmodus movie setzten
        $('#eFMovieContainer').attr('data-efposmodus', 'relation');
        initialPosMainMovie();
        $(this).parent().find('span').removeClass('selected');
        $(this).addClass('selected');
        var eFRelFilmID = $(this).attr('data-filmid');
        $('#eFReSourcesFromMovieContainerContent').css('background-image', 'url(_img/transparent-square-0-percent.png)').load('_ajax/eFEditorVRealtionsInMovie_Movie.php?FilmID=' + eFRelFilmID);
        $('#eFRelMovieTimelineB').show();

    });

    /*** New Movie Relation ***/
    $(document).on('click', '#eFRelationsInterfaceRelationOKButton[data-savemode=movie]', function () {
        console.log("eFEditorV.js #1521");
        var eFRelFormID = $(this).attr('data-formid');
        var eFRelMedium = $(document).find('#eFRelationsInterfaceChoice span.selected').attr('data-medium');
        var eFRelRelationType = $(document).find('select[name=eFRelationsInterfaceRelationType] option:selected').val();
        var eFRelRelationIdentifier = $(document).find('input[name=eFRelationsInterfaceRelationIdentifier]').val();
        var eFRelFrom = $(document).find('input[name=eFRelationsInterfaceRelationFrom]').val();
        var eFRelTo = $(document).find('input[name=eFRelationsInterfaceRelationTo]').val();
        //console.log(eFRelMedium);
        $(document).find('form[id=' + eFRelFormID + '] input[name=relation]').val(eFRelMedium);
        $(document).find('form[id=' + eFRelFormID + '] input[name=relation_relationType]').val(eFRelRelationType);
        $(document).find('form[id=' + eFRelFormID + '] input[name=relation_relationIdentifier]').val(eFRelRelationIdentifier);
        $(document).find('form[id=' + eFRelFormID + '] input[name=relation_relationIdentifier_from]').val(eFRelFrom);
        $(document).find('form[id=' + eFRelFormID + '] input[name=relation_relationIdentifier_to]').val(eFRelTo);

        $(document).find('#eFMovieContainer').attr('data-efposmodus', 'movie');
        initialPosMainMovie();
        $(document).find('#eFReSourcesFromMovieContainerTR').empty();
        $(document).find('#eFReSourcesFromMovieContainerContent').empty();
        $(document).find('#eFReSourcesFromMovieContainer').hide();
        $(document).find('#eFRelMovieTimelineB').hide();
        $(document).find('#eFMovieRangeInputContainerRel').empty();
        $(document).find('#eFRelMovieTimelineB .efMoviePlaybuttons').removeClass('efMovieSpeedContainersActive');
        $(document).find('#eFTimelineContainerTableFrameNumbersRel th').empty();
        $(document).find('#eFTimelineContainerTableINRel').html('<img id="efTLCINRel" alt="in" src="_img/in.png" width="18" height="14">');
        $(document).find('#eFTimelineContainerTableOUTRel').html('<img id="efTLCOUTRel" alt="out" src="_img/out.png" width="18" height="14">');
        $(document).find('#eFTimelineContainerTableFramePicsRel td').removeAttr('style');
        $(document).find('#eFReSourcesFromMovieContainerContent').removeAttr('style');

    });

    $(document).on('click', '.Image-Relation', function () {
        console.log("eFEditorV.js #1557");
        $(document).find('#eFRelationsInterfaceRelationOKButton').attr('data-savemode', 'image');
        //Movie relation auf jeden fall zurücksetzten
        $('#eFMovieContainer').attr('data-efposmodus', 'movie');
        initialPosMainMovie();
        $('#eFRelMovieTimelineB').hide();
        $('#eFMovieRangeInputContainerRel').empty();
        $('#eFRelMovieTimelineB .efMoviePlaybuttons').removeClass('efMovieSpeedContainersActive');
        $('#eFTimelineContainerTableFrameNumbersRel th').empty();
        $('#eFTimelineContainerTableINRel').html('<img id="efTLCINRel" alt="in" src="_img/in.png" width="18" height="14">');
        $('#eFTimelineContainerTableOUTRel').html('<img id="efTLCOUTRel" alt="out" src="_img/out.png" width="18" height="14">');
        $('#eFTimelineContainerTableFramePicsRel td').removeAttr('style');
        $('#eFReSourcesFromMovieContainerContent').removeAttr('style');

        $('#eFRelMovieTimelineB').hide();
        $('#eFReSourcesFromMovieContainerContent').removeAttr('style');
        $(this).parent().find('span').removeClass('selected');
        $(this).addClass('selected');
        $('#eFReSourcesFromMovieContainerContent').load('_ajax/eFEditorVRealtionsInMovie_Image.php');

    });

    /*Source Add*/
    $(document).on('click', '.efResourceUnitNewContainerAddRes', function () {
        console.log("eFEditorV.js #1584");
        var SourceType = $(this).attr('data-type');
        var SourceID = $(this).attr('data-id');
        var SourceKey = $(this).attr('data-key');
        $(document).find('.eFResRelIMFormContainerLineValue input[name=eFResIMsourcetype]').val(SourceType);
        $(document).find('.eFResRelIMFormContainerLineValue input[name=eFResIMsourceid]').val(SourceID);
        $(document).find('.eFResRelIMFormContainerLineValue input[name=eFResIMsourcekey]').val(SourceKey);
        $(document).find('.eFResRelIMFormContainerLineValue input[name=eFResIMsourcefield]').val('');
        $(document).find('.eFResRelIMFormContainerLineValue input[name=eFResIMsourcefieldid]').val('');
    });
    $(document).on('click', '.efResourceUnitNewContainerAddResSub', function () {
        console.log("eFEditorV.js #1595");
        var SourceType = $(this).attr('data-type');
        var SourceID = $(this).attr('data-id');
        var SourceKey = $(this).attr('data-key');
        var SourceFieldName = $(this).attr('data-fieldnamel2');
        var SourceFieldID = $(this).attr('data-idl2');
        $(document).find('.eFResRelIMFormContainerLineValue input[name=eFResIMsourcetype]').val(SourceType);
        $(document).find('.eFResRelIMFormContainerLineValue input[name=eFResIMsourceid]').val(SourceID);
        $(document).find('.eFResRelIMFormContainerLineValue input[name=eFResIMsourcekey]').val(SourceKey);
        $(document).find('.eFResRelIMFormContainerLineValue input[name=eFResIMsourcefield]').val(SourceFieldName);
        $(document).find('.eFResRelIMFormContainerLineValue input[name=eFResIMsourcefieldid]').val(SourceFieldID);

    });

    /* Formular setzen */
    $(document).on('click', '.eFResRelIMOKButton', function () {
        console.log("eFEditorV.js #1611");
        var eFRelFormId = $(this).attr('data-formid');
        var eFRelFilmID = $(this).attr('data-filmid');

        var eFsourceType = $(document).find('.eFResRelIMFormContainerLineValue input[name=eFResIMsourcetype]').val();
        var eFsourceID = $(document).find('.eFResRelIMFormContainerLineValue input[name=eFResIMsourceid]').val();
        var eFsourceKey = $(document).find('.eFResRelIMFormContainerLineValue input[name=eFResIMsourcekey]').val();
        var eFsourceField = $(document).find('.eFResRelIMFormContainerLineValue input[name=eFResIMsourcefield]').val();
        var eFsourceFieldID = $(document).find('.eFResRelIMFormContainerLineValue input[name=eFResIMsourcefieldid]').val();
        var eFsourceFrom = $(document).find('.eFResRelIMFormContainerLineValue input[name=eFResIMsourcefrom]').val();
        var eFsourceTo = $(document).find('.eFResRelIMFormContainerLineValue input[name=eFResIMsourceto]').val();

        var rFSourceStringJSON = '{ "SourceType":"' + eFsourceType + '", "SourceID":"' + eFsourceID + '", "SourceKey":"' + eFsourceKey + '", "SourceField":"' + eFsourceField + '", "SourceFieldID":"' + eFsourceFieldID + '", "SourceFrom":"' + eFsourceFrom + '", "SourceTo":"' + eFsourceTo + '" }';

        $(document).find('form[id=' + eFRelFormId + '] input[name=source]').val(rFSourceStringJSON);
        $('#eFMovieContainer').attr('data-efposmodus', 'movie');
        initialPosMainMovie();
        $('#eFReSourcesFromMovieContainerTR').empty();
        $('#eFReSourcesFromMovieContainerContent').empty();
        $('#eFReSourcesFromMovieContainer').hide();
        $('#eFRelMovieTimelineB').hide();
        $('#eFMovieRangeInputContainerRel').empty();
        $('#eFRelMovieTimelineB .efMoviePlaybuttons').removeClass('efMovieSpeedContainersActive');
        $('#eFTimelineContainerTableFrameNumbersRel th').empty();
        $('#eFTimelineContainerTableINRel').html('<img id="efTLCINRel" alt="in" src="_img/in.png" width="18" height="14">');
        $('#eFTimelineContainerTableOUTRel').html('<img id="efTLCOUTRel" alt="out" src="_img/out.png" width="18" height="14">');
        $('#eFTimelineContainerTableFramePicsRel td').removeAttr('style');
        $('#eFReSourcesFromMovieContainerContent').removeAttr('style');
    });

    /***********************************Preview Window*************************************/
//eFResourcesPreviewWindowContainer
    $(document).on('click', '.efResourceUnit2fieldcontent img', function () {
        console.log("eFEditorV.js #1646");

        $('#eFResourcesPreviewWindowContainer').show();
        if ($(this).attr('src') == '_img/pdf-icon.png') {
            var pdfpath = '_uploads/pdf/' + $(this).attr('alt');
            //$('#eFResourcesPreviewWindowContainerContent').html('<div id="eFResourcesPreviewWindowContainerTitle">' + $(this).attr('alt') + ' (' + $(this).attr('title') + ')</div><iframe src="' + pdfpath + '">')
            $('#eFResourcesPreviewWindowContainerContent').html('<div id="eFResourcesPreviewWindowContainerTitle">' + $(this).attr('alt') + ' (' + $(this).attr('title') + ')</div><div id="eFPDFViewer"><object data="' + pdfpath + '#toolbar=1&amp;navpanes=0&amp;scrollbar=1&amp;page=1&amp;view=FitH" type="application/pdf" width="100%" height="100%"><p>It appears you don´t have a PDF plugin for this browser. You can <a href="' + pdfpath + '">click here to download the PDF file.</a></p></object></div>')
        }
        else {
            var pdfpath = '_uploads/img/' + $(this).attr('alt');
            $('#eFResourcesPreviewWindowContainerContent').html('<div id="eFResourcesPreviewWindowContainerTitle">' + $(this).attr('alt') + ' (' + $(this).attr('title') + ')</div><iframe src="' + pdfpath + '">')
        }
    });

    $(document).on('click', '#eFResourcesPreviewWindowContainerClose', function () {
        console.log("eFEditorV.js #1664");
        $('#eFResourcesPreviewWindowContainerContent').empty();
        $('#eFResourcesPreviewWindowContainer').hide();
    });

/**
 * This opens up the display of the log file for the current film and populates
 * the current log records.
 */
    $('#eFLog').click(function () {
        if (typeof currentFilmID != 'undefined') {
            if (document.getElementById('eFResearchLog') == null) {
                var div = document.createElement("div");
                div.setAttribute('id', 'eFResearchLog');
                div.setAttribute('class', 'eFResearchLog');
                div.style.position = 'absolute';
                div.style.marginTop = '8%';
                div.style.marginLeft = '20%';
                div.style.width = "60%";
                div.style.height = "80%";
                div.style.overflow = 'auto';
                div.style.background = "#ffffff";
                div.style.border = "1px solid #666666";
                div.style.zIndex = '100000000000';
                document.body.appendChild(div);
                $('#eFResearchLog').load('_ajax/researchLog.php?idm=' + currentFilmID);
            } else {
                document.getElementById('eFResearchLog').parentElement.removeChild(document.getElementById('eFResearchLog'));
            }
        }
    });

/**
 * This is the action for submitting notes for the given film.
 * It sends the currentFilmID and comments to the PHP file for processing.
 * PHP File: _ajax/appendLog.php
 */
    $(document).on('submit', '#researchNotes', function (e) {
        $.ajax({
            async: false,
            type: "POST",
            url: "_ajax/appendLog.php",
            data: "film=" + currentFilmID + "&comments=" + document.getElementById('comments').value,
            success: function (data) {
                document.getElementById('researchLogHistory').innerHTML += data;
                document.getElementById('comments').value = '';
            },
            cache: false
        });
        return false;
    });

/**
 * This closes the log display
 */
    $(document).on('click', '#logClose', function () {
        document.getElementById('eFResearchLog').parentElement.removeChild(document.getElementById('eFResearchLog'));
    });

    /* Publish */
    $('#eFPublish').click(function () {
        if (isLive) {
            if (document.getElementById('eFMovieMovieID').innerHTML != '') {
                if (confirm('Unpublish ' + document.getElementById('eFMovieMovieID').innerHTML + ' from the public web site?')) {
                    $('#eFPublish').load('_ajax/unpublish.php?idm=' + currentFilmID);
                } else {
                    // nevermind
                }
            }
        } else {
            if (document.getElementById('eFMovieMovieID').innerHTML != '') {
                if (confirm('Publish ' + document.getElementById('eFMovieMovieID').innerHTML + ' to the public web site?')) {
                    $('#eFPublish').load('_ajax/publish.php?idm=' + currentFilmID);
                } else {
                    // nevermind
                }
            }
        }
    });

    /* Config */
    $('#eFConfigOpen').click(function () {
        console.log("eFEditorV.js #1681");
        $('#eFConfigContainer').show();
        $('#eFConfigContainerContent').load('_ajax/eFEditorVConfig.php');
    });

    $('#eFConfigContainerClose').click(function () {
        console.log("eFEditorV.js #1687");
        $('#eFConfigContainerContent').html('').empty();
        $('#eFConfigContainer').hide();
    });

    /* Resources */
    $('#eFResourcesOpen').click(function () {
        console.log("eFEditorV.js #1700");
        $('#eFResourcesContainer').show();
        $('#eFResourcesContainerContent').load('_ajax/eFEditorVResources.php');
    });

    $('#eFResourcesContainerClose').click(function () {
        console.log("eFEditorV.js #1706");
        $('#eFResourcesContainerContent').html('').empty();
        $('#eFResourcesContainer').hide();
    });
    /*********** EX eFEditorVResources.js ***************************/


    //console.log('Hi, I am Resources!');
    $(document).on('click', '#eFResourcesSelect ul li.content', function () {
        console.log("eFEditorV.js #1715");
        var eFContentSelected = encodeURI($(this).attr('data-content'));
        var eFContentKat = encodeURI($(this).attr('data-kat'));
        $('#eFResourcesSelect ul li.content').removeClass('eFResSelected');
        $(this).addClass('eFResSelected');
        $('#eFResourcesContent').load('_ajax/eFEditorVResourcesContent.php?eFContentSelected=' + eFContentSelected + '&eFContentKat=' + eFContentKat + '&uniquid=' + uniqid());
    });

    /**************** Filter Resource Objects **********************************/
    $(document).on('keyup', '#eFResourcesFilterInput', function () {
        console.log("eFEditorV.js #1725");
        //Unterscheidung: self und relations
        var eFFilterRegion = $(this).attr('data-filterregion');
        if (event.keyCode == 27 || $(this).val() == '') {
            //esc löscht den filter
            $(this).val('');
            //Alle sichtbar machen, da nichts im Filter steht

            switch (eFFilterRegion) {
                case 'self':
                    $('#eFResourcesSubContent .efResourceUnit1').removeClass('eFResourcesFilterFound').removeClass('visible').show().addClass('visible').find('.efResourceUnit2fieldcontent').removeClass('visible').show().addClass('visible').removeClass('eFResourcesFilterHighlight');
                    break;
                case 'relations':

                    $(document).find('#eFResourcesSubContentRelations .efResourceUnit1').removeClass('eFResourcesFilterFound').removeClass('visible').show().addClass('visible').find('.efResourceUnit2fieldcontentRelations').removeClass('visible').show().addClass('visible').removeClass('eFResourcesFilterHighlight');
                    break;
            }
        }
        //Wenn Input vorhanden, dann Filtern
        else {
            switch (eFFilterRegion) {
                case 'self':
                    filterResourceObjects($('#eFResourcesSubContent .efResourceUnit1').find('.efResourceUnit2fieldcontent'), $(this).val());
                    break;
                case 'relations':

                    filterResourceObjects($(document).find('#eFResourcesSubContentRelations .efResourceUnit1').find('.efResourceUnit2fieldcontentRelations'), $(this).val());
                    break;
            }

        }
    });

    /*** Filter Group FUNKTIONIERt NOCH NICHT ***/
    $(document).on('change', '#eFResourcesFilterGroup', function () {
        filterGroups();
        console.log("eFEditorV.js filterGroups()");
    });

    function filterGroups() {
        var selectMenu = document.getElementById('eFResourcesFilterGroup');
        var selection = selectMenu.options[selectMenu.selectedIndex].text;
        var resources = document.getElementsByClassName('efResourceUnit1');
        if (selection == '') {
            for (var i = 0; i < resources.length; i++) {
                resources[i].style.display = 'block';
            }
        } else {
            for (var i = 0; i < resources.length; i++) {
                var resourceSelectMenu = resources[i].getElementsByTagName('select')[0];
                var resourceGroup = resourceSelectMenu.options[resourceSelectMenu.selectedIndex].text;
                if (resourceGroup == selection) {
                    resources[i].style.display = 'block';
                } else {
                    resources[i].style.display = 'none';
                }
            }
        }
    }


    function filterResourceObjects(inputtext, anfrage) {
        console.log("eFEditorV.js -filterResourceObjects()");

        anfrage = $.trim(anfrage); //white spaces raus
        anfrage = anfrage.replace(/ /gi, '|'); // Leerzeichen wird OR für regex suche
        //console.log(anfrage);
        var hugo = new Array();
        $(inputtext).each(function () {

            //console.log($(this).text().search(new RegExp(anfrage, "i")));
            if ($(this).text().search(new RegExp(anfrage, "i")) < 0) {
                //$(this).hide().removeClass('visible');
                $(this).removeClass('eFResourcesFilterHighlight');
                $(this).parent().parent().parent().not('eFResourcesFilterFound').hide().removeClass('visible')
            }
            else {
                $(this).parent().parent().parent().addClass('eFResourcesFilterFound').show().addClass('visible');
                $(this).addClass('eFResourcesFilterHighlight').show().addClass('visible');
                hugo.push($(this).parent().parent().parent().attr('data-idl1'));
            }
        });
        //console.log(hugo);
        jQuery.each(hugo, function (i, val) {
            var eFFilterRegion = $(document).find('input[name=eFResourcesFilterInput]').attr('data-filterregion');
            switch (eFFilterRegion) {
                case 'self':
                    $('#eFResourcesSubContent .efResourceUnit1[data-idl1="' + val + '"]').addClass('eFResourcesFilterFound').show().addClass('visible');
                    break;
                case 'relations':
                    $('#eFResourcesSubContentRelations .efResourceUnit1[data-idl1="' + val + '"]').addClass('eFResourcesFilterFound').show().addClass('visible');
                    break;
            }
        });
    }

    function filterGroup(inputtext, anfrage) {
        console.log("eFEditorV.js -filterGroup()");

        var hugo = new Array();
        $(inputtext).each(function () {

            if ($(this).text().search(new RegExp(anfrage, "i")) < 0) {
                $(this).parent().removeClass('eFResourcesFilterFound').hide().removeClass('visible');
                $(this).removeClass('eFResourcesFilterHighlight').hide().removeClass('visible');
            } else {
                $(this).parent().addClass('eFResourcesFilterFound').show().addClass('visible');
                $(this).addClass('eFResourcesFilterHighlight').show().addClass('visible');
                hugo.push($(this).parent().attr('data-idl1'));
            }
        });
        //console.log(hugo);
        jQuery.each(hugo, function (i, val) {
            console.log("eFEditorV.js #1859");
            var eFFilterRegion = $(document).find('input[name=eFResourcesFilterInput]').attr('data-filterregion');
            switch (eFFilterRegion) {
                case 'self':
                    $('#eFResourcesSubContent .efResourceUnit1[data-idl1="' + val + '"]').addClass('eFResourcesFilterFound').show().addClass('visible');
                    break;
                case 'relations':
                    $('#eFResourcesSubContentRelations .efResourceUnit1[data-idl1="' + val + '"]').addClass('eFResourcesFilterFound').show().addClass('visible');
                    break;
            }
        });
    }

    /**************** Delete L1 Object **********************************/
    $(document).on('click', '.efResourceUnit1DeleteObject', function () {
        console.log("eFEditorV.js #1876");
        $(this).parent().find('.efResourceUnit1DeleteObjectWarning').show();

    });
    $(document).on('click', '#efResourceUnit1DeleteObjectWarningMessageButtonNO', function () {
        console.log("eFEditorV.js #1881");
        $(this).parent().parent().parent().find('.efResourceUnit1DeleteObjectWarning').hide();
    });
    $(document).on('click', '#efResourceUnit1DeleteObjectWarningMessageButtonYES', function () {
        console.log("eFEditorV.js #1885");
        //alert($(this).parent().parent().parent().attr('data-idl1'));
        var eFResourcesDelID = $(this).parent().parent().parent().attr('data-idl1');
        $.ajax({
            async: false,
            type: "GET",
            url: "_ajax/eFEditorVResourcesContentDelete.php",
            data: "eFResourcesDelID=" + eFResourcesDelID,
            success: function () {
                console.log("eFEditorV.js #1894");
                var eFContentSelectedD = encodeURI($('#eFResourcesSelect ul li.eFResSelected').attr('data-content'));
                var eFContentKatD = encodeURI($('#eFResourcesSelect ul li.eFResSelected').attr('data-kat'));
                //console.log(eFContentSelectedD + ' | ' + eFContentKatD);
                $('#eFResourcesContent').empty().load('_ajax/eFEditorVResourcesContent.php?eFContentSelected=' + eFContentSelectedD + '&eFContentKat=' + eFContentKatD + '&uniquid=' + uniqid());
            },
            cache: false
        });
    });
    /**************** New L1 Object **********************************/
    $(document).on('click', '#eFResourcesNewObject', function () {
        console.log("eFEditorV.js #1905");
        //console.log($(this).attr('data-category'));
        var eFNewResourceType = encodeURI($(this).attr('data-type'));
        var eFNewResourceCategory = encodeURI($(this).attr('data-category'));
        var eFShortM1 = encodeURI($(this).attr('data-eFShortM1'));
        var eFShortM2 = encodeURI($(this).attr('data-eFShortM2'));
        $(this).parent().find('#efResourceUnitNewContainer').show();
        $(this).parent().find('#efResourceUnitNewContainerNewObject').load('_ajax/eFEditorVResourcesContentNew.php?eFNewResourceType=' + eFNewResourceType + '&eFNewResourceCategory=' + eFNewResourceCategory + '&eFShortM1=' + eFShortM1 + '&eFShortM2=' + eFShortM2 + '&uniquid=' + uniqid());
    });
    $(document).on('click', '#efResourceUnitNewContainerClose', function () {
        console.log("eFEditorV.js #1915");
        $(this).parent().hide().find('#efResourceUnitNewContainerNewObject').empty();
    });
    /**************** New L2 Object **********************************/

    $(document).on('click', '#eFResourcesNewObjectFormNewSubObject', function () {
        console.log("eFEditorV.js #1921");
        var eFNewL2AdditionalFieldname = $(this).parent().find('form input[name=eFResourcesNewObjectFormNewSubObjectNAME]').val();
        var eFNewL2AdditionalFieldtype = $(this).parent().find('form input[name=eFResourcesNewObjectFormNewSubObjectTYPE]:checked').val();
        if (eFNewL2AdditionalFieldname != '' && eFNewL2AdditionalFieldtype != '' && eFNewL2AdditionalFieldname != 'Type' && eFNewL2AdditionalFieldname != 'Group' && eFNewL2AdditionalFieldname != 'Object_Key' && eFNewL2AdditionalFieldname != 'Key' && eFNewL2AdditionalFieldname != 'Category') {
            switch (eFNewL2AdditionalFieldtype) {
                case 'text':
                    $(this).parent().parent().find('#eFResourcesNewObjectFormNewL2Additional').append('<div class="eFResourcesNewObjectFormNewL2"><div class="eFResourcesNewObjectFormNewL2Fieldname" data-fieldtype="' + eFNewL2AdditionalFieldtype + '">' + eFNewL2AdditionalFieldname + '</div><div class="eFResourcesNewObjectFormNewL2Fieldcontent"><input class="eFinput" type="text" value="" name="' + eFNewL2AdditionalFieldname + '"/><div class="efResourceUnit1DeleteLine">-</div></div></div>');
                    break;
                case 'image':
                    var eFtempFormID = uniqid();
                    var eFthisimagename1 = $(this).parent().parent().find('input[name=Object_Key]').val();
                    //console.log($(this).parent().parent().html());
                    var eFthisimagename2 = eFthisimagename1 + '_IMG_' + eFtempFormID;
                    $(this).parent().parent().find('#eFResourcesNewObjectFormNewL2Additional').append('<div class="eFResourcesNewObjectFormNewL2"><div class="eFResourcesNewObjectFormNewL2Fieldname" data-fieldtype="' + eFNewL2AdditionalFieldtype + '">' + eFNewL2AdditionalFieldname + '</div><div class="eFResourcesNewObjectFormNewL2Fieldcontent"><input class="eFinput" type="text" value="' + eFthisimagename2 + '" name="' + eFNewL2AdditionalFieldname + '" readonly="readonly" /><form id="' + eFtempFormID + '" action="_ajax/eFUploader.php" method="post" enctype="multipart/form-data"><input type="hidden" id="uploadResponseType" name="mimetype" value="html"><input type="hidden" name="effiletype" value="img"><input type="hidden" name="efilmname" value="' + eFthisimagename2 + '"><input type="file" name="hugotest"><input type="submit" value="Upload File"></form><div class="progress"><div class="bar"></div ><div class="percent">0%</div ></div><div class="status"></div><div class="efResourceUnit1DeleteLine">-</div></div>');
                    var bar = $(this).parent().parent().find('#eFResourcesNewObjectFormNewL2Additional .bar');
                    var percent = $(this).parent().parent().find('#eFResourcesNewObjectFormNewL2Additional .percent');
                    var status = $(this).parent().parent().find('#eFResourcesNewObjectFormNewL2Additional .status');

                    $(document).find('form[id=' + eFtempFormID + ']').ajaxForm({
                        beforeSend: function () {
                            console.log("eFEditorV.js #1942");
                            status.empty();
                            var percentVal = '0%';
                            bar.width(percentVal)
                            percent.html(percentVal);
                        },
                        uploadProgress: function (event, position, total, percentComplete) {
                            console.log("eFEditorV.js #1948");
                            var percentVal = percentComplete + '%';
                            bar.width(percentVal)
                            percent.html(percentVal);
                        },
                        complete: function (xhr) {
                            console.log("eFEditorV.js #1954");
                            var uploadstatus = jQuery.parseJSON(xhr.responseText);
                            //console.log(uploadstatus);
                            //status.html(xhr.responseText);
                            //$(document).find('form[id=' + eFtempFormID + ']').parent().find('.status').remove();
                            var oldfilename = $(document).find('form[id=' + eFtempFormID + ']').parent().find('input[class=eFinput]').val();
                            var newfilename = oldfilename + uploadstatus.fileextension;
                            $(document).find('form[id=' + eFtempFormID + ']').parent().find('input[class=eFinput]').val(newfilename);
                            $(document).find('form[id=' + eFtempFormID + ']').parent().find('.progress').remove();
                            var smallheight = Math.round(250 * (uploadstatus.height / uploadstatus.width));
                            $(document).find('form[id=' + eFtempFormID + ']').css('text-align', 'center').html('<img src="_uploads/img_thumbs/' + newfilename + '" />');
                        }
                    });
                    break;
                case 'pdf':
                    var eFtempFormID = uniqid();
                    var eFthisimagename1 = $(this).parent().parent().find('input[name=Object_Key]').val();
                    //console.log($(this).parent().parent().html());
                    var eFthisimagename2 = eFthisimagename1 + '_IMG_' + eFtempFormID;
                    $(this).parent().parent().find('#eFResourcesNewObjectFormNewL2Additional').append('<div class="eFResourcesNewObjectFormNewL2"><div class="eFResourcesNewObjectFormNewL2Fieldname" data-fieldtype="' + eFNewL2AdditionalFieldtype + '">' + eFNewL2AdditionalFieldname + '</div><div class="eFResourcesNewObjectFormNewL2Fieldcontent"><input class="eFinput" type="text" value="' + eFthisimagename2 + '" name="' + eFNewL2AdditionalFieldname + '" readonly="readonly" /><form id="' + eFtempFormID + '" action="_ajax/eFUploader.php" method="post" enctype="multipart/form-data"><input type="hidden" id="uploadResponseType" name="mimetype" value="html"><input type="hidden" name="effiletype" value="pdf"><input type="hidden" name="efilmname" value="' + eFthisimagename2 + '"><input type="file" name="hugotest"><input type="submit" value="Upload File"></form><div class="progress"><div class="bar"></div ><div class="percent">0%</div ></div><div class="status"></div><div class="efResourceUnit1DeleteLine">-</div></div>');
                    var bar = $(this).parent().parent().find('#eFResourcesNewObjectFormNewL2Additional .bar');
                    var percent = $(this).parent().parent().find('#eFResourcesNewObjectFormNewL2Additional .percent');
                    var status = $(this).parent().parent().find('#eFResourcesNewObjectFormNewL2Additional .status');

                    $(document).find('form[id=' + eFtempFormID + ']').ajaxForm({
                        beforeSend: function () {
                            console.log("eFEditorV.js #1985");
                            status.empty();
                            var percentVal = '0%';
                            bar.width(percentVal)
                            percent.html(percentVal);
                        },
                        uploadProgress: function (event, position, total, percentComplete) {
                            console.log("eFEditorV.js #1992");
                            var percentVal = percentComplete + '%';
                            bar.width(percentVal)
                            percent.html(percentVal);
                        },
                        complete: function (xhr) {
                            console.log("eFEditorV.js #1998");
                            var uploadstatus = jQuery.parseJSON(xhr.responseText);
                            //console.log(uploadstatus);
                            //status.html(xhr.responseText);
                            //$(document).find('form[id=' + eFtempFormID + ']').parent().find('.status').remove();
                            var oldfilename = $(document).find('form[id=' + eFtempFormID + ']').parent().find('input[class=eFinput]').val();
                            var newfilename = oldfilename + uploadstatus.fileextension;
                            $(document).find('form[id=' + eFtempFormID + ']').parent().find('input[class=eFinput]').val(newfilename);
                            $(document).find('form[id=' + eFtempFormID + ']').parent().find('.progress').remove();
                            var smallheight = Math.round(250 * (uploadstatus.height / uploadstatus.width));
                            $(document).find('form[id=' + eFtempFormID + ']').css('text-align', 'center').html('<img src="_img/pdf-icon.png" />');
                        }
                    });
                    break;
            }
        }
    });
    $(document).on('click', '.efResourceUnit1DeleteLine', function () {
        console.log("eFEditorV.js #2016");
        $(this).parent().parent().remove();
    });

    /****************  L2 PopDown **********************************/
    $(document).on('click', '.eFResourcesNewObjectFormNewL2Fieldcontent .eFinput', function () {
        console.log("eFEditorV.js #2022");
        $('.eFResourcesNewObjectFormNewL2Fieldcontent .eFinput').attr('data-tiptabstatus', '');
        $(this).attr('data-tiptabstatus', 'active');
        var position = $(this).offset();
        var position2 = $(this).position();
        var eFPopWeite = $(this).width() + 2;

        var eFResL2ContPopDownSearch = $(this).attr('name');
        if (eFResL2ContPopDownSearch == 'Type' || eFResL2ContPopDownSearch == 'Category' || eFResL2ContPopDownSearch == 'Object_Key') {
        }
        else {
            $('#efResourceUnitNewContainerPopDownContent').load('_ajax/eFEditorVResourcesContentNewPopDown.php?eFResL2ContPopDownSearch=' + eFResL2ContPopDownSearch + '&uniquid=' + uniqid());
            $('#efResourceUnitNewContainerPopDown').css('top', position.top - 30 + 'px').css('left', position2.left + 11 + 'px').css('width', eFPopWeite + 2 + 'px').show();
        }
    }).on('keyup', '.eFResourcesNewObjectFormNewL2Fieldcontent .eFinput', function () {
        console.log("eFEditorV.js #2038");
        //Tabellenfilter
        if (event.keyCode == 27 || $(this).val() == '') {
            //esc löscht den filter
            $(this).val('');
            //Alle sichtbar machen, da nichts im Filter steht
            $(document).find('#efResourceUnitNewContainerPopDownContent').find('tbody tr').removeClass('visible').show().addClass('visible');

        }
        //Wenn Input vorhanden, dann Filtern
        else {
            filterPopDown($('#efResourceUnitNewContainerPopDownContent').find('tbody tr'), $(this).val());
        }
    }).on('click', '.eFTipTabCell', function () {
        console.log("eFEditorV.js #2053");
				var eFTipTabInserter = $(this).html();        
        $(document).find('.eFResourcesNewObjectFormNewL2Fieldcontent .eFinput[data-tiptabstatus=active]').val(eFTipTabInserter);
        $(document).find('#efResourceUnitNewContainerPopDownContent').empty();
        $(document).find('#efResourceUnitNewContainerPopDown').hide();
    });

    $(document).on('click', '#efResourceUnitNewContainerPopDownClose', function () {
        console.log("eFEditorV.js #2063");
        $(this).parent().find('#efResourceUnitNewContainerPopDownContent').empty();
        $(this).parent().hide();

    });

    /**************** Save L1 & L2 Object **********************************/
    $(document).on('click', '#efResourceUnitNewContainerSave', function () {
        console.log("eFEditorV.js #2074");
        //eFNewObjektL1L2Array = $(this).parent().find('#eFResourcesNewObjectFormForm').serialize();
        var eFNewObjektL1L2_Array = '';
        $(this).parent().find('.eFResourcesNewObjectFormNewL2').each(function () {
            var eFFieldnameL1L2 = $(this).find('.eFResourcesNewObjectFormNewL2Fieldname').html();
            var eFFieldtypeL1L2 = $(this).find('.eFResourcesNewObjectFormNewL2Fieldname').attr('data-fieldtype');
            var eFFieldcontentL1L2 = $(this).find('input.eFinput').val();
            var originalName = $(this).find('input.eForiginal').val();
            //console.log( eFFieldnameL1L2 + '|' + eFFieldtypeL1L2 + '|' + eFFieldcontentL1L2 );
            eFNewObjektL1L2_Array += '|Fieldname:' + eFFieldnameL1L2 + ',Fieldtype:' + eFFieldtypeL1L2 + ',Fieldcontent:' + eFFieldcontentL1L2 + ',originalName:' + originalName;

        });
        //console.log(eFNewObjektL1L2_Array);
        $.ajax({
            async: false,
            type: "GET",
            url: "_ajax/eFEditorVResourcesContentSaveNew.php",
            data: 'eFNewObjektL1L2_Array=' + encodeURI(eFNewObjektL1L2_Array) + '&uniqid=' + uniqid(),
            success: function () {
                var eFContentSelectedD = encodeURI($('#eFResourcesSelect ul li.eFResSelected').attr('data-content'));
                var eFContentKatD = encodeURI($('#eFResourcesSelect ul li.eFResSelected').attr('data-kat'));
                $('#eFResourcesContent').empty().load('_ajax/eFEditorVResourcesContent.php?eFContentSelected=' + eFContentSelectedD + '&eFContentKat=' + eFContentKatD + '&uniquid=' + uniqid());
            },
            cache: false
        });
    });

    /************* Coverage Landmarks ****************************************/
    // eFEditorVResourcesContentCoverageLandmarksNewEditDelete.php

    $(document).on('click', '#locationPickerMapResourcesLandmarkAdd', function () {
        console.log("eFEditorV.js #2109");
        var eFNewObjektRCL = $(this).parent().serialize();
        eFNewObjektRCL += '&eFResourcesCLMode=NewLandmark&uniqid=' + uniqid();
        //console.log(eFNewObjektRCL);
        var LMK_Name = $.trim($(this).parent().parent().find('#eFLPMRFormInput input[name=Landmark_Name]').val());

        if (LMK_Name == '' || LMK_Name == ' ' || LMK_Name.length < 3) {
            $(this).parent().parent().find('#eFLPMRFormInput input[name=Landmark_Name]').addClass('wrong');
        }
        else {
            $(this).parent().parent().find('#eFLPMRFormInput input[name=Landmark_Name]').removeClass('wrong');
            $.ajax({
                //async: false,
                type: "GET",
                url: "_ajax/eFEditorVResourcesContentCoverageLandmarksNewEditDelete.php",
                data: eFNewObjektRCL,
                success: function () {
                    console.log("eFEditorV.js #2127");
                    var eFContentSelectedD = encodeURI($('#eFResourcesSelect ul li.eFResSelected').attr('data-content'));
                    var eFContentKatD = encodeURI($('#eFResourcesSelect ul li.eFResSelected').attr('data-kat'));
                    $('#eFResourcesContent').empty().load('_ajax/eFEditorVResourcesContent.php?eFContentSelected=' + eFContentSelectedD + '&eFContentKat=' + eFContentKatD + '&uniquid=' + uniqid());
                },
                cache: false
            });
        }
    });

    $(document).on('click', '#eFLPMRFormInput input[name=Group]', function () {
        console.log("eFEditorV.js #2142");
        var position = $(this).offset();
        var position2 = $(this).position();
        var eFPopWeite = $(this).width() + 2;
        var eFResL2ContPopDownSearch = $(this).attr('name');
        $('#efResourceUnitNewContainerPopDownContent').load('_ajax/eFEditorVResourcesContentNewPopDown.php?eFResL2ContPopDownSearch=' + eFResL2ContPopDownSearch + '&uniquid=' + uniqid())
        $('#locationPickerMapResourcesLandmarkGroupTip').css('top', position.top - 33 + 'px').css('left', position.left - 10 + 'px').css('width', eFPopWeite + 'px').show();

    }).on('keyup', '#eFLPMRFormInput input[name=Group]', function () {
        console.log("eFEditorV.js #2151");
        //Tabellenfilter
        //console.log($(this).parent().html());
        if (event.keyCode == 27 || $(this).val() == '') {
            //esc löscht den filter
            $(this).val('');
            //Alle sichtbar machen, da nichts im Filter steht
            $('#efResourceUnitNewContainerPopDownContent').find('tbody tr').removeClass('visible').show().addClass('visible');
        }
        //Wenn Input vorhanden, dann Filtern
        else {
            filterPopDown($('#efResourceUnitNewContainerPopDownContent').find('tbody tr'), $(this).val());
        }
    }).on('click', '.eFTipTabCell', function () {
        console.log("eFEditorV.js #2165");
        //console.log($(this).html());
        var eFTipTabInserter = $(this).html();
        $('#eFLPMRFormInput input[name=Group]').val(eFTipTabInserter);
        $(document).find('#efResourceUnitNewContainerPopDownContent').empty();
        $(document).find('#locationPickerMapResourcesLandmarkGroupTip').hide();
    });
    /************* Relations ****************************************/
    $(document).on('click', '.efResourceUnit2linkscontainerNewRelation', function () {
        console.log("eFEditorV.js #2174");
        $('#eFResourcesFilterContainer input[name=eFResourcesFilterInput]').attr('data-filterregion', 'relations');
        $('#eFResourcesRelationAddContainer').show();
        $('.efResourceUnit2linkscontainer').removeAttr('style');
        $(this).parent().css('background-image', 'url(_img/lightblue-square-40-percent.png)');
        $('.efResourceUnit1').hide();
        $(this).parent().parent().show();
        $(this).html('x').css('background-image', 'url(_img/white-square-30-percent.png)').attr('data-close', 'yes');
        var eFRelIDA = $(this).attr('data-idl1');
        $('#eFResourcesRelationAddContainer').load('_ajax/eFEditorVResourcesRelationsContent.php?eFRelIDA=' + eFRelIDA + '&uniquid=' + uniqid())
    });

    $(document).on('click', '.efResourceUnit2linkscontainerNewRelation[data-close=yes]', function () {
        console.log("eFEditorV.js #2193");
        $('#eFResourcesFilterContainer input[name=eFResourcesFilterInput]').attr('data-filterregion', 'self');
        $('#eFResourcesRelationAddContainer').hide();
        $('.efResourceUnit2linkscontainer').removeAttr('style');
        $('.efResourceUnit1').show();
        $(this).html('+').removeAttr('style').removeAttr('data-close');
        $('#eFResourcesSubContent').scrollTo('.efResourceUnit1[data-idl1=' + $(this).parent().parent().attr('data-idl1') + ']');
    });
//NEW
    $(document).on('click', '.efResourceUnit1RelationsAdd', function () {
        console.log("eFEditorV.js #2203");
        var ID_R_L1_A = $(this).attr('data-efrelida');
        var ID_R_L1_B = $(this).attr('data-efrelidb');
        var RelationType = $(this).parent().find('select[name=eFResRelType]').val();
        var RelationRemark = encodeURI($(this).parent().find('input[name=eFResRelRef]').val());
        if (RelationType != '') {
            $.ajax({
                type: "POST",
                url: "_ajax/eFEditorVResourcesRelationsSaveNew.php",
                data: 'ID_R_L1_A=' + ID_R_L1_A + '&ID_R_L1_B=' + ID_R_L1_B + '&RelationType=' + RelationType + '&RelationRemark=' + RelationRemark + '&uniquid=' + uniqid(),
                success: function () {
                    console.log("eFEditorV.js #2217");
                    $(document).find('.efResourceUnit2linkscontainerContent[data-idl1=' + ID_R_L1_A + ']').load('_ajax/eFEditorVResourcesRelationsRefresh.php?ID_R_L1=' + ID_R_L1_A + '&uniquid=' + uniqid());

                },
                cache: false
            });
        }
    });
//delete
    $(document).on('click', '.efResourceUnit2linkscontainerContentEContentContainerDel', function () {
        console.log("eFEditorV.js #2227");
        var eFRelDelId = $(this).attr('data-id_r_relationindex');
        var RefID = $(this).attr('data-idl1');
        $.ajax({
            type: "POST",
            url: "_ajax/eFEditorVResourcesRelationsDelete.php",
            data: 'eFRelDelId=' + eFRelDelId + '&uniquid=' + uniqid(),
            success: function () {
                console.log("eFEditorV.js #2235");
                $(document).find('.efResourceUnit1[data-idl1=' + RefID + '] .efResourceUnit2linkscontainerContentEContainer[data-ID_R_RelationIndex=' + eFRelDelId + ']').hide();
            },
            cache: false
        });
    });
    function filterPopDown(inputtext, anfrage) {
        console.log("eFEditorV.js -filterPopDown()");
        anfrage = $.trim(anfrage); //white spaces raus
        anfrage = anfrage.replace(/ /gi, '|'); // Leerzeichen wird OR für regex suche
        $(inputtext).each(function () {
            ($(this).text().search(new RegExp(anfrage, "i")) < 0) ? $(this).hide().removeClass('visible') : $(this).show().addClass('visible');
        });
    };

    /*********** /EX eFEditorVResources.js ***************************/

    /* eFEditorVConfig */
    $(document).on('click', '#eFConfigSelect ul li.content', function () {
        console.log("eFEditorV.js #2274");
        var eFContentSelected = encodeURI($(this).attr('data-content'));
        var eFContentKat = encodeURI($(this).attr('data-kat'));
        $('#eFConfigSelect ul li.content').removeClass('eFResSelected');
        $(this).addClass('eFResSelected');
        $('#eFConfigContent').load('_ajax/eFEditorVConfigContent.php?eFContentSelected=' + eFContentSelected + '&eFContentKat=' + eFContentKat + '&uniquid=' + uniqid());
    });

    $(document).on('click', '#eFConfigUsersList .eFConfigUserListEntry', function () {
        console.log("eFEditorV.js #2283");
        var eFIDCUSERS = encodeURI($(this).attr('data-idcusers'));
        $('#eFConfigUsersList .eFConfigUserListEntry').removeAttr('style');
        if ($(this).hasClass("eFConfigUserListEntrySelf")) {
            $(this).css('background-image', 'url(../_img/orange-square-50-percent.png)');
        }
        else {
            $(this).css('background-image', 'url(../_img/lightblue-square-50-percent.png)');
        }
        $('#eFConfigAccessUsersDetails').show().load('_ajax/eFEditorVConfigContentUserView.php?idcusers=' + eFIDCUSERS + '&uniquid=' + uniqid());
    });


    /*********** eFEditorVConfig ***************************/
    /* General Functions */
    /* Unique ID */
    function uniqid() {
        console.log("eFEditorV.js -uniqid()");
        var newDate = new Date;
        return newDate.getTime();
    }

//Initialpositionierung Movie
    /* Movie Statics */
    function initialPosMainMovie() {
        console.log("eFEditorV.js -initialPosMainMovie()");
        var eFPosModus = $('#eFMovieContainer').attr('data-efposmodus');


        if (eFPosModus == 'movie') {
            var Mweite1 = $('#eFMovieContainer').innerWidth();
            var Mhoehe1 = $('#eFMovieContainer').innerHeight();
        }
        else {
            var Mweite1 = $('#eFMovieContainer').innerWidth() / 2;
            var Mhoehe1 = $('#eFMovieContainer').innerHeight() - 107;
        }
        var ContainerSeitneverh1 = Mweite1 / Mhoehe1;
        if (ContainerSeitneverh1 <= Seitenverh) {
            var MgrW1 = Mweite1 - 20;
            var MgrH1 = MgrW1 / Seitenverh;
        }
        else {
            var MgrH1 = Mhoehe1 - 20;
            var MgrW1 = MgrH1 * Seitenverh;
        }


        var RandOben1 = (Mhoehe1 - MgrH1) / 2;
        var RandLinks1 = (Mweite1 - MgrW1) / 2;
        $('#videoAktuell').css('margin-top', RandOben1);
        $('#videoAktuell').css('margin-left', RandLinks1);
        $('#videoAktuell').height(MgrH1 + 'px');
        $('#videoAktuell').width(MgrW1 + 'px');
    }

});

function sendPasswordReset(id) {
    var fd = new FormData();
    fd.append('id', id);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '_ajax/sendEmailReminder.php');
    xhr.send(fd);
    alert('sent email');
}

function showNewUserForm() {
    if (document.getElementById('newUserForm') == null) {
        var divForm = document.createElement("DIV");
        divForm.setAttribute("id", "newUserForm");
        divForm.style.cssText = 'position: absolute; height: 300px; width: 400px; margin: 0px 20px; background-color: #ffffff; border: 1px solid #000000;';
        divForm.innerHTML = "<center><br>Add a New User<br>&nbsp;</center><input type='text' id='newUserName' value='' placeholder='Name' style='height: 20px; width: 375px; margin-left: 10px; margin-top: 5px;'><br><input type='text' id='newUserNickname' value='' placeholder='Nick Name' style='height: 20px; width: 375px; margin-left: 10px; margin-top: 5px;'><br><input type='text' id='newUserEmail' value='' placeholder='Email' style='height: 20px; width: 375px; margin-left: 10px; margin-top: 5px;'><br><center><br>Rights Config &nbsp; <input type='radio' name='newUserRights' id='newUserRightsNone' value='NONE'> NONE &nbsp; <input type='radio' name='newUserRights' id='newUserRightsEdit' value='EDIT'> EDIT</center><center><br>Rights Resources &nbsp; <input type='radio' name='newUserResourceRights' id='newUserResourceRightsNone' value='NONE'> NONE &nbsp; <input type='radio' name='newUserResourceRights' id='newUserResourceRightsEdit' value='EDIT'> EDIT</center><p style='padding: 10px;'>When a new user is added to the system a random password will be created for their account and they will be sent a password reset email.</p><center><input type='submit' name='cancel' value='Cancel' onclick='closeNewUserForm();'> &nbsp; <input type='submit' name='submit' value='Submit' onclick='processNewUserForm(self);'></center>";
        document.getElementById('eFConfigAccessUsersList').appendChild(divForm);
    }
}

function closeNewUserForm() {
    document.getElementById('eFConfigAccessUsersList').removeChild(document.getElementById('newUserForm'));
}

function processNewUserForm(id) {
    var name = document.getElementById('newUserName').value;
    var nickname = document.getElementById('newUserNickname').value;
    var email = document.getElementById('newUserEmail').value;
    var configRightsNone = document.getElementById('newUserRightsNone');
    var configRightsEdit = document.getElementById('newUserRightsEdit');
    var configRights = document.getElementById('newUserRights');
    if (configRightsNone.checked) {
        configRights = 'NONE';
    } else {
        configRights = 'EDIT';
    }
    var resourceRightsNone = document.getElementById('newUserResourceRightsNone');
    var resourceRightsEdit = document.getElementById('newUserResourceRightsEdit');
    var resourceRights;
    if (resourceRightsNone.checked) {
        resourceRights = 'NONE';
    } else {
        resourceRights = 'EDIT';
    }
    closeNewUserForm();
    var fd = new FormData();
    fd.append('name', name);
    fd.append('nickname', nickname);
    fd.append('email', email);
    fd.append('configRights', configRights);
    fd.append('resourceRights', resourceRights);
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            // When user is created, take returned ID and send
            // an email reset request.
//            alert(xhr.responseText);
            if (xhr.responseText != '' && xhr.responseText != 'user exists' && xhr.responseText != 'bad data') {
                var fd2 = new FormData();
                fd2.append('id', xhr.responseText);
                var xhr2 = new XMLHttpRequest();
                xhr2.open('POST', '_ajax/sendEmailReminder.php');
                xhr2.send(fd2);
                alert('New user created!');
                $('#eFConfigContent').load('_ajax/eFEditorVConfigContent.php?eFContentSelected=Access&eFContentKat=Users&uniquid=' + uniqid());
            } else {
                alert('There was a problem creating this user.  Make sure the user does not already exist and that you have entered all of the data in the form.');
            }
        }
    }
    xhr.open('POST', '_ajax/createNewUser.php');
    xhr.send(fd);
}

function deleteUser(id) {
    var continueWithDelete = confirm('Are you sure you want to delete this user?')
    if (continueWithDelete) {
        var fd = new FormData();
        fd.append('id', id);
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                // When user is created, take returned ID and send
                // an email reset request.
                if (xhr.responseText == 'user deleted') {
                    alert('User Deleted!');
                    $('#eFConfigContent').load('_ajax/eFEditorVConfigContent.php?eFContentSelected=Access&eFContentKat=Users&uniquid=' + uniqid());
                } else {
                    alert('There was a problem deleting this user.  Please check with your system administrator.\nError:' + xhr.responseText);
                }
            }
        }
        xhr.open('POST', '_ajax/deleteUser.php');
        xhr.send(fd);
    }
}

function showEditUserForm(id, name, nickname, email) {
    if (document.getElementById('newUserForm') == null) {
        var divForm = document.createElement("DIV");
        divForm.setAttribute("id", "newUserForm");
        divForm.style.cssText = 'position: absolute; height: 180px; width: 400px; margin: 0px 20px; background-color: #ffffff; border: 1px solid #000000; z-index: ';
        divForm.innerHTML = "<center><br>Edit User<br>&nbsp;</center><input type='text' id='editUserName' value='" + name + "' placeholder='Name' style='height: 20px; width: 375px; margin-left: 10px; margin-top: 5px;'><br><input type='text' id='editUserNickname' value='" + nickname + "' placeholder='Nick Name' style='height: 20px; width: 375px; margin-left: 10px; margin-top: 5px;'><br><input type='text' id='editUserEmail' value='" + email + "' placeholder='Email' style='height: 20px; width: 375px; margin-left: 10px; margin-top: 5px;'><br><input type='hidden' value='" + id + "' id='editUserId'><br><center><input type='submit' name='cancel' value='Cancel' onclick='closeNewUserForm();'> &nbsp; <input type='submit' name='submit' value='Save' onclick='processEditUserForm(self);'></center>";
        document.getElementById('eFConfigAccessUsersList').appendChild(divForm);
    }
}

function processEditUserForm(id) {
    var id = document.getElementById('editUserId').value;
    var name = document.getElementById('editUserName').value;
    var nickname = document.getElementById('editUserNickname').value;
    var email = document.getElementById('editUserEmail').value;
    closeNewUserForm();
    var fd = new FormData();
    fd.append('id', id);
    fd.append('name', name);
    fd.append('nickname', nickname);
    fd.append('email', email);
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.responseText == 'success') {
                alert('Changes Saved!');
                $('#eFConfigContent').load('_ajax/eFEditorVConfigContent.php?eFContentSelected=Access&eFContentKat=Users&uniquid=' + uniqid());
            } else {
                alert('There was a problem editing this user.  Make sure you have rights to edit this user account and that you entered valid data.');
            }
        }
    }
    xhr.open('POST', '_ajax/editUser.php');
    xhr.send(fd);
}