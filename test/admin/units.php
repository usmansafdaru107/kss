<?php
session_start();
?>
<script src="js/unitsCrud.js"></script>
		<div class="panel panel-default">
		
		<div class="panel-heading">
		
		<h3 class="panel-title">Units / Themes</h3>
		
		
		</div>
		
		<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
			<div class="btn-group btn-group-md pull-right">
			<?php if(isset($_SESSION['previlege']) && $_SESSION['previlege']==1){ ?>
					<button class="btn btn-primary" data-toggle="modal" data-target="#addNewUnit"><span class="fa fa-plus"> </span> Add a Unit/ Theme</button>
			<?php } ?>
				</div>
				</div>
		</div>
		<h4 class="page-header">
		Available Units / Themes
		</h4>
		<br>
		<div class="row filter"> 
				<div class="col-md-4"> 
				<div class="form-group">
				
					<label class="classListLabel" for="classList">Select Class</label>
					<select name="classList" id="classList" class="classList form-control">
						<option value="0">Select Class</option>
					</select>
				</div>
				</div>
				<div class="col-md-4"> 
				<div class="form-group">
					<label class="subjectListLabel" for="subjectList">Select Subject</label>
					<select name="subjectList" id="subjectList" class="subjectList form-control">
						<option value="0">Select Subject</option>
					</select>
				</div>
				</div>
				    <div class="col-md-4"> 
                    <div class="form-group">
					<label class="termNameLabel" for="term">Select Term</label>
					<select name="term" id="termName" class="termList form-control">
						<option class="nth" value="0">Select Term</option>
                                                <option value="1">Term 1</option>
						<option value="2">Term 2</option>
						<option value="3">Term 3</option>
					</select>
				</div>
                    </div>
				
				</div>
		<div class="unitList unitPage">
		
		</div>
	
	
	
		</div>
		
		</div>	
		</div>	
		
		

        
                                    
    <!-- Light Box -->
	<!-- Create new Unit-->
	<div class="modal fade" id="addNewUnit" role="dialog">
            <script>addUnit();</script>
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Create a new Unit</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<form role="form" class="addNewUnitForm" id="addNewUnitForm" method="post">
                            <div class="form-group ">
						<div class="form-error alert alert-danger">Error</div>
                                                <div class="form-success alert alert-success"></div>
						
                            </div>	
				<div class="form-group">
					<label class="UnitNameLabel" for="themeName">Unit/ Theme Name</label>
					<input type="text" name="themeName" id="UnitName" class="form-control" placeholder="Unit Name E.g A-Z"></input>
				</div>
				<div class="row filter"> 
				<div class="col-md-3"> 
				<div class="form-group">
				
					<label class="classListLabel" for="classList">Select Class</label>
					<select name="classList" id="classList" class="classList form-control">
						<option value="0">Select Class</option>
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
					<label class="tutorLabel" for="tutor">Select Tutor</label>
					<select name="tutor" id="tutor" class="tutorList form-control">
						<option value="0">Select Tutor</option>
					</select>
				</div>
				</div>
				
				</div>
			                            
                            <div class="form-group">
					<label class="termNameLabel" for="term">Select Term</label>
					<select name="term" id="termName" class="form-control">
						<option value="0">Select Term</option>
                                                <option value="1">Term 1</option>
						<option value="2">Term 2</option>
						<option value="3">Term 3</option>
					</select>
				</div>
								
				<div class="form-group">
                                    <label class="unitDetailsLabel" for="unitDetails">Unit/ Theme Details</label>
                                            <textarea name="details" class="form-control" id="unitDetails"></textarea>
				</div>
				<div class="form-group">
					<label class="unitLogoLabel" for="unitLogo">Unit/ Theme Logo Or Image</label>
					<input type="file" name="unitLogo" id="unitLogo" class="form-control"></input>
				</div>
                              <div class="form-group">
                                  <button type="submit" class="btn btn-success"><span class="fa fa-save"> </span> Save Theme/ Unit</button>
				
				
			</div>
			</form>
			
      </div>
      <div class="modal-footer">
    	
			<button type="reset" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
	
		</div>
	
	</div>
	
	
	<!-- Delete Subject -->
<div class="modal fade" id="deleteUnit" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Are You Sure about Deleting this Theme / Unit ?</h4>
		
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
        
        
        
	<!-- Edit Subject-->
	
	<div class="modal fade" id="editUnit" role="dialog">
            
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Edit Theme / Unit</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
       <div class="modal-body">
			<form role="form" method="post" id="editUnitForm" class="editUnitForm">
                            <script>
                            
                            </script>
                            <div class="form-group ">
						<div class="form-error alert alert-danger">Error</div>
                                                <div class="form-success alert alert-success"></div>
                            </div>
				<div class="form-group">
					<label class="UnitNameLabel" for="themeName">Unit/ Theme Name</label>
					<input type="text" name="themeName" id="UnitName" class="form-control" placeholder="Unit Name E.g A-Z"></input>
				</div>
				<div class="row filter"> 
				<div class="col-md-3"> 
				<div class="form-group">
				
					<label class="classListLabel" for="classList">Select Class</label>
					<select name="classList" id="classList" class="classList form-control">
						<option value="0">Select Class</option>
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
					<label class="tutorLabel" for="tutor">Select Tutor</label>
					<select name="tutor" id="tutor" class="tutorList form-control">
						<option value="0">Select Tutor</option>
					</select>
				</div>
				</div>
				
				</div>
                            
                            <div class="form-group">
					<label class="termNameLabel" for="term">Select Term</label>
					<select name="term" id="termName" class="termList form-control">
					
					</select>
				</div>
								
				<div class="form-group">
                                    <label class="unitDetailsLabel" for="unitDetails">Unit/ Theme Details</label>
                                            <textarea name="details" class="form-control" id="unitDetails"></textarea>
				</div>
				<div class="form-group img-upload">
					<label class="unitLogoLabel" for="unitLogo">Unit/ Theme Logo Or Image</label>
					<input type="file" name="unitLogo" id="unitLogoEdit" class="form-control">
				</div>
				<div class="form-group img-avail">
				<img src="" class="pic img-responsive"/>
				</div>
				<div class="form-group">
				<button type="button" class="removeImg btn btn-xs btn-warning"><i class="fa fa-times"> </i> Remove Image</button>
				<button type="button" class="cancelRemoveImg btn btn-xs btn-warning"><i class="fa fa-undo"> </i> Return to Previous Image</button>
						
				</div>
				
				
				
				
				
				
				
				
				
                             <div class="form-group">
				<button type="submit" class="btn btn-success"><span class="fa fa-save"> </span> Update</button>
				
				
			</div>
			</form>
			
      </div>
      <div class="modal-footer">
       
			
			
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
	
		</div>
		<script>

$( function(){
	var isAdmin="<?php echo $_SESSION['previlege']; ?>";
	getAllUnits(isAdmin);
});
		</script>
<script>initFilter();</script>