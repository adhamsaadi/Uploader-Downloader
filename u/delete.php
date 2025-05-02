<?php
// Basic protection
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    http_response_code(403);
    exit("Access denied. Please <a href='login.php'>login</a>.");
}

// Proceed with deletion logic
if (isset($_GET['file'])) {
    $file = basename($_GET['file']); // Prevent path traversal
    $directory = '/home/vol18_2/infinityfree.com/if0_38888521/htdocs/upload/uploads/';
    $filePath = $directory . $file;

    // Ensure the file is inside the uploads directory
    if (file_exists($filePath) && is_file($filePath) && strpos(realpath($filePath), realpath($directory)) === 0) {
        if (unlink($filePath)) {
            // Redirect back with a success message
            header("Location: index.php?message=deleted");
            exit;
        } else {
            echo "Failed to delete file.";
        }
    } else {
        http_response_code(404);
        echo "File not found or access denied.";
    }
} else {
    http_response_code(400);
    echo "No file specified.";
}
?>
