$(function () {
    if (sessionStorage.active_subject > 0 && sessionStorage.subjectName.length > 0) {

        $('#popStudy').modal('show');
        getUnits(sessionStorage.active_subject, 1);
        $('#subjectName').text(sessionStorage.subjectName);
        $('.termSelect').attr('data-id', sessionStorage.active_subject);

    }
    var defaultText = "<div class='defaultPage'><br /><img style='height:50px;' src='./images/klc.png' alt='kas'><br /><br /><h1>Hello, Welcome to " + sessionStorage.subjectName + "</h1><p style='font-size:18px;'>Browse the Units Modules on the left panel to continue</p><br /><br /><img class='pacman' src='./images/pacman.gif'></div>";
    $('.activeSlideView').html(defaultText);

    $('.closePopUp').click(function () {
        sessionStorage.active_subject = "";
        sessionStorage.subjectName = "";
    });

    $('.toggle-bar').click(function () {
        $('.leftPanel ').fadeToggle('fast');
    });
    getenrolledClasses();
    $('.footer').css({
        'display': 'none'
    });
    $('body').on("change", ".termSelect", function () {
        var termId = parseInt($(this).val());
        var subjectId = $(this).attr('data-id');
        if (termId > 0) {
            getUnits(subjectId, termId);
        } else {
            notify("No Units Availble", "warning");
        }
    });

    $('.unitList').on("click", ".unitGroup .unithead", function () {
        $('.title-bar-light').removeClass('title-bar-light-active');

        $(this).addClass('title-bar-light-active');

        var unitId = $(this).attr('data-id');

        var status = $(this).attr('status');

        var unitId3 = $(this).parent('.unitGroup');

        if (status == 0) {
            unitId3.find('.topicList').show();
            getTopics(unitId, unitId3);
        } else if (status == '1') {
            unitId3.find('.topicList').slideToggle('fast');
        }

    });
    $(document.body).on('click', '.printBtn', function (e) {

        e.preventDefault();
        $('#section-to-print .activeSlideView').css({
            'background-image': 'url(./images/klc_watermark_lightest.png)',
            'background-position': 'center',
            'background-repeat': 'repeat-y',
            'background-size': '50%'
        });
        var delay = 2000;
        setTimeout(function () {
            var contentPrint = "";
            var winPrint = "";
            contentPrint = $('#section-to-print .PrintBox').html();
            winPrint = window.open();
            winPrint.document.write(contentPrint);
            winPrint.print();
            //window.print();
        }, delay);
        //$('#section-to-print .activeSlideView').css({});
    });

    $('body').on("click", ".topic", function () {

        $('.topic').removeClass('topicActive');
        $(this).addClass('topicActive');

        //    $('.topic').removeClass('activeTopic');
        //  $(this).addClass('activeTopic');
        var topicId = $(this).attr('data-id');
        var topicName = $(this).text();
        getLessonsByTopic(topicId, topicName);
    });

    $('body').on("click", ".lesson", function () {
        $('.lesson').removeClass('slideActive');
        $(this).addClass('slideActive');
        var lessonId = $(this).attr('data-id');
        getSlidesByLesson(lessonId);
    });

    $('body').on("click", ".slide", function () {
        $('.slide').removeClass('slideActive');
        $(this).addClass('slideActive');
        var slide_url = $(this).attr('data-url');
        var finalLink = slide_url.substring(3);
        loadSlide(finalLink);
    });

});

function getUnits(subjectId = "", termId = "") {
    console.log(subjectId);
    var getUnitsByTermSettings = {
        "async": !0,
        "dataType": "json",
        "type": "GET",
        ///units/subject/152?term=1
        "url": "./api/units/subject/" + subjectId + "?term=" + termId,
        "headers": {
            "cache-control": "no-cache"
        }
    };
    $.ajax(getUnitsByTermSettings).success(function (responsed) {
        $('.unitList').html("");
        var theme = responsed.themes;
        // console.log(theme.length);
        if (theme.length < 0 || theme.length == 0) {
            notify("Sorry, the content you are looking for has not been found.", "warning");
        } else if (theme.length > 0) {
            var appendData = "";
            $.each(theme, function (key, themex) {
                var theme_idx = themex.theme_id;
                appendData += '<div class="unitGroup">' +
                    '<div id="unit' + themex.theme_id + '" status="0" data-id="' + themex.theme_id + '" class="unithead title-bar-light"><p><i class="fa fa-snowflake-o"> </i> ' + themex.theme_name + ' <span class="showArrow pull-right fa fa-angle-down"> </span> </p></div>' +
                    '<div class="topicList">' +

                    '</div>' +
                    '</div>' +
                    '</div>';

            });
            //o
            $('.unitList').html(appendData);
            var firstUnit = $('.unitList .unitGroup:first');
            firstUnit.find('.title-bar-light').addClass('title-bar-light-active');
            var unitId = firstUnit.find('.unithead').attr('data-id');
            var unitId2 = firstUnit.find('.unithead').attr('id');
            var unitId3 = "#" + unitId2;
            //$(unitId3 +' .topicList').show();          
            $(unitId3 + ' .topicList').show();
            getTopics(unitId, firstUnit);

        }

    });

}

function getLessonsByTopic(topicId = "", topicName = "") {
    $('#activeTopic').text(topicName);
    var getSettings = {
        "async": !0,
        "dataType": "json",
        "type": "GET",
        "url": "api/lessons/topic/" + topicId,
        "headers": {
            "cache-control": "no-cache"
        }
    };
    $.ajax(getSettings).success(function (response) {
        console.log(JSON.stringify(response));
        if (response.length < 0 || response.length == 0) {
            notify("Sorry, the content you are looking for has not been found.", "warning");
        } else if (response.length > 0) {
            $('.lessonList').html("");
            var appendData = "";
            $.each(response, function (key, value) {
                appendData += '<li class="lesson" data-id="' + value.lesson_id + '"><i class="fa fa-leanpub"> </i> ' + value.name + '</li>';

                //var appendTopic;
            });
            $('.lessonList').html(appendData);
            var firstLesson = $('.lessonList .lesson:first');
            var lessonId = firstLesson.attr('data-id');
            firstLesson.addClass('slideActive');
            getSlidesByLesson(lessonId);
        }
    });
}

function getTopics(unitId = "", element = '') {
    var getSettings = {
        "async": !0,
        "dataType": "json",
        "type": "GET",
        "url": "./api/topics/theme/" + unitId,
        "headers": {
            "cache-control": "no-cache"
        }
    };
    $.ajax(getSettings).success(function (response) {
        element.find('.unithead').attr("status", "1");
        //console.log(JSON.stringify(response));
        if (response.length < 0 || response.length == 0) {
            notify("Sorry, the content you are looking for has not been found.", "warning");
        } else if (response.length > 0) {
            element.find('.topicList').html("");
            var status;
            var appendData = "";
            $.each(response, function (key, value) {

                if (key == 0) {
                    status = "activeTopic";
                } else {
                    status = "";
                }
                appendData += '<ul class="topicGroup ' + status + '" data-name="' + value.topic_name + '" data-id="' + value.topic_id + '">' +
                    '<li class="topic" data-id="' + value.topic_id + '"><i class="fa fa-tags"> </i> ' + value.topic_name + '</li>' +
                    '</ul>';

                //var appendTopic;
            });
            element.find('.topicList').html(appendData);
        }
    });

}

function getenrolledClasses() {

    var formSettings = {
        "type": "GET",
        "async": true,
        "dataType": "json",
        "url": "api/student/enrollment",
        "headers": {
            "cache-control": "no-cache"
        }
    };
    $.ajax(formSettings).success(function (response) {

        $('.classListed').html("");
        if (response.status == 'failed') {
            notify("No classes availbale yet for study", "warning")
        } else {
            var appendData = "";
            $.each(response.data, function (key, value) {
                var class_image = value.class_pic;

                var imagef = class_image.substring(3);
                var subs;

                if (value.subscription_status == 0) {
                    subs = "Pending";
                } else if (value.subscription_status == 1) {
                    subs = "Active";
                }
                appendData += '<div class="classGroup" data-id="' + value.class_id + '">' +
                    '<div class="image" style="background-image:url(' + imagef + ');">' +
                    '<span class="">0%</span>' +
                    '</div>' +
                    '<div class="description">' +
                    '<h4>' + value.class_name + '</h4>' +
                    ' <p>Subscription status: <span class="text-danger">' + subs + '</span></p>' +
                    '</div>' +
                    '</div>';
            });
            $('.classListed').html(appendData);
            var firstClassInARow = $('.classListed .classGroup:first');
            firstClassInARow.addClass('classGroupActive');
            var activeClassId = firstClassInARow.attr("data-id");
            getsubjectsByClassesActive(activeClassId);
        }

    });

}

function getsubjectsByClassesActive(class_id) {
    var formsettings = {
        "type": "GET",
        "async": true,
        "dataType": "json",
        "url": "api/subjects/class/" + class_id,
        "headers": {
            "cache-control": "no-cache"
        }
    };
    $.ajax(formsettings).success(function (response) {
        //cs_id
        //console.log(JSON.stringify(response));
        $('.subjectsList').html("");

        if (response.status == 'failed') {

            notify("Sorry Cannot get subjects for this class", "warning");

        } else {
            var appendDatac = "";
            $.each(response, function (key, value) {
                // console.log(JSON.stringify(response));
                var class_image = value.subject_logo;

                var imagef = class_image.substring(3);

                appendDatac += '<div class="subjectGroup" data-name="' + value.subject_name + '" data-id="' + value.cs_id + '" data-toggle="modal" data-target="#popStudy">' +
                    '<div class="image" style="background-image:url(' + imagef + ');"></div>' +
                    '<div class="description">' +
                    '<h4>' + value.subject_name + '</h4>' +
                    '<p>Subject No: ' + value.subject_id + '</p>' +
                    '</div>' +
                    '</div>';

            });
            $('.subjectsList').html(appendDatac);
            $('.subjectGroup').on('click', function (e) {
                e.preventDefault();
                var subjectId = $(this).attr('data-id');
                var subjectName = $(this).attr('data-name');
                sessionStorage.active_subject = subjectId;
                sessionStorage.subjectName = subjectName;
                //console.log(subjectId);
                $('.termSelect').attr('data-id', subjectId);
                $('#subjectName').text(subjectName);
                var defaultText = "<div class='defaultPage'><br /><img style='height:50px;' src='./images/klc.png' alt='kas'><br /><br /><h1>Hello, Welcome to " + sessionStorage.subjectName + "</h1><p style='font-size:18px;'>Browse the Units Modules on the left panel to continue</p><br /><br /><img class='pacman' src='./images/pacman.gif'></div>";
                $('.activeSlideView').html(defaultText);
                getUnits(subjectId, 1);
                $('.lessonList, .slideList, .slideCap, #activeTopic').html("");

            });
        }

    });

}

function getSlidesByLesson(lessonId = "") {
    $('.slideCap').html("");

    var getSettings = {
        "async": !0,
        "dataType": "json",
        "type": "GET",
        "url": "api/slides/lesson/" + lessonId,
        "headers": {
            "cache-control": "no-cache"
        }
    };
    $.ajax(getSettings).success(function (response) {
        $('.slideCap').html("<span class=''>Slides: </span>");
        //console.log(JSON.stringify(response));
        if (response.length < 0 || response.length == 0) {
            notify("Sorry, the content you are looking for has not been found.", "warning");
        } else if (response.length > 0) {
            $('.slideList').html("");
            // $('.slideListGroup').prepend("<span class=''>Slides: </span>");
            //		
            var appendData = "";
            $.each(response, function (key, value) {
                var slideNumber = key + 1;
                appendData += '<li class="slide" data-id="' + value.slide_id + '" data-url="' + value.url + '">' + slideNumber + '</li>';

            });
            $('.slideList').html(appendData);
            var firstSlide = $('.slideList .slide:first');
            firstSlide.addClass('slideActive');
            var slideUrl = firstSlide.attr('data-url');
            var finalLink = slideUrl.substring(3);
            loadSlide(finalLink);
        }
    });
}

function loadSlide(url = "") {
    $('.activeSlideView').html("");
    $('.activeSlideView').load(url);
}