<?php

require_once __DIR__ . '/../connector/connector.php';
require_once __DIR__ . '/../helpers/trash.php';

$taskId = filter_input(INPUT_POST, 'TaskID', FILTER_VALIDATE_INT);
if ($taskId === false || $taskId === null) {
    console_log('Invalid task ID.');
    exit();
}

setTask($taskId);

$sql = 'DELETE FROM task WHERE id = ?';
$statement = $conn->prepare($sql);
$statement->bind_param('i', $taskId);

if ($statement->execute()) {
    header("Location: ../pages/homePage.php");
    exit();
} else {
    console_log('Error deleting task: ' . $statement->error);
    exit();
}

$statement->close();
$conn->close();
?>