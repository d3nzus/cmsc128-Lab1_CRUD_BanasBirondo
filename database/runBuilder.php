<?php

    require_once __DIR__ . '/../connector/connector.php';

    $sql_file_path = 'db_builder.sql';

    if (!file_exists($sql_file_path)) {
        die("Error: The file '{$sql_file_path}' was not found.");
    }

    $sql_contents = file_get_contents($sql_file_path);

    if ($conn->multi_query($sql_contents)) {
        echo "SQL file executed and imported successfully!";
    } else {
        echo "Error executing SQL file: " . $conn->error;
    }

    $conn->close();
    
?>