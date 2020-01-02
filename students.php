<?php
function student_login()
	{
		session_start();
		if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['status']) && !empty($_SESSION['status']) && $_SESSION['status']==true)
		{
			echo json_encode(array('status'=>'failed','message'=>'Please Log out to continue'));
		}

		else
		{
			if(isset($_POST['username']) && isset($_POST['password']))
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
						if(password_verify($_POST['password'],$result_set['password']))
						{
							$_SESSION['user']=$result_set['student_id'];
							$_SESSION['status']=true;
							$_SESSION['account']='student';
							$_SESSION['username']=$result_set['username'];
							$_SESSION['student_name']=$result_set['f_name'].' '.$result_set['l_name'];
							echo json_encode(array('status'=>'success','message'=>'You are Logged in as Student'));	
						}

						else
						{
							echo json_encode(array('status'=>'failed','message'=>'Please enter the correct username and password'));
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
	}

function student_enrollments($student_id=0)
	{
		session_start();
		if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['status']) && !empty($_SESSION['status']) && $_SESSION['status']==true)
		{
			if(isset($_SESSION['account']) && !empty($_SESSION['account']))
			{
				if($_SESSION['account']=='student')
				{
					$db=connect_db();
					$fetch_student=$db->prepare('SELECT e.enrollment_id,s.student_id,c.class_id,c.class_name,c.short_class_name,c.class_pic FROM classes AS c JOIN enrollments AS e ON c.class_id=e.class_id JOIN students AS s ON s.student_id=e.student_id WHERE s.student_id=? AND e.enrollment_status=1');
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
							$res_set=$res->fetch_all(MYSQL_ASSOC);
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
							echo json_encode($new_array);
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

				else if($_SESSION['account']=='sponsor')
				{
					if(isset($student_id) && !empty($student_id))
					{
						$db=connect_db();
						$fetch_student=$db->prepare('SELECT e.enrollment_id,c.class_id,c.class_name,c.short_class_name,c.class_pic FROM classes AS c JOIN enrollments AS e ON c.class_id=e.class_id JOIN students AS s ON s.student_id=e.student_id WHERE s.student_id=? AND s.sponsor_id=? AND e.enrollment_status=1');
						$fetch_student->bind_param('ii',$student,$sponsor_id);
						$student=sanitize($db,$student_id);
						$sponsor_id=sanitize($db,$_SESSION['user']);

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
								$res_set=$res->fetch_all(MYSQL_ASSOC);
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
								echo json_encode($new_array);
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
					else
					{
						$db=connect_db();
						$app=\Slim\Slim::getInstance();

						if($app->request()->params('class'))
						{
							if($app->request()->params('class') && strcmp($app->request()->params('class'), 'all')==0)
							{
								$fetch_student=$db->prepare('SELECT student_id,f_name,l_name,dob,username FROM students WHERE sponsor_id=?');
								$fetch_student->bind_param('i',$sponsor_id);
								$sponsor_id=sanitize($db,$_SESSION['user']);

								if(!$fetch_student->execute())
								{
									die($db->error);
								}

								else
								{
									$res=$fetch_student->get_result();
									if($res->num_rows>0)
									{
										echo json_encode($res->fetch_all(MYSQL_ASSOC));
										$fetch_student->close();
										$db->close();
										exit();
									}
								}
							}
							else if($app->request()->params('class') && strcmp($app->request()->params('class'), 'unenrolled')==0){
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
										$students_array=$res->fetch_all(MYSQL_ASSOC);
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
										echo json_encode($students_array);
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
								$fetch_student=$db->prepare('SELECT e.enrollment_id,c.class_id,c.class_name,c.short_class_name,s.student_id,s.f_name,s.l_name,s.dob,s.username FROM classes AS c JOIN enrollments AS e ON c.class_id=e.class_id JOIN students AS s ON s.student_id=e.student_id WHERE s.sponsor_id=? AND e.class_id=? AND e.enrollment_status=1');
								$fetch_student->bind_param('ii',$sponsor_id,$class_id);

								$class_id=sanitize($db,$app->request()->params('class'));
								$sponsor_id=sanitize($db,$_SESSION['user']);
							}
						}

						else
							{
								$fetch_student=$db->prepare('SELECT DISTINCT(c.class_id),c.class_id,c.class_name,c.short_class_name,c.class_pic,COUNT(e.enrollment_id) AS enrolled FROM classes AS c JOIN enrollments AS e ON c.class_id=e.class_id JOIN students AS s ON s.student_id=e.student_id WHERE s.sponsor_id=? AND e.enrollment_status=1 GROUP BY e.class_id');
								$fetch_student->bind_param('i',$sponsor_id);
								$sponsor_id=sanitize($db,$_SESSION['user']);
							}

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
										$res_set=$res->fetch_all(MYSQL_ASSOC);
										if($app->request()->params('class'))
										{
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
										}
										else
										{
											$new_array=$res_set;
										}
										echo json_encode($new_array);
										$fetch_student->close();
										$db->close();
										exit();
									}
									else
									{
										echo json_encode(array('status'=>'failed','message'=>'No students enrolled for this class.'));
									}
								}
					}
				}

				else if($_SESSION['account']=='admin')
				{

				}

				else
				{
					echo json_encode(array('status'=>'failed','message'=>'You dont have permission to proceed.'));
				}
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
?>