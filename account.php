<?php
	session_start();
	if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['username']) && !empty($_SESSION['username'])&& isset($_SESSION['status']) && $_SESSION['status']==true && isset($_SESSION['account']) && $_SESSION['account']=='sponsor')
	{
		
    }
	else{
		
	$_SESSION=array();
	session_destroy();
		header("location:index.php");
	}
?>
<?php  include("inc/header.php");  ?>

    </div>
<div class="box-bg" style="background-color:#f7f7f7;">
<div class="container" style="background-color:#f7f7f7;">
<div class="row" style="background-color:#f7f7f7; height:80vh;">
	<div class="col-md-3 side-bar-nav">
		
			<div class="white_bg" style="border:1px solid #ddd;">
			<div class="public-box">
				
					<img class="profile-pic img-circle sponsor_pic" src="<?php echo $_SESSION['profile_pic']; ?>">
					
					<br>
					<p class="text-center"><?php echo $_SESSION['username']; ?></p>
					<br>
					<a href="#" data-toggle="modal"  data-id="<?php echo $_SESSION['user']; ?>" data-target="#accountSettings" class="editAcc btn btn-sm btn-primary">Edit Account</a>
			
			</div>
			
			<div class="naviga">
				<ul>
					<li class="text-center active"><a href="account.php" class="text-center">STUDENT</a></li>
					<li class=""><a  class="text-center" href="payment.php">PAYMENT HISTORY</a></li>
					
				</ul>
			
			</div>
			</div>
		
	</div>
	<div class="col-md-9 classListEnrolled" style="background-color:#fff; border:1px solid #ddd;">
	
	
	<div class="row">
	<div id="tableLeft" class="leftClass col-md-4">
	<div class="childTab">
	<h4 class="pull-left" style="color:#e53e30;">Classes enrolled</h4>
			
			
			
	<table class="table table-bordered" style="margin-top:50px;">
				<tr>
					
						<th>Class</th>
						<th>Students</th>
				</tr>
				<tbody class="enrolledClassList">
				
				</tbody>
			</table>
	<div class='pull-left noClassEnrolledx' style="width:100%;">
			
			</div>
	</div>
	</div>
	
	
	<div id="studentListRight" class="studentListRight col-md-8">
	
			
			
		<div class="childTab">
			<h4 class="TitleOfStudents pull-left" style="color:#e53e30;">Students</h4>
			
			<div class="pull-right">
			<a href="#" class="contAsStudent pull-left btn btn-primary">Continue as Student</a>
			<div class="pull-left"> &nbsp; </div>
			<a class="subscribeMultiple pull-left btn btn-success">Subscribe</a>
			
			<div class="spacer-normal pull-left">
			&nbsp;
			&nbsp;
			&nbsp;
			&nbsp;
			</div>
			
			<!-- <button class="dismisStudents pull-left btn btn-default"><i class="fa fa-times"></i></button>-->
			</div>
			<br style="clear:left;">
			
			<table class="pull-left ch-table table table-bordered">
				<tr>
					
						<th>Name</th>
						<th>User Name</th>
						<th>Date Of Birth</th>
						<th></th>
						<th></th>
						<th><input type="checkbox" value="*" class="" id="selectAllStudentsEnrolled"/></th>
						
						
						
					
				</tr>
				<tbody class="studentList">
				
				</tbody>
			</table>
			
			<div class='pull-left notStudentadded' style="width:100%;">
			
			</div>
			
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-12 classListNotEnrolled" style="background-color:#fff; margin-top:30px; margin-bottom:30px;">
	
	
	<div class="childTab">
	<h4 class="pull-left" style="color:#e53e30;">Students not enrolled</h4>
			
			<br style="clear:left;">
			
	<a style="" id="promptAddStudent" data-toggle="modal" data-target="#addChildModal" href="#addChild" class="addChild pull-right btn btn-sm btn-primary">Add Student</a>
			
			<button href="#" class="enrollMultiple promptenrollMultiple pull-right btn btn-sm btn-primary" style="margin-right:20px;">Enroll</button>&nbsp;
			
			<table class=" pull-left ch-table table table-hover">
				<tr>
					
						<th>Name</th>
						<th>User Name</th>
						<th>Date Of Birth</th>
						<th></th>
						<th></th>
						<th><input type="checkbox" value="*" class="" id="selectAllChildren"/></th>
						
						
					
				</tr>
				<tbody class="studentListnotEnrolled">
				
				</tbody>
			</table>
	
			<div class='pull-left noUnenrolled' style="width:100%;">
			</div>
	</div>
	
	</div>
	</div>
	</div>
	
	
	
	
	
	
	
	
	

</div>
</div>


<!-- Add student -->
<div class="modal fade" id="addChildModal" role="dialog">

		<div class="modal-dialog" style="">
		<div class="modal-content">
      <div class="modal-header">
    	<h4 class="pull-left">Add Student</h4>
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
	 <form class="addStudent" id="addStudent">
					<div class="row">
					<div class="col-md-6">
					<div class="form-group">
						<input type="text" id="" name="student_fname" class="studentFirstName form-control" placeholder="First name">
					</div>
					</div>
					
					
					<div class="col-md-6">
					<div class="form-group">
						<input type="text" name="student_lname" id="" class="studentLastName form-control" placeholder="Last name">
					</div>
					</div>
					</div>
					
					<div class="form-group">
						<input type="text" id="" name="dob" class="datepicker studentDoB form-control" placeholder="Date of Birth">
					</div>
					
					<div class="form-group">
					<label class="label" for="student_photo"> Student Image</label>
						<input type="file" id="" name="ppic" class="fileUpload studentImages form-control">
					</div>
					
					<!-- user name and password -->
					
					
					<div class="form-group">
					
						<input type="text" id="" name="username" class="studentUsername form-control" placeholder="Username">
					</div>
					
					
					
					<div class="row">
					<div class="col-md-6">
					<div class="form-group">
						<input type="password" id="" name="passwordo" class="studentPassword form-control" placeholder="Password">
					</div>
					</div>
					
					<div class="col-md-6">
					<div class="form-group">
						<input type="password" id="" name="password" class="studentPassword2 form-control" placeholder="Confirm password">
					</div>
					</div>
					</div>
					
					
					<div class="row">
					<div class="col-md-6">
					<div class="form-group">
						<button type="submit" class='btn btn-custom-danger'>Add Student</button>
					</div>
					</div>
					<div class="col-md-6">
					<div class="form-group">
					
					</div>
					</div>
					</div>
					
					</form>
			
      </div>
      
    </div>
	
		</div>
	
	</div>	
	
<!-- view edit student -->
<div class="modal fade" id="editStudent" role="dialog">

		<div class="modal-dialog" style="">
		<div class="modal-content">
      <div class="modal-header">
    	<h4 class="pull-left">Edit Student</h4>
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
         
	 <form class="editStudentForm" id="editStudentForm">
              <img scr="" class="studImg img-circle img-responsive" style="width:90px; height:90px;">
              <br>			
              <div class="row">
					<div class="col-md-6">
					<div class="form-group">
						<input type="text" id="" name="f_name" class="studentFirstName form-control" placeholder="First name">
					</div>
					</div>
					
					
					<div class="col-md-6">
					<div class="form-group">
						<input type="text" name="l_name" id="" class="studentLastName form-control" placeholder="Last name">
					</div>
					</div>
					</div>
					
					<div class="form-group">
						<input type="text" id="" name="dob" class="datepicker studentDoB form-control" placeholder="Date of Birth">
					</div>
					
				
					<!-- user name and password -->
					
					
					<div class="form-group">
					
						<input type="text" id="" name="username" class="studentUsername form-control" placeholder="Username">
					</div>
					
					<div class="row">
					<div class="col-md-12 form-group">
						<button state="deactive" class="btn btn-xs btn-danger changeP">Change Password</button>
					</div>
					<div class="changePfields alert alert-warning">
					<div class="col-md-12 form-group">
						<input type="text" name="pass1" class="np form-control" placeholder="New password">
					</div>
					
					<div class="col-md-12 form-group">
						<input type="text" name="pass2" class="npc form-control" placeholder="Confirm New password">
					</div>
					</div>
					</div>
                                        <!--
                                        <div class="image-change">
                                            <div class="form-group img-upload">
                                            <label class="classLogoLabel" for="classLogo">Class Logo Or Image</label>
                                            <input type="file" name="image" class="sponsorImageEdit" id="PimageEdit" class="form-control">
                                            </div>
                                            <div class="form-group img-avail">
                                            <img src="images/ggll.jpg" class="pic img-responsive"/>
                                            </div>
                                            <div class="form-group">
                                            <button type="button" class="removeImg btn btn-xs btn-warning"><i class="fa fa-times"> </i> Remove Image</button>
                                            <button type="button" class="cancelRemoveImg btn btn-xs btn-warning"><i class="fa fa-undo"> </i> Return to Previous Image</button>

				</div>
				</div>
                                        
                                        -->
					<div class="row">
					<div class="col-md-6">
					<div class="form-group">
						<button type="submit" class='btn btn-custom-danger'>Save changes</button>
					</div>
					</div>
					<div class="col-md-6">
					<div class="form-group">
					
					</div>
					</div>
					</div>
					
					
										
					
					
					
					</form>
			
      </div>
      
    </div>
	
		</div>
	
	</div>	


	
	
	
	
	<!-- Multiple Enroll-->
	<div class="modal fade" id="enrollMultiple" role="dialog">

		<div class="modal-dialog" style="">
		<div class="modal-content">
      <div class="modal-header">
    	<h4 class="pull-left">Enroll Student</h4>
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
	 <form class="enrollStudentM" id="enrollStudentM">
					<div class="form-group studentListA">
						<a href="#" class="btn btn-default">Student Name</a>
					</div>	
					
					<div class="form-group">
						<select name="class_id" class="enroll_class classListed form-control">
				</select>
					</div>
					
					
					<div class="row">
					<div class="col-md-6">
					<div class="form-group">
						<button type="submit" class='btn btn-custom-danger'>Enroll</button>
					</div>
					</div>
					<div class="col-md-6">
					<div class="form-group">
					
					</div>
					</div>
					</div>
					
		</form>
			
      </div>
      
    </div>
	
		</div>
	
	</div>	
	
		<!-- Remove Student -->
<div class="modal fade" id="deleteStudent" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Are You Sure about Removing this Student?</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<div class="row">
				<div class="col-md-2"></div>
				<button data-dismiss="modal" class="delBtn btn btn-danger col-md-3"><span class="fa fa-check"> </span>Yes</button>	
				<div class="col-md-2"></div>
				<button class="btn btn-default col-md-3" data-dismiss="modal"><span class="fa fa-times"> </span>No</button>	
				
				<div class="col-md-2"></div>
			</div>
      </div>
      
    </div>
	
		</div>
	
	</div>	
	
			<!-- Unenroll Student -->
<div class="modal fade" id="unenrollStudentModal" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Are You Sure about unenrolling this Student?</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<div class="row">
				<div class="col-md-2"></div>
				<button data-dismiss="modal" class="delBtn btn btn-danger col-md-3"><span class="fa fa-check"> </span>Yes</button>	
				<div class="col-md-2"></div>
				<button class="btn btn-default col-md-3" data-dismiss="modal"><span class="fa fa-times"> </span>No</button>	
				
				<div class="col-md-2"></div>
			</div>
      </div>
      
    </div>
	
		</div>
	
	</div>	

	
	<!--  Account Settings -->
	
	<div class="modal fade" id="accountSettings" role="dialog">

		<div class="modal-dialog" style="">
		<div class="modal-content">
      <div class="modal-header">
    	<h4 class="pull-left">Edit Account Settings</h4>
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
	 <form class="editAccForm" id="editAccForm">
			
					<div class="form-group">
					<p>Account Type:<span class="accType"></span></p>
					</div>
                            <img src="" style="height:90px; width:90px;" class="pic img-circle img-responsive"/>
                            <br>
                            <!-- 
					<div class="image-change">
					<div class="form-group img-upload">
					<label class="classLogoLabel" for="classLogo">Class Logo Or Image</label>
					<input type="file" name="image" class="sponsorImageEdit" id="PimageEdit" class="form-control">
				</div>
				<div class="form-group img-avail">
				<img src="images/ggll.jpg" class="pic img-responsive"/>
				</div>
				<div class="form-group">
				<button type="button" class="removeImg btn btn-xs btn-warning"><i class="fa fa-times"> </i> Remove Image</button>
				<button type="button" class="cancelRemoveImg btn btn-xs btn-warning"><i class="fa fa-undo"> </i> Return to Previous Image</button>
						
				</div>
				</div>
                            
                            -->
					
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
					<div class="row">
					<div class="col-md-12 form-group">
						<button state="deactive" class="btn btn-xs btn-danger changeP">Change Password</button>
					</div>
					<div class="changePfields alert alert-warning">
					<div class="col-md-12 form-group">
						<input type="text" name="oldpassword" class="op form-control" placeholder="Old password">
					</div>
					<div class="col-md-12 form-group">
						<input type="text" name="newPassword" class="np form-control" placeholder="New password">
					</div>
					
					<div class="col-md-12 form-group">
						<input type="text" name="newPasswordc" class="npc form-control" placeholder="Confirm New password">
					</div>
					</div>
					</div>
					
					
					<div class="form-group">
						<button class='btn btn-custom-primary'>Save changes and Exit</button>
					</div>
					
					</form>
	</form>
			
      </div>
      
    </div>
	
		</div>
	
	</div>	
	
	
				<!-- Subscribe Student -->
<div class="modal fade" id="subscribeStudentModal" role="dialog">
		<div class="modal-dialog" style="width:60%;">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Subscribe Student(s)</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
	  <h4 class="studentsNumber">Students Name(s)</h4>
	  <div class="form-group studentListE">
						
	</div>
	  
				
			<form class="initForm form-inline" id="depositForm" >
			 <div class="form-group col-xs-5 col-md-5">
    <label class="control-label" for="mmnumber">Mobile Money Numner</label>
	<br>
    <button disabled class="btn btn-default">+256</button><input type="text" disabled class="form-control mmnumber" name="mmnumber" placeholder="791954727">
  </div>
  <div class="form-group col-xs-4 col-md-4">
    <label class="control-label" for="ammountd">Amount to be paid</label>
	<br>
    <input type="text" name="ammountd" class="form-control ammountd" disabled placeholder="Amount">
  </div>
 <div class="form-group col-xs-3 col-md-3">
  <label class="control-label" for="ammountd">Click to:</label>
	<br>
			<button disabled type="submit" data-toggle="modal" data-target="#" href="#" class="btn btn-sm btn-primary" style="margin-right:10px;">Initiate Payment</button>&nbsp;
</div>			
			</form>
						<br style="clear:both;">
						<br style="clear:both;">
		<p class="alert alert-warning msg"></p>	
		<br style="clear:both;">
						<br style="clear:both;">
		<h4 class="page-header">Payment Accepted from:</h4>
		<div class="mobile_money_brands">
		<img class="" src="images/mobile_money_logos/airtel.png">
		<img class="" src="images/mobile_money_logos/mtn.png">
		<img class="" src="images/mobile_money_logos/africel.png">
		<img class="" src="images/mobile_money_logos/vodafone.png">
		<img class="" src="images/mobile_money_logos/smart.png">
		</div>
			
      </div>
      
    </div>
	
		</div>
	
	</div>	
	
	
	
	
	
 
<?php  include("inc/footer.php");  ?>
<script src="js/account.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-92899523-1', 'auto');
  ga('send', 'pageview');

</script>

