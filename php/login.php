<?php
/**
 * Created by PhpStorm.
 * User: ExSidius
 * Date: 12/4/17
 * Time: 12:27 AM
 */

    $login_nm = $_POST["uid"];
    $login_passwd = $_POST["password"];

    /* Establish a connection to the LDAP server */
    $ldapconn=ldap_connect("ldap://ldap.umd.edu/",389) or die('Could not connect<br>');
    // $ldapconn=ldap_connect("ldaps://ldap.umd.edu/",389) or die('Could not connect<br>');

    /* Set the protocol version to 3 (unless set to 3 by default) */
    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

    /* Bind user to LDAP with password */
    $verify_user=ldap_bind($ldapconn,"uid=$login_nm,ou=people,dc=umd,dc=edu",$login_passwd);

    /* Returns 1 on Success */
    if ($verify_user != 1) {
        /* Failed */
        echo "<h1>Invalid UID/password combination.</h1><br>";
    } else {
        /* Success */
//        echo "You have been authenticated as having a valid UMD directory ID.";

        $cookie_name = "uid";
        $cookie_value = $login_nm;
        $expire_time = time() + (86400 * 30);

        setcookie($cookie_name, $cookie_value, $expire_time, "/");
        header("Location: ../templates/student.html");
        exit();
    }

    // Release connection
    ldap_unbind($ldapconn);

?>

<button type="button" onclick="returnToLogin()">Back to Login Page</button>
<script>

    function returnToLogin () {
        window.location = "../Login.html";
    }

</script>