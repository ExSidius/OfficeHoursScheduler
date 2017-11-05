<?php

    require_once "db/dbLogin.php";
    require_once("support.php");
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
    
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    } else {
        //echo "Connection to database established<br>";
    }
    
    $email = $_SESSION['email'];
    $pass = $_SESSION['password'];

    /* Query with hashed password */
    $query = "select * from " . $table . " where email=\"$email\" and password=password(\"$pass\")";	
    
    /* Executing query */
    $result = $db_connection->query($query);
    if (!$result) {
        die("Retrieval failed: " . $db_connection->error);
    } else {
        
        /* Number of rows found */
        $num_rows = $result->num_rows;
        if ($num_rows === 0) {
            echo "<h2>No entry exists in the database for the specified email and password</h2>" . $body;
            
        } else {

            /* login sucessful */
            for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                $result->data_seek($row_index);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
		      /* Retrieve user results and set sessions */
                $_SESSION['email']   = $row['email'];
                
                // todo: add users fields to sessions array
                // $_SESSION['']  = $row[''];
               
                //todo: add location to go after sucessful login -> main page
                // header("Location:#");
                echo "Login Successful";
                   }
        }
    }
    
    /* Freeing memory */
    $result->close();
    
    /* Closing connection */
    $db_connection->close();
  
?>