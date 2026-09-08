<?php

require_once __DIR__ . '/../connector/connector.php';

$taskId = filter_input(INPUT_POST, 'TaskID', FILTER_VALIDATE_INT);
if ($taskId === false || $taskId === null) {
    exit('Invalid task ID.');
}

$sql = 'DELETE FROM task WHERE id = ?';
$statement = $conn->prepare($sql);
$statement->bind_param('i', $taskId);

if ($statement->execute()) {
    header("Location: ../pages/homePage.php");
    exit();
} else {
    exit('Error deleting task: ' . $statement->error);
}

$statement->close();
$conn->close();
?>