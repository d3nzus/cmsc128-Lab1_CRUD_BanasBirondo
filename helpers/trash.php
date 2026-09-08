<?php

require_once __DIR__ . '/../connector/connector.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$taskId = null;
$title = null;
$due_date = null;
$due_time = null;
$priority = null;
$category = null;

function setTask(int $id): void
{
    global $conn, $taskId, $title, $due_date, $due_time, $priority, $category;

    $sql = "SELECT * FROM task WHERE id = ?";
    $statement = $conn->prepare($sql);
    $statement->bind_param("i", $id);

    if (!$statement->execute()) {
        console_log('Error fetching task: ' . $statement->error);
        exit();
    }

    $task = $statement->get_result()->fetch_assoc();
    if ($task === null) {
        console_log('Task not found.');
        exit();
    }

    $taskId = $task['id'];
    $title = $task['title'];
    $due_date = $task['due_date'];
    $due_time = $task['due_time'];
    $priority = $task['priority'];
    $category = $task['category_id'];

    $archiveSql = "INSERT INTO trash_task (id, title, due_date, due_time, priority, category_id) VALUES (?, ?, ?, ?, ?, ?)";
    $archiveStatement = $conn->prepare($archiveSql);
    $archiveStatement->bind_param("issssi", $taskId, $title, $due_date, $due_time, $priority, $category);
    if (!$archiveStatement->execute()) {
        console_log('Error moving task to trash: ' . $archiveStatement->error);
        exit();
    }
    $archiveStatement->close();
    $_SESSION['deleted_task_id'] = $taskId;
    $statement->close();
}

function undoDelete(int $id): void
{
    global $conn;

    $selectSql = "SELECT title, due_date, due_time, priority, category_id FROM trash_task WHERE id = ?";
    $selectStatement = $conn->prepare($selectSql);
    $selectStatement->bind_param("i", $id);
    if (!$selectStatement->execute()) {
        console_log('Error finding deleted task: ' . $selectStatement->error);
        exit();
    }

    $task = $selectStatement->get_result()->fetch_assoc();
    $selectStatement->close();
    if ($task === null) {
        console_log('Deleted task not found.');
        exit();
    }

    $title = $task['title'];
    $due_date = $task['due_date'];
    $due_time = $task['due_time'];
    $priority = $task['priority'];
    $category = $task['category_id'];

    $sql = "INSERT INTO task (id, title, due_date, due_time, priority, category_id) VALUES (?, ?, ?, ?, ?, ?)";
    $statement = $conn->prepare($sql);
    $statement->bind_param("issssi", $id, $title, $due_date, $due_time, $priority, $category);

    if ($statement->execute()) {
        $deleteSql = "DELETE FROM trash_task WHERE id = ?";
        $deleteStatement = $conn->prepare($deleteSql);
        $deleteStatement->bind_param("i", $id);
        $deleteStatement->execute();
        $deleteStatement->close();
        unset($_SESSION['deleted_task_id']);
        header("Location: ../pages/homePage.php");
        exit();
    }

    console_log('Error restoring task: ' . $statement->error);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'undo') {
    $deletedTaskId = $_SESSION['deleted_task_id'] ?? null;
    if ($deletedTaskId === null) {
        console_log('No deleted task to restore.');
        exit();
    }

    undoDelete((int) $deletedTaskId);
}

?>