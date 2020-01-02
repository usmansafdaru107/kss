//add Subject
 function addClass(){
            function beforeSubmitAdd(){ 
			var obj={};
		var className=$('#addNewClassForm #className').val();
		var shortClassName=$('#addNewClassForm #shortClassName').val();
		var classDescription=$('#addNewClassForm #classDescription').val();
		var classLogo=$('#addNewClassForm #classLogo').val();
		var addNewClassBtn=$('#addNewClassForm #addNewClassBtn');
		
		
		
		//labels
		$('.classNameLabel').text("Class Name");
		$('.shortClassNameLabel').text("Short Class Name");
		$('.classDescription').text("Class Description");
		$('.classLogoLabel').text("Class Logo");
		$('label').removeClass('text-danger');
	
		//validating classname
		 if(! minmax(3, 20, "#addNewClassForm #className", "Class Name is Invalid","#addNewClassForm .classNameLabel")){
                    obj.status= false;
                 }
		
		//validating shortClassName
		else if(! minmax(3, 5, "#addNewClassForm #shortClassName", "This is not a valid Short Class Name","#addNewClassForm .shortClassNameLabel")){
                   obj.status= false;
                 }
		
		//validating Class Description
		else if(! minmax(5, 100, "#addNewClassForm #classDescription", "This is not a valid Class Description","#addNewClassForm .classDescriptionLabel")){
                    obj.status= false;
                 }
				 else{
					obj.status=true;
					}
				var formx={};
			
			obj.postdata=formx;
					
					return obj;
		
	}
		

	$("#addNewClassForm").ajaxify({url:'../api/classes', validator:beforeSubmitAdd, onSuccess:callBackMethod});	
		function callBackMethod(response){
					
				$('#addNewClassForm .form-success').fadeIn( function(){
										
						$(this).text("Class successfully added");
						$('#addNewClassForm')[0].reset();
						
												
				getAllClasses();
			setTimeout( function(){
				$('#addNewClassForm .form-success').fadeOut("slow");	
					
					
				},1800);
				//end time out
						
					
				});
				
				
		}
			
			
 }	


//get all classes
function getAllClasses(isAdmin){

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
		$('.classList').html("");
		 $.each(response, function(key, value){
			 
		 	var appendData="<div class='col-md-3 classBox'><div class='rounded thumbs'><img style='width:100%;' src='"+value.class_pic+"'  class=''></div>"+
			"<div class='details'><h5 class='text-primary'>"+value.class_name+"</h5>"+
		 	"<div class='btn-group btn-group-xs'><button class='btn btn-primary indClass' value='"+value.class_id+"' data-target='#editClass' data-toggle='modal'>"+
			"<span class='fa fa-edit'> </span> Edit</button><button value='"+value.class_id+"' class='indClassDel btn btn-warning' data-target='#deleteClass' data-toggle='modal'>"+
			"<span class='fa fa-trash'> </span> Delete</button></div></div></div></div>";
			$('.classList').append(appendData);
			
			if(isAdmin==0){
			
				 $('.classBox button').hide();
				 $('.classBox .details h5').addClass('text-center').addClass('offAdmin');
			 }
			 else{
			
			 }
		});
    $('.indClass').click( function(e){
    e.preventDefault();
    var valueX= $(this).attr("value");
    editClass(valueX);
    });
	
	 $('.indClassDel').click( function(e){
    e.preventDefault();
    var delValueX= $(this).attr("value");
    delClass(delValueX);
	
    });
		
	});

}


//edit classes
function editClass(id){
	
   var getClasssByIdSettings = {
  "async": true,
  "dataType":"json",
  "type": "GET",
  "url": "../api/classes/"+id+"",
    "headers": {
    "cache-control": "no-cache"    
  }
};




$.ajax(getClasssByIdSettings).success(function (response) {

   $.each(response, function(key, value){
   
  $('#editClass #editClassForm #className').val(value.class_name);
  $('#editClass #editClassForm #shortClassName').val(value.short_class_name);
  $('#editClass #editClassForm #classDescription').val(value.description);
  $('#editClass #editClassForm .pic').attr("src",value.class_pic);
 
   });
});
	$("#editClass #editClassForm .img-avail").show();
	$("#editClass #editClassForm .img-upload").hide();
	$("#editClass #editClassForm .removeImg").show();
	$("#editClass #editClassForm .cancelRemoveImg").hide();
$("#editClass #editClassForm .img-upload").hide();
$("#editClass #editClassForm .cancelRemoveImg").hide();
$("#editClass #editClassForm .img-upload #classLogoEdit").val("");
$('#editClass #editClassForm .removeImg').click( function(){
	$("#editClass #editClassForm .img-avail").hide();
	$("#editClass #editClassForm .img-upload").slideDown();
	$("#editClass #editClassForm .removeImg").hide();
	$("#editClass #editClassForm .cancelRemoveImg").fadeIn();
	$("#editClass #editClassForm .cancelRemoveImg").click( function(){
		$("#editClass #editClassForm .img-avail").fadeIn();
	$("#editClass #editClassForm .img-upload").hide();
	$("#editClass #editClassForm .img-upload #classLogoEdit").val("");
	$("#editClass #editClassForm .removeImg").fadeIn();
	$("#editClass #editClassForm .cancelRemoveImg").hide();
	});
		
});


		$("#editClassForm").ajaxify({url:"../api/classes/edit/"+id, validator:beforeSubmitEdit, onSuccess:editCallBackMethod});	
	function editCallBackMethod(response){
			
				$('#editClassForm .form-success').fadeIn( function(){
				
						$(this).text("Class successfully Edited");
						
						
						
									
			setTimeout( function(){
				$('#editClassForm .form-success').fadeOut("slow");	
					
					
				},1800);
				//end time out
				$('#content-area').html("");		
				$('#content-area').load("classes.php");	
					
				});
				$(".modal-backdrop").fadeOut();	
				$(".modal").modal("hide");	
		}
	
	


		function beforeSubmitEdit(){
			var obj={};
		var className=$('#editClassForm #className').val();
		var shortClassName=$('#editClassForm #shortClassName').val();
		var classDescription=$('#editClassForm #classDescription').val();
		var classLogo=$('#editClassForm #classLogo').val();
		var addNewClassBtn=$('#editClassForm #addNewClassBtn');
		
		
		
	
	
	//labels
	$('.classNameLabel').text("Class Name");
	$('.shortClassNameLabel').text("Short Class Name");
	$('.classDescription').text("Class Description");
	$('.classLogoLabel').text("Class Logo");
	$('label').removeClass('text-danger');
	
		
		
		
		
		//validating classname
		 if(! minmax(3, 20, "#editClassForm #className", "Class Name is Invalid","#editClassForm .classNameLabel")){
                      obj.status= false;
                 }
		
		//validating shortClassName
		else if(! minmax(3, 5, "#editClassForm #shortClassName", "This is not a valid Short Class Name","#editClassForm .shortClassNameLabel")){
                     obj.status= false;
                 }
		
		//validating Class Description
		else if(! minmax(5, 100, "#editClassForm #classDescription", "This is not a valid Class Description","#editClassForm .classDescriptionLabel")){
                      obj.status= false;
                 }
				  else{
					obj.status=true;
					}
				var formx={};
			
			obj.postdata=formx;
					
					return obj;
		
		
					
		}
		
				
		
		
    
		
	
					
			
	}
	
	function delClass(id){
		
		
		
		$('.delBtn').click( function(){
		
		var delClassesSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/classes/delete/"+id,
			"headers":{
				"cache-control":"no-cache"
			}
		};
	$.ajax(delClassesSettings).success(function(response){
				console.log("Class Deleted Succesfully");
				getAllClasses();
		
					
				
				
				
	});
	
	});	
}







