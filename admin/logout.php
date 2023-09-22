<?php
session_start();
unset($_SESSION['admin_user_id']);
unset($admin_user_id);

header("Location: login");

?>