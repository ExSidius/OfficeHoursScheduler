<?php
require_once("../support.php");

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if (isset($_POST['drop'])){
    // Attempt drop database query execution
    $sql = "DROP DATABASE officeHoursScheduler";
    if(mysqli_query($link, $sql)){
        echo "Database dropped successfully.<br>";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
}

if (isset($_POST['setup'])){
// Attempt create database query execution
$sql = "CREATE DATABASE officeHoursScheduler";
if(mysqli_query($link, $sql)){
    echo "Database created successfully.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}


// Attempt to use database
$sql = "use officeHoursScheduler";
if(mysqli_query($link, $sql)){
    echo "Using database officeHoursScheduler.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

 /*----------------------------- vv Tables vv ----------------------------*/
// Attempt create users table query execution
$sql = "CREATE TABLE usersTA(
    id VARCHAR(100) NOT NULL UNIQUE PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    office VARCHAR(100) NOT NULL,
    photograph longblob NOT NULL,
    section VARCHAR(4) NOT NULL
)";

if(mysqli_query($link, $sql)){
    echo "TA table created successfully.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$sql = "GRANT ALL ON officeHoursScheduler.usersTA TO dbuser@localhost IDENTIFIED BY 'goodbyeWorld'";
if(mysqli_query($link, $sql)){
    echo "Login credentials for TA table established.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$sql = "CREATE TABLE usersInstructor(
    id VARCHAR(100) NOT NULL UNIQUE PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    office VARCHAR(100) NOT NULL,
    photograph longblob NOT NULL,
    section VARCHAR(4) NOT NULL
)";

if(mysqli_query($link, $sql)){
    echo "Instructor table created successfully.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$sql = "GRANT ALL ON officeHoursScheduler.usersInstructor TO dbuser@localhost IDENTIFIED BY 'goodbyeWorld'";
if(mysqli_query($link, $sql)){
    echo "Login credentials for instructor table established.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$sql = "CREATE TABLE usersStudent(
    id VARCHAR(100) NOT NULL UNIQUE PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    section VARCHAR(4) NOT NULL
)";

if(mysqli_query($link, $sql)){
    echo "Student table created successfully.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$sql = "GRANT ALL ON officeHoursScheduler.usersStudent TO dbuser@localhost IDENTIFIED BY 'goodbyeWorld'";
if(mysqli_query($link, $sql)){
    echo "Login credentials for student table established.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$sql = "CREATE TABLE currentQ(
    id VARCHAR(100) NOT NULL,
    name VARCHAR(100) NOT NULL,
    issue VARCHAR(280) NOT NULL,
    aptTime VARCHAR(25) NOT NULL,
    position int NOT NULL
)";

if(mysqli_query($link, $sql)){
    echo "Current queue table created successfully.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$sql = "GRANT ALL ON officeHoursScheduler.currentQ TO dbuser@localhost IDENTIFIED BY 'goodbyeWorld'";
if(mysqli_query($link, $sql)){
    echo "Login credentials for current queue table established.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$sql = "CREATE TABLE pastQ(
    id VARCHAR(100) NOT NULL,
    name VARCHAR(100) NOT NULL,
    issue VARCHAR(280) NOT NULL,
    aptTime VARCHAR(25) NOT NULL
)";

if(mysqli_query($link, $sql)){
    echo "Current queue table created successfully.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$sql = "GRANT ALL ON officeHoursScheduler.pastQ TO dbuser@localhost IDENTIFIED BY 'goodbyeWorld'";
if(mysqli_query($link, $sql)){
    echo "Login credentials for past queue table established.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}


/*----------------------------- ^^ Tables ^^ ----------------------------*/ 

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
