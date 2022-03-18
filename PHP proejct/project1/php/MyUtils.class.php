<?php
class MyUtils{
	static function html_header($title="Untitled", $file=".", $style="", $script=""){
		$string = "
		<!DOCTYPE html>
			<html lang='us'>
			<head>
			    <meta charset='UTF-8'>
			    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
			    <link rel='stylesheet' href='$style' type='text/css'>
			    <link rel='stylesheet' href='$file/css/bootstrap.min.css' type='text/css'>
			    <script type='text/javascript' src='$file/js/jquery-2.1.1.min.js'></script>
			    <script type='text/javascript' src='$file/js/bootstrap.min.js'></script>
			    <script type='text/javascript' src='$script'></script>
			    <title>$title</title>
			</head>
			<body>";
		return $string;
	}

	static function html_nav($active1, $active2, $active3){
		$string ="<nav class='navbar navbar-default'>
		      <div class='container-fluid'>
		        <!-- Brand and toggle get grouped for better mobile display -->
		        <div class='navbar-header'>
		          <button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#bs-example-navbar-collapse-1' aria-expanded='false'>
		            <span class='sr-only'>Toggle navigation</span>
		            <span class='icon-bar'></span>
		            <span class='icon-bar'></span>
		            <span class='icon-bar'></span>
		          </button>
		          <a class='navbar-brand' href='#'>event management system</a>
		        </div>
		        <!-- Collect the nav links, forms, and other content for toggling -->
		        <div class='collapse navbar-collapse' id='bs-example-navbar-collapse-1'>
		          <ul class='nav navbar-nav'>
		          	<li class='$active1'><a href='./event.php'>Events</a></li>
		            <li class='$active2'><a href='./registration.php'>Registrations</a></li>
		            <li class='$active3'><a href='./admin.php'>Admin</a></li>
		            <li><a href='./logout.php'>Logout</a></li>
		          </ul>
		        </div><!-- /.navbar-collapse -->
		      </div><!-- /.container-fluid -->
		</nav>";
		return $string;
	}

	static function html_footer(){
		$string ="<p align='center' style='margin-bottom: 20px;color:#878B91;'>Copyright &copy;2020 </p></body></html>";
		return $string;
	}

	static function encrypt_sha256($str = ''){
		return hash("sha256", $str);
	}

	static function senitized($str=""){
		$text = trim($str);
    	$text = strip_tags($text);
    	$text = htmlentities($text,ENT_QUOTES,"UTF-8");
    	return $text;
	}

	static function login(){
		session_start();
		if(!isset($_SESSION['id']) || $_SESSION['id'] == ""){
			// didn't login
			echo "<h3 class=\"center\">You must login</h3><br>";
		    header("refresh:3;url=../index.php");
		    die();
		}
	}

	static function permission($p){

		if(!isset($_SESSION['role'])){
			echo "<h3 class=\"center\">You have to be a attendee</h3><br>";
		    header("refresh:3;url=./event.php");
		    die();	
		}
		$role = $_SESSION['role'];
		if($role>$p){
			echo "<h3 class=\"center\">You have no permission to visit</h3><br>";
		    header("refresh:3;url=./event.php");
		    die();
		}
	}

	static function error($text="", $url=""){
		echo "<h3 class=\"center\">$text</h3><br>";
		header("refresh:3;url=$url");
		die();
	}
}


?>