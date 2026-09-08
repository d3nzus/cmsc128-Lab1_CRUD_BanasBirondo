<?php

require_once __DIR__ . '/../connector/connector.php';

$taskId = filter_input(INPUT_POST, 'TaskID', FILTER_VALIDATE_INT);
if ($taskId === false || $taskId === null) {
    console_log('Invalid task ID.');
    exit();
}

$sql = 'UPDATE task SET done = NOT done WHERE id = ?';
$statement = $conn->prepare($sql);
$statement->bind_param('i', $taskId);

if (!$statement->execute()) {
    console_log('Error toggling task status: ' . $statement->error);
    exit();
}

$statement->close();
$conn->close();
header('Location: ../pages/homePage.php');
exit();
