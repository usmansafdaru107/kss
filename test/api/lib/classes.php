<?php
function add_class()
	{
		session_start();
		if(isset($_SESSION['status']) && $_SESSION['status']==true && isset($_SESSION['account']) && $_SESSION['account']=='admin' && isset($_SESSION['previlege']) && $_SESSION['previlege']==1)
			{
				if(!empty($_POST['className']) && !empty($_POST['shortClassName']) && !empty($_POST['classDescription']))
				{
					$db=connect_db();
					$name=sanitize($db,$_POST['className']);
					$short=sanitize($db,$_POST['shortClassName']);
					$dpt=sanitize($db,$_POST['classDescription']);

					$add_class=$db->query("INSERT INTO classes (class_name,short_class_name,description) VALUES ('$name','$short','$dpt')");
					if(!$add_class)
					{
						die($db->error);
					}

					else
						{
							$class_id=$db->insert_id;
							if(isset($_FILES['classLogo']) && $_FILES['classLogo']['size']>0)	
								{
									$dest='resources/images';
									$accepted=array("JPG","JPEG","PNG","png","jpeg","jpg");
									$file=$_FILES['classLogo'];

									$res=upload_image($file,$dest,$accepted);
									if($res['status']===1)
										{
											$res_dest=$res['message'];
											$update_pic=$db->query("UPDATE classes SET class_pic='$res_dest' WHERE class_id='$class_id'");

											if(!$update_pic)
												{
													$dest="../resources/images/default_class.png";
													$update_pic=$db->query("UPDATE classes SET class_pic='$dest' WHERE class_id='$class_id'");

													if(!$update_pic)
														{
															die($db->error);
														}
												}
										}	

										else
										{
											array_push($errors,$res['message']);
										}
				}

				else
				{
							$dest="../resources/images/default_class.png";
							$update_pic=$db->query("UPDATE classes SET class_pic='$dest' WHERE class_id='$class_id'");

							if(!$update_pic)
							{
								die($db->error);
							}
				}

				$fetch_class=$db->query("SELECT class_id,class_name,class_pic FROM classes WHERE class_id='$class_id'");

				if(!$fetch_class)
				{
					die($db->error);
				}

					else
						{
							echo json_encode($fetch_class->fetch_assoc());
						}
					}
					$db->close();	
				}

				else
				{
					return json_encode(array("status"=>'failed','message'=>'Please Fill all required fields'));

				}
			}

	else
	{
		echo json_encode(array("status"=>'warning','message'=>'Please login as admin to continue'));
	}
}

function retrieve_classes($id='',$tutor='')
	{
		$db=connect_db();

		$sql="";
		if(!empty($id))
		{
			$id=sanitize($db,$id);
			$sql=$db->query("SELECT * FROM classes WHERE class_id='$id' AND status='1'");
		}

		else if(!empty($tutor))
		{
			if(strcmp($tutor,'logged_in')==0)
			{
				if(!isset($_SESSION))
				{
					session_start();
				}

				if(isset($_SESSION['user']) && isset($_SESSION['status']) && $_SESSION['status']==true && isset($_SESSION['account']) && strcmp($_SESSION['account'],'admin')===0)
					{
						if($_SESSION['previlege']==0)
						{
							$admin=$_SESSION['user'];
							$sql=$db->query("SELECT DISTINCT c.class_id,c.short_class_name,c.class_name,c.class_pic FROM admin AS a JOIN tutors AS tr ON a.admin_id=tr.admin_id JOIN class_subjects AS cs ON tr.class_subject=cs.cs_id JOIN classes AS c ON cs.class_id=c.class_id WHERE a.admin_id='$admin' AND a.status='1' AND cs.status='1' AND tr.status='1' AND c.status='1'");
						}
						else if($_SESSION['previlege']==1)
						{
							$sql=$db->query("SELECT class_id,short_class_name,class_name,class_pic FROM classes WHERE status='1'");
						}
					}
					else
					{
						echo json_encode(array('status'=>'failed','message'=>'Please log in'));
					}
			}
		}

		else
		{
			$sql=$db->query("SELECT * FROM classes WHERE status='1'");
		}

		if(!$sql)
		{
			die($db->error);
		}

		else
		{
			echo json_encode($sql->fetch_all(MYSQL_ASSOC));
		}
		$db->close();
	}

function edit_class($id)
	{
		if(isset($_POST['className']) && !empty($_POST['className']) && isset($_POST['shortClassName']) && !empty($_POST['shortClassName']) && isset($_POST['classDescription']) && !empty($_POST['classDescription']))
		{

			$db=connect_db();

			$find_class=$db->query("SELECT class_id FROM classes WHERE class_id='$id'");
			if(!$find_class)
			{
				die($db->error);
			}

			else
			{
				if($find_class->num_rows>0)
				{
					$errors=array();
					$name=sanitize($db,$_POST['className']);
					$short=sanitize($db,$_POST['shortClassName']);
					$dpt=sanitize($db,$_POST['classDescription']);

					$edit_class=$db->query("UPDATE classes SET class_name='$name',short_class_name='$short',description='$dpt' WHERE class_id='$id'");
					if(!$edit_class)
						{
							die($db->die($db->error));
						}

						else
							{
								if(isset($_FILES['classLogo']))
									{
										$dest='resources/images';
										$accepted=array("JPG","JPEG","PNG","png","jpeg","jpg");
										$file=$_FILES['classLogo'];

										$res=upload_image($file,$dest,$accepted);
										if($res['status']===1)
											{
												$res_dest=$res['message'];
												$update_pic=$db->query("UPDATE classes SET class_pic='$res_dest' WHERE class_id='$id'");

												if(!$update_pic)
													{
														$dest="../resources/images/default_class.png";
														$update_pic=$db->query("UPDATE classes SET class_pic='$dest' WHERE class_id='$id'");

														if(!$update_pic)
															{
																array_push($errors,"File upload Failed");
																die($db->error);
															}
													}
											}
									}
							
									echo json_encode(array("status"=>"success",'message'=>"Class Edited Successfully","errors"=>$errors));
							}
				}
			}

			$db->close();
		}

		else
		{
			echo json_encode(array("status"=>"fail",'message'=>"Please fill in all fields"));
		}
		
}

function delete_class($id)
	{
		if(isset($id) && !empty($id))
		{
			$db=connect_db();
			$delete_class=$db->query("UPDATE classes SET status='0' WHERE class_id='$id'");
			if(!$delete_class)
			{
				die($db->error);
			}

			else
			{
				echo json_encode(array('status'=>'success','message'=>'Class Successfully deleted'));
			}
		}
	}

?>