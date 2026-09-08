<?php

require_once __DIR__ . '/../connector/connector.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$taskId = $_SESSION['deleted_task_id'] ?? null;
if ($taskId === null) {
    console_log('Nothing to undo.');
    exit();
}

$selectSql = 'SELECT title, due_date, due_time, priority, category_id FROM trash_task WHERE id = ?';
$selectStatement = $conn->prepare($selectSql);
$selectStatement->bind_param('i', $taskId);

if (!$selectStatement->execute()) {
    console_log('Error grabbing archive: ' . $selectStatement->error);
    exit();
}

$result = $selectStatement->get_result();
$task = $result->fetch_assoc();
$result->free();
$selectStatement->close();

if ($task === null) {
    console_log('Deleted task not found.');
    exit();
}

$title = $task['title'];
$dueDate = $task['due_date'];
$dueTime = $task['due_time'];
$priority = $task['priority'];
$categoryId = $task['category_id'];

$insertSql = 'INSERT INTO task (id, title, due_date, due_time, priority, category_id) VALUES (?, ?, ?, ?, ?, ?)';
$insertStatement = $conn->prepare($insertSql);
$insertStatement->bind_param('issssi', $taskId, $title, $dueDate, $dueTime, $priority, $categoryId);

if (!$insertStatement->execute()) {
    console_log('Error restoring task: ' . $insertStatement->error);
    exit();
}
$insertStatement->close();

$deleteSql = 'DELETE FROM trash_task WHERE id = ?';
$deleteStatement = $conn->prepare($deleteSql);
$deleteStatement->bind_param('i', $taskId);

if (!$deleteStatement->execute()) {
    console_log('Error clearing restored task: ' . $deleteStatement->error);
    exit();
}
$deleteStatement->close();

unset($_SESSION['deleted_task_id']);
header('Location: ../pages/homePage.php');
exit();