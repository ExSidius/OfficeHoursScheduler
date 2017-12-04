<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Student Template</title>
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
                    <a class="navbar-brand" href="./student.php">
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
                        <li><a class="my-nav-links line-right" href="http://www.cs.umd.edu/class/fall2017/cmsc389N/" target="_blank">Class Web Page</a></li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="row">
                <div class="col-md-3 ta-deck item">
                    <h3 id="ta-queue">TAs on Deck: 3</h3>
                    <hr>
                    <div class="ta-deck">
                        <p class="ta-name"><a target="_blank" href="https://en.wikipedia.org/wiki/Jack_Johnson_(musician)">Jack Johnson</a></p><br>
                        <p class="ta-name"><a target="_blank" href="https://en.wikipedia.org/wiki/Patrice_O%27Neal">Patrice O'Neal</a></p><br>
                        <p class="ta-name"><a target="_blank" href="https://en.wikipedia.org/wiki/Lizz_Winstead">Lizz Winstead</a></p><br>

                    </div>
                </div>

                <div class="col-md-3 student-deck item">
                    <h3 id="students-queue">Students in Queue: 3</h3>
                    <hr>

                    <p class="queue-message">
                        Welcome, <?php echo('<span id="uid">'.$_COOKIE["uid"].'</span>') ?>!<br><br>
                        You are <strong id="queue-pos">#3</strong> in the queue.
                        <br>
                        <br>
                        You should be helped in roughly<br><strong id="time">5 minutes</strong>.
                    </p>
                </div>

                <div class="col-md-6 queue-form item">
                    <h3>Get on Queue</h3>
                    <hr>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div id="ticket-submit-area">
                                <p id="num-tokens">You have <strong id="num-toks">5</strong> tokens remaining.</p>
                                <p><small>This will add you to the office hours queue and will cost one OH token.
                                    If you run out of tokens, you will not be able to receive office hours assistance
                                    until regeneration (every 24 hours).</small>
                                </p>
                                <hr>

<!--                                This code has come from cmsc330hours.cs.umd.edu - it is entirely their programmer's with minor modifications.-->

                                <form id="ticket-submit-form" method="post" action="addToQueue.php">
                                    <textarea name="issue" id="ticket-desc" class="form-control" rows="2" placeholder="Describe your issue in less than two sentences."></textarea>
                                    <br>
                                    <button id="ticket-button" type="submit" class="btn btn-default">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 how-to item">
                    <h3>How-To</h3>
                    <hr>
                    This is the Office Hours Scheduler.
                    <br><br>
                    You can see which TAs are available, how many students are on queue (and your position in queue), and you can submit a ticket.
                    <br><br>
                    <a href="./FAQs.html">Check out FAQs for more information.</a>
                </div>
            </div>

        </div>

    </div>

    <script src="./../js/default.js"></script>
    <script>
        let requestObj = new XMLHttpRequest();
        let firstFeedbackMessage = true;
//        let queue;

        setInterval(lookup, 1000);

        function lookup () {
            let scriptURL = "./updateQueue.php";

            let randomValueToAvoidCache = (new Date()).getTime();
            scriptURL += "?randomValue=" + randomValueToAvoidCache;
            console.log(scriptURL);

            let asynch = true;

            requestObj.open("GET", scriptURL, asynch);
            requestObj.onreadystatechange = updateQueue;

            requestObj.send(null);

        }

        function updateQueue () {
            let studentQueue = document.getElementById("students-queue");
            let taQueue = document.getElementById("ta-queue");
            let queuePos = document.getElementById("queue-pos");
            let timeLeft = document.getElementById("time");
            let toks = document.getElementById("num-toks");


            if (requestObj.readyState === 4) {
                if (requestObj.status === 200) {
                    let results = requestObj.responseText;

//                console.log(JSON.parse(results));

//                    console.log(results);
//                    console.log();

                    let queue = JSON.parse(results);

                    studentQueue.innerHTML = "Students in Queue: " + queue[0];
                    queuePos.innerHTML = queue[1];


                    let numTAs = parseInt(taQueue.textContent.charAt(taQueue.textContent.length - 1));

                    if (isNaN(queue[2])) {
                        timeLeft.innerHTML = Math.round(parseInt(queue[2]) / numTAs) + " minutes";
                    } else {
                        timeLeft.innerHTML = queue[2];
                    }

//                    timeLeft.innerHTML = queue[2];
                    toks.innerHTML = queue[3];

                } else {
                    alert("Request Failed.");
                }
            }
        }
    </script>
</body>
</html>