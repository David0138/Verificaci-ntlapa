<?php
/**
 * REST API for Searching and Verifying Licenses
 */

header('Content-Type: application/json');

// Database connection (replace with actual connection code)
$mysqli = new mysqli('localhost', 'username', 'password', 'database');

// Check connection
if ($mysqli->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $mysqli->connect_error]));
}

// Search Endpoint
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
    $query = $mysqli->real_escape_string($_GET['query']);
    $sql = "SELECT * FROM licenses WHERE license_number LIKE '%" . $query . "%'";
    $result = $mysqli->query($sql);

    $licenses = [];
    while ($row = $result->fetch_assoc()) {
        $licenses[] = $row;
    }

    echo json_encode($licenses);
    exit;
}

// Verify Endpoint
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['license_number'])) {
    $license_number = $mysqli->real_escape_string($_POST['license_number']);
    $sql = "SELECT * FROM licenses WHERE license_number = '$license_number'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $license = $result->fetch_assoc();
        echo json_encode(['valid' => true, 'license' => $license]);
    } else {
        echo json_encode(['valid' => false]);
    }
    exit;
}

echo json_encode(['error' => 'Invalid request method.']);
?>