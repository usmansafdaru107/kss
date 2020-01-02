<?php  include('inc/header.php'); ?>

  
		
		
<div class="box-bg" style="background-color:#f7f7f7;">
		<div class="container">
		
		<div class="row" style="height:70vh; margin-top:8%;">
		<div class="col-md-4 col-sm-offset-4 col-md-offset-4">
			<div class="panel panel-primary" style="margin-top:3%;">
				<div class="panel-heading">
				<h3 class="panel-title text-center">Reset your password</h3>
				</div>
				
				<div class="panel-body">
					<form class="reqPass" id="reqPass" role="form" method="post">
					<p>Enter your email address to reset your password. You may need to check your spam folder.</p>
					<hr>
					<div class="form-group">
						<select name="account_type" class="account_type form-control">
							<option value="2">Parent/ School</option> 
							
						</select>
					</div>
					<div class="form-group">
						<input type="text" name="email" class="email form-control" placeholder="Username Or Email">
					</div>
                    <div class="form-group">
						
						<button style="width: 100%;" type="submit" name="login-btn" id="loginBtn" class="pull-rigth btn btn-primary">Request Change of password Link</button>
						
					</div>
				</div>
					
					
					
					
					</form>
			
			
				</div>
				
				
		</div>
		<div class="col-sm-12 col-md-12">
			<a href="index.php" style="display:block; text-align:center;">Back to Home <i class="fa fa-home"> </i></a>
		</div>
		
			</div>
		
		

       
		
		
		
		</div>
		</div>
      
		

<?php  include('inc/footer.php'); ?>

<script>
$( function(){
	
	$('#reqPass').submit( function(e){
		e.preventDefault();
		//var formData =$(this).serialize();
		var accType=$('#reqPass .account_type').val();
		var emailv=$('#reqPass .email').val();
		
		
		
		
		
				
			          
				//validating class
				if(! selectValid_new("#reqPass .account_type", "Please an accoun type")){
                    return false;
				}	
				else if(! minMax_a(4, 20, "#reqPass .email", "Please Enter a username or email")){
                   
				   return false;
				}
				
				var formData={
					"email":emailv,
					"account_type":"sponsor"
				};
				
				var reqPassSettings={
						"type":"POST",
						"dataType":"json",
						"url":'api/settings/password/reset/request',
						"headers":{
							"cache-control":"no-cache"
						},
						"data":formData
				};
				
				$.ajax(reqPassSettings).success(function(responseSub){
		console.log(JSON.stringify(responseSub));
			if(responseSub.status=="failed" || responseSub.status=="warning"){
				notify("Sorry "+responseSub.message,"error");
				
			}
		else{
		notify("Please check your email "+emailv+" to recieve further instructions  on how to change your account password","success");
		}
				
	});
	
});
});
</script>
