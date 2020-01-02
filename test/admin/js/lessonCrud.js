      //add lesson Form
    //add lesson Form
     //add lesson Form
     //add lesson Form

   function paginate_lessons()
   {
   		$.ajax(
   		{
   			"type":"GET",
   			"async":true,
   			"dataType":"json",
   			"url":"../api/lessons?pages=true&pageCount=10&pagesize=10",
   			success : function(res)
   						{
   							$.each(res,function(idx,val)
   							{
   								var el=$('<div class="pagination">');
   								el.attr('value',val);
   								el.html(idx+1);
   								el.appendTo($("#less_page"));
   							});

   							getAllLessons(res[0]);

   							$(".pagination").click(function()
   							{
   								getAllLessons($(this).attr('value'));
   							});
   						}
   		})
   }

   function getAllLessons(LessonId){
	   /*if(LessonId>0){
         var getClassesSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/lessons/topic/"+LessonId,
			"headers":{
				"cache-control":"no-cache"
			}
		};
	   }
	   else{*/
		   var getClassesSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/lessons?from="+LessonId,
			"headers":{
				"cache-control":"no-cache"
			}
		};   
	   //}
	$.ajax(getClassesSettings).success(function(response){
            
		$('.lessonsList').html("");
		
		 $.each(response, function(key, value){
		 	      
                        var tableData="<tr><td>"+value.name+"</td><td>"+value.topic_name+"</td>"+
			"<td><button value='"+value.lesson_id+"' class='slideByLesson btn btn-primary'><span class='fa fa-film'> </span> Slides</button></td>"+
                        "<td><button value='"+value.lesson_id+"' class='activityByLesson btn btn-default'><span class='fa fa-edit'> </span>Activity</button></td>"+
			"<td><button value='"+value.lesson_id+"' class='indLesson btn btn-primary' data-target='#editLesson' data-toggle='modal'><span class='fa fa-edit'> </span> Edit</button></td>"+
			"<td><button value='"+value.lesson_id+"' class='indLessonDel btn btn-warning' data-target='#deleteLesson' data-toggle='modal'><span class='fa fa-trash'> </span> Delete</button></td></tr>";
			$('.lessonsList').append(tableData);
		});
    $('.indLesson').click( function(e){
    e.preventDefault();
    var valueX= $(this).attr("value");
     
    editLesson(valueX);
   
    });
	
				 $('.indLessonDel').click( function(e){
    e.preventDefault();
    var delValueX= $(this).attr("value");
	
    delLesson(delValueX);
	
    });
	//load slides by lesson
	 $('.slideByLesson').click( function(e){
    e.preventDefault();
    var lessonId= $(this).attr("value");
	
    slideByLesson(lessonId);
	
    });
	
	
		//load activity by lesson
	 $('.activityByLesson').click( function(e){
    e.preventDefault();
    var lessonId= $(this).attr("value");
	
    activityByLesson(lessonId);
	
    });

		
	});
         
         
     }
	 
   
			function addLesson(){
				function callBackMethod(response){
					//alert(JSON.stringify(response));
		$('#addNewLessonForm .form-error').hide();
		if(response.status==="error" || response.status==="Error" || response.status==="Failed" || response.status==="failed"){
			               $('#addNewLessonForm .form-error').fadeIn( function(){
                                $(this).text("Sorry "+response.message + " "+response.errors);	
				
				});
			
		}
		else{
		
		                       $('#addNewLessonForm .form-success').fadeIn( function(){
                                $(this).text("Lesson successfully Added");	
				$('#addNewLessonForm .form-success').fadeOut("slow");	
				});  
				
				$('#addNewLessonForm')[0].reset();	
				getAllLessons();
		}
				
					
				
				
				
	}
				
				 $("#addNewLessonForm").ajaxify({url:'../api/lessons', validator:beforeSubmitAdd, onSuccess:callBackMethod});
        //Label elements in the form 
		function beforeSubmitAdd(){
			var obj={};
            $('.LessonNameLabel').text("Lesson Name");
            $('.topicNameLabel').text("Topic");
            $('.lessonDescriptionLabel').text("Lesson Description");
    
        //default label class
             $('label').removeClass('text-danger');
                if(! minmax(3, 40, "#addNewLessonForm #LessonName", "A Real Lesson name is required","#addNewLessonForm .LessonNameLabel")){
                     obj.status= false;
                 }
                 else if(! selectValid("#addNewLessonForm #topicName", "Please select a Topic", "#addNewLessonForm .topicNameLabel")){
                     
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
      
    
    
    //edit Lesson form
     //edit Lesson form
      //edit Lesson form
       //edit Lesson form
      
     
 	function editLesson(id){
		//alert(id);
		   var getlessonsByIdSettings = {
  "async": true,
  "dataType":"json",
  "type": "GET",
  "url": "../api/lessons/"+id,
    "headers": {
    "cache-control": "no-cache"    
  }
};



$.ajax(getlessonsByIdSettings).success(function (response) {
//alert(JSON.stringify(response[0].topic_id+" "+response[0].topic_name));
	var respx=response[0];
   $('#editLessonForm #LessonNameEdit').val(respx.name);
   
  	var appendData="<option value='"+respx.topic_id+"'>"+respx.topic_name+"</option>";
	
	$('#editLessonForm #topicListEdit').append(appendData);
});
		
		
		
				function callBackMethod(response){
					//alert(JSON.stringify(response));
		$('#editNewLessonForm .form-error').hide();
		if(response.status==="error" || response.status==="Error" || response.status==="Failed" || response.status==="failed" || response.status==="fail"){
			               $('#editNewLessonForm .form-error').fadeIn( function(){
                                $(this).text("Sorry "+response.message + " "+response.errors);	
				
				});
			
		}
		else{
		
		                       $('#addNewLessonForm .form-success').fadeIn( function(){
                                $(this).text("Lesson successfully Edited");	
				$('#addNewLessonForm .form-success').fadeOut("slow");	
				$('#content-area').html("");
					$('#content-area').load("lessons.php");
				});  
				$(".modal-backdrop").fadeOut();	
				$(".modal").modal("hide");	
				
				getAllLessons();
		}
				
					
				
				
				
	}
				
				 $("#editLessonForm").ajaxify({url:'../api/lessons/edit/'+id, validator:beforeSubmitEdit, onSuccess:callBackMethod});
        //Label elements in the form 
		function beforeSubmitEdit(){
			var obj={};
            $('.LessonNameLabel').text("Lesson Name");
            $('.topicNameLabel').text("Topic");
            $('.lessonDescriptionLabel').text("Lesson Description");
    
        //default label class
             $('label').removeClass('text-danger');
                if(! minmax(3, 40, "#editLessonForm #LessonNameEdit", "A Real Lesson name is required","#editLessonForm .LessonNameLabel")){
                     obj.status= false;
                 }
                 else if(! selectValid("#editLessonForm #topicListEdit", "Please select a Topic", "#editLessonForm .topicNameLabel")){
                     
                      obj.status= false;
                 }
                
				 else{
					obj.status=true;
					}
					var formx={};
			
			obj.postdata=formx;
					//alert(JSON.stringify(obj));
					return obj;
                 
			}
			
			}   
				function delLesson(id){
		
		
		//alert(id);
		$('#deleteLesson .delBtn').click( function(){
		
		var delLessonSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/lessons/delete/"+id,
			"headers":{
				"cache-control":"no-cache"
			}
		};
	$.ajax(delLessonSettings).success(function(response){
		getAllLessons();	
				
				
				
	});
	
	});	
}

	


	
			

    


