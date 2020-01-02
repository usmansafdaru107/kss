function getAllAdmins() {
    var getAdminSettings = {
        "type": "GET",
        "async": !0,
        "dataType": "json",
        "url": "../api/admin",
        "headers": {
            "cache-control": "no-cache"
        }
    };
    $.ajax(getAdminSettings).success(function (response) {
        console.log(JSON.stringify(response));
        $('.adminList').html("");
        
            if (response.status=='failed') {
                notify("You have no previllages to access this content, contact admin for more details", "warning");
            } else {
                $.each(response, function (key, value) {
                var previl;
                if (value.previlege == 0) {
                    previl = "Contributor"
                } else if (value.previlege == 1) {
                    previl = "Admin"
                }
                var tableData = "<tr><td>" + value.f_name + " " + value.l_name + "</td><td>" + value.phone_no + "</td><td>" + value.email + "</td><td>" + previl + "</td>" + "<td><button value='" + value.admin_id + "' class='indAdmin btn btn-primary' data-target='#editAdmin' data-toggle='modal'><span class='fa fa-edit'> </span> Edit</button></td>" + "<td><button value='" + value.admin_id + "' class='indAdminDel btn btn-warning' data-target='#deleteAdmin' data-toggle='modal'><span class='fa fa-trash'> </span> Delete</button></td>" + "<td><button value='" + value.admin_id + "' class='adminSubjects btn btn-default' data-target='#subCrud' data-toggle='modal'><span class='fa fa-folder'> </span> Subjects</button></td>" + "</tr>";
                $('.adminList').append(tableData);
                 });
            }

        $('.indAdmin').click(function (e) {
            e.preventDefault();
            var valueX = $(this).attr("value");
            editAdmin(valueX)
        });
        $('.indAdminDel').click(function (e) {
            e.preventDefault();
            var delValueX = $(this).attr("value");
            delAdmin(delValueX)
        });
        $('.adminSubjects').click(function (e) {
            e.preventDefault();
            var assignValue = $(this).attr("value");
            assignSubject(assignValue);
            listSubjectsAssigned(assignValue)
        })
    })
}
$(function () {
    getAllAdmins()
});

function addAdmin() {
    $("#addNewAdminForm").ajaxify({
        url: '../api/admin',
        validator: beforeSubmitAdmin,
        onSuccess: callBackMethod
    });

    function callBackMethod(response) {
        $('#addNewAdminForm .form-error').hide();
        if (response.status === "error" || response.status === "Error" || response.status === "Failed" || response.status === "failed") {
            $('#addNewAdminForm .form-error').fadeIn(function () {
                $(this).text("Sorry " + response.message + " " + response.errors)
            })
        } else {
            $('#addNewAdminForm .form-success').fadeIn(function () {
                $(this).text("Admin / Contributor successfully Added");
                $('#addNewAdminForm .form-success').fadeOut("slow");
            });
            $('#addNewAdminForm')[0].reset();
            getAllAdmins();
        }
    }

    function beforeSubmitAdmin() {
        var obj = {};
        $('.emailLabel').text("Email");
        $('.firstNameLabel').text("First Name");
        $('.lastNameLabel').text("Last Name");
        $('.pass1Label').text("Passowrd");
        $('.pass2Label').text("Confirm Passowrd");
        $('.townLabel').text("Town");
        $('.countryLabel').text("Country");
        $('.phoneLabel').text("Phone Number");
        $('.contributorLogoLabel').text("Contributor Image");
        $('.previlegeLabel').text("Previlege");
        $('label').removeClass('text-danger');
        if (!minmax(3, 40, "#addNewAdminForm #email", "A Correct Email is required", "#addNewAdminForm .emailLabel")) {
            obj.status = !1
        } else if (!minmax(3, 20, "#addNewAdminForm #firstName", "A valid First Name is required", "#addNewAdminForm .firstNameLabel")) {
            obj.status = !1
        } else if (!minmax(3, 20, "#addNewAdminForm #lastName", "A valid Last Name  is required", "#addNewAdminForm .lastNameLabel")) {
            obj.status = !1
        } else if (!minmax(4, 20, "#addNewAdminForm #pass1", "A Password is required", "#addNewAdminForm .pass1Label")) {
            obj.status = !1
        } else if ($('#addNewAdminForm #pass1').val() != $('#addNewAdminForm #pass2').val()) {
            $('#addNewAdminForm .form-error').fadeIn(function () {
                $(this).text("Sorry Password Does not match, Check the password and retype it again.")
            });
            obj.status = !1
        } else if (!minmax(4, 20, "#addNewAdminForm #pass2", "Password verification is required", "#addNewAdminForm .pass2Label")) {
            obj.status = !1
        } else if (!minmax(3, 20, "#addNewAdminForm #town", "Town is required", "#addNewAdminForm .townLabel")) {
            obj.status = !1
        } else if (!minmax(3, 20, "#addNewAdminForm #country", "Country is required", "#addNewAdminForm .countryLabel")) {
            obj.status = !1
        } else if (!minmax(10, 15, "#addNewAdminForm #phone", "Valid Phone Number is required", "#addNewAdminForm .phoneLabel")) {
            obj.status = !1
        } else if (!minmax(10, 15, "#addNewAdminForm #phone", "Valid Phone Number is required", "#addNewAdminForm .phoneLabel")) {
            obj.status = !1
        } else {
            obj.status = !0
        }
        var formx = {};
        obj.postdata = formx;
        return obj
    }
}

function editAdmin(id) {
    console.log(id);
    var getAdminByIdSettings = {
        "async": !0,
        "dataType": "json",
        "type": "GET",
        "url": "../api/admin/" + id + "",
        "headers": {
            "cache-control": "no-cache"
        }
    };
    $.ajax(getAdminByIdSettings).success(function (response) {
        $.each(response, function (key, value) {
            $('#editAdmin #editAdminForm #email').val(value.email);
            $('#editAdmin #editAdminForm #firstName').val(value.f_name);
            $('#editAdmin #editAdminForm #lastName').val(value.l_name);
            $('#editAdmin #editAdminForm #town').val(value.town);
            $('#editAdmin #editAdminForm #country').val(value.country);
            $('#editAdmin #editAdminForm #phone').val(value.phone_no);
            $('#editAdmin #editAdminForm #previlege').val(value.previlege);
            $('#editAdmin #editAdminForm .pic').attr("src", value.photo)
        });
        $("#editAdmin #editAdminForm #pass1").val("");
        $("#editAdmin #editAdminForm #pass2").val("")
    });
    $("#editAdmin #editAdminForm .img-avail").show();
    $("#editAdmin #editAdminForm .img-upload").hide();
    $("#editAdmin #editAdminForm .removeImg").show();
    $("#editAdmin #editAdminForm .cancelRemoveImg").hide();
    $("#editAdmin #editAdminForm .img-upload").hide();
    $("#editAdmin #editAdminForm .cancelRemoveImg").hide();
    $("#editAdmin #editAdminForm .img-upload #classLogoEdit").val("");
    $('#editAdmin #editAdminForm .removeImg').click(function () {
        $("#editAdmin #editAdminForm .img-avail").hide();
        $("#editAdmin #editAdminForm .img-upload").slideDown();
        $("#editAdmin #editAdminForm .removeImg").hide();
        $("#editAdmin #editAdminForm .cancelRemoveImg").fadeIn();
        $("#editAdmin #editAdminForm .cancelRemoveImg").click(function () {
            $("#editAdmin #editAdminForm .img-avail").fadeIn();
            $("#editAdmin #editAdminForm .img-upload").hide();
            $("#editAdmin #editAdminForm .img-upload #classLogoEdit").val("");
            $("#editAdmin #editAdminForm .removeImg").fadeIn();
            $("#editAdmin #editAdminForm .cancelRemoveImg").hide()
        })
    });

    function beforeEditAdmin() {
        var obj = {};
        $('.emailLabel').text("Email");
        $('.firstNameLabel').text("First Name");
        $('.lastNameLabel').text("Last Name");
        $('.pass1Label').text("Passowrd");
        $('.pass2Label').text("Confirm Passowrd");
        $('.townLabel').text("Town");
        $('.countryLabel').text("Country");
        $('.phoneLabel').text("Phone Number");
        $('.contributorLogoLabel').text("Contributor Image");
        $('.previlegeLabel').text("Previlege");
        $('label').removeClass('text-danger');
        if (!minmax(3, 40, "#editAdminForm #email", "A Correct Email is required", "#editAdminForm .emailLabel")) {
            obj.status = !1
        } else if (!minmax(3, 20, "#editAdminForm #firstName", "A valid First Name is required", "#editAdminForm .firstNameLabel")) {
            obj.status = !1
        } else if (!minmax(3, 20, "#editAdminForm #lastName", "A valid Last Name  is required", "#editAdminForm .lastNameLabel")) {
            obj.status = !1
        } else if ($('#editAdminForm #pass1').val() != $('#editAdminForm #pass2').val()) {
            $('#editAdminForm .form-error').fadeIn(function () {
                $(this).text("Sorry Password Does not match, Check the password and retype it again.")
            });
            obj.status = !1
        } else if (!minmax(3, 20, "#editAdminForm #town", "Town is required", "#editAdminForm .townLabel")) {
            obj.status = !1
        } else if (!minmax(3, 20, "#editAdminForm #country", "Country is required", "#editAdminForm .countryLabel")) {
            obj.status = !1
        } else if (!minmax(10, 15, "#editAdminForm #phone", "Valid Phone Number is required", "#editAdminForm .phoneLabel")) {
            obj.status = !1
        } else if (!minmax(10, 15, "#editAdminForm #phone", "Valid Phone Number is required", "#editAdminForm .phoneLabel")) {
            obj.status = !1
        } else {
            obj.status = !0
        }
        var formx = {};
        obj.postdata = formx;
        return obj
    }
    $("#editAdminForm").ajaxify({
        url: '../api/admin/edit/' + id,
        validator: beforeEditAdmin,
        onSuccess: callBackMethod
    });

    function callBackMethod(response) {
        if (response.status === "error" || response.status === "Error" || response.status === "Failed" || response.status === "failed") {
            $('#editAdminForm .form-error').fadeIn(function () {
                $(this).text("Sorry " + response.message)
            })
        } else {
            console.log(JSON.stringify(response));
            $('#editAdminForm .form-success').fadeIn(function () {
                $(this).text("Admin / Contributor successfully Added");
                $('#editAdminForm .form-success').fadeOut("slow");
                $('#content-area').html("");
                $('#content-area').load("admin.php")
            });
            $(".modal-backdrop").fadeOut();
            $(".modal").modal("hide");
            getAllAdmins()
        }
    }
}

function delAdmin(id) {
    $('.delBtn').click(function () {
        var delAdminSettings = {
            "type": "GET",
            "async": !0,
            "url": "../api/admin/delete/" + id,
            "headers": {
                "cache-control": "no-cache"
            }
        };
        $.ajax(delAdminSettings).success(function (response) {
            console.log("Admin Removed Succesfully");
            getAllAdmins()
        })
    })
}

function assignSubject(id) {
    function beforeAssignSubject() {
        var obj = {};
        $('.classListLabel').text("Class");
        $('.subjectListLabel').text("Subject Class");
        $('label').removeClass('text-danger');
        var subjectClass = $('#assignSubjectForm #subjectList').val();
        if (!selectValid("#assignSubjectForm #classList", "Please select a Class", ".classListLabel")) {
            obj.status = !1
        } else if (!selectValid("#assignSubjectForm #subjectList", "Please select a Subject", ".subjectListLabel")) {
            obj.status = !1
        } else {
            obj.status = !0
        }
        var formx = {
            "subject": subjectClass,
            "admin": id
        };
        obj.postdata = formx;
        console.log(JSON.stringify(obj));
        return obj
    }
    $("#assignSubjectForm").ajaxify({
        url: '../api/tutor',
        validator: beforeAssignSubject,
        onSuccess: callBackMethod
    });

    function callBackMethod(response) {
        console.log(JSON.stringify(response));
        $('#assignSubjectForm .form-success').fadeIn(function () {
            $(this).text("Class successfully added");
            setTimeout(function () {
                $('#addNewClassForm .form-success').fadeOut("slow")
            }, 1800);
            $("#assignSubjectForm")[0].reset()
        });
        listSubjectsAssigned(id)
    }
}

function listSubjectsAssigned(id) {
    var getAdminSettings = {
        "type": "GET",
        "async": !0,
        "dataType": "json",
        "url": "../api/tutor/admin/" + id,
        "headers": {
            "cache-control": "no-cache"
        }
    };
    $.ajax(getAdminSettings).success(function (response) {
        console.log(JSON.stringify(response));
        $('.assignedsubjectList').html("");
        var data = response;
        $.each(data, function (key, value) {
            var tableData = "<tr><td>" + value.class_name + "</td><td> " + value.subject_name + "</td>" + "<td><button value='" + value.tutor_id + "' class='indAssignDel btn btn-warning'><span class='fa fa-trash'></span></button></td>";
            "</tr>";
            $('.assignedsubjectList').append(tableData)
        });
        $('.indAssignDel').click(function (e) {
            e.preventDefault();
            var idx = $(this).attr("value");
            var delPop = confirm("Are you about Removing this Assigning?");
            if (delPop) {
                var delassignSettings = {
                    "type": "GET",
                    "async": !0,
                    "url": "../api/tutor/delete/" + idx,
                    "headers": {
                        "cache-control": "no-cache"
                    }
                };
                $.ajax(delassignSettings).success(function (response) {
                    console.log("Assign to subject is Removed");
                    listSubjectsAssigned(id)
                })
            } else {
                console.log("Great Choice")
            }
        })
    })
}