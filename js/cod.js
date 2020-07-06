








	
	









	
	
		
	

	
	







	
			//multiple Subscribe Student
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
	
		notify("Please select atleast one student","warning");
		
		
	}

	$('.studentListE').html("");
	$.each(checkboxArrayN, function(key, value){
	var appendStudentListE='<a href="#" class="btn btn-default" style="margin:1px 5px;">'+value+'</a>';
	$('.studentListE').append(appendStudentListE);
	});
	
	

		var fincanceCalculate= {
			"enrollments":JSON.stringify(checkboxArray)
		};
		var fincanceCalculateSettings={
			"type":"POST",
			"async": true,
			"dataType":"json",
			"url":"api/student/subscribe?check_fee=true",
			"data":fincanceCalculate,
			"headers":{
				"cache-control":"no-cache"
			}
		};
		$.ajax(fincanceCalculateSettings).success(function(response){
			notify(JSON.stringify(response),"success");			
		});
		

	
			
		
		function beforeSubmit(){ 
		var obj={};
		var classToEnroll=$('#enrollStudentM .enroll_class').val();
			
			          
	
	
		//validating class
		 if(! minMax_a(9,10, "#mmnumber", "Please provide a mobile money number")){
                    obj.status= false;
					
                 }				 
				 else{
					obj.status=true;
					
					}
					
					var appendDataM=[];
			$.each(checkboxArray, function(index, value){
				appendDataM.push(value);	
			});
			
				var formx={
					'students':appendDataM,
					'class_id':classToEnroll,
					
				};
			obj.postdata=formx;
			
					return obj;

	}
		
		$(".despositForm").ajaxify({url:'api/student/subscribe', validator:beforeSubmit, onSuccess:callBackMethodd});	
		function callBackMethodd(response){
			

			if(response.status=="failed" || response.status=="warning"){
				notify("Sorry "+response.message,"error");
			console.log(JSON.stringify(response));	
			
		}
		else{
			notify(response.message+ " "+response.failed, "success");
			appendDataM=[];
			checkboxArray =[];	
			checkboxArrayN =[];	
			
					$('#enrollStudentx')[0].reset();
					getAllStudentsNotEnrolled();
					getClassesEnrolled();
					$(".modal").modal("hide");
						
					
		}
					
					
				
		}
	}
