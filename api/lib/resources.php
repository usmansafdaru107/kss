<?php

function add_resource()
{
	if(check_admin()){
			$accepted=array("JPG","JPEG","PNG","MP3","WAV","GIF","jpg","jpeg","png","mp3","wav","gif","PDF",'pdf','DOC','DOCX','docx','doc');
			$dest;

			if(isset($_POST['res_name']) && !empty($_POST['res_name']))
			{
				if(isset($_FILES['resource']) && $_FILES['resource']>0)
				{
				$res=$_FILES['resource'];
				$res_name=$res['name'];
				$type;
				$images_url='resources/uploads/images';
				$audios_url='resources/uploads/audio';
				$documents='resources/uploads/documents';
				$others='resources/uploads/others';

				$rext=explode('.',$res_name);
				$ext=strtolower(end($rext));

				switch ($ext) {
					case 'png':
						$type='image';
							$dest=$images_url;
						break;

					case 'gif':
						$type='image';
							$dest=$images_url;
						break;

					case 'jpeg':
						$type='image';
							$dest=$images_url;
						break;

					case 'jpg':
						$type='image';
							$dest=$images_url;
						break;

					case 'png':
						$type='image';
							$dest=$images_url;
						break;

					case 'mp3':
						$type='audio';
							$dest=$audios_url;
						break;

					case 'wav':
						$type='audio';
							$dest=$audios_url;
						break;

					case 'pdf':
						$type='document';
							$dest=$documents;
						break;

					case 'PDF':
						$type='document';
							$dest=$documents;
						break;

					case 'DOC':
						$type='document';
							$dest=$documents;
						break;

					case 'doc':
						$type='document';
							$dest=$documents;
						break;

					case 'DOCX':
						$type='document';
							$dest=$documents;
						break;

					case 'docx':
						$type='document';
							$dest=$documents;
						break;

					default:
						$type='other';
							$dest=$others;
				}

				if(!empty($dest))
				{
					$db=connect_db();
					$res=upload_image($_FILES['resource'],$dest,$accepted);
					if($res['status']===1)
					{
						$name=sanitize($db,$_POST['res_name']);
						$url=$res['message'];
						$add_resource=$db->query("INSERT into resources(resource_type,resource_name,url,date_added) VALUES ('$type','$name','$url',CURRENT_DATE)");

						if(!$add_resource)
						{
							echo json_encode(array("status"=>"failed","message"=>"file not added to the database"));
						}

						else
						{
							$res_id=$db->insert_id;
							fetch_resource($res_id);
						}
					}
				}
			}

			else
			{
				echo json_encode(array('status'=>'failed','message'=>'Please provide a file'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'failed','message'=>'Please provide a name'));
		}
	}else{
		echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
	}
}

function fetch_resource($id='',$name='',$type='')
{
	$db=connect_db();
	$sql='';
	if(!empty($id))
	{
		$id=sanitize($db,$id);
		$sql=$db->query("SELECT resource_id,resource_name,resource_type,url,date_added FROM resources WHERE resource_id='$id' AND status='1'");
		fetch_arr($sql);
	}

	else if(!empty($name))
	{
		$name=sanitize($db,$name);
		$sql=$db->query("SELECT resource_id,resource_name,resource_type,url,date_added FROM resources WHERE resource_name='$name' AND status='1'");
		fetch_arr($sql);
	}

	else if(!empty($type))
	{
		$name=sanitize($db,$type);
		$sql=$db->query("SELECT resource_id,resource_name,resource_type,url,date_added FROM resources WHERE resource_type='$type' AND status='1'");
		fetch_arr($sql);
	}

	else
	{
		$sql=$db->query("SELECT DISTINCT resource_type FROM resources");
		if(!$sql)
		{
			die($db->error);
		}

		else
		{
			if($sql->num_rows>0)
			{
				$res=$sql->fetch_all(MYSQLI_ASSOC);
				$resources=array();
				$prep=$db->prepare("SELECT resource_id,resource_name,resource_type,url,date_added FROM resources WHERE resource_type=? AND status='1'");
				$prep->bind_param('s',$tp);
				foreach($res AS $key=>$type)
					{
						$tp=$type['resource_type'];
						$type_array=array();
						$type_array['type']=$tp;
						if(!$prep->execute())
						{
							die($db->error);
						}
						else
						{
							$files=$prep->get_result();
							$type_array['files']=$files->fetch_all(MYSQLI_ASSOC);
						}
						array_push($resources,$type_array);
					}
					echo json_encode($resources);
			}
		}
	}

	if(!$sql)
	{
		die($db->error);
	}

	else
	{
		
	}
	$db->close();
}

function fetch_arr($sql)
{
	if(!$sql)
	{
		die($db->error);
	}
	else
	{
		echo json_encode($sql->fetch_all(MYSQLI_ASSOC));
	}
}



function search_resource($term)
{
	$db=connect_db();
	$sql=$db->query("SELECT resource_id,resource_name,resource_type,url,date_added FROM resources WHERE resource_name LIKE '%$term%' AND status='1'");
	if(!$sql)
	{
		die($db->error);
	}
	else
	{
		echo json_encode($sql->fetch_all(MYSQLI_ASSOC));
	}
}

function edit_resource($id)
{
	if(check_admin()){
		$db=connect_db();
		if(isset($_POST['res_name']) && !empty($_POST['res_name']))
		{
			$name=sanitize($db,$_POST['res_name']);
			$sql=$db->query("UPDATE resources SET resource_name='$name' WHERE resource_id='$id'");

			if(!$sql)
			{
				die($db->error);
			}

			else
				{
					$up_dated=$db->query("SELECT resource_id,resource_name,resource_type,url,date_added FROM resources WHERE resource_id='$id'");
					if(!$up_dated)
						{
							die($db->error());
						}

						else
							{
								echo json_encode($up_dated->fetch_assoc());
							}
				}
			$db->close();
		}

		else
		{
			echo json_encode(array('status'=>'failed','message'=>'No changes made'));
		}
	}
	else{
		echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
	}
}

function delete_resource($id)
{
	if(check_admin()){
		$db=connect_db();
		$sql=$db->query("UPDATE resources SET status='0' WHERE resource_id='$id'");

		if(!$sql)
		{
			die($db->error);
		}

		else
		{
			if($db->affected_rows>0)
			{
				echo json_encode(array("status"=>"success","message"=>"Resource Deleted Successfully"));
			}
			else
			{
				echo json_encode(array("status"=>"failed","message"=>"Deleted Failed"));
			}
		}
		$db->close();
	}
	else{
		echo json_encode(array('status'=>'failed','message'=>'Please login to continue'));
	}
}
?>