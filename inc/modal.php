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
<!-- Class Preview -->
<div class="modal fade" id="classPreview" role="dialog">
<div class="modal-dialog" style="width:87%;">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="pull-left">Overview</h4>
			<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body">
			<div class="row topbar">
				<div class="col-md-12 col-sm-12">
					<div class="img"></div>
					<div class="pull-left innerBox">
					<h3>Class name</h3>
					<p>Enrolled</p>
					
					</div>
					<button data-toggle="modal" data-target="#accountPop" class="pull-right btn btn-custom-primary">Go to Class</button>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-12 col-sm-12">
				

				<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#home"><i class="fa fa-sun-o"> </i> Outcomes</a></li>
				<li><a data-toggle="tab" href="#menu1"><i class="fa fa-suitcase"> </i> Syllabus</a></li>
				<li><a data-toggle="tab" href="#menu2"><i class="fa fa-bar-chart-o"> </i> Grading</a></li>
			  </ul>
			  
			  <div class="tab-content">
				<div id="home" class="tab-pane fade in active">
				<h3 class="page-header">Outcomes</h3>
				  <p class="outc">Some content.</p>
				</div>
				<div id="menu1" class="tab-pane fade">
				<h3 class="page-header">Syllabus</h3>
				<p>Select on one of the subject to access more content of the Syllabus</p>
				  <div class="subjectsList"></div>
				</div>
				<div id="menu2" class="tab-pane fade">
				  <h3 class="page-header">Grading</h3>
				  <p>Grading is not yet available for this subject.</p>
				</div>
			  </div>


				</div>
			</div>
		</div>
		<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	</div>
</div>
</div>
<!-- send message modal -->
<div class="modal fade" id="sendMessageModal" role="dialog">

<div class="modal-dialog" style="">
	<div class="modal-content">
		<div class="modal-header">
			<h3 class="pull-left">Send us a message</h3>

			<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body">
			<button class="btn btn-primary"><i class="fa fa-phone"></i> +256 776 182 222</button>
			<button class="btn btn-primary"><i class="fa fa-envelope"></i> kampalasmartschool@gmail.com</button>
			<br class="clear-both">
			<br class="clear-both">
			<form class="sendMessageForm" method="post" action="sendMail.php">
				<div class="form-group">
					<input type="text" name="fname" placeholder="Name" class="form-control" required>
					<input type="email" name="email" placeholder="Email" class="form-control" required>
				</div>
				<div class="form-group">
					<input type="text" name="phone" placeholder="Phone number (optional)" class="form-control">
				</div>

				<div class="form-group">
					<textarea class="form-control" name="msg" placeholder="Your message" required></textarea>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Send</button>
				</div>

			</form>
		</div>
	</div>
</div>
</div>

<!-- Login and Sign up page <div class="" id="accountPop" role="dialog">-->
<div class="modal fade" id="accountPop" role="dialog" style="padding-right: 0px !important">

<div class="modal-dialog modal-dialog-scrollable" style="width:70%; max-height: 100%">
	<div class="modal-content">
		<div class="modal-header">
			<div class="pull-left" style="width:100%;">
				<h3 class="text-left" style="">Account</h3>
			</div>

			<div class="pull-left">
				<a data-target="#helpModal" data-toggle="modal" href="#help">I need help
					<i class="fa fa-question"> </i>
				</a>

			</div>
			<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body" style="width: 100%">

			<div class="row">
				<div class="col-md-3">

				</div>
				<div class="col-md-8 loginPanel">

					<form class="login_sponsor">
						<h4>Login</h4>
						<hr>
						<div class="form-group">
							<select class="loginType form-control">
								<option value="0">Login as:</option>
								<option value="1">Student</option>
								<option value="2">Parent/ School</option>

							</select>
						</div>
						<div class="form-group">
							<input type="text" name="username" class="username form-control" placeholder="Username Or Email">
						</div>
						<div class="form-group">
							<input type="password" name="password" class="password form-control" placeholder="Password">
						</div>

						<div class="form-group">
							<a class='text-danger' href='recoverAccount.php'>Did you forget your password?</a>
						</div>

						<div class="form-group">
							<button type="submit" class='btn btn-custom-danger'>Login</button>
						</div>
												
						<h5>You Don't have an Account ?</h5>
						<p>Please Register with us here or try our demo as a student</p>
						<hr>
					</form>
					<div class="form-group">
						<button class='tryDemo btn btn-default'>Try Our Demo</button>
						<button class='goToRegister btn btn-custom-primary'>Register</button>
					</div>
				</div>

				<div class="col-md-3">

				</div>
			</div>


			<div class="row">
				<div class="col-md-2">

				</div>
				<div class="col-md-8 hiddenElement registerPanel" style="">

					<form class="registerParent" id="registerParent">
						<h4>Register</h4>
						<!-- <hr> -->
						<div class="form-group">
							<select name="type" class="type form-control">
								<option value="x">Please Select Sponsor Type</option>
								<option value="0">Parent</option>
								<option value="1">School</option>

							</select>
						</div>

						<div class="form-group">
							<input type="text" name="sponsor_name" class="f_name form-control" placeholder="Full Names">
						</div>


						<div class="form-group">
							<input type="text" name="country" class="country form-control" placeholder="Country">
						</div>

						<div class="row">
							<div class="col-md-6 form-group">
								<input type="email" name="email" class="email form-control" placeholder="Email">
							</div>
							<div class="col-md-6 form-group">
								<input type="text" name="phone" class="phone form-control" placeholder="Phone Number">
							</div>
						</div>
						<div class="form-group">
							<input type="file" id="" name="profile_pic" class="profile_pic form-control">
						</div>
						<div class="row">
							<div class="col-md-6 form-group">
								<input type="password" name="password1" class="password1 form-control" placeholder="Password">
							</div>
							<div class="col-md-6 form-group">
								<input type="password" name="password2" class="password form-control" placeholder="Confirm Password">
							</div>
						</div>
						<p>By registering, providing personal information and use of Kampala Smart School signifies acceptance
							of our
							<u>
								<a href="terms_of_use.php">Terms of Use</a>
							</u> and
							<u>
								<a href="privacy_policy.php">Privacy Policy</a>
							</u>.
						</p>
						<div class="form-group">
							<button class='btn btn-custom-primary'>Register</button>
						</div>

					</form>
					<br>
					<!-- <br>
					<br> -->
					<h5>You already have an Account ?</h5>
					<hr>
					<div class="form-group">
						<p>Please Login here</p>
						<button class='goTologin btn btn-custom-danger'>Login</button>
					</div>
				</div>
				<div class="col-md-3">

				</div>

			</div>
		</div>

	</div>

</div>

</div>


<!-- help Modal -->
<div class="modal fade" id="helpModal" role="dialog">

<div class="modal-dialog" style="width:87%;">
	<div class="modal-content">
		<div class="modal-header">
			<h3 class="pull-left text-center">How Kampala Smart School works</h3>

			<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<h4> Learning with Kampala Smart School</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<p>
						Discover how Kampala Smart School works — we use an innovative approach to teach children how to learn in a personal way,
						so they build their confidence and get inspired to do great things!
						<br>To join our community, follow the simple steps below.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<h4>STEP I:</h4>
					<p>Click account.</p>
					<img src="images/help/1.png" class="img-rounded img-responsive">
					<br>
					<p>Register as a parent/school.</p>

					<br>

				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<h4>STEP II:</h4>
					<p>Log in as a parent/school.</p>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 col-sm-12">
					<h4>STEP III:</h4>
					<p>Click add student button and enter the child’s details. Create a username and a new password for
						the child.</p>
				</div>
			</div>


			<div class="row">
				<div class="col-md-12 col-sm-12">
					<h4>STEP IV:</h4>
					<p>Check the box next to the child’s name and enroll the child in their right class.
				</div>
			</div>


			<div class="row">
				<div class="col-md-12 col-sm-12">
					<h4>STEP V:</h4>
					<p>Log out, then log in as a student and follow the steps to access sample lessons in each of the subjects.
						The first four lessons are free.</p>
				</div>
			</div>


			<div class="row">
				<div class="col-md-12 col-sm-12">
					<h4>STEP VI:</h4>
					<p>To subscribe, login as a parent, click the child’s class, check the box next to the child’s name
						and click the subscribe button to make payment.</p>
				</div>
			</div>


			<div class="row">
				<div class="col-md-12 col-sm-12">
					<h4>STEP VII:</h4>
					<p>Enter your Airtel Mobile money number in the field and click initiate payment button. The subscription
						fee is 60,000/= per child per year. Our system currently accepts Airtel Money.</p>
				</div>
			</div>



			<div class="row">
				<div class="col-md-12 col-sm-12">

					<p>After a successful subscription, your child can login to access all the lessons and assessment activities
						in their class, connect with expert tutors and take part in the discussion forum with fellow
						children. You will be able to track the progress your child is making too.

						<br>
						<br> Enjoy!
					</p>
				</div>
			</div>


		</div>
	</div>
</div>
</div <!-- Confirm Subscription Student -->
<div class="modal fade" id="ConfrimsubscribeStudentModal" role="dialog">
<div class="modal-dialog" style="">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="pull-left">Payment message has been sent to your Mobile Money Number</h4>

			<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body">

			<p class="alert alert-success">
				You have requested a payment for subscribing students,
				<br> Please approve the mobile money transaction on your phone to complete the payment
			</p>

			<button type="submit" href="#" class="btn btn-md btn-primary iHavePayedBtn" style="margin-right:10px;">I have Payed</button>
			<button type="submit" data-dismiss="modal" href="#" class="btn btn-md btn-warning" style="margin-right:10px;">I have not recieved the Mobile money message</button>
		</div>

	</div>

</div>

</div>



<!-- Reciept payment -->
<div class="modal fade" id="recieptPaymentModal" role="dialog">
<div class="modal-dialog" style="">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="pull-left receiptNoTitle">ReciptNo #1289</h4>

			<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body">

			<p class="charged">Charge</p>
			<p class="datePayed">Date</p>
			<p class="NoStudent">Number of students</p>



			<button type="submit" data-dismiss="modal" href="#" class="btn btn-md btn-success" style="">Finish</button>
		</div>

	</div>

</div>

</div>

<!-- Download Module -->
<div class="modal fade" id="downloadModal" role="dialog">
<div class="modal-dialog" style="">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="pull-left">Download the App</h4>
			<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<img class="img-responsive" src="./images/downloads/kasWindowsApp.jpg" alt="KAS Windows Application">
				</div>
				<div class="col-md-6 col-sm-6">
					<h4 class="page-header">Windows application V 0.1 </h4>
					<ul class="list-group-custom">
						<li>
							<i class="fa fa-diamond"></i>Offline Content Access</li>
						<li>
							<i class="fa fa-exchange"></i>Monthly Updates</li>
						<li>
							<i class="fa fa-bolt"> </i>Quick Installation</li>
					</ul>
					<br>
					<a target="_blank" class="btn btn-md btn-primary" href="https://www.dropbox.com/sh/vwj68iekzerq4sa/AADGP4JRDczp1wCA0tHTE4AAa?dl=0" title="Download KAS Windows Application">
						<i class="fa fa-cloud-download"></i> &nbsp; Download</a>
					<br>
					<br>
				</div>
			</div>
			<br/>
			<br/>
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<img class="img-responsive" style="height:200px;" src="./images/downloads/android.png" alt="KAS Android Application">
				</div>
				<div class="col-md-6 col-sm-6">
					<h4 class="page-header">Android App</h4>
					<p>Android Mobile application is still under development</p>
					<a target="_blank" class="btn btn-md btn-primary" href="#" title="Download KAS Android Application">Coming Soon</a>
				</div>

			</div>
		</div>
	</div>
</div>
</div>



<!-- Programs Module -->
<div class="modal fade" id="programsModal" role="dialog">
<div class="modal-dialog" style="width:80%">
	<div class="modal-content">
		<div class="modal-header">
			<h3 class="pull-left"><b>Thrive Education Programs<b></h3>
			<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body">
			<div class="row">
			<div class="col-md-10 item x">
				<a href="./professional-development-for-teachers.php">
				<div style="background-image: url('./images/programs/td.png');" class="img"></div>
				<span>Professional Development For Teachers</span>
				</a>
				</div>

				<div class="col-md-10 item">
				<a href="./student-support-program.php">
				<div style="background-image: url('./images/programs/ssp-hero.png');" class="img"></div>
				<span>Student Support Programs</span>
				</a>
				</div>
				<div class="col-md-10 item x">
				<a href="./student-pathways-program.php">
				<div style="background-image: url('./images/programs/stu_pathway.svg');" class="img"></div>
				<span>Student Pathways Programs</span>
				</a>
				</div>
				<div class="col-md-10 item">
				<a href="./learning-shift-program.php">
				<div style="background-image: url('./images/programs/lsp.jpg');" class="img"></div>
				<span>The Learning Shift Programs</span>
				</a>
				</div>
			</div>
		</div>
	</div>
</div>
</div>


<!-- Programs register -->
<!-- Login and Sign up page <div class="" id="accountPop" role="dialog">-->
<div class="modal fade" id="programsRegister" role="dialog">

<div class="modal-dialog" style="width:50%;">
	<div class="modal-content">
		<div class="modal-header">
			<div class="pull-left" style="width:80%;">
				<h3 class="text-center" style="">Thrive Education Programs</h3>
			</div>
			<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body">

		<div class="row">
				<div class="col-md-2">

				</div>
				<div class="col-md-8" style="">

					<form class="registerProgram" id="registerProgram">
						<h4>Register</h4>
						<hr>
						<div class="form-group">
							<select required name="type" class="type form-control">
								<option value="0">Please Select registration Type</option>
								<option value="3">Student Support Program</Prog></option>
								<option value="4">Student Pathway Program</Prog></option>
								<option value="1">School ( The Learning Shift Program )</option>
								<option value="2">Mentor ( The Learning Shift Program )</option>

							</select>
						</div>

						<div class="form-group">
							<input required type="text" name="sponsor_name" class="f_name form-control" placeholder="Full Names">
						</div>


						<div class="form-group">
							<input required type="text" name="location" class="location form-control" placeholder="Location">
						</div>

						<div class="row">
							<div class="col-md-6 form-group">
								<input required type="email" name="email" class="email form-control" placeholder="Email">
							</div>
							<div class="col-md-6 form-group">
								<input required type="text" name="phone" class="phone form-control" placeholder="Phone Number">
							</div>
						</div>
						<p>By registering, providing personal information and use of Kampala Smart School signifies acceptance
							of our
							<u>
								<a href="terms_of_use.php">Terms of Use</a>
							</u> and
							<u>
								<a href="privacy_policy.php">Privacy Policy</a>
							</u>.
						</p>
						<div class="form-group">
							<button type="submit" class='btn btn-custom-primary'>Register</button>
						</div>
						

					</form>
					<div class="hiddenElement alert alert-success msg-done success-send">
							<i class="fa fa-check-circle"></i>
							<p>Hello, Ian you registration was successful,
								 be sure to check your email for any updates
								 from Thrive Education Programs</p>
								 <br/>
							<button data-dismiss="modal" class="btn btn-default">Done</button>
					</div>
					<div class="hiddenElement alert alert-danger msg-failed-send">
							<p class="text-center">Hello, Ian you registration was not successful,
								 be sure to check you internet connection and details you submited
								 </p>
								 <br/>
				
						</div>
					<br>
					<br>
					<br>
									
				</div>
				<div class="col-md-2">

				</div>

			</div>
		</div>

	</div>

</div>

</div>





<!-- jQuery Script-->
<script src="admin/js/jquery/jquery.min.js"></script>

<script src="js/nprogress.js"></script>
<script src="admin/js/ajaxify.js"></script>
<script src="admin/js/scriptile.js"></script>
<script src="js/frontEnd.js"></script>
<script src="js/slick/slick.min.js"></script>


<!-- Bootstrap Core JavaScript -->
<script src="admin/js/bootstrap.min.js"></script>
<script src="js/jquery-ui/jquery-ui.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {

	<?php

	if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['username']) && !empty($_SESSION['username'])&& isset($_SESSION['status']) && $_SESSION['status']==true && isset($_SESSION['account']) && $_SESSION['account']=='student')
	{
		?>
	//getStudentLoged(<?php echo $_SESSION['user'];  ?>);
	<?php
	}

?>

	$(".datepicker").datepicker({
		changeMonth: true,
		changeYear: true,
		numberOfMonths: [1, 1],
		yearRange: "1995:2012"


	});
	$(".datepickerP").datepicker({
		changeMonth: true,
		changeYear: true,
		numberOfMonths: [1, 1],
		yearRange: "1900:2000"


	});



});
</script>

</body>
</html>