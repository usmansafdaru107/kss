<?php
function add_unit(){
	if(check_admin()){
		if(isset($_POST['themeName']) && !empty($_POST['themeName']) && isset($_POST['tutor']) && !empty($_POST['tutor']) && isset($_POST['details']) && !empty($_POST['details']) && isset($_POST['term']) && !empty($_POST['term']))
		{
			$db=connect_db();
			$name=sanitize($db,$_POST['themeName']);
			$tutor=sanitize($db,$_POST['tutor']);
			$description=sanitize($db,$_POST['details']);
			$term=$_POST['term'];

			$add_unit=$db->query("INSERT INTO themes_units (theme_name,tutor,details,term) VALUES ('$name','$tutor','$description','$term')");
			if(!$add_unit)
				{
					die($db->error);
				}

				else
					{
						$unit=$db->insert_id;

						if(isset($_FILES['unitLogo']) && $_FILES['unitLogo']['size']>0)
							{
								$dest='resources/images';
								$accepted=array("JPG","JPEG","PNG","png","jpeg","jpg");
								$file=$_FILES['unitLogo'];

								$res=upload_image($file,$dest,$accepted);
								if($res['status']===1)
									{
										$res_dest=$res['message'];
										$update_pic=$db->query("UPDATE themes_units SET logo='$res_dest' WHERE theme_id='$unit'");

										if(!$update_pic)
											{
												$dest="../resources/images/default_unit.png";
												$update_pic=$db->query("UPDATE themes_units SET logo='$dest' WHERE theme_id='$unit'");

												if(!$update_pic)
													{
														die($db->error);
													}
											}
									}
							}

							else
								{
									$dest="../resources/images/default_unit.png";
									$update_pic=$db->query("UPDATE themes_units SET logo='$dest' WHERE theme_id='$unit'");

									if(!$update_pic)
										{
											die($db->error);
										}
								}
							}

			$fetch_subject=$db->query("SELECT th.theme_id,th.logo,s.subject_name FROM themes_units AS th JOIN subjects AS s WHERE th.theme_id='$unit'");

			if(!$fetch_subject)
			{
				die($db->error);
			}

			else
			{

				echo json_encode($fetch_subject->fetch_assoc());
			}
			$db->close();
		}

		else
		{
			echo json_encode(array('status'=>'failed','message'=>'Please fill all required fields'));
		}

	}else{
		echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
	}
}

function fetch_units($id='',$user='',$term='',$subject='',$tutor='')
	{
		
		$db=connect_db();
		$pageSize=10;
		$start=0;

		$app = Slim\Slim::getInstance();

		if($app->request()->params('pagesize'))
			{
				$pageSize=$app->request()->params('pagesize');
			}

		if($app->request()->params('from'))
			{
				$start=($app->request()->params('from'));
			}

		$sql="";
		if(!empty($id))
		{
			$sql=$db->query("SELECT t.term_name,t.term_id,tu.theme_id,tu.theme_name,tu.logo,tu.tutor,a.f_name,a.l_name,tu.details FROM themes_units AS tu JOIN term AS t ON tu.term=t.term_id JOIN tutors AS tr ON tu.tutor=tr.tutor_id JOIN admin AS a ON a.admin_id=tr.admin_id  WHERE tu.theme_id='$id' AND tu.status='1'");
			echo json_encode(exec_units($sql));
		}

		else if(!empty($user))
		{
			$sql=$db->query("SELECT t.term_name,t.term_id,tu.theme_id,tu.theme_name,tu.logo,tu.tutor,a.f_name,a.l_name,tu.details FROM themes_units AS tu JOIN term AS t ON tu.term=t.term_id JOIN tutors AS tr ON tu.tutor=tr.tutor_id JOIN admin AS a ON a.admin_id=tr.admin_id WHERE a.admin_id='$user' AND tu.status='1' AND tu.theme_id>'$start' LIMIT $pageSize");
			echo json_encode(exec_units($sql));
		}

		else if(!empty($tutor))
		{
			$sql=$db->query("SELECT t.term_name,t.term_id,tu.theme_id,tu.theme_name,tu.logo,tu.tutor,a.f_name,a.l_name,tu.details FROM themes_units AS tu JOIN term AS t ON tu.term=t.term_id JOIN tutors AS tr ON tu.tutor=tr.tutor_id JOIN admin AS a ON a.admin_id=tr.admin_id WHERE tr.tutor_id='$tutor' tu.status='1' AND tu.theme_id>'$start' LIMIT $pageSize");
			echo json_encode(exec_units($sql));
		}

		else if(!empty($subject))
		{ 
			if(!empty($_GET['term']))
			{
				$term=$_GET['term'];
				$terms=$db->query("SELECT term_id,term_name FROM term WHERE term_id='$term' LIMIT 1");
				
				if(!$terms)
					{
						die($db->error);
					}

					else
						{
							$term_arr=array();
							$terms=$terms->fetch_assoc();
							$term_arr['name']=$terms['term_name'];
							$term_arr['id']=$terms['term_id'];
							$trm=$terms['term_id'];

							if(strcmp($app->request()->params('pages'),'true')==0)
								{
									$sql=$db->query("SELECT COUNT(theme_id) AS total FROM themes_units WHERE class_subject='$subject' AND term='$trm' AND theme_id>'$start'");
									if(!$sql)
									{
										die($db->error);
									}
									else
									{
										$total=$sql->fetch_assoc()['total'];
										echo json_encode(paginate($total,$pageSize,$start));
										$db->close();
									}
								}
							else
								{
									$sql=$db->query("SELECT tu.theme_id,tu.theme_name,tu.logo,tu.tutor,a.f_name,a.l_name,tu.details FROM themes_units AS tu JOIN term AS t ON tu.term=t.term_id JOIN tutors AS tr ON tu.tutor=tr.tutor_id JOIN admin AS a ON a.admin_id=tr.admin_id JOIN class_subjects AS cs ON cs.cs_id=tr.class_subject WHERE cs.cs_id='$subject' AND tu.status='1' AND t.term_id='$trm' AND tu.theme_id>'$start' LIMIT $pageSize");
									$term_arr['themes']=exec_units($sql);
									echo json_encode($term_arr);
								}
						}
			}

			else
			{
				$terms=$db->query("SELECT term_id,term_name FROM term");
				if(!$terms)
					{
						die($db->error);
					}

				else
					{
						$term_arr=array();
						foreach($terms AS $term)
							{
								$trm=array();
								$trm['id']=$term['term_id'];
								$trm['name']=$term['term_name'];
								$tm_id=$term['term_id'];
								$sql=$db->query("SELECT tu.theme_id,tu.theme_name,tu.logo,tu.tutor,a.f_name,a.l_name,tu.details FROM themes_units AS tu JOIN term AS t ON tu.term=t.term_id JOIN tutors AS tr ON tu.tutor=tr.tutor_id JOIN admin AS a ON a.admin_id=tr.admin_id JOIN class_subjects AS cs ON cs.cs_id=tr.class_subject WHERE cs.cs_id='$subject' AND t.term_id='$tm_id' AND tu.status='1'");
								$trm['themes']=exec_units($sql);
								array_push($term_arr,$trm);
							}
							echo json_encode($term_arr);
					}
			}
		}

		else
			{
				$terms=$db->query("SELECT term_id,term_name FROM term");
				if(!$terms)
					{
						die($db->error);
					}

				else
					{
						$term_arr=array();
						foreach($terms AS $term)
							{
								$trm=array();
								$trm['id']=$term['term_id'];
								$trm['name']=$term['term_name'];
								$tm_id=$term['term_id'];
								$sql=$db->query("SELECT tu.theme_id,tu.theme_name,tu.logo,tu.tutor,a.f_name,a.l_name,tu.details FROM themes_units AS tu JOIN term AS t ON tu.term=t.term_id JOIN tutors AS tr ON tu.tutor=tr.tutor_id JOIN admin AS a ON a.admin_id=tr.admin_id WHERE t.term_id='$tm_id' AND tu.status='1' AND tu.theme_id>'$start' ORDER BY tu.theme_id LIMIT $pageSize");
								$trm['themes']=exec_units($sql);
								array_push($term_arr,$trm);
							}
							echo json_encode($term_arr);
					}
			}
	}

	function edit_units($id)
	{
		if(isset($_POST['themeName']) && !empty($_POST['themeName']) && isset($_POST['details']) && !empty($_POST['details']) && isset($_POST['tutor']) && !empty($_POST['tutor']) && isset($_POST['term']) && !empty($_POST['term']))
		{
			$db=connect_db();
			$name=sanitize($db,$_POST['themeName']);
			$description=sanitize($db,$_POST['details']);
			$tutor=sanitize($db,$_POST['tutor']);
			$term=sanitize($db,$_POST['term']);

			$add_subject=$db->query("UPDATE themes_units SET theme_name='$name',tutor='$tutor',details='$description',term='$term' WHERE theme_id='$id'");
			if(!$add_subject)
				{
					die($db->error);
				}

				else
					{
						if(isset($_FILES['unitLogo'])  && $_FILES['unitLogo']['size']>0)
							{
								$dest='resources/images';
								$accepted=array("JPG","JPEG","PNG","png","jpeg","jpg");
								$file=$_FILES['unitLogo'];

								$res=upload_image($file,$dest,$accepted);
								if($res['status']===1)
									{
										$res_dest=$res['message'];
										$update_pic=$db->query("UPDATE themes_units SET logo='$res_dest' WHERE theme_id='$id'");

										if(!$update_pic)
											{
												$dest="../resources/images/default_unit.png";
												$update_pic=$db->query("UPDATE themes_units SET logo='$dest' WHERE theme_id='$id'");

												if(!$update_pic)
													{
														die($db->error);
													}
											}
									}
							}

								$fetch_subject=$db->query("SELECT th.theme_id,th.theme_name,th.logo,s.subject_name FROM themes_units AS th JOIN subjects AS s WHERE th.theme_id='$id'");
								if(!$fetch_subject)
									{
										die($db->error);
									}

									else
										{
											echo json_encode($fetch_subject->fetch_assoc());
										}
					}
					$db->close();
		}

		else
		{
			echo json_encode(array('status'=>'failed','message'=>'Please fill all required fields'));
		}
	}

function delete_units($id)
{
	if(check_admin()){
		$db=connect_db();
		$delete_units=$db->query("UPDATE themes_units SET status='0' WHERE theme_id='$id'");
		if(!$delete_units)
		{
			die($db->error);
		}

		else
		{
			echo json_encode(array('status'=>'success','message'=>'Unit deleted Successfully'));
		}
	}else{
		echo json_encode(array('status'=>'success','message'=>'Please login to continue'));
	}
}

	function exec_units($sql)
	{
		$db=connect_db();
		if(!$sql)
		{
			die($db->error);
		}

		else
		{
			return $sql->fetch_all(MYSQLI_ASSOC);
		}
		$db->close();
	}

?>