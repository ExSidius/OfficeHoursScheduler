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

function addToCurrentQueue() {
	$link = connectToDB();

	$sql = "SELECT COUNT(*) FROM currentQ";

	if(mysqli_query($link, $sql) === false){
	    die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	}

	$result = mysqli_query($link, $sql);
	$rows = $result->fetch_array(MYSQLI_NUM)[0];

	echo $rows;

	// $sql = "INSERT INTO currentQ (id, name, issue, aptTime, position)
	// 		VALUES ('$id', '$name', '$section')";

	// if(mysqli_query($link, $sql) === false){
	//     die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
	// }

	mysqli_close($link);
}

addToCurrentQueue();

$body = <<<EOBODY
<body>

</body>
EOBODY;

echo generatePage($body, "Admin", "", "");
?>