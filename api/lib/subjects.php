<?php
function add_subject()
{
	if(check_admin()){
		$db=connect_db();
		if(isset($_POST['subjectName']) && !empty($_POST['subjectName']) && isset($_POST['sDescription']) && !empty($_POST['sDescription']))
		{
			$name=sanitize($db,$_POST['subjectName']);
			$description=sanitize($db,$_POST['sDescription']);

			$add_subject=$db->query("INSERT INTO subjects (subject_name,description) VALUES ('$name','$description')");
			if(!$add_subject)
				{
					die($db->error);
				}

				else
					{
						$subject_id=$db->insert_id;

						if(isset($_FILES['subjectLogo']) && $_FILES['subjectLogo']['size']>0)
							{
								$dest='/resources/images';
								$accepted=array("JPG","JPEG","PNG","png","jpeg","jpg");
								$file=$_FILES['subjectLogo'];

								$res=upload_image($file,$dest,$accepted);
								if($res['status']===1)
									{
										$res_dest=$res['message'];
										$update_pic=$db->query("UPDATE subjects SET subject_logo='$res_dest' WHERE subject_id='$subject_id'");

										if(!$update_pic)
											{
												$dest="../resources/images/subjects/default_subject.png";
												$update_pic=$db->query("UPDATE subjects SET subject_logo='$dest' WHERE subject_id='$subject_id'");

												if(!$update_pic)
													{
														die($db->error);
													}
											}
									}
							}

							else
								{
									$dest="../resources/images/default_subject.png";
									$update_pic=$db->query("UPDATE subjects SET subject_logo='$dest' WHERE subject_id='$subject_id'");

									if(!$update_pic)
										{
											die($db->error);
										}
								}

						fetch_subjects($subject_id);
					}
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

function fetch_subjects($sub_id='',$class='',$sub='',$class_subject='',$not_taking='')
{
	$db=connect_db();

	$sql="";
	if(!empty($sub_id))
	{
		$sub_id=sanitize($db,$sub_id);
		$sql=$db->query("SELECT subject_id,subject_name,subject_logo FROM subjects WHERE subject_id='$sub_id' AND status='1'");
	}

	else if(!empty($class))
	{
		$class=sanitize($db,$class);
		$sql=$db->query("SELECT c.class_id,c.class_name,cs.cs_id,s.subject_id,s.subject_name,s.subject_logo FROM subjects AS s JOIN class_subjects AS cs ON cs.subject_id=s.subject_id JOIN classes AS c ON c.class_id=cs.class_id WHERE c.class_id='$class' AND cs.status='1' AND s.status='1'");
	}

	else if(!empty($class_subject))
	{
		$class_subject=sanitize($db,$class_subject);
		$sql=$db->query("SELECT c.class_id,c.class_name,cs.cs_id,s.subject_id,s.subject_name,s.subject_logo FROM subjects AS s JOIN class_subjects AS cs ON cs.subject_id=s.subject_id JOIN classes AS c ON c.class_id=cs.class_id WHERE cs.cs_id='$class_subject' AND cs.status='1'");
	}

	else if(!empty($not_taking))
	{
		$not_taking=sanitize($db,$not_taking);
		$sql=$db->query("SELECT c.class_id,c.class_name FROM class_subjects AS cs LEFT JOIN classes AS c ON c.class_id=cs.class_id WHERE cs.class_id IS NULL");
	}

	else if(!empty($sub))
	{
		$sub=sanitize($db,$sub);
		$sql=$db->query("SELECT c.class_id,c.class_name,cs.cs_id,s.subject_id,s.subject_name,s.subject_logo FROM subjects AS s JOIN class_subjects AS cs ON cs.subject_id=s.subject_id JOIN classes AS c ON c.class_id=cs.class_id WHERE s.subject_id='$sub' AND cs.status='1'");
	}

	else
	{
		$sql=$db->query("SELECT subject_id,subject_name,subject_logo FROM subjects WHERE status='1'");
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

function edit_subject($id)
{
	if(check_admin()){
		if(isset($_POST['subjectName']) && !empty($_POST['subjectName']))
		{
			$db=connect_db();
			$id=sanitize($db,$id);
			$name=sanitize($db,$_POST['subjectName']);
			$description='';

			if(isset($_POST['sDescription']) && !empty($_POST['sDescription']))
			{
				$description=sanitize($db,$_POST['sDescription']);
			}

			$add_subject=$db->query("UPDATE subjects SET subject_name='$name',description='$description' WHERE subject_id='$id'");
			if(!$add_subject)
			{
				die($db->error);
			}

			else
				{
					if(isset($_FILES['subjectLogo']) && $_FILES['subjectLogo']['size']>0)
						{
							$dest='resources/images';
							$accepted=array("JPG","JPEG","PNG","png","jpeg","jpg");
							$file=$_FILES['subjectLogo'];

							$res=upload_image($file,$dest,$accepted);
							if($res['status']===1)
								{
									$res_dest=$res['message'];
									$update_pic=$db->query("UPDATE subjects SET subject_logo='$res_dest' WHERE subject_id='$id'");
								}
						}


						if(isset($_POST['remove_class']) && !empty($_POST['remove_class']))
						{
							 if(is_array($_POST['remove_class']))
							 {
							 	$to_remove=$_POST['remove_class'];
							 }

							 else if(is_string($_POST['remove_class']))
							 {
							 	$to_remove=explode(',',$_POST['remove_class']);
							 }

							foreach ($to_remove AS $idx=>$class_remove)
							{
								$remove=$db->prepare("UPDATE class_subjects SET status='0' WHERE class_id=? AND subject_id=?");
								$remove->bind_param('ii',$class,$subject);
								$class=$class_remove;
								$subject=$id;

								if(!$remove->execute())
								{
									die($db->error);
									$db->close();
								}
								$remove->close();
							}
						}

						if(isset($_POST['add_class']) && !empty($_POST['add_class']))
						{
							if(is_array($_POST['add_class']))
							 {
							 	$to_add=$_POST['add_class'];
							 }

							 else if(is_string($_POST['add_class']))
							 {
							 	$to_add=explode(',',$_POST['add_class']);
							 }

							 $added=array();
							foreach ($to_add AS $idx=>$class_add)
							{
								array_push($added,add_cs($class_add,$id));
							}
							echo json_encode($added);
						}

						$fetch_subject=$db->query("SELECT subject_id,subject_name,subject_logo FROM subjects WHERE subject_id='$id'");
						if(!$fetch_subject)
							{
								die($db->error);
							}

							else
								{
									echo json_encode($fetch_subject->fetch_assoc());
								}
				}
		$db->close();
		}

		else
		{
			echo json_encode(array("status"=>"failed",'message'=>'Please fill all required fields'));
		}
	}else{
		echo json_encode(array("status"=>"failed",'message'=>'Please login to continue'));
	}	
}

function delete_subject($id)
{
	if(check_admin()){
		if(isset($id) && !empty($id))
		{
			$db=connect_db();
			$id=sanitize($db,$id);

			$delete_subject=$db->query("UPDATE subjects SET status='0' WHERE subject_id='$id'");
			if(!$delete_subject)
			{
				die($db->error);
			}
			else
			{
				$db->close();
				echo json_encode(array('status'=>'success','message'=>'Subject Deleted successfully'));
			}
		}
	}else{
		echo json_encode(array("status"=>"failed",'message'=>'Please login to continue'));
	}
}

function add_class_subject()
{
	if(check_admin())
	{
		$db=connect_db();
		if(isset($_POST['subject']) && strcmp($_POST['subject'],'new')==0)
		  {
		  	if(isset($_POST['subjectName']) && !empty($_POST['subjectName']) && isset($_POST['sDescription']) && !empty($_POST['sDescription']))
				{
					$name=sanitize($db,$_POST['subjectName']);
					$description=sanitize($db,$_POST['sDescription']);
		  			$add_subject=$db->query("INSERT INTO subjects (subject_name,description) VALUES ('$name','$description')");
		  			if(!$add_subject)
						{
							die($db->error);
						}

						else
							{
								$subject_id=$db->insert_id;
								if(isset($_FILES['subjectLogo']) && $_FILES['subjectLogo']['size']>0)
									{
										$dest='resources/images';
										$accepted=array("JPG","JPEG","PNG","png","jpeg","jpg");
										$file=$_FILES['subjectLogo'];
										$res=upload_image($file,$dest,$accepted);
										if($res['status']===1)
											{
												$res_dest=$res['message'];
												$update_pic=$db->query("UPDATE subjects SET subject_logo='$res_dest' WHERE subject_id='$subject_id'");
												if(!$update_pic)
													{
														$dest="../resources/images/subjects/default_subject.png";
														$update_pic=$db->query("UPDATE subjects SET subject_logo='$dest' WHERE subject_id='$subject_id'");
														if(!$update_pic)
															{
																die($db->error);
															}
													}
											}
									}

									else
										{
											$dest="../resources/images/default_subject.png";
											$update_pic=$db->query("UPDATE subjects SET subject_logo='$dest' WHERE subject_id='$subject_id'");
											if(!$update_pic)
												{
													die($db->error);
												}
										}
										
										if(isset($_POST['classes']) && is_string($_POST['classes']) && strcmp($_POST['classes'],'all')==0 || empty($_POST['classes']))
											{
												$fetch_classes=$db->query('SELECT class_id FROM classes');
													if(!$fetch_classes)
														{
															die($db->error);
														}

														else
															{
																$r_classes=$fetch_classes->fetch_all(MYSQLI_ASSOC);
																$added_classes=array();
																foreach ($r_classes as $class) 
																	{
																					array_push($added_classes,add_cs($class['class_id'],$subject_id));
																				}
																				echo json_encode($added_classes);
															}
											}

										else
										{
											if(isset($_POST['classes']) && !empty($_POST['classes']))
												{
													$classed_raw=explode(',',$_POST['classes']);
													$added_classes=array();
													foreach($classed_raw AS $key => $class)
														{
															array_push($added_classes,add_cs($class,$subject_id));
														}
													echo json_encode(array('classed'=>$classed_raw,'res'=>$added_classes));
												}
										}
		 					}
		}
		else
		{
			echo json_encode(array('status'=>'failed','message'=>'Please fill in the required fields'));
		}
	}

		else if(isset($_POST['subject']) && !empty($_POST['subject']))
		{
			if(isset($_POST['classes']) && !empty($_POST['classes']))
				{
					$added_classes=array();
					foreach ($_POST['classes'] as $key => $class)
						{
							array_push($added_classes,add_cs($class,$subject_id));
						}
					echo json_encode($added_classes);
				}

				else
					{
						if(isset($_POST['classes']) && strcmp(($_POST['classes']),'all')==0 || empty($_POST['classes']))
							{
								$fetch_classes=$db->query('SELECT class_id FROM classes');
								if(!$fetch_classes)
									{
										die($db->error);
									}

									else
										{
											$r_classes=$fetch_classes->fetch_all(MYSQLI_ASSOC);
											$added_classes=array();
											foreach ($r_classes as $class) 
												{
													array_push($added_classes,add_cs($class['class_id'],$subject_id));
												}
												echo json_encode($added_classes);
										}
							}
					}
		}

		else
		{
			echo json_encode(array('status'=>'failed','message'=>'Please fill in the required fields'));
		}
	}
	else{
		echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
	}
}

function add_cs($class,$subject,$description='')
{
	if(check_admin()){
		$db=connect_db();
		$try_sub=$db->query("SELECT cs_id,status FROM class_subjects WHERE class_id='$class' AND subject_id='$subject'");
		if(!$try_sub)
		{
			die($db->error);
		}

		else
		{
			if($try_sub->num_rows===0)
			{
				$add_subject=$db->query("INSERT INTO class_subjects (class_id,subject_id,description) VALUES ('$class','$subject','$description')");
						if(!$add_subject)
							{
								die($db->error);
							}

							else
								{
									$subject_id=$db->insert_id;
									if(isset($_FILES['cs_Logo']) && $_FILES['cs_Logo']['size']>0)
										{
											$dest='resources/images';
											$accepted=array("JPG","JPEG","PNG","png","jpeg","jpg");
											$file=$_FILES['cs_Logo'];

											$res=upload_image($file,$dest,$accepted);
											if($res['status']===1)
												{
													$res_dest=$res['message'];
													$update_pic=$db->query("UPDATE class_subjects SET cs_image='$res_dest' WHERE cs_id='$subject_id'");

													if(!$update_pic)
														{
															$dest="../resources/default_cs.png";
															$update_pic=$db->query("UPDATE class_subjects SET cs_image='$res_dest' WHERE cs_id='$subject_id''");

															if(!$update_pic)
																{
																	die($db->error);
																}
														}
												}
										}

										else
											{
												$res_dest="../resources/images/default_cs.png";
												$update_pic=$db->query("UPDATE class_subjects SET cs_image='$res_dest' WHERE cs_id='$subject_id'");

												if(!$update_pic)
													{
														die($db->error);
													}
											}

											$fetch_subject=$db->query("SELECT cs.cs_id,cs.subject_id,s.subject_name,cs.cs_image FROM class_subjects AS cs JOIN subjects AS s ON cs.subject_id=s.subject_id WHERE cs.cs_id='$subject_id'");
											if(!$fetch_subject)
												{
													die($db->error);
												}

												else
													{
														return $fetch_subject->fetch_assoc();
													}
								}
			}

			else
			{
				$rep=$try_sub->fetch_assoc();
				if($rep['status']==0)
				{
					$id=$rep['cs_id'];
					$update_status=$db->query("UPDATE class_subjects SET status='1' WHERE cs_id='$id' ");

					if(!$update_status)
					{
						die($db->error);
					}
				}
			}
		}

	}
	else{
		echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
	}
}
?>
