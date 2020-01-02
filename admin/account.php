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
<div class="container">
<div class="row">
	<div class="col-md-2 side-bar-nav">
		
			<div class="public-box">
				
					<img class="profile-pic img-circle sponsor_pic" src="">
					
					<br>
					<p class="text-center"><?php echo $_SESSION['username']; ?></p>
					<br>
					<a href="#" data-toggle="modal"  data-id="<?php echo $_SESSION['user']; ?>" data-target="#accountSettings" class="editAcc btn btn-sm btn-primary">Edit Account</a>
			
			</div>
			<div class="naviga">
				<ul>
					<li><a href="#">Students</a></li>
					<li><a href="#">Payment</a></li>
					<li><a href="#">Settings</a></li>
				</ul>
			
			</div>
		
	</div>
	<div class="col-md-10">
		<div class="childTab">
			<h4 class="pull-left" style="color:#e53e30;">Students</h4>
			<a style="" data-toggle="modal" data-target="#addChildModal" href="#addChild" class="addChild promptAddStudent pull-right btn btn-sm btn-primary">Add Student</a>
			
			<a data-toggle="modal" data-target="#enrollMultiple" href="#enrollMultipleM" class="enrollMultiple promptenrollMultiple pull-right btn btn-sm btn-primary" style="margin-right:20px;">Enroll</a>&nbsp;
			
			<table class=" pull-left ch-table table table-hover">
				<tr>
					
						<th>Name</th>
						<th>User Name</th>
						<th>Date Of Birth</th>
						<th></th>
						<th></th>
						<th><input type="checkbox" value="*" class="" id="selectAllChildren"/></th>
						
						
					
				</tr>
				<tbody class="studentList">
				
				</tbody>
			</table>
			<div class='pull-left notStudentadded' style="width:100%;">
			
			</div>
		</div>
	</div>


</div>
</div>
<br>
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
						<input type="file" id="" name="ppic" class="studentImages form-control">
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
					
				
					<!-- user name and password -->
					
					
					<div class="form-group">
					
						<input type="text" id="" name="username" class="studentUsername form-control" placeholder="Username">
					</div>
					<div class="row">
					<div class="col-md-6">
					<div class="form-group">
						<button type="submit" class='btn btn-custom-danger'>Save</button>
					</div>
					</div>
					<div class="col-md-6">
					<div class="form-group">
					
					</div>
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-12">
					<div class="form-group">
						<p class="page-header">Classes Enrolled for</p>
					</div>
					</div>
					
					</div>	
										
					<div class="row">
					<div class="col-md-5">
					<div class="form-group ">
					<div class="enrolledClasses" role="group" aria-label="...">
					
					</div>
					</div>
					</div>
					<div class="col-md-7">
					<div class="form-group ">
					<p class=""><b>Read this before you do any thing</b></p>
					<p class="alert alert-warning">1. <b>Subscription</b> <br>requires an individual to deposit money in the System
					<br>
					<br>
					
					2. <b>Unenroll</b>  <br> removes a student from a class</p>
					</div>
					</div>
					</div>
					
					
					</form>
			
      </div>
      
    </div>
	
		</div>
	
	</div>	


	
	
	<!-- Enroll Student-->
	<div class="modal fade" id="enrollModal" role="dialog">

		<div class="modal-dialog" style="">
		<div class="modal-content">
      <div class="modal-header">
    	<h4 class="pull-left">Enroll Student</h4>
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
	 <form class="enrollStudent" id="enrollStudentx">
						
					
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

	
	<!--  Account Settings --->
	
	<div class="modal fade" id="accountSettings" role="dialog">

		<div class="modal-dialog" style="">
		<div class="modal-content">
      <div class="modal-header">
    	<h4 class="pull-left">Edit Account Settings</h4>
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
	 <form class="editAccForm" id="editAccForm">
			<form class="registerParent" id="registerParent">
					<div class="form-group">
					<p>Account Type:<span class="accType"></span></p>
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
						<button class='btn btn-custom-primary'>Register</button>
					</div>
					
					</form>
	</form>
			
      </div>
      
    </div>
	
		</div>
	
	</div>	
	

<?php  include("inc/footer.php");  ?>
 <script src="js/account.js"></script>
