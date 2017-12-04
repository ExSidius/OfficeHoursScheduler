<?php
/**
 * Created by PhpStorm.
 * User: ExSidius
 * Date: 12/4/17
 * Time: 12:15 PM
 */

require_once("../db/utility-functions.php");

    if (getNumberOfTokens($_COOKIE['uid']) >= 1) {
         addToCurrentQueue($_COOKIE['uid'], $_COOKIE['uid'], $_POST['issue']);
    }

    header("Location: ./student.php");
    exit();

?>