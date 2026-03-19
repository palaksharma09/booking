<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Include database connection
include 'db_conn.php';

// Get user ID from session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Initialize variables
$error_message = '';

// Begin transaction to ensure all related data is deleted
$conn->begin_transaction();

try {
    // 1. Delete user's bookings (if you have a bookings table)
    // Uncomment if you have a bookings table
    // $delete_bookings = $conn->prepare("DELETE FROM bookings WHERE user_id = ?");
    // $delete_bookings->bind_param("i", $user_id);
    // $delete_bookings->execute();
    // $delete_bookings->close();
    
    // 2. Delete user's reviews/comments (if you have a reviews table)
    // Uncomment if you have a reviews table
    // $delete_reviews = $conn->prepare("DELETE FROM reviews WHERE user_id = ?");
    // $delete_reviews->bind_param("i", $user_id);
    // $delete_reviews->execute();
    // $delete_reviews->close();
    
    // 3. Finally, delete the user
    $delete_user = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $delete_user->bind_param("i", $user_id);
    $delete_user->execute();
    
    if ($delete_user->affected_rows > 0) {
        // Commit transaction
        $conn->commit();
        
        // Clear all session data
        $_SESSION = array();
        
        // Destroy session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Destroy session
        session_destroy();
        
        // Clear remember me cookie if set
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }
        
        // Redirect to goodbye page or login with message
        header("Location: login.php?account_deleted=success");
        exit();
    } else {
        throw new Exception("Could not delete user account.");
    }
    
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    $error_message = "Error deleting account: " . $e->getMessage();
}

$conn->close();

// If there was an error, redirect back with error message
if ($error_message) {
    header("Location: my-profile.php?delete_error=1");
    exit();
}
?>