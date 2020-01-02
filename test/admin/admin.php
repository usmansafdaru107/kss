<?php
session_start();
?>
<script src="js/adminCrud.js"></script>
		<div class="notication alert alert-success"></div>
		
		<div class="panel panel-default">
		
		<div class="panel-heading">
		
		<h3 class="panel-title">Admin</h3>
		
		
		</div>
		
		<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
			<div class="btn-group btn-group-md pull-right">
					<button class="btn btn-primary" data-toggle="modal" data-target="#addNewAdmin"><span class="fa fa-plus"> </span> Add a Admin</button>
					
				</div>
				
				</div>
		</div>
		<br/>
		<h4 class="page-header">
	Contributors
		</h4>
		<div class="row">
		
			<table class="table table-hover">
			<thead><tr>
			<td>Name</td>
			<td>Phone</td>
			<td>Email</td>
			<td>Previllege</td>
			<td>Action</td>
			</tr></thead>
			<tbody class="adminList">
                            
                        <tbody>	
		</table>
		</div>
		</div>
	
	
	
		</div>
		
		<!--</div>	
		</div>	-->
		
		

        
                                    
    <!-- Light Box -->
	<!-- Create new Tutor-->
	<div class="modal fade" id="addNewAdmin" role="dialog">
	  <script>addAdmin();</script>
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Create a new Contributor/ Admmin</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<form class="addNewAdminForm" id="addNewAdminForm" role="form" method="post">
				<div class="form-group ">
						<div class="form-error alert alert-danger"></div>
						<div class="form-success alert alert-success"></div>
						
					</div>	
					
				<div class="form-group">
					<label class="emailLabel" for="email">Email</label>
					<input type="email" name="email" id="email" class="form-control" placeholder="Email Address">
				</div>	
				<div class="form-group">
					<label class="firstNameLabel" for="f_name">First Name</label>
					<input type="text" name="f_name" id="firstName" class="form-control" placeholder="First Name">
				</div>
				
				<div class="form-group">
					<label class="lastNameLabel" for="l_name">Last Name</label>
					<input type="text" name="l_name" id="lastName" class="form-control" placeholder="Last Name">
				</div>
				
				<div class="form-group">
					<label class="pass1Label" for="pass1">Passowrd</label>
					<input type="password" name="pass1" id="pass1" class="form-control" placeholder="Password">
				</div>
				
				<div class="form-group">
					<label class="pass2Label" for="pass2">Confirm Passowrd</label>
					<input type="password" name="pass2" id="pass2" class="form-control" placeholder="Retype your password">
				</div>
				
				<div class="form-group">
					<label class="townLabel" for="town">Town</label>
					<input type="text" name="town" id="town" class="form-control" placeholder="town">
				</div>
				
				
				<div class="form-group">
					<label class="countryLabel" for="country">Country</label>
					<input type="text" name="country" id="country" class="form-control" placeholder="Country">
				</div>
				
				<div class="form-group">
					<label class="phoneLabel" for="phone">Phone Number</label>
					<input type="text" name="phone" id="phone" class="form-control" placeholder="Phone Number eg (256)">
				</div>
				
				<div class="form-group">
					<label class="contributorLogoLabel" for="contributorLogo">Contributor Image</label>
					<input type="file"name="ppic" id="ppic" class="form-control" placeholder="Description about the class"></input>
				</div>
				
				<div class="form-group">
					<label class="previlegeLabel" for="previlege">Previlege</label>
					<select name="previlege" id="previlege" class="form-control">
						<option class="prev" value="0">Contributor</option>
						<option class="prev" value="1">Admin</option>
					</select>
				</div>
				
				
				<div class="form-group">
				<button type="submit" name="addNewAdminBtn" id="addNewAdminBtn" class="btn btn-success"><span class="fa fa-save"> </span> Save Admin</button>
				</div>
			</form>
			
      </div>
      <div class="modal-footer">
      
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
	
		</div>
	
	</div>
	
	
	<!-- Delete Class -->
<div class="modal fade" id="deleteAdmin" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Are You Sure about Deleting this Admin ?</h4>
		
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
	<!-- Edit Class-->
	
	<div class="modal fade" id="editAdmin" role="dialog">
	  <script></script>
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Edit Contributor/ Admin</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<form class="editAdminForm" id="editAdminForm" role="form" method="post">
				<div class="form-group ">
						<div class="form-error alert alert-danger"></div>
						<div class="form-success alert alert-success"></div>
						
					</div>	
					
				<div class="form-group">
					<label class="emailLabel" for="email">Email</label>
					<input type="email" name="email" id="email" class="form-control" placeholder="Email Address">
				</div>	
				<div class="form-group">
					<label class="firstNameLabel" for="f_name">First Name</label>
					<input type="text" name="f_name" id="firstName" class="form-control" placeholder="First Name">
				</div>
				
				<div class="form-group">
					<label class="lastNameLabel" for="l_name">Last Name</label>
					<input type="text" name="l_name" id="lastName" class="form-control" placeholder="Last Name">
				</div>
				
				<div class="form-group">
					<label class="townLabel" for="town">Town</label>
					<input type="text" name="town" id="town" class="form-control" placeholder="town">
				</div>
				
				
				<div class="form-group">
					<label class="countryLabel" for="country">Country</label>
					<input type="text" name="country" id="country" class="form-control" placeholder="Country">
				</div>
				
				<div class="form-group">
					<label class="phoneLabel" for="phone">Phone Number</label>
					<input type="text" name="phone" id="phone" class="form-control" placeholder="Phone Number eg (256)">
				</div>
				
				
				
				<div class="alert alert-warning">
				<p><a href='#' class="changePic"><i class="fa fa-edit"> </i> Change Profile Pic</a></p>
				</div>
				<div class="form-group img-upload">
					<label class="contributorLogoLabel" for="contributorLogo">Contributor Image</label>
					<input type="file" name="ppic" id="adminLogoEdit" class="form-control">
				</div>
				<div class="form-group img-avail">
				<img src="" class="pic img-responsive"/>
				</div>
				<div class="form-group">
				<button type="button" class="removeImg btn btn-xs btn-warning"><i class="fa fa-times"> </i> Remove Image</button>
				<button type="button" class="cancelRemoveImg btn btn-xs btn-warning"><i class="fa fa-undo"> </i> Return to Previous Image</button>
						
				</div>
				
				
				
				
				
				
				<div class="form-group">
					<label class="previlegeLabel" for="previlege">Previlege</label>
					<select name="previlege" id="previlege" class="form-control">
						<option class="prev" value="0">Contributor</option>
						<option class="prev" value="1">Admin</option>
					</select>
				</div>
				<div class="alert alert-warning">
				<p><a href='#' class="changePWD"><i class="fa fa-edit"> </i> Change password</a></p>
				</div>
				<div class="form-group">
					<label class="pass1Label" for="pass1">New password</label>
					<input type="password" name="pass1" id="pass1" class="form-control" placeholder="Password">
				</div>
				
				<div class="form-group">
					<label class="pass2Label" for="pass2">Confirm Passowrd</label>
					<input type="password" name="pass2" id="pass2" class="form-control" placeholder="Retype your password">
				</div>
				
				
				<div class="form-group">
				<button type="submit" name="editAdminBtn" id="editAdminBtn" class="btn btn-success"><span class="fa fa-save"> </span> Update</button>
				</div>
			</form>
			
      </div>
      <div class="modal-footer">
      
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
	
		</div>
	
	</div>
	
	<!-- Tutor Subjects Crud-->
	
	<div class="modal fade" id="subCrud" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Create a new Tutor</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<form class="addNewTutorForm" id="assignSubjectForm" role="form" method="post">
				<div class="form-group ">
						<div class="form-error alert alert-danger"></div>
						<div class="form-success alert alert-success"></div>
						
					</div>	
				<div class="row filter"> 
				<div class="col-md-4"> 
				<div class="form-group">
				
					<label class="classListLabel" for="classList">Select Class</label>
					<select name="classList" id="classList" class="classList form-control">

					</select>
				</div>
				</div>
				<div class="col-md-4"> 
				<div class="form-group">
					<label class="subjectListLabel" for="subjectList">Select Subject</label>
					<select name="subject" id="subjectList" class="subjectList form-control">
					
					</select>
				</div>
				</div>
				<div class="col-md-4">
				<div class="form-group">
				<label class="" for="assignSubject">Assign Subject</label>
				<br>
				<button type="submit" name="assignSubject" id="addNewClassBtn" class="btn btn-success"><span class="fa fa-save"></span></button>
				</div>
				</div>
				
				
				</div>
				
				
				
			</form>
			
			<h4 class="page-header">
	Assigned Subjects
		</h4>
		<div class="row">
		
			<table class="table table-hover">
			<thead><tr>
			<td>Class</td>
			<td>Subject</td>
			<td>Action</td>
			</tr></thead>
			<tbody class="assignedsubjectList">
                            
                        <tbody>	
		</table>
		</div>
			
      </div>
      <div class="modal-footer">
      
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
	
		</div>
	
	</div>
	
<script>initFilter();</script>
	
	

