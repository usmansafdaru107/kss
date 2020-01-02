$.fn.ajaxify = function (options) {
    var fn = new Array();
    var fd;
    this.find("input:file").change(function (event) {
        var dat = {};
        dat.field = $(this).attr("name");
        dat.file = event.target.files[0];
        fn.push(dat)
    });
    var validateFunc = function () {
        return !0
    };
    $.fn.ajaxify.defaults = {
        url: null,
        dataType: 'json',
        type: "POST",
        cache: !1,
        contentType: !1,
        processData: !1,
        cache: !1,
        "onSuccess": function () {},
        "validator": validateFunc,
        "postdata": {}
    };
    options = $.extend({}, $.fn.ajaxify.defaults, options);
    this.submit(function (event) {
        event.preventDefault();
        if (options.validator() == !0) {
            fd = new FormData($(this)[0]);
            if (Object.keys(options.postdata).length > 0) {
                for (var key in options.postdata) {
                    fd.append(key, options.postdata[key])
                }
            }
            $.each(fn, function (idx, val) {
                fd.append("files[]", val)
            });
            options.data = fd;
            $.ajax(options).done(options.onSuccess)
        } else {
            var res = options.validator();
            if (res.status === !0) {
                fd = new FormData($(this)[0]);
                if (Object.keys(options.postdata).length > 0) {
                    for (var key in options.postdata) {
                        fd.append(key, options.postdata[key])
                    }
                }
                if (Object.keys(res.postdata).length > 0) {
                    for (var key in res.postdata) {
                        fd.append(key, res.postdata[key])
                    }
                }
                $.each(fn, function (idx, val) {
                    fd.append("files[]", val)
                });
                options.data = fd;
                $.ajax(options).done(options.onSuccess)
            } else {
                return !1
            }
        }
    })
}