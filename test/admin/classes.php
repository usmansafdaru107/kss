<?php
session_start();
?>
<script src="js/classCrud.js"></script>		
		<div class="notication alert alert-success"></div>
		
		<div class="panel panel-default">
		
		<div class="panel-heading">
		
		<h3 class="panel-title">Classes</h3>
	
		</div>
		
		<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
			<div class="btn-group btn-group-md pull-right">
					<?php if(isset($_SESSION['previlege']) && $_SESSION['previlege']==1){ 
					echo '<button class="btn btn-primary" data-toggle="modal" data-target="#addNewClass"><span class="fa fa-plus"> </span> Add a class</button>';
				 }?>
				</div>
				
				</div>
		</div>
		<br/>
		<div class="row classList" >
		<script>
			
		</script>
			
		</div>
		</div>
	
	
	
		</div>
		
		<!--</div>	
		</div>	-->
		
		

        
                                    
    <!-- Light Box -->
	<!-- Create new Class-->
	<div class="modal fade" id="addNewClass" role="dialog">
	<script>addClass();</script>
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Create a new Class</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<form class="addNewClassForm" id="addNewClassForm" role="form" method="post" enctype="multipart/form-data">
				<div class="form-group ">
						<div class="form-error alert alert-danger"></div>
						<div class="form-success alert alert-success"></div>
						
					</div>	
				<div class="form-group">
					<label class="classNameLabel" for="className">Class Name</label>
					<input type="text" name="className" id="className" class="form-control" placeholder="Class Name E.g Primary One"></input>
				</div>
				
				<div class="form-group">
					<label class="shortClassNameLabel" for="shortClassName">Short Class Name</label>
					<input type="text" name="shortClassName" id="shortClassName" class="form-control" placeholder="Short Class Name E.g P.1"></input>
				</div>
				
				
				<div class="form-group">
					<label class="classDescriptionLabel" for="classDescription">Class Description</label>
					<textarea name="classDescription" id="classDescription" class="form-control" placeholder="Description about the class"></textarea>
				</div>
				
				<div class="form-group">
					<label class="classLogoLabel" for="classLogo">Class Logo Or Image</label>
					<input type="file" name="classLogo" id="classLogo" class="form-control" placeholder="Description about the class"></input>
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
	
	<div class="modal fade" id="editClass" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Edit Class</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<form class="editClassForm" id="editClassForm" role="form" method="post" enctype="multipart/form-data">
				<div class="form-group ">
						<div class="form-error alert alert-danger"></div>
						<div class="form-success alert alert-success"></div>
						
					</div>	
				<div class="form-group">
					<label class="classNameLabel" for="className">Class Name</label>
					<input type="text" name="className" id="className" class="form-control" placeholder="Class Name E.g Primary One"></input>
				</div>
				
				<div class="form-group">
					<label class="shortClassNameLabel" for="shortClassName">Short Class Name</label>
					<input type="text" name="shortClassName" id="shortClassName" class="form-control" placeholder="Short Class Name E.g P.1"></input>
				</div>
				
				
				<div class="form-group">
					<label class="classDescriptionLabel" for="classDescription">Class Description</label>
					<textarea name="classDescription" id="classDescription" class="form-control" placeholder="Description about the class"></textarea>
				</div>
				
				<div class="form-group img-upload">
					<label class="classLogoLabel" for="classLogo">Class Logo Or Image</label>
					<input type="file" name="classLogo" id="classLogoEdit" class="form-control">
				</div>
				<div class="form-group img-avail">
				<img src="" class="pic img-responsive"/>
				</div>
				<div class="form-group">
				<button type="button" class="removeImg btn btn-xs btn-warning"><i class="fa fa-times"> </i> Remove Image</button>
				<button type="button" class="cancelRemoveImg btn btn-xs btn-warning"><i class="fa fa-undo"> </i> Return to Previous Image</button>
						
				</div>
				
				
				
			
			<div class="form-group">
						
						<button type="submit" name="login-btn" class="btn btn-success"><i class="fa fa-save"> </i> Update</button>
						
					</div>
			
			</form>
			
      </div>
      <div class="modal-footer">
        
			
			
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
	
		</div>
		</div>
		
		<script>
		
$( function(){
	var isAdmin="<?php echo $_SESSION['previlege']; ?>";
	getAllClasses(isAdmin);
});

</script>
	
	
	

