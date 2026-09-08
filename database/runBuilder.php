<?php

    require_once __DIR__ . '/../connector/connector.php';

    require_once __DIR__ . '/../debug/debug.php';

    $sql_file_path = __DIR__ . '/db_builder.sql';

    if (!file_exists($sql_file_path)) {
        console_log("Error: The file '{$sql_file_path}' was not found.");
        exit;
    }

    $sql_contents = file_get_contents($sql_file_path);

    if ($sql_contents === false) {
        console_log('Error: Could not read the SQL file.');
        exit;
    }

    if ($conn->multi_query($sql_contents)) {
        do {
            if ($result = $conn->store_result()) {
                $result->free();
            }

            if ($conn->error) {
                console_log('Error executing statement: ' . $conn->error);
                break;
            }
        } while ($conn->more_results() && $conn->next_result());

        if (!$conn->error) {
            console_log('SQL file executed and imported successfully!');
        }
    } else {
        console_log('Error executing SQL file: ' . $conn->error);
    }

?>