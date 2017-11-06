<?php 

	abstract class Person {
		protected $name;
		protected $uid;
		protected $picture;

		function __construct($name, $uid) {
			$this->name = $name;
			$this->uid = $uid;
		}

		function __toString() {
			return "Person named: ".$this->name;
		}

		function getName(){
			return $this->name;
		}

		function getUID(){
			return $this->uid;
		}
	}

?>