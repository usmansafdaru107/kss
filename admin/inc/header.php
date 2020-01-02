<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Panel</title>

    <!-- Bootstrap Core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	
    
    <!-- Custom CSS -->
    <link href="css/theme_x.css" rel="stylesheet">
	<link rel="stylesheet" href="../css/nprogress.css">
	<link rel="icon" href="../images/kas_logo.ico" type="image/gif" sizes="16x16"> 
	
    <!-- Fonts Awesome link-->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<!-- <link href="summernote/summernote.css" rel="stylesheet"> -->

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
		   <a href="#" class="togglesideNav">
				<i class="fa fa-bars"></i>
			</a>
			</div>
	 <div class="icon-nav">
			  <a href="index.php" class=""> </a><img src="../images/klc.png" style="height:40px; width:40px; border-radius:50%; border:2px solid #00a1e0">
			  <br>
			  
			</a>
			</div>
		
		   
		   </div>
		   
		   <ul class="nav navbar-nav navbar-right" style="margin-right:30px;">
		   <li> 
			<a href="thrive.php" class="nav-side-links">Thrive Program</a>
		   </li>
		   <li> 
			<a href="admin.php" class="nav-side-links">Contributors</a>
		   </li>
		   <li> 
			<a href="resources.php" class="nav-side-links">Resources</a>
		   </li>
		   <!-- <li> 
			<a href="tutors.php" class="nav-side-links"><i class="fa fa-pencil-square-o"> </i> Tutors</a>
		   </li> -->
		   <li> 
			<a href="#"  class="nav-side-links"></i> Messages</a>
		   </li>
		   <li> 
			<a href="#" class="nav-side-links">Help</a>
		   </li>
		   
		   <li class="dropdown"> 
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"> </i> Hello <?php if (isset($_SESSION['username'])) {
																																																																																																																																																										echo $_SESSION['username'] . " ";
																																																																																																																																																									}
																																																																																																																																																									else {
																																																																																																																																																										header("location:login.php");
																																																																																																																																																									} ?> <i class="fa fa-caret-down"> </i></a>
		   <ul class="dropdown-menu" style="background-color:#f7f7f7;">
           <!--  <li><a href="#"> <i class="fa fa-gears"> </i> Settings</a></li>-->
            <li role="separator" class="divider"></li>
            <li><a  id="logout" href="#logout"><i class="fa fa-sign-out "> </i> Logout</a></li>
          </ul>
		   </li>
		   
		     
		   
		   </ul>
		   </div>
		   
		   
		</div>
		
		
			<div class="container-fluid" style="margin-top: 50px;">
			<div class="row">
			<div class="sideNavLeft">
			
		  <div class="side-bar" role="navigation">
          
		   <br>
		  
		   
		   <ul class="nav-stacked">
		   
		   <li> 
			<a href="classes.php" id="classLinked" class="nav-side-links" ><i class="fa fa-graduation-cap"></i> <span class="sm-text-rm"> &nbsp; &nbsp; Classes</span></a>
		   </li>
		   <li> 
			<a href="subjects.php" id="subjectLinked" class="nav-side-links"><i class="fa fa-flask"> </i>  <span class="sm-text-rm"> &nbsp; &nbsp; Subjects</span></a>
		   </li>
		   
		   <li> 
			<a href="units.php" id="unitLinked" class="nav-side-links"><i class="fa fa-snowflake-o"> </i>  <span class="sm-text-rm"> &nbsp; &nbsp; Units</span></a>
		   </li>
		   
		   <li> 
			<a href="topics.php" id="topicLinked" class="nav-side-links"><i class="fa fa-tags"> </i> <span class="sm-text-rm"> &nbsp; &nbsp;  Topics</span></a>
		   </li>
		   
		   <li> 
			<a href="lessons.php" id="lessonLinked" class="nav-side-links"><i class="fa fa-leanpub"> </i>  <span class="sm-text-rm"> &nbsp; &nbsp;  Lessons</span></a>
		   </li>
   
		   </ul>
		</div>		
		</div>	