<?php
session_start();
require_once '../middleware/auth.php';

// Logout user
logoutUser();

// Redirect ke login
header('Location: login.php');
exit();