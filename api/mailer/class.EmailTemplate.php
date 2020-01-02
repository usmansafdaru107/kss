<?php
	class EmailTemplate
	{
		var $variables=array();
		var $file_path=array();

		function __construct($file_path){
			if(!file_exists($file_path)){
				trigger_error("Template not found",E_USER_ERROR);
				return;
			}
			$this->file_path=$file_path;
		}

		public function __set($key,$val){
			$this->variables[$key]=$val;
		}

		public function setTemplate($file_path){
			if(!file_exists($file_path)){
				trigger_error("Template not found",E_USER_ERROR);
				return;
			}
			$this->file_path=$file_path;
		}

		public function compile(){
			ob_start();
			extract($this->variables);
			include $this->file_path;

			$content=ob_get_contents();
			ob_end_clean();
			$this->variables=array();
			return $content;
		}
	}
?>