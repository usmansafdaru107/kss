<?php

function add_admin()
{
	session_start();

	if(isset($_SESSION['status']) && $_SESSION['status']==true && isset($_SESSION['account']) && $_SESSION['account']=='admin' && isset($_SESSION['previlege']) && $_SESSION['previlege']==1)
	{
		if(isset($_POST['f_name']) && !empty($_POST['f_name']) && isset($_POST['l_name']) 
		   && !empty($_POST['l_name']) && isset($_POST['email']) && !empty($_POST['email']) 
		   && isset($_POST['pass1']) && !empty($_POST['pass1']) && isset($_POST['pass2']) 
		   && !empty($_POST['pass2']) && isset($_POST['town']) && !empty($_POST['town']) && isset($_POST['country']) && !empty($_POST['country']))
			{
				$db=connect_db();
				$f_name=sanitize($db,$_POST['f_name']);
				$l_name=sanitize($db,$_POST['l_name']);
				$email=sanitize($db,filter_var($_POST['email'],FILTER_SANITIZE_EMAIL));
				$phone=sanitize($db,$_POST['phone']);
				$pass1=sanitize($db,$_POST['pass1']);
				$pass2=sanitize($db,$_POST['pass2']);
				$country=sanitize($db,$_POST['country']);
				$town=sanitize($db,$_POST['town']);
				$previlege=0;

				$errors=array();
				$check_email=$db->query("SELECT admin_id FROM admin WHERE email='$email'");
				if(!$check_email)
				{
					die($db->error);
				}

				else
				{
					if($check_email->num_rows>0)
					{
						array_push($errors,'Email Already exists in the system');	
					}	
				}

				$check_phone=$db->query("SELECT admin_id FROM admin WHERE phone_no='$phone'");
				if(!$check_phone)
				{
					die($db->error);
				}

				else
				{
					if($check_phone->num_rows>0)
					{
						array_push($errors,"Phone number already exists in the system");
					}
				}

				if(strcmp($pass1,$pass2)===0)
					{
						$password=password_hash($pass1,PASSWORD_DEFAULT);
					}
					else
					{
						array_push($errors, "Mismatched Passwords");
					}

			if(sizeof($errors)===0)
			{
				if(!empty($_POST['previlege']))
					{
						$previlege=sanitize($db,$_POST['previlege']);
					}
				
				$add_admin=$db->query("INSERT INTO admin (f_name,l_name,email,phone_no,admin_pass,country,town,previlege) VALUES ('$f_name','$l_name','$email','$phone','$password','$country','$town','$previlege')");
				if(!$add_admin)
					{
						die($db->error);
					}	

					else
					{
						$admin_id=$db->insert_id;
						if(isset($_FILES['ppic']) && $_FILES['ppic']['size']>0)
							{
								$dest='resources/users/admins';
								$accepted=array("JPG","JPEG","PNG","png","jpeg","jpg");
								$file=$_FILES['ppic'];
								$res=upload_image($file,$dest,$accepted);
								if($res['status']===1)
								{
									$res_dest=$res['message'];
									$update_pic=$db->query("UPDATE admin SET photo='$res_dest' WHERE admin_id='$admin_id'");
									if(!$update_pic)
										{
											$dest="..resources/users/admins/default_admin.png";
											$update_pic=$db->query("UPDATE admin SET photo='$res_dest' WHERE admin_id='$admin_id'");

											if(!$update_pic)
												{
													die($db->error);
												}
										}
								}
							}

 							else
								{
									$dest="resources/users/admins/default_admin.png";
									$update_pic=$db->query("UPDATE admin SET photo='$dest' WHERE admin_id='$admin_id'");

									if(!$update_pic)
										{
											die($db->error);
										}
								}
							fetch_admin($admin_id);
						}
			}

			else
			{
					echo json_encode(array('status'=>'failed','message'=>'An error occured','errors'=>$errors));
			}
		}

		else
		{
				echo json_encode(array('status'=>'error','message'=>'Please Fill in the required Fields'));
		}
	}

	else
	{
			echo json_encode(array('status'=>'error','message'=>'Restricted Access Please Login'));
	}
}

function admin_login()
{
	session_start();
	if(isset($_SESSION['status']) && $_SESSION['status']==true)
	{
		echo json_encode(array('message'=>'Already Logged '));
	}

	else
	{
		$db=connect_db();
		if(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password']))
			{
				$login=sanitize($db,$_POST['username']);
				$password=sanitize($db,$_POST['password']);
				$fetch_logs=$db->query("SELECT admin_id,f_name,l_name,previlege,admin_pass FROM admin WHERE email='$login' OR phone_no='$login'");
				if(!$fetch_logs)
					{
						die($db->error);
					}

					else
						{
							if($fetch_logs->num_rows>0)
								{
									$res=$fetch_logs->fetch_assoc();
									if(password_verify($password,$res['admin_pass']))
										{
											$_SESSION['user']=$res['admin_id'];
											$_SESSION['status']=true;
											$_SESSION['account']='admin';
											$_SESSION['username']=$res['f_name'];
											$_SESSION['previlege']=$res['previlege'];
											echo json_encode(array('status'=>'success','message'=>'You are Logged in as Admin'));	
										}

										else
										{
											echo json_encode(array('status'=>'failed','message'=>'Username Or password mismatch !'));
										}													
								}
										else
											{
												echo json_encode(array('status'=>'failed','message'=>'No Account is Associated with this username'));
											}
						}
			}

			else
				{
					echo json_encode(array('status'=>'warning','message'=>'Please Provide login details'));
				}
	}
}

function logout()
{
	session_start();
	$_SESSION=array();
	session_destroy();
	echo json_encode(array('status'=>'success','message'=>'logout Successful'));
}

function fetch_admin($id='')
{
	if(!isset($_SESSION))
	{
		session_start();
	}

	if(isset($_SESSION['status']) && $_SESSION['status']==true && isset($_SESSION['account']) && $_SESSION['account']=='admin' && isset($_SESSION['previlege']) && $_SESSION['previlege']==1)
	{
		$db=connect_db();
		$fetch_admin='';
		if(!empty($id))
			{
				$id=sanitize($db,$id);
				$fetch_admin=$db->query("SELECT admin_id,photo,f_name,l_name,email,phone_no,country,town,previlege FROM admin WHERE admin_id='$id' AND status='1'");
			}

			else
				{
					$admin=$_SESSION['user'];
					$fetch_admin=$db->query("SELECT admin_id,photo,f_name,l_name,email,phone_no,country,town,previlege FROM admin WHERE status='1' AND admin_id!='$admin'");
				}

			if(!$fetch_admin)
				{
					die($db->error);
				}

				else
					{
						echo json_encode($fetch_admin->fetch_all(MYSQL_ASSOC));
					}
				$db->close();
	}
	else
	{
		echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
	}
}

function edit_admin($id)
{
	if(!isset($_SESSION))
	{
		session_start();
	}

	if(isset($_SESSION['status']) && $_SESSION['status']===true && isset($_SESSION['account']) && strcmp($_SESSION['account'],'admin')===0)
	{
		if(isset($id) && !empty($id))
		{
			$db=connect_db();
			$warning=array();
			//$sql='UPDATE admin SET ';
			$sql='';
			$id=sanitize($db,$id);
			if(isset($_POST['f_name']) && !empty($_POST['f_name']))
				{
					$f_name=sanitize($db,$_POST['f_name']);
					$sql=$sql.'f_name='."'".$f_name."' ";
				} 
		
			if(isset($_POST['l_name']) && !empty($_POST['l_name']))
				{
					$lname=sanitize($db,$_POST['l_name']);
					$sql=$sql.'l_name='."'".$lname."' ";
				}

			if(isset($_POST['email']) && !empty($_POST['email']))
				{
					$email=sanitize($db,$_POST['email']);

					$find_email=$db->query("SELECT admin_id FROM admin WHERE email='$email' AND admin_id!='$id'");
					if(!$find_email)
						{
							die($db->error);
						}

						else
							{
							 	if($find_email->num_rows===0)
									{
										$sql=$sql.'email='."'".$email."' ";
									}
								
								else
									{
										array_push($warning,"Email already exists");
									}
							}
				}

			 	if(isset($_POST['phone_no']) && !empty($_POST['phone_no']))
					{
						$phone=sanitize($db,$_POST['phone_no']);

						$find_phone=$db->query("SELECT admin_id FROM admin WHERE phone_no='$phone' AND admin_id!='$id'");
						if(!$find_phone)
							{
								die($db->error);
							}

							else
								{
									if($find_phone->num_rows===0)
										{
											$sql=$sql.'phone_no='."'".$phone."' ";
										}
									else
										{
											array_push($warning,"Phone Number already exists");
										}
								}
					}

					if(isset($_POST['town']) && !empty($_POST['town']))
						{
							$town=sanitize($db,$_POST['l_name']);
							$sql=$sql.'town='."'".$town."' ";
						}

						if(isset($_POST['country']) && !empty($_POST['country']))
							{
								$country=sanitize($db,$_POST['country']);
								$sql=$sql.'country='."'".$country."' ";
							}

						if(isset($_POST['previlege']) && strlen($_POST['previlege'])>0)
							{
							 	$previlege=sanitize($db,$_POST['previlege']);
								$sql=$sql.'previlege='."'".$previlege."' ";
							}

						if(isset($_POST['pass1']) && isset($_POST['pass2']) && !empty($_POST['pass1']) && !empty($_POST['pass2']) && strcmp($_POST['pass1'],$_POST['pass2'])===0)
							{
								$password=password_hash(sanitize($db,$_POST['pass1']),PASSWORD_DEFAULT);
								$sql=$sql.'admin_pass='."'".$password."' ";
							}

						if(strlen($sql)>0)
							{
								if(sizeof($warning)===0)
									{
										$sql=str_replace(' ', ',',$sql);
										$sql=substr($sql,0,strlen($sql)-1);
										$sql='UPDATE admin SET '.$sql.' WHERE admin_id='."'".$id."'";

										$update_admin=$db->query($sql);
										if(!$update_admin)
											{
												die($db->error);
											}

									else
										{
											if(isset($_FILES['ppic']) && $_FILES['ppic']['size']>0)
												{
													$dest='resources/users/admins';
													$accepted=array("JPG","JPEG","PNG","png","jpeg","jpg");
													$file=$_FILES['ppic'];
													$res=upload_image($file,$dest,$accepted);
													if($res['status']===1)
														{
														 	$res_dest=$res['message'];
															$update_pic=$db->query("UPDATE admin SET photo='$res_dest' WHERE admin_id='$id'");
															if(!$update_pic)
																{
																	die($db->error);
																}
														}
												}
										}
										fetch_admin($id);
									}
								else
									{
										echo json_encode(array('status'=>'failed','message'=>'An error occured','errors'=>$warning));
									}
							}
							
							else
								{
									echo json_encode(array('status'=>'failed','message'=>'An error occured','warning'=>$warning));
								}
			}
	}
	
	else
	{
		echo json_encode(array('status'=>'failed','message'=>'Access Denied!!'));
	}
}

function delete_admin($id)
{
	if(!isset($_SESSION))
	{
		session_start();
	}

	if(isset($_SESSION['status']) && $_SESSION['status']===true && isset($_SESSION['account']) && strcmp($_SESSION['account'],'admin')===0)
	{
		$db=connect_db();
		$id=sanitize($db,$id);
		$update_db=$db->query("UPDATE admin SET status='0' WHERE admin_id='$id'");
		
	}

	else
	{
		echo json_encode(array('status'=>'failed','message'=>'Access Denied!!'));
	}
}

?>