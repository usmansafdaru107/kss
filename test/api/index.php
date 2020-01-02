<?php
	require 'Slim/Slim.php';
	include 'config.php';
	include 'lib/classes.php';
	include 'lib/subjects.php';
	include 'lib/units.php';
	include 'lib/topics.php';
	include 'lib/lessons.php';
	include 'lib/slides.php';
	include 'lib/resources.php';
	include 'lib/admin.php';
	include 'lib/tutors.php';
	include 'lib/quizes.php';
	include 'lib/questions.php';
	include 'lib/answers.php';
	include 'lib/crumbs.php';


	\Slim\Slim::registerAutoloader();

	$app=new \Slim\Slim();

	//admin
	$app->post("/admin","add_admin");
	$app->get("/admin/logout","logout");
	$app->post("/admin/login","admin_login");
	$app->get("/admin(/:id)","fetch_admin");
	$app->post("/admin/edit/:id","edit_admin");
	$app->get("/admin/delete/:id","delete_admin");

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

	$app->run();

?>