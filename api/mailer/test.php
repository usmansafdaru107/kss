<?php
	include('class.EmailTemplate.php');
	$template=new EmailTemplate('template.html');
	$template->f_name='Onen';
	$template->l_name='Julius';
	echo $template->compile();
?>