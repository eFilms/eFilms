var loopTimer;

/**
 * Handles expanding of AdvancedSearchBox within display
 * @returns revised display of AdvancedSearchBox
 */
function showDiv(){
    var tray = document.getElementById('advancedSearchBox');
    var maxHeight = 440;
    var newTrayHeight = tray.offsetHeight;
    if(newTrayHeight < maxHeight){
        // not there yet, bump position
        newTrayHeight += 10;
        clearTimeout(loopTimer);
    } else {
        // in position, set final location
        clearTimeout(loopTimer);
        tray.style.height = maxHeight+'px';
        return;
    }
    tray.style.height = newTrayHeight+'px';
    tray.style.display = 'block';
    loopTimer = setTimeout(showDiv,5);
}

/**
 * Handles receding of AdvancedSearchBox within display
 * @returns revised display of AdvancedSearchBox
 */
function hideDiv(){
    var tray = document.getElementById('advancedSearchBox');
    var minHeight = 0;
    var newTrayHeight = tray.offsetHeight;
    if(newTrayHeight > minHeight){
        // not there yet, bump position
        newTrayHeight -= 10;
        clearTimeout(loopTimer);
    } else {
        // in position, set final location
        clearTimeout(loopTimer);
        tray.style.height = '0px';
        tray.style.display = 'none';
        return;
    }
    tray.style.height = newTrayHeight+'px';
    loopTimer = setTimeout(hideDiv,5);
}

/**
 * Determines if the AdvancedSearchBox needs to show or hide
 * @returns display or non display of AdvancedSearchBox
 */
function toggleDiv() {
    clearTimeout(loopTimer);
    var tray = document.getElementById('advancedSearchBox');
    if (tray.offsetHeight > 0) {
        hideDiv();
        document.getElementById('advancedSearchUseIndicator').src = "/images/menuOpenArrow.png";
    } else {
        showDiv();
        document.getElementById('advancedSearchUseIndicator').src = "/images/menuCloseArrow.png";
    }
}

function getCookie(name) {
  var parts = document.cookie.split(name + "=");
  if (parts.length == 2) return parts.pop().split(";").shift();
}

/**
 * Swap languages via cookie and reload the page
 * 
 */
function swapLanguages() {
    if (getCookie('language') == 'en') {
        // set cookie for 'de' and refresh page
        document.cookie = 'language=de; expires=; path=/';
        location.reload();
    } else {
        // set cookie for 'en' and refresh page
        document.cookie = 'language=en; expires=; path=/';
        location.reload();
    }
}