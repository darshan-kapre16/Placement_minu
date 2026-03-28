<?php
/**
 * Database Configuration
 * placement_m/config/database.php
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'placement_db');

// Base URL — change if your folder name differs
define('BASE_URL', 'http://localhost/placement_m/public/');
define('UPLOAD_PATH', dirname(__DIR__) . '/uploads/resumes/');
define('UPLOAD_URL', 'http://localhost/placement_m/uploads/resumes/');

/**
 * Get MySQLi database connection (singleton)
 */
function getDB(): mysqli {
    static $conn = null;
    if ($conn === null) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            die('<div style="font-family:sans-serif;padding:40px;color:#c0392b;">
                <h2>Database Connection Failed</h2>
                <p>' . htmlspecialchars($conn->connect_error) . '</p>
                <p>Please ensure WAMP/XAMPP is running and the database is imported.</p>
            </div>');
        }
        $conn->set_charset('utf8mb4');
    }
    return $conn;
}
