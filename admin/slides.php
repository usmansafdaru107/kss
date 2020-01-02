		<div class="panel panel-default">
		<div class="panel-body">
			
		<div class="row">
		<div class="loadPreview col-md-9">
		<div class="loadpInner">
		</div>
		</div>
		<div class="col-md-3">
		<div class="btn-group btn-group-md">
					<button id="ByLessonBtn" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addNewSlide"><span class="fa fa-plus"> </span> Add a Slide</button>
					<a class="backToLessons btn btn-xs btn-danger" id="backBtn" href="lessons.php">Back to Lessons</a>
				</div>
			<table class="table table-hover">
				<thead><tr>
					<td><strong>Available Slides</strong></td>
					<!-- <td>Content</td>
					<td>Action</td> -->
				<tr></thead>
				
					<tbody id="slideList">
					
					</tbody>
				
		</table>
		</div>
		</div>
		</div>
			</div>
		
		</div>	
		</div>	
		
		

        
                                    
    <!-- Light Box -->
	<!-- Create new Lesson-->
	<div class="modal fade" id="addNewSlide" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Create a new Slide<h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<form role="form" class="addNewSlideForm" id="addNewSlideForm" method="post">
			<div class="form-group ">
						<div class="form-error alert alert-danger"></div>
						<div class="form-success alert alert-success"></div>
						
                            </div>	
                            <div class="form-group">
					<label class="SlideNameLabel" for="SlideName">Slide Name</label>
					<input type="text" name="SlideName" id="SlideName" class="form-control" placeholder="Slide Name E.g Slide 1"></input>
				</div>
				
				<div class="form-group">
				<button type="submits" id="submitAddSlide" class="btn btn-success"><span class="fa fa-save"> </span> Save Slide</button>
				
				
			</div>
			</form>
			
      </div>
      <div class="modal-footer">
        
			
			
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
	
		</div>
	
	</div>
	
	
	<!-- Delete Lesson -->
<div class="modal fade" id="deleteSlide" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Are You Sure about Deleting this Slide ?</h4>
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<div class="row">
				<div class="col-md-2"></div>
				<button data-dismiss="modal" id="delSlideBtn" class="btn btn-danger col-md-3"><span class="fa fa-check"> </span>Yes</button>	
				<div class="col-md-2"></div>
				<button class="btn btn-default col-md-3" data-dismiss="modal"><span class="fa fa-times"> </span>No</button>	
				
				<div class="col-md-2"></div>
			</div>
      </div>
      
    </div>
	
		</div>
	
	</div>	
	
	
	
	<!-- slide content-->
	
	<div class="modal fade" id="slideContent" role="dialog">
		<div class="modal-dialog" style="width:95%;">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Slide Content</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
       <div class="modal-body">
           <div class="row">
		   <!--
			<form role="form" method="post" id="slideContentForm" class="col-md-8 slideContentForm">
			<textarea cols="80" id="editorx" name="editorx3" rows="10"></textarea>	
                        <br>
                        <div class="form-group">
                           <button type="submit" class="btn btn-success"><span class="fa fa-save"> </span> Save</button>
				 
                        </div>
                        </form>	
						-->
						<div class="col-md-8">
						<form role="form" method="post" id="editSlideForm" class="editSlideForm">
			<div class="form-group">
					<label class="SlideNameLabel" for="SlideName">Slide Name</label>
					<input type="text" name="SlideName" id="SlideNameEdit" class="form-control" placeholder="Slide Name E.g Slide 1"></input>
				</div>
				<textarea cols="80" id="editorx" class="textEdited" name="editorx3" rows="10"></textarea>	
                        <br>
						
				       <div class="form-group">
                           <button type="submit" class="btn btn-success"><span class="fa fa-save"> </span> Save</button>
				 
                        </div>
                        </form>	
						</div>
           <div class="col-md-4">
               <div class="panel panel-default">
                   <div class="panel-heading" style="overflow:auto;">
											 <h4 class="pull-left panel-title"><span class="fa fa-cloud"> </span> Resource manager</h4>
											 <button class="addNewResourceBtn pull-right btn btn-xs btn-primary" data-toggle="modal" data-target="#addNewResource"><span class="fa fa-plus"> </span> Add a Resource</button>
                   </div>
                   <div class="panel-body">
                       <div class="row">
                           <form role="form" class="col-md-12" id="searchResourse">
                               <div class="form-group input-group">
                                   <input type="search" placeholder="Search a resource by name" class="form-control" id="searchValue"> 
                                   <span class="input-group-btn">
                                   <button type="button" class="btn btn-primary"><i class="fa fa-search"></i></button> 
                                   </span>
                               </div>
                            </form> 
                       </div>
                       <div class="resourceList" style="height:200px; overflow-y: scroll;">
                   </div>
                       
                   </div>
               </div>
           </div>
           </div>
			
			
      </div>
      <div class="modal-footer">
        
			
			
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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

		<!-- Create new resource-->
	<div class="modal fade" id="addNewResource" role="dialog">
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

	<script src="js/slidesCrud.js"></script>   
