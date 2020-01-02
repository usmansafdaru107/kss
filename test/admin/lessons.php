<script src="js/lessonCrud.js"></script>
		<div class="panel panel-default">
		
		<div class="panel-heading">
		
		<h3 class="panel-title">Lessons</h3>
		
		
		</div>
		
		<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
			<div class="btn-group btn-group-md pull-right">
					<button class="btn btn-primary" data-toggle="modal" data-target="#addNewLesson"><span class="fa fa-plus"> </span> Add a Lesson</button>
					
				</div>
				</div>
		</div>
		<h4 class="page-header">
		Available Lessons
		</h4>
		<div class="row filter"> 
				<div class="col-md-3"> 
				<div class="form-group">
				
					<label class="classListLabel" for="classList">Select Class</label>
					<select name="classList" id="classList" class="classList form-control">
					<!--	<option value="0">Select Class</option> -->
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
				
				<div class="col-md-3"> 
				<div class="form-group">
					<label class="topicLabel" for="topicName">Select Topic</label>
					<select name="topicName" id="topicName" class="topicList form-control">
						<option value="0">Select Topic</option>
					</select>
				</div>
				</div>
				
				</div>
		<br>
		<div class="row">
		
			<table class="table table-hover">
			<thead><tr>
			<td>Lesson</td><td>Topic</td>
			<td>Action</td>
			</tr></thead>
			<tbody class="lessonsList lessonPage">
                            <script>
                            paginate_lessons();
                            </script>
                        <tbody>	
		</table>
		</div>

		<div class='row pagination_sect' id='less_page'>
		</div>
		</div>
	
	
	
		</div>
		
		</div>	
		</div>	
		
		

        
                                    
    <!-- Light Box -->
	<!-- Create new Lesson-->
	<div class="modal fade" id="addNewLesson" role="dialog">
	<script>addLesson();</script>
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Create a new Lesson<h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<form role="form" id="addNewLessonForm" class="addNewLessonForm" method="post">
                            <div class="form-group ">
						<div class="form-error alert alert-danger"></div>
						<div class="form-success alert alert-success"></div>
						
                            </div>
				<div class="form-group">
					<label class="LessonNameLabel" for="LessonName">Lesson Name</label>
					<input type="text" name="LessonName" id="LessonName" class="form-control" placeholder="Lesson Name E.g Lesson 1"></input>
				</div>
				<div class="row filter"> 
				<div class="col-md-3"> 
				<div class="form-group">
				
					<label class="classListLabel" for="classList">Select Class</label>
					<select name="classList" id="classList" class="classList form-control">
					<!--	<option value="0">Select Class</option> -->
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
				
				<div class="col-md-3"> 
				<div class="form-group">
					<label class="topicLabel" for="topicName">Select Topic</label>
					<select name="topicName" id="topicName" class="topicList form-control">
						<option value="0">Select Topic</option>
					</select>
				</div>
				</div>
				
				</div>
				<div class="form-group">
				<button class="btn btn-success"><span class="fa fa-save"> </span> Save Lesson</button>
				
				
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
<div class="modal fade" id="deleteLesson" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Are You Sure about Deleting this Lesson ?</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<div class="row">
				<div class="col-md-2"></div>
				<button class="delBtn btn btn-danger col-md-3" data-dismiss="modal" ><span class="fa fa-check"> </span>Yes</button>	
				<div class="col-md-2"></div>
				<button class="btn btn-default col-md-3" data-dismiss="modal"><span class="fa fa-times"> </span>No</button>	
				
				<div class="col-md-2"></div>
			</div>
      </div>
      
    </div>
	
		</div>
	
	</div>	
	<!-- Edit Lesson-->
	
	<div class="modal fade" id="editLesson" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Edit Lesson</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
       <div class="modal-body">
			<form role="form" id="editLessonForm" class="editLessonForm" method="post">
                            <div class="form-group ">
						<div class="form-error alert alert-danger">Error</div>
						
                            </div>
				<div class="form-group">
					<label class="LessonNameLabel" for="LessonName">Lesson Name</label>
					<input type="text" name="LessonName" id="LessonNameEdit" class="form-control" placeholder="Lesson Name E.g Lesson 1"></input>
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
					<select name="unitName" id="UnitName" class="unitList form-control">
						<option value="0">Select Unit</option>
					</select>
				</div>
				</div>
				
				<div class="col-md-3"> 
				<div class="form-group">
					<label class="topicLabel" for="topicName">Select Topic</label>
					<select name="topicName" id="topicListEdit" class="topicList form-control">
					
					</select>
				</div>
				</div>
				
				</div>
				<div class="form-group">
				<button type="submit" class="btn btn-success"><span class="fa fa-save"> </span> Update Lesson</button>
				
				
			</div>
			</form>
			
      </div>
      <div class="modal-footer">
        
			
			
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
	
		</div>
	
<script>initFilter();</script>