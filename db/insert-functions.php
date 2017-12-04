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

function parsePhoto($dir) {

	$fp = fopen($dir, 'r');
	$image = fread($fp, filesize($dir));
	$image = addslashes($image);

	return $image;

}

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

function addStudent($id, $name, $section) {

	$link = connectToDB();

	$sql = "INSERT INTO usersStudent (id, name, section)
			VALUES ('$id', '$name', '$section')";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	mysqli_close($link);

}

function addToCurrentQueue($id, $name, $issue) {

	$link = connectToDB();

	$sql = "SELECT COUNT(*) FROM currentQ";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	$result = mysqli_query($link, $sql);
	$rows = $result->fetch_array(MYSQLI_NUM)[0];

	$position = $rows + 1;

	$time = date("Y-m-d h:i:sa");
	$time = strtotime($time);

	$sql = "INSERT INTO currentQ (id, name, issue, aptTime, position)
			VALUES ('$id', '$name', '$issue', '$time', '$position')";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	mysqli_close($link);

}

function addToPastQueue($id, $name, $issue, $time) {

	$link = connectToDB();

	$sql = "INSERT INTO pastQ (id, name, issue, aptTime)
			VALUES ('$id', '$name', '$issue', '$time')";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	mysqli_close($link);

}

function removeOldRowsInPastQueue() {

	$time = date("Y-m-d h:i:sa");
	$timestamp = strtotime($time);

	$cutoffTime =  $timestamp - 86400;
	$link = connectToDB();

	$sql = "DELETE FROM pastQ WHERE aptTime < $cutoffTime";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	mysqli_close($link);

}

function updateCurrentQueue() {

	$link = connectToDB();

	$sql = "SELECT * FROM currentQ WHERE position=1";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	$result = mysqli_query($link, $sql);

	$arr = $result->fetch_assoc();

	$id = $arr["id"];
	$name = $arr["name"];
	$issue = $arr["issue"];
	$timestamp = $arr["aptTime"];

	addToPastQueue($id, $name, $issue, $timestamp);

	$sql = "DELETE FROM currentQ WHERE position=1";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	$sql = "UPDATE currentQ SET position = position-1";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	removeOldRowsInPastQueue();

	mysqli_close($link);

}

// $time = date("Y-m-d h:i:sa");
// $timestamp = strtotime($time);

// $cutoffTime =  $timestamp - 86400;

// addToCurrentQueue("mdn1023", "Michael Nguyen", "Entry 1");
// addToCurrentQueue("mdn1023", "Michael Nguyen", "Entry 2");
// addToCurrentQueue("mdn1023", "Michael Nguyen", "Entry 3");
// addToCurrentQueue("mdn1023", "Michael Nguyen", "Entry 4");

// updateCurrentQueue();

// addToPastQueue("mdn1023", "Michael Nguyen", "This should be deleted.", $cutoffTime);
// addToPastQueue("mdn1023", "Michael Nguyen", "This should NOT be deleted.", $timestamp);

// removeOldRowsInPastQueue();

$body = <<<EOBODY
<body>

</body>
EOBODY;

echo generatePage($body, "Admin", "", "");
?>