<?php
//header("Content-Type: application/json; charset=UTF-8");
	function add_program()
	{
		$conn = connect_db();
	
		$full_name = isescape('full_name');
		$type = isescape('type');
		$location = isescape('location');
		$email = isescape('email');
		$phone = isescape('phone');
		exists($email);
	
		$sql = "INSERT INTO program_reg (full_names, type, location, email, phone) VALUES ('$full_name', '$type', '$location', '$email', '$phone')";

	
		$result = mysqli_query($conn, $sql);
	
		if (!$result) {
			echo json_encode(array(
				'status' => 'error',
				'message' => mysqli_error($conn)
			));
			exit();
		}
		else {
			echo json_encode(array(
				'status' => 'success',
				'message' => 'Hello, '.$full_name.' your registration was successful, be sure to check your email for any updates.'
			));
			exit();
		}
	
	}
	function getAllMembers(){
		$conn=connect_db();
		$sql = "SELECT * FROM program_reg";
		$result = mysqli_query($conn, $sql);
		if (!$result) {
			
			echo json_encode(array(
				'status' => 'error',
				'message' => mysqli_error($conn)
			));
			exit();
		}
		else{
			
			if ($result->num_rows > 0) {
				
				echo json_encode(array(
					'status' => 'success',
					'data' => $result->fetch_all(MYSQLI_ASSOC)
				));
				exit();
			} else if ($result->num_rows <= 0) {
				
				echo json_encode(array(
					'status' => 'failed',
					'message' => 'Members not Found'
				));
				exit();
			}
		}
	}
	function isescape($elem = '')
	{
		$conn = connect_db();
		if (isset($_POST[$elem]) && !empty($_POST[$elem]))
		{
			$elem = mysqli_real_escape_string($conn, $_POST[$elem]);
			return $elem;
		}
		else
		{
			echo json_encode(array(
				'status' => 'error',
				'message' => $elem . ' is not provided'
			));
			exit();
		}
	}
	function exists($field = ''){
	$conn = connect_db();
	$sql = "SELECT id FROM program_reg WHERE email = '$field'";
	$result = mysqli_query($conn, $sql);
	if (!$result) {

		echo json_encode(array(
			'status' => 'error',
			'message' => mysqli_error($conn)
		));
		exit();
	}
	else {

		if ($result->num_rows > 0) {

			echo json_encode(array(
				'status' => 'error',
				'message' => $field.' is already regsitered, try using another email'
			));
			exit();
		}
	}
}

?>