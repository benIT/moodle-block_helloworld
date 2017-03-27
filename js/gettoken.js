$(document).ready(function () {
    $("#loader").hide();
    $("form").submit(function (e) {
        $("#loader").show();
        e.preventDefault();
        $("#info").text("");
        var userName = $("#user").val();
        var password = $("#password").val();
        var service = $("#service").val();
        $("#token").val("");
        var request = $.ajax({
            url: "/login/token.php?service="+service+"&username=" + userName + "&password=" + password,
        });
        request.done(function (data) {
            if (data.token) {
                $("#token").val(data.token);
                $("#info").html('<p class="get-token-success">Token successfully received</p>');
            } else {
                $("#info").html('<p class="get-token-error">An error occured : "' + JSON.stringify(data) + '</p>');
            }
        });
        request.fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
        request.always(function (jqXHR) {
            console.log(jqXHR);
            $("#loader").hide();
        });
    });
});