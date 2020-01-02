/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function getAllTutors(){
    	var getClassesSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/tutor",
			"headers":{
				"cache-control":"no-cache"
			}
		};
	$.ajax(getClassesSettings).success(function(response){
           
		$('.tutorList').html("");
		 $.each(response, function(key, value){
		 	var tableData="<tr><td>"+value.f_name+" "+value.l_name+"</td><td>"+value.subject_name+"</td>"+
			"<td><button value='"+value.lesson_id+"' class='indLesson btn btn-primary' data-target='#editTutor' data-toggle='modal'><span class='fa fa-edit'> </span> Edit</button></td>"+
			"<td><button class='btn btn-warning' data-target='#deleteLesson' data-toggle='modal'><span class='fa fa-trash'> </span> Delete</button></td></tr>";
			$('.tutorList').append(tableData);
		});
    $('.indTutor').click( function(e){
    e.preventDefault();
    var valueX= $(this).attr("value");
    editTopic(valueX);
    //alert(valueX);
    });
		
	});
    
    
}
 //add Topic Form
    
     //imageValid('#addNewTopicForm #topicLogo', "Sorry you have selected unsupported file format We only Suppot PNG JPEG and JPG please Change it", "#addNewTopicForm .topicLogoLabel");
function addTopic(){
    //get all units and put them in the select drop down menu
	
	
	
	
	   function getClassesInCheck(id){
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


	var getTutorSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/units",
			"headers":{
				"cache-control":"no-cache"
			}
		};
	$.ajax(getTutorSettings).done(function(response){
		//$('.unitList').html("");
		 $.each(response, function(key, value){
                    	var appendData="<option class='sUnits' value="+value.theme_id+">"+value.theme_name+"</option>";
			
			
			$('#addNewTopicForm .unitList').append(appendData);
		
		});
                
               }); 
    $('#addNewTopicForm').submit( function(e){ 
            e.preventDefault();
        //Label elements in the form 
            $('.TopicNameLabel').text("Topic Name");
            $('.UnitNameLabel').text("Unit/ Theme");
            $('.topicDescriptionLabel').text("Topic Description");
            $('.topicLogoLabel').text("Topic Image");
    
        //default label class
             $('label').removeClass('text-danger');
                if(! minmax(3, 20, "#addNewTopicForm #TopicName", "A Real Topic name is required","#addNewTopicForm .TopicNameLabel")){
                    return false;
                 }
                 else if(! selectValid("#addNewTopicForm #UnitName", "Please select a Unit/ Theme", "#addNewTopicForm .UnitNameLabel")){
                     
                     return false;
                 }
                 
                 else if(! minmax(3, 100, "#addNewTopicForm #topicDescription", "A Real Topic Description is required","#addNewTopicForm .topicDescriptionLabel")){
                    return false;
                 }
                 
      
            var addTopicData=$(this).serialize();
            var addTopicSettings={
		"type":"POST",
		"url":"../api/topics",
		"headers":{
                    "cache-control":"no-cache"
		},
		"data":addTopicData
		};
		$.ajax(addTopicSettings).done(function(response){
                    	function returnResponse(){
                                    $('#addNewTopicForm .form-success').fadeIn( function(){
                                $(this).text("Theme/ Unit successfully Added");	
				$('#addNewTopicForm .form-success').fadeOut("slow");	
				});                                    
                                }		
				returnResponse();
				$('#addNewTopicForm')[0].reset();		
				getAllTopics();	
		});
    });
    
}
    
    
    //edit Unit Form
    //edit Topic Form
     //edit Topic Form
     //edit Topic Form
 function editTopic(id){   
     //get all units and put them in the select drop down menu
	var getTutorSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/units",
			"headers":{
				"cache-control":"no-cache"
			}
		};
                
        //select topic by id        
        var gettopicByIdSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/topics/"+id,
			"headers":{
				"cache-control":"no-cache"
			}
		};  
        $.ajax(gettopicByIdSettings).done(function(response){
            alert(JSON.stringify(response));
		//$('.unitList').html("");
		 $.each(response, function(key, value){
                    	$('#editTopicForm #TopicName').val(value.topic_name);
                        
                        var appendData="<option selected class='sUnits' value="+value.theme_id+">"+value.theme_name+"</option>";
			$('#editTopicForm .unitList').prepend(appendData);
                        $('#editTopicForm #topicDescription').val(value.description);
		
		});
                
               });        
	$.ajax(getTutorSettings).done(function(response){
		//$('.unitList').html("");
		 $.each(response, function(key, value){
                    	var appendData="<option class='sUnits' value="+value.theme_id+">"+value.theme_name+"</option>";
			
			
			$('#editTopicForm .unitList').append(appendData);
		
		});
                
               }); 
     imageValid('#editTopicForm #topicLogo', "Sorry you have selected unsupported file format We only Suppot PNG JPEG and JPG please Change it", "#editTopicForm .topicLogoLabel");

    $('#editTopicForm').submit( function(e){ 
            e.preventDefault();
        //Label elements in the form 
            $('.TopicNameLabel').text("Topic Name");
            $('.UnitNameLabel').text("Unit/ Theme");
            $('.topicDescriptionLabel').text("Topic Description");
            $('.topicLogoLabel').text("Topic Image");
    
        //default label class
             $('label').removeClass('text-danger');
                if(! minmax(3, 20, "#editTopicForm #TopicName", "A Real Topic name is required","#editTopicForm .TopicNameLabel")){
                    return false;
                 }
                 else if(! selectValid("#editTopicForm #UnitName", "Please select a Unit/ Theme", "#editTopicForm .UnitNameLabel")){
                     
                     return false;
                 }
                 
                 else if(! minmax(3, 100, "#editTopicForm #topicDescription", "A Real Topic Description is required","#editTopicForm .topicDescriptionLabel")){
                    return false;
                 }
                 
      
            var editTopicData=$(this).serialize();
            var editTopicSettings={
		"type":"POST",
		"url":"../api/topics/edit/"+id,
		"headers":{
                    "cache-control":"no-cache"
		},
		"data":editTopicData
		};
		$.ajax(editTopicSettings).done(function(response){
                    alert(response);
		});
    });

 }
