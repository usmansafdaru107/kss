<?php
	function fetch_crumbs($slide='',$lesson='',$topic='',$theme='')
	{
		$db=connect_db();
		if(isset($slide) && !empty($slide))
		{
			$sql=$db->query("SELECT s.slide_id,s.slide_name,l.lesson_id,l.name,t.topic_id,t.topic_name,th.theme_id,th.theme_name,sb.subject_id,sb.subject_name,cs.cs_id,cs.class_id,c.class_name FROM slide AS s JOIN lessons AS l ON s.lesson=l.lesson_id JOIN topics AS t ON l.topic=t.topic_id JOIN themes_units AS th ON th.theme_id=t.unit_theme_id JOIN tutors AS tt ON th.tutor=tt.tutor_id JOIN class_subjects AS cs ON tt.class_subject=cs.cs_id JOIN subjects AS sb ON cs.subject_id=sb.subject_id JOIN classes AS c ON c.class_id=cs.class_id WHERE s.slide_id='$slide' LIMIT 1");
			if(!$sql)
			{
				die($db->error);
			}

			else
			{
				if($sql->num_rows>0)
				{
					$crumb=array();
					$res=$sql->fetch_assoc();
					array_push($crumb,array('crumb'=>'slides.php','crumb_data'=>'../api/slides/lesson/'.$res['lesson_id'],'crumb_name'=>$res['name']));
					array_push($crumb,array('crumb'=>'topics.php','crumb_data'=>'../api/lesson/topic/'.$res['topic_id'],'crumb_name'=>$res['topic_name']));
					array_push($crumb,array('crumb'=>'themes.php','crumb_data'=>'../api/topics/theme/'.$res['theme_id'],'crumb_name'=>$res['theme_name']));
					array_push($crumb,array('crumb'=>'subjects.php','crumb_data'=>'../api/units/subject/'.$res['cs_id'],'crumb_name'=>$res['subject_name']));
					array_push($crumb,array('crumb'=>'subjects.php','crumb_data'=>'../api/subjects/class'.$res['class_id'],'crumb_name'=>$res['class_name']));;
					echo json_encode($crumb);
				}
				$db->close();
			}
		}

		else if(isset($lesson) && !empty($lesson))
		{
			$sql=$db->query("SELECT l.lesson_id,l.name,t.topic_id,t.topic_name,th.theme_id,th.theme_name,sb.subject_id,sb.subject_name,cs.cs_id,c.class_name,c.class_id FROM lessons AS l JOIN topics AS t ON l.topic=t.topic_id JOIN themes_units AS th ON th.theme_id=t.unit_theme_id JOIN tutors AS tt ON th.tutor=tt.tutor_id JOIN class_subjects AS cs ON tt.class_subject=cs.cs_id JOIN classes AS c ON c.class_id=cs.class_id JOIN subjects AS sb ON cs.subject_id=sb.subject_id WHERE l.lesson_id='$lesson'");

			if(!$sql)
			{
				die($db->error);
			}

			else
			{
				if($sql->num_rows>0)
				{
					$crumb=array();
					$res=$sql->fetch_assoc();
					array_push($crumb,array('crumb'=>'topics.php','crumb_data'=>'../api/lesson/topic/'.$res['topic_id'],'crumb_name'=>$res['topic_name']));
					array_push($crumb,array('crumb'=>'themes.php','crumb_data'=>'../api/topics/theme/'.$res['theme_id'],'crumb_name'=>$res['theme_name']));
					array_push($crumb,array('crumb'=>'subjects.php','crumb_data'=>'../api/units/subject/'.$res['cs_id'],'crumb_name'=>$res['subject_name']));
					array_push($crumb,array('crumb'=>'subjects.php','crumb_data'=>'../api/subjects/class/'.$res['class_id'],'crumb_name'=>$res['class_name']));;
					echo json_encode($crumb);
				}
				$db->close();
			}
		}

		else if(isset($topic) && !empty($topic))
		{
			$sql=$db->query("SELECT t.topic_id,t.topic_name,th.theme_id,th.theme_name,sb.subject_id,sb.subject_name,cs.cs_id,c.class_name,c.class_id FROM topics AS t JOIN themes_units AS th ON th.theme_id=t.unit_theme_id JOIN tutors AS tt ON th.tutor=tt.tutor_id JOIN class_subjects AS cs ON tt.class_subject=cs.cs_id JOIN classes AS c ON c.class_id=cs.class_id JOIN subjects AS sb ON cs.subject_id=sb.subject_id WHERE t.topic_id='$topic'");

			if(!$sql)
			{
				die($db->error);
			}

			else
			{
				if($sql->num_rows>0)
				{
					$crumb=array();
					$res=$sql->fetch_assoc();
					array_push($crumb,array('crumb'=>'themes.php','crumb_data'=>'../api/topics/theme/'.$res['theme_id'],'crumb_name'=>$res['theme_name']));
					array_push($crumb,array('crumb'=>'subjects.php','crumb_data'=>'../api/units/subject/'.$res['cs_id'],'crumb_name'=>$res['subject_name']));
					array_push($crumb,array('crumb'=>'subjects.php','crumb_data'=>'../api/subjects/class/'.$res['class_id'],'crumb_name'=>$res['class_name']));;
					echo json_encode($crumb);
				}
				$db->close();
			}
		}

		else if(isset($theme) && !empty($theme))
		{
			$sql=$db->query("SELECT th.theme_id,th.theme_name,sb.subject_id,sb.subject_name,cs.cs_id,c.class_name,c.class_id FROM themes_units AS th ON JOIN tutors AS tt ON th.tutor=tt.tutor_id JOIN class_subjects AS cs ON tt.class_subject=cs.cs_id JOIN subjects AS sb ON cs.subject_id=sb.subject_id WHERE th.theme_id='$theme'");

			if(!$sql)
			{
				die($db->error);
			}

			else
			{
				if($sql->num_rows>0)
				{
					$crumb=array();
					$res=$sql->fetch_assoc();
					array_push($crumb,array('crumb'=>'subjects.php','crumb_data'=>'../api/units/subject/'.$res['cs_id'],'crumb_name'=>$res['subject_name']));
					array_push($crumb,array('crumb'=>'subjects.php','crumb_data'=>'../api/subjects/class/'.$res['class_id'],'crumb_name'=>$res['class_name']));;
					echo json_encode($crumb);
				}
				$db->close();
			}
		}
	}
?>