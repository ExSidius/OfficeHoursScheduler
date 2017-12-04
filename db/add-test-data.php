<?php
require_once("../support.php");

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql = "INSERT INTO usersTA (name, office, section, photograph)
		VALUES ('Andrej', 'AVW 1120', '0101', '" . file_get_contents($tmp_image) . "')";




// Close connection
mysqli_close($link);
}

$body = <<<EOBODY
<body>
    <form action="$_SERVER[PHP_SELF]" method="post">
        <input type="submit" name="drop" value="Drop Database" /> 
        <input type="submit" name="setup" value="Setup Database" /><br>
    </form>
</body>
EOBODY;

echo generatePage($body, "Admin", "", "");
?>