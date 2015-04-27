$(document).ready(function () {
    console.log("eFEditorVResourcesInMovies_Movie.js #1");

/**************** Browser Detection **********************/
var BrowserDetect = {
	init: function () {
    console.log("eFEditorVResourcesInMovies_Movie.js #6");
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
    console.log("eFEditorVResourcesInMovies_Movie.js #14");
		for (var i=0;i<data.length;i++)	{
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
    console.log("eFEditorVResourcesInMovies_Movie.js #28");
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{
			string: navigator.userAgent,
			subString: "Chrome",
			identity: "Chrome"
		},
		{ 	string: navigator.userAgent,
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
		{		// for newer Netscapes (6+)
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
		{ 		// for older Netscapes (4-)
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}
	],
	dataOS : [
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

var MovieAID= $('#eFMovieMovieID').html();

$(document).find('#eFMovieRelATitle').html(MovieAID);
var Seitenverh = 4/3;

initialPosSecondaryMovie();

$(window).resize(function() {
    console.log("eFEditorVResourcesInMovies_Movie.js #136");
initialPosSecondaryMovie();
});

//Movie auswählen
$(document).on('change', '#eFRelMovieBSelect', function () {
    console.log("eFEditorVResourcesInMovies_Movie.js #147");
	$(document).find('input[name=eFRelationsInterfaceRelationIdentifier]').val($(this).val());
	
	//Weiche für unteschiedliche Server
	eFServerChoiceURLPrefix=storeURL+"/";
	
	$('#eFRelMovieBGMovieB').empty().html('<video autobuffer preload="auto" id="eFRelVideoB"><source src="' + eFServerChoiceURLPrefix + '_media/movies_wm/' + $(this).val() + '.m4v" type="video/mp4"></source></video>');
	initialPosSecondaryMovie();
	/* video als jQuery $Media Instanz laden */
	eFRelVideoB = $.media('#eFRelVideoB');
    console.log("eFEditorVResourcesInMovies_Movie.js #193");
	/* Basis Variablen setzen */
	/* Movie ID setzen */
	movie_idB = $(this).val();
	/* FPS setzen */
	fpsB = $(this).find('option:selected').attr('data-fps');
	// 24 aktiv setzen
	$(document).find("#eFMovieControlsContainerRel .efMovieSpeedContainers").removeClass("efMovieSpeedContainersActive");
	$(document).find("#eFMovieControlsContainerRel .efMovieSpeedContainers:contains('" + fpsB + "')").addClass("efMovieSpeedContainersActive");
	/* Vars setzen */
	eFRelVideoB.totalTime(function (duration) {

	framecountB = duration/(1/fpsB);
	framecountFixedB = Floor((duration/(1/fpsB)),0)  -1;
    $('#eFRelVideoB').attr('data-totaltime', duration);
    $('#eFRelVideoB').attr('data-framecount', framecountFixedB);
	});
    console.log("eFEditorVResourcesInMovies_Movie.js #212");
	$('#eFRelVideoB').attr('data-eFTimerunnerActiveStateRelB', 'false');

	$('#eFRelVideoB').attr('data-fps',fpsB);
	eFtotaltimeB = $(document).find('#eFRelVideoB').prop('data-totaltime');
	eFframecountB = $(document).find('#eFRelVideoB').attr('data-framecount');

	eFRelVideoB.seek('0');

/* Timeline Rangeimput Balken Dynamics */
$(document).on('mouseenter', "#eFMovieRangeInputContainerRel",function() {
    console.log("eFEditorVResourcesInMovies_Movie.js #230");
		$(document).find('#eFRelVideoB').attr('data-eFTimerunnerActiveStateRelB', 'true');
	}).on('mouseleave', "#eFMovieRangeInputContainerRel", function() {
    console.log("eFEditorVResourcesInMovies_Movie.js #234");
		$(document).find('#eFRelVideoB').attr('data-eFTimerunnerActiveStateRelB', 'false');
	});
eFRelVideoB.totalTime(function (duration) {
    console.log("eFEditorVResourcesInMovies_Movie.js #238");
		var eFframecount = Floor((duration/(1/fpsB)),0)  -1;	
   		$(document).find('#eFMovieRangeInputContainerRel').html('<input type="range" id="eFTimerunnerRel" name="eFTimerunnerRel" min="0" max="" value="0" />');
		var TLFweite = $(document).find('#eFMovieRangeInputContainerRel').innerWidth();
		$(document).find('#eFMovieRangeInputContainerRel .slider').css('width', (TLFweite-95) + 'px');
		eFTimerunnerRel = $(document).find("#eFMovieRangeInputContainerRel input[type='range']").rangeinput({ 
				progress: true,
				min:0,
				max: Math.floor(eFframecount), 
				onSlide: function(ev, value) {
    console.log("eFEditorVResourcesInMovies_Movie.js #248");
					var eFTimerunnerActiveState = $(document).find('#eFRelVideoB').attr('data-eFTimerunnerActiveStateRelB');
					if (eFTimerunnerActiveState == "true") {
					eFRelVideoB.pause();
					$("#efMoviePlaybuttonsPlayPauseRel").css("background-position", "-36px 0");
					var diepositionf = value;
					//Browserspezifisch abrechnen;)
					if ( BrowserDetect.browser == 'Safari' && BrowserDetect.version > 5.1 ) {
						var diepositiont = ((1/fpsB)*(diepositionf)) + ((1/fpsB)/2);
					}
					else {
						var diepositiont = (diepositionf/fpsB) + ((1/fpsB)/4);
					}
					eFRelVideoB.seek(diepositiont);
					}
				},
				change: function(e, value) {
    console.log("eFEditorVResourcesInMovies_Movie.js #269");
					var eFTimerunnerActiveState = $(document).find('#eFRelVideoB').attr('data-eFTimerunnerActiveStateRelB');
					if (eFTimerunnerActiveState == "true") {
					eFRelVideoB.pause();
					$("#efMoviePlaybuttonsPlayPauseRel").css("background-position", "-36px 0");
					var diepositionf = value;
					//Browserspezifisch abrechnen;)
					if ( BrowserDetect.browser == 'Safari' && BrowserDetect.version > 5.1 ) {
						var diepositiont = ((1/fpsB)*(diepositionf)) + ((1/fpsB)/2);
					}
					else {
						var diepositiont = (diepositionf/fpsB) + ((1/fpsB)/4);
					}
					eFRelVideoB.seek(diepositiont);
					}
					
				}

				});
});

/* Movie Dynamics */
eFRelVideoB.bind('timeupdate', function () {
    console.log("eFEditorVResourcesInMovies_Movie.js #307");
	/* Timecodes in Zieldivs schreiben ************************************************/
	var eFcurrtime = eFRelVideoB.time();
	var eFcurrtimeHMS = eFRelVideoB.time().secondsTo('hh:mm:ss');
	var eFcurrtimeSMPTENEW = secondsToTimecodeNEW(eFcurrtime, fpsB);
	var eFcurrtimeFPS = pad(Round((eFcurrtime*fpsB),0),6);
	var eFcurrtimeFPSn0 = Round((eFcurrtime*fpsB),0);
	
	/* Timeline Balken Dynamics ******************************************************/
	var eFTimerunnerSRel = $(document).find("#eFTimerunnerRel").data("rangeinput");
	var eFTimerunnerActiveState = $('#eFRelVideoB').attr('data-eFTimerunnerActiveStateRelB');
	if (eFTimerunnerActiveState == "false") {
		if (isNaN(eFcurrtimeFPSn0) == false) {
			eFTimerunnerSRel.setValue(eFcurrtimeFPSn0);
		}
		else {
			eFTimerunnerSRel.setValue('0');
		}
	} else {
	}

    console.log("eFEditorVResourcesInMovies_Movie.js #342");
	/* Einzelframes Anzeige **********************************************************/
	$('#eFTimelineContainerTableActualRel').html(eFcurrtimeFPS);
	$('#eFTimelineContainerAFrameRel').css('background-image','url("' + eFServerChoiceURLPrefix + '_media/shots/' + movie_idB + '/' + eFcurrtimeFPS +'.jpg")' );
	var eFMovieTotalFrames = $(document).find('#eFRelVideoB').attr('data-framecount');
	/* -10 Frames */
	if (eFcurrtimeFPSn0 > 9) {
	$("#eFTimelineContainerTableFrameNumbersRel th:nth-child(1)").html(pad(eFcurrtimeFPSn0-10,6));
	$("#eFTimelineContainerTableFramePicsRel td:nth-child(1)").css('background-image','url("' + eFServerChoiceURLPrefix + '_media/shots/' + movie_idB + '/' + pad((eFcurrtimeFPS - 10),6) +'.jpg")' ).attr('name' , (eFcurrtimeFPS-10));
	} else { $("#eFTimelineContainerTableFrameNumbersRel th:nth-child(1)").html(''); $("#eFTimelineContainerTableFramePicsRel td:nth-child(1)").removeAttr( 'style' );}
	if (eFcurrtimeFPSn0 > 8) {
	$("#eFTimelineContainerTableFrameNumbersRel th:nth-child(2)").html(pad(eFcurrtimeFPSn0-9,6));
	$("#eFTimelineContainerTableFramePicsRel td:nth-child(2)").css('background-image','url("' + eFServerChoiceURLPrefix + '_media/shots/' + movie_idB + '/' + pad((eFcurrtimeFPS - 9),6) +'.jpg")' ).attr('name' , (eFcurrtimeFPS-9));
	} else { $("#eFTimelineContainerTableFrameNumbersRel th:nth-child(2)").html(''); $("#eFTimelineContainerTableFramePicsRel td:nth-child(2)").removeAttr( 'style' ); }
	if (eFcurrtimeFPSn0 > 7) {
	$("#eFTimelineContainerTableFrameNumbersRel th:nth-child(3)").html(pad(eFcurrtimeFPSn0-8,6));
	$("#eFTimelineContainerTableFramePicsRel td:nth-child(3)").css('background-image','url("' + eFServerChoiceURLPrefix + '_media/shots/' + movie_idB + '/' + pad((eFcurrtimeFPS - 8),6) +'.jpg")' ).attr('name' , (eFcurrtimeFPS-8));
	} else { $("#eFTimelineContainerTableFrameNumbersRel th:nth-child(3)").html(''); $("#eFTimelineContainerTableFramePicsRel td:nth-child(3)").removeAttr( 'style' ); }
	if (eFcurrtimeFPSn0 > 6) {
	$("#eFTimelineContainerTableFrameNumbersRel th:nth-child(4)").html(pad(eFcurrtimeFPSn0-7,6));
	$("#eFTimelineContainerTableFramePicsRel td:nth-child(4)").css('background-image','url("' + eFServerChoiceURLPrefix + '_media/shots/' + movie_idB + '/' + pad((eFcurrtimeFPS - 7),6) +'.jpg")' ).attr('name' , (eFcurrtimeFPS-7));
	} else { $("#eFTimelineContainerTableFrameNumbersRel th:nth-child(4)").html(''); $("#eFTimelineContainerTableFramePicsRel td:nth-child(4)").removeAttr( 'style' ); }
	if (eFcurrtimeFPSn0 > 5) {
	$("#eFTimelineContainerTableFrameNumbersRel th:nth-child(5)").html(pad(eFcurrtimeFPSn0-6,6));
	$("#eFTimelineContainerTableFramePicsRel td:nth-child(5)").css('background-image','url("' + eFServerChoiceURLPrefix + '_media/shots/' + movie_idB + '/' + pad((eFcurrtimeFPS - 6),6) +'.jpg")' ).attr('name' , (eFcurrtimeFPS-6));
	} else { $("#eFTimelineContainerTableFrameNumbersRel th:nth-child(5)").html(''); $("#eFTimelineContainerTableFramePicsRel td:nth-child(5)").removeAttr( 'style' ); }
	if (eFcurrtimeFPSn0 > 4) {
	$("#eFTimelineContainerTableFrameNumbersRel th:nth-child(6)").html(pad(eFcurrtimeFPSn0-5,6));
	$("#eFTimelineContainerTableFramePicsRel td:nth-child(6)").css('background-image','url("' + eFServerChoiceURLPrefix + '_media/shots/' + movie_idB + '/' + pad((eFcurrtimeFPS - 5),6) +'.jpg")' ).attr('name' , (eFcurrtimeFPS-5));
	} else { $("#eFTimelineContainerTableFrameNumbersRel th:nth-child(6)").html(''); $("#eFTimelineContainerTableFramePicsRel td:nth-child(6)").removeAttr( 'style' ); }
	if (eFcurrtimeFPSn0 > 3) {
	$("#eFTimelineContainerTableFrameNumbersRel th:nth-child(7)").html(pad(eFcurrtimeFPSn0-4,6));
	$("#eFTimelineContainerTableFramePicsRel td:nth-child(7)").css('background-image','url("' + eFServerChoiceURLPrefix + '_media/shots/' + movie_idB + '/' + pad((eFcurrtimeFPS - 4),6) +'.jpg")' ).attr('name' , (eFcurrtimeFPS-4));
	} else { $("#eFTimelineContainerTableFrameNumbersRel th:nth-child(7)").html(''); $("#eFTimelineContainerTableFramePicsRel td:nth-child(7)").removeAttr( 'style' ); }
	if (eFcurrtimeFPSn0 > 2) {
	$("#eFTimelineContainerTableFrameNumbersRel th:nth-child(8)").html(pad(eFcurrtimeFPSn0-3,6));
	$("#eFTimelineContainerTableFramePicsRel td:nth-child(8)").css('background-image','url("' + eFServerChoiceURLPrefix + '_media/shots/' + movie_idB + '/' + pad((eFcurrtimeFPS - 3),6) +'.jpg")' ).attr('name' , (eFcurrtimeFPS-3));
	} else { $("#eFTimelineContainerTableFrameNumbersRel th:nth-child(8)").html(''); $("#eFTimelineContainerTableFramePicsRel td:nth-child(8)").removeAttr( 'style' ); }
	if (eFcurrtimeFPSn0 > 1) {
	$("#eFTimelineContainerTableFrameNumbersRel th:nth-child(9)").html(pad(eFcurrtimeFPSn0-2,6));
	$("#eFTimelineContainerTableFramePicsRel td:nth-child(9)").css('background-image','url("' + eFServerChoiceURLPrefix + '_media/shots/' + movie_idB + '/' + pad((eFcurrtimeFPS - 2),6) +'.jpg")' ).attr('name' , (eFcurrtimeFPS-2));
	} else { $("#eFTimelineContainerTableFrameNumbersRel th:nth-child(9)").html(''); $("#eFTimelineContainerTableFramePicsRel td:nth-child(9)").removeAttr( 'style' ); }
	if (eFcurrtimeFPSn0 > 0) {
	$("#eFTimelineContainerTableFrameNumbersRel th:nth-child(10)").html(pad(eFcurrtimeFPSn0-1,6));
	$("#eFTimelineContainerTableFramePicsRel td:nth-child(10)").css('background-image','url("' + eFServerChoiceURLPrefix + '_media/shots/' + movie_idB + '/' + pad((eFcurrtimeFPS - 1),6) +'.jpg")' ).attr('name' , (eFcurrtimeFPS-1));
	} else { $("#eFTimelineContainerTableFrameNumbersRel th:nth-child(10)").html(''); $("#eFTimelineContainerTableFramePicsRel td:nth-child(10)").removeAttr( 'style' ); }
    console.log("eFEditorVResourcesInMovies_Movie.js #388");
	/* +10 Frames */
	if (eFcurrtimeFPSn0+1 <= eFMovieTotalFrames) {
	$("#eFTimelineContainerTableFrameNumbersRel th:nth-child(14)").html(pad(eFcurrtimeFPSn0+1,6));
	$("#eFTimelineContainerTableFramePicsRel td:nth-child(12)").css('background-image','url("' + eFServerChoiceURLPrefix + '_media/shots/' + movie_idB + '/' + pad((eFcurrtimeFPSn0+1),6) +'.jpg")' ).attr('name' , (eFcurrtimeFPSn0+1));
	} else { $("#eFTimelineContainerTableFrameNumbersRel th:nth-child(14)").html(''); $("#eFTimelineContainerTableFramePicsRel td:nth-child(12)").removeAttr( 'style' ); }
	if (eFcurrtimeFPSn0+2 <= eFMovieTotalFrames) {
	$("#eFTimelineContainerTableFrameNumbersRel th:nth-child(15)").html(pad(eFcurrtimeFPSn0+2,6));
	$("#eFTimelineContainerTableFramePicsRel td:nth-child(13)").css('background-image','url("' + eFServerChoiceURLPrefix + '_media/shots/' + movie_idB + '/' + pad((eFcurrtimeFPSn0+2),6) +'.jpg")' ).attr('name' , (eFcurrtimeFPSn0+2));
	} else { $("#eFTimelineContainerTableFrameNumbersRel th:nth-child(15)").html(''); $("#eFTimelineContainerTableFramePicsRel td:nth-child(13)").removeAttr( 'style' ); }
	if (eFcurrtimeFPSn0+3 <= eFMovieTotalFrames) {
	$("#eFTimelineContainerTableFrameNumbersRel th:nth-child(16)").html(pad(eFcurrtimeFPSn0+3,6));
	$("#eFTimelineContainerTableFramePicsRel td:nth-child(14)").css('background-image','url("' + eFServerChoiceURLPrefix + '_media/shots/' + movie_idB + '/' + pad((eFcurrtimeFPSn0+3),6) +'.jpg")' ).attr('name' , (eFcurrtimeFPSn0+3));
	} else { $("#eFTimelineContainerTableFrameNumbersRel th:nth-child(16)").html(''); $("#eFTimelineContainerTableFramePicsRel td:nth-child(14)").removeAttr( 'style' ); }
	if (eFcurrtimeFPSn0+4 <= eFMovieTotalFrames) {
	$("#eFTimelineContainerTableFrameNumbersRel th:nth-child(17)").html(pad(eFcurrtimeFPSn0+4,6));
	$("#eFTimelineContainerTableFramePicsRel td:nth-child(15)").css('background-image','url("' + eFServerChoiceURLPrefix + '_media/shots/' + movie_idB + '/' + pad((eFcurrtimeFPSn0+4),6) +'.jpg")' ).attr('name' , (eFcurrtimeFPSn0+4));
	} else { $("#eFTimelineContainerTableFrameNumbersRel th:nth-child(17)").html(''); $("#eFTimelineContainerTableFramePicsRel td:nth-child(15)").removeAttr( 'style' ); }
	if (eFcurrtimeFPSn0+5 <= eFMovieTotalFrames) {
	$("#eFTimelineContainerTableFrameNumbersRel th:nth-child(18)").html(pad(eFcurrtimeFPSn0+5,6));
	$("#eFTimelineContainerTableFramePicsRel td:nth-child(16)").css('background-image','url("' + eFServerChoiceURLPrefix + '_media/shots/' + movie_idB + '/' + pad((eFcurrtimeFPSn0+5),6) +'.jpg")' ).attr('name' , (eFcurrtimeFPSn0+5));
	} else { $("#eFTimelineContainerTableFrameNumbersRel th:nth-child(18)").html(''); $("#eFTimelineContainerTableFramePicsRel td:nth-child(16)").removeAttr( 'style' ); }
	if (eFcurrtimeFPSn0+6 <= eFMovieTotalFrames) {
	$("#eFTimelineContainerTableFrameNumbersRel th:nth-child(19)").html(pad(eFcurrtimeFPSn0+6,6));
	$("#eFTimelineContainerTableFramePicsRel td:nth-child(17)").css('background-image','url("' + eFServerChoiceURLPrefix + '_media/shots/' + movie_idB + '/' + pad((eFcurrtimeFPSn0+6),6) +'.jpg")' ).attr('name' , (eFcurrtimeFPSn0+6));
	} else { $("#eFTimelineContainerTableFrameNumbersRel th:nth-child(19)").html(''); $("#eFTimelineContainerTableFramePicsRel td:nth-child(17)").removeAttr( 'style' ); }
	if (eFcurrtimeFPSn0+7 <= eFMovieTotalFrames) {
	$("#eFTimelineContainerTableFrameNumbersRel th:nth-child(20)").html(pad(eFcurrtimeFPSn0+7,6));
	$("#eFTimelineContainerTableFramePicsRel td:nth-child(18)").css('background-image','url("' + eFServerChoiceURLPrefix + '_media/shots/' + movie_idB + '/' + pad((eFcurrtimeFPSn0+7),6) +'.jpg")' ).attr('name' , (eFcurrtimeFPSn0+7));
	} else { $("#eFTimelineContainerTableFrameNumbersRel th:nth-child(20)").html(''); $("#eFTimelineContainerTableFramePicsRel td:nth-child(18)").removeAttr( 'style' ); }
	if (eFcurrtimeFPSn0+8 <= eFMovieTotalFrames) {
	$("#eFTimelineContainerTableFrameNumbersRel th:nth-child(21)").html(pad(eFcurrtimeFPSn0+8,6));
	$("#eFTimelineContainerTableFramePicsRel td:nth-child(19)").css('background-image','url("' + eFServerChoiceURLPrefix + '_media/shots/' + movie_idB + '/' + pad((eFcurrtimeFPSn0+8),6) +'.jpg")' ).attr('name' , (eFcurrtimeFPSn0+8));
	} else { $("#eFTimelineContainerTableFrameNumbersRel th:nth-child(21)").html(''); $("#eFTimelineContainerTableFramePicsRel td:nth-child(19)").removeAttr( 'style' ); }
	if (eFcurrtimeFPSn0+9 <= eFMovieTotalFrames) {
	$("#eFTimelineContainerTableFrameNumbersRel th:nth-child(22)").html(pad(eFcurrtimeFPSn0+9,6));
	$("#eFTimelineContainerTableFramePicsRel td:nth-child(20)").css('background-image','url("' + eFServerChoiceURLPrefix + '_media/shots/' + movie_idB + '/' + pad((eFcurrtimeFPSn0+9),6) +'.jpg")' ).attr('name' , (eFcurrtimeFPSn0+9));
	} else { $("#eFTimelineContainerTableFrameNumbersRel th:nth-child(22)").html(''); $("#eFTimelineContainerTableFramePicsRel td:nth-child(20)").removeAttr( 'style' ); }
	if (eFcurrtimeFPSn0+10 <= eFMovieTotalFrames) {
	$("#eFTimelineContainerTableFrameNumbersRel th:nth-child(23)").html(pad(eFcurrtimeFPSn0+10,6));
	$("#eFTimelineContainerTableFramePicsRel td:nth-child(21)").css('background-image','url("' + eFServerChoiceURLPrefix + '_media/shots/' + movie_idB + '/' + pad((eFcurrtimeFPSn0+10),6) +'.jpg")' ).attr('name' , (eFcurrtimeFPSn0+10));
	} else { $("#eFTimelineContainerTableFrameNumbersRel th:nth-child(23)").html(''); $("#eFTimelineContainerTableFramePicsRel td:nth-child(21)").removeAttr( 'style' ); }
		
	/* Frames Klick Seek*** **********************************************************/
	$("#eFTimelineContainerTableFramePicsRel td").click(function () {
    console.log("eFEditorVResourcesInMovies_Movie.js #435");
		if ($(this).attr('name')) {
			var diepositionfRel = $(this).attr('name');
			var diepositiontRel = ((1/fpsB)*(diepositionfRel)) + ((1/fpsB)/2);
			//alert(diepositiont);
			eFRelVideoB.seek(diepositiontRel);
			}
	});

});//Movie Dynamics

});

/* Movie Speedchange */
	$("#eFMovieControlsContainerRel .efMovieSpeedContainers").click(function(){
    console.log("eFEditorVResourcesInMovies_Movie.js #467");
	$("#eFMovieControlsContainerRel .efMovieSpeedContainers").removeClass("efMovieSpeedContainersActive");
	$(this).toggleClass("efMovieSpeedContainersActive");
	var eFPlaybackSpeedB = $(this).html()/fpsB;
	eFRelVideoB.prop('playbackRate', eFPlaybackSpeedB);
	});

/* IN OUT Setzen */
//Von der Timeline
$(document).on('click', '#eFTimelineContainerTableINRel', function() {
    console.log("eFEditorVResourcesInMovies_Movie.js #482");
if (isNaN($(document).find('#eFTimelineContainerTableActualRel').html()) == false) {
var eFInsertFNINRel = ($(document).find('#eFTimelineContainerTableActualRel').html())/1;
}
else {
var eFInsertFNINRel = '0';
}
$(document).find('input[name=eFRelationsInterfaceRelationFrom]').val(eFInsertFNINRel);
});

$(document).on('click', '#eFTimelineContainerTableOUTRel', function() {
    console.log("eFEditorVResourcesInMovies_Movie.js #493");
if (isNaN($(document).find('#eFTimelineContainerTableActualRel').html()) == false) {
var eFInsertFNINRel = ($(document).find('#eFTimelineContainerTableActualRel').html())/1;
}
else {
var eFInsertFNINRel = '0';
}
$(document).find('input[name=eFRelationsInterfaceRelationTo]').val(eFInsertFNINRel);
});


function initialPosSecondaryMovie() {
    console.log("eFEditorVResourcesInMovies_Movie.js -initialPosSecondaryMovie()");
	var p = $('#videoAktuell');
	var position = p.offset();
	$('#eFRelMovieBGTop').css('height', position.top-50 + 'px');
	$('#eFRelMovieBGBottom').css('top', position.top+$('#videoAktuell').height()-25 + 'px');
	$('#eFRelMovieBGM2').css('top', position.top-50 + 'px').css('height', $('#videoAktuell').height()+25 + 'px');
	$('#eFRelMovieBGM3').css('top', position.top-50 + 'px').css('height', $('#videoAktuell').height()+25 + 'px');
	$('#eFRelMovieBGMovieB').css('top', position.top-38 + 'px').css('right', position.left+5 + 'px').css('height', $('#videoAktuell').height() + 'px').css('width', $('#videoAktuell').width() + 'px');
	
	$('#eFMovieRelATitle').css('top', ((position.top-38)/2) + 'px');
	$('#eFMovieRelBSelect').css('top', ((position.top-38)/2) + 'px');
	var eFPosModus = $('#eFMovieContainer').attr('data-efposmodus');
	if (eFPosModus == 'movie') {
  		var Mweite1 = $('#eFMovieContainer').innerWidth();
  		var Mhoehe1 = $('#eFMovieContainer').innerHeight();
  	}
  	else {
  		var Mweite1 = $('#eFMovieContainer').innerWidth()/2;
  		var Mhoehe1 = $('#eFMovieContainer').innerHeight()-107;
  	}
  	if ($('#eFRelVideoB')) {
  		$('#eFRelVideoB').css('height', $('#videoAktuell').height() + 'px').css('width', $('#videoAktuell').width() + 'px');
  	}
	}

/* generelle Funktionen */
/* Runden */
function Round(Number, DecimalPlaces) {
    console.log("eFEditorVResourcesInMovies_Movie.js -Round()");
   return Math.round(parseFloat(Number) * Math.pow(10, DecimalPlaces)) / Math.pow(10, DecimalPlaces);
}
function Floor(Number, DecimalPlaces) {
    console.log("eFEditorVResourcesInMovies_Movie.js -Floor()");
   return Math.floor(parseFloat(Number) * Math.pow(10, DecimalPlaces)) / Math.pow(10, DecimalPlaces);
}
function Ceil(Number, DecimalPlaces) {
    console.log("eFEditorVResourcesInMovies_Movie.js -Ceil()");
   return Math.ceil(parseFloat(Number) * Math.pow(10, DecimalPlaces)) / Math.pow(10, DecimalPlaces);
}
function RoundFixed(Number, DecimalPlaces) {
    console.log("eFEditorVResourcesInMovies_Movie.js -RoundFixed()");
   return Round(Number, DecimalPlaces).toFixed(DecimalPlaces);
}
/* Timecodes */
function secondsToTimecode(timein, fpsin) {
    console.log("eFEditorVResourcesInMovies_Movie.js -secondsToTimecode()");
    
    var hours = Math.floor(timein / 3600) % 24;
    var minutes = Math.floor(timein / 60) % 60;
    var seconds = Math.floor(timein % 60);
    var frames = Math.floor(((timein % 1)*fpsin).toFixed(3));
    var result = (hours < 10 ? "0" + hours : hours) + ":"
    + (minutes < 10 ? "0" + minutes : minutes) + ":"
    + (seconds < 10 ? "0" + seconds : seconds) + ":"
    + (frames < 10 ? "0" + frames : frames);
    return result;
}
function secondsToTimecodeNEW(timein, fpsin) {
   
    console.log("eFEditorVResourcesInMovies_Movie.js -secondsToTimecodeNEW");
    
    var hours = Floor((timein / 3600),0) % 24;
    var minutes = Floor((timein / 60),0) % 60;
    var seconds = Floor((timein % 60),0);
    var frames = Floor((((timein % 1)*fpsin).toFixed(3)),0);
    var result = (hours < 10 ? "0" + hours : hours) + ":"
    + (minutes < 10 ? "0" + minutes : minutes) + ":"
    + (seconds < 10 ? "0" + seconds : seconds) + ":"
    + (frames < 10 ? "0" + frames : frames);
    return result;
}
/* führende Nullen */
function pad(number, length) {
    console.log("eFEditorVResourcesInMovies_Movie.js -pad()");
    var str = '' + number;
    while (str.length < length) {
        str = '0' + str;
    }
    return str;
}
/* gearde ungerade*/
function istGerade(irgendwas){
    console.log("eFEditorVResourcesInMovies_Movie.js -istGerade()");
    return (irgendwas%2 == 0) ? true : false;
};

/* Unique ID */
function uniqid() {
    console.log("eFEditorVResourcesInMovies_Movie.js -uniqid()");
	var newDate = new Date;
	return newDate.getTime();
}
});
