<?php
/**
 * Created by PhpStorm.
 * User: ExSidius
 * Date: 12/3/17
 * Time: 11:16 PM
 */
    $prebody = "<!DOCTYPE html>
    <html lang=\"en\">
        <head>
            <meta charset=\"utf-8\">
    
            <title>Schedule</title>
            <!-- Latest compiled and minified CSS -->
            <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">
    
            <!-- jQuery library -->
            <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>
    
            <!-- Latest compiled JavaScript -->
            <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>
    
            <link rel=\"stylesheet\" href=\"../css/navbar.css\">
            <link rel=\"stylesheet\" href=\"../css/default.css\">
    
        </head>
    
        <body>
    
            <div class=\"wrapper\">
                <div class=\"navbar navbar-default navbar-static-top\">
                    <div class=\"container-fluid\">
                        <div class=\"navbar-header\">
                            <a class=\"navbar-brand\" href=\"http://www.cs.umd.edu/class/fall2017/cmsc389N/staff.shtml\">
                                Office Hours Scheduling
                            </a>
    
                            <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#main_nav_bar\" aria-expanded=\"false\" aria-controls=\"navbar\">
                                <span class=\"sr-only\">Toggle navigation</span>
                                <span class=\"icon-bar\"></span>
                                <span class=\"icon-bar\"></span>
                                <span class=\"icon-bar\"></span>
                            </button>
                        </div>
    
    
                        <div id=\"main_nav_bar\" class=\"collapse navbar-collapse\">
                            <ul id=\"menuItems\" class=\"nav navbar-nav navbar-right\">
                                <li class=\"dropdown\">
                                    <a class=\"dropdown-toggle my-nav-links line-right\" data-toggle=\"dropdown\" href=\"#\">Overview
                                        <span class=\"caret\"></span></a>
                                    <ul class=\"dropdown-menu\">
                                        <li><a class=\"\" href=\"#\">CMSC132</a></li>
                                        <li><a class=\"\" href=\"#\">CMSC216</a></li>
                                        <li><a class=\"\" href=\"#\">CMSC389N</a></li>
                                        <!--This part will have to be generated dynamically.-->
                                    </ul>
                                </li>
                                <li><a class=\"my-nav-links line-right\" href=\"./schedule.html\" target=\"_blank\">Schedule</a></li>
                                <li><a class=\"my-nav-links line-right\" href=\"https://www.google.com\" target=\"_blank\">Class Web Page</a></li>
                                <li><a class=\"my-nav-links\" href=\"./FAQs.html\" target=\"_blank\">FAQs</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
    
                <div class=\"row\">
                    <div class=\"col-md-4\"></div>
                    <div class=\"col-md-5\">
                        <div class=\"timetable\">
    ";

    $postbody = "
                        </div>
                    </div>
                    <div class=\"col-md-3\"></div>
                </div>
            </div>
    
            <script src=\"./../js/schedule.js\"></script>
    
        </body>
    </html>";

    $body = "<table border='1px'>";

    $table = Array();
    if (($handle = fopen("../data/officehours.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            array_push($table, $data);
        }

    //    print_r($table);
        fclose($handle);

        foreach ($table as $key=>$element) {

            $tag_type = "";
            if ($key === 0) {
                $tag_type = "th";
            } else {
                $tag_type = "td";
            }

            $body .= "<tr>";
            foreach ($element as $_=>$slot) {
                if ($_ !== 0) {
                    $body .= "<".$tag_type.">".preg_replace("/\s+/", ", ", trim($slot))."</".$tag_type.">";
                } else {
                    $body .= "<".$tag_type.">".trim($slot)."</".$tag_type.">";
                }
            }
            $body .= "</tr>";
        }

        $body .= "</table>";

        file_put_contents("../templates/schedule.html", $prebody.$body.$postbody);

        echo("<h2>Schedule Built Successfully!</h2>");
    }
?>