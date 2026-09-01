<?php
require_once 'config.php';

if (!isset($_GET['file'])) {
    http_response_code(400);
    die('File not specified');
}

$file = $_GET['file'];

// Security check - prevent directory traversal
if (strpos($file, '..') !== false || strpos($file, '/') !== false && strpos($file, UPLOAD_DIR) === false) {
    http_response_code(403);
    die('Invalid file path');
}

// Check if file exists
if (!file_exists($file)) {
    http_response_code(404);
    die('File not found');
}

// Get file info
$filename = basename($file);
$filesize = filesize($file);
$filetype = mime_content_type($file);

// Set headers for download
header('Content-Type: ' . $filetype);
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . $filesize);
header('Pragma: no-cache');
header('Expires: 0');

// Read and output file
readfile($file);
exit();
?>
