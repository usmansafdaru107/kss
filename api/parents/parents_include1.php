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
					echo json_encode(array('status'=>'failed','message'=>'Email address not available for use'));
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
				if(strlen($pass1)>8)
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
					fetch_sponsor($par_id);
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
		$fetch_logs=$db->query("SELECT sponsor_id,sponsor_name,sponsor_type,password FROM sponsors WHERE email='$login' OR phone='$login' LIMIT 1");
		if(!$fetch_logs)
			{
				die($db->error);
			}

			else
				{
					if($fetch_logs->num_rows>0)
						{
							$res=$fetch_logs->fetch_assoc();
							if(password_verify($password,$res['password']))
								{
									session_start();
									$_SESSION['user']=$res['sponsor_id'];
									$_SESSION['status']=true;
									$sponsor_id=$_SESSION['account']='sponsor';
									$_SESSION['username']=$res['sponsor_name'];
									$sponsor_type=$_SESSION['sponsor_type']=$res['sponsor_type'];

									$app=\Slim\Slim::getInstance();
									if($app->request->params('verify') && strcmp($app->request->params('verify'),'desktop')==0){
										if(isset($_POST['serialNumber']) && isset($_POST['serialNumber'])){
											$check_devices=$db->prepare("SELECT desktop_id,serialNumber FROM kass_desktop WHERE sponsor_id=? and status=1");
											$check_devices->bind_param('i',$sponsor);
											$sponsor=$sponsor_id
											if(!$check_devices->execute()){
												$check_devices->close();
												die($db->errror);
											}else{
												$res=$check_devices->get_result();
												$count=$res->num_rows;
												$res=$res->fetch_all(MYSQLI_ASSOC);
												if($sponsor_type==0){
													$get_count=$db->prepare("SELECT COUNT(student_id) AS student_count FROM students WHERE sponsor_id=?");
													$get_count=bind_param('i',$sponsor);
													$sponsor=$sponsor_id;

													if(!$get_count->execute()){
														$get_count->close();
														die($db->error);
													}else{
														$res=$get_count->get_result();
														$res=$res->fetch_assoc()['student_count'];

														if($count>=$res){
															$get_count->close();
															$db->close();

															echo json_encode(array('status'=>'failed','message'=>'You have reached the subscription limit of your package'));
															exit();
														}else{
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
																echo json_encode(array('status'=>'success','message'=>'Device verified successfuly'));
															}
														}
													}
												}else{
													if($count>=60){
														$get_count->close();
														$db->close();

														echo json_encode(array('status'=>'failed','message'=>'You have reached the subscription limit of your package,please upgrade'));
														exit();
													}else{
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
															echo json_encode(array('status'=>'success','message'=>'Device verified successfuly'));
														}
													}
												}
											}

										}else{
											echo json_encode(array('status'=>'failed','message'=>'Device verification failed'));	
										}
									}
									else{
										echo json_encode(array('status'=>'success','message'=>'You are Logged in as sponsor'));	
									}
									
									$db->close();
									exit();
								}

								else
								{
									echo json_encode(array('status'=>'failed','message'=>'Username Or password mismatch !'));
									$db->close();
									exit();
								}													
						}
						else
							{
								echo json_encode(array('status'=>'failed','message'=>'No Account is Associated with this username'));
								$db->close();
								exit();
							}
				}
	}

	else
		{
			echo json_encode(array('status'=>'warning','message'=>'Please Provide login details'));
		}
}

function fetch_sponsor($id)
	{
		if(isset($id) && !empty($id) && $id>0)
		{
			$db=connect_db();
			$id=sanitize($db,$id);
			$fetch_parent=$db->prepare("SELECT sponsor_id,sponsor_name,country,phone,profile_pic FROM sponsors WHERE sponsor_id=?");
			$fetch_parent->bind_param('i',$parent_id);
			$parent_id=$id;

			if(!$fetch_parent->execute())
			{
				die($db->error);
				$fetch_parent->close();
			}
			else
			{
				$res=$fetch_parent->get_result();
				echo json_encode($res->fetch_assoc());
				$fetch_parent->close();
			}
			$db->close();

		}
		else
		{
			echo json_encode(array("status"=>"failed","message"=>"Please provide parent_id"));
		}
	}

	function parent_sponsored($parent_id)
	{
		
	}
?>