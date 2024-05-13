<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $files = $_FILES['files'];

    // Check if files were uploaded successfully
    if (!empty($files['name'][0])) {
        $uploadDir = '/home/vol19_1/hstn.me/mseet_35444429/htdocs//upload/uploads/';

        // Iterate over uploaded files
        for ($i = 0; $i < count($files['name']); $i++) {
            $fileName = $files['name'][$i];
            $filePath = $uploadDir . $fileName;
            $fileType = $files['type'][$i];

            // Check if the file type is allowed (excluding HTML and PHP)
            if ($fileType !== 'text/html' && $fileType !== 'application/x-php') {
                // Move uploaded file to destination directory
                if (move_uploaded_file($files['tmp_name'][$i], $filePath)) {
                    $response[] = [
                        'file' => $fileName,
                        'status' => 'success'
                    ];
                } else {
                    $response[] = [
                        'file' => $fileName,
                        'status' => 'error',
                        'message' => 'Error uploading file.'
                    ];
                }
            } else {
                $response[] = [
                    'file' => $fileName,
                    'status' => 'error',
                    'message' => 'HTML and PHP files are not allowed.'
                ];
            }
        }

        echo json_encode($response);
    } else {
        echo json_encode(['message' => 'No files uploaded.']);
    }
}
?>
