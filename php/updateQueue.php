<?php
/**
 * Created by PhpStorm.
 * User: ExSidius
 * Date: 12/4/17
 * Time: 11:40 AM
 */

require_once("../db/utility-functions.php");

    if (isset($_COOKIE['uid'])) {
        $pos = getPositionInQueue($_COOKIE['uid']);

        if ($pos < 0) {
            $pos = "not";
            $eta = "no minutes";
        } else {
            $eta = ($pos * 5)." minutes";
            $pos = "#".$pos;
        }

        $toks = getNumberOfTokens($_COOKIE['uid']);
    }

    echo(json_encode(Array(getCurrentQueueSize(), $pos, $eta, $toks)));

?>