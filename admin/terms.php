<?php

include('inc/header.php');

?>
		<div Class="content-area col-md-9 col-sm-9 pull-right">
		
		<div class="panel panel-default">
		
		<div class="panel-heading">
		
		<h3 class="panel-title">Terms</h3>
		
		
		</div>
		
		<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
			<div class="btn-group btn-group-md pull-right">
					<button class="btn btn-primary" data-toggle="modal" data-target="#addNewTerm"><span class="fa fa-plus"> </span> Add a Term</button>
					
				</div>
				</div>
		</div>
		<h4 class="page-header">
		Available Terms
		</h4>
		<div class="row">
		
			<table class="table table-hover">
			<thead><tr>
			<td>
			Term
			</td>
			<td>
			Action
			</td>
			<tr>
			</thead>
			
			
		<tbody>	
		<tr>
			<td>
			Term 1
			</td>
			<td>
				<button class="btn btn-primary" data-target="#editTerm" data-toggle="modal"><span class="fa fa-edit"> </span> Edit</button>
			</td>
			<td>			
				<button class="btn btn-warning" data-target="#deleteTerm" data-toggle="modal"><span class="fa fa-trash"> </span> Delete</button>
			</td>
			</tr>
		<tbody>	
		</table>
		</div>
		</div>
	
	
	
		</div>
		
		</div>	
		</div>	
		
		

        
                                    
    <!-- Light Box -->
	<!-- Create new Term-->
	<div class="modal fade" id="addNewTerm" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Create a new Term</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<form id="addTermForm" role="form" class="addTermForm">
			
			<div class="form-group ">
						<div class="form-error alert alert-danger">Username or Password are invalid please check them and try again.</div>
						
					</div>	
				<div class="form-group">
					<label class="termNameLabel" for="termName">Term Name</label>
					<input type="text" name="termName" id="termName" class="form-control" placeholder="Term Name E.g Term One"></input>
				</div>
				
				<div class="form-group">
					<label class="TermDescriptionLabel" for="TermDescription">Term Description</label>
					<textarea name="TermDescription" id="TermDescription" class="form-control" placeholder="Description about the Term"></textarea>
				</div>
				
				<div class="form-group">
					<button type="submit" class="btn btn-success"><span class="fa fa-save"> </span> Save Term</button>
				
				</div>
				
				</form>
			
      </div>
      <div class="modal-footer">
        			
			
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
	
		</div>
	
	</div>
	
	
	<!-- Delete Term -->
<div class="modal fade" id="deleteTerm" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Are You Sure about Deleting this Term ?</h4>
		
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
	
	
	
	
	
	<!-- Edit Term-->
	
	<div class="modal fade" id="editTerm" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Edit Term</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<form class="editTermForm" id="editTermForm" role="form" method="post">
                            <div class="form-group ">
				<div class="form-error alert alert-danger">Error While Submitting Form</div>
			    </div>	
				<div class="form-group">
					<label class="termNameLabel" for="termName">Term Name</label>
					<input type="text" name="termName" id="termName" class="form-control" placeholder="Term Name E.g Term One"></input>
				</div>
				
				<div class="form-group">
					<label class="TermDescriptionLabel" for="TermDescription">Term Description</label>
					<textarea name="TermDescription" id="TermDescription" class="form-control" placeholder="Description about the Term"></textarea>
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
	
	</div>
