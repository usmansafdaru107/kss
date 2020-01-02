<?php  include('inc/header.php'); ?>
<?php 
if ( isset($_GET['code'])){
	$code=$_GET['code'];
	$disabled="disabled";
	}
	else{
	$code="";
	$disabled="";
	}
?>	
<div class="box-bg" style="background-color:#f7f7f7;">
		<div class="container">
		
		<div class="row" style="height:70vh; margin-top:8%;">
		<div class="col-md-4 col-sm-offset-4 col-md-offset-4">
		<a href="recoverAccount.php" style="display:block; text-align:center;">Resend reset instruction to my email again</a>
			<div class="panel panel-primary" style="margin-top:3%;">
				<div class="panel-heading">
				<h3 class="panel-title text-center">Change your password</h3>
				</div>
				
				<div class="panel-body">
				
					<form class="chPass" id="chPass" role="form" method="post">
					<?php 
if ( ! isset($_GET['code'])){
?>
                                            <p class="text-center">Please type verification code.</p>
                                            <hr>
											<div class="form-group">
						<input type="text" name="verification_code"  class="verification_code form-control" placeholder="Verification code">
					</div>
					
					<p class="text-center">AND</p>
					<?php }?>
					<p class="text-center">Enter your new password below to complete the process.</p>
					<hr>
					<div class="form-group">
						<input type="password" name="password1" class="password1 form-control" placeholder="Password">
					</div>
                                        <div class="form-group">
						<input type="password" name="password2" class="password2 form-control" placeholder="Retype password">
					</div>
                    <div class="form-group">
						
						<button style="width: 100%;" type="submit" name="login-btn" id="loginBtn" class="pull-rigth btn btn-primary">Save changes & login</button>
						
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
	
	$('#chPass').submit( function(e){
		e.preventDefault();
		//var formData =$(this).serialize();
		var verv="";
							<?php 
								if ( ! isset($_GET['code'])){
							?>
							var ver=$('#chPass .verification_code');
                                verv=$('#chPass .verification_code').val();
								if(! minMax_a(4, 20, ver, "Please enter your verification code below")){
                                    return false;
								}
								
							<?php
								}
								else{
							?>
							verv='<?php echo $code; ?>';
							<?php
								}
								
							?>
							
		
		
				var pass1=$('#chPass .password1');
                                var pass1v=$('#chPass .password1').val();
			        var pass2=$('#chPass .password2');
                                var pass2v=$('#chPass .password2').val();
				//validating class
				if(! minMax_a(4, 20, pass1, "Please enter your password below")){
                                    return false;
				}	
				else if(! minMax_a(4, 20, pass2, "Please Confirm your password below")){
                   
				   return false;
				}
                                else if(pass1v!=pass2v){
                                    notify("Passwords did not match please retype it","error");
                                    //pass1.val("");
                                    pass2.val("");
                                    return false;
                                }
				
                                var sendData={
                                        "code":verv,
                                        "account_type":"sponsor",
                                        "pass1":pass1v,
                                        "pass2":pass2v
                                       }
				var chPassSettings={
						"type":"POST",
						"dataType":"json",
						"url":'api/settings/password/reset/complete',
						"headers":{
							"cache-control":"no-cache"
						},
						"data":sendData
				};
                                
                                
				
				$.ajax(chPassSettings).success(function(responseSub){
		console.log(JSON.stringify(responseSub));
			if(responseSub.status=="failed" || responseSub.status=="warning"){
				notify("Sorry "+responseSub.message,"error");
			}
		else if(responseSub.status=="success" || responseSub.status=="success"){
		notify("Hey your account password has been changed", "success");
					window.location="index.php?action=login";
		}
                else{
                    notify("Sorry "+responseSub.message,"error");
                }
				
	}); 
	
});
});
</script>
