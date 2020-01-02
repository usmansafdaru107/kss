<?php

function add_question()
{
	if(check_admin())
		{
			if(isset($_POST['instruction']) && isset($_POST['quiz']) && !empty($_POST['quiz']) && isset($_POST['question']) && !empty($_POST['question']) && isset($_POST['qnType']) && !empty($_POST['qnType']))
			{
				$db=connect_db();
				$quiz=sanitize($db,$_POST['quiz']);
				$admin=sanitize($db,$_SESSION['user']);
				$find_contributing=$db->query("SELECT t.topic_id,a.admin_id FROM quizes AS q JOIN lessons AS l ON q.lesson=l.lesson_id JOIN topics AS t ON l.topic=t.topic_id JOIN themes_units AS tu ON tu.theme_id=t.unit_theme_id JOIN tutors AS tr ON tr.tutor_id=tu.tutor JOIN admin AS a ON a.admin_id=tr.admin_id WHERE q.quiz_id='$quiz' AND q.status='1' AND t.status='1' AND tu.status='1' LIMIT 1");

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
									$question=sanitize($db,$_POST['question']);
									$instruction=sanitize($db,$_POST['instruction']);
									$question_type=sanitize($db,$_POST['qnType']);

									$add_instruction=$db->query("INSERT INTO instructions (instruction,quiz,qn_type) VALUES ('$instruction','$quiz','$question_type')");

									if(!$add_instruction)
									{
										die($db->error);
									}

									else
									{
										if($db->insert_id)
										{
											$ans='';
											$res='';
											if(isset($_POST['answers']) || !empty($_POST['answers']) || isset($_POST['answers']) && !empty($_POST['answers']))
											{
												$ans=$_POST['answers'];
											}

											if(isset($_POST['resources']) || !empty($_POST['resources']) || isset($_POST['resources']) && !empty($_POST['resources']))
											{
												$res=$_POST['resources'];
											}
											add_qns($_POST['question'],$ans,$db->insert_id,$db,$res);

											echo json_encode(array('status'=>'success','message'=>'Question Added successfully'));
										}
										else
										{
											echo json_encode(array('status'=>'failed','message'=>'Question not added successfully'));
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

function edit_question($id)
{
	if(check_admin())
		{
			if(isset($id) && !empty($id) && isset($_POST['question']) && !empty($_POST['question']) && isset($_POST['qnType']) && !empty('qnType'))
			{
				$db=connect_db();
				$id=sanitize($db,$id);

				$admin=sanitize($db,$_SESSION['user']);
				$find_contributing=$db->query("SELECT t.topic_id,a.admin_id FROM instructions AS qn JOIN quizes AS q ON qn.quiz=q.quiz_id JOIN lessons AS l ON l.lesson_id=q.lesson JOIN topics AS t ON l.topic=t.topic_id JOIN themes_units AS tu ON tu.theme_id=t.unit_theme_id JOIN tutors AS tr ON tr.tutor_id=tu.tutor JOIN admin AS a ON a.admin_id=tr.admin_id WHERE qn.instruction_id='$id' AND qn.status='1' AND q.status='1' AND t.status='1' AND l.status='1' AND tu.status='1' LIMIT 1");

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
										$instruction='';
										$qn_type=sanitize($db,$qn_type);

										if(isset($_POST['instruction']) && !empty($_POST['instruction']))
											{
												$instruction=sanitize($db,$_POST['instruction']);
											}

										$get_qn_type=$db->query("SELECT qn_type FROM instructions WHERE instruction_id='$id'");
										if(!$get_qn_type)
										{
											die($db->error);
										}

										else
										{
											$or_type=$get_qn_type->fetch_assoc()['qn_type'];
										}
									
									$update_qn=$db->query("UPDATE instructions SET quiz='$quiz', qn_type='$qn_type',instruction='$instruction' WHERE instruction_id='$id'");
									if(!$update_qn)
										{
											die($db->error);
										}
										
										else
											{
												if(strcmp($qn_type,$or_type)==0)
												{
													if(isset($_POST['question']) && !empty($_POST['question']) && is_string($_POST['question']))
														{
															if($qn=json_decode($_POST['question']))
															{
																$update_qn=$db->prepare("UPDATE questions SET question=? WHERE instruction_id=? AND qn_id=?");
																foreach ($qn as $idx => $qnr)
																{
																	$update_qn->bind_param('sii',$qn_txt,$instr,$qn_id);
																	$qn_txt=$qnr->question;
																	$qn_id=$qnr->id;
																	$instr=$id;

																	if(!$update_qn->execute())
																		{
																			die($db->error);
																		}
																}
																$update_qn->close();
															}
														}
												}

												else
												{
													$delete_qn=$db->query("UPDATE questions SET status='0' WHERE instruction_grp='$id'");
													if(!$delete_qn)
													{
														die($db->error);
													}
													else
													{
														$delete_ans=$db->query("UPDATE answers AS a JOIN questions AS q ON a.question=q.qn_id JOIN instructions AS i ON i.instruction_id=q.instruction_grp SET a.status='0' WHERE i.instruction_id='$id'");	
														if(!$delete_ans)
														{
															die($db->error);
														}
													}

													if(isset($_POST['question']) && !empty($_POST['question']) && isset($_POST['answers']) && !empty($_POST['answers']))
													{
														$resource='';
														if(isset($_POST['resources']) && !empty($_POST['resources']))
														{
															$resource=$_POST['resources'];
														}

														add_qns($_POST['question'],$_POST['answers'],$id,$db,$resources);
													}

												}
												echo json_encode(array('status'=>'success','message'=>'Question edited successfully'));
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
				echo json_encode(array('status'=>'failed','message'=>'here Please fill in all details'));
			}
		}

		else
		{
			echo json_encode(array('status'=>'failed','message'=>'You dont have enough rights to process this request'));
		}
}

function fetch_question($id='',$quiz='')
{
	$db=connect_db();
	if(isset($id) && !empty($id))
	{
		$id=sanitize($db,$id);
		$fetch_qn=$db->query("SELECT instruction_id,instruction,qn_type FROM instructions WHERE instruction_id='$id' AND status='1'");
		if(!$fetch_qn)
		{
			die($db->error);
		}

		else
		{
			if($fetch_qn->num_rows>0)
			{
				echo json_encode($fetch_qn->fetch_assoc());
			}
			else
			{
				echo json_encode(array());
			}
		}
	}

	else if(isset($quiz) && !empty($quiz)) 
	{
		$quiz=sanitize($db,$quiz);
		$app = Slim\Slim::getInstance();

		$fetch_quiz=$db->query("SELECT quiz_id,quiz_name FROM quizes WHERE quiz_id='$quiz' AND status='1'");

		if(!$fetch_quiz)
		{
			die($db->error);
		}

		else
		{
			if($fetch_quiz->num_rows>0)
			{
				$res=$fetch_quiz->fetch_assoc();
				$quiz_arr=array();
				$quiz_id=$res['quiz_id'];
				$quiz_arr['quiz_id']=$quiz_id;
				$quiz_arr['quiz_name']=$res['quiz_name'];
				$fetch_qns=$db->query("SELECT i.instruction_id,i.instruction,i.qn_type FROM instructions AS i JOIN quizes AS q ON q.quiz_id=i.quiz WHERE i.quiz='$quiz' AND q.status='1'");
				if(strcmp($app->request()->params('pagination'),'true')==0)
					{
						$pagesize=10;
						$start=0;
						if($app->request()->params('pagesize'))
							{
								$pagesize=$app->request()->params('pagesize');
							}

						if($app->request()->params('from'))
							{
								$start=($app->request()->params('from')-1);
							}

						if(strcmp($app->request()->params('fields'),'id')==0)
							{
								$fetch_qns=$db->query("SELECT i.instruction_id FROM instructions AS i JOIN quizes AS q ON q.quiz_id=i.quiz WHERE q.quiz='$quiz' AND q.status='1' AND i.status='1' LIMIT $start,$pagesize");
							}
							else
							{
								$fetch_qns=$db->query("SELECT i.instruction_id,i.instruction,i.qn_type FROM instructions AS i JOIN quizes AS q ON q.quiz_id=i.quiz WHERE i.quiz='$quiz' AND q.status='1' AND i.status='1' LIMIT $start,$pagesize");
							}
					}

				if(!$fetch_qns)
				{
					die($db->error);
				}
				else
				{
					$quiz_arr['questions']=$fetch_qns->fetch_all(MYSQLI_ASSOC);
				}
				echo json_encode($quiz_arr);
			}
		}
	}
	$db->close();
}

function set_up_qn($id)
{
	$db=connect_db();

	if(isset($id) && !empty($id))
	{
		$id=sanitize($db,$id);
		$ins_query=$db->query("SELECT instruction_id,instruction,qn_type FROM instructions WHERE instruction_id='$id' AND status='1' LIMIT 1");
		if(!$ins_query)
		{
			die($db->error);
		}
		else
		{
				$res=$ins_query->fetch_assoc();
				$instruction=$res['instruction_id'];
				$qn_arr=array();
				$qn_arr['instruction_id']=$instruction;
				$qn_arr['instruction']=$res['instruction'];

				switch ($res['qn_type']) {
					case 1:
							$qn_arr['qn_type']='Objective';
							break;
					case 2:
							$qn_arr['qn_type']='Structured';
							break;
					case 3:
							$qn_arr['qn_type']='Multiple Choice';
							break;
					case 4:
							$qn_arr['qn_type']='Missing letters';
							break;
					case 5:
							$qn_arr['qn_type']='Rearrange';
							break;
				}

				$qn_arr['questions']=array();

				$qn_sel=$db->query("SELECT qn_id,question FROM questions WHERE instruction_grp='$instruction' AND status='1'");
				if(!$qn_sel)
				{
					die($db->error);
				}

				else
				{
					$qns=$qn_sel->fetch_all(MYSQLI_ASSOC);

					foreach($qns AS $qnr)
					{	
						$qn=array();
						$qn_id=$qnr['qn_id'];
						$qn['qn_id']=$qn_id;
						$qn['question']=$qnr['question'];

						$qn['resources']=array();
						$qn['answers']=array();

						if($res['qn_type']!=4 && $res['qn_type']!=5)
						{
							$qns_sel=$db->query("SELECT a.ans_id,a.answer,a.ans_status FROM answers AS a JOIN questions AS q ON a.question=q.qn_id WHERE q.qn_id='$qn_id' AND q.status='1' AND a.status='1'");
							if(!$qns_sel)
								{
									die($db->error);
								}

								else
									{
										$qn['answers']=$qns_sel->fetch_all(MYSQLI_ASSOC);
									}
						}
						
						$res_sql=$db->query("SELECT r.qn_res,r.display_txt FROM qn_resources AS r JOIN questions AS q ON q.qn_id=r.qn JOIN resources AS rsc ON rsc.resource_id=r.res WHERE q.qn_id='$qn_id' AND q.status='1' AND r.status='1' AND rsc.status='1'");
						if(!$res_sql)
								{
									die($db->error);
								}

						else
							{
								$qn_arr['resources']=$res_sql->fetch_all(MYSQLI_ASSOC);
							}
							array_push($qn_arr['questions'],$qn);
					}

					$db->close();
					echo json_encode($qn_arr);
				}
		}
	}
}

function delete_question($id)
{
	if(check_admin())
		{
			if(isset($id) && !empty($id))
			{
				$db=connect_db();
				$id=sanitize($db,$id);
				$find_contributing=$db->query("SELECT t.topic_id,a.admin_id FROM instructions AS qn JOIN quizes AS q ON qn.quiz=q.quiz_id JOIN lessons AS l ON l.lesson_id=q.lesson JOIN topics AS t ON t.topic=t.topic_id JOIN themes_units AS tu ON tu.theme_id=t.unit_theme_id JOIN tutors AS tr ON tr.tutor_id=tu.tutor JOIN admin AS a ON a.admin_id=tr.admin_id WHERE qn.instruction_id='$id' AND qn.status='1' AND q.status='1' AND t.status='1' AND tu.status='1' LIMIT 1");

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
									$delete_ins=$db->query("UPDATE instructions SET status='0' WHERE instruction_id='$id'");

									if(!$delete_ins)
									{
										die($db->error);
									}

									$delete_qn=$db->query("UPDATE questions SET status='0' WHERE instruction_grp='$id'");
									if(!$delete_qn)
										{
											die($db->error);
										}
										
										else
											{
												if($db->affected_rows>0)
												{
													$del_ans=$db->query("UPDATE answers AS a JOIN questions AS q SET a.status='0' WHERE q.instruction_grp='$id'");
													if(!$del_ans)
													{
														die($db->error);
													}

													$del_res=$db->query("UPDATE qn_resources AS qrs JOIN questions AS q SET qrs.status='0' WHERE q.instruction_grp='$id'");
													if(!$del_res)
													{
														die($db->error);
													}
													echo json_encode(array('status'=>'success','message'=>'Question deleted successfully'));
												}
												
												else
													{
														echo json_encode(array('status'=>'failed','message'=>'Question delete failed'));
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

function add_qns($question,$answer,$instruction,$db,$resources='')
{
	if(isset($question) && !empty($question) && is_string($question))
		{
			if($qns=json_decode($question))
			{
				$qn_query=$db->prepare("INSERT INTO questions (question,instruction_grp) VALUES (?,?)");
				foreach($qns AS $idx=>$qn_base)
				{
					$qn_query->bind_param('si',$qn_str,$instr);
					$qn_str=$qn_base->question;
					$instr=$instruction;
					if(!$qn_query->execute())
						{
							die($db->error);
						}

						else
							{
								$qn_id=$db->insert_id;
								ans_add($qn_id,$qn_base->answers,$db);
								add_res($qn_base->resources,$qn_id,$db);
							}
				}
			}

			else
			{
				$add_question=$db->query("INSERT INTO questions (question,instruction_grp) VALUES ('$question','$instruction')");
				if(!$add_question)
					{
						die($db->error);
					}
										
					else
	 					{
							if($db->insert_id)
							{
								//echo json_encode(array($_POST['answers']));
								$qn=$db->insert_id;
								ans_add($qn,$answer,$db);
								add_res($resources,$qn,$db);
								echo json_encode(array('status'=>'success','message'=>'Question added successfully','question'=>$qn));
							}
												
							else
								{
									echo json_encode(array('status'=>'failed','message'=>'Question not added'));
								}
						}
			}
		}
}

function ans_add($qn,$answers,$db,$status=1)
{
	if(isset($answers) && !empty($answers) && is_string($answers))
		{
			$msg='';
			if($anss=json_decode($answers))
			{
				$add_answer=$db->prepare("INSERT INTO answers (answer,question,ans_status) VALUES (?,?,?)");
				foreach ($anss as $idx => $ans) 
				{
					$add_answer->bind_param('sii',$answer,$question,$status);
					$answer=sanitize($db,$ans->answer);
					$question=$qn;
					$status=sanitize($db,$ans->status);
	
					if(!$add_answer->execute())
						{
							die($db->error);
	 					}
				}
				$add_answer->close();
			}
			else if(isset($answers) && !empty($answers))
			{
				$answer=sanitize($db,$answers);
				$ans_status=sanitize($db,$status);
				$add_answer=$db->query("INSERT INTO answers (answer,question,ans_status) VALUES ('$answers','$qn','$ans_status')");
				if(!$add_answer)
					{
						die($db->error);
					}
			}
		}
}

function add_res($res,$qn,$db)
{
	if(isset($res) && !empty(isset($res)) && is_string($res))
		{
			if($res=json_decode($res))
			{
				$add_resource=$db->prepare("INSERT INTO qn_resources (qn,res,display_txt) VALUES (???)");						
				foreach($res AS $rsc)
				{
					$add_resource->bind_param('iis',$qn_id,$res_id,$display_txt);
					$qn_id=$qn;
					$res_id=sanitize($db,$res->resource);
					$display_txt=sanitize($db,$res->text);

					if(!$add_resource->execute())
						{
							die($db->error);
						}
 				}
				$add_resource->close();
			}
		}
}
?>