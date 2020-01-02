<?php
session_start();
if (isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['username']) && !empty($_SESSION['username']) && isset($_SESSION['status']) && $_SESSION['status'] == true && isset($_SESSION['account']) && $_SESSION['account'] == 'admin')
	{

//setting cokiees for the user type to be used when user is loged in
	$cookie_name = "adminType";
	$cookie_value = $_SESSION['previlege'];
//set for 30 day most probably a month
	if (!isset($_COOKIE[$cookie_name])) {
		setcookie($cookie_name, $cookie_value, time() + (66400 * 30), "/");
	}
	require_once ('inc/header.php');
}
else {
	$_SESSION = array();
	session_destroy();
	header("location:login.php?notification=Please Login to Continue");
}
?>
		<div class="mainBox">
		<br>
		<div id="content-area">
		
		</div>
		
		</div>
		
		</div>	
		</div>	
		                          
    <!--Main Conetent Area -->
	<div class="loader">
		
		</div><!-- loader -->
	
<?php
require ('inc/footer.php');
	//print_r($_SESSION);
?>
