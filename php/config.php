<?php
// Database configuration for Railway
$host = getenv('DB_HOST') ?: 'localhost';
$db_name = getenv('DB_NAME') ?: 'railway';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$port = getenv('DB_PORT') ?: 3306;
try {
    $conn = new mysqli($host, $username, $password, $db_name, $port);
    if ($conn->connect_error) {
        die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
    }
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die(json_encode(['error' => 'Database error: ' . $e->getMessage()]));
}
?>