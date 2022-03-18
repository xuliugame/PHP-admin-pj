$(function() {
	$(".apply").click(function(){
		$id=$(this).data("id");
		//$(this).attr("disabled","disabled");
        var flag = 0;
        $.ajax({
            type: "post",
            url: "./registration_handle.php",
            async: false, 
            data: {"m": "apply","session":$id},
            success: function(data) {
                if(data == 1){
                    flag = 1;
                    alert("apply session successfully");
                }else{
                	flag = 0;
                    alert("apply session failed");
                }
            }
        });
        if(flag == 1){
            $(this).attr("disabled","disabled");   
        }
	});

	$(".editRe").click(function(){
        $id = $(this).data("id");
        $("#idregistration").val($id);
        $("#editApplyModal").modal("show");
    })

    $("#editApplySubmit").click(function() {
        $("#editApplyForm").submit();
    })

	$(".deletRe").click(function(){
		$id=$(this).data("id");
        var flag = 0;
        $.ajax({
            type: "post",
            url: "./registration_handle.php",
            async: false, 
            data: {"m": "deleteapply","idregistration":$id},
            success: function(data) {
                if(data == 1){
                    flag = 1;
                    alert("delete apply successfully");
                }else{
                	flag = 0;
                    alert("delete apply failed");
                }
            }
        });
        if(flag == 1){
            $(this).parent().parent().remove();   
        }
	});

	$(".accRe").click(function(){
		$id=$(this).data("id");
        var flag = 0;
        $.ajax({
            type: "post",
            url: "./registration_handle.php",
            async: false, 
            data: {"m": "accapply","idregistration":$id},
            success: function(data) {
                if(data == 1){
                    flag = 1;
                    alert("accept apply successfully");
                }else{
                	flag = 0;
                    alert("accept apply failed");
                }
            }
        });
	});
})