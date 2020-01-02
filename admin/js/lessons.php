<?php
	function add_lesson()
	{
		$db=connect_db();

		if(isset($_POST['LessonName']) && !empty($_POST['LessonName']) && isset($_POST['topicName']) && !empty($_POST['topicName']))
		{
			$name=sanitize($db,$_POST['LessonName']);
			$topic=sanitize($db,$_POST['topicName']);

			$add_lesson=$db->query("INSERT INTO lessons (name,topic) VALUES ('$name','$topic')");
			if(!$add_lesson)
				{
					die($db->error);
				}

				else
					{
						$lesson=$db->insert_id;
						$fetch_lesson=$db->query("SELECT l.lesson_id,t.topic_id,l.name,t.topic_name FROM lessons AS l JOIN topics AS t ON t.topic_id=l.topic WHERE l.lesson_id='$lesson'");

						if(!$fetch_lesson)
							{
								die($db->error);
							}

							else
								{
									echo json_encode($fetch_lesson->fetch_assoc());
								}
					}
					$db->close();
		}

		else
		{
			echo json_encode(array('status'=>'fail','message'=>'fill In all fields'));
		}
	}

	function fetch_lessons($id='',$topic='')
	{
		$db=connect_db();

		$pageSize=10;
		$start=0;
		$pageCount=10;
		$pagination=false;

		$app = Slim\Slim::getInstance();

		if($app->request()->params('pagesize'))
			{
				$pageSize=$app->request()->params('pagesize');
			}

		if($app->request()->params('from'))
			{
				$start=($app->request()->params('from'));
				$start=$start-1;
				if($start<0)
				{
					$start=0;
				}
			}

		if($app->request()->params('pageCount'))
			{
				$pageCount=$app->request()->params('pageCount');
			}

		if(strcmp($app->request()->params('pages'),'true')==0)
			{
				$pagination=true;
			}

		$sql="";

		if(!empty($id))
		{
			$id=sanitize($db,$id);
			$sql=$db->query("SELECT l.lesson_id,t.topic_id,l.name,t.topic_name FROM lessons AS l JOIN topics AS t ON t.topic_id=l.topic WHERE l.lesson_id='$id' AND l.status='1' LIMIT 1");
		}

		else if(!empty($topic))
		{
			if($pagination==true)
				{
					$total=$db->query("SELECT COUNT(l.lesson_id) AS total FROM lessons AS l JOIN topics AS t ON t.topic_id=l.topic WHERE t.topic_id='$topic' AND t.status='1' AND l.status='1'");

					$total_recs=0;
					if(!$total)
					{
						die($db->error);
					}

					else
					{
						$total_recs=$total->fetch_assoc()['total'];
					}

					$sql=$db->prepare("SELECT l.lesson_id FROM lessons AS l JOIN topics AS t ON t.topic_id=l.topic WHERE t.topic_id='$topic' AND t.status='1' AND l.status='1' ORDER BY l.lesson_id ASC LIMIT ?,1");

					$idx=$start;
					$paginated=array();

					for($i=$start;$i<$start+$pageCount;$i++)
					{
						if($idx<$total_recs)
						{
							$sql->bind_param('i',$lmt);
							$lmt=$idx;

							if(!$sql->execute())
								{
									die($db->error);
								}

								else
									{
										$res=$sql->get_result();
										array_push($paginated,$res->fetch_assoc()['lesson_id']);
									}
							$idx=$idx+$pageSize;
						}
						else
						{
							break;
						}
					}
					$sql->close();
					$db->close();
					echo json_encode($paginated);
					exit();
				}

				else
				{
					$sql=$db->query("SELECT l.lesson_id,t.topic_id,l.name,t.topic_name FROM lessons AS l JOIN topics AS t ON t.topic_id=l.topic WHERE t.topic_id='$topic' AND t.status='1' AND l.status='1' ORDER BY l.lesson_id DESC LIMIT $start,$pageSize");
				}

			if(!$sql)
				{
					die($db->error);
				}

				else
				{
					echo json_encode($sql->fetch_all(MYSQL_ASSOC));
					$db->close();
				}

		}

		else
		{
			if($pagination==true)
				{
					$total=$db->query("SELECT COUNT(l.lesson_id) AS total FROM lessons AS l JOIN topics AS t ON t.topic_id=l.topic WHERE t.status='1' AND l.status='1'");

					$total_recs=0;
					if(!$total)
					{
						die($db->error);
					}

					else
					{
						$total_recs=$total->fetch_assoc()['total'];
					}

					$sql=$db->prepare("SELECT l.lesson_id FROM lessons AS l JOIN topics AS t ON t.topic_id=l.topic WHERE t.status='1' AND l.status='1' ORDER BY l.lesson_id ASC LIMIT ?,1");

					$idx=$start;
					$paginated=array();

					for($i=$start;$i<$start+$pageCount;$i++)
					{
						if($idx+$pageSize<$total_recs)
						{
							$sql->bind_param('i',$lmt);
							$lmt=$idx;

							if(!$sql->execute())
								{
									die($db->error);
								}

								else
									{
										$res=$sql->get_result();
										array_push($paginated,$res->fetch_assoc()['lesson_id']);
									}
							$idx=$idx+$pageSize;
						}
						else
						{
							break;
						}
					}
					$sql->close();
					$db->close();
					echo json_encode($paginated);
					exit();
				}

				else
				{
					$sql=$db->query("SELECT l.lesson_id,t.topic_id,l.name,t.topic_name FROM lessons AS l JOIN topics AS t ON t.topic_id=l.topic WHERE t.status='1' AND l.status='1' ORDER BY l.lesson_id DESC LIMIT $start,$pageSize");
				}

			if(!$sql)
				{
					die($db->error);
				}

				else
				{
					echo json_encode($sql->fetch_all(MYSQL_ASSOC));
					$db->close();
				}
		}
	}

	function edit_lessons($id)
	{
		
		if(isset($_POST['LessonName']) && !empty($_POST['LessonName']) && isset($_POST['topicName']) && !empty($_POST['topicName']))
		{
			$db=connect_db();
			$name=sanitize($db,$_POST['LessonName']);
			$topic=sanitize($db,$_POST['topicName']);

			$add_subject=$db->query("UPDATE lessons SET name='$name',topic='$topic' WHERE lesson_id='$id'");
			if(!$add_subject)
				{
					die($db->die($db->error));
				}

				else
					{

						$fetch_lesson=$db->query("SELECT l.lesson_id,t.topic_id,l.name,t.topic_name FROM lessons AS l JOIN topics AS t ON t.topic_id=l.topic WHERE l.lesson_id='$id'");
						if(!$fetch_lesson)
							{
								die($db->error);
							}

							else
								{
									echo json_encode($fetch_lesson->fetch_assoc());
								}
					}
			$db->close();
		}

		else
		{
			echo json_encode(array('status'=>'fail','message'=>'fill In all fields'));
		}
	}

	function delete_lessons($id)
	{
		if(isset($id) && !empty($id))
		{
			$db=connect_db();
			$id=sanitize($db,$id);

			$delete_lesson=$db->query("UPDATE lessons SET status='0' WHERE lesson_id='$id'");
			if(!$delete_lesson)
			{
				die($db->error);
				$db->close();
			}

			else
			{
				if($db->affected_rows>0)
				{
					$db->close();
					echo json_encode(array('status'=>'success','message'=>'Lesson deleted successfully'));
				}
				else
				{
					$db->close();
					echo json_encode(array('status'=>'success','message'=>'Lesson failed to delete'));
				}
			}
		}
	}

?>