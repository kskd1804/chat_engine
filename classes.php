<?php
	class Recents{
		private $firstName,$lastName,$imgURL,$status,$msg;
		
		public function getfirstName(){
			return $this->firstName;	
		}
	
		public function setfirstName($name){
			$this->firstName=$name;
		}
		
		public function getlastName(){
			return $this->lastName;	
		}
	
		public function setlastName($name){
			$this->lastName=$name;
		}
		
		public function getStatus(){
			return $this->status;	
		}
	
		public function setStatus($name){
			$this->status=$name;
		}
		
		public function getimgURL(){
			return $this->imgURL;	
		}
	
		public function setimgURL($name){
			$this->imgURL=$name;
		}	
		
		public function getMsg(){
			return $this->msg;	
		}
	
		public function setMsg($name){
			$this->msg=$name;
		}
	}
?>