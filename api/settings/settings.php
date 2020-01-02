<?php
function reset_password(){	
	$db=connect_db();
	if(isset($_POST['email']) && !empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && isset($_POST['account_type']) && !empty($_POST['account_type'])){
		switch ($_POST['account_type']) {
			case 'sponsor':
					$check_sponsor=$db->prepare("SELECT sponsor_id,sponsor_name FROM sponsors WHERE email=? AND status=1 LIMIT 1");
					$check_sponsor->bind_param('s',$email);
					$email=sanitize($db,$_POST['email']);

					if(!$check_sponsor->execute()){
						die($db->error);
					}else{
						$res=$check_sponsor->get_result();
						$vals=$res->fetch_assoc();
						$sponsor=$vals['sponsor_id'];
						$sponsor_name=$vals['sponsor_name'];

						if($res->num_rows>0){
							$check_sponsor->close();
							$reset_password=$db->prepare("INSERT INTO sponsor_reset_requests (sponsor_id,code) VALUES (?,?)");
							$reset_password->bind_param('is',$sponsor_id,$hcode);
							$sponsor_id=$sponsor;
							$code=randomiser(5);
							$hcode=password_hash($code,PASSWORD_DEFAULT);

							if(!$reset_password->execute()){
								die($db->error);
							}else{
								$res=$reset_password->get_result();
								if($db->affected_rows>0){
									$code=$code.$db->insert_id;
									$url="https:www.kampalasmartschool.com/reset_password.php?target=sponsor&code=".$code;
									send_reset_email($sponsor_name,$url,$code,$_POST['email']);
									echo json_encode(array('status'=>'success','message'=>'Please check your email address to continue'));
								}
							}

						}else{
							echo json_encode(array('status'=>'failed','message'=>'The account doesnot exist on kampala smart school'));
						}
					}
				break;
			
			case 'admin':
				$check_admin=$db->prepare("SELECT admin_id,f_name,l_name FROM admin WHERE email=? AND status=1");
				$check_admin->bind_param('i',$admin);
				$admin=sanitize($db,$_POST['email']);

				if(!$check_admin->execute()){
					die($db->error);
				}else{
					$res=$check_admin->get_result();
					$admin_res=$res->fetch_assoc();
					if($res->num_rows>0){
						$check_admin->close();
						$reset_password=$db->prepare("INSERT INTO admin_reset_requests (admin_id,code) VALUES (?,?)");
						$reset_password->bind_param('is',$admin_id,$hcode);
						$admin_id=$admin_res['admin_id'];
						$code=randomiser(5);
						$hcode=password_hash($code,PASSWORD_DEFAULT);

						if(!$reset_password->execute()){
							die($db->error);
						}else{
							$res=$reset_password->get_result();
							if($db->affected_rows>0){
								$code=$code.$db->insert_id;
								$url="https:www.kampalasmartschool.com/password_reset?target=admin&code=".$code;
								send_reset_email($admin_res['f_name'].' '.$admin_res['l_name'],$url,$code,$_POST['email']);
								echo json_encode(array('status'=>'success','message'=>'Please check your email address to continue'));
							}
							else{
								echo json_encode(array('status'=>'failed','message'=>'The account doesnot exist on kampala smart school'));
							}
						}
					}else{
						echo json_encode(array('status'=>'failed','message'=>'The account doesnot exist on kampala smart school'));
					}
				}
				break;

			case 'student':
					$check_student=$db->prepare("SELECT student_id,sponsor_id FROM students WHERE student_id=? AND status=1");
					$check_student->bind_param('i',$student);
					$student=sanitize($db,$student_id);

					if(!$check_student->execute()){
						die($db->error);
					}else{
						$res=$check_student->get_result();
						if($res->num_rows>0){
							$check_student->close();
							$reset_password=$db->prepare("INSERT INTO student_reset_requests (student_id,code) VALUES (?,?)");
							$reset_password->bind_param('is',$st_id,$hcode);
							$st_id=$student;
							$code=randomiser(5);
							$hcode=password_hash($code,PASSWORD_DEFAULT);

							if(!$reset_password->execute()){
								die($db->error);
							}else{
									session_start();
								$res=$reset_password->get_result();
								if($res->affected_rows>0){
									$template=new EmailTemplate('templates/password_reset.html');
									$template->name=$_SESSION['username'];
									$template->url=$url;
									$template->code=$code;
									$body=$template->compile();

									$emailer=new Emailer("noreply@kampalasmartschool.com","kass256elephants");
									$emailer->setTemplate($body);

									$mg="Hello ".$_SESSION['username'];
									$mg.=",Thank you for using Kampala Smart School!";
									$mg.="You requested for a password reset. Please click this link to continue or copy and paste this in a browser. ";
									$mg.=$url;
									$mg.=", or you can enter this password reset code, ".$code;
									$mg.=", For inquiries, email us at admin@kampalasmartschool.com or call 267776182222, 25670182224";
									$mg.="Kind regards,";
									$mg.="Kampala Smart School";

									$emailer->set_Alt_body($mg);
									$emailer->addSender("Kampala Smart School","noreply@kampalasmartschool.com");
									$emailer->addRecipient($_SESSION['username'],$email);
									$emailer->send("Kampala Smart School Password Reset");
									echo json_encode(array('status'=>'success','message'=>'Please check your email address to continue'));
								}
								else{
									echo json_encode(array('status'=>'failed','message'=>'The account doesnot exist on kampala smart school'));
								}
							}
						}else{
							echo json_encode(array('status'=>'failed','message'=>'The account doesnot exist on kampala smart school'));
						}
					}
				break;
			default:
					echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
				break;
			}
		}

	else{
		echo json_encode(array('status'=>'failed','message'=>'Please provide both the email address and account_type'));
	}
}

function verify_password_reset(){
	if(isset($_POST['code']) && !empty($_POST['code']) && isset($_POST['account_type']) && !empty($_POST['account_type']) && isset($_POST['pass1']) && !empty($_POST['pass1']) && isset($_POST['pass2']) && !empty($_POST['pass2'])){
		$db=connect_db();

		switch ($_POST['account_type']) {
			case 'sponsor':
				$reset_password=$db->prepare("SELECT sponsor_id,request_date,code FROM sponsor_reset_requests WHERE reset_id=? AND request_status=0 LIMIT 1");
				$reset_password->bind_param('i',$resetID);
				$raw_code=(string)$_POST['code'];
				$len=strlen($raw_code);
				$reset_id=substr($raw_code,5-$len);
				$resetID=sanitize($db,$reset_id);
				$s_code=substr($_POST['code'], 0,5);

				if(!$reset_password->execute()){
					die($db->error);
				}else{
					$res=$reset_password->get_result();
					if($res->num_rows>0){
						$results=$res->fetch_assoc();
						if(password_verify($s_code,$results['code'])){
							$today=date('Y-m-d H:m:s',strtotime('+2 hour'));
							$diff=(strtotime($today)-strtotime($results['request_date']))/3600;
							//echo $today.' '.$results['request_date'].' '.$diff;
							//echo $diff;
							if(($diff)<1){
								if(strcmp($_POST['pass1'], $_POST['pass2'])==0){
									$update_sponsors=$db->prepare("UPDATE sponsors SET password=? WHERE sponsor_id=?");
									$update_sponsors->bind_param('si',$pass,$sponsor);
									$pass=password_hash(sanitize($db,$_POST['pass1']),PASSWORD_DEFAULT);
									//echo $pass;
									$sponsor=$results['sponsor_id'];

									if(!$update_sponsors->execute()){
										die($db->error);
									}else{
										if($db->affected_rows>0){
											$update_token=$db->prepare("UPDATE sponsor_reset_requests SET request_status=1 WHERE reset_id=?");
											$update_token->bind_param('i',$resetID);
											$resetID=sanitize($db,$reset_id);
											if(!$update_token->execute()){
												die($db->error);
											}
											echo json_encode(array('status'=>'success','message'=>'Password reset successfully, Please login'));
										}else{
											echo json_encode(array('status'=>'failed','message'=>'Password was not reset successfully'));
										}
									}

								}else{
									echo json_encode(array('status'=>'failed','message'=>'Mismatching passwords, Please provide matching passwords'));
								}

							}else{
								$update_token=$db->prepare("UPDATE sponsor_reset_requests SET request_status=-1 WHERE reset_id=?");
								$update_token->bind_param('i',$resetID);
								$resetID=sanitize($db,$reset_id);
								if(!$update_token->execute()){
									die($db->error);
								}
								echo json_encode(array('status'=>'failed','message'=>'Token has already expired, please reset the password again'));
							}

						}else{
							echo json_encode(array('status'=>'failed','message'=>'Please provide a valid token'));
						}

					}else{
						echo json_encode(array('status'=>'failed','message'=>'No request is associated with this unique ID'));
					}
				}
				break;
			
			case 'admin':
				# code...
				break;

			default:
				# code...
				break;
		}
	}else{
		echo json_encode(array('status'=>'failed','message'=>'Please fill in all required fields'));
	}
}

function send_reset_email($name,$url,$code,$email){
	$template=new EmailTemplate('templates/password_reset.html');
	$template->name=$name;
	$template->url=$url;
	$template->code=$code;
	$body=$template->compile();

	$emailer=new Emailer("noreply@kampalasmartschool.com","kass256elephants");
	$emailer->setTemplate($body);

	$mg="Hello ".$name;
	$mg.=",Thank you for using Kampala Smart School!";
	$mg.=" You requested for a password reset. Please click this link to continue or copy and paste this in a browser. ";
	$mg.=$url;
	$mg.=", or you can enter this password reset code, ".$code;
	$mg.=", For inquiries, email us at admin@kampalasmartschool.com or call 267776182222, 256705182224";
	$mg.="Kind regards,";
	$mg.="Kampala Smart School";

	$emailer->set_Alt_body($mg);
	$emailer->addSender("Kampala Smart School","noreply@kampalasmartschool.com");
	$emailer->addRecipient($name,$email);
	$emailer->send("Kampala Smart School Password Reset");
	//echo $body;
}
?>