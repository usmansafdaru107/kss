
function getActivities(id){
	$('#ByLessonBtn').attr("value",id);
	//alert($('#ByLessonBtn').attr("value"));
	var getActiviySettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/quiz/lesson/"+id,
			"headers":{
				"cache-control":"no-cache"
			}
		};
	$.ajax(getActiviySettings).success(function(response){
           
		$('.activityList').html("");
		var responsed=JSON.stringify(response); 
		
		
		 $.each(response, function(key, value){
		 	var appendData="<tr><td class='prevAcitity' data-target='"+value.quiz_id+"'>"+value.quiz_name+"</td>"+
			"<td><button value='"+value.quiz_id+"' data-target='#QandA' data-toggle='modal' class='QandA btn btn-default btn-xs'>?</button></td>"+
			"<td><button value='"+value.quiz_id+"' data-target='#QuizContent' data-toggle='modal' class='indQuiz btn btn-default btn-xs'><span class='fa fa-edit'></span></button></td>"+
			"<td><button value='"+value.quiz_id+"' class='indQuizDel btn btn-default btn-xs' data-target='#deleteQuiz' data-toggle='modal'><span class='fa fa-times'></span></button></td>"+
			"</tr>";
			$('.activityList').append(appendData);
		});
    $('.indQuiz').click( function(e){
    e.preventDefault();
    var valueX= $(this).attr("value");
    editQuiz(valueX,id);
    });
	
				 $('.indQuizDel').click( function(e){
    e.preventDefault();
    var delValue= $(this).attr("value");
	
    delQuiz(delValue, id);
	
    });
	
	$('.QandA').click( function(e){
	 e.preventDefault();
    var qValue= $(this).attr("value");
	$('.addQuestionBtn').attr("value",qValue);
	getQuestions(qValue);
	});
	
	$('.prevAcitity').click( function(e){
	 e.preventDefault();
    var aValue= $(this).attr("data-target");
	prevActivity(aValue);
	});
	
	
		
	});


}	


function getQuestions(id){
	//alert("List all Question of a Quiz");
	
	//alert($('#ByLessonBtn').attr("value"));
	var getQuestionSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/question/quiz/"+id,
			"headers":{
				"cache-control":"no-cache"
			}
		};
	$.ajax(getQuestionSettings).success(function(response){
             alert(JSON.stringify(response));
		$('.questionList').html("");
		
		var responsed=JSON.stringify(response); 
		//alert(responsed);
		if(responsed.length<3){
		//loadPreview("../resources/activity/template.html");
			
		}else{
			
		//loadPreview("../resources/activity/template.html");
		}
		var fResponse=response.questions;
		
		 $.each(fResponse, function(key, value){
		 	var appendData="<tr class='prevQuestion' data-target='"+value.instruction_id+"instruction_id'><td data-target='"+value.instruction_id+"'>"+value.instruction+"</td>"+
			"<td><button value='"+value.instruction_id+"' data-target='#QuizContent' data-toggle='modal' class='indQuiz btn btn-default btn-xs'><span class='fa fa-edit'></span></button></td>"+
			"<td><button value='"+value.instruction_id+"' class='indQuizDel btn btn-default btn-xs' data-target='#deleteQuiz' data-toggle='modal'><span class='fa fa-times'></span></button></td>"+
			"</tr>";
			$('.questionList').append(appendData);
		});
				$('#EditQandAForm').hide();		
				
				$('.prevQuestion').click( function(e){
					e.preventDefault();
				 if($('.prevQuestion').hasClass('btn-primary')){
					 $('.prevQuestion').removeClass('btn-primary');
				 }
    
    var qnaId=$(this).attr("data-target");
	$(this).addClass('btn-primary');
	
       
		
			$('#AddQandAForm').hide( function(){
				$('#EditQandAForm').show( function(){
					
					editQandA(qnaId);
					
				});
			});
			
	

    });
		

	});


}	
$(function(){
$('#AddQandAForm').hide();
 $('#ByLessonBtn').click( function(e){
    e.preventDefault();
   
	
    addActivity();
	
    });
	
	$('.addQuestionBtn').click( function(e){
    e.preventDefault();
    var qValue= $(this).attr("value");
	
	addQandA(qValue);
	
	
    });
	
});

			function beforeSubmitAddA(){
				 var lessonId= $('#ByLessonBtn').attr("value");
			var obj={};
          $('.QuizNameLabel').text("Activity Name");
          
		  
    
        //default label class
           $('label').removeClass('text-danger');
                if(! minmax(3, 100, "#addNewActivityForm #quizNameAdd", "A Real Quiz name is required","#addNewActivityForm .QuizNameLabel")){
                    obj.status= false;
                 }
           	 else{
					obj.status=true;
					}
					
			var quizName=$('#quizNameAdd').val();
          		
					
					var formx={
			"quizName":quizName,
			"lesson":lessonId
			
			};
			
			obj.postdata=formx;
					
					return obj;
                 
			}			
				function callBackMethodA(response){
					
		$('#addNewActivityForm .form-error').hide();
		if(response.status==="error" || response.status==="Error" || response.status==="Failed" || response.status==="failed"){
			               $('#addNewActivityForm .form-error').fadeIn( function(){
                                $(this).text("Sorry "+response.message + " "+response.errors);	
				
				});
			
		}
		else{
		
		                       $('#addNewActivityForm .form-success').fadeIn( function(){
                                $(this).text("Quiz successfully Added");	
				$('#addNewActivityForm .form-success').fadeOut("slow");	
				});  
				
				$('#addNewActivityForm')[0].reset();	
				 var lessonId= $('#ByLessonBtn').attr("value");
				getActivities(lessonId);
				var quizName="";
			var lessonId="";
		}
				
	}
	function addActivity(){

				
				 $("#addNewActivityForm").ajaxify({url:'../api/quiz', validator:beforeSubmitAddA, onSuccess:callBackMethodA});
        //Label elements in the form 

			
			}
			
			
//edit slide


 	function editQuiz(quizId,lessonId){
		
		//getAllResources();
		
	var getQuizByIdSettings = {
  "async": true,
  "dataType":"json",
  "type": "GET",
  "url": "../api/quiz/"+quizId,
    "headers": {
    "cache-control": "no-cache"    
  }
};



$.ajax(getQuizByIdSettings).success(function (response) {

	
  $('#editActivityForm #quizNameEdit').val(response[0].quiz_name);
  //var urlEdit=response[0].url;





});
		
		
		
				function callBackMethod(response){
					
					$('#editActivityForm .form-error').hide();
		if(response.status==="error" || response.status==="Error" || response.status==="Failed" || response.status==="failed" || response.status==="fail"){
			             
				notify("Sorry "+response.message + " "+response.errors, "error");
				
			
		}
		else{
 			
			$('#content-area').html("");
	 var linked="activity.php";
         $('#content-area').load(linked, function(){
         	//sessionStorage['current_page']=linked;
			
					
					$(".modal-backdrop").hide();	
				$(".modal").modal("hide");	
		 	getActivities(lessonId);	
			notify("Quiz successfully updated", "success");	
			var quizId="";	
		 });
		}
				
					
				
				
				
	}
				
				 $("#editActivityForm").ajaxify({url:'../api/quiz/edit/'+quizId, validator:beforeSubmitEdit, onSuccess:callBackMethod});
        //Label elements in the form 
		function beforeSubmitEdit(){
			var obj={};
           $('.ActivityNameLabel').text("Activity Name");
          
    
        //default label class
             $('label').removeClass('text-danger');
                if(! minmax(3, 100, "#editActivityForm #quizNameEdit", "A Valid Quiz name is required","#editActivityForm .ActivityNameLabel")){
                     obj.status= false;
                 }
                              
				 else{
					obj.status=true;
					}
					
					var quizName=$('#quizNameEdit').val();
					//var slideContent=$('#editorx').val();
          
							var formx={
			"quizName":quizName,
		"lesson":lessonId
			//"editorx":slideContent
			
			};
			
			obj.postdata=formx;
					//alert(JSON.stringify(obj));
					return obj;
                 
			}
			
			}  			
       
    
 
				
 
function delQuiz(quizId, lessonId){
	
		//alert(lessonId);
		
		
		$('.delQuizBtn').click( function(){
		//alert(slideId);
		var delQuizSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/quiz/delete/"+quizId,
			"headers":{
				"cache-control":"no-cache"
			}
		};
		//alert(JSON.stringify(delSlideSettings));
	$.ajax(delQuizSettings).success(function(response){
		//alert(JSON.stringify(response));
		//alert(response);
		getActivities(lessonId);	
			notify("Quiz Removed", "warning");	
			var quizId="";					
			//var lessonId="";					
	});
	
	});	
}

function loadPreview(url){

$('.loadpInner').html("");	
$('.loadpInner').load(url);	
	//alert(url);
	
}





















			function beforeSubmitAddq(){
				 var lessonId= $('#addQuestionBtn').attr("value");
			var obj={};
          $('#AddQandAForm .QuestionLabel').text("Question");
          $('#AddQandAForm .questionTypeLabel').text("Question Type");
          $('#AddQandAForm .answerLabel').text("Answer");
         $('#AddQandAForm.objectiveAnswer').text("Objective Answer");
      
	  
		  
    
        //default label class
           $('label').removeClass('text-danger');
                if(! minmax(2, 100, "#AddQandAForm #question", "A valid question is required","#AddQandAForm .QuestionLabel")){
                    obj.status= false;
                 }
				 
				 else if(! selectValid("#AddQandAForm #questionType", "Please select a Question Type", ".questionTypeLabel")){
                    obj.status= false;
					
                 }
				 else if(!$('#AddQandAForm #answer').attr("disabled")==true && ! minmax(2, 100, "#AddQandAForm #answer", "A valid Anwser is required","#AddQandAForm .answerLabel")){
                    obj.status= false;
                 }
				 else if(!$('#AddQandAForm #objective1').attr("disabled")==true && ! minmax(2, 100, "#AddQandAForm #objective1", "A Please Provide Objectives","#AddQandAForm .objectiveAnswer")){
					  obj.status= false;
				 }
				 
				  else if(!$('#AddQandAForm #objective2').attr("disabled")==true && ! minmax(2, 100, "#AddQandAForm #objective2", "A Please Provide Objectives","#AddQandAForm .objectiveAnswer")){
					 obj.status= false; 
				 }
				   else if($('#AddQandAForm #objective3').length && !$('#AddQandAForm #objective3').attr("disabled")==true && ! minmax(2, 100, "#AddQandAForm #objective3", "A Please Provide Objectives","#AddQandAForm .objectiveAnswer")){
					 obj.status= false; 
				 }
				   else if($('#AddQandAForm #objective4').length && !$('#AddQandAForm #objective4').attr("disabled")==true && ! minmax(2, 100, "#AddQandAForm #objective4", "A Please Provide Objectives","#AddQandAForm .objectiveAnswer")){
					 obj.status= false; 
				 }
           	 else{
					obj.status=true;
					}
					
			var question=$('#question').val();
			var qnType=$('#AddQandAForm #questionType').val();
          		
				
		    var objectiveTrue={};
     var checkedRadio=$('input[name="answer"]:checked', '#AddQandAForm').val();
	 
	
      
	  
		//objectiveTrue['status']=checkedRadio;
		var answer=[];	
		
		$.each($('#AddQandAForm .ans'), function(){
			var x={};
			
		x['answer']=$(this).find($('.objk')).val();
		//var checkedRadio=$(this).find($('.radio:checked'));
		//alert(checkedRadio.val());
			if($(this).hasClass('selectedR')){
				alert($(this).html());
				x['status']=1;
			}
		else{
		
			x['status']=0;
		}		
			answer.push(x);	
		});

		
	
				
				var quizId=$('.addQuestionBtn').attr("value");	
			var formx={
								"quiz":quizId,
								"question":question,
                                                                 "instruction":"No instruction"
							  };

					if($("#questionType").val()==1)
					{
						//objectiveTrue['status']=checkedRadio;
						var answer=[];	
						$.each($('#AddQandAForm .ans'), function(){
						var x={};
			
						x['answer']=$(this).find($('.objk')).val();
						//var checkedRadio=$(this).find($('.radio:checked'));
						//alert(checkedRadio.val());
						if($(this).hasClass('selectedR')){
						//alert($(this).html());
						x['status']=1;
						}
						
						else{
								x['status']=0;
							}		
						
							answer.push(x);	
						});
						formx['qnType']=1;
						formx["answers"]=JSON.stringify(answer);
                                                
                                                 formx['instruction']='No instruction';
                                                 notify(typeof formx['answers'],'warning');
					}

					else if($("#questionType").val()==2)
					{
						formx['qnType']=2;
						formx["answer"]=$("#answer").val();
						formx["status"]=1;
                                                formx['instruction']='No instruction';

					}
			
			obj.postdata=formx;
				alert(JSON.stringify(formx));	
					return obj;
                 
			}			
				function callBackMethod(response){
					alert(JSON.stringify(response));	
					
		$('#AddQandAForm .form-error').hide();
		if(response.status==="error" || response.status==="Error" || response.status==="Failed" || response.status==="failed"){
			               $('#AddQandAForm .form-error').fadeIn( function(){
                                $(this).text("Sorry "+response.message + " "+response.errors);	
				
				});
			
		}
		else{
		
		                       $('#AddQandAForm .form-success').fadeIn( function(){
                                $(this).text("Question successfully Added");	
				$('#AddQandAForm .form-success').fadeOut("slow");	
				});  
				
				$('#AddQandAForm')[0].reset();	
				 var quizId=$('.addQuestionBtn').attr("value");
				getQuestions(quizId);
				var question="";
			var qnType="";
			var objectives="";
		}
				
	}
	function addQandA(quizId){
            
            
		$('#AddQandAForm .objectiveFields .addedFields').html('');
			$('#EditQandAForm').hide( function(){
				$('#AddQandAForm').slideDown();	
							
			});
		var objValue=2;
		$('#addObj').click( function(){
			//alert('Tsup');
			//var objValue=$('.nd').val();
			objValue++;
				
			var objField='<div class="row objField">'+
					'<div class="col-md-12">'+
						'<label class="objectiveAnswer" for="objectives">Objective Answer</label>'+
						'<div class="input-group ans">'+
							 '<input type="text" name="objective'+objValue+'" id="objective'+objValue+'" class="objk form-control" placeholder="Objective '+objValue+'"></input>'+
							 '<span class="input-group-addon">'+
								'<input name="answer" value="'+objValue+'" class="radio" type="radio">'+
								
									
							'</span>'+'<span class="removeObjFieldDiv input-group-addon">'+
								'<a class="removeObjField btn btn-xs btn-warning"><i class="fa fa-times"> </i> </a>'+'</span>'+
						'</div>'+
				  '</div>'+
				'</div>'+
				'';
			if(objValue<5){
				
			$('.objectiveFields .addedFields').append(objField);
			$('.removeObjFieldDiv').hide();
			$('.objectiveFields .addedFields .row:last .removeObjFieldDiv').show();
			$('#AddQandAForm .removeObjField').click( function(e){
				e.preventDefault();
				if(objValue>2){
					
				objValue--;
				}
				else{
					objValue=2;
				}				
				notify('You have removed this Field', 'success');
				var parentObj=$(this).parent().parent().parent().parent();
				//alert(parentObj);
				//$('.objectiveFields .objField:last-child').remove();
				
				parentObj.remove();
				$('#AddQandAForm .removeObjFieldDiv').hide();
			$('#AddQandAForm .objectiveFields .addedFields .row:last .removeObjFieldDiv').show();
			});
			}
			else{
				objValue=4;
				notify('You cannot add more than four objectives','warning');
			}
		});
		 $('body').on('change','.radio', function(){
		  $('.ans').removeClass('selectedR'); 
		  //$.find('.ans').removeClass('selectedR');
		// alert($(this).parent().parent().html());
		 $(this).parent().parent().addClass('selectedR');
			 
	 });
		//alert(quizId);
		
		 $('.structuredField').hide(); 
			$('.objectiveFields').hide();
		 $('body').on("change", "#questionType", function(){
			 //alert("Nara");
			 var valueChange=$('#questionType').val();
			 //var intP=parseInt(valueChange);
			 if(valueChange=="2"){
				 
				 $('.objectiveFields').hide( function(){
				$('.structuredField').slideDown(); 
				$('.objectiveFields input').attr("disabled",true);
				$('.structuredField #answer').attr("disabled",false);
				 });
			 }
			 else if(valueChange=="1"){
				 	 
					 $('.structuredField').hide( function(){
						 $('.objectiveFields').slideDown(); 
						 $('.objectiveFields input').attr("disabled",false);
						 $('.structuredField #answer').attr("disabled",true);
					 }); 
					 
			 }
			 else{
				 notify("Select a Question Type", "warning");
			 $('.structuredField').hide(); 
			$('.objectiveFields').hide(); 					 
			 }

		 });
		
$('#AddQandAForm')[0].reset();


$('#AddQandAForm').addClass('alert alert-success');
				
				 $("#AddQandAForm").ajaxify({url:'../api/question', validator:beforeSubmitAddq, onSuccess:callBackMethod});

			}
			

	function editQandA(id){
            
           function beforeSubmitEditq(){
				
			var obj={};
          $('#EditQandAForm .QuestionLabele').text("Question");
          $('#EditQandAForm .questionTypeLabele').text("Question Type");
          $('#EditQandAForm .answerLabele').text("Answer");
         $('#EditQandAForm .objectiveAnswere').text("Objective Answer");
      
	  
		  
    
        //default label class
           $('label').removeClass('text-danger');
                if(! minmax(2, 100, "#EditQandAForm #questione", "A valid question is required","#EditQandAForm .QuestionLabele")){
                    obj.status= false;
                 }
				 
				 else if(! selectValid("#EditQandAForm #questionTypee", "Please select a Question Type", ".questionTypeLabele")){
                    obj.status= false;
					
                 }
				 else if(!$('#EditQandAForm #answere').attr("disabled")==true && ! minmax(2, 100, "#EditQandAForm #answere", "A valid Anwser is required","#EditQandAForm .answerLabele")){
                    obj.status= false;
                 }
				 else if(!$('#EditQandAForm #objectivee1').attr("disabled")==true && ! minmax(2, 100, "#EditQandAForm #objectivee1", "A Please Provide Objectives","#EditQandAForm .objectiveAnswere")){
					  obj.status= false;
				 }
				 
				  else if(!$('#EditQandAForm #objectivee2').attr("disabled")==true && ! minmax(2, 100, "#EditQandAForm #objectivee2", "A Please Provide Objectives","#EditQandAForm .objectiveAnswere")){
					 obj.status= false; 
				 }
				   else if($('#EditQandAForm #objectivee3').length && !$('#EditQandAForm #objectivee3').attr("disabled")==true && ! minmax(2, 100, "#EditQandAForm #objectivee3", "A Please Provide Objectives","#EditQandAForm .objectiveAnswere")){
					 obj.status= false; 
				 }
				   else if($('#EditQandAForm #objectivee4').length && !$('#EditQandAForm #objectivee4').attr("disabled")==true && ! minmax(2, 100, "#EditQandAForm #objectivee4", "A Please Provide Objectives","#EditQandAForm .objectiveAnswere")){
					 obj.status= false; 
				 }
           	 else{
					obj.status=true;
					}
					
			var question=$('#questione').val();
			var qnType=$('#EditQandAForm #questionTypee').val();
                        var instruction=$('#EditQandAForm #instructione').val();
          		
				
		    var objectiveTrue={};
     var checkedRadio=$('input[name="answer"]:checked', '#EditQandAForm').val();
	 
	
      
	  
		//objectiveTrue['status']=checkedRadio;
		var answer=[];	
		
		$.each($('#EditQandAForm .ans'), function(){
			var x={};
			
		x['answer']=$(this).find($('.objk')).val();
		//var checkedRadio=$(this).find($('.radio:checked'));
		//alert(checkedRadio.val());
			if($(this).hasClass('selectedR')){
				alert($(this).html());
				x['status']=1;
			}
		else{
		
			x['status']=0;
		}		
			answer.push(x);	
		});

		
	
				
				
			var formx={
								'qn_id':id,
                                                                "instruction":instruction,
								"question":question
							  };

					if($("#questionTypee").val()==1)
					{
						//objectiveTrue['status']=checkedRadio;
						var answer=[];	
						$.each($('#EditQandAForm .ans'), function(){
						var x={};
			
						x['answer']=$(this).find($('.objk')).val();
						//var checkedRadio=$(this).find($('.radio:checked'));
						//alert(checkedRadio.val());
						if($(this).hasClass('selectedR')){
						//alert($(this).html());
						x['status']=1;
						}
						
						else{
								x['status']=0;
							}		
						
							answer.push(x);	
						});
						formx['qnType']=1;
                                                formx['instruction']=instruction;
						formx["answers"]=JSON.stringify(answer);
                                                 formx['qn_id']=id;
					}

					else if($("#questionTypee").val()==2)
					{
						formx['qnType']=2;
                                                formx['qn_id']=id;
                                                formx['instruction']=instruction;
						formx["answer"]=$("#answere").val();
						formx["status"]=1;

					}
			
			obj.postdata=formx;
				alert(JSON.stringify(formx));	
					return obj;
                 
			}			
				function callBackMethodq(response){
				//alert(json.stringify(response));
                                alert("We are done for good");
					
		
               
		if(response.status==="error" || response.status==="Error" || response.status==="Failed" || response.status==="failed"){
			     notify("Sorry "+response.message + " "+response.errors,"warning");
                                
                                
			
		}
		else{
		       notify("Question successfully Added","success");
				
				//$('#EditQandAForm')[0].reset();	
				 id='';
				getQuestions(id);
				question="";
			qnType="";
			objectives="";
		}
				
	} 
        
         $("#EditQandAForm").ajaxify({url:'../api/question/edit/'+id, validator:beforeSubmitEditq, onSuccess:callBackMethodq});
            
            
			$('.removeObjFieldDiv').hide();
		$('.objectiveFields .row:last .removeObjFieldDiv').show();
                
			
		
		
			 
			var getQnASettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/question/load/"+id,
			"headers":{
				"cache-control":"no-cache"
			}
		};	
		$.ajax(getQnASettings).success(function(response){
			var strinified=JSON.stringify(response);
				$('#questione').val(response.question);
				var justc =$('#questionTypee option.'+response.qn_type);
				justc.attr('selected', true);
				if(response.qn_type=="2"){
				 
				 $('.objectiveFields').hide( function(){
				$('.structuredField').slideDown(); 
				$('.objectiveFields input').attr("disabled",true);
				$('.structuredField #answere').attr("disabled",false);
				 });
				 var answers=response.answers; 
				//alert(answers[0].answer);
				 $('#answere').val(answers[0].answer); 
			 }
			 else if(response.qn_type=="1"){
				 	 
					 $('.structuredField').hide( function(){
						 $('.objectiveFields').slideDown(); 
						 $('.objectiveFields input').attr("disabled",false);
						 $('.structuredField #answere').attr("disabled",true);
					 });

 var answers=response.answers;
 $('#EditQandAForm .objectiveFields').html('');
		 $.each(answers, function(key, value){
			 
			 key++;
		// $('#objectivee'+key).val(value.answer);
		 
		 			 var rowObkect='<div class="row objField" value="'+key+'">'+
					'<div class="col-md-12">'+
						'<label class="objectiveAnswere" for="objectives">Objective Answer</label>'+
						'<div class="input-group ans">'+
							  '<input type="text" name="objective'+key+'" id="objectivee'+key+'" class="objk form-control" value="'+value.answer+'" placeholder="Objective '+key+'"></input>'+
							 '<span class="input-group-addon">'+
								'<input name="answer" value="'+key+'" class="radio nd" type="radio">'+
							'</span>'+
							'<span class="removeObjFieldDiv input-group-addon">'+
								'<a class="removeObjField btn btn-xs btn-warning" href="'+key+'"><i class="fa fa-times"> </i> </a>'+
							'</span>'+
					'</div><!-- /input-group -->'+
				'</div>'+
				'</div>';
			 $('#EditQandAForm .objectiveFields').append(rowObkect);
                         });
                         $('.removeObjFieldDiv').hide();
			$('.objectiveFields .row:last .removeObjFieldDiv').show();   
                         
                          
                        $('.addObj').click( function(){
                             var objValue=$('#EditQandAForm .objectiveFields .row').last().attr("value");
                            alert(objValue);
                            if(objValue>0){
                                
                             
                            }
                            else{
                             objValue=0;   
                            }
                            objValue++; 
                   	//alert(objValue);
			//var objValue=$('.nd').val();
			var key=objValue;
				
			var objField='<div class="row objField" value="'+key+'">'+
					'<div class="col-md-12">'+
						'<label class="objectiveAnswer" for="objectives">Objective Answer</label>'+
						'<div class="input-group ans">'+
							 '<input type="text" name="objective'+objValue+'" id="objective'+objValue+'" class="objk form-control" placeholder="Objective '+objValue+'"></input>'+
							 '<span class="input-group-addon">'+
								'<input name="answer" value="'+objValue+'" class="radio" type="radio">'+
								
									
							'</span>'+'<span class="removeObjFieldDiv input-group-addon">'+
								'<a class="removeObjField btn btn-xs btn-warning"><i class="fa fa-times"> </i> </a>'+'</span>'+
						'</div>'+
				  '</div>'+
				'</div>'+
				'';
			if(objValue<5){
				
			$('#EditQandAForm .objectiveFields').append(objField);
                            
                          $('#EditQandAForm .removeObjFieldDiv').hide();
			$('#EditQandAForm .objectiveFields .row:last .removeObjFieldDiv').show();
                                              
			
			 $('#EditQandAForm .removeObjField').click( function(e){
                            var objValue=$(this).attr("data-value");
				e.preventDefault();
				if(objValue>0){
					
				objValue--;
				}
				else{
					objValue=0;
				}				
				notify('You have removed this Field', 'success');
				var parentObj=$(this).parent().parent().parent().parent();
				//alert(parentObj);
				//$('.objectiveFields .objField:last-child').remove();
				
				parentObj.remove();
				$('#EditQandAForm .removeObjFieldDiv').hide();
			$('#EditQandAForm .objectiveFields .row:last .removeObjFieldDiv').show();
			});
			}
			else{
				objValue=4;
				notify('You cannot add more than four objectives','warning');
			}
                        
		});
                        $('#EditQandAForm .removeObjField').click( function(e){
                            var objValue=$(this).attr("data-value");
				e.preventDefault();
				if(objValue>0){
					
				objValue--;
				}
				else{
					objValue=0;
				}				
				notify('You have removed this Field', 'success');
				var parentObj=$(this).parent().parent().parent().parent();
				//alert(parentObj);
				//$('.objectiveFields .objField:last-child').remove();
				
				parentObj.remove();
				$('#EditQandAForm .removeObjFieldDiv').hide();
			$('#EditQandAForm .objectiveFields .row:last .removeObjFieldDiv').show();
			}); 
                         
                         
			 
		 
			 
			 }
			//$('#questionTypee option.'+response.qn_type).attr('selected', true);				
		
		});
		
		$('body').on("change", "#questionTypee", function(){
			// alert("Nara");
			 var valueChange=$('#questionTypee').val();
			 //var intP=parseInt(valueChange);
			 if(valueChange=="2"){
				 
				 $('.objectiveFields').hide( function(){
				$('.structuredField').slideDown(); 
				$('.objectiveFields input').attr("disabled",true);
				$('.structuredField #answere').attr("disabled",false);
				 });
			 }
			 else if(valueChange=="1"){
				 	 
					 $('.structuredField').hide( function(){
						 $('.objectiveFields').slideDown(); 
						 $('.objectiveFields input').attr("disabled",false);
						 $('.structuredField #answere').attr("disabled",true);
					 }); 
					 
			 }
			 else{
				// notify("Select a Question Type", "warning");
			 $('.structuredField').hide(); 
			$('.objectiveFields').hide(); 					 
			 }

		 });
		 
		
		
		
	}
	
	
function prevActivity(id){
	//$('.loadpInner').html('');
	$('.loadpInner .answers-section').html('');
	$('.loadpInner h3.page-header').text('');
	$('.loadpInner .question-section').html('');

		var getactivityLoadSettings = {
		  "async": true,
		  "dataType":"json",
		  "type": "GET",
		  "url": "../api/quiz/setup/"+id,
			"headers": {
			"cache-control": "no-cache"    
		}
};
	$.ajax(getactivityLoadSettings).success(function (response) {

	//notify(JSON.stringify(response), 'warning');
 // $('#editActivityForm #quizNameEdit').val(response[0].quiz_name);
  //var urlEdit=response[0].url;
 
  $.each(response, function(key, value){
	  
$('.loadpInner h3.page-header').text(response.name);	  
  });


var quenId=response.questions;
$('.pagitivity').html('');
$.each(quenId, function(key, value){
	key++;
	var but='<button class="btn btn-default" value="'+value+'">'+key+'</button>';
	$('.pagitivity').append(but);
	
});
$('.pagitivity button').click( function(e){
	e.preventDefault();
    var buttonV= $(this).attr("value");
    getQNABy(buttonV);
});

function getQNABy(id){
		var getQNAByseting = {
		  "async": true,
		  "dataType":"json",
		  "type": "GET",
		  "url": "../api/question/load/"+id,
			"headers": {
			"cache-control": "no-cache"    
		}
};
$('.loadpInner .answers-section').html('');
$('.loadpInner .question-section').html('');
$.ajax(getQNAByseting).success(function (response) {
	//notify(JSON.stringify(response), 'success');
	var question_Sec='<p class="q-alert alert alert-warning">'+response.question+'</p>';
	$('.loadpInner .question-section').append(question_Sec);	
	//notify(JSON.stringify(response.answers), 'success');
	$('.loadpInner .answers-section').html('');
	$.each(response.answers, function(key, value){
	var answersssss='<p class="alert alert-warning">'+value.answer+'</p>';
	
	$('.loadpInner .answers-section').append(answersssss);
});
	
});

		}



});
	
	//$('loadpInner h3.page-header').text(activityQuestion);
	//$('loadpInner .q-alert').text(question);
	
	
}	


	