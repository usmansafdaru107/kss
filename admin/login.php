<?php
	session_start();
	if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['status']) && $_SESSION['status']==true)
	{
		header("location:index.php");
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>KAS Admin Login</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="icon" href="../images/kas_logo.ico" type="image/gif" sizes="16x16"> 
    
    <!-- Custom CSS -->
    <link href="css/theme_x.css" rel="stylesheet">

  
    <!-- Fonts Awesome link-->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body style="background-color:#f8f8f8;">
	<div class="loader">
		
		</div><!-- loader -->
  
		
		

		<div class="container">
		<div class="row" style="margin-top:5%;">
		<div class="col-md-12">
		<h2 class="text-center" style="color:#e53e30; margin:80px auto 5px auto; font-weight:bold;">Kampala Smart School</h2>
		</div>
		</div>
		<div class="row">
		<div class="col-md-4 col-sm-offset-4 col-md-offset-4">
			<div class="panel panel-primary" style="margin-top:3%;">
				<div class="panel-heading">
				<h3 class="panel-title text-center">Login</h3>
				</div>
				
				<div class="panel-body">
					<form class="loginForm" id="loginForm" role="form" method="post">
					<div class="form-group ">
						<div class="form-error alert alert-danger"></div>
						<div class="form-success alert alert-success"></div>
						
					</div>	
					<div class="form-group ">
						<label class="usernameLabel" for="username">Username</label>
						<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input name="username" id="username" class="form-control" placeholder="Username" type="text">
					</div>
					</div>
					
					<div class="form-group ">
						<label class="passwordLabel"for="password">Password</label>
						<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
						<input name="password" id="password" class="form-control" placeholder="Your Password" type="password">
					</div>
					</div>
					
					<div class="form-group">
						
						<button type="submit" name="login-btn" id="loginBtn" class="pull-rigth btn btn-primary">Login</button>
						
					</div>
					
					
					</form>
			
			
				</div>
				
				
		</div>
			</div>
		</div>
		
		<div class="row" style="margin-top:1%;">
		<div class="col-md-12">
		<a href="../" style="display:block; text-align:center;">Back to Home <i class="fa fa-home"> </i></a>
		</div>
		</div>
		</div>
		

        
                                    
    <!--Main Conetent Area -->
	
	
<script src="js/jquery/jquery.js"></script>
<?php
include('inc/footer.php');

?>
