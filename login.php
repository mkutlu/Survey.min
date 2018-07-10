<?php
include("config.php");
session_start();
error_reporting(0);
if ($_SESSION['login_user'] != "") {
    header("location: home.php");
 }
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $myusername = mysqli_real_escape_string($db, $_POST['username']);
    $mypassword = mysqli_real_escape_string($db, $_POST['password']);

    $sql = "SELECT username FROM users WHERE username = '$myusername' and password = '$mypassword'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        $_SESSION['login_user'] = $myusername;

        header("location: home.php");
    } else {
        $error = "Your Login Name or Password is invalid";
    }
}
?>
<html>

    <head>
        <title>Login Page - KUTLU</title>
    </head>

    <body bgcolor = "#FFFFFF">

        <div align = "center">
            <div style = "width:300px; border: solid 1px #333333; " align = "left">
                <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>

                <div style = "margin:30px">

                    <form action = "" method = "post">
                        <label>Username  :</label><input type = "text" name = "username" class = "box"/><br /><br />
                        <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
                        <input type = "submit" value = " Submit "/><br />
                    </form>

                    <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>

                </div>

            </div>

        </div>

    </body>
</html>