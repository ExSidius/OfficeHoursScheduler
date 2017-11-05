<?php
    
    require_once ("db/dbLogin.php");
    session_start();

    
    // Go to login incase of error
    if (isset($_POST['goToIndex'])) {
        //todo: remove - after development
        header("Location: index.php");
    }
    
    $body = <<<EOBODY
    <form action="$_SERVER[PHP_SELF]" method="post">
        <input type="submit" name="goToIndex" value="Return to Log In" /><br><br>
    </form>
EOBODY;
    
    /* Connecting to the database */
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    } else {
        //echo "Connection to database established<br>";
    }
    
    /* set up query */
    $query = "insert into " . $table . " values(\"{$_SESSION['email']}\", password(\"{$_SESSION['password']}\"), \"{$_SESSION['fullname']}\", \"{$_SESSION['zipcode']}\")";

    /* Executing query */
    $result = $db_connection->query($query);
    if (!$result) {
        die("Insertion failed: " . $db_connection->error . $body);
    } else {
        /* Signup sucessful */
        //todo: remove - after development
        header("Location:index.php");
    }
    
    /* Closing connection */
    $db_connection->close();
?>