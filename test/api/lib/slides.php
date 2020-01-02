<?php
	function add_slides()
	{
		if(isset($_POST['SlideName']) && !empty($_POST['SlideName']) && isset($_POST['LessonName']) && !empty($_POST['LessonName']))
		{
			$db=connect_db();
			$name=sanitize($db,$_POST['SlideName']);
			$lesson=sanitize($db,$_POST['LessonName']);

			$add_slide=$db->query("INSERT INTO slide (slide_name,lesson) VALUES ('$name','$lesson')");
			if(!$add_slide)
			{
				die($db->error);
			}

			else
				{
					$slide_id=$db->insert_id;
					$template='../resources/slides/template.html';
					$fle=file_get_contents($template);

					if(!is_dir('../resources/slides/'.$lesson))
						{
							mkdir('../resources/slides/'.$lesson,755,true);
						}

					$file_name='../resources/slides/'.$lesson.'/'.$slide_id.".html";
					$file_handle=fopen($file_name,'w');

					if($file_handle)
					{
						if(fwrite($file_handle, $fle))
						{
							$add_content=$db->query("UPDATE slide SET url='$file_name' WHERE slide_id='$slide_id'");
							fclose($file_handle);
						}
					}
					

					echo json_encode(array("status"=>"success","message"=>"Slide created Successfully"));
				}
			$db->close();
		}
		else
		{
			echo json_encode(array('status'=>'fail','message'=>'fill In all fields'));
		}

	}

	function edit_slide($id)
	{
		if(isset($_POST['SlideName']) && !empty($_POST['SlideName']) && isset($id) && !empty($id))
		{
			$db=connect_db();

			$id=sanitize($db,$id);
			$slide_name=sanitize($db,$_POST['SlideName']);
			$edit_slide=$db->query("UPDATE slide SET slide_name='$slide_name' WHERE slide_id='$id'");

			if(!$edit_slide)
			{
				die($db->error);
			}
			else
			{
				if(isset($_POST['editorx']) && !empty($_POST['editorx']))
					{
						$fetch_url=$db->query("SELECT url,lesson FROM slide WHERE slide_id='$id' LIMIT 1");
						if(!$fetch_url)
							{
								die($db->error);
							}
					
						else
							{
								if($fetch_url->num_rows>0)
									{
										$res=$fetch_url->fetch_assoc();

										$url=$res['url'];
										$lesson=$res['lesson'];
										
										if(empty($url))
											{
												if(!is_dir('../resources/slides/'.$lesson))
													{
														mkdir('../resources/slides/'.$lesson,755,true);
													}

													$file_name='../resources/slides/'.$lesson.'/'.$id.".html";
													$file_handle=fopen($file_name,'w') or die("Failed to open file");
													fwrite($file_handle, $_POST['editorx']);
													fclose($file_handle);

													$fle=$file_name;
													$add_content=$db->query("UPDATE slide SET url='$fle' WHERE slide_id='$id'");

													if(!$add_content)
														{
															die($db->error);
														}

														else
															{
																echo json_encode(array("status"=>"success","message"=>"Content added Successfully"));
															}
											}
							
											else
												{

													if(!is_dir(dirname($url)))
													{
														mkdir(dirname($url),755,true);
													}

													$file_handle=fopen($url,'w') or die("Failed to open file");
													fwrite($file_handle, $_POST['editorx']);
													fclose($file_handle);
													echo json_encode(array("status"=>"success","message"=>"Content edited successfuly"));
												}
									}
						}
					}
					
					else
					{
						if($db->affected_rows>0)
							{
								echo json_encode(array("status"=>'success','message'=>'Partial changes made'));
							}
							
							else
								{
									echo json_encode(array("status"=>'success','message'=>'No changes made'));
								}
					}
			}
		}
		
		else
		{
			echo json_encode(array("status"=>'failed','message'=>'Fill in all details'));
		}
	}

	/*function edit()
	{
		if(isset($_POST['editorx']) && !empty($_POST['editorx']) && isset($_POST['slide_no']) && !empty($_POST['slide_no']))
		{
			$db=connect_db();
			$content=$_POST['editorx'];
			$id=sanitize($db,$_POST['slide_no']);
			
			if(!is_dir('../resources/slides'))
			{
				mkdir('../resources/slides',755,true);
			}

			$file_name='../resources/slides/'.$id.".html";
			$file_handle=fopen($file_name,'w') or die("Failed to open file");
			fwrite($file_handle, $content);
			fclose($file_handle);

			$fle=$file_name;
			$add_content=$db->query("UPDATE slide SET url='$fle' WHERE slide_id='$id'");

			if(!$add_content)
			{
				die($db->error);
			}

			else
			{
				echo json_encode(array("status"=>"success","message"=>"Content added Successfully"));
			}
			$db->close();
		}
	}

	function edit_content($id)
	{
		$db=connect_db();

		$fetch_url=$db->query("SELECT url FROM slide WHERE slide_id='$id'");

		if(!$fetch_url)
		{
			die($db->error);
		}

		else
		{
			$url='../resources/slides/'.end(explode('/',$fetch_url->fetch_assoc()['url']));
			$content=$_POST['editorx'];

			$file_handle=fopen($url,'w') or die("Failed to open file");
			fwrite($file_handle, $content);
			fclose($file_handle);
			echo json_encode(array("status"=>"success","message"=>"Content edited successfuly"));
		}
		$db->close();
	}*/

	function fetch_slides($id='',$lesson='')
	{
		$db=connect_db();
		$sql='';
		if(!empty($id))
		{
			$id=sanitize($db,$id);
			$sql=$db->query("SELECT s.slide_id,s.slide_name,l.name,t.topic_name,s.slide_details,s.url FROM slide AS s JOIN lessons AS l ON l.lesson_id=s.lesson JOIN topics AS t ON t.topic_id=l.topic WHERE s.slide_id='$id' AND l.status='1' AND s.status='1' AND t.status='1'");
		}

		else if(!empty($lesson))
		{
			$lesson=sanitize($db,$lesson);
			$sql=$db->query("SELECT s.slide_id,s.slide_name,l.name,t.topic_name,s.slide_details,s.url FROM slide AS s JOIN lessons AS l ON l.lesson_id=s.lesson JOIN topics AS t ON t.topic_id=l.topic WHERE l.lesson_id='$lesson' AND s.status='1' AND l.status='1' AND t.status='1'");
		}

		else
		{
			$sql=$db->query("SELECT s.slide_id,s.slide_name,l.name,t.topic_name,s.slide_details,s.url FROM slide AS s JOIN lessons AS l ON l.lesson_id=s.lesson JOIN topics AS t ON t.topic_id=l.topic WHERE s.status='1' AND l.status='1' AND t.status='1'");
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

	function delete_slide($id)
	{
		$db=connect_db();

		if(isset($id) && !empty($id))
		{
			$id=sanitize($db,$id);
			$sql=$db->query("UPDATE slide SET status='0' WHERE slide_id='$id'");
			if(!$sql)
				{
					die($db->error);
				}

				else
				{
					if($db->affected_rows>0)
					{
						echo json_encode(array('status'=>'success','message'=>'Slide Successfully deleted'));
					}
					else
					{
						echo json_encode(array('status'=>'failed','message'=>'Deleted failed'));	
					}
				}
		
			$db->close();
		}
	}

?>