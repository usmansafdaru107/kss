<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="We are an award winning innovative education platform that uses smart approaches to create impactful learning experiences and solutions for the young people that are growing up in the fast changing world.">
	<meta name="keywords" content="kampalasmartschool, elerning, kampala, uganda, africa, education, smart school, kas, kass, onteq, mugarura, emmanuel, digital learning, website, platform, primary education ">
	<meta name="author" content="Onteq, Nnyanzi Ian, Onen julius">
	<meta http-equiv="cache-control" content="no-cache">
	<meta name="google-site-verification" content="J04q1A2DBNBk2YQxZDLCA11e0TXo6LVLhja45wcuWCM" />

	<!-- face book seo -->
	<meta property="og:url"                content="<?php echo $_SERVER['REQUEST_URI']; ?>" />
	<meta property="og:type"               content="website" />
	<meta property="og:title"              content="Kampala Smart School" />
	<meta property="og:description"        content="We are an award winning innovative education platform that uses smart approaches to create impactful learning experiences and solutions for the young people that are growing up in the fast changing world." />
	<meta property="og:image"              content="./images/webAdd.jpg" />

    <title>Kampala Smart School</title>

      <!-- Bootstrap Core CSS -->
    <link href="admin/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
	<link href="css/theme_x.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./js/slick/slick.css"/>
  
    <!-- Fonts Awesome link-->
    <link href="admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
     <link rel="icon" href="images/kas_logo.ico" type="image/gif" sizes="16x16"> 
	 <link rel="stylesheet" href="js/jquery-ui/jquery-ui.css">
	 <link rel="stylesheet" href="css/animate.min.css">
	 <link rel="stylesheet" href="css/aos.css">

<!-- Slick -->
		<link rel="stylesheet" href="js/slick/slick.css">
	<link rel="stylesheet" href="js/slick/slick-theme.css">
	<link rel="stylesheet" href="css/nprogress.css">
</head>

<body>
<div id="errorNot" class="notification alert alert-danger">
	<i class="fa fa-close pull-right"></i>
		<p class="text-danger text-center"></p>	
	</div>	
   <div id="successNot" class="notification alert alert-success">
   <i class="fa fa-close pull-right"></i>
		<p class="text-success text-center"></p>	
		</div>
	<div id="warnNot" class="notification alert alert-warning">
	<i class="fa fa-close pull-right"></i>
		<p class="text-warning text-center"></p>	
	</div>	

        <!-- Navigation -->
        <div class="navbar navbar-default navbar-static-top customHeader" role="navigation" style="z-index:980;">
           <div class="container">
		   <div class="navbar-header">
		   
		   <div class="navbar-brand" style="">
		   
			 <a href="index.php"><img src="images/klc.png" style="height:40px; border-radius:0;"> &nbsp; Kampala Smart School</a> 
			
			
		  </div>
		  <button class='btn btn-default navbar-toggle' data-toggle='collapse' data-target='#navLinks'>
			 <i class='fa fa-bars'></i>
			 </button>
		  </div>
	
		  
		   
		   <ul id='navLinks' class="collapse navbar-collapse nav navbar-nav navbar-right" style=''>
		 <?php 
		   
		   if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['username']) && !empty($_SESSION['username'])&& isset($_SESSION['status']) && $_SESSION['status']==true) 
		   {
		   ?> 
			  
		 <?php
		 
		   }
		   else{
			   
		   
		 ?>
		    <!-- <li> 
					<a href="#classesInList" class="classesMenuItem" role="button" aria-haspopup="true" aria-expanded="false">Classes</a>
					
				</li>
				
				-->
		   
		   <?php
		   
		   
		   }
		   ?>
		   
		   <li class="programsPage"> 
			<a href="#programs" data-toggle="modal" data-target="#programsModal">Programs</a>
		   </li>
		   <li> 
			<a href="#download" data-toggle="modal" data-target="#downloadModal">Apps</a>
		   </li>
		   <li> 
			<a href="#help" data-toggle="modal" data-target="#helpModal">Help</a>
		   </li>
		   <li> 
		   <li class="" style='width:auto;'> 
		   <?php 
		   
		   if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['username']) && !empty($_SESSION['username'])&& isset($_SESSION['status']) && $_SESSION['status']==true && isset($_SESSION['account'])) 
		   {
		   ?> 
			<a href="#"  class="acc_drop acc" data-target="#" data-toggle="#"><?php echo $_SESSION['username']; ?>&nbsp; &nbsp; <i class="fa fa-caret-down"></i></a>
			
		   <?php }else {?>
		   <a href="#"  class="acc" data-target="#accountPop" data-toggle="modal">Account <i class="fa fa-caret"> </i></a>
		   
		   <?php }  ?>
		  
		   
			<div class='hiddenElement loginMenu'>
			
		<div class='container-fluid'>
<div class='caret-up'>

</div>
		 
		
				
				
				<?php
				if($_SESSION['account']=='sponsor'){
				
				?>
				<!--<ul class='top'> 
			<li><a href="account.php">Account</a></li></ul> -->
			<?php
				} 
				
					else if($_SESSION['account']=='student'){
						
						?>
						<img style="height:60px;" class="img-circle" src="images/default_image.jpg">
						<ul class='top'>
						<li class=""><a href="#"><?php echo $_SESSION['student_name']; ?>'s Profile</a></li></ul>
						<?php 
					}
			?>
			
			
			<ul class="bottom">
		<hr class"separated_list">
			
			<li><a class="logoutSponsor" href="#">Logout</a></li>
		</ul>
		</div>
		</div>
		
		
		   </li>
		   
		     </ul>
			 
			 
			
		   </div>
		   
		   
		</div>
		
		
		
		
		<!-- End of Navigation -->