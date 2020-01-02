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

function fetch_student($student_id=0)
	{
		session_start();
			$sql='';
			if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['account'])
				&& !empty($_SESSION['account'])	&& isset($_SESSION['status']) && $_SESSION['status']==true)
			{
				$db=connect_db();
				if(strcmp($_SESSION['account'],'sponsor')==0)
					{
						$sponsor_id=$_SESSION['user'];
						if(isset($student) && !empty($student))
						{
							$sql=$db->query("SELECT sponsor_id,student_id,f_name,l_name,dob,username,profile_pic FROM students WHERE sponsor_id='$sponsor_id' AND student_id='$student_id' AND status=1 LIMIT 1");
							if(!$sql)
							{
								die($db->error);
							}
						}
						else
						{
							$sql=$db->query("SELECT sponsor_id,student_id,f_name,l_name,dob,username,profile_pic FROM students WHERE sponsor_id='$sponsor_id' AND status=1");
							if(!$sql)
							{
								die($db->error);
							}
						}
					}

					else if(strcmp($_SESSION['account'],'student')==0)
						{
							$student=$_SESSION['user'];
							if(isset($student) && !empty($student))
							{
								$sql=$db->query("SELECT sp.sponsor_id,sp.sponsor_name,s.student_id,s.f_name,s.l_name,s.dob,s.username,s.profile_pic FROM students AS s JOIN sponsors AS sp ON sp.sponsor_id=s.sponsor_id WHERE s.student_id='$student' AND s.status=1 LIMIT 1");
								if(!$sql)
								{
									die($db->error);
								}
							}
						}
				if(isset($sql) AND !empty($sql))
						{
							if($sql->num_rows>0)
							{
								if(isset($student_id) && !empty($student_id))
								{
									echo json_encode($sql->fetch_assoc());
								}
								else
								{
									echo json_encode($sql->fetch_all(MYSQLI_ASSOC));
								}
									$db->close();
									exit();
							}
							else
							{
								echo json_encode(array('status' =>'failed','message'=>'No Results returned'));
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
				echo json_encode(array('status'=>'success','amount'=>"'".($enrollments*20000)."'","count"=>$enrollments,"cost_per_child"=>"20000"));
				exit();
			}
			
		}
		else{
			echo json_encode(array('status'=>'failed'));
			exit();
		}
		
	}
	else
	{
		if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['account'])
			&& !empty($_SESSION['account']) && strcmp($_SESSION['account'],'sponsor')==0 
			&& isset($_SESSION['status']) && $_SESSION['status']==true && isset($_POST['method']) && !empty($_POST['method']))
		{
			if(strcmp($_POST['method'], 'yo')==0)
			{
				if(isset($_POST['phone_no']) && !empty($_POST['phone_no']) && isset($_POST['carrier_code']) && !empty($_POST['carrier_code']) && isset($_POST['enrollments']) && !empty($_POST['enrollments']))
				{
					$db=connect_db();
					$enrollments=explode(',',$_POST['enrollments']);
					multiple_subscriptions($enrollments,'YO',$db);

					$sub_count=sizeof($enrollments);
					if($sub_count>0)
					{
						$add_yo=$db->prepare("INSERT INTO yo_payments (sponsor_id,amount,phone_no,carrier_code,date_paid,subscription_count) VALUES (?,?,?,?,NOW(),?)");
						$add_yo->bind_param('iissi',$sponsor,$amount,$phone,$carrier,$cnt);
						$sponsor=sanitize($db,$_SESSION['user']);

						if($_SESSION['sponsor_type']==0)
						{
							$amount=($sub_count*60000);
						}
						else if($_SESSION['sponsor_type']==1)
						{
							$amount=($sub_count*20000);
						}

						$amount=($sub_count*60000);
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
							$residual=create_subscribe_xml($yo_ref,$amount,$phone,$carrier);
							$xml_res=new SimpleXMLElement($residual);
							$xml_res->asXml('updated.xml');
							if(strcmp($xml_res->Response->Status,'OK')==0)
							{
								if(strcmp($xml_res->Response->TransactionStatus,'SUCCEEDED')==0)
								{
									$update_yo=$db->prepare('UPDATE yo_payments SET reciept_no=?,status=1 WHERE yo_ref=?');
									$update_yo->bind_param('si',$rcpt,$ref);
									$rcpt=$xml_res->Response->TransactionReference;
									$ref=$yo_ref;

									if(!$update_yo->execute())
									{
										die($db->error);
									}
									else
									{
										$update_yo->close();
										update_subscriptions($enrollments,1,$ref,$db);
										echo json_encode(array('status'=>'success','message'=>'Your transaction completed successfully','reciept_no'=>''.$ref.'','charge'=>$amount,'subscribed'=>$cnt,'subscribed_list'=>$enrollments));
									}
								}
								else if(strcmp($xml_res->Response->TransactionStatus,'PENDING')==0)
								{
									$update_yo=$db->prepare('UPDATE yo_payments SET reciept_no=? WHERE yo_ref=?');
									$update_yo->bind_param('si',$rcpt,$ref);
									$rcpt=$xml_res->Response->TransactionReference;
									$ref=$yo_ref;


									if(!$update_yo->execute())
									{
										die($db->error);
									}
									else
									{
										$update_yo->close();
										update_subscriptions($enrollments,0,$ref,$db);
										echo json_encode(array('status'=>'success','message'=>'Your transaction is pending','reciept_no'=>''.$ref.'','charge'=>$amount,'subscribed'=>$cnt,'subscribed_list'=>$enrollments));
									}
								}

								else
								{
									echo json_encode(array('status'=>'failed','message'=>'Your transaction failed, please try again later'));
								}
							}
							else
							{
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
		}
		else
		{
			echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
		}
	}
	
	/*if(isset($_POST['enrollment_id']) && !empty($_POST['enrollment_id']))
	{

	}

	else if(isset($_POST['enrollments']) && !empty($_POST['enrollments']))
	{

	}

	else
	{
		echo json_encode(array('status'=>'failed','message'=>'Please Provide a list of enrolled students'));
	}*/
}

function create_subscribe_xml($res,$amount,$mm_number,$carrier_code)
{

	$xml=new DOMDocument('1.0','UTF-8');	
	$xml->formatOutput = false;
	$xml_autoCreate=$xml->createElement("AutoCreate");
		$xml_autoCreate->appendChild($xml->createElement("Amount",$amount));
	$xml_request=$xml->createElement("Request");
	$xml_request->appendChild($xml->createElement("APIUsername","100052269895"));
	$xml_request->appendChild($xml->createElement("APIPassword","FMFD-BHWA-sa8W-fHs9-5CFJ-zB9n-D1Dd-wQig"));
	$xml_request->appendChild($xml->createElement("Method","acdepositfunds"));
	//$xml_request->appendChild($xml->createElement("NonBlocking","TRUE"));
	$xml_request->appendChild($xml->createElement("Amount",$amount));
	$xml_request->appendChild($xml->createElement("Account",$mm_number));
	//$xml_request->appendChild($xml->createElement("AccountProviderCode",$carrier_code));
	$xml_request->appendChild($xml->createElement("ExternalReference",$res));
	//$xml_request->appendChild($xml->createElement("InstantNotificationUrl","https://www.kampalasmartschool.com/api/payments/yo/ipn"));
	$xml_request->appendChild($xml->createElement("Narrative","Testing Mobile money payments"));
	//$xml_request->appendChild($xml->createElement("ProvidedsdsdsdsdsrReferenceText","Kass Testing Mobile Money"));
	$xml_autoCreate->appendChild($xml_request);
	$xml->appendChild($xml_autoCreate);

	$xml->formatOutput = true; // set the formatOutput attribute of domDocument to true
	$f_xml = $xml->saveXML();

	$url="https://paymentsapi1.yo.co.ug/ybs/task.php";
	//https://41.220.12.206/services/yopaymentsdev/task.php

	$curly=curl_init();
	curl_setopt($curly, CURLOPT_URL, "https://paymentsapi1.yo.co.ug/ybs/task.php"); //set to API endpoint
	curl_setopt($curly, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($curly, CURLOPT_SSL_VERIFYPEER, 0);
	//curl_setopt($curly, CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($curly, CURLOPT_RETURNTRANSFER, true); // tell curl to return data in a variable 
	curl_setopt($curly, CURLOPT_HEADER, false); 
	curl_setopt($curly, CURLOPT_HTTPHEADER, array("Content-Type: text/xml", "Content-length: ".strlen($f_xml))); 
	curl_setopt($curly, CURLOPT_POST, true); 
	curl_setopt($curly, CURLOPT_POSTFIELDS, $f_xml); // post the xml 
	//curl_setopt($c, CURLOPT_TIMEOUT, (int)60); // set timeout in seconds
	$xml->save('fileName.xml');

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

function create_verify_xml($ref)
{

	$xml=new DOMDocument('1.0','UTF-8');	
	$xml->formatOutput = false;
	$xml_autoCreate=$xml->createElement("AutoCreate");
	$xml_request=$xml->createElement("Request");
	$xml_request->appendChild($xml->createElement("APIUsername","100052269895"));
	$xml_request->appendChild($xml->createElement("APIPassword","FMFD-BHWA-sa8W-fHs9-5CFJ-zB9n-D1Dd-wQig"));
	$xml_request->appendChild($xml->createElement("Method","actransactioncheckstatus"));
	$xml_request->appendChild($xml->createElement("TransactionReference",$ref));
	$xml_request->appendChild($xml->createElement("DepositTransactionType","PULL"));
	$xml_autoCreate->appendChild($xml_request);
	$xml->appendChild($xml_autoCreate);

	$xml->formatOutput = true; // set the formatOutput attribute of domDocument to true
	$f_xml = $xml->saveXML();

	$url="https://41.220.12.206/services/yopaymentsdev/task.php";

	$curly=curl_init();
	curl_setopt($curly, CURLOPT_URL, "https://paymentsapi2.yo.co.ug/ybs/task.php"); //set to API endpoint
	curl_setopt($curly, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($curly, CURLOPT_SSL_VERIFYPEER, 0);
	//curl_setopt($curly, CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($curly, CURLOPT_RETURNTRANSFER, true); // tell curl to return data in a variable 
	curl_setopt($curly, CURLOPT_HEADER, false); 
	curl_setopt($curly, CURLOPT_HTTPHEADER, array("Content-Type: text/xml", "Content-length: ".strlen($f_xml))); 
	curl_setopt($curly, CURLOPT_POST, true); 
	curl_setopt($curly, CURLOPT_POSTFIELDS, $f_xml); // post the xml 
	//curl_setopt($c, CURLOPT_TIMEOUT, (int)60); // set timeout in seconds 

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
				$check_reciept=$db->prepare("SELECT sponsor_id,reciept_no FROM yo_payments WHERE yo_ref=? LIMIT 1");
				$check_reciept->bind_param("i",$reciept);

				if(!$check_reciept->execute()){
					die($db->error);
				}
				else{
					$res=$check_reciept->get_result();
					$nos=$res->num_rows;
					$res=$res->fetch_assoc();
					if($nos>0)
					{
						if($res['sponsor_id']==$_SESSION['user']){
							$res=create_verify_xml($res['reciept_no']);
							$xml_res=new SimpleXMLElement($res);
							$xml_res->saveXML('output.xml');
							print_r($xml_res);
							if(strcmp($xml_res->Response->Status,"OK")==0 )
							{
								if(strcmp($xml_res->Response->TransactionStatus,'SUCCEEDED')==0)
								{
									$update_yo=$db->prepare('UPDATE yo_payments SET status=1,reciept=? WHERE yo_ref=?');
									$update_yo->bind_param('ii',$rcp,$recpt);
									$rcp=$xml_res->Response->IssuedReceiptNumber;
									$recpt=$reciept;

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
											echo json_encode(array('status'=>'success','message'=>'Your transaction completed successfully','reciept_no'=>''.$reciept.'','charge'=>''.$xml_res->Response->AmountFormatted.''));
											$update_payments->close();
											$db->close();
											exit();
										}
									}
								}
								else if(strcmp($xml_res->Response->TransactionStatus,'PENDING')==0)
								{
										$update_yo->close();
										echo json_encode(array('status'=>'success','message'=>'Your transaction is pending please try again later'));
								}

								else
								{
									echo json_encode(array('status'=>'failed','message'=>'Your transaction failed, please try again later'));
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