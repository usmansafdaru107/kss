<?php
	function register_sponsor()
	{
		if(isset($_POST['sponsor_name']) && !empty($_POST['sponsor_name']) && isset($_POST['type'])
			&& isset($_POST['country']) && !empty($_POST['country'])
			&& isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['phone']) && !empty($_POST['phone'])
			&& isset($_POST['password1']) && !empty($_POST['password1']) && isset($_POST['password2']) && !empty($_POST['password2'])
		 ){
			$db=connect_db();
			$errors=array();
			$full_name=filter_var(sanitize($db,$_POST['sponsor_name']),FILTER_SANITIZE_STRING);
			$type=filter_var(sanitize($db,$_POST['type']),FILTER_SANITIZE_STRING);
			$country=filter_var(sanitize($db,$_POST['country']),FILTER_SANITIZE_STRING);
			$email=filter_var(sanitize($db,$_POST['email']),FILTER_SANITIZE_STRING);
			$phone_no=filter_var(sanitize($db,$_POST['phone']),FILTER_SANITIZE_STRING);
			$pass1=filter_var(sanitize($db,$_POST['password1']),FILTER_SANITIZE_STRING);
			$pass2=filter_var(sanitize($db,$_POST['password2']),FILTER_SANITIZE_STRING);
			$password='';

			$check_existance=$db->prepare("SELECT sponsor_id FROM sponsors WHERE email=? OR phone=? LIMIT 1");
			$check_existance->bind_param('ss',$check_mail,$checkphone);
			$check_mail=$email;
			$checkphone=$phone_no;

			if(!$check_existance->execute())
			{
				die($db->error);
			}
			else
			{
				$res=$check_existance->get_result();
				if($res->num_rows>0)
				{
					echo json_encode(array('status'=>'failed','message'=>'Email address or phone not available for use'));
					$check_existance->close();
					$db->close();
					exit();
				}
			}

			
			if(strcmp($pass1,$pass2)!=0)
			{
				$errors['password']="Mismatching passwords";
			}
			else
			{
				if(strlen($pass1)>=5)
				{
					$password=password_hash($pass1,PASSWORD_DEFAULT);
				}
				else
				{
					$errors['password']="Password is too short";
				}
			}

			if(!empty($password) && count($errors)==0)
			{
				$add_parent=$db->prepare("INSERT INTO sponsors (sponsor_name,country,email,sponsor_type,phone,password) VALUES (?,?,?,?,?,?)");
				$add_parent->bind_param('sssiss',$fname,$ctry,$eml,$stype,$phone,$pass);
				$fname=$full_name;
				$ctry=$country;
				$eml=$email;
				$phone=$phone_no;
				$pass=$password;
				$stype=$type;

				if(!$add_parent->execute())
				{
					die($db->error);
				}
				else
				{
					$par_id=$db->insert_id;
					if(isset($_FILES['ppic']) && $_FILES['ppic']['size']>0)
						{
							$dest='resources/users/parents';
							$accepted=array("JPG","JPEG","PNG","png","jpeg","jpg");
							$file=$_FILES['ppic'];
							$res=upload_image($file,$dest,$accepted);
							if($res['status']===1)
							{
								$res_dest=$res['message'];
								$update_pic=$db->query("UPDATE sponsors SET profile_pic='$res_dest' WHERE sponsor_id='$par_id'");
								if(!$update_pic)
									{
										$dest="..resources/users/admins/default_admin.png";
										$update_pic=$db->query("UPDATE sponsors SET profile_pic='$res_dest' WHERE sponsor_id='$par_id'");

										if(!$update_pic)
											{
												die($db->error);
											}
									}
							}
						}

						else
							{
								$dest="resources/users/parents/default_parent.png";
								$update_pic=$db->query("UPDATE sponsors SET profile_pic='$dest' WHERE sponsor_id='$par_id'");

								if(!$update_pic)
									{
										die($db->error);
									}
							}
					$template=new EmailTemplate('templates/parent_registration.html');
					$template->name=$fname;
					$body=$template->compile();

					$emailer=new Emailer("noreply@kampalasmartschool.com","genieplayer");
					$emailer->setTemplate($body);

					$mg="Hello ".$fname;
					$mg.=",Welcome to Kampala Smart School!";
					$mg.="You have joined a community of parents and teachers, all striving to provide each of their children with the education they deserve";
					$mg.="To access our high quality lessons and resources aligned to the Uganda Primary School Curriculum, log in and enroll your child in their right class from Primary One to Primary Seven.";
					$mg.="For inquiries, email us to admin@kampalasmartschool.com or call 267776182222, 25670182224";
					$mg.="Kind regards,";
					$mg.="Kampala Smart School";

					$emailer->set_Alt_body($mg);
					$emailer->addSender("Kampala Smart School","noreply@kampalasmartschool.com");
					$emailer->addRecipient($fname,$eml);
					$emailer->send("Welcome to Kampala Smart School");

					$template=new EmailTemplate("templates/admin_send_reg.html");
					$template->type=($type==0? "parent":"school");
					$template->name=$full_name;
					$template->acc=$par_id;
					$template->reg_date=date("Y/m/d");
					$template->country=$country;
					$template->email=$email;
					$template->phone=$phone_no;

					$body=$template->compile();

					$mg="Name ".$full_name;
					$mg.=" Type ".($type==0? "parent":"school");
					$mg.=" Account number ".$par_id;
					$mg.=" Registration date ".date("Y/m/d");
					$mg.=" Country ".$country;
					$mg.=" Email ".$email;
					$mg.=" Phone ".$phone_no;
					$emailer->setTemplate($body);

					$emailer->set_Alt_body($mg);
					$emailer->addRecipient("Kampala Smart School","admin@kampalasmartschool.com");
					$emailer->addRecipient("Kampala Smart School","kampalasmartschool@gmail.com");
					
					$emailer->send("New Registration notification");

					echo json_encode(array('status'=>'success','message'=>'Please login to continue'));
					exit();
				}
			}
			else
			{
				echo json_encode(array('status'=>'failed','message'=>'Some errors occured','errors'=>$errors));
				exit();
			}
		}
		else
		{
			echo json_encode(array('status'=>'failed','message'=>'Please fill in all the details'));
			exit();
		}
	}

function sponsor_login()
{
	$db=connect_db();
	if(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password']))
	{
		$login=sanitize($db,$_POST['username']);
		$password=sanitize($db,$_POST['password']);
		$fetch_logs=$db->query("SELECT sponsor_id,sponsor_name,sponsor_type,profile_pic,password FROM sponsors WHERE email='$login' OR phone='$login' LIMIT 1");
		if(!$fetch_logs)
			{
				die($db->error);
			}

			else
				{
					if($fetch_logs->num_rows>0)
						{
							$res_sponsor=$fetch_logs->fetch_assoc();
							if(password_verify($password,$res_sponsor['password']))
								{
									session_start();
									session_regenerate_id();
									$sponsor_id=$_SESSION['user']=$res_sponsor['sponsor_id'];
									$_SESSION['status']=true;
									$_SESSION['account']='sponsor';
									$_SESSION['username']=$res_sponsor['sponsor_name'];
									$_SESSION['profile_pic']=$res_sponsor['profile_pic'];
									$sponsor_type=$_SESSION['sponsor_type']=$res_sponsor['sponsor_type'];

									$app=\Slim\Slim::getInstance();
									if($app->request->params('verify') && strcmp($app->request->params('verify'),'desktop')==0){
										if(isset($_POST['serialNumber']) && !empty($_POST['serialNumber'])){
											$check_devices=$db->prepare("SELECT desktop_id,serialNumber FROM kass_desktop WHERE sponsor_id=? and status=1");
											$check_devices->bind_param('i',$sponsor);
											$sponsor=$sponsor_id;
											if(!$check_devices->execute()){
												$check_devices->close();
												die($db->errror);
											}else{
												$res=$check_devices->get_result();
												$count=$res->num_rows;
												$sn=$res->fetch_all(MYSQLI_ASSOC);

												$get_count=$db->prepare("SELECT COUNT(DISTINCT e.student_id) AS student_count FROM students AS s JOIN sponsors AS sp ON s.sponsor_id=sp.sponsor_id JOIN enrollments AS e ON e.student_id=s.student_id JOIN subscriptions AS sb ON sb.enrollment_id=e.enrollment_id WHERE sp.sponsor_id=? AND sb.expiry_date>? AND sb.payment_status=1");
												$get_count->bind_param('is',$sponsor,$expiry);
												$sponsor=$sponsor_id;
												$expiry=date("Y-m-d H:i:s");

													if(!$get_count->execute()){
														$get_count->close();
														die($db->error);
													}else{
														$res=$get_count->get_result();
														$res=$res->fetch_assoc()['student_count'];
														if($count>=$res){
																	$get_count->close();
																	$db->close();

																	echo json_encode(array('status'=>'failed','message'=>'You have reached the subscription limit of your package, Subscibe students to continue'));
																	exit();
																}else{
																	if($count>0){
																		$exists=false;
																		foreach ($sn as $serial) {
																			if($serial['serialNumber']==$_POST['serialNumber']){
																				$exists=true;
																				break;
																			}
																		}

																		if($exists==false){
																			$add_serial=$db->prepare("INSERT INTO kass_desktop(sponsor_id,serialNumber) VALUES(?,?)");
																			$add_serial->bind_param('is',$sponsor,$sn);
																			$sponsor=$sponsor_id;
																			$sn=sanitize($db,$_POST['serialNumber']);

																			if(!$add_serial->execute()){
																				$add_serial->close();
																				die($db->error);
																				$db->close();
																			}
																			else{
																				echo json_encode(array('status'=>'success','message'=>'Device verified successfuly','data'=>$res_sponsor));
																			}																			
																		}
																		else{
																			echo json_encode(array('status'=>'success','message'=>'Your computer had already been verified','data'=>$res_sponsor));
																		}
																	}
																	else{
																			$add_serial=$db->prepare("INSERT INTO kass_desktop(sponsor_id,serialNumber) VALUES(?,?)");
																			$add_serial->bind_param('is',$sponsor,$sn);
																			$sponsor=$sponsor_id;
																			$sn=sanitize($db,$_POST['serialNumber']);

																			if(!$add_serial->execute()){
																				$add_serial->close();
																				die($db->error);
																				$db->close();
																			}
																			else{
																				echo json_encode(array('status'=>'success','message'=>'Device verified successfuly','data'=>$res_sponsor));
																			}
																	}
																}
													}
												}
											}
											else{
													echo json_encode(array("status"=>"failed","message"=>"Device verification failed"));
												}
								}
								else{
									echo json_encode(array('status'=>'success','message'=>'Welcome, you have logged in as a sponsor'));
								}
							}
							else{
								echo json_encode(array('status'=>'failed','message'=>'Please provide a valid email and password'));
							}
						}else{
							echo json_encode(array('status'=>'failed','message'=>'Please provide a valid email and password'));
						}
				}
		}else{
			echo json_encode(array('status'=>'failed','message'=>'Please provide both username and passord'));
		}
}

function fetch_sponsor($id=0)
	{
		session_start();
		if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['account'])
						&& !empty($_SESSION['account'])
						&& isset($_SESSION['status']) && $_SESSION['status']==true){
			$db=connect_db();
			if(isset($id) && !empty($id) || strcmp($_SESSION['account'],'sponsor')==0)
			{
				if(strcmp($_SESSION['account'],'sponsor')==0){
					$fetch_parent=$db->prepare("SELECT sponsor_id,sponsor_name,country,phone,profile_pic FROM sponsors WHERE sponsor_id=? AND status=1");
					$fetch_parent->bind_param('i',$parent_id);
					$parent_id=$_SESSION['user'];
				}
				else{
					$id=sanitize($db,$id);
					$fetch_parent=$db->prepare("SELECT sponsor_id,sponsor_name,country,phone,profile_pic FROM sponsors WHERE sponsor_id=? AND status=1");
					$fetch_parent->bind_param('i',$parent_id);
					$parent_id=$id;
				}

				if(!$fetch_parent->execute())
				{
					die($db->error);
					$fetch_parent->close();
				}
				else
				{
					$res=$fetch_parent->get_result();
					if($res->num_rows>0){
						echo json_encode($res->fetch_assoc());
						exit();
					}
					else{
						echo json_encode(array('status'=>'failed','message'=>'Nothing to show here'));
					}
					$fetch_parent->close();
					$db->close();
				}
			}
			else
			{
				if(strcmp($_SESSION['account'],'admin')==0){
					$fetch_parent=$db->prepare("SELECT sponsor_id,sponsor_name,country,phone,profile_pic FROM sponsors WHERE status=1");
					if(!$fetch_parent->execute()){
						die($db->error);
					}else{
						$res=$fetch_parent->get_result();
						if($res->num_rows>0){
							echo json_encode(array('status'=>'success','data'=>$res->fetch_all(MYSQLI_ASSOC)));
							$fetch_parent->close();
							$db->close();
							exit();
						}else{
							echo json_encode(array('status'=>'failed','message'=>"No results returned"));
						}
					}

				}else{
					echo json_encode(array("status"=>"failed","message"=>"Please provide parent_id"));
				}
			}
	}
	else{
		echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
	}
}

function edit_sponsor(){
	session_start();
	if(check_sponsor()){
		$db=connect_db();
		$edited=array();
		$failed=array();
		if(isset($_POST['name']) && !empty($_POST['name'])){
			$update_name=$db->prepare("UPDATE sponsors SET sponsor_name=? WHERE sponsor_id=?");
			$update_name->bind_param('si',$name,$id);
			$name=sanitize($db,$_POST['name']);
			$id=sanitize($db,$_SESSION['user']);

			if(!$update_name->execute()){
				die($db->error);
			}
			else{
				if($db->affected_rows>0){
					array_push($edited, 'Sponsor name');
					$update_name->close();
				}else{
					array_push($failed, 'Sponsor name');
					$update_name->close();
				}
			}
		}

		if(isset($_POST['country']) && !empty($_POST['country'])){
			$update_coutry=$db->prepare("UPDATE sponsors SET country=? WHERE sponsor_id=?");
			$update_coutry->bind_param('si',$country,$id);
			$country=sanitize($db,$_POST['country']);
			$id=sanitize($db,$_SESSION['user']);

			if(!$update_coutry->execute()){
				die($db->error);
			}
			else{
				if($db->affected_rows>0){
					array_push($edited, 'Country');
					$update_coutry->close();
				}else{
					array_push($failed, 'Country');
					$update_coutry->close();
				}
			}
		}

		if(isset($_POST['email']) && !empty($_POST['email'])){
			$update_email=$db->prepare("UPDATE sponsors SET email=? WHERE sponsor_id=?");
			$update_email->bind_param('si',$email,$id);
			$email=sanitize($db,$_POST['email']);
			$id=sanitize($db,$_SESSION['user']);

			if(!$update_email->execute()){
				die($db->error);
			}
			else{
				if($db->affected_rows>0){
					array_push($edited, 'email');
					$update_email->close();
				}
				else{
					array_push($failed, 'email');
					$update_email->close();
				}
			}
		}

		if(isset($_POST['phone']) && !empty($_POST['phone'])){
			$update_phone=$db->prepare("UPDATE sponsors SET phone=? WHERE sponsor_id=?");
			$update_phone->bind_param('si',$phone,$id);
			$phone=sanitize($db,$_POST['phone']);
			$id=sanitize($db,$_SESSION['user']);

			if(!$update_phone->execute()){
				die($db->error);
			}
			else{
				if($db->affected_rows>0){
					array_push($edited, 'Phone number');
					$update_phone->close();
				}
				else{
					array_push($failed, 'Phone number');
					$update_phone->close();
				}
			}
		}

		if(isset($_FILES['ppic']) && $_FILES['ppic']['size']>0)
		{
			$dest='resources/users/sponsors';
			$accepted=array("JPG","JPEG","PNG","png","jpeg","jpg");
			$file=$_FILES['ppic'];
			$res_data=upload_image($file,$dest,$accepted);
			if($res_data['status']===1)
			{
				$res_dest=$res_data['message'];
				$update_pic=$db->prepare("UPDATE sponsors SET profile_pic=? WHERE sponsor_id=?");
				$update_pic->bind_param('si',$file_src,$id);
				$file_src=$res_dest;
				$id=sanitize($db,$_SESSION['user']);

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
				$update_pass=$db->prepare("UPDATE sponsors SET password=? WHERE sponsor_id=?");
				$update_pass->bind_param('si',$pass,$id);
				$pass=password_hash(sanitize($db,$_POST['pass1']),PASSWORD_DEFAULT);
				$id=sanitize($db,$_SESSION['user']);

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
	}
	else{
		echo json_encode(array('status'=>'failed','message'=>'Please log in to continue'));
	}
}
?>