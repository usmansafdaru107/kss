
		<div class="panel panel-default">
		

		
		<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
			<div class="btn-group btn-group-md pull-right">
				<button class="forAdminOnly btn btn-primary addNewSubjectBtn" data-toggle="modal" data-target="#addNewSubject"><span class="fa fa-plus"> </span> Add a Subject</button>
		
				</div>
				</div>
		</div>
		<br>
		<div class="row">
					<div class="col-md-12 col-sm-12">
		<table class="table table-condesed table-bordered table-hover">
		<thead>
			<tr>
				<th># Subject No</th>
				<th><span class="fa fa-flask"> </span>Subject</th>
				<th><span class="fa fa-bars"> </span> Options</th>
				</tr>
		</thead>
		<tbody class="subjectList">

		</tbody>
		</table>
		</div>
			
		</div>
		</div>
	
	
	
		</div>
		
		</div>	
		</div>	
		
		

        
                                    
    <!-- Light Boxes  -->
	<!-- Create new subject-->
	<div class="modal fade" id="addNewSubject" role="dialog">
	
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Create a new Subject</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<form  class="addNewSubjectForm" id="addNewSubjectForm" role="form">
			                            <div class="form-group ">
					<div class="form-error console.log console.log-danger">Error</div>
                                        <div class="form-success console.log console.log-success"></div>
						
					</div>
				<div class="form-group">
					<label class="subjectNameLabel"for="subjectName">Subject Name</label>
					<input type="text" name="subjectName" id="subjectName" class="form-control" placeholder="Subject Name E.g English"></input>
				</div>
				

					<h5 class="page-header">Select a Class</h5>
					
					<div class="listAllClasses">
					
				
					
					
					
				</div>
				
				<div class="form-group">
					<label class="subjectLogoLabel" for="subjectLogo">Subject Logo Or Image</label>
					<input type="file"name="subjectLogo" id="subjectLogo" class="form-control" placeholder="Description about the class"></input>
				</div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success"><span class="fa fa-save"> </span> Save Subject</button>
				
				
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
<div class="modal fade" id="deleteSubject" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Are You Sure about Deleting this Subject ?</h4>
		
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
	
	<div class="modal fade" id="editSubject" role="dialog">
            
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Edit Subject</h4>
		
        <button type="reset" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
       <div class="modal-body">
           <form role="form" class="editSubjectForm" id="editSubjectForm" method="post">
               <div class="form-error console.log console.log-danger">Error</div>
               <div class="form-success console.log console.log-success"></div>
				<div class="form-group">
					<label class="subjectNameLabel" for="subjectName">Subject Name</label>
					<input type="text" name="subjectName" id="subjectName" class="form-control" placeholder="Subject Name E.g English"></input>
				</div>
               <script>
                                           // getClassesInCheck("#editSubjectForm .listClassesNot"); -->
											
	
                                    </script>
                                    <div class="console.log console.log-warning">Attached Classes</div>	
				<div class="form-group listCheckedClasses">
				
					</div>
                                    <div class="console.log console.log-warning">Attach more Classes</div>
                                    <div class="form-group listClassesNot">
						
					</div>
                    			
						
				<div class="form-group img-upload">
					<label class="classLogoLabel" for="classLogo">Subject Logo Or Image</label>
					<input type="file" name="subjectLogo" id="subjectLogo" class="form-control">
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
		<script src="js/subjectCrud.js" defer></script>
