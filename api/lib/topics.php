<?php
function add_topic()
{
	if(check_admin()){
		if(isset($_POST['topicName']) && !empty($_POST['topicName']) && isset($_POST['unitName']) && !empty($_POST['unitName']))
		{
			$db=connect_db();
			$name=sanitize($db,$_POST['topicName']);
			$theme=sanitize($db,$_POST['unitName']);

			$add_topic=$db->query("INSERT INTO topics (topic_name,unit_theme_id) VALUES ('$name','$theme')");
			if(!$add_topic)
				{
					die($db->error);
				}

				else
					{
						$topic=$db->insert_id;

						if(isset($_FILES['topicLogo']) && $_FILES['topicLogo']['size']>0)
							{
								$dest='resources/images';
								$accepted=array("JPG","JPEG","PNG","png","jpeg","jpg");
								$file=$_FILES['topicLogo'];

								$res=upload_image($file,$dest,$accepted);
								if($res['status']===1)
									{
										$res_dest=$res['message'];
										$update_pic=$db->query("UPDATE topics SET image='$res_dest' WHERE topic_id='$topic'");

										if(!$update_pic)
											{
												$dest="../resources/images/default_topic.png";
												$update_pic=$db->query("UPDATE topics SET image='$dest' WHERE topic_id='$topic'");

												if(!$update_pic)
													{
														die($db->error);
													}
											}
									}
							}

							else
								{
									$dest="../resources/images/default_topic.png";
									$update_pic=$db->query("UPDATE topics SET image='$dest' WHERE topic_id='$topic'");

									if(!$update_pic)
										{
											die($db->error);
										}
								}

								$fetch_topic=$db->query("SELECT t.topic_id,tu.theme_id,t.topic_name,tu.theme_name,t.image FROM topics AS t JOIN themes_units AS tu ON tu.theme_id=t.unit_theme_id WHERE t.topic_id='$topic'");

								if(!$fetch_topic)
									{
										die($db->error);
									}

									else
										{
											echo json_encode($fetch_topic->fetch_assoc());
										}
					}
				$db->close();
		}

		else
		{
			echo json_encode(array('status'=>'failed','message'=>'Please fill all required fields'));
		}
	}
	else{
		echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
	}
}

function fetch_topics($id='',$theme='')
{
	$db=connect_db();

	$app = Slim\Slim::getInstance();
	$start=0;
	$pageSize=10;
	if($app->request()->params('pagesize'))
		{
			$pageSize=$app->request()->params('pagesize');
		}

	if($app->request()->params('from'))
		{
			$start=($app->request()->params('from'));
		}

	$sql="";
	if(!empty($id))
	{
		$sql=$db->query("SELECT t.topic_id,tu.theme_id,t.topic_name,tu.theme_name,t.image FROM topics AS t JOIN themes_units AS tu ON tu.theme_id=t.unit_theme_id WHERE t.topic_id='$id' AND t.status='1' AND tu.status='1'");
	}
	else if(!empty($theme))
	{
		if(strcmp($app->request()->params('pages'),'true')==0)
			{
				$page_count=10;
				if($app->request()->params('count'))
				{
					$page_count=$app->request()->params('count');
				}

				$sql=$db->query("SELECT COUNT(topic_id) AS total FROM topics WHERE unit_theme_id='$theme' AND unit_theme_id>'$start'");
				if(!$sql)
					{
						die($db->error);
					}
				
				else
					{
						$total=$sql->fetch_assoc()['total'];
						$page_count=$total/$pageSize;

						$paginated=array();
						$max=0;
						$sql=$db->prepare("SELECT t.topic_id AS tid FROM topics AS t JOIN themes_units AS th ON th.theme_id=t.unit_theme_id WHERE t.topic_id>? AND th.theme_id='$theme' ORDER BY t.topic_id ASC LIMIT $pageSize");
						for($i=0;$i<$page_count;$i++)
						{
							$sql->bind_param('i',$max);
							if(!$sql->execute())
							{
								die($db->error);
							}
							else
							{
								$res=$sql->get_result();
								$max=$res->fetch_all(MYSQLI_ASSOC);
								print_r($max);
								array_push($paginated,$max);
								$res->free_result();
							}
						}
						$sql->close();
						//echo json_encode($paginated);
						$db->close();
						exit();
					}
			}

			else
			{
				$sql=$db->query("SELECT t.topic_id,tu.theme_id,t.topic_name,tu.theme_name,t.image FROM topics AS t JOIN themes_units AS tu ON tu.theme_id=t.unit_theme_id WHERE t.topic_id>'$start' AND tu.theme_id='$theme' AND t.status='1' AND tu.status='1' LIMIT $pageSize");
			}
	}

	else
	{
		if(strcmp($app->request()->params('pages'),'true')==0)
			{
				$sql=$db->query("SELECT COUNT(topic_id) AS total FROM topics WHERE unit_theme_id>'$start'");
				if(!$sql)
					{
						die($db->error);
					}
				
				else
					{
						$total=$sql->fetch_assoc()['total'];
						echo json_encode(paginate($total,$pageSize,$start));
						$db->close();
						exit();
					}
			}

			else
			{
				$sql=$db->query("SELECT t.topic_id,tu.theme_id,t.topic_name,tu.theme_name,t.image FROM topics AS t JOIN themes_units AS tu ON tu.theme_id=t.unit_theme_id WHERE t.status='1' AND tu.status='1' AND t.topic_id>'$start' LIMIT $pageSize");
			}
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

function edit_topics($id)
{
	if(check_admin()){
		if(isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['theme']) && !empty($_POST['theme']))
		{
			$db=connect_db();
			$name=sanitize($db,$_POST['name']);
			$theme=sanitize($db,$_POST['theme']);

			$add_subject=$db->query("UPDATE topics SET topic_name='$name',unit_theme_id='$theme' WHERE topic_id='$id'");
			if(!$add_subject)
				{
					die($db->error);
					$db->close();
				}

				else
					{
						if(isset($_FILES['topicLogo']) && $_FILES['topicLogo']['size']>0)
							{
								$dest='resources/images';
								$accepted=array("JPG","JPEG","PNG","png","jpeg","jpg");
								$file=$_FILES['topicLogo'];

								$res=upload_image($file,$dest,$accepted);
								if($res['status']===1)
									{
										$res_dest=$res['message'];
										$update_pic=$db->query("UPDATE topics SET image='$res_dest' WHERE topic_id='$id'");
									}
							}
						fetch_topics($id);
					}
		}

		else
		{
			echo json_encode(array('status'=>'failed','message'=>'Please fill all the required fields'));
		}
	}else{
		echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
	}
}

function delete_topic($id)
{
	if(check_admin()){
		if(isset($id) && !empty($id))
		{
			$db=connect_db();
			$id=sanitize($db,$id);

			$check_topic=$db->query("SELECT topic_id FROM topics WHERE topic_id='$id' AND status='1' LIMIT 1");
			if(!$check_topic)
			{
				die($db->error);
			}
			else
			{
				if($check_topic->num_rows>0)
				{
					$delete_topic=$db->query("UPDATE topics SET status='0' WHERE topic_id='$id'");
					if($db->affected_rows>0)
					{
						echo json_encode(array('status'=>'success','message'=>'Topic deleted successfully'));
					}
					else
					{
						echo json_encode(array('status'=>'failed','message'=>'Delete failed'));
					}
				}
				else
				{
					echo json_encode(array('status'=>'failed','message'=>'Selected topic not available'));
				}
			}
		}
		else
		{
			echo json_encode(array('status'=>'failed','message'=>'Please provide a valid Id'));
		}
	}else{
		echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
	}
}

?>