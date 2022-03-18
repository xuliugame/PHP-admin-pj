<?php
	require("./php/MyUtils.class.php");
	echo MyUtils::html_header("Login",".","./css/mystyle","./js/login.js");
?>
	<div class="main" style="min-height: 600px;">
		<div class="container-fluid" style="height: 400px; width: 500px;">
	        <h2 class="text-center">Login Page</h2>
	        <form action="./php/verifyLogin.php" id="loginForm" method="POST" class="form-horizontal" style="margin-top: 40px;">
	            <input type="hidden" name="url" id="url">
	            <div class="form-group">
	                <label for="uid" class="col-sm-3 control-label"><i class="glyphicon glyphicon-user" aria-hidden="true"></i>Username</label>
	                <div class="col-sm-9">
	                    <input type="text" class="form-control" name="name" id="uid" placeholder="name"><span id="warn-username" style="color:red;display:none;" ">name can't be empty</span>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="psd" class="col-sm-3 control-label"><i class="glyphicon glyphicon-lock"></i>Password</label>
	                <div class="col-sm-9">
	                    <input type="password" class="form-control" name="password" id="psd" placeholder="Password"><span id="warn-password" style="color:red;display:none;">password can't be empty</span>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-4 col-sm-2">
	                    <button type="button" id="sub" class="btn btn-success" style="height: 30px;">Login</button>
	                </div>
	            </div>
	        </form>
	    </div>
	</div>

 <?php 
	echo MyUtils::html_footer();
  ?>