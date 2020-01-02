
		<div class="panel panel-default">
		<div class="panel-body">
				
		<div class="row">
			<div class="loadPreview col-md-7">
				<div class="loadpInner">
					<h3 class="page-header" style='border: 1px solid #ccc; padding:5px;'></h3>
					<div class='group-box'>
					<h4 class="pull-left">Instruction:</h4>
					<h4 id="instruction_area"></h4>
					</div>
					<br>
					<h4 class='blue-title'>Question(s)</h4>
					<div id='activity_flow' class='group-box'>
					</div>
					<br>
				</div>

				<div class="btn-toolbar" role="toolbar">
  					<div class="btn-group pagitivity"></div>
				</div>
			</div>

			<div class="col-md-5">
			<div class="btn-group btn-group-md">
				<button id="ByLessonBtn" class="btn btn-primary" data-toggle="modal" data-target="#addNewActivity"><span class="fa fa-plus"> </span> Add an Activity</button>
			</div>

			<table class="table table-hover">
				<thead><tr>
					<td><strong>Available Activities</strong></td>
					
				<tr></thead>
				
					<tbody class="activityList">
					
					</tbody>
				
		</table>
		</div>
		</div>
		</div>
	
	
	
		</div>
		
		</div>	
		</div>	
		
		

        
                                    
    <!-- Light Box -->
	<!-- Create new Activity-->
	<div class="modal fade" id="addNewActivity" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Create a new Activity<h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<form role="form" class="addNewActivityForm" id="addNewActivityForm" method="post">
			<div class="form-group ">
						<div class="form-error alert alert-danger"></div>
						<div class="form-success alert alert-success"></div>
						
                            </div>	
                            <div class="form-group">
					<label class="QuizNameLabel" for="quizName">Activity Name</label>
					<input type="text" name="quizName" id="quizNameAdd" class="form-control" placeholder="Activity Name"></input>
				</div>
				
				<div class="form-group">
				<button type="submit" class="btn btn-success"><span class="fa fa-save"> </span> Save Quiz</button>
				
				
			</div>
			</form>
			
      </div>
      <div class="modal-footer">
        
			
			
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
	
		</div>
	
	</div>
	
	
	<!-- Delete Quiz -->
<div class="modal fade" id="deleteQuiz" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Are You Sure about Deleting this Activty ?</h4>
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<div class="row">
				<div class="col-md-2"></div>
				<button data-dismiss="modal" class="delQuizBtn btn btn-danger col-md-3"><span class="fa fa-check"> </span>Yes</button>	
				<div class="col-md-2"></div>
				<button class="btn btn-default col-md-3" data-dismiss="modal"><span class="fa fa-times"> </span>No</button>	
				
				<div class="col-md-2"></div>
			</div>
      </div>
      
    </div>
	
		</div>
	
	</div>	
	
	
	
	<!-- Quiz content-->
	
	<div class="modal fade" id="QuizContent" role="dialog">
		<div class="modal-dialog" style="width:95%;">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Activity Content</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
       <div class="modal-body">
           <div class="row">
		   		<div class="col-md-8">
						<form role="form" method="post" id="editActivityForm" class="editActivityForm">
			<div class="form-group">
					<label class="ActivityNameLabel" for="quizName">Activity Name</label>
					<input type="text" name="quizName" id="quizNameEdit" class="form-control" placeholder="Activity Name E.g Activity One"></input>
				
				</div>
				
				
					       <div class="form-group">
                           <button type="submit" class="btn btn-success"><span class="fa fa-save"> </span> Save</button>
				 
                        </div>
                        </form>	
						</div>
           
           </div>
			
			
      </div>
      <div class="modal-footer">
        
			
			
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
	
		</div>
		</div>
		
<div class="modal fade" id="QandA">
<div class="modal-dialog" style="width:100%;">
		<div class="modal-content">
<div class="modal-header">
        <h4 class="pull-left">Questions and Answers</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
<div class="modal-body row">
<div class="col-md-6 contentQnA">

<form name="AddQandAForm" class="AddQandAForm" id="AddQandAForm" method="post">
    
    <div class="form-group">
        <label class="instrunctionLabel" for="instruction">Instruction</label>
    	<textarea class="form-control" id="instruction" name='instruction'></textarea>
    </div>
    
		<div class="questionPanel">	
		<div class="form-group">
					<label class="questionTypeLabel" for="questionType">Question Type</label>
					<select name="questionType" id="questionType" class="form-control">
						<option value="0">Select Question Type</option>
						<option value="1" data-qnType='objective'>Objective</option>
						<option value="2" data-qnType='structured'>Structured</option>
						<option value="3" data-qnType='multiple_choice'>Multiple Choice</option>
						<option value="4" data-qnType='missing_letters'>Fill in the missing letters</option>
						<option value="5" data-qnType='rearrange'>Rearrange</option>
					</select>
				</div>
		</div>

		<div id='objective' class='qn_area'>
			<div class='o_qn_group'>
				<div class="form-group">
					<label class="QuestionLabel" for="question">Question</label>
					<textarea class="o_question question form-control" ></textarea>
				</div>

				<div class='obj_ans'>
				<div class="row objField">
					<div class="col-md-12">
						<label class="objectiveAnswer" for="objectives">Answer</label>
						<div class="input-group ans">
							  <input type="text" class="objk form-control" placeholder="Answer"></input>
							 <span class="input-group-addon">
								<input value='1' class='radio' type="radio">
							</span>
							<span class="removeObjFieldDiv input-group-addon"><a class="removeObjField btn btn-xs btn-warning"><i class="fa fa-times"> </i> </a></span>
						</div><!-- /input-group -->
				 	</div>
				</div>

				<div class="row objField">
					<div class="col-md-12">
						<label class="objectiveAnswer" for="objectives">Answer</label>
						<div class="input-group ans">
							  <input type="text" class="objk form-control" placeholder="Answer"></input>
							 <span class="input-group-addon">
								<input value='1' class='radio'type="radio"/>
							</span>
							<span class="removeObjFieldDiv input-group-addon"><a class="removeObjField btn btn-xs btn-warning"><i class="fa fa-times"> </i> </a></span>
						</div><!-- /input-group -->
				  		</div>
					</div>
				</div>
				<div class="form-group">
					<button type="button" class='addObj'  class="btn btn-default"><i class='fa fa-plus'> </i> Add an Objective</button>
				</div>
			</div>
		</div>

	<div id='structured' class='qn_area'>
		<div class='s_qn_group'>
				<div class="form-group">
					<label class="QuestionLabel" for="question">Question</label>
					<textarea class="struct_qn form-control question"></textarea>
				</div>

				<div class="form-group">
					<label class="answerLabel" for="answer">Answer</label>
					<textarea class="struct_ans form-control" ></textarea>
				</div>
		</div>
	</div>

	<div id='multiple_choice' class='qn_area'>
		<div class='m_qn_group'>
				<div class="form-group">
					<label class="QuestionLabel" for="question">Question</label>
					<textarea class="form-control question multi_qn" ></textarea>
				</div>

		<div class='m_ans_grp'>
			<div class="row multi_fld">
				<div class="col-md-12">
					<label class="multi_ans">Answer</label>
					<div class="input-group ans">
						<input type="text" class="mult form-control" placeholder="Answer"></input>
						<span class="input-group-addon">
							<input value='1' class='check' type="checkbox">
						</span>
						<span class="removeObjFieldDiv input-group-addon"><a class="removeObjField btn btn-xs btn-warning"><i class="fa fa-times"> </i> </a></span>
					</div>
				 </div>
			</div>

			<div class="row multi_fld">
				<div class="col-md-12">
					<label class="multi_ans" for="multi_sel">Answer</label>
					<div class="input-group ans">
						<input type="text" class="mult form-control" placeholder="Answer"></input>
						<span class="input-group-addon">
							<input value='1' class='check' type="checkbox">
						</span>
						<span class="removeObjFieldDiv input-group-addon"><a class="removeObjField btn btn-xs btn-warning"><i class="fa fa-times"> </i> </a></span>
					</div>
				 </div>
			</div>
		</div>
		<div class="form-group">
					<button type="button" class='addChk'  class="btn btn-default"><i class='fa fa-plus'> </i> Add an Option</button>
		</div>
	</div>
	</div>

	<div id='missing_letters' class='qn_area'>
		<div class='ml_qn_group row'>
			<div class='col-sm-4 form-group'>
				<input type='text' class='inc_word' placeholder='Incomplete Word'>
			</div>

			<div class='ml_ans col-sm-4 form-group'>
				<input type='text' class='comp_word' placeholder='Full Word'>
			</div>
		</div>
	</div>

	<div id='rearrange' class='qn_area'>
			<div class='r_qn_group row'>
					<div class='col-sm-4 form-group'>
						<input type='text' class='ra_jumbled' placeholder='Jumbled Word'>
					</div>

					<div class='r_ans_group col-sm-4 form-group'>
						<input type='text' class='ra_correct' placeholder='Correct Word'>
					</div>
			</div>
	</div>
			
	<div class="form-group">
			<button type="button" class="btn btn-primary" id='add_qn_btn'>New Question</button>
			<button type="submit" class="btn btn-success">Save</button>
	</div>
</form>
								
<form name="EditQandAForm" class="EditQandAForm" id="EditQandAForm" method="post">
    <div class="form-group">
        <label class="instrunctionLabel" for="instruction">Instruction</label>
    <textarea class="form-control" id="instructione" name='instruction'></textarea>
    </div>
    <div class="questionPanel">		
		<div class="form-group">
					<label class="QuestionLabele" for="questione">Question</label>
					<textarea name="question" id="questione" class="form-control" ></textarea>
				</div>
				<div class="form-group">
					<label class="questionTypeLabele" for="questionType">Question Type</label>
					<select name="questionType" id="questionTypee" class="form-control">
						<option class='0' value="0">Select Question Type</option>
						<option class='2'  value="2">Structured</option>
						<option class='1' value="1">Objective</option>
					</select>
				</div>
				</div>
					
				
				
				<div class="answerPanel">
				
				<div class="form-group structuredField">
					<label class="answerLabele" for="answer">Answer</label>
					<textarea id="answere" class="form-control" ></textarea>
				</div>
				<div class="objectiveFields">
							
				</div>
					<div class="form-group">
					<button type="button" class="addObj btn btn-default"><i class='fa fa-plus'> </i> Add an Objective</button>
					</div>
					<div class="form-group">
					<button type="submit" class="btn btn-success">Save</button>
					</div>
					
				</div>
				</form>
				
				
				
				
				</div>
				<div class="col-md-6">
				<button class='addQuestionBtn btn btn-primary'>Add a question</button>
				<br>
				<h4 class="page-header">Available Questions and Answers</h4>
				<br>
				<table class="questionList table table-hover" style='width:100%;'>
				
				</table>
				</div>
				</div>
				   <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			
			</div>
			
      </div>

	</div>		
	</div>		
	</div>		     
 <script src="js/activityCrud.js"></script>   
