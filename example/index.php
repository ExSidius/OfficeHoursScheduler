<?php

require_once("support.php");
session_start();

if (isset($_POST['login'])){
  $_SESSION['email']= trim($_POST['email']);
  $_SESSION['password']= trim($_POST['password']);
  header("Location: login_backend.php");
}
   
if (isset($_POST['create'])){
  $_SESSION['email']= trim($_POST['email']);
  $_SESSION['password']= trim($_POST['password']);
  $_SESSION['fullname']= trim($_POST['fullname']);
  $_SESSION['zipcode']= trim($_POST['zipcode']);
  header("Location: signup_backend.php");    
}


$head = <<<EOBODY
  <title>Paws Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900'>
    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Montserrat:400,700'>
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="css/login.css">
EOBODY;

$script = <<<EODATA
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="js/index.js"></script>
EODATA;


$body = <<<EODATA
    <div class="form">
      <!-- logo -->
      <div id="littlePaw">
        <span class="fa fa-paw" aria-hidden="true"></span>
      </div>
      <!-- app name -->
      <div class="container name">
        <div class="row">
          <div class="col-lg-12">
            <h2 id="name">Paws</h2>
          </div>
        </div>
      </div>      
      <form class="register-form" action="$_SERVER[PHP_SELF]" method="post">
        <input type="text" placeholder="Full Name" id="fullname" name="fullname" required/>
        <input type="password" placeholder="Password" id="password" name="password" required/>
        <input type="text" placeholder="Email" name="email" id="email" required/>
        <input type="text" placeholder="Zip Code" name="zipcode" id="zipcode" required/>
        <input type="submit" name="create" id="create" value="Create" />
        <p class="message">Already registered? <a href="#">Sign In</a></p>
      </form>
      <form class="login-form" action="$_SERVER[PHP_SELF]" method="post">
        <input type="email" name="email" placeholder="Email"required/>
        <input type="password" name="password" placeholder="Password" required/>
        <input type="submit" name="login" id="login" value="Log In" />
        <p class="message">Not registered? <a href="#">Create an account</a></p>
      </form>
      
    </div>
EODATA;

echo generatePage($body, $head, $script);
?>
