<?php

    require_once __DIR__ . '/../config/config.php';

    $conn = new mysqli($servername, $username, $password); // Connect without specifying a database
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
}
?>