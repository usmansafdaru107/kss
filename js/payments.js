
$( function(){
	//list payment history
	listAllPayments();
	
	
//view students of a single payment	


//print history
$('.printPage').click( function(){
	window.print();
});



});

//list payment history
function listAllPayments(){
		var listAllPaymentsSettings={
			"type":"GET",
			"async": true,
			"dataType":"json",
			"url":"api/payments/yo",
			"headers":{
				"cache-control":"no-cache"
			}
		};
	
	
	$.ajax(listAllPaymentsSettings).success(function(response){
		
		if(response.status=='failed' || status=='failed'){
			
			$('.notPaymentsadded').html("");
	
			$('.subscriptionLogList').html("");
			var appendLog='<p class="alert alert-warning">You have not made any payments lately</p>';
			$('.notPaymentsadded').html(appendNotStu);
		}
		else{
			console.log(JSON.stringify(response.data));
		$('.notPaymentsadded').html("");
		$('.subscriptionLogList').html("");
		console.log(JSON.stringify(response.data));
		var paymentDataTable="";
		$.each(response.data, function(key, value){
			if(value.status==1){
				var greenBar="transactionSuccess";
				var statusBack="Successful";
				var verifyB="hiddenElement";
			}
			else if(value.status==0){
				var greenBar="transactionPending";
				var statusBack="Pending";
				var verifyB="";
			}
			else if(value.status==-1){
				var greenBar="transactionBounced";
				var statusBack="Failed";
				var verifyB="hiddenElement";
			}
		
			paymentDataTable+='<tr class="'+greenBar+'"><td>'+value.date_paid+'</td>'+
					'<td>'+statusBack+'</td>'+
					'<td>'+value.yo_ref+'</td>'+
					'<td>+'+value.phone_no+'</td>'+
					'<td><button data-id="'+value.yo_ref+'" class="viewSingle btn btn-xs btn-default">View</button></td>'+
					'<td><button data-id="'+value.yo_ref+'" class="'+verifyB+' iHavePayedBtn btn btn-xs btn-success">Confirm</button></td></tr>';
					
					
					});
					$('.subscriptionLogList').html(paymentDataTable);
					$('.viewSingle').click( function(e){
						e.preventDefault();
						var refNo=$(this).attr("data-id");
						viewRefStudents(refNo);
					});
					var refNo="";
					$('.iHavePayedBtn').click( function(e){
					
					refNo=$(this).attr('data-id');
						e.preventDefault();
						var ihavePayedSettings={
						"type":"GET",
						"async":false,
						"dataType":"json",
						"url":'api/payments/verify/'+refNo,
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
			
					
					listAllPayments();
								
					
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
					
		}
	});

}

//view students of a single payment	
function viewRefStudents(refNo){
	
	$('.studentListE').html("");
	
	var viewRefStudentsSettings={
			"type":"GET",
			"async": false,
			"dataType":"json",
			"url":"api/payments/yo/reciept/"+refNo,
			"headers":{
				"cache-control":"no-cache"
			}
		};
	
	
	$.ajax(viewRefStudentsSettings).success(function(response){
		$('#listStudenSubtModal').modal('show');
		
		$('#listStudenSubtModal .charged').html("");
		$('#listStudenSubtModal .datePayed').html("");
		$('#listStudenSubtModal .NoStudent').html("");
					
		console.log(JSON.stringify(response));
		
		$.each(response.data, function(key, value){
			var studentChips='<a href="#" class="btn btn-xs btn-default">'+value.subscription_count+'</a>';
			$('.studentListE').html(studentChips);
			
			
					
					$('#listStudenSubtModal .charged').html("ReciptNo #"+value.yo_ref);
					$('#listStudenSubtModal .datePayed').html("Charge: "+value.amount+" UGX");
					$('#listStudenSubtModal .NoStudent').html("Number of Students: "+value.subscription_count);
					
					
					var RefStudentsSettings={
						"type":"GET",
						"async": true,
						"dataType":"json",
						"url":"api/payments/students/reciept/"+refNo,
						"headers":{
							"cache-control":"no-cache"
					}
					};
					
					$.ajax(RefStudentsSettings).success(function(responsefg){
						console.log(JSON.stringify(responsefg));
						
						if(responsefg.status=="failed"){
							notify(responsefg.message,'warning')
						}
						else if(responsefg.status=="success"){
						
						$('.StudentListRec').html('');
						var studentListIn="";
							$.each(responsefg.data, function(key, value){
							
								studentListIn+='<p class="">'+value.class_name+':::::::::: '+value.f_name+' '+value.l_name+'</p>';
								
							});
							
							$('.StudentListRec').html(studentListIn);
							
						}
					});
					
					
			
					
		});
	});

}












