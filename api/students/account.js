// show student if enrolled on not
$( function(){
	
	getAllStudentsNotEnrolled();
	getClassesEnrolled();

	$('.promptAddStudent').click( function(){
			addStudent();
	});
	registerParent();
	
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
		
});






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
			$('.noUnenrolled').append(appendNotStu);
		}
	
	else{
		$('.noUnenrolled').hide();
		$('.studentListnotEnrolled').html("");
		//console.log(JSON.stringify(response));
	 $.each(response, function(key, value){
		 
		 	
			var appendData='<tr>'+
						'<td>'+value.f_name+' '+value.l_name+'</td>'+
						'<td>'+value.username+'</td>'+
						'<td>'+value.dob+'</td>'+
						'<td><a data-sid="'+value.student_id+'" class="btn btn-xs btn-light editStudent" href="#" data-target="#editStudent" data-toggle="modal">View</a></td>'+
						'<td><a data-sid="'+value.student_id+'" class="btn btn-xs btn-light deleteStudent" href="#" data-target="#deleteStudent" data-toggle="modal"><i class="fa fa-times"></i></a></td>'+
						'<td><input type="checkbox" data-sid="'+value.f_name+' '+value.l_name+'" value="'+value.student_id+'" class="selectUnStudent" /></td>'+
					'</tr>';
			$('.studentListnotEnrolled').append(appendData);
	
			
		});
	}
		
		
		//enroll student
			$('a.enrollBtn').click( function(e){
				e.preventDefault();
				var student_id =$(this).attr("data-sid");
				enrollStudent(student_id);
				
				});
				
		//mutiple enroll
		$('button.enrollMultiple').click( function(e){
				e.preventDefault();
				

		
	
			$('.notification').hide();
			multienrollStudent();
	
				
				
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
				
				$('#selectAllChildren').click( function(){
					
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
	$('.enrolledClassList').html("");
	$('.studentListRight .noClassEnrolled, .noClassEnrolledx').html("");
	if(response.status=='failed'){
	var appendNotStu='<p class="alert alert-warning">You have not enrolled any students </p>';
	$('.studentListRight .noClassEnrolled, .noClassEnrolledx').append(appendNotStu);
	}
	else{
	console.log(JSON.stringify(response))
	 $.each(response, function(key, value){
		 
		 	
			var appendData='<tr class="indClass" data-name="'+value.class_name+'" sid="'+value.class_id+'">'+
						'<td>'+value.class_name+'</td>'+
						'<td>'+value.enrolled+'</td>'+
						'</tr>';
			$('.enrolledClassList').append(appendData);
	
			
		});
	}
		
		
		//enroll student
			$('tr.indClass').click( function(e){
				e.preventDefault();
				var class_id =$(this).attr("sid");
				var class_name =$(this).attr("data-name");
				
				getAllStudents(class_id, class_name);
				
				});

    });
		
	

}




	// list all students
	function getAllStudents(class_id, className){
		
	$('.TitleOfStudents').html('');
	$('.TitleOfStudents').html(className+' students');
	$('.classListEnrolled .leftClass').addClass('col-md-4', function(){
	$('.classListEnrolled .leftClass').removeClass('col-md-12', function(){
	$('.studentListRight').fadeIn( function(){
	
	});
	});
	});
	
	$('.dismisStudents').click( function(){
	$('.studentListRight').fadeOut( function(){
		$('.classListEnrolled .leftClass').addClass('col-md-12', function(){
	$('.classListEnrolled .leftClass').removeClass('col-md-4');
	$('.TitleOfStudents').html('');
	});
	
	});
	});
	

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
	$('.studentList').html("");
	$('.studentListRight .notStudentadded').html("");
	if(response.status=='failed'){
	var appendNotStu='<p class="alert alert-warning">You have not added any students</p>';
	$('.studentListRight .notStudentadded').append(appendNotStu);
	}
	else{
		console.log(JSON.stringify(response));
	 $.each(response, function(key, value){
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
		 	
			var appendData='<tr data-class-name="'+value.class_name+'" class="'+greenBar+'">'+
						'<td>'+value.f_name+' '+value.l_name+'</td>'+
						'<td>'+value.username+'</td>'+
						'<td>'+value.dob+'</td>'+
						'<td><a data-sid="'+value.student_id+'" class="btn btn-xs btn-light editStudent" href="#" data-target="#editStudent" data-toggle="modal">View</a></td>'+
						'<td><button data-target="#unenrollStudentModal" data-toggle="modal" '+classAdded+' data-sid="'+value.student_id+'" class="btn btn-xs btn-light unenrollS" href="#" data-target="#deleteStudent" data-toggle="modal">Unenroll</button></td>'+
						'<td><input '+classAdded+' type="checkbox" data-sid="'+value.f_name+' '+value.l_name+'" value="'+value.enrollment_id+'" class="selectEnStudent" /></td>'+
					'</tr>';
			$('.studentList').append(appendData);
	
			
		});
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
				
				$('#selectAllStudentsEnrolled').click( function(){
					
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
					getClassesEnrolled();
		}
					
					
				
		}
	}



















	//remove student

function removeStudent(studentId, elementRemove){
		$('#deleteStudent .delBtn').click( function(){
		
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
	
		$('#unenrollStudentModal .delBtn').click( function(){
		
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
			getAllStudentsNotEnrolled();
			getClassesEnrolled();
			getAllStudents(classId, className);
			$('.modal').modal('hide');
			notify("Student unerolled sucessfully","success");	
			
		});
	
	});	
}

			//multiple enroll Student
		function multienrollStudent(){
			
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
			//$('.enrollMultiple').attr('disabled',true);
			$('#enrollMultiple').modal('hide');
		}
		
		else{
			$('#enrollMultiple').modal('show');
		$('.studentListA').html("");
		$.each(checkboxArrayN, function(key, value){
		var appendStudentListA='<a href="#" class="btn btn-default" style="margin:1px 5px;">'+value+'</a>';
		$('.studentListA').append(appendStudentListA);
		});
	

			getAllClassesInList();
			
			$('#enrollStudentM').submit( function(e){
				e.preventDefault();
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
					
					$(".modal").modal("hide");
					
					getClassesEnrolled();
					getAllStudentsNotEnrolled();
										
		}
					
					
				
	});//on success
			
			});// on subit close
		}
			
		
			
	}

function veiwDetails(studentId){
	
	var getStudentSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"api/student/"+studentId+"/profile",
			"headers":{
				"cache-control":"no-cache"
			}
		};
	$.ajax(getStudentSettings).success(function(response){
		$('#editStudentForm')[0].reset();
		
		$('#editStudentForm .studentFirstName').val(response.f_name);
		$('#editStudentForm .studentLastName').val(response.l_name);
		$('#editStudentForm .studentDoB').val(response.dob);
		$('#editStudentForm .studentUsername').val(response.username);
		
		//alert(JSON.stringify(response));
		
		//classes enrolled for
		var classEnrolledSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"api/student/"+studentId+"/enrollment",
			"headers":{
				"cache-control":"no-cache"
			}
		};
		
		$.ajax(classEnrolledSettings).success(function(responsex){
			
			if(responsex.status=='failed'){
				$('.enrolledClasses').html('');
				var appendData='<p class="alert alert-warning">'+responsex.message+'</p>';
				$('.enrolledClasses').append(appendData);
			}
			else{
				$('.enrolledClasses').html('');
				//alert(responsex[0].class_name);
				$.each(responsex, function(key, value){
		 
		 	
				var appendData='<div style="margin-bottom:5px;" class="btn-group" class-id="'+value.class_id+'" data-id="'+value.enrollment_id+'">'+
				'<p class="btn btn-default">'+value.short_class_name+'</p></div>';
				$('.enrolledClasses').append(appendData);	
				
				});
				
				
			}
			
			
		
			
		
			
		});
	});
	
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
	$(".image-change .img-avail").fadeOut();
	$(".image-change .img-upload").slideDown();
	$(".image-change .removeImg").fadeOut();
	$(".image-change .cancelRemoveImg").fadeIn();
	$(".image-change .cancelRemoveImg").click( function(){
		$(".image-change .img-avail").fadeIn();
	$(".image-change .img-upload").slideUp();
	$(".image-change .img-upload #PimageEdit").val("");
	$(".image-change .removeImg").fadeIn();
	$(".image-change .cancelRemoveImg").fadeOut();
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
			//alert(JSON.stringify(response));
			changeImage();
			$('.sponsor_pic').attr('src',response.profile_pic);
			
		$('#editAccForm')[0].reset();		
		
			
			$('#editAccForm .f_name').val(response.sponsor_name);
			$('#editAccForm .country').val(response.country);
			$('#editAccForm .phone').val(response.phone);
			$('#editAccForm .email').val(response.email);
			
			
			
		

    });
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
		$.each(checkboxArrayN, function(key, value){
		var appendStudentListA='<a href="#" class="btn btn-default" style="margin:1px 5px;">'+value+'</a>';
		$('.studentListE').append(appendStudentListA);
		});
		
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
			$('#subscribeStudentModal .msg').html("Cost per Child is: "+responseComputed.cost_per_child);
			$('#subscribeStudentModal .studentsNumber').html("Students ("+responseComputed.count+")");
			
			
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
					
					var appendDataM=[];
					$.each(checkboxArray, function(index, value){
						appendDataM.push(value);	
					});
			
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
	
	
	





