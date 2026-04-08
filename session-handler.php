<?php
/**
 * Session Configuration & Security Handler
 * Include this at the very beginning of your application
 * Ensures secure session handling across the entire platform
 */

// Set secure session configuration BEFORE session_start()
if (session_status() === PHP_SESSION_NONE) {
    // Session cookie settings
    ini_set('session.use_strict_mode', 1);              // Reject invalid session IDs
    ini_set('session.use_only_cookies', 1);            // Only use cookies, not URL params
    ini_set('session.cookie_httponly', 1);             // HttpOnly (no JavaScript access)
    ini_set('session.cookie_secure', 0);               // Set to 1 if using HTTPS
    ini_set('session.cookie_samesite', 'Strict');      // CSRF protection
    ini_set('session.cookie_lifetime', 0);             // Cookie expires when browser closes
    ini_set('session.gc_maxlifetime', 3600);           // Server-side: 1 hour
    
    session_start();
}

/**
 * Validate and restore session from database
 * Checks that the user still exists and has the same role
 * Prevents stale/hijacked sessions
 */
function validateSession() {
    // Allow unauthenticated pages to not validate
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
        return false;
    }

    // If session is too old (1 hour), force re-login
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > 3600) {
        destroyAllSessions();
        return false;
    }

    // Update last activity timestamp
    $_SESSION['last_activity'] = time();

    // Validate session fingerprint (basic security)
    if (!isset($_SESSION['ip_address'])) {
        $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
    } elseif ($_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR']) {
        // IP changed - potential session hijacking
        error_log("Session hijacking attempt detected for user " . $_SESSION['user_id']);
        destroyAllSessions();
        return false;
    }

    // Verify user still exists in database with same role
    try {
        include 'db_conn.php';
        
        $userId = (int)$_SESSION['user_id'];
        $sql = "SELECT user_id, role FROM users WHERE user_id = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            return false;
        }
        
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if (!$user) {
            // User no longer exists
            destroyAllSessions();
            return false;
        }

        if ($user['role'] !== $_SESSION['user_role']) {
            // User role changed - force re-login
            error_log("User role changed for user " . $_SESSION['user_id']);
            destroyAllSessions();
            return false;
        }

        return true;

    } catch (Exception $e) {
        error_log("Session validation error: " . $e->getMessage());
        return false;
    }
}

/**
 * Destroy ALL session data completely
 * Used for logout and security violations
 */
function destroyAllSessions() {
    // Clear all session variables
    $_SESSION = array();

    // Destroy session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Clear remember token if exists
    if (isset($_COOKIE['remember_token'])) {
        setcookie('remember_token', '', time() - 3600, '/');
    }

    // Destroy the actual session
    session_destroy();
}

/**
 * Check if user is authenticated
 */
function isAuthenticated() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && validateSession();
}

/**
 * Check if user is admin
 * Must call isAuthenticated() first
 */
function isAdmin() {
    return isAuthenticated() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

/**
 * Check if user is regular user (not admin)
 * Must call isAuthenticated() first
 */
function isRegularUser() {
    return isAuthenticated() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'user';
}

/**
 * Get current user ID safely
 */
function getCurrentUserId() {
    return isAuthenticated() ? (int)$_SESSION['user_id'] : null;
}

/**
 * Get current user role safely
 */
function getCurrentUserRole() {
    return isAuthenticated() ? $_SESSION['user_role'] : null;
}

?>
