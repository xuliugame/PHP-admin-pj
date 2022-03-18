$(function() {
    $("#sub").click(function() {
        var uid = $("#uid").val();
        var psd = $("#psd").val();
        if (uid == null || uid == undefined || uid == "") {
            $("#warn-username").css("display", "block");
            return;
        } else {
            $("#warn-username").css("display", "none");
        }
        if (psd == null || psd == undefined || psd == "") {
            $("#warn-password").css("display", "block");
            return;
        } else {
            $("#warn-password").css("display", "none");
        }
        $("#loginForm").submit();
    })
});