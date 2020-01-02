<?php

function add_tutor()
{
	if(check_admin() && isset($_SESSION['previlege']) && $_SESSION['previlege']==1)
	{
		if(isset($_POST['subject']) && !empty($_POST['subject']) && isset($_POST['admin']) && !empty($_POST['admin']))
		{
			$db=connect_db();
			$subject=sanitize($db,$_POST['subject']);
			$admin=sanitize($db,$_POST['admin']);

			$class_exists=$db->query("SELECT cs_id FROM class_subjects WHERE cs_id='$subject' AND status='1' LIMIT 1");
			if(!$class_exists)
			{
				die($db->error);
			}

			else
			{
				if($class_exists->num_rows>0)
				{
					$find_contributing=$db->query("SELECT tutor_id,status FROM tutors WHERE admin_id='$admin' AND class_subject='$subject' LIMIT 1");
					if(!$find_contributing)
						{
							die($db->error);
						}

						else
							{
								if($find_contributing->num_rows===0)
									{
										$add_tutor=$db->query("INSERT INTO tutors (class_subject,admin_id) VALUES ('$subject','$admin')");
										if(!$add_tutor)
											{
												die($db->error);
											}

											else
												{
													$new_tutor=$db->insert_id;
													echo json_encode(array('status'=>'success','message'=>'Tutor added successfully','id'=>$new_tutor));
												}
									}
								
								else
									{
										$status=$find_contributing->fetch_assoc()['status'];
										$tutor=$find_contributing->fetch_assoc()['tutor_id'];
										if($status===0)
										{
											$change_status=$db->query("UPDATE tutors SET status='1' WHERE tutor_id='$tutor'");
											if(!$change_status)
											{
												die($db->error);
											}
										}
										echo json_encode(array('status'=>'failed','message'=>'Already contributing'));
									}
							}
							$db->close();
				}
				else
				{
					echo json_encode(array('status'=>'failed','message'=>'Selected subject is not availabe'));
				}
			}
		}

		else
		{
			echo json_encode(array('status'=>'failed','message'=>'Please Fill all required fields'));
		}
	}

	else
	{
		echo json_encode(array('status'=>'error','message'=>'Restricted Access Please Login'));
	}
}

function fetch_tutor($id='',$admin='',$class='',$subject='',$classSubject='')
{
	$db=connect_db();
	$fetch_tutor='';
	if(!empty($id))
	{
		$fetch_tutor=$db->query("SELECT t.tutor_id,a.admin_id,a.f_name,a.l_name,s.subject_name,c.class_name,t.status FROM tutors AS t JOIN admin AS a ON t.admin_id=a.admin_id JOIN class_subjects AS cs ON cs.cs_id=t.class_subject JOIN classes AS c ON c.class_id=cs.class_id JOIN subjects AS s ON s.subject_id=cs.subject_id WHERE t.tutor_id='$tutor' AND t.status='1' AND a.status='1'");
	}

	else if(!empty($admin))
	{
		$fetch_tutor=$db->query("SELECT t.tutor_id,a.admin_id,a.f_name,a.l_name,s.subject_name,c.class_name,t.status FROM tutors AS t JOIN admin AS a ON t.admin_id=a.admin_id JOIN class_subjects AS cs ON cs.cs_id=t.class_subject JOIN classes AS c ON c.class_id=cs.class_id JOIN subjects AS s ON s.subject_id=cs.subject_id WHERE a.admin_id='$admin' AND t.status='1' AND a.status='1'");
	}

	else if(!empty($class))
	{
		$fetch_tutor=$db->query("SELECT t.tutor_id,a.admin_id,a.f_name,a.l_name,s.subject_name,c.class_name,t.status FROM tutors AS t JOIN admin AS a ON t.admin_id=a.admin_id JOIN class_subjects AS cs ON cs.cs_id=t.class_subject JOIN classes AS c ON c.class_id=cs.class_id JOIN subjects AS s ON s.subject_id=cs.subject_id WHERE c.class_id='$class' AND t.status='1' AND a.status='1'");
	}

	else if(!empty($subject))
	{
		$fetch_tutor=$db->query("SELECT t.tutor_id,a.admin_id,a.f_name,a.l_name,s.subject_name,c.class_name,t.status FROM tutors AS t JOIN admin AS a ON t.admin_id=a.admin_id JOIN class_subjects AS cs ON cs.cs_id=t.class_subject JOIN classes AS c ON c.class_id=cs.class_id JOIN subjects AS s ON s.subject_id=cs.subject_id WHERE s.subject_id='$subject' AND t.status='1' AND a.status='1'");
	}

	else if(!empty($classSubject))
	{
		$fetch_tutor=$db->query("SELECT t.tutor_id,a.admin_id,a.f_name,a.l_name,s.subject_name,c.class_name,t.status FROM tutors AS t JOIN admin AS a ON t.admin_id=a.admin_id JOIN class_subjects AS cs ON cs.cs_id=t.class_subject JOIN classes AS c ON c.class_id=cs.class_id JOIN subjects AS s ON s.subject_id=cs.subject_id WHERE cs.cs_id='$classSubject' AND t.status='1' AND a.status='1'");
	}


	else
	{
		$fetch_tutor=$db->query("SELECT t.tutor_id,a.admin_id,a.f_name,a.l_name,s.subject_name,c.class_name,t.status FROM tutors AS t JOIN admin AS a ON t.admin_id=a.admin_id JOIN class_subjects AS cs ON cs.cs_id=t.class_subject JOIN classes AS c ON c.class_id=cs.class_id JOIN subjects AS s ON s.subject_id=cs.subject_id AND t.status='1' AND a.status='1'");
	}

	if(!$fetch_tutor)
	{
		die($db->error);
		$db->close();
	}

	else
	{
		echo json_encode($fetch_tutor->fetch_all(MYSQLI_ASSOC));
	}
	$db->close();
}


function delete_tutor($id)
{
	if(check_admin() && $_SESSION['previlege']==1){
		if(isset($id) && strlen($id)>0)
		{
			$db=connect_db();
			if(is_numeric($id))
			{
				$delete_tutor=$db->query("UPDATE tutors SET status='0' WHERE tutor_id='$id'");
				if(!$delete_tutor)
				{
					die($db->error);
				}
				else
				{
					echo json_encode(array('status'=>'success','message'=>'Tutor added successfully'));
				}
			}
			$db->close();
		}
		else
		{
			echo json_encode(array('status'=>'failed','message'=>'Please specify provide a tutor ID'));
		}
	}else{
		echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
	}
}

?>