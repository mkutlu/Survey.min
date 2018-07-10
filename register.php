<?php
include("config.php");
session_start();
error_reporting(0);
if ($_SESSION['login_user'] != "") {
    header("location: home.php");
 }
$error="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form 

    $name = mysqli_real_escape_string($db, $_POST['name']);
    $surname = mysqli_real_escape_string($db, $_POST['surname']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    $sql = "SELECT username FROM users WHERE username = 'username'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    //$active = $row['active'];

    $count = mysqli_num_rows($result);

    // If result matched $myusername and $mypassword, table row must be 1 row

    if ($count == 1) {
        $error = "Username already exist!";
        //session_register("myusername");
    }else if($name=="" || $surname==""||$username==""||$password==""){
        $error = "Fill all inputs!";
    }
    else {
        $sql = "INSERT INTO users (name, surname, username, password) VALUES ('" . $name . "', '" . $surname . "', '" . $username . "', '" . $password . "')";
        $result = mysqli_query($db, $sql);
        if ($result === TRUE) {
            echo '<script language="javascript">';
            echo 'alert("Registration completed. Redirect to login page")';
            echo '</script>';
            header("location: login.php");
        } else {
             $error = "Error while registration";
        }
    }
}
?>
<html>
    <head>
        <title>Registration Page</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="scripts.js"></script>
        <link href="styles.css" rel="stylesheet">
    </head>

    <body bgcolor = "#FFFFFF">

        <div align = "center">
            <div style = "width:300px; border: solid 1px #333333; " align = "left">
                <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>

                <div style = "margin:30px">

                    <form action = "" method = "post">
                        <label>Name  :</label><input type = "text" name = "name" class = "box"/><br /><br />
                        <label>Surname  :</label><input type = "text" name = "surname" class = "box" /><br/><br />
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
