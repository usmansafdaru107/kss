<?php
	function view_payment($sponsor=0,$reciept=0){
		session_start();
		if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['account'])
				&& !empty($_SESSION['account'])
				&& isset($_SESSION['status']) && $_SESSION['status']==true){
				if(isset($sponsor) && !empty($sponsor) && strcmp($_SESSION['account'],'admin')==0){
						$db=connect_db();
						$fetch_sponsor_recs=$db->prepare("SELECT y.yo_ref,s.sponsor_name,s.sponsor_id,y.amount,y.phone_no,y.carrier_code,y.date_paid,y.subscription_count,y.status FROM sponsors AS s JOIN yo_payments AS y ON y.sponsor_id=s.sponsor_id WHERE s.sponsor_id=? AND s.status=1");
						$fetch_sponsor_recs->bind_param("i",$sponsor_id);
						$sponsor_id=$sponsor;

						if(!$fetch_sponsor_recs->execute()){
							die($db->error);
						}
						else{
							$res=$fetch_sponsor_recs->get_result();
							$fetch_sponsor_recs->close();
							$db->close();
							echo json_encode($res->fetch_all(MYSQLI_ASSOC));
							exit();
						}
					}

			else if(isset($reciept) && !empty($reciept)){
					$db=connect_db();

					if(strcmp($_SESSION['account'],'sponsor')==0)
					{
						$fetch_sponsor_recs=$db->prepare("SELECT yo_ref,amount,phone_no,carrier_code,date_paid,subscription_count,status FROM yo_payments WHERE sponsor_id=? AND yo_ref=?");
						$fetch_sponsor_recs->bind_param("ii",$sponsor_id,$rpt);
						$sponsor_id=$_SESSION['user'];
						$rpt=$reciept;
					}
					else if(strcmp($_SESSION['account'],'admin')==0){
						$fetch_sponsor_recs=$db->prepare("SELECT y.yo_ref,s.sponsor_name,s.sponsor_id,y.amount,y.phone_no,y.carrier_code,y.date_paid,y.subscription_count,y.status FROM sponsors AS s JOIN yo_payments AS y ON y.sponsor_id=s.sponsor_id WHERE y.yo_ref=? LIMIT 1");
						$fetch_sponsor_recs->bind_param("i",$rpt);
						$rpt=$reciept;
					}

					if(!$fetch_sponsor_recs->execute()){
						die($db->error);
					}
					else{
						$res=$fetch_sponsor_recs->get_result();
						$fetch_sponsor_recs->close();
						$db->close();
						echo json_encode(array('status'=>'success','data'=>$res->fetch_all(MYSQLI_ASSOC)));
						exit();
					}
			}
			else {
					if(strcmp($_SESSION['account'],'sponsor')==0){
							$db=connect_db();
							$fetch_sponsor_recs=$db->prepare("SELECT yo_ref,amount,phone_no,carrier_code,date_paid,subscription_count,status FROM yo_payments WHERE sponsor_id=?");
							$fetch_sponsor_recs->bind_param("i",$sponsor_id);
							$sponsor_id=$_SESSION['user'];
						}

						elseif (strcmp($_SESSION['account'],'admin')==0 && $_SESSION['previlege']==1){
							$db=connect_db();
							$fetch_sponsor_recs=$db->prepare("SELECT y.yo_ref,s.sponsor_name,s.sponsor_id,y.amount,y.phone_no,y.carrier_code,y.date_paid,y.subscription_count,y.status FROM sponsors AS s JOIN yo_payments AS y ON y.sponsor_id=s.sponsor_id");
						}
						else{
							echo json_encode(array("status"=>"failed","message"=>"Please login to a previleged account to continue"));
							exit();
						}

						if(!$fetch_sponsor_recs->execute()){
							die($db->error);
						}
						else{
							$res=$fetch_sponsor_recs->get_result();
							$fetch_sponsor_recs->close();
							$db->close();
							echo json_encode(array('status'=>'success','data'=>$res->fetch_all(MYSQLI_ASSOC)));
							exit();
						}
				}
		}
		
		else{
				echo json_encode(array("status"=>"failed","message"=>"Please login to continue"));
			}
	}

function list_students($reciept){
		session_start();
		if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['account'])
				&& !empty($_SESSION['account']) && strcmp($_SESSION['account'], 'admin')==0 || strcmp($_SESSION['account'], 'sponsor')==0
				&& isset($_SESSION['status']) && $_SESSION['status']==true)
		{
			$db=connect_db();
			$fetch_students=$db->prepare("SELECT e.enrollment_id,e.class_id,c.class_name,s.f_name,s.l_name FROM yo_payments AS yo JOIN subscriptions AS sub ON yo.yo_ref=sub.reciept_no JOIN enrollments AS e ON e.enrollment_id=sub.enrollment_id JOIN students AS s ON s.student_id=e.student_id JOIN classes AS c ON c.class_id=e.class_id WHERE yo.yo_ref=?");
			$fetch_students->bind_param('i',$yo_ref);
			$yo_ref=$reciept;
			if(!$fetch_students->execute()){
				die($db->error);
			}else{
				$res=$fetch_students->get_result();
				$res=$res->fetch_all(MYSQLI_ASSOC);
				echo json_encode(array('status'=>'success','data'=>$res));
			}
		}
		else{
				echo json_encode(array("status"=>"failed","message"=>"Please login to continue"));
			}
	}

function generate_subscribed_pdf($reciept){

	}
?>