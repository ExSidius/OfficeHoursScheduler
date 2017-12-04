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

$sql = "SELECT * FROM products WHERE id = $id";
$sth = $db->query($sql);
$result=mysqli_fetch_array($sth);
echo '<img src="data:image/jpeg;base64,'.base64_encode( $result['image'] ).'"/>';


$sql = "SELECT * FROM usersTA";

/*----------------------------- ^^ Tables ^^ ----------------------------*/ 

// Close connection
mysqli_close($link);

$body = <<<EOBODY
<body>

</body>
EOBODY;

echo generatePage($body, "Admin", "", "");
?>