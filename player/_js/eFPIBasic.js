/**************** License **********************/
/*
The technology and most of the code for this site was developed by Georg Kö 
( reads as Georg Koe in english) from 2011 to 2013 for the Project 
"Ephemeral Films: National Socialism in Austria".
The technology and the code is available to be copied, distributed, transmited and adapted 
under the Creative Commons License Attribution-NonCommercial-ShareAlike 2.0 Generic (CC BY-NC-SA 2.0)
See: http://creativecommons.org/licenses/by-nc-sa/2.0/
To comply with this license agreement this license statement has to be attributed in any case of 
copying, distribution, transmission or adaption within the code and Georg Kö (reads Georg Koe in english)
has to be publicly mentioned particularly by name as its inventor on any web site, in any publication or on the lable 
of any virtual or physical product resulting from copying, distributing, transmitting or adapting this code 
or the technological invention it represents.
*/
/**************** License **********************/
var Anotations,MovieInfo,Search,Close,Help,NumberingAndAnalytics,DynamicAnnotations,ImageRelations,Geolocation;
var BrowserDetect = {
	init: function () {
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
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
$(document).ready(function() {
$.ajaxSetup({cache: false});
BrowserDetect.init();

Language = getCookie('language');

switch (Language) {
    case 'de':
        window.Anotations = 'Annotationen';
        window.MovieInfo = 'Film Info';
        window.Search = 'Suche im Film';
        window.Close = 'schlie&szlig;en';
        window.Help = 'Player Info';
        window.NumberingAndAnalytics = 'Filmanalytische Angaben';
        window.DynamicAnnotations = 'Dynamische Annotationen';
        window.ImageRelations = 'BILD';
        window.Geolocation = 'LANDKARTE';
        window.Framerate = 'Bildrate';
        break;
    default:
        window.Anotations = 'Annotations';
        window.MovieInfo = 'Film Info';
        window.Search = 'Search This Film';
        window.Close = 'close';
        window.Help = 'Player How-To';
        window.NumberingAndAnalytics = 'Numbering and Film Analytics';
        window.DynamicAnnotations = 'Dynamic Annotations';
        window.ImageRelations = 'IMAGE';
        window.Geolocation = 'MAP';
        window.Framerate = 'Frame Rate';
        break;
};

//Erster Aufruf
$('#eFPInav1').addClass('eFPInavItemActive');

$(document).on('mouseover', '#INeFPIANImgRel img', function() {
	var imgloc = $(this).attr('src');
	imgloc = imgloc.replace("Location-Shots_sm", "Location-Shots_l");
	$(document).find('#efPIMovieCurrentContainer').append('<div id="eFPIImgRelInMovieShow" style="z-index:999999999;display:block;"><img src="' + imgloc + '"/></div>')

});
$(document).on('mouseleave', '#INeFPIANImgRel img', function() {
    $(document).find('#eFPIImgRelInMovieShow').remove();
});

var el = document.getElementById('INeFPIANImgRel');
Hammer(el).on("touch", function() {
    var imgloc = $(this).attr('src');
    imgloc = imgloc.replace("Location-Shots_sm", "Location-Shots_l");
    $(document).find('#efPIMovieCurrentContainer').append('<div id="eFPIImgRelInMovieShow" style="z-index:999999999;display:block;"><img src="' + imgloc + '"/></div>')
});
Hammer(el).on("release", function() {
    $(document).find('#eFPIImgRelInMovieShow').remove();
});

/*************** License **********************/
/*
The technology and most of the code for this site was developed by Georg Kö 
( reads as Georg Koe in english) from  2011 to 2013 for the Project 
"Ephemeral Films: National Socialism in Austria".
The technology and the code is available to be copied, distributed, transmited and adapted 
under the Creative Commons License Attribution-NonCommercial-ShareAlike 2.0 Generic (CC BY-NC-SA 2.0)
See: http://creativecommons.org/licenses/by-nc-sa/2.0/
To comply with this license agreement this license  statement has to be attributed in any case of 
copying, distribution, transmission or adaption within the code and Georg Kö (reads Georg Koe in english)
has to be publicly mentioned   particularly by name as its inventor on any web site, in any publication or on the lable 
of any virtual or physical product resulting from copying, distributing, transmitting or adapting this code 
or the technological invention it represents.
*/
/**************** License *********************/

});

/* generelle Funktionen */
function lengthOf(object) {
    var element_count = 0;
    for (e in object) { element_count++; }
    return element_count;
}
function Round(Number, DecimalPlaces) {
   return Math.round(parseFloat(Number) * Math.pow(10, DecimalPlaces)) / Math.pow(10, DecimalPlaces);
}
function Floor(Number, DecimalPlaces) {
   return Math.floor(parseFloat(Number) * Math.pow(10, DecimalPlaces)) / Math.pow(10, DecimalPlaces);
}
function Ceil(Number, DecimalPlaces) {
   return Math.ceil(parseFloat(Number) * Math.pow(10, DecimalPlaces)) / Math.pow(10, DecimalPlaces);
}
function RoundFixed(Number, DecimalPlaces) {
   return Round(Number, DecimalPlaces).toFixed(DecimalPlaces);
}

/* Timecodes */
/**
 * Creates a SMPTE time code for display
 * @param {int} timein - current video time stamp
 * @param {int} fpsin - user selected FPS
 * @returns {String} - formatted SMPTE time code
 */
function secondsToTimecode(timein, fpsin) {
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

/**
 * Creates a SMPTE time code for display
 * *This version uses the math rounding functions above
 * @param {int} timein - current video time stamp
 * @param {int} fpsin - user selected FPS
 * @returns {String} formatted SMPTE time code
 */
function secondsToTimecodeNEW(timein, fpsin) {
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
    var str = '' + number;
    while (str.length < length) {
        str = '0' + str;
    }
    return str;
}

/* gearde ungerade*/
function istGerade(irgendwas){
    return (irgendwas%2 == 0) ? true : false;
};

/* Unique ID */
function uniqid() {
	var newDate = new Date;
	return newDate.getTime();
}

/**
 * 10/18/2013 - ckb USHMM
 * getCookie()
 * @param {string} name
 * @returns value of cookie with matching name
 */
function getCookie(name) {
  var parts = document.cookie.split(name + "=");
  if (parts.length == 2) return parts.pop().split(";").shift();
}

/**
 * 10/18/2013 - ckb USHMM
 * added to control buttons above movie player
 * @param {int} movieid
 * @param {int} speed
 * @returns {void} updated display
 */
function moviePlayerDetailsButton1(movieid,speed) {
    var buttons = new Array(document.getElementById('moviePlayerDetailsButton1').innerHTML,document.getElementById('moviePlayerDetailsButton2').innerHTML,document.getElementById('moviePlayerDetailsButton3').innerHTML);
    if (document.getElementById('moviePlayerDetailsButton1').innerHTML == window.Search) {
	$(document).find('#efPIMovieCurrentAnnotationsContainerS').show().load('/_ajax/movieAnnotationData.php?movieID='+movieid+'&movieSpeed='+speed);
	$(document).find('#efPIMovieCurrentAnnotationsContainerQ').empty().hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerD').hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerI').empty().hide();
    } else if (document.getElementById('moviePlayerDetailsButton1').innerHTML == window.Anotations) {
	$(document).find('#efPIMovieCurrentAnnotationsContainerD').show();
	$(document).find('#efPIMovieCurrentAnnotationsContainerQ').empty().hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerI').empty().hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerS').empty().hide();
    } else if (document.getElementById('moviePlayerDetailsButton1').innerHTML == window.MovieInfo) {
	$(document).find('#efPIMovieCurrentAnnotationsContainerI').show().load('/_ajax/aboutThisMovie.php?movieID='+movieid);
	$(document).find('#efPIMovieCurrentAnnotationsContainerQ').empty().hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerD').hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerS').empty().hide();
    } else if (document.getElementById('moviePlayerDetailsButton1').innerHTML == window.Help) {
	$(document).find('#efPIMovieCurrentAnnotationsContainerQ').show().load('/_ajax/inPlayerHelp.php');
	$(document).find('#efPIMovieCurrentAnnotationsContainerI').empty().hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerD').hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerS').empty().hide();
    }
    if (buttons.indexOf(window.Search) == -1) {
        document.getElementById('moviePlayerDetailsButton1').innerHTML = window.Search;
    }
    if (buttons.indexOf(window.Anotations) == -1) {
        document.getElementById('moviePlayerDetailsButton1').innerHTML = window.Anotations;
    }
    if (buttons.indexOf(window.MovieInfo) == -1) {
        document.getElementById('moviePlayerDetailsButton1').innerHTML = window.MovieInfo;
    }
    if (buttons.indexOf(window.Help) == -1) {
        document.getElementById('moviePlayerDetailsButton1').innerHTML = window.Help;
    }    
}

/**
 * 10/18/2013 - ckb USHMM
 * added to control buttons above movie player
 * @param {int} movieid
 * @param {int} speed
 * @returns {void} updated display
 */
function moviePlayerDetailsButton2(movieid,speed) {
    var buttons = new Array(document.getElementById('moviePlayerDetailsButton1').innerHTML,document.getElementById('moviePlayerDetailsButton2').innerHTML,document.getElementById('moviePlayerDetailsButton3').innerHTML);
    if (document.getElementById('moviePlayerDetailsButton2').innerHTML == window.Search) {
	$(document).find('#efPIMovieCurrentAnnotationsContainerS').show().load('/_ajax/movieAnnotationData.php?movieID='+movieid+'&movieSpeed='+speed);
	$(document).find('#efPIMovieCurrentAnnotationsContainerQ').empty().hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerD').hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerI').empty().hide();
    } else if (document.getElementById('moviePlayerDetailsButton2').innerHTML == window.Anotations) {
	$(document).find('#efPIMovieCurrentAnnotationsContainerD').show();
	$(document).find('#efPIMovieCurrentAnnotationsContainerQ').empty().hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerI').empty().hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerS').empty().hide();
    } else if (document.getElementById('moviePlayerDetailsButton2').innerHTML == window.MovieInfo) {
	$(document).find('#efPIMovieCurrentAnnotationsContainerI').show().load('/_ajax/aboutThisMovie.php?movieID='+movieid);
	$(document).find('#efPIMovieCurrentAnnotationsContainerQ').empty().hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerD').hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerS').empty().hide();
    } else if (document.getElementById('moviePlayerDetailsButton2').innerHTML == window.Help) {
	$(document).find('#efPIMovieCurrentAnnotationsContainerQ').show().load('/_ajax/inPlayerHelp.php');
	$(document).find('#efPIMovieCurrentAnnotationsContainerI').empty().hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerD').hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerS').empty().hide();
    }
    if (buttons.indexOf(window.Search) == -1) {
        document.getElementById('moviePlayerDetailsButton2').innerHTML = window.Search;
    }
    if (buttons.indexOf(window.Anotations) == -1) {
        document.getElementById('moviePlayerDetailsButton2').innerHTML = window.Anotations;
    }
    if (buttons.indexOf(window.MovieInfo) == -1) {
        document.getElementById('moviePlayerDetailsButton2').innerHTML = window.MovieInfo;
    }
    if (buttons.indexOf(window.Help) == -1) {
        document.getElementById('moviePlayerDetailsButton2').innerHTML = window.Help;
    }    
}

/**
 * 10/18/2013 - ckb USHMM
 * added to control buttons above movie player
 * @param {int} movieid
 * @param {int} speed
 * @returns {void} updated display
 */
function moviePlayerDetailsButton3(movieid,speed) {
    var buttons = new Array(document.getElementById('moviePlayerDetailsButton1').innerHTML,document.getElementById('moviePlayerDetailsButton2').innerHTML,document.getElementById('moviePlayerDetailsButton3').innerHTML);
    if (document.getElementById('moviePlayerDetailsButton3').innerHTML == window.Search) {
	$(document).find('#efPIMovieCurrentAnnotationsContainerS').show().load('/_ajax/movieAnnotationData.php?movieID='+movieid+'&movieSpeed='+speed);
	$(document).find('#efPIMovieCurrentAnnotationsContainerQ').empty().hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerD').hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerI').empty().hide();
    } else if (document.getElementById('moviePlayerDetailsButton3').innerHTML == window.Anotations) {
	$(document).find('#efPIMovieCurrentAnnotationsContainerD').show();
	$(document).find('#efPIMovieCurrentAnnotationsContainerQ').empty().hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerI').empty().hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerS').empty().hide();
    } else if (document.getElementById('moviePlayerDetailsButton3').innerHTML == window.MovieInfo) {
	$(document).find('#efPIMovieCurrentAnnotationsContainerI').show().load('/_ajax/aboutThisMovie.php?movieID='+movieid);
	$(document).find('#efPIMovieCurrentAnnotationsContainerQ').empty().hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerD').hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerS').empty().hide();
    } else if (document.getElementById('moviePlayerDetailsButton3').innerHTML == window.Help) {
	$(document).find('#efPIMovieCurrentAnnotationsContainerQ').show().load('/_ajax/inPlayerHelp.php');
	$(document).find('#efPIMovieCurrentAnnotationsContainerI').empty().hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerD').hide();
	$(document).find('#efPIMovieCurrentAnnotationsContainerS').empty().hide();
    }
    if (buttons.indexOf(window.Search) == -1) {
        document.getElementById('moviePlayerDetailsButton3').innerHTML = window.Search;
    }
    if (buttons.indexOf(window.Anotations) == -1) {
        document.getElementById('moviePlayerDetailsButton3').innerHTML = window.Anotations;
    }
    if (buttons.indexOf(window.MovieInfo) == -1) {
        document.getElementById('moviePlayerDetailsButton3').innerHTML = window.MovieInfo;
    }
    if (buttons.indexOf(window.Help) == -1) {
        document.getElementById('moviePlayerDetailsButton3').innerHTML = window.Help;
    }    
}

function isBrowserMobile(a) {
    if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od|ad)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) {
        return true;
    }
    return false;
}

/**
 * 12/05/2013 - ckb USHMM
 * Here we are going to load a SINGLE Google Map
 * it will not have any controls because of it's
 * small size. We are going to style it so that it
 * looks old and hide it. Popcornjs tells it when
 * to display.
 */
var ushmm = new google.maps.LatLng(38.886690, -77.032131);
function initialize() {

    var mapOptions;
    
    if (isBrowserMobile(navigator.userAgent||navigator.vendor||window.opera)) { // Can't show zoomControl on mobile because Google makes the controls too big
        mapOptions = {
            zoom: 14,
            center: ushmm,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            panControl: false,
            zoomControl: false,
            mapTypeControl: false,
            scaleControl: false,
            rotateControl: false,
            streetViewControl: false
        };
    } else {
        mapOptions = {
            zoom: 16,
            center: ushmm,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            panControl: false,
            zoomControl: true,
            mapTypeControl: false,
            scaleControl: false,
            rotateControl: false,
            streetViewControl: false
        };
    }

    map = new google.maps.Map(document.getElementById('INeFPIANMaps'), mapOptions);
    google.maps.visualRefresh = true;

    // Create an ElevationService.
    elevator = new google.maps.ElevationService();

    var styles = GetMapStyles();
    map.setOptions({
       styles: styles
    });
    document.getElementById('INeFPIANMaps').style.display = 'none';
}

function GetMapStyles() {
    var styles = [{
        "stylers": [{
                      "saturation": -50
                  }
                 ]
        }, {
        "featureType": "administrative",
        "elementType": "labels.text",
        "stylers": [{
                      "lightness": 60
                  }
                 ]
        }, {
        "featureType": "administrative",
        "elementType": "geometry.stroke",
        "stylers": [{
                      "lightness": 30
                  }
                 ]
        }, {
        "featureType": "administrative",
        "elementType": "labels.icon",
        "stylers": [{
                      "lightness": 80
                  }
                 ]
        }, {}
        ];

    return styles;
}

google.maps.event.addDomListener(window, 'load', initialize);

/*
 * showefmovie()
 * @param int movieid
 * @param string moviesig
 * @param int speed
 * @param int start
 * @param int stop
 * @returns (void) fills display with movie player
 */
function showefmovie(movieid, moviesig, speed, start, stop) {        
	start = typeof start !== 'undefined' ? start : '0.000001';  // Default start is 0.000001 if it is not provided
        stop = typeof stop !== 'undefined' ? stop : '0';            // Default stop is 0 if it is not provided
        speed = typeof speed !== 'undefined' ? speed : '24';        // Default speed is 24 if it is not provided
	fps = speed;
        	
	var MovieLovcationPrefix = $('body').attr('data-movielocationprefix');
	
	$(document).find('#efPIMovieCurrentContainer').html('<video id="eFMovieVideoCurrent" webkit-playsinline> <source src="' + MovieLovcationPrefix + moviesig + '.m4v" type="video/mp4"> <source src="' + MovieLovcationPrefix + moviesig + '.ogg" type="video/ogg"> </video><div id="demoRangeimputContainer"><div id="demoRangeimputContainerPP"></div><div id="demoRangeimputContainerRISlider"></div><div id="demoRangeimputContainerSMPTE">00:00:00:00</div><div id="efMoviePlaybuttonsSpeed"><div class="moviePlayerFrameRateLabel">'+window.Framerate+':</div><div class="efMoviePlaybuttons efMovieSpeedContainers efMovieSpeedContainersActive" data-moviespeed="6">6</div> <div class="efMoviePlaybuttons efMovieSpeedContainers" data-moviespeed="12">12</div> <div class="efMoviePlaybuttons efMovieSpeedContainers" data-moviespeed="16">16</div> <div class="efMoviePlaybuttons efMovieSpeedContainers" data-moviespeed="18">18</div> <div class="efMoviePlaybuttons efMovieSpeedContainers" data-moviespeed="20">20</div> <div class="efMoviePlaybuttons efMovieSpeedContainers" data-moviespeed="22">22</div> <div class="efMoviePlaybuttons efMovieSpeedContainers" data-moviespeed="24">24</div> <div class="efMoviePlaybuttons efMovieSpeedContainers" data-moviespeed="25">25</div> <div class="efMoviePlaybuttons efMovieSpeedContainers" data-moviespeed="36">36</div></div></div><div id="eFTimerunnerActiveState">false</div>');
	
	/*set intended playback speed*/
	$(document).find('#efMoviePlaybuttonsSpeed .efMovieSpeedContainers').removeClass('efMovieSpeedContainersActive');
	$(document).find('#efMoviePlaybuttonsSpeed .efMovieSpeedContainers[data-moviespeed=' + speed + ']').toggleClass('efMovieSpeedContainersActive');
	PlaybackRateFromMovieSpeed = speed/fps;
	
	/* video als jQuery $Media Instanz laden */
	var currentvideo = $.media('#eFMovieVideoCurrent');
	
	if ( start > '0') {
            currentvideo.seek(start);
            currentvideo.ready(4, function () {
                $(document).find('#demoRangeimputContainerPP').css('background-image', 'url(/images/controls/play.svg)');	
                currentvideo.prop('playbackRate', PlaybackRateFromMovieSpeed);
                currentvideo.play();
                currentvideo.timeline(stop, function () {
                        this.pause();
                        currentvideo.seek(stop);
                });		
            });
	}
	
	$(document).find('#demoRangeimputContainerPP').click(function(){
		if (currentvideo.playing()) {
		$(this).css('background-image', 'url(/images/controls/play.svg)');
		currentvideo.pause();
		} else {
		$(this).css('background-image', 'url(/images/controls/pause.svg)');
		currentvideo.prop('playbackRate', PlaybackRateFromMovieSpeed);
		currentvideo.play();
		}
	
	});
	
	$(document).on('click', '#efMoviePlaybuttonsSpeed .efMovieSpeedContainers', function(){
	$('#efMoviePlaybuttonsSpeed .efMovieSpeedContainers').removeClass('efMovieSpeedContainersActive');
	$(this).toggleClass('efMovieSpeedContainersActive');
	var eFPlaybackSpeed = $(this).html()/fps;
	currentvideo.prop('playbackRate', eFPlaybackSpeed);
	});

	currentvideo.bind('timeupdate', function () {
            /* Timecodes in Zieldivs schreiben ************************************************/
            var eFcurrtime = currentvideo.time();
            var eFcurrtimeHMS = currentvideo.time().secondsTo('hh:mm:ss');
            var eFcurrtimeSMPTENEW = secondsToTimecodeNEW(eFcurrtime, fps);
            var eFcurrtimeFPS = pad(Round((eFcurrtime*fps),0),6);
            var eFcurrtimeFPSn0 = Round((eFcurrtime*fps),0);
            $('#demoRangeimputContainerSMPTE').html(eFcurrtimeSMPTENEW);

            /* Timeline Balken Dynamics ******************************************************/
            var eFTimerunnerS = $("#eFTimerunner").data("rangeinput");
            var eFTimerunnerActiveState = $('#eFTimerunnerActiveState').html();
            if (eFTimerunnerActiveState == "false") {
                eFTimerunnerS.setValue(eFcurrtimeFPSn0);
            } else {
            }
        });

/* Timeline Rangeimput Balken Dynamics */
$("#demoRangeimputContainerRISlider").mouseenter(function() {
	$('#eFTimerunnerActiveState').html('true');
	}).mouseleave(function() {
		$('#eFTimerunnerActiveState').html('false');
	});

currentvideo.totalTime(function (duration) {
    var eFframecount = Floor((duration/(1/24)),0)  -1;	
    $('#demoRangeimputContainerRISlider').html('<input type="range" id="eFTimerunner" name="eFTimerunner" min="0" max="" value="0" />');
    var TLFweite = $('#demoRangeimputContainerRISlider').innerWidth();
    eFTimerunner = $("#demoRangeimputContainerRISlider input[type='range']").rangeinput({ 
        progress: true,
        min:0,
        max: Math.floor(eFframecount), 
        onSlide: function(ev, value) {
                var eFTimerunnerActiveState = $('#eFTimerunnerActiveState').html();
                if (eFTimerunnerActiveState == "true") {
                $("#demoRangeimputContainerPP").css("background-position", "0px 0");
                currentvideo.pause();
                $("#efMoviePlaybuttonsPlayPause").css("background-position", "-36px 0");
                var diepositionf = value;
                //Browserspezifisch abrechnen;)
                if ( BrowserDetect.browser == 'Safari' && BrowserDetect.version > 5.1 ) {
                        var diepositiont = ((1/fps)*(diepositionf)) + ((1/fps)/2);
                }
                else {
                        var diepositiont = (diepositionf/fps) + ((1/fps)/4);
                }
                //var diepositiont = ((1/24)*(value)) + ((1/24)/2);
                currentvideo.seek(diepositiont);
                }
        },
        change: function(e, value) { 
            var eFTimerunnerActiveState = $('#eFTimerunnerActiveState').html();
            if (eFTimerunnerActiveState == "true") {
                $("#demoRangeimputContainerPP").css("background-position", "0px 0");
                currentvideo.pause();
                $("#efMoviePlaybuttonsPlayPause").css("background-position", "-36px 0");
                var diepositionf = value;
                //Browserspezifisch abrechnen;)
                if ( BrowserDetect.browser == 'Safari' && BrowserDetect.version > 5.1 ) {
                    var diepositiont = ((1/fps)*(diepositionf)) + ((1/fps)/2);
                }
                else {
                    var diepositiont = (diepositionf/fps) + ((1/fps)/4);
                }
                currentvideo.seek(diepositiont);
            }
        }
    });
});
// Add buttons to swap info panel
$('.moviePlayer').append('<div id="eFPIMinibuttonMenuTop"><div id="moviePlayerDetailsButton1" class="eFPIminibutton" onclick="moviePlayerDetailsButton1('+movieid+','+speed+');">' + Search + '</div><div id="moviePlayerDetailsButton2" class="eFPIminibutton" onclick="moviePlayerDetailsButton2('+movieid+','+speed+');">' + MovieInfo + '</div><div id="moviePlayerDetailsButton3" class="eFPIminibutton" onclick="moviePlayerDetailsButton3('+movieid+','+speed+');">' + Help + '</div></div>');
// Add containers for movie info
$(document).find('#efPIMovieCurrentAnnotationsContainer').html('<div id="efPIMovieCurrentAnnotationsContainerD"></div><div id="efPIMovieCurrentAnnotationsContainerQ"></div><div id="efPIMovieCurrentAnnotationsContainerI"></div><div id="efPIMovieCurrentAnnotationsContainerS"></div>');
// Add placeholders for annotation data
$(document).find('#efPIMovieCurrentAnnotationsContainerD').html('<div id="shotNumber" class="annotationsFull"></div><div id="shotType" class="annotationsFull"></div><div id="shotLocation" class="annotationsFull"></div><div id="shotDate" class="annotationsFull"></div><div id="shotLanguage" class="annotationsFull"></div><div id="shotPunctum" class="annotationsFull"></div><div id="shotPersonNumber" class="annotationsFull"></div><div id="shotPersonAction" class="annotationsFull"></div><div id="shotPersonName" class="annotationsFull"></div><div id="shotPersonGender" class="annotationsFull"></div><div id="shotPersonAge" class="annotationsFull"></div><div id="shotSpacialType" class="annotationsFull"></div><div id="shotSpacialUse" class="annotationsFull"></div><div id="shotLocationType" class="annotationsFull"></div><div id="shotLandmark" class="annotationsFull"></div><div id="shotWrittenElement" class="annotationsFull"></div><div id="shotWrittenLanguage" class="annotationsFull"></div><div id="shotTranscript" class="annotationsFull"></div><div id="shotOrganization" class="annotationsFull"></div><div id="shotHistoricEvent" class="annotationsFull"></div><div id="shotEventType" class="annotationsFull"></div><div id="shotEvent" class="annotationsFull"></div><div id="shotAudioType" class="annotationsFull"></div><div id="shotAudio" class="annotationsFull"></div><div id="shotCameraPosition" class="annotationsFull"></div>');

// Add boxes for related images and location map
$('.moviePlayer').append('<div id="eFPIANImgRel"><div class="eFPIANSupertitle">' + ImageRelations + '</div><div id="INeFPIANImgRel"></div></div><div id="eFPIANMaps"><div class="eFPIANSupertitle">' + Geolocation + '</div><div id="INeFPIANMaps"></div></div>');

$(document).on('click','.eFTabCellPlayMini', function() {
    var ministartingerframes = $(this).attr('data-start');
    var ministartinger = (1/24) * $(this).attr('data-start');
    var ministopinger = (1/24) * $(this).attr('data-stop');
    var miniSpeedInger = $(this).attr('data-speed');
    currentvideo.seek(ministartinger);
    currentvideo.play();
    currentvideo.timeline(ministopinger, function () {
            this.pause();
            currentvideo.seek(ministopinger);
    });
});

/* Popcorn */
var pop = Popcorn( "#eFMovieVideoCurrent" );

/* Annotationen laden */
var MovieIDforDemo = $('body').attr('data-movieid');

$.ajax({
        async: false,
        type: "GET",
        url: "/_ajax/movieAnnotationDataJSON.php",
        data: "movieID=" + movieid,
        success: function(data){
        DomoAnJson = $.parseJSON(data);
                },
        cache: false
});

/**
 * !!! MAGIC NUMBERS !!!
 * Aparently ShotNumber is not actually pulled from the database
 * in relation to the current annotation or point in the film, but is
 * instead generated here in this script.  Be careful about trying to
 * use these values anywhere else.
 */
var demoShotNumber = 0;
var shotNumbers = new Array();

$.each(DomoAnJson.annotation, function(key, value) { 
    if (DomoAnJson.annotation[key].FormID == "eFSCSShotNumber") {
            demoShotNumber = demoShotNumber+1;
    }
});

$.each(DomoAnJson.annotation, function(key, value) { 
    var startTimeN = (DomoAnJson.annotation[key].startTime)*(1/24);
    var endTimeN = (DomoAnJson.annotation[key].endTime)*(1/24);
    // order of appearance is handled on line #732 above
    switch (DomoAnJson.annotation[key].FormID) {
        case "eFSCDLocationN":  // Spacial Coverage Location Name
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotLocationType').style.display = 'block';
                    document.getElementById('shotLocationType').style.marginTop = '10px';
                    if (document.getElementById('shotLocationType').innerHTML == '') {
                        document.getElementById('shotLocationType').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotLocationType').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].coverage+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotLocationType').style.display = 'none';
                    document.getElementById('shotLocationType').style.marginTop = '0px';
                    document.getElementById('shotLocationType').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;					
        case "eFSCDLocationG":  // Google Map
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('INeFPIANMaps').style.display = 'block';
                    newPanLocation = new google.maps.LatLng(DomoAnJson.annotation[key].coverage_S_Latitude, DomoAnJson.annotation[key].coverage_S_Longitude);
                    map.panTo(newPanLocation);
                },
                onEnd: function() {document.getElementById('INeFPIANMaps').style.display = 'none';},
                onFrame: function() {}
            });
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotLocation').style.display = 'block';
                    document.getElementById('shotLocation').style.marginTop = '10px';
                    if (document.getElementById('shotLocation').innerHTML == '') {
                        document.getElementById('shotLocation').innerHTML = "<span id='big' class='demoTitle'>Geolocation (Name)</span>\n";
                    }
                    document.getElementById('shotLocation').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].coverage_S_Geoname+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotLocation').style.display = 'none';
                    document.getElementById('shotLocation').style.marginTop = '0px';
                    document.getElementById('shotLocation').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCDLandmark":   // Name of Landmark
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotLandmark').style.display = 'block';
                    document.getElementById('shotLandmark').style.marginTop = '10px';
                    if (document.getElementById('shotLandmark').innerHTML == '') {
                        document.getElementById('shotLandmark').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotLandmark').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].coverage+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotLandmark').style.display = 'none';
                    document.getElementById('shotLandmark').style.marginTop = '0px';
                    document.getElementById('shotLandmark').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCDDate":       // Date Range of shot
            if (DomoAnJson.annotation[key].coverage_T_From == DomoAnJson.annotation[key].coverage_T_To) {
                DemoDate = DomoAnJson.annotation[key].coverage_T_From;
            } else {
                DemoDate = DomoAnJson.annotation[key].coverage_T_From + " - " + DomoAnJson.annotation[key].coverage_T_To;
            }
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotDate').style.display = 'block';
                    document.getElementById('shotDate').style.marginTop = '10px';
                    if (document.getElementById('shotDate').innerHTML == '') {
                        document.getElementById('shotDate').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotDate').innerHTML += "<div class='demoText' id='mid'>"+DemoDate+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotDate').style.display = 'none';
                    document.getElementById('shotDate').style.marginTop = '0px';
                    document.getElementById('shotDate').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCDPerson":     // Person's name
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotPersonName').style.display = 'block';
                    document.getElementById('shotPersonName').style.marginTop = '10px';
                    if (document.getElementById('shotPersonName').innerHTML == '') {
                        document.getElementById('shotPersonName').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotPersonName').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].subject_P_PersonName+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotPersonName').style.display = 'none';
                    document.getElementById('shotPersonName').style.marginTop = '0px';
                    document.getElementById('shotPersonName').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCDOrganisation":   // Organization Name
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotOrganization').style.display = 'block';
                    document.getElementById('shotOrganization').style.marginTop = '10px';
                    if (document.getElementById('shotOrganization').innerHTML == '') {
                        document.getElementById('shotOrganization').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotOrganization').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].subject_O_OrganizationName+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotOrganization').style.display = 'none';
                    document.getElementById('shotOrganization').style.marginTop = '0px';
                    document.getElementById('shotOrganization').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCDHistoricEvent":  // Historic Event
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotHistoricEvent').style.display = 'block';
                    document.getElementById('shotHistoricEvent').style.marginTop = '10px';
                    if (document.getElementById('shotHistoricEvent').innerHTML == '') {
                        document.getElementById('shotHistoricEvent').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotHistoricEvent').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].subject_HE_Title + "<br/>" + DomoAnJson.annotation[key].subject_HE_Type + " (" + DomoAnJson.annotation[key].subject_HE_Date +")</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotHistoricEvent').style.display = 'none';
                    document.getElementById('shotHistoricEvent').style.marginTop = '0px';
                    document.getElementById('shotHistoricEvent').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCSLanguage":   // Language of segment
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotLanguage').style.display = 'block';
                    document.getElementById('shotLanguage').style.marginTop = '10px';
                    if (document.getElementById('shotLanguage').innerHTML == '') {
                        document.getElementById('shotLanguage').innerHTML = "<span id='big' class='demoTitle'>Language</span>\n";
                    }
                    document.getElementById('shotLanguage').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].language+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotLanguage').style.display = 'none';
                    document.getElementById('shotLanguage').style.marginTop = '0px';
                    document.getElementById('shotLanguage').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCSRelation":   // Related Images
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('INeFPIANImgRel').style.display = 'block';
                    document.getElementById('INeFPIANImgRel').innerHTML = "<img src='"+storeURL+"/_media/movies_wm/_img/Location-Shots_sm/"+DomoAnJson.annotation[key].relation+"' style='max-width: 134px; padding-left: 2px; opacity:0.8; filter:alpha(opacity=80);'>\n";
                },
                onEnd: function() {
                    document.getElementById('INeFPIANImgRel').style.display = 'none';
                    document.getElementById('INeFPIANImgRel').innerHTML = '';
                    $(document).find('#eFPIImgRelInMovieShow').remove();
                },
                onFrame: function() {}
            });
            break;
        case "eFSCSShotNumber":     // Shot Number
            /*
             * 12/06/2013 - ckb USHMM
             * NOTE!! This is not a real datapoint. It is a counter.
             * Be careful repurposing this value for other areas of the site,
             * the data may not relate appropriately.
             */
            shotNumbers[key] = demoShotNumber;
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotNumber').style.display = 'block';
                    document.getElementById('shotNumber').style.marginTop = '10px';
                    if (document.getElementById('shotNumber').innerHTML == '') {
                        document.getElementById('shotNumber').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotNumber').innerHTML += "<div class='demoText' id='mid'>"+shotNumbers[key]+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotNumber').style.display = 'none';
                    document.getElementById('shotNumber').style.marginTop = '0px';
                    document.getElementById('shotNumber').innerHTML = '';
                },
                onFrame: function() {}
            });
            demoShotNumber--;
            break;
        case "eFSCSSpacialType":    // Spacial Type (plaza, etc.)
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotSpacialType').style.display = 'block';
                    document.getElementById('shotSpacialType').style.marginTop = '10px';
                    if (document.getElementById('shotSpacialType').innerHTML == '') {
                        document.getElementById('shotSpacialType').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotSpacialType').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].description+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotSpacialType').style.display = 'none';
                    document.getElementById('shotSpacialType').style.marginTop = '0px';
                    document.getElementById('shotSpacialType').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCSSpacialUse":     // Spacial Use (work, leisure, etc.)
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotSpacialUse').style.display = 'block';
                    document.getElementById('shotSpacialUse').style.marginTop = '10px';
                    if (document.getElementById('shotSpacialUse').innerHTML == '') {
                        document.getElementById('shotSpacialUse').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotSpacialUse').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].description+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotSpacialUse').style.display = 'none';
                    document.getElementById('shotSpacialUse').style.marginTop = '0px';
                    document.getElementById('shotSpacialUse').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCSPersonsNumber":  // Number of People (crowd, single person, etc.)
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotPersonNumber').style.display = 'block';
                    document.getElementById('shotPersonNumber').style.marginTop = '10px';
                    if (document.getElementById('shotPersonNumber').innerHTML == '') {
                        document.getElementById('shotPersonNumber').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotPersonNumber').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].description+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotPersonNumber').style.display = 'none';
                    document.getElementById('shotPersonNumber').style.marginTop = '0px';
                    document.getElementById('shotPersonNumber').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCSPersonsGender":  // Gender of subjects
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotPersonGender').style.display = 'block';
                    document.getElementById('shotPersonGender').style.marginTop = '10px';
                    if (document.getElementById('shotPersonGender').innerHTML == '') {
                        document.getElementById('shotPersonGender').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotPersonGender').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].description+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotPersonGender').style.display = 'none';
                    document.getElementById('shotPersonGender').style.marginTop = '0px';
                    document.getElementById('shotPersonGender').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCSPersonsAge":     // Age range of subjects
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotPersonAge').style.display = 'block';
                    document.getElementById('shotPersonAge').style.marginTop = '10px';
                    if (document.getElementById('shotPersonAge').innerHTML == '') {
                        document.getElementById('shotPersonAge').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotPersonAge').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].description+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotPersonAge').style.display = 'none';
                    document.getElementById('shotPersonAge').style.marginTop = '0px';
                    document.getElementById('shotPersonAge').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCSPersonsAction":  // Actions of person in shot
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotPersonAction').style.display = 'block';
                    document.getElementById('shotPersonAction').style.marginTop = '10px';
                    if (document.getElementById('shotPersonAction').innerHTML == '') {
                        document.getElementById('shotPersonAction').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotPersonAction').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].description+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotPersonAction').style.display = 'none';
                    document.getElementById('shotPersonAction').style.marginTop = '0px';
                    document.getElementById('shotPersonAction').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCSVisualEventType":    // Type of Objects in shot
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotEventType').style.display = 'block';
                    document.getElementById('shotEventType').style.marginTop = '10px';
                    if (document.getElementById('shotEventType').innerHTML == '') {
                        document.getElementById('shotEventType').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotEventType').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].description+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotEventType').style.display = 'none';
                    document.getElementById('shotEventType').style.marginTop = '0px';
                    document.getElementById('shotEventType').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCSVisualEvent":    // Descriptions of objects in shot
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotEvent').style.display = 'block';
                    document.getElementById('shotEvent').style.marginTop = '10px';
                    if (document.getElementById('shotEvent').innerHTML == '') {
                        document.getElementById('shotEvent').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotEvent').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].description+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotEvent').style.display = 'none';
                    document.getElementById('shotEvent').style.marginTop = '0px';
                    document.getElementById('shotEvent').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCSAudioEventType": // Audio Event Type
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotAudioType').style.display = 'block';
                    document.getElementById('shotAudioType').style.marginTop = '10px';
                    if (document.getElementById('shotAudioType').innerHTML == '') {
                        document.getElementById('shotAudioType').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotAudioType').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].description+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotAudioType').style.display = 'none';
                    document.getElementById('shotAudioType').style.marginTop = '0px';
                    document.getElementById('shotAudioType').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCSAudioEvent":     // Audio event
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotAudio').style.display = 'block';
                    document.getElementById('shotAudio').style.marginTop = '10px';
                    if (document.getElementById('shotAudio').innerHTML == '') {
                        document.getElementById('shotAudio').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotAudio').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].description+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotAudio').style.display = 'none';
                    document.getElementById('shotAudio').style.marginTop = '0px';
                    document.getElementById('shotAudio').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCSIntertitleTranscript":   // Transcribed text in shot
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotTranscript').style.display = 'block';
                    document.getElementById('shotTranscript').style.marginTop = '10px';
                    if (document.getElementById('shotTranscript').innerHTML == '') {
                        document.getElementById('shotTranscript').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotTranscript').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].description+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotTranscript').style.display = 'none';
                    document.getElementById('shotTranscript').style.marginTop = '0px';
                    document.getElementById('shotTranscript').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCSWrittenElementsLanguage":    // Language of written element
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotWrittenLanguage').style.display = 'block';
                    document.getElementById('shotWrittenLanguage').style.marginTop = '10px';
                    if (document.getElementById('shotWrittenLanguage').innerHTML == '') {
                        document.getElementById('shotWrittenLanguage').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotWrittenLanguage').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].description+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotWrittenLanguage').style.display = 'none';
                    document.getElementById('shotWrittenLanguage').style.marginTop = '0px';
                    document.getElementById('shotWrittenLanguage').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCSWrittenElementsTranscript":  // Type of element containing writing
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotWrittenElement').style.display = 'block';
                    document.getElementById('shotWrittenElement').style.marginTop = '10px';
                    if (document.getElementById('shotWrittenElement').innerHTML == '') {
                        document.getElementById('shotWrittenElement').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotWrittenElement').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].description+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotWrittenElement').style.display = 'none';
                    document.getElementById('shotWrittenElement').style.marginTop = '0px';
                    document.getElementById('shotWrittenElement').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCSPunctum":    // Description of shot content
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotPunctum').style.display = 'block';
                    document.getElementById('shotPunctum').style.marginTop = '10px';
                    if (document.getElementById('shotPunctum').innerHTML == '') {
                        document.getElementById('shotPunctum').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotPunctum').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].description+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotPunctum').style.display = 'none';
                    document.getElementById('shotPunctum').style.marginTop = '0px';
                    document.getElementById('shotPunctum').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCSShotType":       // Shot type
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotType').style.display = 'block';
                    document.getElementById('shotType').style.marginTop = '10px';
                    if (document.getElementById('shotType').innerHTML == '') {
                        document.getElementById('shotType').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotType').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].description+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotType').style.display = 'none';
                    document.getElementById('shotType').style.marginTop = '0px';
                    document.getElementById('shotType').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
        case "eFSCSCameraPosition": // camera position
            pop.code({
                start: startTimeN,
                end: endTimeN,
                onStart: function() {
                    document.getElementById('shotCameraPosition').style.display = 'block';
                    document.getElementById('shotCameraPosition').style.marginTop = '10px';
                    if (document.getElementById('shotCameraPosition').innerHTML == '') {
                        document.getElementById('shotCameraPosition').innerHTML = "<span id='big' class='demoTitle'>"+DomoAnJson.annotation[key].AnnotationType_L3+"</span>\n";
                    }
                    document.getElementById('shotCameraPosition').innerHTML += "<div class='demoText' id='mid'>"+DomoAnJson.annotation[key].description+"</div>\n";
                },
                onEnd: function() {
                    document.getElementById('shotCameraPosition').style.display = 'none';
                    document.getElementById('shotCameraPosition').style.marginTop = '0px';
                    document.getElementById('shotCameraPosition').innerHTML = '';
                },
                onFrame: function() {}
            });
            break;
    }
});
}
/****************  License **********************/
/*
The technology and most  of the code for this site was developed by Georg Kö 
( reads as Georg Koe in english) from 2011 to 2013 for the Project 
"Ephemeral Films:  National Socialism in Austria".
The technology and the code is available to be copied, distributed, transmited and adapted 
under the Creative  Commons License Attribution-NonCommercial-ShareAlike 2.0 Generic (CC BY-NC-SA 2.0)
See: http://creativecommons.org/licenses/by-nc-sa/2.0/
To comply with this license   agreement this license statement has to be attributed in any case of 
copying, distribution, transmission or adaption within the code and  Georg Kö (reads Georg Koe in english)
has to be publicly mentioned  particularly by name as its  inventor on any web site, in any publication or on the lable 
of any virtual or physical product resulting from copying, distributing, transmitting or adapting this code 
or the technological invention it represents.
*/
/**************** License  **********************/
