function getAllThrive() {
    var settings = {
        "type": "GET",
        "async": !0,
        "dataType": "json",
        "url": "../api/programs/members",
        "headers": {
            "cache-control": "no-cache"
        }
    };
    $.ajax(settings).success(function (response) {
        $('.tutorList').html("");
        $.each(response.data, function (key, value) {
            var typeyy ="";
            if(value.type=="1" || value.type==1){
                typeyy="School";
            }
            else if(value.type=="2" || value.type==2) {
                typeyy="Mentor";
            }
            else if(value.type=="3" || value.type==3) {
                typeyy="Student Support Program";
            }
            else if(value.type=="4" || value.type==4) {
                typeyy="Student Pathway Program";
            }
            var tableData = "<tr><td>" + value.full_names
             + "</td><td>" 
             + value.location + "</td>" + 
             "<td>"+value.email+"</td><td>"+value.phone+"</td><td>"+typeyy+"</td></tr>";
            $('.tutorList').append(tableData);
        });
       
    })
}

