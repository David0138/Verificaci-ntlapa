<?php

// API Endpoints for Admin Operations

header('Content-Type: application/json');

// Sample database connection (replace with your actual DB connection)
$db = new mysqli('localhost', 'user', 'password', 'database');

if ($db->connect_errno) {
    die(json_encode(['error' => 'Failed to connect to MySQL: ' . $db->connect_error]));
}

// Function to add a license
function addLicense($db, $data) {
    $licenseKey = $data['licenseKey'];
    $userId = $data['userId'];
    $expiryDate = $data['expiryDate'];

    $stmt = $db->prepare('INSERT INTO licenses (license_key, user_id, expiry_date) VALUES (?, ?, ?)');
    $stmt->bind_param('sis', $licenseKey, $userId, $expiryDate);
    return $stmt->execute();
}

// Function to edit a license
function editLicense($db, $data) {
    $id = $data['id'];
    $licenseKey = $data['licenseKey'];
    $expiryDate = $data['expiryDate'];

    $stmt = $db->prepare('UPDATE licenses SET license_key = ?, expiry_date = ? WHERE id = ?');
    $stmt->bind_param('ssi', $licenseKey, $expiryDate, $id);
    return $stmt->execute();
}

// Function to delete a license
function deleteLicense($db, $id) {
    $stmt = $db->prepare('DELETE FROM licenses WHERE id = ?');
    $stmt->bind_param('i', $id);
    return $stmt->execute();
}

// Handle the request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    switch ($data['action']) {
        case 'add':
            $result = addLicense($db, $data);
            echo json_encode(['success' => $result]);
            break;
        case 'edit':
            $result = editLicense($db, $data);
            echo json_encode(['success' => $result]);
            break;
        case 'delete':
            $result = deleteLicense($db, $data['id']);
            echo json_encode(['success' => $result]);
            break;
        default:
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}