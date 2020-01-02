<?php

function add_quiz()
{
	if(check_admin())
	{
		if(isset($_POST['lesson']) && !empty($_POST['lesson']) && isset($_POST['quizName']) && !empty($_POST['quizName']))
		{
			$db=connect_db();
			$lesson=sanitize($db,$_POST['lesson']);
			$admin=sanitize($db,$_SESSION['user']);
			$find_contributing=$db->query("SELECT l.lesson_id,a.admin_id FROM lessons AS l JOIN topics AS t ON l.topic=t.topic_id JOIN themes_units AS tu ON tu.theme_id=t.unit_theme_id JOIN tutors AS tr ON tr.tutor_id=tu.tutor JOIN admin AS a ON a.admin_id=tr.admin_id WHERE l.lesson_id='$lesson' AND t.status='1' AND tu.status='1' LIMIT 1");

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
						$quiz_name=sanitize($db,$_POST['quizName']);
						$add_quiz=$db->query("INSERT INTO quizes (quiz_name,lesson,date_created) VALUES ('$quiz_name','$lesson',CURRENT_DATE)");

						if(!$add_quiz)
							{
								die($db->error);
							}

						else
							{
								if($db->insert_id)
									{
										echo json_encode(array('status'=>'success','message'=>'Quiz added successfully'));
									}

									else
										{
											echo json_encode(array('status'=>'failed','message'=>'Quiz not added successfully'));
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
					echo json_encode(array('status'=>'failed','message'=>'Quiz or topic not found'));
				}
			}
			$db->close();

		}

		else
		{
			echo json_encode(array('status'=>'failed','message'=>'Please fill in all details'));
		}
	}
	else
	{
		echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
	}
}

function edit_quiz($id)
{
	if(check_admin())
	{
		if(isset($_POST['lesson']) && !empty($_POST['lesson']) && isset($_POST['quizName']) && !empty($_POST['quizName']))
		{
			$db=connect_db();
			$lesson=sanitize($db,$_POST['lesson']);
			$admin=sanitize($db,$_SESSION['user']);
			$quiz=sanitize($db,$id);
			$find_contributing=$db->query("SELECT l.lesson_id FROM lessons AS l JOIN topics AS t ON l.topic=t.topic_id JOIN themes_units AS tu ON tu.theme_id=t.unit_theme_id JOIN tutors AS tr ON tr.tutor_id=tu.tutor JOIN admin AS a ON a.admin_id=tr.admin_id WHERE l.lesson_id='$lesson' AND a.admin_id='$admin' AND l.status='1'  AND t.status='1' AND tu.status='1' LIMIT 1");

			if(!$find_contributing)
			{
				die($db->error);
			}
			else
			{
				if($find_contributing->num_rows>0 || $_SESSION['previlege']==1)
				{
					$quiz_name=sanitize($db,$_POST['quizName']);
					$edit_quiz=$db->query("UPDATE quizes SET quiz_name='$quiz_name',lesson='$lesson' WHERE quiz_id='$quiz'");

					if(!$edit_quiz)
					{
						die($db->error);
					}

					else
					{
						if($db->affected_rows>0)
						{
							echo json_encode(array('status'=>'success','message'=>'Quiz edited successfully'));
						}

						else
						{
							echo json_encode(array('status'=>'failed','message'=>'Quiz not edited successfully'));
						}
					}
				}
				else
				{
					echo json_encode(array('status'=>'failed','message'=>'You dont have enough rights to process this request'));
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
		echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
	}
}

function fetch_quiz($id='',$lesson='')
{
	$sql='';
	$db=connect_db();
	if(isset($id) && !empty($id))
	{
		$id=sanitize($db,$id);
		$sql=$db->query("SELECT quiz_id,quiz_name FROM quizes WHERE quiz_id='$id' AND status='1'");
	}

	else if(isset($lesson) && !empty($lesson))
	{
		$id=sanitize($db,$lesson);
		$sql=$db->query("SELECT q.quiz_id,q.quiz_name FROM quizes AS q JOIN lessons AS l ON q.lesson=l.lesson_id WHERE l.lesson_id='$lesson' AND q.status='1' AND l.status='1'");
	}

	if(!$sql)		
	{
		die($db->error);
	}

	else
	{
		echo json_encode($sql->fetch_all(MYSQLI_ASSOC));
	}
	$db->close();
}

function delete_quiz($id)
{
	if(check_admin())
	{
		if(!empty($id))
		{
			$db=connect_db();
			$admin=sanitize($db,$_SESSION['user']);
			$quiz=sanitize($db,$id);
			$find_contributing=$db->query("SELECT t.topic_id FROM quizes AS q JOIN lessons AS l ON q.lesson=l.lesson_id JOIN topics AS t ON t.topic_id=l.topic JOIN themes_units AS tu ON tu.theme_id=t.unit_theme_id JOIN tutors AS tr ON tr.tutor_id=tu.tutor JOIN admin AS a ON a.admin_id=tr.admin_id WHERE q.quiz_id='$id' AND a.admin_id='$quiz' AND t.status='1' AND tu.status='1' LIMIT 1");

			if(!$find_contributing)
			{
				die($db->error);
			}
			else
			{
				if($find_contributing->num_rows>0 || $_SESSION['previlege']==1)
				{
					$edit_quiz=$db->query("UPDATE quizes SET status='0' WHERE quiz_id='$quiz'");

					if(!$edit_quiz)
					{
						die($db->error);
					}

					else
					{
						if($db->affected_rows>0)
						{
							echo json_encode(array('status'=>'success','message'=>'Quiz deleted successfully'));
						}

						else
						{
							echo json_encode(array('status'=>'failed','message'=>'Quiz not deleted successfully'));
						}
					}
				}
				else
				{
					echo json_encode(array('status'=>'failed','message'=>'You dont have enough rights to process this request'));
				}
			}
			$db->close();
		}

		else
		{
			echo json_encode(array('status'=>'failed','message'=>'Please provide in all required fields'));
		}
	}
	else
	{
		echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
	}
}

function set_up_quiz($id)
{
	if(isset($id) && !empty($id))
	{
		$db=connect_db();
		$fetch_quiz=$db->query("SELECT quiz_id,quiz_name FROM quizes WHERE quiz_id='$id'");
		if(!$fetch_quiz)
		{
			die($db->error);
		}

		else
		{
			$res=$fetch_quiz->fetch_assoc();
			$quiz_arr=array();
			$quiz_arr['id']=$res['quiz_id'];
			$quiz_arr['name']=$res['quiz_name'];
			$quiz_arr['questions']=array();

			$app=\Slim\Slim::getInstance();
				$page_count=10;
				$start=0;
				if($app->request()->params('qn_count'))
				{
					$page_count=$app->request()->params('qn_count');
				}

				$fetch_max=$paginate=$db->query("SELECT MAX(i.instruction_id) AS max_id,MIN(i.instruction_id) AS min_id,COUNT(i.instruction_id) AS total fROM questions AS qn JOIN instructions AS i ON qn.instruction_grp=i.instruction_id JOIN quizes AS q ON q.quiz_id=i.quiz WHERE q.quiz_id='$id' AND q.status=1 AND i.status=1");
				if(!$fetch_max)
				{
					die($db->error);
				}
				else
				{
					$page_res=$fetch_max->fetch_assoc();
					$quiz_arr['total']=$page_res['total'];
					$quiz_arr['max']=$page_res['max_id'];
					$quiz_arr['min']=$page_res['min_id'];
				}

				if(strcmp($app->request()->params('dir'),'prev')==0)
				{
					$start=$app->request()->params('from')+1;
					$paginate=$db->query("SELECT i.instruction_id fROM questions AS qn JOIN instructions AS i ON qn.instruction_grp=i.instruction_id JOIN quizes AS q ON q.quiz_id=i.quiz WHERE q.quiz_id='$id' AND i.instruction_id<'$start' AND q.status=1 AND i.status=1 ORDER BY i.instruction_id DESC LIMIT $page_count");
				}
				else
				{
					if($app->request()->params('from'))
						{
							$start=$app->request()->params('from')-1;
						}
					$paginate=$db->query("SELECT DISTINCT i.instruction_id fROM questions AS qn JOIN instructions AS i ON qn.instruction_grp=i.instruction_id JOIN quizes AS q ON q.quiz_id=i.quiz WHERE q.quiz_id='$id' AND i.instruction_id>'$start' AND q.status=1 AND i.status=1 ORDER BY i.instruction_id LIMIT $page_count");
				}

				if(!$paginate)
				{
					die($db->error);
				}

				else
				{
					$arr=$paginate->fetch_all();
					if(strcmp($app->request()->params('dir'),'prev')==0)
					{
						$arr=array_reverse($arr);
					}
					foreach ( $arr AS $res)
					{
						array_push($quiz_arr['questions'],$res[0]);
					}
				}
			echo json_encode($quiz_arr);
		}
	}
}
?>