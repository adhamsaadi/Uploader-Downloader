<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    http_response_code(403);
    exit("Access denied. Please <a href='login.php'>login</a>.");
}

$directory = '/home/vol18_2/infinityfree.com/if0_38888521/htdocs/upload/uploads/';

if (is_dir($directory)) {
    $files = scandir($directory);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $filePath = $directory . $file;
            if (is_file($filePath)) {
                unlink($filePath);
            }
        }
    }
}

header("Location: index.php?message=deleted_all");
exit;
?>
