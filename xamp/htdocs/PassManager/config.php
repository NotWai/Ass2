<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$db = "PassManager";
$salt = "ayam"; // added to every password instance before encryption

// Set secure session cookie parameters before starting the session
$cookieParams = session_get_cookie_params();
session_set_cookie_params([
    'lifetime' => $cookieParams['lifetime'],
    'path' => $cookieParams['path'],
    'domain' => $cookieParams['domain'],
    'secure' => true, // Ensure the cookie is sent only over HTTPS
    'httponly' => true, // Prevent JavaScript access to the session cookie
    'samesite' => 'Strict' // Prevent the cookie from being sent in cross-site requests
]);

// Start the session
session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set session timeout
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    session_unset(); // Unset $_SESSION
    session_destroy(); // Destroy session data
}
$_SESSION['LAST_ACTIVITY'] = time(); // Update last activity time

// Regenerate session ID periodically to prevent session fixation
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] > 1800) {
    session_regenerate_id(true); // Regenerate session ID every 30 minutes
    $_SESSION['CREATED'] = time();
}

echo "Connected successfully";

// Example of setting a session variable
$_SESSION['user_id'] = 1; // Example user ID
?>
