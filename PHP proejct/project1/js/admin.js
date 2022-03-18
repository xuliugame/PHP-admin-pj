$(function() {
    $("#addUser").click(function() {
        var uid = $("#name").val();
        var psd = $("#psd").val();
        var email = $("#email").val();
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
        $("#addUserForm").submit();
    })

    $(".editUser").click(function(){
        $id = $(this).data("id");
        $username = $(".username"+$id).html();
        $email = $(".email"+$id).html();
        $("#edituid").val($id);
        $("#editname").val($username);
        $("#editUserModal").modal("show");
    })

    $("#editUserSubmit").click(function() {
        var uid = $("#editname").val();
        var psd = $("#editpsd").val();
        var email = $("#editemail").val();
        if (uid == null || uid == undefined || uid == "") {
            $("#edit-username").css("display", "block");
            return;
        } else {
            $("#edit-username").css("display", "none");
        }
        if (psd == null || psd == undefined || psd == "") {
            $("#edit-password").css("display", "block");
            return;
        } else {
            $("#edit-password").css("display", "none");
        }
        $("#editUserForm").submit();
    })

    $(".deletUser").click(function(){
        $id = $(this).data("id");
        var flag = 0;
        $.ajax({
            type: "post",
            url: "./ajax.php",
            async:false, 
            data: {"m": "deleteuser","uid":$id},
            success: function(data) {
                if(data == 1){
                    flag = 1;
                    alert("delete user successfully");
                }else{
                    alert("delete user failed");
                }
            }
        });
        if(flag == 1){
            $(this).parent().parent().remove();    
        }
    })

    $("#addVenue").click(function() {
        var name = $("#add_venue_name").val();
        var capacity = $("#add_venue_capacity").val();
        if (name == null || name == undefined || name == "") {
            $("#warn-venuename").css("display", "block");
            return;
        } else {
            $("#warn-venuename").css("display", "none");
        }
        if (capacity == null || capacity == undefined || capacity == "") {
            $("#warn-capacity").css("display", "block");
            return;
        } else {
            $("#warn-capacity").css("display", "none");
        }
        $("#addVenueForm").submit();
    })

    $(".editVenue").click(function(){
        $id = $(this).data("id");
        $venue = $(".venue"+$id).html();
        $capacity = $(".capacity"+$id).html();
        $("#idvenue").val($id);
        $("#edit_venue_name").val($venue);
        $("#edit_venue_capacity").val($capacity);
        $("#editVenueModal").modal("show");
    })

    $("#editVenueSubmit").click(function() {
        var name = $("#edit_venue_name").val();
        var capacity = $("#edit_venue_capacity").val();
        if (name == null || name == undefined || name == "") {
            $("#edit-venuename").css("display", "block");
            return;
        } else {
            $("#edit-venuename").css("display", "none");
        }
        if (capacity == null || capacity == undefined || capacity == "") {
            $("#edit-capacity").css("display", "block");
            return;
        } else {
            $("#edit-capacity").css("display", "none");
        }
        $("#editVenueForm").submit();
    })

    $(".deletVenue").click(function(){
        $id = $(this).data("id");
        var flag = 0;
        $.ajax({
            type: "post",
            url: "./ajax.php",
            async:false, 
            data: {"m": "deletevenue","idvenue":$id},
            success: function(data) {
                if(data == 1){
                    flag = 1;
                    alert("delete venue successfully");
                }else{
                    alert("delete venue failed");
                }
            }
        });
        if(flag == 1){
            $(this).parent().parent().remove();    
        }
    })

    $("#addEvent").click(function() {
        $("#addEventForm").submit();
    })

    $(".editEvent").click(function(){
        $id = $(this).data("id");
        $eventname = $(".eventname"+$id).html();
        $datestart = $(".datestart"+$id).html();
        $dateend = $(".dateend"+$id).html();
        $numberallowed = $(".numberallowed"+$id).html();
        $venue = $(".eventvenue"+$id).html();
        $("#idevent").val($id);
        $("#edit_event_name").val($venue);
        $("#edit_event_datestart").val($datestart);
        $("#edit_event_dateend").val($dateend);
        $("#edit_event_numberallowed").val($numberallowed);
        $("#edit_event_venue").val($venue);
        $("#editEventModal").modal("show");
    })

    $("#editEventSubmit").click(function() {
        $("#editEventForm").submit();
    })

    $(".deletEvent").click(function(){
        $id = $(this).data("id");
        var flag = 0;
        $.ajax({
            type: "post",
            url: "./ajax.php",
            async:false, 
            data: {"m": "deleteevent","idevent":$id},
            success: function(data) {
                if(data == 1){
                    flag = 1;
                    alert("delete Event successfully");
                }else{
                    alert("delete Event failed");
                }
            }
        });
        if(flag == 1){
            $(this).parent().parent().remove();    
        }
    })

    $("#addSession").click(function() {
        $("#addSessionForm").submit();
    })

    $(".editSession").click(function(){
        $id = $(this).data("id");
        $sessionname = $(".sessionname"+$id).html();
        $sstartdate = $(".sstartdate"+$id).html();
        $senddate = $(".senddate"+$id).html();
        $snumberallowed = $(".snumberallowed"+$id).html();
        $("#idsession").val($id);
        $("#edit_session_name").val($sessionname);
        $("#edit_session_startdate").val($sstartdate);
        $("#edit_session_enddate").val($senddate);
        $("#edit_session_numberallowed").val($snumberallowed);
        $("#editSessionModal").modal("show");
    })

    $("#editSessionSubmit").click(function() {
        $("#editSessionForm").submit();
    })

    $(".deletSession").click(function(){
        $id = $(this).data("id");
        var flag = 0;
        $.ajax({
            type: "post",
            url: "./ajax.php",
            async:false, 
            data: {"m": "deletesession","idsession":$id},
            success: function(data) {
                if(data == 1){
                    flag = 1;
                    alert("delete Session successfully");
                }else{
                    alert("delete Session failed");
                }
            }
        });
        if(flag == 1){
            $(this).parent().parent().remove();    
        }
    })

    $("#addAttendee").click(function() {
        $("#addAttendeeForm").submit();
    })

    $(".deletAtt").click(function(){
        $id = $(this).data("id");
        $arr=$id.split("-");
        console.log($arr[0]);
        console.log($arr[1]);
        console.log($arr[2]);
        if($arr[2] == 'attendee'){
            var flag = 0;
            $.ajax({
                type: "post",
                url: "./ajax.php",
                async:false, 
                data: {"m": "deleteattendee","session":$arr[1],"attendee":$arr[0]},
                success: function(data) {
                    console.log(data);
                    if(data == 1){
                        flag = 1;
                        alert("delete attdendee successfully");
                    }else{
                        alert("delete attdendee failed");
                    }
                }
            });
            if(flag == 1){
                $(this).parent().parent().remove();    
            }
        }else{
            var flag = 0;
            $.ajax({
                type: "post",
                url: "./ajax.php",
                async:false, 
                data: {"m": "deletemanager","event":$arr[1], "manager":$arr[0]},
                success: function(data) {
                    console.log(data);
                    if(data == 1){
                        flag = 1;
                        alert("delete manager successfully");
                    }else{
                        alert("delete manager failed");
                    }
                }
            });
            if(flag == 1){
                $(this).parent().parent().remove();    
            } 
        }
        
    })

    $("#addManagerSubmit").click(function() {
        $("#addManagerForm").submit();
    })

});