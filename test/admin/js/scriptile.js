  $(document).ready(function()
{
	if(sessionStorage['current_page'])
	{
		$('#content-area').load(sessionStorage['current_page'], function(){
			$('.loader').fadeOut( function(){
					//$('.loader').hide();
					$(".modal-backdrop").fadeOut();	
				$(".modal").modal("hide");	
			}); 
		 });
	}
	else
	{
		$('#content-area').load("classes.php", function(){
			$('.loader').fadeOut( function(){
					//$('.loader').hide();
					$(".modal-backdrop").fadeOut();	
				$(".modal").modal("hide");	
			}); 
		 });
	}
});

  //validate Image function
        function imageValid(imageField, errorTxt, errorlabel){
            var match=['image/jpeg', 'image/png', 'image/jpg'];
            $(imageField).change(function(){
            var file=this.files[0];
            var imagefile=file.type;
            if(!((imagefile===match[0]) || (imagefile===match[1]) || (imagefile===match[2]))){
                  $(errorlabel).text(errorTxt);
                  $(errorlabel).addClass("text-danger");
                   return false;
               }
		   else{
                       $(errorlabel).text("Class Logo/ Image");
                       $(errorlabel).removeClass("text-danger");  
		}
	});
 }
        
 //minmax validation
    function minmax(min, max,idElement, error, classError){
	var idElement2=$(idElement).val();
	if(idElement2.length<min || idElement2.length>max){
            $(idElement).focus();				
            $(classError).text(error);
            $(classError).addClass('text-danger');
            return false;
	}
        else {
            return true;
	}
    }
        
        
        
   //select field validation
                function selectValid(idElement, error, classError){
			var idElement2=$(idElement).val();
			if(idElement2==="0"){
                            $(idElement).focus();				
                            $(classError).text(error);
                            $(classError).addClass('text-danger');
                            return false;
			}
                        else {
                            return true;
                        }
		} 
                
                
 	function notify(textM, type){
		
		if(type==="error"){
			mType="#errorNot";
		}
		else if(type==="success"){
			mType="#successNot";
		}
		else if(type==="warning"){
			mType="#warnNot";
		}
		else{
			console.log("Error on Notify Plugin (var type)");
		}
$(mType).slideDown( function(){
	$(mType+" p").text('');
	$(mType+" p").text(textM);
	
	setTimeout( function(){
$(mType).slideUp("slow");	
	}, 6000);
});	
	}               
                
                
                
//document. ready function                
$( function(){
	//$('.loader').hide();
	 //$('#content-area').load("classes.php");
	//notify("Connection has been lost", "error");

	$('.togglesideNav').click( function(){
	if($('.togglesideNav').hasClass('onActive')){
		$('.sideNavLeft').show( function(){
			$('.togglesideNav').removeClass('onActive');
			$('.mainBox').addClass('col-md-9');
			$('.mainBox').addClass('col-sm-9');
			$('.mainBox').removeClass('col-sm-12');
		});
	}
	else{
		$('.sideNavLeft').hide( function(){
			$('.togglesideNav').addClass('onActive');
			$('.mainBox').removeClass('col-md-9');
			$('.mainBox').removeClass('col-sm-9');
			$('.mainBox').addClass('col-sm-12');
		});
	}
	});
	
    
//navigation Manager

  //$('.loader').hide();
 
   $('.nav-side-links').click( function(e){
	    e.preventDefault();
	    $('.loader').show();
       $('#content-area').html("");
	
	 var link= $(this).attr('href');
	 
         $('#content-area').load(link, function(){
         	sessionStorage['current_page']=link;
			$('.loader').fadeOut( function(){
					//$('.loader').hide();
					$(".modal-backdrop").fadeOut();	
				$(".modal").modal("hide");	
			}); 
		 });
   });  



//logout script
    $('a#logout').click( function(){
        var logoutSettings={
            "method":"GET",
            "url":"../api/admin/logout",
            "headers":{
                "cache-control":"no-cache"
            }
	};
        $.ajax(logoutSettings).done(function(){
        	sessionStorage['current_page']='';
            window.location.href="login.php";
	});
        
        
    });

    
    
    
    
    
//Ajax Error Tracker
    $(document).ajaxError(function(event, request, settings) {
   $('.form-error').fadeIn( function(){
	$('.form-error').text(settings.url + "'. ERROR CODE:" + request.status + " ERROR MESSAGE: " + request.statusText);
    });
	console.log(JSON.stringify(request));
    });	
	
	
	$(document).ajaxSend(function() {
		$('.loader').fadeIn();
	});
	$(document).ajaxStart(function() {
	$('.loader').fadeIn();
	});
	
	$(document).ajaxStop(function() {
	$('.loader').fadeOut();
	});
	
     
    

//login Form Valdidation
	var userName=$('#loginForm #username').val();
	var loginpassword=$('#loginForm #password').val();
	
	//validating username 
	$('#loginForm #username').on("keyup", function(e){
		if($('.usernameLabel').hasClass('text-danger') || $('#loginForm #username').val().length>2){
		$('.usernameLabel').text("Username");
			$('.usernameLabel').removeClass('text-danger');
			
		}
		
		else if(userName.length<3){
							
			
			$('.usernameLabel').text("Incorect Username");
			$('.usernameLabel').addClass('text-danger');
			
			
		}
		
		});
		
		//validating passowrd
                
	$('#loginForm #password').on("keyup", function(e){	
		if($('.passwordLabel').hasClass('text-danger') || $('#loginForm #password').val().length>5){
		$('.passwordLabel').text("Password");
			$('.passwordLabel').removeClass('text-danger');
			
		}
		
		else if(loginpassword.length<6){
				$('.passwordLabel').text("Incorect Password");
			$('.passwordLabel').addClass('text-danger');
			
			
		}
		
		});
	
	$('#loginForm').submit( function(e){
			var userName=$('#loginForm #username').val();
		var loginpassword=$('#loginForm #password').val();
	
		e.preventDefault();
		
		
		
		//validating username
		if(userName.length<3){
			$('#loginForm #username').focus();				
			
			$('.usernameLabel').text("Incorect Username");
			$('.usernameLabel').addClass('text-danger');
				
			return false;
		}
		
		//validating password
		if(loginpassword.length<6){
			$('#loginForm #password').focus();		
			
			
			$('.passwordLabel').text("Incorect Password");
			$('.passwordLabel').addClass('text-danger');
				
			return false;
		}
		
		
		$('#loginBtn').text("Loading...");
		var loginData=$(this).serialize();
		
		var loginSettings={
			"type":"POST",
			"dataType":"json",
			"url":"../api/admin/login",
			"headers":{
				"cache-control":"no-cache"
			},
			"data":loginData
		};
            
		$('#loginForm .form-error').fadeOut();
		$('#loginForm .form-success').fadeOut();
		
		
		$.ajax(loginSettings).success(function(response){
						
			$('#loginBtn').text("Loging in");
			
			$('#loginForm .form-error').fadeIn();
			if(response.status==="Failed" || response.status==="failed"){
				$('#loginBtn').text("Login");
				$('#loginForm .form-error').text("Sorry "+response.message);
				return false;
			}
			else if(response.status==="Warning"){
				$('#loginBtn').text("Login");
				$('#loginForm .form-error').text("Sorry "+response.message);
				return false;
			}
			else if(response.status==="success"){
				$('#loginForm').fadeOut("fast");
				$('#loginForm .form-success').text(response.message);
				$('#loginBtn').text("Login successfull");
				
                                 window.location.href="index.php";
				
			}
			else if(response.message==="Already Logged in"){
			$('#loginForm .form-success').text(response.message);
			$('#loginBtn').text("Loging in");
                        window.location.href="index.php";
			}
			else{
				$('#loginForm .form-success').text(response.message);
					
			}
			
			
                   
					
					
			});



});
});
//end of login code




   
    
       

function initFilter(){
	
	var getClassesSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/classes/tutor/logged_in",
			"headers":{
				"cache-control":"no-cache"
			}
		};
	$.ajax(getClassesSettings).success(function(response){
		
		if(response.length<0 || response.length===0){
			$('.filter .classList').html("");
			$('.filter .classList').append("<option selected value='0'>No classes avalible</option>");
		}
		else if(response.length>0){
                    
			$('.filter .classList').html("");
			$('.filter .classList').append("<option value='0'>Select a Class</option>");

		$.each(response, function(key, value){
		 	var appendData="<option value='"+value.class_id+"'>"+value.class_name+"</option>";
			$('.filter .classList').append(appendData);
		});
		
		}
    });
	
	var selectedVal= $('.filter .classList').val();  
	 //getSubjectsByClass(selectedVal);
	 $('body').on("change", ".filter .classList", function(){
		var selectedVal= $(this).val();  
		 $('.filter .subjectList').html("");
		 $('.filter .tutorList').html("");
		 $('.filter .topicList').html("");
		 $('.filter .lessonList').html("");

		 if(selectedVal>0)
		 {
		 	getSubjectsByClass(selectedVal);
                       
                        
                       
		 }

		 else
		 {

            
                     
		 	$('.filter .subjectList').html("");
		 	$('.filter .subjectList').append("<option selected value='0'>No Subjects avalible</option>");

		 	$('.filter .tutorList').html("");
		 	$('.filter .tutorList').append("<option selected value='0'>No Tutors Avalible</option>");
		 	
		 	$('.filter .unitList').html("");
			$('.filter .unitList').append("<option selected value='0'>No Units avalible</option>");

			$('.filter .topicList').html("");
			$('.filter .topicList').append("<option selected value='0'>No Topics avalible</option>");
		 }
	  });
}  

	 
	  

  
function getSubjectsByClass(id){
  var getSubjectsByClassSettings = {
	  "async": true,
	  "dataType":"json",
	  "type": "GET",
	  "url": "../api/subjects/class/"+id,
		"headers": {
		"cache-control": "no-cache"    
	  }
	};
$.ajax(getSubjectsByClassSettings).success(function (response) {
	//console.log(JSON.stringify(response));
	if(response.length<0 || response.length===0){
		$('.filter .subjectList').html("");
			$('.filter .subjectList').append("<option selected value='0'>No Subjects avalible</option>");
		}
	else if(response.length>0){	
		$('.filter .subjectList').html("");
                $('.filter .subjectList').append("<option selected value='0'>Select a Subject</option>");
		 $.each(response, function(key, value){
		 	var appendData="<option value='"+value.cs_id+"'>"+value.subject_name+"</option>";
			$('.filter .subjectList').append(appendData);
		});

		 var val=$('.filter .subjectList').val();
		 if(val>0)
		 {
		 if($('#tutor').length){
				//alert($('#tutor').length);
			getTutorBySubject(val);
                       
			}
			 if($('#UnitName').length){
			getUnitsBySubject(val);
                       
			 }
		 }

		 else
		 {
		 	$('.filter .tutorList').html("");
			$('.filter .tutorList').append("<option selected value='0'>No Tutors Avalible</option>");

		 	$('.filter .unitList').html("");
			$('.filter .unitList').append("<option selected value='0'>No Units avalible</option>");
		 }
	}
});

var selectedVal3= $('.filter .subjectList').val(); 
 //getTutorBySubject(selectedVal3);
		 //getUnitsBySubject(selectedVal3);
	 $('body').on("change", ".filter .subjectList", function(){
		var selectedVal3= $(this).val(); 
               
		 //console.log(selectedVal3);
		//$('.filter .tutorList').html("");
		
		 //getTutorBySubject(selectedVal3);
		 if(selectedVal3>0)
		 {
			 $('.filter .tutorList').html("");
			 
			 $('.filter .tutorList').html("");
		 	getUnitsBySubject(selectedVal3);
                        if($('.unitList').length){
							
							if($('.unitPage').length){
                            
                         getAllUnits(isAdmin=1, selectedVal3, term=0);
                         
							}
                   
			if($('.tutorList').length){
				
			getTutorBySubject(selectedVal3);
                       
			}
                         }
                                  
          $('body').on("change", ".filter .termList", function(){
		var selectedVal7= parseInt($(this).val());  
		
             
		 if(selectedVal7>0)
		 {
		 	
                       // getUnitsByTerm(selectedVal7,selectedVal3);
                        getAllUnits(isAdmin=1, selectedVal3, selectedVal7);
		 }

		 else
		 {
		 	alert("No Units Availble");
		 }

	  });
		 }
		 else
		 {
		 	$('.filter .unitList').html("");
			$('.filter .unitList').append("<option selected value='0'>No Units avalible</option>");
                        
                        
			
		 }
		 
	  });
	
}

function getTutorBySubject(id){
  var getTutorBySubjectSettings = {
	  "async": true,
	  "dataType":"json",
	  "type": "GET",
	  "url":"../api/tutor/class_subject/"+id,
		"headers": {
		"cache-control": "no-cache"    
	  }
	};


$.ajax(getTutorBySubjectSettings).success(function (response) {
	console.log(JSON.stringify(response));
	//alert(response.length+" " +JSON.stringify(response));
		if(response.length<0 || response.length===0){
			$('.filter .tutorList').html("");
			$('.filter .tutorList').append("<option selected value='0'>No Tutors Avalible</option>");
		}
		else if(response.length>0){	
		$('.filter .tutorList').html("");
                $('.filter .tutorList').append("<option selected value='0'>Select a Tutor</option>");
	$.each(response, function(key, value){
		
		 	var appendData="<option class='sTutor' value="+value.tutor_id+">"+value.f_name+" "+value.l_name+"</option>";
			
			
			$('.filter .tutorList').append(appendData);
		});
		}
});

}

        
       function getUnitsBySubject(id){
var getUnitsBySubjectSettings = {
	  "async": true,
	  "dataType":"json",
	  "type": "GET",
	  "url":"../api/units/subject/"+id,
		"headers": {
		"cache-control": "no-cache"    
	  }
	};


$.ajax(getUnitsBySubjectSettings).success(function (response) {
	//alert(JSON.stringify(response));
		
		
			$('.filter .unitList').html("");
                        $('.filter .unitList').append("<option selected value='0'>Select a Unit</option>");
		    $.each(response, function(key, value){
				var theme=value.themes;
				$.each(theme, function(key, themex){
					
		
		
                                    var appendData="<option class='sTutor' value="+themex.theme_id+">"+themex.theme_name+"</option>";
			$('.filter .unitList').append(appendData);
			
			
			});
			
			//$('.unitList').append("</div>");
		});
		

		var selectedVal4= $('.filter .unitList').val(); 
 if(selectedVal4>0)
		 {
		 	getTopicsByUnit(selectedVal4);
		 }

		 else
		 {
		 	$('.filter .topicList').append("<option selected value='0'>No Topics avalible</option>");
		 }
	$('body').on("change", ".filter .unitList", function(){
		var selectedVal4= $(this).val();  
		// console.log(selectedVal4);
		 $('.filter .topicList').html("");

		 if(selectedVal4>0)
		 {
		 	getTopicsByUnit(selectedVal4);
			if($('.topicPage').length){
			getAllTopics(selectedVal4);
			
			}
		 }

		 else
		 {
			 $('.filter .topicList').html();
		 	$('.filter .topicList').append("<option selected value='0'>No Topics avalible</option>");
		 }

	  });

	});
}

      function getTopicsByUnit(id){
var getTopicBySubjectSettings = {
	  "async": true,
	  "dataType":"json",
	  "type": "GET",
	  "url":"../api/topics/theme/"+id,
		"headers": {
		"cache-control": "no-cache"    
	  }
	};


$.ajax(getTopicBySubjectSettings).success(function (response) {
	//console.log(JSON.stringify(response));
		$('.filter .topicList').html("");
			if(response.length<0 || response.length===0){
			$('.filter .topicList').append("<option selected value='0'>No Topics avalible</option>");
		}
		else if(response.length>0){
			$('.filter .topicList').html("");
			$('.filter .topicList').append("<option selected value='0'>Select a Topic</option>");
		 $.each(response, function(key, value){
		 	var appendData="<option class='' value="+value.topic_id+">"+value.topic_name+"</option>";
				$('.filter .topicList').append(appendData);
		});
			$('body').on("change", ".filter .topicList", function(){
		var selectedVal11= $(this).val();  
		if(selectedVal11>0)
		 {
		 	
			if($('.lessonPage').length){
			getAllLessons(selectedVal11);
			
			}
		 }

	  });
		}
});


	   }


//get slides by lesson

function slideByLesson(lid){
	   
       $('#content-area').html("");
	 var linked="slides.php";
         $('#content-area').load(linked, function(){
         	sessionStorage['current_page']=linked;
			
					
					$(".modal-backdrop").hide();	
				$(".modal").modal("hide");	
		 	getSlides(lid);
			
		 });
	
}

//get activity by lesson

function activityByLesson(lid){
	   
       $('#content-area').html("");
	 var linkedz="activity.php";
         $('#content-area').load(linkedz, function(){
         	//sessionStorage['current_page']=linkedz;
					$(".modal-backdrop").hide();	
				$(".modal").modal("hide");	
		 	getActivities(lid);
			
		 });
	
}







 


        
