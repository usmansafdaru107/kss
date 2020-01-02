<?php
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
function connect_db(){
	// if(isset($db)){
	// 	mysqli_close($db);
	// }
	static $db;

	if(!isset($db))
	{
				$db_array=parse_ini_file("kass.ini",true);
				$host_name = $db_array['host_name'];
				$username = $db_array['username'];
				$password =$db_array['password'];
				$database = $db_array['database'];
			
			

		$db = new mysqli($host_name, $username, $password, $database);

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

function val_dob($dob)
{
	$val_dob=explode('/',$dob);
		if(count($val_dob)==3)
		{
			if(!checkdate($val_dob[0], $val_dob[1], $val_dob[2]))
			{
				$errors['date']="Invalid date,Please provide a valid date";
			}

			else
			{
				$dob=date('Y-m-d', strtotime(str_replace('-', '/', $dob)));
				return $dob;
			}
		}
}

function send_email($recipient,$f_name,$l_name,$subject,$txt_body,$html_body)
{
	$mg="Hello ".$f_name.' '.$l_name;
	$mg.=",Welcome to Kampala Smart School!";
	$mg.="You have joined a community of parents and teachers, all striving to provide each of their children with the education they deserve";
	$mg.="To access our high quality lessons and resources aligned to the Uganda Primary School Curriculum, log in and enroll your child in their right class from Primary One to Primary Seven.";
	$mg.="For inquiries, email us to admin@kampalasmartschool.com or call 267776182222, 25670182224";
	$mg.="Kind regards,";
	$mg.="Kampala Smart School";

	date_default_timezone_set('Etc/UTC');
	require 'mailer/PHPMailerAutoload.php';
	include('mailer/class.EmailTemplate.php');
	$template=new EmailTemplate('mailer/template.html');
	$template->f_name=$f_name;
	$template->l_name=$l_name;
	echo $msg=$template->compile();

	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->Host = 'mail.kampalasmartschool.com';
	$mail->Port = 25; 
	//$mail->SMTPSecure = 'tls';
	$mail->SMTPAuth = true;
	$mail->Username = "noreply@kampalasmartschool.com";
	$mail->Password = "kass256elephants";
	$mail->setFrom('noreply@kampalasmartschool.com', 'Kampala Smart School');
	$mail->addAddress($recipient, $f_name.' '.$l_name);
												//Set the subject line
	$mail->Subject = $subject;
	$mail->msgHTML($msg);
	$mail->AltBody = $mg;
		set_time_limit(300);
		//$mail->send();

}
?>