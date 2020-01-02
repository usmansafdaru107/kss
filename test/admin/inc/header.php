<?php
session_start();
	if(!isset($_SESSION['user']) || empty($_SESSION['user']) || !isset($_SESSION['username']) || empty($_SESSION['username']) || !isset($_SESSION['status']) || empty($_SESSION['status']) || isset($_SESSION['status']) && $_SESSION['status']==false)
	{
		header("location:login.php?notification=Please Login to Continue");
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

    <title>KASS Admin Panel</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="css/theme_x.css" rel="stylesheet">
  
    <!-- Fonts Awesome link-->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


	
	
</head>

<body>

		
	<div id="errorNot" class="notification alert alert-danger">
		<p class="text-danger text-center"></p>	
	</div>	
   <div id="successNot" class="notification alert alert-success">
		<p class="text-success text-center"></p>	
		</div>
	<div id="warnNot" class="notification alert alert-warning">
		<p class="text-warning text-center"></p>	
		</div>	

        <!-- Navigation -->
        <div class="navbar navbar-default navbar-fixed-top topNav" role="navigation" style="z-index:980;">
           <div class="container-fluid">
		   <div class="navbar-header">
		   <div class="navbar-brand">
		   <a href="#" class="togglesideNav btn btn-default btn-xs">
				<i class="fa fa-bars"></i>
			</a>
			</div>
		<a href="index.php" class="navbar-brand">Kass Admin Panel</a>
		   
		   </div>
		   
		   <ul class="nav navbar-nav navbar-right">
		   <li> 
			<a href="admin.php" class="nav-side-links"><i class="fa fa-pencil"> </i> Contributors</a>
		   </li>
		   <li> 
			<a href="resources.php" class="nav-side-links"><i class="fa fa-file"> </i> Resources</a>
		   </li>
		   <!-- <li> 
			<a href="tutors.php" class="nav-side-links"><i class="fa fa-pencil-square-o"> </i> Tutors</a>
		   </li> -->
		   <li> 
			<a href="#"  class="nav-side-links"><i class="fa fa-envelope"> </i> Messages</a>
		   </li>
		   <li> 
			<a href="#" class="nav-side-links"><i class="fa fa-wrench"> </i> Help</a>
		   </li>
		   
		   <li class="dropdown"> 
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"> </i> Hello <?php if(isset($_SESSION['username'])){echo $_SESSION['username']." "; } else{ header("location:login.php");}?> <i class="fa fa-caret-down"> </i></a>
		   <ul class="dropdown-menu">
            <li><a href="#"> <i class="fa fa-gears"> </i> Settings</a></li>
            <li role="separator" class="divider"></li>
            <li><a  id="logout" href="#logout"><i class="fa fa-sign-out "> </i> Logout</a></li>
          </ul>
		   </li>
		   
		     
		   
		   </ul>
		   </div>
		   
		   
		</div>
		
		<br><br><br>
			<div class="container-fluid">
			<div class="row">
			<div class="sideNavLeft col-md-2 col-sm-2">
			
		  <div class="navbar navbar-default navbar-static-top side-bar" role="navigation" style="">
          
		   
		   
		   <ul class="nav nav-stacked">
		   
		   <li> 
			<a href="classes.php" class="nav-side-links" ><i class="fa fa-th-large"> </i> Classes</a>
		   </li>
		  <!--  Term is removed
		  <li> 
			<a href="terms.php"><i class="fa fa-signal"> </i> Terms</a>
		   </li>
		   -->
		   <li> 
			<a href="subjects.php" class="nav-side-links"><i class="fa fa-folder"> </i> Subject</a>
		   </li>
		   
		   <li> 
			<a href="units.php" class="nav-side-links"><i class="fa fa-columns"> </i> Themes / Units</a>
		   </li>
		   
		   <li> 
			<a href="topics.php" class="nav-side-links"><i class="fa fa-database"> </i> Topics</a>
		   </li>
		   
		   <li> 
			<a href="lessons.php" class="nav-side-links"><i class="fa fa-file"> </i> Lessons</a>
		   </li>
		   
		   </ul>
		   
		   
		   
		</div>		
		</div>		
		<!-- End of Navigation -->