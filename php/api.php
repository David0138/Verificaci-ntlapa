<?php

// REST API for License Retrieval

// Database connection settings
$host = 'your_host';
$username = 'your_username';
$password = 'your_password';
$database = 'your_database';

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle search and retrieval functions
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['license_id'])) {
        // Retrieve license by ID
        $license_id = $_GET['license_id'];
        $sql = "SELECT * FROM licenses WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $license_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $license = $result->fetch_assoc();
            echo json_encode($license);
        } else {
            echo json_encode(['error' => 'License not found']);
        }
        $stmt->close();
    } else if (isset($_GET['search'])) {
        // Search licenses
        $search_query = $_GET['search'];
        $sql = "SELECT * FROM licenses WHERE name LIKE ?";
        $stmt = $conn->prepare($sql);
        $search_param = "%" . $search_query . "%";
        $stmt->bind_param('s', $search_param);
        $stmt->execute();
        $result = $stmt->get_result();

        $licenses = [];
        while ($row = $result->fetch_assoc()) {
            $licenses[] = $row;
        }
        echo json_encode($licenses);
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Invalid request']);
    }
} else {
    echo json_encode(['error' => 'Only GET method is allowed']);
}

$conn->close();
?>