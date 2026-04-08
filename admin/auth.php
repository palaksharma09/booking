<?php
/**
 * Admin Authentication Middleware
 * Include this file at the top of all admin pages to protect them
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

// Check if user has admin role
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../dashboard.php");
    exit();
}

// Include database connection
require_once dirname(__DIR__) . '/db_conn.php';

?>
