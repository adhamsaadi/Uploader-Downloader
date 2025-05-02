<?php
session_start();
session_destroy();
header('Location: index.php'); // Redirect to main download page
exit;
