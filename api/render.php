<?php
	ob_start();
	include '../'.$_GET['url'];
	$page=ob_get_clean();
	echo '<html><head><base href="http://www.kampalasmartschool.com/api/"></head><body>'.$page.'</body></html>';
?>