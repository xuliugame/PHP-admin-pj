<?php
    error_reporting(0);
    session_start();
    unset($_SESSION['id']);
    unset($_SESSION['role']);
    header("refresh:3;url=../index.php");
    echo "<h1>Log out successfully!</h1>";
?>