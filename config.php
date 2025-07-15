
<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'mydb');

// Database connection function
function getConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        // Show error details for developer
        $error_details = "
        <div style='background: #ffebee; padding: 20px; border: 1px solid #f44336; border-radius: 5px; margin: 20px;'>
            <h3 style='color: #f44336;'>❌ Database Connection Failed</h3>
            <p><strong>Error:</strong> {$conn->connect_error}</p>
            <p><strong>Error Number:</strong> {$conn->connect_errno}</p>
            <hr>
            <h4>Check:</h4>
            <ul>
                <li>Is XAMPP/WAMP running?</li>
                <li>Is MySQL running?</li>
                <li>Is database name correct? (Currently: " . DB_NAME . ")</li>
                <li>Are username and password correct?</li>
            </ul>
        </div>";
        die($error_details);
    }
    
    // Set UTF-8 charset
    $conn->set_charset("utf8");
    
    return $conn;
}

// Function to sanitize input data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>