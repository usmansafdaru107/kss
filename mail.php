<?php
header('Content-type:application/json');
if(isset($_POST['email']) &&  !empty($_POST['email']) && isset($_POST['phone']) &&  
!empty($_POST['phone']) &&	isset($_POST['fname']) &&  !empty($_POST['fname']) &&
	isset($_POST['company']) &&  !empty($_POST['company']) &&	isset($_POST['list']) &&  !empty($_POST['list'])
){
$email=$_POST['email'];
$phone=$_POST['phone'];
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$company=$_POST['company'];
$list=$_POST['list'];
if (isset($_FILES['attachment'])){
	//$check = getimagesize($_FILES["attachment"]["tmp_name"]);
	$tmp_file=$_FILES['attachment']['tmp_name'];
	$attachment =chunk_split(base64_encode(file_get_contents($tmp_file))); // Set your file path here
}
else{
$attachment="";
}



sendEmail($email, $phone, $fname, $lname, $company, $list, $attachment);
	
}
else{
//please provide email
echo json_encode(array(
																				'status' => 'error',
																				'message' => 'Please fill all fields'
																));
																exit();


}

		

		
		function sendEmail($email, $phone, $fname, $lname, $company, $list, $attachment){
			//$to='info@rindgroup.com';
			$to='nnyanziian@gmail.com';

		//$message =  "Request Quote from ".$fname." ".$lname.", ".$email.", ".$phone.", ".$company.", ".$list;
		
		
		$message='<!DOCTYPE html><head><meta charset="UTF-8"><title>RindPharma - Request Mail from:'.$fname." ".$lname.'</title>
		<style>

						*{ -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;	margin:0; padding:0;}
						img { width:150px; margin:10px auto; display:block; }
						body{ border:3px solid #ad1c17; font-family: "Source Sans Pro", Arial, Helvetica, sans-serif;
							font-size: 20px;
							line-height: 32px;
							font-weight: 300;
							color: rgba(0, 0, 0 , 0.5);
							background: #f7f7f7;
							
							text-rendering: optimizeLegibility;
							vertical-align: baseline;
						}

						.group{
						width:80%;
						display:block;
						margin:10px auto;
						background-color:#618739;
						padding:5px;
						overflow:auto;
						}

						.group-light{
						width:80%;
						display:block;
						margin:10px auto;
						background-color:#fff;
						padding:5px;
						overflow:auto;
						}

						.name{
						color:#fff;
						font-weight:bold;
						width:30%;
						display:block;
						float:left;
						}

						.name-dark{
						color:#787878;
						font-weight:bold;
						width:30%;
						display:block;
						float:left;
						}

						.value{
						color:rgba(255, 255, 255, 0.7);
						font-weight:light;
						display:block;
						float:left
						width:70%;
						}

						.value-dark{
						color:rgba(0, 0, 0, 0.4);
						font-weight:light;
						display:block;
						float:left
						width:70%;
						}


</style>
</head>
<body>

<img src="images/ico/apple-touch-icon-57.png">
<div class="group"><span class="name">Name: </span><span class="value">'.$fname.' '.$lname.'</span></div>
<div class="group"><span class="name">Email: </span><span class="value">'.$email.'</span></div>
<div class="group"><span class="name">Phone: </span><span class="value">'.$phone.'</span></div>
<div class="group"><span class="name">Company: </span><span class="value">'.$company.'</span></div>
<div class="group-light"><span class="name-dark">List: </span><span class="value-dark">'.$list.'</span></div>


</body>

</html>';








		$subject="Request Quote From ".$fname." ".$lname;
		/*set up the email headers*/
		
		$headers = 'From: ' . $fname." ".$lname ."\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		$random_hash = md5(date('r', time()));
		$headers .= "Content-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\r\n";
		$message .= $attachment;
		
		/*send the message and check if its been sent and respond accordingly*/
		if (mail($to, $subject, $message, $headers)){
			echo json_encode(array(
																				'status' => 'success',
																				'message' => 'Thank you, Your Quote has been received'
																));
																exit();
		} 
		else{
				echo json_encode(array(
																				'status' => 'error',
																				'message' => 'You message has not been sent please try again '.print_r(error_get_last())
																));
																exit();
			}
		}

?>




