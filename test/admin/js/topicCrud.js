   $( function(){
getAllTopics();	   
//topicPaginator();
   }); 
    
	function topicPaginator(){
	var topicPaginatorSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/topics?pages=true&pagesize=8",
			"headers":{
				"cache-control":"no-cache"
			}
		};
		
			$.ajax(topicPaginatorSettings).success(function(response){
				//alert(JSON.stringify(response));
		$('.paginator').html("");
		var oneX=1;
		 $.each(response, function(key, value){
			 var totalPan=key+oneX;
		 	var appendData="<button class='btn btn-default pageBtn' value='"+value+"'>"+totalPan+"</button>";
			$('.paginator').append(appendData);
		});
    $('.pageBtn').click( function(e){
    e.preventDefault();
    var valueX= $(this).attr("value");
    
    });
		
	});
		
	}
function getAllTopics(UnitId){
	
	if(UnitId>0){
	  	var getClassesSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/topics/theme/"+UnitId,
			"headers":{
				"cache-control":"no-cache"
			}
		};	
		
	
	}
	else{
	
    	var getClassesSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/topics",
			"headers":{
				"cache-control":"no-cache"
			}
		};
	}
	$.ajax(getClassesSettings).success(function(response){
		
		$('.topicList').html("");
		 $.each(response, function(key, value){
		 	var appendData="<div class='col-md-3 topicBox'><div class='thumbs'><img src='"+value.image+"' class='' style='width:100%;'></div>"+
			"<div class='details'><h4 class='text-primary'><a class='text-primary' href='#'>"+value.topic_name+"</a></h4>"+
		 	"<div class='btn-group btn-group-xs'><button class='btn btn-primary indTopic' value='"+value.topic_id+"' data-target='#editTopic' data-toggle='modal'>"+
			"<span class='fa fa-edit'></span> Edit</button><button value='"+value.topic_id+"' class='delTopic btn btn-warning' data-target='#deleteTopic' data-toggle='modal'>"+
			"<span class='fa fa-trash'></span> Delete</button></div></div></div>";
			$('.topicList').append(appendData);
		});
    $('.indTopic').click( function(e){
    e.preventDefault();
    var valueX= $(this).attr("value");
    editTopic(valueX);
    //console.log(valueX);
    });
	   $('.delTopic').click( function(e){
    e.preventDefault();
    var valueD= $(this).attr("value");
    deleteTopic(valueD);
    //console.log(valueD);
    });
		
	});
    
    
}
 //add Topic Form

	//imageValid('#addNewTopicForm #topicLogo', "Sorry you have selected unsupported file format We only Suppot PNG JPEG and JPG please Change it", "#addNewTopicForm .topicLogoLabel");
function addTopic(){
    //get all units and put them in the select drop down menu
	
		
		 $("#addNewTopicForm").ajaxify({url:'../api/topics', validator:beforeSubmitTopic, onSuccess:callBackMethodo}); 
		function callBackMethodo(responseo){
			console.log(JSON.stringify(responseo));
			
			if(responseo.status==="failed"){
				              $('#addNewTopicForm .form-error').fadeIn( function(){
                                $(this).text(responseo.message);
                                setTimeout( function(){
				$('#addNewTopicForm .form-error').fadeOut("slow");	
				}, 3000);
                                });

			}
			else{
				
                                    $('#addNewTopicForm .form-success').fadeIn( function(){
                                $(this).text("Theme/ Unit successfully Added");	
                                setTimeout( function(){
				$('#addNewTopicForm .form-success').fadeOut("slow");
                                }, 3000);
				});                                    
              
				$('#addNewTopicForm')[0].reset();		
				getAllTopics();
			}
				
		}
 

			function beforeSubmitTopic(){
				var obj={};
        //Label elements in the form 
            $('.TopicNameLabel').text("Topic Name");
            $('.UnitNameLabel').text("Unit/ Theme");
            $('.topicDescriptionLabel').text("Topic Description");
            $('.topicLogoLabel').text("Topic Image");
    
        //default label class
             $('label').removeClass('text-danger');
                if(! minmax(3, 100, "#addNewTopicForm #TopicName", "A Real Topic name is required","#addNewTopicForm .TopicNameLabel")){
                    obj.status= false;
                 }
                 else if(! selectValid("#addNewTopicForm #UnitName", "Please select a Unit/ Theme", "#addNewTopicForm .UnitNameLabel")){
                     
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
    
    
    //edit Unit Form
    //edit Topic Form
     //edit Topic Form
     //edit Topic Form
 function editTopic(id){
	 	$("#editTopicForm .img-avail").show();
	$("#editTopicForm .img-upload").hide();
	$("#editTopicForm .removeImg").show();
	$("#editTopicForm .cancelRemoveImg").hide();
$("#editTopicForm .img-upload").hide();
$("#editTopicForm .cancelRemoveImg").hide();
$("#editTopicForm .img-upload #classLogoEdit").val("");
$('#editTopicForm .removeImg').click( function(){
	$("#editTopicForm .img-avail").hide();
	$("#editTopicForm .img-upload").slideDown();
	$("#editTopicForm .removeImg").hide();
	$("#editTopicForm .cancelRemoveImg").fadeIn();
	$("#editTopicForm .cancelRemoveImg").click( function(){
		$("#editTopicForm .img-avail").fadeIn();
	$("#editTopicForm .img-upload").hide();
	$("#editTopicForm .img-upload #unitLogoEdit").val("");
	$("#editTopicForm .removeImg").fadeIn();
	$("#editTopicForm .cancelRemoveImg").hide();
	});

});
     //get all units and put them in the select drop down menu
                
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
            console.log(JSON.stringify(response));
		$('#editTopicForm .unitList').html("");
		 $.each(response, function(key, value){
                    	$('#editTopicForm #TopicName').val(value.topic_name);
                        
                        var appendData="<option selected class='sUnits' value="+value.theme_id+">"+value.theme_name+"</option>";
			$('#editTopicForm .unitList').prepend(appendData);
                        $('#editTopicForm #topicDescription').val(value.description);
                        $('#editTopicForm .pic').attr("src",value.image);
		
		});
                
               });        

			   
     imageValid('#editTopicForm #topicLogo', "Sorry you have selected unsupported file format We only Suppot PNG JPEG and JPG please Change it", "#editTopicForm .topicLogoLabel");

   
		function beforeEditTopic(){
			var obj={};
            $('.TopicNameLabel').text("Topic Name");
            $('.UnitNameLabel').text("Unit/ Theme");
            $('.topicDescriptionLabel').text("Topic Description");
            $('.topicLogoLabel').text("Topic Image");
    
        //default label class
             $('label').removeClass('text-danger');
                if(! minmax(3, 100, "#editTopicForm #TopicName", "A Real Topic name is required","#editTopicForm .TopicNameLabel")){
                    obj.status= false;
                 }
                 else if(! selectValid("#editTopicForm #UnitName", "Please select a Unit/ Theme", "#editTopicForm .UnitNameLabel")){
                     
                       obj.status= false;
                 }
                 

				   else{
					obj.status=true;
					}
					var formx={};
			
			obj.postdata=formx;
					
					return obj;
                 
      
            var editTopicData=$(this).serialize();
            var editTopicSettings={
		"type":"POST",
		"url":"../api/topics/edit/"+id,
		"headers":{
                    "cache-control":"no-cache"
		},
		"data":editTopicData
		};
		
	}
	
			  $("#editTopicForm").ajaxify({url:'../api/topics/edit/'+id, validator:beforeEditTopic, onSuccess:callBackMethodEdit});     
	function callBackMethodEdit(response){
		console.log(JSON.stringify(response));
		                    console.log("Hey i m from Here "+JSON.stringify(response));
          if(response.status==="failed"){
				              $('#editTopicForm .form-error').fadeIn( function(){
                                $(this).text(response.message);	
				$('#editTopicForm .form-error').fadeOut("slow");	
				});				
			}
			else{
			$('#editTopicForm .form-success').fadeIn( function(){
                    $(this).text("Theme/ Unit successfully Edited");	
                    $('#editTopicForm .form-success').fadeOut("slow");	
					
					
					 $('#content-area').html("");
					$('#content-area').load("topics.php");
                    });  
					$(".modal-backdrop").fadeOut();	
				$(".modal").modal("hide");	
			}          
                    
                     
					
				}    

 }
 
 
 
 	function deleteTopic(id){
		
		
		console.log(id);
		$('#deleteTopic .delBtn').click( function(){
		
		var delSubjectSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/topics/delete/"+id,
			"headers":{
				"cache-control":"no-cache"
			}
		};
	$.ajax(delSubjectSettings).success(function(response){
		getAllTopics();	
				
				
				
	});
	
	});	
}
