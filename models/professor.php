<?php 

	class Professor extends TA{

		function __constructor($name, $uid){
			parent::__construct($name, $uid);
		}

		public function __toString(){
			return "Professor named: ".$this->name;
		}
	}

 ?>