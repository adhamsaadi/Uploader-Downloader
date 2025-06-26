<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    http_response_code(403);
    exit("Access denied. Please <a href='login.php'>login</a>.");
}

if (isset($_GET['file'])) {
    $file = basename($_GET['file']); // Prevent directory traversal
    $directory = '/home/vol18_2/infinityfree.com/if0_38888521/htdocs/upload/uploads/';
    $filePath = $directory . $file;

    // Ensure the file exists and is a file
    if (file_exists($filePath) && is_file($filePath)) {
        if (unlink($filePath)) {
            header("Location: index.php?message=deleted&file=" . urlencode($file));
            exit;
        } else {
            echo "Failed to delete file.";
        }
    } else {
        http_response_code(404);
        echo "File not found.";
    }
} else {
    http_response_code(400);
    echo "No file specified.";
}
?>
