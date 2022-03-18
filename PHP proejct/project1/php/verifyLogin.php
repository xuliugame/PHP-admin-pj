<?php
    require("./MyUtils.class.php");
    require("./MMysql.class.php");
    
    error_reporting(0);
    session_start();
    $name = '';
    $password = '';
    if(!isset($_POST['name']) || trim($_POST['name']) == "" ){
        MyUtils::error("name can't be empty","../index.php");   
    }
    if(!isset($_POST['password']) || trim($_POST['password']) == ""){
        MyUtils::error("password can't be empty","../index.php");
    }
    $name = MyUtils::senitized($_POST['name']);
    $password = MyUtils::senitized($_POST['password']);
    $password = MyUtils::encrypt_sha256($password);

    $mysql = new MMysql();
    $res = $mysql->field(array('idattendee','name','password','role'))
        ->where(array('name'=>'\''.$name.'\'','password'=>'\''.$password.'\''))
        ->select('attendee');
    if($res){
        $_SESSION['id'] = $res[0]['idattendee'];
        $_SESSION['role'] = $res[0]['role'];
        //$_SESSION['uid'] = $res[0]['idattendee'];        
        echo "<h3 class=\"center\">Login Successfully, ".$name." welcome to!</h3><br>";
        header("refresh:3;url=./event.php");
    }else{
        echo "<h3 class=\"center\">Login failed, wrong name or password!</h3><br>";
        header("refresh:3;url=../index.php");
    }

?>