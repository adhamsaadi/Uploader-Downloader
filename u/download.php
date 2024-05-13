<?php
// Check if the file parameter is set in the query string
if (isset($_GET['file'])) {
    // Retrieve the file name from the query string
    $file = $_GET['file'];

    // Specify the directory path where the files are stored
    $directory = '/home/vol19_1/hstn.me/mseet_35444429/htdocs/upload/uploads/';

    // Specify the path to the file
    $filePath = $directory . $file;

    // Check if the file exists
    if (file_exists($filePath)) {
        // Set appropriate headers for the file download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filePath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        
        // Read the file and output it to the user
        readfile($filePath);
        exit;
    } else {
        // Display an error message if the file doesn't exist
        echo "File not found.";
    }
}
?>