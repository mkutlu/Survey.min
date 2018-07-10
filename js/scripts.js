$(function () {
    var question = 0;
    var option = 0;
    $('[data-toggle="popover"]').popover();
    function register(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        alert('girdi');
        console.log("register func run");
        var username = document.getElementById('display_name').value;
        var firstname = document.getElementById('first_name').value;
        var lastname = document.getElementById('last_name').value;
        var password = document.getElementById('password').value;

        if (username == null || firstname == "" || lastname == null || password == "")
        {
            alert("Please Fill All Required Field");
            return false;
        } else {
            $.ajax({
                url: "insert_data.php",
                type: 'POST',
                data: {username: username, firstname: firstname, lastname: lastname, password: password},
                complete: function (response) {
                    window.location.replace("/login.php");
                    alert('succees');
                }
            });
        }
    }
    $('#aform').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'home.php',
            data: $(this).serialize(),
            success: function () {
                $link = $('#link').val();
                $linktext = $('#linktext').val();
                $current_content = $('#profile-content').html();
                $('#profile-content').empty();
                $('#profile-content').append("<div class='content-element col-xs-12 col-sm-12 col-md-12'><button type='button' class='close' onclick='deleteItem();'>&times;</button><a href='" + $link + "'>" + $linktext + "</a><br />");
                $('#profile-content').append($current_content);
            }
        });
        $.get("home.php");
        return false;
    });
    $('#save-btn').on('click', function (e) {
        if (confirm("Are you sure you want to save survey?")) {
            saveSurvey();
        } else {
            //Do nothing  
        }
    });
    $('#cancel-btn').on('click', function (e) {
        if (confirm("Are you sure you want to and redirect to homepage?")) {
            window.location.href = 'home.php';
        } else {
            //Do nothing  
        }
    });
    $('#clear-btn').on('click', function (e) {
        if (confirm("Are you sure you want to clear the entire survey context?")) {
            clearSurvey();
        } else {
            //Do nothing  
        }
    });
    $('#text-btn').on('click', function (e) {
        question = question + 1;
        option = 0;
        idstring="question"+question+"";
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'createSurvey.php',
            data: $(this).serialize(),
            success: function () {
                $current_content = $('#question-area').html();
                $('#question-area').empty();
                $('#question-area').append('<div class="question-text" style="margin: 20px;"><label for="exampleTextarea">'+question+') Question Text</label><textarea class="form-control" id="'+idstring+'" rows="3"></textarea></div>');
                $('#question-area').append($current_content);
            }
        });

    });
    $('#number-btn').on('click', function (e) {
        question = question + 1;
        option = 0;
    });
    $('#radio-btn').on('click', function (e) {
        question = question + 1;
        option = 0;
    });
    $('#combo-btn').on('click', function (e) {
        question = question + 1;
        option = 0;
    });
    $('#matrix-btn').on('click', function (e) {
        question = question + 1;
        option = 0;
    });

    function clearSurvey() {

    }
    function saveSurvey() {

    }
});