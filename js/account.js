// show student if enrolled on not
$( function(){

	getAllStudentsNotEnrolled();
	getClassesEnrolled();

	//registerParent();
	
	editAccount();
		
		//change password
		
	$('.changeP').click( function(e){
			e.preventDefault();
			if($('.changeP').attr('state')=='active'){
				$('.changePfields').fadeOut( function(){
					$('.changeP').html('');
					$('.changeP').html('Change Password');
					$('.changeP').attr('state', 'deactive');
					$('.changePfields input').attr('disabled', true);
				});
			}
			else if($('.changeP').attr('state')=='deactive'){
				$('.changePfields').fadeIn( function(){
					$('.changeP').html('');
					$('.changeP').html('<i class="fa fa-times"> </i> Cancel');
					$('.changeP').attr('state', 'active');
					$('.changePfields input').attr('disabled', false);
				});
			}
			
		});
		
		//change image 
		$('.fileUpload').change( function(){
			imageValido();
		});

		//add student
		
$('#promptAddStudent').click( function(){
			addStudent();
	});
		
});

var home="account.php";

//get not enrolled students
	function getAllStudentsNotEnrolled(){
		
	var getStudentsSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"api/student/enrollment?class=unenrolled",
			"headers":{
				"cache-control":"no-cache"
			}
		};
		
	$.ajax(getStudentsSettings).success(function(response){
		console.log(JSON.stringify(response));
		if(response.status=='failed' || status=='failed'){
			
			$('.studentListnotEnrolled').html("");
	
			$('.noUnenrolled').html("");
			var appendNotStu='<p class="alert alert-warning">You have not added any students</p>';
			$('.noUnenrolled').html(appendNotStu);
		}
	
	else{
		$('.noUnenrolled').hide();
		$('.studentListnotEnrolled').html("");
		//console.log(JSON.stringify(response));
		var appendData="";
		var studentsNot=response.data;
	 $.each(studentsNot, function(key, value){
		 
			appendData+='<tr>'+
						'<td>'+value.f_name+' '+value.l_name+'</td>'+
						'<td>'+value.username+'</td>'+
						'<td>'+value.dob+'</td>'+
						'<td><a data-sid="'+value.student_id+'" class="btn btn-xs btn-light editStudent" href="#" data-target="#editStudent" data-toggle="modal">View</a></td>'+
						'<td><a data-sid="'+value.student_id+'" class="btn btn-xs btn-light deleteStudent" href="#" data-target="#deleteStudent" data-toggle="modal"><i class="fa fa-times"></i></a></td>'+
						'<td><input type="checkbox" data-sid="'+value.f_name+' '+value.l_name+'" value="'+value.student_id+'" class="selectUnStudent" /></td>'+
					'</tr>';
			$('.studentListnotEnrolled').html(appendData);
	
		});
	}
		
		//mutiple enroll
		$('button.enrollMultiple').click( function(e){
				e.preventDefault();
				e.stopImmediatePropagation();

				$('.notification').hide();
				//clear array fro check box
				var checkboxArray =[];	
				var checkboxArrayN =[];	
				
					//find checked boxes
			$.each($('.studentListnotEnrolled .selectUnStudent'), function(){
					//alert($(this).prop("checked"));
					if($(this).prop("checked")==true){
						checkboxArray.push($(this).val());
						checkboxArrayN.push($(this).attr('data-sid'));
							
					}
					
		});
		
		if(checkboxArray.length==0){
				notify("Please select atleast one student","warning");
			
			$('#enrollMultiple').modal('hide');
			checkboxArray =[];
			checkboxArrayN =[];
		}
		
		else if(checkboxArray.length>0){
			
			$('#enrollMultiple').modal('show');
		$('.studentListA').html("");
		var appendStudentListA="";
		$.each(checkboxArrayN, function(key, value){
		appendStudentListA+='<a href="#" class="btn btn-default" style="margin:1px 5px;">'+value+'</a>';
		
		});
	$('.studentListA').html(appendStudentListA);

			getAllClassesInList();
				multienrollStudent(checkboxArray);
				//$('button.enrollMultiple').unbind();
		}
		else{
			notify("Something going wrong","warning")
		}
				});
				
			//delete student
				$('a.deleteStudent').click( function(e){
				e.preventDefault();
				var student_id =$(this).attr("data-sid");
				var elementRemove=$(this).parent().parent();
				removeStudent(student_id, elementRemove);
				
				});
				
			//veiw individual student details
			$('a.editStudent').click( function(e){
				e.preventDefault();
				var student_id =$(this).attr("data-sid");
				
				veiwDetails(student_id);
				
				});
				
				$('#selectAllChildren').click( function(e){
					e.preventDefault();
					 $('input.selectUnStudent:checkbox').not(this).prop('checked', this.checked);
				});
    });
		
}

		function getClassesEnrolled(classId){

	var getEnrolledSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"api/student/enrollment",
			"headers":{
				"cache-control":"no-cache"
			}
		};
	$.ajax(getEnrolledSettings).success(function(response){
		console.log(JSON.stringify(response));
	$('.enrolledClassList').html("");
	$('.studentListRight .noClassEnrolled, .noClassEnrolledx').html("");
	if(response.status=='failed'){
		console.log('Failed to load Class');
	var appendNotStu='<p class="alert alert-warning">You have not enrolled any students </p>';
	$('.studentListRight .noClassEnrolled, .noClassEnrolledx').html(appendNotStu);
	}
	else if(response.status=='success'){
	
	var appendData="";
	 $.each(response.data, function(key, value){
		 
			appendData+='<tr class="indClass" data-name="'+value.class_name+'" sid="'+value.class_id+'">'+
						'<td>'+value.class_name+'</td>'+
						'<td>'+value.enrolled+'</td>'+
						'</tr>';
			
		});
		$('.enrolledClassList').html(appendData);
			//alert('Done');
			$('.enrolledClassList tr.indClass').first().addClass('active');
				var autoLoadStudentsId = $('.enrolledClassList tr.indClass').first().attr('sid');
				var autoLoadClassName = $('.enrolledClassList tr.indClass').first().attr('data-name');
				getAllStudents(autoLoadStudentsId, autoLoadClassName);
		
	}
		
			$('tr.indClass').click( function(e){
				e.preventDefault();
				var clickedTr=$(this);
				$('.enrolledClassList tr.indClass').removeClass('active');
					clickedTr.addClass('active');
				
				var class_id =$(this).attr("sid");
				var class_name =$(this).attr("data-name");
			
				getAllStudents(class_id, class_name);
				
				});

    });
		
}

	// list all students
	function getAllStudents(class_id, className){
		
		if(className=="undefined"){
			
			$('.TitleOfStudents').html('');
	$('.TitleOfStudents').html('Students');
		}
		else{
			
				$('.TitleOfStudents').html('');
	$('.TitleOfStudents').html(className+' students');
		}
		
	/*
	$('.dismisStudents').click( function(e){
		e.preventDefault();
	$('#studentListRight').fadeOut( function(){
		$('.classListEnrolled .leftClass').addClass('col-md-12', function(){
	$('.classListEnrolled .leftClass').removeClass('col-md-4');
	$('.TitleOfStudents').html('');
	});
	
	});
	});
	*/

	var getStudentsSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"api/student/enrollment?class="+class_id,
			"headers":{
				"cache-control":"no-cache"
			}
		};
		
	$.ajax(getStudentsSettings).success(function(response){
		console.log(JSON.stringify(response));
	
	$('.studentListRight .noClassEnrolled').html("");
	if(response.status=='failed'){
	
	var appendNotStu='<p class="alert alert-warning">You have not added any students</p>';
	$('.studentListRight .notStudentadded').html(appendNotStu);
	notify("You have not added any students","warning");
	}
	else if(response.status=='success'){
		$('.studentList').html("");
		var appendData="";
	 $.each(response.data, function(key, value){
		 if(value.subscription_status=="1"){
				var greenBar="transactionSuccess";
				var statusBack="Successfull";
				var classAdded="disabled";
			}
			else if(value.subscription_status=="0"){
				var greenBar="transactionBounced";
				var statusBack="Failed";
				var classAdded="";
			}
		 	
			appendData+='<tr data-class-name="'+value.class_name+'" class="'+greenBar+'">'+
						'<td>'+value.f_name+' '+value.l_name+'</td>'+
						'<td>'+value.username+'</td>'+
						'<td>'+value.dob+'</td>'+
						'<td><a data-sid="'+value.student_id+'" class="btn btn-xs btn-light editStudent" href="#" data-target="#editStudent" data-toggle="modal">View</a></td>'+
						'<td><button data-target="#unenrollStudentModal" data-toggle="modal" '+classAdded+' data-sid="'+value.student_id+'" class="btn btn-xs btn-light unenrollS" href="#" data-target="#deleteStudent" data-toggle="modal">Unenroll</button></td>'+
						'<td><input '+classAdded+' type="checkbox" data-sid="'+value.f_name+' '+value.l_name+'" value="'+value.enrollment_id+'" class="selectEnStudent" /></td>'+
					'</tr>';
			
		});
		$('.studentList').html(appendData);
	}
			$('.unenrollS').click( function(e){
				e.preventDefault();
				//var enrollmentId =$(this).parent().attr("data-id");
				var className=$(this).parent().parent().attr("data-class-name");
				var student_id =$(this).attr("data-sid");
				var elementRemove=$(this).parent().parent();
				
				unenrollStudent(student_id, class_id, elementRemove, className);
				
				});
		
		//mutiple Subscribe
		$('a.subscribeMultiple').click( function(e){
				e.preventDefault();
				//var student_id =$(this).attr("data-sid");
				multiSubscribeStudent();
				
				});
				
			//delete student
				$('a.deleteStudent').click( function(e){
				e.preventDefault();
				var student_id =$(this).attr("data-sid");
				var elementRemove=$(this).parent().parent();
				removeStudent(student_id, elementRemove);
				
				});
				
			//veiw individual student details
			$('.studentList a.editStudent').click( function(e){
				e.preventDefault();
				var student_idv =$(this).attr("data-sid");
				
				veiwDetails(student_idv);
				
				});
				
				$('#selectAllStudentsEnrolled').click( function(e){
					e.preventDefault();
					 $('input.selectEnStudent:checkbox').not(this).prop('checked', this.checked);
				});
    });
		
}

	// add student 
	
	function addStudent(){
		
		imageValido('.studentImages');
		function beforeSubmitt(){ 
			
			var obj={};
			
			//selecting form elements value 
			var studentFirstName=$('#addStudent .studentFirstName').val();
			var studentLastName=$('#addStudent .studentLastName').val();
			var studentDoB=$('#addStudent .studentDoB').val();
			var studentUsername=$('#addStudent .studentUsername').val();
			var studentPassword=$('#addStudent .studentPassword');
			var studentPassword2=$('#addStudent .studentPassword2');
			
		//validating f_name
		 if(! minMax_a(2, 200, "#addStudent .studentFirstName", "Please Provide a Valid First Name")){
                    obj.status= false;
                 }
				   else if(! minMax_a(2, 20, "#addStudent .studentLastName", "Please Provide a last name")){
                    obj.status= false;
                 }
				    else if(! minMax_a(8, 50, "#addStudent .studentDoB", "Please Provide a Valid date")){
                    obj.status= false;
                 }
				     else if(! minMax_a(4, 15, "#addStudent .studentUsername", "Please Provide a Valid Username")){
                    obj.status= false;
                 }
				      else if(! minMax_a(6, 20, "#addStudent .studentPassword", "Please Provide a Valid Password")){
                    obj.status= false;
                 }
				  	 else if($('#addStudent .studentPassword').val()!=$('#addStudent .studentPassword2').val()){
						           notify("Password Doesn't Match", "error");
									$('#addStudent .studentPassword2').focus();
							 
					 obj.status= false;
				 }
				 
				 else{
					obj.status=true;
					}
				//we have an issue in trasfering the data
				var formx={};
			obj.postdata=formx;
					return obj;

	}
		
		$("#addStudent").ajaxify({url:'api/sponsor/student', validator:beforeSubmitt, onSuccess:callBackMethodd});	
		function callBackMethodd(response){
		//	alert(JSON.stringify(response));
			if(response.status=="failed" || response.status=="warning"){
				notify("Sorry "+response.message,"error");
			console.log(JSON.stringify(response));	
			
		}
		else{
			
					$('#addStudent')[0].reset();
					$(".modal").modal("hide");
						notify("Student Successfully added", "success");
			
					getAllStudentsNotEnrolled();
					
		}
					
		}
	}

	//remove student

function removeStudent(studentId, elementRemove){
		$('#deleteStudent .delBtn').click( function(e){
		e.preventDefault();
		var delLessonSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"api/student/delete/"+studentId,
			"headers":{
				"cache-control":"no-cache"
			}
		};
	$.ajax(delLessonSettings).success(function(response){
		elementRemove.remove();
		notify("Student removed sucessfully","success");			
	});
	
	});	
}

function unenrollStudent(studentId, classId, elementRemove, className){
	
		$('#unenrollStudentModal .delBtn').click( function(e){
		e.preventDefault();
		var unenrollData= {
			"student_id":studentId,
			"class_id":classId
		};
		var delLessonSettings={
			"type":"POST",
			"async": true,
			"dataType":"json",
			"url":"api/student/unenroll",
			"data":unenrollData,
			"headers":{
				"cache-control":"no-cache"
			}
		};
		$.ajax(delLessonSettings).success(function(response){
			console.log(JSON.stringify(response));
			elementRemove.remove();
			//getAllStudentsNotEnrolled();
			//getClassesEnrolled();
			//getAllStudents(classId, className);
			$('.modal').modal('hide');
			notify("Student unerolled sucessfully","success");	
			var checkboxArray =[];	
			var checkboxArrayN =[];	

			window.location.href=home;
		});
	
	});	
}

			//multiple enroll Student
		function multienrollStudent(checkboxArray){
			
			$('#enrollStudentM').submit( function(e){
				e.preventDefault();
				e.stopImmediatePropagation();
				//alert(checkboxArray);
				var classToEnroll=$('#enrollStudentM .enroll_class').val();
				
				//validating class
				if(! selectValid_new("#enrollStudentM .enroll_class", "Please select a class")){
                    return false;
				}				 
				//else{
					
					//}
					
					var appendDataM=[];
					$.each(checkboxArray, function(index, value){
						appendDataM.push(value);	
					});
			
					var form4enroll={
						'students':appendDataM.toString(),
						'class_id':classToEnroll,
					
					};
				
				var enrollSettings={
						"type":"POST",
						"async":false,
						"dataType":"json",
						"url":'api/student/enroll',
						"headers":{
							"cache-control":"no-cache"
						},
						"data":form4enroll
				};
//alert(JSON.stringify(enrollSettings));
	$.ajax(enrollSettings).success(function(response){
	
			if(response.status=="failed" || response.status=="warning"){
				notify("Sorry "+response.message,"error");
				
			}
		else{
			notify(response.message+ " "+response.failed, "success");
			appendDataM=[];
			checkboxArray =[];	
			checkboxArrayN =[];	
			
					$('#enrollStudentM')[0].reset();
					
					window.location.href=home;
					//$(".modal").modal("hide");
					
					//getClassesEnrolled();
					//getAllStudentsNotEnrolled();
										
		}
					
	});//on success
			
			});// on subit close
		
	}

function veiwDetails(studentId){
	$('#editStudentForm')[0].reset();
	var getStudentSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"api/student/"+studentId+"/profile",
			"headers":{
				"cache-control":"no-cache"
			}
		};
                
                var studentIdEdit="";
	$.ajax(getStudentSettings).success(function(response){
		console.log("View "+JSON.stringify(response));
		var res=response.data[0];
		$('#editStudentForm .studentFirstName').val(res.f_name);
		$('#editStudentForm .studentLastName').val(res.l_name);
		$('#editStudentForm .studentDoB').val(res.dob);
		$('#editStudentForm .studentUsername').val(res.username);
		
                $('#editStudentForm .studImg').attr("src",res.profile_pic.substring(3));
		//alert(JSON.stringify(response));
		studentIdEdit=res.student_id;
		
        });
        
        function beforeSubmitEdit(){ 
            var obj={};
            //selecting form elements value 
            var fnv = $('#editStudentForm .studentFirstName').val();
            var fn = $('#editStudentForm .studentFirstName');
            
            var lnv = $('#editStudentForm .studentLastName').val();
            var ln = $('#editStudentForm .studentLastName');
            
            var dobv = $('#editStudentForm .studentDoB').val();
            var dob = $('#editStudentForm .studentDoB');
            
            var usnv =  $('#editStudentForm .studentUsername').val();
            var usn =  $('#editStudentForm .studentUsername');
            
            var pass1v =  $('#editStudentForm .np').val();
            var pass1 =  $('#editStudentForm .np');
            
            var pass2v =  $('#editStudentForm .npc').val();
            var pass2 =  $('#editStudentForm .npc');
			
		//validating f_name
		 if(! minMax_a(2, 200, fn, "Please Provide your student's First Name")){
                    obj.status= false;
                 }
                         else if(! minMax_a(2, 20, ln, "Please Provide your student's last name")){
                    obj.status= false;
                 }
			else if(! minMax_a(8, 20, dob, "Please Provide a Valid date")){
                    obj.status= false;
                 }
			else if(! minMax_a(4, 20, usn, "Please Provide a Username for your student")){
                    obj.status= false;
                 }
                      
			else if(pass1v!=pass2v){
				notify("Password Doesn't Match", "error");
                                pass2v.val("");
				pass2.focus();
		 		 obj.status= false;
				 }
				  else{
					obj.status=true;
					}
				//we have an issue in trasfering the data
				var formx={
                                    "student_id":studentIdEdit,
                                    "f_name":fnv,
                                    "l_name":lnv,
                                    "dob":dobv,
                                    "pass1":pass1v,
                                    "pass2":pass2v,
                                    "username":usnv
                                };
			obj.postdata=formx;
					return obj;

	}
        
        $("#editStudentForm").ajaxify({url:'api/student/edit', validator:beforeSubmitEdit, onSuccess:callBackMethodEdit});	
		function callBackMethodEdit(response){
		//	alert(JSON.stringify(response));
			if(response.status=="failed" || response.status=="warning"){
				notify("Sorry "+response.message,"error");
			console.log(JSON.stringify(response));	
			
		}
		else if(response.status=="success"){
			console.log(JSON.stringify(response));
			
					$('#addStudent')[0].reset();
					$(".modal").modal("hide");
						notify("Student Successfully Edited", "success");
			
					window.location.href=home;
					
		}
					
		}
        
}

function changeImage(){
	
	$(".image-change .img-avail").show();
	$(".image-change.img-upload").hide();
	$(".image-change .removeImg").show();
	$(".image-change .cancelRemoveImg").hide();
$(".image-change .img-upload").hide();
$(".image-change .cancelRemoveImg").hide();
$(".image-change .img-upload #PimageEdit").val(""); //edir
$('.image-change .removeImg').click( function(){
	$(".image-change .img-avail").hide();
	$(".image-change .img-upload").show();
	$(".image-change .removeImg").hide();
	$(".image-change .cancelRemoveImg").show();
	$(".image-change .cancelRemoveImg").click( function(e){
		e.preventDefault();
		$(".image-change .img-avail").show();
	$(".image-change .img-upload").hide();
	$(".image-change .img-upload #PimageEdit").val("");
	$(".image-change .removeImg").show();
	$(".image-change .cancelRemoveImg").hide();
	});
});

}

	//edit Account
	function editAccount(){
            	
		imageValido('.sponsorImageEdit');
	
	var accId=$('.editAcc').attr("data-id");
		var getAccountSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"api/sponsor/profile/"+accId,
			"headers":{
				"cache-control":"no-cache"
			}
		};
		
			$.ajax(getAccountSettings).success(function(response){
			console.log("Account Edit "+JSON.stringify(response));
			//changeImage();
			$('#editAccForm .pic').attr('src',response.profile_pic);
			
			$('#editAccForm .f_name').val(response.sponsor_name);
			$('#editAccForm .country').val(response.country);
			$('#editAccForm .phone').val(response.phone);
			$('#editAccForm .email').val(response.email);
			
		});
                
                function beforeSubmitEditAcc(){ 
            var obj={};
            //selecting form elements value 
            var fnamev = $('#editAccForm .f_name').val();
            var fname = $('#editAccForm .f_name');
            
            var countryv=$('#editAccForm .country').val();
            var country=$('#editAccForm .country');
           
            var phonev=$('#editAccForm .phone').val();
            var phone=$('#editAccForm .phone');
            
            var emailv=$('#editAccForm .email').val();
            var email=$('#editAccForm .email');
            
            var pass1v =  $('#editAccForm .np').val();
            var pass1 =  $('#editAccForm .np');
            
            var pass2v =  $('#editAccForm .npc').val();
            var pass2 =  $('#editAccForm .npc');
			
		//validating f_name
		 if(! minMax_a(2, 200, fname, "Please Provide your Full Name")){
                    obj.status= false;
                 }
                         else if(! minMax_a(2, 20, country, "Please Provide your Country")){
                    obj.status= false;
                 }
			else if(! minMax_a(8, 20, phone, "Please Provide your phone number")){
                    obj.status= false;
                 }
			else if(! minMax_a(4, 20, email, "Please Provide a valid email address")){
                    obj.status= false;
                 }
                      
			else if(pass1v!=pass2v){
				notify("Password Doesn't Match", "error");
                                pass2v.val("");
				pass2.focus();
		 		 obj.status= false;
				 }
				  else{
					obj.status=true;
					}
				//we have an issue in trasfering the data
				var formx={
                                    "name":fnamev,
                                    "email":emailv,
                                    "country":countryv,
                                    "pass1":pass1v,
                                    "pass2":pass2v,
                                    "phone":phonev
                                };
			obj.postdata=formx;
					return obj;

	}
        
        $("#editAccForm").ajaxify({url:'api/sponsor/edit', validator:beforeSubmitEditAcc, onSuccess:callBackMethodEditAcc});	
		function callBackMethodEditAcc(response){
		//	alert(JSON.stringify(response));
			if(response.status=="failed" || response.status=="warning"){
				notify("Sorry "+response.message,"error");
			console.log(JSON.stringify(response));	
			
		}
		else if(response.status=="success"){
			console.log(JSON.stringify(response));
			
					$(".modal").modal("hide");
						notify("Account Details Successfully Edited", "success");
			
					window.location.href=home;
					
		}
					
		}
	}
	
			//multiple subscribe Student
		function multiSubscribeStudent(){
			
			//clear array fro check box
				var checkboxArray =[];	
				var checkboxArrayN =[];	
				
					//find checked boxes
			$.each($('.studentList .selectEnStudent'), function(){
					//alert($(this).prop("checked"));
					if($(this).prop("checked")==true){
						checkboxArray.push($(this).val());
						checkboxArrayN.push($(this).attr('data-sid'));
		
					}
		});
		if(checkboxArray.length==0){
				notify("Please select atleast one student to enroll","warning");
			
			$('#subscribeStudentModal').modal('hide');
		}
		
		else{
			$('#subscribeStudentModal').modal('show');
		$('.studentListE').html("");
		var appendStudentListA="";
		$.each(checkboxArrayN, function(key, value){
		appendStudentListA+='<a href="#" class="btn btn-default" style="margin:1px 5px;">'+value+'</a>';
		
	});
	$('.studentListE').html(appendStudentListA);
		
		var computeData={
			"enrollments":checkboxArray.toString(0)
			
		};
		
		//alert(JSON.stringify(computeData));
		var computeAmountSettings={
			"type":"POST",
			"async": false,
			"dataType":"json",
			"url":"api/student/subscribe?check_fee=true",
			"data":computeData,
			"headers":{
				"cache-control":"no-cache"
			}
			
		};
		
		$.ajax(computeAmountSettings).success(function(responseComputed){
			console.log(responseComputed);
			$('.initForm')[0].reset();
			$('#subscribeStudentModal .msg').html("")
			$('#subscribeStudentModal .studentsNumber').html("")
			$('#depositForm .ammountd').val(responseComputed.amount.slice(1, -1));
		$('#subscribeStudentModal .msg').html("Cost per Child is: "+responseComputed.cost_per_child+ " Per year.");
			$('#subscribeStudentModal .studentsNumber').html("Students ("+responseComputed.count+")");
			
		});
		
		var appendDataM=[];
					$.each(checkboxArray, function(index, value){
						appendDataM.push(value);	
					});
		
			$('.initForm').submit( function(e){
				e.preventDefault();
				
				//select elements to be validated
				var mobileNumber=$('.initForm .mmnumber').val();
				//alert(mobileNumber.length);
			          
				//validating class
				if(! minMax_a(8, 10, ".initForm .mmnumber", "Please Enter a Mobile Money Number Below")){
                   
				   return false;
				}				 
				//else{
					
					//}
					
					var form4Subscribe={
							'enrollments':appendDataM.toString(),
							'method':'yo',
							'phone_no':'256'+mobileNumber,
							'carrier_code':"AIRTEL_UGANDA",

					};
					
					//alert(JSON.stringify(form4Subscribe));
				
				var subscribeSettings={
						"type":"POST",
						"async":false,
						"dataType":"json",
						"url":'api/student/subscribe',
						"headers":{
							"cache-control":"no-cache"
						},
						"data":form4Subscribe
				};

	$.ajax(subscribeSettings).success(function(responseSub){
	
			if(responseSub.status=="failed" || responseSub.status=="warning"){
				notify("Sorry "+responseSub.message,"error");
				
			}
		else{
			console.log(JSON.stringify(responseSub));
			//notify(response.message+ " "+response.failed, "success");
			//appendDataM=[];
			//checkboxArray =[];	
			//checkboxArrayN =[];	
			
					//$('.initForm')[0].reset();
					
					//$(".modal").modal("hide");
					
					//getClassesEnrolled();
					//getAllStudentsNotEnrolled();
					
					var form4Confirm={
						'phone':responseSub.phone,
						'reciept':responseSub.reciept_no
					};
					var CsubscribeSettings={
						"type":"POST",
						"async":false,
						"dataType":"json",
						"url":'api/student/subscribe?confirm=true',
						"headers":{
							"cache-control":"no-cache"
						},
						"data":form4Confirm
				};

	$.ajax(CsubscribeSettings).success(function(responsex){
		console.log(JSON.stringify(responsex));
		$("#ConfrimsubscribeStudentModal").modal("show");
		
						var recieptNoF=responseSub.reciept_no;
						//alert(recieptNoF);
						
					$('.iHavePayedBtn').click( function(e){
						e.preventDefault();
						var ihavePayedSettings={
						"type":"GET",
						"async":false,
						"dataType":"json",
						"url":'api/payments/verify/'+recieptNoF,
						"headers":{
							"cache-control":"no-cache"
						},
						
						};
					//alert(JSON.stringify(ihavePayedSettings));

					$.ajax(ihavePayedSettings).success(function(responsey){
						console.log(JSON.stringify(responsey));
						if(responsey.status=='failed'){
								notify('Your Payment has not yet been Recieved Please click I have payed to try again ','warning');
						}else if(responsey.status=='success'){
							notify('Thank you, Your Payment has been Recieved','success');
							
							appendDataM=[];
							checkboxArray =[];	
							checkboxArrayN =[];	
			
					$('.initForm')[0].reset();
					
					$(".modal").modal("hide");
					
					getClassesEnrolled();
					getAllStudentsNotEnrolled();
					
					$("#recieptPaymentModal").modal("show");
					$('#recieptPaymentModal .charged').html("");
					$('#recieptPaymentModal .datePayed').html("");
					$('#recieptPaymentModal .NoStudent').html("");
					
					$('#recieptPaymentModal .charged').html("ReciptNo #"+responsey.reciept_no);
					$('#recieptPaymentModal .datePayed').html("Charge: "+responsey.charge+" UGX");
					$('#recieptPaymentModal .NoStudent').html("Number of Students: "+responsey.students_count);
					
						}
					});
		
					});
					
	});
					
		}
					
	});//on success
			
			});// on subit close
		}
			
	}
	