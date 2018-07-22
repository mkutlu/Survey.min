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
        <script src="js/scripts.js"></script>
        <link href="css/styles.css" rel="stylesheet">
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
                                if (isset($_SESSION['login_user'])) {
                                    $username = mysqli_real_escape_string($db, $_SESSION['login_user']);
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
            <div class="col-xs-12 col-md-1 profile-sidebar top40" >
                <button type="button" class="btn-primary btn-lg btn-block" id="create-btn" onclick="window.location.href = 'createSurvey.php'">Create Survey</button><br />
            </div>
            <div class="col-xs-12 col-md-9 profile-sidebar top40" >
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1default" data-toggle="tab">Created Surveys</a></li>
                            <li><a href="#tab2default" data-toggle="tab">Public Surveys</a></li>                          
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab1default">
                                <?php
                                echo '<table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Survey Name</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Creation Date</th>
                                                    <th scope="col">Version</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                $sql = "SELECT surveyname,surveydesc,surveydate,surveyversion FROM surveys where  username='".$_SESSION['login_user']."'";
                                $result = mysqli_query($db, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {

                                    echo '<tr><td>' . $row['surveyname'] . '</td><td>' . $row['surveydesc'] . '</td><td> ' . $row['surveydate'] . '</td><td>' . $row['surveyversion'] . '</td></tr>';
                                }
                                echo '</tbody></table>'
                                ?> 
                            </div>
                            <div class="tab-pane fade" id="tab2default">
                                <div class="menuitem">
                                    <?php
                                    echo '<table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Survey Name</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Creation Date</th>
                                                    <th scope="col">Version</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                    $sql = "SELECT surveyname,surveydesc,surveydate,surveyversion FROM surveys";
                                    $result = mysqli_query($db, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {

                                        echo '<tr><td>' . $row['surveyname'] . '</td><td>' . $row['surveydesc'] . '</td><td> ' . $row['surveydate'] . '</td><td>' . $row['surveyversion'] . '</td></tr>';
                                    }
                                    echo '</tbody></table>'
                                    ?> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-element col-xs-12 col-md-2 top40">
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
