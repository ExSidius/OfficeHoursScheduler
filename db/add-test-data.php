<?php
require_once("../support.php");

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Attempt to use database
$sql = "use officeHoursScheduler";
if(mysqli_query($link, $sql)){
    echo "Using database officeHoursScheduler.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

/*----------------------------- vv Tables vv ----------------------------*/

$dir = "photosTA/andrej.png";
$fp = fopen($dir, 'r');
$image = fread($fp, filesize($dir));
$image = addslashes($image);

$sql = "INSERT INTO usersTA (name, office, photograph, section)
		VALUES ('Andrej', 'AVW 1120', '$image', '0101')";

if(mysqli_query($link, $sql)){
    echo "Successfully added in TA info for Andrej.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$dir = "photosTA/roozbeh.jpg";
$fp = fopen($dir, 'r');
$image = fread($fp, filesize($dir));
$image = addslashes($image);

$sql = "INSERT INTO usersTA (name, office, photograph, section)
		VALUES ('Roozbeh', 'AVW 1120', '$image', '0101')";

if(mysqli_query($link, $sql)){
    echo "Successfully added in TA info for Roozbeh.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$dir = "photosTA/nelson.png";
$fp = fopen($dir, 'r');
$image = fread($fp, filesize($dir));
$image = addslashes($image);

$sql = "INSERT INTO usersInstructor (name, office, photograph, section)
		VALUES ('Nelson', 'AVW 1120', '$image', '0101')";

if(mysqli_query($link, $sql)){
    echo "Successfully added in Instructor info for Nelson.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}



$sql = "INSERT INTO usersStudent (name, section)
		VALUES ('Michael', '0101')";

if(mysqli_query($link, $sql)){
    echo "Successfully added in Student info for Michael.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$sql = "INSERT INTO usersStudent (name, section)
		VALUES ('Mukul', '0101')";

if(mysqli_query($link, $sql)){
    echo "Successfully added in Student info for Mukul.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$sql = "INSERT INTO usersStudent (name, section)
		VALUES ('Akshay', '0101')";

if(mysqli_query($link, $sql)){
    echo "Successfully added in Student info for Akshay.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$sql = "INSERT INTO usersStudent (name, section)
		VALUES ('Tushar', '0101')";

if(mysqli_query($link, $sql)){
    echo "Successfully added in Student info for Tushar.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}


/*----------------------------- ^^ Tables ^^ ----------------------------*/ 

// Close connection
mysqli_close($link);

$body = <<<EOBODY
<body>

</body>
EOBODY;

echo generatePage($body, "Admin", "", "");
?>