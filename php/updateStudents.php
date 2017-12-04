<?php
/**
 * Created by PhpStorm.
 * User: ExSidius
 * Date: 12/4/17
 * Time: 10:49 AM
 */

    require_once("../db/utility-functions.php");

    $students = listOfStudentsOnCurrentQueue();
//    echo($students);

    echo(json_encode($students));

?>
