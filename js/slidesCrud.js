$(function () {
        var active_lesson = sessionStorage.active_lesson;
        var slide = new Slide(active_lesson, '#slideList');
        slide.getSlidesByLesson();

    CKEDITOR.replace('editorx');

    $('#searchResourse #searchValue').on("keyup", function () {
        var searchValue = "";
        searchValue = $('#searchResourse #searchValue').val();
        var searchValuex = searchValue.replace(/  +/g, ' ');
        if (searchValuex != "" && searchValuex.length > 2 && searchValuex != " ") {
            searchResources(searchValuex);
        } else {
            $('.resourceList').html("");
        }
    });
    $('#addNewSlideForm').submit(function (e) {
        event.preventDefault();
        if (!minmax(3, 40, "#addNewSlideForm #SlideName", "A Real Slide name is required", "#addNewSlideForm .SlideNameLabel")) {
            return false;
        } else {
            slide.addSlide();
            console.log('Adding content...');
        }

    });
    $('#delSlideBtn').click(function (e) {
        e.preventDefault();
        console.log(' Good');
        slide.delSlide();
    });

    $('.backToLessons').click(function (e) {
        e.preventDefault();
        $('#content-area').html("");
        var link = $(this).attr('href');
        backToLessons(link);
    });

    addResource();

});

function backToLessons(link) {
    var lastTopicById = sessionStorage.lastTopicById;
    $('#content-area').load(link, function () {
        sessionStorage.current_page = link;
        $(".modal").modal("hide");
    });
}

function searchResources(strings) {
    var searchResourceSettings = {
        "type": "GET",
        "async": !0,
        "dataType": "json",
        "url": "../api/resource/search/" + strings,
        "headers": {}
    };
    $.ajax(searchResourceSettings).success(function (response) {
        //console.log(JSON.stringify(response));
        if (JSON.stringify(response).length < 3) {
            notify("No results Found", "warning");
            // $('.resourceList').html("<p>The word must be 3 letters long and above</p>");
        }
        $('.resourceList').html("");
        var appendData = "";
        $.each(response, function (key, value2) {
            appendData += "<div class='row'>" +
                "<div url='" + value2.url + "' class='col-md-6'>" +
                "<div class='detailsN pull-left' style='margin-right:5%;'>" +
                "<a href='#'><h4 class='resourceName text-primary'>" + value2.resource_name + "</h4></a>" +
                "</div>" + "</div>" + "<div class='col-md-6'>" +
                "<div class='pull-left btn-group btn-group-xs' style='margin-top:10px; margin-bottom:10px;'>" +
                "<a href='" + value2.url + "' target='blank' class='btn btn-default'><span class='fa fa-cloud-download'> </span></a>" +
                "<button data-link='" + value2.url + "' class='copyLink btn btn-default'><span class='fa fa-copy'> </span></button>" +
                "<button value='" + value2.resource_id +
                "' class='indResource btn btn-default' data-target='#editResource' data-toggle='modal'><span class='fa fa-edit'> </span></button>" +
                "</div>" + "</div>" + "</div>";
        });
        $('.resourceList').html(appendData);
        $('.indResource').click(function (e) {
            e.preventDefault();
            var valueX = $(this).attr("value");
            editResource(valueX);
        });
        $('.copyLink').click(function (e) {
            var linkToImg = $(this).attr('data-link');
            // Get the editor instance that you want to interact with.
            var editor = CKEDITOR.instances.editorx;
            var value = '<img style="height:200px; width:200px;" src="' + linkToImg + '">';

            // Check the active editing mode.
            if (editor.mode == 'wysiwyg') {
                // Insert HTML code.
                // http://docs.ckeditor.com/#!/api/CKEDITOR.editor-method-insertHtml
                editor.insertHtml(value);
            } else
                alert('You must be in WYSIWYG mode!');
        });
    });
}

function editResource(id) {
    editUnitByIdSettings = {
        "type": "GET",
        "async": !0,
        "dataType": "json",
        "url": "../api/resource/" + id,
        "headers": {
            "cache-control": "no-cache"
        }
    };

    $.ajax(editUnitByIdSettings).done(function (response) {
        var fileEdit = response[0];
        $('#editResourceForm #ResourceNameEdit').val(fileEdit.resource_name);
        $('#editResourceForm .pic').attr("src", fileEdit.url);
    });
    $("#editResourceForm").ajaxify({
        url: '../api/resource/edit/' + id,
        validator: beforeEditResource,
        onSuccess: callBackMethodEdit
    });

    function callBackMethodEdit(responseo) {
        console.log(JSON.stringify(responseo));
        if (responseo.status === "failed") {
            notify(responseo.message, 'warning');
        } else {
            notify("Image details updated ", 'success');
            $(".modal-backdrop").fadeOut();
            $(".modal").modal("hide");
        }
    }

    function beforeEditResource() {
        var obj = {};
        $('.ResourceNameLabel').text("Resource Name");
        $('.resourceFileLabel').text("Upload Resource");
        $('label').removeClass('text-danger');
        if (!minmax(3, 40, "#editResourceForm #ResourceNameEdit", "Please give a Resource a name", "#editResourceForm .ResourceNameLabel")) {
            obj.status = !1;
        } else {
            obj.status = !0;
        }
        var formx = {};
        obj.postdata = formx;
        return obj;
    }
}

function addResource() {
    $("#addNewResourceForm").ajaxify({
        url: '../api/resource',
        validator: beforeSubmit,
        onSuccess: callBackMethodo
    });

    function callBackMethodo(responseo) {
        console.log(JSON.stringify(responseo));
        if (responseo.status === "failed") {
            notify(responseo.message, "warning");

        } else {
            notify("Resource added sucessfully", "success");
            $('#addNewResourceForm')[0].reset();

        }
    }

    function beforeSubmit() {
        var obj = {};
        $('.ResourceNameLabel').text("Resource Name");
        $('.resourceFileLabel').text("Upload Resource");
        $('label').removeClass('text-danger');
        if (!minmax(3, 20, "#addNewResourceForm #ResourceName", "Please give a Resource a name", "#addNewResourceForm .ResourceNameLabel")) {
            obj.status = !1;
        } else {
            obj.status = !0;
        }
        var formx = {};
        obj.postdata = formx;
        return obj;
    }
}

function Slide(li="") {
    var lessonId = li;
    $('#slideList').attr("lesson-id", lessonId);
    var lsId= $('#slideList').attr('lesson-id');
    
    //getlesson by Id
    function loadPreview(url) {
        var uncachedUrl = url;
        uncachedUrl += '?_=' + (new Date()).getTime();
        $('.loadpInner').html("");
        $('.loadpInner').load(uncachedUrl);
    }
    this.getSlidesByLesson = function () {
        if (typeof lessonId === 'undefined' && typeof lsId === 'undefined' && lsId != lessonId) {
            location.reload();
         }
         else {
           // lessonId =lsId;
            console.log("Session: "+ lessonId);
            console.log("Form: "+ li);
         }
        //prepare the location to be empty
        $('#slideList').html("");
        
        //getSettings
        var getSlideSettings = {
            "type": "GET",
            "dataType": "json",
            "url": "../api/slides/lesson/" + lessonId,
            "cache": false,
            "headers": {
                "cache-control": "no-cache"
            }
        };

        //run the ajax to get Slides
        var responsed = "";
        $.ajax(getSlideSettings).success(function (response) {
            responded = JSON.stringify(response);
            //console.log(responded);
            if (responded.length < 3 || responded.length === "2") {
                loadPreview("../resources/slides/template.html");
            } else {
                loadPreview(response[0].url);
            }
            var appendData = "";
            $.each(response, function (key, value) {
                appendData += "<tr><td class='clickPrev' data-target='" +
                    value.url + "'>" + value.slide_name + "</td>" +
                    "<td><button id= 'slideId'" + key + " value='" + value.slide_id +
                    "' data-target='#slideContent' data-toggle='modal' class='indslide btn btn-default btn-xs'><span class='fa fa-edit'></span></button></td>" +
                    "<td><button value='" + value.slide_id + "' class='indslideDel btn btn-default btn-xs' data-target='#deleteSlide' data-toggle='modal'><span class='fa fa-times'></span></button></td>" +
                    "</tr>";
            });
            $('#slideList').html(appendData);
            $('td.clickPrev').first().addClass('btn-primary');
            $('.clickPrev').click(function (e) {
                if ($('.clickPrev').hasClass('btn-primary')) {
                    $('.clickPrev').removeClass('btn-primary');
                }
                e.preventDefault();
                var slideValue = $(this).attr("data-target");
                $(this).addClass('btn-primary');
                loadPreview(slideValue);
            });
            $('.indslide').on('click', function () {
                var slideId = $(this).attr("value");
                editSlide(slideId);
            });

            $('.indslideDel').on('click', function () {

                var slideId = "";
                slideId = $(this).attr("value");
                // slide.delSlide(slideId);

                var approveBtn = "";
                approveBtn = $('#delSlideBtn');
                approveBtn.val(slideId);

            });

        }).error(function (response) {
            responded = JSON.stringify(response);
            console.log(responded);
            loadPreview("../resources/slides/template.html");
        });
    }

    function editSlide(slideId = "") {
        // console.log("You are editing the slide " + slideId);
        
        var getSlideByIdSettings = "";
        getSlideByIdSettings = {
            "dataType": "json",
            "type": "GET",
            "url": "../api/slides/" + slideId,
            "headers": {
                "cache-control": "no-cache"
            }
        };
        $.ajax(getSlideByIdSettings).success(function (response) {
            $('#editSlideForm #SlideNameEdit').val(response[0].slide_name);
            $('#editSlideForm').attr('slide-id', response[0].slide_id);
            var urlEdit = response[0].url;
            $.get(urlEdit, function (data) {
                CKEDITOR.instances.editorx.setData(data);
            });

            $("#editSlideForm").submit(function (e) {
                e.preventDefault();
                //console.log('Submitting');
                // editSlide(slideId);
                if (!minmax(3, 40, "#editSlideForm #SlideNameEdit", "A Real Lesson name is required", "#editSlideForm .SlideNameLabel")) {
                    return false;
                }

                if (typeof lessonId === 'undefined') {
                   lessonId= $('#slideList').attr('lesson-id');
                   console.log("lesson id was undefined");
                }
                var slideName = "";
                var slideContent = "";
                var slideId = "";
                slideName = $('#editSlideForm #SlideNameEdit').val();
                slideContent = $('#editSlideForm #editorx').val();
                slideIded = $('#editSlideForm').attr('slide-id');
                var formEdit = "";
                formEdit = {
                    "SlideName": slideName,
                    "LessonName": lessonId,
                    "editorx": slideContent
                };
                var formEditSettings = "";
                formEditSettings = {
                    "type": "POST",
                    //"dataType": "json",
                    "data": formEdit,
                    "url": '../api/slides/edit/' + slideIded,
                };
                $.ajax(formEditSettings).success(function (response) {
                    if (response.status === "error" || response.status === "Error" || response.status === "Failed" || response.status === "failed" || response.status === "fail") {
                        notify("Sorry " + response.message, "warning");
                        console.log(JSON.stringify(response));
                    } else {
                        notify("Your slide is saved succesfully", "success");
                        var recallSlide = new Slide(lessonId);
                        recallSlide.getSlidesByLesson();
                    }

                });
            });
        });
    }
    this.addSlide = function () {

        console.log('Submitting');
        // editSlide(slideId);

        var slideName = $('#SlideName').val();
        var formx = {
            "SlideName": slideName,
            "LessonName": lessonId
        };
        console.log(JSON.stringify(formx));
        var formAddSettings = "";
        formAddSettings = {
            "type": "POST",
            //"dataType": "json",
            "data": formx,
            "url": '../api/slides'
        };
        $.ajax(formAddSettings).success(function (response) {
            if (response.status === "error" || response.status === "Error" || response.status === "Failed" || response.status === "failed" || response.status === "fail") {
                notify("Sorry " + response.message, "warning");
                console.log(JSON.stringify(response));
            } else {
                $('#addNewSlideForm')[0].reset();
                notify("Your slide is saved succesfully", "success");
                                // getSlidesByLesson();
                //location.reload();
                var recallSlide = new Slide(lessonId);
                recallSlide.getSlidesByLesson();
                // location.reload();
            }

        });
    }

    this.delSlide = function () {
        console.log('deleting..');
        var slidIded = "";
        var approveBtn = "";
        approveBtn = $('#delSlideBtn');
        slidIded = approveBtn.val();
        var delSlideSettings = "";
        delSlideSettings = {
            "type": "GET",
            "async": !0,
            "dataType": "json",
            "url": "../api/slides/delete/" + slidIded,
            "headers": {
                "cache-control": "no-cache"
            }
        };
        $.ajax(delSlideSettings).success(function (response) {
            notify("Slide has been removed", "success");
            var recallSlide = new Slide(lessonId);
            recallSlide.getSlidesByLesson();
            //location.reload();
        });

    }
}