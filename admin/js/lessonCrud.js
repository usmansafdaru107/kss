$(document).ready(function () {
    var lastTopicById = sessionStorage.lastTopicById;
    if (lastTopicById > 0) {
        paginate_lessons(idx = 0, dir = '', lastTopicById)
    } else {
        paginate_lessons(idx = 0, dir = '', topic = 0)
    }
    page_buttons();
    initFilter('.filter-lesson-main');
    $('.addLessonBtn').click(function () {
        initFilter('.filter-add-lesson');
        addLesson();
    })
});

function page_buttons() {
    var topic = 0;
    $("#l_prev_btn").click(function () {
        if ($("#less_page").attr("data-role") == 'topical') {
            topic = $("#less_page").attr("data-topic")
        }
        if ($(this).attr("value") - $("#less_page").attr("data-min") > 0) {
            paginate_lessons($(this).attr('value'), 'prev', topic)
        }
    });
    $("#l_next_btn").click(function () {
        if ($("#less_page").attr("data-role") == 'topical') {
            topic = $("#less_page").attr("data-topic")
        }
        if ((parseInt(($(this).attr("value"))) + 10) < $("#less_page").attr("data-max")) {
            paginate_lessons($(this).attr('value'), 0, topic)
        }
    })
}

function topical_lessons(topic) {
    paginate_lessons(idx = 0, 0, topic)
}

function paginate_lessons(idx = 0, dir = '', topic = 0) {
    var topic_state = !1;
    var url = "../api/lessons?pages=true&pageCount=10&pagesize=10&from=" + idx + "&dir=" + dir
    if (topic > 0) {
        url = "../api/lessons/topic/" + topic + "?pages=true&pageCount=10&pagesize=10&from=" + idx + "&dir=" + dir;
        console.log(url)
    }
    $.ajax({
        "type": "GET",
        "async": !0,
        "dataType": "json",
        "url": url,
        success: function (res) {
            if (topic > 0) {
                $("#less_page").attr("data-role", "topical");
                $("#less_page").attr("data-topic", topic)
            }
            $("#less_page").attr("data-max", res.max);
            $("#less_page").attr("data-min", res.min);
            $("#l_page_btns").html(' ');
            $.each(res.pages, function (idx, val) {
                var el = $('<div class="btn l_page">');
                el.attr('value', val);
                el.html(idx + 1);
                el.appendTo($("#l_page_btns"))
            });
            var first = $(".l_page:first").attr("value");
            $("#l_prev_btn").attr("value", first);
            $("#l_next_btn").attr("value", $(".l_page:last").attr("value"));
            if ($("#less_page").attr("data-role") == "topical") {
                topic_state = !0;
                topic = $("#less_page").attr("data-topic")
            }
            if (topic_state) {
                getAllLessons(first, 'topic', topic)
            } else {
                getAllLessons(first)
            }
            $(".l_page").click(function () {
                if (topic_state) {
                    getAllLessons($(this).attr('value'), 'topic', topic)
                } else {
                    getAllLessons($(this).attr('value'))
                }
            })
        }
    })
}

function getAllLessons(idx = 0, type = 'all', topic = 0) {
    var lastCalled = {
        id: idx,
        typex: type,
        topicx: topic
    };
    sessionStorage.lastTopicById = lastCalled.topicx;
    var lastTopicById = sessionStorage.lastTopicById;
    console.log(lastTopicById.lastTopicById);
    var url = "../api/lessons?from=" + idx;
    if (type == 'topic' && topic > 0) {
        url = "../api/lessons/topic/" + topic + "?from=" + idx
    }
    var getClassesSettings = {
        "type": "GET",
        "async": !0,
        "dataType": "json",
        "url": url,
        "headers": {}
    };
    $.ajax(getClassesSettings).success(function (response) {
        $('.lessonsList').html("");
        var tableData = "";
        $.each(response, function (key, value) {
            tableData += "<tr><td>" + value.name + "</td><td>" + value.topic_name + "</td>" + "<td><button value='" + value.lesson_id + "' class='slideByLesson btn-xs btn btn-primary'><span class='fa fa-film'> </span> Slides</button></td>" + "<td><button value='" + value.lesson_id + "' class='activityByLesson btn-xs btn btn-default'><span class='fa fa-edit'> </span>Activity</button></td>" + "<td><button value='" + value.lesson_id + "' class='indLesson btn btn-xs btn-primary' data-target='#editLesson' data-toggle='modal'><span class='fa fa-edit'> </span> Edit</button> &nbsp;" + "<button value='" + value.lesson_id + "' class='indLessonDel btn-xs btn btn-warning' data-target='#deleteLesson' data-toggle='modal'><span class='fa fa-trash'> </span></button></td></tr>"
        });
        $('.lessonsList').html(tableData);
        $('.indLesson').click(function (e) {
            e.preventDefault();
            var valueX = $(this).attr("value");
            editLesson(valueX)
        });
        $('.indLessonDel').click(function (e) {
            e.preventDefault();
            var delValueX = $(this).attr("value");
            delLesson(delValueX)
        });
        $('.slideByLesson').click(function (e) {
            e.preventDefault();
            var lessonId = $(this).attr("value");
            slideByLesson(lessonId)
        });
        $('.activityByLesson').click(function (e) {
            e.preventDefault();
            var lessonId = $(this).attr("value");
            activityByLesson(lessonId)
        })
    })
}

function addLesson() {
    function callBackMethod(response) {
        $('#addNewLessonForm .form-error').hide();
        if (response.status === "error" || response.status === "Error" || response.status === "Failed" || response.status === "failed") {
            console.log(JSON.stringify(response));
            notify("Lesson could not be added", "warning")
        } else {
            notify("Lesson is saved successfully", "success");
            $('#addNewLessonForm')[0].reset()
        }
    }
    $("#addNewLessonForm").ajaxify({
        url: '../api/lessons',
        validator: beforeSubmitAdd,
        onSuccess: callBackMethod
    });

    function beforeSubmitAdd() {
        var obj = {};
        $('.LessonNameLabel').text("Lesson Name");
        $('.topicNameLabel').text("Topic");
        $('.lessonDescriptionLabel').text("Lesson Description");
        $('label').removeClass('text-danger');
        if (!minmax(3, 40, "#addNewLessonForm #LessonName", "A Real Lesson name is required", "#addNewLessonForm .LessonNameLabel")) {
            obj.status = !1
        } else if (!selectValid("#addNewLessonForm #topicName", "Please select a Topic", "#addNewLessonForm .topicNameLabel")) {
            obj.status = !1
        } else {
            obj.status = !0
        }
        var formx = {};
        obj.postdata = formx;
        return obj
    }
}

function editLesson(id) {
    var getlessonsByIdSettings = {
        "async": !0,
        "dataType": "json",
        "type": "GET",
        "url": "../api/lessons/" + id,
        "headers": {
            "cache-control": "no-cache"
        }
    };
    $.ajax(getlessonsByIdSettings).success(function (response) {
        var respx = response[0];
        $('#editLessonForm #LessonNameEdit').val(respx.name);
        var appendData = "<option value='" + respx.topic_id + "'>" + respx.topic_name + "</option>";
        $('#editLessonForm #topicListEdit').append(appendData)
    });

    function callBackMethod(response) {
        $('#editNewLessonForm .form-error').hide();
        if (response.status === "error" || response.status === "Error" || response.status === "Failed" || response.status === "failed" || response.status === "fail") {
            $('#editNewLessonForm .form-error').fadeIn(function () {
                $(this).text("Sorry " + response.message + " " + response.errors)
            })
        } else {
            $('#addNewLessonForm .form-success').fadeIn(function () {
                $(this).text("Lesson successfully Edited");
                $('#addNewLessonForm .form-success').fadeOut("slow");
                $('#content-area').html("");
                $('#content-area').load("lessons.php")
            });
            $(".modal-backdrop").fadeOut();
            $(".modal").modal("hide");
            getAllLessons()
        }
    }
    $("#editLessonForm").ajaxify({
        url: '../api/lessons/edit/' + id,
        validator: beforeSubmitEdit,
        onSuccess: callBackMethod
    });

    function beforeSubmitEdit() {
        var obj = {};
        $('.LessonNameLabel').text("Lesson Name");
        $('.topicNameLabel').text("Topic");
        $('.lessonDescriptionLabel').text("Lesson Description");
        $('label').removeClass('text-danger');
        if (!minmax(3, 40, "#editLessonForm #LessonNameEdit", "A Real Lesson name is required", "#editLessonForm .LessonNameLabel")) {
            obj.status = !1
        } else if (!selectValid("#editLessonForm #topicListEdit", "Please select a Topic", "#editLessonForm .topicNameLabel")) {
            obj.status = !1
        } else {
            obj.status = !0
        }
        var formx = {};
        obj.postdata = formx;
        return obj
    }
}

function delLesson(id) {
    $('#deleteLesson .delBtn').click(function () {
        var delLessonSettings = {
            "type": "GET",
            "async": !0,
            "dataType": "json",
            "url": "../api/lessons/delete/" + id,
            "headers": {
                "cache-control": "no-cache"
            }
        };
        $.ajax(delLessonSettings).success(function (response) {
            getAllLessons()
        })
    })
}