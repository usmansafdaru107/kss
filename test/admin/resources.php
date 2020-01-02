<script src="js/resourceCrud.js"></script>
 <script src="js/clipboard.min.js"></script>
 <script>
    var clipboard = new Clipboard('.btn');

    clipboard.on('success', function(e) {
        console.log(e);
    });

    clipboard.on('error', function(e) {
        console.log(e);
    });
    </script>
	
		<div class="panel panel-default">
		
		<div class="panel-heading">
		
		<h3 class="panel-title">Resources</h3>
		
		
		</div>
		
		<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
			 
			<div class="btn-group btn-group-md pull-right">
					<button class="btn btn-primary" data-toggle="modal" data-target="#addNewResource"><span class="fa fa-plus"> </span> Add a Resource</button>
					
				</div>
				
				<form role="form" class="col-md-8" id="">
                               <div class="form-group input-group">
                                   <input type="search" placeholder="Search" class="form-control" id=""> 
                                   <span class="input-group-btn">
                                   <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button> 
                                   </span>
                               </div>
                            </form> 
				</div>
		</div>
		<h4 class="page-header">
		Available Resources
		</h4>
			<div class="resourceList">
		
		</div>
		
		
		</div>
	
	
	
		</div>
		
		</div>	
		</div>	
		
		

        
                                    
    <!-- Light Box -->
	<!-- Create new resource-->
	<div class="modal fade" id="addNewResource" role="dialog">
	<script>
	addResource();
	
	</script>
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Add a New Resource</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<form class="addNewResourceForm" id="addNewResourceForm" method="post">
                              <div class="form-group ">
						<div class="form-error alert alert-danger"></div>
						<div class="form-success alert alert-success"></div>
						
                            </div>
				<div class="form-group">
					<label class="ResourceNameLabel" for="ResourceName">Resource Name</label>
					<input type="text" name="res_name" id="ResourceName" class="form-control" placeholder="Resource Name E.g Man Washing Caps"></input>
				</div>
				
				
				<div class="form-group">
					<label class="resourceFileLabel" for="resourceFile">Upload Resource</label>
					<input type="file" name="resource" id="resourceFile" class="form-control"></input>
				</div>
                             <div class="form-group">
				<button type="submit" class="btn btn-success"><span class="fa fa-save"> </span> Save Resource</button>
                            </div>
			</form>
			
      </div>
      <div class="modal-footer">
       
			
			
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
	
		</div>
	
	</div>
	
	
	<!-- Delete Subject -->
<div class="modal fade" id="deleteResource" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Are You Sure about Deleting this Resource ?</h4>
		
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
	
	<!-- Edit Resource-->
	<div class="modal fade" id="editResource" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Edit a Resource</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<form class="editResourceForm" id="editResourceForm" method="post">
                              <div class="form-group ">
						<div class="form-error alert alert-danger"></div>
						<div class="form-success alert alert-success"></div>
						
                            </div>
				<div class="form-group">
					<label class="ResourceNameLabel" for="ResourceName">Resource Name</label>
					<input type="text" name="res_name" id="ResourceNameEdit" class="form-control" placeholder="Resource Name E.g Man Washing Caps"></input>
				</div>
				
				<div class="form-group img-avail">
				<img src="" class="pic img-responsive" style="width:50px; height:50px;"/>
				</div>
								
                             <div class="form-group">
				<button type="submit" class="btn btn-success"><span class="fa fa-save"> </span> Save Resource</button>
                            </div>
			</form>
			
      </div>
      <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
	
		</div>
	
	</div>
