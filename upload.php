<?php
session_start();
require_once 'config.php';
require_once 'database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    die(json_encode(array('success' => false, 'error' => 'Invalid request method')));
}

if (!isset($_POST['userId']) || !isset($_FILES['profilePicture'])) {
    http_response_code(400);
    die(json_encode(array('success' => false, 'error' => 'Missing required fields')));
}

$userId = $_POST['userId'];
$uploadType = isset($_POST['type']) ? $_POST['type'] : 'profile'; // profile or cover

// Verify user exists
$user = $db->getUserById($userId);
if (!$user) {
    http_response_code(404);
    die(json_encode(array('success' => false, 'error' => 'User not found')));
}

$file = $_FILES['profilePicture'];

// Validate file
if ($file['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    die(json_encode(array('success' => false, 'error' => 'File upload error')));
}

if ($file['size'] > MAX_FILE_SIZE) {
    http_response_code(400);
    die(json_encode(array('success' => false, 'error' => 'File too large. Max 5MB')));
}

if (!in_array($file['type'], ALLOWED_TYPES)) {
    http_response_code(400);
    die(json_encode(array('success' => false, 'error' => 'Invalid file type. Only images allowed')));
}

// Generate unique filename
$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$newFilename = $userId . '_' . $uploadType . '_' . time() . '.' . $ext;
$uploadPath = UPLOAD_DIR . $newFilename;

// Move uploaded file
if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
    // Update database
    if ($uploadType === 'cover') {
        $db->updateCoverPhoto($userId, $newFilename);
    } else {
        $db->updateProfilePicture($userId, $newFilename);
    }
    
    echo json_encode(array(
        'success' => true,
        'message' => ucfirst($uploadType) . ' picture uploaded successfully',
        'file' => $uploadPath,
        'download' => 'download.php?file=' . urlencode($uploadPath)
    ));
} else {
    http_response_code(500);
    echo json_encode(array('success' => false, 'error' => 'Failed to save file'));
}
?>
