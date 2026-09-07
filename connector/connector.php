<?php

    require_once __DIR__ . '/../connector/connector.php';

    $conn = new mysqli($servername, $username, $password); // Connect without specifying a database
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
}
?>