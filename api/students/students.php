<?php
function student_login()
{
	if(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password']))
		{
			$db=connect_db();
			$check_student=$db->prepare("SELECT student_id,f_name,l_name,username,password,profile_pic FROM students WHERE username=? LIMIT 1");
			$check_student->bind_param('s',$username);
			$username=sanitize($db,$_POST['username']);

			if(!$check_student->execute())
			{
				die($db->error);
			}

			else
			{
				$res=$check_student->get_result();
				if($res->num_rows>0)
				{
					$result_set=$res->fetch_assoc();
					$get_current_session=$db->prepare("SELECT login_id,session_id,browser,country FROM logins WHERE user_id=? AND account_type=? AND status=1");
					$get_current_session->bind_param('is',$user_id,$type);
					$user_id=$result_set['student_id'];
					$type='STU';
					if(!$get_current_session->execute()){
						die($db->error);
					}else{
						$session_result=$get_current_session->get_result();
						if($session_result->num_rows>0){
							$sess_status=0;
							$sess_results=$session_result->fetch_all(MYSQLI_ASSOC);
							$invalidate=$db->prepare("UPDATE logins SET status=0 WHERE login_id=?");
							$invalidate->bind_param('s',$login);
							foreach ($sess_results as $key=>$set){
								$login=$set['login_id'];
								if(!$invalidate->execute()){
								die($db->error);
								}else{
									if($db->affected_rows>0){
										session_id($set['session_id']);
										session_start();
										session_regenerate_id(true);
										session_destroy();
									}
								}
							}
							
							session_start();
							session_regenerate_id();
							$sess=session_id();
							$add_session=$db->prepare("INSERT INTO logins (session_id,user_id,account_type,ip_address,browser) VALUES (?,?,?,?,?)");
							$add_session->bind_param('sisss',$session,$user,$type,$address,$browser);
							$user=$result_set['student_id'];
							$address=$_SERVER['REMOTE_ADDR'];
							$session=$sess;
							$browser=$_SERVER['HTTP_USER_AGENT'];
							$type='STU';
							if(!$add_session->execute()){
								die($db->error);
							}else{
									$_SESSION['user']=$result_set['student_id'];
									$_SESSION['track']=$db->insert_id;
									$_SESSION['status']=true;
									$_SESSION['account']='student';
									$_SESSION['username']=$result_set['username'];
									$_SESSION['profile_pic']=$result_set['profile_pic'];
									$_SESSION['student_name']=$result_set['f_name'].' '.$result_set['l_name'];

									echo json_encode(array('status'=>'success','message'=>'You are Logged in as Student'));	
								}
						}else{
							if(password_verify($_POST['password'],$result_set['password']))
							{
								session_start();
								session_regenerate_id();
								$sess=session_id();
								$add_session=$db->prepare("INSERT INTO logins (session_id,user_id,account_type,ip_address,browser) VALUES (?,?,?,?,?)");
								$add_session->bind_param('sisss',$session,$user,$type,$address,$browser);
								$user=$result_set['student_id'];
								$address=$_SERVER['REMOTE_ADDR'];
								$session=$sess;
								$browser=$_SERVER['HTTP_USER_AGENT'];
								$type='STU';
								if(!$add_session->execute()){
									die($db->error);
								}else{
										$_SESSION['user']=$result_set['student_id'];
										$_SESSION['track']=$db->insert_id;
										$_SESSION['status']=true;
										$_SESSION['account']='student';
										$_SESSION['username']=$result_set['username'];
										$_SESSION['profile_pic']=$result_set['profile_pic'];
										$_SESSION['student_name']=$result_set['f_name'].' '.$result_set['l_name'];
										echo json_encode(array('status'=>'success','message'=>'You are Logged in as Student'));	
									}
							}

							else
							{
								echo json_encode(array('status'=>'failed','message'=>'Please enter the correct username and password'));
							}
						}
					}
				}
				else
				{
					echo json_encode(array('status'=>'failed','message'=>'Please enter a correct username'));
				}

				$check_student->close();
				$db->close();
			}
		}

		else
		{
			echo json_encode(array('status'=>'failed','message'=>'Please enter both username and password'));
		}
}

function student_enrollments($student_id=0,$sponsor_id=0)
{
	session_start();
	if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['status']) && !empty($_SESSION['status']) && $_SESSION['status']==true)
	{
		if(isset($_SESSION['account']) && !empty($_SESSION['account']))
		{
			if(strcmp($_SESSION['account'],'student')==0)
			{
				$db=connect_db();
				$fetch_student=$db->prepare('SELECT e.enrollment_id,s.student_id,c.class_id,c.class_name,c.short_class_name,c.class_pic,c.description FROM classes AS c JOIN enrollments AS e ON c.class_id=e.class_id JOIN students AS s ON s.student_id=e.student_id WHERE s.student_id=? AND e.enrollment_status=1');
				$fetch_student->bind_param('i',$student_id);
				$student_id=sanitize($db,$_SESSION['user']);

				if(!$fetch_student->execute())
				{
					die($db->error);
				}

				else
				{
					$res=$fetch_student->get_result();
					if($res->num_rows>0)
					{
						$new_array=array();
						$res_set=$res->fetch_all(MYSQLI_ASSOC);
						foreach ($res_set as $rsl) 
						{
							$enroll_array=$rsl;
							$sub=check_subscription($rsl['enrollment_id']);
							if($sub!=false)
							{
								$enroll_array['subscription_status']=1;
							}
							else
							{
								$enroll_array['subscription_status']=0;
							}							
							array_push($new_array,$enroll_array);
						}
						echo json_encode(array('status'=>'success','data'=>$new_array));
						$fetch_student->close();
						$db->close();
						exit();
					}
					else
					{
						echo json_encode(array('status'=>'failed','message'=>'You are not enrolled for any class.'));
					}
				}
			}

			else if(strcmp($_SESSION['account'],'sponsor')==0 || strcmp($_SESSION['account'],'admin')==0)
			{
				if(isset($student_id) && !empty($student_id))
				{
					$db=connect_db();

					if(strcmp($_SESSION['account'],'sponsor')==0){
						$fetch_student=$db->prepare('SELECT e.enrollment_id,c.class_id,c.class_name,c.short_class_name,c.class_pic FROM classes AS c JOIN enrollments AS e ON c.class_id=e.class_id JOIN students AS s ON s.student_id=e.student_id WHERE s.student_id=? AND s.sponsor_id=? AND e.enrollment_status=1');
						$fetch_student->bind_param('ii',$student,$sponsor_id);
						$sponsor_id=sanitize($db,$_SESSION['user']);
					}
					else if(strcmp($_SESSION['account'],'admin')==0){
						$fetch_student=$db->prepare('SELECT e.enrollment_id,c.class_id,c.class_name,c.short_class_name,c.class_pic,sp.sponsor FROM classes AS c JOIN enrollments AS e ON c.class_id=e.class_id JOIN students AS s ON s.student_id=e.student_id JOIN sponsors AS sp ON sp.sponsor_id=s.sponsor_id JOIN class_subjects AS cs ON cs.class_id=c.class_id JOIN tutors AS tt ON tt.class_subject=cs.cs_id JOIN themes_units AS tu ON tu.tutor=tt.tutor_id JOIN admin AS a ON a.admin_id=tt.admin_id WHERE s.student_id=? AND a.admin_id=? AND e.enrollment_status=1 AND a.status=1 AND s.status=1 AND .status=1 AND cs.status=1');
						$fetch_student->bind_param('ii',$student,$sponsor_id);
					}
					
					
					$student=sanitize($db,$student_id);
					

					if(!$fetch_student->execute())
					{
						die($db->error);
					}

					else
					{
						$res=$fetch_student->get_result();
						if($res->num_rows>0)
						{
							$new_array=array();
							$res_set=$res->fetch_all(MYSQLI_ASSOC);
							foreach ($res_set as $rsl) 
							{
								$enroll_array=$rsl;
								$sub=check_subscription($rsl['enrollment_id']);
								if($sub!=false)
								{
									$enroll_array['subscription_status']=1;
								}
								else
								{
									$enroll_array['subscription_status']=0;
								}
								array_push($new_array,$enroll_array);
							}
							echo json_encode(array('status'=>'success','data'=>$new_array));

							$fetch_student->close();
							$db->close();
							exit();
						}
						else
						{
							echo json_encode(array('status'=>'failed','message'=>'Student not enrolled for any class.'));
						}
					}
				}
				elseif(isset($sponsor_id) && !empty($sponsor_id) && strcmp($_SESSION['account'],'admin')==0)
				{
					$res=fetch_classification($sponsor_id);

					if(sizeof($res)>0)
						{
							echo json_encode(array('status'=>'success','data'=>$res));
							exit();
						}
						else
						{
							echo json_encode(array('status'=>'failed','message'=>'Sponsor has not enrolled any student for any class.'));
						}
				}
				else
				{
					$db=connect_db();
					$app=\Slim\Slim::getInstance();

					if($app->request()->params('class') && strcmp($app->request()->params('class'), 'unenrolled')==0){
							$fetch_student=$db->prepare('SELECT student_id,f_name,l_name,username,dob FROM students WHERE sponsor_id=? AND status=1');
							$fetch_student->bind_param('i',$sponsor_id);
							$sponsor_id=$_SESSION['user'];

							if(!$fetch_student->execute())
							{
								die($db->error);
							}
							else
							{
								$res=$fetch_student->get_result();
								if($res->num_rows>0)
								{
									$students_array=$res->fetch_all(MYSQLI_ASSOC);
									$fetch_student->close();
									$check_enrollment=$db->prepare("SELECT student_id FROM enrollments WHERE student_id=? AND enrollment_status=1");

									foreach ($students_array as $idx => $student) {
										$check_enrollment->bind_param('i',$student_id);
										$student_id=$student["student_id"];

										if(!$check_enrollment->execute()){
											die($db->error);
										}
										else{
											$res=$check_enrollment->get_result();
											if($res->num_rows!=0)
											{
												unset($students_array[$idx]);
											}
										}
									}
									$check_enrollment->close();
									$db->close();
									echo json_encode(array('status'=>'success','data'=>$students_array));
									exit();
								}
								else
								{
									echo json_encode(array('status'=>'failed',"message"=>"You have not added any students"));
									$fetch_student->close();
									$db->close();
									exit();
								}
							}
						}
						else
						{
							if(strcmp($_SESSION['account'],'admin')==0)
							{

								if(strcmp($app->request()->params('class'), "all")==0){
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
											
											$fetch_student=$db->prepare('SELECT e.enrollment_id,c.class_id,c.class_name,c.short_class_name,s.student_id,s.f_name,s.l_name,s.dob,s.username,sp.sponsor_name FROM classes AS c JOIN enrollments AS e ON c.class_id=e.class_id JOIN students AS s ON s.student_id=e.student_id JOIN sponsors AS sp ON sp.sponsor_id=s.sponsor_id WHERE e.enrollment_status=1 && e.enrollment_id>? LIMIT ?');
											$fetch_student->bind_param('ii',$floor,$size);
											$floor=$start;
											$size=$pagesize;
									}
									else{
										$fetch_student=$db->prepare('SELECT e.enrollment_id,c.class_id,c.class_name,c.short_class_name,s.student_id,s.f_name,s.l_name,s.dob,s.username,sp.sponsor_name FROM classes AS c JOIN enrollments AS e ON c.class_id=e.class_id JOIN students AS s ON s.student_id=e.student_id JOIN sponsors AS sp ON sp.sponsor_id=s.sponsor_id WHERE e.enrollment_status=1');
									}
								}
								elseif(!$app->request()->params('class')){
									$res=fetch_classification();
									if(sizeof($res)>0)
										{
											echo json_encode(array('status'=>'success','data'=>$res));
											exit();
										}
										else
										{
											echo json_encode(array('status'=>'failed','message'=>'You have not enrolled any student for any class.'));
										}
										exit();
								}
								else{

									$fetch_student=$db->prepare('SELECT e.enrollment_id,c.class_id,c.class_name,c.short_class_name,s.student_id,s.f_name,s.l_name,s.dob,s.username,sp.sponsor_name FROM classes AS c JOIN enrollments AS e ON c.class_id=e.class_id JOIN students AS s ON s.student_id=e.student_id JOIN sponsors AS sp ON sp.sponsor_id=s.sponsor_id WHERE e.class_id=? AND e.enrollment_status=1 ORDER BY e.enrollment_id ASC');
										$fetch_student->bind_param('i',$class_id);
										$class_id=sanitize($db,$app->request()->params('class'));
								}
								if(!$fetch_student->execute()){
									die($db->error);
								}else{
									$res=$fetch_student->get_result();
									if($res->num_rows>0){
										echo json_encode(array('status'=>'success','data'=>$res->fetch_all(MYSQLI_ASSOC)));
									}
									else{
										echo json_encode(array('status'=>'failed','message'=>'No results returned'));
									}
								}	
								
							}

							elseif(strcmp($_SESSION['account'],'sponsor')==0)
							{
								if(strcmp($app->request()->params('class'), "all")==0){
									$pagesize=10;
									$start=0;
									if(strcmp($app->request()->params('pagination'),'true')==0)
										{
											if($app->request()->params('pagesize'))
												{
													$pagesize=$app->request()->params('pagesize');
												}

											if($app->request()->params('from'))
												{
													$start=($app->request()->params('from')-1);
												}

											
											$fetch_student=$db->prepare('SELECT e.enrollment_id,c.class_id,c.class_name,c.short_class_name,s.student_id,s.f_name,s.l_name,s.dob,s.username,sb.payment_status FROM classes AS c JOIN enrollments AS e ON c.class_id=e.class_id JOIN subscriptions AS sb ON sb.enrollment_id=e.enrollment_id JOIN students AS s ON s.student_id=e.student_id WHERE s.sponsor_id=? AND e.enrollment_status=1 AND e.enrollment_id>? ORDER BY c.class_id ASC LIMIT ?');
											$fetch_student->bind_param('iii',$sponsor_id,$floor,$size);
											$floor=$start;
											$size=$pagesize;							
									}
									else{
										$fetch_student=$db->prepare('SELECT e.enrollment_id,c.class_id,c.class_name,c.short_class_name,s.student_id,s.f_name,s.l_name,s.dob,s.username,sb.payment_status FROM classes AS c JOIN enrollments AS e ON c.class_id=e.class_id JOIN subscriptions AS sb ON sb.enrollment_id=e.enrollment_id JOIN students AS s ON s.student_id=e.student_id WHERE s.sponsor_id=? AND e.enrollment_status=1 ORDER BY c.class_id ASC');
										$fetch_student->bind_param('i',$sponsor_id);
									}

									$sponsor_id=sanitize($db,$_SESSION['user']);	
									if(!$fetch_student->execute()){
										die($db->error);
									}else{
										$res=$fetch_student->get_result();
										if($res->num_rows>0){
											echo json_encode(array('status'=>'success','data'=>$res->fetch_all(MYSQLI_ASSOC)));
										}
										else{
											echo json_encode(array('status'=>'failed','message'=>'No results returned'));
										}
									}	
								}
								elseif($app->request()->params('class')){
									$fetch_student=$db->prepare('SELECT e.enrollment_id,c.class_id,c.class_name,c.short_class_name,s.student_id,s.f_name,s.l_name,s.username,s.dob FROM classes AS c JOIN enrollments AS e ON c.class_id=e.class_id JOIN students AS s ON s.student_id=e.student_id WHERE s.sponsor_id=? AND e.class_id=? AND e.enrollment_status=1');

										$fetch_student->bind_param('ii',$sponsor_id,$class_id);
										$sponsor_id=sanitize($db,$_SESSION['user']);
										$class_id=sanitize($db,$app->request()->params('class'));
										
										if(!$fetch_student->execute()){
											die($db->error);
										}else{
											$res=$fetch_student->get_result();
											if($res->num_rows>0){
												if($res->num_rows>0)
												{
													$new_array=array();
													$res_set=$res->fetch_all(MYSQLI_ASSOC);
													foreach ($res_set as $rsl) 
													{
														$enroll_array=$rsl;
														$sub=check_subscription($rsl['enrollment_id']);
														if($sub!=false)
														{
															$enroll_array['payment_status']=1;
														}
														else
														{
															$enroll_array['payment_status']=0;
														}
														array_push($new_array,$enroll_array);
													}
													echo json_encode(array('status'=>'success','data'=>$new_array));
													$fetch_student->close();
													$db->close();
													exit();
												}
											}
											else{
												echo json_encode(array('status'=>'failed','message'=>'No results returned'));
											}
										}								
									}
									else{
										$res=fetch_classification($_SESSION['user']);

										if(sizeof($res)>0)
											{
												echo json_encode(array('status'=>'success','data'=>$res));
												exit();
											}
											else
											{
												echo json_encode(array('status'=>'failed','message'=>'You have not enrolled any student for any class.'));
											}
									}
							}
					}
				}
			}

			else
			{
				echo json_encode(array('status'=>'failed','message'=>'You dont have permission to proceed.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'failed','message'=>'Please Login to proceed'));
		}
	}

	else
	{
		echo json_encode(array('status'=>'failed','message'=>'Please Login to proceed'));
	}
}

function check_enrollment($student_id,$class_id)
	{
		if(isset($student_id) && !empty($student_id) && isset($class_id) && !empty($class_id))
		{
			$db=connect_db();
			$check_enrollment=$db->prepare("SELECT enrollment_id FROM enrollments WHERE student_id=? AND class_id=? AND enrollment_status=1 LIMIT 1");
			$check_enrollment->bind_param('ii',$student,$class);
			$student=sanitize($db,$student_id);
			$class=sanitize($db,$class_id);

			if(!$check_enrollment->execute())
			{
				die($db->error);
			}

			else
			{
				$res=$check_enrollment->get_result();

				if($res->num_rows>0)
				{
					$enrollment_id=$res->fetch_assoc()['enrollment_id'];
					$check_enrollment->close();
					return $enrollment_id;
				}
				else
				{
					$check_enrollment->close();
					return false;
				}
			}
		}

		else
		{
			return false;
		}
	}

function check_subscription($enrollment_id)
{
	if(isset($enrollment_id) && !empty($enrollment_id))
	{
		$db=connect_db();
		$check_subscription=$db->prepare("SELECT subscription_no,reciept_no,payment_status,date_paid,expiry_date FROM subscriptions WHERE enrollment_id=? AND expiry_date>? LIMIT 1");
		$check_subscription->bind_param('is',$enrollment,$expire);
		$expire=date("Y-m-d H:i:s");
		$enrollment=sanitize($db,$enrollment_id);

		if(!$check_subscription->execute())
		{
			die($db->error);
		}

		else
		{
			$res=$check_subscription->get_result();

			if($res->num_rows>0)
			{
				$subscription=$res->fetch_assoc();
				$check_subscription->close();
				return $subscription;
			}

			else
			{
				$check_subscription->close();
				return false;
			}
		}
	}

	else
	{
		return false;
	}
}

function fetch_classification($sponsor_id=0){
	$db=connect_db();
	if(isset($sponsor_id) && !empty($sponsor_id)){
		$fetch_student=$db->prepare('SELECT DISTINCT(c.class_id),c.class_id,c.class_name,c.short_class_name,c.class_pic,c.description,COUNT(e.enrollment_id) AS enrolled FROM classes AS c JOIN enrollments AS e ON c.class_id=e.class_id JOIN students AS s ON s.student_id=e.student_id WHERE s.sponsor_id=? AND e.enrollment_status=1 GROUP BY e.class_id');
			$fetch_student->bind_param('i',$sponsor);
			$sponsor=sanitize($db,$sponsor_id);
	}else{
		$fetch_student=$db->prepare('SELECT DISTINCT(c.class_id),c.class_id,c.class_name,c.short_class_name,c.class_pic,c.description,COUNT(e.enrollment_id) AS enrolled FROM classes AS c JOIN enrollments AS e ON c.class_id=e.class_id JOIN students AS s ON s.student_id=e.student_id WHERE e.enrollment_status=1 GROUP BY e.class_id');
	}
		
	if(!$fetch_student->execute())
	{
		die($db->error);
	}

	else
	{
		$res=$fetch_student->get_result();
		$res=$res->fetch_all(MYSQLI_ASSOC);
		$fetch_student->close();
		$db->close();
		return $res;
	}
}

function edit_student(){
	if(check_sponsor()){
		if(isset($_POST['student_id']) && !empty($_POST['student_id'])){
			$db=connect_db();

			$check_sponsor=$db->prepare("SELECT sponsor_id FROM students WHERE student_id=? AND status=1 LIMIT 1");
			$check_sponsor->bind_param('i',$stu);
			$stu=sanitize($db,$_POST['student_id']);

			if(!$check_sponsor->execute()){
				die($db->error);
			}
			else{
				$res=$check_sponsor->get_result();
				if($res->num_rows>0){
					$res=$res->fetch_assoc();
					if(strcmp($res['sponsor_id'], $_SESSION['user'])==0){
						$edited=array();
						$failed=array();
						if(isset($_POST['f_name']) && !empty($_POST['f_name'])){
							$update_name=$db->prepare("UPDATE students SET f_name=? WHERE student_id=?");
							$update_name->bind_param('si',$name,$id);
							$name=sanitize($db,$_POST['f_name']);
							$id=sanitize($db,$_POST['student_id']);

							if(!$update_name->execute()){
								die($db->error);
							}
							else{
								if($db->affected_rows>0){
									array_push($edited, 'first name');
									$update_name->close();
								}else{
									array_push($failed, 'first name');
									$update_name->close();
								}
							}
						}

						if(isset($_POST['l_name']) && !empty($_POST['l_name'])){
							$update_name=$db->prepare("UPDATE students SET l_name=? WHERE student_id=?");
							$update_name->bind_param('si',$name,$id);
							$name=sanitize($db,$_POST['l_name']);
							$id=sanitize($db,$_POST['student_id']);

							if(!$update_name->execute()){
								die($db->error);
							}
							else{
								if($db->affected_rows>0){
									array_push($edited, 'Last name');
									$update_name->close();
								}else{
									array_push($failed, 'Last name');
									$update_name->close();
								}
							}
						}

						if(isset($_POST['username']) && !empty($_POST['username'])){
							$update_user_name=$db->prepare("UPDATE students SET username=? WHERE student_id=?");
							$update_user_name->bind_param('si',$name,$id);
							$name=sanitize($db,$_POST['username']);
							$id=sanitize($db,$_POST['student_id']);

							if(!$update_user_name->execute()){
								die($db->error);
							}
							else{
								if($db->affected_rows>0){
									array_push($edited, 'username');
									$update_user_name->close();
								}else{
									array_push($failed, 'username');
									$update_user_name->close();
								}
							}
						}

						if(isset($_POST['dob']) && !empty($_POST['dob'])){
							$update_dob=$db->prepare("UPDATE students SET dob=? WHERE student_id=?");
							$update_dob->bind_param('si',$dob,$id);
							$dob=sanitize($db,$_POST['dob']);
							$id=sanitize($db,$_POST['student_id']);

							if(!$update_dob->execute()){
								die($db->error);
							}
							else{
								if($db->affected_rows>0){
									array_push($edited, 'dob');
									$update_dob->close();
								}
								else{
									array_push($failed, 'dob');
									$update_dob->close();
								}
							}
						}

						if(isset($_FILES['ppic']) && $_FILES['ppic']['size']>0)
						{
							$dest='resources/users/students';
							$accepted=array("JPG","JPEG","PNG","png","jpeg","jpg");
							$file=$_FILES['ppic'];
							$res_data=upload_image($file,$dest,$accepted);
							if($res_data['status']===1)
							{
								$res_dest=$res_data['message'];
								$update_pic=$db->prepare("UPDATE students SET profile_pic=? WHERE student_id=?");
								$update_pic->bind_param('si',$file_src,$stu_id);
								$file_src=$res_dest;
								$stu_id=sanitize($db,$_POST['student_id']);

								if(!$update_pic->execute())
									{
										die($db->error);
									}else{
										if($db->affected_rows>0){
											array_push($edited, 'Profile pic');
											$update_pic->close();
										}
										else{
											array_push($failed, 'Profile pic');
											$update_pic->close();
										}
									}
							}
						}

						if(isset($_POST['pass1']) && !empty($_POST['pass1']) && isset($_POST['pass2']) && !empty($_POST['pass2'])){
							if(strcmp($_POST['pass1'], $_POST['pass2'])==0){
								$update_pass=$db->prepare("UPDATE students SET password=? WHERE student_id=?");
								$update_pass->bind_param('si',$pass,$id);
								$pass=password_hash(sanitize($db,$_POST['pass1']),PASSWORD_DEFAULT);
								$id=sanitize($db,$_POST['student_id']);

								if(!$update_pass->execute()){
									die($db->error);
								}
								else{
									if($db->affected_rows>0){
										array_push($edited, 'Password');
										$update_pass->close();
									}
									else{
										array_push($failed, 'Password');
										$update_pass->close();
									}
								}

							}else{
								array_push($failed,array('field'=>'password'));
							}
						}
						echo json_encode(array('status'=>'success','edited'=>$edited,'failed'=>$failed));
					}else{
						echo json_encode(array('status'=>'failed','message'=>'You are not authorised for this action'));
					}
				}
				else{
					echo json_encode(array('status'=>'failed','message'=>'You are not authorised for this action'));
				}
			}
		}else{
			echo json_encode(array('status'=>'failed','message'=>'Please provide a student_id'));
		}
	}
	else{
		echo json_encode(array('status'=>'failed','message'=>'Please log in to continue'));
	}
}
?>