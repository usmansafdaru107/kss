		<div class="panel panel-default">
		<div class="panel-body">
		<h4 class="page-header">
		Available Topics <button class="btn pull-right btn-xs btn-primary addTopicBtn" data-toggle="modal" data-target="#addNewTopic"><span class="fa fa-plus"> </span> Add a topic</button>
		</h4>
                <div class="row topic-filter"> 
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
					<label class="UnitNameLabel" for="UnitName">Select Unit</label>
					<select name="unitName" id="UnitName" class="unitList form-control">
						<option value="0">Select Unit</option>
					</select>
				</div>
				</div>
				
				</div>    
					<br>
					
		<div class="row topicList topicPage">
		
		</div>
		<!-- Paginator -->
		<div class="paginator btn-group btn-group-md">
		
		</div>
		
		
		
		
		</div>
	
	
	
		</div>
		
		</div>	
		</div>	
		
		

        
                                    
    <!-- Light Box -->
	<!-- Create new Topic-->
	<div class="modal fade" id="addNewTopic" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Create a new Topic</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<form role="form" class="addNewTopicForm" id="addNewTopicForm" method="post">
                            <div class="form-group ">
						<div class="form-error alert alert-danger">Error</div>
                                                <div class="form-success alert alert-success"></div>
						
                            </div>
				<div class="form-group">
					<label class="TopicNameLabel" for="TopicName">Topic Name</label>
					<input type="text" name="topicName" id="TopicName" class="form-control" placeholder="Topic Name E.g Vowels"></input>
				</div>
				<div class="row filter-add-topic"> 
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
					<label class="UnitNameLabel" for="UnitName">Select Unit</label>
					<select name="unitName" id="UnitName" class="unitList form-control">
						<option value="0">Select Unit</option>
					</select>
				</div>
				</div>
				
				</div>
				
				
				<div class="form-group">
					<label class="topicLogoLabel" for="topicLogo">Topic Logo Or Image</label>
					<input type="file" name="topicLogo" id="topicLogo" class="form-control"></input>
				</div>
                                    <div class="form-group">
				<button type="submit" class="btn btn-success"><span class="fa fa-save"> </span> Save topic</button>
				
				
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
<div class="modal fade" id="deleteTopic" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Are You Sure about Deleting this Topic ?</h4>
		
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
        <!-- Edit Subject-->
        <!-- Edit Subject-->
	
	<div class="modal fade" id="editTopic" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Edit Topic</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
       <div class="modal-body">
			<form role="form" class="editTopicForm" id="editTopicForm" method="post">
                        
                            <div class="form-group ">
						<div class="form-error alert alert-danger">Error</div>
                                                <div class="form-success alert alert-success"></div>
						
                            </div>
				<div class="form-group">
					<label class="TopicNameLabel" for="TopicName">Topic Name</label>
					<input type="text" name="name" id="TopicName" class="form-control" placeholder="Topic Name E.g Vowels"></input>
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
					<label class="UnitNameLabel" for="UnitName">Select Unit</label>
					<select name="theme" id="UnitName" class="unitList form-control">
						<option value="0">Select Unit</option>
					</select>
				</div>
				</div>
				
				</div>
				
				<div class="form-group img-upload">
					<label class="topicLogoLabel" for="topicLogo">Topic Logo Or Image</label>
					<input type="file" name="topicLogo" id="topicLogoEdit" class="form-control">
				</div>
				<div class="form-group img-avail">
				<img src="" class="pic img-responsive"/>
				</div>
				<div class="form-group">
				<button type="button" class="removeImg btn btn-xs btn-warning"><i class="fa fa-times"> </i> Remove Image</button>
				<button type="button" class="cancelRemoveImg btn btn-xs btn-warning"><i class="fa fa-undo"> </i> Return to Previous Image</button>
						
				</div>
				
                                    <div class="form-group">
				<button type="submit" class="btn btn-success"><span class="fa fa-save"> </span> Save topic</button>
				
				
			</div>
			</form>
			
      </div>
      <div class="modal-footer">
        
			
			
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
	
		</div>
<script src="js/topicCrud.js" defer></script>