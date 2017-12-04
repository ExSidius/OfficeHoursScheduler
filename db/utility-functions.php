<?php
require_once("../support.php");

function connectToDB() {

	/* Attempt MySQL server connection. Assuming you are running MySQL
	server with default setting (user 'root' with no password) */
	$link = mysqli_connect("localhost", "root", "");
	 
	// Check connection
	if($link === false){
	    die("ERROR: Could not connect. " . mysqli_connect_error());
	}

	// Attempt to use database
	$sql = "use officeHoursScheduler";
	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	return $link;

}

// Given a filepath to an image, parse it into a longblob that can be inserted into table
function parsePhoto($dir) {

	$fp = fopen($dir, 'r');
	$image = fread($fp, filesize($dir));
	$image = addslashes($image);

	return $image;

}

// Add an instructor into the instructors table
function addInstructor($id, $name, $office, $photographDir, $section) {

	$link = connectToDB();
	$image = parsePhoto($photographDir);

	$sql = "INSERT INTO usersInstructor (id, name, office, photograph, section)
			VALUES ('$id', '$name', '$office', '$image', '$section')";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	mysqli_close($link);

}

// Add a TA into the TAs table
function addTA($id, $name, $office, $photographDir, $section) {

	$link = connectToDB();
	$image = parsePhoto($photographDir);

	$sql = "INSERT INTO usersTA (id, name, office, photograph, section)
			VALUES ('$id', '$name', '$office', '$image', '$section')";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	mysqli_close($link);

}

// Add a student into the students table
function addStudent($id, $name, $section) {

	$link = connectToDB();

	$sql = "INSERT INTO usersStudent (id, name, section)
			VALUES ('$id', '$name', '$section')";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	mysqli_close($link);

}

// When a student signs in for office hours, they are added to the current queue
function addToCurrentQueue($id, $name, $issue) {

	$link = connectToDB();

	$sql = "SELECT COUNT(*) FROM currentQ";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	// Fetch the number of current entries in the queue (current queue size)
	$result = mysqli_query($link, $sql);
	$rows = $result->fetch_array(MYSQLI_NUM)[0];

	// Set the position of the student as the current queue size + 1
	$position = $rows + 1;

	// Generate a numerical timestamp based on the current time to be added to table
	$time = date("Y-m-d h:i:sa");
	$time = strtotime($time);

	$sql = "INSERT INTO currentQ (id, name, issue, aptTime, position)
			VALUES ('$id', '$name', '$issue', '$time', '$position')";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	mysqli_close($link);

}

// After a student has been seen by a TA, this function will be used to insert them into the past queue
function addToPastQueue($id, $name, $issue, $time) {

	$link = connectToDB();

	$sql = "INSERT INTO pastQ (id, name, issue, aptTime)
			VALUES ('$id', '$name', '$issue', '$time')";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	mysqli_close($link);

}

// This function removes any entries in the past queue that are older than 24 hours
function removeOldRowsInPastQueue() {

	$link = connectToDB();

	// Generate a numerical timestamp based on the current time
	$time = date("Y-m-d h:i:sa");
	$timestamp = strtotime($time);

	// Set a cutoff time that is 24 hours previous to the current timestamp
	$cutoffTime = $timestamp - 86400;
	
	// Delete all rows in table where the timestamp is less than the cutoff time
	$sql = "DELETE FROM pastQ WHERE aptTime < $cutoffTime";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	mysqli_close($link);

}

// Updates the current queue by removing the student who was just seen, 
// updating the positions of the remaining students on the queue, inserting
// that student into the past queue, then removing old rows from the past queue.
function updateCurrentQueue() {

	$link = connectToDB();

	$sql = "SELECT * FROM currentQ WHERE position=1";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	$result = mysqli_query($link, $sql);

	// Fetches the fields of the student with position = 1
	$arr = $result->fetch_assoc();

	$id = $arr["id"];
	$name = $arr["name"];
	$issue = $arr["issue"];
	$timestamp = $arr["aptTime"];

	// Add the student to the past queue
	addToPastQueue($id, $name, $issue, $timestamp);

	// Remove the student from the current queue
	$sql = "DELETE FROM currentQ WHERE position=1";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	// Update positions of all remaining students on the current queue
	$sql = "UPDATE currentQ SET position = position-1";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	removeOldRowsInPastQueue();

	mysqli_close($link);

}

// Returns the number of daily tokens given a student id
function getNumberOfTokens($id) {

	removeOldRowsInPastQueue();

	$link = connectToDB();

	$sql = "SELECT * FROM pastQ WHERE id='$id'";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	// Fetches the number of times in the past 24 hours that the student has appeared in the past queue
	$result = mysqli_query($link, $sql);
	$frequency = $result->num_rows;


	$sql = "SELECT * FROM currentQ WHERE id='$id'";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	// Fetches the number of times in the past 24 hours that the student has appeared in the current queue
	$result = mysqli_query($link, $sql);
	$frequency = $frequency + $result->num_rows;

	mysqli_close($link);

	// Returns the remaining amount of tokens the student has
	return 5 - $frequency;

}

// Returns an array of arrays of table entries of all students on the current queue (in order)
function listOfStudentsOnCurrentQueue() {

	$link = connectToDB();

	$sql = "SELECT * FROM currentQ";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	$result = $link->query($sql);

	while($row = $result->fetch_array()) {
		$rows[] = $row;
	}

	mysqli_close($link);

	return $rows;

}

// Returns size of the current queue
function getCurrentQueueSize() {

	return count(listOfStudentsOnCurrentQueue());

}

// Given a student ID, return that student's highest position in the current queue
function getPositionInQueue($id) {

	$link = connectToDB();

	$sql = "SELECT position FROM currentQ WHERE id='$id'";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	$result = mysqli_query($link, $sql);

	$arr = $result->fetch_assoc();

	if ($arr === null) {
		return -1;
	}
	else {
		return $arr["position"];
	}

	mysqli_close($link);

}

class Student {

	private $id;
	private $name;
	private $section;

	public function __construct($id, $name, $section) 
    {
        $this->id = $id;
        $this->name = $name;
        $this->section = $section;
    }

    public function getId() {
    	return $this->id;
    }

    public function getName() {
    	return $this->name;
    }

  	public function getSection() {
    	return $this->section;
    }


}

class TA {
	
	private $id;
	private $name;
	private $office;
	private $photographDir;
	private $section;

	public function __construct($id, $name, $office, $photographDir, $section) 
    {
        $this->id = $id;
        $this->name = $name;
        $this->office = $office;
        $this->photographDir = $photographDir;
        $this->section = $section;
    }

    public function getId() {
    	return $this->id;
    }

    public function getName() {
    	return $this->name;
    }

    public function getOffice() {
    	return $this->office;
    }

    public function getphotographDir() {
    	return $this->photographDir;
    }

  	public function getSection() {
    	return $this->section;
    }

}

class Instructor {
	
	private $id;
	private $name;
	private $office;
	private $photographDir;
	private $section;

	public function __construct($id, $name, $office, $photographDir, $section) 
    {
        $this->id = $id;
        $this->name = $name;
        $this->office = $office;
        $this->photographDir = $photographDir;
        $this->section = $section;
    }

    public function getId() {
    	return $this->id;
    }

    public function getName() {
    	return $this->name;
    }

    public function getOffice() {
    	return $this->office;
    }

    public function getphotographDir() {
    	return $this->photographDir;
    }

  	public function getSection() {
    	return $this->section;
    }

}

?>