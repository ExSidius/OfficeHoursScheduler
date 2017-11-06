<?php 

	class TA extends Person{
		private $office;

		function __constructor($name, $uid){
			parent::__construct($name, $uid);
		}

		public function __toString(){
			return "TA named: ".$this->name;
		}

		protected function addNewAppointment($student, $issueSubject, $issueMessage, $comments = ""){
			//TODO
		}

		protected function addComment($appointment, $comments){
			//TODO
		}

		protected function moveOffice($newLocation){
			//TODO
		}

		protected function getAppointments($class="default", $day="default"){
			//TODO
		}
	}

 ?>