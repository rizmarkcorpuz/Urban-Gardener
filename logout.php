<?php
session_start();
unset($_SESSION['user_id']);
unset($_SESSION['username']);
unset($_SESSION['LOGGED_IN']);
unset($user_id);
unset($username);
//session_start();
//session_destroy();


header("Location: login");
die;
?>