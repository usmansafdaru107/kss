<?php
	function add_lesson()
	{
		$db=connect_db();
		if(check_admin()){
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
		else{
			echo json_encode(array("status"=>"failed","message"=>"Please login to continue"));
		}
		
	}

function fetch_lessons($id='',$topic='')
	{
		$db=connect_db();
		$sql="";
		
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

		if(!empty($id))
		{
			$id=sanitize($db,$id);
			$sql=$db->query("SELECT l.lesson_id,t.topic_id,l.name,t.topic_name FROM lessons AS l JOIN topics AS t ON t.topic_id=l.topic WHERE l.lesson_id='$id' AND l.status='1' LIMIT 1");
			if(!$sql)
				{
					die($db->error);
				}

				else
				{
					echo json_encode($sql->fetch_all(MYSQLI_ASSOC));
					$db->close();
					exit();
				}
		}

		else if(!empty($topic))
		{
			if($pagination==true)
				{
					$page=paginate_lessons($db,$topic,$app,$start,$pageSize);
					echo json_encode($page);
					exit();
				}

				else
				{
					$start=$start-1;
					$sql=$db->query("SELECT l.lesson_id,t.topic_id,l.name,t.topic_name FROM lessons AS l JOIN topics AS t ON t.topic_id=l.topic WHERE t.topic_id='$topic' AND l.lesson_id>'$start' AND t.status='1' AND l.status='1' ORDER BY l.lesson_id ASC LIMIT $pageSize");
					if(!$sql)
					{
						die($db->error);
					}

					else
						{
							echo json_encode($sql->fetch_all(MYSQLI_ASSOC));
							$db->close();
							exit();
						}
				}
		}

		else
		{
			if($pagination==true)
				{
					$page=paginate_lessons($db,0,$app,$start,$pageSize);
					echo json_encode($page);
					exit();
				}

				else
				{
					$sql=$db->query("SELECT l.lesson_id,t.topic_id,l.name,t.topic_name FROM lessons AS l JOIN topics AS t ON t.topic_id=l.topic WHERE t.status='1' AND l.status='1' ORDER BY l.name ASC LIMIT $start,$pageSize");
					if(!$sql)
						{
							die($db->error);
						}

						else
						{
							echo json_encode($sql->fetch_all(MYSQLI_ASSOC));
							$db->close();
							exit();
						}
				}
		}
}

function edit_lessons($id)
	{
		if(check_admin()){
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
		else{
			echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
		}
	}

function delete_lessons($id)
	{
		if(check_admin()){
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
		}else{
			echo json_encode(array("status"=>"failed","message"=>"Please login to continue"));
		}
	}

function paginate_lessons($db,$topic_id=0,$slim_instance='',$start=0,$pageSize=10,$pageCount=10)
	{
		$page=array();
		$topic_state=false;
		$dir=1;
		$max=0;

		if(strcmp($slim_instance->request()->params('dir'),'prev')==0)
		{
			$dir=0;
		}

		if(isset($topic_id) && !empty($topic_id))
		{
			$total=$db->prepare("SELECT MAX(l.lesson_id) AS max_id,MIN(l.lesson_id) AS min_id,COUNT(l.lesson_id) AS total_recs FROM lessons AS l JOIN topics AS t ON t.topic_id=l.topic WHERE t.topic_id=? AND t.status='1' AND l.status='1'");
			$total->bind_param('i',$tot);
			$tot=sanitize($db,$topic_id);
		}
		else
		{
			$total=$db->prepare("SELECT MAX(l.lesson_id) AS max_id,MIN(l.lesson_id) AS min_id,COUNT(l.lesson_id) AS total_recs FROM lessons AS l JOIN topics AS t ON t.topic_id=l.topic WHERE t.status='1' AND l.status='1'");
		}
		$total_recs=0;
		if(!$total->execute())
		{
			die($db->error);
		}

		else
		{
			$page_res=$total->get_result()->fetch_assoc();
			$page['total']=$page_res['total_recs'];
			$max=$page['max']=$page_res['max_id'];
			$min=$page['min']=$page_res['min_id'];

			if($start<$min || $start==$min)
			{
				$start=$min-1;
			}
		}

		if(isset($slim_instance) && !empty($slim_instance) && $dir==0 && $topic_state==true)
		{
			$start=$slim_instance->request()->params('from')+1;
			$paginate=$db->prepare("SELECT MIN(l.lesson_id) AS lesson_id FROM lessons AS l JOIN topics AS t ON t.topic_id=l.topic WHERE t.topic_id=? AND t.topic_id<? AND t.status='1' AND l.status='1' ORDER BY l.lesson_id DESC LIMIT ?");
		}

		else if(isset($slim_instance) && !empty($slim_instance) && $dir!=0 && $topic_state==true || !isset($slim_instance) || empty($slim_instance))
		{
			$paginate=$db->prepare("SELECT MIN(l.lesson_id) AS lesson_id FROM lessons AS l JOIN topics AS t ON t.topic_id=l.topic WHERE t.topic_id=? AND t.topic_id>? AND t.status='1' AND l.status='1' ORDER BY l.lesson_id ASC LIMIT ?");
		}

		else if(isset($slim_instance) && !empty($slim_instance) && $dir==0 && $topic_state==false)
		{
			$start=$slim_instance->request()->params('from')+1;
			$paginate=$db->prepare("SELECT MAX(l.lesson_id) AS lesson_id FROM lessons AS l JOIN topics AS t ON t.topic_id=l.topic WHERE l.lesson_id<? AND t.status='1' AND l.status='1' ORDER BY l.lesson_id DESC LIMIT ?");
		}

		else if(isset($slim_instance) && !empty($slim_instance) && $dir!=0 && $topic_state==false || !isset($slim_instance) || empty($slim_instance))
		{
			$paginate=$db->prepare("SELECT MIN(l.lesson_id) AS lesson_id FROM lessons AS l JOIN topics AS t ON t.topic_id=l.topic WHERE l.lesson_id>? AND t.status='1' AND l.status='1' ORDER BY l.lesson_id ASC LIMIT ?");
		}

		if($topic_state==true)
		{
			$paginate->bind_param('iii',$topc,$strt,$cnt);
			$topc=$topic;
		}

		else
		{
			$paginate->bind_param('ii',$strt,$cnt);
		}
		$cnt=$pageSize;
		$page['pages']=array();
		for($i=0;$i<$pageCount;$i++)
		{
			$strt=$start;
			if(!$paginate->execute())
				{
					die($db->error);
				}
			else
			{
				$res=$paginate->get_result()->fetch_assoc()['lesson_id'];
				if(is_null($res) || $res>=$max)
				{
					break;
				}
				else
				{
					array_push($page['pages'],$res);
					if($dir==0)
					{
						$start-=$cnt;
					}
					else
					{
						$start+=$cnt;
					}
				}
			}
		}
		if($dir==0)
			{
				$page['pages']=array_reverse($page['pages']);
			}
		return $page;
		$paginate->close();
		$db->close();
	}
?>