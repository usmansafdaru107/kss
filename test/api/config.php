<?php
	function connect_db()
	{
		static $db;

		if(!isset($db))
		{
			$db_array=parse_ini_file("kass.ini",true);
			$db=new mysqli($db_array['host_name'],$db_array['username'],$db_array['password'],$db_array['database']);

			if(!$db)
			{
				die($db->error);
			}

			else
			{
				return $db;
			}
		}

		else
		{
			return $db;
		}
			
	}

	function upload_image($file,$dest,$accepted)
	{
		$file_name=$file['name'];
		$tmp=$file['tmp_name'];
		$size=$file['size'];

		$rext=explode('.',$file_name);
		$ext=strtolower(end($rext));

		if(in_array($ext,$accepted)===false)
		{
			return array("status"=>0,"message"=>"File format not accepted");
		}

		else
		{
			if(!is_dir('../'.$dest))
			{
				mkdir('../'.$dest,755,true);
			}
			$dest_name=randomiser(15);

			if(is_file('../'.$dest.'/'.$dest_name.'.'.$ext))
			{
				upload_image($file,$dest,$accepted);
			}

			else
			{
				if(!move_uploaded_file($tmp,'../'.$dest.'/'.$dest_name.'.'.$ext))
					{
						return array("status"=>0,"message"=>"File upload failded");
					}

					else
						{
							return array("status"=>1,"message"=>"".'../'.$dest.'/'.$dest_name.'.'.$ext);
						}
			}
		}
	}

	function randomiser($length)
	{
		$new_arr=implode("",(preg_replace('/[^A-Za-z0-9]/',"",array_merge(range('A','z'),range(0,9)))));
			
			$new_arr=str_split($new_arr);
			$rnd="";
			$index=0;
			while($index<$length)
			{
				$rnd.=$new_arr[array_rand($new_arr)];
				$index++;
			}
			return $rnd;
	}

	function sanitize($db,$data)
	{
		$data=trim($data);
		$data=stripslashes($data);
		$data=htmlspecialchars($data);
		$data=mysqli_real_escape_string($db,$data);
		return $data;
	}

	function paginate($total,$pageSize,$start=0)
	{
		$segements=(int) ($total/$pageSize);
			($segements<=0?$segements=1:$segements=$segements);
			$pages=array();
			for($i=0;$i<$segements;$i++)
				{
					array_push($pages,($pageSize*$i)+$start);
				}
			return $pages;
	}
?>