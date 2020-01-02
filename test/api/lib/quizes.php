<?php

function add_quiz()
{
	session_start();
	if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['status']) && $_SESSION['status']==true && isset($_SESSION['account']) && $_SESSION['account']=='admin')
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
	session_start();
	if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['status']) && $_SESSION['status']==true && isset($_SESSION['account']) && $_SESSION['account']=='admin')
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
		echo json_encode($sql->fetch_all(MYSQL_ASSOC));
	}
	$db->close();
}

function delete_quiz($id)
{
	session_start();
	if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['status']) && $_SESSION['status']==true && isset($_SESSION['account']) && $_SESSION['account']=='admin')
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

				if($app->request()->params('from'))
				{
					$start=$app->request()->params('from')-1;
				}

				$paginate=$db->query("SELECT qn_id fROM questions WHERE quiz='$id' AND qn_id>'$start' AND status=1 ORDER BY qn_id LIMIT $page_count");
				if(!$paginate)
				{
					die($db->error);
				}

				else
				{
					foreach ($paginate->fetch_all() AS $res)
					{
						array_push($quiz_arr['questions'],$res[0]);
					}
				}
			echo json_encode($quiz_arr);
		}
	}
}
?>