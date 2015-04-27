$(document).ready(function () {
    console.log("eFEditorVConfig.js #1");
    $(document).on('change', 'input[name=USERRIGHTSCONFIG]', function () {
        console.log("eFEditorVConfig.js #4");
        var uidcchange = $(this).attr('data-idcusers');
        var uidcchangeval = $(this).attr('value');
        //alert(uidcchange + ' | ' + uidcchangeval);
        $.ajax({
            async: false,
            type: "GET",
            url: "_ajax/eFEditorVConfigContentUsersChange.php",
            data: "idcusers=" + uidcchange + "&eFConfigChangeAction=CUserRightsConfig" + "&eFConfigChangeValue=" + uidcchangeval + "&uniquid=" + uniqid(),
            success: function (data) {
                console.log("eFEditorVConfig.js #14");
                $(document).find('#eFUCOK').fadeIn(300).fadeOut(300);
            },
            cache: false
        });
    });

    $(document).on('change', 'input[name=USERRIGHTSRES]', function () {
        console.log("eFEditorVConfig.js #23");
        var uidcchange = $(this).attr('data-idcusers');
        var uidcchangeval = $(this).attr('value');
        $.ajax({
            async: false,
            type: "GET",
            url: "_ajax/eFEditorVConfigContentUsersChange.php",
            data: "idcusers=" + uidcchange + "&eFConfigChangeAction=CUserRightsRes" + "&eFConfigChangeValue=" + uidcchangeval + "&uniquid=" + uniqid(),
            success: function (data) {
                console.log("eFEditorVConfig.js #33");
                $(document).find('#eFUCOK').fadeIn(300).fadeOut(300);
            },
            cache: false
        });
    });

    $(document).on('change', 'input[name=USERRIGHTSPUB]', function () {
        console.log("eFEditorVConfig.js #42-1");
        var uidcchange = $(this).attr('data-idcusers');
        var uidcchangeval = $(this).attr('value');
        $.ajax({
            async: false,
            type: "GET",
            url: "_ajax/eFEditorVConfigContentUsersChange.php",
            data: "idcusers=" + uidcchange + "&eFConfigChangeAction=CUserRightsPub" + "&eFConfigChangeValue=" + uidcchangeval + "&uniquid=" + uniqid(),
            success: function (data) {
                console.log("eFEditorVConfig.js #53");
                //alert('The user rights for Resources have been changed to ' + uidcchangeval + '!');
                $(document).find('#eFUCOK').fadeIn(300).fadeOut(300);
            },
            cache: false
        });
    });

    $(document).on('change', 'input[name=USERMOVIERIGHTS_SETALL]', function () {
        console.log("eFEditorVConfig.js #42");
        var uidcchange = $(this).attr('data-idcusers');
        var uidcchangeval = $(this).attr('value');
        $.ajax({
            async: false,
            type: "GET",
            url: "_ajax/eFEditorVConfigContentUsersChange.php",
            data: "idcusers=" + uidcchange + "&eFConfigChangeAction=CUserRightsMoviesSetAll" + "&eFConfigChangeValue=" + uidcchangeval + "&uniquid=" + uniqid(),
            success: function (data) {
                console.log("eFEditorVConfig.js #52");
                $(document).find('#eFConfigUserDetailMovieList').load("_ajax/eFEditorVConfigContentUsersChange.php?idcusers=" + uidcchange + "&eFConfigChangeAction=CUserRightsMoviesSetRefresh&eFConfigChangeValue=" + uidcchangeval + "&uniquid=" + uniqid());
                $(document).find('#eFUCOK').fadeIn(300).fadeOut(300);
            },
            cache: false
        });
    });

    $(document).on('change', '#eFConfigUserDetailMovieList input[type=radio]', function () {
        console.log("eFEditorVConfig.js #64");
        var uidcchange = $(this).attr('data-idu');
        var midcchange = $(this).attr('data-idm');
        var uidcchangeval = $(this).attr('value');
        $.ajax({
            async: false,
            type: "GET",
            url: "_ajax/eFEditorVConfigContentUsersChange.php",
            data: "idcusers=" + uidcchange + "&idm=" + midcchange + "&eFConfigChangeAction=CUserRightsMoviesSetI&eFConfigChangeValue=" + uidcchangeval + "&uniquid=" + uniqid(),
            success: function (data) {
                console.log("eFEditorVConfig.js #75");
                $(document).find('#eFUCOK').fadeIn(300).fadeOut(300);
            },
            cache: false
        });
    });



});


/* General Functions */
/* Unique ID */
function uniqid() {
    console.log("eFEditorVConfig.js -uniqid");
    var newDate = new Date;
    return newDate.getTime();
}
