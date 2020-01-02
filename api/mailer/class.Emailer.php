<?php
	class Emailer
	{
		var $credentials=array();
		var $sender=array();
		var $recipients=array();
		var $template='';
		var $txt_body=array();

		public function __construct($username,$password){
			$this->credentials['username']=$username;
			$this->credentials['password']=$password;
			require 'PHPMailerAutoload.php';
		}

		public function addSender($name,$email){
			$this->sender['name']=$name;
			$this->sender['email']=$email;
		}

		public function addRecipient($name,$email){
			array_push($this->recipients, $email);
		}

		public function setTemplate($template){
			$this->template=$template;
		}

		public function set_Alt_body($txt){
			$this->txt_body=$txt;
		}

		public function send($subject){
			$header = "From: Kampala Smart School <noreply@kampalasmartschool.com> \r\n";
			$header .="Reply-To: Mugarura Emmanuel <admin@kampalasmartschool.com>";
         	$header .= "MIME-Version: 1.0\r\n";
         	$header .= "Content-type: text/html\r\n";
         	//var_dump($this->recipients);
         	$to=implode(",",$this->recipients);

			mail ($to,$subject,$this->template,$header);
			$this->recipients=[];
			/*date_default_timezone_set('Etc/UTC');
			$mail = new PHPMailer;
			//$mail->isSMTP();
			$mail->SMTPDebug = 3;
			$mail->Debugoutput = 'html';
			$mail->Host = 'mail.kampalasmartschool.com';
			$mail->Port = 25; 
			$mail->SMTPOptions = array(
			    'ssl' => array(
			        'verify_peer' => false,
			        'verify_peer_name' => false,
			        'allow_self_signed' => true
			    )
			    );
			$mail->SMTPSecure = 'tls';
			$mail->SMTPAuth = true;
			$mail->Username = $this->credentials['username'];
			$mail->Password = $this->credentials['password'];
			echo $mail->Username;
			echo $mail->Password;
			$mail->setFrom($this->sender['email'], $this->sender['name']);

			foreach ($this->recipients as $recipient){
				$mail->addAddress($recipient['email'], $recipient['name']);
			}
			//Set the subject line
			$mail->Subject = $subject;
			$mail->msgHTML($this->template);
			$mail->AltBody = $this->txt_body;
			set_time_limit(300);
			$mail->send();
			$this->recipients=array();*/
		}
	}
?>