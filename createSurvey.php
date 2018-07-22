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
//New survey creation
if (isset($_POST['htmlContent'])) {
    include('./pharse/pharse.php');
    $html =  $_POST['htmlContent'];
    
    $surveyName = $_POST['surveyName'];
    $surveyDesc = $_POST['surveyDesc'];
    
    $sql = "SELECT max(surveyid) as max_id FROM surveys";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = $row['max_id'];
    $surveyid = $count + 1;
    
    date_default_timezone_set('Europe/Istanbul');
    $date = date('d/m/Y h:i:s a', time());
    
    $surveyVersion = 1;
    
    $username = mysqli_real_escape_string($db, $_SESSION['login_user']);
    
    $sql = "INSERT INTO surveys (surveyid, surveyname, surveydesc, surveydate, surveyversion, username)"
            . " VALUES ('" . $surveyid . "', '" . $surveyName . "', '" . $surveyDesc . "','" . $date . "', '" . $surveyVersion . "',, '" . $username . "')";

    foreach ($html('li') as $element){
        $question = $element('textarea')->getPlainText();
        $sequence = $element('input')->value;
        $sql = "INSERT INTO questions (surveyid, sequence, question)"
            . " VALUES ('" . $surveyid . "', '" . $sequence . "', '" . $question . "')";
        $result = mysqli_query($db, $sql);
       
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
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

        <script src="js/scripts.js"></script>
        <link href="css/styles.css" rel="stylesheet">
        <link href="css/list.css" rel="stylesheet">

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
                <button type="button" class="btn-primary btn-lg btn-block" id="save-btn">Save</button><br />
                <button type="button" class="btn-primary btn-lg btn-block" id="clear-btn">Clear</button><br />
                <button type="button" class="btn-primary btn-lg btn-block" id="cancel-btn">Cancel</button><br />
            </div>

            <div id="profile-content" class="col-xs-12 col-sm-8 col-md-9 top40">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Survey Name</span>
                    <input id="survey-name" type="text" class="form-control" aria-describedby="basic-addon1">
                </div>
                <br/>
                <div class="form-group">
                    <label for="exampleTextarea">Description</label>
                    <textarea class="form-control" id="survey-desc" rows="3"></textarea>
                </div>
                <div style="box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22); background-color: honeydew">
                    <form name="xyz" action="/scripts/change-position.php">
                        <ul id="mySortable">

                        </ul>
                    </form>
                </div>
                <!--<div style="box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22); background-color: honeydew">
                <div class="question-text" style="margin: 20px;">
                    <label for="exampleTextarea">Question Text</label>
                    <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
                </div>
                <button type="button" class="btn-primary btn-md btn-right" style="float: right;" id="txt-option-btn">Add Option</button><br />
            </div>-->
            </div>
            <div class="content-element col-xs-12 col-sm-8 col-md-2 top40">               
                <button type="button" class="btn-primary btn-lg btn-block" id="text-btn">Text Box</button><br />
                <button type="button" class="btn-primary btn-lg btn-block" id="number-btn">Number Box</button><br />
                <button type="button" class="btn-primary btn-lg btn-block" id="radio-btn">Multiple Radio</button><br />
                <button type="button" class="btn-primary btn-lg btn-block" id="combo-btn">Multple CBox</button><br />
                <button type="button" class="btn-primary btn-lg btn-block" id="matrix-btn">Matrix</button><br />
            </div>
        </div>      
    </body>
</html>
