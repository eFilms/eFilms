$(document).ready(function () {
    console.log("eFEditorVResourcesInMovies.js #1");
    $('#eFResourcesSelect ul li.content').click(function () {
        console.log("eFEditorVResourcesInMovies.js #4");
        var eFContentSelected = encodeURI($(this).attr('data-content'));
        var eFContentKat = encodeURI($(this).attr('data-kat'));
        $('#eFResourcesSelect ul li.content').removeClass('eFResSelected');
        $(this).addClass('eFResSelected');
        $('#eFResourcesContent').load('_ajax/eFEditorVResourcesContent.php?eFContentSelected=' + eFContentSelected + '&eFContentKat=' + eFContentKat + '&uniquid=' + uniqid());
    });

    /**************** Filter Resource Objects **********************************/
    $(document).on('keyup', '#eFResourcesFilterInput', function () {
        console.log("eFEditorVResourcesInMovies.js #14");
        if (event.keyCode == 27 || $(this).val() == '') {
            //esc löscht den filter
            $(this).val('');
            //Alle sichtbar machen, da nichts im Filter steht
            $('.efResourceUnit1').removeClass('eFResourcesFilterFound').removeClass('visible').show().addClass('visible').find('.efResourceUnit2fieldcontent').removeClass('visible').show().addClass('visible').removeClass('eFResourcesFilterHighlight');
        }
        //Wenn Input vorhanden, dann Filtern
        else {
            filter($('.efResourceUnit1').find('.efResourceUnit2fieldcontent'), $(this).val());
        }
    });

    /*** Filter Group FUNKTIONIERt NOCH NICHT ***/
    $(document).on('change', '#eFResourcesFilterGroup', function () {
        console.log("eFEditorVResourcesInMovies.js #29");

        var eFGroupSuchTerm = $(this).find(':selected').html();
        if (event.keyCode == 27 || eFGroupSuchTerm == '') {
            //esc löscht den filter
            $(this).val('');
            //Alle sichtbar machen, da nichts im Filter steht
            $('.efResourceUnit1').removeClass('eFResourcesFilterFound').removeClass('visible').show().addClass('visible').find('.efResourceUnit1Group').removeClass('visible').show().addClass('visible').removeClass('eFResourcesFilterHighlight');
        }
        //Wenn Input vorhanden, dann Filtern
        else {
            filterGroup($('.efResourceUnit1').find('.efResourceUnit1Group'), eFGroupSuchTerm);
        }
    });


    function filter(inputtext, anfrage) {
        console.log("eFEditorVResourcesInMovies.js -filter()");
        anfrage = $.trim(anfrage); //white spaces raus
        anfrage = anfrage.replace(/ /gi, '|'); // Leerzeichen wird OR für regex suche
        var hugo = new Array();
        $(inputtext).each(function () {
            console.log("eFEditorVResourcesInMovies.js #52");

            if ($(this).text().search(new RegExp(anfrage, "i")) < 0) {
                $(this).removeClass('eFResourcesFilterHighlight');
                $(this).parent().parent().parent().not('eFResourcesFilterFound').hide().removeClass('visible')
            } else {
                $(this).parent().parent().parent().addClass('eFResourcesFilterFound').show().addClass('visible');
                $(this).addClass('eFResourcesFilterHighlight').show().addClass('visible');
                hugo.push($(this).parent().parent().parent().attr('data-idl1'));
            }
        });
        jQuery.each(hugo, function (i, val) {
            console.log("eFEditorVResourcesInMovies.js #73");
            $('.efResourceUnit1[data-idl1="' + val + '"]').addClass('eFResourcesFilterFound').show().addClass('visible');
        });
    }

    function filterGroup(inputtext, anfrage) {
        console.log("eFEditorVResourcesInMovies.js -filterGroup()");

        var hugo = new Array();
        $(inputtext).each(function () {
            console.log("eFEditorVResourcesInMovies.js #86");
            if ($(this).text().search(new RegExp(anfrage, "i")) < 0) {
                $(this).removeClass('eFResourcesFilterHighlight');
                $(this).parent().not('eFResourcesFilterFound').hide().removeClass('visible')
            } else {
                $(this).parent().addClass('eFResourcesFilterFound').show().addClass('visible');
                $(this).addClass('eFResourcesFilterHighlight').show().addClass('visible');
                hugo.push($(this).parent().attr('data-idl1'));
            }
        });
        jQuery.each(hugo, function (i, val) {
            console.log("eFEditorVResourcesInMovies.js #106");
            $('.efResourceUnit1[data-idl1="' + val + '"]').addClass('eFResourcesFilterFound').show().addClass('visible');
        });
    }

    /**************** Delete L1 Object **********************************/
    $(document).on('click', '.efResourceUnit1DeleteObject', function () {
        console.log("eFEditorVResourcesInMovies.js #115");
        $(this).parent().find('.efResourceUnit1DeleteObjectWarning').show();
    });
    $(document).on('click', '#efResourceUnit1DeleteObjectWarningMessageButtonNO', function () {
        console.log("eFEditorVResourcesInMovies.js #120");
        $(this).parent().parent().parent().find('.efResourceUnit1DeleteObjectWarning').hide();
    });
    $(document).on('click', '#efResourceUnit1DeleteObjectWarningMessageButtonYES', function () {
        console.log("eFEditorVResourcesInMovies.js #124");
        var eFResourcesDelID = $(this).parent().parent().parent().attr('data-idl1');
        $.ajax({
            async: false,
            type: "GET",
            url: "_ajax/eFEditorVResourcesContentDelete.php",
            data: "eFResourcesDelID=" + eFResourcesDelID,
            success: function () {
                console.log("eFEditorVResourcesInMovies.js #133");
                var eFContentSelectedD = encodeURI($('#eFResourcesSelect ul li.eFResSelected').attr('data-content'));
                var eFContentKatD = encodeURI($('#eFResourcesSelect ul li.eFResSelected').attr('data-kat'));
                $('#eFResourcesContent').empty().load('_ajax/eFEditorVResourcesContent.php?eFContentSelected=' + eFContentSelectedD + '&eFContentKat=' + eFContentKatD + '&uniquid=' + uniqid());
            },
            cache: false
        });
    });
    /**************** New L1 Object **********************************/
    $(document).on('click', '#eFResourcesNewObject', function () {
        console.log("eFEditorVResourcesInMovies.js #144");
        var eFNewResourceType = encodeURI($(this).attr('data-type'));
        var eFNewResourceCategory = encodeURI($(this).attr('data-category'));
        var eFShortM1 = encodeURI($(this).attr('data-eFShortM1'));
        var eFShortM2 = encodeURI($(this).attr('data-eFShortM2'));
        $(this).parent().find('#efResourceUnitNewContainer').show();
        $(this).parent().find('#efResourceUnitNewContainerNewObject').load('_ajax/eFEditorVResourcesContentNew.php?eFNewResourceType=' + eFNewResourceType + '&eFNewResourceCategory=' + eFNewResourceCategory + '&eFShortM1=' + eFShortM1 + '&eFShortM2=' + eFShortM2 + '&uniquid=' + uniqid());
    });
    $(document).on('click', '#efResourceUnitNewContainerClose', function () {
        console.log("eFEditorVResourcesInMovies.js #154");
        $(this).parent().hide().find('#efResourceUnitNewContainerNewObject').empty();
    });
    /**************** New L2 Object **********************************/

    $(document).on('click', '#eFResourcesNewObjectFormNewSubObject', function () {
        console.log("eFEditorVResourcesInMovies.js #160");
        var eFNewL2AdditionalFieldname = $(this).parent().find('form input[name=eFResourcesNewObjectFormNewSubObjectNAME]').val();
        var eFNewL2AdditionalFieldtype = $(this).parent().find('form input[name=eFResourcesNewObjectFormNewSubObjectTYPE]:checked').val();
        if (eFNewL2AdditionalFieldname != '' && eFNewL2AdditionalFieldtype != '' && eFNewL2AdditionalFieldname != 'Type' && eFNewL2AdditionalFieldname != 'Group' && eFNewL2AdditionalFieldname != 'Object_Key' && eFNewL2AdditionalFieldname != 'Key' && eFNewL2AdditionalFieldname != 'Category') {
            switch (eFNewL2AdditionalFieldtype) {
                case 'text':
                    $(this).parent().parent().find('#eFResourcesNewObjectFormNewL2Additional').append('<div class="eFResourcesNewObjectFormNewL2"><div class="eFResourcesNewObjectFormNewL2Fieldname" data-fieldtype="' + eFNewL2AdditionalFieldtype + '">' + eFNewL2AdditionalFieldname + '</div><div class="eFResourcesNewObjectFormNewL2Fieldcontent"><input class="eFinput" type="text" value="" name="' + eFNewL2AdditionalFieldname + '"/></div></div>');
                    break;
                case 'image':
                    //$(this).parent().parent().find('#eFResourcesNewObjectFormNewL2Additional').append('<div class="eFResourcesNewObjectFormNewL2"><div class="eFResourcesNewObjectFormNewL2Fieldname" data-fieldtype="' + eFNewL2AdditionalFieldtype + '">' + eFNewL2AdditionalFieldname + '</div><div class="eFResourcesNewObjectFormNewL2Fieldcontent"><input class="eFinput" type="text" value="" name="' + eFNewL2AdditionalFieldname + '"/><form enctype="multipart/form-data" action="uploader.php" method="POST"><input type="hidden" name="MAX_FILE_SIZE" value="100000" />Choose a file to upload: <input name="uploadedfile" type="file" /><input type="submit" value="Upload File" /></form></div></div>');
                    break;
                case 'pdf':
                    //$(this).parent().parent().find('#eFResourcesNewObjectFormNewL2Additional').append('<div class="eFResourcesNewObjectFormNewL2"><div class="eFResourcesNewObjectFormNewL2Fieldname" data-fieldtype="' + eFNewL2AdditionalFieldtype + '">' + eFNewL2AdditionalFieldname + '</div><div class="eFResourcesNewObjectFormNewL2Fieldcontent"><input class="eFinput" type="text" value="" name="' + eFNewL2AdditionalFieldname + '"/><form id="Form1" name="Form1" method="post" action=""><input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_size; ?>" /> Select an image from your hard disk: <div>  <input type="file" name="fileToUpload" id="fileToUpload" size="18" />  <input class="eFResourcesNewObjectFormNewL2UploadButton" type="Submit" value="Submit" id="buttonForm" /> </div> </form> <img id="loading" src="loading.gif" style="display:none;" /> <p id="message"> <p id="result"></div></div>');
                    break;
            }
        }
    });
    /****************  L2 PopDown **********************************/
    $(document).on('click', '.eFResourcesNewObjectFormNewL2Fieldcontent .eFinput', function () {
        console.log("eFEditorVResourcesInMovies.js #179");
        $('.eFResourcesNewObjectFormNewL2Fieldcontent .eFinput').attr('data-tiptabstatus', '');
        $(this).attr('data-tiptabstatus', 'active');
        var position = $(this).offset();
        var position2 = $(this).position();
        var eFPopWeite = $(this).width() + 2;

        var eFResL2ContPopDownSearch = $(this).attr('name');
        if (eFResL2ContPopDownSearch == 'Type' || eFResL2ContPopDownSearch == 'Category' || eFResL2ContPopDownSearch == 'Object_Key') {
        }
        else {
            $('#efResourceUnitNewContainerPopDownContent').load('_ajax/eFEditorVResourcesContentNewPopDown.php?eFResL2ContPopDownSearch=' + eFResL2ContPopDownSearch);
            $('#efResourceUnitNewContainerPopDown').css('top', position.top - 30 + 'px').css('left', position2.left + 11 + 'px').css('width', eFPopWeite + 2 + 'px').show();
        }
    }).on('keyup', '.eFResourcesNewObjectFormNewL2Fieldcontent .eFinput', function () {
        console.log("eFEditorVResourcesInMovies.js #195");
        //Tabellenfilter
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
        console.log("eFEditorVResourcesInMovies.js #209");
        var eFTipTabInserter = $(this).html();
        $('.eFResourcesNewObjectFormNewL2Fieldcontent .eFinput[data-tiptabstatus=active]').val(eFTipTabInserter);
        $(document).find('#efResourceUnitNewContainerPopDownContent').empty();
        $(document).find('#efResourceUnitNewContainerPopDown').hide();
    });
    function filterPopDown(inputtext, anfrage) {
        console.log("eFEditorVResourcesInMovies.js -filterPopDown()");
        anfrage = $.trim(anfrage); //white spaces raus
        anfrage = anfrage.replace(/ /gi, '|'); // Leerzeichen wird OR für regex suche
        $(inputtext).each(function () {
            ($(this).text().search(new RegExp(anfrage, "i")) < 0) ? $(this).hide().removeClass('visible') : $(this).show().addClass('visible');
        });
    }
    ;

    $(document).on('click', '#efResourceUnitNewContainerPopDownClose', function () {
        console.log("eFEditorVResourcesInMovies.js #226");

        $(this).parent().find('#efResourceUnitNewContainerPopDownContent').empty();
        $(this).parent().hide();

    });

    /**************** Save L1 & L2 Object **********************************/
    $(document).on('click', '#efResourceUnitNewContainerSave', function () {
        console.log("eFEditorVResourcesInMovies.js #237");
        //eFNewObjektL1L2Array = $(this).parent().find('#eFResourcesNewObjectFormForm').serialize();
        var eFNewObjektL1L2_Array = '';
        $(this).parent().find('.eFResourcesNewObjectFormNewL2').each(function () {
            console.log("eFEditorVResourcesInMovies.js #242");
            var eFFieldnameL1L2 = $(this).find('.eFResourcesNewObjectFormNewL2Fieldname').html();
            var eFFieldtypeL1L2 = $(this).find('.eFResourcesNewObjectFormNewL2Fieldname').attr('data-fieldtype');
            var eFFieldcontentL1L2 = $(this).find('input.eFinput').val();
            eFNewObjektL1L2_Array += '|Fieldname:' + eFFieldnameL1L2 + ',Fieldtype:' + eFFieldtypeL1L2 + ',Fieldcontent:' + eFFieldcontentL1L2;

        });
        $.ajax({
            async: false,
            type: "GET",
            url: "_ajax/eFEditorVResourcesContentSaveNew.php",
            data: 'eFNewObjektL1L2_Array=' + encodeURI(eFNewObjektL1L2_Array) + '&uniqid=' + uniqid(),
            success: function () {
                console.log("eFEditorVResourcesInMovies.js #258");
                var eFContentSelectedD = encodeURI($('#eFResourcesSelect ul li.eFResSelected').attr('data-content'));
                var eFContentKatD = encodeURI($('#eFResourcesSelect ul li.eFResSelected').attr('data-kat'));
                $('#eFResourcesContent').empty().load('_ajax/eFEditorVResourcesContent.php?eFContentSelected=' + eFContentSelectedD + '&eFContentKat=' + eFContentKatD + '&uniquid=' + uniqid());
            },
            cache: false
        });
    });

/**
 * This is the action for the 'add' button when picking an Image-Relation in the editor
 */
     $(document).on('click', '.efResourceUnitNewContainerAddRel', function () {
        console.log("eFEditorVResourcesInMovies.js #270");
        var eFRelObjectKey = $(this).attr('data-key');

        $(document).find('input[name=eFRelationsInterfaceRelationIdentifier]').val(eFRelObjectKey);
        
        // The form data is populated when the user clicks the 'SetForm' button
    });

    $(document).on('click', '#eFRelationsInterfaceRelationOKButton', function () {
        console.log("eFEditorVResourcesInMovies.js #278");
        var eFRelFormID = $(this).attr('data-formid');
        var eFRelMedium = $(document).find('#eFRelationsInterfaceChoice span.selected').attr('data-medium');
        var eFRelRelationType = $(document).find('select[name=eFRelationsInterfaceRelationType] option:selected').val();
        var eFRelRelationIdentifier = $(document).find('input[name=eFRelationsInterfaceRelationIdentifier]').val();
        var eFRelFrom = $(document).find('input[name=eFRelationsInterfaceRelationFrom]').val();
        var eFRelTo = $(document).find('input[name=eFRelationsInterfaceRelationTo]').val();

        $(document).find('form[id=' + eFRelFormID + '] input[name=relation]').val(eFRelMedium);
        $(document).find('form[id=' + eFRelFormID + '] input[name=relation_relationType]').val(eFRelRelationType);
        $(document).find('form[id=' + eFRelFormID + '] input[name=relation_relationIdentifier]').val(eFRelRelationIdentifier);
        $(document).find('form[id=' + eFRelFormID + '] input[name=relation_relationIdentifier_from]').val(eFRelFrom);
        $(document).find('form[id=' + eFRelFormID + '] input[name=relation_relationIdentifier_to]').val(eFRelTo);

        $('#eFReSourcesFromMovieContainerTR').empty();
        $('#eFReSourcesFromMovieContainerContent').empty();
        $('#eFReSourcesFromMovieContainer').hide();

    });

});

/* General Functions */
/* Unique ID */
function uniqid() {
    console.log("eFEditorVResourcesInMovies.js -uniqid()");
    var newDate = new Date;
    return newDate.getTime();
}
