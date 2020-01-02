<?php

if (isset($_POST['fname']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['msg'])){
$fname=$_POST['fname'];
$email=$_POST['email'];
if(isset($_POST['phone'])){
$tel=$_POST['phone'];
}
else{
$tel="no-tel";
}
$msg=$_POST['msg'];



$to='kampalasmartschool@gmail.com,admin@kampalasmartschool.com';

		/*initialize the message that is to be sent to the specified email above*/
		$message =  "<h4 style='padding:5px; border:1px solid #000;'>Name: ".$fname."</h4> \n <p>Email: ".$email."</p> \n <p>Phone Number".$tel."</p> \n </p>Message:".$msg."</p>";
		$subject="Message From KAS Client:";
		/*set up the email headers*/
		$headers = '';
		$headers .= 'From: ' . $fname." ".$email."\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		
		/*send the message and check if its been sent and respond accordingly*/
		if (mail($to, $subject, $message, $headers)){
		echo"Hey ". $fname ." We have received your message, we shall get back to you immediately on your Email: ".$email."<br/> <a href='./'>Back to Home</a>";			} 
			else{
			echo "Sorry There was a Problem while Sending Your Message Please try again<a href='./'>Back to Home</a>";	
			}
		

}

else{

header('location:index.php');
}


?>