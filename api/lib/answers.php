<?php

function add_answer()
{
	if(check_admin())
		{
			if(isset($_POST['question']) && !empty($_POST['question']) && isset($_POST['answer']) && !empty($_POST['answer']) && isset($_POST['ans']) && !empty($_POST['ans']))
			{
				$db=connect_db();
				$qn=sanitize($db,$_POST['question']);
				$admin=sanitize($db,$_SESSION['user']);
				$find_contributing=$db->query("SELECT a.admin_id FROM questions AS qn JOIN quizes AS q ON qn.quiz=q.quiz_id JOIN lessons AS l ON q.lesson=l.lesson_id JOIN topics AS t ON l.topic=t.topic_id JOIN themes_units AS tu ON tu.theme_id=t.unit_theme_id JOIN tutors AS tr ON tr.tutor_id=tu.tutor JOIN admin AS a ON a.admin_id=tr.admin_id WHERE qn.qn_id='$qn' AND q.status='1' AND t.status='1' AND tu.status='1' LIMIT 1");

				if(!$find_contributing)
					{
						die($db->error);
					}
				
				else
					{
						if($find_contributing->num_rows>0)
							{
								if($find_contributing->fetch_assoc()['admin_id']==$_SESSION['user'] || $_SESSION['previlege']==1)
								{
									if(is_array($_POST['answer']))
									{
										$msg='';
										$ans_added=array();
										$add_answer=$db->prepare("INSERT INTO answers (answer,question,ans_status) VALUES (?,?,?)");
										foreach ($_POST['answer'] as $idx => $ans) 
										{
											$answer=sanitize($db,$ans['answer']);
											$ans_status=sanitize($db,$ans['ans']);

											$add_answer->bind_param('sii',$rans,$rqn,$rstatus);

											if(!$add_answer->execute())
											{
												die($db->error);
												$msg="Some errors occured";
											}

											else
											{
												if($db->insert_id)
												{
													array_push($ans_added,$db->insert_id);
												}
											}
										}
										$add_answer->close();
										echo json_encode(array('status'=>'success','message'=>$msg,'added'=>$ans_added));
									}

									else
									{
										$answer=sanitize($db,$_POST['answer']);
										$ans_status=sanitize($db,$_POST['ans']);
										$add_answer=$db->query("INSERT INTO answers (answer,question,ans_status) VALUES ('$answer','$qn','$ans_status')");

										if(!$add_answer)
										{
											die($db->error);
										}
										
										else
											{
												if($db->insert_id)
												{
													echo json_encode(array('status'=>'success','message'=>'Answer added successfully'));
												}
												
												else
													{
														echo json_encode(array('status'=>'failed','message'=>'Answer not added'));
													}
											}
									}
								}
								else
								{
									echo json_encode(array('status'=>'failed','message'=>'You dont have enough rights to process this request'));
								}
							}
							else
							{
								echo json_encode(array('status'=>'failed','message'=>'The topic or quiz does not exist'));
							}
					}
			}

			else
			{
				echo json_encode(array('status'=>'failed','message'=>'Please fill in all details'));
			}
		}

		else
		{
			echo json_encode(array('status'=>'failed','message'=>'You dont have enough rights to process this request'));
		}
}

function edit_answer($id)
{
	if(check_admin())
		{
			if(isset($_POST['question']) && !empty($_POST['question']) && isset($_POST['answer']) && !empty($_POST['answer']) && isset($_POST['ans']) && !empty($_POST['ans']))
			{
				$db=connect_db();
				$qn=sanitize($db,$_POST['question']);
				$admin=sanitize($db,$_SESSION['user']);
				$find_contributing=$db->query("SELECT a.admin_id FROM questions AS qn JOIN quizes AS q ON qn.quiz=q.quiz_id JOIN lessons AS l ON q.lesson=l.lesson_id JOIN topics AS t ON l.topic=t.topic_id JOIN themes_units AS tu ON tu.theme_id=t.unit_theme_id JOIN tutors AS tr ON tr.tutor_id=tu.tutor JOIN admin AS a ON a.admin_id=tr.admin_id WHERE qn.qn_id='$qn' AND q.status='1' AND t.status='1' AND tu.status='1' LIMIT 1");

				if(!$find_contributing)
					{
						die($db->error);
					}
				
				else
					{
						if($find_contributing->num_rows>0)
							{
								if($find_contributing->fetch_assoc()['admin_id']==$_SESSION['user'] || $_SESSION['previlege']==1)
								{
									$answer=sanitize($db,$_POST['answer']);
									$ans_status=sanitize($db,$_POST['ans']);
									$id=sanitize($db,$id);
									$edit_answer=$db->query("UPDATE answers SET answer='$answer',question='$qn',ans_status='$ans_status' WHERE ans_id='$id'");

									if(!$edit_answer)
										{
											die($db->error);
										}
										
										else
											{
												if($db->affected_rows>0)
												{
													echo json_encode(array('status'=>'success','message'=>'Answer edited successfully'));
												}
												
												else
													{
														echo json_encode(array('status'=>'failed','message'=>'Answer not edited'));
													}
											}
								}
								else
								{
									echo json_encode(array('status'=>'failed','message'=>'You dont have enough rights to process this request'));
								}
							}
							else
							{
								echo json_encode(array('status'=>'failed','message'=>'The topic or quiz does not exist'));
							}
					}
			}

			else
			{
				echo json_encode(array('status'=>'failed','message'=>'Please fill in all details'));
			}
		}

		else
		{
			echo json_encode(array('status'=>'failed','message'=>'You dont have enough rights to process this request'));
		}
}

function fetch_answer($id='',$qn='')
{
	if(isset($id) && !empty($id))
	{

	}

	else if(isset($qn) && !empty($id))
	{
		
	}

}

function delete_answer($id)
{
	if(check_admin())
		{
			$id=sanitize($db,$id);
			$admin=sanitize($db,$_SESSION['user']);
			$find_contributing=$db->query("SELECT a.admin_id FROM answers AS ans JOIN questions AS qn ON ans.question=qn.qn_id JOIN quizes AS q ON qn.quiz=q.quiz_id JOIN lessons AS l ON q.lesson=l.lesson_id JOIN topics AS t ON l.topic=t.topic_id JOIN themes_units AS tu ON tu.theme_id=t.unit_theme_id JOIN tutors AS tr ON tr.tutor_id=tu.tutor JOIN admin AS a ON a.admin_id=tr.admin_id WHERE ans.ans_id='$id' AND ans.status='1' AND q.status='1' AND t.status='1' AND tu.status='1' LIMIT 1");

				if(!$find_contributing)
					{
						die($db->error);
					}
				
				else
					{
						if($find_contributing->num_rows>0)
							{
								if($find_contributing->fetch_assoc()['admin_id']==$_SESSION['user'] || $_SESSION['previlege']==1)
								{
									$delete_answer=$db->query("UPDATE answers SET status='0' WHERE ans_id='$id'");
									if(!$delete_answer)
									{
										die($db->error);
									}
									else
									{
										if($delete_answer->affected_rows>0)
										{
											echo json_encode(array('status'=>'success','message'=>'Answer deleted successfully'));
										}

										else
										{
											echo json_encode(array('status'=>'success','message'=>'Answer delete failed'));
										}
									}
								}

								else
								{
									echo json_encode(array('status'=>'success','message'=>'You dont have the rights to this question'));
								}
							}

							else
							{
								echo json_encode(array('status'=>'success','message'=>'Answer doesnt exist'));
							}
					}
		}
}

?>