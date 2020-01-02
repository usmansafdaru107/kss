function addUnit(){
    //get all tutors and put them in the select drop down menu

	 
            //add Unit Form
    //add Unit Form
    //add Unit Form
    //add Unit Form
  
     imageValid('#addNewUnitForm #unitLogo', "Sorry you have selected unsupported file format We only Suppot PNG JPEG and JPG please Change it", ".unitLogoLabel");
  		 $("#addNewUnitForm").ajaxify({url:'../api/units', validator:beforeSubmit, onSuccess:callBackMethod});    
	function callBackMethod(response){
		                       $('#addNewUnitForm .form-success').fadeIn( function(){
                                $(this).text("Theme/ Unit successfully Added");	
				$('#addNewUnitForm .form-success').fadeOut("slow");	
				});                                    
		
				
						
				//getAllUnits();
				$('#addNewUnitForm')[0].reset();
				
				getAllUnits();
	}
	      
    
			
			function beforeSubmit(){
				var obj={};
        //Label elements in the form 
            $('.UnitNameLabel').text("Unit/ Thme Name");
            $('.tutorLabel').text("Tutor");
            $('.termNameLabel').text("Term");
            $('.unitLogoLabel').text("Unit/ Theme Image");
             $('.unitDetailsLabel').text("Unit Details");
        //default label class
             $('label').removeClass('text-danger');
                if(! minmax(3, 100, "#addNewUnitForm #UnitName", "A Real Unit/ Theme  name is required","#addNewUnitForm .UnitNameLabel")){
                    obj.status= false;
                 }
                 else if(! selectValid("#addNewUnitForm #tutor", "Please select a Tutor", ".tutorLabel")){
                     
                     obj.status= false;
                 }
                 
                 else if(! selectValid("#addNewUnitForm #termName", "Please select a Term", ".termNameLabel")){
                     
                     obj.status= false;
                 }
                 
                 else if(! minmax(3, 200, "#addNewUnitForm #unitDetails", "Unit details are required","#addNewUnitForm .unitDetailsLabel")){
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
function unitPaginator(){
	var getUnitsSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/units/"+subjectId,
			"headers":{
				"cache-control":"no-cache"
			}
		};
}
function getAllUnits(isAdmin, subjectId, term){
    
if(subjectId>0 && term===0){
    
 	var getUnitsSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/units/subject/"+subjectId,
			"headers":{
				"cache-control":"no-cache"
			}
		};
                
                $.ajax(getUnitsSettings).success(function(response){
		$('.unitList').html("");
		
		
		 $.each(response, function(key, value){
		 	var termNameHead="<br><br><br style='clear:both;'><h5 class='page-header'>"+value.name+"</h5>";
			$('.unitList').append(termNameHead);
				var theme=value.themes;
				$.each(theme, function(key, themex){
					var unitsBoxList="<div class='col-md-3 unitBox'>"+
									"<div class='thumbs'>"+
											"<img src='"+themex.logo+"' style='width:100%;' class=''></div>"+
									"<div class='details'>"+
											"<h5 class='text-primary'>"+themex.theme_name+"</h5>"+
															"<div class='btn-group btn-group-xs'>"+
											"<button class='btn btn-primary indUnit' data-target='#editUnit' value='"+themex.theme_id+"' data-toggle='modal'>"+
													"<span class='fa fa-edit'></span> Edit"+
											"</button>"+
											"<button value='"+themex.theme_id+"' class='indUnitDel btn btn-warning' data-target='#deleteUnit' data-toggle='modal'>"+
													"<span class='fa fa-trash'></span> Delete"+
											"</button>"+
											"</div></div>"+
							"</div>";
			$('.unitList').append(unitsBoxList);
			
				if(isAdmin==0){
			
				 $('.unitBox button').hide();
                                  $('.filter').hide();
				 $('.unitBox .details h5').addClass('text-center').addClass('offAdmin');
			 }
			});
			
			//$('.unitList').append("</div>");
		});
		
    $('.indUnit').click( function(e){
    e.preventDefault();
	var valueX= $(this).attr("value");
    console.log(valueX);
      editUnit(valueX);
    });
	
			 $('.indUnitDel').click( function(e){
    e.preventDefault();
    var delValueX= $(this).attr("value");
	
    delUnit(delValueX);
	
    });
               
	});
    
}
else if(term>0){
    
   var getUnitsByTermSettings = {
	  "async": true,
	  "dataType":"json",
	  "type": "GET",
	  "url":"../api/units/subject/"+subjectId+"?term="+term,
		"headers": {
		"cache-control": "no-cache"    
	  }
	};


$.ajax(getUnitsByTermSettings).success(function(responsed){
    
		$('.unitList').html("");
		 
		 var termNameHead="<br><br><br style='clear:both;'><h5 class='page-header'>"+responsed.name+"</h5>";
		$('.unitList').append(termNameHead);
				var theme=responsed.themes;
                                
				$.each(theme, function(key, themex){
					var unitsBoxList="<div class='col-md-3 unitBox'>"+
									"<div class='thumbs'>"+
											"<img src='"+themex.logo+"' style='width:100%;' class=''></div>"+
									"<div class='details'>"+
											"<h5 class='text-primary'>"+themex.theme_name+"</h5>"+
															"<div class='btn-group btn-group-xs'>"+
											"<button class='btn btn-primary indUnit' data-target='#editUnit' value='"+themex.theme_id+"' data-toggle='modal'>"+
													"<span class='fa fa-edit'></span> Edit"+
											"</button>"+
											"<button value='"+themex.theme_id+"' class='indUnitDel btn btn-warning' data-target='#deleteUnit' data-toggle='modal'>"+
													"<span class='fa fa-trash'></span> Delete"+
											"</button>"+
											"</div></div>"+
							"</div>";
			$('.unitList').append(unitsBoxList);
			
				if(isAdmin===0){
			
				 $('.unitBox button').hide();
                                  $('.filter').hide();
				 $('.unitBox .details h5').addClass('text-center').addClass('offAdmin');
			 }
			});
			
			
		
                
		
    $('.indUnit').click( function(e){
    e.preventDefault();
	var valueX= $(this).attr("value");
    console.log(valueX);
      editUnit(valueX);
    });
	
			 $('.indUnitDel').click( function(e){
    e.preventDefault();
    var delValueX= $(this).attr("value");
	
    delUnit(delValueX);
	
    });
               
	}); 
    
}
else{
    
   
	var getUnitsSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/units",
			"headers":{
				"cache-control":"no-cache"
			}
		};
                
    
	$.ajax(getUnitsSettings).success(function(response){
		$('.unitList').html("");
		
		
		 $.each(response, function(key, value){
		 	var termNameHead="<br><br><br style='clear:both;'><h5 class='page-header'>"+value.name+"</h5>";
			$('.unitList').append(termNameHead);
				var theme=value.themes;
				$.each(theme, function(key, themex){
					var unitsBoxList="<div class='col-md-3 unitBox'>"+
									"<div class='thumbs'>"+
											"<img src='"+themex.logo+"' style='width:100%;' class=''></div>"+
									"<div class='details'>"+
											"<h5 class='text-primary'>"+themex.theme_name+"</h5>"+
															"<div class='btn-group btn-group-xs'>"+
											"<button class='btn btn-primary indUnit' data-target='#editUnit' value='"+themex.theme_id+"' data-toggle='modal'>"+
													"<span class='fa fa-edit'></span> Edit"+
											"</button>"+
											"<button value='"+themex.theme_id+"' class='indUnitDel btn btn-warning' data-target='#deleteUnit' data-toggle='modal'>"+
													"<span class='fa fa-trash'></span> Delete"+
											"</button>"+
											"</div></div>"+
							"</div>";
			$('.unitList').append(unitsBoxList);
			
				if(isAdmin==0){
			
				 $('.unitBox button').hide();
                                  $('.filter').hide();
				 $('.unitBox .details h5').addClass('text-center').addClass('offAdmin');
			 }
			});
			
			//$('.unitList').append("</div>");
		});
		
    $('.indUnit').click( function(e){
    e.preventDefault();
	var valueX= $(this).attr("value");
    console.log(valueX);
      editUnit(valueX);
    });
	
			 $('.indUnitDel').click( function(e){
    e.preventDefault();
    var delValueX= $(this).attr("value");
	
    delUnit(delValueX);
	
    });
               
	});
        
}
    
}

$( function(){
	//getAllUnits();
});
function editUnit(id){
	var editUnitByIdSettings="";
	
      editUnitByIdSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/units/"+id,
			"headers":{
				"cache-control":"no-cache"
			}
		};
                
     
                           
    
    //get all tutors and put them in the select drop down menu
	$("#editUnit #editUnitForm .img-avail").show();
	$("#editUnit #editUnitForm .img-upload").hide();
	$("#editUnit #editUnitForm .removeImg").show();
	$("#editUnit #editUnitForm .cancelRemoveImg").hide();
$("#editUnit #editUnitForm .img-upload").hide();
$("#editUnit #editUnitForm .cancelRemoveImg").hide();
$("#editUnit #editUnitForm .img-upload #classLogoEdit").val("");
$('#editUnit #editUnitForm .removeImg').click( function(){
	$("#editUnit #editUnitForm .img-avail").hide();
	$("#editUnit #editUnitForm .img-upload").slideDown();
	$("#editUnit #editUnitForm .removeImg").hide();
	$("#editUnit #editUnitForm .cancelRemoveImg").fadeIn();
	$("#editUnit #editUnitForm .cancelRemoveImg").click( function(){
		$("#editUnit #editUnitForm .img-avail").fadeIn();
	$("#editUnit #editUnitForm .img-upload").hide();
	$("#editUnit #editUnitForm .img-upload #unitLogoEdit").val("");
	$("#editUnit #editUnitForm .removeImg").fadeIn();
	$("#editUnit #editUnitForm .cancelRemoveImg").hide();
	});

});	
                
              
	$.ajax(editUnitByIdSettings).done(function(response){
		$('#editUnitForm .tutorList').html("");
		$('#editUnitForm .termList').html("");
		 $.each(response, function(key, value){
                 var tutorData="<option selected class='sTutor' value="+value.tutor+">"+value.f_name+" "+value.l_name+"</option>";
                  var termData="<option selected value="+value.term_id+">"+value.term_name+"</option>"+
				  
				  "<option value='1'>Term One</option>"+
				  "<option value='2'>Term Two</option>"+
				  "<option value='3'>Term Three</option>";
				  
			
			
			
		$('#editUnitForm #UnitName').val(value.theme_name);
		         $('#editUnitForm .tutorList').prepend(tutorData);
                $('#editUnitForm .termList').prepend(termData);
                $('#editUnitForm #unitDetails').val(value.details);
				$('#editUnitForm .pic').attr("src",value.logo);
		
		
		});
		

                
       });         
            //add Unit Form
    //add Unit Form
    //add Unit Form
    //add Unit Form
	
	  	
		  $("#editUnitForm").ajaxify({url:'../api/units/edit/'+id, validator:beforeSubmitEdit, onSuccess:callBackMethodEdit});     
	function callBackMethodEdit(response){
		                    console.log("Hey i m from Here "+JSON.stringify(response));
                    
                    
                     $('#editUnitForm .form-success').fadeIn( function(){
                    $(this).text("Theme/ Unit successfully Edited");	
                    $('#editUnitForm .form-success').fadeOut("slow");	
					
					
					 $('#content-area').html("");
					$('#content-area').load("units.php");
                    });  
					$(".modal-backdrop").fadeOut();	
				$(".modal").modal("hide");	
					
				}                                   
		
				
						
				
				
	
   
 
        
            
			function beforeSubmitEdit(){
				var obj={};
        //Label elements in the form 
            $('.UnitNameLabel').text("Unit/ Thme Name");
            $('.tutorLabel').text("Tutor");
            $('.termNameLabel').text("Term");
            $('.unitLogoLabel').text("Unit/ Theme Image");
             $('.unitDetailsLabel').text("Unit Details");
        //default label class
             $('label').removeClass('text-danger');
                if(! minmax(3, 100, "#editUnitForm #UnitName", "A Real Unit/ Theme  name is required","#editUnitForm .UnitNameLabel")){
                    obj.status= false;
                 }
                 else if(! selectValid("#editUnitForm #tutor", "Please select a Tutor", "#editUnitForm .tutorLabel")){
                     
                     obj.status= false;
                 }
                 
                 else if(! selectValid("#editUnitForm #termName", "Please select a Term", "#editUnitForm .termNameLabel")){
                     
                     obj.status= false;
                 }
                 
                 else if(! minmax(3, 200, "#editUnitForm #unitDetails", "Unit details are required","#editUnitForm .unitDetailsLabel")){
                    obj.status= false;
                 }
                 else{
					obj.status=true;
					}
					var formx={};
			
			obj.postdata=formx;
					
					return obj;
      
                        
                       
				
                		
						

	$("#editUnit").modal("hide");	
    }
		      
       
	

}


//delete unit


	function delUnit(id){
		
		
		console.log(id);
		$('#deleteUnit .delBtn').click( function(){
		
		var delSubjectSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"../api/units/delete/"+id,
			"headers":{
				"cache-control":"no-cache"
			}
		};
	$.ajax(delSubjectSettings).success(function(response){
		getAllUnits();	
				
				
				
	});
	
	});	
}






