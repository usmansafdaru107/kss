function getActivities(id){$('#ByLessonBtn').attr("value",id);var getActiviySettings={"type":"GET","async":!0,"dataType":"json","url":"../api/quiz/lesson/"+id,"headers":{"cache-control":"no-cache"}};$.ajax(getActiviySettings).success(function(response){$('.activityList').html("");var responsed=JSON.stringify(response);$.each(response,function(key,value){var appendData="<tr><td class='prevAcitity' data-target='"+value.quiz_id+"'>"+value.quiz_name+"</td>"+"<td><button value='"+value.quiz_id+"' data-target='#QandA' data-toggle='modal' class='QandA btn btn-default btn-xs'>?</button></td>"+"<td><button value='"+value.quiz_id+"' data-target='#QuizContent' data-toggle='modal' class='indQuiz btn btn-default btn-xs'><span class='fa fa-edit'></span></button></td>"+"<td><button value='"+value.quiz_id+"' class='indQuizDel btn btn-default btn-xs' data-target='#deleteQuiz' data-toggle='modal'><span class='fa fa-times'></span></button></td>"+"</tr>";$('.activityList').append(appendData)});$('.indQuiz').click(function(e){e.preventDefault();var valueX=$(this).attr("value");editQuiz(valueX,id)});$('.indQuizDel').click(function(e){e.preventDefault();var delValue=$(this).attr("value");delQuiz(delValue,id)});$('.QandA').click(function(e){e.preventDefault();var qValue=$(this).attr("value");$('.addQuestionBtn').attr("value",qValue);getQuestions(qValue)});$('.prevAcitity').click(function(e){e.preventDefault();var aValue=$(this).attr("data-target");prevActivity(aValue)});prevActivity($('.prevAcitity:first').attr("data-target"))})}
function getQuestions(id){var getQuestionSettings={"type":"GET","async":!0,"dataType":"json","url":"../api/question/quiz/"+id,"headers":{"cache-control":"no-cache"}};$.ajax(getQuestionSettings).success(function(response){$('.questionList').html("");var responsed=JSON.stringify(response);if(responsed.length<3){}
else{}
var fResponse=response.questions;$.each(fResponse,function(key,value){var appendData="<tr class='prevQuestion' data-target='"+value.instruction_id+"instruction_id'><td data-target='"+value.instruction_id+"'>"+value.instruction+"</td>"+"<td><button value='"+value.instruction_id+"' data-target='#QuizContent' data-toggle='modal' class='indQuiz btn btn-default btn-xs'><span class='fa fa-edit'></span></button></td>"+"<td><button value='"+value.instruction_id+"' class='indQuizDel btn btn-default btn-xs' data-target='#deleteQuiz' data-toggle='modal'><span class='fa fa-times'></span></button></td>"+"</tr>";$('.questionList').append(appendData)});$('#EditQandAForm').hide();$('.prevQuestion').click(function(e){e.preventDefault();if($('.prevQuestion').hasClass('btn-primary')){$('.prevQuestion').removeClass('btn-primary')}
var qnaId=$(this).attr("data-target");$(this).addClass('btn-primary');$('#AddQandAForm').hide(function(){$('#EditQandAForm').show(function(){editQandA(qnaId)})})})})}
$(function(){$('#AddQandAForm').hide();$('#ByLessonBtn').click(function(e)
{e.preventDefault();addActivity()});$('.addQuestionBtn').click(function(e)
{e.preventDefault();var qValue=$(this).attr("value");addQandA(qValue)});$("body").on('click','.removeObjFieldDiv',function()
{$(this).parent().parent().remove()})});function beforeSubmitAddA(){var lessonId=$('#ByLessonBtn').attr("value");var obj={};$('.QuizNameLabel').text("Activity Name");$('label').removeClass('text-danger');if(!minmax(3,100,"#addNewActivityForm #quizNameAdd","A Real Quiz name is required","#addNewActivityForm .QuizNameLabel")){obj.status=!1}
else{obj.status=!0}
var quizName=$('#quizNameAdd').val();var formx={"quizName":quizName,"lesson":lessonId};obj.postdata=formx;return obj}
function callBackMethodA(response){$('#addNewActivityForm .form-error').hide();if(response.status==="error"||response.status==="Error"||response.status==="Failed"||response.status==="failed"){$('#addNewActivityForm .form-error').fadeIn(function(){$(this).text("Sorry "+response.message+" "+response.errors)})}
else{notify("Activity added successfully","success")}
$('#addNewActivityForm')[0].reset();var lessonId=$('#ByLessonBtn').attr("value");getActivities(lessonId);var quizName="";var lessonId=""}
function addActivity()
{$("#addNewActivityForm").ajaxify({url:'../api/quiz',validator:beforeSubmitAddA,onSuccess:callBackMethodA})}
function editQuiz(quizId,lessonId){var getQuizByIdSettings={"async":!0,"dataType":"json","type":"GET","url":"../api/quiz/"+quizId,"headers":{"cache-control":"no-cache"}};$.ajax(getQuizByIdSettings).success(function(response){$('#editActivityForm #quizNameEdit').val(response[0].quiz_name)});function callBackMethod(response){$('#editActivityForm .form-error').hide();if(response.status==="error"||response.status==="Error"||response.status==="Failed"||response.status==="failed"||response.status==="fail"){notify("Sorry "+response.message+" "+response.errors,"error")}
else{$('#content-area').html("");var linked="activity.php";$('#content-area').load(linked,function(){$(".modal-backdrop").hide();$(".modal").modal("hide");getActivities(lessonId);notify("Quiz successfully updated","success");var quizId=""})}}
$("#editActivityForm").ajaxify({url:'../api/quiz/edit/'+quizId,validator:beforeSubmitEdit,onSuccess:callBackMethod});function beforeSubmitEdit(){var obj={};$('.ActivityNameLabel').text("Activity Name");$('label').removeClass('text-danger');if(!minmax(3,100,"#editActivityForm #quizNameEdit","A Valid Quiz name is required","#editActivityForm .ActivityNameLabel")){obj.status=!1}
else{obj.status=!0}
var quizName=$('#quizNameEdit').val();var formx={"quizName":quizName,"lesson":lessonId};obj.postdata=formx;return obj}}
function delQuiz(quizId,lessonId){$('.delQuizBtn').click(function(){var delQuizSettings={"type":"GET","async":!0,"dataType":"json","url":"../api/quiz/delete/"+quizId,"headers":{"cache-control":"no-cache"}};$.ajax(delQuizSettings).success(function(response){getActivities(lessonId);notify("Quiz Removed","warning");var quizId=""})})}
function loadPreview(url){$('.loadpInner').html("");$('.loadpInner').load(url)}
function beforeSubmitAddq()
{var obj={};var formx={};$('#AddQandAForm .QuestionLabel').text("Question");$('#AddQandAForm .questionTypeLabel').text("Question Type");$('#AddQandAForm .answerLabel').text("Answer");$('#AddQandAForm.objectiveAnswer').text("Objective Answer");var question=$('#question').val();var qnType=$('#AddQandAForm #questionType').val();var quizId=$('.addQuestionBtn').attr("value");var formx={"quiz":quizId,"qnType":qnType,"instruction":$('#instruction').val(),"question":new Array()};switch(qnType)
{case '1':$('.o_qn_group:visible').each(function()
{var question={}
var qn=$(this).find('.o_question').val();question.question=qn;question.answers=new Array();question.resources=new Array();var ans=$(this).find('.ans').find('.objk');var res=$(this).find('.qn_res').find('.res_itm');$(ans).each(function()
{var answer={};answer.answer=$(this).val();if($(this).parent().hasClass('selectedR'))
{answer.status=1}
else{answer.status=0}
question.answers.push(answer)});$(res).each(function()
{var resource={}});question.answers=JSON.stringify(question.answers);formx.question.push(question)});break;case '2':$('.s_qn_group:visible').each(function()
{var question={};question.question=$(this).find('.struct_qn').val();question.answers=new Array();var answer={};answer.answer=$(this).find('.struct_ans').val()
answer.status=1;question.answers.push(answer);question.answers=JSON.stringify(question.answers);question.resources=new Array();formx.question.push(question)});break;case '3':$('.m_qn_group:visible').each(function()
{var question={};question.question=$(this).find('.multi_qn').val();question.answers=new Array();question.resources=new Array();var ans=$(this).find('.m_ans_grp').find('.mult');var res=$(this).find('.qn_res').find('.res_itm');$(ans).each(function()
{var answer={};answer.answer=$(this).val();if($(this).parent().hasClass('selectedR'))
{answer.status=1}
else{answer.status=0}
question.answers.push(answer)});$(res).each(function()
{var resource={}});question.answers=JSON.stringify(question.answers);formx.question.push(question)});break;case '4':$('.ml_qn_group:visible').each(function()
{var question={};question.question=$(this).find('.inc_word').val();question.answers=new Array();question.resources=new Array();var ans=$(this).find('.comp_word');var res=$(this).find('.qn_res').find('.res_itm');$(ans).each(function()
{var answer={};answer.answer=$(this).val();answer.status=1;question.answers.push(answer)});$(res).each(function()
{var resource={}});question.answers=JSON.stringify(question.answers);formx.question.push(question)});break;case '5':$('.r_qn_group:visible').each(function()
{var question={};question.question=$(this).find('.ra_jumbled').val();question.answers=new Array();question.resources=new Array();var ans=$(this).find('.ra_correct');var res=$(this).find('.qn_res').find('.res_itm');$(ans).each(function()
{var answer={};answer.answer=$(this).val();answer.status=1;question.answers.push(answer)});$(res).each(function()
{var resource={}});question.answers=JSON.stringify(question.answers);formx.question.push(question)});break}
obj.status=!0;console.log(JSON.stringify(formx));formx.question=JSON.stringify(formx.question);obj.postdata=formx;return obj}
function callBackMethod(response){$('#AddQandAForm .form-error').hide();if(response.status==="error"||response.status==="Error"||response.status==="Failed"||response.status==="failed"){$('#AddQandAForm .form-error').fadeIn(function(){$(this).text("Sorry "+response.message+" "+response.errors)})}
else{notify("Question added successfully","success");$('#AddQandAForm')[0].reset();var quizId=$('.addQuestionBtn').attr("value");getQuestions(quizId);var question="";var qnType="";var objectives=""}}
function addQandA(quizId)
{$('#AddQandAForm .objectiveFields .addedFields').html('');$('#EditQandAForm').hide(function()
{$('#AddQandAForm').slideDown()});var objValue=2;dynamic_options();$('body').on('change','.radio',function()
{$(this).parent().parent().parent().parent().parent().find('.ans').removeClass('selectedR');$(this).parent().parent().parent().parent().parent().find('.radio:checked').prop("checked",!1);$(this).prop("checked",!0);$(this).parent().parent().addClass('selectedR')});$('body').on('change','.check',function()
{if($(this).parent().parent().parent().parent().parent().find('.check:checked').length===$(this).parent().parent().parent().parent().parent().find('.check').length)
{notify("No wrong answer Left","warning");$(this).prop("checked",!1)}
else{if($(this).prop("checked",!0))
{$(this).parent().parent().addClass('selectedR')}
else if($(this).prop("checked",!1))
{$(this).parent().parent().removeClass('selectedR')}}});$('.structuredField').hide();$('.objectiveFields').hide();$('body').on("change","#questionType",function()
{var valueChange=$('option:selected',this).attr('data-qnType');$(".qn_area").slideUp();$("#"+valueChange).slideDown()});$('#AddQandAForm')[0].reset();$('#AddQandAForm').addClass('console.log console.log-success');$("#AddQandAForm").ajaxify({url:'../api/question',validator:beforeSubmitAddq,onSuccess:callBackMethod})}
function editQandA(id)
{function beforeSubmitEditq()
{var obj={};$('#EditQandAForm .QuestionLabele').text("Question");$('#EditQandAForm .questionTypeLabele').text("Question Type");$('#EditQandAForm .answerLabele').text("Answer");$('#EditQandAForm .objectiveAnswere').text("Objective Answer");$('label').removeClass('text-danger');if(!minmax(2,100,"#EditQandAForm #questione","A valid question is required","#EditQandAForm .QuestionLabele"))
{obj.status=!1}
else if(!selectValid("#EditQandAForm #questionTypee","Please select a Question Type",".questionTypeLabele"))
{obj.status=!1}
else if(!$('#EditQandAForm #answere').attr("disabled")==!0&&!minmax(2,100,"#EditQandAForm #answere","A valid Anwser is required","#EditQandAForm .answerLabele"))
{obj.status=!1}
else if(!$('#EditQandAForm #objectivee1').attr("disabled")==!0&&!minmax(2,100,"#EditQandAForm #objectivee1","A Please Provide Objectives","#EditQandAForm .objectiveAnswere"))
{obj.status=!1}
else if(!$('#EditQandAForm #objectivee2').attr("disabled")==!0&&!minmax(2,100,"#EditQandAForm #objectivee2","A Please Provide Objectives","#EditQandAForm .objectiveAnswere"))
{obj.status=!1}
else if($('#EditQandAForm #objectivee3').length&&!$('#EditQandAForm #objectivee3').attr("disabled")==!0&&!minmax(2,100,"#EditQandAForm #objectivee3","A Please Provide Objectives","#EditQandAForm .objectiveAnswere"))
{obj.status=!1}
else if($('#EditQandAForm #objectivee4').length&&!$('#EditQandAForm #objectivee4').attr("disabled")==!0&&!minmax(2,100,"#EditQandAForm #objectivee4","A Please Provide Objectives","#EditQandAForm .objectiveAnswere"))
{obj.status=!1}
else{obj.status=!0}
var question=$('#questione').val();var qnType=$('#EditQandAForm #questionTypee').val();var instruction=$('#EditQandAForm #instructione').val();var objectiveTrue={};var checkedRadio=$('input[name="answer"]:checked','#EditQandAForm').val();var answer=[];$.each($('#EditQandAForm .ans'),function(){var x={};x.answer=$(this).find($('.objk')).val();if($(this).hasClass('selectedR')){console.log($(this).html());x.status=1}
else{x.status=0}
answer.push(x)});var formx={'qn_id':id,"instruction":instruction,"question":question};if($("#questionTypee").val()==1)
{var answer=[];$.each($('#EditQandAForm .ans'),function(){var x={};x.answer=$(this).find($('.objk')).val();if($(this).hasClass('selectedR')){x.status=1}
else{x.status=0}
answer.push(x)});formx.qnType=1;formx.instruction=instruction;formx.answers=JSON.stringify(answer);formx.qn_id=id}
else if($("#questionTypee").val()==2)
{formx.qnType=2;formx.qn_id=id;formx.instruction=instruction;formx.answer=$("#answere").val();formx.status=1}
obj.postdata=formx;console.log(JSON.stringify(formx));return obj}
function callBackMethodq(response){console.log("We are done for good");if(response.status==="error"||response.status==="Error"||response.status==="Failed"||response.status==="failed"){notify("Sorry "+response.message+" "+response.errors,"warning")}
else{notify("Question successfully Added","success");id='';getQuestions(id);question="";qnType="";objectives=""}}
$("#EditQandAForm").ajaxify({url:'../api/question/edit/'+id,validator:beforeSubmitEditq,onSuccess:callBackMethodq});$('.removeObjFieldDiv').hide();$('.objectiveFields .row:last .removeObjFieldDiv').show();var getQnASettings={"type":"GET","async":!0,"dataType":"json","url":"../api/question/load/"+id,"headers":{"cache-control":"no-cache"}};$.ajax(getQnASettings).success(function(response){var strinified=JSON.stringify(response);$('#questione').val(response.question);var justc=$('#questionTypee option.'+response.qn_type);justc.attr('selected',!0);if(response.qn_type=="2"){$('.objectiveFields').hide(function(){$('.structuredField').slideDown();$('.objectiveFields input').attr("disabled",!0);$('.structuredField #answere').attr("disabled",!1)});var answers=response.answers;$('#answere').val(answers[0].answer)}
else if(response.qn_type=="1"){$('.structuredField').hide(function(){$('.objectiveFields').slideDown();$('.objectiveFields input').attr("disabled",!1);$('.structuredField #answere').attr("disabled",!0)});var answers=response.answers;$('#EditQandAForm .objectiveFields').html('');$.each(answers,function(key,value){var rowObkect='<div class="row objField">'+'<div class="col-md-12">'+'<label class="objectiveAnswere" for="objectives">Objective Answer</label>'+'<div class="input-group ans">'+'<input type="text" class="objk form-control" value="'+value.answer+'" placeholder="Objective '+key+'"></input>'+'<span class="input-group-addon">'+'<input vclass="radio nd" type="radio">'+'</span>'+'<span class="removeObjFieldDiv input-group-addon">'+'<a class="removeObjField btn btn-xs btn-warning" href="'+key+'"><i class="fa fa-times"> </i> </a>'+'</span>'+'</div><!-- /input-group -->'+'</div>'+'</div>';$('#EditQandAForm .objectiveFields').append(rowObkect)});$('.removeObjFieldDiv').hide();$('.objectiveFields .row:last .removeObjFieldDiv').show();$('#EditQandAForm .removeObjField').click(function(e){var objValue=$(this).attr("data-value");e.preventDefault();if(objValue>0){objValue--}
else{objValue=0}
notify('You have removed this Field','success');var parentObj=$(this).parent().parent().parent().parent();parentObj.remove();$('#EditQandAForm .removeObjFieldDiv').hide();$('#EditQandAForm .objectiveFields .row:last .removeObjFieldDiv').show()})}});$('body').on("change","#questionTypee",function(){var valueChange=$('#questionTypee').val();if(valueChange=="2"){$('.objectiveFields').hide(function(){$('.structuredField').slideDown();$('.objectiveFields input').attr("disabled",!0);$('.structuredField #answere').attr("disabled",!1)})}
else if(valueChange=="1"){$('.structuredField').hide(function(){$('.objectiveFields').slideDown();$('.objectiveFields input').attr("disabled",!1);$('.structuredField #answere').attr("disabled",!0)})}
else{$('.structuredField').hide();$('.objectiveFields').hide()}})}
function prevActivity(id,from=0,start=0,dir=''){$('.loadpInner .answers-section').html('');$('.loadpInner h3.page-header').text('');$('.loadpInner .question-section').html('');var getactivityLoadSettings={"async":!0,"dataType":"json","type":"GET","url":"../api/quiz/setup/"+id+"?dir="+dir+"&from="+from,"headers":{"cache-control":"no-cache"}};$.ajax(getactivityLoadSettings).success(function(response){console.log(JSON.stringify(response));$('.pagitivity').attr('data-max',response.max);$('.pagitivity').attr('data-min',response.min);$.each(response,function(key,value){$('.loadpInner h3.page-header').text(response.name)});var quenId=response.questions;if(quenId.length>0)
{$('.pagitivity').html('');$.each(quenId,function(key,value){start++;var but='<button class="btn btn-default qpages" value="'+value+'">'+start+'</button>';$('.pagitivity').append(but)});var prev_btn="<button class='btn btn-default pb4' value='"+$('.qpages:first').val()+"'>Previous Questions</button>";$('.pagitivity').prepend(prev_btn);var next_btn="<button class='btn btn-default pnext' value='"+$('.qpages:last').val()+"'>More Questions</button>";$('.pagitivity').append(next_btn)}
$('.pagitivity .qpages').click(function(e){e.preventDefault();var buttonV=$(this).attr("value");getQNABy(buttonV)});getQNABy($('.qpages:first').val());$(".pagitivity .pnext").click(function()
{var max=$('.pagitivity').attr('data-max');if(max-$(this).val()>0)
{prevActivity(id,$(this).val(),parseInt($(".qpages:last").html()))}});$(".pagitivity .pb4").click(function()
{var min=$('.pagitivity').attr('data-min');if($(this).val()-min>0)
{prevActivity(id,$(this).val(),parseInt($(".qpages:first").html())-11,"prev")}});function getQNABy(id){var getQNAByseting={"async":!0,"dataType":"json","type":"GET","url":"../api/question/load/"+id,"headers":{"cache-control":"no-cache"}};$('.loadpInner .answers-section').html('');$('.loadpInner .question-section').html('');$.ajax(getQNAByseting).success(function(response){console.log(JSON.stringify(response));var qn_type=response.qn_type;$("#activity_flow").html("");$("#instruction_area").html(response.instruction);var idx='0';$.each(response.questions,function(idx,qn)
{var ans_area=$('<div class="answers-section">');var qn_cont=$("<div class='qn_cont'>");var qn_a=$("<div class='question-section'>");switch(qn_type)
{case "Objective":if(response.questions.length>1)
{qn_a.append($("<span class='qn-label'>").html(String.fromCharCode(97+idx)+") "))}
qn_a.append($("<span class='qn-label'>").html(qn.question));$.each(qn.answers,function(key,value)
{var ans=$("<div class='set_ans'>");ans.append($("<input class='ans_radio' type='radio'>"));ans.append("<span>"+value.answer+"</span>");ans_area.append(ans)});break;case "Multiple Choice":qn_a.html(qn.question);$.each(qn.answers,function(key,value)
{var ans=$("<div class='set_ans'>");ans.append("<label><input class='ans_radio' type='checkbox'><span class='ans_ans'>"+value.answer+"</span></label>");ans_area.append(ans)});break;case "Structured":var pat=/\#/gi;var str=qn.question;var res=str.replace(pat,"<input type='text' name='answers' class='strd_qn'>");qn_a.html(res);break;case "Missing letters":var pat=/\#/gi;var str=qn.question;var res=str.replace(pat,"<input type='text' name='answers' class='strd_qn'>");qn_a.addClass("float-qn");qn_a.html(res);ans_area.addClass('float-qn');break;case "Rearrange":qn_a.addClass("float-qn");qn_a.html(qn.question);ans_area.append($("<input type='text' name='answers' class='strd_qn'>"));ans_area.addClass('float-qn');break}
qn_cont.append(qn_a);qn_cont.append(ans_area);qn_cont.appendTo($("#activity_flow"));idx++})})}})}
function dynamic_options()
{$("body").on('click','.addObj',function(){var par=$(this).parent().parent().find(".obj_ans");var objValue=par.find(".ans").length;if(objValue<4){var objField='<div class="row objField">'+'<div class="col-md-12">'+'<label class="objectiveAnswer" for="objectives">Answer</label>'+'<div class="input-group ans">'+'<input type="text" class="objk form-control" placeholder="Answer"></input>'+'<span class="input-group-addon">'+'<input class="radio" type="radio">'+'</span>'+'<span class="removeObjFieldDiv input-group-addon">'+'<a class="removeObjField btn btn-xs btn-warning"><i class="fa fa-times"> </i> </a>'+'</span>'+'</div>'+'</div>'+'</div>'+'';par.append(objField)}
else if(objValue>=4)
{notify('You cannot add more than four objectives','warning')}});$("body").on('click','.addChk',function(){var par=$(this).parent().parent().find(".m_ans_grp");var objValue=par.find(".ans").length;if(objValue<5){var objField='<div class="row multi_fld">'+'<div class="col-md-12">'+'<label class="multi_ans" for="multi_sel">Answer</label>'+'<div class="input-group ans">'+'<input type="text" class="mult form-control" placeholder="Answer"></input>'+'<span class="input-group-addon">'+"<input value='1' class='check' type='checkbox'></span>"+'<span class="removeObjFieldDiv input-group-addon"><a class="removeObjField btn btn-xs btn-warning"><i class="fa fa-times"> </i> </a></span>'+'</div></div></div>'+'';par.append(objField)}
else if(objValue>=4)
{notify('You cannot add more than four Multiple choices','warning')}});$('#add_qn_btn').click(function()
{if($("#questionType").val()!=0)
{switch($('option:selected',"#questionType").attr('data-qnType'))
{case 'objective':var html='hjhhh';load_template("#objective","objectives");break;case 'structured':load_template("#structured","structured");break;case 'multiple_choice':load_template("#multiple_choice","multiple_choice");break;case 'missing_letters':load_template("#missing_letters","missing_letters");break;case 'rearrange':load_template("#rearrange","rearrange");break}}})}
function load_template(container,template)
{var url="templates/"+template+".html"
$.ajax({url:url,type:"GET",dataType:"html",success:function(res)
{$(container).append(res)}})}