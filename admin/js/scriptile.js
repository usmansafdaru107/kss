NProgress.start();
$(document).ready(function () {
    NProgress.done();
    if (sessionStorage.current_page == 'slides.php' && sessionStorage.active_lesson > 0) {
        var active_lesson = sessionStorage.active_lesson;
        $('#content-area').load('slides.php'+ '?_=' + (new Date()).getTime(), function () {
            $('.loader').fadeOut(function () {
                $(".modal-backdrop").hide();
                $(".modal").modal("hide");
                // getSlides(active_lesson)
                //var slide = new Slide(active_lesson, '#slideList');
                //slide.getSlidesByLesson();
            })
        });
        $('#lessonLinked').addClass('activeSideLink')
    } else if (sessionStorage.current_page == 'lessons.php' && sessionStorage.lastTopicById > 0) {
        var lastTopicById = sessionStorage.lastTopicById;
        $('#content-area').load('lessons.php', function () {
            $('.loader').fadeOut(function () {
                $(".modal-backdrop").hide();
                $(".modal").modal("hide");
                paginate_lessons(idx = 0, dir = '', lastTopicById)
            })
        });
        $('#lessonLinked').addClass('activeSideLink')
    } else if (sessionStorage.current_page) {
        $('#content-area').load(sessionStorage.current_page, function () {
            $('.loader').fadeOut(function () {
                $(".modal-backdrop").hide();
                $(".modal").modal("hide")
            });
            var linkItem = sessionStorage.current_link;
            $('.nav-side-links').removeClass('activeSideLink');
            $('#' + linkItem).addClass('activeSideLink')
        })
    } else {
        $('#content-area').load("classes.php", function () {
            $('.loader').fadeOut(function () {
                $(".modal-backdrop").fadeOut();
                $(".modal").modal("hide");
                $('.nav-side-links').removeClass('activeSideLink');
                $('#classLink').addClass('activeSideLink')
            })
        })
    }
    $('.nav-side-links').click(function (e) {
        e.preventDefault();
        var activeLink = $(this).attr('id');
        $('.nav-side-links').removeClass('activeSideLink');
        $(this).addClass('activeSideLink');
        $('#content-area').html("");
        var link = $(this).attr('href');
        $('#content-area').load(link, function () {
            sessionStorage.current_page = link;
            sessionStorage.current_link = activeLink;
            $(".modal").modal("hide")
        })
    });
    $('.togglesideNav').click(function () {
        if ($('.togglesideNav').hasClass('onActive')) {
            $('.togglesideNav').removeClass('onActive');
            $('.sideNavLeft').animate({
                width: '15%',
            }, function () {
                $('.sm-text-rm').fadeIn()
            });
            $('.mainBox').animate({
                width: '85%',
            })
        } else {
            $('.togglesideNav').addClass('onActive');
            $('.sm-text-rm').hide();
            $('.sideNavLeft').animate({
                width: '3.9%',
            });
            $('.mainBox').animate({
                width: '96.1%',
            })
        }
    });
    $('a#logout').click(function () {
        var logoutSettings = {
            "method": "GET",
            "url": "../api/admin/logout",
            "headers": {
                "cache-control": "no-cache"
            }
        };
        $.ajax(logoutSettings).done(function () {
            sessionStorage.current_page = '';
            window.location.href = "login.php"
        })
    });
    $(document).ajaxSend(function () {
        $('.loader').fadeIn();
        NProgress.configure({
            showSpinner: !0
        });
        NProgress.start();
        $('#nprogress .bar').css({
            'background': '#00a1e0'
        });
        $('#nprogress .peg').css({
            'box-shadow': '0 0 10px #00a1e0, 0 0 5px #00a1e0'
        });
        $('#nprogress .spinner-icon').css({
            'border-top-color': '#fff',
            'border-left-color': '#fff'
        })
    });
    $(document).ajaxStart(function () {});
    $(document).ajaxStop(function () {
        NProgress.done();
        $('.loader').fadeOut()
    });
    var userName = $('#loginForm #username').val();
    var loginpassword = $('#loginForm #password').val();
    $('#loginForm #username').on("keyup", function (e) {
        if ($('.usernameLabel').hasClass('text-danger') || $('#loginForm #username').val().length > 2) {
            $('.usernameLabel').text("Username");
            $('.usernameLabel').removeClass('text-danger')
        } else if (userName.length < 3) {
            $('.usernameLabel').text("Incorect Username");
            $('.usernameLabel').addClass('text-danger')
        }
    });
    $('#loginForm #password').on("keyup", function (e) {
        if ($('.passwordLabel').hasClass('text-danger') || $('#loginForm #password').val().length > 5) {
            $('.passwordLabel').text("Password");
            $('.passwordLabel').removeClass('text-danger')
        } else if (loginpassword.length < 6) {
            $('.passwordLabel').text("Incorect Password");
            $('.passwordLabel').addClass('text-danger')
        }
    });
    $('#loginForm').submit(function (e) {
        var userName = $('#loginForm #username').val();
        var loginpassword = $('#loginForm #password').val();
        e.preventDefault();
        if (userName.length < 3) {
            $('#loginForm #username').focus();
            $('.usernameLabel').text("Incorect Username");
            $('.usernameLabel').addClass('text-danger');
            return !1
        }
        if (loginpassword.length < 6) {
            $('#loginForm #password').focus();
            $('.passwordLabel').text("Incorect Password");
            $('.passwordLabel').addClass('text-danger');
            return !1
        }
        $('#loginBtn').text("Signing in.");
        var loginData = $(this).serialize();
        var loginSettings = {
            "type": "POST",
            "dataType": "json",
            "url": "../api/admin/login",
            "headers": {
                "cache-control": "no-cache"
            },
            "data": loginData
        };
        $('#loginForm .form-error').fadeOut();
        $('#loginForm .form-success').fadeOut();
        $.ajax(loginSettings).success(function (response) {
            $('#loginBtn').text("Signing in..");
            // 
            if (response.status === "Failed" || response.status === "failed") {
                $('#loginForm .form-error').fadeIn();
                $('#loginBtn').text("Login");
                $('#loginForm .form-error').text("Sorry " + response.message);
                $('#loginBtn').text("Sign in");
                return !1
            } else if (response.status === "Warning") {
                $('#loginForm .form-error').fadeIn();
                $('#loginBtn').text("Login");
                $('#loginForm .form-error').text("Sorry " + response.message);
                $('#loginBtn').text("Sign in");
                return !1
            } else if (response.status === "success") {
                $('#loginForm .form-success').fadeIn();
                $('#loginForm .form-success').text(response.message);
                $('#loginBtn').text("Signing in...");
                window.location.href = "index.php"
            } else if (response.message === "Already Logged in") {
                $('#loginForm .form-success').text(response.message);
                $('#loginBtn').text("Signing in...");
                window.location.href = "index.php"
            } else {
                $('#loginForm .form-success').text(response.message)
            }
        });
    });
});

function imageValid(imageField, errorTxt, errorlabel) {
    var match = ['image/jpeg', 'image/png', 'image/jpg'];
    $(imageField).change(function () {
        var file = this.files[0];
        var imagefile = file.type;
        if (!((imagefile === match[0]) || (imagefile === match[1]) || (imagefile === match[2]))) {
            $(errorlabel).text(errorTxt);
            $(errorlabel).addClass("text-danger");
            return !1
        } else {
            $(errorlabel).text("Class Logo/ Image");
            $(errorlabel).removeClass("text-danger");
        }
    });
}

function imageValido(imageField) {
    var match = ['image/jpeg', 'image/png', 'image/jpg'];
    $(imageField).change(function () {
        var file = this.files[0];
        var imagefile = file.type;
        var imagefileSize = file.size;
        var imageInKbs = Math.round(imagefileSize / 1024);
        if (!((imagefile === match[0]) || (imagefile === match[1]) || (imagefile === match[2]))) {
            notify('File uploaded in not an image', 'error');
            $(imageField).val('');
            return !1
        } else if (imageInKbs > 500) {
            $(imageField).val('');
            notify('Image is large, (it should be less than 500Kbs)', 'error');
            return !1
        } else {
            $('.notification').hide();
            return !0
        }
    });
}

function minmax(min, max, idElement, error, classError) {
    var idElement2 = $(idElement).val();
    if (idElement2.length < min || idElement2.length > max) {
        $(idElement).focus();
        $(classError).text(error);
        $(classError).addClass('text-danger');
        return !1
    } else {
        return !0
    }
}

function minMax_a(min, max, idElement, errorText) {
    var idElement2 = $(idElement).val();
    if (idElement2.length < min || idElement2.length > max) {
        $(idElement).focus();
        notify(errorText, "error");
        return !1
    } else {
        return !0
    }
}

function selectValid(idElement, error, classError) {
    var idElement2 = $(idElement).val();
    if (idElement2 === "0") {
        $(idElement).focus();
        $(classError).text(error);
        $(classError).addClass('text-danger');
        return !1
    } else {
        return !0
    }
}

function selectValid_new(idElement, error) {
    var idElement2 = $(idElement).val();
    if (idElement2 === "0") {
        $(idElement).focus();
        notify(error, "error")
        return !1
    } else {
        return !0
    }
}

function imageErrorFix() {
    $('img').error(function () {
        $(this).attr("src", "../images/default_image.jpg")
    })
}

function notify(textM, type) {
    $('.notification').hide();
    if (type === "error") {
        mType = "#errorNot"
    } else if (type === "success") {
        mType = "#successNot"
    } else if (type === "warning") {
        mType = "#warnNot"
    } else {
        console.log("Error on Notify Plugin (var type)")
    }
    $(mType).slideDown(function () {
        $(mType + " p").text('');
        $(mType + " p").text(textM);
        $(mType).click(function () {
            $(this).slideUp()
        });
        setTimeout(function () {
            $(mType).slideUp();
        }, 40000);
    })
}
function initFilter(resultElement) {
    var getClassesSettings = {
        "type": "GET",
        "async": !0,
        "dataType": "json",
        "url": "../api/classes/tutor/logged_in",
        "headers": {
            "cache-control": "no-cache"
        }
    };
    $.ajax(getClassesSettings).success(function (response) {
        if (response.length < 0 || response.length === 0) {
            $(resultElement + ' .classList').html("");
            $(resultElement + ' .classList').append("<option selected value='0'>No classes avalible</option>")
        } else if (response.length > 0) {
            $(resultElement + ' .classList').html("");
            var appendData = "";
            $.each(response, function (key, value) {
                appendData += "<option value='" + value.class_id + "'>" + value.class_name + "</option>"
            });
            $(resultElement + ' .classList').html("<option value='0'>Select a Class</option>");
            $(resultElement + ' .classList').append(appendData)
        }
    });
    var selectedVal = $(resultElement + ' .classList').val();
    $('body').on("change", resultElement + " .classList", function () {
        var selectedVal = $(this).val();
        $(resultElement + ' .subjectList').html("");
        $(resultElement + ' .tutorList').html("");
        $(resultElement + ' .topicList').html("");
        $(resultElement + ' .lessonList').html("");
        if (selectedVal > 0) {
            getSubjectsByClass(selectedVal, resultElement)
        } else {
            $(resultElement + ' .subjectList').html("");
            $(resultElement + ' .subjectList').append("<option selected value='0'>No Subjects avalible</option>");
            $(resultElement + ' .tutorList').html("");
            $(resultElement + ' .tutorList').append("<option selected value='0'>No Tutors Avalible</option>");
            $(resultElement + ' .unitList').html("");
            $(resultElement + ' .unitList').append("<option selected value='0'>No Units avalible</option>");
            $(resultElement + ' .topicList').html("");
            $(resultElement + ' .topicList').append("<option selected value='0'>No Topics avalible</option>")
        }
    })
}

function getSubjectsByClass(id, resultElement) {
    var getSubjectsByClassSettings = {
        "async": !0,
        "dataType": "json",
        "type": "GET",
        "url": "../api/subjects/class/" + id,
        "headers": {
            "cache-control": "no-cache"
        }
    };
    $.ajax(getSubjectsByClassSettings).success(function (response) {
        if (response.length < 0 || response.length === 0) {
            $(resultElement + ' .subjectList').html("");
            $(resultElement + ' .subjectList').append("<option selected value='0'>No Subjects avalible</option>")
        } else if (response.length > 0) {
            $(resultElement + ' .subjectList').html("");
            $(resultElement + ' .subjectList').append("<option selected value='0'>Select a Subject</option>");
            var appendData = "";
            $.each(response, function (key, value) {
                appendData += "<option value='" + value.cs_id + "'>" + value.subject_name + "</option>"
            });
            $(resultElement + ' .subjectList').html(appendData);
            var val = $(resultElement + ' .subjectList').val();
            if (val > 0) {
                if ($('#tutor').length) {
                    getTutorBySubject(val)
                }
                if ($('#UnitName').length) {
                    getUnitsBySubject(val, resultElement)
                }
            } else {
                $(resultElement + ' .tutorList').html("");
                $(resultElement + ' .tutorList').append("<option selected value='0'>No Tutors Avalible</option>");
                $(resultElement + ' .unitList').html("");
                $(resultElement + ' .unitList').append("<option selected value='0'>No Units avalible</option>")
            }
        }
    });
    var selectedVal3 = $(resultElement + ' .subjectList').val();
    $('body').on("change", resultElement + " .subjectList", function () {
        var selectedVal3 = $(this).val();
        if (selectedVal3 > 0) {
            $(resultElement + ' .tutorList').html("");
            $(resultElement + ' .tutorList').html("");
            getUnitsBySubject(selectedVal3, resultElement);
            if ($('.unitList').length) {
                if ($('.unitPage').length) {
                    getAllUnits(isAdmin = 1, selectedVal3, term = 0)
                }
                if ($('.tutorList').length) {
                    getTutorBySubject(selectedVal3, resultElement)
                }
            }
            $('body').on("change", resultElement + " .termList", function () {
                var selectedVal7 = parseInt($(this).val());
                if (selectedVal7 > 0) {
                    getAllUnits(isAdmin = 1, selectedVal3, selectedVal7)
                } else {
                    alert("No Units Availble")
                }
            })
        } else {
            $(resultElement + ' .unitList').html("");
            $(resultElement + ' .unitList').append("<option selected value='0'>No Units avalible</option>")
        }
    })
}

function getTutorBySubject(id, resultElement) {
    var getTutorBySubjectSettings = {
        "async": !0,
        "dataType": "json",
        "type": "GET",
        "url": "../api/tutor/class_subject/" + id,
        "headers": {
            "cache-control": "no-cache"
        }
    };
    $.ajax(getTutorBySubjectSettings).success(function (response) {
        console.log(JSON.stringify(response));
        if (response.length < 0 || response.length === 0) {
            $(resultElement + ' .tutorList').html("");
            $(resultElement + ' .tutorList').append("<option selected value='0'>No Tutors Avalible</option>")
        } else if (response.length > 0) {
            $(resultElement + ' .tutorList').html("");
            $(resultElement + ' .tutorList').append("<option selected value='0'>Select a Tutor</option>");
            var appendData = "";
            $.each(response, function (key, value) {
                appendData += "<option class='sTutor' value=" + value.tutor_id + ">" + value.f_name + " " + value.l_name + "</option>"
            })
        }
        $(resultElement + ' .tutorList').html(appendData)
    })
}

function getUnitsBySubject(id, resultElement) {
    var getUnitsBySubjectSettings = {
        "async": !0,
        "dataType": "json",
        "type": "GET",
        "url": "../api/units/subject/" + id,
        "headers": {
            "cache-control": "no-cache"
        }
    };
    $.ajax(getUnitsBySubjectSettings).success(function (response) {
        $(resultElement + ' .unitList').html("");
        $(resultElement + ' .unitList').append("<option selected value='0'>Select a Unit</option>");
        $.each(response, function (key, value) {
            var theme = value.themes;
            $.each(theme, function (key, themex) {
                var appendData = "<option class='sTutor' value=" + themex.theme_id + ">" + themex.theme_name + "</option>";
                $(resultElement + ' .unitList').append(appendData)
            })
        });
        var selectedVal4 = $(resultElement + ' .unitList').val();
        if (selectedVal4 > 0) {
            getTopicsByUnit(selectedVal4)
        } else {
            $(resultElement + ' .topicList').append("<option selected value='0'>No Topics avalible</option>")
        }
        $('body').on("change", resultElement + " .unitList", function () {
            var selectedVal4 = $(this).val();
            $(resultElement + ' .topicList').html("");
            if (selectedVal4 > 0) {
                getTopicsByUnit(selectedVal4, resultElement);
                if ($('.topicPage').length) {
                    getAllTopics(selectedVal4)
                }
            } else {
                $(resultElement + ' .topicList').html();
                $(resultElement + ' .topicList').append("<option selected value='0'>No Topics avalible</option>")
            }
        })
    })
}

function getTopicsByUnit(id, resultElement) {
    var getTopicBySubjectSettings = {
        "async": !0,
        "dataType": "json",
        "type": "GET",
        "url": "../api/topics/theme/" + id,
        "headers": {
            "cache-control": "no-cache"
        }
    };
    $.ajax(getTopicBySubjectSettings).success(function (response) {
        $(resultElement + ' .topicList').html("");
        if (response.length < 0 || response.length === 0) {
            $(resultElement + ' .topicList').append("<option selected value='0'>No Topics avalible</option>")
        } else if (response.length > 0) {
            $(resultElement + ' .topicList').html("");
            $(resultElement + ' .topicList').append("<option selected value='0'>Select a Topic</option>");
            $.each(response, function (key, value) {
                var appendData = "<option class='' value=" + value.topic_id + ">" + value.topic_name + "</option>";
                $(resultElement + ' .topicList').append(appendData)
            });
            $('body').on("change", resultElement + " .topicList", function () {
                var selectedVal11 = $(this).val();
                if (selectedVal11 > 0) {
                    if ($('.lessonPage').length) {
                        topical_lessons(selectedVal11)
                    }
                }
            })
        }
    })
}
function slideByLesson(lid) {
    $('#content-area').html("");
    var linked = "slides.php"+ '?_=' + (new Date()).getTime();
    $('#content-area').load(linked, function () {
        sessionStorage.current_page = linked;
        sessionStorage.active_lesson = lid;
        $(".modal-backdrop").hide();
        $(".modal").modal("hide");
        location.reload(true);
        //getSlides(lid)
        //var slide = new Slide(lid, '#slideList');
        //slide.getSlidesByLesson();
    });

}

function activityByLesson(lid) {
    $('#content-area').html("");
    var linkedz = "activity.php";
    $('#content-area').load(linkedz, function () {
        $(".modal-backdrop").hide();
        $(".modal").modal("hide");
        getActivities(lid)
    })
}
