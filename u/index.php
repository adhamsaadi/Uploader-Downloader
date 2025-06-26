<!DOCTYPE html>
<?php
session_start();
$isLoggedIn = isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;
?>
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
            font-size: 20px;
            margin-bottom: 10px;
        }

        .file-list li a {
            text-decoration: none;
        }

        .file-list li a:hover {
            text-decoration: underline;
        }

        .alert-info {
            margin-top: 20px;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
            padding: 0.3rem 0.6rem;
            border: none;
            border-radius: 0.25rem;
            font-size: 0.9rem;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .delete-all {
            margin-bottom: 20px;
        }

        .logout-group {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="header mb-0">File Downloader</h1>
            <?php if ($isLoggedIn): ?>
                <div class="logout-group">
                    <a href="delete_all.php" class="btn btn-danger" style="color: white;" onclick="return confirm('Are you sure you want to delete ALL files?');">Delete All</a>
                    <a href="logout.php" class="btn btn-secondary">Logout</a>
                </div>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary">Login</a>
            <?php endif; ?>
        </div>

        <?php if ($isLoggedIn && !empty($_GET['message']) && $_GET['message'] == 'deleted_all'): ?>
            <div class="alert alert-success">All files have been deleted successfully.</div>
        <?php endif; ?>

        <?php
        $directory = '/home/vol18_2/infinityfree.com/if0_38888521/htdocs/upload/uploads/';
        $fileList = [];

        if (is_dir($directory)) {
            if ($handle = opendir($directory)) {
                while (($file = readdir($handle)) !== false) {
                    if ($file != "." && $file != "..") {
                        $filePath = $directory . $file;
                        $fileSize = filesize($filePath);
                        $fileList[] = [
                            'name' => $file,
                            'size' => $fileSize
                        ];
                    }
                }
                closedir($handle);

                usort($fileList, function ($a, $b) {
                    return strtolower($a['name']) <=> strtolower($b['name']);
                });
            }
        }

        if (!empty($fileList)) {
            echo "<ul class='file-list'>";
            foreach ($fileList as $file) {
                $fileName = $file['name'];
                $fileSize = formatFileSize($file['size']);
                $fileUrl = urlencode($fileName);

                echo "<li><a href='download.php?file=$fileUrl'>" . htmlspecialchars($fileName) . "</a> ($fileSize)";
                if ($isLoggedIn) {
                    echo " <a href='delete.php?file=$fileUrl' class='btn btn-delete ml-2' onclick=\"return confirm('Are you sure you want to delete $fileName?');\">Delete</a>";
                }
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<div class='alert alert-info'>No files found in the directory.</div>";
        }

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
