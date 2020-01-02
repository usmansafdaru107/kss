<?php
function add_student()
	{
		session_start();
		if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['account'])
			&& !empty($_SESSION['account']) && strcmp($_SESSION['account'],'sponsor')==0 
			&& isset($_SESSION['status']) && $_SESSION['status']==true)
		{
			$db=connect_db();
			$find_student_count=$db->prepare("SELECT COUNT(student_id) AS total_students FROM students WHERE sponsor_id=? AND status=1");
			$find_student_count->bind_param('i',$sponsor);
			$sponsor=sanitize($db,$_SESSION['user']);

			if(!$find_student_count->execute())
			{
				die($db->error);
			}

			else
			{
				$res=$find_student_count->get_result();
				$res=$res->fetch_assoc()['total_students'];
				$find_student_count->close();
				if(isset($_SESSION['sponsor_type']) && $_SESSION['sponsor_type']==0 && $res<10 || isset($_SESSION['sponsor_type']) && $_SESSION['sponsor_type']==1)
				{
					if(isset($_POST['student_fname']) && !empty($_POST['student_fname']) 
						&& isset($_POST['student_lname']) && !empty($_POST['student_lname'])
						&& isset($_POST['dob']) && !empty($_POST['dob']) 
						&& isset($_POST['username']) && !empty($_POST['username']) 
						&& isset($_POST['password']) && !empty($_POST['password']))
					{
						$find_username=$db->prepare("SELECT student_id FROM students WHERE username=?");
						$find_username->bind_param("s",$uname);
						$uname=sanitize($db,$_POST['username']);
						if(!$find_username->execute())
						{
							die($db->error);
						}

						else
						{
							$result_set=$find_username->get_result();
							if($result_set->num_rows>0)
							{
								echo json_encode(array("status"=>"failed","message"=>"Username for student already taken, Please choose another"));
								$find_username->close();
								$db->close();
								exit();
							}
							else
							{
								$add_student=$db->prepare("INSERT INTO students (f_name,l_name,dob,username,password,sponsor_id) VALUES (?,?,?,?,?,?)");
								$add_student->bind_param("sssssi",$fname,$lname,$dob,$username,$password,$sponsor_id);
								$fname=sanitize($db,$_POST['student_fname']);
								$lname=sanitize($db,$_POST['student_lname']);
								$dob=val_dob(sanitize($db,$_POST['dob']));
								$username=sanitize($db,$_POST['username']);
								$password=password_hash(sanitize($db,$_POST['password']),PASSWORD_DEFAULT);
								$sponsor_id=sanitize($db,$_SESSION['user']);

								if(!$add_student->execute())
								{
									die($db->error);
								}

								else
								{
									$res=$db->insert_id;
									if($res>0)
									{
										if(isset($_FILES['ppic']) && $_FILES['ppic']['size']>0)
										{
											$dest='resources/users/students';
											$accepted=array("JPG","JPEG","PNG","png","jpeg","jpg");
											$file=$_FILES['ppic'];
											$res_data=upload_image($file,$dest,$accepted);
											if($res_data['status']===1)
											{
												$res_dest=$res_data['message'];
												$update_pic=$db->query("UPDATE students SET profile_pic='$res_dest' WHERE student_id='$res'");
												if(!$update_pic)
													{
														$dest="resources/users/students/default_student.png";
														$update_pic=$db->query("UPDATE students SET profile_pic='$res_dest' WHERE student_id='$res'");

														if(!$update_pic)
															{
																die($db->error);
															}
													}
											}
										}

										else
											{
												$dest="resources/users/students/default_student.png";
												$update_pic=$db->query("UPDATE students SET profile_pic='$dest' WHERE student_id='$res'");

												if(!$update_pic)
													{
														die($db->error);
													}
											}

											$find_username->close();
											$add_student->close();
											$db->close();
											echo json_encode(array("status"=>"success","message"=>"Student Added Successfully"));
									}
								}
							}
						}
					}

					else
					{
						echo json_encode(array("status"=>"failed","message"=>"Please fill in all the required fields"));
					}
				}

				else
				{
					echo json_encode(array('status'=>'failed','message'=>'Student capacity exceeded, Please upgrade to continue'));
				}
			}

		}
		else
		{
			echo json_encode(array("status"=>"failed","message"=>"You are not authorised to perform such an action"));
		}
	}

function fetch_student($student_id=0,$sponsor_id=0)
	{
		session_start();
			$sql='';
			if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['account'])
				&& !empty($_SESSION['account'])	&& isset($_SESSION['status']) && $_SESSION['status']==true)
			{
				$db=connect_db();
				$app=\Slim\Slim::getInstance();
				if(strcmp($_SESSION['account'],'sponsor')==0 || strcmp($_SESSION['account'],'admin')==0)
					{
						if(strcmp($_SESSION['account'],'sponsor')==0){
							if(isset($student_id) && !empty($student_id))
							{
									$sql=$db->prepare("SELECT sponsor_id,student_id,f_name,l_name,dob,username,profile_pic FROM students WHERE sponsor_id=? AND student_id=? AND status=1 LIMIT 1");
									$sql->bind_param('ii',$sponsor,$student);
									$student=$student_id;
							}
							else{
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

									$sql=$db->prepare("SELECT sponsor_id,student_id,f_name,l_name,dob,username,profile_pic FROM students WHERE sponsor_id=?  AND status=1 AND student_id>? ORDER BY  student_id ASC LIMIT ?");
									$sql->bind_param('iii',$sponsor,$floor,$size);
									$floor=$start;
									$size=$pagesize;							
							}else{
								$sql=$db->prepare("SELECT sponsor_id,student_id,f_name,l_name,dob,username,profile_pic FROM students WHERE sponsor_id=?  AND status=1 ORDER BY  student_id ASC");
								$sql->bind_param('i',$sponsor);
							}
						}
						$sponsor=sanitize($db,$_SESSION['user']);
						if(!$sql->execute()){
							die($db->error);
						}else{
							$res=$sql->get_result();
							if($res->num_rows){
								echo json_encode(array('status'=>'success','data'=>$res->fetch_all(MYSQLI_ASSOC)));
							}
							else{
								echo json_encode(array('status'=>'failed','message'=>'No data to display'));
							}
							
						}
					}
						elseif(strcmp($_SESSION['account'],'admin')==0) {
							if(isset($student_id) && !empty($student_id))
							{
								$sql=$db->prepare("SELECT sponsor_id,student_id,f_name,l_name,dob,username,profile_pic FROM students WHERE student_id=? AND status=1 LIMIT 1");
								$sql->bind_param('i',$student);
								$student=$student_id;
							}
							else{
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

									$sql=$db->prepare("SELECT sponsor_id,student_id,f_name,l_name,dob,username,profile_pic FROM students WHERE status=1 AND student_id>? ORDER BY  student_id ASC LIMIT ?");
									$sql->bind_param('iii',$sponsor,$floor,$size);
									$floor=$start;
									$size=$pagesize;	
								}else{
									$sql=$db->prepare("SELECT sponsor_id,student_id,f_name,l_name,dob,username,profile_pic FROM students WHERE status=1 ORDER BY  student_id ASC");
								}
							}
							if(!$sql->execute()){
								die($db->error);
							}else{
								$res=$sql->get_result();
								if($res->num_rows){
									echo json_encode(array('status'=>'success','data'=>$res->fetch_all(MYSQLI_ASSOC)));
								}
								else{
									echo json_encode(array('status'=>'failed','message'=>'No data to display'));
								}
								
							}
						}
					}

					else if(strcmp($_SESSION['account'],'student')==0)
						{
							$session=new sessionManager(session_id());
							$student=$_SESSION['user'];
							if(isset($student) && !empty($student))
							{
								$sql=$db->query("SELECT sp.sponsor_id,sp.sponsor_name,s.student_id,s.f_name,s.l_name,s.dob,s.username,s.profile_pic FROM students AS s JOIN sponsors AS sp ON sp.sponsor_id=s.sponsor_id WHERE s.student_id='$student' AND s.status=1 LIMIT 1");
								if(!$sql)
								{
									die($db->error);
								}

								elseif($sql->num_rows>0)
								{
									echo json_encode(array('status'=>'success','data'=>$sql->fetch_assoc()));
									exit();
								}
								else
								{
									echo json_encode(array('status' =>'failed','message'=>'No Results returned'.$student_id));
								}
							}
						}
					}
					else
					{
						echo json_encode(array("status"=>"failed","message"=>"Please login to continue"));
					}
	}

function delete_student($id)
	{
		session_start();
		if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['account'])
			&& !empty($_SESSION['account']) && strcmp($_SESSION['account'],'sponsor')==0 
			&& isset($_SESSION['status']) && $_SESSION['status']==true)
		{
			$db=connect_db();
			$id=sanitize($db,$id);
			$get_student=$db->prepare("SELECT student_id,sponsor_id FROM students WHERE student_id=? AND status=1 LIMIT 1");
			$get_student->bind_param('i',$student_no);
			$student_no=$id;

			if(!$get_student->execute())
			{
				die($db->error);
				$get_student->close();
				$db->close();
			}
			else
			{
				$res_res=$get_student->get_result();
				if($res_res->num_rows>0)
				{
					$res_assoc=$res_res->fetch_assoc();
					if($_SESSION['user']==$res_assoc['sponsor_id'])
					{
						$get_student->close();
						$delete_student=$db->query("UPDATE students SET status=0 WHERE student_id='$id'");
						if(!$delete_student)
						{
							die($db->error);
						}

						else
						{
							echo json_encode(array('status'=>'success','message'=>'Student deleted successfully'));
							$db->close();
						}
					}
					else
					{
						echo json_encode(array("status"=>"failed","message"=>"You are not authorised for this action"));
						$db->close();
					}
				}
				else
				{
					echo json_encode(array("status"=>"failed","message"=>"Student does not exist"));
					$get_student->close();
					$db->close();	
				}
			}
		}
		else
		{
			echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
		}
	}

function update_student($id)
	{

	}

function enroll_student()
	{
		if(isset($_POST["student_id"]) && !empty($_POST["student_id"]) && isset($_POST["class_id"]) && !empty($_POST["class_id"]))
		{
			$db=connect_db();

			if(check_class($_POST["class_id"],$db)==true)
				{
					if(enroll_singular($_POST["student_id"],$_POST["class_id"],$db)==true)
					{
						echo json_encode(array('status'=>'success','message'=>'Student enrolled successfully'));
					}
					else
					{
						echo json_encode(array('status'=>'failed','message'=>'Student not enrolled successfully'));
					}

				}
				else
				{
					echo json_encode(array('status'=>'failed','message'=>'Class does not exist on Kampala Smart School'));
				}
			
		}
		else if(isset($_POST["students"]) && !empty($_POST["students"]) && isset($_POST["class_id"]) && !empty($_POST["class_id"]))
		{
			$db=connect_db();
			if(check_class($_POST["class_id"],$db)==true)
				{
					$students_array=explode(',',$_POST["students"]);
					$success=array();
					$failure=array();
					foreach ($students_array as $student)
					{
						if(enroll_singular($student,$_POST["class_id"],$db)==true)
						{
							array_push($success,$student);
						}
						else
						{
							array_push($failure,$student);
						}
					}

					if(sizeof($success)>0 && sizeof($failure)==0)
					{
						echo json_encode(array('status'=>'success','message'=>'Students added successfully','success'=>$success,'failed'=>$failure));
					}
					else if(sizeof($success)>0 && sizeof($failure)>0)
					{
						echo json_encode(array('status'=>'success','message'=>'Students added successfully, some failed to enroll','success'=>$success,'failed'=>$failure));
					}
					else
					{
						echo json_encode(array('status'=>'failed','message'=>'Students not added successfully, some failed to enroll','success'=>$success,'failed'=>$failure));
					}
				}
				else
				{
					echo json_encode(array('status'=>'failed','message'=>'Class does not exist on Kampala Smart School'));
				}
		}
}

function check_class($class,$db)
{
	$check_class=$db->prepare("SELECT class_id FROM classes WHERE class_id=? LIMIT 1");
	$check_class->bind_param('i',$class_id);
	$class_id=sanitize($db,$class);

	if(!$check_class->execute())
	{
		die($db->error);
	}
	else
	{
		$res_class=$check_class->get_result();
		if($res_class->num_rows>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

function enroll_singular($student_id,$class_id,$db)
{
		$check_student=$db->prepare("SELECT student_id FROM students WHERE student_id=? LIMIT 1");
		$check_student->bind_param('i',$student_no);
		$student_no=sanitize($db,$student_id);

		if(!$check_student->execute())
		{
			die($db->error);
		}

		else
		{
			$res=$check_student->get_result();
			if($res->num_rows>0)
			{
				$check_enrollments=$db->query("SELECT enrollment_id FROM enrollments WHERE student_id='$student_no' AND class_id='$class_id' AND enrollment_status=1 LIMIT 1");
				if(!$check_enrollments)
				{
					die($db->error);
				}
				else
				{
					if($check_enrollments->num_rows>0)
					{
						return false;
					}

					else
					{
						$enroll_student=$db->query("INSERT INTO enrollments (student_id,class_id,date_enrolled) VALUES ('$student_no','$class_id',NOW())");
						if(!$enroll_student)
						{
							die($db->error);
						}
						else
						{
							if($db->affected_rows==1)
							{
								return true;
							}
							else
							{
								return false;
							}
						}
					}
				}
			}
			else
			{
				return false;
			}
		}
}

function un_enroll()
	{
		session_start();
		if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['account'])
			&& !empty($_SESSION['account']) && strcmp($_SESSION['account'],'sponsor')==0 
			&& isset($_SESSION['status']) && $_SESSION['status']==true)
		{
			if(isset($_POST["student_id"]) && !empty($_POST["student_id"]) && isset($_POST["class_id"]) && !empty($_POST["class_id"]))
			{
				$db=connect_db();
				$find_student=$db->prepare("SELECT e.enrollment_id,sp.sponsor_id,e.enrollment_status FROM enrollments AS e JOIN students AS s ON e.student_id=s.student_id
											JOIN sponsors AS sp ON sp.sponsor_id=s.sponsor_id WHERE s.student_id=? AND e.class_id=? AND 
											s.status=1 AND sp.status=1 AND e.enrollment_status=1");
				$find_student->bind_param("ii",$student_id,$class_id);
				$student_id=sanitize($db,$_POST['student_id']);
				$class_id=sanitize($db,$_POST['class_id']);

				if(!$find_student->execute())
				{
					die($db->error);
				}
				else
				{
					$res_students=$find_student->get_result();
					if($res_students->num_rows>0)
					{
						$res=$res_students->fetch_assoc();
							if($res['sponsor_id']==$_SESSION['user'])
							{
								$find_student->close();
								$enrollment=$res['enrollment_id'];
								$un_enroll=$db->query("UPDATE enrollments SET enrollment_status=0,date_un_enrolled=NOW() WHERE enrollment_id='$enrollment'");
								if(!$un_enroll)
								{
									die($db->error);
								}

								else
								{
									echo json_encode(array("status"=>"success","message"=>"Student unenrolled succcessfully"));
									$db->close();
								}

							}
							else
							{
								echo json_encode(array("status"=>"failed","message"=>"You are not authorised to perform this action"));
								$find_student->close();
								$db->close();
							}
					}
					else
					{
						echo json_encode(array("status"=>"failed","message"=>"Student not enrolled for this class"));
					}
				}
			}
			else
			{
				echo json_encode(array("status"=>"failed","message"=>"Please provide both the students ID and Class"));
			}
		}
		else
		{
			echo json_encode(array("status"=>"failed","message"=>"Please Login to continue"));	
		}
	}

function subscribe()
{
	session_start();
	set_time_limit(300);
	if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['account'])
		&& !empty($_SESSION['account']) && strcmp($_SESSION['account'],'sponsor')==0 
		&& isset($_SESSION['status']) && $_SESSION['status']==true)
	{
		$app=\Slim\Slim::getInstance();
		if($app->request()->params('check_fee') && strcmp($app->request()->params('check_fee'),'true')==0)
		{
			if(isset($_POST['enrollments']) && !empty($_POST['enrollments']) && isset($_SESSION['sponsor_type']))
			{
				$enrollments=sizeof(explode(',',$_POST['enrollments']));

				if($_SESSION['sponsor_type']==0){
					echo json_encode(array('status'=>'success','amount'=>"'".($enrollments*60000)."'","count"=>$enrollments,"cost_per_child"=>"60000"));
					exit();
				}
				else
				{
					echo json_encode(array('status'=>'success','amount'=>"'".($enrollments*10000)."'","count"=>$enrollments,"cost_per_child"=>"10000"));
					exit();
				}
				
			}
			else{
				echo json_encode(array('status'=>'failed'));
				exit();
			}
			
		}
		else if($app->request()->params('confirm') && strcmp($app->request()->params('confirm'),'true')==0){
			if(isset($_POST['reciept']) && !empty($_POST['reciept']) && isset($_POST['phone']) && !empty($_POST['phone'])){
				$db=connect_db();
				$confirm=$db->prepare('SELECT reciept_no FROM yo_payments WHERE sponsor_id=? AND phone_no=? AND yo_ref=? LIMIT 1');
				$confirm->bind_param('isi',$sponsor_id,$phone,$reciept_no);
				$sponsor_id=$_SESSION['user'];
				$phone=sanitize($db,$_POST['phone']);
				$reciept_no=sanitize($db,$_POST['reciept']);

				if(!$confirm->execute()){
					die($db->error);
				}else{
					$res=$confirm->get_result();
					$res=$res->fetch_assoc();

					if($res['reciept_no']!=null)
					{
						$confirmation=json_decode(confirm_payment($res['reciept_no'],$_POST['phone']),true);
						if(strcmp($confirmation['status'],'OK')==0 && strcmp($confirmation['status_code'],'202')==0)
						{
							if(strcmp($confirmation['tx_status'], 'PENDING')==0){

								$update_payments=$db->prepare("UPDATE yo_payments SET ref_txt=? WHERE yo_ref=?");
								$update_payments->bind_param('si',$ref_txt,$yo_ref);
								$ref_txt=$confirmation['tx_reference'];
								$yo_ref=sanitize($db,$_POST['reciept']);

								if(!$update_payments->execute()){
									die($db->error);
								}
								else{
									$db->close();
									echo json_encode(array('status'=>'success','message'=>'The mobile money transaction request was sent successfully'));
									exit();
								}
							}
							else{
								echo json_encode(array('status'=>'failed','message'=>'The mobile money transaction request was not sent successfully'));
							}

						}else{
							$confirm->close();
							$update_payments=$db->prepare("UPDATE yo_payments SET status=-1 WHERE yo_ref=?");
							$update_payments->bind_param('i',$yo_ref);
							$yo_ref=sanitize($db,$_POST['reciept']);

							if(!$update_payments->execute()){
								die($db->error);
							}
							else{
									$db->close();
									//echo json_encode($confirmation);
									echo json_encode(array('status'=>'failed','message'=>'The Mobile money transaction failed, please try again later'));
								}
							exit();
						}

					}
					else{
						$confirm->close();
						$db->close();
						echo json_encode(array('status'=>'failed','message'=>'The transaction was not validated, please try again later'));
						exit();
					}
				}
			}
			else{
				echo json_encode(array('status'=>'failed','message'=>'Please fill in all details'));
			}
		}
		else
		{
			if(isset($_POST['method']) && !empty($_POST['method']) && strcmp($_POST['method'], 'yo')==0 && isset($_SESSION['sponsor_type']))
				{
					if(isset($_POST['phone_no']) && !empty($_POST['phone_no']) && isset($_POST['carrier_code']) && !empty($_POST['carrier_code']) && isset($_POST['enrollments']) && !empty($_POST['enrollments']))
					{
						$db=connect_db();
						$enrollments=explode(',',$_POST['enrollments']);
						multiple_subscriptions($enrollments,'YO',$db);

						$sub_count=sizeof($enrollments);
						if($sub_count>0)
						{
							$add_yo=$db->prepare("INSERT INTO yo_payments (sponsor_id,amount,phone_no,carrier_code,subscription_count) VALUES (?,?,?,?,?)");
							$add_yo->bind_param('iissi',$sponsor,$amount,$phone,$carrier,$cnt);
							$sponsor=sanitize($db,$_SESSION['user']);

							if($_SESSION['sponsor_type']==0)
							{
								$amount=($sub_count*60000);
							}
							else if($_SESSION['sponsor_type']==1)
							{
								$amount=($sub_count*10000);
							}

							$phone=sanitize($db,$_POST['phone_no']);
							$carrier=sanitize($db,$_POST['carrier_code']);
							$cnt=$sub_count;

							if(!$add_yo->execute())
							{
								die($db->error);
								$add_yo->close();
							}

							else
							{
								$yo_ref=$db->insert_id;
								$residual=subscribe_json($yo_ref,$amount,$phone,$_SESSION['user']);
								$json_res=json_decode($residual,true);
								if(strcmp($json_res['status'],'OK')==0)
								{
									if(strcmp($json_res["status_code"],'201')==0)
									{
										$update_yo=$db->prepare('UPDATE yo_payments SET reciept_no=?,initiated=? WHERE yo_ref=?');
										$update_yo->bind_param('sii',$rcpt,$init,$ref);
										$rcpt=$json_res['request_id'];
										$init=$json_res['confirmation']['total_mm'];
										$ref=$yo_ref;

										if(!$update_yo->execute())
										{
											die($db->error);
										}
										else
										{
											$update_yo->close();
											update_subscriptions($enrollments,0,$yo_ref,$db);
											$charge=$json_res['confirmation']['total_mm'];
											$phone=$json_res['confirmation']['sender_phone'];
											echo json_encode(array('status'=>'success','reciept_no'=>''.$yo_ref.'','phone'=>$phone,'charge'=>$charge,'subscribed'=>$cnt,'subscribed_list'=>$enrollments));
										}
									}
									else{
										echo json_encode(array('status'=>'failed','message'=>'Your kkk transaction failed, please try again later'));
									}
							}else{
									echo json_encode(array('status'=>'failed','message'=>'Your transaction failed, please try again later'));
							}
						}									
					}
					else
					{
						echo json_encode(array('status'=>'failed','message'=>'Your transaction failed, please Check the list of students you are trying to enroll,they might have subscibed already'));
					}	
				}
				else
					{
						echo json_encode(array('status'=>'failed','message'=>'Please Fill in all payment details to continue'));	
					}
				}
				else if(strcmp($_POST['method'], 'paypal'))
				{
					if(isset($_POST['enrollments']) && !empty($_POST['enrollments']))
					{
						$db=connect_db();
						$enrollments=explode(',',$_POST['enrollments']);
						multiple_subscriptions($enrollments,'PAYPAL',$db);

						$sub_count=sizeof($enrollments);
						if($sub_count>0)
						{
							$add_yo=$db->prepare("INSERT INTO paypal_payments (sponsor_id,amount,phone_no,carrier_code,date_paid,subscription_count) VALUES (?,?,?,?,NOW(),?)");
						}
					}
					else
					{
						echo json_encode(array('status'=>'failed','message'=>'Please provide a list of students to subscribe'));
					}
				}
			
			else
			{
				echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
			}
		}
	}
	else{
		echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
	}
}

function subscribe_json($yo_ref,$amount,$mm_number,$user_ref)
{
	//https://41.220.12.206/services/yopaymentsdev/task.php
	$data=array();
	$data['action']="initiate_mobile_money_payments";
	$data['merchant_code']="333";
	$data['sender_reference']=$user_ref;
	$data['sender_phone']=$mm_number;
	$data['amount']=$amount;
	$data['external_ref']=$yo_ref;
	$json_data=json_encode($data);



	//"merchant_code":"1001", "sender_reference":"1000", "sender_phone":"256783086794", "amount": "2000", "external_ref":"0001"

	$curly=curl_init();
	curl_setopt($curly, CURLOPT_URL, "https://pocketmoney.infosis.uk/Api/"); //set to API endpoint
	curl_setopt($curly, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($curly, CURLOPT_SSL_VERIFYPEER, 0);
	//curl_setopt($curly, CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($curly, CURLOPT_RETURNTRANSFER, true); // tell curl to return data in a variable 
	curl_setopt($curly, CURLOPT_HEADER, false); 
	curl_setopt($curly, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization-Key:CEBMPKPYUVVB7AGC3QRX9HBHCT8T7PKAMXA69HXPRN6G93WV7JA ")); 
	curl_setopt($curly, CURLOPT_POST, true); 
	curl_setopt($curly, CURLOPT_POSTFIELDS, $json_data); // post the xml 
	//curl_setopt($c, CURLOPT_TIMEOUT, (int)60); // set timeout in seconds
	//$xml->save('fileName.xml');

	$data=curl_exec($curly);

	if(curl_errno($curly))
	{
		//print_r(curl_error($curly));
		return false;
	}

	else
	{
		curl_close($curly);
		return $data;
	}
}

function confirm_payment($reciept,$mm_number){
	$data=array();
	$data['action']="initiate_mobile_money_payments_confirmed";
	$data['sender_phone']=$mm_number;
	$data['request_id']=$reciept;
	$json_data=json_encode($data);

	$curly=curl_init();
		curl_setopt($curly, CURLOPT_URL, "https://pocketmoney.infosis.uk/Api/"); //set to API endpoint
		curl_setopt($curly, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curly, CURLOPT_SSL_VERIFYPEER, 0);
		//curl_setopt($curly, CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($curly, CURLOPT_RETURNTRANSFER, true); // tell curl to return data in a variable 
		curl_setopt($curly, CURLOPT_HEADER, false); 
		curl_setopt($curly, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization-Key:CEBMPKPYUVVB7AGC3QRX9HBHCT8T7PKAMXA69HXPRN6G93WV7JA ")); 
		curl_setopt($curly, CURLOPT_POST, true); 
		curl_setopt($curly, CURLOPT_POSTFIELDS, $json_data); // post the xml 
		//curl_setopt($c, CURLOPT_TIMEOUT, (int)60); // set timeout in seconds
		//$xml->save('fileName.xml');

		$data=curl_exec($curly);

		if(curl_errno($curly))
		{
			//print_r(curl_error($curly));
			return false;
		}

		else
		{
			curl_close($curly);
			return $data;
		}
}
//0700470555

function verify_json($ref,$ref_txt)
{
	$data=array();
	$data['action']="mobile_money_payments_check_status";
	$data['tx_reference']=$ref_txt;
	$data['external_ref']=$ref;
	$data['merchant_code']='333';
	$json_data=json_encode($data);



	//"merchant_code":"1001", "sender_reference":"1000", "sender_phone":"256783086794", "amount": "2000", "external_ref":"0001"

	$curly=curl_init();
	curl_setopt($curly, CURLOPT_URL, "https://pocketmoney.infosis.uk/Api/"); //set to API endpoint
	curl_setopt($curly, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($curly, CURLOPT_SSL_VERIFYPEER, 0);
	//curl_setopt($curly, CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($curly, CURLOPT_RETURNTRANSFER, true); // tell curl to return data in a variable 
	curl_setopt($curly, CURLOPT_HEADER, false); 
	curl_setopt($curly, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization-Key:CEBMPKPYUVVB7AGC3QRX9HBHCT8T7PKAMXA69HXPRN6G93WV7JA ")); 
	curl_setopt($curly, CURLOPT_POST, true); 
	curl_setopt($curly, CURLOPT_POSTFIELDS, $json_data); // post the xml 
	//curl_setopt($c, CURLOPT_TIMEOUT, (int)60); // set timeout in seconds
	//$xml->save('fileName.xml');

	$data=curl_exec($curly);

	if(curl_errno($curly))
	{
		//print_r(curl_error($curly));
		return false;
	}

	else
	{
		curl_close($curly);
		return $data;
	}
}

function multiple_subscriptions(&$enrollments,$channel,$db)
{
	if(!isset($_SESSION))
	{
		session_start();
	}

	$subscribe=$db->prepare("INSERT INTO subscriptions (enrollment_id,channel,date_paid) VALUES (?,?,NOW())");
	$subscribe->bind_param('is',$e_id,$chnl);
	$chnl=$channel;

	$check_student=$db->prepare("SELECT s.student_id FROM enrollments AS e JOIN students AS s ON e.student_id=s.student_id WHERE s.status=1 AND e.enrollment_id=? AND s.sponsor_id=? LIMIT 1");
	$check_student->bind_param('ii',$enrolmnt_id,$sponsor_id);
	$sponsor_id=$_SESSION['user'];
	$new_list=array();

	$check_subscription=$db->prepare("SELECT subscription_no FROM subscriptions WHERE enrollment_id=? AND expiry_date>? LIMIT 1");
	$check_subscription->bind_param("is",$sid,$curr_date);
	$curr_date=date("Y-m-d H:i:s");

	foreach ($enrollments as $idx => $enrollment)
	{
		$sid=$enrollment;
		if(!$check_subscription->execute())
		{
			die($db->error);
		}
		else
		{
			$resi=$check_subscription->get_result();
			if($resi->num_rows==0)
			{
				$enrolmnt_id=$enrollment;
				if(!$check_student->execute())
				{
					die($db->error);
				}
				
				else
				{	$res=$check_student->get_result();
					if($res->num_rows>0)
					{
						$e_id=$enrollment;
						if(!$subscribe->execute())
							{
								die($db->error);
							}
							else
							{
								array_push($new_list,$db->insert_id);
							}
					}
				}
			}
		}
	}

	$subscribe->close();
	$check_student->close();
	$check_subscription->close();
	$enrollments=$new_list;
}

function update_subscriptions($enrollments,$status,$reciept,$db)
{
	if(!isset($_SESSION))
	{
		session_start();
	}

	$subscribe=$db->prepare("UPDATE subscriptions SET reciept_no=?,expiry_date=?,payment_status=? WHERE subscription_no=?");
	$subscribe->bind_param('isii',$rcpt_no,$expire,$sts,$e_id);

	if($status==1)
	{
		$expire=date('Y-m-d H:m:s',strtotime('+ 1 year'));
		$sts=1;
	}
	else
	{
		$expire='0000-00-00';
		$sts=0;
	}

	$rcpt_no=$reciept;

	foreach ($enrollments as $idx => $enrollment)
	{
		$e_id=$enrollment;
		if(!$subscribe->execute())
			{
				die($db->error);
			}
	}
	$subscribe->close();
}

function verify_payment($reciept){
	if(isset($reciept) && !empty($reciept))
	{
		session_start();
		if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['account'])
			&& !empty($_SESSION['account']) && strcmp($_SESSION['account'],'sponsor')==0 
			&& isset($_SESSION['status']) && $_SESSION['status']==true)
		{
				$db=connect_db();
				$check_reciept=$db->prepare("SELECT y.sponsor_id,y.ref_txt,s.email FROM yo_payments AS y JOIN sponsors AS s ON y.sponsor_id=s.sponsor_id WHERE y.yo_ref=? LIMIT 1");
				$check_reciept->bind_param("i",$reciept);

				if(!$check_reciept->execute()){
					die($db->error);
				}
				else{
					$res=$check_reciept->get_result();
					$nos=$res->num_rows;
					$res=$res->fetch_assoc();
					$email=$res['email'];
					if($nos>0)
					{
						if($res['sponsor_id']==$_SESSION['user']){
							$res=json_decode(verify_json($reciept,$res['ref_txt']),true);

							if(strcmp($res['status'],'OK')==0 && strcmp($res['status_code'],'201')==0)
							{
								if(strcmp($res['tx_status'],'SUCCEEDED')==0)
								{
									$update_yo=$db->prepare('UPDATE yo_payments SET status=1 WHERE yo_ref=?');
									$update_yo->bind_param('i',$rcp);
									$rcp=$reciept;

									if(!$update_yo->execute())
									{
										die($db->error);
									}
									else
									{
										$update_yo->close();
										//update_subscriptions($enrollments,1,$ref,$db);
										$update_payments=$db->prepare("UPDATE subscriptions SET payment_status=?,expiry_date=? WHERE reciept_no=?");
											  //$subscribe=$db->prepare("UPDATE subscriptions SET reciept_no=?,expiry_date=?,payment_status=? WHERE subscription_no=?");
										$update_payments->bind_param("isi",$status,$expire,$recpt);
										$status=1;
										$recpt=$reciept;
										$expire=date('Y-m-d H:m:s',strtotime('+ 1 year'));

										if(!$update_payments->execute()){
											die($db->error);
											$db->close();
											$update_payments->close();
											exit();
										}
										else
										{
											$get_reciept=$db->prepare("SELECT yo_ref,initiated,phone_no,date_paid,subscription_count FROM yo_payments WHERE yo_ref=? AND sponsor_id=? AND status=1 LIMIT 1");
											$get_reciept->bind_param('ii',$yo,$sponsor);
											$yo=$reciept;
											$sponsor=$_SESSION['user'];

											if(!$get_reciept->execute()){
												die($db->error);
											}else{
												$res=$get_reciept->get_result();
												if($res->num_rows>0){
													$res=$res->fetch_assoc();

													$template=new EmailTemplate('templates/payment_notification.html');
													$template->name=$_SESSION['username'];
													$template->sponsor_id=$_SESSION['user'];
													$template->reciept=$reciept;
													$template->date=$res['date_paid'];
													$template->count=$res['subscription_count'];
													$template->charge=$res['initiated'];
													$body=$template->compile();

													$emailer=new Emailer("noreply@kampalasmartschool.com","kass256elephants");
													$emailer->setTemplate($body);

													$mg="Hello ".$_SESSION['username'];
													$mg.=",Thank you for using Kampala Smart School!";
													$mg.="This is a summary of your payment; ";
													$mg.=" Sponsor id - ".$_SESSION['user'];
													$mg.=", Reciept number - ".$reciept;
													$mg.=", Date Paid - ".$res['date_paid'];
													$mg.=", Students Subscribed - ".$res['subscription_count'];
													$mg.=", Amount Paid -".$res['initiated'];

													$mg.=", For inquiries, email us to admin@kampalasmartschool.com or call 267776182222, 25670182224";
													$mg.="Kind regards,";
													$mg.="Kampala Smart School";

													$emailer->set_Alt_body($mg);
													$emailer->addSender("Kampala Smart School","noreply@kampalasmartschool.com");
													$emailer->addRecipient($_SESSION['username'],$email);
													$emailer->send("Kampala Smart School Payment");

													$template->setTemplate('templates/admin_payments_notice.html');
													$template->name=$_SESSION['username'];
													$template->account=$_SESSION['user'];
													$template->reciept=$reciept;
													$template->date=$res['date_paid'];
													$template->count=$res['subscription_count'];
													$template->charge=$res['initiated'];
													$body=$template->compile();

													$emailer->setTemplate($body);
													$mg="Hello Kampala Smart School, ".$_SESSION['username'];
													$mg.="has made some payments.";
													$mg.="This is a summary of the payment; ";
													$mg.=" Sponsor id - ".$_SESSION['user'];
													$mg.=", Reciept number - ".$reciept;
													$mg.=", Date Paid - ".$res['date_paid'];
													$mg.=", Students Subscribed - ".$res['subscription_count'];
													$mg.=", Amount Paid -".$res['initiated'];

													$mg.=" Kind regards,";
													$mg.=" Kampala Smart School.";

													$emailer->set_Alt_body($mg);
													$emailer->addRecipient("Kampala Smart School","admin@kampalasmartschool.com");
													$emailer->addRecipient("Kampala Smart School","kampalasmartschool@gmail.com");
													
													$emailer->send("New Payment notification");



													echo json_encode(array('status'=>'success','message'=>'Your transaction completed successfully','reciept_no'=>''.$res['yo_ref'].'','charge'=>''.$res['initiated'].'','date'=>''.$res['date_paid'].'','students_count'=>''.$res['subscription_count'].''));
													$update_payments->close();
													$db->close();
													exit();
												}
												else{
													echo json_encode(array('status'=>'failed','message'=>'Sorry, The payment has been successful but please verify again later'));
												}
											}
										}
									}
								}
								else if(strcmp($res['tx_status'],'PENDING')==0)
								{
										echo json_encode(array('status'=>'failed','message'=>'Your transaction is pending please try again later'));
								}

								else
								{
									$update_yo=$db->prepare('UPDATE yo_payments SET status=? WHERE yo_ref=?');
									$update_yo->bind_param('ii',$status,$rcp);
									$rcp=$reciept;
									$status=-1;

									if(!$update_yo->execute())
									{
										die($db->error);
									}
									else
									{
										echo json_encode(array('status'=>'failed','message'=>'Your transaction failed, please try again later'));
										exit();
									}
								}
							}
							else{
							echo json_encode(array("status"=>"failed","message"=>"Thetransaction failed"));
							}
						}
						else{
							echo json_encode(array("status"=>"failed","message"=>"You are not authorised to process this request"));
						}
					}
					else
					{
						echo json_encode(array("status"=>"failed","message"=>"Reciept Number does not exist"));
					}
					
				}
		}
		else
		{
			echo json_encode(array("status"=>"failed","message"=>"You are not authorised to process this request,please login to contuinue"));
		}
	}
}

function yo_ipn(){
	header("Status: 200");
	if(isset($_POST['date_time']) && !empty($_POST['date_time']) 
		&& isset($_POST['amount']) && !empty($_POST['amount'])
		&& isset($_POST['network_ref']) && !empty($_POST['network_ref'])
		&& isset($_POST['msisdn']) && !empty($_POST['msisdn'])
		&& isset($_POST['external_ref']) && !empty($_POST['external_ref'])
		&& isset($_POST['signature']) && !empty($_POST['signature'])){

			$fle=fopen("yo.txt", "c");
				fwrite($fle,$_SERVER['REQUEST_METHOD'].' '.$SERVER['REQUEST_URI']);
				fclose($fle);

	}
	else
	{
		$fle=fopen("yo.txt", "c");
		fwrite($fle,$_SERVER['REQUEST_METHOD'].' '.$SERVER['REQUEST_URI']);
		fclose($fle);
	}
}

?>