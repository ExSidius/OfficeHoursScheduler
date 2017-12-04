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

function addInstructor($name, $office, $photographDir, $section) {

	$link = connectToDB();
	$image = parsePhoto($photographDir);

	$sql = "INSERT INTO usersInstructor (name, office, photograph, section)
			VALUES ('$name', '$office', '$image', '$section')";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	mysqli_close($link);

}

function addTA($name, $office, $photographDir, $section) {

	$link = connectToDB();
	$image = parsePhoto($photographDir);

	$sql = "INSERT INTO usersTA (name, office, photograph, section)
			VALUES ('$name', '$office', '$image', '$section')";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	mysqli_close($link);

}

function addStudent($name, $section) {

	$link = connectToDB();

	$sql = "INSERT INTO usersStudent (name, section)
			VALUES ('$name', '$section')";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	mysqli_close($link);

}

$body = <<<EOBODY
<body>

</body>
EOBODY;

// addTA('TA1', 'AVW 1120', 'photosTA/roozbeh.jpg', '0101');
// addInstructor('Instructor1', 'AVW 1120', 'photosTA/nelson.png', '0101');
// addStudent('Student1', '0101');


echo generatePage($body, "Admin", "", "");
?>