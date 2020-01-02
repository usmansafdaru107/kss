    function getAllSubjects(isAdmin){
	var getSubjectSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/subjects",
			"headers":{
				"cache-control":"no-cache"
			}
		};
	$.ajax(getSubjectSettings).done(function(response){
		$('.subjectList').html("");
		 $.each(response, function(key, value){
		 	var appendData="<div class='col-md-3 subjectBox'><div class='thumbs'><img src='"+value.subject_logo+"' style='width:100%;' class=''></div>"+
			"<div class='details'><h5 class='text-primary'>"+value.subject_name+"</h5>"+
		 	"<div class='btn-group btn-group-xs'><button class='btn btn-primary indSubject' value='"+value.subject_id+"' data-target='#editSubject' data-toggle='modal'>"+
			"<span class='fa fa-edit'></span> Edit</button><button value='"+value.subject_id+"' class='indSubjectDel btn btn-warning' data-target='#deleteSubject' data-toggle='modal'>"+
			"<span class='fa fa-trash'></span> Delete</button></div></div></div></div>";
			
			
			$('.subjectList').append(appendData);
				if(isAdmin==0){
			
				 $('.subjectBox button').hide();
				 $('.subjectBox .details h5').addClass('text-center').addClass('offAdmin');
			 }
			 else{
			
			 }
	
			
		
		});
		
				$('.indSubject').click( function(e){
		e.preventDefault();
		var valueX="";
		valueX= $(this).attr("value");
		editSubject(valueX);
           
		
		
	});
	
		 $('.indSubjectDel').click( function(e){
    e.preventDefault();
    var delValueX= $(this).attr("value");
    delSubject(delValueX);
	
    });
        
		
	});

}


   
   
   
   
   
   
   
   
   
   
   function getClassesInCheck(location){
	var getClassesSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/classes",
			"headers":{
                            "cache-control":"no-cache"
			}
		};
		
		$.ajax(getClassesSettings).success(function(response){
                
		$(location).html("");
		 $.each(response, function(key, value){
		 	var appendData="<input type='checkbox' class='classCheckbox' name='add_class' value='"+value.class_id+"'><label class='text-primary' for='"+value.short_class_name+"' >"+value.class_name+"</label>&nbsp;&nbsp;&nbsp;";
			$(location).append(appendData);
		});

	});
	
	
	
}

//add a subject
function addSubject(){
	
		
	function beforeSubmit(){
				
		var obj={};
		            var checkboxArray =[];	
	
	
	//find checked boxes
	$.each($('#addNewSubjectForm .classCheckbox'), function(){
		//alert($(this).prop("checked"));
		if($(this).prop("checked")==true){
		checkboxArray.push($(this).val());
		//alert($(this).val());
		}
	});
	
	//Label elements in the form 
    $('.subjectNameLabel').text("Subject Name");
    $('.classNameLabel').text("Class");
     $('.termNameLabel').text("Term");
    $('.subjectLogoLabel').text("Subject Image");
    
    //default label class
    $('label').removeClass('text-danger');
    
	if(! minmax(3, 20, "#addNewSubjectForm #subjectName", "A Real term name is required","#addNewSubjectForm .subjectNameLabel")){
    obj.status= false;
      }
	else{
		obj.status=true;
	}
        
	
		
		var subject=$('#subjectName').val();

			var appendData=[];
			$.each(checkboxArray, function(index, value){
				appendData.push(value);	
			});
			
			var formx={
			"subjectName":subject,
			"sDescription":"No description",	
			"subject": "new",
			"classes":appendData
				
			};
			
			obj.postdata=formx;
			//alert(JSON.stringify(obj));
			return obj;
			
			
			
		}	
		
	
		
		
		
			
		
		
			$("#addNewSubjectForm").ajaxify({url:'../api/subjects/class_subjects', validator:beforeSubmit, onSuccess:callBackMethod, dataType:'text'});
		
		function callBackMethod(response){
			
			
			
		checkboxArray=[];
		appendData=[];		
           //alert(checkboxArray+" "+appendData);                   
           //alert(JSON.stringify(response));                   
                               $('#addNewSubjectForm .form-success').fadeIn( function(){
                                $(this).text("New Subject has been Added");  
                                 $('#addNewSubjectForm .form-success').fadeOut("slow");
                              });
				
					                        $('#addNewSubjectForm')[0].reset();
                              getAllSubjects();
				
				
		}
}

//validating Subject Logo
 //imageValid('#subjectLogo', "Sorry you have selected unsupported file format We only Suppot PNG JPEG and JPG please Change it", ".subjectLogoLabel");

 
 
 //edit a subject
function editSubject(id){
	console.log(id);
	var getSubjectByIdSettings = {
        "async": true,
        "dataType":"json",
        "type": "GET",
        "url": "../api/subjects/"+id,

        "headers": {
          "cache-control": "no-cache"    
        }
        };
$.ajax(getSubjectByIdSettings).done(function (response) {
   $.each(response, function(key, value){
   $('#editSubject #editSubjectForm #subjectName').val(value.subject_name);
    $('#editSubject #editSubjectForm .pic').attr("src",value.subject_logo);
     });
     
   function getClassesChecked(){
	var getClassesSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/subjects/classes/"+id,
			"headers":{
                            "cache-control":"no-cache"
			}
		};
		
		$.ajax(getClassesSettings).success(function(response){
			//alert(JSON.stringify(response));
		$('#editSubjectForm .listCheckedClasses').html("");
		
		 $.each(response, function(key, value){
			 
		 	var appendData="<input type='checkbox' checked class='classCheckbox' name='remove_class' value='"+value.class_id+"'><label class='text-primary' for='"+value.short_class_name+"' >"+value.class_name+"</label>&nbsp;&nbsp;&nbsp;";
			$('#editSubjectForm .listCheckedClasses').append(appendData);
			
		});

	});
	
	
	
}
getClassesChecked();
});

	$("#editSubject #editSubjectForm .img-avail").show();
	$("#editSubject #editSubjectForm .img-upload").hide();
	$("#editSubject #editSubjectForm .removeImg").show();
	$("#editSubject #editSubjectForm .cancelRemoveImg").hide();
$("#editSubject #editSubjectForm .img-upload").hide();
$("#editSubject #editSubjectForm .cancelRemoveImg").hide();
$("#editSubject #editSubjectForm .img-upload #classLogoEdit").val("");
$('#editSubject #editSubjectForm .removeImg').click( function(){
	$("#editSubject #editSubjectForm .img-avail").hide();
	$("#editSubject #editSubjectForm .img-upload").slideDown();
	$("#editSubject #editSubjectForm .removeImg").hide();
	$("#editSubject #editSubjectForm .cancelRemoveImg").fadeIn();
	$("#editSubject #editSubjectForm .cancelRemoveImg").click( function(){
		$("#editSubject #editSubjectForm .img-avail").fadeIn();
	$("#editSubject #editSubjectForm .img-upload").hide();
	$("#editSubject #editSubjectForm .img-upload #classLogoEdit").val("");
	$("#editSubject #editSubjectForm .removeImg").fadeIn();
	$("#editSubject #editSubjectForm .cancelRemoveImg").hide();
	});

});
      //editing subject 
      //editing subject 
      //editing subject 
    
    function beforeSubmit(){ 
          
		 var obj={};
	var checkboxArray=[];
	//find checked boxes
	$.each($('#editSubjectForm .classCheckbox'), function(){
		if($(this).prop("checked") === true){
		checkboxArray.push($(this).val());
		}
	});

	var unchecked=[];
	

	$.each($('#editSubjectForm .listCheckedClasses .classCheckbox'), function(){
		if(!$(this).is(":checked")){
		unchecked.push($(this).val());
		}
		
		
	});
	

	
	//Label elements in the form 
    $('#editSubjectForm .subjectNameLabel').text("Subject Name");
    $('#editSubjectForm .classNameLabel').text("Class");
     $('#editSubjectForm .termNameLabel').text("Term");
    $('#editSubjectForm .subjectLogoLabel').text("Subject Image");
    
    //default label class
    $('label').removeClass('text-danger');
    
	if(! minmax(3, 20, "#editSubjectForm  #subjectName", "A Real term name is required","#editSubjectForm .subjectNameLabel")){
        obj.status= false;
      }
	else{
		obj.status=true;
	}
     
		
		var subject=$('#editSubjectForm #subjectName').val();
		
		
			var appendData=[];
			
			$.each(checkboxArray, function(index, value){
				appendData.push(value);	
			});
			
			var formz={
			"subjectName":subject,
			"sDescription":"No description",	
			"add_class":appendData,
			"remove_class":unchecked
			};
			obj.postdata=formz;
			//alert(JSON.stringify(obj));
			return obj;	
		
					
    }
	$("#editSubjectForm").ajaxify({url:"../api/subjects/edit/"+id, validator:beforeSubmit, onSuccess:editCallBackMethod, dataType:'text'});	
        
function editCallBackMethod(){
		checkboxArray=[];
		appendData=[];		
           //alert(checkboxArray+" "+appendData);                   
                               $('#editSubjectForm .form-success').fadeIn( function(){
                                    $(this).text("Subject has been Edited");  
                                     $('#editSubjectForm .form-success').fadeOut("slow");
                                
								
								
								$('#content-area').html("");		
				$('#content-area').load("subjects.php");	
								});
				
					
				
                                
                               
                
					
				
				$(".modal-backdrop").fadeOut();	
				$(".modal").modal("hide");	
								
								


}	
			
}

	function delSubject(id){
		
		
		console.log(id);
		$('#deleteSubject .delBtn').click( function(){
		
		var delSubjectSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/subjects/delete/"+id,
			"headers":{
				"cache-control":"no-cache"
			}
		};
	$.ajax(delSubjectSettings).success(function(response){
				console.log("Subject Deleted Succesfully");
				getAllSubjects();
		
					
				
				
				
	});
	
	});	
}