<!DOCTYPE html>
<html>
<head>
    <title>Downloader</title>
    <link rel="icon" href="icon.png" type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header {
            font-family: "Arial", sans-serif;
            font-size: 32px;
            margin-bottom: 20px;
        }

        .file-list {
            list-style: none;
            padding: 0;
        }

        .file-list li {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .file-list li a {
            color: #007bff;
            text-decoration: none;
        }

        .file-list li a:hover {
            text-decoration: underline;
        }

        .alert-info {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="header">File Downloader</h1>

        <?php
        // Specify the directory to scan
        $directory = '/home/vol19_1/hstn.me/mseet_35444429/htdocs/upload/uploads/';

        // Initialize an array to store the file names and sizes
        $fileList = [];

        // Check if the directory exists
        if (is_dir($directory)) {
            // Open the directory
            if ($handle = opendir($directory)) {
                // Read directory contents
                while (($file = readdir($handle)) !== false) {
                    // Exclude current and parent directory entries
                    if ($file != "." && $file != "..") {
                        // Add the file name and size to the file list array
                        $filePath = $directory . $file;
                        $fileSize = filesize($filePath);
                        $fileList[] = [
                            'name' => $file,
                            'size' => $fileSize
                        ];
                    }
                }
                // Close the directory
                closedir($handle);

                // Sort the file list alphabetically by name
                usort($fileList, function ($a, $b) {
                    return strtolower($a['name']) <=> strtolower($b['name']);
                });
            }
        }

        // Display the file list with download links
        if (!empty($fileList)) {
            echo "<ul class='file-list'>";
            foreach ($fileList as $file) {
                $fileName = $file['name'];
                $fileSize = formatFileSize($file['size']);
                $fileUrl = urlencode($fileName); // Encode the file name for the URL

                // Generate the download link
                echo "<li><a href='download.php?file=$fileUrl'>$fileName</a> ($fileSize)</li>";
            }
            echo "</ul>";
        } else {
            echo "<div class='alert alert-info'>No files found in the directory.</div>";
        }

        // Function to format file size in a human-readable format
        function formatFileSize($size)
        {
            $units = ['B', 'KB', 'MB', 'GB', 'TB'];
            $unitIndex = 0;
            while ($size >= 1024 && $unitIndex < count($units) - 1) {
                $size /= 1024;
                $unitIndex++;
            }
            return round($size, 2) . ' ' . $units[$unitIndex];
        }
        ?>
    </div>
</body>
</html>
