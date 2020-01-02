<script src="js/tutorCrud.js"></script>
		<div class="notication alert alert-success"></div>
		
		<div class="panel panel-default">
		
		<div class="panel-heading">
		
		<h3 class="panel-title">Tutors</h3>
		
		
		</div>
		
		<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
			<div class="btn-group btn-group-md pull-right">
					<button class="btn btn-primary" data-toggle="modal" data-target="#addNewTutor"><span class="fa fa-plus"> </span> Add a Tutor</button>
					
				</div>
				
				</div>
		</div>
		<br/>
		<h4 class="page-header">
		Available Tutors
		</h4>
		<div class="row">
		
			<table class="table table-hover">
			<thead><tr>
			<td>Names</td><td>subject</td>
			<td>Action</td>
			</tr></thead>
			<tbody class="tutorList">
                            <script>
                            getAllTutors();
                            </script>
                        <tbody>	
		</table>
		</div>
		</div>
	
	
	
		</div>
		
		<!--</div>	
		</div>	-->
		
		

        
                                    
    <!-- Light Box -->
	<!-- Create new Tutor-->
	<div class="modal fade" id="addNewTutor" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Create a new Tutor</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<form class="addNewTutorForm" id="addNewTutorForm" role="form" method="post">
				<div class="form-group ">
						<div class="form-error alert alert-danger"></div>
						<div class="form-success alert alert-success"></div>
						
					</div>	
				<div class="row filter"> 
				<div class="col-md-3"> 
				<div class="form-group">
				
					<label class="classListLabel" for="classList">Select Class</label>
					<select name="classList" id="classList" class="classList form-control">
						
					</select>
				</div>
				</div>
				<div class="col-md-3"> 
				<div class="form-group">
					<label class="subjectListLabel" for="subjectList">Select Subject</label>
					<select name="subjectList" id="subjectList" class="subjectList form-control">
						<option value="0">Select Subject</option>
					</select>
				</div>
				</div>
				
				<div class="col-md-3"> 
				<div class="form-group">
				<script>getAllAdminInList();</script>
					<label class="adminLabel" for="tutor">Assign Admin</label>
					<select name="admin" id="admin" class="adminList form-control">
						<option value="0">Select Admin</option>
					</select>
				</div>
				</div>
				
				</div>
				
				
				<div class="form-group">
				<button type="submit" name="addNewClassBtn" id="addNewClassBtn" class="btn btn-success"><span class="fa fa-save"> </span> Save Class</button>
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
<div class="modal fade" id="deleteClass" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Are You Sure about Deleting this Class ?</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<div class="row">
				<div class="col-md-2"></div>
				<button class="btn btn-danger col-md-3"><span class="fa fa-check"> </span>Yes</button>	
				<div class="col-md-2"></div>
				<button class="btn btn-default col-md-3" data-dismiss="modal"><span class="fa fa-times"> </span>No</button>	
				
				<div class="col-md-2"></div>
			</div>
      </div>
      
    </div>
	
		</div>
	
	</div>	
	<!-- Edit Class-->
	
		<div class="modal fade" id="editTutor" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Edit Tutor</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<form class="editTutorForm" id="editTutorForm" role="form" method="post">
				<div class="form-group ">
						<div class="form-error alert alert-danger"></div>
						<div class="form-success alert alert-success"></div>
						
					</div>	
				<div class="row filter"> 
				<div class="col-md-3"> 
				<div class="form-group">
			
					<label class="classListLabel" for="classList">Select Class</label>
					<select name="classList" id="classList" class="classList form-control">
						
					</select>
				</div>
				</div>
				<div class="col-md-3"> 
				<div class="form-group">
					<label class="subjectListLabel" for="subjectList">Select Subject</label>
					<select name="subjectList" id="subjectList" class="subjectList form-control">
						<option value="0">Select Subject</option>
					</select>
				</div>
				</div>
				
				<div class="col-md-3"> 
				<div class="form-group">
				<script>getAllAdminInList();
				
				//getClassesInCheck(location)
				</script>
					<label class="adminLabel" for="tutor">Assign Admin</label>
					<select name="admin" id="admin" class="adminList form-control">
						<option value="0">Select Admin</option>
					</select>
				</div>
				</div>
				
				</div>
				
				
				<div class="form-group">
				<button type="submit" name="addNewClassBtn" id="addNewClassBtn" class="btn btn-success"><span class="fa fa-save"> </span> Save Class</button>
				</div>
			</form>
			
      </div>
      <div class="modal-footer">
      
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
	
		</div>
	
	</div>

	<script>initFilter();</script>
	
	

