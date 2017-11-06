<?php 

	class Student extends Person{
		function __constructor($name, $uid){
			parent::__construct($name, $uid);
		}

		public function __toString(){
			return "Student named: ".$this->name;
		}

		public function getAppointments(){
			//TODO
		}
	}

 ?>