<?php

    require_once __DIR__ . '/../connector/connector.php';

    $sql_file_path = __DIR__ . '/db_builder.sql';

    if (!file_exists($sql_file_path)) {
        die("Error: The file '{$sql_file_path}' was not found.");
    }

    $sql_contents = file_get_contents($sql_file_path);

    if ($sql_contents === false) {
        die("Error: Could not read the SQL file.");
    }

    if ($conn->multi_query($sql_contents)) {
        do {
            if ($result = $conn->store_result()) {
                $result->free();
            }

            if ($conn->error) {
                echo "Error executing statement: " . $conn->error . "\n";
                break;
            }
        } while ($conn->more_results() && $conn->next_result());

        if (!$conn->error) {
            echo "SQL file executed and imported successfully!";
        }
    } else {
        echo "Error executing SQL file: " . $conn->error;
    }

?>