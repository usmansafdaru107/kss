<?php
function add_slides()
{
	if(check_admin()){
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
	}else{
		echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
	}
}

function edit_slide($id)
{
	if(check_admin()){
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
	}else{
		echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
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
	if(check_admin() || check_sponsor()){
		$db=connect_db();
		$sql='';
		if(!empty($id))
		{
			$id=sanitize($db,$id);
			$sql=$db->query(" SELECT s.slide_id,s.slide_name,l.name,t.topic_name,s.slide_details,s.url FROM slide AS s JOIN lessons AS l ON l.lesson_id=s.lesson JOIN topics AS t ON t.topic_id=l.topic WHERE s.slide_id='$id' AND l.status='1' AND s.status='1' AND t.status='1'");
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
			echo json_encode($sql->fetch_all(MYSQLI_ASSOC));
		}
		$db->close();
	}
	elseif (check_student()) {
		//lesson/topic/theme/tutor/class_subject/class
		$db=connect_db();
		if(!empty($id)){
			$id=sanitize($db,$id);
			$get_class_id=$db->prepare("SELECT c.class_id,l.lesson_id FROM slide AS s JOIN lessons AS l ON s.lesson=l.lesson_id 
										JOIN topics AS t ON t.topic_id=l.topic JOIN themes_units AS tu ON tu.theme_id=t.unit_theme_id 
										JOIN tutors AS tt ON tu.tutor=tt.tutor_id JOIN class_subjects AS cs ON tt.class_subject=cs.cs_id
										JOIN classes AS c ON cs.class_id=c.class_id WHERE s.slide_id=? LIMIT 1");
			$get_class_id->bind_param('i',$slide);
			$slide=$id;

			if(!$get_class_id->execute()){
				die($db->error);
			}
			else{
				$class_res=$get_class_id->get_result();
				$class_res=$class_res->fetch_assoc()['class_id'];
				$get_class_id->close();
				$enrollment_id=check_enrollment($_SESSION['user'],$class_res);
				if($enrollment_id!=false){
					$sql=$db->query(" SELECT s.slide_id,s.slide_name,l.name,t.topic_name,s.slide_details,s.url FROM slide AS s JOIN lessons AS l ON l.lesson_id=s.lesson JOIN topics AS t ON t.topic_id=l.topic WHERE s.slide_id='$id' AND l.status='1' AND s.status='1' AND t.status='1' LIMIT 1");
					if(!$sql){
						die($db->error);
					}
					else{
						if(check_subscription($enrollment_id)!=false){
							echo json_encode($sql->fetch_all(MYSQLI_ASSOC));
							$db->close();
							exit();
						}
						else{
							//fetch units sequenc-done
							//fetch topics sequence-done
							//fetch lessons sequence-done
							//fetch slides sequence
							$slides=$sql->fetch_all(MYSQLI_ASSOC);

							$units_sequence=$db->prepare("SELECT tu.theme_id FROM themes_units AS tu JOIN term AS t ON tu.term=t.term_id JOIN tutors AS tr ON tu.tutor=tr.tutor_id JOIN admin AS a ON a.admin_id=tr.admin_id JOIN class_subjects AS cs ON tr.class_subject=cs.cs_id WHERE cs.class_id=? ORDER BY tu.theme_id ASC");
							$units_sequence->bind_param('i',$class_id);
							$class_id=$class_res;

							if(!$units_sequence->execute()){
								die($db->error);
							}
							else{
								$res_units=$units_sequence->get_result();
								$res_units=$res_units->fetch_all(MYSQLI_ASSOC);

								$get_theme=$db->prepare("SELECT tu.theme_id FROM slide AS s JOIN lessons AS l ON s.lesson=l.lesson_id 
														 JOIN topics AS t ON t.topic_id=l.topic JOIN themes_units AS tu ON tu.theme_id=t.unit_theme_id 
														 WHERE s.slide_id=? LIMIT 1");

								$get_theme->bind_param('i',$slide_no);
								$slide_no=$id;

								if(!$get_theme->execute()){
									die($db->error);
								}
								else{
									$themes=$get_theme->get_result();
									$themes=$themes->fetch_assoc();

									if($res_units[0]['theme_id']==$themes['theme_id']){
										$topics_seq=$db->prepare("SELECT t.topic_id AS tid FROM topics AS t JOIN themes_units AS th ON th.theme_id=t.unit_theme_id WHERE th.theme_id=? ORDER BY t.topic_id ASC");
										$topics_seq->bind_param('i',$themeId);
										$themeId=$themes['theme_id'];

										if(!$topics_seq->execute()){	
											die($db->error);
										}else{
											$res_topics=$topics_seq->get_result();
											$res_topics=$res_topics->fetch_all(MYSQLI_ASSOC);

											$get_topic=$db->prepare("SELECT t.topic_id FROM slide AS s JOIN lessons AS l ON s.lesson=l.lesson_id 
																	 JOIN topics AS t ON t.topic_id=l.topic JOIN themes_units AS tu ON tu.theme_id=t.unit_theme_id 
																	 WHERE s.slide_id=? LIMIT 1");

											$get_topic->bind_param('i',$slide_no);
											$slide_no=$id;

											if(!$get_topic->execute()){

											}else{
												$topic=$get_topic->get_result();
												$topic=$topic->fetch_assoc();

												if($topic['topic_id']==$res_topics[0]['topic_id']){
													$get_lessons=$db->prepare("SELECT l.lesson_id FROM lessons AS l JOIN topics AS t ON t.topic_id=l.topic WHERE t.topic_id=? AND l.lesson_id>'$start' AND t.status='1' AND l.status='1' ORDER BY l.name ASC");
													$get_lessons->bind_param('i',$topic_id);
													$topic_id=$topic['topic_id'];

													if(!$get_lessons->execute()){
														die($db->error);
													}else{
														$res_lesssons=$get_lessons->get_result();
														$res_lesssons=$res_lesssons->fetch_all(MYSQLI_ASSOC);
														$get_lessons->close();

														$get_lesson=$db->prepare("SELECT l.lesson_id FROM slide AS s JOIN lessons AS l ON s.lesson=l.lesson_id 
																	 JOIN topics AS t ON t.topic_id=l.topic JOIN themes_units AS tu ON tu.theme_id=t.unit_theme_id 
																	 WHERE s.slide_id=? LIMIT 1");
														$get_lesson->bind_param('i',$slide_no);
														$slide_no=$id;

														if($get_lesson->execute()){
															die($db->error);
														}
														else{
															$res_lessson=$get_lesson->get_result();
															$res_lesson=$res_lesson->fetch_assoc();

															if($res_lesson['lesson_id']==$res_lesssons[0]['lesson_id']){
																foreach ($slides as $idx => $slide) {
																	if($idx>2){
																		$slide['slide_id']=NULL;
																		$res[$idx]=$slide;
																	}
																	echo json_encode($slides);
																}
															}
															else{
																$get_lesson->close();
																echo json_encode(array('status'=>'failed','message'=>'This content is only available after subscription'));
																$db->close();
																exit();
														}
													}
												}
											}
											else{
													$get_topic->close();
													echo json_encode(array('status'=>'failed','message'=>'This content is only available after subscription'));
													$db->close();
													exit();
												}
											}
										}
									}
									else{
											echo json_encode(array('status'=>'failed','message'=>'This content is only available after subscription'));
											$db->close();
											exit();
										}
								}
								//if($res[1]['theme_id']==)
							}
							//$sql="SELECT l.topic_id FROM slide AS s JOIN lessons AS l ON l.lesson_id=s.lesson JOIN topics AS t ON t.topic_id=l.topic WHERE s.slide_id='$id' AND l.status='1' AND s.status='1' AND t.status='1'";
							//$sql="SELECT s.slide_id,s.slide_name,l.name,t.topic_name,s.slide_details,s.url FROM slide AS s JOIN lessons AS l ON l.lesson_id=s.lesson JOIN topics AS t ON t.topic_id=l.topic WHERE s.slide_id='$id' AND l.status='1' AND s.status='1' AND t.status='1'";
						}
					}
				}
				else{
					echo json_encode(array('status'=>'failed','message'=>'This content is only available after subscription'));
				}
			}
		}
		elseif(!empty($lesson)){
			$lesson=sanitize($db,$lesson);
			$get_class_id=$db->prepare("SELECT c.class_id FROM slide AS s JOIN lessons AS l ON s.lesson=l.lesson_id 
										JOIN topics AS t ON t.topic_id=l.topic JOIN themes_units AS tu ON tu.theme_id=t.unit_theme_id 
										JOIN tutors AS tt ON tu.tutor=tt.tutor_id JOIN class_subjects AS cs ON tt.class_subject=cs.cs_id
										JOIN classes AS c ON cs.class_id=c.class_id WHERE l.lesson_id=? LIMIT 1");
			$get_class_id->bind_param('i',$lesson_id);
			$lesson_id=$lesson;
			if(!$get_class_id->execute()){
				die($db->error);
			}
			else{
				$res=$get_class_id->get_result();
				$res=$res->fetch_assoc()['class_id'];
				$get_class_id->close();
				$enrollment_id=check_enrollment($_SESSION['user'],$res);
				if($enrollment_id!=false){

					if(check_subscription($enrollment_id)!=false){
						$sql=$db->query("SELECT s.slide_id,s.slide_name,s.url FROM slide AS s JOIN lessons AS l ON l.lesson_id=s.lesson JOIN topics AS t ON t.topic_id=l.topic WHERE l.lesson_id='$lesson' AND s.status='1' AND l.status='1' AND t.status='1'");
						if(!$sql){
							die($db->error);
						}
						else{
							echo json_encode($sql->fetch_all(MYSQLI_ASSOC));
							$db->close();
							exit();
						}
					}else{
						$sql=$db->prepare("SELECT s.slide_id,s.slide_name,s.url FROM slide AS s JOIN lessons AS l ON l.lesson_id=s.lesson JOIN topics AS t ON t.topic_id=l.topic WHERE l.lesson_id=? AND s.status='1' AND l.status='1' AND t.status='1'");
						$sql->bind_param('i',$lesson_id);
						$lesson_id=$lesson;
						if(!$sql->execute()){
							die($db->error);
							$db->close();
							exit();
						}
						else{
							$slides=$sql->get_result();
							$slides=$slides->fetch_all(MYSQLI_ASSOC);

							$fetch_topic=$db->prepare("SELECT t.topic_id,t.unit_theme_id FROM topics AS t JOIN lessons AS l ON t.topic_id=l.topic WHERE l.lesson_id=? AND t.status=1 LIMIT 1 ");
							$fetch_topic->bind_param('i',$less_id);
							$less_id=$lesson;

							if(!$fetch_topic->execute()){
								die($db->error);
							}else{
								$topic=$fetch_topic->get_result();
								$topic=$topic->fetch_assoc();
								$theme_id=$topic['unit_theme_id'];
								$topic_id=$topic['topic_id'];
								$fetch_topic->close();
								
								$fetch_topics=$db->prepare("SELECT t.topic_id FROM topics AS t JOIN themes_units AS th ON th.theme_id=t.unit_theme_id WHERE th.theme_id=? AND t.status=1");
								$fetch_topics->bind_param('i',$theme);
								$theme=$theme_id;
								if(!$fetch_topics->execute()){
									die($db->error);
								}else{
									$topics=$fetch_topics->get_result();
									$topics=$topics->fetch_all(MYSQLI_ASSOC);
									
									if($topics[0]['topic_id']==$topic_id){
										$get_class_id=$db->prepare("SELECT tt.class_subject FROM slide AS s JOIN lessons AS l ON s.lesson=l.lesson_id 
											JOIN topics AS t ON t.topic_id=l.topic JOIN themes_units AS tu ON tu.theme_id=t.unit_theme_id 
											JOIN tutors AS tt ON tu.tutor=tt.tutor_id JOIN class_subjects AS cs ON tt.class_subject=cs.cs_id
											JOIN classes AS c ON cs.class_id=c.class_id WHERE l.lesson_id=? AND l.status=1 LIMIT 1");
										$get_class_id->bind_param('i',$lesson_idd);
										$lesson_idd=$lesson;

										if(!$get_class_id->execute()){
											die($db->error);
										}else{
											$class_id=$get_class_id->get_result();
											$class_id=$class_id->fetch_assoc()['class_subject'];

											$get_themes=$db->prepare("SELECT th.theme_id FROM themes_units AS th JOIN tutors AS tt ON tt.tutor_id=th.tutor WHERE tt.class_subject=? AND tt.status=1");
											$get_themes->bind_param('i',$cs);
											$cs=$class_id;

											if(!$get_themes->execute()){
												die($db->error);
											}else{
												$themes=$get_themes->get_result();
												$themes=$themes->fetch_all(MYSQLI_ASSOC);
												
												if($themes[0]['theme_id']==$theme_id){
													$fetch_lessons=$db->prepare("SELECT l.lesson_id FROM lessons AS l JOIN topics AS t ON t.topic_id=l.topic WHERE t.topic_id=? AND t.status=1 ");
													$fetch_lessons->bind_param('i',$tpc);
													$tpc=$topic_id;

													if(!$fetch_lessons->execute()){
														die($db->error);
													}else{
														$lessons=$fetch_lessons->get_result();
														$lessons=$lessons->fetch_all(MYSQLI_ASSOC);

														if($lessons[0]['lesson_id']==$lesson){
															foreach ($slides as $idx => $slide) {
																if($idx>2){
																	$slide['slide_id']=NULL;
																	$slide['url']='../resources/slides/default/notNubscribed.html';
																	$slides[$idx]=$slide;
																}
															}
															echo json_encode($slides);
														}
														else{
															nullify($slides);
															echo json_encode($slides);
														}
													}
												}
												else{
													nullify($slides);
													echo json_encode($slides);
												}
											}
										}
									}else{
										nullify($slides);
										echo json_encode($slides);
									}
								}
							}	
						}			
					}
				}
				else{
					echo json_encode(array('status'=>'failed','message'=>'Sorry, you are not enrolled for this class'));
				}
			}
		}
	}
	else{
		echo json_encode(array('status'=>'failed','message'=>'Access denied,Please login to continue'));
	}
}

function delete_slide($id)
{
	if(check_admin()){
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
		else{
			echo json_encode(array('status'=>'failed','message'=>'Please provide a valid slide'));
		}
	}else{
		echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
	}	
}

function nullify(&$slides){
	foreach ($slides as $idx => $slide) {
			$slide['slide_id']=NULL;
			$slide['url']='../resources/slides/default/notNubscribed.html';
			$slides[$idx]=$slide;
	}
}

function render_slide($id){
	if(isset($id) && !empty($id)){
		ob_start();
		fetch_slides($id);
		//include '../'.$_GET['url'];
		$res=ob_get_clean();
		ob_start();
		$result=json_decode($res,true);
		if(sizeof($result)>0 && $result['status']!='failed'){
			include $result[0]['url'];
			$html=ob_get_clean();
			echo '<html><head><base href="http://www.kampalasmartschool.com/api/"></head><body>'.$html.'</body></html>';
		}else{
			echo json_encode($result);
			include '../resources/slides/template.html';
			$html=ob_get_clean();
			echo '<html><head><base href="http://www.kampalasmartschool.com/api/"></head><body>'.$html.'</body></html>';	
		}
	
	}
	else{
		ob_start();
		include '../resources/slides/template.html';
		$res=ob_get_clean();
		ob_start();
		include json_decode($res,true)[0]['url'];
		$html=ob_get_clean();
		echo '<html><head><base href="http://www.kampalasmartschool.com/api/"></head><body>'.$html.'</body></html>';
	}
}
?>
