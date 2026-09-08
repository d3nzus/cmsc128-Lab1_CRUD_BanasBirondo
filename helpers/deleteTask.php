<?php

require_once __DIR__ . '/../connector/connector.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$taskId = filter_input(INPUT_POST, 'TaskID', FILTER_VALIDATE_INT);
if ($taskId === false || $taskId === null) {
    console_log('Invalid task ID.');
    exit();
}

$clean_archive = "DELETE FROM trash_task";
$clean_statement = $conn->prepare($clean_archive);
if (!$clean_statement->execute()) {
    console_log('Error clearing trash: ' . $clean_statement->error);
    exit();
}
$clean_statement->close();

$sql = "SELECT * FROM task WHERE id = ?";
$statement = $conn->prepare($sql);
$statement->bind_param("i", $taskId);

if (!$statement->execute()) {
    console_log('Error fetching task: ' . $statement->error);
    exit();
}

$result = $statement->get_result();
$task = $result->fetch_assoc();
$result->free();
$statement->close();

if ($task === null) {
    console_log('Task not found.');
    exit();
}

$archiveSql = "INSERT INTO trash_task (id, title, due_date, due_time, priority, category_id, done) VALUES (?, ?, ?, ?, ?, ?, ?)";
$archiveStatement = $conn->prepare($archiveSql);
$title = $task['title'];
$dueDate = $task['due_date'];
$dueTime = $task['due_time'];
$priority = $task['priority'];
$categoryId = $task['category_id'];
$done = (int) $task['done'];
$archiveStatement->bind_param("issssii", $taskId, $title, $dueDate, $dueTime, $priority, $categoryId, $done);
if (!$archiveStatement->execute()) {
    console_log('Error moving task to trash: ' . $archiveStatement->error);
    exit();
}
$archiveStatement->close();
$_SESSION['deleted_task_id'] = $taskId;

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