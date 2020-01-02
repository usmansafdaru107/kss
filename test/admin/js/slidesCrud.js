
function getSlides(id){
	$('#ByLessonBtn').attr("value",id);
	//alert($('#ByLessonBtn').attr("value"));
	var getSlideSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/slides/lesson/"+id,
			"headers":{
				"cache-control":"no-cache"
			}
		};
	$.ajax(getSlideSettings).success(function(response){
		$('.slideList').html("");
		var responsed=JSON.stringify(response); 
		//alert(responsed);
		if(responsed.length<3 || responsed.length==="2"){
		loadPreview("../resources/slides/template.html");
			
		}else{
			
		loadPreview(response[0].url);
		}
		
		 $.each(response, function(key, value){
		 	var appendData="<tr><td class='clickPrev' data-target='"+value.url+"'>"+value.slide_name+"</td>"+
			//"<td><button class='btn btn-default' data-target='#slideContent' data-toggle='modal'><span class='fa fa-list-alt'> </span> Content</button></td>"+
			"<td><button value='"+value.slide_id+"' data-target='#slideContent' data-toggle='modal' class='indslide btn btn-default btn-xs'><span class='fa fa-edit'></span></button></td>"+
			"<td><button value='"+value.slide_id+"' class='indslideDel btn btn-default btn-xs' data-target='#deleteSlide' data-toggle='modal'><span class='fa fa-times'></span></button></td>"+
			"</tr>";
			$('.slideList').append(appendData);
		});
    $('.indslide').click( function(e){
    e.preventDefault();
    var valueX= $(this).attr("value");
    editSlide(valueX,id);
    });
	
				 $('.indslideDel').click( function(e){
    e.preventDefault();
    var delValue= $(this).attr("value");
	
    delSlide(delValue, id);
	
    });
	$('td.clickPrev').first().addClass('btn-primary');
	
					 $('.clickPrev').click( function(e){
						 if($('.clickPrev').hasClass('btn-primary')){
							 $('.clickPrev').removeClass('btn-primary');
						 }
    e.preventDefault();
    var slideValue=$(this).attr("data-target");
	$(this).addClass('btn-primary');
	
        loadPreview(slideValue);

    });
		
	});


}	
$(function(){

 $('#ByLessonBtn').click( function(e){
    e.preventDefault();
   
	
    addSlide();
	
    });
});

			function beforeSubmitAdd(){
				 var lessonId= $('#ByLessonBtn').attr("value");
			var obj={};
          $('.SlideNameLabel').text("Slide Name");
          $('.slideDescriptionLabel').text("Slide Description");
		  
    
        //default label class
           $('label').removeClass('text-danger');
                if(! minmax(3, 40, "#addNewSlideForm #SlideName", "A Real Slide name is required","#addNewSlideForm .SlideNameLabel")){
                    obj.status= false;
                 }
               
                          
				 else{
					obj.status=true;
					}
					
			var slideName=$('#SlideName').val();
          		
					
					var formx={
			"SlideName":slideName,
			"LessonName":lessonId
			
			};
			
			obj.postdata=formx;
					
					return obj;
                 
			}			
				function callBackMethod(response){
					
		$('#addNewSlideForm .form-error').hide();
		if(response.status==="error" || response.status==="Error" || response.status==="Failed" || response.status==="failed"){
			               $('#addNewSlideForm .form-error').fadeIn( function(){
                                $(this).text("Sorry "+response.message + " "+response.errors);	
				
				});
			
		}
		else{
		
		                       $('#addNewSlideForm .form-success').fadeIn( function(){
                                $(this).text("Lesson successfully Added");	
				$('#addNewSlideForm .form-success').fadeOut("slow");	
				});  
				
				$('#addNewSlideForm')[0].reset();	
				 var lessonId= $('#ByLessonBtn').attr("value");
				getSlides(lessonId);
		}
				
	}
	function addSlide(){

				
				 $("#addNewSlideForm").ajaxify({url:'../api/slides', validator:beforeSubmitAdd, onSuccess:callBackMethod});
        //Label elements in the form 

			
			}
			
			
//edit slide


 	function editSlide(slideId,lessonId){
		getAllResources();
		//alert(slideId+" "+lessonId);
	var getSlideByIdSettings = {
  "async": true,
  "dataType":"json",
  "type": "GET",
  "url": "../api/slides/"+slideId,
    "headers": {
    "cache-control": "no-cache"    
  }
};



$.ajax(getSlideByIdSettings).success(function (response) {

	
  $('#editSlideForm #SlideNameEdit').val(response[0].slide_name);
  var urlEdit=response[0].url;
	

$.get(urlEdit, function(data){
CKEDITOR.instances.editorx.setData(data);	
	
});




});
		
		
		
				function callBackMethod(response){
					
					$('#editSlideForm .form-error').hide();
		if(response.status==="error" || response.status==="Error" || response.status==="Failed" || response.status==="failed" || response.status==="fail"){
			             
				notify("Sorry "+response.message + " "+response.errors, "error");
				
			
		}
		else{
					notify("Slide successfully updated", "success");
		
				slideByLesson(lessonId);
					
				
				
				
				
		}
				
					
				
				
				
	}
				
				 $("#editSlideForm").ajaxify({url:'../api/slides/edit/'+slideId, validator:beforeSubmitEdit, onSuccess:callBackMethod});
        //Label elements in the form 
		function beforeSubmitEdit(){
			var obj={};
           $('.SlideNameLabel').text("Slide Name");
            $('.slideDescriptionLabel').text("Slide Description");
    
        //default label class
             $('label').removeClass('text-danger');
                if(! minmax(3, 40, "#editSlideForm #SlideNameEdit", "A Real Lesson name is required","#editSlideForm .SlideNameLabel")){
                     obj.status= false;
                 }
                              
				 else{
					obj.status=true;
					}
					
					var slideName=$('#SlideNameEdit').val();
					var slideContent=$('#editorx').val();
          
							var formx={
			"SlideName":slideName,
			"LessonName":lessonId,
			"editorx":slideContent
			
			};
			
			obj.postdata=formx;
					//alert(JSON.stringify(obj));
					return obj;
                 
			}
			
			}  			
       
    
 
				
 
function delSlide(slideId, lessonId){
		
		
		
		$('.delSlideBtn').click( function(){
		//alert(slideId);
		var delSlideSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/slides/delete/"+slideId,
			"headers":{
				"cache-control":"no-cache"
			}
		};
		//alert(JSON.stringify(delSlideSettings));
	$.ajax(delSlideSettings).success(function(response){
		//alert(JSON.stringify(response));
		//alert(response);
		getSlides(lessonId);				
	});
	
	});	
}

function loadPreview(url){

$('.loadpInner').html("");	
$('.loadpInner').load(url);	
	//alert(url);
	
}

function getAllResources(){
    	var getResourceSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/resource",
			"headers":{
				"cache-control":"no-cache"
			}
		};
	$.ajax(getResourceSettings).success(function(response){
		
		console.log(JSON.stringify(response));
		$('.resourceList').html("");
		 $.each(response, function(key, value){
		 			var file=value.files;
			 $.each(file, function(key2, value2){	
			var appendData="<div class='row'>"+
								"<div class='col-md-2'>"+
									"<div class='thumbnail'>"+
											"<img src='"+value2.url+"' class='img-responsive'></div>"+
									"</div>"+
								"<div class='col-md-5'>"+
									"<div class='detailsN pull-left' style='margin-right:5%;'>"+
											"<a href='#'><h4 class='resourceName text-primary'>"+value2.resource_name+"</h4></a>"+
									"</div>"+
									"</div>"+
									"<div class='col-md-5'>"+
										"<div class='pull-left btn-group btn-group-xs' style='margin-top:10px; margin-bottom:10px;'>"+
											//"<a href='"+value2.url+"' target='blank' class='btn btn-default'><span class='fa fa-cloud-download'> </span></a>"+
											//"<button value='"+value2.resource_id+"' class='delResource btn btn-default' data-target='#deleteResource' data-toggle='modal'><span class='fa fa-trash'> </span></button>"+
											"<button data-clipboard-action='copy' data-clipboard-text='"+value2.url+"' class='copyLink btn btn-default'><span class='fa fa-copy'> </span></button>"+
											//"<button value='"+value2.resource_id+"' class='indResource btn btn-default' data-target='#editResource' data-toggle='modal'><span class='fa fa-edit'> </span></button>"+
												"</div>"+
												"</div>"+
												"</div>";
			$('.resourceList').append(appendData);
		});
		});

		
		
	   $('.copyLink').click( function(e){
    //e.preventDefault();
    //var valueD= $(this).attr("data-target");
    //copyResourceLink(valueD);
    //console.log(valueD);
    });

	
	});
    
    
}	
	
	


	