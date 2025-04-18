<?php
session_start();

// Destroy session
$_SESSION = [];
session_unset();
session_destroy();

// Redirect to login page
header("Location: admin_login.php");
exit();
