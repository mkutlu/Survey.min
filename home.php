<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include('session.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($db, $_SESSION['login_user']);
    if (isset($_POST['parea'])) {
        $content = "<p>" . mysqli_real_escape_string($db, $_POST['parea']) . "</p>";
    }
    date_default_timezone_set('Europe/Istanbul');
    $date = date('d.m.Y H:i:s');

    $sql = "SELECT max(sequence) as max_id FROM contents WHERE user = '" . $username . "'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = $row['max_id'];

    //$count = mysqli_num_rows($result);
    $count = $count + 1;

    $sql = "INSERT INTO contents (user, sequence, content, time) VALUES ('" . $username . "', '" . $count . "', '" . $content . "','" . $date . "')";

    function alert($msg) {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }

    alert($sql);
    $result = mysqli_query($db, $sql);
    if ($result === TRUE) {
        
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Profile - KUTLU</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="scripts.js"></script>
        <link href="styles.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar  navbar-inverse  navbar-fixed-top">
            <div class="container">
                <button type="button" class="navbar-toggle"
                        data-toggle="collapse"
                        data-target=".navbar-collapse"
                        >
                    <span class="sr-only"> Toggle navigation</span>
                    <span class="icon-bar"> </span>
                    <span class="icon-bar"> </span>
                    <span class="icon-bar"> </span>
                </button>
                <img class="navbar-brand" src="img/logo.png" alt="logo" width="100" height="100"/>

                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class=""><a href="#">
                                <?php
                                if (isset($_GET['username'])) {
                                    $user_check = $_GET['username'];
                                    $ses_sql = mysqli_query($db, "select name,surname from users where username = '$user_check' ");
                                    $row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);
                                    $login_session = $row['name'] . " " . $row['surname'];
                                }
                                echo $login_session;
                                ?>
                            </a> </li>
                        <li> <a href = "logout.php">Sign Out</a> </li>                 
                    </ul>
                </div>
            </div>
        </nav>
        <br/>
        <div class="container-back">
            <div class="col-xs-12 col-sm-2 col-md-1 profile-sidebar top40" >
                <button type="button" class="btn-primary btn-lg btn-block" id="create-btn" onclick="window.location.href='createSurvey.php'">Create Survey</button><br />
            </div>
            
            <div id="profile-content" class="col-xs-12 col-sm-8 col-md-9 top40">
                <?php
                if (isset($_GET['username'])) {
                    if ($_GET['username'] == $_SESSION['login_user']) {
                        $username = mysqli_real_escape_string($db, $_SESSION['login_user']);
                    } else {
                        $username = $_GET['username'];
                    }
                } else {
                    $username = mysqli_real_escape_string($db, $_SESSION['login_user']);
                }
                $sql = "SELECT content,time FROM contents WHERE user = '$username' ORDER BY sequence DESC";
                $result = mysqli_query($db, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="content-element col-xs-12 col-sm-12 col-md-12">
                    <button type="button" class="close" onclick="deleteItem();">&times;</button>';
                    echo '<button data-html="true"  style="float: right; margin-right: 10px;" type="button" class="btn btn-xs btn-warning" data-container="body" data-toggle="popover" data-placement="bottom" data-content="';
                    echo "<form id='settings1'>Background Color:<input type='color' id='back-color' name='back-color' value='#ff0000'><br/>Font Color:<input type='color' id='font-color' name='font-color' value='#ff0000'><br/>Size:<input type='text' class='form-control' id='usr'><input type='submit'></form>";
                    echo '">
                        CSS
                    </button>';
                    echo $row['content'];
                    echo "</div>";
                }
                ?>
            </div>
            <div class="content-element col-xs-12 col-sm-8 col-md-2 top40">
                <?php
                $sql = "SELECT username,name,surname FROM users";
                $result = mysqli_query($db, $sql);
                echo '<b>User List:</b> <br />';
                while ($row = mysqli_fetch_assoc($result)) {

                    echo '<a href="home.php?username=' . $row['username'] . '">' . $row['name'] . ' ' . $row['surname'] . '</a> <br />';
                }
                ?>               
            </div>
        </div>      
    </body>
</html>
