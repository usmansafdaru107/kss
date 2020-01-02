<?php
	require 'Slim/Slim.php';
	include 'config.php';
	include 'lib/admin_includes.php';
	include 'parents/parents_include.php';
	include 'programs.php';
	include 'students/students_sponsored.php';
	include 'students/students.php';
	include 'payments/payments.php';
	include 'settings/settings.php';
	include 'mailer/class.Emailer.php';
	include 'mailer/class.EmailTemplate.php';
	include 'sessionManager/class.sessionManager.php';
	date_default_timezone_set('Africa/Kampala');


	\Slim\Slim::registerAutoloader();

	$app=new \Slim\Slim();

	//admin
	$app->post("/admin","add_admin");
	$app->get("/admin/logout","logout");
	$app->post("/admin/login","admin_login");
	$app->get("/admin(/:id)","fetch_admin");
	$app->post("/admin/edit/:id","edit_admin");
	$app->get("/admin/delete/:id","delete_admin");

	//Programs
	$app->post("/programs/register","add_program");
	$app->get("/programs/members","getAllMembers");


	//tutors
	$app->post("/tutor","add_tutor");
	$app->get("/tutor(/:id)(/admin/:admin)(/class/:class)(/subject/:subject)(/class_subject/:classSubject)","fetch_tutor");
	$app->get("/tutor/delete/:id","delete_tutor");

	//classes

	$app->post("/classes","add_class");
	$app->get("/classes(/:id)(/tutor/:tutor)","retrieve_classes");
	$app->post("/classes/edit/:id","edit_class");
	$app->get("/classes/delete/:id","delete_class");

	//subjects
	$app->post("/subjects","add_subject");
	$app->get("/subjects(/:sub_id)(/class/:class)(/classes/:sub)(/class_sub/:class_subject)(/unattached/:not_taking)","fetch_subjects");
	$app->post("/subjects/edit/:id","edit_subject");
	$app->get("/subjects/delete/:id","delete_subject");
	$app->post("/subjects/class_subjects","add_class_subject");

	//themes And Unit
	$app->post("/units","add_unit");
	$app->get("/units(/:id)(/tutor/:tutor)(/user/:user)(/subject/:subject)","fetch_units");
	$app->post("/units/edit/:id","edit_units");
	$app->get("/units/delete/:id","delete_units");

	//topics
	$app->post("/topics","add_topic");
	$app->get("/topics(/:id)(/theme/:theme)","fetch_topics");
	$app->post("/topics/edit/:id","edit_topics");
	$app->get("/topics/delete/:id","delete_topic");

	//lessons
	$app->post("/lessons","add_lesson");
	$app->get("/lessons(/:id)(/topic/:topic)","fetch_lessons");
	$app->post("/lessons/edit/:id","edit_lessons");
	$app->get("/lessons/delete/:id","delete_lessons");

	//slides
	$app->post("/slides","add_slides");
	$app->get("/slides(/:id)(/lesson/:lesson)","fetch_slides");
	$app->post("/slides/edit/:id","edit_slide");
	$app->get("/slides/delete/:id","delete_slide");
	$app->get("/slides/render/:id","render_slide");

	//resources	
	$app->post("/resource","add_resource");
	$app->get("/resource(/:id)(/name/:name)(/type/:type)","fetch_resource");
	$app->post("/resource/edit/:id","edit_resource");
	$app->get("/resource/delete/:id","delete_resource");
	$app->get("/resource/search/:term","search_resource");

	//breadcrubs
	$app->get("/breadcrumbs(/slide/:slide)(/lesson/:lesson)(/topic/:topic)(/themes/:theme)(/subjects/:subject)","fetch_crumbs");

	//quizes

	$app->post("/quiz","add_quiz");
	$app->post("/quiz/edit/:id","edit_quiz");
	$app->get("/quiz(/:id)(/lesson/:lesson)","fetch_quiz");
	$app->get("/quiz/delete/:id","delete_quiz");
	$app->get("/quiz/setup/:id","set_up_quiz");

	//questions
	$app->post("/question","add_question");
	$app->post("/question/edit/:id","edit_question");
	$app->get("/question(/:id)(/quiz/:quiz)","fetch_question");
	$app->get("/question/delete/:id","delete_question");
	$app->get("/question/load/:id","set_up_qn");


	//answers
	$app->post("/answers","add_answer");
	$app->post("/answers/edit/:id","edit_answer");
	$app->get("/answers(/:id)(/question/:qn)","fetch_answer");
	$app->get("/answers/delete/:id","delete_answer");

	///////////////////////////////////////////////////////////////////
	//////// PARENTS /////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////

	$app->post("/sponsor","register_sponsor");
	$app->post("/sponsor/account/login","sponsor_login");
	$app->get("/sponsor/logout","logout");
	$app->get("/sponsor/profile(/:id)","fetch_sponsor");
	$app->post("/sponsor/student","add_student");
	$app->get("/sponsor/student(/:student_id)","fetch_student");
	$app->post("/sponsor/edit","edit_sponsor");

	///////////////////////////////////////////////////////////////////
	//////// students /////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////
	$app->post("/student/enroll","enroll_student");
	$app->post("/student/unenroll","un_enroll");
	$app->post("/student/login","student_login");
	$app->post("/student/subscribe","subscribe");
	$app->post("/student/edit","edit_student");
	$app->get("/student/enrollment(/student/:student_id)(/sponsor(/:sponsor_id))","student_enrollments");
	$app->get("/student(/:student_id/profile)","fetch_student");
	$app->get("/student/delete/:id","delete_student");
	$app->get("/student/check/:enrollment_id",'check_subscription');

	$app->get("/payments/verify/:reciept","verify_payment");
	$app->get("/payments/yo(/sponsor/:sponsor)(/reciept/:reciept)","view_payment");
	$app->get("/payments/students/reciept/:reciept","list_students");
	
	$app->get("/payments/yo/ipn","yo_ipn");
	$app->post("/payments/yo/ipn","yo_ipn");

	$app->post("/settings/password/reset/request","reset_password");
	$app->post("/settings/password/reset/complete","verify_password_reset");

	$app->run();

?>
