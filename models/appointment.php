<?php 

	class Appointment {
		private $date;
		private $location;
		private $class;
		private $issueSubject;
		private $issueMessage;
		private $student;
		private $instructor;
		private $comments;

		function __construct($date, $location, $class, $issueSubject, $issueMessage){
			$this->date = $date;
			$this->class = $class;
			$this->location = $location;
			$this->issueSubject = $issueSubject;
			$this->issueMessage = $issueMessage;
		}

		public function setInstructor($instructor){
			$this->instructor = $instructor;
		}

		public function setStudent($student){
			$this->student = $student;
		}

		public function setDate($date){
			$this->date = $date;
		}

		public function setLocation($location){
			$this->location = $location;
		}

		public function setClass($class){
			$this->class = $class;
		}

		public function setComments($comments){
			$this->comments = $comments;
		}

		public function setIssue($issueSubject, $issueMessage){
			$this->issueSubject = $issueSubject;
			$this->issueMessage = $issueMessage;
		}

		public function getInstructor(){
			return $this->instructor;
		}

		public function getStudent(){
			return $this->student;
		}

		public function getDate(){
			return $this->date;
		}

		public function getLocation(){
			return $this->location;
		}

		public function getClass($class){
			return $this->class;
		}

		public function getComments($comments){
			return $this->comments;
		}

		public function getIssueSubject(){
			return $this->issueSubject;
		}

		public function getIssueMessage(){
			return $this->issueMessage;
		}
	}

 ?>