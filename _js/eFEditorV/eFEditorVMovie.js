$(document).ready(function () {
    console.log("eFEditorVMovie.js #1");
    /**************** Browser Detection **********************/
    var BrowserDetect = {
        init: function () {
            console.log("eFEditorVMovie.js #5");
            this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
            this.version = this.searchVersion(navigator.userAgent)
                    || this.searchVersion(navigator.appVersion)
                    || "an unknown version";
            this.OS = this.searchString(this.dataOS) || "an unknown OS";
        },
        searchString: function (data) {
            console.log("eFEditorVMovie.js #13");
            for (var i = 0; i < data.length; i++) {
                var dataString = data[i].string;
                var dataProp = data[i].prop;
                this.versionSearchString = data[i].versionSearch || data[i].identity;
                if (dataString) {
                    if (dataString.indexOf(data[i].subString) != -1)
                        return data[i].identity;
                }
                else if (dataProp)
                    return data[i].identity;
            }
        },
        searchVersion: function (dataString) {
            console.log("eFEditorVMovie.js #27");
            var index = dataString.indexOf(this.versionSearchString);
            if (index == -1)
                return;
            return parseFloat(dataString.substring(index + this.versionSearchString.length + 1));
        },
        dataBrowser: [
            {
                string: navigator.userAgent,
                subString: "Chrome",
                identity: "Chrome"
            },
            {string: navigator.userAgent,
                subString: "OmniWeb",
                versionSearch: "OmniWeb/",
                identity: "OmniWeb"
            },
            {
                string: navigator.vendor,
                subString: "Apple",
                identity: "Safari",
                versionSearch: "Version"
            },
            {
                prop: window.opera,
                identity: "Opera",
                versionSearch: "Version"
            },
            {
                string: navigator.vendor,
                subString: "iCab",
                identity: "iCab"
            },
            {
                string: navigator.vendor,
                subString: "KDE",
                identity: "Konqueror"
            },
            {
                string: navigator.userAgent,
                subString: "Firefox",
                identity: "Firefox"
            },
            {
                string: navigator.vendor,
                subString: "Camino",
                identity: "Camino"
            },
            {// for newer Netscapes (6+)
                string: navigator.userAgent,
                subString: "Netscape",
                identity: "Netscape"
            },
            {
                string: navigator.userAgent,
                subString: "MSIE",
                identity: "Explorer",
                versionSearch: "MSIE"
            },
            {
                string: navigator.userAgent,
                subString: "Gecko",
                identity: "Mozilla",
                versionSearch: "rv"
            },
            {// for older Netscapes (4-)
                string: navigator.userAgent,
                subString: "Mozilla",
                identity: "Netscape",
                versionSearch: "Mozilla"
            }
        ],
        dataOS: [
            {
                string: navigator.platform,
                subString: "Win",
                identity: "Windows"
            },
            {
                string: navigator.platform,
                subString: "Mac",
                identity: "Mac"
            },
            {
                string: navigator.userAgent,
                subString: "iPhone",
                identity: "iPhone/iPod"
            },
            {
                string: navigator.platform,
                subString: "Linux",
                identity: "Linux"
            }
        ]

    };
    BrowserDetect.init();

    $('#eFMovieRangeInputContainer').html('<input type="range" id="eFTimerunner" name="eFTimerunner" min="0" max="" value="0" />');
    /* video als jQuery $Media Instanz laden */
    video = $.media('#videoAktuell');
    /* Video Lade Progress */

    video.bind('progress', function () {
        efilmvideoloaded();
    });

    function efilmvideoloaded() {
        var v = document.getElementById('videoAktuell');
        var r = v.buffered;
        var total = v.duration;

        var start = r.start(0);
        var end = r.end(0);
        $("#videoaktuellprogressbar").progressbar({value: (end / total) * 100});
    }

    /* Basis Variablen setzen */
    /* Movie ID setzen */
    var movie_id = $("#efMCVMovieID").html();
    /* FPS setzen */
    var fps = $("#efMCVMovieFPS").html();
    /* FORMAT */
    OriginalFormat = $(".eFMovieSelectCSelected").attr('data-format');
    /* Vars setzen */
    video.totalTime(function (duration) {
        console.log("eFEditorVMovie.js #173");
        framecount = duration * fps;
        framecountFixed = Floor(framecount, 0) - 1;
        $('#efMovieControllVars').append('<div id="eFtotaltime">' + duration + '</div>');
        $('#efMovieControllVars').append('<div id="eFframecount">' + framecountFixed + '</div>');
        $('#videoAktuell').attr('data-totaltime', duration);
        $('#videoAktuell').attr('data-framecount', framecountFixed + 1);
    });
    $('#videoAktuell').attr('data-eFTimerunnerActiveState', 'false');
    $('#videoAktuell').attr('data-eFPossibleFramesCount', '');
    $('#videoAktuell').attr('data-fps', fps);
    $('#efMovieControllVars').append('<div id="eFTimerunnerActiveState">false</div>');
    $('#efMovieControllVars').append('<div id="eFPossibleFramesCount"></div>');
    eFtotaltime = $("#eFtotaltime").html();
    eFframecount = $("#eFframecount").html();

    /* Movie Speedchange */
    // 24 aktiv setzen
    $("#eFMovieControlsContainer .efMovieSpeedContainers:contains('" + fps + "')").toggleClass("efMovieSpeedContainersActive");
    $("#eFMovieControlsContainer .efMovieSpeedContainers").click(function () {
        $("#eFMovieControlsContainer .efMovieSpeedContainers").removeClass("efMovieSpeedContainersActive");
        $(this).toggleClass("efMovieSpeedContainersActive");
        var eFPlaybackSpeed = $(this).html() / fps;
        video.prop('playbackRate', eFPlaybackSpeed);
    });

    /* Movie Dynamics */
    /** Direkte JS Ansteuerung **/
    var mediaElement = document.getElementById('videoAktuell');
    video.bind('timeupdate', function () {
        console.log("eFEditorVMovie.js #213");
        /* Timecodes in Zieldivs schreiben ************************************************/
        var eFcurrtime = video.time();
        var eFcurrtimeHMS = video.time().secondsTo('hh:mm:ss');
        //var eFcurrtimeSMPTE = secondsToTimecode(eFcurrtime, fps);
        var eFcurrtimeSMPTENEW = secondsToTimecodeNEW(eFcurrtime, fps);
        //Browserweiche
        if (BrowserDetect.browser == 'Safari' && BrowserDetect.version > 5.1) {
            var eFcurrtimeFPS = pad(Round((eFcurrtime * fps), 0), 6);
            var eFcurrtimeFPSn0 = Round((eFcurrtime * fps), 0);
        }
        else {
            var eFcurrtimeFPS = pad(Floor((eFcurrtime * fps), 0), 6);
            var eFcurrtimeFPSn0 = Floor((eFcurrtime * fps), 0);
        }
        /* JS Timestamp */
        var eFcurrtimeJS = mediaElement.currentTime;
        var eFcurrtimeJSRND = Round(eFcurrtimeJS, 10);
        /* Float */
        $('#eFControlDataMovieTimecodeContainerFLOAT').html(eFcurrtimeJSRND);
        //$('#eFControlDataMovieTimecodeContainerFLOAT').html(eFcurrtime);
        /* HH:MM:SS */
        $('#eFControlDataMovieTimecodeContainerHHMMSS').html(eFcurrtimeHMS);
        /* SMPTE */
        $('#eFControlDataMovieTimecodeContainerSMPTE').html(eFcurrtimeSMPTENEW);
        /* Frames */
        $('#eFControlDataMovieTimecodeContainerFPS').html(eFcurrtimeFPS);
        /*Basis für Längenangaben*/
        var LengthParameter = new Array();

        LengthParameter["S8mm"] = "4.234";
        LengthParameter["N8mm"] = "3.8025";
        LengthParameter["9.5mm"] = "7.5415";
        LengthParameter["16mm"] = "7.605";
        LengthParameter["35mm"] = "19.000";
        LengthParameter["35mm/3Perf"] = "14.250";
        LengthParameter["35mm/2Perf"] = "9.5";
        LengthParameter["65mm"] = "23.750";
        LengthParameter["IMAX"] = "71.250";


        eFcurrtimeMETER = Math.round((eFcurrtimeFPS * LengthParameter[OriginalFormat] / 1000) * 100) / 100;
        eFcurrtimeFOOT = Math.round((eFcurrtimeMETER * (1 / 0.30481)) * 10) / 10;

        console.log("eFEditorVMovie.js #258");

        /* METER */
        $('#eFControlDataMovieTimecodeContainerMETER').html(eFcurrtimeMETER);
        /* FEET */
        $('#eFControlDataMovieTimecodeContainerFEET').html(eFcurrtimeFOOT);

        /* Timeline Balken Dynamics ******************************************************/
        var eFTimerunnerS = $("#eFTimerunner").data("rangeinput");
        var eFTimerunnerActiveState = $('#eFTimerunnerActiveState').html();
        if (eFTimerunnerActiveState == "false") {
            if (isNaN(eFcurrtimeFPSn0) == false) {
                eFTimerunnerS.setValue(eFcurrtimeFPSn0);
            }
            else {
                eFTimerunnerS.setValue('0');
            }
        }
        else {
        }

        /* Einzelframes Anzeige **********************************************************/
        /** Neuberechnung vom aktuellen Frame nach JS Standard **/
        var eFcurrtimeJSTimeline = mediaElement.currentTime;
        var eFcurrtimeJSFPSTimeline = pad(Floor((eFcurrtimeJSTimeline / (1 / fps)), 0), 6);

        console.log("eFEditorVMovie.js #311");
        //Das scheint in Chrome zu funktionieren ... => Browswerweiche einbauen und für Chrome Floor statt Round
        $('#eFTimelineContainerTableActual').html(eFcurrtimeFPS);

        eFServerChoiceURLPrefix = storeURL+"/";

        $('#eFTimelineContainerAFrame').css('background-image', 'url("' + eFServerChoiceURLPrefix + '_media/shots/' + $("#efMCVMovieID").html() + '/' + eFcurrtimeFPS + '.jpg")');
        var eFMovieTotalFrames = $("#eFframecount").html();
        console.log("eFEditorVMovie.js #351");

        /* -10 Frames */
        if (eFcurrtimeFPSn0 > 9) {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(1)").html(pad(eFcurrtimeFPSn0 - 10, 6));
            $("#eFTimelineContainerTableFramePics td:nth-child(1)").css('background-image', 'url("' + eFServerChoiceURLPrefix + '_media/shots/' + $("#efMCVMovieID").html() + '/' + pad((eFcurrtimeFPS - 10), 6) + '.jpg")').attr('name', (eFcurrtimeFPS - 10));
        } else {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(1)").html('');
            $("#eFTimelineContainerTableFramePics td:nth-child(1)").removeAttr('style');
        }
        if (eFcurrtimeFPSn0 > 8) {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(2)").html(pad(eFcurrtimeFPSn0 - 9, 6));
            $("#eFTimelineContainerTableFramePics td:nth-child(2)").css('background-image', 'url("' + eFServerChoiceURLPrefix + '_media/shots/' + $("#efMCVMovieID").html() + '/' + pad((eFcurrtimeFPS - 9), 6) + '.jpg")').attr('name', (eFcurrtimeFPS - 9));
        } else {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(2)").html('');
            $("#eFTimelineContainerTableFramePics td:nth-child(2)").removeAttr('style');
        }
        if (eFcurrtimeFPSn0 > 7) {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(3)").html(pad(eFcurrtimeFPSn0 - 8, 6));
            $("#eFTimelineContainerTableFramePics td:nth-child(3)").css('background-image', 'url("' + eFServerChoiceURLPrefix + '_media/shots/' + $("#efMCVMovieID").html() + '/' + pad((eFcurrtimeFPS - 8), 6) + '.jpg")').attr('name', (eFcurrtimeFPS - 8));
        } else {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(3)").html('');
            $("#eFTimelineContainerTableFramePics td:nth-child(3)").removeAttr('style');
        }
        if (eFcurrtimeFPSn0 > 6) {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(4)").html(pad(eFcurrtimeFPSn0 - 7, 6));
            $("#eFTimelineContainerTableFramePics td:nth-child(4)").css('background-image', 'url("' + eFServerChoiceURLPrefix + '_media/shots/' + $("#efMCVMovieID").html() + '/' + pad((eFcurrtimeFPS - 7), 6) + '.jpg")').attr('name', (eFcurrtimeFPS - 7));
        } else {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(4)").html('');
            $("#eFTimelineContainerTableFramePics td:nth-child(4)").removeAttr('style');
        }
        if (eFcurrtimeFPSn0 > 5) {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(5)").html(pad(eFcurrtimeFPSn0 - 6, 6));
            $("#eFTimelineContainerTableFramePics td:nth-child(5)").css('background-image', 'url("' + eFServerChoiceURLPrefix + '_media/shots/' + $("#efMCVMovieID").html() + '/' + pad((eFcurrtimeFPS - 6), 6) + '.jpg")').attr('name', (eFcurrtimeFPS - 6));
        } else {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(5)").html('');
            $("#eFTimelineContainerTableFramePics td:nth-child(5)").removeAttr('style');
        }
        if (eFcurrtimeFPSn0 > 4) {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(6)").html(pad(eFcurrtimeFPSn0 - 5, 6));
            $("#eFTimelineContainerTableFramePics td:nth-child(6)").css('background-image', 'url("' + eFServerChoiceURLPrefix + '_media/shots/' + $("#efMCVMovieID").html() + '/' + pad((eFcurrtimeFPS - 5), 6) + '.jpg")').attr('name', (eFcurrtimeFPS - 5));
        } else {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(6)").html('');
            $("#eFTimelineContainerTableFramePics td:nth-child(6)").removeAttr('style');
        }
        if (eFcurrtimeFPSn0 > 3) {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(7)").html(pad(eFcurrtimeFPSn0 - 4, 6));
            $("#eFTimelineContainerTableFramePics td:nth-child(7)").css('background-image', 'url("' + eFServerChoiceURLPrefix + '_media/shots/' + $("#efMCVMovieID").html() + '/' + pad((eFcurrtimeFPS - 4), 6) + '.jpg")').attr('name', (eFcurrtimeFPS - 4));
        } else {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(7)").html('');
            $("#eFTimelineContainerTableFramePics td:nth-child(7)").removeAttr('style');
        }
        if (eFcurrtimeFPSn0 > 2) {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(8)").html(pad(eFcurrtimeFPSn0 - 3, 6));
            $("#eFTimelineContainerTableFramePics td:nth-child(8)").css('background-image', 'url("' + eFServerChoiceURLPrefix + '_media/shots/' + $("#efMCVMovieID").html() + '/' + pad((eFcurrtimeFPS - 3), 6) + '.jpg")').attr('name', (eFcurrtimeFPS - 3));
        } else {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(8)").html('');
            $("#eFTimelineContainerTableFramePics td:nth-child(8)").removeAttr('style');
        }
        if (eFcurrtimeFPSn0 > 1) {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(9)").html(pad(eFcurrtimeFPSn0 - 2, 6));
            $("#eFTimelineContainerTableFramePics td:nth-child(9)").css('background-image', 'url("' + eFServerChoiceURLPrefix + '_media/shots/' + $("#efMCVMovieID").html() + '/' + pad((eFcurrtimeFPS - 2), 6) + '.jpg")').attr('name', (eFcurrtimeFPS - 2));
        } else {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(9)").html('');
            $("#eFTimelineContainerTableFramePics td:nth-child(9)").removeAttr('style');
        }
        if (eFcurrtimeFPSn0 > 0) {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(10)").html(pad(eFcurrtimeFPSn0 - 1, 6));
            $("#eFTimelineContainerTableFramePics td:nth-child(10)").css('background-image', 'url("' + eFServerChoiceURLPrefix + '_media/shots/' + $("#efMCVMovieID").html() + '/' + pad((eFcurrtimeFPS - 1), 6) + '.jpg")').attr('name', (eFcurrtimeFPS - 1));
        } else {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(10)").html('');
            $("#eFTimelineContainerTableFramePics td:nth-child(10)").removeAttr('style');
        }

        /* +10 Frames */

        if (eFcurrtimeFPSn0 + 1 <= eFMovieTotalFrames) {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(14)").html(pad(eFcurrtimeFPSn0 + 1, 6));
            $("#eFTimelineContainerTableFramePics td:nth-child(12)").css('background-image', 'url("' + eFServerChoiceURLPrefix + '_media/shots/' + $("#efMCVMovieID").html() + '/' + pad((eFcurrtimeFPSn0 + 1), 6) + '.jpg")').attr('name', (eFcurrtimeFPSn0 + 1));
        } else {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(14)").html('');
            $("#eFTimelineContainerTableFramePics td:nth-child(12)").removeAttr('style');
        }
        if (eFcurrtimeFPSn0 + 2 <= eFMovieTotalFrames) {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(15)").html(pad(eFcurrtimeFPSn0 + 2, 6));
            $("#eFTimelineContainerTableFramePics td:nth-child(13)").css('background-image', 'url("' + eFServerChoiceURLPrefix + '_media/shots/' + $("#efMCVMovieID").html() + '/' + pad((eFcurrtimeFPSn0 + 2), 6) + '.jpg")').attr('name', (eFcurrtimeFPSn0 + 2));
        } else {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(15)").html('');
            $("#eFTimelineContainerTableFramePics td:nth-child(13)").removeAttr('style');
        }
        if (eFcurrtimeFPSn0 + 3 <= eFMovieTotalFrames) {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(16)").html(pad(eFcurrtimeFPSn0 + 3, 6));
            $("#eFTimelineContainerTableFramePics td:nth-child(14)").css('background-image', 'url("' + eFServerChoiceURLPrefix + '_media/shots/' + $("#efMCVMovieID").html() + '/' + pad((eFcurrtimeFPSn0 + 3), 6) + '.jpg")').attr('name', (eFcurrtimeFPSn0 + 3));
        } else {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(16)").html('');
            $("#eFTimelineContainerTableFramePics td:nth-child(14)").removeAttr('style');
        }
        if (eFcurrtimeFPSn0 + 4 <= eFMovieTotalFrames) {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(17)").html(pad(eFcurrtimeFPSn0 + 4, 6));
            $("#eFTimelineContainerTableFramePics td:nth-child(15)").css('background-image', 'url("' + eFServerChoiceURLPrefix + '_media/shots/' + $("#efMCVMovieID").html() + '/' + pad((eFcurrtimeFPSn0 + 4), 6) + '.jpg")').attr('name', (eFcurrtimeFPSn0 + 4));
        } else {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(17)").html('');
            $("#eFTimelineContainerTableFramePics td:nth-child(15)").removeAttr('style');
        }
        if (eFcurrtimeFPSn0 + 5 <= eFMovieTotalFrames) {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(18)").html(pad(eFcurrtimeFPSn0 + 5, 6));
            $("#eFTimelineContainerTableFramePics td:nth-child(16)").css('background-image', 'url("' + eFServerChoiceURLPrefix + '_media/shots/' + $("#efMCVMovieID").html() + '/' + pad((eFcurrtimeFPSn0 + 5), 6) + '.jpg")').attr('name', (eFcurrtimeFPSn0 + 5));
        } else {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(18)").html('');
            $("#eFTimelineContainerTableFramePics td:nth-child(16)").removeAttr('style');
        }
        if (eFcurrtimeFPSn0 + 6 <= eFMovieTotalFrames) {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(19)").html(pad(eFcurrtimeFPSn0 + 6, 6));
            $("#eFTimelineContainerTableFramePics td:nth-child(17)").css('background-image', 'url("' + eFServerChoiceURLPrefix + '_media/shots/' + $("#efMCVMovieID").html() + '/' + pad((eFcurrtimeFPSn0 + 6), 6) + '.jpg")').attr('name', (eFcurrtimeFPSn0 + 6));
        } else {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(19)").html('');
            $("#eFTimelineContainerTableFramePics td:nth-child(17)").removeAttr('style');
        }
        if (eFcurrtimeFPSn0 + 7 <= eFMovieTotalFrames) {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(20)").html(pad(eFcurrtimeFPSn0 + 7, 6));
            $("#eFTimelineContainerTableFramePics td:nth-child(18)").css('background-image', 'url("' + eFServerChoiceURLPrefix + '_media/shots/' + $("#efMCVMovieID").html() + '/' + pad((eFcurrtimeFPSn0 + 7), 6) + '.jpg")').attr('name', (eFcurrtimeFPSn0 + 7));
        } else {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(20)").html('');
            $("#eFTimelineContainerTableFramePics td:nth-child(18)").removeAttr('style');
        }
        if (eFcurrtimeFPSn0 + 8 <= eFMovieTotalFrames) {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(21)").html(pad(eFcurrtimeFPSn0 + 8, 6));
            $("#eFTimelineContainerTableFramePics td:nth-child(19)").css('background-image', 'url("' + eFServerChoiceURLPrefix + '_media/shots/' + $("#efMCVMovieID").html() + '/' + pad((eFcurrtimeFPSn0 + 8), 6) + '.jpg")').attr('name', (eFcurrtimeFPSn0 + 8));
        } else {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(21)").html('');
            $("#eFTimelineContainerTableFramePics td:nth-child(19)").removeAttr('style');
        }
        if (eFcurrtimeFPSn0 + 9 <= eFMovieTotalFrames) {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(22)").html(pad(eFcurrtimeFPSn0 + 9, 6));
            $("#eFTimelineContainerTableFramePics td:nth-child(20)").css('background-image', 'url("' + eFServerChoiceURLPrefix + '_media/shots/' + $("#efMCVMovieID").html() + '/' + pad((eFcurrtimeFPSn0 + 9), 6) + '.jpg")').attr('name', (eFcurrtimeFPSn0 + 9));
        } else {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(22)").html('');
            $("#eFTimelineContainerTableFramePics td:nth-child(20)").removeAttr('style');
        }
        if (eFcurrtimeFPSn0 + 10 <= eFMovieTotalFrames) {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(23)").html(pad(eFcurrtimeFPSn0 + 10, 6));
            $("#eFTimelineContainerTableFramePics td:nth-child(21)").css('background-image', 'url("' + eFServerChoiceURLPrefix + '_media/shots/' + $("#efMCVMovieID").html() + '/' + pad((eFcurrtimeFPSn0 + 10), 6) + '.jpg")').attr('name', (eFcurrtimeFPSn0 + 10));
        } else {
            $("#eFTimelineContainerTableFrameNumbers th:nth-child(23)").html('');
            $("#eFTimelineContainerTableFramePics td:nth-child(21)").removeAttr('style');
        }

        console.log("eFEditorVMovie.js #439");



    });
    /* Frames Klick Seek*** **********************************************************/
    $("#eFTimelineContainerTableFramePics td").click(function () {
        console.log("eFEditorVMovie.js #446");
        if ($(this).attr('name')) {
            var diepositionf = $(this).attr('name');
            //Browserweiche
            if (BrowserDetect.browser == 'Safari' && BrowserDetect.version > 5.1) {
                var diepositiont = ((1 / fps) * (diepositionf)) + ((1 / fps) / 2);
            }
            else {
                var diepositiont = (diepositionf / fps) + ((1 / fps) / 4);
            }
            mediaElement.currentTime = diepositiont;
        }
    });

    //Annotationen ansteuern
    $("#eFTimelineContainerTableFrameNumbers th").click(function () {
        console.log("eFEditorVMovie.js #468");
        if ($(this).attr('id') != 'eFTimelineContainerTableIN' || $(this).attr('id') != 'eFTimelineContainerTableOUT') {
            var diepositionS = $(this).text();

            $("#eFMovieAnnotationsContainerANList tr").filter(function () {
                return parseInt($(this).children("td.eFTabCellIN").text(), 10) < diepositionS && parseInt($(this).children("td.eFTabCellOUT").text(), 10) > diepositionS;
            }).addClass("scrollmetothisanotation");

            eFAnonZahlenspiel = $("#eFMovieAnnotationsContainerANList table").attr('data-anoncount');
            if (eFAnonZahlenspiel > 0) {

                $('#eFMovieAnnotationsContainerANList').scrollTo("tr.scrollmetothisanotation");
                $("#eFMovieAnnotationsContainerANList tr").removeClass("scrollmetothisanotation");

            } else {

            }
        }
    });

    /* Timeline Rangeimput Balken Dynamics */
    $("#eFMovieRangeInputContainer").mouseenter(function () {
        console.log("eFEditorVMovie.js #499");
        $('#eFTimerunnerActiveState').html('true');
    }).mouseleave(function () {
        $('#eFTimerunnerActiveState').html('false');
    });
    video.totalTime(function (duration) {
        console.log("eFEditorVMovie.js #505");
        var eFframecount = Floor((duration / (1 / fps)), 0);
        var TLFweite = $('#eFMovieRangeInputContainer').innerWidth();
        $('#eFMovieRangeInputContainer .slider').css('width', (TLFweite - 95) + 'px');
        eFTimerunner = $("#eFMovieRangeInputContainer input[type='range']").rangeinput({
            progress: true,
            min: 0,
            max: Math.floor(eFframecount),
            onSlide: function (ev, value) {
                console.log("eFEditorVMovie.js #516");
                var eFTimerunnerActiveState = $('#eFTimerunnerActiveState').html();
                if (eFTimerunnerActiveState == "true") {
                    video.pause();
                    $("#efMoviePlaybuttonsPlayPause").css("background-position", "-36px 0");
                    var diepositionf = value;
                    //Browserspezifisch abrechnen;)

                    if (BrowserDetect.browser == 'Safari' && BrowserDetect.version > 5.1) {
                        var diepositiont = ((1 / fps) * (diepositionf)) + ((1 / fps) / 2);
                    }
                    else {
                        var diepositiont = (diepositionf / fps) + ((1 / fps) / 4);
                    }

                    video.seek(diepositiont);
                }
            },
            onchange: function (e, value) {
                console.log("eFEditorVMovie.js #539");
                var eFTimerunnerActiveState = $('#eFTimerunnerActiveState').html();
                if (eFTimerunnerActiveState == "true") {
                    video.pause();
                    $("#efMoviePlaybuttonsPlayPause").css("background-position", "-36px 0");
                    var diepositionf = value;
                    //Browserspezifisch abrechnen;)

                    if (BrowserDetect.browser == 'Safari' && BrowserDetect.version > 5.1) {
                        var diepositiont = ((1 / fps) * (diepositionf)) + ((1 / fps) / 2);
                    }
                    else {
                        var diepositiont = (diepositionf / fps) + ((1 / fps) / 4);
                    }

                    video.seek(diepositiont);
                }

            }

        });
    });

    /* IN OUT Setzen */
//Von der Timeline
    $(document).on('click', '#efTLCIN', function () {
        console.log("eFEditorVMovie.js #574");
        if (isNaN($('#eFTimelineContainerTableActual').html()) == false) {
            var eFInsertFNIN = ($('#eFTimelineContainerTableActual').html()) / 1;
        }
        else {
            var eFInsertFNIN = '0';
        }
        $('#eFAFormIN').val(eFInsertFNIN);
    });

    $(document).on('click', '#efTLCOUT', function () {
        console.log("eFEditorVMovie.js #586");
        if (isNaN($('#eFTimelineContainerTableActual').html()) == false) {
            var eFInsertFNIN = ($('#eFTimelineContainerTableActual').html()) / 1;
        }
        else {
            var eFInsertFNIN = '0';
        }
        $('#eFAFormOUT').val(eFInsertFNIN);
    });

//Vom Formular
    $('#eFAFormINGET').click(function () {
        console.log("eFEditorVMovie.js #598");
        if (isNaN($('#eFTimelineContainerTableActual').html()) == false) {
            var eFInsertFNIN = ($('#eFTimelineContainerTableActual').html()) / 1;
        }
        else {
            var eFInsertFNIN = '0';
        }
        $('#eFAFormIN').val(eFInsertFNIN);
    });

    $('#eFAFormOUTGET').click(function () {
        console.log("eFEditorVMovie.js #609");
        if (isNaN($('#eFTimelineContainerTableActual').html()) == false) {
            var eFInsertFNIN = ($('#eFTimelineContainerTableActual').html()) / 1;
        }
        else {
            var eFInsertFNIN = '0';
        }
        $('#eFAFormOUT').val(eFInsertFNIN);
    });

    /* Dynamisches Resize */

    var Seitenverh = 4 / 3;


//movie oder relation
    //Initialpositionierung Movie

    /* Movie Statics */
    function initialPosMainMovie() {
        console.log("eFEditorVMovie.js -initialPosMainMovie()");
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

    initialPosMainMovie();

    /* /Movie Dynamics */
    $(window).resize(function () {
        console.log("eFEditorVMovie.js #672");
        initialPosMainMovie();
    });

    /* generelle Funktionen */
    /* Runden */
    function Round(Number, DecimalPlaces) {
        console.log("eFEditorVMovie.js -Round()");
        return Math.round(parseFloat(Number) * Math.pow(10, DecimalPlaces)) / Math.pow(10, DecimalPlaces);
    }
    function Floor(Number, DecimalPlaces) {
        console.log("eFEditorVMovie.js -Floor()");
        return Math.floor(parseFloat(Number) * Math.pow(10, DecimalPlaces)) / Math.pow(10, DecimalPlaces);
    }
    function Ceil(Number, DecimalPlaces) {
        console.log("eFEditorVMovie.js -Ceil()");
        return Math.ceil(parseFloat(Number) * Math.pow(10, DecimalPlaces)) / Math.pow(10, DecimalPlaces);
    }

    function RoundFixed(Number, DecimalPlaces) {
        console.log("eFEditorVMovie.js -RoundFixed()");
        return Round(Number, DecimalPlaces).toFixed(DecimalPlaces);
    }
    /* Timecodes */
    function secondsToTimecode(timein, fpsin) {
        console.log("eFEditorVMovie.js -secondsToTimecode()");
        var hours = Math.floor(timein / 3600) % 24;
        var minutes = Math.floor(timein / 60) % 60;
        var seconds = Math.floor(timein % 60);
        var frames = Math.floor(((timein % 1) * fpsin).toFixed(3));
        var result = (hours < 10 ? "0" + hours : hours) + ":"
                + (minutes < 10 ? "0" + minutes : minutes) + ":"
                + (seconds < 10 ? "0" + seconds : seconds) + ":"
                + (frames < 10 ? "0" + frames : frames);
        return result;
    }
    function secondsToTimecodeNEW(timein, fpsin) {
        console.log("eFEditorVMovie.js -secondsToTimecodeNEW()");
        var hours = Floor((timein / 3600), 0) % 24;
        var minutes = Floor((timein / 60), 0) % 60;
        var seconds = Floor((timein % 60), 0);
        var frames = Floor((((timein % 1) * fpsin).toFixed(3)), 0);
        var result = (hours < 10 ? "0" + hours : hours) + ":"
                + (minutes < 10 ? "0" + minutes : minutes) + ":"
                + (seconds < 10 ? "0" + seconds : seconds) + ":"
                + (frames < 10 ? "0" + frames : frames);
        return result;
    }
    /* führende Nullen */
    function pad(number, length) {
        var str = '' + number;
        while (str.length < length) {
            str = '0' + str;
        }
        return str;
    }
    /* gearde ungerade*/
    function istGerade(irgendwas) {
        console.log("eFEditorVMovie.js -istGerade()");
        return (irgendwas % 2 == 0) ? true : false;
    };

    /* Unique ID */
    function uniqid() {
        console.log("eFEditorVMovie.js -uniqid()");
        var newDate = new Date;
        return newDate.getTime();
    }
});

