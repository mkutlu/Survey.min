
$(function () {
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

});