<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Instructor Template</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/default.css">

</head>

<body>

    <div class="wrapper">
        <div class="navbar navbar-default navbar-static-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="http://www.cs.umd.edu/class/fall2017/cmsc389N/staff.shtml">
                        Office Hours Scheduling
                    </a>

                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main_nav_bar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>


                <div id="main_nav_bar" class="collapse navbar-collapse">
                    <ul id="menuItems" class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle my-nav-links line-right" data-toggle="dropdown" href="#">Overview
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a class="" href="#">CMSC132</a></li>
                                <li><a class="" href="#">CMSC216</a></li>
                                <li><a class="" href="#">CMSC389N</a></li>
                                <!--This part will have to be generated dynamically.-->
                            </ul>
                        </li>
                        <li><a class="my-nav-links line-right" href="./schedule.html" target="_blank">Schedule</a></li>
                        <li><a class="my-nav-links line-right" href="https://www.google.com" target="_blank">Class Web Page</a></li>
                        <li><a class="my-nav-links" href="./FAQs.html" target="_blank">FAQs</a></li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="row">
                <div class="col-md-3 ta-deck item">
                    <h3 id="ta-queue">TAs on Deck: 3</h3>
                    <hr>
                    <div id="ta-deck">
                        <p class="ta-name"><a target="_blank" href="https://en.wikipedia.org/wiki/Jack_Johnson_(musician)">Jack Johnson</a></p><br>
                        <p class="ta-name"><a target="_blank" href="https://en.wikipedia.org/wiki/Patrice_O%27Neal">Patrice O'Neal</a></p><br>
                        <p class="ta-name"><a target="_blank" href="https://en.wikipedia.org/wiki/Lizz_Winstead">Lizz Winstead</a></p><br>
                    </div>
                </div>

                <div class="col-md-3 student-deck item">
                    <h3 id="students-queue">Students in Queue: 3</h3>
                    <hr>
                    <div id="student-deck">
                        <button onclick="" class="student-name">Banana Republic</button><br><br>
                        <button onclick="" class="student-name">Beastie Boy</button><br><br>
                        <button onclick="" class="student-name">Fiona Apple</button><br><br>
                        <button onclick="" class="student-name">Shaq O'Neal</button><br><br>
                        <button onclick="" class="student-name">Bill Burr</button><br><br>
                        <button onclick="" class="student-name">Ray Dalio</button><br><br>
                        <button onclick="" class="student-name">Walter Isaacson</button><br><br>
                        <button onclick="" class="student-name">Edgar Wright</button><br><br>
                    </div>
                </div>


                <div class="col-md-3 how-to item">
                    <h3>How-To</h3>
                    <hr>
                    Click the student name to see more information about them.
                </div>

            </div>


        </div>

    </div>

<script src="./../js/default.js"></script>
<script>
    let requestObj = new XMLHttpRequest();
    let firstFeedbackMessage = true;
    let studentList;

    setInterval(lookup, 1000);

    function lookup () {
        let scriptURL = "./updateStudents.php";

        let randomValueToAvoidCache = (new Date()).getTime();
        scriptURL += "?randomValue=" + randomValueToAvoidCache;
        console.log(scriptURL);

        let asynch = true;

        requestObj.open("GET", scriptURL, asynch);
        requestObj.onreadystatechange = updateStudents;

        requestObj.send(null);

    }

    function updateStudents () {
        let studentDeck = document.getElementById("student-deck");
        let studentQueue = document.getElementById("students-queue");


        if (requestObj.readyState === 4) {
            if (requestObj.status === 200) {
                let results = requestObj.responseText;

//                console.log(JSON.parse(results));

                let size = JSON.parse(results)[0];
                let students = JSON.parse(results)[1];
                studentList = students;
                let deckHTML = "";

                students.forEach(function (el) {
                    deckHTML += '<button id="' + el[0] + '" onclick="knockOff()" class="student-name">' + el[0] + '</button><br><br>';
                });

                studentDeck.innerHTML = deckHTML;
                studentQueue.innerHTML = "Students in Queue: " + size;

            } else {
                alert("Request Failed.");
            }
        }
    }

    function knockOff () {
        let scriptURL = "./knockOffStudents.php";

        let randomValueToAvoidCache = (new Date()).getTime();
        scriptURL += "?randomValue=" + randomValueToAvoidCache;
        console.log(scriptURL);

        let asynch = true;

        requestObj.open("GET", scriptURL, asynch);
        requestObj.onreadystatechange = knockOffStud;

        requestObj.send(null);
    }

    function knockOffStud () {
        if (requestObj.readyState === 4) {
            if (requestObj.status === 200) {
                let results = requestObj.responseText;

                console.log(results);

            } else {
                alert("Request Failed.");
            }
        }
    }
</script>
</body>
</html>