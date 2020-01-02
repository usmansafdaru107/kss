<?php

class sessionManager{
	private $sessionID=NULL;
	private $is_alive=0;
	private $account_type=NULL;
	private $user=NULL;
	private $db=NULL;
	public function __construct($session_id){
		$this->sessionID=$session_id;
		$db_array=parse_ini_file("kass.ini",true);
		$this->db=new mysqli($db_array['host_name'],$db_array['username'],$db_array['password'],$db_array['database']);
		$get_current_session=$this->db->prepare("SELECT account_type,status,user_id FROM logins WHERE session_id=? LIMIT 1");
		$get_current_session->bind_param('s',$session);
		$session=$this->sessionID;

		if(!$get_current_session->execute()){
				die($this->db->error);
			}else{
				$res=$get_current_session->get_result();
				if($res->num_rows>0){
					$res=$res->fetch_assoc();
					$this->account_type=$res['account_type'];
					$this->is_alive=$res['status'];
					$this->user=$res['user_id'];
				}
			}
	}

	public function getStatus(){
		return $this->is_alive;
	}

	public function getAC(){
		return $this->account_type;
	}

	public function user(){
		return $this->user;
	}

	 function update(){
		$update_timestamp=$this->db->prepare("UPDATE logins SET last_seen=NOW() WHERE session_id=? LIMIT 1");
		$update_timestamp->bind_param('s',$session);
		$session=$this->sessionID;

		if(!$update_timestamp->execute()){
			die($this->db->error);
		}else{
			if($this->db->affected_rows>0){
				return true;
			}else{
				return false;
			}
		}
	}

	public function invalidate(){
		$invalidate=$this->db->prepare("UPDATE logins SET status=0 WHERE session_id=?");
		$invalidate->bind_param('s',$session);
		$session=$this->sessionID;

		if(!$invalidate->execute()){
			die($this->db->error);
		}else{
			if($this->db->affected_rows>0){
				return true;
			}else{
				return false;
			}
		}
	}
}

?>